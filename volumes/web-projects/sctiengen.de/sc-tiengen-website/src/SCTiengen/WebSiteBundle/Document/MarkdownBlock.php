<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use SCTiengen\WebSiteBundle\Document\BootstrapHelperTrait;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\AbstractBlock;

/**
 * @PHPCR\Document(referenceable=true)
 */
class MarkdownBlock extends AbstractBlock
{
	use BootstrapHelperTrait;
	
	/**
	 * @PHPCR\String(nullable=true)
	 */
	protected $content;

	public function getType()
	{
		return 'sctiengen_website.block.markdown';
	}

	public function getOptions()
	{
		$options = array(
				'name' => $this->name,
		);
		if ($this->content) {
			$options['content'] = $this->content;
		}

		return $options;
	}

	public function getContent() {
		return $this->content;
	}

	public function setContent($content) {
		$this->content = $content;
		return $this;
	}
	
}

?>
