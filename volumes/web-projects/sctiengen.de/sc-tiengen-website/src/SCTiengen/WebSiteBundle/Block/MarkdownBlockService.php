<?php

namespace SCTiengen\WebSiteBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

class MarkdownBlockService extends BaseBlockService
{

	/**
	 * Define valid options for a block of this type.
	 */
	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'name' => '',
				'content' => '',
				'template' => 'SCTiengenWebSiteBundle:Blocks:markdown.html.twig'
		));
	}

	/**
	 * The block context knows the default settings, but they can be
	 * overwritten in the call to render the block.
	 */
	public function execute(BlockContextInterface $blockContext, Response $response = null)
	{
		$block = $blockContext->getBlock();

		if (!$block->getEnabled()) {
			return new Response();
		}

		// merge settings with those of the concrete block being rendered
		$settings = $blockContext->getSettings();
		$resolver = new OptionsResolver();
		$resolver->setDefaults($settings);
		$settings = $resolver->resolve($block->getOptions());

		return $this->renderResponse($blockContext->getTemplate(), array(
				'block'     => $block,
				'settings'  => $settings
		), $response);
	}

	// These methods are required by the sonata block service interface.
	// They are not used in the CMF. To edit, create a symfony form or
	// a sonata admin.

	public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
	{
		throw new \Exception();
	}

	public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
	{
		throw new \Exception();
	}
}

?>