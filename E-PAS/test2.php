<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$f=$db->deadlineFlags;
$c=$db->currentReviewCycle;
$n=$db->Notifications;
$adl=$db->adminlist;
$k=$db->encryptionkey; 

$fileName="abcd.xls";

	$ext = substr(strrchr($fileName, "."), 1);
	echo $ext;
//$n->update(array("name"=>"review3"),array('$set'=>array("finalised"=>0)));
//$n->update(array("name"=>"review3"),array('$set'=>array("finalisedIDs"=>array())));
//$c->update(array("psiid"=>"666"),array('$set'=>array("flag2"=>"10","flag1"=>"4")));
//,"normalisedRating"=>"E"


?>



