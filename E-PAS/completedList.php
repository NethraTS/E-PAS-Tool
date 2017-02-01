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
$bd=$db->BasicDetails;
$nt=$db->Notifications;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$active=$_GET['active'];
$r1id=$_GET['r1id'];
//echo $active;
//echo $r1id;
//echo $psiid;

$doc=$bd->findOne(array("psiid"=>$psiid));
//echo $role;
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
//echo '<li class="sub-menu"><a href="#" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
if ($role==="emp") 	       
{                  
echo '<li class="sub-menu"><a href="gmanagerlist.php"><i class="fa fa-desktop"></i><span>Goals</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="employeegoalsreview.php">My Goals</a></li>';
echo '<li><a  href="goalHistory.php">Goal History</a></li>';
echo '</ul></li>';               
echo '<li class="sub-menu"><a href"3"><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  href="selfassessmentform.php">Start Self-Assessment</a></li>';
echo '<li><a  href="reviewHistory.php">Past Review</a></li>';
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
echo '<li class="sub-menu"><a href="#"><i class="fa fa-cogs"></i><span>Reviews</span></a>';
echo '<ul class="sub">';
echo '<li><a  onclick="check()">Start Self-Assessment</a></li>';
echo '<li><a  href="review1list.php">Current Review</a></li>';
echo '<li><a  href="reviewHistory.php">Past Review</a></li>';
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
          
          
              	<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  
                <div class="bs-example">
    <ul class="nav nav-tabs">
<?php
if($active=="c") 
{
echo '<li class="active"><a data-toggle="tab" href="#completedlist">Completed List</a></li>';
echo '<li><a data-toggle="tab" href="#pendinglist">Pending List</a></li>';
}
elseif($active=="p") 
{
echo '<li><a data-toggle="tab" href="#completedlist">Completed List</a></li>';
echo '<li class="active"><a data-toggle="tab" href="#pendinglist">Pending List</a></li>';
}
?>
        </ul> <br><br>
    <div class="tab-content">
<?php
if($active=="c") 
echo '<div id="completedlist" class="tab-pane fade in active">';
elseif($active=="p") 
echo '<div id="completedlist" class="tab-pane fade">';
?>
        <table class="table" id="deliverables">
						  <thead>
							  <tr>
								  <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Self-Appraisal</th>
								  <th>Review 1 Rating</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>

<?php
$r1res=$c->find(array("r1id"=>$r1id,"r2id"=>$psiid));
foreach($r1res as $result)
{
//var_dump($res);
$managername=$result["r1name"];

if($result["postponedFlag"]=="2" || $result["postponedFlag"]=="3")
{
echo '<tr>';
echo '<td>'.$result["psiid"].'</td>';
$en=$bd->findOne(array("psiid"=>$result["psiid"]));
echo '<td>'.$en["name"].'</td>';
echo '<td>-</td>';
echo '<td><p style="background-color:pink;display:inline-block;">postponed</p></td>';
echo '<td><button class="btn btn-info btn-xs" onclick="postponecomment(this)">View</button>';
echo '<p style="display:none;" id="r1">'.$result["r1PostponementComment"].'</p>';
echo '<p style="display:none;" id="r2">'.$result["r2PostponementComment"].'</p>';
echo '</td>';
echo '</tr>';

}
elseif($result["flag1"]>="4" && $result["flag2"]>="4")
{
echo '<tr>';
echo '<td>'.$result["psiid"].'</td>';
$en=$bd->findOne(array("psiid"=>$result["psiid"]));
echo '<td>'.$en["name"].'</td>';
echo '<td>'.decrypt($result["overallselfrating"]).'</td>';
echo '<td>'.decrypt($result["overall R1rating"]).'</td>';

if($result["flag2"]>="6")
echo '<td><button class="btn btn-info btn-xs" onclick="r2form1(this)">View</button></td>';
else 
echo '<td><button class="btn btn-info btn-xs" onclick="r2form1(this)">Review</button></td>';

echo '</tr>';
}
}
?>
						  </tbody>
					  </table>            

          
 </div>    <!end -completed list-->   
 
 
         
<?php
if($active=="c") 
echo '<div id="pendinglist" class="tab-pane fade">';
elseif($active=="p") 
echo '<div id="pendinglist" class="tab-pane fade in active">';
?>
       			 <table class="table" id="deliverables">

					  <thead>
							  <tr>
							     <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Self-Appraisal</th>
								  <th>Review 1 Rating</th>
							  </tr>
						  </thead>   
						  <tbody>
<?php						  
$r1res=$c->find(array("r1id"=>$r1id,"r2id"=>$psiid));
$count=0;
foreach($r1res as $result)
{
$managername=$result["r1name"];
if($result["postponedFlag"]>="2")
{}
elseif($result["flag1"]<"4" || $result["flag2"]<"4")
{
	$count++;
echo '<tr>';
echo '<td>'.$result["psiid"].'</td>';
$en=$bd->findOne(array("psiid"=>$result["psiid"]));
echo '<td>'.$en["name"].'</td>';
if(!empty($result["overallselfrating"]))
echo '<td>'.decrypt($result["overallselfrating"]).'</td>';
else 
echo '<td><p style="background-color:yellow;display:inline-block;">Pending</p></td>';
if(!empty($result["overall R1rating"]))
echo '<td>'.decrypt($result["overall R1rating"]).'</td>';
else 
echo '<td><p style="background-color:yellow;display:inline-block;">Pending</p></td>';
echo '</tr>';
}
}
if($count===0)
{	
echo '<tr><td></td><td></td><td> No Pending Reviews </td></tr>';
}
?>						  </tbody>
					  </table>  

           
        </div>
       


    </div><!--tab content-->
</div><!-- example--> 
<!-- save and submit buttons -->
<div class="row-mt">
<div class="col-lg-12" style="width:107.5%;margin-left:-35px;">
<br>
<div class="form-panel">
<div class="col-lg-7">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='review1list.php?active=r2'"><i class="fa fa-arrow-left"></i>Back to Review 2 List</button>    
</div>
<br><br>
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
                 <form role="form" method="POST" action="r2postponedcomment.php">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="postponedid" id="postponedid">
                        </div>
                        <div class="form-group"> 
                          <label> R1 comment: </label>
									<p class="form-control-static" id="r1c"></p>
									</div>                          
                        <div class="form-group">
                            <label for="name" class="control-label"> Your Comment </label>
                            <textarea class="form-control" id="r2comment" name="r2comment" rows=3></textarea>
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

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   Yearly Assessment Review - <?php echo date("Y"); ?>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
  <script src="assets/js/jquery.js"></script> 
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>       
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
      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });
  </script>

  
<script type="text/javascript">
function r2form1(it)
{
var tr=$(it).parent().parent();
var empid=$('td:eq(0)',tr).html();
//alert(empid);
var r1id="<?php echo $r1id; ?>";
window.location.href="review2form1.php?eid="+empid+"&r1id="+r1id;
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
function postponecomment(th)
{
var r1c=$(th).siblings('p#r1').text();
var r2c=$(th).siblings('p#r2').text();
var tr=$(th).parent().parent();
var empid=$('td:eq(0)',tr).html();
//alert(r2c);
document.getElementById("postponedid").value=empid;
document.getElementById("r1c").innerHTML=r1c;
if(r2c)
document.getElementById("r2comment").value=r2c;
$("#myModal1").modal('show');

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

<!--<Script References>-->


  </body>
</html>