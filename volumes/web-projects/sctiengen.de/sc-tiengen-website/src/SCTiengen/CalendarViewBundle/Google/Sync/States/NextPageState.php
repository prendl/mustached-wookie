<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync\States;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncState;

class NextPageState implements SyncState {
    
    private $nextPageToken;
    
    public function __construct($nextPageToken) {
        $this->nextPageToken = $nextPageToken;
    }
    
    public function proceed(CalendarSynchronization $sync, CalendarManager $manager) {
        try {
            /**
             * @var $events \Google_Service_Calendar_Events
             */
            $events = $manager->getCalendarProxy()->getNextEvents($sync->getCalendar()->getId(), $this->nextPageToken);
            
            if ($events->count() > 0) {
                $manager->storeEvents($sync->getCalendar(), $events);
                $nextPageToken = $events->getNextPageToken();
                if ($nextPageToken !== null) {
                    $sync->setState(new NextPageState($nextPageToken));
                    return;
                }
            }
            $manager->storeSyncToken($sync->getCalendar(), $events->getNextSyncToken());
            $sync->setState(new InSyncState());
        }
        catch (\Google_Service_Exception $e) {
            if ($e->getCode() === 410) {
                $sync->setState(new TokenExpiredState());
            }
            else {
                throw $e;
            }
        }
    }
    
}