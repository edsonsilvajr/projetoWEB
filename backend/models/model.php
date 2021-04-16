<?php

namespace projetoweb\models;

use projetoweb\Conexao;

class Model
{
  protected $bd;

  public function __construct()
  {
    $this->bd = Conexao::get();
  }

  public function __get($property)
  {
    return $this->$property;
  }

  public function __set($property, $value)
  {
    $this->$property = $value;
  }

  public function setByArray(array $array_properties)
  {
    foreach ($array_properties as $key => $value) {
      $this->__set($key, $value);
    }
  }
}
