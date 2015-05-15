<?php

namespace Rosello\T411Bundle\Storage\Token;

/**
 * Class CookieStorageTest
 * @package Rosello\T411Bundle\Storage\Token
 */
class CookieStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CookieStorage
     */
    private $storage;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    public function setUp()
    {
        $this->request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();


        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->storage = new CookieStorage(
            $this->dispatcher,
            $this->request,
            'name',
            90
        );
    }

    public function testShouldGetToken()
    {
        $bag = $this->getMock('Symfony\Component\HttpFoundation\ParameterBag');
        $this->request->cookies = $bag;

        $bag
            ->expects($this->once())
            ->method('get')
            ->with('name')
            ->willReturn('token');

        $this->assertSame('token', $this->storage->getToken());
    }

    public function testShouldSetToken()
    {
        $this->dispatcher
            ->expects($this->once())
            ->method('addListener');

        $this->storage->setToken('token');
    }
}
