<?php

namespace Rosello\T411Bundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Cookie;

class TokenCookieEvent extends Event
{
    /**
     * @var Cookie
     */
    private $cookie;

    /**
     * @param Cookie $cookie
     */
    public function __construct(Cookie $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * @return Cookie
     */
    public function getCookie()
    {
        return $this->cookie;
    }
}