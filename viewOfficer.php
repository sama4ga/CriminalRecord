<?php
$page = "View Officer";
include_once("header.php");
require_once("connect.php");

$id = $_REQUEST['id'];

$stmt = $con->prepare("SELECT `name`,`type`,`dob`,`gender`,`phone`,`email`,`passport`,`address`,`rank` FROM `officer` WHERE `id`=?;");
$stmt->bind_param("i",$id);
$stmt->execute();
if ($stmt) {
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $officer = $result->fetch_assoc();
    echo "
          <h1 class='my-4'>Officer Data</h1>
          <div class='row mb-5'>
            <div class='col-6'>
              <div class='row'>
                <div class='col-3'>Name</div>
                <div class='col-9'>".$officer['name']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Gender</div>
                <div class='col-9'>".$officer['gender']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Date of birth</div>
                <div class='col-9'>".$officer['dob']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Phone</div>
                <div class='col-9'>".$officer['phone']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Email</div>
                <div class='col-9'>".$officer['email']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Address</div>
                <div class='col-9'>".$officer['address']."</div>
              </div>
            </div>
            <div class='col-6'>
              <div>
                <img src='".$officer['passport']."' width='100' height='100' />
              <div>
              <div class='row'>
                <div class='col-3'>Rank</div>
                <div class='col-9'>".$officer['rank']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Type</div>
                <div class='col-9'>".$officer['type']."</div>
              </div>
            </div>
          </div>
         ";

  }else{
    echo "<div class='alert alert-info alert-dismissible'>No officer found</div>".$stmt->error;
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching officer info</div>".$con->error;
}

include_once("footer.php");
?>