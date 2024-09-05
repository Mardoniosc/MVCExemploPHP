<?php

namespace App\Model;

class Task extends Bean
{

  public $title;
  public $description;

  public function __construct($id = NULL, $title = NULL, $description = NULL)
  {
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
  }
}
