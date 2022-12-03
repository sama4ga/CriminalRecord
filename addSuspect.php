<?php

/*
  A suspect cannot be a witness
*/

require_once("classes/Crime.php");
session_start();
$page = "Add Suspects";
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

if (isset($_POST['btnAddSuspect'])) {
  $studentId = $_POST['txtSuspectId'];  
  $query = "INSERT INTO `suspect` (`studentId`,`crimeId`) VALUES(?,?);";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ii",$studentId,$crime->id);
  $stmt->execute();
  if (!$stmt->errno) {
    // $crime->addSuspect();
    // $_SESSION['crime'] = $crime;
    // header("Location:addSuspect.php");
    echo "<div class='card mx-auto my-4 p-4' style='width:400px;'>
            <div class='alert alert-success alert-dismissible'>Suspect successfully added</div>
            <div class='btn-group'>
              <a class='btn btn-md btn-primary' href='addSuspect.php'>Add another suspect</a>
              <a class='btn btn-md btn-danger' href='".$_SESSION['back']."'>Cancel</a>
            </div>
          </div>";
          return;
  }else{
    echo "<div class='alert alert-danger alert-dismissible'>Error occured while adding suspect</div>".$stmt->error;
  }
}

?>

<div class="card mx-auto my-4 p-4" style="width:400px;">
  <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <h2 class="text-center">Add Suspect</h2>
    
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
      <div id="resultDiv" style="margin-top:30px;"></div>
    </div>
    <div>
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
    $.post("fetchSuspect.php", {text:searchText, cId:<?php echo $crimeId; ?>}, (data, status, xhr) => {
      if (status == "success") {
        $("#resultDiv").html(data);   
      }else{
        $("#resultDiv").html("No student found");
      }    
    });
  });
</script>