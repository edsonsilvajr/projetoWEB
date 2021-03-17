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


$id = getRandomId($receitas);



if (str_contains($metodo, 'POST')) {
    metodoPost($id, $receitas, $file_path);
} else if (str_contains($metodo, 'GET')) {
    metodoGet($receitas);
} else if (str_contains($metodo, 'PUT')) {
    metodoPut($receitas, $file_path);
} else if (str_contains($metodo, 'DELETE')) {
    metodoDelete($receitas, $file_path);
}
