<?php
session_start();include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
 
   <?php include 'stylesheets.php'; ?>
   
   
	 <link href="Gritter-master/css/jquery.gritter.css" rel="stylesheet">     
<!--slider and pips -->
  
    <link rel="stylesheet" href="slider/jquery-ui.css"> 
<script src="slider/jquery-1.10.2.js"></script> 
<script src="slider/jquery-ui.js"></script>
<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 

<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({min:1,max:4});
 
$('#overallSR').slider( "option", "value",ar[$('#overallSR').attr("name")]); //to set slider value
 
// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','E','E+','X'],  
    prefix: "",  
    suffix: ""  
    
});

$('.noslider').slider("disable");
});
</script>
    <![endif]-->
  </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$id=$_GET['eid'];

$n=$bd->findOne(array("psiid"=>$_SESSION["psiid"]));
$r1name=$n["name"];

$d=$c->findOne(array("psiid"=>$id));

$doc=$bd->findOne(array("psiid"=>$psiid));


?>


  <section id="container" >
 <?php include 'headerandsidebar.php'; ?>    	       	  
 
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
 <h3>Self Assessement</h3>
          	<p class="pull-right">Page 2</p>
         	
	<!--				<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i>Questionnaire </h4>
                      <form class="form-horizontal style-form" method="get">
                                  <label class="col-sm-2 control-label col-lg-2">Question 1</label>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>              
 											option 1</label>				                                  
                                  </div>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option2" checked>              
											option 2</label>                                  
                                  </div>     
<br></br><br><br>                          
                                  <label class="col-sm-2 control-label col-lg-2">Question 1</label>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios2" id="optionsRadios2" value="option1" checked>               											option 1</label>				                                  
                                  </div>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios2" id="optionsRadios2" value="option2" checked>              
											option 2</label>                                  
                                  </div>     
<br></br><br><br>                        
                                  <label class="col-sm-2 control-label col-lg-2">Question 1</label>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios3" id="optionsRadios3" value="option1" checked>              
 											option 1</label>				                                  
                                  </div>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios3" id="optionsRadios3" value="option2" checked>              
											option 2</label>                                  
                                  </div>     
<br></br><br><br>                     
                                  <label class="col-sm-2 control-label col-lg-2">Question 1</label>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios4" id="optionsRadios4" value="option1" checked>              
 											option 1</label>				                                  
                                  </div>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios4" id="optionsRadios4" value="option2" checked>              
											option 2</label>                                  
                                  </div>     
<br></br><br><br>
    
                                  <label class="col-sm-2 control-label col-lg-2">Question 1</label>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios5" id="optionsRadios5" value="option1" checked>              
 											option 1</label>				                                  
                                  </div>
                                  <div class="col-lg-5">
											<label><input type="radio" name="optionsRadios5" id="optionsRadios5" value="option2" checked>              
											option 2</label>                                  
                                  </div>     
<br><br>
			                     
                       </form>
                       </div>
                  </div>
                  </div>
          	
<!-- review form -->          	
          	<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb">Review Form </h4>
                      <form class="form-horizontal style-form" method="get">
                              <label class="col-sm-2 col-sm-2 control-label">Overall Self-Rating</label>
                              <div class="col-sm-9">
<?php
echo '<div class="slider col-lg-2 noslider green" id="overallSR" name="'.$d['overallselfrating'].'"></div>';
?>
                              </div>
                               <br><br><br>

                              <label class="col-sm-2 col-sm-2 control-label">Personal comments/ Suggestions</label>
                              <div class="col-sm-9">
<?php 
echo '<textarea id="personalComments" rows="3" cols="70" readonly="readonly">'.$d['personalcomments'].'</textarea>';
?>
                              </div>
<br><br><br><br><br>
                 
                       </form>
                       </div>
                  </div>
                  </div>

   <!-- save and submit buttons -->
<div class="row mt">
<div class="col-lg-12"> 
<div class="form-panel">  
<div class="col-lg-6">
<!--<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="review1list.php"><i class="fa fa-arrow-left"></i>&nbspBack to List</button>-->
</div>
<div class="col-lg-6" style="text-align:right">           
    <button type="button" class="btn btn-theme03 pull-left" onclick="filledform1()"><i class="fa fa-arrow-left"></i>&nbspBack</button> 
</div>          
<br><br>
</div>
</div>
</div>


			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->

      <!--footer start-->
    <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
 <!--   <script src="assets/js/jquery.js"></script> -->
    <script src="assets/js/bootstrap.min.js"></script>
<!--    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>  -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->         
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
  </script>
<script type="text/javascript" >
    $('.slider').slider();
    $(".disable").prop('disabled',true);    
//var a=$('.slider').slider('getValue');
//alert(a);    
</script>

<script type="text/javascript" >
function filledform1()
{
var empid="<?php echo $id;?>";
window.location.href="filledform1.php?eid="+empid;	
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
