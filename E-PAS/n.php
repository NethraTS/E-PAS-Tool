<?php 
include "query_emp.php";
	$id1=$_GET['q'];
	$str=verifyUserTemp($id1);
	/*$det = explode(",", $str);
$m = new MongoClient();
$db=$_SESSION['dbname'];
$collection = $db->manage_users;
$uid=$det[1];
$uname=ucfirst(strtolower($det[0]));
$email=$det[2];
$hw=array('user_id'=>$uid);*/
echo $str;	
?>
