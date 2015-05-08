<?php

namespace SCTiengen\MarkdownBundle\Twig\Extension;

use SCTiengen\MarkdownBundle\Templating\MarkdownHelper;

class MarkdownTwigExtension extends \Twig_Extension {
    
    protected $helper;
    
    function __construct(MarkdownHelper $helper)
    {
        $this->helper = $helper;
    }
    
    public function getFilters()
    {
        return array(
            'markdown' => new \Twig_Filter_Method($this, 'markdown', array('is_safe' => array('html'))),
        );
    }
    
    public function markdown($text)
    {
        return $this->helper->transform($text);
    }
    
    public function getName()
    {
        return 'markdown';
    }
    
}
