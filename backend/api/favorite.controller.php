<?php


require('models/favorite.model.php');
require('models/auth.model.php');

if (str_contains($metodo, 'POST')) {
    metodoPost();
} else if (str_contains($metodo, 'GET')) {
    metodoGet($usuarios);
} else if (str_contains($metodo, 'PUT')) {
    if (isAuth()) {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    } else {
        metodoPut();
    }
} else if (str_contains($metodo, 'DELETE')) {
    if (isAuth()) {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    } else {
        metodoDelete();
    }
}
