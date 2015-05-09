<?php

namespace SCTiengen\MarkdownBundle\Doctrine\Phpcr;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\PHPCR\DocumentManager;
use SCTiengen\MarkdownBundle\MarkdownUrlFilter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SCTiengen\WebSiteBundle\Document\DownloadBlock;
use SCTiengen\WebSiteBundle\Document\ImageBlock;

class UrlFilter implements MarkdownUrlFilter {
    
    const SEPERATOR = '://';
    
    private $map = array(
      'cmf-link' => null,
      'cmf-download' => 'cmf_media_download',
      'cmf-display' => 'cmf_media_image_display'
    );
    
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;
    /**
     * @var DocumentManager
     */
    protected $dm;

    public function __construct(UrlGeneratorInterface $urlGenerator, ManagerRegistry $registry) {
        $this->urlGenerator = $urlGenerator;
        $this->dm = $registry->getManager(null);
    }
    
    public function filterUrl($url) {
        $parts = explode(UrlFilter::SEPERATOR, $url);
        if (count($parts) === 2 && array_key_exists($parts[0], $this->map)) {
            $name = $this->map[$parts[0]];
            try {
                if ($name) {
                    $file = null;
                    $obj = $this->dm->find(null, $parts[1]);
                    if ($obj instanceof DownloadBlock) {
                        $file = $obj->getFile();
                    }
                    elseif ($obj instanceof ImageBlock) {
                        $file = $obj->getImage();
                    }
                    if (!$file) {
                        return '#';
                    }
                    $parameters = array('path' => ltrim($file->getId(), '/'));
                }
                else {
                    $name = $parts[1];
                    $parameters = array();
                }
                return $this->urlGenerator->generate($name, $parameters, UrlGeneratorInterface::ABSOLUTE_PATH);
            }
            catch (\Exception $e) {
                return '#';
            }
        }
        return $url;
    }
    
}