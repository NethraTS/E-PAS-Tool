<?php 
session_start();include session_timeout.php;
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
//$c1=$db->currentGoalCycle;
$id=$_POST['id'];
$cmt=$_POST['cmt'];
$date=$_POST['dat'];
$goal22=$_POST['goal22'];
$def22=$_POST['def22'];

//$timestamp=date("d-m-Y H:i:s");

$doc=$c->findOne(array("id"=>$id));

//$c->update(array("id"=>$id),array('$set'=>array("r1overallcomment"=>encrypt($cmt))));
$c->update(array('id' => $id),array('$push' => array('r1overallcomment' => array("comment"=>($cmt),'CDate'=>$date,'goal'=>$goal22,'definition'=>$def22))));
//$c1->update(array('id' => $id),array('$push' => array('r1overallcomment' => array("comment"=>($cmt),'CDate'=>$date,'goal'=>$goal22,'definition'=>$def22))));
?>