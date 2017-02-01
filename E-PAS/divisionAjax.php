<?php

$m=new MongoClient();
$db=$m->goals1;
$goalDefCursor=$db->goal_definition;
$division= $_REQUEST['v'];
$goal=$_REQUEST['goal'];
//echo $goal;
$cursor=$goalDefCursor->find(array("goal"=>$goal));
$divString="";
$divOutter=array();

foreach($cursor as $v)
{
	//var_dump($v);
	$divArray=array();
	foreach($v['definition'] as $val)
	{
		if($val['category']==$division)
		{
			array_push($divArray,$val['name']);
		}
		
		//$divString .=$val['name'].",";
		//$divArray=array_push($divArray,$val['name'])
	}
	echo json_encode($divArray);
	//var_dump($divArray);
}
//echo rtrim($divString,",");
?>
