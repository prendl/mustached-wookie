<?php

namespace SCTiengen\WebSiteBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class RenderHintsExtension extends AdminExtension {
	
	public function configureFormFields(FormMapper $formMapper) {
		$formMapper
			->add('blockTemplate', 'text', array('required' => false, 'empty_data' => null))
			->add('gridClassOverride', 'text', array('required' => false, 'empty_data' => null))
		;
	}
	
}

?>