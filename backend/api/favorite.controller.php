<?php

use projetoweb\models\Favorite;

class FavoriteController
{
    private $favoriteModel;
    public function __construct()
    {
        $this->favoriteModel = new Favorite();
    }
    public function put()
    {
        $this->favoriteModel->favorite();
    }
}
