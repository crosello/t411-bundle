<?php

namespace Rosello\T411Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class T411Extension
 * @package Rosello\T411Bundle\DependencyInjection
 */
class T411Extension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //Parameters
        $container->setParameter('t411.storage.name', $config['token']['name']);
        $container->setParameter('t411.storage.expire', $config['token']['expire']);

        //Storage
        $this->defineStorageAlias($container, $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    private function defineStorageAlias(ContainerBuilder $container, $config)
    {
        if ($container->hasAlias('t411.storage.token')) {
            return;
        }

        $storage = $config['token']['storage'];

        switch ($storage) {
            case "cookie":
                $service = 't411.storage.token.cookie';
                break;

            case "session":
                $service = 't411.storage.token.session';
                break;

            case false:
                $service = 't411.storage.token.null';
                break;

            default:
                throw new InvalidArgumentException('Storage type invalid');
                break;
        }

        $container->setAlias('t411.storage.token', $service);
    }
}
