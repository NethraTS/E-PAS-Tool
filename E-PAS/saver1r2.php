<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('currentGoalCycle');
$c1 = $db->selectCollection('BasicDetails');
$desgn = $_GET['desgn'];
$id22 = $_GET['id22'];
$idr1 = $_GET['emp_id'];
$idr2 = $_GET['emp_id22'];
$namer1 = $_GET['name1'];
$namer2 = $_GET['name22'];
$emailr1 = $_GET['email'];
$emailr2 = $_GET['email22'];

//echo $desgn;echo $desgn;echo $id22 ;echo $idr1 ;echo $idr2 ;echo $namer1 ;echo $namer2;echo $emailr1;echo $emailr2;




/*$id22 = "666";
$idr1 = "1066";
$idr2 = "1071";
$namer1 = "Balagopalan";
$namer2 = "Sureash";
$emailr1 = "abc@gmail.com";
$emailr2 = "bcd@gmail.com";*/


$d=$c->update(array("id"=>$id22),array('$set'=>array("desgn"=>$desgn,"r1id"=>$idr1,"r2id"=>$idr2,"r1name"=>$namer1,"r2name"=>$namer2,"r1emailid"=>$emailr1,"r2emailid"=>$emailr2)));
$d1=$c1->update(array("id"=>$id22),array('$set'=>array("desgn"=>$desgn,"r1name"=>$namer1,"r2name"=>$namer2,"r1emailid"=>$emailr1,"r2emailid"=>$emailr2)));
header("Location:employeedetails.php");
//var_dump($d);
//var_dump($d1);
?>
