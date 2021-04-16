<?php

namespace projetoweb\utils;

use Exception;

class Validator
{
  public static function validate($type, $toBeValidated)
  {
    if ($type == 'user') {
      if (!(isset($toBeValidated['name']) &&
        isset($toBeValidated['type']) &&
        isset($toBeValidated['gender']) &&
        isset($toBeValidated['date']) &&
        isset($toBeValidated['email']))) {
        Error::fireMessage(new Exception('Missing Parameters in request payload', 406));
        return false;
      }
      return true;
    } else {
      if (!(isset($toBeValidated['title']) &&
        isset($toBeValidated['description']) &&
        isset($toBeValidated['ingredients']) &&
        isset($toBeValidated['preparationMode']) &&
        isset($toBeValidated['url']) &&
        isset($toBeValidated['authorid']) &&
        isset($toBeValidated['author']))) {
        Error::fireMessage(new Exception('Missing Parameters in request payload', 406));
        return false;
      } else {
        return true;
      }
    }
  }
}

class Error
{
  public static function fireMessage(Exception $e = NULL)
  {
    $message = [
      "data" => [],
      "status" => $e->getCode(),
      "errors" => $e->getMessage(),
    ];
    http_response_code($e->getCode());
    header('Content-Type: application/json');
    echo json_encode($message);
  }
}
