<?php
//header('Location: http://localhost:3000/');

//$json = file_get_contents("teste.json");

$receitas = json_decode(file_get_contents("http://localhost/projetoWEB/backend/api/teste.json"), true);

$receita;
$id = 0;

if (str_contains($metodo, 'POST')) {
    $receita = json_decode(file_get_contents('php://input'), true);
    $receita['id'] = $id;
    $id++;
    array_push($receitas, $receita);
    echo json_encode($receitas);
} else if (str_contains($metodo, 'GET')) {
    $indice = array_search($_GET['id'] ?? null, array_column($receitas, 'id'));

    switch ($_GET['getParam']) {
        case '1': //1 - Get One
            if ($indice || $indice === 0) {
                echo json_encode($receitas[$indice]);
            } else {
                echo "Not Found";
            }
            break;
        case '2': //2 - Get List
            echo json_encode($receitas);
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
        echo json_encode($receitas);
    } else {
        echo "not found";
    }
} else if (str_contains($metodo, 'DELETE')) {
    $indice = array_search($_GET['id'], array_column($receitas, 'id'));
    if ($indice || $indice === 0) {
        array_splice($receitas, $indice);
        echo json_encode($receitas);
    } else {
        echo "no element to delete";
    }
}
