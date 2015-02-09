<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareTrait;
/**
 * @PHPCR\Document(referenceable=true)
 */
class Page extends StaticContent implements SeoAwareInterface {
	
	use BlockChildrenTrait;
	use SeoAwareTrait;
	
	public function __construct() {
		parent::__construct();
		$this->children = new ArrayCollection();
	}
	
}

?>