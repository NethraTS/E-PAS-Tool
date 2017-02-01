<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;
$dest=$db->reviewHistory;

$psiid=$_POST['psiid'];
$role=$_POST['role'];
$timestamp=date("d-m-Y H:i:s");

$doc=$c->findOne(array("psiid"=>$psiid));
//echo $psiid;
//var_dump($role);
   
if($role=="emp")
{
if($doc["flag2"]=="11")
{echo "Already Closed!!";}
else 
{
$c->update(array("psiid"=>$psiid),array('$set'=>array("flag2"=>"11","accpetedByemp"=>"1")));
$c->update(array("psiid"=>$psiid),array('$set'=>array("finisedTimeStamp"=>$timestamp)));
$re=$dest->save($c->findOne(array("psiid"=>$psiid)));
header("location:dashoboard.php");        
}
}
elseif($role=="hr")
{
if($doc["flag2"]=="11")
echo "Already Closed!!";
else 
{
$c->update(array("psiid"=>$psiid),array('$set'=>array("flag2"=>"11","accpetedByHR"=>"1")));
$c->update(array("psiid"=>$psiid),array('$set'=>array("finisedTimeStamp"=>$timestamp)));
$re=$dest->save($c->findOne(array("psiid"=>$psiid)));
header("location:hrviewlist.php");
//echo "success";
}
}       
?>



