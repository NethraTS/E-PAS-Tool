<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->tempdates;

$id = $_POST['id'];
$date=$_POST['Mdate'];
$data =json_decode($posted_data,true);

$d=$c->update(array("id"=>$id),array('$set'=>array("r1Date"=>$date)));

//var_dump($d);
?>
