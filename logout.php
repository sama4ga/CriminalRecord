<?php
session_start();

unset($_SESSION['officer']);
session_write_close();

header("Location:index.php");

?>