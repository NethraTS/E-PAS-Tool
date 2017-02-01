<?php
 include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$b=$db->basics;

$gtypes=array("Quarterly","Half-Yearly","Annual");


$b->drop();

$b->insert(array("name"=>"gPeriods",
			"Q1"=>"Apr-June",
			"Q2"=>"July-Sept",
			"Q3"=>"Oct-Dec",
			"Q4"=>"Jan-March",
			"H1"=>"Apr-Sept",
			"H2"=>"Oct-March",
			"A"=>"Apr-March"));
			
$b->insert(array("GoalYear"=>date("Y"),
						"currentGoalPeriod"=>date("M")));
						
 ?>