<?php
$page = "View Courts";
include_once("header.php");
require_once("connect.php");


$result = $con->query("SELECT `id`,`name`,`address`,`type` FROM `court`;");
if ($result) {
  if ($result->num_rows > 0) {
    echo "<div class='my-5 py-3'>
          <h1 class='text-center'>View Courts</h1>
          <div class='float-right my-3'>
            <a href='addCourt.php' class='btn btn-md btn-primary'><i class='fas fa-plus fa-xs fa-fw'></i> Add Court</a>
          </div>
          <div class='table-responsive my-3'>
            <table class='table table-striped table-hover' id='tblCourt'>
              <thead>
                <th>S/N</th>
                <th>Court Name</th>
                <th>Type</th>
                <th>Address</th>
                <th></th>
              </thead>
              <tbody style='border-bottom: #cfcfcf 1px solid;'>
    ";
    $count = 0;
    while ($court = $result->fetch_assoc()) {
      $count++;
      echo "
                <tr>
                  <td>".$count."</td>
                  <td>".$court['name']."</td>
                  <td>".$court['type']."</td>
                  <td>".$court['address']."</td>
                  <td class='d-flex' data-id='".$court['id']."'>
                    <a href='editCourt.php?id=".$court['id']."' class='btn btn-sm btn-primary' title='Edit Court'><i class='fas fa-edit fa-xs fa-fw'></i></a>
                    <button onclick=\"confirmDelete(this, 'removeCourt.php')\" class='btn btn-sm btn-danger' title='Remove Court'><i class='fas fa-trash fa-xs fa-fw'></i></button>
                  </td>
                </tr>
      ";
    }

    echo "
              </tbody>
            </table>
          </div>
          </div>
          ";
  }else{
    echo "<div class='alert alert-info alert-dismissible'>No courts found</div>";
  }
}else{
  echo "<div class='alert alert-danger alert-dismissible'>An error occured while fetching courts</div>".$con->error;
}




include_once("footer.php");
?>


<div id="dialog-confirm" title="Confirm Delete" style="display: none;">
  <p class="mt-4">
    Are you  sure you want to delete this court?
  </p>
</div>

<div id="dialog-message" title="Delete complete" style="display: none;">
  <p>
    Court successfully deleted
  </p>
</div>

<script>
  $("#tblCourt").DataTable();
</script>