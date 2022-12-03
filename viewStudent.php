<?php
$page = "View Student";
include_once("header.php");
require_once("connect.php");

$id = $_REQUEST['id'];

$result = $con->query("SELECT `department`,`faculty`,`name`,`regNo`,`pg`,`dob`,`gender`,`phone`,`email`,`passport`,`address`,`level` FROM `student` WHERE `id`=$id;");
if ($result) {
  if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo "
          <h1 class='my-4'>Student Data</h1>
          <div class='row mb-5'>
            <div class='col-6'>
              <div class='row'>
                <div class='col-3'>Name</div>
                <div class='col-9'>".$student['name']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Gender</div>
                <div class='col-9'>".$student['gender']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Date of birth</div>
                <div class='col-9'>".$student['dob']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Phone</div>
                <div class='col-9'>".$student['phone']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Email</div>
                <div class='col-9'>".$student['email']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Address</div>
                <div class='col-9'>".$student['address']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Parent/Guardian</div>
                <div class='col-9'>".$student['pg']."</div>
              </div>
            </div>
            <div class='col-6'>
              <div>
                <img src='".$student['passport']."' width='100' height='100' />
              <div>
              <div class='row'>
                <div class='col-3'>Reg. No.</div>
                <div class='col-9'>".$student['regNo']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Faculty</div>
                <div class='col-9'>".$student['faculty']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Department</div>
                <div class='col-9'>".$student['department']."</div>
              </div>
              <div class='row'>
                <div class='col-3'>Level</div>
                <div class='col-9'>".$student['level']."</div>
              </div>
            </div>
          </div>
         ";

  }else{
    echo "<div class='alert alert-info alert-dismissible'>No student found</div>".$stmt->error;
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching student info</div>".$stmt->error;
}

include_once("footer.php");
?>