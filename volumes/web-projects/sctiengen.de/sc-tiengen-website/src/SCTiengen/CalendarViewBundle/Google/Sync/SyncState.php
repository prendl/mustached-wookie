<?php

namespace SCTiengen\CalendarViewBundle\Google\Sync;

interface SyncState {
    
    function proceed(CalendarSynchronization $sync, CalendarManager $manager);
    
}

?>