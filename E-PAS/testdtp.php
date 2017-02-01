 <?php
session_start();include session_timeout.php;
//require('auth.php');
include 'secure.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>
  
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

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
</style>
     </head>
  

  <body>

<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$d=$db->BasicDetails;
$nt=$db->Notifications;

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
<button class="btn pull-left btn-theme03" onclick="location.reload(true)"><i class="fa fa-refresh"></i>Refresh</button>      
</div>
<div class="row mt form-panel form-inline">
<div class="col-sm-6">
<div class="input-group date" id="datetimepicker1">
<input size="25" class="datetimepickers" id="d1" onblur="savedate(this)" placeholder="Click Here..">
</div></div>

<div class="col-sm-3">
<p class="form-control-static"> ndfkdksddscnxcmncmzxbcz</p>
</div>	        

<div class="col-sm-6">
<label for="name" style="color:violet;size:18;">name:&nbsp&nbsp</label>
<input type="text" class="form-control" placeholder="type here..."></input> 
</div>

<button class="btn btn-twitter">Test</button>
<button class="btn btn-xs" style="color:black;background-color:pink;">Test</button>
</div>
   		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->


      <!--footer start-->
     <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
 <!-- <script src="assets/js/jquery.js"></script>--> 
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
minDate:today
	});
$('.d').prop('disabled',true);
</script>

  </body>
</html>
