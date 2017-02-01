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
	
$length=count($data);
$forlooplimit=ceil($length/3);
$x=1;

//var_dump($data); 

//store the reviewer-1 comments for each goal

for($i=1;$i<$forlooplimit;$i++)
{
if(strpos($data[$x],"d")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"deliverables", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"q")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"quality", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"c")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"competency", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"oc")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"organisational contribution", "cnt"=>intval(substr($data[$x],2))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"va")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"value addition", "cnt"=>intval(substr($data[$x],2))))),$newdata1);
$x=$x+3;
}
}
$c->update(array("psiid" => $data[0]),array('$set'=>array("flag1"=>"3")));	
}
elseif($d["flag1"]==="3")
{
$d=$c->findOne(array("psiid"=>$data[0]));
	
//update reviewer-1 ratings 
$c->update(array("psiid"=>$data[0]),array('$unset'=>array("reviewer1Ratings"=>array())));

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

	
$length=count($data);
$forlooplimit=ceil($length/3);
$x=1;

 //update the reviewer-1 comments for each goal
 
for($i=1;$i<$forlooplimit;$i++)
{
if(strpos($data[$x],"d")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"deliverables", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"q")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"quality", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"c")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"competency", "cnt"=>intval(substr($data[$x],1))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"oc")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"organisational contribution", "cnt"=>intval(substr($data[$x],2))))),$newdata1);
$x=$x+3;
}
elseif(strpos($data[$x],"va")===0)
{
$newdata1=array('$set'=>array('appraisal.$.reviewer1comment' =>encrypt($data[$x+2])));	
$c->update(array(
"psiid" => $data[0],
"appraisal" => array(
'$elemMatch'=>array("parameter"=>"value addition", "cnt"=>intval(substr($data[$x],2))))),$newdata1);
$x=$x+3;
}
}
}
elseif($d["flag1"]=="4")
{
echo("submitted");	
}
?>
