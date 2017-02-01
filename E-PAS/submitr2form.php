<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$submitted = $_POST['sub'];
$id=$_POST['id'];
//$id="541";
//$submitted="true";

if($submitted=="true")
{
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag2"=>"6")));
//$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag1"=>"6")));	

$doc=$c->findOne(array("psiid"=>$id));
$r2rating=decrypt($doc["overall R2rating"]);


if(strpos($r2rating,"E-")===0)
$r2N="E-";
elseif(strpos($r2rating,"E+")===0)
$r2N="E+";
elseif($r2rating=="E low" || $r2rating=="E mid" || $r2rating=="E high")
$r2N="E";
elseif($r2rating=="X")
$r2N="X";

$d=$c->update(array("psiid"=>$id),array('$set'=>array(
"normalisedRating"=>encrypt($r2N))));

//$res=$c->findOne(array("psiid"=>$id));

//print_r($res);
}

?>
