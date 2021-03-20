<?php

require("models/auth.model.php");

$file_path = getcwd() . "/models/users.json";

$users = json_decode(file_get_contents($file_path), true);

if (str_contains($metodo, 'POST')) {
    post($users);
}

if (str_contains($metodo, 'GET')) {
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
