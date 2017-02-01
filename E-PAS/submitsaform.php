<?php
session_start();include session_timeout.php;
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;

require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional

$submitted = $_POST['sub'];
$id=$_POST['id'];

if($submitted=="true")
{
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag1"=>"2")));
$d=$c->update(array("psiid"=>$id),array('$set'=>array("flag2"=>"2")));
$doc=$c->findOne(array("psiid"=>$id));
 $to=$doc["emailid"]; 
 $message = "Hello ".$doc["name"].",     

This is to inform you that you have successfully completed the self-assessment process for the year ". date("Y").".

Please visit epas.paxterrasolutions.com to track the status of manager review. 

For any queries drop an email at paxsustenance@paxterrasolutions.com.

Thanks, 
HR
";
$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="Self-assessment for the year". date("Y")." completed successfully";
$mail->AddCC($doc["r1emailid"]);
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();
}


var_dump($id);
?>
