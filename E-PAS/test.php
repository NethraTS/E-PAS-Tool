<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$db=$m->appraisalmgmt;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;

$newdate=$_POST['newdate'];
$idarray=array();



if(!empty($_POST['check_list'])) {
foreach($_POST['check_list'] as $check) {
array_push($idarray,$check);
}

//var_dump($idarray);

//var_dump($newdate);

$res=$n->findOne(array("name"=>"extendedSelfAppraisals"));
if(empty($res))
{
$result=$n->insert(array("name"=>"extendedSelfAppraisals","Deadline"=>$newdate,"employee IDs"=>$idarray));	
for($i=0;$i<count($idarray);$i++)
{
$r=$n->update(array("name"=>"selfAppraisal"),array('$pull'=>array("employee IDs"=>$idarray[$i])));
}
}
else
{
for($i=0;$i<count($idarray);$i++)
{
$result=$n->update(array("name"=>"extendedSelfAppraisals"),
array('$addToSet'=>array("employee IDs"=>$idarray[$i])));
$r=$n->update(array("name"=>"selfAppraisal"),array('$pull'=>array("employee IDs"=>$idarray[$i])));
}}  
header('location:extendsadeadline.php?status=success');        
}
?>
