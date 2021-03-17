<?php

function metodoPost($id, $receitas, $file_path)
{
    $receita = json_decode(file_get_contents('php://input'), true);
    $receita['id'] = $id;
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

    switch ($_GET['getParam']) {
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
            $category = empty($_GET['category']) ? null : $_GET['category'];;
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
            break;
    }
}
