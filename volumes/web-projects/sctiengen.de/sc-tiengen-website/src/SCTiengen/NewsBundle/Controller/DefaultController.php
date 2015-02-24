<?php

namespace SCTiengen\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	
	/**
	 * @Route("/", name="news_list")
	 */
    public function listAction(Request $request) {
    	// load all
    	$repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
    	$allMessages = $repository->findAll();
        return $this->render('SCTiengenNewsBundle:Default:list.html.twig', array('messages' => $allMessages));
    }

    /**
     * @Route("/{id}", name="news_detail")
     */
    public function detailAction(Request $request, $id) {
    	// load by id
    	$repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
    	$message = $repository->find($id);
    	if (!$message) {
    		throw $this->createNotFoundException('Unknown ID ' . $id);
    	}
    	return $this->render('SCTiengenNewsBundle:Default:detail.html.twig', array('message' => $message));
    } 
    
    public function topNewsAction(Request $request) {
    	// load all
    	$repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
    	$allMessages = $repository->findAll();
        return $this->render('SCTiengenNewsBundle:Default:topNews.html.twig', array('messages' => $allMessages));
    }
}

?>
