<?php

namespace SCTiengen\MarkdownBundle\Parser;

use \Michelf\MarkdownExtra as MarkdownParser;
use SCTiengen\MarkdownBundle\MarkdownParserInterface;

class MarkdownExtra extends Markdown {
    
    public function __construct() {
        $this->parser = new MarkdownParser();
    }
    
}

?>