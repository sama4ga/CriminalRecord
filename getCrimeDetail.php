<?php
session_start();
require_once("connect.php");

$_SESSION['back'] = "viewCrimes.php";
// var_dump($_SESSION);
$crimeId = $_POST['cId'];

// fetch crime info
$query = "SELECT `subject`,`scene`,`status`,`name`,`date`,`statement`,o.`id` as 'officerId',`priority`,`category`,`passport`
            FROM `crime` c
            JOIN `officer` o ON o.`id`=c.`officerId`
            WHERE c.`id`=$crimeId;";
$result = $con->query($query);

if ($result) {
  if ($result->num_rows > 0) {
    $crime = $result->fetch_assoc();
    echo "<h3>Crime</h3>
          <div class='row'>
            <div class='col-3'>Subject:</div>
            <div class='col-9'>".$crime['subject']."</div>
          </div>
          <div class='row'>
            <div class='col-3'>Statement:</div>
            <div class='col-9'>".$crime['statement']."</div>
          </div>
          <div class='row'>
            <div class='col-3'>Scene:</div>
            <div class='col-9'>".$crime['scene']."</div>
          </div>
          <div class='row'>
            <div class='col-3'>Date committed:</div>
            <div class='col-9'>".$crime['date']."</div>
          </div>
          <div class='row'>
            <div class='col-3'>Officer in-charge:</div>
            <div class='col-8'>".$crime['name']."</div>
            <span><a href='removeOfficer.php?oId=".$crime['officerId']."&cId=".$crimeId."' title='Change Officer'>-</a></span>
          </div>
        ";
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No detail found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching crime details</div>".$con->error;
}


// fetch suspects
$query = "SELECT s.`id` as 'suspectId',`name`,`regNo`,`department`,`faculty`,`level`,st.`id` as 'studentId',`passport`
            FROM `suspect` s
            JOIN `student` st ON st.`id`=s.`studentId`
            WHERE s.`crimeId`=$crimeId;";
$result = $con->query($query);

if ($result) {
  if ($result->num_rows > 0) {
    //$suspects = $result->fetch_assoc();
    while ($suspect = $result->fetch_assoc()) {
      echo "<h3 class='pt-3'>Suspects</h3>
            <div class='row'>
              <div class='col-3 pr-0'>
                <img src='".$suspect['passport']."' width='100%' height='100' />
              </div>           
              <div class='col-7'>
                <div class='row'>
                  <div class='col-3'>Name:</div>
                  <div class='col-9'>".$suspect['name']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Reg. No.</div>
                  <div class='col-9'>".$suspect['regNo']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Level</div>
                  <div class='col-9'>".$suspect['level']."</div>
                </div>
              </div>
              <div class='col-2'>
                <a href='viewStudent.php?id=".$suspect['studentId']."' title='View suspect info'>+</a>
                <a href='removeSuspect.php?id=".$suspect['suspectId']."' title='Remove suspect'>-</a>
              </div>
            </div>
          ";
    }
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No suspects found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching suspects</div>".$con->error;
}

echo "<div class='alert alert-info'><a href='addSuspect.php?cId=$crimeId'>+ Add Suspect</a></div>";


// fetch witnesses
$query = "SELECT w.`id` as 'witnessId',`name`,`regNo`,`department`,`faculty`,`level`,st.`id` as 'studentId',`passport`,`statement`
            FROM `witness` w
            JOIN `student` st ON st.`id`=w.`studentId`
            WHERE w.`crimeId`=$crimeId;";
$result = $con->query($query);

if ($result) {
  if ($result->num_rows > 0) {
    // $witnesses = $result->fetch_assoc();
    while ($witness = $result->fetch_assoc()) {
      echo "<h3 class='pt-3'>Witnesses</h3>
            <div class='row'>
              <div class='col-3 pr-0'>
                <img src='".$witness['passport']."' width='100%' height='100' />
              </div>           
              <div class='col-7'>
                <div class='row'>
                  <div class='col-3'>Name</div>
                  <div class='col-8'>".$witness['name']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Reg. No.</div>
                  <div class='col-8'>".$witness['regNo']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Level</div>
                  <div class='col-8'>".$witness['level']."</div>
                </div>
                <div class='row'>
                  <div class='col-3'>Statement</div>
                  <div class='col-8'>".$witness['statement']."</div>
                </div>
              </div>
              <div class='col-2'>
                <a href='viewStudent.php?id=".$witness['studentId']."' title='View witness info'>+</a>
                <a href='removeWitness.php?id=".$witness['witnessId']."' title='Remove witness'>-</a>
              </div>
            </div>
          ";
    }
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No witnesses found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>Error occured while fetching witnesses</div>".$con->error;
}

echo "<div class='alert alert-info'><a href='addWitness.php?cId=$crimeId'>+ Add Witness</a></div>";


// fetch verdicts
$query = "SELECT v.`id` as 'verdictId',`name`,`type`,`address`,`judge`,`status`,c.`id` as 'courtId',`date`
            FROM `verdict` v
            JOIN `court` c ON c.`id`=v.`courtId`
            WHERE v.`crimeId`=$crimeId;";
$result = $con->query($query);

if ($result) {
  if ($result->num_rows > 0) {
    // $verdicts = $result->fetch_assoc();
    while ($verdict = $result->fetch_assoc()) {
      echo "<h3 class='pt-3'>Verdicts</h3>
            <div class='row'>
              <div class='col-10'>
                <div class='row'>
                  <div class='col-3'>Court</div>
                  <div class='col-7'>".$verdict['name'].", ".$verdict['address']."</div>
                  <div class='col-2'>
                    <a href='viewCourt.php?id=".$verdict['courtId']."' title='View court info'>+</a>
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
              </div>
              <div class='col-2'>
                <a href='removeVerdict.php?id=".$verdict['verdictId']."' title='Remove verdict'>-</a>
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

echo "<div class='alert alert-info'><a href='addVerdict.php?cId=$crimeId'>+ Add Verdict</a></div>";


?>