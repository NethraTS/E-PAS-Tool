<?php 
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;


$c->update(array("psiid"=>"888"),array('$set'=>array("flag2"=>"10")));
?>


/*
$coll->update(array("psiid"=>$doc["psiid"]),
array('$set'=>array(
"normalisedRating"=>encypt($doc["normalisedRating"]),
"overall R1rating"=>encrypt($doc["overall R1rating"]),
"overall R2rating"=>encrypt($doc["overall R2rating"]),
"overall R3rating"=>encrypt($doc["overall R3rating"]),
"overallselfrating"=>encrypt($doc["overallselfrating"]),
"personalcomments"=>encrypt($doc["personalcomments"]),
"r1 feedback"=>encrypt($doc["r1 feedback"]),
"r2 feedback"=>encrypt($doc["r2 feedback"]),
"r3 feedback"=>encrypt($doc["r3 feedback"]),
)));	*/
