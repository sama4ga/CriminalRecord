<?php

require_once("Enum.php");
require_once("Student.php");
require_once("Officer.php");
require_once("Person.php");
require_once("Witness.php");
require_once("Verdict.php");

class Crime
{
  public $id;
  public $statement;
  private $suspects = []; // accused
  private $victims = [];
  private $witnesses = [];
  private $officer;
  private $verdicts = [];
  public $date;
  public $evidences = [];
  public $scene;  // scene
  private $category;
  private $status;
  public $subject;
  private $priority;
  public $type; // caution, reprimands, warnings, convictions, offence

  /**
   * Constructor for the Crime class
   */
  public function __construct(string $subject, string $statement)
  {
    $this->statement = $statement;
    $this->subject = $subject;
  }

  /**
   * Adds suspect to the list of suspects for the crime
   * @param Student $suspect A suspect is a student that may be responsible for the crime
   */
  function addSuspect(Student $suspect): void
  {
    array_push($this->suspects, $suspect);
  }
  function getSuspects(): array
  {
    return $this->suspects;
  }

  /**
   * A witness is one that testifies to the crime
   */
  function addWitness(Witness $witness): void
  {
    array_push($this->witnesses, $witness);
  }
  function getWitnesses(): array
  {
    return $this->witnesses;
  }

  /**
   * Adds a victim to the list of victims affected by the crime
   * @param Witness $victim A victim is a witness that is affected by the crime.
   */
  function addVictim(Witness $victim): void
  {
    array_push($this->victims, $victim);
  }
  function getVictims(): array
  {
    return $this->victims;
  }

  /**
   * A verdict is judgement passed by a judge in a court concerning the crime.
   */
  function addVerdict(Verdict $verdict): void
  {
    array_push($this->verdicts, $verdict);
  }
  function getVerdicts(): array
  {
    return $this->verdicts;
  }

  /**
   * A officer is the a person in the criminal department handling the crime
   */
  function setOfficer(Officer $officer): void
  {
    $this->officer = $officer;
  }
  function getOfficer(): Officer
  {
    return $this->officer;
  }

  /**
   * The category of the crime
   */
  function setCategory(string $category): void
  {
    $this->category = $category;
  }
  function getCategory(): string
  {
    return $this->category;
  }

  /**
   * The status of the crime
   */
  function setStatus(string $status): void
  {
    $this->status = $status;
  }
  function getStatus(): string
  {
    return $this->status;
  }

  /**
   * The priority of the crime
   */
  function setPriority(string $priority): void
  {
    $this->priority = $priority;
  }
  function getPriority(): string
  {
    return $this->priority;
  }



}

?>