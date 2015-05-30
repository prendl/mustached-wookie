<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync;

use Doctrine\ORM\EntityManager;
use SCTiengen\CalendarViewBundle\Entity\Calendar;
use SCTiengen\CalendarViewBundle\Google\CalendarProxy;
use SCTiengen\CalendarViewBundle\Google\Sync\States\InSyncState;
use SCTiengen\CalendarViewBundle\Google\Sync\States\UnknownState;
use Psr\Log\LoggerInterface;

class CalendarSynchronization {
    
    /**
     * @var SyncState
     */
    private $state;
    
    public function getState() {
        return $this->state;
    }
    
    public function setState(SyncState $state) {
        $this->logger->info('setState()', array('cal' => $this->calendar->getId(), 'oldState' => $this->state, 'newState' => $state));
        $this->state = $state;
    }
    
    /**
     * @var Calendar
     */
    private $calendar;
    
    /**
     * @return Calendar
     */
    public function getCalendar() {
        return $this->calendar;
    }

    /**
     * @var \DateTime
     */
    private $startDateTime;
    
    /**
     * @return \DateTime
     */
    public function getStartDateTime() {
        return $this->startDateTime;
    }
    
    /**
     * @var \DateTime
     */
    private $endDateTime;
    
    /**
     * @return \DateTime
     */
    public function getEndDateTime() {
        return $this->endDateTime;
    }
    
    /**
     *
     * @var LoggerInterface
     */
    protected $logger;
    
    public function __construct(Calendar $calendar, \DateTime $startDateTime, \DateTime $endDateTime, LoggerInterface $logger) {
        $this->calendar = $calendar;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->logger = $logger;
        $this->setState(new UnknownState());
    }
    
    /**
     * 
     * @return boolean
     */
    public function isFinished() {
        $finished = $this->getState() instanceof InSyncState;
        $this->logger->notice('isFinished()', array('finished' => $finished, 'state' => $this->getState()));
        return $finished;
    }
    
    /**
     * @static
     * @param CalendarSynchronization $sync
     * @return void
     */
    public static function synchronize(CalendarSynchronization $sync, CalendarManager $manager) {
        do {
            $sync->getState()->proceed($sync, $manager);
        } while (!$sync->isFinished());
    }
    
}