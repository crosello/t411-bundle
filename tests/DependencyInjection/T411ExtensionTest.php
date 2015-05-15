<?php

namespace Rosello\T411Bundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class T411ExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Return an array of container extensions you need to be registered for each test (usually just the container
     * extension you are testing.
     *
     * @return ExtensionInterface[]
     */
    protected function getContainerExtensions()
    {
        return array(
          new T411Extension()
        );
    }


    public function testShouldSetParameters()
    {
        $this->load(array(
            'token' => array(
                'name' => 'cookie_name',
                'expire' => 'expire_ttl'
            )
        ));

        $this->assertContainerBuilderHasParameter('t411.storage.name', 'cookie_name');
        $this->assertContainerBuilderHasParameter('t411.storage.expire', 'expire_ttl');
    }

    public function testShouldSetAliasSessionStorage()
    {
        $this->load(array(
            'token' => array(
                'storage' => 'session'
            )
        ));

        $this->assertContainerBuilderHasAlias('t411.storage.token', 't411.storage.token.session');
    }

    public function testShouldSetAliasCookieStorage()
    {
        $this->load(array(
            'token' => array(
                'storage' => 'cookie'
            )
        ));

        $this->assertContainerBuilderHasAlias('t411.storage.token', 't411.storage.token.cookie');
    }

    public function testShouldSetAliasNullStorage()
    {
        $this->load(array(
            'token' => array(
                'storage' => false
            )
        ));

        $this->assertContainerBuilderHasAlias('t411.storage.token', 't411.storage.token.null');
    }

    /**
     * @dataProvider provideServices
     */
    public function testShouldLoadServices($serviceId, $serviceClass, $arguments = array())
    {
        $this->load();

        $this->assertContainerBuilderHasService($serviceId, $serviceClass);

        foreach ($arguments as $key =>$argument) {
            $this->assertContainerBuilderHasServiceDefinitionWithArgument(
                $serviceId,
                $key,
                $argument
            );
        }
    }

    public function provideServices()
    {
        return array(
            array(
                't411.repository.torrents',
                'Rosello\T411\Repository\TorrentRepository',
                array('t411.config.token')
            ),
            array(
                't411.provider.token_config',
                'Rosello\T411Bundle\Provider\TokenConfigProvider',
                array('t411.authentication', 't411.storage.token', '%t411_user%', '%t411_password%')
            ),
            array(
                't411.config.token',
                'Rosello\T411\Config\TokenConfig',
            ),
            array(
                't411.authentication',
                'Rosello\T411\Authentication\Authentication',
            ),
            array(
                't411.storage.token.cookie',
                'Rosello\T411Bundle\Storage\Token\CookieStorage',
                array('event_dispatcher', 'request', '%t411.storage.name%', '%t411.storage.expire%')
            ),
            array(
                't411.storage.token.session',
                'Rosello\T411Bundle\Storage\Token\SessionStorage',
                array('session', '%t411.storage.name%')
            ),
            array(
                't411.storage.token.null',
                'Rosello\T411Bundle\Storage\Token\NullStorage'
            )
        );
    }
}
