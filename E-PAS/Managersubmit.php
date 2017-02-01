<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('BasicDetails');
$c1 = $db->selectCollection('RelievingDetails');

$id = $_POST["eid"];
$d=$c->update(array("id"=>$id),array('$set'=>array("MF"=>1)));

$mcomment1=$_POST["mcomment1"];
$mcomment2=$_POST["mcomment2"];
$mcomment3=$_POST["mcomment3"];
$mcomment4=$_POST["mcomment4"];
$mcomment5=$_POST["mcomment5"];
$mcomment6=$_POST["mcomment6"];
$mcomment7=$_POST["mcomment7"];
$mcomment8=$_POST["mcomment8"];
$mcomment9=$_POST["mcomment9"];
/*$mcomment10=$_POST["mcomment10"];
$mcomment11=$_POST["mcomment11"];
$mcomment12=$_POST["mcomment12"];
$mcomment1=$_POST["mcomment1"];
$mcomment2=$_POST["mcomment2"];
$mcomment3=$_POST["mcomment3"];
$mcomment4=$_POST["mcomment4"];
$mcomment5=$_POST["mcomment5"];
$mcomment6=$_POST["mcomment6"];*/
$d1=$c1->update(array("id"=>$id),array('$set'=>array("id"=>$id,"mComment1"=>$mcomment1,"mComment2"=>$mcomment2,"mComment3"=>$mcomment3,"mComment4"=>$mcomment4,"mComment5"=>$mcomment5,"mComment6"=>$mcomment6,"mComment7"=>$mcomment7,"mComment8"=>$mcomment8,"mComment9"=>$mcomment9)),array("upsert"=>true));


?>