<?php
session_start();include session_timeout.php;
include 'secure.php';
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="paxterra" >
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>EPAS</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

<!--     <link href="slider/css/slider.css" rel="stylesheet">
	<link href="jQuery-ui-Slider-Pips-master/src/css/jquery-ui-slider-pips.css" rel="stylesheet">     

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="Gritter-master/css/jquery.gritter.css" rel="stylesheet">
      <link rel="stylesheet" href="slider/jquery-ui.css"> 
<script src="slider/jquery-1.10.2.js"></script> 
<script src="slider/jquery-ui.js"></script>
<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 
<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
var rv={"":0,"E- low":1,"E- mid":2,"E- high":3,"E low":4,"E mid":5,"E high":6,"E+ low":7,"E+ mid":8,"E+ high":9,"X":10};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({
	min:1,
	max:10,
	});

$('.qslider').slider({min:1,max:5});

// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','','','E','','','E+','','','X'],  
    prefix: "",  
    suffix: ""  
    
});

$('.qslider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['1','2','3','4','5'],  
    prefix: "",  
    suffix: ""      
});

$('.saslider').slider({min:1,max:4});
$('.noslider').slider("disable");

$('.saslider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','E','E+','X'],  
    prefix: "",  
    suffix: ""  
    
});


$('#1').slider( "option", "value",$('#1').attr("name")); 
$('#2').slider( "option", "value",$('#2').attr("name")); 
$('#3').slider( "option", "value",$('#3').attr("name")); 
$('#4').slider( "option", "value",$('#4').attr("name")); 
$('#5').slider( "option", "value",$('#5').attr("name")); 
$('#6').slider( "option", "value",$('#6').attr("name")); 
$('#7').slider( "option", "value",$('#7').attr("name")); 
$('#8').slider( "option", "value",$('#8').attr("name")); 
$('#9').slider( "option", "value",$('#9').attr("name")); 
$('#10').slider( "option", "value",$('#10').attr("name")); 
$('#11').slider( "option", "value",$('#11').attr("name")); 
$('#12').slider( "option", "value",$('#12').attr("name")); 


//selfrating values
$('#sasv').slider( "option", "value",ar[$('#sasv').attr("name")]); //to set slider value

$('#r1sv').slider( "option", "value",rv[$('#r1sv').attr("name")]); //to set slider value

});
</script>

  </head>

<body onload="load()">
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$cat=$db->designationCategories;

$psiid=$_GET["eid"];

$d=$c->findOne(array("psiid"=>$psiid));

$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$_SESSION["psiid"]));

$f=0;

if($d["flag2"]=="2")
{
$f=2;	
}
elseif($d["flag2"]=="3") 
{
$f=3;	
}	
elseif($d["flag2"]>="4")
{
$f=4;	
}

$meetingdate=$d["r1MeetingDate"];
//$meetingdate="11-03-2015 1:00 PM";
$exp=explode(" ",$meetingdate);

$mt=$exp[1]." ".$exp[2];
$mtfinal= date("G:i", strtotime($mt));

$today=date("d-m-Y");
$now = date("H:i");
//echo $now;
//echo $exp[0]."   ";echo $today."  ";
//echo $mtfinal."   ";echo $now."      ";
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
//echo '<li class="sub-menu"><a href="goal.php" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if ($role==="emp") 	       
{                  
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href="goalHistory.php">Goal History</a></li>';
echo '</ul></li>';               
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="selfassessmentform.php">Start Self-Assessment</a></li>';
echo '<li><a  href="reviewHistory.php">Past Reviews</a></li>';
echo '</ul></li>';
}
elseif (strpos($role,'r') !== false) 	       
{
	echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href=" gmanagerlist.php#">Goal Overview</a></li>';
echo '<li><a  href="goalHistory.php">Goal History</a></li>';
echo '</ul></li>'; 
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()">Start Self-Assessment</a></li>';
echo '<li><a  href="review1list.php">Current Review</a></li>';
echo '<li><a  href="reviewHistory.php">Past Reviews</a></li>';
echo '</ul></li>';
}
if($admin==="HRM")
{
echo '<li class="sub-menu"><a><i class="fa fa-tasks"></i><span>Admin Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="adminsettings.php">Timeline Settings</a></li>';
echo '<li><a  href="goaladminsettings.php">Goal Timeline Settings</a></li>';
echo '<li><a  href="addadmins.php">Add New Admins</a></li>';
echo '<li><a  href="editadminlist.php">Edit Admin List</a></li>';
echo '<li><a  href="hrviewlist.php">Appraisal Employee List</a></li>';
echo '<li><a  href="employeedetails.php">Goals Employee List</a></li>';
echo '<li><a  href="gradesandweights.php">Grades and Weights</a></li>';
echo '<li><a  href="startnewreviewcycle.php">New Review Cycle</a></li>';
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
echo '<li><a  href="startnewreviewcycle.php">New Review Cycle</a></li>';
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
<?php
echo '<h3>'.$d["name"].'</h3>';
?>

          	<p class="pull-right">Page 2</p>
            
            
<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">           		 
                  	  <h4 class="mb" data-toggle="tooltip" data-placement="top" data-original-title="Give your deliverable goals and accomplishements">Questionnaire </h4>
                      <form class="form-horizontal style-form" method="get">
                                  <label class="col-sm-1"><b>1</b></label>
                                  <p class="form-static-control col-lg-6"> 
                                     I am satisfied about the work assigned to me.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="1" name="'.$d['q1'].'"></div>'; 
?>
											 </p>
<br><br><br><br>
                                 <label class="col-sm-1"><b>2</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I receive useful and constructive feedback about my work.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="2" name="'.$d['q2'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>3</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My job makes good use of my skills and abilities.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="3" name="'.$d['q3'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>4</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I was given opportunities/responsibilities at workplace.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="4" name="'.$d['q4'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>5</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My ideas and opinions count at work.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="5" name="'.$d['q5'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>6</b></label>
                                  <p class="form-static-control col-lg-6"> 
											 Information and knowledge are shared openly within the team.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="6" name="'.$d['q6'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>7</b></label>
                                  <p class="form-static-control col-lg-6"> 
												Team follows leading edge of professional and technical best practices.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="7" name="'.$d['q7'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>8</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My work is challenging, stimulating, and rewarding.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="8" name="'.$d['q8'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>9</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I am involved in decisions that affect my work.		
<?php
echo '<div class="qslider green col-lg-2 noslider" id="9" name="'.$d['q9'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>10</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My supervisor is actively interested in my professional development and advancement.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="10" name="'.$d['q10'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>11</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I work in an environment that encourages continuous learning.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="11" name="'.$d['q11'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>12</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I help the team turn strategy into quantifiable goals/actions.
<?php
echo '<div class="qslider green col-lg-2 noslider" id="12" name="'.$d['q12'].'"></div>'; 
?>
											 </p>
<br><br>											
											          
			                     
                       </form>
                       </div>
                  </div>
                  </div>                  

			  	<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Employee Review </h4>
                      <form class="form-horizontal style-form" method="get">
									<label class="col-sm-2 col-sm-2 control-label">Personal comments/ Suggestions</label>
                              <div class="col-sm-9">
<?php
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["personalcomments"]).'</p>';
//echo '<textarea readonly="readonly" rows="3" cols="70">'.$d["personalcomments"].'</textarea>';
?>
                            </div>
										<br><br><br><br><br>                                                            
                             
 <label class="col-sm-2 col-sm-2 control-label"><b>Overall Ratings :</b></label>
 <div class="col-sm-9">
 </div>
 <br><br><br>
                              <label class="col-sm-2 col-sm-2 control-label">Self </label>
                              <div class="col-sm-9">
<?php
echo '<div class="saslider col-lg-2 noslider green" id="sasv" name="'.decrypt($d["overallselfrating"]).'"></div>';
?>		          
                              </div>
                              <br><br><br>
<?php
if($meetingover==1) 
echo '<div>';
else 
echo '<div style="display:none">';						
?>				<label class="col-sm-2 col-sm-2 control-label">Reviewer 1 </label>
                             <div class="col-sm-4">
<?php
if($f==2)
{
echo '<div class="slider col-lg-5 green" id="r1sv" name=""></div>';
}
if($f==3)
{
echo '<div class="slider col-lg-5 noslider green" id="r1sv" name="'.decrypt($d["overall R1rating"]).'"></div>';
}
if($f==4)
{
echo '<div class="slider col-lg-5 noslider green" id="r1sv" name="'.decrypt($d["overall R1rating"]).'"></div>';
}
?>		          
                              </div>
<?php
if($f==3)
{
echo '<div class="col-sm-2">';
echo '<button type="button" class="btn btn-xs btn-info pull-left" onclick="enableslider()">Edit</button>';
echo '</div>';
}
?>

         <br><br>                     <br><br><br>
<?php
if($f==2)
{
echo '<input type="radio" name="radio" id="r1" value="promotion" onchange="change_promotion()">&nbsp&nbsp<label for="r1">Propose a Promotion</label><br></br>';
echo '<div id="propose_promotion1" style="">';
}
elseif($f==3)
{
if($d["proposedAction"]["name"]==="promotion")
{
echo '<input type="radio" name="radio" id="r1" checked="checked" value="promotion" onchange="change_promotion()">&nbsp&nbsp<label for="r1">Propose a Promotion</label><br></br>';
echo '<div id="propose_promotion1" style="">';
}
else 
{
echo '<input type="radio" name="radio" id="r1" value="promotion" onchange="change_promotion()">&nbsp&nbsp<label for="r1">Propose a Promotion</label><br></br>';
echo '<div id="propose_promotion1" style="">';
}
}
elseif($f==4)
{
if($d["proposedAction"]["name"]==="promotion")
{
echo '<div id="propose_promotion1" style="">';
echo '<label class="col-sm-4 control-label"><b>Proposed Action: Promotion</b></label>';
echo '<div class="col-sm-7"></div>';
echo '<br><br>';
}
else 
echo '<div id="propose_promotion1" style="display:none;">';
}	

?>
							
                               <label class="col-sm-2 col-sm-2 control-label">Current Designation</label>
                              <div class="col-sm-9">
                              
<?php		
//echo '<p class="form-control-static">'.$d["designation"].'</p>';	
echo '<p class="form-control-static">'.$d["designation"].'</p>';		
//echo '<input type="text" id="current_des1" style="width:300px" class="pull-left" readonly="readonly" value="'.$d["designation"].'">';		          
 ?>                         
                             </div>
                            
										<br><br><br>
										<label class="col-sm-2 col-sm-2 ">Category</label>
                              <div class="col-xs-3">
										<select class="form-control" name="category1" id="category1" onchange="promotion_change(this.value)">
											
<?php 
$types = $db->command(array("distinct" => "designationCategories", "key" => "category"));
if($f==2)
{
echo '<option>Category</option>';										 
foreach ($types['values'] as $type) 
echo '<option>'.$type.'</option>';
}
elseif($f==3)
{
if($d["proposedAction"]["name"]==="promotion")
{
echo '<option>'.$d["proposedAction"]["category"].'</option>';
foreach ($types['values'] as $type)
{
if($d["proposedAction"]["category"]==$type)
{}
else	
echo '<option>'.$type.'</option>';
}
}
else 
{
echo '<option>Category</option>';										 	
foreach ($types['values'] as $type) 
echo '<option>'.$type.'</option>';
}	
}
elseif($f==4)
{
if($d["proposedAction"]["name"]==="promotion")
echo '<option>'.$d["proposedAction"]["category"].'</option>';
}
?>		
										</select>
										</div>
										<br><br><br>
                              <label class="col-sm-2 col-sm-2 ">Promotion Suggestion</label>
                              <div class="col-xs-3">
	       
										<select class="form-control" name="currentposition" id="current1">
<?php 
if($f==2)
echo '<option>Proposed Position</option>';
elseif($f==3) 
{
if($d["proposedAction"]["name"]==="promotion")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';
}
elseif($f==4) 
{
if($d["proposedAction"]["name"]==="promotion")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
}
?>
										</select>
										</div>
										<br><br><br>
										<label class="col-sm-2 col-sm-2 control-label">Comments</label>
                              <div class="col-sm-9">
<?php
if($f==2)
echo '<textarea rows="3" cols="70" id="comments1"></textarea>';
elseif($f==3)
{
if($d["proposedAction"]["name"]==="promotion")
echo '<textarea rows="3" cols="70" id="comments1">'.$d["proposedAction"]["comments"].'</textarea>';
else 
echo '<textarea rows="3" cols="70" id="comments1"></textarea>';
}
elseif($f==4)
{
if($d["proposedAction"]["name"]=="promotion")
echo '<p class="form-control-static">'.$d["proposedAction"]["comments"].'</p>';	
//echo '<textarea rows="3" cols="70" id="comments1" readonly="readonly">'.$d["proposedAction"]["comments"].'</textarea>';
}
?>

                              </div>
                              </div>
										<br><br><br><br><br> 
									
										&nbsp;&nbsp;&nbsp;&nbsp;

<?php
if($f==2)
{
echo '<input type="radio" name="radio" id="r2" value="role_change" onchange="role_change()">&nbsp&nbsp<label for="r2"> Propose a role change</label><br></br>';
echo '<div id="propose_role_change1" style="">';
}
elseif($f==3)
{
if($d["proposedAction"]["name"]==="role_change")
{
echo '<input type="radio" name="radio" id="r2" checked="checked" value="role_change" onchange="role_change()">&nbsp&nbsp<label for="r2"> Propose a role change</label><br></br>';
echo '<div id="propose_role_change1" style="">';
}
else 
{
echo '<input type="radio" name="radio" id="r2" value="role_change" onchange="role_change()">&nbsp&nbsp<label for="r2"> Propose a role change</label><br></br>';
echo '<div id="propose_role_change1" style="">';
}
}
elseif($f==4)
{
if($d["proposedAction"]["name"]==="role_change")
{
echo '<div id="propose_role_change1" style="">';
echo '<label class="col-sm-4 control-label"><b>Proposed Action: Role Change</b></label>';
echo '<div class="col-sm-7"></div>';
echo '<br><br>';
}
else 
echo '<div id="propose_role_change1" style="display:none;">';
}	
?>


								 	 <label class="col-sm-2 col-sm-2 control-label">Current Designation</label>
                              <div class="col-sm-9">
<?php
echo '<p class="form-control-static">'.$d["designation"].'</p>';	
//echo '<input type="text" id="current_des2" style="width:300px" class="pull-left" readonly="readonly" value="'.$d["designation"].'">';		          
?>

                              </div>
                            
										<br><br><br>
										<label class="col-sm-2 col-sm-2 ">Category</label>
                              <div class="col-xs-3">
										<select class="form-control" name="proposed_role" id="category2" onchange="promotion_change1(this.value)">
														
<?php 
$types = $db->command(array("distinct" => "designationCategories", "key" => "category"));
if($f==2)
{
echo '<option>Category</option>';													
foreach ($types['values'] as $type) 
echo '<option>'.$type.'</option>';
}
elseif($f==3)
{
if($d["proposedAction"]["name"]==="role_change")
{
echo '<option>'.$d["proposedAction"]["category"].'</option>';
foreach ($types['values'] as $type)
{
if($d["proposedAction"]["category"]==$type)
{}
else	
echo '<option>'.$type.'</option>';
}
}
else 
{
echo '<option>Category</option>';														
foreach ($types['values'] as $type) 
echo '<option>'.$type.'</option>';
}	
}
elseif($f==4)
{
if($d["proposedAction"]["name"]==="role_change")
echo '<option>'.$d["proposedAction"]["category"].'</option>';
}
?>		
										</select>
										</div>
										<br><br><br>										
                              <label class="col-sm-2 col-sm-2 ">Proposed New Role</label>
                              <div class="col-xs-3">
										<select class="form-control" name="proposed_role" id="role1">
<?php 
if($f==2)
echo '<option>Proposed Position</option>';
elseif($f==3) 
{
if($d["proposedAction"]["name"]==="role_change")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';
}
elseif($f==4) 
{
if($d["proposedAction"]["name"]==="role_change")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
}
?>		
														
										</select>
										</div>
										<br><br><br>
										<label class="col-sm-2 col-sm-2 control-label">Comments</label>
                              <div class="col-sm-9">
<?php
if($f==2)
echo '<textarea rows="3" cols="70" id="comments2"></textarea>';
elseif($f==3)
{
if($d["proposedAction"]["name"]==="role_change")
echo '<textarea rows="3" cols="70" id="comments2">'.$d["proposedAction"]["comments"].'</textarea>';
else 
echo '<textarea rows="3" cols="70" id="comments2"></textarea>';
}
elseif($f==4)
{
if($d["proposedAction"]["name"]==="role_change")
echo '<p class="form-control-static">'.$d["proposedAction"]["comments"].'</p>';	
//echo '<textarea rows="3" cols="70" id="comments2" readonly="readonly">'.$d["proposedAction"]["comments"].'</textarea>';
}
?>

                              </div>
								</div>

	
 									<br><br><br><br><br><br>
                 					<label class="col-sm-2 col-sm-2 control-label">Overall Feedback</label>
                              <div class="col-sm-8">
<?php 
if($f==2)
{
	echo '<textarea rows="4" cols="70" maxlength="320" id="r1feedback"></textarea>';
}	
if($f==3)
{
	echo '<textarea rows="4" cols="70" maxlength="320" readonly="readonly" id="r1feedback">'.decrypt($d["r1 feedback"]).'</textarea>';
}	
if($f==4)
{
	echo '<textarea rows="4" cols="70" readonly="readonly" id="r1feedback">'.decrypt($d["r1 feedback"]).'</textarea>';
}	
?>                              </div>
<?php
if($f==3)
{
echo '<div class="col-sm-2">';
echo '<button type="button" class="btn btn-xs btn-info pull-left" onclick="enabledit()">Edit</button>';
echo '</div>';					 
}
?>
										<br><br><br><br><br>
	</div>									
                       </form>
                       </div>
                  </div>
                  </div>

   <!-- save and submit buttons -->
<div class="col-lg-12 showback" style="width:98%;margin-left:10px;">
<div class="row-mt">
<div class="col-lg-5">
<?php
if($meetingover==1)
{
if($f==4)
{
echo '<button type="button" class="btn btn-theme03 pull-left disable" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
else {
echo '<button type="button" class="btn btn-theme03 pull-left" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}}
?>	           
</div>
<div class="col-lg-2">    
<?php
if($meetingover==1)
{
if($f==4)
{ 
echo '<button type="button" class="btn btn-theme03 pull-left disable" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button> </div>';
}  
else
{ 
echo '<button type="button" class="btn btn-theme03 pull-left" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button> </div>';
}  }
?>
<div class="col-lg-5"> 
<?php 
if($meetingover==1)
echo '<button type="button" class="btn btn-theme03 pull-right" onclick="review1form1()"><i class="fa fa-floppy-o"></i>&nbspBack</button>'; 
else 
echo '<button type="button" class="btn btn-theme03 pull-left" onclick="review1form1()"><i class="fa fa-floppy-o"></i>&nbspBack</button>'; 
?>
</div>
</div>
</div>      
</div>





<div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
							              
                    <h4><center>The Employee Review has been submitted successfully!</center></h4>
                      
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-primary" name="ok" onclick="window.location.href='review1list.php?active=r1'">OK</button> 
                       </div>  
                </div>
            </div>
        </div>
    </div>
 
 <div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4><center>The Employee Review has been saved!</center></h4>
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-primary close" data-dismiss="modal" name="ok">OK</button> 
                       </div>  
                </div>
            </div>
        </div>
    </div>

<div id="conf" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body">
                 <form role="form">							             
                No changes can be made after submit. Are you sure?      
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="button" class="btn btn-primary" data-dismiss="modal" name="edit" onclick="sub()">Yes</button> 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>

			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
  <b>Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)</b>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
 <!--   <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->             
    
  <script>
      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });
  </script>

<script type="text/javascript" >
  $('.slider').slider();
  $(".disable").prop('disabled',true);  
function enabledit()
{
$('#r1feedback').prop('readonly',false);	
}    
function enableslider()
{
$('#r1sv').slider("enable");	
	} 
</script>


<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
function sav()
{
var v={1:"E- low",2:"E- mid",3:"E- high",4:"E low",5:"E mid",6:"E high",7:"E+ low",8:"E+ mid",9:"E+ high",10:"X"};	
var dsv = $( "#r1sv" ).slider( "option", "value" ); //to get slider value
var radioValue=$("input[name='radio']:checked").val();

columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[dsv];
columnvalue[columnvalue.length]=$('#r1feedback').val();

if(radioValue=="promotion")
{
columnvalue[columnvalue.length]=radioValue;
columnvalue[columnvalue.length]=$("#category1 option:selected").text();
columnvalue[columnvalue.length]=$("#current1 option:selected").text();
columnvalue[columnvalue.length]=$("#comments1").val();
}
else if(radioValue=="role_change")
{
columnvalue[columnvalue.length]=radioValue;
columnvalue[columnvalue.length]=$("#category2 option:selected").text();
columnvalue[columnvalue.length]=$("#role1 option:selected").text();
columnvalue[columnvalue.length]=$("#comments2").val();
}


for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);

$.ajax({ 
url:'r1f2insert.php', 
type:'POST', 
data:{json:unique}, 
success:function(data){ 
$("#myModal2").modal('show'); 
//alert("Saved Successfully!");
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
columnvalue=[];
}
</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};

function sub()
{
var v={1:"E- low",2:"E- mid",3:"E- high",4:"E low",5:"E mid",6:"E high",7:"E+ low",8:"E+ mid",9:"E+ high",10:"X"};		
		var dsv = $( "#r1sv" ).slider( "option", "value" ); //to get slider value
		var radioValue=$("input[name='radio']:checked").val();
columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[dsv];
if(columnvalue[1]==null)
alert("Please, provide an Overall Review1 Rating for the employee before submit.");
else 
{
columnvalue[columnvalue.length]=$('#r1feedback').val();

if(radioValue=="promotion")
{
columnvalue[columnvalue.length]=radioValue;
columnvalue[columnvalue.length]=$("#category1 option:selected").text();
columnvalue[columnvalue.length]=$("#current1 option:selected").text();
columnvalue[columnvalue.length]=$("#comments1").val();
}
else if(radioValue=="role_change")
{
columnvalue[columnvalue.length]=radioValue;
columnvalue[columnvalue.length]=$("#category2 option:selected").text();
columnvalue[columnvalue.length]=$("#role1 option:selected").text();
columnvalue[columnvalue.length]=$("#comments2").val();
}

for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);
$.ajax({ 
url:'r1f2insert.php', 
type:'POST', 
data:{json:unique}, 
success:function(data){ 
//alert(data);
var id="<?php echo $psiid; ?>";
$.ajax(
{
url:'submitr1form.php',
type:'POST',
data:{"id":id,"sub":"true"}, 
success:function(data){ 
//alert(data); 
$("#myModal1").modal('show'); 
},
failure:function(xhr,desc,err){
alert("fail");	
}
});
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
}
columnvalue=[];
}

</script>
  
<script type="text/javascript" >
function review1form1()
{
var empid="<?php echo $psiid;?>";
window.location.href="review1form1.php?eid="+empid;	
}	
</script>  

<script type="text/javascript" >
$("input[type='radio']").click(function (event) {
        // If the button is selected.
        if ($(this).hasClass("checked")) {
            // Remove the placeholder.
            $(this).removeClass("checked");
            // And remove the selection.
            $(this).removeAttr("checked");
         if(($(this).attr("value"))=="role_change")
				{
					document.getElementById("role1").disabled = true;
      			document.getElementById("category2").disabled = true; 
		      	document.getElementById("comments2").disabled = true;			
					}
			else if(($(this).attr("value"))=="promotion")
				{
					document.getElementById("current1").disabled = true;
      			document.getElementById("category1").disabled = true; 
		      	document.getElementById("comments1").disabled = true;			
					}
			            // If the button is not selected.
        } else {
            // Remove the placeholder from the other buttons.
        	  $("input[type='radio']").each(function () {
                $(this).removeClass("checked");
            });
            // And add the placeholder to the button.
            $(this).addClass("checked");
         // alert($("input[name='radio']:checked").val());  
        }
    });


      function load()
      {
      	//document.getElementById("current_des1").disabled = true;      	
        // document.getElementById("current_des2").disabled = true;
var flag="<?php echo $f; ?>";

if(flag==2)      	
{
      	document.getElementById("comments1").disabled = true;
      	document.getElementById("current1").disabled = true;
      	document.getElementById("comments2").disabled = true;
      	document.getElementById("role1").disabled = true;
      	document.getElementById("category2").disabled = true; 
      	document.getElementById("category1").disabled = true;      	     	
} 
else if(flag==3)
{
var radioVal=$("input[name='radio']:checked").val();
if(radioVal==="promotion")
change_promotion();
else if(radioVal==="role_change")
role_change();
else 
{
      	document.getElementById("comments1").disabled = true;
      	document.getElementById("current1").disabled = true;
      	document.getElementById("comments2").disabled = true;
      	document.getElementById("role1").disabled = true;
      	document.getElementById("category2").disabled = true; 
      	document.getElementById("category1").disabled = true;      	     	
	
}
}
else if(flag==4)
{
      	document.getElementById("current1").disabled = true;
      	document.getElementById("role1").disabled = true;
      	document.getElementById("category2").disabled = true; 
      	document.getElementById("category1").disabled = true;      	     	
}
} 
 
      function change_promotion() 
{
      	//document.getElementById("current_des1").disabled = true;			
      	//document.getElementById("current_des2").disabled = true;
      	document.getElementById("comments1").disabled = false;
      	document.getElementById("current1").disabled = false;
      	document.getElementById("comments2").disabled = true;
      	document.getElementById("role1").disabled = true;
      	document.getElementById("category2").disabled = true;
      	document.getElementById("category1").disabled = false;      	     	      	
}

function role_change() 
{
      	//document.getElementById("current_des1").disabled = true;
			//document.getElementById("current_des2").disabled = true;      	
			document.getElementById("comments1").disabled = true;
      	document.getElementById("current1").disabled = true;
      	document.getElementById("comments2").disabled = false;
      	document.getElementById("role1").disabled = false;
      	document.getElementById("category2").disabled = false;
      	document.getElementById("category1").disabled = true;      	     	
}
function promotion_change(str) {
 if (str.length == 0) {
  document.getElementById("current1").innerHTML = "Current Position";
  return;
 } else {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("current1").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "get_promotion.php?category=" + str, true);
 xmlhttp.send();
 }
}
function promotion_change1(str) {
 if (str.length == 0) {
  document.getElementById("current1").innerHTML = "Current Position";
  return;
 } else {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("role1").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "get_promotion1.php?category=" + str, true);
 xmlhttp.send();
 }
}


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

  </body>
</html>
