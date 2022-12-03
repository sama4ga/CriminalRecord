<?php
require_once("classes/Officer.php");
session_start();
$page = "Edit Crime";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnEditCrime'])) {
  $officerId = $_SESSION['officer']->id;
  $statement = $_POST['txtStatement'];
  $scene = $_POST['txtScene'];
  $priority = $_POST['cmbPriority'];
  $category = $_POST['cmbCategory'];
  $status = $_POST['cmbStatus'];
  $subject = $_POST['txtSubject'];
  $id = $_POST['txtId'];
  
  $query = "UPDATE `crime` SET `statement`=?,`subject`=?,`priority`=?,`category`=?,`scene`=?,`status`=?,`officerId`=? WHERE `id`=?;";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ssssssii",$statement,$subject,$priority,$category,$scene,$status,$officerId,$id);
  $stmt->execute();
  if (!$stmt->errno) {

    // $crime = new Crime($subject, $statement);
    // $crime->id = $stmt->insert_id;
    // $crime->scene = $scene;
    // $crime->setCategory($category);
    // $crime->setPriority($priority);
    // $crime->setStatus("New");

    // $_SESSION['crime'] = $crime;
    // $_SESSION['back'] = "addCrime.php";
    // header("Location:addSuspect.php");
    echo "<div class='alert alert-success alert-dismissible'>Crime successfully updated</div>";
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while updating crime</div>".$stmt->error;
  }

  echo "<meta http-equiv='refresh' content='5; url=viewCrimes.php' />";

  die();
}


$id = $_REQUEST['i'];

$result = $con->query("SELECT * FROM `crime` WHERE `id`=$id;");
if ($result) {
  if ($result->num_rows == 1) {
    $crime = $result->fetch_assoc();
    $statement = $crime['statement'];
    $scene = $crime['scene'];
    $subject = $crime['subject'];
    $priority = $crime['priority'];
    $status = $crime['status'];
    $category = $crime['category'];
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No crime found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching crime details</div>".$con->error;
}



?>


<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Edit Crime</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtSubject">Subject</label>
        <input type="text" class="form-control" id="txtSubject" name="txtSubject" value="<?php echo $subject; ?>" required/>
        <input type="hidden" id="txtId" name="txtId" value="<?php echo $id; ?>" />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbPriority">Priority</label>
        <select id="cmbPriority" name="cmbPriority" class="form-control" required>
          <option value="0" disabled>Select Priority</option>
          <option value="Low" <?php echo($priority == "Low" ? "selected" : ""); ?>>Low</option>
          <option value="Medium" <?php echo($priority == "Medium" ? "selected" : ""); ?>>Medium</option>
          <option value="High" <?php echo($priority == "High" ? "selected" : ""); ?>>High</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbStatus">Status</label>
        <select id="cmbStatus" name="cmbStatus" class="form-control" required>
          <option value="0" disabled>Select Status</option>
          <option value="New" <?php echo($status == "New" ? "selected" : ""); ?>>New</option>
          <option value="Settled" <?php echo($status == "Settled" ? "selected" : ""); ?>>Settled</option>
          <option value="Pending" <?php echo($status == "Pending" ? "selected" : ""); ?>>Pending</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbCategory">Category</label>
        <select id="cmbCategory" name="cmbCategory" class="form-control" required>
          <option value="0" disabled>Select Category</option>
          <option value="Theft" <?php echo($category == "Theft" ? "selected" : ""); ?>>Theft</option>
          <option value="Murder" <?php echo($category == "Murder" ? "selected" : ""); ?>>Murder</option>
          <option value="Vandalism" <?php echo($category == "Vandalism" ? "selected" : ""); ?>>Vandalism</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtStatement">Statement</label>
        <textarea class="form-control" id="txtStatement" name="txtStatement" rows="5" cols="10" required><?php echo $statement; ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtScene">Scene</label>
        <textarea class="form-control" id="txtScene" name="txtScene" rows="2" cols="10" required><?php echo $scene; ?></textarea>
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" class="form-control mx-auto btn-success" style="width:70%;" id="btnEditCrime" name="btnEditCrime" value="Update" />
    </div>
  </form>
</div>



<?php
include_once("footer.php");
?>
