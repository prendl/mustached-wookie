<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Page extends StaticContent {
	
	use BlockChildrenTrait;
	
	public function __construct() {
		parent::__construct();
		$this->children = new ArrayCollection();
	}
	
}

?>