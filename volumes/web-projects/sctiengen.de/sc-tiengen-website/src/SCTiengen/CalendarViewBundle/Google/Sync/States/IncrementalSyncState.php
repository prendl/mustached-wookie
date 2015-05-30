<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync\States;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncState;

class IncrementalSyncState implements SyncState {
    
    private $syncToken;
    
    public function __construct($syncToken) {
        $this->syncToken = $syncToken;
    }
    
    public function proceed(CalendarSynchronization $sync, CalendarManager $manager) {
        /**
         * @var $events \Google_Service_Calendar_Events
         */
        $events = $manager->getCalendarProxy()->getChangedEvents($sync->getCalendar()->getId(), $this->syncToken);
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
    
}