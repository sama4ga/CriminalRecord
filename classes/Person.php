<?php
class Person  
{
  public $id;
  public $name;
  public $dob;
  public $gender;
  public $phone;
  public $email;
  public $passport;
  public $address;

  /**
   * Constructor for the Person class
   */
  public function __construct($id, $name, $gender, $address, $phone, $email, $passport, $dob)
  {
    $this->id = $id;
    $this->name = $name;
    $this->gender = $gender;
    $this->phone = $phone;
    $this->address = $address;
    $this->passport = $passport;
    $this->email = $email;
    $this->dob = $dob;
  }
}

?>