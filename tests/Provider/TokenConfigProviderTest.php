<?php

namespace Rosello\T411Bundle\Provider;
use Rosello\T411\Config\AuthConfig;
use Rosello\T411\Config\TokenConfig;

/**
 * Class TokenConfigProviderTest
 * @package Rosello\T411Bundle\Provider
 */
class TokenConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenConfigProvider
     */
    private $tokenConfigProvider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $storage;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $authentication;

    public function setUp()
    {
        $this->storage = $this->getMock('Rosello\T411Bundle\Storage\Token\Storage');
        $this->authentication = $this->getMockBuilder('Rosello\T411\Authentication\Authentication')
            ->disableOriginalConstructor()
            ->getMock();

        $this->tokenConfigProvider = new TokenConfigProvider(
            $this->authentication,
            $this->storage,
            'username',
            'password'
        );
    }

    public function testShouldCallAuthenticationIfEmptyTokenInStorageAndReturnToken()
    {
        $token = 'token';

        $this->storage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn(null);

        $authConfig = new AuthConfig('username', 'password');
        $tokenConfig = new TokenConfig($token);

        $this->authentication
            ->expects($this->once())
            ->method('auth')
            ->with($authConfig)
            ->willReturn($tokenConfig);

        $this->storage
            ->expects($this->once())
            ->method('setToken')
            ->with($token);

        $this->assertSame($tokenConfig, $this->tokenConfigProvider->getTokenConfig());
    }

    public function testShouldNotCallAuthenticationIfTokenExistsInStorageAndReturnToken()
    {
        $token = 'token';
        $tokenConfig = new TokenConfig($token);

        $this->storage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $this->authentication
            ->expects($this->never())
            ->method('auth');

        $this->storage
            ->expects($this->never())
            ->method('setToken');

        $this->assertEquals(
            $tokenConfig->getToken(),
            $this->tokenConfigProvider->getTokenConfig()->getToken()
        );
    }
}
