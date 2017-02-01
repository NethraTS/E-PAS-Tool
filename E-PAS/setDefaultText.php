<?php
$defName=$_POST['val'];
$con = new Mongo;
$db = $con->goals1;
$c = $db->goal_definition;

 $cursor = $c->findOne(array("definition.name"=>$defName));

foreach($cursor as $key => $v)
{
foreach($v as $v1)
{
	if($v1['name']==$defName)
	{
		echo $v1['defaultText'];
	}
}
}