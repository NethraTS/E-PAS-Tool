<?php
session_start();include session_timeout.php; 
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$dest=$db->GoalsToBeReviewed;
$id=$_POST['id'];
//$psiid=
$timestamp=date("d-m-Y H:i:s");

$doc=$c->findOne(array("id"=>$id));

$c->update(array("id"=>$id),array('$set'=>array("flag"=>"3","goalsAcceptedByEmpAt"=>$timestamp)));


$alldocs=$c->find(array('id'=>$_SESSION['psiid']));
$name="";
$r1name="";
$r1mailid="";
$mailid="";
foreach($alldocs as $doc)
{
	$name=$doc['name'];
	$r1name=$doc["r1name"];
	$r1mailid=$doc["r1emailid"];
	$mailid=$doc["r1emailid"];
	$c->update(array("id"=>$doc["id"]),array('$set'=>array("rFlag"=>"0")));
	$dest->save($c->findOne(array("id"=>$doc["id"]))); //move to history collection
}
//echo $name;

require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional

$eid = $_POST['id'];
$data =json_decode($posted_data,true);

$doc=$c->findOne(array("psiid"=>$eid));

//$Mdate=$doc["r1MeetingDate"];
/*$r1name=$doc["r1name"];
$r1mailid=$doc["r1emailid"];
$mailid=$doc["emailid"];
*/
/*
$r1name="sam";
$r1mailid="samuvel.j@paxterrasolutions.com";
$mailid="samuvel.j@paxterrasolutions.com"; */
//remove 3 line in production

$subject="[EPAS Goals] $name Acknowledged Goals";
$message="Hello ".$r1name.", 

This is to inform you that ".$name." has acknowledged the goals. 

 

Thanks,
HR
";
//$to=$mailid;
echo $r1mailid ." ".$r1name." ".$name." ".$mailid;
$mail->Host       = "mail.paxterrasolutions.com";
$mail->Port = 26; 
$mail->Username   = "paxsustenance@paxterrasolutions.com"; // SMTP account username
$mail->Password   = "P@ssword";  
$mail->addAddress($r1mailid, $r1name);
$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS');
$mail->SMTPAuth = true;
$mail->SMTPDebug =0;
$mail->Subject ="[EPAS - Goals] ".$name." has Acknowledged Goals ";
$mail->AddCC($mailid); 
$mail->Body = $message;
$mail->Send();
$mail->ClearAddresses();


?>