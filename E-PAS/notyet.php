<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="paxterra" >
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - Bootstrap Admin Template</title>

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

  <body>

<?php
session_start();include session_timeout.php;
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->currentReviewCycle;
$u=$db->User0;
$adl=$db->adminlist;

if(isset($_POST["login"]))
{
$usr=$u->findOne(array("name"=>"user0"));
if($_POST["psiid"]===$usr["id"] && $_POST["password"]===$usr["pwd"])
{
	if($usr["flag"]==="0")
	{
$role="user0";
$_SESSION["id"]=$_POST["psiid"];
$_SESSION["role"]=$role;
header('Location:user0page.php');
	}
	else
	{
echo "HR-Manager already registered. Login using your PSIID.";	
	}
}
else {
$doc = $c->findOne(array("psiid"=>$_POST["psiid"]));
$hrlist=$adl->findOne(array("psiid"=>$_POST["psiid"]));
$role="";
	
if(in_array("r1",$doc["role"]))
 $role=$role."r1";

if(in_array("emp",$doc["role"]))
$role=$role."emp";

if($hrlist["designation"]==="HR Manager")
$admin="HRM";
elseif($hrlist["designation"]==="HR Admin")
$admin="HRA";	
else 
$admin=0;

$_SESSION["psiid"]=$_POST["psiid"];
$_SESSION["role"]=$role;
$_SESSION["admin"]=$admin;

//header('Location:selfassessmentform.php');
//header('Location:review1list.php');
//header('Location:adminsettings.php');
header('Location:dashoboard.php');
}
}
?>


      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" action="" method="POST">
		        <h2 class="form-login-heading"></h2>
		        <div class="login-wrap">
		            <h3><center>E-PAS portal has not been opened yet.</center></h3>        
		        </div>
		     		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
