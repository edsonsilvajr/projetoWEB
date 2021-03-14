<?php
//header('Location: http://localhost:3000/');

//$json = file_get_contents("teste.json");

$file_path = getcwd() . "/models/recipes.json";

$receitas = json_decode(file_get_contents($file_path), true);


$receita;
$id = getRandomId($receitas);

function getRandomId($receitas)
{
    $random_id = random_int(0, 1000000);
    while (array_search($random_id, array_column($receitas, 'id'))) {
        $random_id = random_int(0, 1000000);
    }
    return $random_id;
}

if (str_contains($metodo, 'POST')) {
    $receita = json_decode(file_get_contents('php://input'), true);
    $receita['id'] = $id;
    array_push($receitas, $receita);
    file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
    echo json_encode($receitas);
} else if (str_contains($metodo, 'GET')) {
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
            $filterList = [];
            if (!$title && $category) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalCategory = strtolower($receitas[$indice]['category']);
                    if (strtolower($category) === $finalCategory) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
            } else if ($title && $category) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalTitle = strtolower($receitas[$indice]['title']);
                    $finalCategory = strtolower($receitas[$indice]['category']);

                    if (strtolower($category) === $finalCategory && strtolower($title) === $finalTitle) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
            } else if ($title) {
                for ($indice = 0; $indice < sizeof($receitas); $indice++) {
                    $finalTitle = strtolower($receitas[$indice]['title']);
                    if (strtolower($title) === $finalTitle) {
                        array_push($filterList, $receitas[$indice]);
                    }
                }
            } else {
                $message = [
                    "status" => "invalid",
                    "errors" => "no query found"
                ];
                echo json_encode($message);
            }

            if (!empty($filterList)) echo json_encode($filterList);

            break;
        default:
            break;
    }
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
        unset($receitas[$indice]);
        file_put_contents($file_path, json_encode($receitas)); // escrevendo no arquivo
        echo json_encode($receitas);
    } else {
        http_response_code(404);
        echo "no element to delete";
    }
}
