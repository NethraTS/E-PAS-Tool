<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->selectCollection('Notifications');
$d=$db->BasicDetails;
$ed=$db->adminlist;

if(isset($_POST['edit']))
{
$id=$_POST['hiddenid'];
$psiid=$_POST['Psiid'];
$name=$_POST['Name'];
$mailid=$_POST['Mailid'];
$desgn=$_POST['Desgn'];

$res=$ed->update(array("psiid"=>$id),array('$set'=>array("psiid"=>$psiid,
"name"=>$name,
"email"=>$mailid,
"designation"=>$desgn)));

header("Location:editadminlist.php");
}

?>


