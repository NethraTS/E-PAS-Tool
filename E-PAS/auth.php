<?php
session_start();include session_timeout.php;
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['psiid']) || (trim($_SESSION['psiid']) == '')) {
		header("location:index.php");
		
		exit();
	}

     
?>