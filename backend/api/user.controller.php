<?php

use projetoweb\models\User;
use projetoweb\utils\Validator;
use projetoweb\utils\Error;

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
            Error::fireMessage(new Exception("Missing 'uid' in query", 406));
            return;
        }

        $indice = $_GET['uid'];

        //tentando ler usuário do banco
        try {
            $this->userModel->uid = $indice;
            echo $this->userModel->readUser();
        } catch (Exception $e) {
            //usuário não encontrado
            Error::fireMessage($e);
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
            Error::fireMessage(new Exception('Missing password in payload!', 406));
        }

        //setando campos do objeto
        $this->userModel->setByArray($usuario);

        //tentando salvar no banco
        try {
            echo $this->userModel->saveUser();
        } catch (Exception $e) {
            Error::fireMessage($e);
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
            Error::fireMessage($e);
        }
    }

    public function delete()
    {
        if (!isset($_GET['uid'])) {
            Error::fireMessage(new Exception("Missing 'uid' in query", 406));
            return;
        }

        $indice = $_GET['uid'];

        try {
            $this->userModel->uid = $indice;
            echo $this->userModel->deleteUser();
        } catch (Exception $e) {
            Error::fireMessage($e);
        }
    }
}
