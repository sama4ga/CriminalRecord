<?php
$page = "Edit Officer";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnUpdate'])) {
  $phone = $_POST['txtPhone'];
  $email = $_POST['txtEmail'];
  $rank = $_POST['txtRank'];
  $dob = $_POST['dtpDOB'];
  $gender = $_POST['cmbGender'];
  $name = $_POST['txtName'];
  $address = $_POST['txtAddress'];
  $id = $_POST['txtOfficerId'];
  $oldPassport = $_POST['txtPassport'];
  $passport = $_FILES['picPassport'];
  $type = $_POST['cmbType']; //SuperUser, User

  if ($passport['name'] == ""  && $passport['tmp_name'] == "" && $passport['size'] == 0) {
    $passportFile = $oldPassport;
  }else{
    if (!file_exists("passports/officers")) {
      mkdir("passports/officers", true);
    }
    $passportFile = "passports/officers/officer_".$id.".jpeg";
    move_uploaded_file($passport['tmp_name'], $passportFile);
  }
    

  $query = "UPDATE `officer` SET `name`=?,`rank`=?,`type`=?,`dob`=?,`gender`=?,`phone`=?,`email`=?,`passport`=?,`address`=? WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("sssssssssi",$name,$rank,$type,$dob,$gender,$phone,$email,$passportFile,$address,$id);
  $stmt->execute();
  if ($stmt) {
    echo "<div class='alert alert-success alert-dismissible'>Officer data successfully updated</div>";
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while updating officer info</div>".$con->error;
  }

  echo "<a href='viewOfficers.php' class=''>Go back...</a>";
  exit();
}


if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $stmt = $con->prepare("SELECT `username`,`password`,`name`,`rank`,`type`,`dob`,`gender`,`phone`,`email`,`passport`,`address` FROM `officer` WHERE `id`=?;"); 
  $stmt->bind_param("i",$id);
  $stmt->execute();
  if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $officer = $result->fetch_assoc();
    }else{
      echo "<div class='alert alert-info alert-dismissible'>No officer found</div>";
      exit();      
    }
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occurred while fetching officer data</div>";
    exit();
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Edit Officer Data</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo $officer['name']; ?>" required/>
        <input type="hidden" name="txtOfficerId" value="<?php echo $id; ?>" />
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPhone">Phone Number</label>
        <input type="tel" class="form-control" id="txtPhone" name="txtPhone" value="<?php echo $officer['phone']; ?>"required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" name="txtEmail"  value="<?php echo $officer['email']; ?>"/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtRank">Rank</label>
        <input type="text" class="form-control" id="txtRank" name="txtRank" value="<?php echo $officer['rank']; ?>" />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbType">Type</label>
        <select id="cmbType" name="cmbType" class="form-control">
          <option value="0" disabled>Select type</option>
          <option value="User" <?php echo $officer['type'] == "User" ? "selected" : ""; ?>>User</option>
          <option value="Admin" <?php echo $officer['type'] == "Admin" ? "selected" : ""; ?>>Admin</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="dtpDOB">Date of Birth</label>
        <input type="date" class="form-control" id="dtpDOB" name="dtpDOB"  value="<?php echo $officer['dob']; ?>" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbGender">Gender</label>
        <select id="cmbGender" name="cmbGender" class="form-control" required>
          <option value="0" disabled>Select gender</option>
          <option value="Male" <?php echo $officer['gender'] == "Male" ? "selected" : ""; ?>>Male</option>
          <option value="Female" <?php echo $officer['gender'] == "Female" ? "selected" : ""; ?>>Female</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10" required><?php echo $officer['address']; ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="picPassport">Passport</label>
        <div class="d-flex">
          <input type="file" class="form-control" id="picPassport" name="picPassport" />
          <input type="hidden" name="txtPassport" value="<?php echo $officer['passport']; ?>" />
          <img src="<?php echo $officer['passport']; ?>" width="50" height="50" class="ml-2" alt="staff passport" />
        </div>
      </div>
    </div>
    <div class="card-footer d-flex">
      <input type="submit" class="form-control mx-auto btn-success" id="btnUpdate" name="btnUpdate" value="Update" />
      <a href="javascript:history.back();" class="btn btn-warning btn-md form-control ml-2">Back</a>
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>