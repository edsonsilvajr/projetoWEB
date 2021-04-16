<?php

namespace projetoweb\models;

use Exception;
use projetoweb\models\Model;
use PDO;

class Auth extends Model
{
    public function authenticate()
    {
        $json = json_decode(file_get_contents('php://input'), true);

        try {
            $query = $this->bd->prepare('SELECT * FROM users WHERE users.email = :email');
            $query->bindParam(':email', $json['email']);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($user) {
            if ($user->password === $json['password']) {
                $header = [
                    'alg' => 'HS256',
                    'typ' => 'jwt'
                ];

                $header = json_encode($header);
                $header = base64_encode($header);

                try {
                    $query = $this->bd->prepare("SELECT rid FROM favorites WHERE favorites.uid = :uid");
                    $query->bindParam(':uid', $user->uid);
                    $query->execute();
                    $recipes = $query->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $e) {
                    throw $e;
                }
                $user->favorites = $recipes;

                $payload = [
                    'uid' => $user->uid,
                    'name' => $user->name,
                    'type' => $user->type,
                    'favorites' => $user->favorites
                ];

                $payload = json_encode($payload);
                $payload = base64_encode($payload);

                $signature = hash_hmac('sha256', "$header.$payload", '123', true);
                $signature = base64_encode($signature);

                $key = $header . '.' . $payload . '.' . $signature;

                $userToSend = $user;

                unset($user->password);
                $message = [
                    "data" => ["token" => $key, "user" => $userToSend],
                    "status" => "success"
                ];
                return json_encode($message);
            } else {
                throw new Exception('Invalid Password', 3);
            }
        } else {
            throw new Exception('User not found', 1);
        }
    }

    public function isAuthenticated($receivedToken): bool
    {

        //TODO: CRIAR EXPIRAÇÃO

        $token = explode('Bearer ', $receivedToken);
        $token = explode('.', $token[1]);

        $header = $token[0];
        $payload = $token[1];

        //PARA EVITAR O \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        $received_signature = json_encode($token[2]);
        $received_signature = explode('"', $received_signature)[1];


        $valid_signature = hash_hmac('sha256', "$header.$payload", '123', true);
        $valid_signature = base64_encode($valid_signature);

        //PARA EVITAR O \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        $valid_signature = json_encode($valid_signature);
        $valid_signature = explode('"', $valid_signature)[1];

        return $received_signature === $valid_signature;
    }

    public function isAuth()
    {
        if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            return $this->isAuthenticated($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
        } else {
            return false;
        }
    }
}
