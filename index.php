<?php
require_once("classes/Officer.php");
session_start();
$page = "Home";

if (isset($_SESSION['officer'])) {
  header("Location: admin.php");
}else{
  header("Location: login.php");
}

?>