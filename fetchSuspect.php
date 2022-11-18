<?php
require_once("connect.php");

/*
 A suspect cannot be a witness
*/

$name = $_POST['text'];
$crimeId = $_POST['cId'];

$query = "SELECT `id`,`name`,`department`,`level`,`faculty`,`gender`,`phone`,`email`,`passport`,`address`
              from `student` 
              WHERE `name` LIKE '%$name%'
              AND `id` NOT IN (SELECT `studentId` FROM `witness` WHERE `crimeId`=$crimeId);";
  $stmt = $con->prepare($query);
  // $stmt->bind_param("s",$name);
  $stmt->execute();
  if (!$stmt->errno) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<form method='POST'>
                <div class='d-flex'>
                  <div class='mr-2'>
                    <img src='".$row['passport']."' width='30' height='30' alt='".$row['name']."'/> ".$row['name']."<br />
                    <i class='text-sm'>".$row['faculty']." ".$row['department']."</i>
                  </div>
                  <div>
                    <button type='submit' name='btnAddSuspect' class='btn btn-sm btn-success'> + Add</button>
                    <input type='hidden' value='".$row['id']."' name='txtSuspectId' />
                  </div>
                </div>
              </form>";         
      }      
    }else{
      echo "<div class='alert alert-info'>No student found</div>";
    }
  }else{
    echo "<div class='alert alert-danger'>Error fetching student record</div>".$stmt->error;
  }


?>