 <?php
session_start();//include session_timeout.php;
include 'secure.php';
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="PAX" >
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>EPAS</title>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

   <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
   <script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#tablehr').dataTable();
	 } );
   </script>  

	<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<style type="text/css">
.btn
{
    margin-left: 20px;
}
</style>



     </head>
  

  <body>

<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$d=$db->BasicDetails;
$nt=$db->Notifications;

$rev1=$nt->findOne(array("name"=>"review1"));
$r1deadline=$rev1["Deadline"];

$psiid=$_SESSION["psiid"];
$n=$c->findOne(array("r1id"=>$psiid));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];


$r1name=$n["r1name"];
$active=$_GET["active"];
if(!empty($active))
{}
else 
$active=substr($role,0,2);

//echo $active;
//echo $r1name;

$list=$c->find(array("r1name"=>$r1name));
$emplist=array();
$cnt=1;
$postponedcomment=0;

foreach($list as $det){
$empid=$det["psiid"];

$e=$d->findOne(array("psiid"=>$empid));
$empname=$e["name"];

if($det["postponedFlag"]=="1") 
{
$selfappraisal="postponed";
}
elseif($det["postponedFlag"]>="2")
{
$selfappraisal="postponed";
$postponedcomment=1;	
}
elseif($det["flag1"]>="2" && $det["flag2"]>="2")
{      
$selfappraisal=decrypt($det["overallselfrating"]);
}
else
{
$selfappraisal="pending";
}
//echo $empname;
//echo $selfappraisal;

if($det["r1MeetingMailSent"]=="1")
$r1mailsent=1;

$meetingdate=$det["r1MeetingDate"];
//$meetingdate="11-03-2015 1:00 PM";
$exp=explode(" ",$meetingdate);

//echo $meetingdate;

$mt=$exp[1]." ".$exp[2];
$mtfinal= date("G:i", strtotime($mt));
$today=date("d-m-Y");
$now = date("H:i");
//echo $now;
//echo $exp[0]."   ";
//echo $today."  ";
//echo $mtfinal."   ";
//echo $now."      ";
if($meetingdate=="")
$meetingover=0;
else 
{
if(strtotime($exp[0]) >= strtotime($today))
{
if(strtotime($exp[0]) == strtotime($today))
{
if(strtotime($mtfinal) <= strtotime($now))
$meetingover=1;
else 
$meetingover=0;
}
else 
$meetingover=0;
}
else 
$meetingover=1;
}

$emplist[$cnt]=array("psiid"=>$empid,
"name"=>$empname,
"sa"=>$selfappraisal,
"Mdate"=>$meetingdate,
"f1"=>$det["flag1"],
"f2"=>$det["flag2"],
"ppc"=>$postponedcomment,
"mo"=>$meetingover,
);
//echo $emplist[$cnt]["mo"];
//echo $emplist[$cnt]["psiid"];
//echo $emplist[$cnt]["sa"];
//echo $emplist[$cnt]["ppc"];
$cnt++;
}

$doc=$d->findOne(array("psiid"=>$psiid));
$finalised="0";
$r3f=$nt->findOne(array("name"=>"review3"));
if(in_array($psiid,$r3f["finalisedIDs"]))
$finalised="1";


?>
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a class="logo"><img src="paxterralogo.png" height='40px'></img></a>
            <!--logo end-->

            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Sign Out</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a><img src="assets/img/user.png" class="img-circle" width="40"></a></p>
              	  
<?php 
echo '<h5 class="centered">'.$name.'</h5>';
echo '<h5 class="centered">'.$_SESSION["psiid"].'</h5>';
echo '<li class="mt"><a href="dashoboard.php"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>';
//echo '<li class="sub-menu"><a href="#" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if ($role==="emp") 	       
{                  
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href="goalHistory.php">Goal History</a></li>';
echo '</ul></li>';               
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()" data-toggle="tooltip" title="Start Self-Assessment">Self-Assessment</a></li>';
echo '<li><a  href="reviewHistory.php">Past Reviews</a></li>';
}
elseif (strpos($role,'r') !== false) 	       
{
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href=" gmanagerlist.php#">Goal Overview</a></li>';
echo '<li><a  href="goalHistory.php">Goals History</a></li>';
echo '</ul></li>';
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()" data-toggle="tooltip" title="Start Self-Assessment">Self-Assessment</a></li>';
echo '<li><a  href="review1list.php">Current Review</a></li>';
echo '<li><a  href="reviewHistory.php">Past Review</a></li>';
}

if($admin==="HRM")
{
echo '<li class="sub-menu"><a><i class="fa fa-tasks"></i><span>E-PAS Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="adminsettings.php">Timeline </a></li>';
echo '<li><a  href="addadmins.php">Add Admins</a></li>';
echo '<li><a  href="editadminlist.php">Edit Admin </a></li>';
echo '<li><a  href="hrviewlist.php">View List</a></li>';
echo '<li><a  href="startnewreviewcycle.php" data-toggle="tooltip" title="Start a New Review Cycle">New Review</a></li>';
echo '</ul></li>';

echo '<li class="sub-menu"><a><i class="fa   fa-bullseye  fa-4x"></i><span>Goals Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="goaladminsettings.php">Timeline </a></li>';
echo '<li><a  href="employeedetails.php">View List</a></li>';
echo '<li><a  href="gradesandweights.php">Grades/Weights</a></li>';
echo '</ul></li>';
}
elseif($admin==="HRA")
{ 
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href="gmanagerlist.php">Goal Overview</a></li>';
echo '<li><a  href="#">Goal History</a></li>';
echo '</ul></li>';
 
echo '<li class="sub-menu"><a><i class="fa fa-tasks"></i><span>Admin Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="hradminsettings.php">Upload Data</a></li>';
echo '<li><a  href="goaladminsettings.php">Goal Timeline Settings</a></li>';
echo '<li><a  href="addadmins.php">Add New Admins</a></li>';
echo '<li><a  href="editadminlist.php">Edit Admin List</a></li>';
echo '<li><a  href="hrviewlist.php">Appraisal Employee List</a></li>';
echo '<li><a  href="employeedetails.php">Goals Employee List</a></li>';
echo '<li><a  href="gradesandweights.php">Grades and Weights</a></li>';
echo '<li><a  href="startnewreviewcycle.php" data-toggle="tooltip" title="Start a New Review Cycle">New Review Cycle</a></li>';
echo '</ul></li>';
}
?>


                </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
    
          
              	<div class="row mt">
<button class="btn pull-left btn-theme03" onclick="location.reload(true)"><i class="fa fa-refresh"></i>Refresh</button>      
        
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  
                <div class="bs-example">
    <ul class="nav nav-tabs">

<?php
if($active=="r1")
{
if (strpos($role,'r1') !== false) 
echo '<li class="active"><a data-toggle="tab" href="#review1">Review 1 </a></li>';
if (strpos($role,'r2') !== false) 
echo '<li><a data-toggle="tab" href="#review2">Review 2 </a></li>';
if (strpos($role,'r3') !== false) 
echo '<li><a data-toggle="tab" href="#review3">Review 3 </a></li>';
}
elseif($active=="r2")
{
if (strpos($role,'r1') !== false) 	
echo '<li><a data-toggle="tab" href="#review1">Review 1 </a></li>';
if (strpos($role,'r2') !== false) 
echo '<li class="active"><a data-toggle="tab" href="#review2">Review 2 </a></li>';
if (strpos($role,'r3') !== false) 
echo '<li><a data-toggle="tab" href="#review3">Review 3 </a></li>';
}
elseif($active=="r3")
{
if (strpos($role,'r1') !== false) 	
echo '<li><a data-toggle="tab" href="#review1">Review 1 </a></li>';
if (strpos($role,'r2') !== false) 
echo '<li><a data-toggle="tab" href="#review2">Review 2 </a></li>';
if (strpos($role,'r3') !== false)
echo '<li class="active"><a data-toggle="tab" href="#review3">Review 3 </a></li>';
}
?>  
        </ul> <br><br>
    <div class="tab-content">

<?php 
if($active=="r1")
echo '<div id="review1" class="tab-pane fade in active">';
else 
echo '<div id="review1" class="tab-pane fade">';

?>
                 <table class="table" id="rev1">
		                          <thead>                       
		                               <tr>
								 					 <th>Name</th>
								  					 <th>Self-Appraisal</th>
								 					 <th>Schedule a Meeting</th>
							 				    </tr>
		                        
		                          </thead>
		                          <tbody>

<?php
$dp=1;
$sortedEmpNames=array();
for($i=1;$i<$cnt;$i++)
{	
array_push($sortedEmpNames,$emplist[$i]["name"]);	
}
sort($sortedEmpNames);

for($j=0;$j<count($sortedEmpNames);$j++)
{
for($i=1;$i<$cnt;$i++)
{
	if($emplist[$i]["name"]==$sortedEmpNames[$j])
	{
$cmt=$c->findOne(array("psiid"=>$emplist[$i]["psiid"]));	
echo '<tr  class="center" id="'.$emplist[$i]["psiid"].'">';
echo '<td>'.$emplist[$i]["name"].'</td>';
if($emplist[$i]["sa"]=="postponed")
{
echo '<td><p style="background-color:pink;display:inline-block;">'.$emplist[$i]["sa"].'</p></td>';
if($emplist[$i]["ppc"]==1)
{
echo '<td>';
echo 'Reviewer 1 Comment: '.$cmt["r1PostponementComment"];
echo '</td>';
echo '<td>';
echo 'Reviewer 2 Comment: '.$cmt["r2PostponementComment"];
echo '</td>';
}
else {
echo '<td>';
echo '<button type="button" class="btn btn-primary btn-xs" onclick="pop(this)" ><i class="fa fa-cog"></i>Click to Comment</button>';
echo '</td>';
}
}
elseif($emplist[$i]["sa"]==="pending")
{
echo '<td><p style="background-color:yellow;display:inline-block;">'.$emplist[$i]["sa"].'</p></td>';
echo '<td>';
echo '<div class="col-sm-6">';
echo '<div class="input-group date" id="datetimepicker'.$i.'">';
echo '<input size="25" class="datetimepickers d" id="d'.$i.'" onblur="savedate(this)" placeholder="Click Here..">';
echo '</div></div></td>';
}
else if($emplist[$i]["f1"]>="4" && $emplist[$i]["f2"]>="4")
{
echo '<td>'.$emplist[$i]["sa"].'</td>';	
echo '<td>';
echo '<div class="col-sm-6">';
echo '<div class="input-group date">';
echo '<input size="25" class="datetimepickers d" id="d'.$i.'" onblur="savedate(this)" placeholder="Click Here.." value="'.$emplist[$i]["Mdate"].'"/>';
echo '</div></div></td>';
echo '<td>';
echo '<button type="button" class="btn btn-theme03 btn-xs" id="'.$i.'" onclick="reviewform1(this)"><i class="fa fa-cog"></i> View</button>';
echo '</td>';
}
else if($emplist[$i]["f1"]>="2" && $emplist[$i]["f2"]>="2")
{
echo '<td>'.$emplist[$i]["sa"].'</td>';	
echo '<td>';
echo '<div class="col-sm-6">';
echo '<div class="input-group date">';

if($emplist[$i]["mo"]==1)
echo '<input size="25" class="datetimepickers d" id="d'.$i.'" onblur="savedate(this)" placeholder="Click Here.." value="'.$emplist[$i]["Mdate"].'"/>';
else 
echo '<input size="25" class="datetimepickers" id="d'.$i.'" onblur="savedate(this)" placeholder="Click Here.." value="'.$emplist[$i]["Mdate"].'"/>';

echo '</div></div></td>';
echo '<td>';
echo '<button type="button" class="btn btn-primary btn-xs" name="'.$i.'" onclick="notify(this)" ><i class="fa fa-cog"></i>Notify</button>';
//echo '<button type="button" class="btn btn-primary btn-xs" onclick="filledform1(this)";><i class="fa fa-eye"></i>&nbspView</button>';
echo '<button type="button" class="btn btn-theme03 btn-xs" id="'.$i.'" onclick="reviewform1(this)"><i class="fa fa-cog"></i> Review</button>';
echo '</td>';
}
else if($emplist[$i]["f1"]>"2" || $emplist[$i]["f2"]>"2")
{
echo '<td>'.$emplist[$i]["sa"].'</td>';		
echo '<td>';
echo '<div class="col-sm-6">';
echo '<div class="input-group date">';
echo '<input size="25" class="datetimepickers d" id="d'.$i.'" onblur="savedate(this)" placeholder="Click Here.." value="'.$emplist[$i]["Mdate"].'"/>';
echo '</div></div></td>';
echo '<td>';
echo '<button type="button" class="btn btn-theme03 btn-xs" id="'.$i.'" onclick="reviewform1(this)"><i class="fa fa-cog"></i>Review</button>';
echo '</td>';
}
echo '</tr>';
}
}
}
?>
								</tbody>
		                 </table>
          

       
        
</div><!--review 1-->
        
 <?php 
if($active=="r2")
echo '<div id="review2" class="tab-pane fade in active">';
else 
echo '<div id="review2" class="tab-pane fade">';
?>
        <table class="table" id="rev2">
						  <thead>
							  <tr>
								  <th>Manager Name</th>
								  <th>Completed Reviews</th>
								  <th>Pending Reviews</th>
								  <th>Total Reviews</th>
								  <th>My Reviews</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php

$myr1list=array();
$doc = $c->find(array("r2id"=>$psiid));
foreach($doc as $d)
{
$r1id=$d["r1id"];
array_push($myr1list,$r1id);
}

$totalcount=count($myr1list);
$myr1list=array_unique($myr1list);
//echo $totalcount." ";
//var_dump($myr1list);


foreach($myr1list as $r1l)
{
$pendingcount=0;
$completedcount=0;
$totalcount=0;
$r2completed=0;

$r1res=$c->find(array("r1id"=>$r1l,"r2id"=>$psiid));
foreach($r1res as $result)
{
$managername=$result["r1name"];

if($result["postponedFlag"]>="1")
{
$completedcount++;
$totalcount++;
}
elseif($result["flag1"]>="4" && $result["flag2"]>="4")
{
$completedcount++;
$totalcount++;
}
elseif($result["flag1"]<"4" || $result["flag2"]<"4")
{
$pendingcount++;
$totalcount++;
}

if($result["flag2"]>="6")
$r2completed++;
}
echo '<tr id="'.$r1l.'">';
echo '<td>'.$managername.'</td>';
echo '<td><a class="btn" onclick="completed(this)" href="#">'.$completedcount.'</a></td>';
echo '<td><a class="btn" onclick="pending(this)" href="#">'.$pendingcount.'</a></td>';
echo '<td><a>'.$totalcount.'</a></td>';
echo '<td><a>'.$r2completed.' / '.$totalcount.'</a></td>';
echo '</tr>';
}
?>


						  </tbody>
					  </table>            
<br><br><br>
<div class="row-fluid showback" style="margin-bottom:-90px;width:102%;margin-left:-9px;">
<div class="col-lg-7">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='r2viewlist.php'"><i class="fa fa-eye"></i>&nbspView List</button>
</div>
<br><br>
</div>       
          
 </div>    <!-- end - review 2 list-->
 
             
 <?php 
if($active=="r3")
echo '<div id="review3" class="tab-pane in active">';
else 
echo '<div id="review3" class="tab-pane fade">';
?>
<div class="row-mt" style="margin-top:-80px">
<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Filter <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a onclick="nalist()"><i class="glyphicon glyphicon-exclamation-sign">&nbsp;Need-Attention</i></a></li>
            <li><a onclick="pplist()"><i class="glyphicon glyphicon-repeat">&nbsp;Postponed</i></a></li>
            <li><a onclick="prlist()"><i class="glyphicon glyphicon-star-empty">&nbsp;Promoted / Rolechange</i></a></li>
            <li><a onclick="enlist()"><i class="glyphicon glyphicon-list">&nbsp;All</i></a></li>
           </ul>
        </li>
      </ul>

	<div class="pull-right col-sm-1"><div style="width:12px;height:12px;background-color:lightgreen;">
	</div>Promotion</div>

	<div class="pull-right col-sm-1" style="width:10.999%"><div style="width:12px;height:12px;background-color:orange;">
	</div>Role change</div>

	<div class="pull-right col-sm-1" style="width:12.99%"><div style="width:12px;height:12px;background-color:red;">
	</div>Need Attention </div>
	
	<div class="pull-right col-sm-1"><div style="width:12px;height:12px;background-color:pink;">
	</div>Postponed </div>


	
	
</div>
<br><br><br><br>

          		<table class="table" id="tablehr" style="text-align:center">

					  <thead>
							  <tr>
							     <th style="text-align:center;">PSI-ID</th>
								  <th style="text-align:center;">Name</th>
								  <th style="text-align:center;">Designation</th> 
								  <th style="text-align:center;">Self-Appraisal</th>
								  <th style="text-align:center;">Reviewer 1</th>
								  <th style="text-align:center;">R1 Rating</th>
								  <th style="text-align:center;">Reviewer 2</th>
								  <th style="text-align:center;">R2 Rating</th>
								  <th style="text-align:center;">Normalised Rating</th>
								  <th style="text-align:center;">Promotion / Role Change</th>
								  <th style="text-align:center;">Action</th>
								  </tr>
						  </thead>   
						  <tbody>

<?php
$r3doc=$c->find(array("r3id"=>$psiid));
foreach($r3doc as $el)
{
echo '<tr>';
echo '<td>';
if($el["needAttentionbyR3"]===1)
echo '<p style="background-color:red;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["postponedFlag"]>=1)
echo '<p style="background-color:pink;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R3proposedAction"]["name"]==="promotion")	
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R3proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R2proposedAction"]["name"]==="promotion")	
echo '<p style="background-color:lightgreen;display:inline-block;">'.$el["psiid"].'</p>';
elseif($el["R2proposedAction"]["name"]==="role_change")
echo '<p style="background-color:orange;display:inline-block;">'.$el["psiid"].'</p>';
else 
echo '<p>'.$el["psiid"].'</p>';

echo '</td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["designation"].'</td>';

if($el["flag1"]>="2" && $el["flag2"]>="2")
	echo '<td>'.decrypt($el["overallselfrating"]).'</td>';
else 
	{
	if($el["postponedFlag"]>="1")	
		echo '<td>postponed</td>';
	else 
	   echo '<td>pending</td>';
	}
	
echo '<td>'.$el["r1name"].'</td>';

if($el["flag1"]>="4" && $el["flag2"]>="4")
	echo '<td>'.decrypt($el["overall R1rating"]).'</td>';
else 
	{
	if($el["postponedFlag"]>="1")	
		echo '<td><p style="display:none">'.$el["r1PostponementComment"].'</p>-</td>';
	else 
	   echo '<td>pending</td>';
	}
echo '<td>'.$el["r2name"].'</td>';
if($el["flag2"]>="6")
{
if($el["flag2"]>"6" && decrypt($el["overall R3rating"]) != "")	
echo '<td>'.decrypt($el["overall R3rating"]).'</td>';
else 
echo '<td>'.decrypt($el["overall R2rating"]).'</td>';
}
else 
	{
	if($el["postponedFlag"]>="1")	
	echo '<td><p style="display:none">'.$el["r2PostponementComment"].'</p>-</td>';
	else 
	   echo '<td>pending</td>';
	}

echo '<td>'.decrypt($el["normalisedRating"]).'</td>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R3proposedAction"]["newPosition"].'</td>';
elseif($el["R2proposedAction"]["name"]==="promotion" || $el["R2proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R2proposedAction"]["newPosition"].'</td>';
else 
echo '<td>-</td>';

if($el["postponedFlag"]>="1")	
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="viewppc(this)"><i class="fa fa-cog"></i>View</button></td>';
elseif($el["flag2"]>="8")
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i> View</button></td>';
elseif($el["flag2"]<"6")
echo '<td><button type="button" class="btn btn-theme03 btn-xs d" onclick="review3form1(this)"><i class="fa fa-cog"></i> Review</button></td>';
else
echo '<td><button type="button" class="btn btn-theme03 btn-xs" onclick="review3form1(this)"><i class="fa fa-cog"></i> Review</button></td>';
echo '</tr>';
} 
?>
					  </tbody>
					  </table>  
					  
					  <div class="row-fluid">
      			    <div id="pageNavPosition" style="padding-top: 20px" align="center">
		          		<br><br>
							</div></div>

<br><br><br>

<!--<div class="col-lg-12 showback" style="width:97.5%;margin-left:12px;">-->
<div class="row-fluid showback" style="margin-bottom:-90px;width:102%;margin-left:-9px;">
<div class="col-lg-5">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadTable.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div>
<div class="col-lg-2">
</div>
<div class="col-lg-5">
<button type="button" class="btn btn-theme03 pull-left dis" onclick="finalise()"><i class="fa fa-check"></i>Finalize the List</button>
</div>

 <br><br></div>

        </div>
        
     </div><!--tab content-->
</div><!-- example-->     
              </div>
              </div>
              </div>    
                 

   <!-- save and submit buttons -->


		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->

<div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Postponement Reason/Comment</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="r1postponedcomment.php">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="hiddenid" id="hiddenid">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Comment Box </label>
                            <textarea class="form-control" id="comment" name="comment" rows=3></textarea>
                        </div>
                                              
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" name="submit">Submit</button> 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>


<div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Postponement Reason/Comment</h4>
                </div>
                <div class="modal-body">
                 <form role="form">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="postponedid" id="postponedid">
                        </div>
                        <div class="form-group"> 
                          <label> R1 comment: </label>
									<p class="form-control-static" id="r1c"></p>
									</div>                          
									<div class="form-group"> 
                          <label> R2 comment: </label>
									<p class="form-control-static" id="r2c"></p>
									</div>                          

                                              
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>


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

      <!--footer start-->
      <footer class="site-footer">
           <div class="text-center">
  <b>Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)</b>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--  <script src="assets/js/jquery.js"></script> -->
  	<script src="moment-2.8.4/moment.js"></script>    
   <script src="assets/js/bootstrap.min.js"></script>
   <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>  
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script> 
    <script src="assets/js/jquery.scrollTo.min.js"></script> 
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script> 
    <!--common script for all pages-->
  <script src="assets/js/common-scripts.js"></script>
    <!--script for this page-->

  

   <script src="bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>
  <script>
      var finalised="<?php echo $finalised; ?>";
      if(finalised=="1")
 $(".dis").prop('disabled',true);      

    $(function(){
          $('select.styled').customSelect();
      });
     
//setTimeout("location.reload(true);", 5000);
   
  </script>
  
 
<script type="text/javascript" >
function savedate(it)
{
var empid=$(it).parent().parent().parent().parent().attr('id');
var scheduleddate=$(it).val();
$.ajax({
url:'savemeetingdate.php',
type:'POST',
data:{'id':empid,'Mdate':scheduleddate},
success:function(data)
{
//alert(data);
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});
}
</script>  

<script type="text/javascript" >
function notify(th)
{
	
var empid=$(th).parent().parent().attr('id');
var dpid=$(th).attr('name');
var selected=$('#d'+dpid).val();
var msg1="1 on 1 meeting with the employee not scheduled!";
if(selected.length==0)
{
document.getElementById("ms").innerHTML=msg1;	
$("#message").modal('show');
//alert(msg1);
}
else 
{

$.ajax({
url:'notifymeeting.php',
type:'POST',
data:{'id':empid},
success:function(data){
	
document.getElementById("ms").innerHTML="The employee has been notified.";	
$("#message").modal('show');
alert("The employee has been notified");
},
failure:function(xhr,desc,err){
alert("fail");
}
});
}
}
</script>

<script type="text/javascript" >
var currentdate = new Date(); 
var today = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() +"-" 
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes();
var r1deadline="<?php echo $r1deadline; ?>";
//alert(r1deadline);

$('.datetimepickers').datetimepicker({
format:"DD-MM-YYYY h:m A",
minDate:today,
maxDate:r1deadline
	});
$('.d').prop('disabled',true);
</script>

<script type="text/javascript">
function filledform1(it)
{
var empid=$(it).parent().parent().attr('id');
//alert(empid);
window.location.href="filledform1.php?eid="+empid;
}

</script>
  
<script type="text/javascript" >
function reviewform1(it)
{
//var dpid=$(it).attr('id');
//alert(dpid);
var empid=$(it).parent().parent().attr('id');
//alert(empid);
window.location.href="review1form1.php?eid="+empid;
}


</script>  

<script type="text/javascript" >
function pop(th)
{
var empid=$(th).parent().parent().attr('id');
document.getElementById("hiddenid").value=empid;
$("#myModal2").modal('show');
}
</script>

<script type="text/javascript" >
function completed(th)
{
var r1id=$(th).parent().parent().attr('id');
window.location.href="completedList.php?r1id="+r1id+"&active=c";
}
function pending(th)
{
var r1id=$(th).parent().parent().attr('id');
window.location.href="completedList.php?r1id="+r1id+"&active=p";
}
</script>


<script type="text/javascript" >
function review3form1(it)
{
var tr=$(it).parent().parent();
var empid=$('td:eq(0)',tr).children().first().html();
//alert(empid);
window.location.href="review3form1.php?eid="+empid;	
}
function viewppc(th)
{
var tr=$(th).parent().parent();
var empid=$('td:eq(0)',tr).children().first().html();
var r1c=$('td:eq(5)',tr).children().first().html();
var r2c=$('td:eq(7)',tr).children().first().html();
document.getElementById("postponedid").value=empid;
document.getElementById("r1c").innerHTML=r1c;
document.getElementById("r2c").innerHTML=r2c;
$("#myModal1").modal('show');
}
</script>

<script type="text/javascript" >
function nalist()
{

var str="na";
var r3id="<?php echo $psiid; ?>";
//alert(r3id);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
	}
function pplist()
{

var str="pp";
var r3id="<?php echo $psiid; ?>";
//alert(r3id);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
}
function prlist()
{

var str="pr";
var r3id="<?php echo $psiid; ?>";
//alert(str);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
	}
function enlist()
{
	//alert("ds");
window.location.href="review1list.php?active=r3";
}
</script>


<script type="text/javascript">

function Pager(tableName, itemsPerPage) {
this.tableName = tableName;
this.itemsPerPage = itemsPerPage;
this.currentPage = 1;
this.pages = 0;
this.inited = false;
this.showRecords = function(from, to) {
var rows = document.getElementById(tableName).rows;

// i starts from 1 to skip table header row
for (var i = 1; i < rows.length; i++) {
if (i < from || i > to)
rows[i].style.display = 'none';
else
rows[i].style.display = '';
}
}
this.showPage = function(pageNumber) {
if (! this.inited) {
alert("not inited");
return;
}

var oldPageAnchor = document.getElementById('pg'+this.currentPage);
oldPageAnchor.className = 'pg-normal';
this.currentPage = pageNumber;
var newPageAnchor = document.getElementById('pg'+this.currentPage);
newPageAnchor.className = 'pg-selected';
var from = (pageNumber - 1) * itemsPerPage + 1;
var to = from + itemsPerPage - 1;
this.showRecords(from, to);
}

this.prev = function() {
if (this.currentPage > 1)
this.showPage(this.currentPage - 1);
}

this.next = function() {
if (this.currentPage < this.pages) {
this.showPage(this.currentPage + 1);
}
}

this.init = function() {
var rows = document.getElementById(tableName).rows;
var records = (rows.length - 1);
this.pages = Math.ceil(records / itemsPerPage);
this.inited = true;
}

this.showPageNav = function(pagerName, positionId) {
if (! this.inited) {
alert("not inited");
return;
}
var element = document.getElementById(positionId);
var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> « Prev </span> ';
for (var page = 1; page <= this.pages; page++)
pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> ';
pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next »</span>';
element.innerHTML = pagerHtml;
}
}
</script>

<script type="text/javascript">
var pager = new Pager('tablepaging', 10);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
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
function finalise()
{
var psid="<?php echo $psiid; ?>";
$.ajax({ 
url:'finalise.php', 
type:'POST', 
data:{"psiid":psid}, 
success:function(data){ 
document.getElementById("ms").innerHTML=data;	
$("#message").modal('show');
 
//alert("The list has been finalised.");

}, 
error:function(xhr,desc,err){ 
alert(err); 
} 
});

}
</script>
<!--<Script References>-->


  </body>
</html>
