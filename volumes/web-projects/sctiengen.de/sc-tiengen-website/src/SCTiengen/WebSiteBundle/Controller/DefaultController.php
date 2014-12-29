<?php

namespace SCTiengen\WebSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SCTiengenWebSiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
