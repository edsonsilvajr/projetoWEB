<?php

require("models/auth.model.php");

$file_path = getcwd() . "/models/users.json";

$users = json_decode(file_get_contents($file_path), true);

if (str_contains($metodo, 'POST')) {
    metodoPost($users);
}

if (str_contains($metodo, 'GET')) {
    metodoGet();
}
