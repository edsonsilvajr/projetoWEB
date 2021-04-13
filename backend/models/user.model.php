<?php

require("utils/functions.php");

require('conexao.php');

function metodoPost($id, $usuarios, $file_path)
{
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario[0]['uid'] = $id;
    print_r($usuario);
    echo json_encode($usuario);

    $bd = Conexao::get();
    $query = $bd->prepare("INSERT INTO users (uid, name, type, password, gender, date, email, document) VALUES(:uid, :name, :type, :password, :gender, :date, :email, :document)");
    $query->bindParam(':uid', $usuario[0]['uid']);
    $query->bindParam(':name', $usuario[0]['name']);
    $query->bindParam(':type', $usuario[0]['type']);
    $query->bindParam(':password', $usuario[0]['password']);
    $query->bindParam(':gender', $usuario[0]['gender']);
    $query->bindParam(':date', $usuario[0]['date']);
    $query->bindParam(':email', $usuario[0]['email']);
    $query->bindParam(':document', $usuario[0]['document']);
    $query->execute();

    /*
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario['favorites'] = [];
    $usuario['uid'] = $id;
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
    //var_dump($usuario);
    if (!in_array($usuario['email'], array_column($usuarios, 'email'))) {
        if (strtolower($usuario['type']) == 'aprendiz') {
            $usuario['document'] = null;
        }
        array_push($usuarios, $usuario);
        file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
        echo json_encode($usuarios);
    } else { // Email
        $message = [
            "data" => [],
            "status" => "conflict",
            "errors" => "Email already registered"
        ];
        http_response_code(409);
        header('Content-Type: application/json');
        echo json_encode($message);
    }*/
}

function metodoGet($usuarios)
{
    $indice = $_GET['uid'];

    $bd = Conexao::get();

    $query = $bd->prepare("SELECT rid FROM favorites WHERE favorites.uid = :uid");
    $query->bindParam(':uid', $indice);
    $query->execute();
    $recipes = $query->fetchAll(PDO::FETCH_COLUMN);


    $query = $bd->prepare("SELECT * FROM users WHERE users.uid = :uid");
    $query->bindParam(':uid', $indice);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);
    $user->favorites = $recipes;


    if ($user != null) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo "Not Found";
    }


    /*
    $indice = array_search($_GET['uid'] ?? null, array_column($usuarios, 'uid'));

    if ($indice || $indice === 0) {

        $user = $usuarios[$indice];
        unset($user['password']);
        echo json_encode($user);
    } else { // 404 - Not Found
        http_response_code(404);
        echo "Not Found";
    }
    */
}

function metodoPut($usuarios, $file_path)
{

    $usuario = json_decode(file_get_contents('php://input'), true);

    $bd = Conexao::get();
    $query = $bd->prepare("UPDATE users SET name = :name, type = :type, password = :password, gender = :gender, date = :date, email = :email, document = :document WHERE users.uid = :uid");
    $query->bindParam(':uid', $usuario[0]['uid']);
    $query->bindParam(':name', $usuario[0]['name']);
    $query->bindParam(':type', $usuario[0]['type']);
    $query->bindParam(':password', $usuario[0]['password']);
    $query->bindParam(':gender', $usuario[0]['gender']);
    $query->bindParam(':date', $usuario[0]['date']);
    $query->bindParam(':email', $usuario[0]['email']);
    $query->bindParam(':document', $usuario[0]['document']);
    $query->execute();

    $user = $query->fetchAll(PDO::FETCH_OBJ);
    print_r($user);



    /*
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario['password'] = '';
    $usuario['favorites'] = [];
    if (!validateUser($usuario)) return;

    $indice = array_search($_GET['uid'] ?? null, array_column($usuarios, 'uid'));

    switch ($_GET['getParam'] ?? null) {
        case '1': // updating entire user
            if ($indice || $indice === 0) {
                $passwordBackup = $usuarios[$indice]['password'];
                $favoritesBackup = $usuarios[$indice]['favorites'];
                $usuarios[$indice] = $usuario;

                // recebendo os campos que podem ser perdidos
                $usuarios[$indice]['password'] = $passwordBackup;
                $usuarios[$indice]['favorites'] = $favoritesBackup;

                $usuarios[$indice]['uid'] = (int)$_GET['uid'];
                $userToSend = $usuarios[$indice];
                unset($userToSend['password']);

                $message = [
                    "data" => $userToSend,
                    "status" => "Success",
                    "message" => "Successfully updated!"
                ];
                file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
                echo json_encode($message);
            } else { // 404 not found
                http_response_code(404);
                echo "not found";
            }
            break;
        case '2': //updating favorites list
            if ($indice || $indice === 0) {
                $usuarios[$indice]['favorites'] = $usuario['favorites'];
                $message = [
                    "data" => [],
                    "status" => "Success",
                    "message" => "Successfully updated!"
                ];
                file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
                echo json_encode($message);
            } else { // 404 not found
                http_response_code(404);
                echo "not found";
            }
            break;
        default:
            http_response_code(400);
            echo "Bad request";
            break;
    }
    */
}

function metodoDelete($usuarios, $file_path)
{
    $indice = $_GET['uid'];

    $bd = Conexao::get();
    $query = $bd->prepare("DELETE FROM users WHERE users.uid = :uid");
    $query->bindParam(':uid', $indice);
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_OBJ);
    if ($user == null) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo "Error User Not Removed";
    }

    /*
    $indice = array_search($_GET['uid'] ?? null, array_column($usuarios, 'uid'));
    if ($indice || $indice === 0) {
        array_splice($usuarios, $indice, 1);
        file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
        echo json_encode($usuarios);
    } else {
        http_response_code(404);
        echo "no element to delete";
    }*/
}
