<?php
require_once("connect.php");

$id = $_REQUEST['id'];

$result = $con->query("DELETE FROM `officer` WHERE `id`=$id;");
if ($result) {
  $data = array("status"=>"success");
}else{
  $data = array("status"=>"error");
}

echo json_encode($data);

?>