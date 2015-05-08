<?php

namespace SCTiengen\MarkdownBundle\Doctrine\Phpcr;

use SCTiengen\MarkdownBundle\MarkdownUrlFilter;
use Symfony\Cmf\Bundle\CoreBundle\Templating\Helper\CmfHelper;

class UrlFilter implements MarkdownUrlFilter {
    
    const PREFIX = 'phpcr://';
    
    /**
     * @var CmfHelper
     */
    protected $cmfHelper;
    
    public function __construct(CmfHelper $cmfHelper) {
        $this->cmfHelper = $cmfHelper;
    }
    
    public function filterUrl($url) {
        if (strpos($url, UrlFilter::PREFIX) === 0) {
            try {
                $path = substr($url, strlen(UrlFilter::PREFIX));
                return $this->cmfHelper->getPath($path);
            }
            catch (Exception $e) {
                return '#';
            }
        }
        return $url;
    }
    
}