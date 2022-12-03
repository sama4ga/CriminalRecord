<?php

require_once("Court.php");

class Verdict
{
  public $id;
  private $court;
  private $crime;
  public $date;
  public $judge;
  public $verdict;
  public $status;

  /**
   * The court that gives the verdict
   * @param Court $court
   */
  function setCourt(Court $court): void
  {
    $this->court = $court;
  }
  function getCourt(): Court
  {
    return $this->court;
  }

  /**
   * Crime The crime for which the verdict is given
   */
  function setCrime(Crime $crime): void
  {
    $this->crime = $crime;
  }
  function getCrime(): Crime
  {
    return $this->crime;
  }
}



?>