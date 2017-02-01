<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);

$doc=$c->findOne(array("id"=>$data[0]));

if($doc["flag"]=="0")
{	
  
   //insert weights into the record
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("Weightage"=>array(
		"deliverables"=>encrypt($data[1]),
		"quality"=>encrypt($data[2]),
		"competency"=>encrypt($data[3]),
		"organisationalContribution"=>encrypt($data[4]),
		"valueAddition"=>encrypt($data[5])))));

	array_splice($data,1,5);  //remove weights from array
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
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Deliverables"=> array(
					"cnt"=>$dc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$dc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"q")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Quality"=> array(
					"cnt"=>$qc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$qc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"c")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Competency"=> array(
					"cnt"=>$cc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$cc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"oc")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("OrgContribution"=> array(
					"cnt"=>$occ,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$occ++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"va")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("ValueAddition"=> array(
					"cnt"=>$vac,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$vac++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
	}
	$c->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"1")));
}
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
{
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Weightage"=>"")));	
	
	  //insert weights into the record
	$d=$c->update(array("id"=>$data[0]),array('$set'=>array("Weightage"=>array(
		"deliverables"=>encrypt($data[1]),
		"quality"=>encrypt($data[2]),
		"competency"=>encrypt($data[3]),
		"organisationalContribution"=>encrypt($data[4]),
		"valueAddition"=>encrypt($data[5])))));

	array_splice($data,1,5);  //remove weights from array
	var_dump($data);
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
 	$x=1;
 	$dc=1;
 	$qc=1;
 	$cc=1;
 	$occ=1;
 	$vac=1;
	
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Deliverables"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Quality"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Competency"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("OrgContribution"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("ValueAddition"=>"")));
	
	//store the measurements and descriptions for each category
	for($i=1;$i<$forlooplimit;$i++)
	{
		if(strpos($data[$x],"d")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Deliverables"=> array(
					"cnt"=>$dc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$dc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"q")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Quality"=> array(
					"cnt"=>$qc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$qc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"c")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("Competency"=> array(
					"cnt"=>$cc,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$cc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"oc")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("OrgContribution"=> array(
					"cnt"=>$occ,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$occ++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"va")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("ValueAddition"=> array(
					"cnt"=>$vac,
					"msrmt"=>encrypt($data[++$x]),
					"descr"=>encrypt($data[++$x])
			));
				++$x;
				$vac++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
	}
}
else if($doc["flag"]>="3")
{
echo("already Accepted.");
}

?>