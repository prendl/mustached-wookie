<?php

namespace SCTiengen\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_message")
 */
class NewsMessage {
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $title;
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $summary;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $content;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $publicationDate;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $publishStartDate;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $publishEndDate;
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return NewsMessage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return NewsMessage
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return NewsMessage
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     * @return NewsMessage
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime 
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set publishStartDate
     *
     * @param \DateTime $publishStartDate
     * @return NewsMessage
     */
    public function setPublishStartDate($publishStartDate)
    {
        $this->publishStartDate = $publishStartDate;

        return $this;
    }

    /**
     * Get publishStartDate
     *
     * @return \DateTime 
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    /**
     * Set publishEndDate
     *
     * @param \DateTime $publishEndDate
     * @return NewsMessage
     */
    public function setPublishEndDate($publishEndDate)
    {
        $this->publishEndDate = $publishEndDate;

        return $this;
    }

    /**
     * Get publishEndDate
     *
     * @return \DateTime 
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }
}
