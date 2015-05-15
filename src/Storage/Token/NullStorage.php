<?php
/**
 * Created by PhpStorm.
 * User: chris_000
 * Date: 2015-05-13
 * Time: 22:12
 */

namespace Rosello\T411Bundle\Storage\Token;

/**
 * Class NullStorage
 * @package Rosello\T411Bundle\Storage\Token
 */
class NullStorage implements Storage
{
    /**
     * @return null|string
     */
    public function getToken()
    {
        return null;
    }

    /**
     * @param $token
     * @return void
     */
    public function setToken($token)
    {
        //Do not nothing
    }

}