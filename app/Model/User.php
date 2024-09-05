<?php

namespace App\Model;

class User extends Bean
{

  public $username;
  public $password;

  public function __construct($id = NULL, $username = NULL, $password = NULL)
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
  }
}
