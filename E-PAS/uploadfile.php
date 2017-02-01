<?php 
session_start();include session_timeout.php;
require('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
  <?php include 'stylesheets.php'; ?>
  	

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="css/sb-admin-2.css" rel="stylesheet">
            <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
	<!-- end: CSS -->
	
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		
		
		
</head>

<body style="padding-top:40px;">
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$coll=$db->currentReviewCycle;
$n=$db->Notifications;
$bd=$db->BasicDetails;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];

if(isset($_POST["savedates"]))
{
$pod=$n->findOne(array("name"=>"portalOpening"));
if($pod["Date"]=="")
$n->update(array("name"=>"portalOpening"),array('$set'=>array("Date"=>$_POST['d1'])));
else 
{
if($pod["Date"]===$_POST['d1'])
$n->update(array("name"=>"portalOpening"),array('$set'=>array("changed"=>"no")));
else 
$n->update(array("name"=>"portalOpening"),array('$set'=>array("changed"=>"yes","Date"=>$_POST['d1'])));
}
$r1=$n->findOne(array("name"=>"review1"));
if($r1["Deadline"]==="")
$n->update(array("name"=>"review1"),array('$set'=>array("Deadline"=>$_POST['d3'])));
else 
{
if($r1["Deadline"]===$_POST['d3'])
$n->update(array("name"=>"review1"),array('$set'=>array("changed"=>"no")));
else
$n->update(array("name"=>"review1"),array('$set'=>array("changed"=>"yes","Deadline"=>$_POST['d3'])));
}
$r2=$n->findOne(array("name"=>"review2"));
if($r2["Deadline"]==="")
$n->update(array("name"=>"review2"),array('$set'=>array("Deadline"=>$_POST['d4'])));
else 
{
if($r2["Deadline"]===$_POST['d4'])
$n->update(array("name"=>"review2"),array('$set'=>array("changed"=>"no")));
else
$n->update(array("name"=>"review2"),array('$set'=>array("changed"=>"yes","Deadline"=>$_POST['d4'])));
}

$today=date("d-m-Y");
$checkpod=$n->findOne(array("name"=>"portalOpening"));
echo $today;


//notifications to reviewer-1 on deadline change
if(strtotime($checkpod["Date"])<=strtotime($today))
{
$a=$n->findOne(array("name"=>"review1"));
if($a["changed"]==="yes")
{
$reviewer1IDs=$a["reviewer IDs"];	
for($i=0;$i<count($reviewer1IDs);$i++)
{
$r1Obj=$bd->findOne(array("psiid"=>$reviewer1IDs[$i]));
$r1mailid=$r1Obj["emailID"];
$messageOnR1change="The last date for review-1 completion has been extended to ".$a["Deadline"];
if(mail("malinihp@gmail.com","APAS-Review 1 deadline changed",$messageOnR1change))
echo "sent";
else 
echo "not sent";
}	
}
}

}
?>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner navbar-fixed-top">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>Paxterra</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						
					
					
					<!-- start: User logout-->
								<li><a href="logout.php"><i class="halflings-icon off"></i> Sign Out</a></li>
							<!-- end: User logout -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2" style="position:fixed;">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
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
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					Home
					<i class="icon-angle-right"></i>
				</li>
				<li>Admin Settings</li>

			</ul>

		<div class="row-fluid sortable" style="text-align:center">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span> Timeline Settings</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
			<div class="box-content">			
				
 <form class="form-horizontal" action="insertlibrary1.php" method="post" enctype="multipart/form-data">						
<div class="form-group">							
<label>Upload .xls file </label> <br>
<input type="file" name="libfile" accept=".xls" />
</div> <br>
<button class="btn btn-info" type="submit" name="lib" value="lib">Upload</button>
</form> 
    </div>
        </div>
        </div>
                               
		
	        </div>                               
	     	</div> <!--/.fluid-container-->
	

		</div> <!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
    <?php include 'footer.php'; ?>


	
	<!-- start: JavaScript-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
		
		<script src="js/jquery-1.9.1.min.js"></script>

		<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
		
		<script src="js/bootbox.min.js"></script>
	
<script src="js/plugins/metisMenu/metisMenu.min.js"></script>	
    <script src="js/sb-admin-2.js"></script>
 
<script type="text/javascript">
    $('.dropdown-menu').click(function(e) {
          e.stopPropagation();
    });
</script>  

<script type="text/javascript" >
function changepod()
{
$('#d1').prop("readonly",false);	
return false;
}
function r1extend()
{
$('#d3').prop("readonly",false);	
return false;
}
function r2extend()
{
$('#d4').prop("readonly",false);	
return false;
}
function saextend()
{
window.open("extenddeadline.php");
}
</script>


  <!-- <script type="text/javascript">
    $('form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("No changes can be made after 'submit'. Are you sure?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
</script> 
	<!-- end: JavaScript-->
	
</body>
</html>
							
