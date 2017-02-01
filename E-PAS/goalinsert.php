<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);

$doc=$c->findOne(array("id"=>$data[0]));

if($doc["flag"]=="0"||$doc["flag"]=="1")
{	  
  //var_dump($data);
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
 $x=6;
 	$dc=1;
 	$qc=1;
 	$cc=1;
 	$occ=1;
 	$vac=1;
 	$tac=1;
	
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Deliverables"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Quality"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Competency"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("OrgContribution"=>"")));
	$c->update(array("id"=>$data[0]),array('$unset'=>array("ValueAddition"=>"")));
		$c->update(array("id"=>$data[0]),array('$unset'=>array("training"=>"")));
	$c->update(array("id"=>$data[0]),array('$set'=>array("gWts"=>array("del"=>$data[1],"qual"=>$data[2],"comp"=>$data[3],"orgcont"=>$data[4],"valadd"=>$data[5]))));
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
			));
				++$x;
				$vac++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
		if(strpos($data[$x],"t")===0)
		{
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("training"=> array(
					"cnt"=>$tac,
					"train"=>encrypt($data[++$x]),
					"traindate"=>($data[++$x]),
					"train-quater"=>($data[++$x])
					
			));
				++$x;
				$tac++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
			}
		}
	}
	
	$c->update(array("id"=>$data[0]),array('$set'=>array("flag"=>"1")));
}
elseif($doc["flag"]=="2")
{
	$c->update(array("id"=>$data[0]),array('$unset'=>array("Weightage"=>"")));	
		
	var_dump($data);
	
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
	//echo $forlooplimit;
 	$x=6;
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
	/* update the weightage by r1 */
	
	$c->update(array("id"=>$data[0]),array('$set'=>array("gWts"=>array("del"=>$data[1],"qual"=>$data[2],"comp"=>$data[3],"orgcont"=>$data[4],"valadd"=>$data[5]))));
	/*------------------------------*/
	
	
	
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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
					"descr"=>encrypt($data[++$x]),
					"defgoal"=>encrypt($data[++$x])
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