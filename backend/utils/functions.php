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
  if (!(isset($recipe['title']) &&
    isset($recipe['description']) &&
    isset($recipe['ingredients']) &&
    isset($recipe['preparationMode']) &&
    isset($recipe['url']) &&
    isset($recipe['authorid']) &&
    isset($recipe['author']))) {
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
