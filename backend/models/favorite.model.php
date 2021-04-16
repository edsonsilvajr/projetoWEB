<?php

namespace projetoweb\models;

use Exception;
use PDO;

class Favorite extends Model
{
    protected $uid;
    protected $rid;

    public function favorite()
    {
        try {
            $query = $this->bd->prepare('SELECT * FROM users WHERE users.uid=:uid');
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($user == NULL) {
            throw new Exception('User not Found', 404);
        }

        try {
            $query = $this->bd->prepare('SELECT * FROM recipes WHERE recipes.id=:rid');
            $query->bindParam(':rid', $this->rid);
            $query->execute();
            $recipe = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($recipe == NULL) {
            throw new Exception('Recipe not Found', 404);
        }

        try {
            $query = $this->bd->prepare('SELECT * FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid');
            $query->bindParam(':uid', $this->uid);
            $query->bindParam(':rid', $this->rid);
            $query->execute();
            $favorites = $query->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        if ($favorites) {
            try {
                $query = $this->bd->prepare("DELETE FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid");
                $query->bindParam(':uid', $this->uid);
                $query->bindParam(':rid', $this->rid);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }
            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe Removed from Favorites'
            ];
            return json_encode($message);
        } else {
            try {
                $query = $this->bd->prepare("INSERT INTO favorites (uid, rid) VALUES(:uid, :rid)");
                $query->bindParam(':uid', $this->uid);
                $query->bindParam(':rid', $this->rid);
                $query->execute();
            } catch (Exception $e) {
                throw $e;
            }
            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe Marked as Favorite'
            ];
            return json_encode($message);
        }
    }

    function getFavorites()
    {
        try {
            $query = $this->bd->prepare("SELECT *, recipes.id as id FROM recipes INNER JOIN favorites WHERE favorites.uid =:uid AND recipes.id = favorites.rid");
            $query->bindParam(':uid', $this->uid);
            $query->execute();

            $favorites = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }

        return json_encode($favorites);
    }
}
