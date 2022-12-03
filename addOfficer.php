<?php
$page = "Add Officer";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnRegister'])) {
  $username = $_POST['txtUsername'];
  $password = $_POST['txtPassword'];
  $phone = $_POST['txtPhone'];
  $email = $_POST['txtEmail'];
  $rank = $_POST['txtRank'];
  $dob = $_POST['dtpDOB'];
  $gender = $_POST['cmbGender'];
  $name = $_POST['txtName'];
  $address = $_POST['txtAddress'];
  $passport = $_FILES['picPassport'];
  $type = "User"; //SuperUser

  $hPassword = password_hash($password, PASSWORD_DEFAULT);
  
  $query = "INSERT INTO `officer` (`username`,`password`,`name`,`rank`,`type`,`dob`,`gender`,`phone`,`email`,`passport`,`address`) VALUES(?,?,?,?,?,?,?,?,?,?,?);";
  $stmt = $con->prepare($query);
  $stmt->bind_param("sssssssssss",$username,$hPassword,$name,$rank,$type,$dob,$gender,$phone,$email,$passport['name'],$address);
  $stmt->execute();
  if (!$stmt->errno) {    
    mkdir("passports/officers");
    $passportFile = "passports/officers/officer_".$stmt->insert_id.".jpeg";
    move_uploaded_file($passport['tmp_name'], $passportFile);
    $con->query("Update `officer` SET `passport`='$passportFile' WHERE `id`=$stmt->insert_id;");
    $msg = "<div class='alert alert-success alert-dismissible'>Registration successful</div>";
  }else{
    $msg = "<div class='alert alert-danger alert-dismissible'>Error occured while registering officer".$stmt->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Register Officer</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPhone">Phone Number</label>
        <input type="tel" class="form-control" id="txtPhone" name="txtPhone" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" name="txtEmail" />
      </div>
      <div class="form-group">
        <label class="form-label" for="txtRank">Rank</label>
        <input type="text" class="form-control" id="txtRank" name="txtRank" />
      </div>
      <div class="form-group">
        <label class="form-label" for="dtpDOB">Date of Birth</label>
        <input type="date" class="form-control" id="dtpDOB" name="dtpDOB" />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbGender">Gender</label>
        <select id="cmbGender" name="cmbGender" class="form-control">
          <option value="0" selected>Select gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10"></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="picPassport">Passport</label>
        <input type="file" class="form-control" id="picPassport" name="picPassport" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtUsername">Username</label>
        <input type="text" class="form-control" id="txtUsername" name="txtUsername" />
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPassword">Password</label>
        <input type="password" class="form-control" id="txtPassword" name="txtPassword" />
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" class="form-control mx-auto btn-success" style="width:70%;" id="btnRegister" name="btnRegister" value="Register" />
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>