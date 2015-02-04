<?php

namespace SCTiengen\WebSiteBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class BootstrapHelperExtension extends AdminExtension {
	
	public function configureFormFields(FormMapper $formMapper) {
		$formMapper->add('subtype', 'text', array('required' => false, 'empty_data' => null))
			->add('grid', 'text', array('required' => false, 'empty_data' => null));
	}
	
}

?>
