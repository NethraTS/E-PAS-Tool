<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
if(date('d-m')=="01-07")
{
$docs=$c->find(array("gName"=>"Q1"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"Q1"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
}
if(date('d-m')=="01-10")
{
$docs=$c->find(array("gName"=>"Q2"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"Q2"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
$docs=$c->find(array("gName"=>"H1"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"H1"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
}
if(date('d-m')=="01-01")
{
$docs=$c->find(array("gName"=>"Q3"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"Q3"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
}
if(date('d-m')=="01-04")
{
$docs=$c->find(array("gName"=>"Q4"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"Q4"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
$docs=$c->find(array("gName"=>"A"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"A"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
$docs=$c->find(array("gName"=>"H2"));	
foreach($docs as $row)
{
$docs=$c->update(array("gName"=>"H2"),array('$set'=>array("Competency"=>"",
		"Deliverables"=>"",
		"OrgContribution"=>"",
		"Quality"=>"",
		"ValueAddition"=>"",
		"gName"=>"",
		"gType"=>"",
		"gWts"=>"",
		"gYear"=>"",
		"r1MeetingDate"=>"",
		"flag"=>"0")));
//echo 	$row["name"];
//echo 	$row["gName"];
}
}

//echo date('d-m');
//else 
//echo "not the specified date";
?>