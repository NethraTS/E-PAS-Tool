<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('BasicDetails');
$e1 = $db->selectCollection('RelievingInfo');

$id = $_POST['id'];

$d=$c->update(array("id"=>$id),array('$set'=>array("EF"=>1)));

$role=$_POST["role"];
$doj=$_POST["doj"];
$Project=$_Project["Project"];
$StartDate=$_POST["StartDate"];
$lwd=$_POST["lwd"];
$EmployeeEmail=$_POST["EmployeeEmail"];
$ManagerName=$_POST["ManagerName"];
$Name=$_POST["Name"];
	


$e=$e1->update(array("id"=>$id),array('$set'=>array("id"=>$id,"role"=>$role,"doj"=>$doj,"EmployeeEmail"=>$EmployeeEmail,"ManagerName"=>$ManagerName,"StartDate"=>$StartDate,"lwd"=>$lwd,"Name"=>$Name)),array("upsert"=>true));




require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional

$eid = $_POST['id'];
$data =json_decode($posted_data,true);

$doc=$c->findOne(array("id"=>$id));


//$r1name=$doc["r1name"];
//$mailid=$doc["emailid"];
$mailid=$doc["emailID"];

$subject="Activation Feedback form";
$message="Hello ".$doc["name"].", 

This is to inform you that feedback form has been enabled for you , by the HR with regard to your request. 

Please fill the form. 

Thanks,
HR
";
$to=$mailid;

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Activation Feedback form";
//$mail->AddCC($doc["r1emailid"]); 
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();

$mailid1=$doc["r1emailid"];

$subject="Activation Feedback form";
$message="Hello ".$doc["r1name"].", 

This is to inform you that employee exit formality in Employee Central has been enabled for you , by the HR .Please provide your feedback. 

 

Thanks,
HR
";
$to=$mailid1;

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $r1name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Activation Feedback form";
//$mail->AddCC($doc["r1emailid"]); 
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();















?>
