<?php

namespace SCTiengen\MarkdownBundle\Templating;

use SCTiengen\MarkdownBundle\MarkdownParserInterface;
use Symfony\Component\Templating\Helper\HelperInterface;

class MarkdownHelper implements HelperInterface {
    
    private $charset = 'UTF-8';
    private $parser;
    
    public function __construct(MarkdownParserInterface $parser) {
        $this->parser = $parser;
    }
    
    /**
     * Transforms markdown syntax to HTML
     *
     * @param string      $markdownText The markdown syntax text
     *
     * @return string                   The HTML code
     *
     * @throws \RuntimeException
     */
    public function transform($markdownText)
    {
        return $this->parser->transformMarkdown($markdownText);
    }

    /**
     * Sets the default charset.
     *
     * @param string $charset The charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Gets the default charset.
     *
     * @return string The default charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'markdown';
    }
}
