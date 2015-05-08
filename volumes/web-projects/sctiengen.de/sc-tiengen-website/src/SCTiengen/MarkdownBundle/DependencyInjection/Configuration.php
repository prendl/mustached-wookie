<?php

namespace SCTiengen\MarkdownBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {
    
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        
        /*
        sc_tiengen_markdown:
          - parser: Markdown|MarkdownExtra
          - options
          	- url_filter_func: null|servieLookup
        */
        $treeBuilder->root('sc_tiengen_markdown');
        
        return $treeBuilder;
    }
    
}
