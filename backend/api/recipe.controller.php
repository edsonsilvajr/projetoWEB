<?php

require('models/recipe.model.php');
require('models/auth.model.php');


if (str_contains($metodo, 'POST')) {
    if (isAuth()) {
        metodoPost();
    } else {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    }
} else if (str_contains($metodo, 'GET')) {
    metodoGet($receitas);
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
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    } else {
        metodoDelete();
    }
}
