<?php
require_once("classes/Officer.php");
session_start();
include_once("header.php");
require_once("connect.php");

$page = "Login";
$msg = "";

if (isset($_POST['btnLogin'])) {
  $username = $_POST['txtUsername'];
  $password = $_POST['txtPassword'];

  $query = "SELECT `password`,`id`,`name`,`rank`,`type`,`dob`,`gender`,`phone`,`email`,`passport`,`address`
              from `officer` WHERE `username`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("s",$username);
  $stmt->execute();
  if (!$stmt->errno) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $result = $result->fetch_assoc();
      if (password_verify($password, $result['password'])) {

        $officer = new Officer($result['name']);
        $officer->address = $result['address'];
        $officer->gender = $result['gender'];
        $officer->phone = $result['phone'];
        $officer->email = $result['email'];
        $officer->passport = $result['passport'];
        $officer->address = $result['address'];
        $officer->rank = $result['rank'];
        $officer->dob = $result['dob'];
        $officer->type = $result['type'];
        $officer->id = $result['id'];

        $_SESSION["officer"] = $officer;
        header("Location:admin.php");
        $msg = "<div class='alert alert-success alert-dismissible'>Login successful</div>";
      }else{
        $msg = "<div class='alert alert-danger alert-dismissible'>Invalid username and/or password</div>wrong password".$stmt->error;
      }
    }else{
      $msg = "<div class='alert alert-danger alert-dismissible'>Invalid username and/or password</div>no record".$stmt->error;
    }
  }else{
    $msg = "<div class='alert alert-danger alert-dismissible'>Invalid username and/or password</div>error".$stmt->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
    <h2 class="text-center">Login</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtUsername">Username</label>
        <input type="text" class="form-control" id="txtUsername" name="txtUsername" required/>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtPassword">Password</label>
        <input type="password" class="form-control" id="txtPassword" name="txtPassword" required/>
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" class="form-control mx-auto btn-success" style="width:70%;" id="btnLogin" name="btnLogin" value="Login" />
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>