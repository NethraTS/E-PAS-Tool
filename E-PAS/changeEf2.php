<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('BasicDetails');
$c1 = $db->selectCollection('RelievingDetails');

$id = $_POST["eid"];
$d=$c->update(array("id"=>$id),array('$set'=>array("EF"=>2)));

$comment1=$_POST["comment1"];
$comment2=$_POST["comment2"];
$comment3=$_POST["comment3"];
$comment4=$_POST["comment4"];
$comment5=$_POST["comment5"];
$comment6=$_POST["comment6"];
$comment7=$_POST["comment7"];
$comment8=$_POST["comment8"];
$comment9=$_POST["comment9"];
$comment10=$_POST["comment10"];
$comment11=$_POST["comment11"];
$comment12=$_POST["comment12"];

$d1=$c1->update(array("id"=>$id),array('$set'=>array("id"=>$id,"Comment1"=>$comment1,"Comment2"=>$comment2,"Comment3"=>$comment3,"Comment4"=>$comment4,"Comment5"=>$comment5,"Comment6"=>$comment6,"Comment7"=>$comment7,"Comment8"=>$comment8,"Comment9"=>$comment9,"Comment10"=>$comment10,"Comment11"=>$comment11,"Comment12"=>$comment12)),array("upsert"=>true));


?>