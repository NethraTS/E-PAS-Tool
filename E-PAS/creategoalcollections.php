<?php 
session_start();include session_timeout.php;
$db=new MongoClient();
$c=$db->goals1;
//$c=$db->appraisalmgmt;
$base=$c->xlsupload;
$bd=$c->BasicDetails;
$n=$c->Notifications;
$crc=$c->currentGoalCycle;
$u=$c->uploaded;
$f=$c->deadlineFlags;
$r=$c->Roles;

// creating Basic Details collections
	$allDoc=$base->find();
foreach($allDoc as $d)
{
	//if($d["flag"]==="1")
	{}
	//else 
	{
		$res=$bd->insert(array(
					"id"=>$d["PSIID"],
					"name"=>$d["NAME"],
					"desgn"=>$d["DESIGNATION"],
					"emailID"=>$d["EMAILID"],
					"r1name"=>$d["R1NAME"],
					"r2name"=>$d["R2NAME"],
					"r3name"=>$d["R3NAME"],
					"r1emailid"=>$d["R1EMAILID"],
					"r2emailid"=>$d["R2EMAILID"],
					"r3emailid"=>$d["R3EMAILID"]
				      ));
	}
}

//add reviewer1 IDs to notifications
$allDoc=$base->find();

$n->ensureIndex(array('name' => 1), array('unique' => 1));

$setofr1ids=array();

foreach($allDoc as $d)
{
	$r1id=$d["R1 PSIID"];
		//$res=$base->findOne(array("NAME"=>$r1name));
		array_push($setofr1ids,$r1id);
}
$setofr1ids=array_unique($setofr1ids);
$setofr1ids=array_filter($setofr1ids);

$doc = $n->findOne(array("name"=>"review1"));
if(!empty($doc))
{
	foreach($setofr1ids as $v)
	{
		$res=$n->update(array("name"=>"review1"),array('$addToSet'=>array("reviewer IDs"=>$v)));
	}
}
else{
	$res=$n->insert(array("name"=>"review1","changed"=>"no","Deadline"=>" "));
	foreach($setofr1ids as $v)
	{
		$res=$n->update(array("name"=>"review1"),array('$addToSet'=>array("reviewer IDs"=>$v)));
	}
}

//add reviewer2 IDs to notifications
$setofr2ids=array();

foreach($allDoc as $d)
{
	$r2id=$d["R2 PSIID"];
		//$res=$base->findOne(array("NAME"=>$r2name));
		array_push($setofr2ids,$r2id);
}

$setofr2ids=array_unique($setofr2ids);
$setofr2ids=array_filter($setofr2ids);

$doc = $n->findOne(array("name"=>"review2"));
if(!empty($doc))
{
	foreach($setofr2ids as $v)
	{
		$res=$n->update(array("name"=>"review2"),array('$addToSet'=>array("reviewer IDs"=>$v)));
	}
}
else {
	$res=$n->insert(array("name"=>"review2","changed"=>"no","Deadline"=>" "));
		foreach($setofr2ids as $v)
		{
			$res=$n->update(array("name"=>"review2"),array('$addToSet'=>array("reviewer IDs"=>$v)));
		}
}

//add reviewer3 IDs to notifications
$setofr3ids=array();

foreach($allDoc as $d)
{
	$r3id=$d["R3 PSIID"];
		//$res=$base->findOne(array("NAME"=>$r3name));
		array_push($setofr3ids,$r3id);
}

$setofr3ids=array_unique($setofr3ids);
$setofr3ids=array_filter($setofr3ids);

$doc = $n->findOne(array("name"=>"review3"));
if(!empty($doc))
{
	foreach($setofr3ids as $v)
	{
		$res=$n->update(array("name"=>"review3"),array('$addToSet'=>array("reviewer IDs"=>$v)));
	}
}
else {
	$res=$n->insert(array("name"=>"review3","changed"=>"no","Deadline"=>" ","finalised"=>0));
		foreach($setofr3ids as $v)
		{
			$res=$n->update(array("name"=>"review3"),array('$addToSet'=>array("reviewer IDs"=>$v)));
		}
}

//add all employee IDs for self-appraisal notifications
$setofempids=array();

foreach($allDoc as $d)
{
	array_push($setofempids,$d["PSIID"]);
}

$setofempids=array_unique($setofempids);
$setofempids=array_filter($setofempids);

$doc = $n->findOne(array("name"=>"selfAppraisal"));
if(!empty($doc))
{
	foreach($setofempids as $v)
	{
		$res=$n->update(array("name"=>"selfAppraisal"),array('$addToSet'=>array("employee IDs"=>$v)));
	}
}
else {
	$res=$n->insert(array("name"=>"selfAppraisal","changed"=>"no","Deadline"=>" "));
		foreach($setofempids as $v)
		{
			$res=$n->update(array("name"=>"selfAppraisal"),array('$addToSet'=>array("employee IDs"=>$v)));
		}
}

//create portalOpening document in notifications
$doc = $n->findOne(array("name"=>"portalOpening"));
if(!empty($doc))
{}
else {
	$res=$n->insert(array("name"=>"portalOpening","changed"=>"no","Date"=>" "));
}	

//create currentReviewCycle collection
$allDoc=$base->find();

$crc->ensureIndex(array('id' => 1), array('unique' => 1));

$r1=$n->findOne(array("name"=>"review1"));
$r1IDs=$r1["reviewer IDs"];

$r2=$n->findOne(array("name"=>"review2"));
$r2IDs=$r2["reviewer IDs"];

$r3=$n->findOne(array("name"=>"review3"));
$r3IDs=$r3["reviewer IDs"];


foreach($allDoc as $d){
	$role=array("emp");
	//if($d["flag"]==="1")
	{}
	//else 
	{
		$res=$crc->insert(array(
					"id"=>$d["PSIID"],
					"name"=>$d["NAME"],
					"emailid"=>$d["EMAILID"],
					"r1name"=>$d["R1NAME"],
					"r1id"=>$d["R1 PSIID"],
					"r2name"=>$d["R2NAME"],
					"r2id"=>$d["R2 PSIID"],
					"r3name"=>$d["R3NAME"],
					"r3id"=>$d["R3 PSIID"],
					"r1emailid"=>$d["R1EMAILID"],
					"r2emailid"=>$d["R2EMAILID"],
					"r3emailid"=>$d["R3EMAILID"],
					"flag"=>"0",
					"desgn"=>$d["DESIGNATION"],
					"year"=>date("Y"),
					"role"=>array()
				       ));  

		if(in_array($d["PSIID"],$r1IDs)){
			array_push($role,"r1");}

		if(in_array($d["PSIID"],$r2IDs)){
			array_push($role,"r2");}

		if(in_array($d["PSIID"],$r3IDs)){
			array_push($role,"r3");}

		foreach($role as $v)
		{
			$res=$crc->update(array("id"=>$d["PSIID"]),array('$addToSet'=>array("role"=>$v)));
			//echo $v." ";
		} 
		unset($role);
	}
}

//creating deadline flags
$f->insert(array("name"=>"SAdeadlineOver","flag"=>"0"));
$f->insert(array("name"=>"ESAdeadlineOver","flag"=>"0"));
$f->insert(array("name"=>"R1deadlineOver","flag"=>"0"));

foreach($allDoc as $i)
{
        //var_dump($i);
	$base->update(array("id"=>$i["id"]),array('$set'=>array("flag"=>"1")));	
}

if($_SESSION["admin"]=="HRA")
header('location:hradminsettings.php?status=Inserted successfully');        
elseif($_SESSION["admin"]=="HRM")
header('location:goaladminsettings.php?status=Goal Inserted successfully');        

?>

