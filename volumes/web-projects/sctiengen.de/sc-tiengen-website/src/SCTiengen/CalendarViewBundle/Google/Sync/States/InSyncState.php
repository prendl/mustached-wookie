<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync\States;

use SCTiengen\CalendarViewBundle\Google\Sync\CalendarSynchronization;
use SCTiengen\CalendarViewBundle\Google\Sync\CalendarManager;
use SCTiengen\CalendarViewBundle\Google\Sync\SyncState;

class InSyncState implements SyncState {
    
    public function proceed(CalendarSynchronization $sync, CalendarManager $manager) {
        
    }
    
}