<?php
require_once("connect.php");

/*
 A witness cannot be a suspect
*/

$name = $_POST['text'];
$crimeId = $_POST['cId'];

$query = "SELECT `id`,`name`,`department`,`level`,`faculty`,`gender`,`phone`,`email`,`passport`,`address`
              from `student` 
              WHERE `name` LIKE '%$name%'
              AND `id` NOT IN (SELECT `studentId` FROM `suspect` WHERE `crimeId`=$crimeId);";
  $stmt = $con->prepare($query);
  // $stmt->bind_param("s",$name);
  $stmt->execute();
  if (!$stmt->errno) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='row'>
                <div class='col-10'>
                  <img src='".$row['passport']."' width='30' height='30' alt='".$row['name']."'/> ".$row['name']."<br />
                  <i class='text-sm text-nowrap'>".$row['faculty']." ".$row['department']."</i>
                </div>
                <div class='col-2'>
                  <button type='button' class='btn btn-sm btn-success btnAdd' onclick='add(".$row['id'].", this)'> + Add</button>
                  <input type='hidden' value='".$row['name']."' name='txtStudentName' />
                </div>
              </div>";         
      }      
    }else{
      echo "<div class='alert alert-info'>No student found</div>";
    }
  }else{
    echo "<div class='alert alert-danger'>Error fetching student record</div>".$stmt->error;
  }


?>