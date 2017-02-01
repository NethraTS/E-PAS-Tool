<?php 
$con = new Mongo;
$db = $con->goals1;
$c = $db->selectCollection('gradesandweights');
$db1=$con->AppraisalManagement1;
$desg=$db1->designationCategories;
$cate = $_REQUEST["category"];
?>
		           <thead>
							<tr>
                        <th>Designation</th>
                        <th>Grade</th>
                        <th></th>
							</tr>		           
		           </thead>
		           <tbody>

		           
<?php
$alldc=$c->find(array('category'=>$cate));
$alldcs=$desg->find(array('category'=>$cate));
if($alldc->count()>0)
{
$doc=$c->findOne(array("category"=>$cate));

foreach($doc["roleweights"] as $a=>$b)
{
	echo '<tr class="rows">';
	echo '<td>'.$a.'</td>';
	echo '<td><input class="uc disa" value="'.$b.'" onkeypress="return isNumberAlpha(event)"></td>';
	echo '<td><button class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</button></td>';
	echo '</tr>';
}
}
else if($alldcs->count()>0)
{
$doc=$desg->findOne(array("category"=>$cate));

foreach($doc["role"] as $a=>$b)
{
	echo '<tr class="rows">';
	echo '<td>'.$b.'</td>';
	echo '<td><input class="uc" value="" onkeypress="return isNumberAlpha(event)"></td>';
	//echo '<td><button class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</button></td>';
	echo '</tr>';
}
	
}
?>
</tbody>
