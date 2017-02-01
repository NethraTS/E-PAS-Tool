<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$d=$c->findOne(array("psiid"=>$data[0]));
var_dump($d["flag1"]);

if($d["flag1"]=="0")
{
$d=$c->findOne(array("psiid"=>$data[0]));

//update selfratings 

$d=$c->update(array("psiid"=>$data[0]),array('$set'=>array("selfRatings"=>array(
"deliverables"=>encrypt($data[1]),
"quality"=>encrypt($data[2]),
"competency"=>encrypt($data[3]),
"organisationalContribution"=>encrypt($data[4]),
"valueAddition"=>encrypt($data[5])))));

array_splice($data,1,5);  //remove selfratings from array

$length=count($data);
$forlooplimit=intval(ceil($length/3));
 $x=1;
 $dc=1;
 $qc=1;
 $cc=1;
 $occ=1;
 $vac=1;

//store the goals and accomplishemnts for each category

for($i=1;$i<$forlooplimit;$i++)
{
if(strpos($data[$x],"d")===0)
	{
		if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
	$newdata = array("appraisal"=> array(
		"parameter" => "deliverables",
		"cnt"=>$dc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$dc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"q")===0)
	{
	if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "quality",
		"cnt"=>$qc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$qc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"c")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "competency",
		"cnt"=>$cc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$cc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"oc")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
	$newdata = array("appraisal"=> array(
		"parameter" => "organisational contribution",
		"cnt"=>$occ,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$occ++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
}
if(strpos($data[$x],"va")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "value addition",
		"cnt"=>$vac,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$vac++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
}
}
//set array flag to 1
$c->update(array("psiid"=>$data[0]),array('$set'=>array("flag1"=>"1")));
}
elseif($d["flag1"]=="1")
{
$d=$c->findOne(array("psiid"=>$data[0]));

//update selfratings 
$c->update(array("psiid"=>$data[0]),array('$unset'=>array("selfRatings"=>array())));

$c->update(array("psiid"=>$data[0]),array('$set'=>array("selfRatings"=>array(
"deliverables"=>encrypt($data[1]),
"quality"=>encrypt($data[2]),
"competency"=>encrypt($data[3]),
"organisationalContribution"=>encrypt($data[4]),
"valueAddition"=>encrypt($data[5])))));

array_splice($data,1,5);  //remove selfratings from array

$length=count($data);
$forlooplimit=ceil($length/3);
 $x=1;
 $dc=1;
 $qc=1;
 $cc=1;
 $occ=1;
 $vac=1;

$newdata = array("appraisal"=> array());
$doc=$c->update(array("psiid" =>$data[0]),array('$unset'=>$newdata));	

for($i=1;$i<$forlooplimit;$i++)
{
if(strpos($data[$x],"d")===0)
	{
		if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
	$newdata = array("appraisal"=> array(
		"parameter" => "deliverables",
		"cnt"=>$dc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$dc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"q")===0)
	{
	if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "quality",
		"cnt"=>$qc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$qc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"c")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "competency",
		"cnt"=>$cc,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$cc++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
	}
if(strpos($data[$x],"oc")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
	$newdata = array("appraisal"=> array(
		"parameter" => "organisational contribution",
		"cnt"=>$occ,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$occ++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
}
if(strpos($data[$x],"va")===0)
	{
if(empty($data[$x+1]) && empty($data[$x+2]))
		{
			$x=$x+3;
			}
			else {		
		$newdata = array("appraisal"=> array(
		"parameter" => "value addition",
		"cnt"=>$vac,
		"goal"=>encrypt($data[++$x]),
		"accomplishment"=>encrypt($data[++$x])
	));
	++$x;
	$vac++;
	$c->update(array("psiid" => $data[0]),array('$addToSet'=>$newdata));
	}
}
}
}
elseif($d["flag1"]=="2")
{
if($d["flag2"]=="2" && $d["mailsent"]=="0")
{
$r1=$bd->findOne(array("name"=>$d["r1name"]));
$en=$bd->findOne(array("psiid"=>$data[0]));
$empname=$en["name"];
$mailid=$r1["emailID"];
$subject="Self-Apprasial submitted-".$empname;
$msg=$empname." has completed the self-appraisal form. You can now schedule a meeting and do the review";
if(mail($mailID,$subject,$msg))
$c->update(array("psiid"=>$data[0]),array('$set'=>array("mailsent"=>"1")));
}
} 


?>

