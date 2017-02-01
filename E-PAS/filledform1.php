<?php
session_start();include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>

    <link href="Gritter-master/css/jquery.gritter.css" rel="stylesheet">
<!--slider and pips-->
     <link rel="stylesheet" href="slider/jquery-ui.css"> 
		<script src="slider/jquery-1.10.2.js"></script> 
		<script src="slider/jquery-ui.js"></script>
		<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
		<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 

<style >textarea { width: 100%; }</style>
<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({min:1,max:4});

$('#dsv').slider( "option", "value",ar[$('#dsv').attr("name")]); //to set slider value
$('#qsv').slider( "option", "value",ar[$('#qsv').attr("name")]); //to set slider value
$('#csv').slider( "option", "value",ar[$('#csv').attr("name")]); //to set slider value
$('#ocsv').slider( "option", "value",ar[$('#ocsv').attr("name")]); //to set slider value
$('#vasv').slider( "option", "value",ar[$('#vasv').attr("name")]); //to set slider value

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
          	<p class="pull-right">Page 1</p>
          	<div class="row mt">
          		<div class="col-lg-12">
          <!--Place your content here. -->
<!-- first table- deliverables -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Deliverables</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="deliverables">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody> 
<?php		                          
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]==="deliverables")
     {
   	 	echo '<tr class="rows">';
  			echo '<td><textarea rows="3" cols="50" readonly="readonly">'.$d["appraisal"][$j]["goal"].'</textarea></td>';
  			echo '<td><textarea rows="3" cols="60" readonly="readonly">'.$d["appraisal"][$j]["accomplishment"].'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="dsv" name="'.$d["selfRatings"]["deliverables"].'"></div>';

?>
			 </div>
    		</div>

<!-- second table- quality -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Quality</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="quality">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="quality")
     {
   	 	echo '<tr class="rows">';
  			echo '<td><textarea rows="3" cols="50" readonly="readonly">'.$d["appraisal"][$j]["goal"].'</textarea></td>';
  			echo '<td><textarea rows="3" cols="60" readonly="readonly">'.$d["appraisal"][$j]["accomplishment"].'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="qsv" name="'.$d["selfRatings"]["quality"].'"></div>';

?>

			  </div>
    		</div>
<!-- third table- competency -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Competency</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="competency">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="competency")
     {
   	 	echo '<tr class="rows">';
  			echo '<td><textarea rows="3" cols="50" readonly="readonly">'.$d["appraisal"][$j]["goal"].'</textarea></td>';
  			echo '<td><textarea rows="3" cols="60" readonly="readonly">'.$d["appraisal"][$j]["accomplishment"].'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="slider col-lg-2 noslider green" name="'.$d["selfRatings"]["competency"].'" id="csv"></div>';

?>
			  </div>
    		</div>   		

<!-- fourth table- organisational contribution -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Organizational Contribution</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="orgcontribution">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="organisational contribution")
     {
   	 	echo '<tr class="rows">';
  			echo '<td><textarea rows="3" cols="50" readonly="readonly">'.$d["appraisal"][$j]["goal"].'</textarea></td>';
  			echo '<td><textarea rows="3" cols="60" readonly="readonly">'.$d["appraisal"][$j]["accomplishment"].'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="ocsv" name="'.$d["selfRatings"]["organisationalContribution"].'"></div>';

?>
			  </div>
    		</div>   		   		

<!-- fifth table- value addition -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4>Value Addition</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="valueaddition">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="value addition")
     {
   	 	echo '<tr class="rows">';
  			echo '<td><textarea rows="3" cols="50" readonly="readonly">'.$d["appraisal"][$j]["goal"].'</textarea></td>';
  			echo '<td><textarea rows="3" cols="60" readonly="readonly">'.$d["appraisal"][$j]["accomplishment"].'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
echo '<div class="slider col-lg-2 noslider green" id="vasv" name="'.$d["selfRatings"]["valueAddition"].'"></div>';

?>
				  </div>
    		</div>   		   		
    
   <!-- save and submit buttons -->

<div class="row mt">
<div class="col-md-12"> 
<div class="form-panel">  
<div class="col-md-6">
<button type="button" class="btn btn-theme03 pull-left" onclick=window.location.href="review1list.php"><i class="fa fa-arrow-left"></i>&nbspBack to List</button>
</div>
<div class="col-md-6" style="text-align:right">           
    <button type="button" class="btn btn-theme03 pull-right" onclick="filledform2()"><i class="fa fa-arrow-right"></i>&nbspNext</button> 
</div>
<br><br> 
</div>
</div>
</div>
  
  
          	</div>	</div>		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->

      <!--footer start-->
     <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <!--<script src="assets/js/jquery.js"></script> -->
    <script src="assets/js/bootstrap.min.js"></script>
  <!--  <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
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
function filledform2()
{
	var empid="<?php echo $id;?>" 
window.location.href="filledform2.php?eid="+empid;	
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
