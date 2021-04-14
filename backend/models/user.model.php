<?php

require("utils/functions.php");

require('conexao.php');

function metodoPost($id, $usuarios, $file_path)
{
    $bd = Conexao::get();
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario['uid'] = $id;
    echo json_encode($usuario);

    if (!validateUser($usuario)) return;
    if (!isset($usuario['password'])) {
        $message = [
            "data" => [],
            "status" => "Missing Parameters",
            "errors" => "Missing password in payload!"
        ];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($message);
        return;
    }

    $query = $bd->prepare("SELECT * FROM users WHERE users.email = :email");
    $query->bindParam(':email', $usuario['email']);
    $query->execute();
    $resul = $query->fetchAll(PDO::FETCH_OBJ);

    if ($resul == null) {

        if (strtolower($usuario['type']) == 'aprendiz') {
            $usuario['document'] = null;
        }

        $query = $bd->prepare("INSERT INTO users (uid, name, type, password, gender, date, email, document) VALUES(:uid, :name, :type, :password, :gender, :date, :email, :document)");
        $query->bindParam(':uid', $usuario['uid']);
        $query->bindParam(':name', $usuario['name']);
        $query->bindParam(':type', $usuario['type']);
        $query->bindParam(':password', $usuario['password']);
        $query->bindParam(':gender', $usuario['gender']);
        $query->bindParam(':date', $usuario['date']);
        $query->bindParam(':email', $usuario['email']);
        $query->bindParam(':document', $usuario['document']);
        $query->execute();

        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe successfully registered!'
        ];
        echo json_encode($message);
    } else {
        $message = [
            "data" => [],
            "status" => "conflict",
            "errors" => "Email already registered"
        ];
        http_response_code(409);
        header('Content-Type: application/json');
        echo json_encode($message);
    }
}

function metodoGet($usuarios)
{
    $indice = $_GET['uid'];

    $bd = Conexao::get();

    $query = $bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
    $query->bindParam(':uid', $indice);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);


    if ($user != null) {
        $query = $bd->prepare("SELECT rid FROM favorites WHERE favorites.uid = :uid");
        $query->bindParam(':uid', $indice);
        $query->execute();
        $recipes = $query->fetchAll(PDO::FETCH_COLUMN);
        $user->favorites = $recipes;
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo "Not Found";
    }
}

function metodoPut($usuarios, $file_path)
{
    $bd = Conexao::get();
    $usuario = json_decode(file_get_contents('php://input'), true);
    if (!validateUser($usuario)) return;

    $query = $bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
    $query->bindParam(':uid', $usuario['uid']);
    $query->execute();
    $resul = $query->fetchAll(PDO::FETCH_OBJ);

    if ($resul != null) {

        $query = $bd->prepare("UPDATE users SET name = :name, type = :type, password = :password, gender = :gender, date = :date, email = :email, document = :document WHERE users.uid = :uid");
        $query->bindParam(':uid', $usuario['uid']);
        $query->bindParam(':name', $usuario['name']);
        $query->bindParam(':type', $usuario['type']);
        $query->bindParam(':password', $usuario['password']);
        $query->bindParam(':gender', $usuario['gender']);
        $query->bindParam(':date', $usuario['date']);
        $query->bindParam(':email', $usuario['email']);
        $query->bindParam(':document', $usuario['document']);
        $query->execute();

        $user = $query->fetchAll(PDO::FETCH_OBJ);

        $message = [
            'Status' => 'Success',
            'Message' => 'User successfully updated!'
        ];

        echo json_encode($message);
    } else { // 404 not found
        http_response_code(404);
        echo "User not found";
    }
}

function metodoDelete($usuarios, $file_path)
{
    $indice = $_GET['uid'];
    $bd = Conexao::get();

    $query = $bd->prepare("SELECT users.uid FROM users WHERE users.uid = :uid");
    $query->bindParam(':uid', $indice);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_OBJ);

    if ($user != null) {
        $query = $bd->prepare("DELETE FROM users WHERE users.uid = :uid");
        $query->bindParam(':uid', $indice);
        $query->execute();

        $message = [
            'Status' => 'Success',
            'Message' => 'Recipe successfully deleted!'
        ];
        echo json_encode($message);
    } else {
        http_response_code(404);
        echo "Error User Not Found/Removed";
    }
}
