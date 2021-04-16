<?php

use projetoweb\models\User;

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function get()
    {
        $indice = $_GET['uid'];
        try {
            echo $this->userModel->readUser($indice);
        } catch (Exception $e) {
            if ($e->getCode() == 1) {
                $message = [
                    "data" => [],
                    "status" => "Not Found",
                    "errors" => "User not found"
                ];
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode($message);
            } else {
                http_response_code(400);
                throw $e;
            }
        }
    }

    public function post()
    {
        $this->userModel->saveUser();
    }

    public function put()
    {
        $this->userModel->saveUser();
    }

    public function delete()
    {
        $this->userModel->saveUser();
    }
}

/* require('models/auth.model.php');


if (str_contains($metodo, 'POST')) {
    //defino o usuario

    metodoPost();
} else if (str_contains($metodo, 'GET')) {
    metodoGet();
} else if (str_contains($metodo, 'PUT')) {
    if (isAuth()) {
        metodoPut();
    } else {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    }
} else if (str_contains($metodo, 'DELETE')) {
    if (isAuth()) {
        metodoDelete();
    } else {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    }
} */
