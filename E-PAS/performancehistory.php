<?php
session_start();include session_timeout.php;
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
<link href="progressline.css" media="all" rel="stylesheet">     
<style type="text/css">
h1
{
text-align: center;
}
</style>
    
  </head>

  <body>
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$fl=$db->deadlineFlags;;
$n=$db->Notifications;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));
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
echo '<h5 class="centered">'.$psiid.'</h5>';
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

<br><br><br><br><br>


<h1>COMING SOON...</h1>


			
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
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

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
