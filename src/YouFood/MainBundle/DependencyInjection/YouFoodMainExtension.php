<?php

namespace YouFood\MainBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * YouFoodMainExtension
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class YouFoodMainExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('admin.yml', 'block.yml') as $file) {
            $loader->load($file);
        }
    }
}
