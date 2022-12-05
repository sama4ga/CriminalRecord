<?php
$page = "View Verdict";
include_once("header.php");
require_once("connect.php");

if (isset($_REQUEST['cId'])) {

  $crimeId = $_REQUEST['cId'];
  
  $query = "SELECT v.`id` as 'verdictId',`name`,`type`,`address`,`judge`,`status`,`verdict`,c.`id` as 'courtId',`date`
            FROM `verdict` v
            JOIN `court` c ON c.`id`=v.`courtId`
            WHERE v.`crimeId`=?;";
$stmt = $con->prepare($query);
$stmt->bind_param("i",$crimeId);
$stmt->execute();
if ($stmt) {
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    // $verdicts = $result->fetch_assoc();
    echo "<div class='my-5'>
          <h3 class='pt-3'>Verdicts</h3>";
    while ($verdict = $result->fetch_assoc()) {
      echo "<div class='row mt-2 pb-2'>
              <div class='col-10'>
                <div class='row'>
                  <div class='col-3'>Court</div>
                  <div class='col-7'>".$verdict['name'].", ".$verdict['address']."</div>
                  <div class='col-2'>
                    <a href='viewCourt.php?id=".$verdict['courtId']."' title='View court info'><i class='fa fa-address-card' aria-hidden='true'></i></a>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-3'>Judge</div>
                  <div class='col-8'>".$verdict['judge']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Status</div>
                  <div class='col-8'>".$verdict['status']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Verdict</div>
                  <div class='col-8'>".$verdict['verdict']."</div>
                </div>
              </div>
              <div class='col-2'>
                <a href='removeVerdict.php?id=".$verdict['verdictId']."' title='Remove verdict'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>
              </div>
            </div>
          </div>
          ";
    }
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No verdicts found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching verdicts</div>".$con->error;
}

echo "<div class='alert alert-info mt-2'><a href='addVerdict.php?cId=$crimeId'><i class='fa fa-plus' aria-hidden='true'></i> Add Verdict</a></div>";



}



include_once("footer.php");
?>