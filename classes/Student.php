<?php

require_once("Person.php");

class Student extends Person
{
  public $regNo;
  public $department;
  public $faculty;
  public $level;
  public $parentGuardian;

  /**
   * Constructor for the Student class
   */
  public function __construct($regNo, $department, $faculty, $level, $parentGuardian)
  {
    $this->regNo = $regNo;
    $this->department = $department;
    $this->faculty = $faculty;
    $this->level = $level;
    $this->parentGuardian = $parentGuardian;
  }
}

?>