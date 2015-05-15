<?php

namespace Rosello\T411Bundle\Storage\Token;

/**
 * Class SessionStorageTest
 * @package Rosello\T411Bundle\Storage\Token
 */
class SessionStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    /**
     * @var SessionStorage
     */
    private $storage;

    public function setUp()
    {
        $this->session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')
            ->disableOriginalConstructor()
            ->getMock();

        $this->storage = new SessionStorage($this->session, 'name');
    }

    public function testShouldGetToken()
    {
        $this->session
            ->expects($this->once())
            ->method('get')
            ->with('name')
            ->willReturn('token');

        $this->assertSame('token', $this->storage->getToken());
    }

    public function testShouldSetToken()
    {
        $this->session
            ->expects($this->once())
            ->method('set')
            ->with('name', 'token');

        $this->storage->setToken('token');
    }
}
