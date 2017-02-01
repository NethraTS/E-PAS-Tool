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
$cursor=$dc->find(array('category'=>$data[0]));
if($cursor->count()==0)
{
 $dc->insert(array("category"=>$data[0],"flag"=>"0"));	
}

$doc=$dc->findOne(array("category"=>$data[0]));
//var_dump($doc);



$length=count($data);
$forlooplimit=intval(ceil($length/2));

$x=1;
$tobeinserted=array();
$grades=array();

for($j=1;$j<$forlooplimit;$j++)
{
$tobeinserted[ucwords(trim($data[$x]))]=strtoupper($data[$x+1]);
array_push($grades,strtoupper($data[$x+1]));
$x=$x+2;	
}
//var_dump($tobeinserted);

$grades=array_unique($grades);
//var_dump($grades);

$dc->update(array("category"=>$data[0]),array('$set'=>array("roleweights"=>$tobeinserted,"flag"=>"1")));
$dc->update(array("category"=>$data[0]),array('$unset'=>array("grades"=>"")));

foreach($grades as $k=>$v)
		{
			$res=$dc->update(array("category"=>$data[0]),array('$addToSet'=>array("grades"=>$v)));
		} 

unset($grades);
unset($tobeinserted);

?>
