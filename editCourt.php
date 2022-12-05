<?php
$page = "Edit Court";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnEditCourt'])) {
  $type = $_POST['cmbType'];
  $name = $_POST['txtName'];
  $address = $_POST['txtAddress'];
  $id = $_POST['txtCourtId'];

  
  $query = "UPDATE `court` SET `name`=?,`address`=?,`type`=? WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("sssi",$name,$address,$type,$id);
  $stmt->execute();
  if ($stmt) {
    echo "<div class='alert alert-success alert-dismissible'>Court successfully updated</div>";
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while updating court".$con->error;
  }

  echo "<a href='javascript:history.back();history.back();' class='my-4'>Back...</a>";
  exit();

}

if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $query = "SELECT `name`,`address`,`type` FROM `court` WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("i",$id);
  $stmt->execute();
  if (!$stmt->errno) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $court = $result->fetch_assoc();
    }else{
      echo "<div class='alert alert-info alert-dismissible'>No court found</div>";
    }
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while getting court details</div>".$stmt->error;
  }
}


?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
    <h2 class="text-center">Edit Court</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" name="txtName" value="<?php echo $court['name'];  ?>" />
        <input type="hidden" name="txtCourtId" value="<?php echo $id;  ?>" />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbType">Type</label>
        <select id="cmbType" name="cmbType" class="form-control">
          <option value="0">Select Court Type</option>
          <option value="Supreme Court" <?php echo $court['type'] == "Supreme Court" ? "selected" : ""; ?>>Supreme Court</option>
          <option value="Judiciary Court" <?php echo $court['type'] == "Judiciary Court" ? "selected" : ""; ?>>Judiciary Court</option>
          <option value="Appeal Court" <?php echo $court['type'] == "Appeal Court" ? "selected" : ""; ?>>Appeal Court</option>
          <option value="Magistrate Court" <?php echo $court['type'] == "Magistrate Court" ? "selected" : ""; ?>>Magistrate Court</option>
          <option value="Federal High Court" <?php echo $court['type'] == "Federal High Court" ? "selected" : ""; ?>>Federal High Court</option>
          <option value="State High Court" <?php echo $court['type'] == "State High Court" ? "selected" : ""; ?>>State High Court</option>
          <option value="Customary Court" <?php echo $court['type'] == "Customary Court" ? "selected" : ""; ?>>Customary Court</option>
          <option value="National Industrial Court" <?php echo $court['type'] == "National Industrial Court" ? "selected" : ""; ?>>National Industrial Court</option>
          <option value="Sharia Court of Appeal" <?php echo $court['type'] == "Sharia Court of Appeal" ? "selected" : ""; ?>>Sharia Court of Appeal</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtAddress">Address</label>
        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="2" cols="10"><?php echo $court['address'];  ?></textarea>
      </div>
    </div>
    <div class="card-footer d-flex">
      <input type="submit" class="form-control mx-auto btn-success" id="btnEditCourt" name="btnEditCourt" value="Update" />
      <a href="javascript:history.back();" class="btn btn-warning btn-md form-control ml-2">Back</a>
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>