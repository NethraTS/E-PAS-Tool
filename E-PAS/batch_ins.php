<?php
$con = new Mongo;
$db = $con->AppraisalManagement1;
$user=$db->User0;
$df=$db->deadlineFlags;
$k=$db->encryptionkey;

$user->insert(array("id"=>"000","pwd"=>"111","name"=>"user0","flag"=>"0"));
$k->insert(array("key"=>""));

//$df->insert(array("name"=>"SAdeadlineOver","flag"=>"0"));
//$df->insert(array("name"=>"ESAdeadlineOver","flag"=>"0"));
//$df->insert(array("name"=>"R1deadlineOver","flag"=>"0"));


$document1=array(
		"category"=>"ENGINEERING SERVICES",
		);
$document2=array(
		"category"=>"ENTERPRISE PRODUCT SUPPORT",
		);
$document4=array(
		"category"=>"NOC/ INFRASTRUCTURE SUPPORT",
		);
$document5=array(
		"category"=>"CONTENT DEVELOPMENT",
		);
$document6=array(
		"category"=>"INSIDE SALES",
		);
$document7=array(
		"category"=>"LEARNING AND DEVELOPMENT",
		);
$document8=array(
		"category"=>"FINANCE",
		);
$document9=array(
		"category"=>"HUMAN RESOURCES",
		);
$document10=array(
		"category"=>"OPERATIONS",
		);
$c = $db->selectCollection('designationCategories');
$c->batchInsert(
    array($document1, $document2, $document4,$document5,$document6,$document7,$document8,$document9,$document10),
    array('continueOnError' => true)
);
$c->update(array('category'=>"ENGINEERING SERVICES"),array('$set'=>array('role'=>array('Senior Vice president','Vice president','Director','Senior Director','Senior Manager','Senior Architect','Manager','Architect','Senior Technical Lead','Associate Manager - II','Technical Lead','Associate Manager - I','Lead engineer','Software engineer - IV','Software engineer - III','Software engineer - II','Software engineer - I','Software engineer Trainee'))));
$c->update(array('category'=>'ENTERPRISE PRODUCT SUPPORT'),array('$set'=>array('role'=>array('Senior Vice president','Vice president','Director','Senior Director','Senior Manager - Support services','Manager - Support services','Manager - Process support','Associate Manager II - Support services','Team lead - II - Support services','Technical lead - Support services','Associate Manager I - Support services','Team Lead - I','Technical Support engineer - IV','Technical Support engineer - III','Technical Support engineer - II','Technical Support engineer - I','Technical Support engineer Trainee','Manager-Customer Support','Lead-Customer Support','Team Lead-Customer Support','Senior Customer Support Representative','Customer Support Representative'))));

$c->update(array('category'=>'NOC/ INFRASTRUCTURE SUPPORT'),array('$set'=>array('role'=>array('IT Manager','Lead - System Administrator','Senior System Administrator','System Administrator','Junior System Administrator','Trainee System Administrator'))));
$c->update(array('category'=>'CONTENT DEVELOPMENT'),array('$set'=>array('role'=>array('Manager -Technical writing','Lead - Technical Writing','Team lead - Technical Writing','Senior Technical writer','Technical Writer'))));
$c->update(array('category'=>'INSIDE SALES'),array('$set'=>array('role'=>array('Director - Business Development','Senior Manager - Business Development','Manager - Business Development','Lead - Business Development','Senior Executive - Business Development','Executive - Business Development'))));
$c->update(array('category'=>'LEARNING AND DEVELOPMENT'),array('$set'=>array('role'=>array('Senior Program Manager','Program Manager','Manager - Training & Development','Lead - Training & Development','Senior Trainer','Trainer'))));
$c->update(array('category'=>'FINANCE'),array('$set'=>array('role'=>array('Senior Manager - Finance','Manager - Finance','Associate Manager - Finance','Lead - Accountant','Senior Accountant','Accountant','Junior Accountant'))));
$c->update(array('category'=>'HUMAN RESOURCES'),array('$set'=>array('role'=>array('Senior Manager - HR','Manager - HR','Associate Manager - HR','Lead - HR executive','Senior HR executive','HR executive','Junior HR executive','Trainee HR executive'))));
$c->update(array('category'=>'OPERATIONS'),array('$set'=>array('role'=>array('Head - Operations','Senior Manager - Operations','Manager - Operations','Lead - Operations','Building in charge/ Faculties in charge','Senior Faculty executive','Faculty executive'))));


?>
