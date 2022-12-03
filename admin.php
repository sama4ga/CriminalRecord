<?php
require_once("classes/Officer.php");
session_start();
$page = "Admin";
include_once("header.php");


// var_dump($_SESSION);

if (isset($_SESSION['officer'])) {
  $officer = $_SESSION['officer'];

  // if ($officer->type != "Admin") {
  //   http_response_code(401);
  //   include_once("errors/401.php");
  //   die();
  // }
}else{
  http_response_code(403);
  include_once("errors/403.php");
  die();
}
?>

<div class="my-4">
  <h1 class="text-center ">Admin Portal</h1>
  <div></div>
  <div class="row mb-3">
    <div class="col-6 card p-3">
      <h3>Manage Crimes</h3>
      <a href="viewCrimes.php" class="btn btn-sm btn-secondary"><i class="fa fa-address-book" aria-hidden="true"></i> View Crimes</a>
      <a href="addCrime.php" class="btn btn-sm btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Crimes</a>
    </div>
    <div class="col-6 card p-3">
      <h3>Manage Students</h3>
      <a href="viewStudents.php" class="btn btn-sm btn-secondary"><i class="fa fa-address-card" aria-hidden="true"></i> View Student</a>
      <a href="addStudent.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Student</a>
    </div>
  </div>
  <div class="row">
    <div class="col-6 card p-3">
      <h3>Manage Courts</h3>
      <a href="viewCourts.php" class="btn btn-sm btn-secondary"><i class="fa fa-address-card" aria-hidden="true"></i> View Courts</a>
      <a href="addCourt.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Court</a>
    </div>
    <div class="col-6 card p-3">
      <h3>Manage Officers</h3>
      <a href="viewOfficers.php" class="btn btn-sm btn-secondary"><i class="fa fa-address-book" aria-hidden="true"></i> View Officers</a>
      <a href="addOfficer.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Officer</a>
    </div>
  </div>
</div>



<?php
include_once("footer.php");
?>