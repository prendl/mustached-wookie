<?php

namespace SCTiengen\WebSiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function homeAction(Request $request) {
    	$dm = $this->get('doctrine_phpcr')->getManager();
    	$contentRoot = $dm->find('Doctrine\ODM\PHPCR\Document\Generic', '/cms/content');
    	$contentDocument = $contentRoot->getChildren()->first();
    	
    	if (!$contentDocument) {
    		throw $this->createNotFoundException('No homepage configured');
    	}
    	
    	$contentController = $this->get('cmf_content.controller');
        $contentTemplate = 'SCTiengenWebSiteBundle:Page:home.html.twig';

        return $contentController->indexAction($request, $contentDocument, $contentTemplate);
    }
}
