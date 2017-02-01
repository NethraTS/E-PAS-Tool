<?php
session_start();include session_timeout.php;
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$d=$c->findOne(array("psiid"=>$data[0]));

if($d["flag1"]==="2")
{
$d=$c->findOne(array("psiid"=>$data[0]));
	
//update reviewer-1 ratings 

$d=$c->update(array("psiid"=>$data[0]),array('$set'=>array("reviewer1Ratings"=>array(
"deliverables"=>encrypt($data[1]),
"quality"=>encrypt($data[2]),
"competency"=>encrypt($data[3]),
"organisationalContribution"=>encrypt($data[4]),
"valueAddition"=>encrypt($data[5])))));
$emp=0;
for($i=1;$i<=5;$i++)
{
if(empty($data[$i]))
$emp++;
}

array_splice($data,1,5-$emp);  //remove selfratings from array
var_dump($data); 	
}
?>
