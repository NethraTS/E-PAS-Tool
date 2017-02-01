<?php 
session_start();include session_timeout.php;

require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional


$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->currentReviewCycle;
$n=$db->Notifications;
$adl=$db->adminlist;

$r3id=$_POST["psiid"];
$alldoc=$c->find(array("r3id"=>$r3id));


$pendings=$c->find(array("r3id"=>$r3id,"flag2"=>array('$lt'=>"6")));
$arcount= $pendings->count();

if($arcount>0)
{
foreach($pendings as $dc)
{
if($dc["postponedFlag"]>="1")
{}	
else 
{
echo  "Some reviews are still pending!";
exit;
}
}
}
else 
{
$alldoc=$c->find(array("r3id"=>$r3id));	
$ids=$n->findOne(array("name"=>"review3"));
if(in_array($r3id,$ids["finalisedIDs"]))
{
echo("The list has been already finalised!");
}
else 
{
foreach($alldoc as $docs)
{
if($docs["postponedFlag"]>="1")
{}	
else 
{
$c->update(array("psiid"=>$docs["psiid"]),array('$set'=>array("flag2"=>"9")));
//$c->update(array("psiid"=>$docs["psiid"]),array('$set'=>array("flag1"=>"9")));
}
}

$n->update(array("name"=>"review3"),array('$inc' => array("finalised" => 1)));
$n->update(array("name"=>"review3"),array('$addToSet' => array("finalisedIDs" =>$r3id)));

$hrmailids=array();
$doc=$c->findOne(array("r3id"=>$r3id));
$hrm=$adl->find(array("designation"=>"HR Manager"));

$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
//$mail->addAddress($to, $name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
//$mail->SMTPDebug =2;
$mail->Subject =$_SESSION["uname"]." has finalised review list."; 
$message="Hello HR, 

This is to inform you that the ".$_SESSION["uname"]." has finalized the assessment review list for the year ". date("Y")."  

Thanks,
EPAS
";
foreach($hrm as $hr)
{
$mail->addAddress($hr["email"]);
}
$mail->AddCC($doc["r3emailid"]);
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();

echo("Successfully Finalised!");
}
}

?>
