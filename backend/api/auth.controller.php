<?php

use projetoweb\models\Auth;

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
            $this->errorMessage($e);
        }
    }

    public function isAuthenticated()
    {
        if ($this->authModel->isAuth()) {
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

    public function errorMessage(Exception $e)
    {
        switch ($e->getCode()) {
            case 1:
                $message = [
                    "data" => [],
                    "status" => "Not Found",
                    "errors" => "User not found"
                ];
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode($message);
                break;

            case 3:
                $message = [
                    "data" => [],
                    "status" => "invalid",
                    "errors" => "Incorrect Password"
                ];
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode($message);
                break;

            default:
                http_response_code(400);
                throw $e;
                break;
        }
    }
}
