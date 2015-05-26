<?php

namespace SCTiengen\CalendarViewBundle\Google;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use SCTiengen\CalendarViewBundle\Entity\CalendarEvent;
use SCTiengen\CalendarViewBundle\Google\CalendarService;

class CalendarProxy {
    
    /**
     * @var $calendarService CalendarService
     */
    protected $calendarService;
    
    public function setCalendarService($calendarService) {
        $this->calendarService = $calendarService;
    }
    
    /**
     * @var $em EntityManager
     */
    protected $em;
    
    public function setEntityManager($em) {
        $this->em = $em;
    }
    
    public function updateCacheCurrent() {
        $this->updateCache(new \DateTime('today -1 day'), new \DateTime('today +1 day +1 week'));
    }
    public function updateCache(\DateTime $startDateTime, \DateTime $endDateTime) {
        $this->em->beginTransaction();
        $this->deleteEvents($startDateTime, $endDateTime);
        /**
         * @var $cal \Google_Service_Calendar_CalendarListEntry
         */
        foreach ($this->calendarService->listCalendars() as $cal) {
            foreach ($this->calendarService->listEvents($cal->getId(), $startDateTime, $endDateTime) as $event) {
                $this->em->persist($this->mapCalendarEvent($event, $cal->getSummary()));
            }
        }
        
        $this->em->flush();
        $this->em->commit();
    }
    
    function deleteEvents(\DateTime $startDateTime, \DateTime $endDateTime) {
        $criteria = Criteria::create()->where(Criteria::expr()->gte('startDateTime', $startDateTime))
            ->andWhere(Criteria::expr()->lt('endDateTime', $endDateTime));
        /**
         * @var $result Collection
         */
        $result = $this->em->getRepository('SCTiengenCalendarViewBundle:CalendarEvent')->matching($criteria);
        $em = &$this->em;
        $result->map(function($entity) use (&$em) {
            /**
             * @var $em EntityManager
             */
            $em->remove($entity);
        });
        $this->em->flush();
    }
    
    protected function mapCalendarEvent(\Google_Service_Calendar_Event $eventResource, $category) {
        $event = new CalendarEvent();
        $event->setId($eventResource->getId());
        $event->setTitle($eventResource->getSummary());
        $event->setStartDateTime(\DateTime::createFromFormat(\DateTime::RFC3339, $eventResource->getStart()->getDateTime()));
        $event->setEndDateTime(\DateTime::createFromFormat(\DateTime::RFC3339, $eventResource->getEnd()->getDateTime()));
        $event->setLocation($eventResource->getLocation());
        $event->setCategory($category);
        return $event;
    }
    
}

?>