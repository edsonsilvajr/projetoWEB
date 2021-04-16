<?php

require("vendor/autoload.php");

//Configurando o CORS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");

use Pecee\SimpleRouter\SimpleRouter as Router;

//ENDPOINTS DE USER
Router::get('/api/user', 'UserController@get');
Router::post('/api/user', 'UserController@post');
Router::put('/api/user', 'UserController@put');
Router::delete('/api/user', 'UserController@delete');

//ENDPOINTS DE RECEITAS
Router::get('/api/recipe', 'RecipeController@get');
Router::post('/api/recipe', 'RecipeController@post');
Router::put('/api/recipe', 'RecipeController@put');
Router::delete('/api/recipe', 'RecipeController@delete');

//ENDPOINT AUTENTICAÇÃO
Router::post('/api/auth', 'AuthController@post');

//ENDPOINTS DE FAVORITOS
Router::get('/api/favorite', 'FavoriteController@get');
Router::put('/api/favorite', 'FavoriteController@put');


Router::start();
