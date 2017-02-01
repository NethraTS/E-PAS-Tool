<?php 
ob_start();
session_start();include session_timeout.php;
include 'secure.php';
?>
<html>
<body>
          		<table class="table yui" id="tablepaging" align="center">

					  <thead>
							  <tr>
							     <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  <th>Self-Appraisal</th>
								  <th>R1 name</th>
								  <th>R1 Rating</th>
								  <th>R2 name</th>
								  <th>R2 Rating</th>
								  <th>Normalised Rating</th>
								  <th>Promotion Suggestion/ Role Change</th>
								  </tr>
						  </thead>   
						  <tbody>

<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$psiid=$_SESSION["psiid"];

$r3doc=$c->find(array("r3id"=>$psiid));
//var_dump($psiid);
foreach($r3doc as $el)
{
echo '<tr>';
echo '<td>';
echo '<p>'.$el["psiid"].'</p>';
echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
if($el["flag1"]>="2" && $el["flag2"]>="2")
	echo '<td>'.decrypt($el["overallselfrating"]).'</td>';
else 
	{
	if($el["postponedFlag"]>="1")	
		echo '<td>postponed</td>';
	else 
	   echo '<td>pending</td>';
	}
	
echo '<td>'.$el["r1name"].'</td>';

if($el["flag1"]>="4" && $el["flag2"]>="4")
	echo '<td>'.decrypt($el["overall R1rating"]).'</td>';
else 
	echo '<td>-</td>';

echo '<td>'.$el["r2name"].'</td>';
if($el["flag2"]>="6")
{
if($el["flag2"]>"6" && decrypt($el["overall R3rating"]) != "")	
echo '<td>'.decrypt($el["overall R3rating"]).'</td>';
else 
echo '<td>'.decrypt($el["overall R2rating"]).'</td>';
}
else 
	echo '<td>-</td>';

echo '<td>'.decrypt($el["normalisedRating"]).'</td>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R3proposedAction"]["newPosition"].'</td>';
elseif($el["R2proposedAction"]["name"]==="promotion" || $el["R2proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R2proposedAction"]["newPosition"].'</td>';
else 
echo '<td>-</td>';

echo '</tr>';
} 
?>
					  </tbody>
					  </table>  

</body>
</html>


<?php
$today=date("d-m-Y");
$name="reviewlist/".$today.".xls";
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$name);
?>
