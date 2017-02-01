<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;

$newdate=$_POST['newdate'];
$idarray=array();

if(!empty($_POST['check_list'])) {
foreach($_POST['check_list'] as $check) {
array_push($idarray,$check);
}
}


$res=$n->findOne(array("name"=>"extendedSelfAppraisals"));
if(empty($res))
{
$result=$n->insert(array("name"=>"extendedSelfAppraisals","Deadline"=>$newdate,"employee IDs"=>$idarray));	
for($i=0;$i<count($idarray);$i++)
{
$details=$bd->findOne(array("psiid"=>$idarray[$i]));
$emailid=$details["emailID"];
$msg="Your Self-Appraisal deadline has been extended to ".$newdate;
mail("malinihp@gmail.com","A-PAS self-appraisal deadline extended",$msg);
	
	}
}
else
{
for($i=0;$i<count($idarray);$i++)
{
$result=$n->update(array("name"=>"extendedSelfAppraisals"),
array('$addToSet'=>array("employee IDs"=>$idarray[$i])));
$details=$bd->findOne(array("psiid"=>$idarray[$i]));
$emailid=$details["emailID"];
$msg="Your Self-Appraisal deadline has been extended to ".$newdate;
mail("malinihp@gmail.com","A-PAS self-appraisal deadline extended",$msg);
}} 
?>

