<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;

$eid="1";
$gName="Q1";

$newdata1=array('$set'=>array('Q1.Weightage.reviewer1comment' =>"fff"));	
$c->update(array(
"id" => $eid,
"Q1" => array(
'$elemMatch'=>array("Weightage.deliverables"=>"dfffdsfdsfs"))),$newdata1);


/*

$d=$c->update(array("id"=>$eid),array('$push'=>array($gName=>array("Weightage"=>array(
		"deliverables"=>"dfffdsfdsfs",
		"quality"=>"ggvbbnvb",
		"competency"=>"jgumnmnmm",
		"organisationalContribution"=>"tedfdfgvcbn",
		"valueAddition"=>"gjhgjgj")))));



$d=$c->update(array("id"=>$eid,"Q1.Quality.cnt"=>"dfffdsfdsfs"),array('$set'=>array(
		"Q1.Quality.msrmt"=>"fg fgdgdf",
		"Q1.Quality.descr"=>"  gfd",
		"Q1.Quality.ecomm"=>"fgg ",
		"Q1.Quality.r1comm"=>"fgd fgd")));*/		
?>
