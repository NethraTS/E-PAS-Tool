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
<style >textarea { width: 100%; }</style>
<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
var rv={"E-":1,"E- mid":2,"E- high":3,"E":4,"E mid":5,"E high":6,"E+":7,"E+ mid":8,"E+ high":9,"X":10};
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
$('#dsv').slider( "option", "value",ar[$('#dsv').attr("name")]); //to set slider value
$('#qsv').slider( "option", "value",ar[$('#qsv').attr("name")]); //to set slider value
$('#csv').slider( "option", "value",ar[$('#csv').attr("name")]); //to set slider value
$('#ocsv').slider( "option", "value",ar[$('#ocsv').attr("name")]); //to set slider value
$('#vasv').slider( "option", "value",ar[$('#vasv').attr("name")]); //to set slider value

var d=$('#r1dsv').attr("name");
//alert(rv["E"]);

$('#r1dsv').slider( "option", "value",rv[$('#r1dsv').attr("name")]); //to set slider value
$('#r1qsv').slider( "option", "value",rv[$('#r1qsv').attr("name")]); //to set slider value
$('#r1csv').slider( "option", "value",rv[$('#r1csv').attr("name")]); //to set slider value
$('#r1ocsv').slider( "option", "value",rv[$('#r1ocsv').attr("name")]); //to set slider value
$('#r1vasv').slider( "option", "value",rv[$('#r1vasv').attr("name")]); //to set slider value

});
</script>
 </head>

  <body>
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$psiid=$_GET["eid"];
$view=$_GET["view"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$_SESSION["psiid"]));


$f=0;
$d=$c->findOne(array("psiid"=>$psiid));
if($d["postponedFlag"]>="1")
$f=1;	
elseif($d["flag2"]>="4" && $d["flag1"]>="4")
$f=2;
elseif($d["flag2"]>="2" && $d["flag1"]>="2")
$f=3;

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

          	<p class="pull-right">Page 1</p>

<div class="row mt">
<div class="col-lg-12">
<?php
if($view=="hr")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="hrviewlist.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';
elseif($view=="r2")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="r2viewlist.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';
elseif($view=="emp")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="dashoboard.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';

?>
</div>
</div>

          	<div class="row mt">
          		<div class="col-lg-12">
          <!--Place your content here. -->
<!-- first table- deliverables -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Deliverables</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="deliverables">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                              <th>Reviewer 1 Comments</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php

$m=count($d["appraisal"]);	
		$dc=0;
if($f==2 || $f==3)
{
	for($j=0;$j<$m;$j++)	
	{ 
     if($d["appraisal"][$j]["parameter"]=="deliverables")
     {
     	echo '<tr class="rows" id="d'.$d["appraisal"][$j]["cnt"].'">';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
if($f==2)
echo '<td><textarea readonly="readonly" rows="6" cols="40">'.decrypt($d["appraisal"][$j]["reviewer1comment"]).'</textarea></td>';		
		$dc++;  			
  			}
   }
	echo '</tbody>';
	echo '</table>';

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="saslider col-lg-2 noslider green" id="dsv" name="'.decrypt($d["selfRatings"]["deliverables"]).'"></div>';
echo '<br><br><br>';
if($f==2)
{
echo '<label class="col-lg-2 pull-left">Reviewer 1 Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="r1dsv" name="'.decrypt($d['reviewer1Ratings']['deliverables']).'"></div>';
}
}
elseif($f==1)
{
echo "<tr><td></td><td>Postponed</td></tr>";
}
elseif($f==0)
echo "<tr><td></td><td><h4 style='color:orange'>Pending</h4></td></tr>";
?>
</tbody></table>			  
			 </div>
    		</div>

<!-- second table- quality -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Quality</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="quality">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                              <th>Reviewer 1 comments</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php

$m=count($d["appraisal"]);	
		$dc=0;
if($f==2 || $f==3)
{		
	for($j=0;$j<$m;$j++)	
	{ 
     if($d["appraisal"][$j]["parameter"]=="quality")
     {
     	echo '<tr class="rows" id="d'.$d["appraisal"][$j]["cnt"].'">';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
if($f==2)
echo '<td><textarea readonly="readonly" rows="6" cols="40">'.decrypt($d["appraisal"][$j]["reviewer1comment"]).'</textarea></td>';		
		$dc++;  			
  			}
   }
	echo '</tbody>';
	echo '</table>';

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="saslider col-lg-2 noslider green" id="qsv" name="'.decrypt($d["selfRatings"]["quality"]).'"></div>';
echo '<br><br><br>';
if($f==2)
{
echo '<label class="col-lg-2 pull-left">Reviewer 1 Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="r1qsv" name="'.decrypt($d['reviewer1Ratings']['quality']).'"></div>';
}
}
elseif($f==1)
{
echo "<tr><td>Postponed</td></tr>";
}
elseif($f==0)
echo "<tr><td></td><td><h4 style='color:orange'>Pending</h4></td></tr>";
?>
</tbody></table>			  
			  </div>
    		</div>
<!-- third table- competency -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Competency</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="competency">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
												<th>Reviewer 1 comments</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php

$m=count($d["appraisal"]);	
		$dc=0;
if($f==2 || $f==3)
{
	for($j=0;$j<$m;$j++)	
	{ 
     if($d["appraisal"][$j]["parameter"]=="competency")
     {
     	echo '<tr class="rows" id="c'.$d["appraisal"][$j]["cnt"].'">';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
if($f==2)
echo '<td><textarea readonly="readonly" rows="6" cols="40">'.decrypt($d["appraisal"][$j]["reviewer1comment"]).'</textarea></td>';		
		$dc++;  			
  			}
   }
	echo '</tbody>';
	echo '</table>';

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="saslider col-lg-2 noslider green" id="csv" name="'.decrypt($d["selfRatings"]["competency"]).'"></div>';
echo '<br><br><br>';
if($f==2)
{
echo '<label class="col-lg-2 pull-left">Reviewer 1 Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="r1csv" name="'.decrypt($d['reviewer1Ratings']['competency']).'"></div>';
}
}
elseif($f==1)
{
echo "<tr><td>Postponed</td></tr>";
}
elseif($f==0)
echo "<tr><td></td><td><h4 style='color:orange'>Pending</h4></td></tr>";
?>
</tbody></table>			  
			  </div>
    		</div>   		

<!-- fourth table- organisational contribution -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Organisational Contribution</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="orgcontribution">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                              <th>Reviewer 1 comments</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php

$m=count($d["appraisal"]);	
		$dc=0;
if($f==2 || $f==3)
{
	for($j=0;$j<$m;$j++)	
	{ 
     if($d["appraisal"][$j]["parameter"]=="organisational contribution")
     {
     	echo '<tr class="rows" id="oc'.$d["appraisal"][$j]["cnt"].'">';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="30">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="30">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
if($f==2)
echo '<td><textarea readonly="readonly" rows="6" cols="40">'.decrypt($d["appraisal"][$j]["reviewer1comment"]).'</textarea></td>';		
		$dc++;  			
  			}
   }
	echo '</tbody>';
	echo '</table>';

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="saslider col-lg-2 noslider green" id="ocsv" name="'.decrypt($d["selfRatings"]["organisationalContribution"]).'"></div>';
echo '<br><br><br>';
if($f==2)
{
echo '<label class="col-lg-2 pull-left">Reviewer 1 Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="r1ocsv" name="'.decrypt($d['reviewer1Ratings']['organisationalContribution']).'"></div>';
}
}
elseif($f==1)
{
echo "<tr><td>Postponed</td></tr>";
}
elseif($f==0)
echo "<tr><td></td><td><h4 style='color:orange'>Pending</h4></td></tr>";
?>
</tbody></table>			  
			  </div>
    		</div>   		   		

<!-- fifth table- value addition -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Value Addition</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="valueaddition">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                              <th>Reviewer 1 comments</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php

$m=count($d["appraisal"]);	
		$dc=0;
if($f==2 || $f==3)
{
	for($j=0;$j<$m;$j++)	
	{ 
     if($d["appraisal"][$j]["parameter"]=="value addition")
     {
     	echo '<tr class="rows" id="va'.$d["appraisal"][$j]["cnt"].'">';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  	   echo '<td><textarea readonly="readonly" rows="6" cols="35">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
if($f==2)
echo '<td><textarea readonly="readonly" rows="6" cols="40">'.decrypt($d["appraisal"][$j]["reviewer1comment"]).'</textarea></td>';		
		$dc++;  			
  			}
   }
	echo '</tbody>';
	echo '</table>';

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="saslider col-lg-2 noslider green" id="vasv" name="'.decrypt($d["selfRatings"]["valueAddition"]).'"></div>';
echo '<br><br><br>';
if($f==2)
{
echo '<label class="col-lg-2 pull-left">Reviewer 1 Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="r1vasv" name="'.decrypt($d['reviewer1Ratings']['valueAddition']).'"></div>';
}
}
elseif($f==1)
{
echo "<tr><td>Postponed</td></tr>";
}
elseif($f==0)
echo "<tr><td></td><td><h4 style='color:orange'>Pending</h4></td></tr>";
?>
</tbody></table>			  
				  </div>
    		</div>   		   		
    
   <!-- save and submit buttons -->
<div class="col-lg-12 showback" style="width:97.5%;margin-left:12px;">
<div class="row-mt">
<div class="col-lg-4">
<?php
if($view=="hr")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="hrviewlist.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';
elseif($view=="r2")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="r2viewlist.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';
elseif($view=="emp")
echo '<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="dashoboard.php"><i class="fa fa-arrow-left"></i>&nbspBack</button>';

?>
</div>
<div class="col-lg-3">

</div>
<div class="col-lg-5">
<button type="button" class="btn btn-theme03 pull-right" onclick="viewform2()"><i class="fa fa-arrow-right"></i>&nbspNext</button> 
</div>
</div>

</div>  
  
  
          	</div>	</div> 		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   Yearly Assessment Review - <?php echo date("Y"); ?>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <!--<script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>         
  		-->
  		<script src="Gritter-master/js/jquery.gritter.js"></script>
 <script src="Gritter-master/js/jquery.gritter.min.js"></script>
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

<script type="text/javascript" >
    $('.slider').slider();
    $(".disable").prop('disabled',true);
$(".noslider").slider('disable');
</script>


<script type="text/javascript" >
function viewform2()
{
var empid="<?php echo $psiid;?>";
var view="<?php echo $_GET['view']; ?>";
window.location.href="viewform2.php?eid="+empid+"&view="+view;	
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
