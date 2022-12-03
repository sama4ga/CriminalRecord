<?php
require_once("classes/Crime.php");
session_start();
$page = "Add Crime";
include_once("header.php");
require_once("connect.php");

$msg = "";

if (isset($_POST['btnAddCrime'])) {
  $officerId = $_SESSION['officer']->id;
  $statement = $_POST['txtStatement'];
  $scene = $_POST['txtScene'];
  $priority = $_POST['cmbPriority'];
  $category = $_POST['cmbCategory'];
  $subject = $_POST['txtSubject'];
  
  $query = "INSERT INTO `crime` (`statement`,`subject`,`priority`,`category`,`scene`,`officerId`) VALUES(?,?,?,?,?,?);";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ssssss",$statement,$subject,$priority,$category,$scene,$officerId);
  $stmt->execute();
  if (!$stmt->errno) {

    $crime = new Crime($subject, $statement);
    $crime->id = $stmt->insert_id;
    $crime->scene = $scene;
    $crime->setCategory($category);
    $crime->setPriority($priority);
    $crime->setStatus("New");

    $_SESSION['crime'] = $crime;
    $_SESSION['back'] = "addCrime.php";
    header("Location:addSuspect.php");
    $msg = "<div class='alert alert-success alert-dismissible'>Crime successfully logged</div>";
  }else{
    $msg = "<div class='alert alert-danger alert-dismissible'>Error occured while logging crime</div>".$stmt->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Add Crime</h2>
    <div>
      <?php echo $msg; ?>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label" for="txtSubject">Subject</label>
        <input type="text" class="form-control" id="txtSubject" name="txtSubject" required />
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbPriority">Priority</label>
        <select id="cmbPriority" name="cmbPriority" class="form-control" required>
          <option value="0" disabled>Select Priority</option>
          <option value="Low" selected>Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="cmbCategory">Category</label>
        <select id="cmbCategory" name="cmbCategory" class="form-control" required>
          <option value="0" disabled selected>Select Category</option>
          <option value="Theft">Theft</option>
          <option value="Murder">Murder</option>
          <option value="Vandalism">Vandalism</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtStatement">Statement</label>
        <textarea class="form-control" id="txtStatement" name="txtStatement" rows="5" cols="10" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="txtScene">Scene</label>
        <textarea class="form-control" id="txtScene" name="txtScene" rows="2" cols="10" required></textarea>
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" class="form-control mx-auto btn-success" style="width:70%;" id="btnAddCrime" name="btnAddCrime" value="Add Crime" />
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>