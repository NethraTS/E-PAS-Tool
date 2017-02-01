<?php 
include 'secure.php';
$con = new Mongo();
$db = $con->goals1;
$c = $db->currentGoalCycle;
$goal =$_GET["goal"];
$id123=$_GET["id"];
//$goal=trim($goal);
//$id123=trim($id123);
//echo $goal;
//echo $id123;

if($goal=="Organizational/ Project Contribution")
{
$goal="OrgContribution";	
	}
if($goal=="Strategic Planning /Value Addition")
{
$goal="ValueAddition";	
	}
	if($goal=="Initiatives/ Ownership")
{
$goal="Competency";	
	}
//$id123="666";
//$goal="Deliverables";
echo '<select class="static-form-control" id="def1">';
echo '<option selected disabled>Select a definition</option>';

$cursor = $c->find(array("id"=>$id123)); 
foreach ($cursor as $val) {
	
	foreach($val[$goal] as $val1)
	{
	echo '<option>'.decrypt($val1['msrmt']); 
  	 
  	echo '</option>';
}
}
echo '</select>';
//echo "first line";
?>