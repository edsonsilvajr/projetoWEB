<?php

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

    if ($received_signature === $valid_signature) {
        echo json_encode(["status" => "autenticado"]);
    } else {
        echo json_encode(["status" => "não autenticado"]);
    }
}

function metodoPost($users)
{
    $json = json_decode(file_get_contents('php://input'), true);
    $user_index = array_search($json['email'] ?? null, array_column($users, 'email'));
    if ($user_index || $user_index === 0) {
        if ($users[$user_index]['password'] === $json['password']) {
            // Gerando o token - JWT

            $header = [
                'alg' => 'HS256',
                'typ' => 'jwt'
            ];

            $header = json_encode($header);
            $header = base64_encode($header);

            $payload = [
                'uid' => $users[$user_index]['uid'],
                'name' => $users[$user_index]['name'],
                'type' => $users[$user_index]['type'],
                'favorites' => $users[$user_index]['favorites']
            ];
            $payload = json_encode($payload);
            $payload = base64_encode($payload);

            $signature = hash_hmac('sha256', "$header.$payload", '123', true);
            $signature = base64_encode($signature);

            $key = $header . '.' . $payload . '.' . $signature;

            $userToSend = $users[$user_index];
            unset($userToSend['password']);
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

function metodoGet()
{
    isAuthenticated($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
}