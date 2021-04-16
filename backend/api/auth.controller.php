<?php

use projetoweb\models\Auth;
use projetoweb\utils\Error;

class AuthController
{
    protected $authModel;
    public function __construct()
    {
        $this->authModel = new Auth();
    }

    public function post()
    {
        try {
            echo $this->authModel->authenticate();
        } catch (Exception $e) {
            Error::fireMessage($e);
        }
    }

    public function isAuthenticated()
    {
        return $this->authModel->isAuth();
    }
}
