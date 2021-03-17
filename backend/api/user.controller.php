<?php
function getRandomId($usuarios)
{
    $random_id = random_int(0, 1000000);
    while (array_search($random_id, array_column($usuarios, 'uid'))) {
        $random_id = random_int(0, 1000000);
    }
    return $random_id;
}

$file_path = getcwd() . "/models/users.json";

$usuarios = json_decode(file_get_contents($file_path), true);
$id = getRandomId($usuarios);



if (str_contains($metodo, 'POST')) {
    $usuario = json_decode(file_get_contents('php://input'), true);
    $usuario['uid'] = $id;
    if (!in_array($usuario['email'], array_column($usuarios, 'email'))) {
        $usuario['favorites'] = [];
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

    switch ($_GET['getParam']) {
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
