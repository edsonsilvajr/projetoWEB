<?php

function validateUser($user)
{
  if (!(isset($user['uid']) &&
    isset($user['name']) &&
    isset($user['type']) &&
    isset($user['gender']) &&
    isset($user['date']) &&
    isset($user['email']))) {
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
}

function validateRecipe($recipe)
{
  if (!(isset($recipe[0]['id']) &&
    isset($recipe[0]['title']) &&
    isset($recipe[0]['description']) &&
    isset($recipe[0]['ingredients']) &&
    isset($recipe[0]['preparationMode']) &&
    isset($recipe[0]['url']) &&
    isset($recipe[0]['authorid']) &&
    isset($recipe[0]['author']))) {
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
