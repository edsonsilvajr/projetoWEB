<?php

use projetoweb\models\Recipe;

class RecipeController
{
    protected $recipeModel;
    public function __construct()
    {
        $this->recipeModel = new Recipe();
    }

    public function get()
    {
        try {
            echo $this->recipeModel->readRecipe();
        } catch (Exception $e) {
            if ($e->get == 1) {
                $message = [
                    "data" => [],
                    "status" => "Not Found",
                    "errors" => "User not found"
                ];
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode($message);
            }
        }
    }

    public function post()
    {
        $this->recipeModel->saveRecipe();
    }

    public function put()
    {
        $this->recipeModel->alterRecipe();
    }

    public function delete()
    {
        $this->recipeModel->deleteRecipe();
    }
}

/* 
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
    metodoGet();
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
        metodoDelete();
    } else {
        $message = [
            'error' => 'User not authenticated!'
        ];
        http_response_code(401);
        echo json_encode($message);
    }
} */
