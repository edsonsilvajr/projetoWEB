<?php

use projetoweb\models\Recipe;
use projetoweb\utils\Validator;
use projetoweb\utils\Error;

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
            Error::fireMessage(new Exception('Missing parameters (id, category, title or getParam)', 406));
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
            Error::fireMessage($e);
        }
    }

    public function post()
    {
        //pegando usuário do payload
        $receita = json_decode(file_get_contents('php://input'), true);

        //validando usuário e retornando mensagem caso não seja valido
        if (!Validator::validate('recipe', $receita)) {
            return;
        };

        //setando campos do objeto
        $this->recipeModel->setByArray($receita);
        try {
            $this->recipeModel->saveRecipe();
        } catch (Exception $e) {
            Error::fireMessage($e);
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
            Error::fireMessage($e);
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            Error::fireMessage(new Exception("Missing 'id' in query", 406));
            return;
        }

        $indice = $_GET['id'];

        try {
            $this->recipeModel->id = $indice;
            $this->recipeModel->deleteRecipe();
        } catch (Exception $e) {
            Error::fireMessage($e);
        }
    }
}
