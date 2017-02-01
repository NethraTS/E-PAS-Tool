<?php 
$con = new Mongo;
$db = $con->goals1;
$db1 = $con->AppraisalManagement1;
$desgCate = $db1->selectCollection('designationCategories');
$c = $db->selectCollection('gradesandweights');
$cate = $_REQUEST["category"];

?>
		           <thead>
							<tr>
                        <th>Grade</th>
                        <th>Deliverables-Wt</th>
                        <th>Quality-Wt</th>
                        <th>Competency-Wt</th>
                        <th>Org. Contribution-Wt</th>
                        <th>Value Addition-Wt</th>
                        <th>Total</th>
                      <!--  <?php 
								$alldocs=$c->find(array("flag"=>"2","category"=>$cate));
								if($alldocs->count()==1)
								{?>
								<th>Edit</th>
								<?php }
								                        
                        ?>        -->                                                                                         
							</tr>		           
		           </thead>
		           <tbody>
		           
<?php 
$doc=$c->findOne(array("category"=>$cate));
$count=count($doc["gradeweights"]);
if($count == 0)
{
	foreach($doc["grades"] as $g)
	{
		echo '<tr id="'.$g.'" class="w">';
		echo '<td style="color:hotpink;font-weight:bold">'.$g.'</td>';
		echo '<td><input class="w" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)"></td>';
		echo '<td><input class="w" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)"></td>';
		echo '<td><input class="w" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)"></td>';
		echo '<td><input class="w" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)"></td>';
		echo '<td><input class="w" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)"></td>';
		echo '<td></td>';
		echo '</tr>';
	}
}
else 
{
	for($i=0;$i< $count; $i++)
	{
		echo '<tr id="'.$doc["gradeweights"][$i]["grade"].'" class="w">';
		echo '<td style="color:hotpink;font-weight:bold">'.$doc["gradeweights"][$i]["grade"].'</td>';
		echo '<td><input class="w disa" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)" value="'.$doc["gradeweights"][$i]["Deli"].'"></td>';
		echo '<td><input class="w disa" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)" value="'.$doc["gradeweights"][$i]["Qual"].'"></td>';
		echo '<td><input class="w disa" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)" value="'.$doc["gradeweights"][$i]["Comp"].'"></td>';
		echo '<td><input class="w disa" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)" value="'.$doc["gradeweights"][$i]["OrgCont"].'"></td>';
		echo '<td><input class="w disa" onblur="selectgrades(this)" onkeypress="return isNumberKey(event)" value="'.$doc["gradeweights"][$i]["ValAdd"].'"></td>';
		echo '<td>'.$doc["gradeweights"][$i]["Total"].'</td>';
	//	echo '<td><button type="button" class="btn btn-theme03 btn-xs" id="'.$i.'" onclick="reviewform1(this)"><i class="fa fa-cog"></i>Edit</button></td>';
		echo '</tr>';
	}
} 
?>
</tbody>

