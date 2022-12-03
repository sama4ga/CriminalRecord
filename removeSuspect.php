<?php
require_once("connect.php");

$id = $_REQUEST['id'];

$result = $con->query("DELETE FROM `suspect` WHERE `id`=$id;");
if ($result) {
  $data = ["status"=>"success"];
}else{
  $data = ["status"=>"error"];
}

?>