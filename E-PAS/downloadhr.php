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
							     <th>EMP-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  <th>R1 name</th>
								  <th>R2 name</th>
								  <th>R3 name</th>
								  <th>Normalised Rating</th>
								  <th>Promotion / Role Change</th>
								  </tr>
						  </thead>   
						  <tbody>

<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

$r3doc=$c->find();
foreach($r3doc as $el)
{
echo '<tr>';

echo '<td>';

if($el["postponedFlag"]>="1")
echo '<p style="background-color:pink;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R3proposedAction"]["name"]==="promotion")	
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R3proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R2proposedAction"]["name"]==="promotion")	
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R2proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';
else 
echo '<p>'.$el["psiid"].'</p>';

echo '</td>';


echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>'.$el["r1name"].'</td>';
echo '<td>'.$el["r2name"].'</td>';
echo '<td>'.$el["r3name"].'</td>';

if($el["postpnedFlag"]>="1")
echo '<td>Postponed</td>';
elseif($el["flag2"]<"8")
echo '<td>Pending</td>';
else
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
