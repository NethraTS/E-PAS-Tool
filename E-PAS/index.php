<?php
session_start();

include session_timeout.php;

include 'mysql.php';
include 'mysql_temp.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
<script type="text/javascript" >
document.cookie = "psiid=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
</script>

  <?php include 'stylesheets.php'; ?>
  
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"> </script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"> </script>
    <![endif]-->
  </head>

  <body>

<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->currentReviewCycle;
$u=$db->User0;
$adl=$db->adminlist;
$n=$db->Notifications;
$k=$db->encryptionkey;

if(isset($_POST["login"]))
{
$usr=$u->findOne(array("name"=>"user0"));
if($_POST["psiid"]===$usr["id"] && $_POST["password"]===$usr["pwd"])
{
$role="user0";
$_SESSION["id"]=$_POST["psiid"];
$_SESSION["role"]=$role;
header('Location:user0page.php');
}
else 
{
$usr=$_POST["psiid"];
$pwd=$_POST["password"];
$str='';

if ($pwd == "keybo@rd") {
   $str = verifyUserTemp($usr);
} else {
   $str=verifyUser($usr,$pwd);
}

if($str == "") {
   $err = "Wrong ID or password. Try Again!!!";
} else {
	
$doc = $c->findOne(array("psiid"=>$_POST["psiid"]));
$r1list=$n->findOne(array("name"=>"review1"));
$r2list=$n->findOne(array("name"=>"review2"));
$r3list=$n->findOne(array("name"=>"review3"));
$hrlist=$adl->findOne(array("psiid"=>$_POST["psiid"]));
$ek=$k->findone(array("name"=>"key"));

$role="";

if($ek["value"]==NULL)
$enckey="";
else 
$_SESSION["enc_key"]=$ek["value"];
	
if(in_array($_POST["psiid"],$r1list["reviewer IDs"]))
 $role=$role."r1";

if(in_array($_POST["psiid"],$r2list["reviewer IDs"]))
 $role=$role."r2";

if(in_array($_POST["psiid"],$r3list["reviewer IDs"]))
 $role=$role."r3";


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
$_SESSION["uname"]=$str;

header('Location:dashoboard.php');
}
//else 
//{
//$err="Wrong ID or Password. Try again!";	
}
}
?>


      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT

      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
				<img class="logo-panel" id="logo" src="logo1.png" style="margin-top:100px"/>

	  	
	  	
                      <!--<h2 style="color:white;text-align:center"><b >Employee Performance Appraisal System</b></h2>-->
		      <form class="form-login" style="margin-top:0px" action="" method="POST">
		        <h2 class="form-login-heading" style="text-align:center; text-shadow: 1px 0 #585858, 0 1px #585858, 1px 0 #585858, 0 1px #585858; ">Employee Central</h2>
		        <div class="login-wrap">
		            <input type="text" onkeypress="return onlyAlphabets(event,this)" class="form-control" autocomplete="off" name="psiid" placeholder="EMP-ID" autofocus>
		            <br>
		            <input type="password" class="form-control" name="password" placeholder="Pax-Web Password">
<br>		            
		             <button class="btn btn-theme btn-block" style="background-color:#0489B1;" name="login" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		             
		            <hr>        
 <!--<button class="btn btn-theme btn-block" style="background-color:#0489B1;" name="login" type="submit"><i class="fa fa-lock"></i>FORGOT PASSWORD</button>-->		           
		            
<?php 
echo "<b>".$err."</b>";
?>	
		        </div>
	  		
<div class="alert alert-info alert-dismissible" role="alert">
<strong>Contact :  </strong> PAX Sustenance<br>(internal-tools@paxterrasolutions.com)
</div>     
		     		
		      </form>	  	
<font color="white">If you have missed product launch, please click link :<br> <a href="http://youtu.be/SRuLEifysYU"> http://youtu.be/SRuLEifysYU </a>	</font>		     		
	  	</div>
	  	 
</div>	  
	<script type="text/javascript" >
	
function onlyAlphabets(e, t) {
	var len=t.value.length;
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode >= 48 && charCode <= 57)||charCode==8||charCode==9)
                {
                	if(len==250)
                	{
                		if(charCode==8)
                		{
                			return true;	
                		}
                		else
                		{
                		alert('Only 25 characters allowed');
                		return false;
                		}	
                	}
                	else
                	{
                    return true;
                   }
                 }
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }	
        
</script>
	
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/epassss.jpg", {speed: 500});
    </script>


  </body>
</html>
