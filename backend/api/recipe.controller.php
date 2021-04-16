<?php

use projetoweb\models\Recipe;
use projetoweb\utils\Validator;

class RecipeController
{
    protected $recipeModel;
    public function __construct()
    {
        $this->recipeModel = new Recipe();
    }

    public function get()
    {

        if (!isset($_GET['id']) && !isset($_GET['category']) && !isset($_GET['title']) && !isset($_GET['getParam'])) {
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'id/category/title/getParam' in query"
            ];
            echo json_encode($message);
            return;
        }

        $indice = $_GET['id'] ?? null;

        $category = empty($_GET['category']) ? null : $_GET['category'];
        $category = preg_quote(strToLower($category), '~');

        $title = empty($_GET['title']) ? null : $_GET['title'];
        $title = preg_quote(strToLower($title), '~');

        try {
            $this->recipeModel->id = $indice;
            $this->recipeModel->title = $title;
            $this->recipeModel->category = $category;
            echo $this->recipeModel->readRecipe();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function post()
    {
        //pegando usuário do payload
        $receita = json_decode(file_get_contents('php://input'), true);
        var_dump($receita);

        //validando usuário e retornando mensagem caso não seja valido
        if (!Validator::validate('recipe', $receita)) {
            return;
        };

        //setando campos do objeto
        $this->recipeModel->setByArray($receita);
        try {
            $this->recipeModel->saveRecipe();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function put()
    {

        $receita = json_decode(file_get_contents('php://input'), true);

        if (!Validator::validate('recipe', $receita)) {
            return;
        }

        $this->recipeModel->setByArray($receita);
        try {
            $this->recipeModel->alterRecipe();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'id' in query"
            ];
            echo json_encode($message);
            return;
        }

        $indice = $_GET['id'];

        try {
            $this->recipeModel->id = $indice;
            $this->recipeModel->deleteRecipe();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function errorMessage(Exception $e)
    {
        switch ($e->getCode()) {
            case 1:
                $message = [
                    "data" => [],
                    "status" => "Not Found",
                    "errors" => "Recipe not found"
                ];
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode($message);
                break;

            default:
                http_response_code(400);
                throw $e;
                break;
        }
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
