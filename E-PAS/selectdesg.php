<?php 
ob_start();
session_start();include session_timeout.php;
include 'secure.php';
require('auth.php');


$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$q=$_GET["q"];
//$q="Technical Lead";
$m=new MongoClient();
$db=$m->goals;
$employee=$db->currentGoalCycle;
?>
<?php
if($q=="All")
{
$data="";
$data=$data.'	<table> <thead> <tr>   <th>PSI-ID</th>  <th>Name</th>  <th>Designation</th> <th>R1 name</th> <th>R1 psi id</th> <th>R2 name</th>
								  <th>R2 psi id</th>	  
								  
								  </tr>
						  </thead>   
						  <tbody>';
					  
$empdoc=$employee->find();
foreach($empdoc as $el)
{
$data= $data.'<tr >';
$data= $data.'<td>';
 $data= $data.$el["id"];
'</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
 $data= $data.'<td>'.$el["name"].'</td>';
 $data= $data.'<td>'.$el["desgn"].'</td>';
 $data= $data.'<td>'.$el["r1name"].'</td>';
 $data= $data.'<td>'.$el["r1id"].'</td>';
 $data= $data.'<td>'.$el["r2name"].'</td>';
 $data= $data.'<td>'.$el["r2id"].'</td>';
 $data= $data.'</tr>';
} 
$data= $data.'					  </tbody>
					  </table> ';
echo $data;	
	
	
	
	}
else {
$data="";
$data=$data.'	<table> <thead> <tr>   <th>PSI-ID</th>  <th>Name</th>  <th>Designation</th> <th>R1 name</th> <th>R1 psi id</th> <th>R2 name</th>
								  <th>R2 psi id</th>	  
								  
								  </tr>
						  </thead>   
						  <tbody>';
					  
$empdoc=$employee->find(array("desgn"=>$q));
foreach($empdoc as $el)
{
$data= $data.'<tr >';
$data= $data.'<td>';
 $data= $data.$el["id"];
'</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
 $data= $data.'<td>'.$el["name"].'</td>';
 $data= $data.'<td>'.$el["desgn"].'</td>';
 $data= $data.'<td>'.$el["r1name"].'</td>';
 $data= $data.'<td>'.$el["r1id"].'</td>';
 $data= $data.'<td>'.$el["r2name"].'</td>';
 $data= $data.'<td>'.$el["r2id"].'</td>';
 $data= $data.'</tr>';
} 
$data= $data.'					  </tbody>
					  </table> ';
echo $data;					  
}
?>