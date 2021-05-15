<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RecipeController;

//Route::apiResource('/user', 'App\Http\Controllers\UserController');

Route::post('auth', [AuthController::class, 'login']);
//Route::post('auth/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'apiJwt'], function () {
  //recipe routes
  Route::post('recipe', [RecipeController::class, 'store']);
  Route::put('recipe', [RecipeController::class, 'update']);
  Route::delete('recipe', [RecipeController::class, 'destroy']);

  //user routes
  Route::get('user', [UserController::class, 'index']);
  Route::put('user', [UserController::class, 'update']);
  Route::delete('user', [UserController::class, 'destroy']);

  //favorite routes
  Route::get('favorite', [FavoriteController::class, 'index']);
  Route::put('favorite', [FavoriteController::class, 'update']);

  //auth routes
  Route::delete('auth', [AuthController::class, 'logout']);
});

Route::get('recipe', [RecipeController::class, 'index']);

Route::post('user', [AuthController::class, 'register']);
