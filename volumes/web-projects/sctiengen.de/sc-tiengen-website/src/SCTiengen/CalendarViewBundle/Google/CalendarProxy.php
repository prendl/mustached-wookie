<?php

namespace SCTiengen\CalendarViewBundle\Google;

use Google_Client;
use Google_Service_Calendar;

class CalendarProxy {
    
    private $appName;
    private $scopes = Google_Service_Calendar::CALENDAR_READONLY;
    private $serviceAccountCredentialsFile;
    
    public function setAppName($appName) {
        $this->appName = $appName;
    }
    
    public function setServiceAccountCredentialsFile($filePath) {
        $this->serviceAccountCredentialsFile = $filePath;
    }
    
    protected function getClient() {
        $client = new Google_Client();
        $client->setApplicationName($this->appName);
        
        $credentials = $client->loadServiceAccountJson($this->serviceAccountCredentialsFile, $this->scopes);
        $client->setAssertionCredentials($credentials);
        
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion();
        }
        
        return $client;
    }
    
    /**
     * @return \Google_Service_Calendar
     */
    protected function getRemoteService() {
        return new Google_Service_Calendar($this->getClient());
    }
    
    protected function getEventParams() {
        $params = array(
            'singleEvents' => true,
            'showDeleted' => true,
            'fields' => 'items(description,end,id,location,start,status,summary),nextPageToken,nextSyncToken,summary'
        );
        return $params;
    }
    
    protected function getCalendarParams() {
        $params = array(
            'showDeleted' => true,
            'fields' => 'items(deleted,id,summary)'
        );
        return $params;
    }
    
    /**
     * 
     * @return Google_Service_Calendar_CalendarList
     */
    public function getCalendars() {
        $service = $this->getRemoteService();
        return $service->calendarList->listCalendarList($this->getCalendarParams());
    }
    
    /**
     * 
     * @param String $calendarId
     * @param \DateTime $startDateTime
     * @param \DateTime $endDateTime
     * @return Google_Service_Calendar_Events
     */
    public function getEventSlice($calendarId, \DateTime $startDateTime, \DateTime $endDateTime) {
        $params = array(
            'timeMin' => $startDateTime->format(\DateTime::RFC3339),
            'timeMax' => $endDateTime->format(\DateTime::RFC3339)
        );
        return $this->getEvents($calendarId, array_merge($this->getEventParams(), $params));
    }
    
    /**
     * 
     * @param String $calendarId
     * @param String $syncToken
     * @return Google_Service_Calendar_Events
     */
    public function getChangedEvents($calendarId, $syncToken) {
        $params = array(
            'syncToken' => $syncToken
        );
        return $this->getEvents($calendarId, array_merge($this->getEventParams(), $params));
    }
    
    /**
     * 
     * @param String $calendarId
     * @param String $pageToken
     * @return Google_Service_Calendar_Events
     */
    public function getNextEvents($calendarId, $pageToken) {
        $params = array(
            'pageToken' => $pageToken
        );
        return $this->getEvents($calendarId, array_merge($this->getEventParams(), $params));
    }
    
    /**
     * 
     * @param String $calendarId
     * @param array  $params
     * @return Google_Service_Calendar_Events
     */
    protected function getEvents($calendarId, $params) {
        $service = $this->getRemoteService();
        return $service->events->listEvents($calendarId, $params);
    }
    
}

?>