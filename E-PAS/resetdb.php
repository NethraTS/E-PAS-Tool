<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;
$xl=$db->xlsupload;
$dest=$db->reviewHistory;
$f=$db->deadlineFlags;
$k=$db->encryptionkey;


$alldoc=$c->find();
foreach($alldoc as $doc)
{
if($doc["postponedFlag"]>="1" || $doc["flag2"]>"10")
{
}
else
{
$dest->save($c->findOne(array("psiid"=>$doc["psiid"])));
}
}

$f->update(array("name"=>"SAdeadlineOver"),array('$set'=>array("flag"=>"0")));
$f->update(array("name"=>"ESAdeadlineOver"),array('$set'=>array("flag"=>"0")));
$f->update(array("name"=>"R1deadlineOver"),array('$set'=>array("flag"=>"0")));

$ek=$k->findOne();
$k->update(array("key"=>$ek["key"]),array('$unset'=>array("key"=>array())));
$c->drop();
$bd->drop();
$n->drop();
$xl->drop();
$f->drop();

echo "Now you can upload new data to begin the next review cycle.";
?>



