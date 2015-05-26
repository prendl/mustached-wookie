<?php

namespace SCTiengen\CalendarViewBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SCTiengen\CalendarViewBundle\Google\CalendarProxy;
use SCTiengen\CalendarViewBundle\Google\CalendarService;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;

class DefaultController extends Controller {
    
    /**
     * @Route("/", name="calendar_list")
     */
    public function indexAction(Request $request) {
        $startDateTime = new \DateTime('today -1 day');
        $endDateTime = new \DateTime('today +1 day +1 week');
        $criteria = Criteria::create()->where(Criteria::expr()->gte('startDateTime', $startDateTime))
        ->andWhere(Criteria::expr()->lt('endDateTime', $endDateTime))
        ->orderBy(array('startDateTime' => 'ASC', 'endDateTime' => 'ASC'));
        
        $repository = $this->getDoctrine()->getRepository('SCTiengenCalendarViewBundle:CalendarEvent');
        /**
         * @var $result Collection
         */
        $result = $repository->matching($criteria);
        
        return $this->render('SCTiengenCalendarViewBundle:Default:index.html.twig', array('events' => $result->toArray()));
    }
    
}
