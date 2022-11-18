<?php
require_once("classes/Crime.php");
session_start();
$page = "View Crimes";
include_once("header.php");
require_once("connect.php");

unset($_SESSION['back']);
// var_dump($_SESSION);
$msg = "";

$query = "SELECT c.`id` as 'crimeId',`subject`,`scene`,`status`,`name`,`date`
            FROM `crime` c
            JOIN `officer` o ON o.`id`=c.`officerId`;";
$result = $con->query($query);

if ($result) {
  if ($result->num_rows > 0) {
    echo "<div class='m-3'>
            <h3>View Crimes</h3>
            <div class='d-flex mx-auto my-3'>
              <input type='search' class='form-control mr-1' placeholder='Search Crimes' />
              <button class='btn btn-md btn-secondary'>Search</button>
            </div>
            <div id='resultDiv'></div>
            <div>
              <table class='table table-responsive table-hover table-stripped'>
                <thead>
                  <th>S/N</th>
                  <th>Subject</th>
                  <th>Scene</th>
                  <th>Status</th>
                  <th>Officer in-charge</th>
                  <th>Date</th>
                  <th></th>
                </thead>
                <tbody>";
    $count = 0;
    while ($row = $result->fetch_assoc()) {
      $count++;
      echo  "
                  <tr>
                    <td>".$count."</td>
                    <td>".$row['subject']."</td>
                    <td>".$row['scene']."</td>
                    <td>".$row['status']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['date']."</td>
                    <td data-id='".$row['crimeId']."'>
                      <button onclick='viewDetail(this)' class='btn btn-sm btn-primary'>View detail</button>
                      <button onclick='' class='btn btn-sm btn-warning'>View verdicts</button>
                      <button onclick='' class='btn btn-sm btn-danger'>Delete</button>
                      <button onclick='' class='btn btn-sm btn-info'>Edit</button>
                    </td>
                  </tr>
            ";
    }
    echo    "   </tbody>
              </table>
            </div>
          </div>";
  }else{
    echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>No crimes found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error occured while fetching crimes</div>".$con->error;
}



?>

<div id="crimeDetailModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"  id="crimeDetailDiv"></div>
    </div>
  </div>
</div>


<?php
  include_once("footer.php");
?>

<script>
  function viewDetail(e) {
    const id = $(e).parent()[0].dataset.id;
    $.post("getCrimeDetail.php", {'cId':id}, (data, status, xhr) => {
      if (status == "success") {
        $("#crimeDetailDiv").html(data);
        $("#crimeDetailModal").modal('show');
      }
    })
  }
</script>