<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync\States;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncState;

class TokenExpiredState implements SyncState {
    
    public function proceed(CalendarSynchronization $sync, CalendarManager $manager) {
        $manager->deleteSyncToken($sync->getCalendar());
        $manager->truncateEvents($sync->getCalendar());
        $sync->setState(new FullSyncState());
    }
    
}