<?php

require_once("Person.php");

class Officer extends Person
{
  public $rank;
  public $type;

  /**
   * Constructor for the Officer class
   */
  public function __construct($name)
  {
    $this->name = $name;
  }
}

?>