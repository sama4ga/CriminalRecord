<?php
require_once("connect.php");


$name = $_POST['text'];
$query = "SELECT `id`,`name`,`department`,`level`,`faculty`,`gender`,`phone`,`email`,`passport`,`address`
              from `student` WHERE `name` LIKE '%$name%';";
  $stmt = $con->prepare($query);
  // $stmt->bind_param("s",$name);
  $stmt->execute();
  if (!$stmt->errno) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $id = $row['id'];
        echo "<div class='d-flex'>
                <div class='mr-2'>
                  <img src='".$row['passport']."' width='30' height='30' alt='".$row['name']."'/> ".$row['name']."<br />
                  <i class='text-sm'>".$row['faculty']." ".$row['department']."</i>
                </div>
                <div>
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