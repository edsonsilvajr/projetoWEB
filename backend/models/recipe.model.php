<?php

namespace projetoweb\models;

use Exception;
use projetoweb\Conexao;
use projetoweb\utils\Validator;
use PDO;

class Recipe extends Model
{
    protected $id;
    protected $author;
    protected $authorid;
    protected $title;
    protected $url;
    protected $description;
    protected $ingredients;
    protected $preparationMode;
    protected $category;

    public function saveRecipe()
    {


        try {
            $query = $this->bd->prepare("INSERT INTO recipes (id, author, authorid, title, url, description, ingredients, preparationMode, category) VALUES(:id, :author, :authorid, :title, :url, :description, :ingredients, :preparationMode, :category)");
            $query->bindParam(':id', $this->id);
            $query->bindParam(':author', $this->aauthor);
            $query->bindParam(':authorid', $this->authorid);
            $query->bindParam(':title', $this->title);
            $query->bindParam(':url', $this->url);
            $query->bindParam(':description', $this->description);
            $query->bindParam(':ingredients', $this->ingredients);
            $query->bindParam(':preparationMode', $this->preparationMode);
            $query->bindParam(':category', $this->category);
            $query->execute();
        } catch (Exception $e) {
            throw $e;
        }

        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe successfully registered!'
        ];

        echo json_encode($message);
    }

    public function alterRecipe()
    {

        try {
            $query = $this->bd->prepare("SELECT * FROM recipes WHERE recipes.id = :id");
            $query->bindParam(':id', $this->id);
            $query->execute();
            $resul = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }



        if ($resul != null) {
            try {
                $query = $this->bd->prepare("UPDATE recipes SET title = :title, url = :url, description = :description, preparationMode = :preparationMode, category = :category WHERE recipes.id = :id");
                $query->bindParam(':id', $this->id);
                $query->bindParam(':title', $this->title);
                $query->bindParam(':url', $this->url);
                $query->bindParam(':description', $this->description);
                $query->bindParam(':preparationMode', $this->preparationMode);
                $query->bindParam(':category', $this->category);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe successfully updated!'
            ];
            echo json_encode($message);
        } else {
            throw new Exception("Recipe not found", 1);
        }
    }

    public function deleteRecipe()
    {

        try {
            $query = $this->bd->prepare("SELECT * FROM recipes WHERE recipes.id = :id");
            $query->bindParam(':id', $this->id);
            $query->execute();
            $recipe = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($recipe != null) {
            try {
                $query = $this->bd->prepare("DELETE FROM recipes WHERE recipes.id = :id");
                $query->bindParam(':id', $this->id);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe successfully deleted!'
            ];
            echo json_encode($message);
        } else {
            throw new Exception("Recipe not found", 1);
        }
    }

    public function readRecipe()
    {

        switch ($_GET['getParam'] ?? null) {
            case '1': //GET ONE SPECIFIC RECIPE
                try {
                    $query = $this->bd->prepare("SELECT * FROM recipes WHERE recipes.id=:id");
                    $query->bindParam(':id', $this->id);
                    $query->execute();
                    $recipe = $query->fetch(PDO::FETCH_OBJ);
                } catch (Exception $e) {
                    throw $e;
                }

                if ($recipe != null) {
                    echo json_encode($recipe);
                } else {
                    throw new Exception("No Recipes found", 1);
                }

                break;

            case '2': //GET ALL THE RECIPES FROM THE DATABASE
                try {
                    $query = $this->bd->prepare(!$this->id ? 'SELECT * FROM recipes' : 'SELECT * FROM recipes WHERE recipes.authorid = :id');
                    if ($this->id) {
                        $query->bindParam(':id', $this->id);
                    }
                    $query->execute();
                    $recipes = $query->fetchall(PDO::FETCH_OBJ);
                    echo json_encode($recipes);
                } catch (Exception $e) {
                    throw $e;
                }
                break;

            case '3':

                if (!$this->title && $this->category) {
                    try {
                        $query = $this->bd->prepare('SELECT * FROM recipes WHERE lower(recipes.category)=:category');
                        $query->bindParam(':category', $this->category);
                        $query->execute();
                        $recipes = $query->fetchAll(PDO::FETCH_OBJ);
                    } catch (Exception $e) {
                        throw $e;
                    }

                    if ($recipes != null) {
                        echo json_encode($recipes);
                    } else {
                        throw new Exception("No Recipes found", 1);
                    }
                } else if ($this->title && $this->category) {
                    try {
                        $query = $this->bd->prepare('SELECT * FROM recipes WHERE lower(recipes.category) LIKE :category AND lower(recipes.title) LIKE "%":title"%" ');
                        $query->bindParam(':category', $this->category);
                        $query->bindParam(':title', $this->title);
                        $query->execute();
                        $recipes = $query->fetchAll(PDO::FETCH_OBJ);
                    } catch (Exception $e) {
                        throw $e;
                    }

                    if ($recipes != null) {
                        echo json_encode($recipes);
                    } else {
                        throw new Exception("No Recipes found", 1);
                    }
                } else if ($this->title) {
                    try {
                        $query = $this->bd->prepare('SELECT * FROM recipes WHERE lower(recipes.title) LIKE "%":title"%" ');
                        $query->bindParam(':title', $this->title);
                        $query->execute();
                        $recipes = $query->fetchAll(PDO::FETCH_OBJ);
                    } catch (Exception $e) {
                        throw $e;
                    }

                    if ($recipes != null) {
                        echo json_encode($recipes);
                    } else {
                        throw new Exception("No Recipes found", 1);
                    }
                }

                break;

            default:
                http_response_code(400);
                echo "Bad Request";
                break;
        }
    }
}
