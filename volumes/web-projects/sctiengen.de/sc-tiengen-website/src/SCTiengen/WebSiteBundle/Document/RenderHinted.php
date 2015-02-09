<?php

namespace SCTiengen\WebSiteBundle\Document;

interface RenderHinted {
	
	public function getBlockTemplate();
	public function setBlockTemplate($blockTemplate);
		
	public function getGridClassOverride();
	public function setGridClassOverride($gridClassOverride);
	
}

?>