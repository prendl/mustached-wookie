<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync\States;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncState;

class UnknownState implements SyncState {
    
    public function proceed(CalendarSynchronization $sync, CalendarManager $manager) {
        $syncToken = $sync->getCalendar()->getNextSyncToken();
        if ($syncToken === null) {
            $sync->setState(new FullSyncState());
        }
        else {
            $sync->setState(new IncrementalSyncState($syncToken));
        }
    }
    
}