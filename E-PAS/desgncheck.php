<?php 
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$gc = $db->selectCollection('gradesandweights');

$eid=$_POST['id'];


//$eid="809";
$doc=$c->findOne(array("id"=>$eid));


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
					$a=$gradedoc["gradeweights"][$i]["Deli"];
					$b=$gradedoc["gradeweights"][$i]["Qual"];
					$c=$gradedoc["gradeweights"][$i]["Comp"];
					$d=$gradedoc["gradeweights"][$i]["OrgCont"];
					$e=$gradedoc["gradeweights"][$i]["ValAdd"];
					
					goto en;
				}
				else $i++;
			}
		}			
	}
}
}

en:
if($a>0) {echo "1";}
else if($a<=0||$a=="") {echo "0";}

//echo $grade;
//var_dump($rolewts);


?>