<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\ImagineBlock;

/**
 * @PHPCR\Document(referenceable=true)
 */
class ImageBlock extends ImagineBlock implements RenderHinted {
    
    use RenderHintsTrait;
    
    /**
     * @PHPCR\String(nullable=true)
     */
    protected $caption;
    
    public function getCaption() {
        return $this->caption;
    }
    
    public function setCaption($caption) {
        $this->caption = $caption;
        return $this;
    }
    
}

?>