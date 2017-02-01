<?php
session_start();include session_timeout.php;
require('auth.php');
require_once('PHPMailer-master/PHPMailerAutoload.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SendMail transport
$mail->Debugoutput = 'html';		//Optional
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'stylesheets.php'; ?>

<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

<style>
.btn
{
margin:5px;
}
</style>
</head>

<body onload="myfun()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$coll=$db->currentGoalCycle;
$n=$db->Notifications;
$bd=$db->BasicDetails;
$adl=$db->adminlist;
//$k=$db->encryptionkey;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$status=$_GET["status"];

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

//echo $portalOpened;
$r1=$n->findOne(array("name"=>"review1"));
$r1deadline=$r1["Deadline"];
$samax = date('d-m-Y', strtotime('-5 days', strtotime($r1deadline)));
//$ek=$k->findOne();

if(isset($_POST["savegoaldates"]))
{

	//var_dump($_POST['d1']);
	//echo $_POST['d2'];
	//echo $_POST['d3'];
	//echo $_POST['d4'];
	
	/*
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
	} */
	
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
			$mail->SMTPAuth = true;
			$mail->SMTPDebug =2;
				$mail->Subject = 'E-PAS Goal Review-2 deadline changed';
				$mail->Body = $message;
				$mail->Send();
				$mail->ClearAddresses();
			}	
		}
	}

//}
}
?>


<section id="container" >
<?php include 'headerandsidebar.php'; ?>    	       	  

	<!-- **********************************************************************************************************************************************************
	MAIN CONTENT
	*********************************************************************************************************************************************************** -->

<!--main content start-->
<section id="main-content">
<section class="wrapper">
<h3>Goal Timeline Settings</h3>
<div class="row mt">
<div class="col-lg-12">
<div class="content-panel">
<section id="unseen">
<center>
<form class="form-horizontal style-form" method="POST" action="">
<label class="col-sm-2 control-label col-lg-2">Goal Start Date:</label>
<div class="col-lg-5">
<?php
$po=$n->findOne(array("name"=>"portalOpening"));
if($po["Date"]===" " || $po["Date"]==NULL)
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers" id="g1" name="g1" placeholder="DD-MM-YYYY">';
	echo '</div>';
}
else 
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers d" id="g1" name="g1" readonly="readonly" value="'.$po["Date"].'">';
	echo '</div>';
}
?>                                               
</div>
<div class="span4"> 
	<?php
if($portalOpened==1)
{}
else {
	//echo '<a class="btn btn-theme03 btn-sm col-sm-1" onclick="return changeGod()">Change</a>';
}
?>
</div>

<br><br><br><br>            



<div class="row-fluid">  
<label class="col-sm-2 control-label col-lg-2">Goal Closure Date:</label>
<div class="col-lg-5">
<?php
$sa=$n->findOne(array("name"=>"selfAppraisal"));
if($sa["Deadline"]===" " || $sa["Deadline"]==NULL)
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers sad" id="g2" name="g2" placeholder="DD-MM-YYYY">';
	echo '</div>';
}
else
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers sad d" id="g2" name="g2" readonly="readonly" value="'.$sa["Deadline"].'">';
	echo '</div>';
}
?>

</div>
<div class="row-fluid"> 
<!--<a class="btn btn-theme03 btn-sm col-sm-1"  onclick="return extendallgoal();">Extend All</a>-->
<!--<a class="btn btn-theme03 btn-sm col-sm-2"  onclick="goalextend();">Selective Extend</a>--> 
</div>           

</div>


<br><br> <br><br>  
<!--                
<div class="row-fluid"> 
<label class="col-sm-2 control-label col-lg-2">Goal Review 1 Closure Date:</label>
<div class="col-lg-5">
<?php
$r1=$n->findOne(array("name"=>"review1"));
if($r1["Deadline"]===" " || $r1["Deadline"]==NULL)
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers" id="g3" name="g3" placeholder="DD-MM-YYYY">';
	echo '</div>';
}
else
{
	echo '<div class="input-group date">';
	echo '<input size="25" class="datetimepickers d" id="g3" name="g3" readonly="readonly" value="'.$r1["Deadline"].'">';
	echo '</div>';
}
?>

</div>
<div> 
<a class="btn btn-theme03 btn-sm col-sm-1" onclick="return r1GoalExtended()">Extend</a>
</div>
</div>             
<br><br><br><br>                   

<label class="col-sm-2 control-label col-lg-2">Goal Review 2 Closure Date:</label>
<div class="col-lg-5">
<?php
$r2=$n->findOne(array("name"=>"review2"));
if($r2["Deadline"]===" " || $r2["Deadline"]===NULL)
{
	echo '<div class="input-append date" data-date="02-02-2015">';
	echo '<input size="25" class="datetimepickers" id="g4" name="g4" placeholder="DD-MM-YYYY">';
	echo '</div>';
}
else
{
	echo '<div class="input-append date" data-date="02-02-2015">';
	echo '<input size="25" class="datetimepickers d" id="g4" name="g4" readonly="readonly" value="'.$r2["Deadline"].'">';
	echo '</div>';
}
?>

</div>  
<div class="span4"> 
<a class="btn btn-theme03 btn-sm col-sm-1" onclick="return r2GoalExtended()">Extend</a>
</div>

<br><br><br><br>

-->											
</div>  
                                                                                 
<br><br><br>

<div class="row-fluid">
<div class="span20" style="text-align:center">
<button type="submit" class="btn btn-theme03 btn-sm pull-center" name="savegoaldates" value="submit"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>

</div>
<?php 
echo '<p><b><h5 style="color:hotpink">'.$savedsatus.'</h5></b></p>';
?>								  
</form>                      

<div class="row mt" style="margin-top:9px;">
<div class="col-lg-12">
<div class="content-panel">
<section id="no-more-tables">
<center>

<?php 
echo '<p><b><h5 style="color:hotpink">'.$status.'</h5></b></p>';
?>								  

<form class="form-horizontal" action="insertgoallibrary.php" method="post" enctype="multipart/form-data">
<div class="form-group">
<label style="color:red">Upload .xls file </label> <br>
<input type="file" name="libfile" accept=".xls" />
</div> <br>
<button class="btn btn-theme03 btn-sm" disabled="disabled" type="submit" name="lib" value="lib"><i class="fa fa-spinner"></i>
&nbsp Upload</button>
</form> 

</center>
</section>		  
</div>	  					 
</div>
</div>


<div class="row-mt" style="margin-bottom:-90px;width:103%;margin-left:-14px;padding-top:5px;">
<div class="col-lg-12">
<div class="content-panel">
<center>
<!--<button class="btn btn-theme02 btn-md" onclick="publish()"><i class="fa fa-arrows"></i>
PUBLISH</button>-->
</center>
<br><br></br>
</div></div></div>

</section><! --/wrapper -->
<!-- /MAIN CONTENT -->
</section>

<div id="message" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">          

<center><h4><p id="ms"></p></h4></center>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>  
</div>
</div>
</div>
</div>


<div id="myModal1" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<form role="form">
<h4><center>"This is to test"</center></h4>
<div class="modal-footer">
<a class="btn btn-info close" data-dismiss="modal" name="ok">OK</a>
</div>
</form>
</div>
</div>
</div>
</div>


	<?php 
if(isset($status))
{ ?>
	<script type="text/javascript">
		$(document).ready(function()
				{
				alert("status");
				$('#mymodal1').modal('show');
				}
				);
	</script>
		<?php }
		?>

	<!--main content end-->

		<!--footer start-->
<?php include 'footer.php'; ?>     
		<!--footer end-->
		</section>

		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.js"></script> 

		<!-- js placed at the end of the document so the pages load faster -->
		<!--		<script src="assets/js/jquery.js"></script> -->
		<script src="moment-2.8.4/moment.js"></script>     
		<!--	<script src="assets/js/bootstrap.min.js"></script>  -->
		<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

		<!--common script for all pages-->
		<script src="assets/js/common-scripts.js"></script>
		<script src="bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>
		<!--script for this page-->

		<script>
		//custom select box
		$(function(){
				$('select.styled').customSelect();
				});
function checklen()
{
var e=$('#g5').val();
if(e.length < 6)
alert("The Encryption Key should have atleast 6 characters");
}

</script>

<script type="text/javascript" >
var currentdate = new Date(); 
var today = currentdate.getDate() + "-"
+ (currentdate.getMonth()+1)  + "-" 
+ currentdate.getFullYear();
//alert(datetime);

var samax="<?php echo $samax; ?>";
$('.sad').datetimepicker({
format:"DD-MM-YYYY",
minDate:today,

});

$('.datetimepickers').datetimepicker({
format:"DD-MM-YYYY",
minDate:today,
});

$('.d').prop('disabled',true);
function myfun()
{
}
</script>

	<script type="text/javascript" >

/*goal enabled */
function changeGod()
{
	
	$('#g1').prop("readonly",false);
	$('#g1').prop('disabled',false);			
	return false;
}
function r1GoalExtended()
{
	$('#g3').prop("readonly",false);	
	$('#g3').prop('disabled',false);		
	return false;
}
function r2GoalExtended()
{
	$('#g4').prop("readonly",false);
	$('#g4').prop('disabled',false);		
	return false;
}
function goalextend()
{
	window.open("extendsadeadline.php");
}
function extendallgoal()
{
	$('#g2').prop("readonly",false);	
	$('#g2').prop('disabled',false);	
}
function changegoalkey()
{
$('#g5').prop("readonly",false);	
$('#g5').prop('disabled',false);	
return false;
}


/*-------------------*/
</script>

	<script type="text/javascript" >
function check()
{
	var role="<?php echo $role; ?>";
	if ( role.indexOf("emp") > -1 ) 
		window.location.href="selfassessmentform.php";
	else 
		alert("You are not part of this review cycle.");
}
</script>

	<script type="text/javascript" >
function publish()
{
	$.ajax({ 
url:'publish.php', 
type:'POST', 
success:function(data){ 
document.getElementById("ms").innerHTML=data;	
$("#message").modal('show');
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert(err); 
} 
});
//window.location.href="publish.php";
}
</script>

</body>
</html>
