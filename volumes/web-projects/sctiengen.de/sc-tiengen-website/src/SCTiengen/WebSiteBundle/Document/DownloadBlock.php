<?php

namespace SCTiengen\WebSiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use PHPCR\NodeInterface;
use Symfony\Cmf\Bundle\MediaBundle\Doctrine\Phpcr\File;
use Symfony\Cmf\Bundle\MediaBundle\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\AbstractBlock;

/**
 * @PHPCR\Document(referenceable=true)
 */
class DownloadBlock extends AbstractBlock {

	/**
	 * @PHPCR\String(nullable=true)
	 */
	protected $label;
	
	/**
	 * @var File \PHPCR\Child(cascade="persist")
	 */
	protected $file;
	
	/**
	 * @var \PHPCR\NodeInterface
	 */
	protected $node;
	
	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return 'sctiengen_website.block.download';
	}

    /**
     * Set label
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
	
	/**
	 * Set the file for this block.
	 *
	 * @param FileInterface|UploadedFile|null $file optional the file to update
	 *
	 * @return $this
	 *
	 * @throws \InvalidArgumentException If the $file parameter can not be handled.
	 */
	public function setFile($file = null)
	{
		if (!$file) {
			return $this;
		}
	
		if (!$file instanceof FileInterface && !$file instanceof UploadedFile) {
			$type = is_object($file) ? get_class($file) : gettype($file);
	
			throw new \InvalidArgumentException(sprintf(
					'File is not a valid type, "%s" given.',
					$type
			));
		}
	
		if ($this->file) {
			// existing file, only update content
			// TODO: https://github.com/doctrine/phpcr-odm/pull/262
			$this->file->copyContentFromFile($file);
		} elseif ($file instanceof FileInterface) {
			$file->setName('file'); // ensure document has right name
			$this->file = $file;
		} else {
			$this->file = new File();
			$this->file->copyContentFromFile($file);
		}
	
		return $this;
	}
	
	/**
	 * Get file
	 *
	 * @return File
	 */
	public function getFile()
	{
		return $this->file;
	}
	
	/**
	 * Get node
	 *
	 * @return NodeInterface
	 */
	public function getNode()
	{
		return $this->node;
	}
	
}

?>