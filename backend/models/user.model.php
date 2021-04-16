<?php

namespace projetoweb\models;

use Exception;
use projetoweb\utils\Validator;
use PDO;

class User extends Model
{
    protected $uid;
    protected $name;
    protected $type;
    protected $password;
    protected $gender;
    protected $date;
    protected $email;
    protected $document;

    public function readUser()
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($user != null) {
            try {
                $query = $this->bd->prepare("SELECT rid FROM favorites WHERE favorites.uid = :uid");
                $query->bindParam(':uid', $this->uid);
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

    public function saveUser()
    {
        $query = $this->bd->prepare("SELECT * FROM users WHERE users.email = :email");
        $query->bindParam(':email', $this->email);
        $query->execute();
        $resul = $query->fetchAll(PDO::FETCH_OBJ);

        if ($resul == null) {

            if (strtolower($this->type) == 'aprendiz') {
                $this->document = null;
            }

            try {
                $query = $this->bd->prepare("INSERT INTO users (name, type, password, gender, date, email, document) VALUES(:name, :type, :password, :gender, :date, :email, :document)");
                $query->bindParam(':name', $this->name);
                $query->bindParam(':type', $this->type);
                $query->bindParam(':password', $this->password);
                $query->bindParam(':gender', $this->gender);
                $query->bindParam(':date', $this->date);
                $query->bindParam(':email', $this->email);
                $query->bindParam(':document', $this->document);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }

            $message = [
                'Status' => 'Success',
                'Message' => 'User successfully registered!'
            ];
            return json_encode($message);  //retornar pro controlador

        } else {
            throw new Exception("Error Processing Request", 2);
        }
    }

    public function alterUser()
    {
        try {
            $query = $this->bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $resul = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($resul != null) {
            try {
                $query = $this->bd->prepare("UPDATE users SET name = :name, type = :type, gender = :gender, date = :date, email = :email, document = :document WHERE users.uid = :uid");
                $query->bindParam(':uid', $this->uid);
                $query->bindParam(':name', $this->name);
                $query->bindParam(':type', $this->type);
                $query->bindParam(':gender', $this->gender);
                $query->bindParam(':date', $this->date);
                $query->bindParam(':email', $this->email);
                $query->bindParam(':document', $this->document);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }

            try {
                $query = $this->bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
                $query->bindParam(':uid', $this->uid);
                $query->execute();
                $userToSend = $query->fetch(PDO::FETCH_OBJ);
            } catch (Exception $e) {
                throw $e;
            }


            unset($userToSend->password);

            $message = [
                "data" => $userToSend,
                "status" => "Success",
                "message" => "Successfully updated!"
            ];

            return json_encode($message);
        } else { // 404 not found
            throw new Exception("User not found", 1);
        }
    }

    public function deleteUser()
    {
        $query = $this->bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
        $query->bindParam(':uid', $this->uid);
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_OBJ);

        if ($user != null) {
            $query = $this->bd->prepare("DELETE FROM users WHERE users.uid = :uid");
            $query->bindParam(':uid', $this->uid);
            $query->execute();

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe successfully deleted!'
            ];
            return json_encode($message);
        } else {
            throw new Exception("User not found", 1);
        }
    }
}
