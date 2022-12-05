<?php
require_once("connect.php");

if (isset($_REQUEST['id'])) {

  $id = $_REQUEST['id'];

  $stmt = $con->prepare("SELECT `id`,`name`,`address`,`type` FROM `court` WHERE `id`=?;");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $court = $result->fetch_assoc();
      echo "<div class='my-5'>
              <h1 class='text-center mb-3'>Court details</h1>
              <div class='row'>
                <div class='col-4'>Name</div>
                <div class='col-8'>".$court['name']."</div>
              </div>
              <div class='row'>
                <div class='col-4'>Type</div>
                <div class='col-8'>".$court['type']."</div>
              </div>
              <div class='row'>
                <div class='col-4'>Address</div>
                <div class='col-8'>".$court['address']."</div>
              </div>
            </div>
      ";
  
    }else{
      echo "<div class='alert alert-info alert-dismissible'>No court found</div>";
    }
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>An error occurred while fetching court details</div>".$con->error;
  }
  
}



?>