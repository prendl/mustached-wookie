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
    
    protected function buildEventParams(\DateTime $startDateTime, \DateTime $endDateTime) {
        $params = array(
            'singleEvents' => true,
            'timeMin' => $startDateTime->format(\DateTime::RFC3339),
            'timeMax' => $endDateTime->format(\DateTime::RFC3339),
            'fields' => 'items(id,description,end,location,start,summary)'
        );
        return $params;
    }
    
    protected function buildCalendarListParams() {
        $params = array(
            'fields' => 'items(id,summary)'
        );
        return $params;
    }
    
    public function listCalendars() {
        $cal = $this->getRemoteService();
        $params = $this->buildCalendarListParams();
        return $cal->calendarList->listCalendarList($params)->getItems();
    }
    
    public function listEvents($calendarId, $startDateTime, $endDateTime) {
        $cal = $this->getRemoteService();
        $params = $this->buildEventParams($startDateTime, $endDateTime);
        return $cal->events->listEvents($calendarId, $params)->getItems();
    }
    
}

?>