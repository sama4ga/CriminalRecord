<?php
require_once("connect.php");

$id = $_REQUEST['id'];

$result = $con->query("DELETE FROM `suspect` WHERE `id`=$id;");
if ($result) {
  $data = array("status"=>"success");
}else{
  $data = array("status"=>"error");
}

echo json_encode($data);

?>