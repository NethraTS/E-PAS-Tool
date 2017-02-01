<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$dc = $db->selectCollection('gradesandweights');
$db1=$m->AppraisalManagement1;
$desg=$db1->designationCategories;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);


$length=count($data);
$forlooplimit=intval(ceil($length/7));
$x=1;
$dc->update(array("category"=>$data[0]),array('$unset'=>array("gradeweights"=>array()))); 

for($j=1;$j<$forlooplimit;$j++)
{																	
	$dc->update(array("category"=>$data[0]),array('$addToSet'=>array("gradeweights"=>array( 
				"grade"=>$data[$x],
				"Deli"=>$data[$x+1],
				"Qual"=>$data[$x+2],
				"Comp"=>$data[$x+3],
				"OrgCont"=>$data[$x+4],
				"ValAdd"=>$data[$x+5],
				"Total"=>$data[$x+6]))));
					$x=$x+7;
	$dc->update(array("category"=>$data[0]),array('$set'=>array('flag'=>"2")));
}
?>
