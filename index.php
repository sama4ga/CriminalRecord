<?php
$page = "Home";
include_once("header.php");
// Criminal record database for Michael Okpara University
// require_once("Student.php");
// require_once("Officer.php");
require_once("classes/Crime.php");
require_once("classes/Enum.php");
require_once("connect.php");

$maurice = new Student("Maurice","12/EG/PE/462","Petroleum Engineering", "Engineering",100);
$okon = new Officer("Okon");
$stealing = new Crime("Stealing", "Stole money from okon");
$stealing->setCategory(Category::THEFT);
$stealing->setStatus(Status::NEW);
$stealing->setPriority(Priority::HIGH);

$stealing->addSuspect($maurice);
$stealing->setOfficer($okon);

var_dump($stealing);

include_once("footer.php");
?>