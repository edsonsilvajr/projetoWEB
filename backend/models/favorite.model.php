<?php

require("utils/functions.php");

require_once('conexao.php');

function metodoPost()
{
    $favorite['uid'] = $_GET['uid'];
    $favorite['rid'] = $_GET['rid'];

    $bd = Conexao::get();
    $query = $bd->prepare("INSERT INTO favorites (uid, rid) VALUES(:uid, :rid)");
    $query->bindParam(':uid', $favorite['uid']);
    $query->bindParam(':rid', $favorite['rid']);
    $query->execute();
}

function metodoGet()
{
    $indice = $_GET['uid'];

    $bd = Conexao::get();

    $query = $bd->prepare("SELECT * FROM recipes INNER JOIN favorites WHERE favorites.uid =:uid AND recipes.id = favorites.rid");
    $query->bindParam(':uid', $indice);
    $query->execute();

    $favorites = $query->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($favorites);
}

function metodoPut()
{
    $favorite['uid'] = $_GET['uid'];
    $favorite['rid'] = $_GET['rid'];

    $bd = Conexao::get();
    $query = $bd->prepare('SELECT * FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid');
    $query->bindParam(':uid', $favorite['uid']);
    $query->bindParam(':rid', $favorite['rid']);
    $query->execute();
    $favorites = $query->fetch(PDO::FETCH_OBJ);

    if ($favorites) {
        $query = $bd->prepare("DELETE FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid");
        $query->bindParam(':uid', $favorite['uid']);
        $query->bindParam(':rid', $favorite['rid']);
        $query->execute();
        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe Removed from Favorites'
        ];
        echo json_encode($message);
    } else {
        $query = $bd->prepare("INSERT INTO favorites (uid, rid) VALUES(:uid, :rid)");
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

function metodoDelete()
{
    $indice1 = $_GET['uid'];
    $indice2 = $_GET['rid'];
    $bd = Conexao::get();
    $query = $bd->prepare("DELETE FROM favorites WHERE favorites.uid = :uid AND favorites.rid = :rid");
    $query->bindParam(':uid', $indice1);
    $query->bindParam(':rid', $indice2);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_OBJ);
    if ($user != null) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo "Not Found";
    }
}
