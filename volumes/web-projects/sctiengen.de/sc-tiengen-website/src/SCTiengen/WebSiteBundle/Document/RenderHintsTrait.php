<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

trait RenderHintsTrait {
	
	/**
	 * @PHPCR\String(nullable=true)
	 * @var blockTemplate
	 */
	protected $blockTemplate;

	/**
	 * @PHPCR\String(nullable=true)
	 * @var gridClassOverride
	 */
	protected $gridClassOverride;
	
	public function getBlockTemplate() {
		return $this->blockTemplate;
	}
	
	public function setBlockTemplate($blockTemplate) {
		$this->blockTemplate = $blockTemplate;
		return $this;
	}
	
	public function getGridClassOverride() {
		return $this->gridClassOverride;
	}
	
	public function setGridClassOverride($gridClassOverride) {
		$this->gridClassOverride = $gridClassOverride;
		return $this;
	}

}

?>