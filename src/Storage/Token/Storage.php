<?php

namespace Rosello\T411Bundle\Storage\Token;

/**
 * Interface Storage
 * @package Rosello\T411Bundle\Storage
 */
interface Storage
{
    /**
     * @return null|string
     */
    public function getToken();

    /**
     * @param $token
     * @return void
     */
    public function setToken($token);
}