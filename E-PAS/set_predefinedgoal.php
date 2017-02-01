<?php 
$con = new Mongo;
$db = $con->goals1;
$c = $db->selectCollection('gradesandweights');
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
	echo '<tr class="rows">';
	echo '<td>'.$a.'</td>';
	echo '<td><input class="uc" value="'.$b.'" onkeypress="return isNumberAlpha(event)"></td>';
	echo '<td><button class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</button></td>';
	echo '</tr>';

?>
</tbody>
