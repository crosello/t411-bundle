<?php

namespace Rosello\T411Bundle\Event;

/**
 * Class TokenCookieEventTest
 * @package Rosello\T411Bundle\Event
 */
class TokenCookieEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenCookieEvent
     */
    private $event;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cookie;

    public function setUp()
    {
        $this->cookie = $this->getMockBuilder('Symfony\Component\HttpFoundation\Cookie')
            ->disableOriginalConstructor()
            ->getMock();

        $this->event = new TokenCookieEvent($this->cookie);
    }

    public function testShouldGetCookie()
    {
        $this->assertSame($this->cookie, $this->event->getCookie());
    }
}
