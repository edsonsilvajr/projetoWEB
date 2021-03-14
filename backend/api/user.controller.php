<?php

$file_path = getcwd() . "/models/users.json";

$usuarios = json_decode(file_get_contents($file_path), true);
$id = getRandomId($usuarios);

function getRandomId($usuarios)
{
    $random_id = random_int(0, 1000000);
    while (array_search($random_id, array_column($usuarios, 'id'))) {
        $random_id = random_int(0, 1000000);
    }
    return $random_id;
}

if (str_contains($metodo, 'POST')) {
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario['uid'] = $id;
    if (!in_array($usuario['email'], array_column($usuarios, 'email'))) {
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
    }
} else if (str_contains($metodo, 'GET')) {
    $indice = array_search($_GET['uid'] ?? null, array_column($usuarios, 'uid'));

    if ($indice || $indice === 0) {

        unset($usuarios[$indice]['password']);
        echo json_encode($usuarios[$indice]);
    } else { // 404 - Not Found
        http_response_code(404);
        echo "Not Found";
    }
} else if (str_contains($metodo, 'PUT')) {
    $indice = array_search($_GET['uid'], array_column($usuarios, 'uid'));
    $usuario = json_decode(file_get_contents('php://input'), true);

    if ($indice || $indice === 0) {
        $usuarios[$indice] = $usuario;
        $usuarios[$indice]['uid'] = (int)$_GET['uid'];
        file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
        echo json_encode($usuarios);
    } else { // 404 not found
        http_response_code(404);
        echo "not found";
    }
} else if (str_contains($metodo, 'DELETE')) {
    $indice = array_search($_GET['uid'], array_column($usuarios, 'uid'));
    if ($indice || $indice === 0) {
        unset($usuarios[$indice]);
        file_put_contents($file_path, json_encode($usuarios)); // escrevendo no arquivo
        echo json_encode($usuarios);
    } else {
        http_response_code(404);
        echo "no element to delete";
    }
}
