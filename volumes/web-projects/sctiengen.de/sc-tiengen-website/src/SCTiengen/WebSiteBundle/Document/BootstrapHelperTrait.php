<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

trait BootstrapHelperTrait {
	
	/**
	 * @PHPCR\String(nullable=true)
	 * @var subtype
	 */
	protected $subtype;

	/**
	 * @PHPCR\String(nullable=true)
	 * @var grid
	 */
	protected $grid;
	
	public function getSubtype() {
		return $this->subtype;
	}
	
	public function setSubtype($subtype) {
		$this->subtype = $subtype;
	}
	
	public function getGrid() {
		return $this->grid;
	}
	
	public function setGrid($grid) {
		$this->grid = $grid;
	}

}

?>
