<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$d=$c->findOne(array("psiid"=>$data[0]));

if($d["flag2"]=="4")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("flag2"=>"5")));

$c->update(array("psiid" => $data[0]),array('$set'=>array("overall R2rating"=>encrypt($data[1]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("r2 feedback"=>encrypt($data[2]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("R2proposedAction"=>array(
"name"=>$data[3],
"category"=>$data[4],
"newPosition"=>$data[5],
"comments"=>$data[6]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("needAttentionbyR3"=>$data[7])));
}
elseif($d["flag2"]=="5")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("overall R2rating"=>encrypt($data[1]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("r2 feedback"=>encrypt($data[2]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("R2proposedAction"=>array(
"name"=>$data[3],
"category"=>$data[4],
"newPosition"=>$data[5],
"comments"=>$data[6]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("needAttentionbyR3"=>$data[7])));
}
elseif($d["flag2"]=="6")
{
echo("already submitted");
} 
print_r($data);

?>
