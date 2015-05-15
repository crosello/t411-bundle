<?php

namespace Rosello\T411Bundle\Provider;

use Rosello\T411\Authentication\Authentication;
use Rosello\T411\Config\AuthConfig;
use Rosello\T411\Config\TokenConfig;
use Rosello\T411Bundle\Storage\Token\Storage;

class TokenConfigProvider
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @param Storage $storage
     */
    public function __construct(Authentication $authentication, Storage $storage, $username, $password)
    {
        $this->storage = $storage;
        $this->username = $username;
        $this->password = $password;
        $this->authentication = $authentication;
    }

    /**
     * @return TokenConfig
     * @throws \Rosello\T411\Exception\AuthenticationException
     */
    public function getTokenConfig()
    {
        $token = $this->storage->getToken();

        if ($token) {
            return $token instanceof TokenConfig ?: new TokenConfig($token);
        }

        $authConfig = new AuthConfig($this->username, $this->password);

        $tokenConfig = $this->authentication->auth($authConfig);

        $this->storage->setToken($tokenConfig->getToken());

        return $tokenConfig;
    }
}