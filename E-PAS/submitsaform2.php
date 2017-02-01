s<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$submitted = $_POST['sub'];
$id=$_POST['id'];

if($submitted=="true")
{
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag1"=>"2")));
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag2"=>"2")));
}
var_dump($id);
?>
