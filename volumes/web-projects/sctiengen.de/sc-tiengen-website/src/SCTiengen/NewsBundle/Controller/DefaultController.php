<?php

namespace SCTiengen\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SCTiengenNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
