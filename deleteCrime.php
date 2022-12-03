<?php
require_once("connect.php");

$id = $_REQUEST['i'];

$result = $con->query("DELETE FROM `crime` WHERE `id`=$id;");
if ($result) {
  $data = ["status"=>"success"];
}else{
  $data = ["status"=>"error"];
}

echo json_encode($data);

?>