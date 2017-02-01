<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$dc = $db->selectCollection('gradesandweights');

$document1=array(
		"category"=>"DEVELOPMENT/AUTOMATION/QA/TESTING",
		);
$document2=array(
		"category"=>"TECHNICAL SUPPORT/ PRODUCT SUPPORT",
		);
$document3=array(
		"category"=>"CUSTOMER SUPPORT",
		);
$document4=array(
		"category"=>"NOC/ INFRASTRUCTURE SUPPORT",
		);
$document5=array(
		"category"=>"TECHNICAL WRITER/ DOCUMENTATION TEAM",
		);
$document6=array(
		"category"=>"BUSINESS DEVELOPMENT",
		);
$document7=array(
		"category"=>"TRAINING / DEVELOPMENT",
		);
$document8=array(
		"category"=>"FINANCE TEAM",
		);
$document9=array(
		"category"=>"HUMAN RESOURCES TEAM",
		);
$document10=array(
		"category"=>"OPERATIONS",
		);

$dc->batchInsert(
    array($document1, $document2, $document3, $document4,$document5,$document6,$document7,$document8,$document9,$document10),
    array('continueOnError' => true)
);

$doc=$dc->update(array('category'=>'OPERATIONS'),array('$set'=>array('roleweights'=>(
				array('Head - Operations'=>'',
						'Senior Manager - Operations'=>'',
						'Manager - Operations'=>'',
						'Lead - Operations'=>'',
						'Building in charge/ Facilities in charge'=>'',
						'Senior Facility executive'=>'',
						'Facility executive'=>'')))));

$doc=$dc->update(array('category'=>'HUMAN RESOURCES TEAM'),array('$set'=>array('roleweights'=>array(
'Senior Manager - HR'=>'',
'Manager - HR'=>'',
'Associate Manager - HR'=>'',
'Lead - HR executive'=>'',
'Senior HR executive'=>'',
'HR executive'=>'',
'Junior HR executive'=>'',
'Trainee HR executive'=>''
))));

$dc->update(array('category'=>'FINANCE TEAM'),array('$set'=>array('roleweights'=>array(
'Senior Manager - Finance'=>'',
'Manager - Finance'=>'',
'Associate Manager - Finance'=>'',
'Lead - Accountant'=>'',
'Senior Accountant'=>'',
'Accountant'=>'',
'Junior Accountant'=>''))));

$dc->update(array('category'=>'TRAINING / DEVELOPMENT'),array('$set'=>array('roleweights'=>array(
'Senior Program Manager'=>'',
'Program Manager'=>'',
'Manager - Training & Development'=>'',
'Lead - Training & Development'=>'',
'Senior Trainer'=>'',
'Trainer'=>''))));

$dc->update(array('category'=>'BUSINESS DEVELOPMENT'),array('$set'=>array('roleweights'=>array(
'Director - Business Development'=>'',
'Senior Manager - Business Development'=>'',
'Manager - Business Development'=>'',
'Lead - Business Development'=>'',
'Senior Executive - Business Development'=>'',
'Executive - Business Development'=>''))));

$dc->update(array('category'=>'TECHNICAL WRITER/ DOCUMENTATION TEAM'),array('$set'=>array('roleweights'=>array(
'Manager -Technical writing'=>'',
'Lead - Technical Writing'=>'',
'Team lead - Technical Writing'=>'',
'Senior Technical writer'=>'',
'Technical Writer'=>''))));

$dc->update(array('category'=>'NOC/ INFRASTRUCTURE SUPPORT'),array('$set'=>array('roleweights'=>array(
'IT Manager'=>'',
'Lead - System Administrator'=>'',
'Senior System Administrator'=>'',
'System Administrator'=>'',
'Junior System Administrator'=>'',
'Trainee System Administrator'=>''))));

$dc->update(array('category'=>'CUSTOMER SUPPORT'),array('$set'=>array('roleweights'=>array(
'Manager - Customer Support'=>'',
'Lead - Customer Support'=>'',
'Team lead - Customer Support'=>'',
'Senior Customer Support representative'=>'',
'Customer Support representative'=>''))));

$dc->update(array('category'=>'TECHNICAL SUPPORT/ PRODUCT SUPPORT'),array('$set'=>array('roleweights'=>array(
'Senior Vice president'=>'',
'Vice president'=>'',
'Director'=>'',
'Senior Director'=>'',
'Senior Manager - Support services'=>'',
'Manager - Support services'=>'',
'Manager - Process support'=>'',
'Associate Manager II - Support services'=>'',
'Team lead - II - Support services'=>'',
'Technical lead - Support services'=>'',
'Associate Manager I - Support services'=>'',
'Team Lead I'=>'',
'Technical Support engineer - IV'=>'',
'Technical Support engineer - III'=>'',
'Technical Support engineer - II'=>'',
'Technical Support engineer - I'=>'',
'Technical Support engineer Trainee'=>''))));
						
$dc->update(array('category'=>"DEVELOPMENT/AUTOMATION/QA/TESTING"),array('$set'=>array('roleweights'=>array(
'Senior Vice president'=>'',
'Vice president'=>'',
'Director'=>'',
'Senior Director'=>'',
'Senior Manager'=>'',
'Senior Architect'=>'',
'Manager'=>'',
'Architect'=>'',
'Senior Technical Lead'=>'',
'Associate Manager II'=>'',
'Technical Lead'=>'',
'Associate Manager I'=>'',
'Lead engineer'=>'',
'Software engineer - IV'=>'',
'Software engineer - III'=>'',
'Software engineer - II'=>'',
'Software engineer - I'=>'',
'Software engineer Trainee'=>''))));						
?>
