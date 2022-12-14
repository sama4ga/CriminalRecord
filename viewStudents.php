<?php
require_once("connect.php");
$page = "View Students";
include_once("header.php");


$query = "SELECT `id`,`name`,`regNo`,`department`,`level`,`faculty`,`gender`,`phone`,`email`,`passport`,`address`,`dob`
              from `student`;";
  $result = $con->query($query);
  if ($result) {
    if ($result->num_rows > 0) {
      echo "<div class='mx-2 my-4'>
              <h1 class='text-center mb-4'>View Student</h1>
              <div class='table-responsive'>
                <table class='table table-striped table-hover'>
                  <thead class='table-dark'>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Reg. No.</th>
                    <th>Deparment</th>
                    <th>Faculty</th>
                    <th>Level</th>
                    <th>Gender</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th class='text-nowrap'>Date of birth</th>
                    <th></th>
                  </thead>
                  <tbody>
           ";
        $count = 0;
      while ($row = $result->fetch_assoc()) {
        $count++;
        echo "      <tr>
                      <td class='align-middle'>".$count."</td>
                      <td class='d-flex'>
                        <img src='".$row['passport']."' width='50' height='50' class='rounded-circle mr-1' /><span class='text-nowrap mt-3'>".$row['name']."</span>
                      </td>
                      <td class='align-middle'>".$row['regNo']."</td>
                      <td class='align-middle'>".$row['department']."</td>
                      <td class='align-middle'>".$row['faculty']."</td>
                      <td class='align-middle'>".$row['level']."</td>
                      <td class='align-middle'>".$row['gender']."</td>
                      <td class='align-middle'>".$row['phone']."</td>
                      <td class='align-middle'>".$row['email']."</td>
                      <td class='text-nowrap align-middle'>".$row['address']."</td>
                      <td class='align-middle'>".$row['dob']."</td>
                      <td>
                        <a href='editStudent.php?id=".$row['id']."' class='bg-primary'><i class='fa fa-keys'></i></a>
                        <a href='removeStudent.php?id=".$row['id']."' class='bg-danger'><i class='fa fa-stop'></i></a>
                      </td>
                    </tr>
             ";         
      } 
      echo "      </tbody>
                </table>
              </div>
            </div>";     
    }else{
      echo "<div class='alert alert-info'>No student found</div>";
    }
  }else{
    echo "<div class='alert alert-danger'>Error fetching student record</div>".$stmt->error;
  }

include_once("footer.php");
?>