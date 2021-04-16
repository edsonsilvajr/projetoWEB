<?php

namespace projetoweb\models;

use PDO;

class Favorite extends Model
{
    protected $uid;
    protected $rid;

    public function favorite()
    {
        $favorite['uid'] = $_GET['uid'];
        $favorite['rid'] = $_GET['rid'];

        $query = $this->bd->prepare('SELECT * FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid');
        $query->bindParam(':uid', $favorite['uid']);
        $query->bindParam(':rid', $favorite['rid']);
        $query->execute();
        $favorites = $query->fetch(PDO::FETCH_OBJ);

        if ($favorites) {
            $query = $this->bd->prepare("DELETE FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid");
            $query->bindParam(':uid', $favorite['uid']);
            $query->bindParam(':rid', $favorite['rid']);
            $query->execute();
            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe Removed from Favorites'
            ];
            echo json_encode($message);
        } else {
            $query = $this->bd->prepare("INSERT INTO favorites (uid, rid) VALUES(:uid, :rid)");
            $query->bindParam(':uid', $favorite['uid']);
            $query->bindParam(':rid', $favorite['rid']);
            $query->execute();

            $message = [
                'Status' => 'Success',
                'Message' => 'Recipe Marked as Favorite'
            ];
            echo json_encode($message);
        }
    }
}
