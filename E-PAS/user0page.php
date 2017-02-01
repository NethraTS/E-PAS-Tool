<?php 
session_start();include session_timeout.php;
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

$psiid=$_SESSION["id"];
$role=$_SESSION["role"];

$flag=0;
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
//   $upd->update(array("psiid"=>$_POST['psiid']),array('$addToSet'=>array("role"=>"HRM")));
   $res=$_POST['name'].' has been added as HR-Manager.Now, you can login using your PSIID.';
   $u->update(array("name"=>"user0"),array('$set'=>array("flag"=>"1")));
   $flag=1;
   }


}


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
            <a href="index.html" class="logo"><img src="paxterralogo.png" height='40px'></img></a>
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
echo '<h5 class="centered">'.$role.'</h5>';
?>					</ul>
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
  -        	<h3><center>Welcome to E-PAS!</center></h3>
          
       <div class="row mt">
          		<div class="col-lg-12">
          		<p>Create HR Manager for the E-PAS tool using the form below.</p>
          		<p>This allows you to perform admin related tasks and manage the tool.</p>
          		</div>
      </div>
		
		<div class="row mt">
        		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i>Register</h4>
     <form class="form-horizontal style-form" action="" method="POST">
		 <div class="form-group">
		    <div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">PSIID  :</label>
              <div class="col-sm-3">
<?php
if($flag==1)
echo '<input type="text" name="psiid" readonly="true" class="form-control round-form">';
else 
echo '<input type="text" name="psiid" class="form-control round-form">';
?>
              </div>
        </div>
			<div class="form-group">
			  <div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">NAME  :</label>
              <div class="col-sm-3">
<?php
if($flag==1)
echo '<input type="text" name="name" readonly="true" class="form-control round-form">';
else 
echo '<input type="text" name="name" class="form-control round-form">';
?>
              </div>
        </div>
		<div class="form-group">
				<div class="col-sm-2"></div>           
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">E-MAIL ID  :</label>
              <div class="col-sm-3">
<?php
if($flag==1)
echo '<input type="text" name="email" readonly="true" class="form-control round-form">';
else 
echo '<input type="text" name="email" class="form-control round-form">';
?>
              </div>
        </div>
		<div class="form-group">
			<div class="col-sm-2"></div>
           <label class="col-sm-2 col-sm-2 control-label" style="text-align:right">DESIGNATION  :</label>
              <div class="col-sm-3">
                 <input type="text" name="dsgn" class="form-control round-form" value="HR Manager" readonly="readonly">
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
