<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\SlideshowBlock as SlideshowBlock_PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class SlideshowBlock extends SlideshowBlock_PHPCR implements RenderHinted {
    
    use RenderHintsTrait;
    
}
