<?php

/*
 A witness cannot be a suspect
*/

require_once("classes/Crime.php");
session_start();
$page = "Add Witness";
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
}else{
  echo "<div>You cannot access this page.</div>";
  return;
}


if (isset($_POST['btnAddWitness'])) {

  if (!isset($_POST['txtWitnessId'])) {
    echo "<div class='alert alert-danger'>No witness selected</div>";
    return;
  }

  $studentId = $_POST['txtWitnessId'];  
  $statement = $_POST['txtStatement'];  
  $query = "INSERT INTO `witness` (`studentId`,`crimeId`,`statement`) VALUES(?,?,?);";
  $stmt = $con->prepare($query);
  $stmt->bind_param("iis",$studentId,$crime->id,$statement);
  $stmt->execute();
  if (!$stmt->errno) {
    // $witness->addSuspect();
    // $_SESSION['witness'] = $witness;
    // header("Location:addSuspect.php");
    echo "<div class='card mx-auto my-4 p-4' style='width:400px;'>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>Witness successfully added</div>
            <div class='btn-group'>
              <a class='btn btn-md btn-primary' href='addWitness.php'>Add another witness</a>
              <a class='btn btn-md btn-danger' href='".$_SESSION['back']."'>Cancel</a>
            </div>
          </div>";
          return;
  }else{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error occured while adding witness</div>".$stmt->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Add Witness</h2>
    
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
      <div class="d-flex">
        <input type="search" id="txtSearchText" name="txtSearchText" placeholder="Enter student name to search" class="form-control mr-2" />
        <input type="button" value="Search" id="btnSearch" name="btnSearch" class="p-1" />
      </div>
      <div id="resultDiv" class="my-4"></div>
      <input type="hidden" name="txtWitnessId" id="txtWitnessId" />
      <div class="form-group">
        <label for="txtStatement">Statement</label>
        <textarea id="txtStatement" name="txtStatement" rows="5" cols="3" class="form-control" required></textarea>
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" value="Add Witness" id="btnAddWitness" name="btnAddWitness" class="form-control btn btn-md btn-success" />
    </div>
    <div class="mt-3">
      <a class="btn btn-md btn-secondary float-right" href="<?php echo $_SESSION['back']; ?>">Back</a>
    </div>
  </form>
</div>

<?php

include_once("footer.php");
?>

<script>
  $("#btnSearch").on("click", (e) => {
    const searchText = $("#txtSearchText").val();
    $.post("fetchWitness.php", {text:searchText, cId:<?php echo $crimeId; ?>}, (data, status, xhr) => {
      if (status == "success") {
        $("#resultDiv").html(data); 
      }else{
        $("#resultDiv").html("No student found");
      }    
    });
  });

  function add(id, e) {
    $("#txtWitnessId").val(id);
    var name = e.nextElementSibling.value;      
    $("#resultDiv").html("Suspect: " + name);
  }
</script>