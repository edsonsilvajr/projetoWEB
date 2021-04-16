<?php
require("vendor/autoload.php");

use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get('/api/user', 'UserController@get');
Router::get('/api/recipe', 'RecipeController@get');

Router::put('/api/favorite', 'FavoriteController@put');

Router::start();
