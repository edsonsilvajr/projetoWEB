<?php
// API Web Simples
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$recurso = $_SERVER['REQUEST_URI'] ?? 'index';
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$recurso = explode('?', $recurso);
$url = $recurso[0];
$query = $recurso[1] ?? null;

$controlador = ".$url.controller.php";

if (file_exists($controlador)) {
    require($controlador);
} else {
    echo "Erro 500: Este recurso não existe!";
}
