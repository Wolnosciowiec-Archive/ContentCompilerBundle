<?php

declare(strict_types=1);

namespace ContentCompilerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ContentCompilerExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/'));
        $loader->load('services.yml');

        $implementations = $container->findTaggedServiceIds('wolnosciowiec.contentcompiler');
        $factory = $container->getDefinition('wolnosciowiec.contentcompiler.factory');

        foreach ($implementations as $id => $tags) {
            $factory->addMethodCall('addCompiler', [new Reference($id)]);
        }
    }
}
