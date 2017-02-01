<?php
session_start();include session_timeout.php;
include 'secure.php';
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
$db=$m->goals1;
$c=$db->currentGoalCycle;

$eid="781";

$doc=$c->findOne(array("id"=>$eid));
//var_dump($doc);
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
<?php   
     echo '<h3>'.$doc["name"].'<br><br></h3> <h4> Type: '.$doc["gType"].' Goals <br><br> Overall Weightage : '.$doc["gWts"]["total"].'<h4><br>';
?> 

  	 	<button class="btn btn-sm btn-theme03 pull-left" style="margin-left:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>  			
  	  </div>

<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]<="2")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="3")
{
	$maxm=count($doc["Deliverables"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["descr"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}   	
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
}
?>
					  </tbody>
					  </table>

 <?php 
if($doc["flag"]<="2")
{}
elseif($doc["flag"]>="3")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["del"].'</p></b>';
}
?>         
	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                        <th>Description</th>                                                        							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]<="2")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="3")
{
	$maxm=count($doc["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Quality"][$j]["descr"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
}
?>									                			 				 						           
						</tbody>
			      </table>

<?php 
if($doc["flag"]<="2")
{}
elseif($doc["flag"]>="3")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';
}
?>              		
					 			
	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]<="2")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="3")
{
	$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			echo '<td><p class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
}
?>
					  </tbody>
			      </table>

<?php 
if($doc["flag"]<="2")
{}
elseif($doc["flag"]>="3")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';
}
?> 					
									
			    </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]<="2")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="3")
{
	$maxm=count($doc["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  			echo '<td><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";	  	
}
?>			
					  </tbody>
					  </table>	
<?php 
if($doc["flag"]<="2")
{}
elseif($doc["flag"]>="3")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';
}
?>		
	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>                                                              							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]<="2")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="3")
{
	$maxm=count($doc["ValueAddition"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			echo '<td><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";   	
}
?>						                						           
					  </tbody>
			      </table>
<?php 
if($doc["flag"]<="2")
{}
elseif($doc["flag"]>="3")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';
}
?>
	
	         </div>
		    </div>
       
	 </div>

<!--button-->
		  <div class="row mt" id="appr">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	  <div class="col-lg-7">         	  
                <button class="btn btn-theme03 pull-right" onclick="r2appr()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Approve
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
   <b>Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)</b>
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
var fl='<?php echo $doc["flag"]; ?>';
if(fl==4)
	$('#appr').hide(); 
</script>

<script type="text/javascript" >
function goback()
{
	window.location.href="gmanagerlist.php?active=r2";	
}

function r2appr()
{
	var id='<?php echo $eid; ?>';
	$.ajax({ 
		url:'r2Approval.php', 
		type:'POST', 
		data:{"id":id,"sub":"true"}, 
		success:function(data){ 
			//$("#myModal1").modal('show'); 
			//alert("Saved Successfully!");
			alert("The Goal setting process for this employee has been completed");
			window.location.reload();	
			}, 
		error:function(xhr,desc,err){ 
			alert(err); 
		} 
	});
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
