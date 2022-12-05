<?php
$page = "Add Court";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnAddCourt'])) {
  $type = $_POST['cmbType'];
  $name = $_POST['txtName'];
  $address = $_POST['txtAddress'];

  if ($type == null) {
    $msg = "<div class='alert alert-danger alert-dismissible'>Select court type to proceed</div>";
  }else{
    
    $query = "INSERT INTO `court` (`name`,`address`,`type`) VALUES(?,?,?);";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss",$name,$address,$type);
    $stmt->execute();
    if (!$stmt->errno) {
      $msg = "<div class='alert alert-success alert-dismissible'>Court successfully added</div>";
    }else{
      $msg = "<div class='alert alert-danger alert-dismissible'>Error occured while adding court</div>".$stmt->error;
    }

  }
  
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
    <h2 class="text-center">Add Court</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" required />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbType">Type</label>
        <select id="cmbType" name="cmbType" class="form-control" required>
          <option value="0" disabled>Select Court Type</option>
          <option value="Supreme Court">Supreme Court</option>
          <option value="Judiciary Court">Judiciary Court</option>
          <option value="Appeal Court">Appeal Court</option>
          <option value="Magistrate Court">Magistrate Court</option>
          <option value="Federal High Court">Federal High Court</option>
          <option value="State High Court">State High Court</option>
          <option value="Customary Court">Customary Court</option>
          <option value="National Industrial Court">National Industrial Court</option>
          <option value="Sharia Court of Appeal">Sharia Court of Appeal</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10" required></textarea>
      </div>
    </div>
    <div class="card-footer d-flex">
      <input type="submit" class="form-control mx-auto btn-success" id="btnAddCourt" name="btnAddCourt" value="Add Court" />
      <a href="javascript:history.back();" class="btn btn-warning btn-md form-control ml-2">Back</a>
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>
