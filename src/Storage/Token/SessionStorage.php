<?php

namespace Rosello\T411Bundle\Storage\Token;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionStorage
 * @package Rosello\T411Bundle\Storage\Token
 */
class SessionStorage implements Storage
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var
     */
    private $name;

    /**
     * @param Session $session
     * @param $name
     */
    public function __construct(Session $session, $name)
    {
        $this->session = $session;
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getToken()
    {
        return $this->session->get($this->name);
    }

    /**
     * @param $token
     * @return void
     */
    public function setToken($token)
    {
        $this->session->set($this->name, $token);
    }
}