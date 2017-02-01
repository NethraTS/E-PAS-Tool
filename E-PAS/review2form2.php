<?php
session_start();
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

 <!--    <link href="slider/css/slider.css" rel="stylesheet">
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
	max:10});
// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','','','E','','','E+','','','X'],  
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

//selfrating values
$('#sasv').slider( "option", "value",ar[$('#sasv').attr("name")]); //to set slider value
$('#r1sv').slider( "option", "value",rv[$('#r1sv').attr("name")]); //to set slider value
$('#r2sv').slider( "option", "value",rv[$('#r2sv').attr("name")]); //to set slider value
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
$r1id=$_GET["r1id"];
$d=$c->findOne(array("psiid"=>$psiid));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$_SESSION["psiid"]));

$f=0;

if($d["flag2"]=="4")
{
$f=2;	
}
elseif($d["flag2"]=="5") 
{
$f=3;	
}	
elseif($d["flag2"]>="6")
{
$f=4;	
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
echo '<li class="sub-menu"><a href="#" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if ($role==="emp") 	       
{                  
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="selfassessmentform.php">Start Self-Assessment</a></li>';
echo '<li><a  href="#">Performance History</a></li>';
echo '</ul></li>';
}
elseif (strpos($role,'r') !== false) 	       
{
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()">Start Self-Assessment</a></li>';
echo '<li><a  href="review1list.php">Reviews Overview</a></li>';
echo '<li><a  href="#">Performance History</a></li>';
echo '</ul></li>';
}

if($admin==="HRM")
{
echo '<li class="sub-menu"><a><i class="fa fa-tasks"></i><span>Admin Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="adminsettings.php">Timeline Settings</a></li>';
echo '<li><a  href="addadmins.php">Add New Admins</a></li>';
echo '<li><a  href="editadminlist.php">Edit Admin List</a></li>';
echo '<li><a  href="hrviewlist.php">View List</a></li>';
echo '<li><a  href="startnewreviewcycle.php">New Review Cycle</a></li>';
echo '</ul></li>';
}
elseif($admin==="HRA")
{ 
echo '<li class="sub-menu"><a><i class="fa fa-tasks"></i><span>Admin Settings</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="hradminsettings.php">Upload Data</a></li>';
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
                  	  <h4 class="mb">Employee Review</h4>
                      <form class="form-horizontal style-form" method="get">
									<label class="col-sm-2 col-sm-2 control-label">Personal comments/ Suggestions</label>
                              <div class="col-sm-9">
<?php
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["personalcomments"]).'</p>';
//echo '<textarea readonly="readonly" rows="3" cols="70">'.$d["personalcomments"].'</textarea>';
?>

                              </div>
										<br><br><br><br><br> 
										<label class="col-sm-2 col-sm-2 control-label">Reviewer 1 Feedback</label>
                              <div class="col-sm-9">
<?php
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["r1 feedback"]).'</p>';
//echo '<textarea readonly="readonly" rows="3" cols="70">'.$d["r1 feedback"].'</textarea>';
?>
                              </div>
										<br></br><br><br><br>                                                          
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
										<label class="col-sm-2 col-sm-2 control-label">Reviewer 1 </label>
                              <div class="col-sm-9">
<?php
echo '<div class="slider col-lg-2 noslider green" id="r1sv" name="'.decrypt($d["overall R1rating"]).'"></div>';
?>		          

                              </div>
                              <br><br><br>
                              <label class="col-sm-2 col-sm-2 control-label">Reviewer 2 </label>
                              <div class="col-sm-4">
<?php
if($f==2)
{
echo '<div class="slider col-lg-5 green" id="r2sv" name=""></div>';
}
if($f==3)
{
echo '<div class="slider col-lg-5 noslider green" id="r2sv" name="'.decrypt($d["overall R2rating"]).'"></div>';
}
if($f==4)
{
echo '<div class="slider col-lg-5 noslider green" id="r2sv" name="'.decrypt($d["overall R2rating"]).'"></div>';
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

                              <br><br><br><br><br><br>
<?php

if($d["proposedAction"]["name"]=="promotion")
echo '<label class="col-sm-12 control-label"><b>REVIEWER 1 PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMOTION</b></label>';
elseif($d["proposedAction"]["name"]=="role_change") 
echo '<label class="col-sm-12 control-label"><b>REVIEWER 1 PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspROLE CHANGE</b></label>';
else 
echo '<label class="col-sm-12 control-label"><b>REVIEWER 1 PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp-</b></label>'; 
?>
										<BR><BR><BR>
									<label class="col-sm-2 col-sm-3 control-label">Current Designation:</label>
                              <div class="col-sm-8">
<?php 
echo '<p class="form-control-static">'.$d["designation"].'</p>';
?>
                              </div>
                              <br><br><br>
									<label class="col-sm-2 col-sm-2 control-label">Category :</label>
                              <div class="col-sm-9">
<?php 
echo '<p class="form-control-static">'.$d["proposedAction"]["category"].'</p>';

?>
                              </div>
                              <br><br><br>
									<label class="col-sm-2 col-sm-2 control-label">New Position :</label>
                              <div class="col-sm-9">
<?php 
echo '<p class="form-control-static">'.$d["proposedAction"]["newPosition"].'</p>';
?>
                              </div>
                              <br><br><br>
									<label class="col-sm-2 col-sm-2 control-label">Comments :</label>
                              <div class="col-sm-9">
<?php 
echo '<p class="form-control-static">'.$d["proposedAction"]["comments"].'</p>';
?>
                              </div>
                                <br><br>                            
										<br><br>

<label class="col-sm-2 col-sm-2 control-label"><b>REVIEWER 2 :</b></label>
 <div class="col-sm-9">
 </div>
 <br><br><br>
 

<?php
if($f==2)
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
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="promotion")
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
if($d["R2proposedAction"]["name"]==="promotion")
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
if($d["proposedAction"]["name"]==="promotion")
{
echo '<option>'.$d["proposedAction"]["category"].'</option>';		
foreach ($types['values'] as $type){
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
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="promotion")
{
echo '<option>'.$d["R2proposedAction"]["category"].'</option>';
foreach ($types['values'] as $type)
{
if($d["R2proposedAction"]["category"]==$type)
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
if($d["R2proposedAction"]["name"]==="promotion")
echo '<option>'.$d["R2proposedAction"]["category"].'</option>';
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
{
if($d["proposedAction"]["name"]==="promotion")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';
}
elseif($f==3) 
{
if($d["R2proposedAction"]["name"]==="promotion")
echo '<option>'.$d["R2proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';
}
elseif($f==4) 
{
if($d["R2proposedAction"]["name"]==="promotion")
echo '<option>'.$d["R2proposedAction"]["newPosition"].'</option>';
}
?>

										</select>
										</div>
										<br><br><br>
										<label class="col-sm-2 col-sm-2 control-label">Comments</label>
                              <div class="col-sm-9">
<?php
if($f==2)
{
echo '<textarea rows="3" cols="70" id="comments1"></textarea>';
}
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="promotion")
echo '<textarea rows="3" cols="70" id="comments1">'.$d["R2proposedAction"]["comments"].'</textarea>';
else 
echo '<textarea rows="3" cols="70" id="comments1"></textarea>';
}
elseif($f==4)
{
if($d["R2proposedAction"]["name"]==="promotion")
echo '<p class="form-control-static">'.$d["R2proposedAction"]["comments"].'</p>';
//echo '<textarea rows="3" cols="70" id="comments1" readonly="readonly">'.$d["R2proposedAction"]["comments"].'</textarea>';
}
?>

                              </div>
                              </div>
										<br><br><br><br><br> 
									
										&nbsp;&nbsp;&nbsp;&nbsp;

<?php
if($f==2)
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
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="role_change")
{
echo '<input type="radio" name="radio" id="r2" checked="checked" value="role_change" onchange="role_change()">&nbsp&nbsp<label for="r2"> Propose a role change</label><br></br>';
echo '<div id="propose_role_change1" style="">';
}
else 
{
echo '<input type="radio" name="radio" id="r2" value="role_change" onchange="role_change()">&nbsp&nbsp<label for="r2">Propose a role Change</label><br></br>';
echo '<div id="propose_role_change1" style="">';
}
}
elseif($f==4)
{
if($d["R2proposedAction"]["name"]==="role_change")
{
echo '<div id="propose_role_change1" style="">';
echo '<label class="col-sm-4 control-label"><b>Proposed Action: Role Change</b></label>';
echo '<div class="col-sm-7"></div>';
echo '<br><br>';
}
else 
echo '<div id="propose_role_change1" class="ds" style="display:none;">';
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
if($d["proposedAction"]["name"]==="role_change")
{
echo '<option>'.$d["proposedAction"]["category"].'</option>';		
foreach ($types['values'] as $type){ 
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
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="role_change")
{
echo '<option>'.$d["R2proposedAction"]["category"].'</option>';
foreach ($types['values'] as $type)
{
if($d["R2proposedAction"]["category"]==$type)
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
if($d["R2proposedAction"]["name"]==="role_change")
echo '<option>'.$d["R2proposedAction"]["category"].'</option>';
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
{
if($d["proposedAction"]["name"]==="role_change")
echo '<option>'.$d["proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';	
}
elseif($f==3) 
{
if($d["R2proposedAction"]["name"]==="role_change")
echo '<option>'.$d["R2proposedAction"]["newPosition"].'</option>';
else
echo '<option>Proposed Position</option>';
}
elseif($f==4) 
{
if($d["R2proposedAction"]["name"]=="role_change")
echo '<option>'.$d["R2proposedAction"]["newPosition"].'</option>';
}
?>		

														
										</select>
										</div>
										<br><br><br>
										<label class="col-sm-2 col-sm-2 control-label">Comments</label>
                              <div class="col-sm-9">
<?php
if($f==2)
{
echo '<textarea rows="3" cols="70" id="comments2"></textarea>';
}
elseif($f==3)
{
if($d["R2proposedAction"]["name"]==="role_change")
echo '<textarea rows="3" cols="70" id="comments2">'.$d["R2proposedAction"]["comments"].'</textarea>';
else 
echo '<textarea rows="3" cols="70" id="comments2"></textarea>';
}
elseif($f==4)
{
if($d["R2proposedAction"]["name"]==="role_change")
echo '<p class="form-control-static">'.$d["R2proposedAction"]["comments"].'</p>';
//echo '<textarea rows="3" cols="70" id="comments2" readonly="readonly">'.$d["R2proposedAction"]["comments"].'</textarea>';
}
?>

                              </div>
								</div>
								
<br><br><br><br><br><br><br><br>								
							
&nbsp&nbsp&nbsp&nbsp&nbsp
<?php
if($f==2)
{
	echo '<input type="checkbox" value="" id="needattention" name="needattention">';
	echo '<b> &nbsp&nbsp&nbsp&nbspNeed Attention by Reviewer-3</b>';
}
elseif($f==3)
{
if($d["needAttentionbyR3"]==1)
{
	echo '<input type="checkbox" value="" id="needattention" name="needattention" checked>';
	echo '<b> &nbsp&nbsp&nbsp&nbspNeed Attention by Reviewer-3</b>';
}	
else
{
	echo '<input type="checkbox" value="" id="needattention" name="needattention">';
	echo '<b> &nbsp&nbsp&nbsp&nbspNeed Attention by Reviewer-3</b>';
}
}	
elseif($f==4)
{
if($d["needAttentionbyR3"]==1)
{
	echo '<input type="checkbox" readonly="readonly" value="" id="needattention" name="needattention" checked>';
	echo '<b> &nbsp&nbsp&nbsp&nbspNeed Attention by Reviewer-3</b>';
}	
}										
?>
	<br><br><br><br>
                 					<label class="col-sm-2 col-sm-2 control-label">Overall Feedback</label>
                              <div class="col-sm-7">
<?php 
if($f==2)
{
	echo '<textarea rows="4" cols="70" maxlength="320" id="r2feedback"></textarea>';
}	
if($f==3)
{
	echo '<textarea rows="4" cols="70" maxlength="320" readonly="readonly" id="r2feedback">'.decrypt($d["r2 feedback"]).'</textarea>';
}	
if($f==4)
{
	echo '<textarea rows="4" cols="70" readonly="readonly" id="r2feedback">'.decrypt($d["r2 feedback"]).'</textarea>';
}	
?>
                              </div>
<?php
if($f==3)
{
echo '<div class="col-sm-2">';
echo '<button type="button" class="btn btn-xs btn-info pull-left" onclick="enabledit()">Edit</button>';
echo '</div>';					 
}
?>

										<br><br><br><br>
                       </form>
                       <br><br>
                       </div>
                  </div>
                  </div>

   <!-- save and submit buttons -->
<div class="row-mt">
<div class="col-lg-12" style="width:103%;margin-left:-15px;">
<div class="form-panel">
<div class="col-lg-3">
<?php
if($f==4)
{
echo '<button type="button" class="btn btn-theme03 pull-left disable" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
else {
echo '<button type="button" class="btn btn-theme03 pull-left" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
?>	           
<div class="col-lg-4">    
<?php
if($f==4)
{ 
echo '<button type="button" class="btn btn-theme03 pull-right disable" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square"></i>&nbspSubmit</button></div>';
}  
else
{ 
echo '<button type="button" class="btn btn-theme03 pull-right" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square"></i>&nbspSubmit</button> </div>';
}  
?>
<div class="col-lg-5">           
    <button type="button" class="btn btn-theme03 pull-right" onclick="review2form1()"><i class="fa fa-arrow-left"></i>Back</button> </div>
<br><br><br>
</div>


</div>
</div>  
</div>


		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->

<div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">							              
                    <h4><center>The Employee Review has been submitted successfully!</center></h4>           
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-primary" name="ok" onclick="completedlist()">OK</button> 
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

 
 
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   Yearly Assessment Review - <?php echo date("Y"); ?>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
 <!--   <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>-->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <!--script for this page-->
<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->    
    
  <script>
      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });

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
var flag="<?php echo $f; ?>";

if(flag==2 || flag==3)
{
var radioVal=$("input[name='radio']:checked").val();
if(radioVal=="promotion")
change_promotion();
else if(radioVal=="role_change")
role_change();
else 
{
      	document.getElementById("current1").disabled = true;
      	document.getElementById("role1").disabled = true;
      	document.getElementById("category2").disabled = true; 
      	document.getElementById("category1").disabled = true;
      	document.getElementById("comments1").disabled = true;      	     	
			document.getElementById("comments2").disabled = true;      	     		      	    	
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
			document.getElementById("comments1").disabled = false;
      	document.getElementById("current1").disabled = false;
      	//document.getElementById("current_des1").disabled = true;
      	document.getElementById("comments2").disabled = true;
      	document.getElementById("role1").disabled = true;
      	//document.getElementById("current_des2").disabled = true;
      	document.getElementById("category2").disabled = true;
      	document.getElementById("category1").disabled = false;      	     	      	
}

function role_change() 
{
			document.getElementById("comments1").disabled = true;
      	document.getElementById("current1").disabled = true;
      	//document.getElementById("current_des1").disabled = true;
      	document.getElementById("comments2").disabled = false;
      	document.getElementById("role1").disabled = false;
      	//document.getElementById("current_des2").disabled = true;
      	document.getElementById("category2").disabled = false;
      	document.getElementById("category1").disabled = true;      	     	
}
/*function promotion_change(str)
	{
	
		jQuery.ajax({
			type: "GET",
			url: "get_promotion.php?category="+str,
			cache: false,
			success: function(res){
					alert('adsf');
					jQuery('#current1').html(res);
			}
		});
	}*/
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
    $('.slider').slider();
  $(".disable").prop('disabled',true);  
function enabledit()
{
$('#r2feedback').prop('readonly',false);	
}    
function enableslider()
{
$('#r2sv').slider("enable");	
	} 


</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};

function sav()
{
var v={1:"E- low",2:"E- mid",3:"E- high",4:"E low",5:"E mid",6:"E high",7:"E+ low",8:"E+ mid",9:"E+ high",10:"X"};	
var dsv = $( "#r2sv" ).slider( "option", "value" ); //to get slider value
var radioValue=$("input[name='radio']:checked").val();
var checkedvalue=document.getElementById("needattention").checked;
if(checkedvalue)
var needattention=1;
else
var needattention=0;

columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[dsv];
columnvalue[columnvalue.length]=$('#r2feedback').val();

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
columnvalue[columnvalue.length]=needattention;

for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);

$.ajax({ 
url:'r2f2insert.php', 
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
var dsv = $( "#r2sv" ).slider( "option", "value" ); //to get slider value
var radioValue=$("input[name='radio']:checked").val();
var checkedvalue=document.getElementById("needattention").checked;
if(checkedvalue)
var needattention=1;
else
var needattention=0;

columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[dsv];
if(columnvalue[1]==null)
alert("Please, provide an Overall Review-2 Rating for the employee before submit.");
else 
{
columnvalue[columnvalue.length]=$('#r2feedback').val();

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
columnvalue[columnvalue.length]=needattention;

for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);

$.ajax(
{
url:'r2f2insert.php', 
type:'POST', 
data:{json:unique}, 
success:function(data){ 
var id="<?php echo $psiid; ?>";
$.ajax(
{
url:'submitr2form.php',
type:'POST',
data:{"id":id,"sub":"true"}, 
success:function(data){ 
//	alert(data); 
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
function review2form1()
{
var empid="<?php echo $psiid;?>";
var r1id="<?php echo $r1id;?>";
window.location.href="review2form1.php?eid="+empid+"&r1id="+r1id;	
}	
function completedlist()
{
var r1id="<?php echo $r1id;?>";
window.location.href="completedList.php?r1id="+r1id+"&active=c";	
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
