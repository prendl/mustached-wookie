<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Symfony Standard Edition Bundles
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            // Symfony CMF Standard Edition Bundles
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle(),
            new Symfony\Cmf\Bundle\ContentBundle\CmfContentBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Symfony\Cmf\Bundle\MediaBundle\CmfMediaBundle(),

            new Symfony\Cmf\Bundle\BlockBundle\CmfBlockBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),

            new Symfony\Cmf\Bundle\MenuBundle\CmfMenuBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new \Burgov\Bundle\KeyValueFormBundle\BurgovKeyValueFormBundle(),

            new Symfony\Cmf\Bundle\CreateBundle\CmfCreateBundle(),
            new FOS\RestBundle\FOSRestBundle(),

            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrinePHPCRAdminBundle\SonataDoctrinePHPCRAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),

            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Symfony\Cmf\Bundle\TreeBrowserBundle\CmfTreeBrowserBundle(),

            new Sonata\SeoBundle\SonataSeoBundle(),
            new Symfony\Cmf\Bundle\SeoBundle\CmfSeoBundle(),

            new Liip\ImagineBundle\LiipImagineBundle(),

            new SCTiengen\WebSiteBundle\SCTiengenWebSiteBundle(),
            new SCTiengen\NewsBundle\SCTiengenNewsBundle(),
            new SCTiengen\MarkdownBundle\SCTiengenMarkdownBundle(),
            new SCTiengen\CalendarViewBundle\SCTiengenCalendarViewBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
