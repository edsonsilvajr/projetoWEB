<?php
// API Web Simples
$recurso = $_SERVER['REQUEST_URI'] ?? 'index';
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$controlador = ".$recurso.controller.php";

if (file_exists($controlador)) {
    require($controlador);
} else {
    echo "Erro 500: Este recurso não existe!";
}
