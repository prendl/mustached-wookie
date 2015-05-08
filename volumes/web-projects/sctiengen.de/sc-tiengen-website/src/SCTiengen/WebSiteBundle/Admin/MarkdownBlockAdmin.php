<?php

namespace SCTiengen\WebSiteBundle\Admin;

use SCTiengen\WebSiteBundle\Document\MarkdownBlock;
use Symfony\Cmf\Bundle\BlockBundle\Admin\AbstractBlockAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MarkdownBlockAdmin extends AbstractBlockAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
                ->add('parentDocument', 'doctrine_phpcr_odm_tree', array(
                        'root_node' => $this->getRootPath(), 
                        'choice_list' => array(), 
                        'select_root_node' => true))
                ->add('name', 'text')
                ->add('content', 'textarea')
            ->end()
        ;
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
        return $object instanceof MarkdownBlock && $object->getName()
            ? $object->getName()
            : $this->trans('link_add', array(), 'SonataAdminBundle')
        ;
    }
    
}

?>