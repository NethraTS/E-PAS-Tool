<?php
session_start();include session_timeout.php;
$m=new MongoClient();

$db=$m->goals1;
$coll=$db->currentGoalCycle;
$n=$db->Notifications;
$bd=$db->BasicDetails;
$adl=$db->adminlist;
$k=$gdb->encryptionkey;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

//echo $_REQUEST['g1'].$_REQUEST['g2'].$_REQUEST['g3'].$_REQUEST['g4'].$_REQUEST['g5'];
//echo $_REQUEST['savegoaldates'];
//$status=$_GET["status"];

$doc=$bd->findOne(array("psiid"=>$psiid));

$adldoc=$adl->findOne(array("psiid"=>$psiid));


$today = date("d-m-Y");
$today_time = strtotime($today);
$po=$n->findOne(array("name"=>"portalOpening"));
if($po["Date"]==NULL)
{}
elseif (strtotime($po["Date"]) <= $today_time)
{
	$portalOpened=1;
}
//echo $_REQUEST['g1'].$_REQUEST['g2'].$_REQUEST['g3'].$_REQUEST['g4'].$_REQUEST['g5'];
//echo $portalOpened;
$r1=$n->findOne(array("name"=>"review1"));
$r1deadline=$r1["Deadline"];

$samax = date('d-m-Y', strtotime('-5 days', strtotime($r1deadline)));

$ek=$k->findOne();

//echo $_POST['g5'];

//echo $_REQUEST['g1'].$_REQUEST['g2'].$_REQUEST['g3'].$_REQUEST['g4'].$_REQUEST['g5'];
	//var_dump($_POST['d1']);
	//echo $_POST['d2'];
	//echo $_POST['d3'];
	//echo $_POST['d4'];
	
	
if($_POST['g5']==NULL && $ek["key"]==NULL)
{
$savedsatus="You have not specified the Encryption key!";
//break;	

}	
else 
{

if($_POST['g5']!=NULL)
	{
		$ek=$k->findOne();
		$k->update(array("key"=>$ek["key"]),array('$set'=>array("key"=>$_POST['g5'])));
	}
	
	$pod=$n->findOne(array("name"=>"portalOpening"));
		if($_POST['g1']==NULL)
		{}
		else{
			if(!empty($pod))
			{	
				if(($pod["Date"]===" "))
					$n->update(array("name"=>"portalOpening"),array('$set'=>array("Date"=>$_POST['g1'])));
				else 
					$n->update(array("name"=>"portalOpening"),array('$set'=>array("changed"=>"yes","Date"=>$_POST['g1'])));
			}
			else {
				$n->insert(array("name"=>"portalOpening","Date"=>$_POST['g1'],"changed"=>"no"));	
			}	
		}	

	$sa=$n->findOne(array("name"=>"selfAppraisal"));
		if($_POST['g2']==NULL)
		{}
		else{
			if(!empty($sa))
			{	
				if(($sa["Deadline"]===" "))
					$n->update(array("name"=>"selfAppraisal"),array('$set'=>array("Deadline"=>$_POST['g2'])));
				else
					$n->update(array("name"=>"selfAppraisal"),array('$set'=>array("changed"=>"yes","Deadline"=>$_POST['g2'])));
			}
			else {
				$n->insert(array("name"=>"selfAppraisal","Deadline"=>$_POST['g2'],"changed"=>"no"));	
			}	
		}

	$r1=$n->findOne(array("name"=>"review1"));
		if($_POST['g3']==NULL)
		{}
		else{
			if(!empty($r1))
			{	
				if(($r1["Deadline"]===" "))
					$n->update(array("name"=>"review1"),array('$set'=>array("Deadline"=>$_POST['g3'])));
				else
					$n->update(array("name"=>"review1"),array('$set'=>array("changed"=>"yes","Deadline"=>$_POST['g3'])));
			}
			else {
				$n->insert(array("name"=>"review1","Deadline"=>$_POST['g3'],"changed"=>"no"));	
			}	
		}
	$r2=$n->findOne(array("name"=>"review2"));
		if($_POST['g4']==NULL)
		{}
		else{
			if(!empty($r2))
			{	
				if(($r2["Deadline"]===" "))
					$n->update(array("name"=>"review2"),array('$set'=>array("Deadline"=>$_POST['g4'])));
				else
					$n->update(array("name"=>"review2"),array('$set'=>array("changed"=>"yes","Deadline"=>$_POST['g4'])));
			}
			else {
				$n->insert(array("name"=>"review2","Deadline"=>$_POST['g4'],"changed"=>"no"));	
			}	
		}

	$savedsatus="Saved Successfully";

	$today=date("d-m-Y");
	$checkpod=$n->findOne(array("name"=>"portalOpening"));
	//echo $today;

/*	
	//notifications to all employees on SA-deadline change
	if(strtotime($checkpod["Date"])<=strtotime($today))
	{
		$a=$n->findOne(array("name"=>"selfAppraisal"));
		if($a["changed"]==="yes")
		{
			$employeeIDs=$a["employee IDs"];	
			for($i=0;$i<count($employeeIDs);$i++)
			{
				$saObj=$bd->findOne(array("psiid"=>$employeeIDs[$i]));
				$empmailid=$saObj["emailID"];
				$to= $empmailid;
				$message="The last date for Self-Appraisal completion has been extended to ".$a["Deadline"];
				$mail->Host       = "mail.paxterrasolutions.com";
				$mail->Port = 26; 
				$mail->Username   = "rajesh.bn@paxterrasolutions.com"; // HR account name
				$mail->Password   = "4riteCos";  //HR password
				$mail->addAddress($to, $name);
				$mail->setFrom('malini.int@paxterrasolutions.com', 'Malini'); //HR mailid
				//$mail->SMTPAuth = true;
				//$mail->SMTPDebug =2;
				$mail->Subject = 'E-PAS Self-Appraisal deadline changed';
				$mail->Body = $message;
				$mail->Send();
				$mail->ClearAddresses();
			}
		}
	}
*/
	//notifications to reviewer-1 on deadline change
	if(strtotime($checkpod["Date"])<=strtotime($today))
	{
		$a=$n->findOne(array("name"=>"review1"));
		if($a["changed"]==="yes")
		{
			$reviewer1IDs=$a["reviewer IDs"];	
			for($i=0;$i<count($reviewer1IDs);$i++)
			{
				$r1Obj=$coll->findOne(array("r1id"=>$reviewer1IDs[$i]));
				$r1mailid=$r1Obj["r1emailid"];
				$to= $r1mailid;
				$message="The last date for review-1 completion has been extended to ".$a["Deadline"];
				$mail->Host       = "mail.paxterrasolutions.com";
				$mail->Port = 26; 
				$mail->Username   = "paxsustenance@paxterrasolutions.com"; // HR account name
				$mail->Password   = "P@ssword";  //HR password
				$mail->addAddress($to, $name);
				$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS'); //HR mailid
				$mail->SMTPAuth = true;
				$mail->SMTPDebug =2;
				$mail->Subject = 'E-PAS Goal Review-1 deadline changed';
				$mail->Body = $message;
				$mail->Send();
				$mail->ClearAddresses();
			}	
		}
	}

	//notifications to reviewer-2 on deadline change
	if(strtotime($checkpod["Date"])<=strtotime($today))
	{
		$a=$n->findOne(array("name"=>"review2"));
		if($a["changed"]==="yes")
		{
			$reviewer2IDs=$a["reviewer IDs"];	
			for($i=0;$i<count($reviewer2IDs);$i++)
			{
				$r2Obj=$coll->findOne(array("r2id"=>$reviewer2IDs[$i]));
				$r2mailid=$r1Obj["r2emailid"];
				$to= $r1mailid;
				$message="The last date for review-2 completion has been extended to ".$a["Deadline"];
				$mail->Host       = "mail.paxterrasolutions.com";
				$mail->Port = 26; 
				$mail->Username   = "paxsustenance@paxterrasolutions.com"; // HR account name
				$mail->Password   = "P@ssword";  //HR password
				$mail->addAddress($to, $name);
				$mail->setFrom('paxsustenance@paxterrasolutions.com', 'E-PAS'); //HR mailid
				//$mail->SMTPAuth = true;
				//$mail->SMTPDebug =2;
				$mail->Subject = 'E-PAS Goal Review-2 deadline changed';
				$mail->Body = $message;
				$mail->Send();
				$mail->ClearAddresses();
			}	
		}
	}

}


?>
