<?php

require('utils/functions.php');

require('conexao.php');


function metodoPost($id, $receitas, $file_path)
{

    $receita = json_decode(file_get_contents('php://input'), true);
    $receita['id'] = $id;

    if (!validateRecipe($receita)) return;

    $bd = Conexao::get();
    $query = $bd->prepare("INSERT INTO recipes (id, author, authorid, title, url, description, ingredients, preparationMode, category) VALUES(:id, :author, :authorid, :title, :url, :description, :ingredients, :preparationMode, :category)");
    $query->bindParam(':id', $receita['id']);
    $query->bindParam(':author', $receita['author']);
    $query->bindParam(':authorid', $receita['authorid']);
    $query->bindParam(':title', $receita['title']);
    $query->bindParam(':url', $receita['url']);
    $query->bindParam(':description', $receita['description']);
    $query->bindParam(':ingredients', $receita['ingredients']);
    $query->bindParam(':preparationMode', $receita['preparationMode']);
    $query->bindParam(':category', $receita['category']);
    $query->execute();

    $message = [
        'Status' => 'Success',
        'Message' => 'Recipe successfully registered!'
    ];
    echo json_encode($message);
}

function metodoGet($receitas)
{
    $indice = $_GET['id'] ?? null;
    $bd = Conexao::get();

    switch ($_GET['getParam'] ?? null) {
        case '1': //GET ONE SPECIFIC RECIPE

            $query = $bd->prepare('SELECT * FROM recipes WHERE recipes.id=:id');
            $query->bindParam(':id', $indice);
            $query->execute();
            $recipe = $query->fetch(PDO::FETCH_OBJ);

            if ($recipe != null) {
                echo json_encode($recipe);
            } else {
                http_response_code(404);
                echo "Not Found";
            }

            break;

        case '2': //GET ALL THE RECIPES FROM THE DATABASE

            $query = $bd->prepare('SELECT * FROM recipes');
            $query->execute();
            $recipes = $query->fetchall(PDO::FETCH_OBJ);


            if ($recipes != null) {
                echo json_encode($recipes);
            } else {
                http_response_code(404);
                echo "Zero Recipes Registered in the site";
            }


            break;

        case '3':

            $category = empty($_GET['category']) ? null : $_GET['category'];
            $category = preg_quote(strToLower($category), '~');
            $title = empty($_GET['title']) ? null : $_GET['title'];
            $input = preg_quote(strToLower($title), '~');


            if (!$title && $category) {
                $query = $bd->prepare('SELECT * FROM recipes WHERE lower(recipes.category)=:category');
                $query->bindParam(':category', $category);
                $query->execute();
                $recipes = $query->fetchAll(PDO::FETCH_OBJ);
                if ($recipes != null) {
                    echo json_encode($recipes);
                } else {
                    http_response_code(404);
                    echo "Zero Recipes Registered in the session";
                }
            } else if ($title && $category) {
                $query = $bd->prepare('SELECT * FROM recipes WHERE lower(recipes.category) LIKE :category AND lower(recipes.title) LIKE "%":title"%" ');
                $query->bindParam(':category', $category);
                $query->bindParam(':title', $title);
                $query->execute();
                $recipes = $query->fetchAll(PDO::FETCH_OBJ);
                if ($recipes != null) {
                    echo json_encode($recipes);
                } else {
                    http_response_code(404);
                    echo "Zero Recipes Registered in the session with this name";
                }
            } else if ($title) {
                $query = $bd->prepare('SELECT * FROM recipes WHERE lower(recipes.title) LIKE "%":title"%" ');
                $query->bindParam(':title', $title);
                $query->execute();
                $recipes = $query->fetchAll(PDO::FETCH_OBJ);

                if ($recipes != null) {
                    echo json_encode($recipes);
                } else {
                    http_response_code(404);
                    echo "Zero Recipes Registered with this name";
                }
            } else {
                $message = [
                    "status" => "invalid",
                    "errors" => "no query found"
                ];
                echo json_encode($message);
            }


            break;

        default:
            http_response_code(400);
            echo "Bad Request";
            break;
    }
}

function metodoPut($receitas, $file_path)
{

    $receita = json_decode(file_get_contents('php://input'), true);

    if (!validateRecipe($receita)) return;

    $bd = Conexao::get();

    $query = $bd->prepare("SELECT * FROM recipes WHERE recipes.id = :id");
    $query->bindParam(':id', $receita['id']);
    $query->execute();
    $resul = $query->fetchAll(PDO::FETCH_OBJ);

    if ($resul != null) {

        $query = $bd->prepare("UPDATE recipes SET title = :title, url = :url, description = :description, preparationMode = :preparationMode, category = :category WHERE recipes.id = :id");
        $query->bindParam(':id', $receita['id']);
        $query->bindParam(':title', $receita['title']);
        $query->bindParam(':url', $receita['url']);
        $query->bindParam(':description', $receita['description']);
        $query->bindParam(':preparationMode', $receita['preparationMode']);
        $query->bindParam(':category', $receita['category']);
        $query->execute();

        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe successfully updated!'
        ];
        echo json_encode($message);
    } else {
        http_response_code(404);
        echo "Receipe Not Found!";
    }
}

function metodoDelete($receitas, $file_path)
{

    $indice = $_GET['id'];
    $bd = Conexao::get();

    $query = $bd->prepare("SELECT * FROM recipes WHERE recipes.id = :id");
    $query->bindParam(':id', $indice);
    $query->execute();
    $recipe = $query->fetchAll(PDO::FETCH_OBJ);



    if ($recipe != null) {
        $query = $bd->prepare("DELETE FROM recipes WHERE recipes.id = :id");
        $query->bindParam(':id', $indice);
        $query->execute();
        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe successfully deleted!'
        ];
        echo json_encode($message);
    } else {
        http_response_code(404);
        echo "No such recipe to be deleted";
    }
}
