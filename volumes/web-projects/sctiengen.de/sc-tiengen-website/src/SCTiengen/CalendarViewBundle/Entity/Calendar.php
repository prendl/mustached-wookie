<?php

namespace SCTiengen\CalendarViewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calendar")
 */
class Calendar {
    
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nextSyncToken;
    public function getNextSyncToken() {
        return $this->nextSyncToken;
    }
    public function setNextSyncToken($nextSyncToken) {
        $this->nextSyncToken = $nextSyncToken;
    }

}

?>