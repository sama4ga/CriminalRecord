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
    echo "<div class='my-5'>
            <h3 class='text-center'>View Crimes</h3>
            <!-- <div class='d-flex mx-auto mt-3'>
              <input type='search' class='form-control mr-1' placeholder='Search Crimes' id='txtSearch'/>
              <button class='btn btn-md btn-secondary' id='btnSearch'>Search</button>
            </div>
            <div id='resultDiv' class='my-3'></div> -->
            <div>
              <a href='addCrime.php' class='btn btn-md btn-success float-right mb-2'><i class='fa fa-plus' aria-hidden='true'></i> Add Crime</a>
            </div>
            <div class='table-responsive'>
              <table class='table table-hover table-striped' id='tblCrime'>
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
                    <td style='white-space:nowrap;text-overflow:ellipsis;overflow:hidden;'>".$row['scene']."</td>
                    <td>".$row['status']."</td>
                    <td>".$row['name']."</td>
                    <td class='text-nowrap'>".date('d-m-Y', strtotime($row['date']))."</td>
                    <td data-id='".$row['crimeId']."' class='d-flex'>
                      <button onclick='viewDetail(this)' class='btn btn-sm btn-primary' title='View detail'><i class='fa fa-list' aria-hidden='true'></i></button>
                      <button onclick=\"viewVerdict(this,'deleteCrime.php')\" class='btn btn-sm btn-warning' title='View verdicts'><i class='fa fa-address-card' aria-hidden='true'></i></button>
                      <button onclick=\"confirmDelete(this, 'deleteCrime.php')\" class='btn btn-sm btn-danger' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></button>
                      <button onclick='editCrime(this)' class='btn btn-sm btn-info' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button>
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

<div id="dialog-confirm" title="Confirm Delete" style="display: none;">
  <p class="mt-4">
    Are you  sure you want to delete this crime?
  </p>
  <p>
    This will delete all related records, files, evidences, suspects, verdicts, witness with the crime.<br />
    This action cannot be undone
  </p>
</div>

<div id="dialog-message" title="Delete complete" style="display: none;">
  <p>
    Crime successfully deleted
  </p>
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

  function editCrime(e) {
    const id = $(e).parent()[0].dataset.id;
    window.location.href = "editCrime.php?i="+id;
  }

  function viewVerdict(e) {
    const id = $(e).parent()[0].dataset.id;
    window.location.href = "viewVerdict.php?cId="+id;
  }

  $("#btnSearch").one("click", function(){
    const searchText = $("#txtSearch").val();
    $("#resultDiv").html(searchText);
  });

  $("#tblCrime").DataTable();
</script>