<?php
$servername="localhost";
$uname="root";
$upassword="";
$dbName="criminal_record";

// CREATE CONNECTION
$con=new mysqli($servername,$uname,$upassword,$dbName);
// check connection
if ($con -> connect_error){
    die("could not connect". $con -> connect_error);
}
// echo "connection succeed";
?>