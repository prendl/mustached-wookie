<?php

namespace SCTiengen\CalendarViewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calendar_event")
 */
class CalendarEvent {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $startDateTime;
    public function getStartDateTime() {
        return $this->startDateTime;
    }
    public function setStartDateTime($startDateTime) {
        $this->startDateTime = $startDateTime;
    }
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $endDateTime;
    public function getEndDateTime() {
        return $this->endDateTime;
    }
    public function setEndDateTime($endDateTime) {
        $this->endDateTime = $endDateTime;
    }
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $location;
    public function getLocation() {
        return $this->location;
    }
    public function setLocation($location) {
        $this->location = $location;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=false)
     */
    private $calendar;
    public function getCalendar() {
        return $this->calendar;
    }
    public function setCalendar($calendar) {
        $this->calendar = $calendar;
    }

}

?>