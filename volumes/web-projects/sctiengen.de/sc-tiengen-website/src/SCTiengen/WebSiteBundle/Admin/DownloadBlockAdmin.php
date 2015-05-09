<?php

namespace SCTiengen\WebSiteBundle\Admin;

use SCTiengen\WebSiteBundle\Document\DownloadBlock;
use Symfony\Cmf\Bundle\BlockBundle\Admin\AbstractBlockAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DownloadBlockAdmin extends AbstractBlockAdmin
{
    function __construct($code, $class, $baseControllerName) {
    	parent::__construct($code, $class, $baseControllerName);
    	$this->setRootPath("/cms/media");
    }
    
    /**
     * {@inheritdoc}
     */
	protected function configureFormFields(FormMapper $formMapper) {
		parent::configureFormFields($formMapper);

        // file is only required when creating a new item
        // TODO: sonata is not using one admin instance per object, so this doesn't really work - https://github.com/symfony-cmf/BlockBundle/issues/151
        $fileRequired = ($this->getSubject() && $this->getSubject()->getParentDocument()) ? false : true;

        if (null === $this->getParentFieldDescription()) {
            $formMapper
                ->with('form.group_general')
                ->add(
                    'parentDocument',
                    'doctrine_phpcr_odm_tree',
                    array('root_node' => $this->getRootPath(), 'choice_list' => array(), 'select_root_node' => true)
                )
                ->add('name', 'text')
            ->end();
        }

        $formMapper
            ->with('form.group_general')
                ->add('label', 'text', array('required' => false))
                ->add('file', 'download_file', array('required' => $fileRequired))
                ->add('position', 'hidden', array('mapped' => false))
            ->end();
	}
	
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->add('name', 'text')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', 'doctrine_phpcr_nodename');
    }
    
    public function toString($object)
    {
        return $object instanceof DownloadBlock && $object->getName()
            ? $object->getName()
            : $this->trans('link_add', array(), 'SonataAdminBundle')
        ;
    }
    
}

?>