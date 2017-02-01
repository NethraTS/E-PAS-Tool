<?php 

//check if the goals are eligible for review in this cycle
function checkstatus($id)
{

$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;

	$doc=$c->findOne(array("id"=>$id));
	//$doc['gName']="Q1";
	if(($doc['gName']=="Q1" && date("M")=="Jun") || ($doc['gName']=="Q2" && date("M")=="Sep") || 
	    ($doc['gName']=="Q3" && date("M")=="Dec") || ($doc['gName']=="Q4" && date("M")=="Mar") || 
  	    ($doc['gName']=="H1" && date("M")=="Sep") || ($doc['gName']=="H2" && date("M")=="Mar") ||
	    ($doc['gName']=="A" && date("M")=="Mar"))
		     $status="Yes";
	else 
	        $status="No";	               	        

	return $status;	        
}

