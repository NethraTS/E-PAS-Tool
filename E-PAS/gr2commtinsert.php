<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$c1=$db->currentGoalCycle;
$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);

$doc=$c->findOne(array("id"=>$data[0]));

if($doc["rFlag"]=="4")
{
	$c->update(array("id"=>$data[0]),array('$set'=>array("r2feedback"=>encrypt($data[1]),"rFlag"=>"5")));	
	$c->update(array("id"=>$id),array('$set'=>array("flag"=>"8")));
	$c1->update(array("id"=>$id),array('$set'=>array("flag"=>"8")));
}
elseif($doc["rFlag"]=="5")
{
	$c->update(array("id"=>$data[0]),array('$set'=>array("r2feedback"=>encrypt($data[1]))));	
}
elseif($doc["rFlag"]=="6")
{
echo "already submitted";
}

?>