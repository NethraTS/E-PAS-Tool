<?php
require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional


$m=new MongoClient();
$db=$m->AppraisalManagement1;
$crc=$db->currentReviewCycle;
$c=$db->Notifications;
$bd=$db->BasicDetails;

$today=date("d-m-Y");
$pod=$c->findOne(array("name"=>"portalOpening"));
$r1=$c->findOne(array("name"=>"review1"));
$san=$c->findOne(array("name"=>"selfAppraisal"));
$r2=$c->findOne(array("name"=>"review2"));
$r3=$c->findOne(array("name"=>"review3"));

//notifications on portal opening date
if(strtotime($pod["Date"])==strtotime($today))
{

	//mail to all r1 reviewers
$reviewer1IDs=$r1["reviewer IDs"];	
for($i=0;$i<count($reviewer1IDs);$i++)
{
$r1Obj=$crc->findOne(array("r1id"=>$reviewer1IDs[$i]));
$r1mailid=$r1Obj["r1emailid"];
$to=$r1mailid;
//echo $to;
$messageonPOD="Hello All, 

This is to inform you that the employee performance review for the year ". date("Y"). " kick starts on ". $pod["Date"]."  

Please visit epas.paxterrasolutions.com to complete the reviews on or before ". $r1["Deadline"]."

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Employee Performance Review for the year ". date("Y")." kick starts."; 
$mail->Body = $messageonPOD;
$mail->Send();
$mail->ClearAddresses();
}

//mails to all reviewer 2
$reviewer2IDs=$r2["reviewer IDs"];	
for($i=0;$i<count($reviewer2IDs);$i++)
{
$r2Obj=$crc->findOne(array("r2id"=>$reviewer2IDs[$i]));
$r2mailid=$r2Obj["r2emailid"];
$to=$r2mailid;
$subject="Self-assessment process for the year ".date("Y")." kick starts."; 
$messageonPOD="Hello All, 

This is to inform you that the employee performance review for the year ". date("Y"). " kick starts on ". $pod["Date"]."  

Please visit epas.paxterrasolutions.com to complete the reviews on or before ". $r2["Deadline"]."

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Employee Performance Review for the year ". date("Y")." kick starts."; 
$mail->Body = $messageonPOD;
$mail->Send();
$mail->ClearAddresses();
}

//mails to all reviewer 3
$reviewer3IDs=$r3["reviewer IDs"];	
for($i=0;$i<count($reviewer3IDs);$i++)
{
$r3Obj=$crc->findOne(array("r3id"=>$reviewer3IDs[$i]));
$r3mailid=$r3Obj["r3emailid"];
$to=$r3mailid;
$subject="Self-assessment process for the year ". date("Y")." kick starts."; 
$messageonPOD="Hello All, 

This is to inform you that the employee performance review for the year ". date("Y"). " kick starts on ". $pod["Date"]."  

Please visit epas.paxterrasolutions.com to complete the reviews. 

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Employee Performance Review for the year ". date("Y")." kick starts."; 
$mail->Body = $messageonPOD;
$mail->Send();
$mail->ClearAddresses();
}


  //mails to all employees
$empIDs=$san["employee IDs"];
for($i=0;$i<count($empIDs);$i++)
{
$empObj=$crc->findOne(array("psiid"=>$empIDs[$i]));
$empmailid=$empObj["emailid"];

$to=$empmailid;
$messageOnPOD="Hello All, 

We are pleased to inform you that your yearly assessment process for the year ". date("Y")." has been planned to start on ". $pod["Date"].". 

Please visit epas.paxterrasolutions.com to complete the self-assessment process or before ".$san["Deadline"]." 

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Self-assessment process for the year ". date("Y")." kick starts."; 
$mail->Body = $messageonPOD;
$mail->Send();
$mail->ClearAddresses();
}
}


//notifications on last date
$today=date("d-m-Y");
$pod=$c->findOne(array("name"=>"portalOpening"));
$r1=$c->findOne(array("name"=>"review1"));
$san=$c->findOne(array("name"=>"selfAppraisal"));

		//mails to all r1 reviewers
if(strtotime($r1["Deadline"])==strtotime($today))
{
$reviewer1IDs=$r1["reviewer IDs"];	
for($i=0;$i<count($reviewer1IDs);$i++)
{
$r1Obj=$crc->findOne(array("r1id"=>$reviewer1IDs[$i]));
$r1mailid=$r1Obj["r1emailid"];
$to=$r1mailid;

$messageOnr1Deadline="Hello All, 

This is to inform you that the employee performance review-1 for the year ". date("Y") ." ends today.  

Please visit epas.paxterrasolutions.com to complete the reviews.

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";


$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Employee Performance review for the year ". date("y")." ends today"; 
$mail->Body = $messageOnr1Deadline;
$mail->Send();
$mail->ClearAddresses();
}
}

		//mails to all r2 reviewers
if(strtotime($r2["Deadline"])==strtotime($today))
{
$reviewer1IDs=$r2["reviewer IDs"];	
for($i=0;$i<count($reviewer2IDs);$i++)
{
$r2Obj=$crc->findOne(array("r2id"=>$reviewer2IDs[$i]));
$r2mailid=$r2Obj["r2emailid"];
$to=$r2mailid;

$messageOnr2Deadline="Hello All, 

This is to inform you that the employee performance review-2 for the year ". date("Y") ." ends today.  

Please visit epas.paxterrasolutions.com to complete the reviews.

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";


$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Employee Performance review for the year ". date("y")." ends today"; 
$mail->Body = $messageOnr2Deadline;
$mail->Send();
$mail->ClearAddresses();
}
}

	 //mails to all employees
if(strtotime($san["Deadline"])==strtotime($today))
{
$empIDs=$san["employee IDs"];
for($i=0;$i<count($empIDs);$i++)
{
$empObj=$crc->findOne(array("psiid"=>$empIDs[$i]));
$empmailid=$empObj["emailid"];
$messageOnsaDeadline="Hello All, 

This is to inform you that the self-assessment process for the year ". date("Y")." ends today.

Please visit epas.paxterrasolutions.com to complete the self-assessment process. 

For any queries drop in an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Self Assessment Process for the year ". date("y")." ends today"; 
$mail->Body = $messageOndaDeadline;
$mail->Send();
$mail->ClearAddresses();
}	
}	

	
//notifications 2 days before deadline
$today=date("d-m-Y");
$r1=$c->findOne(array("name"=>"review1"));
$san=$c->findOne(array("name"=>"selfAppraisal"));

	//mails to all r1 reviewers
$r1deadline=$r1["Deadline"];
$datetime1 = new DateTime($today);
$datetime2 = new DateTime($r1deadline);
$interval = $datetime1->diff($datetime2);
$diff=$interval->format('%R%a');
if($diff=="+2")
{
$reviewer1IDs=$r1["reviewer IDs"];	
for($i=0;$i<count($reviewer1IDs);$i++)
{
$r1Obj=$crc->findOne(array("r1id"=>$reviewer1IDs[$i]));
$r1mailid=$r1Obj["r1emailid"];
$to=$r1mailid;

$messageb4r1Deadline="Hello All, 

This is to inform you that the employee performance review-1 for the year ". date("Y") ." closes
 on ". $r1["Deadline"]. "  

Please visit epas.paxterrasolutions.com to complete the reviews.

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Employee Performance review-1 for the year ". date("y")." ends on".$r1["Deadline"]; 
$mail->Body = $messageb4r1Deadline;
$mail->Send();
$mail->ClearAddresses();
}	
}	

	//mails to all r2 reviewers
$r2deadline=$r2["Deadline"];
$datetime1 = new DateTime($today);
$datetime2 = new DateTime($r2deadline);
$interval = $datetime1->diff($datetime2);
$diff=$interval->format('%R%a');
if($diff=="+2")
{
$reviewer2IDs=$r2["reviewer IDs"];	
for($i=0;$i<count($reviewer2IDs);$i++)
{
$r2Obj=$crc->findOne(array("r2id"=>$reviewer2IDs[$i]));
$r2mailid=$r2Obj["r2emailid"];
$to=$r2mailid;

$messageb4r2Deadline="Hello All, 

This is to inform you that the employee performance review-2 for the year ". date("Y") ." closes
 on ". $r2["Deadline"]. "  

Please visit epas.paxterrasolutions.com to complete the reviews.

For any queries drop an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Employee Performance review-2 for the year ". date("y")." ends on".$r2["Deadline"]; 
$mail->Body = $messageb4r2Deadline;
$mail->Send();
$mail->ClearAddresses();
}	
}	


	 //mails to all employees
$sadeadline=$san["Deadline"];
$datetime1 = new DateTime($today);
$datetime2 = new DateTime($sadeadline);
$interval = $datetime1->diff($datetime2);
$diff=$interval->format('%R%a');
if($diff=="+2")
{
$empIDs=$san["employee IDs"];
for($i=0;$i<count($empIDs);$i++)
{
$empObj=$crc->findOne(array("psiid"=>$empIDs[$i]));
$empmailid=$empObj["emailid"];
$messagebeforesaDeadline="This is to inform you that the self-assessment process for the year ". date("Y"). " 
closes on ". $sadeadline."

Please visit epas.paxterrasolutions.com to complete the self-assessment process. 

For any queries drop in an email at internal-tools@paxterrasolutions.com.

Thanks, 
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Reminder :Self Assessment process for the year ". date("y")." ends on ".$sadeadline; 
$mail->Body = $messagebeforesaDeadline;
$mail->Send();
$mail->ClearAddresses();
}	
}	

//notifications to all employees on publish
$alldoc=$crc->find();

foreach($alldoc as $doc)
{
	if($doc["flag2"]=="10")
	{
		$to=$doc["emailid"];
$message="Hello All, 

We are pleased to inform you that the yearly assessment review for the year ". date("Y")." has been successfully completed. 

Please visit epas.paxterrasolutions.com to view your rating. 

Thanks,
HR";

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Employee Performance Review for the year ". date("Y")." published."; 
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();	
	}
} 	 

	 	 
?>
