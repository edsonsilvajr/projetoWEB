<?php

require("vendor/autoload.php");

//Configurando o CORS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");

use Pecee\SimpleRouter\SimpleRouter as Router;

$verifyAuth = new AuthController();

if ($verifyAuth->isAuthenticated()) {
  Router::put('/api/user', 'UserController@put');
  Router::delete('/api/user', 'UserController@delete');

  Router::post('/api/recipe', 'RecipeController@post');
  Router::put('/api/recipe', 'RecipeController@put');
  Router::delete('/api/recipe', 'RecipeController@delete');

  Router::get('/api/favorite', 'FavoriteController@get');
  Router::put('/api/favorite', 'FavoriteController@put');
} else {
  Router::match(['put', 'delete'], '/api/user', function () {
    http_response_code(401);
    $message = [
      'message' => 'User not authenticated!',
      'status' => 'success',
    ];
    echo json_encode($message);
  });

  Router::match(['post', 'put', 'delete'], '/api/recipe', function () {
    http_response_code(401);
    $message = [
      'message' => 'User not authenticated!',
      'status' => 'success',
    ];
    echo json_encode($message);
  });

  Router::match(['get', 'put'], '/api/favorite', function () {
    http_response_code(401);
    $message = [
      'message' => 'User not authenticated!',
      'status' => 'success',
    ];
    echo json_encode($message);
  });
}

//ENDPOINTS DE USER
Router::get('/api/user', 'UserController@get');
Router::post('/api/user', 'UserController@post');

//ENDPOINTS DE RECEITAS
Router::get('/api/recipe', 'RecipeController@get');

//ENDPOINT AUTENTICAÇÃO
Router::post('/api/auth', 'AuthController@post');


Router::start();
