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
  </head>
<script type="text/javascript" >
s="<?php echo $status; ?>";
</script>

  <body>
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$db=$m->appraisalmgmt;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$dl=$db->Notifications;
$adl=$db->adminlist;

$psiid=$_SESSION["psiid"];
$d=$c->findOne(array("psiid"=>$_SESSION["psiid"]));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));

$adldoc=$adl->findOne(array("psiid"=>$psiid));



$a=$c->find();
$status=$_GET["status"];
//print_r($status);

$r1=$dl->findOne(array("name"=>"review1"));
$r1deadline=$r1["Deadline"];
$sadeadline = date('d-m-Y', strtotime('-5 days', strtotime($r1deadline)));
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
          	<h3>Extensions</h3>
          	<form class="form-horizontal" action="updateesad.php" method="POST">           	
          	<div class="row mt">
          		<table class="table yui" id="tablepaging" align="center">
		                          <thead>
		                       
		                               <tr>
		                               	<th></th>
								 					 <th>EMP-ID</th>
								  					 <th>Name</th>
							 				    </tr>
		                        
		                          </thead>
		                          <tbody>
<?php
foreach($a as $doc)
{
$n=$bd->findOne(array("psiid"=>$doc["psiid"]));
echo '<tr>';
echo '<td><input type="checkbox" name="check_list[]" value="'.$doc["psiid"].'"></td>';
echo '<td>'.$doc["psiid"].'</td>';
echo '<td>'.$n["name"].'</td>';
echo '</tr>';
}						
?>	
										  </tbody>
		                 			  </table>
          

          	</div>
							<div class="row-fluid">
      			    <div id="pageNavPosition" style="padding-top: 20px" align="center">
		          		<br><br>
							</div></div>

          				<div class="row-fluid"> 
                                  <label class="col-sm-2 control-label col-lg-2">Deadline Date:</label>
                                  <div class="col-lg-3">
<?php
echo '<input type="text" name="newdate" readonly="readonly" value="'.$sadeadline.'"></input>';                                 
 ?>
                                  </div>
                                  <div class="span2"> 
											 <button type="submit" name="extendsad" class="btn btn-theme03 pull-left"><i class="fa fa-floppy-o"></i>&nbspSave</button> 
			  								 </div>
                        </div>   
  </form>
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)
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


  </body>
</html>
