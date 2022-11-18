<?php

require_once("Enum.php");

class Court
{
  public $id;
  public $name;
  public $address;
  private $type;

  /**
   * The type of the court
   * @param CourtType $type
   */
  function setType(CourtType $type): void
  {
    $this->type = $type;
  }
  function getCourtType(): CourtType
  {
    return $this->type;
  }
}



?>