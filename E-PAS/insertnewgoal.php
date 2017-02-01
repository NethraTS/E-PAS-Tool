<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$dc = $db->goal_definition;
$goal=strtoupper($_GET['goal']);
$def=strtoupper($_GET['def']);
$defaultText=strtoupper($_GET['defaultText']);
$div=$_GET['div'];
$goal=trim($goal);
$def=trim($def);

$allgoal=$dc->find(array('goal'=>$goal));

if($allgoal->count()==0)
{
  $document=array(
	"goal"=>$goal
	);
  $dc->insert($document);
  if($div!="")
  {
  $dc->update(array('goal'=> $goal), array('$push' => array('definition' =>array('name'=>$def,'defaultText'=>$defaultText,'category'=>$div))));
  }
  else{
	$dc->update(array('goal'=> $goal), array('$push' => array('definition' =>array('name'=>$def,'defaultText'=>$defaultText))));	  	
  }
}
else if($allgoal->count()>0)
{
	if($div!=""){
	$dc->update(array('goal'=> $goal), array('$push' => array('definition' =>array('name'=>$def,'defaultText'=>$defaultText,'category'=>$div))));
	}
  else{
	$dc->update(array('goal'=> $goal), array('$push' => array('definition' =>array('name'=>$def,'defaultText'=>$defaultText))));	  	
  }
}
echo "inserted successfully";	
?>