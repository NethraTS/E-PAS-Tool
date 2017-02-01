<?php
session_start();include session_timeout.php;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 

<!--slider and pips-->
     <link rel="stylesheet" href="slider/jquery-ui.css"> 
		<script src="slider/jquery-1.10.2.js"></script> 
		<script src="slider/jquery-ui.js"></script>
		<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
		<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 

   <style type="text/css">
h1
{
text-align: center;
}
::-webkit-input-placeholder { /* WebKit browsers */
    color:    grey;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    grey;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    grey;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
   color:    grey;;
}
.ag
{
margin-right:20px;
background-color:salmon;
border:white	
}
</style>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

?>

  <section id="container" >
   <?php include 'headerandsidebar.php'; ?>    	       	  
         
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          
  	<div class="row mt">
     <h3>Employee Name [ Time Period]</h3>  <br>
  	 	<button class="btn btn-sm btn-theme03 pull-left" style="margin-left:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>  			
  	  </div>

  	 <div class="row mt">
  
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
	         
                 <label class=" col-lg-3 pull-left"><b>Employee Name  :</b></label>              
					  <p class="form-class-static">NAME here.. </p>
					<br>
					 <label class="col-lg-3 pull-left"><b>Select Year  :</b></label>
					 <select style="width:10%"><option>2015</option></select>	
					<br><br>
					 <label class="col-lg-3 pull-left"><b>Select Quarter  :</b></label>
					 <select style="width:10%">
					 	<option>Q1</option>
						<option>Q2</option>
						<option>Q3</option>
						<option>Q4</option>		
					 </select> 							  	         
	         </div>
		    </div>

	</div>

<!--button-->
		  <div class="row mt">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	  <div class="col-lg-7">
                <button class="btn btn-theme03 pull-right" id="viewgh" onclick="viewhistory()">
                  <i class="fa fa-eye"></i>&nbsp&nbsp View History
                </button>
               </div> 
            </div>
          </div>
         </div>
         
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
    <!--<script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>-->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
 <link href="bootstrap-toggle-master/css/bootstrap2-toggle.min.css" rel="stylesheet">    

<script type="text/javascript" >
var rv={"":0,"0":1,"25":2,"50":3,"75":4,"100":5,"E high":6,"E+":7,"E+ mid":8,"E+ high":9,"X":10};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({
	min:1,
	max:5});
	

// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['0%','25%','50%','75%','100%'],  
    prefix: "",  
    suffix: ""
   });
$('#ds1').slider( "option", "value",rv[$('#ds1').attr("name")]); //to set slider value
$('#ds2').slider( "option", "value",rv[$('#ds2').attr("name")]); //to set slider value
$('#ds3').slider( "option", "value",rv[$('#ds3').attr("name")]); //to set slider value
$('#ds4').slider( "option", "value",rv[$('#ds4').attr("name")]); //to set slider value
$('#ds5').slider( "option", "value",rv[$('#ds5').attr("name")]); //to set slider value
});

</script>

<script type="text/javascript" >
$('#viewgh').on("click",function()
	{
		window.location.href="employeeoldgoals.php";
	});
function goback()
{
	window.location.href="gmanagerlist.php";	
}

<!--
sjQuery('<a/>', {
    id: 'foo',
    href: 'http://google.com',
    title: 'Become a Googler',
    rel: 'external',
    text: 'Go to Google!'
}).appendTo('#deliverables'); 
-->

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
