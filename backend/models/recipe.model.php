<?php

require('utils/functions.php');

function metodoPost($id, $receitas, $file_path)
{
    $receita = json_decode(file_get_contents('php://input'), true);
    $receita['id'] = $id;

    if (!validateRecipe($receita)) return;

    array_push($receitas, $receita);
    file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
    //echo json_encode($receitas);
    $message = [
        'Status' => 'Sucess',
        'Message' => 'Recipe successfully registered!'
    ];
    echo json_encode($message);
}

function metodoGet($receitas)
{
    $indice = array_search($_GET['id'] ?? null, array_column($receitas, 'id'));

    switch ($_GET['getParam'] ?? null) {
        case '1': // 1 - Get One
            if ($indice || $indice === 0) {
                echo json_encode($receitas[$indice]);
            } else { // 404 - Not Found
                http_response_code(404);
                echo "Not Found";
            }
            break;
        case '2': // 2 - Get List
            echo json_encode($receitas);
            break;
        case '3': // 3 - Get List w/ Filters
            $category = empty($_GET['category']) ? null : $_GET['category'];
            $title = empty($_GET['title']) ? null : $_GET['title'];

            $input = preg_quote(strToLower($title), '~');

            $filterList = [];
            if (!$title && $category) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalCategory = strtolower($receitas[$indice]['category']);
                    if (strtolower($category) === $finalCategory) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
                echo json_encode($filterList);
            } else if ($title && $category) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalTitle = strtolower($receitas[$indice]['title']);
                    $finalCategory = strtolower($receitas[$indice]['category']);

                    if (strtolower($category) === $finalCategory && preg_match('~' . $input . '~', $finalTitle)) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
                echo json_encode($filterList);
            } else if ($title) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalTitle = strtolower($receitas[$indice]['title']);
                    if (preg_match('~' . $input . '~', $finalTitle)) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
                echo json_encode($filterList);
            } else {
                $message = [
                    "status" => "invalid",
                    "errors" => "no query found"
                ];
                echo json_encode($message);
            }
            break;
        default:
            http_response_code(400);
            echo "Bad Request";
            break;
    }
}

function metodoPut($receitas, $file_path)
{
    $receita = json_decode(file_get_contents('php://input'), true);

    if (!validateRecipe($receita)) return;

    $indice = array_search($_GET['id'] ?? null, array_column($receitas, 'id'));

    if ($indice !== false) {
        $receitas[$indice] = $receita;
        $receitas[$indice]['id'] = (int)$_GET['id'];
        file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
        echo json_encode($receitas);
    } else { // 404 not found
        http_response_code(404);
        echo "Receipe Not Found!";
    }
}

function metodoDelete($receitas, $file_path)
{
    $indice = array_search($_GET['id'] ?? null, array_column($receitas, 'id'));
    $file_path2 = getcwd() . "/models/users.json";

    $usuarios = json_decode(file_get_contents($file_path2), true);

    if ($indice !== false) {
        array_splice($receitas, $indice, 1);
        file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo

        for ($i = 0; $i < sizeof($usuarios); $i++) {

            if (in_Array($_GET['id'], $usuarios[$i]['favorites'])) {
                $aux = array_search($indice, array_column($usuarios[$i], 'favorites'));
                array_splice($usuarios[$i]['favorites'], $aux, 1);
                file_put_contents($file_path2, json_encode($usuarios));
            }
        }

        echo json_encode($receitas);
    } else {
        http_response_code(404);
        echo "No such recipe to be deleted";
    }
}
