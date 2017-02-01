s<?php

$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;

$submitted = $_POST['sub'];
$id=$_POST['id'];

if($submitted=="true")
{
$d=$c->update(array("id"=>$id),array('$set'=>array("flag"=>"2")));	

}
?>
