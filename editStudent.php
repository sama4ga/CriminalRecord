<?php
$page = "Edit Student";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnEditStudent'])) {
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
  $id = $_POST['txtStudentId'];
  $oldPassport = $_POST['txtPassport'];
  $passport = $_FILES['picPassport'];

  if ($passport['name'] == "" && $passport['size'] == 0 && $passport['tmp_name'] == "") {
    $passportFile = $oldPassport;
  }else{
    if (!file_exists("passports/students")) {
      mkdir("passports/students");
    }
    $passportFile = "passports/students/student_".$id.".jpeg";
    move_uploaded_file($passport['tmp_name'], $passportFile);
  }
  
  $query = "UPDATE `student` SET `department`=?,`faculty`=?,`name`=?,`regNo`=?,`pg`=?,`dob`=?,`gender`=?,`phone`=?,`email`=?,`passport`=?,`address`=?,`level`=? WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ssssssssssssi",$department,$faculty,$name,$regNo,$pg,$dob,$gender,$phone,$email,$passportFile,$address,$level,$id);
  $stmt->execute();
  if (!$stmt->errno) {    
    $msg = "<div class='alert alert-success alert-dismissible'>Update successful</div>";
  }else{
    $msg = "<div class='alert alert-danger alert-dismissible'>Error occured while updating student record</div>".$stmt->error;
  }

  exit();
}

if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $query = "SELECT `department`,`faculty`,`name`,`regNo`,`pg`,`dob`,`gender`,`phone`,`email`,`passport`,`address`,`level` FROM `student` WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("i",$id);
  $stmt->execute();
  if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $student = $result->fetch_assoc();
    }else{
      echo "<div class='alert alert-info alert-dismissible'>No student found</div>";
    }
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occurred while fetching student data</div>".$con->error;
  }

}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Edit Student Record</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo $student['name']; ?>" required/>
        <input type="hidden" id="txtStudentId" name="txtStudentId" value="<?php echo $id; ?>"/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtRegNo">Reg. No.</label>
        <input type="text" class="form-control" id="txtRegNo" name="txtRegNo" value="<?php echo $student['regNo']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPhone">Phone Number</label>
        <input type="tel" class="form-control" id="txtPhone" name="txtPhone" value="<?php echo $student['phone']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" name="txtEmail" value="<?php echo $student['email']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="dtpDOB">Date of Birth</label>
        <input type="date" class="form-control" id="dtpDOB" name="dtpDOB" value="<?php echo $student['dob']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbGender">Gender</label>
        <select id="cmbGender" name="cmbGender" class="form-control" required>
          <option value="0" selected>Select gender</option>
          <option value="Male" <?php echo $student['gender'] == "Male" ? "selected" : ""; ?>>Male</option>
          <option value="Female" <?php echo $student['gender'] == "Female" ? "selected" : ""; ?>>Female</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbLevel">Level</label>
        <select id="cmbLevel" name="cmbLevel" class="form-control" required>
          <option value="0">Select Level</option>
          <option value="100" <?php echo $student['level'] == "100" ? "selected" : ""; ?>>100</option>
          <option value="200" <?php echo $student['level'] == "200" ? "selected" : ""; ?>>200</option>
          <option value="300" <?php echo $student['level'] == "300" ? "selected" : ""; ?>>300</option>
          <option value="400" <?php echo $student['level'] == "400" ? "selected" : ""; ?>>400</option>
          <option value="500" <?php echo $student['level'] == "500" ? "selected" : ""; ?>>500</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10" required><?php echo $student['address']; ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="picPassport">Passport</label>
        <div class="d-flex">
          <input type="file" class="form-control" id="picPassport" name="picPassport" />
          <input type="hidden" id="txtPassport" name="txtPassport" value="<?php echo $student['passport']; ?>" />
          <img src="<?php echo $student['passport']; ?>" width="50" height="50" class="ml-2"/>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtFaculty">Faculty</label>
        <input type="text" class="form-control" id="txtFaculty" name="txtFaculty" value="<?php echo $student['faculty']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtDepartment">Department</label>
        <input type="text" class="form-control" id="txtDepartment" name="txtDepartment" value="<?php echo $student['department']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPG">Parent/Guardian</label>
        <input type="text" class="form-control" id="txtPG" name="txtPG" value="<?php echo $student['pg']; ?>" />
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" class="form-control mx-auto btn-success" style="width:70%;" id="btnEditStudent" name="btnEditStudent" value="Update" />
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>