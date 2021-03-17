<?php


require('models/user.model.php');


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
    metodoPost($id, $usuarios, $file_path);
} else if (str_contains($metodo, 'GET')) {
    metodoGet($usuarios);
} else if (str_contains($metodo, 'PUT')) {
    metodoPut($usuarios, $file_path);
} else if (str_contains($metodo, 'DELETE')) {
    metodoDelete($usuarios, $file_path);
}
