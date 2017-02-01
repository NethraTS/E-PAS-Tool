<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$c1=$db->currentGoalCycle;
$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$doc=$c->findOne(array("id"=>$data[0]));

if($doc["rFlag"]=="0")
{		
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
			$newdata1=array('$set'=>array('Deliverables.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Deliverables" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"q")===0)
		{
			$newdata1=array('$set'=>array('Quality.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Quality" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		
		}
		if(strpos($data[$x],"c")===0)
		{
			$newdata1=array('$set'=>array('Competency.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Competency" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;		
		}
		if(strpos($data[$x],"oc")===0)
		{
			$newdata1=array('$set'=>array('OrgContribution.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"OrgContribution" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"va")===0)
		{
			$newdata1=array('$set'=>array('ValueAddition.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"ValueAddition" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;	
		}
		if(strpos($data[$x],"t")===0)
		{
			$newdata1=array('$set'=>array('training.$.traindate' =>($data[$x+1])));	
			$c->update(array(
				"id" => $data[0],
				"training" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+2;	
		}
	}
	$c->update(array("id"=>$data[0]),array('$set'=>array("rFlag"=>"1")));
	$c->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"4")));
	$c1->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"4")));
}
elseif($doc["rFlag"]=="1")
{		
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
			$newdata1=array('$set'=>array('Deliverables.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Deliverables" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"q")===0)
		{
			$newdata1=array('$set'=>array('Quality.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Quality" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;
		
		}
		if(strpos($data[$x],"c")===0)
		{
			$newdata1=array('$set'=>array('Competency.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"Competency" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+3;		
		}
		if(strpos($data[$x],"oc")===0)
		{
			$newdata1=array('$set'=>array('OrgContribution.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"OrgContribution" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;
		}
		if(strpos($data[$x],"va")===0)
		{
			$newdata1=array('$set'=>array('ValueAddition.$.employeecomment' =>encrypt($data[$x+2])));	
			$c->update(array(
				"id" => $data[0],
				"ValueAddition" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],2))))),$newdata1);
			$x=$x+3;	
		}
		if(strpos($data[$x],"t")===0)
		{
			$newdata1=array('$set'=>array('training.$.traindate' =>($data[$x+1])));	
			$c->update(array(
				"id" => $data[0],
				"training" => array(
				'$elemMatch'=>array("cnt"=>intval(substr($data[$x],1))))),$newdata1);
			$x=$x+2;	
		}
	}
//$c->update(array("id"=>$data[0]),array('$set'=>array("rFlag"=>"2")));
}
else if($doc["flag"]>="3")
{
echo("already Accepted.");
}

?>