<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$submitted = $_POST['sub'];
$id=$_POST['id'];
//$id="888";
$submitted="true";

if($submitted=="true")
{
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag2"=>"8")));
//$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag1"=>"8")));	

$doc=$c->findOne(array("psiid"=>$id));
$r3rating=decrypt($doc["overall R3rating"]);



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
$d=$c->update(array("psiid"=>$id),array('$set'=>array(
"normalisedRating"=>encrypt($r3N))));

//$res=$c->findOne(array("psiid"=>$id));

//print_r($res);
}

?>
