<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$db=$m->appraisalmgmt;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;

require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional

$newdate=$_POST['newdate'];
$idarray=array();



if(!empty($_POST['check_list'])) {
foreach($_POST['check_list'] as $check) {
array_push($idarray,$check);
}

//var_dump($idarray);

//var_dump($newdate);

$res=$n->findOne(array("name"=>"extendedSelfAppraisals"));
if(empty($res))
{
$result=$n->insert(array("name"=>"extendedSelfAppraisals","Deadline"=>$newdate,"employee IDs"=>$idarray));	
for($i=0;$i<count($idarray);$i++)
{
$r=$n->update(array("name"=>"selfAppraisal"),array('$pull'=>array("employee IDs"=>$idarray[$i])));
$doc=$c->findOne(array("psiid"=>$idarray[$i]));

$email=$doc["emailid"];
 $to= $email;
 $message ="You Self-Appraisal Deadline has been extended to ".$newdate;
 $mail->Host       = "mail.paxterrasolutions.com";
 $mail->Port = 26; 
 $mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =2;
$mail->Subject = 'E-PAS Self-Appraisal Deadline extension';
$mail->Body = $message;
$mail->Send();
$mail->ClearAddressess();
}
}
else
{
for($i=0;$i<count($idarray);$i++)
{
$result=$n->update(array("name"=>"extendedSelfAppraisals"),
array('$addToSet'=>array("employee IDs"=>$idarray[$i])));
$r=$n->update(array("name"=>"selfAppraisal"),array('$pull'=>array("employee IDs"=>$idarray[$i])));
$doc=$c->findOne(array("psiid"=>$idarray[$i]));

$email=$doc["emailid"];
 $to= $email;
 $message ="You Self-Appraisal Deadline has been extended to ".$newdate;
 $mail->Host       = "mail.paxterrasolutions.com";
 $mail->Port = 26; 
 $mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =2;
$mail->Subject = 'E-PAS Self-Appraisal Deadline extension';
$mail->Body = $message;
$mail->Send();
$mail->ClearAddressess();
}}  
header('location:extendsadeadline.php?status=success');        
}
?>
