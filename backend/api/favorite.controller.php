<?php

use projetoweb\models\Favorite;
use projetoweb\utils\Error;

class FavoriteController
{
    protected $favoriteModel;
    public function __construct()
    {
        $this->favoriteModel = new Favorite();
    }
    public function put()
    {
        if (!isset($_GET['uid']) && !isset($_GET['rid'])) {
            Error::fireMessage(new Exception("Missing 'uid/rid' in query", 406));
            return;
        }
        try {
            $this->favoriteModel->uid = $_GET['uid'];
            $this->favoriteModel->rid = $_GET['rid'];
            echo $this->favoriteModel->favorite();
        } catch (Exception $e) {
            Error::fireMessage($e);
        }
    }

    public function get()
    {
        if (!isset($_GET['uid'])) {
            Error::fireMessage(new Exception("Missing 'uid' in query", 406));
            return;
        }
        $indice = $_GET['uid'];
        try {
            $this->favoriteModel->uid = $indice;
            echo $this->favoriteModel->getFavorites();
        } catch (Exception $e) {
            Error::fireMessage($e);
        }
    }
}
