<?php 
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$dest=$db->GoalsToBeReviewed;

$alldocs=$c->find();
foreach($alldocs as $doc)
{
	$c->update(array("id"=>$doc["id"]),array('$set'=>array("rFlag"=>"0")));
	$dest->save($c->findOne(array("id"=>$doc["id"]))); //move to history collection
}