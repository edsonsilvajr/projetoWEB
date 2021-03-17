<?php

require('models/recipe.model.php');

function getRandomId($receitas)
{
    $random_id = random_int(0, 1000000);
    while (array_search($random_id, array_column($receitas, 'id'))) {
        $random_id = random_int(0, 1000000);
    }
    return $random_id;
}

$file_path = getcwd() . "/models/recipes.json";

$receitas = json_decode(file_get_contents($file_path), true);



$receita;
$id = getRandomId($receitas);



if (str_contains($metodo, 'POST')) {
    metodoPost($id, $receitas, $file_path);
} else if (str_contains($metodo, 'GET')) {
    metodoGet($receitas);
} else if (str_contains($metodo, 'PUT')) {
    $indice = array_search($_GET['id'], array_column($receitas, 'id'));
    $receita = json_decode(file_get_contents('php://input'), true);

    if ($indice || $indice === 0) {
        $receitas[$indice] = $receita;
        $receitas[$indice]['id'] = (int)$_GET['id'];
        file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
        echo json_encode($receitas);
    } else { // 404 not found
        http_response_code(404);
        echo "not found";
    }
} else if (str_contains($metodo, 'DELETE')) {
    $indice = array_search($_GET['id'], array_column($receitas, 'id'));
    if ($indice || $indice === 0) {
        array_splice($receitas, $indice, 1);
        file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
        echo json_encode($receitas);
    } else {
        http_response_code(404);
        echo "no element to delete";
    }
}
