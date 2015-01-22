<?php

namespace SCTiengen\WebSiteBundle\Menu;

use Knp\Menu\ItemInterface;
use Symfony\Cmf\Bundle\MenuBundle\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CurrentMenuItemVoter implements VoterInterface {

	private $request;
	
	public function setRequestStack(RequestStack $requestStack) {
		$request = $requestStack->getCurrentRequest();
		if ($request != null) {
			$this->setRequest($request);
		}
	}
	 
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function matchItem(ItemInterface $item) {
		if ($this->request != null && strpos($this->request->getRequestUri(), $item->getUri()) === 0) {
			return true;
		}
		return null;
	}
	
}

?>
