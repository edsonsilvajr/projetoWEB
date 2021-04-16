<?php

use projetoweb\models\Favorite;

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
            http_response_code(400);
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'uid/rid' in query"
            ];
            echo json_encode($message);
            return;
        }
        try {
            $this->favoriteModel->uid = $_GET['uid'];
            $this->favoriteModel->rid = $_GET['rid'];
            echo $this->favoriteModel->favorite();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function get()
    {
        if (!isset($_GET['uid'])) {
            http_response_code(400);
            $message = [
                "data" => [],
                "status" => "Missing parameters in query",
                "errors" => "Missing 'uid' in query"
            ];
            echo json_encode($message);
            return;
        }
        $indice = $_GET['uid'];
        try {
            $this->favoriteModel->uid = $indice;
            echo $this->favoriteModel->getFavorites();
        } catch (Exception $e) {
            $this->errorMessage($e);
        }
    }

    public function errorMessage(Exception $e)
    {
        switch ($e->getCode()) {
            case 1:
                $message = [
                    "data" => [],
                    "status" => "Not Found",
                    "errors" => $e->getMessage()
                ];
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode($message);
                break;

            case 3:
                $message = [
                    "data" => [],
                    "status" => "invalid",
                    "errors" => "Incorrect Password"
                ];
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode($message);
                break;

            default:
                http_response_code(400);
                throw $e;
                break;
        }
    }
}
