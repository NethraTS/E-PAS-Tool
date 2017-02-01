<?php 
include 'secure.php';
$con = new Mongo;
$db = $con->AppraisalManagement1;
$c = $db->selectCollection('currentReviewCycle');
$cate = $_REQUEST["category"];
$r3id=$_REQUEST["r3id"];
?>
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
								  <th>Action</th>
								  </tr>
						  </thead>   
						  <tbody>
<?php
if($cate==="na")
{
$r3doc=$c->find(array("r3id"=>$r3id));
foreach($r3doc as $el)
{
if($el["needAttentionbyR3"]==1)
{
echo '<tr>';
echo '<td>';
echo '<p style="background-color:red;display:inline-block;">'.$el["psiid"].'</p>';
echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>'.decrypt($el["overallselfrating"]).'</td>';
echo '<td>'.$el["r1name"].'</td>'; 
echo '<td>'.decrypt($el["overall R1rating"]).'</td>';
echo '<td>'.$el["r2name"].'</td>';

if($el["flag2"]>"6" && decrypt($el["overall R3rating"]) != "")	
echo '<td>'.decrypt($el["overall R3rating"]).'</td>';
else 
echo '<td>'.decrypt($el["overall R2rating"]).'</td>';

echo '<td>'.decrypt($el["normalisedRating"]).'</td>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R3proposedAction"]["newPosition"].'</td>';
elseif($el["R2proposedAction"]["name"]==="promotion" || $el["R2proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R2proposedAction"]["newPosition"].'</td>';
else 
echo '<td>-</td>';

echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i> Review</button></td>';
echo '</tr>';
}
}
}
elseif($cate==="pp")
{
$r3doc=$c->find(array("r3id"=>$r3id));
foreach($r3doc as $el)
{
if($el["postponedFlag"]>=1)	
{
echo '<tr>';
echo '<td>';
echo '<p style="background-color:pink;display:inline-block;">'.$el["psiid"].'</p>';
echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>Postponed</td>';
echo '<td>'.$el["r1name"].'</td>'; 
echo '<td>-</td>';
echo '<td>'.$el["r2name"].'</td>';
echo '<td>-</td>';
echo '<td>-</td>';
echo '<td>-</td>';
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i>View</button></td>';
echo '</tr>';
}
}	
}
elseif($cate==="pr")
{
$r3doc=$c->find(array("r3id"=>$r3id));
foreach($r3doc as $el)
{
if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
{
echo '<tr>';
echo '<td>';
if($el["R3proposedAction"]["name"]==="promotion")
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R3proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';

echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>'.decrypt($el["overallselfrating"]).'</td>';
echo '<td>'.$el["r1name"].'</td>'; 
echo '<td>'.decrypt($el["overall R1rating"]).'</td>';
echo '<td>'.$el["r2name"].'</td>';

if($el["flag2"]>"6" && decrypt($el["overall R3rating"]) != "")	
echo '<td>'.decrypt($el["overall R3rating"]).'</td>';
else 
echo '<td>'.decrypt($el["overall R2rating"]).'</td>';

echo '<td>'.decrypt($el["normalisedRating"]).'</td>';
echo '<td>'.$el["R3proposedAction"]["newPosition"].'</td>';
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i>Review</button></td>';
echo '</tr>';
}
elseif($el["R2proposedAction"]["name"]==="promotion" || $el["R2proposedAction"]["name"]==="role_change")	
{
echo '<tr>';
echo '<td>';
if($el["R2proposedAction"]["name"]==="promotion")
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R2proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';

echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>'.decrypt($el["overallselfrating"]).'</td>';
echo '<td>'.$el["r1name"].'</td>'; 
echo '<td>'.decrypt($el["overall R1rating"]).'</td>';
echo '<td>'.$el["r2name"].'</td>';

if($el["flag2"]==="8" && decrypt($el["overall R3rating"]) != "")	
echo '<td>'.decrypt($el["overall R3rating"]).'</td>';
else 
echo '<td>'.decrypt($el["overall R2rating"]).'</td>';

echo '<td>'.decrypt($el["normalisedRating"]).'</td>';
echo '<td>'.$el["R2proposedAction"]["newPosition"].'</td>';
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i>Review</button></td>';
echo '</tr>';
}
}	

}

?>						  
</tbody>	
