<?php

namespace projetoweb\utils;

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
        $message = [
          "data" => [],
          "status" => "Missing Parameters",
          "errors" => "Missing Parameters in Request payload!"
        ];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($message);
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
        $message = [
          "data" => [],
          "status" => "Missing Parameters",
          "errors" => "Missing Parameters in Request payload!"
        ];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($message);
        return false;
      } else {
        return true;
      }
    }
  }
}
