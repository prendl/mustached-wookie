<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ImagineBlock;

/**
 * @PHPCR\Document(referenceable=true)
 */
class ImageBlock extends ImagineBlock implements RenderHinted {
	
	use RenderHintsTrait;
	
}

?>