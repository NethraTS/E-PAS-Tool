<html>
<head>
<script type="text/javascript" >
function check1()
{
var role="<?php echo $role; ?>";
var fl="<?php echo $flg2; ?>";
//alert(fl)
//if(fl>=10||fl=="")
//alert("You are not part of the current review cycle.");
//else 
	window.location.href="review1list.php";  
}
</script>

</head>
<body>


<?php
session_start();
include 'session_timeout.php';
require('auth.php');

$m=new MongoClient();
$db1=$m->AppraisalManagement1;
$c1=$db1->currentReviewCycle;
$db=$m->goals1;
$c=$db->currentGoalCycle;
$goal_role="";
$psiid=$_SESSION["psiid"];
$r2id=$c->find(array('r2id'=>$psiid));
$r1id=$c->find(array('r1id'=>$psiid));
$empid=$c->find(array('id'=>$psiid));
$d=$c1->findOne(array("psiid"=>$psiid));
$flg2=$d["flag2"];


if($r2id->count()!=0)
{
 	$goal_role="r2";
}
else if($r1id->count()!=0)
{
	$goal_role="r1";	
}
else if($empid->count()!=0)
{
 $goal_role="emp";	
}
echo '
    <header class="header black-bg">
              <!--<div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div> -->
            <!--logo start-->
            <a class="logo"><img src="paxterralogo1.png" height="50px"></img></a>
            <!--logo end-->

            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Sign Out</a></li>
            	</ul>
            </div> 
        </header>
      
       <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                	<p class="centered"><a><img src="assets/img/user.png" class="img-circle" width="40"></a></p>';
echo '<h5 class="centered">'.$name.'</h5>';
echo '<h5 class="centered">'.$psiid.'</h5>';
echo '<li class="mt"><a href="dashoboard.php"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>';
//echo '<li class="sub-menu"><a href="gmanagerlist.php" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if($goal_role==="emp" || $role==="emp")
{
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href="goalHistory.php">Goal History</a></li>';
echo '</ul></li>';               
//echo '<li class="sub-menu"><a><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<li class="sub-menu"><a href="#"><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="#" onclick="check()"  data-toggle="tooltip" title="Start Self-Assessment">Self-Assessment</a></li>';
echo '<li><a  href="reviewHistory.php">Past Reviews</a></li>';
echo '</ul></li>';
}
elseif ((strpos($role,'r') !== false)||(strpos($goal_role,'r') !== false)) 	       
{
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href=" gmanagerlist.php#">Goal Overview</a></li>';
echo '<li><a  href="goalHistory.php">Goals History</a></li>';
echo '</ul></li>';
echo '<li class="sub-menu"><a  href="#"><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="#" onclick="check()" data-toggle="tooltip" title="Start Self-Assessment">Self-Assessment</a></li>';
echo '<li><a  onclick="check1()" href="#">Current Review</a></li>';
echo '<li><a  href="reviewHistory.php">Past Review</a></li>';

echo '</ul></li>';
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

echo '</ul>
      <!-- sidebar menu end-->
      </div>
      </aside>';
          
?>

</body>


</html>
