<?php 
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$c1=$db->currentGoalCycle;
$id=$_POST['id'];
//$sub=$_POST['sub'];

//if($sub=="true")
{
	$doc=$c->findOne(array("id"=>$id));
	
		$c->update(array("id"=>$id),array('$set'=>array("r1MeetingDate" => "")));
			$c1->update(array("id"=>$id),array('$set'=>array("r1MeetingDate" => "")));	
}
?>