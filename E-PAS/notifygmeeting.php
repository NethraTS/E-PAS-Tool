<?php
session_start();include session_timeout.php;
$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('currentGoalCycle');

require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional

$eid = $_POST['id'];
$data =json_decode($posted_data,true);

$doc=$c->findOne(array("id"=>$eid));

$Mdate=$doc["r1MeetingDate"];
//$r1name=$doc["r1name"];
//$mailid=$doc["emailid"];
$mailid=$doc["emailid"];

$subject="Goal Setting Meeting Date";
$message="Hello ".$doc["name"].", 

This is to inform you that a 1 on 1 has been scheduled on ".$Mdate." , by your manager with regard to the goal setting process. 

Please make yourself available. 

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
$mail->Subject ="Goal Setting Meeting scheduled";
$mail->AddCC($doc["r1emailid"]); 
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();
?>
