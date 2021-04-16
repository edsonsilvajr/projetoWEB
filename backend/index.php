<?php

require("vendor/autoload.php");

//Configurando o CORS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");

use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get('/api/user', 'UserController@get');
Router::post('/api/user', 'UserController@post');
Router::put('/api/user', 'UserController@put');
Router::delete('/api/user', 'UserController@delete');

Router::get('/api/recipe', 'RecipeController@get');
Router::post('/api/recipe', 'RecipeController@post');
Router::put('/api/recipe', 'UserController@put');
Router::delete('/api/recipe', 'RecipeController@delete');

Router::post('/api/auth', 'AuthController@post');

Router::put('/api/favorite', 'FavoriteController@put');


Router::start();
