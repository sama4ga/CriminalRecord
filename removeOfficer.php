<?php
$page = "Change Officer";
include_once("header.php");
require_once("connect.php");

if (isset($_REQUEST['oId']) && isset($_REQUEST['cId'])) {
  $OfficerId = $_REQUEST['oId'];
  $crimeId = $_REQUEST['cId'];
  
  $stmt = $con->prepare("SELECT `id`,`name`,`rank`,`type` FROM `officer` WHERE `id` != ?;"); 
  $stmt->bind_param("i",$OfficerId);
  $stmt->execute();
  if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      echo "
            <div class='card my-5 pt-5 pb-3 mx-auto' style='width:400px;'>
              <h1 class='text-center'>Change officer</h1>
              <form method='POST' class='card-body' action='".htmlentities($_SERVER['PHP_SELF'])."'>
                <div class='mb-5'>
                  <label for='cmbOfficer'>Choose officer</label>
                  <select class='form-control' name='cmbOfficer' id='cmbOfficer'>
                    <option value='0' disabled>select officer</option>
      ";
      while ($officer = $result->fetch_assoc()) {
        echo "<option value='".$officer['id']."'>".$officer['name']."</option>";
      }
      
      echo "
                  </select>
                  </div>
                  <div class='card-footer d-flex'>
                    <input type='submit' name='btnChange' id='btnChange' value='Change' class='btn btn-success btn-md form-control' />
                    <input type='hidden' name='txtCrimeId' value='".$crimeId."' />
                    <a href='viewCrimes.php' class='btn btn-warning btn-md form-control ml-2'>Back</a>
                  </div>
                </form>
              </div>
          ";
    }else{
      echo "<div class='alert alert-info alert-dismissible'>No officer found</div>";
    }
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error fetching officers</div>".$con->error;
  }
  
}


if (isset($_POST['btnChange'])) {
  $OfficerId = $_POST['cmbOfficer'];
  $crimeId = $_POST['txtCrimeId'];

  $stmt = $con->prepare("UPDATE `crime` SET `officerId`=? WHERE `id`=?;");
  $stmt->bind_param("ii",$OfficerId,$crimeId);
  $stmt->execute();
  if ($stmt) {
    echo "<div class='alert alert-success alert-dismissible mt-5'>Officer successfully changed</div>";
  }else{
    echo "<div class='alert alert-danger alert-dismissible mt-5'>Error encounted while changing officer</div>".$con->error;
  }
   
  echo "<a href='viewCrimes.php' class='mb-5'>Go back...</a>";
}

include_once("footer.php");
?>