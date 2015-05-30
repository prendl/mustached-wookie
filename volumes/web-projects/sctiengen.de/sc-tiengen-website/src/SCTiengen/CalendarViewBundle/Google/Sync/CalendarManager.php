<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use SCTiengen\CalendarViewBundle\Entity\CalendarEvent;
use SCTiengen\CalendarViewBundle\Entity\Calendar;
use SCTiengen\CalendarViewBundle\Google\CalendarProxy;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncMachine;

/**
 * 
 * Tasks:
 * manage calendar list with id, summary, nextSyncToken
 *  - map to calendar entity
 * 
 * sync events for all calendars
 *  - map to event entity
 */
class CalendarManager {
    

    /**
     * 
     * @var LoggerInterface
     */
    protected $logger;
    
    public function setLogger(LoggerInterface $logger) {
        $this->logger = $logger;
    }
    
    /**
     * @var EntityManager
     */
    protected $em;
    
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }
    
    /**
     * @var CalendarProxy
     */
    protected $calendarProxy;
    
    public function setCalendarProxy(CalendarProxy $calendarProxy) {
        return $this->calendarProxy = $calendarProxy;
    }
    
    /**
     * @return CalendarProxy
     */
    public function getCalendarProxy() {
        return $this->calendarProxy;
    }
    
    public function updateCalendars() {
        $this->logger->notice('updateCalendars()');
        $this->em->beginTransaction();
        $calendarRepo = $this->em->getRepository('SCTiengenCalendarViewBundle:Calendar');
        /**
         * @var $calendars \Google_Service_Calendar_CalendarList
        */
        $calendars = $this->getCalendarProxy()->getCalendars();
        /**
         * @var $calendarItem \Google_Service_Calendar_CalendarListEntry
        */
        foreach ($calendars->getItems() as $calendarItem) {
            $calendar = $calendarRepo->find($calendarItem->getId());
            $this->logger->info('processing calendar; {remote} {db}', array('remote' => $calendarItem->getId(), 'db' => is_null($calendar) ? 'NULL' : $calendar->getId()));
            if ($calendarItem->getDeleted()) {
                if ($calendar !== null) {
                    $this->em->remove($calendar);
                    $this->logger->debug('deleted');
                }
                else {
                    //TODO: warn?
                    $this->logger->warning('calendar marked as deleted does not exist locally; {remote}', array('remote' => $calendarItem->getId()));
                }
            }
            else {
                if ($calendar === null) {
                    $calendar = new Calendar();
                    $calendar->setId($calendarItem->getId());
                    $this->logger->debug('created');
                }
                else {
                    $this->logger->debug('updated');
                }
                $calendar->setTitle($calendarItem->getSummary());
                $calendar->setNextSyncToken(null);
                $this->em->persist($calendar);
            }
        }
        $this->em->flush();
        $this->em->commit();
    }
    
    public function syncAllCalendarEvents(\DateTime $startDateTime, \DateTime $endDateTime) {
        $this->logger->notice('syncAllCalendarEvents({start}, {end})', array('start' => $startDateTime, 'end' => $endDateTime));
        $this->em->beginTransaction();
        $calendarRepo = $this->em->getRepository('SCTiengenCalendarViewBundle:Calendar');
        /**
         * @var $calendar Calendar
         */
        try {
            foreach ($calendarRepo->findAll() as $calendar) {
                $this->syncCalendarEvents($calendar, $startDateTime, $endDateTime);
            }
            $this->em->commit();
        }
        catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }
    
    public function syncCalendarEvents(Calendar $calendar, \DateTime $startDateTime, \DateTime $endDateTime) {
        $this->logger->notice('syncAllCalendarEvents({calendar}, {start}, {end})', array('calendar' => $calendar->getId(), 'start' => $startDateTime, 'end' => $endDateTime));
        $sync = new CalendarSynchronization($calendar, $startDateTime, $endDateTime, $this->logger);
        CalendarSynchronization::synchronize($sync, $this);
        if (!$sync->isFinished()) {
            throw new \Exception("Calendar synchronization is not finished");
        }
    }
    
    public function storeEvents(Calendar $calendar, \Google_Service_Calendar_Events $events) {
        $calendarEventRepo = $this->em->getRepository('SCTiengenCalendarViewBundle:CalendarEvent');
        /**
         * @var $event \Google_Service_Calendar_Event
         */
        foreach ($events->getItems() as $event) {
            $calendarEvent = $calendarEventRepo->find($event->getId());
            if ($event->getStatus() === 'cancelled') {
                if ($calendarEvent !== null) {
                    $this->em->remove($calendarEvent);
                }
                else {
                    //TODO: warn?
                }
            }
            else {
                $calendarEvent = $this->mapCalendarEvent($event, $calendar, $calendarEvent);
                $this->em->persist($calendarEvent);
            }
        }
        $this->em->flush();
    }
    
    public function storeSyncToken(Calendar $calendar, $syncToken) {
        $calendar->setNextSyncToken($syncToken);
        $this->em->flush($calendar);
    }
    
    public function deleteSyncToken(Calendar $calendar) {
        $calendar->setNextSyncToken(null);
        $this->em->flush($calendar);
    }
    
    public function truncateEvents() {
        $result = $this->em->getRepository('SCTiengenCalendarViewBundle:CalendarEvent')->findAll();
        $em = &$this->em;
        $result->map(function($entity) use (&$em) {
            /**
             * @var $em EntityManager
             */
            $em->remove($entity);
        });
        $this->em->flush();
    }
    
    protected function mapCalendarEvent(\Google_Service_Calendar_Event $eventResource, Calendar $calendar, CalendarEvent $originalEvent=null) {
        if ($originalEvent === null) {
            $event = new CalendarEvent();
            $event->setId($eventResource->getId());
        }
        else {
            $event = $originalEvent;
        }
        $event->setTitle($eventResource->getSummary());
        $event->setStartDateTime(\DateTime::createFromFormat(\DateTime::RFC3339, $eventResource->getStart()->getDateTime()));
        $event->setEndDateTime(\DateTime::createFromFormat(\DateTime::RFC3339, $eventResource->getEnd()->getDateTime()));
        $event->setLocation($eventResource->getLocation());
        $event->setCalendar($calendar);
        return $event;
    }
    
}

/**
 * syncEvents forCalendar:
 * hasNextSyncToken
 *   ?
 *   + fetchNextPage
 *     expired
 *       ?
 *       + deleteSyncToken
 *         truncate
 *         fullSync
 *       - hasItems
 *         ?
 *         + mapToEntity
 *           hasNextPage
 *           ?
 *           + fetchNextPage
 *         - storeNextSyncToken
 *           IN_SYNC
 *   - fullSync:
 *     fetchNextPage
 *     hasNextPage
 *       ?
 *       + fetchNextPage
 *       - storeNextSyncToken
 *     IN_SYNC
 *     
 * error
 *   ?
 *   + rollback
 *  
 * 
 */

?>