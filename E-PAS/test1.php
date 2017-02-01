<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;
$f=$db->deadlineFlags;

//$c->update(array("psiid"=>"541"),array('$set'=>array("postponeFlag"=>"0")));

//$n->update(array("name"=>"selfAppraisal"),array('$set'=>array("Deadline"=>"1-2-2015")));


//Checking Self-Appraisal deadline date
$SADflag=$f->findOne(array("name"=>"SAdeadlineOver"));
//var_dump($SADflag);

if($SADflag["flag"]==="0")
{
$SAObj=$n->findOne(array("name"=>"selfAppraisal"));
$SADeadline=$SAObj["Deadline"];
$today = date("d-m-Y");
$today_time = strtotime($today);
//echo $today;
//echo $SADeadline;

//if SA-deadline expired
if (strtotime($SADeadline) < $today_time) 
{
$SADemployees=array();
		 
$allDoc=$c->find();
$count=count($SAObj["employee IDs"]);
for($i=0;$i<$count;$i++)
array_push($SADemployees,$SAObj["employee IDs"][$i]);
//var_dump($SADemployees);

//extend deadline for incompeted SAs
foreach($allDoc as $doc)
{
if(in_array($doc["psiid"],$SADemployees))
{	
if($doc["flag1"]<"2" || $doc["flag2"]<"2")
{
$n->update(array("name"=>"extendedSelfAppraisals"),
array('$addToSet'=>array("employee IDs"=>$doc["psiid"])));
$n->update(array("name"=>"selfAppraisal"),array('$pull'=>array("employee IDs"=>$doc["psiid"])));	
}
}
$f->update(array("name"=>"SAdeadlineOver"),array('$set'=>array("flag"=>"1")));
}
else {
 	echo "not expired";
}
}
}

//checking Extended Deadline date
$ESADflag=$f->findOne(array("name"=>"ESAdeadlineOver"));
if($ESADflag["flag"]==="0")
{
$ESAObj=$n->findOne(array("name"=>"ExtendedSelfAppraisals"));
$ESADeadline=$ESAObj["Deadline"];
$today = date("d-m-Y");
$today_time = strtotime($today);

//if ESA deadline expires
if (strtotime($ESADeadline) < $today_time) 
{
$ESADemployees=array();
$allDoc=$c->find();
$count=count($ESAObj["employee IDs"]);

for($i=0;$i<$count;$i++)
array_push($ESADemployees,$ESAObj["employee IDs"][$i]);
	
//set postponeflag for employees
foreach($allDoc as $doc)
{
if(in_array($doc["psiid"],$ESADemployees))
{	
if($doc["flag1"]<"2" || $doc["flag2"]<"2")
{
$c->update(array("psiid"=>$doc["psiid"]),array('$set'=>array("postponedFlag"=>"1")));
}
}
}
$f->update(array("name"=>"ESAdeadlineOver"),array('$set'=>array("flag"=>"1")));
}
}

?>



