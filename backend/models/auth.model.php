<?php

require_once('conexao.php');

function isAuthenticated($receivedToken)
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

function post()
{
    $json = json_decode(file_get_contents('php://input'), true);
    //$user_index = array_search($json['email'] ?? null, array_column($users, 'email'));
    $bd = Conexao::get();
    $query = $bd->prepare('SELECT * FROM users WHERE users.email = :email');
    $query->bindParam(':email', $json['email']);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);

    if ($user) {
        if ($user->password === $json['password']) {
            $header = [
                'alg' => 'HS256',
                'typ' => 'jwt'
            ];

            $header = json_encode($header);
            $header = base64_encode($header);

            $payload = [
                'uid' => $user->uid,
                'name' => $user->name,
                'type' => $user->type
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
            echo json_encode($message);
        } else {
            $message = [
                "data" => [],
                "status" => "invalid",
                "errors" => "Incorrect Password"
            ];
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode($message);
        }
    } else {
        $message = [
            "data" => [],
            "status" => "invalid",
            "errors" => "User not found"
        ];
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode($message);
    }
}

function isAuth()
{
    if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        return isAuthenticated($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    } else {
        return false;
    }
}
