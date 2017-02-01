<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->selectCollection('currentReviewCycle');

$submitted = $_POST['sub'];
$id=$_POST['id'];

if($submitted=="true")
{
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag1"=>"2")));
}
var_dump($d);
?>
