<?php

require("models/auth.model.php");

class AuthController
{
    protected $authModel;
    public function __construct()
    {
        //$authModel = new Auth();
    }

    public function post()
    {
        post();
    }

    public function isAuthenticated()
    {
        if (isAuth()) {
            $message = [
                'message' => 'User authenticated!',
                'status' => 'success',
            ];
            http_response_code(200);
            echo $message;
        } else {
            http_response_code(401);
            echo $message = [
                'message' => 'User not authenticated!',
                'status' => 'success',
            ];
        }
    }
}
