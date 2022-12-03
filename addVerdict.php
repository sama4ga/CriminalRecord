<?php
require_once("classes/Crime.php");
session_start();
$page = "Add Verdict";
include_once("header.php");
require_once("connect.php");

$msg = "";
// var_dump($_SESSION);

if (isset($_GET['cId'])) {
  $crimeId = $_GET['cId'];

  $result = $con->query("SELECT `statement`,`subject` FROM `crime` WHERE `id`=$crimeId;");
  if ($result) {
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $crime = new Crime($row['subject'], $row['statement']);
      $crime->id = $crimeId;
      $_SESSION['crime'] = $crime;
    }else{
      echo "<div>You cannot access this page.</div>No record";
      return;
    }
  }else{
    echo "<div>You cannot access this page.</div>".$con->error;
    return;
  }

}elseif(isset($_SESSION['crime'])){
  $crime = $_SESSION['crime'];
  $crimeId = $crime->id;
}else{
  echo "<div>You cannot access this page.</div>";
  return;
}

if (isset($_POST['btnAddVerdict'])) {
  $courtId = $_POST['cmbCourt'];
  $judge = $_POST['txtJudge'];
  $verdict = $_POST['txtVerdict'];
  $status = $_POST['cmbStatus'];
  $date = $_POST['dtpDate'];

  $stmt = $con->prepare("INSERT INTO `verdict`(`courtId`,`crimeId`,`judge`,`verdict`,`status`,`date`) VALUES(?,?,?,?,?,?);");
  $stmt->bind_param("iissss",$courtId,$crimeId,$judge,$verdict,$status,$date);
  $stmt->execute();
  if (!$stmt->errno) {
    echo "<div class='alert alert-success alert-dismissible'>Verdict successfully added</div>";
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while adding verdict</div>".$stmt->error;
  }


}

?>


<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Add Verdict</h2>
    
    <div class="mt-4 mb-3">
      <fieldset>
        <legend>Crime Description</legend>
        <h5>
          <?php echo $crime->subject; ?>
        </h5>
        <div class="text-muted text-sm">
          <?php echo $crime->statement; ?>
        </div>
      </fieldset>
    </div>

    <div>
      <?php echo $msg; ?>
    </div>

    <div class="card-body">
      <div class="form-group">
        <label for="cmbCourt">Court</label>
        <select class="form-control" name="cmbCourt" id="cmbCourt" required></select>
      </div>
      <div class="form-group">
        <label for="txtJudge">Judge</label>
        <input class="form-control" type="text" name="txtJudge" id="txtJudge" required />
      </div>
      <div class="form-group">
        <label for="txtVerdict">Verdict</label>
        <textarea class="form-control" name="txtVerdict" id="txtVerdict" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <label for="cmbStatus">Status</label>
        <select class="form-control" name="cmbStatus" id="cmbStatus" required>
          <option value="0" disabled>Select status</option>
          <option value="Hearing">Hearing</option>
          <option value="Decided" selected>Decided</option>
        </select>
      </div>
      <div class="form-group">
        <label for="dtpDate">Date</label>
        <input type="date" class="form-control" name="dtpDate" id="dtpDate" required value="<?php echo date("Y-m-d"); ?>"/>
      </div>
    </div>
    <div class="card-footer">
      <input class="form-control btn btn-success" type="submit" value="Add Verdict" name="btnAddVerdict" id="btnAddVerdict" />
    </div>
    <!-- <div>
      <a class="btn btn-md btn-secondary float-right" href="<?php echo $_SESSION['back']; ?>">Back</a>
    </div> -->
  </form>
</div>

<?php
include_once("footer.php");
?>

<script>
  $(document).ready(function() {
      $.post("getCourt.php", (data,status,xhr) => {
        if (status == "success") {
          $("#cmbCourt").html(data);
        }
      })
  })
</script>

