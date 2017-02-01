<?php 
session_start();include session_timeout.php;
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$db1=$m->goals1;
$c1 = $db1->currentGoalCycle;
$c = $db->currentReviewCycle;
$dest=$db->reviewHistory;
$n=$db->Notifications;

$alldoc=$c->find();

$fin=$n->findOne(array("name"=>"review3"));

if(count($fin["reviewer IDs"])==count($fin["finalisedIDs"]))
{
foreach($alldoc as $doc)
{
//if($doc["postponedFlag"]>="1")



if($doc["proposedAction"]["newPosition"]!=null||$doc["proposedAction"]["newPosition"]!="")	
$c1->update(array("id"=>$doc["psiid"]),array('$set'=>array("desgn"=>$doc["proposedAction"]["newPosition"])));	

//$c->update(array("psiid"=>$doc["psiid"]),array('$set'=>array("flag2"=>"12")));

$dest->save($c->findOne(array("psiid"=>$doc["psiid"]))); //move to history collection



if($doc["flag2"]=="9")
{
$c->update(array("psiid"=>$doc["psiid"]),array('$set'=>array("flag2"=>"11")));

if($doc["accpetedByemp"]>="1")
{}
else
{

$c->update(array("psiid"=>$doc["psiid"]),array('$set'=>array("accpetedByHR"=>"1")));
}


}
}

echo "published Successfully!";

}
else 
{
echo "Cannot publish now.Some reviews are still pending!";	
}


?>
