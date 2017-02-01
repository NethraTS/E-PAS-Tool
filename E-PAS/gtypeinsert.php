<?php 
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$gc = $db->selectCollection('gradesandweights');

$eid=$_POST['id'];
$gtype=$_POST['gtype'];
//$eid="888";
//$gtype="Quarterly";


$doc=$c->findOne(array("id"=>$eid));
if($doc['flag']==0||$doc['flag']==1)
{
$desgn=$doc["desgn"];
$gaw=$gc->find();
$rolewts=array();


{
foreach($gaw as $gradedoc)
{
	foreach($gradedoc["roleweights"] as $k=>$v)
	{
		if($desgn == $k)
			{
			$grade=$v;
			$i=0;
			while($i< count($gradedoc["gradeweights"]))
			{							
				if($gradedoc["gradeweights"][$i]["grade"]==$grade)
				{
					//var_dump($gradedoc["gradeweights"][$i]);
					$rolewts["del"]=$gradedoc["gradeweights"][$i]["Deli"];
					$rolewts["qual"]=$gradedoc["gradeweights"][$i]["Qual"];
					$rolewts["comp"]=$gradedoc["gradeweights"][$i]["Comp"];
					$rolewts["orgcont"]=$gradedoc["gradeweights"][$i]["OrgCont"];
					$rolewts["valadd"]=$gradedoc["gradeweights"][$i]["ValAdd"];
					$rolewts["total"]=$gradedoc["gradeweights"][$i]["Total"];
					goto en;
				}
				else $i++;
			}
		}			
	}
}
}

en:
//echo $grade;
//var_dump($rolewts);

if($gtype=="Quarterly")
{
	//echo date("M");
	
	if(date("M")=="Apr"||date("M")=="Jun"||date("M")=="May")
	{
		$gName="Q1";
		//echo date("M");
	}	
	elseif(date("M")=="Jul"||date("M")=="Aug"||date("M")=="Sep")
{	
		$gName="Q2";	
}
	elseif(date("M")=="Oct"||date("M")=="Nov"||date("M")=="Dec")
{
		$gName="Q3";	
}
	elseif(date("M")=="Jan"||date("M")=="Feb"||date("M")=="Mar")
{
		$gName="Q4";	
}	
	$rolewts["del"]=intval($rolewts["del"]);	
	$rolewts["qual"]=intval($rolewts["qual"]);	
	$rolewts["comp"]=intval($rolewts["comp"]);	
	$rolewts["orgcont"]=intval($rolewts["orgcont"]);	
	$rolewts["valadd"]=intval($rolewts["valadd"]);	
	$rolewts["total"]=intval($rolewts["total"]);	
	
}
elseif($gtype=="Half-Yearly")
{
	if(date("m")>=4&&date("m")<=9)
		$gName="H1";
	elseif((date("m")>=10)||(date("m")>=1&&date("m")<=3))
		$gName="H2";	
		
	$rolewts["del"]=intval($rolewts["del"]);	
	$rolewts["qual"]=intval($rolewts["qual"]);	
	$rolewts["comp"]=intval($rolewts["comp"]);	
	$rolewts["orgcont"]=intval($rolewts["orgcont"]);	
	$rolewts["valadd"]=intval($rolewts["valadd"]);	
	$rolewts["total"]=intval($rolewts["total"]);		
}
elseif($gtype=="Annual")
{
	//if(date("m")>=4&&date("m")<=3)
		$gName="A";

	$rolewts["del"]=intval($rolewts["del"]);	
	$rolewts["qual"]=intval($rolewts["qual"]);	
	$rolewts["comp"]=intval($rolewts["comp"]);	
	$rolewts["orgcont"]=intval($rolewts["orgcont"]);	
	$rolewts["valadd"]=intval($rolewts["valadd"]);	
	$rolewts["total"]=intval($rolewts["total"]);				
}

if($doc["flag"]<"1")
{
	
$c->update(array("id"=>$eid),array('$set'=>array(
		"gType"=>$gtype,
		"gYear"=>date("Y"),
		"gName"=>$gName,
		"gWts"=>array( 
					"del"=>$rolewts["del"],
					"qual"=>$rolewts["qual"],
					"comp"=>$rolewts["comp"],
					"orgcont"=>$rolewts["orgcont"],
					"valadd"=>$rolewts["valadd"],
					"total"=>$rolewts["total"],	
					"delhr"=>$rolewts["del"],
					"qualhr"=>$rolewts["qual"],
					"comphr"=>$rolewts["comp"],
					"orgconthr"=>$rolewts["orgcont"],
					"valaddhr"=>$rolewts["valadd"],
										
					))));
	$c->update(array("id"=>$eid),array('$set'=>array(

		"gWtshr"=>array( 
					"delhr"=>$rolewts["del"],
					"qualhr"=>$rolewts["qual"],
					"comphr"=>$rolewts["comp"],
					"orgconthr"=>$rolewts["orgcont"],
					"valaddhr"=>$rolewts["valadd"],
										
					))));				
echo("1");
}
if($doc["flag"]=="1")
{
	
$c->update(array("id"=>$eid),array('$set'=>array(
		"gType"=>$gtype,
		"gYear"=>date("Y"),
		"gName"=>$gName,
		"gWtshr"=>array( 
					
					"delhr"=>$rolewts["del"],
					"qualhr"=>$rolewts["qual"],
					"comphr"=>$rolewts["comp"],
					"orgconthr"=>$rolewts["orgcont"],
					"valaddhr"=>$rolewts["valadd"],
										
					))));
	$c->update(array("id"=>$eid),array('$set'=>array(

		"gWtshr"=>array( 
					"delhr"=>$rolewts["del"],
					"qualhr"=>$rolewts["qual"],
					"comphr"=>$rolewts["comp"],
					"orgconthr"=>$rolewts["orgcont"],
					"valaddhr"=>$rolewts["valadd"],
										
					))));				
echo("1");
}
elseif($doc["flag"]=="2")
{
echo("2");
}
}
?>
