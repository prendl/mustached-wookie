<?php

namespace SCTiengen\MarkdownBundle\Parser;

use \Michelf\Markdown as MarkdownParser;
use SCTiengen\MarkdownBundle\MarkdownParserInterface;
use SCTiengen\MarkdownBundle\MarkdownUrlFilter;

class Markdown implements MarkdownParserInterface {
    
    protected $parser;
    
    public function __construct() {
        $this->parser = new MarkdownParser();
    }
    
    public function setUrlFilter(MarkdownUrlFilter $filterObj) {
        $this->parser->url_filter_func = function($url) use (&$filterObj) {
            return $filterObj->filterUrl($url);
        };
    }
    
    public function transformMarkdown($text) {
        return $this->parser->transform($text);
    }
    
}

?>