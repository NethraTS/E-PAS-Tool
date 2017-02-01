<?php
session_start();
include session_timeout.php;
session_destroy();
unset($_SESSION['psiid']);
unset($_SESSION['uname']);
unset($_SESSION['role']);
unset($_SESSION['admin']);


header("Location:index.php");
?>
