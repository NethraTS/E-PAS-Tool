<?php
session_start();include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>
    
  </head>

  <body>
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$db=$m->appraisalmgmt;
$coll=$db->currentReviewCycle;
$n=$db->Notifications;
$bd=$db->BasicDetails;
$adl=$db->adminlist;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));

$adldoc=$adl->findOne(array("psiid"=>$psiid));

?>

  <section id="container" >

<?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i>Data Upload</h3>
		  
		  		<div class="row mt">
              <div class="col-lg-12">
                      <div class="content-panel">
                          <section id="no-more-tables">
                          <center>
								  		<form class="form-horizontal" action="insertlibrary1.php" method="post" enctype="multipart/form-data">
											<div class="form-group">
													<label>Upload .xls file </label> <br>
													<input type="file" name="libfile" accept=".xls" />
											</div> <br>
											<button class="btn btn-theme03 btn-sm" type="submit" name="lib" value="lib"><i class="fa fa-spinner"></i>
&nbspUpload</button>
									</form> 
								  </center>
								  </section>		  
		  					 </div>
					</div>
             </div>
		</section><! --/wrapper -->
		  	</section>
      <!--main content end-->

      <!--footer start-->
    <?php include 'footer.php'; ?>
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
window.open("extendsadeadline.php");
}
function extendall()
{
$('#d2').prop("readonly",false);	
	
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
