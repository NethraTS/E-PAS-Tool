<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$c1=$db->currentGoalCycle;
$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);
//echo "adfadsf";
$doc=$c->findOne(array("id"=>$data[0]));
//echo $doc["rFlag"];
if($doc["rFlag"]=="2")
{		
 	//update Accomplished wts into record
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("AccWeightage"=>array(
		"deliverables"=>encrypt($data[1]),
		"quality"=>encrypt($data[2]),
		"competency"=>encrypt($data[3]),
		"organisationalContribution"=>encrypt($data[4]),
		"valueAddition"=>encrypt($data[5])))));
		
		//update total accomplished wt and reviewer 1 feedback
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("totalAccWt"=>encrypt($data[6]),
		"r1feedback"=>encrypt($data[7]))));
	
	array_splice($data,1,7);  //remove weights and the feedback from array	
		//var_dump($data);
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
 	$x=1;
 	$dc=1;
 	$qc=1;
 	$cc=1;
 	$occ=1;
 	$vac=1;
	
	//store the measurements and descriptions for each category
	for($i=1;$i<$forlooplimit;$i++)
	{
		if(strpos($data[$x],"d")===0)
		{
			$newdata1=array('$set'=>array('Deliverables.$.r1comment' =>encrypt($data[$x+1]),
													  'Deliverables.$.status' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Deliverables" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"q")===0)
		{
			$newdata1=array('$set'=>array('Quality.$.r1comment' =>encrypt($data[$x+1]),
													  'Quality.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"Quality" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		
		}
		if(strpos($data[$x],"c")===0)
		{
			$newdata1=array('$set'=>array('Competency.$.r1comment' =>encrypt($data[$x+1]),
													  'Competency.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"Competency" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;		
		}
		if(strpos($data[$x],"oc")===0)
		{
			$newdata1=array('$set'=>array('OrgContribution.$.r1comment' =>encrypt($data[$x+1]),
													  'OrgContribution.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"OrgContribution" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"va")===0)
		{
			$newdata1=array('$set'=>array('ValueAddition.$.r1comment' =>encrypt($data[$x+1]),
													  'ValueAddition.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"ValueAddition" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;	
		}
	}
	$c->update(array("id"=>$data[0]),array('$set'=>array("rFlag"=>"3")));
	$c->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"6")));
	$c1->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"6")));
}
elseif($doc["rFlag"]=="3")
{	//update Accomplished wts into record
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("AccWeightage"=>array(
		"deliverables"=>encrypt($data[1]),
		"quality"=>encrypt($data[2]),
		"competency"=>encrypt($data[3]),
		"organisationalContribution"=>encrypt($data[4]),
		"valueAddition"=>encrypt($data[5])))));
		
		//update total accomplished wt and reviewer 1 feedback
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("totalAccWt"=>encrypt($data[6]),
		"r1feedback"=>encrypt($data[7]))));
	
	array_splice($data,1,7);  //remove weights and the feedback from array	
		//var_dump($data);
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
 	$x=1;
 	$dc=1;
 	$qc=1;
 	$cc=1;
 	$occ=1;
 	$vac=1;
	
	//store the measurements and descriptions for each category
	for($i=1;$i<$forlooplimit;$i++)
	{
		if(strpos($data[$x],"d")===0)
		{
			$newdata1=array('$set'=>array('Deliverables.$.r1comment' =>encrypt($data[$x+1]),
													  'Deliverables.$.status' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Deliverables" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"q")===0)
		{
			$newdata1=array('$set'=>array('Quality.$.r1comment' =>encrypt($data[$x+1]),
													  'Quality.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"Quality" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		
		}
		if(strpos($data[$x],"c")===0)
		{
			$newdata1=array('$set'=>array('Competency.$.r1comment' =>encrypt($data[$x+1]),
													  'Competency.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"Competency" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;		
		}
		if(strpos($data[$x],"oc")===0)
		{
			$newdata1=array('$set'=>array('OrgContribution.$.r1comment' =>encrypt($data[$x+1]),
													  'OrgContribution.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"OrgContribution" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"va")===0)
		{
			$newdata1=array('$set'=>array('ValueAddition.$.r1comment' =>encrypt($data[$x+1]),
													  'ValueAddition.$.status' =>encrypt($data[$x+2])));
			$c->update(array(
				"id" => $data[0],
				"ValueAddition" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;	
		}
	}
	//$c->update(array("id"=>$data[0]),array('$set'=>array("rFlag"=>"3")));
	}
else if($doc["flag"]>="4")
{
echo("already Submitted.");
}

?>