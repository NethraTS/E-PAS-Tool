<?php
session_start();include session_timeout.php;
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$ed=$db->adminlist;


$psiid=$_POST['id'];
$res=$ed->remove(array("psiid"=>$psiid));
?>


