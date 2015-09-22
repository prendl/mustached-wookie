<?php

namespace SCTiengen\WebSiteBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class ImageCaptionExtension extends AdminExtension {
    
    public function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('form.caption')
                ->add('caption', 'textarea', array('required' => false, 'empty_data' => null))
            ->end()
        ;
    }
    
}

?>