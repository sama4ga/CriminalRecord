<?php
$page = "Add Student";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnRegister'])) {
  $department = $_POST['txtDepartment'];
  $faculty = $_POST['txtFaculty'];
  $level = $_POST['cmbLevel'];
  $pg = $_POST['txtPG'];
  $phone = $_POST['txtPhone'];
  $email = $_POST['txtEmail'];
  $regNo = $_POST['txtRegNo'];
  $dob = $_POST['dtpDOB'];
  $gender = $_POST['cmbGender'];
  $name = $_POST['txtName'];
  $address = $_POST['txtAddress'];
  $passport = $_FILES['picPassport'];
  
  $query = "INSERT INTO `student` (`department`,`faculty`,`name`,`regNo`,`pg`,`dob`,`gender`,`phone`,`email`,`passport`,`address`,`level`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ssssssssssss",$department,$faculty,$name,$regNo,$pg,$dob,$gender,$phone,$email,$passport['name'],$address,$level);
  $stmt->execute();
  if ($stmt) {
    if (!file_exists("passports/students")) {
      mkdir("passports/students", true);
    }
    $passportFile = "passports/students/student_".$stmt->insert_id.".jpeg";
    move_uploaded_file($passport['tmp_name'], $passportFile);
    $con->query("Update `student` SET `passport`='$passportFile' WHERE `id`=$stmt->insert_id;");
    $msg = "<div class='alert alert-success alert-dismissible'>Registration successful</div>";
  }else{
    $msg = "<div class='alert alert-danger alert-dismissible'>Error occured while registering student</div>".$con->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Register Student</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtRegNo">Reg. No.</label>
        <input type="text" class="form-control" id="txtRegNo" name="txtRegNo" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPhone">Phone Number</label>
        <input type="tel" class="form-control" id="txtPhone" name="txtPhone" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="dtpDOB">Date of Birth</label>
        <input type="date" class="form-control" id="dtpDOB" name="dtpDOB" value="<?php echo date("Y-m-d"); ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbGender">Gender</label>
        <select id="cmbGender" name="cmbGender" class="form-control" required>
          <option value="0" disabled>Select gender</option>
          <option value="Male" selected>Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbLevel">Level</label>
        <select id="cmbLevel" name="cmbLevel" class="form-control" required>
          <option value="0" disabled>Select Level</option>
          <option value="100" selected>100</option>
          <option value="200">200</option>
          <option value="300">300</option>
          <option value="400">400</option>
          <option value="500">500</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="picPassport">Passport</label>
        <input type="file" class="form-control" id="picPassport" name="picPassport" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtFaculty">Faculty</label>
        <input type="text" class="form-control" id="txtFaculty" name="txtFaculty" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtDepartment">Department</label>
        <input type="text" class="form-control" id="txtDepartment" name="txtDepartment" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPG">Parent/Guardian</label>
        <input type="text" class="form-control" id="txtPG" name="txtPG" />
      </div>
    </div>
    <div class="card-footer d-flex">
      <input type="submit" class="form-control mx-auto btn-success" id="btnRegister" name="btnRegister" value="Register" />
      <a href="javascript:history.back();" class="btn btn-warning btn-md form-control ml-2">Back</a>
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>