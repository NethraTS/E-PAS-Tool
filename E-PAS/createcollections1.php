<?php 
$db=new MongoClient();
$c=$db->AppraisalManagement1;
$base=$c->xlsupload;
$bd=$c->BasicDetails;
$n=$c->Notifications;
$crc=$c->currentReviewCycle;



// creating Basic Details collections

$allDoc=$base->find();

foreach($allDoc as $d){
$res=$bd->insert(array(
"psiid"=>$d["PSIID"],
"name"=>$d["NAME"],
"designation"=>$d["DESIGNATION"],
"emailID"=>$d["EMAILID"]
));
}


//add reviewer1 IDs to notifications
$allDoc=$base->find();

$setofr1ids=array();

foreach($allDoc as $d)
{
$r1name=$d["R1NAME"];
$res=$base->findOne(array("NAME"=>$r1name));
array_push($setofr1ids,$res["PSIID"]);
}
$setofr1ids=array_unique($setofr1ids);
$setofr1ids=array_filter($setofr1ids);

$res=$n->insert(array("name"=>"review1","changed"=>"no","Deadline"=>"","reviewer IDs"=>array()));
foreach($setofr1ids as $v)
{
$res=$n->update(array("name"=>"review1"),array('$addToSet'=>array("reviewer IDs"=>$v)));
}
//add reviewer2 IDs to notifications
$setofr2ids=array();

foreach($allDoc as $d)
{
$r2name=$d["R2NAME"];
$res=$base->findOne(array("NAME"=>$r2name));
array_push($setofr2ids,$res["PSIID"]);
}
$setofr2ids=array_unique($setofr2ids);
$setofr2ids=array_filter($setofr2ids);

$res=$n->insert(array("name"=>"review2","changed"=>"no","Deadline"=>"","reviewer IDs"=>array()));
foreach($setofr2ids as $v)
{
$res=$n->update(array("name"=>"review2"),array('$addToSet'=>array("reviewer IDs"=>$v)));
}

//add reviewer3 IDs to notifications
$setofr3ids=array();

foreach($allDoc as $d)
{
$r3name=$d["R3NAME"];
$res=$base->findOne(array("NAME"=>$r3name));
array_push($setofr3ids,$res["PSIID"]);
}
$setofr3ids=array_unique($setofr3ids);
$setofr3ids=array_filter($setofr3ids);

$res=$n->insert(array("name"=>"review3","changed"=>"no","Deadline"=>"","reviewer IDs"=>array()));
foreach($setofr3ids as $v)
{
$res=$n->update(array("name"=>"review3"),array('$addToSet'=>array("reviewer IDs"=>$v)));
}
//create currentReviewCycle collection
$allDoc=$base->find();

$r1=$n->findOne(array("name"=>"review1"));
$r1IDs=$r1["reviewer IDs"];

$r2=$n->findOne(array("name"=>"review2"));
$r2IDs=$r2["reviewer IDs"];

$r3=$n->findOne(array("name"=>"review3"));
$r3IDs=$r3["reviewer IDs"];


foreach($allDoc as $d){
$role=array("emp");

$res=$crc->insert(array(
"psiid"=>$d["PSIID"],
"r1name"=>$d["R1NAME"],
"r2name"=>$d["R2NAME"],
"r3name"=>$d["R3NAME"],
"flag1"=>"0",
"flag2"=>"0",
"mailsent"=>"0",
"role"=>array()
));  

if(in_array($d["PSIID"],$r1IDs)){
array_push($role,"r1");
}

if(in_array($d["PSIID"],$r2IDs)){
array_push($role,"r2");}

if(in_array($d["PSIID"],$r3IDs)){
array_push($role,"r3");}

foreach($role as $v)
{
$res=$crc->update(array("psiid"=>$d["PSIID"]),array('$addToSet'=>array("role"=>$v)));
echo $v." ";
} 
unset($role);
}

			header('location:adminsettings.php?status=libinserted');        

?>








