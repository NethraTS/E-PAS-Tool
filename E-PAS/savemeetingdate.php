<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->selectCollection('currentReviewCycle');

$id = $_POST['id'];
$date=$_POST['Mdate'];
$data =json_decode($posted_data,true);

$d=$c->update(array("psiid"=>$id),array('$set'=>array("r1MeetingDate"=>$date)));

//var_dump($d);
?>
