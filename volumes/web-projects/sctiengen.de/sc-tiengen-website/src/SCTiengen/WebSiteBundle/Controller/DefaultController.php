<?php

namespace SCTiengen\WebSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SeoBundle\SeoPresentationInterface;

class DefaultController extends Controller {
    
    public function homeAction(Request $request) {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $contentRoot = $dm->find('Doctrine\ODM\PHPCR\Document\Generic', '/cms/content');
        $contentDocument = $contentRoot->getChildren()->first();
        
        if (!$contentDocument) {
            throw $this->createNotFoundException('No homepage configured');
        }
        /**
         * @var $seoPage SeoPresentationInterface
         */
        $seoPage = $this->get('cmf_seo.presentation');
        $seoPage->updateSeoPage($contentDocument);
        
        $contentController = $this->get('cmf_content.controller');
        $contentTemplate = 'SCTiengenWebSiteBundle:Page:home.html.twig';

        return $contentController->indexAction($request, $contentDocument, $contentTemplate);
    }
}
