<?php
require_once("connect.php");

$result = $con->query("SELECT `id`,`name`,`address`,`type` FROM `court`;");
if ($result) {
  if ($result->num_rows > 0) {
    echo "<option value='0' disabled selected>Select court</option>";
    while ($court = $result->fetch_assoc()) {
      echo "<option value='".$court['id']."'>
              ".$court['name'].", ".$court['address']."
            </option>";
    }
  }else{
    echo "<option value='0' disabled selected>Select court</option>";
  }
}else{
  echo "<option value='0' disabled selected>Select court</option>";
}


?>