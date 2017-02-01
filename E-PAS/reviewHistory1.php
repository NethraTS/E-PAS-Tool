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

   <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
   <script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#tablehr').dataTable();
	 } );
   </script>  

	<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<style type="text/css">
.btn
{
    margin-left: 20px;
}
</style>
<script type="text/javascript" >
function togle1(n)
{

var str1 = "m";
var str2 = n;
var res = str1.concat(n); //m1
$('#'+res).toggle();	
}
</script>


     </head>
  

  <body>

<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$d=$db->reviewHistory;
$nt=$db->Notifications;

$historyCol=$db->reviewHistory;

$rev1=$nt->findOne(array("name"=>"review1"));
$r1deadline=$rev1["Deadline"];

$psiid=$_SESSION["psiid"];
$n=$c->findOne(array("r1id"=>$psiid));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
//echo $role;

$r1name=$n["r1name"];
$active=$_GET["active"];
if(!empty($active))
{}
else 
$active=substr($role,0,2);

$history=$historyCol->find(array("psiid"=>$psiid));

$r1docs=$historyCol->find(array("r1id"=>$psiid));
$r2docs=$historyCol->find(array("r2id"=>$psiid));
$r3docs=$historyCol->find(array("r3id"=>$psiid));
$roleArray=array("emp");

if($r1docs->count()!=0)
{

	array_push($roleArray,"r1");
}
if($r2docs->count()!=0)
{
	array_push($roleArray,"r2");
}
if($r3docs->count()!=0)
{
	array_push($roleArray,"r3");
}


//echo $active;
//echo $r1name;

$list=$c->find(array("r1name"=>$r1name));
$emplist=array();
$cnt=1;
$postponedcomment=0;

foreach($list as $det){
$empid=$det["psiid"];

$e=$d->findOne(array("psiid"=>$empid));
$empname=$e["name"];

if($det["postponedFlag"]=="1") 
{
$selfappraisal="postponed";
}
elseif($det["postponedFlag"]>="2")
{
$selfappraisal="postponed";
$postponedcomment=1;	
}
elseif($det["flag1"]>="2" && $det["flag2"]>="2")
{      
$selfappraisal=decrypt($det["overallselfrating"]);
}
else
{
$selfappraisal="pending";
}
//echo $empname;
//echo $selfappraisal;

if($det["r1MeetingMailSent"]=="1")
$r1mailsent=1;

$meetingdate=$det["r1MeetingDate"];
//$meetingdate="11-03-2015 1:00 PM";
$exp=explode(" ",$meetingdate);

//echo $meetingdate;

$mt=$exp[1]." ".$exp[2];
$mtfinal= date("G:i", strtotime($mt));
$today=date("d-m-Y");
$now = date("H:i");
//echo $now;
//echo $exp[0]."   ";
//echo $today."  ";
//echo $mtfinal."   ";
//echo $now."      ";
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

$emplist[$cnt]=array("psiid"=>$empid,
"name"=>$empname,
"sa"=>$selfappraisal,
"Mdate"=>$meetingdate,
"f1"=>$det["flag1"],
"f2"=>$det["flag2"],
"ppc"=>$postponedcomment,
"mo"=>$meetingover,
);
//echo $emplist[$cnt]["mo"];
//echo $emplist[$cnt]["psiid"];
//echo $emplist[$cnt]["sa"];
//echo $emplist[$cnt]["ppc"];
$cnt++;
}

$doc=$d->findOne(array("psiid"=>$psiid));
$finalised="0";
$r3f=$nt->findOne(array("name"=>"review3"));
if(in_array($psiid,$r3f["finalisedIDs"]))
$finalised="1";


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
//echo '<li class="sub-menu"><a href="#" ><i class="fa fa-desktop"></i><span>Goals</span></a></li>';
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
    
          
              	<div class="row mt">
<!--<button class="btn pull-left btn-theme03" onclick="location.reload(true)"><i class="fa fa-refresh"></i>Refresh</button>-->      
        
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  
                <div class="bs-example">
    <ul class="nav nav-tabs">

<?php
//echo '<li class="active"><a data-toggle="tab" href="#review1">My Goals </a></li>';
if(in_array("emp",$roleArray))
{
echo '<li  class="active" ><a data-toggle="tab" href="#emp">My History</a></li>';
}
if(in_array("r1",$roleArray))
{
echo '<li ><a data-toggle="tab" href="#review1">Review 1 </a></li>';
}

?>  
    </ul> 
    <div class="tab-content">

<div id="emp" class="tab-pane active">

  <table  class="table table-striped">
                  <thead>
                  <th>Review Year</th><th>R1 PSI ID</th><th>R1 Name</th><th>R2 PSI ID</th><th>R2 Name</th><th>View </th><thead>
                  <tbody>
						<?php
				
						foreach($history as $v )
						{
							 $encPsiid=base64_encode($v['psiid']);
							 $encYear=base64_encode($v['year']);
						?>
						<tr>
						<td><?php echo $v['year']; ?></td>
						<td><?php echo $v['r1id']; ?></td>
						<td><?php echo $v['r1name']; ?></td>
						<td><?php echo $v['r2id']; ?></td>
						<td><?php echo $v['r2name']; ?></td>
						<td><a  href="historyView.php?emp=<?php echo $encPsiid ?>&year=<?php echo $encYear; ?>">View</a></td>
						</tr>
						<?php
												
						}
						?>                  
                  </tbody>
                  </table>


</div>
<?php 
if(in_array("r1",$roleArray))
{
	
echo '<div id="review1" class="tab-pane">';
?>

 <table class="table" id="rev1">
		                  <thead>                       
		                   <tr>
		                   <th>PSI ID</th>
								 <th>Name</th>
								 <th>No of Reviews Accomplished</th>
								 
								 </tr>     
		                  </thead>
		                  <tbody>
								<?php
						$r1docs=$historyCol->find(array("r1id"=>$psiid));
						$duplArr=array();
						foreach($r1docs as $v )
						{
						array_push($duplArr,$v["psiid"]);
						}
						$uniqueArray=array_unique($duplArr);
						//var_dump($uniqueArray);
						$count3=1;
						//$fArr=$historyCol->find(array("r1id"=>$psiid));
						foreach($uniqueArray as $v )
						{					
						?>
						<tr>
						<td><?php echo $v ?></td>
						<td><?php $name=$historyCol->findOne(array("psiid"=>$v)); echo $name["name"]; ?></td>
						<td><?php 
						echo '<a href="#" onclick="togle1('.$count3.')">';
						?>
						<?php
						$i=$historyCol->find(array("psiid"=>$v));
						foreach($i as $v)
						{
							$encPsiid=base64_encode($v['psiid']);
							 $encYear=base64_encode($v['year']);
						?>
						
						<a href="historyView.php?emp=<?php echo $encPsiid ?>&year=<?php echo $encYear; ?>"><?php echo $v['year']; ?></a>
						
						
						<?php
						}
						?>
						
						</td>
						</tr>
					                 
                  </tbody>
                  </table>																			 
							<?php
							echo '</div>';
							?> 
							</td>
						</tr>
						<?php		
						$count3++;	
						}
						?> 
								</tbody>
		                 </table>

<?php

echo '</div>'; 

} ?>
</div>
        
  
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
                 <form role="form">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="postponedid" id="postponedid">
                        </div>
                        <div class="form-group"> 
                          <label> R1 comment: </label>
									<p class="form-control-static" id="r1c"></p>
									</div>                          
									<div class="form-group"> 
                          <label> R2 comment: </label>
									<p class="form-control-static" id="r2c"></p>
									</div>                          

                                              
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>


<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          

							<center><h4><p id="ms"></p></h4></center>
                 
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
   Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--  <script src="assets/js/jquery.js"></script> -->
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
      var finalised="<?php echo $finalised; ?>";
      if(finalised=="1")
 $(".dis").prop('disabled',true);      

    $(function(){
          $('select.styled').customSelect();
      });
     
//setTimeout("location.reload(true);", 5000);
   
  </script>
  
 
<script type="text/javascript" >
function savedate(it)
{
var empid=$(it).parent().parent().parent().parent().attr('id');
var scheduleddate=$(it).val();
$.ajax({
url:'savemeetingdate.php',
type:'POST',
data:{'id':empid,'Mdate':scheduleddate},
success:function(data)
{
//alert(data);
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});
}
</script>  

<script type="text/javascript" >
function notify(th)
{
var empid=$(th).parent().parent().attr('id');
var dpid=$(th).attr('name');
var selected=$('#d'+dpid).val();
var msg1="1 on 1 meeting with the employee not scheduled!";
if(selected.length==0)
{
document.getElementById("ms").innerHTML=msg1;	
$("#message").modal('show');
//alert(msg1);
}
else 
{
$.ajax({
url:'notifymeeting.php',
type:'POST',
data:{'id':empid},
success:function(data){
document.getElementById("ms").innerHTML="The employee has been notified.";	
$("#message").modal('show');
//alert("The employee has been notified");
},
failure:function(xhr,desc,err){
alert("fail");
}
});
}
}
</script>

<script type="text/javascript" >
var currentdate = new Date(); 
var today = currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getFullYear() +"-" 
                + currentdate.getHours() + "-"  
                + currentdate.getMinutes();
var r1deadline="<?php echo $r1deadline; ?>";
//alert(r1deadline);

$('.datetimepickers').datetimepicker({
format:"DD-MM-YYYY h:m A",
minDate:today,
maxDate:r1deadline
	});
$('.d').prop('disabled',true);
</script>

<script type="text/javascript">
function filledform1(it)
{
var empid=$(it).parent().parent().attr('id');
//alert(empid);
window.location.href="filledform1.php?eid="+empid;
}

</script>
  
<script type="text/javascript" >
function reviewform1(it)
{
//var dpid=$(it).attr('id');
//alert(dpid);
var empid=$(it).parent().parent().attr('id');
//alert(empid);
window.location.href="review1form1.php?eid="+empid;
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
function completed(th)
{
var r1id=$(th).parent().parent().attr('id');
window.location.href="completedList.php?r1id="+r1id+"&active=c";
}
function pending(th)
{
var r1id=$(th).parent().parent().attr('id');
window.location.href="completedList.php?r1id="+r1id+"&active=p";
}
</script>


<script type="text/javascript" >
function review3form1(it)
{
var tr=$(it).parent().parent();
var empid=$('td:eq(0)',tr).children().first().html();
//alert(empid);
window.location.href="review3form1.php?eid="+empid;	
}
function viewppc(th)
{
var tr=$(th).parent().parent();
var empid=$('td:eq(0)',tr).children().first().html();
var r1c=$('td:eq(5)',tr).children().first().html();
var r2c=$('td:eq(7)',tr).children().first().html();
document.getElementById("postponedid").value=empid;
document.getElementById("r1c").innerHTML=r1c;
document.getElementById("r2c").innerHTML=r2c;
$("#myModal1").modal('show');
}
</script>

<script type="text/javascript" >
function nalist()
{

var str="na";
var r3id="<?php echo $psiid; ?>";
//alert(r3id);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
	}
function pplist()
{

var str="pp";
var r3id="<?php echo $psiid; ?>";
//alert(r3id);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
}
function prlist()
{

var str="pr";
var r3id="<?php echo $psiid; ?>";
//alert(str);

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("tablehr").innerHTML = xmlhttp.responseText;
  }
 }
 xmlhttp.open("POST", "filterlist.php?category=" + str+"&r3id="+r3id, true);
 xmlhttp.send();
	}
function enlist()
{
	//alert("ds");
window.location.href="review1list.php?active=r3";
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

<script type="text/javascript" >
function finalise()
{
var psid="<?php echo $psiid; ?>";
$.ajax({ 
url:'finalise.php', 
type:'POST', 
data:{"psiid":psid}, 
success:function(data){ 
document.getElementById("ms").innerHTML=data;	
$("#message").modal('show');
 
//alert("The list has been finalised.");

}, 
error:function(xhr,desc,err){ 
alert(err); 
} 
});

}
</script>
<!--<Script References>-->


  </body>
</html>
