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
								  <th>Goal Quarter</th>
								  <th>Training 1</th>
								  <th>Training 2</th>
								  <th>Training 3</th>
								  <th>Training 4</th>
								  </tr>
						  </thead>   
						  <tbody>

<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;

$r3doc=$c->find();
foreach($r3doc as $el)
{
echo '<tr>';

echo '<td>';
echo '<p>'.$el["id"].'</p>';
echo '</td>';


echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["desgn"].'</td>';
echo '<td>'.$el["r1name"].'</td>';
echo '<td>'.$el["r2name"].'</td>';
echo '<td>'.$el["gName"].'</td>';

foreach($el["training"] as $d)
{
echo '<td>'.decrypt($d["train"]).'</td>'; //echo "&nbsp&nbsp";echo "&nbsp&nbsp";

}


echo '</tr>';
} 
?>
					  </tbody>
					  </table>  
</body>
</html>


<?php
$today=date("d-m-Y");
$name="training_details/".$today.".xls";
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$name);
?>

