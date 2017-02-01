<?php
session_start();include session_timeout.php;
require('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
  <?php include 'stylesheets.php'; ?>
  
    <link href="progressline.css" media="all" rel="stylesheet"> 
  </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;
$u=$db->User0;
$adl=$db->adminlist;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));

$adldoc=$adl->findOne(array("psiid"=>$psiid));



//$flag=0;
//echo $role;

if(isset($_POST["addadmin"]))
{
 if (!$_POST['psiid'] || !$_POST['name'] || !$_POST['email'] || !$_POST['dsgn'])
	{
	$err='Please,Fill all the fields';
	}
 else
   {
    $admindetails=array(
   'psiid'=>$_POST['psiid'],
   'name'=>$_POST['name'],
   'email'=>$_POST['email'],
   'designation'=>$_POST['dsgn']	
	);
   $adl->insert($admindetails);
   if($admindetails["designation"]==="HR Manager")
   $res=$_POST['name'].' has been added as HR-Manager.';
   else
	$res=$_POST['name'].' has been added as HR-Admin.'; 
	$err=" ";  
   }
}


?>
  <section id="container" >

<?php include 'headerandsidebar.php'; ?>    	       	  
   
 	<!--	 **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
         	
		<div class="row mt">
        		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb">Add New Admins</h4>
     <form class="form-horizontal style-form" action="" method="POST">
		 <div class="form-group">
		    <div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">EMPLOYEE ID  :</label>
              <div class="col-sm-3">
					<input type="text" name="psiid" class="form-control round-form">
              </div>
        </div>
			<div class="form-group">
			  <div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">NAME  :</label>
              <div class="col-sm-3">
					<input type="text" name="name" class="form-control round-form">
              </div>
        </div>
		<div class="form-group">
				<div class="col-sm-2"></div>           
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">E-MAIL ID  :</label>
              <div class="col-sm-3">
					<input type="text" name="email" class="form-control round-form">
              </div>
        </div>
		<div class="form-group">
			<div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">DESIGNATION  :</label>
              <div class="col-sm-3">
					<select class="form-control" name="dsgn">
														<option>HR Manager</option>;
														<option>HR Admin</option>
														</select>
              </div>
        </div>

<div class="row-mt">
 <?php echo "<p style='color:red;text-align:center;'>$err</p>";?> 
</div>

		 <div style="text-align:center">
		   <button class="btn btn-theme03" type="submit" name="addadmin">Add</button></div>

<div class="row-fluid"> <h5>
 <?php echo "<p style='color:green;text-align:center;'>$res</p>";?> 
 </h5></div>
		 
 	</form>          
          
          
          
           </div></div></div>	


		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
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

    <script type="text/javascript" >
		$(document).ready(function(){
			var a="<?php echo $panelflag; ?>";

			if(a==1)
			{ 
			$("#cir1").addClass("active");
			$("#tab1").addClass("active");
			$(".progress-bar").css("width", "1%");
			}else if(a==2)
			{
			$("#cir2").addClass("active");
			$("#tab2").addClass("active");
			$(".progress-bar").css("width", "33%");
			}else if(a==3)
			{
			$("#cir3").addClass("active");
			$("#tab3").addClass("active");
			$(".progress-bar").css("width", "65%");
			}else
			{
			$("#cir1").addClass("active");
			$("#tab1").addClass("active");
			$(".progress-bar").css("width", "1%");
			}
		});
	 </script>

  </body>
</html>
