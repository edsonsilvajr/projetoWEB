<?php

use projetoweb\models\User;
use projetoweb\utils\Validator;

class UserController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function get()
    {
        //indice a ser lido
        if (!isset($_GET['uid'])) {
            http_response_code(400);
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'uid' in query"
            ];
            echo json_encode($message);
            return;
        }

        $indice = $_GET['uid'];

        //tentando ler usuário do banco
        try {
            $this->userModel->uid = $indice;
            echo $this->userModel->readUser();
        } catch (Exception $e) {
            //usuário não encontrado
            $this->errorMessage($e);
        }
    }

    public function post()
    {
        //pegando usuário do payload
        $usuario = json_decode(file_get_contents('php://input'), true);

        //validando usuário e retornando mensagem caso não seja valido
        if (!Validator::validate('user', $usuario)) {
            return;
        };
        if (!isset($usuario['password'])) {
            $message = [
                "data" => [],
                "status" => "Missing Parameters",
                "errors" => "Missing password in payload!"
            ];
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode($message);
        }

        //setando campos do objeto
        $this->userModel->setByArray($usuario);

        //tentando salvar no banco
        try {
            echo $this->userModel->saveUser();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function put()
    {
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (!Validator::validate('user', $usuario)) return;

        $this->userModel->setByArray($usuario);
        try {
            echo $this->userModel->alterUser();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function delete()
    {
        if (!isset($_GET['uid'])) {
            http_response_code(400);
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'uid' in query"
            ];
            echo json_encode($message);
            return;
        }

        $indice = $_GET['uid'];

        try {
            $this->userModel->uid = $indice;
            echo $this->userModel->deleteUser();
        } catch (Exception $e) {
            $this->errorMessage($e);
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

            case 2:
                $message = [
                    "data" => [],
                    "status" => "Conflict",
                    "errors" => "Email already registered!"
                ];
                http_response_code(409);
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
