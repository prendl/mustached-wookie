<?php

namespace SCTiengen\NewsBundle\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SeoBundle\SeoPresentationInterface;

class DefaultController extends Controller {
    
    private $publishedFilterCriteria;
    
    /**
     * @Route("/", name="news_list")
     */
    public function listAction(Request $request) {
        // load all
        $repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
        $criteria = Criteria::create();
        $criteria = $this->addPublishedFitler($criteria);
        $criteria = $this->addListSorting($criteria);
        /**
         * @var $result Collection
         */
        $result = $repository->matching($criteria);
        return $this->render('SCTiengenNewsBundle:Default:list.html.twig', array('messages' => $result));
    }

    /**
     * @Route("/{id}", name="news_detail")
     */
    public function detailAction(Request $request, $id) {
        // load by id
        $repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
        $criteria = Criteria::create()->where(Criteria::expr()->eq('id', $id));
        $criteria = $this->addPublishedFitler($criteria);
        /**
         * @var $result Collection
         */
        $result = $repository->matching($criteria);
        
        if ($result->isEmpty()) {
            throw $this->createNotFoundException('Unknown ID ' . $id);
        }

        /**
         * @var $seoPage SeoPresentationInterface
         */
        $seoPage = $this->get('cmf_seo.presentation');
        $seoPage->updateSeoPage($result->first());
        
        return $this->render('SCTiengenNewsBundle:Default:detail.html.twig', array('message' => $result->first()));
    } 
    
    public function topNewsAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository('SCTiengenNewsBundle:NewsMessage');
        $criteria = Criteria::create()->where(Criteria::expr()->eq('topNews', true));
        $criteria = $this->addPublishedFitler($criteria);
        $criteria = $this->addListSorting($criteria);
        /**
         * @var $result Collection
         */
        $result = $repository->matching($criteria);
        return $this->render('SCTiengenNewsBundle:Default:topNews.html.twig', array('messages' => $result));
    }
    
    protected function addPublishedFitler(Criteria $criteria) {
        if ($this->publishedFilterCriteria == null) {
            $now = new \DateTime();
            
            $a = Criteria::create()->orWhere(Criteria::expr()->isNull('publishStartDate'))
                    ->orWhere(Criteria::expr()->lte('publishStartDate', $now))->getWhereExpression();
            $b = Criteria::create()->orWhere(Criteria::expr()->isNull('publishEndDate'))
                    ->orWhere(Criteria::expr()->gte('publishEndDate', $now))->getWhereExpression();
            
            $this->publishedFilterCriteria = Criteria::create()->where(
                Criteria::expr()->eq('publishable', true))
                ->andWhere($a)
                ->andWhere($b);
        }
        return $criteria->andWhere($this->publishedFilterCriteria->getWhereExpression());
    }
    
    protected function addListSorting(Criteria $criteria) {
        return $criteria->orderBy(array('sorting' => 'DESC', 'publicationDate' => 'DESC'));
    }
}

?>
