<?php

namespace SCTiengen\NewsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NewsMessageAdmin extends Admin {
	
	/**
	 * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
	 *
	 * @return void
	 */
	protected function configureShowField(ShowMapper $showMapper) {
		$showMapper
			->add('title')
		;
	}
	
	/**
	 * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
	 *
	 * @return void
	 */
	protected function configureFormFields(FormMapper $formMapper) {
		$formMapper
			->with('General')
			->add('title')
			->add('publicationDate')
			->add('summary')
			->add('content')
			->end()
		;
	}
	
	/**
	 * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
	 *
	 * @return void
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('title')
			->add('summary')
			->add('content')
			->add('_action', 'actions', array(
					'actions' => array(
							'show' => array(),
							'edit' => array(),
							'delete' => array(),
					)
			))
		;
	}
	
	/**
	 * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
	 *
	 * @return void
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		$datagridMapper
			->add('title')
		;
	}
}

?>