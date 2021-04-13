<?php

require("utils/functions.php");

require('conexao.php');

function metodoPost($id, $usuarios, $file_path)
{
    $favorite['uid'] = $_GET['uid'];
    $favorite['rid'] = $_GET['rid'];
    $favorite['id'] = $id;
    echo json_encode($_POST);
    print_r($_POST);

    $bd = Conexao::get();
    $query = $bd->prepare("INSERT INTO favorites (id, uid, rid) VALUES(:id, :uid, :rid)");
    $query->bindParam(':id',  $favorite['id']);
    $query->bindParam(':uid', $favorite['uid']);
    $query->bindParam(':rid', $favorite['rid']);
    $query->execute();
}

function metodoGet($usuarios)
{
}

function metodoPut($usuarios, $file_path)
{
}

function metodoDelete($usuarios, $file_path)
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
