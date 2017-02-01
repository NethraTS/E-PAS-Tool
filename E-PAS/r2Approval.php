<?php 
session_start();include session_timeout.php;
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$gHistoryCollection=$db->goalHistory;
$id=$_POST['id'];
//$cmt=$_POST['cmt'];

//$timestamp=date("d-m-Y H:i:s");

$doc=$c->findOne(array("id"=>$id));

$c->update(array("id"=>$id),array('$set'=>array("r2Finalcomment"=>1)));

$doc=$c->findOne(array("id"=>$id));
$gHistoryCollection->insert($doc);
?>