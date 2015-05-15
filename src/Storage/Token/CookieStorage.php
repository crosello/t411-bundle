<?php

namespace Rosello\T411Bundle\Storage\Token;

use Rosello\T411Bundle\Event\TokenCookieEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CookieStorage implements Storage
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $name;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var integer
     */
    private $ttl;

    /**
     * @param Request $request
     * @param string $name
     */
    public function __construct(EventDispatcherInterface $dispatcher, Request $request, $name, $ttl)
    {
        $this->request = $request;
        $this->name = $name;
        $this->dispatcher = $dispatcher;
        $this->ttl = $ttl;
    }

    /**
     * @return null|string
     */
    public function getToken()
    {
        return $this->request->cookies->get($this->name);
    }

    /**
     * @param $token
     * @return void
     */
    public function setToken($token)
    {
        $cookie = new Cookie($this->name, $token, time() + $this->ttl);
        $event = new TokenCookieEvent($cookie);

        $this->dispatcher->addListener(
            KernelEvents::RESPONSE,
            function (FilterResponseEvent $responseEvent) use ($event) {
                $response = $responseEvent->getResponse();
                $response->headers->setCookie($event->getCookie());
            }
        );
    }
}