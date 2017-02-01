<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$d=$c->findOne(array("psiid"=>$data[0]));

if($d["flag2"]=="6")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("flag2"=>"7")));

$c->update(array("psiid" => $data[0]),array('$set'=>array("overall R3rating"=>encrypt($data[1]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("r3 feedback"=>encrypt($data[2]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("R3proposedAction"=>array(
"name"=>$data[3],
"category"=>$data[4],
"newPosition"=>$data[5],
"comments"=>$data[6]))));

$r3rating=$data[1];
if(strpos($r3rating,"E-")===0)
$r3N="E-";
elseif(strpos($r3rating,"E+")===0)
$r3N="E+";
elseif(strpos($r3rating,"E ")===0)
$r3N="E";
elseif($r3rating=="X")
$r3N="X";

if($r3N=="")
{}
else 
$d=$c->update(array("psiid"=>$data[0]),array('$set'=>array(
"normalisedRating"=>encrypt($r3N))));

}
elseif($d["flag2"]=="7")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("overall R3rating"=>encrypt($data[1]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("r3 feedback"=>encrypt($data[2]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("R3proposedAction"=>array(
"name"=>$data[3],
"category"=>$data[4],
"newPosition"=>$data[5],
"comments"=>$data[6]))));

$r3rating=$data[1];
if(strpos($r3rating,"E-")===0)
$r3N="E-";
elseif(strpos($r3rating,"E+")===0)
$r3N="E+";
elseif(strpos($r3rating,"E ")===0)
$r3N="E";
elseif($r3rating=="X")
$r3N="X";

if($r3N=="")
{}
else 
$d=$c->update(array("psiid"=>$data[0]),array('$set'=>array(
"normalisedRating"=>encrypt($r3N))));

}
elseif($d["flag2"]=="8")
{
echo("already submitted");
} 
print_r($data);

?>
