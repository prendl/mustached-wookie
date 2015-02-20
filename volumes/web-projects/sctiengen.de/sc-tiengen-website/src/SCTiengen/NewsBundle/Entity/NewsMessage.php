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
	 * @ORM\Column(type="text", nullable)
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
	 * @ORM\Column(type="datetime", nullable)
	 */
	protected $publishStartDate;
	/**
	 * @ORM\Column(type="datetime", nullable)
	 */
	protected $publishEndDate;
	
}

?>