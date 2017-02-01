<?php 
session_start();include session_timeout.php;
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$c1=$db->currentGoalCycle;
$id=$_GET['id'];
//$id="1069";
//$timestamp=date("d-m-Y H:i:s");
$doc=$c->find(array("id"=>$id));
echo '<br>';
foreach($doc as $docs)
if($docs['r1overallcomment']=="")
{
echo "No Feebacks Entered";	break;
	}
	else 
	{
foreach($docs['r1overallcomment'] as $v1)							
							{
								$b[]=$v1["date"];
							}										
							$a[]=(array_unique($b));
							(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{
echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 
foreach($doc as $v)
{
foreach($v['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date'])
	{

echo '<br><b>Goal</b> : '.$v1['goal']; 
echo '<br><b>Definition</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
		
		}
}
}
echo '</li>';
//var_dump($doc['r1overallcomment']);
}
}

/*
foreach($doc as $v)
{
foreach($v['r1overallcomment'] as $v1)
{
echo '<li class="list-group-item">';
echo '<b>'.$v1['date'].'</b><br>'; 
echo '<br><b>Goal</b> : '.$v1['goal']; 
echo '<br><b>Definition</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '</li>';
}
}*/
?>