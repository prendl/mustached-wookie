<?php

use SCTiengen\CalendarViewBundle\Google\CalendarService;
use SCTiengen\CalendarViewBundle\Entity\CalendarEvent;

class CalendarProxy {
    
    /**
     * @var $calendarService CalendarService
     */
    protected $calendarService;
    
    public function updateCache() {
        $startDateTime = '';
        $endDateTime = '';
        
        $em = $this->getDoctrine()->getEntityManager();
        
        foreach ($this->getCalenderIds() as $id) {
            foreach ($this->calendarService->listEvents($id, $startDateTime, $endDateTime) as $event) {
                $em->persist($this->mapCalendarEvent($event));
            }
        }
        $em->flush();
    }
    
    protected function mapCalendarEvent(Google_Service_Calendar_Event $eventResource) {
        $event = new CalendarEvent();
        
        return $event;
    }
    
    /**
     * @return array: Calendar IDs
     */
    protected function getCalenderIds() {
        $ids = array();
        /**
         * @var $cal Google_Service_Calendar_CalendarListEntry
         */
        foreach ($this->calendarService->listCalendars() as $cal) {
            $ids[] = $cal->getId();
        }
        return $ids;
    }
    
}

?>