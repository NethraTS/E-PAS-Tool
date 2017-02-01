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
                <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">

                <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
                <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
                <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
                <script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
                        
                                $('#tablehr').dataTable();
                        } );
                </script>
  </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;
$adl=$db->adminlist;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$adldoc=$adl->findOne(array("psiid"=>$psiid));


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
          	<h3>Current Review Cycle List</h3>
<button class="btn pull-left btn-theme03" onclick="location.reload(true)"><i class="fa fa-refresh"></i>Refresh</button>                	          	
 <div class="row-mt">
	<div class="pull-right col-sm-1"><div style="width:12px;height:12px;background-color:lightgreen;">
	</div>Promotion</div>

	<div class="pull-right col-sm-1" style="width:10.999%"><div style="width:12px;height:12px;background-color:orange;">
	</div>Role change</div>
	
	<div class="pull-right col-sm-1"><div style="width:12px;height:12px;background-color:pink;">
	</div>Postponed </div>
</div> 
<br>
          	<div class="row mt">
          		<div class="col-lg-12">

          		<table class="table yui" id="tablehr" align="center">

					  <thead>
							  <tr>
							     <th>EMP-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  <th>R1 name</th>
								  <th>R2 name</th>
								  <th>R3 name</th>
								  <th>Normalised Rating</th>
								  <th>Promotion / Role Change</th>
								  </tr>
						  </thead>   
						  <tbody>

<?php
$r3doc=$c->find(array("r2id"=>$psiid));
$count=0;
$pending=0;
$completed=0;

foreach($r3doc as $el)
{
$count++;
if($el["postponedFlag"]>="1")
$completed++;
elseif($el["flag2"]<"8")
$pending++;
else 
$completed++;

echo '<tr>';

echo '<td>';

if($el["postponedFlag"]>="1")
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


echo '<td onclick="view(this)"><a href="#" style="color:#797979;">'.$el["name"].'</a></td>';
echo '<td>'.$el["designation"].'</td>';
echo '<td>'.$el["r1name"].'</td>';
echo '<td>'.$el["r2name"].'</td>';
echo '<td>'.$el["r3name"].'</td>';

if($el["postpnedFlag"]>="1")
echo '<td>Postponed</td>';
elseif($el["flag2"]<"6")
echo '<td>Pending</td>';
else
echo '<td>'.decrypt($el["normalisedRating"]).'</td>';

if($el["R3proposedAction"]["name"]==="promotion" || $el["R3proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R3proposedAction"]["newPosition"].'</td>';
elseif($el["R2proposedAction"]["name"]==="promotion" || $el["R2proposedAction"]["name"]==="role_change")	
echo '<td>'.$el["R2proposedAction"]["newPosition"].'</td>';
else 
echo '<td>-</td>';

echo '</tr>';
} 
echo '<b>Total : '.$count.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo 'Completed : '.$completed.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo 'Pending : '.$pending.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b><br><br>';
?>
					  </tbody>
					  </table>  
						<div class="row-fluid">
      			    <div id="pageNavPosition" style="padding-top: 20px" align="center">
		          		<br><br>
							</div></div>
<br><br><br>
<div class="col-lg-6">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadr2.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div>

          		</div>
          	</div>
			
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
<!--    <script src="assets/js/jquery.js"></script> -->
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
function view(th)
{
var id=$(th).prev().children().first().html();
window.location.href="viewform1.php?eid="+id+"&view=r2";
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
  

  </body>
</html>
