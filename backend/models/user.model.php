<?php

namespace projetoweb\models;

use Exception;
use projetoweb\utils\Validator;
use PDO;

class User extends Model
{
    private $uid;
    private $name;
    private $type;
    private $password;
    private $gender;
    private $date;
    private $email;
    private $document;

    public function saveUser()
    {
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (!Validator::validate('user', $usuario)) return;

        if (!isset($usuario['password'])) { // responsa do controlador
            $message = [
                "data" => [],
                "status" => "Missing Parameters",
                "errors" => "Missing password in payload!"
            ];
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode($message);
            return;
        }

        $query = $this->bd->prepare("SELECT * FROM users WHERE users.email = :email");
        $query->bindParam(':email', $usuario['email']);
        $query->execute();
        $resul = $query->fetchAll(PDO::FETCH_OBJ);

        if ($resul == null) {

            if (strtolower($usuario['type']) == 'aprendiz') {
                $usuario['document'] = null;
            }

            try {
                $query = $this->bd->prepare("INSERT INTO users (name, type, password, gender, date, email, document) VALUES(:name, :type, :password, :gender, :date, :email, :document)");
                $query->bindParam(':name', $usuario['name']);
                $query->bindParam(':type', $usuario['type']);
                $query->bindParam(':password', $usuario['password']);
                $query->bindParam(':gender', $usuario['gender']);
                $query->bindParam(':date', $usuario['date']);
                $query->bindParam(':email', $usuario['email']);
                $query->bindParam(':document', $usuario['document']);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe successfully registered!'
            ];
            echo json_encode($message);  //retornar pro controlador

        } else {
            $message = [
                "data" => [],
                "status" => "conflict",
                "errors" => "Email already registered"
            ];
            http_response_code(409);
            header('Content-Type: application/json');
            echo json_encode($message); //retornar pro controlador
            // throw new Exception("Error Processing Request", 1);
        }
    }

    public function alterUser()
    {
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (!Validator::validate('user', $usuario)) return;

        $query = $this->bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
        $query->bindParam(':uid', $usuario['uid']);
        $query->execute();
        $resul = $query->fetchAll(PDO::FETCH_OBJ);

        if ($resul != null) {

            $query = $this->bd->prepare("UPDATE users SET name = :name, type = :type, gender = :gender, date = :date, email = :email, document = :document WHERE users.uid = :uid");
            $query->bindParam(':uid', $usuario['uid']);
            $query->bindParam(':name', $usuario['name']);
            $query->bindParam(':type', $usuario['type']);
            $query->bindParam(':gender', $usuario['gender']);
            $query->bindParam(':date', $usuario['date']);
            $query->bindParam(':email', $usuario['email']);
            $query->bindParam(':document', $usuario['document']);
            $query->execute();

            $query = $this->bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $usuario['uid']);
            $query->execute();
            $userToSend = $query->fetch(PDO::FETCH_OBJ);

            unset($userToSend->password);

            $message = [
                "data" => $userToSend,
                "status" => "Success",
                "message" => "Successfully updated!"
            ];

            echo json_encode($message);
        } else { // 404 not found
            http_response_code(404);
            echo "User not found";
        }
    }

    public function deleteUser()
    {
        $indice = $_GET['uid'];

        $query = $this->bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
        $query->bindParam(':uid', $indice);
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_OBJ);

        if ($user != null) {
            $query = $this->bd->prepare("DELETE FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $indice);
            $query->execute();

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe successfully deleted!'
            ];
            echo json_encode($message);
        } else {
            http_response_code(404);
            echo "Error User Not Found/Removed";
        }
    }

    public function readUser($indice)
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $indice);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($user != null) {
            try {
                $query = $this->bd->prepare("SELECT rid FROM favorites WHERE favorites.uid = :uid");
                $query->bindParam(':uid', $indice);
                $query->execute();
                $recipes = $query->fetchAll(PDO::FETCH_COLUMN);
                $user->favorites = $recipes;
                return json_encode($user);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Exception("User not found", 1);
        }
    }
}
