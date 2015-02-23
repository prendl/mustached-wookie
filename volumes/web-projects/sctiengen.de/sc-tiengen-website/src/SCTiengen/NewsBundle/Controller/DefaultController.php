<?php

namespace SCTiengen\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	
	/**
	 * @Route("/", name="list")
	 */
    public function listAction(Request $request) {
    	// load all
    	$repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
    	$allMessages = $repository->findAll();
        return $this->render('SCTiengenNewsBundle:Default:index.html.twig', array('messages' => $allMessages));
    }

    /**
     * @Route("/{id}", name="detail")
     */
    public function detailAction(Request $request, $id) {
    	// load by id
    	$repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
    	$message = $repository->find($id);
    	if (!$message) {
    		throw $this->createNotFoundException('Unknown ID ' . $id);
    	}
    	return $this->render('SCTiengenNewsBundle:Default:index.html.twig', array('message' => $message));
    } 
    
}
