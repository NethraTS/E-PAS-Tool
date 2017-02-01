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
<style>
 .Button
    {
        margin:5px;
    }
    </style>
<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
var rv={"E- low":1,"E- mid":2,"E- high":3,"E low":4,"E mid":5,"E high":6,"E+ low":7,"E+ mid":8,"E+ high":9,"X":10};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({min:1,max:10});
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
$('#r3sv').slider( "option", "value",rv[$('#r3sv').attr("name")]); //to set slider value
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

$view=$_GET["view"];
$psiid=$_GET["eid"];
$d=$c->findOne(array("psiid"=>$psiid));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$_SESSION["psiid"]));

$f=0;
$d=$c->findOne(array("psiid"=>$psiid));
if($d["postponedFlag"]>="1")
$f=1;
elseif($d["flag2"]>="8")
$f=5;
elseif($d["flag2"]>="6")
$f=4;
elseif($d["flag2"]>="4" && $d["flag1"]>="4")
$f=3;
elseif($d["flag2"]>="2" && $d["flag1"]>="2")
$f=2;
//echo $f;
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
echo '<li class="sub-menu"><a href="goal.php" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if ($role==="emp") 	       
{                  
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="selfassessmentform.php">Start Self-Assessment</a></li>';
echo '<li><a  href="performancehistory.php">Performance History</a></li>';
echo '</ul></li>';
}
elseif (strpos($role,'r') !== false) 	       
{
echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()">Start Self-Assessment</a></li>';
echo '<li><a  href="review1list.php">Reviews Overview</a></li>';
echo '<li><a  href="performancehistory.php">Performance History</a></li>';
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
<?php
echo '<label class="col-lg-3 col-sm-3 col-xs-3 control-label"><b>Personal comments/ Suggestions</b></label>';
echo '<div class="col-sm-6 col-xs-6 col-lg-6">';
if($f>=2)
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["personalcomments"]).'</p>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
echo '</div>';
//echo '<textarea readonly="readonly" rows="3" cols="70">'.$d["personalcomments"].'</textarea>';
?>

<br><br><br><br><br>
										<br><br><br>
<?php
echo '<label class="col-lg-3 col-sm-3 col-xs-3 control-label">Reviewer 1 Feedback</label>';
echo '<div class="col-sm-6 col-xs-6 col-lg-6">';
if($f>=3)
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["r1 feedback"]).'</p>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
echo '</div>';
//echo '<textarea readonly="readonly" rows="3" cols="70">'.$d["r1 feedback"].'</textarea>';
?>
                              
<br><br><br><br><br>										<br><br><br>
										
 <?php
echo '<label class="col-lg-3 col-sm-3 col-xs-3 control-label">Reviewer 2 Feedback</label>';
echo '<div class="col-sm-6 col-xs-6 col-lg-6">';
if($f>=4)
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["r2 feedback"]).'</p>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
echo '</div>';
?>
<br><br><br><br><br>
										<br><br><br><br>
 
<?php
echo '<label class="col-lg-3 col-sm-3 col-xs-3 control-label">Reviewer 3 Feedback</label>';
echo '<div class="col-sm-6 col-xs-6 col-lg-6">';
if($f>=5)
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px;">'.decrypt($d["r3 feedback"]).'</p>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
echo '</div>';
?>
<br><br><br>										<br><br><br>
<?php                               
if($view=="emp")
echo '<div style="display:none;">';
else 
echo '<div>';
?>
 <label class="col-sm-2 col-sm-2 control-label"><b>Overall Ratings :</b></label>
 <div class="col-sm-9">
 </div>
 <br><br><br>
 
 <?php
echo '<label class="col-sm-2 col-sm-2 control-label">Self </label>';
if($f>=2)
echo '<div class="saslider col-lg-2 green noslider green" id="sasv" name="'.decrypt($d["overallselfrating"]).'"></div>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
?>		          

                              <br><br><br>
<?php
echo '<label class="col-sm-2 col-sm-2 control-label">Reviewer 1 </label>';
if($f>=3)
echo '<div class="slider col-lg-2 green noslider green" id="r1sv" name="'.decrypt($d["overall R1rating"]).'"></div>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
?>		          
                             
										<br><br><br>
<?php
echo '<label class="col-sm-2 col-sm-2 control-label">Reviewer 2 </label>';
//echo '<div class="col-sm-5">';
if($f>=4)						    
echo '<div class="slider col-lg-2 green noslider green" id="r2sv" name="'.decrypt($d["overall R2rating"]).'"></div>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
//echo '</div>';
?>		          
                               <br><br><br>                           
<?php
echo '<label class="col-sm-2 col-sm-2 control-label">Reviewer 3 </label>';
//echo '<div class="col-sm-5">';
if($f>=5)
echo '<div class="slider green col-lg-2 noslider green" id="r3sv" name="'.decrypt($d["overall R3rating"]).'"></div>';
else 
echo '<p class="form-control-static" style="word-wrap: break-word;min-width: 80px;max-width: 600px; color:orange">Pending</p>';
//echo '</div>';
?>		          
</div>
                  
                  
<?php 

if($view=="emp")
{
echo '<label class="col-sm-2 col-sm-2 control-label" style="color:fuchsia;">Normalised Rating : </label>';
echo '<p class="form-control-static" style="color:fuchsia;font-size:16px;"><b>'.decrypt($d["normalisedRating"]).'</b></p>';
echo '<br><br><br><br><br><br><br>';
echo '<div style="display:none;">';
}
else 
{
	echo '<br><br><br>';
echo '<label class="col-sm-2 col-sm-2 control-label">Normalised Rating : </label>';
echo '<p class="form-control-static"><b>'.decrypt($d["normalisedRating"]).'</b></p>';
echo '<br><br><br><br><br><br><br>';
echo '<div>';
}
?>

<?php
if($f>=3)
{
if($d["proposedAction"]["name"]==="promotion")
echo '<label class="col-sm-6 control-label"><b>REVIEWER 1-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMOTION</b></label>';
elseif($d["proposedAction"]["name"]==="role_change") 
echo '<label class="col-sm-6 control-label"><b>REVIEWER 1-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspROLE CHANGE</b></label>';
else 
echo '<label class="col-sm-6 control-label"><b>REVIEWER 1-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-</b></label>';
}
?>
<?php
if($f>=4)
{
if($d["R2proposedAction"]["name"]==="promotion")
echo '<label class="col-sm-6 control-label"><b>REVIEWER 2-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMOTION</b></label>';
elseif($d["R2proposedAction"]["name"]==="role_change")
echo '<label class="col-sm-6 control-label"><b>REVIEWER 2-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspROLE CHANGE</b></label>';
else 
echo '<label class="col-sm-6 control-label"><b>REVIEWER 2-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-</b></label>';
}
?>
<br><br>
<?php 
if($f>=3)
{
echo '<label class="col-sm-2 col-sm-2 control-label">Current Designation:</label>';	
echo '<div class="col-sm-4">';
echo '<p class="form-control-static">'.$d["designation"].'</p>';
echo '</div>';
}
if($f>=4)
{
echo '<label class="col-sm-2 col-sm-2 control-label">Current Designation:</label>';
echo '<p class="form-control-static">'.$d["designation"].'</p>';
}
?>                                                                                       
            <br>                  
<?php 
if($f>=3)
{                          
echo '<label class="col-sm-2 col-sm-2 control-label">Category :</label>';
echo '<div class="col-sm-4">';
echo '<p class="form-control-static">'.$d["proposedAction"]["category"].'</p>';
echo '</div>';
}
if($f>=4)
{                          
echo '<label class="col-sm-2 col-sm-2 control-label">Category :</label>';
echo '<p class="form-control-static">'.$d["R2proposedAction"]["category"].'</p>';
}
?><br>
<?php 
if($f>=3)
{    
echo '<label class="col-sm-2 col-sm-2 control-label">New Position :</label>';
echo '<div class="col-sm-4">';
echo '<p class="form-control-static">'.$d["proposedAction"]["newPosition"].'</p>';
echo '</div>';
}
if($f>=4)
{    
echo '<label class="col-sm-2 col-sm-2 control-label">New Position :</label>';
echo '<p class="form-control-static">'.$d["R2proposedAction"]["newPosition"].'</p>';
}
?>
<br>
<?php
if($f>=3)
{    
echo '<label class="col-sm-2 col-sm-2 control-label">Comments :</label>';
echo '<div class="col-sm-4">';
echo '<p class="form-control-static">'.$d["proposedAction"]["comments"].'</p>';
echo '</div>';
}
if($f>=4)
{    
echo '<label class="col-sm-2 col-sm-2 control-label">Comments :</label>';
echo '<p class="form-control-static">'.$d["R2proposedAction"]["comments"].'</p>';
}
?>
                          <br><br><br><br><br>                           
</div>
<?php
if($view=="emp")
{
if($d["R3proposedAction"]["name"]==="promotion" || $d["R2proposedAction"]["name"]==="promotion")
echo '<label class="col-sm-6 control-label"><b>PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMOTION</b></label>';
elseif($d["R3proposedAction"]["name"]==="role_change" || $d["R2proposedAction"]["name"]==="role_change" )
echo '<label class="col-sm-6 control-label"><b>PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspROLE CHANGE</b></label>';

echo '<br><br>';
echo '<label class="col-sm-2 col-sm-2 control-label">Current Designation:</label>';
echo '<p class="form-control-static">'.$d["designation"].'</p>';		
echo '<br>';
echo '<label class="col-sm-2 col-sm-2 ">Category :</label>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<p class="form-control-static">'.$d["R3proposedAction"]["category"].'</p>';
else 
echo '<p class="form-control-static">'.$d["R2proposedAction"]["category"].'</p>';

echo '<br>';
echo '<label class="col-sm-2 col-sm-2 ">New Position : </label>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<p class="form-control-static">'.$d["R3proposedAction"]["newPosition"].'</p>';
else
echo '<p class="form-control-static">'.$d["R2proposedAction"]["newPosition"].'</p>';
}
elseif($f>=5)
{
if($d["R3proposedAction"]["name"]==="promotion")
echo '<label class="col-sm-6 control-label"><b>REVIEWER 3-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMOTION</b></label>';
elseif($d["R3proposedAction"]["name"]==="role_change")
echo '<label class="col-sm-6 control-label"><b>REVIEWER 3-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspROLE CHANGE</b></label>';
else 
echo '<label class="col-sm-6 control-label"><b>REVIEWER 3-PROPOSED ACTION&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-</b></label>';
echo '<br><br>';
echo '<label class="col-sm-2 col-sm-2 control-label">Current Designation:</label>';
echo '<p class="form-control-static">'.$d["designation"].'</p>';		
echo '<br>';
echo '<label class="col-sm-2 col-sm-2 ">Category :</label>';
echo '<p class="form-control-static">'.$d["R3proposedAction"]["category"].'</p>';
echo '<br>';
echo '<label class="col-sm-2 col-sm-2 ">New Position : </label>';
echo '<p class="form-control-static">'.$d["R3proposedAction"]["newPosition"].'</p>';
echo '<br>';
echo '<label class="col-sm-2 col-sm-2 control-label">Comments :</label>';
echo '<p class="form-control-static">'.$d["R3proposedAction"]["comments"].'</p>';
}
?>
										<br><br><br><br><br> 
                              </form>                
                       <br><br>
  <?php 
if($view=="emp")
echo '<div style="border:solid;">';
else 
echo '<div style="display:none;">';
?>
                    
<b><h4>
<input type="checkbox" value="" id="agree" name="agree">&nbsp&nbsp
I acknowledge that I have read through and agree to the above Review results.</h4></b>

<button class="btn-sm pull-right btn-theme03 Button" onclick="accept()">Accept and Close</button>
<br><br><br>
</div>                       
                       

                       </div>
                  </div>
                  </div>

   <!-- save and submit buttons -->
<div class="row-mt">
<div class="col-lg-12" style="width:103%;margin-left:-15px;">
<div class="form-panel">
<div class="col-lg-7">           
<button type="button" class="btn btn-theme03 pull-right" onclick="viewform1()"><i class="fa fa-arrow-left"></i>Back</button> </div>
<br><br>
</div>
</div>
</div>  



		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          

							<center><h5><p id="ms">Please, Select the Checkbox to accept the results and then click the accept button.</p></h5></center>
                 
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
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->    
    
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
$('#r3feedback').prop('readonly',false);	
}    
function enableslider()
{
$('#r3sv').slider("enable");	
	} 


</script>


<script type="text/javascript" >
function viewform1()
{
var empid="<?php echo $psiid;?>";
var view="<?php echo $_GET['view']; ?>";
window.location.href="viewform1.php?eid="+empid+"&view="+view;	
}	
</script>  
<script type="text/javascript" >
function accept()
{
var checkedvalue=document.getElementById("agree").checked;
if(checkedvalue)
{
var id="<?php echo $_SESSION['psiid']; ?>";
//alert(id);
$.ajax({ 
url:'finish.php', 
type:'POST', 
data:{"psiid":id,"role":"emp"},
success:function(data){ 
window.location.href="dashoboard.php";
},
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
}
else
{
$("#message").modal('show');
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
