
<?php
session_start();
include session_timeout.php;
include 'secure.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 
<link rel="stylesheet" type="text/css" href="datetime/jquery.datetimepicker.css"/>
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
td{
text-align: justify;	
/*margin: 10px;
padding: 10px; */
	}
</style>
 </head>

  <body onload="a()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];

$eid=$_GET['eid'];
$r1docs=$c->find(array('r1id'=>$_SESSION['psiid']));
$r2docs=$c->find(array('r2id'=>$_SESSION['psiid']));
if($r1docs->count()!=0 && $r2docs->count()!=0)
{
$active="r2";
}
else if($r1docs->count()!=0)
{
$active="r1";	
}
else if($r2docs->count()!=0)
{
$active="r";	
}
else 
{
$active="emp";	
}

$doc=$c->findOne(array("id"=>$eid));

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
 <table> 
 <tr><td>
<?php   
     echo '<h3>'.$doc["id"].'- '.$doc["name"];?></td></tr>
     
     <tr><td>
<?php echo 'Type: '.$doc["gType"].' Goals <br> <br> <p> Overall Weightage : 100 <class="form-class-static" id="Cweight"></p>';
?></td><td>
<?php
echo '<div class="col-lg-11">';
echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th><center>Deliverables</center></th><th><center>Quality</center></th><th><center>Initiatives/ Ownership</center></th><th><center>Organizational/ Project Contribution</center></th><th><center>Strategic Planning /Value Addition</center></th></tr>';
echo '<tr><td><center>'.$doc['gWtshr']['delhr'].'%</center></td><td><center>'.$doc['gWtshr']['qualhr'].'%</center></td><td><center>'.$doc['gWtshr']['comphr'].'%</center></td><td><center>'.$doc['gWtshr']['orgconthr'].'%</center></td><td><center>'.$doc['gWtshr']['valaddhr'].'%</center></td></tr>';
echo '</table>';
echo '</div>';
?></td><td>
  	 <?php
if($active!="emp")
{ 	
  	 	echo '<button class="btn btn-sm btn-theme03 pull-right" id ="back" style="margin-right:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
 	  ';
}
?>
  	   </td>
  </tr>
</table>
  	
</div>


<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  <?php 
 			if($doc['gWts']['del']>0)
 			{    	
    	?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table table-hover table-striped" id="deliverables">
		           <thead>
							<tr>
                        <th>Definition</th>
                         <th>Description</th> 
                               <th>Specifics</th>
                                                                                         							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["Deliverables"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-4"><p style="font-style: italic;" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-4" style="width:200px"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
			$dc++;
  	 	}   	
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
}
?>
		          
		           <!--  	<td><textarea rows="3" cols="30" maxlength="240" employee review comment></textarea></td>-->
					  </tbody>
					  </table>

<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{}
elseif($doc["flag"]>="2")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["del"].'</p></b>';
}
?>
					<br>
<!--					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-40)</label> -->
					  
	         </div>
		    </div>
<?php } 

$doc=$c->findOne(array("id"=>$eid));
         	
         	 			if($doc['gWts']['qual']>=0)
			{			
?> 
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table table-hover table-striped" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                
                          <th>Description</th> 
                                                <th>Specifics</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Quality"][$j]["cnt"].'">';
  			
  			echo '<td class="col-lg-4"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-4"><p style="font-style: italic" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-4"><p class="form-control-static"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["Quality"][$j]["defgoal"]).'</textarea></p></td>';
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
if($doc["flag"]=="0" || $doc["flag"]=="1")
{}
elseif($doc["flag"]>="2")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';
}
?>
         
					<br>
<!--					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-30)</label>-->

	         </div>
		    </div>
<?php 
}

$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']>0)
			{
?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table table-hover table-striped" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                     
                          <th>Description</th> 
                                                <th>Specifics</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-4"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-4"><p class="form-control-static"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["Competency"][$j]["defgoal"]).'</textarea></p></td>';
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
if($doc["flag"]=="0" || $doc["flag"]=="1")
{}
elseif($doc["flag"]>="2")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';
}
?>          
					<br>
<!--					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-30)</label>-->

			    </div>
		    </div>
<?php
		}

$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']>0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table table-hover table-striped" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        
                         <th>Description</th> 
                                                <th>Specifics</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-4"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-4"><p class="form-control-static"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</textarea></p></td>';
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
if($doc["flag"]=="0" || $doc["flag"]=="1")
{}
elseif($doc["flag"]>="2")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';
}
?>
					<br>
	<!--				 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-5)</label>-->

	         </div>
		    </div>
<?php
			}

$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']>0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table table-hover table-striped" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                    
                           <th>Description</th> 
                                                <th>Specifics</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Goals Not yet set for this cycle...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["ValueAddition"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-4"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-4"><p class="form-control-static"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</textarea></p></td>';
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
if($doc["flag"]=="0" || $doc["flag"]=="1")
{}
elseif($doc["flag"]>="2")
{
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';
}
?>
					<br>
	<!--				 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-5)</label>-->

	         </div>
		    </div>
<?php } ?>

<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Trainings</h4>             	  
		         <table class="table table-hover table-striped" id="training">
		           <thead>
							<tr>
                        <th>Training</th>
                     	<!--<th>Training Date</th>-->
                       <th>Training Quarter</th>
                        
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($doc["flag"]=="0" || $doc["flag"]=="1")
{
	echo "<tr><td>Training Not yet set ...</td></tr>";
}
elseif($doc["flag"]>="2")
{
	$maxm=count($doc["training"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
		//	echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';					
  			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Trainings Not  set ...</b></td></tr>";   	
}
?>						                						           
					  </tbody>
			      </table>


					<br>
	<!--				 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-5)</label>-->

	         </div>
		    </div>
		    
		    <?php if($doc['flag']>2)
		    {
		    	?>
<div class="col-lg-12" style="padding-bottom:20px" id="feedback1" class="panel-collapse collapse out"> 
         	<div class="content-panel" style="padding-bottom:40px">
          <h4>Feedback</h4>             	  
		       			<div class="col-lg-12">
		       			<form class="form-horizontal" role="form">
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">Date</label>
    <div class="col-sm-6">
     	<input size="18"  id="dater1cmt"  class="datetimepickers" placeholder="Click Here.." ></input>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3" id="gll1" for="pwd">Select a Goal</label>
    <div class="col-sm-6"> 
     
	  				<select class="static-form-control" id="goal1" onchange="goal_change1(this.value)"><option selected disabled>Select a Goal</option>
					<option>Deliverables</option>
					<option>Quality</option>
					<option>Initiatives/ Ownership</option>
					<option>Organizational/ Project Contribution</option>
					<option>Strategic Planning /Value Addition</option> 
 					</select>
    </div>
  </div>
 <div class="form-group">
    <label class="control-label col-sm-3" id="deff" for="pwd">Select a Definition</label>
    <div class="col-sm-6"> 
     <select class="static-form-control" id="def1" onchange="goal_select(this)"><option selected disabled>Select a definition</option>
 					</select>
	  			
    </div>
  </div>
 
</form>
		       			
 						
		       			              
                                                                                              


  
 				
<table class="table table-hover table-striped" id="deliverables1">
		           <thead>
							<tr>
                        <th>Goal</th>
                          <th>Definition</th>                                                               							
								<th>Feedback</th> 		
							</tr>		           
		           </thead>
		           <tbody> 
		          
		           </tbody>
		           </table>					
 					
 		</div>	                                                            
					
 <center>                 			
<button class="btn btn-primary" onclick="savr1cmmt1()" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button>                    			
         </center>            			
									<div id="demo" class="panel-collapse collapse in">
									
									</div>
	         </div>
		    </div>

     <?php }
     
     else {?>  	
     
     <div class="col-lg-12" style="padding-bottom:20px" id="feedback1" class="panel-collapse collapse out"> 
         	<div class="content-panel" style="padding-bottom:40px">
          <h4>Employee has not yet accepted the goals in the system. Kindly request employee to accept.</h4>           
      </div>
		    </div>
     
     
<?php } ?>
	 </div>

<!--button-->
		  <div class="row mt" id="revBtns" style="display:none;">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:50px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-right" onclick="goback()">
                  <i class="fa fa-backward"></i>&nbsp&nbsp Back
                  
                </button>
                
               </div> 
              
            </div>
          </div>
         </div>
         
		</section><! --/wrapper -->

      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          

							<center><h5><p id="ms">Please, Select the Checkbox to accept the results and then click the accept button.</p></h5></center>
                 
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>  
                </div>
            </div>
        </div>
    </div>
    
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

<!--<script src="datetime/jquery.js"></script> -->
<script src="datetime/jquery.datetimepicker.js"></script>

<script type="text/javascript" >
		var todayDate="<?php echo date('Y/m/d'); ?>";
var todayTime="<?php echo date('H:i'); ?>";
var dateTime="<?php echo date('Y/m/d H:i') ?>";

$( "#dater1cmt" ).blur(function() {
  
  var d=$('#dater1cmt').val();
	//alert()
	if(d!=""||d!="____/__/__")
	{
	 $('#goal1').prop('disabled', false);
	 $('#def1').prop('disabled', false);
	//$('#goal1').val();
	//$('#def1').val();
	}
  
});

  $("#dater1cmt").datetimepicker({
	//mask:'9999/19/39 29:59',
	maxDate:todayDate,
	timepicker:false,
	format:'Y/m/d',
	mask:true,
	onSelectDate:function(ct,$i){
		//alert("hai");
	 $('#goal1').prop('disabled', false);
	 $('#def1').prop('disabled', false);
	}
	/*minTime:todayTime, 
	onSelectDate:function(ct,$i){
		this.setOptions({minTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()<dateTime)
		{
			$input.val("");
		}
	} */
}); 
/*$("#dater1cmt").datepicker({
    onSelect: function(dateText, inst) {
        //var date = $(this).val();
      //  var time = $('#time').val();
   
        alert('on select triggered');
       // $("#start").val(date + time.toString(' HH:mm').toString());
 $('#goal1').prop('disabled', false);
	 $('#def1').prop('disabled', false);
    }
});*/
</script>
<script type="text/javascript" >
function a()
{
ret();	
var d=$('#dater1cmt').val();
//alert()
if(d==""||d=="____/__/__")
{
	 $('#goal1').prop('disabled', true);
	 $('#def1').prop('disabled', true);
//$('#goal1').val();
//$('#def1').val();
}
}
var fl='<?php echo $doc["flag"]; ?>';
if(fl==2)
 { 
	$('#agrmnt').show(); 
 }

var rfl='<?php echo $doc["Rflag"]; ?>';
//if(rfl==1)
{
	$('#revBtns').show();
}
</script>

<script type="text/javascript" >
var inc1=11;
var inc2=21;
var defaultTextAreaCount=0;
var defaultTextAreaCount1=0;


function b()
{
	alert()
	if(d!=""||d!="____/__/__")
{
	 $('#goal1').prop('disabled', false);
	 $('#def1').prop('disabled', false);
//$('#goal1').val();
//$('#def1').val();
}
	
	}

function goback()
{
	window.location.href="gmanagerlist.php?active=r1";	
}
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
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) ||charCode==8 ||charCode==46||charCode==47||(charCode >= 48 && charCode <= 57)||charCode==13||charCode==32||charCode==40||charCode==41||charCode==92||charCode==44||charCode==34||charCode==39||charCode==64||charCode==33||charCode==58)
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

function goal_select(th)
{
	//alert();
 //var cate=$(th).attr("id");
//alert(cate);
var selected1=$('#goal1').val();
//alert(selected1);
 var selected=th.value;
// alert(selected);
defaultTextAreaCount++;
defaultTextAreaCount1++;
				$.ajax({ 
				url:'setDefaultText.php', 
				type:'POST', 
				data:'val='+selected, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert(data);
					//alert(str);
					$("#"+cate+defaultTextAreaCount).val(toTitleCase(data.toLowerCase()));
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(err); 
				} 
			});
	
 //alert(cate);
 //alert(selected);

	//if(cate=="dgoal")
	{
		//alert(selected)
 		$('table#deliverables1 > tbody').append('<tr class="rows" id="d'+inc1+'"><td>'+selected1+':</td><td><textarea readonly style="border: none;outline: none;" id="'+cate+defaultTextAreaCount+'" rows="4" cols="70" maxlength="240">'+selected+'</textarea></td><td><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="30" maxlength="240" name="feed1" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td><button class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
 		inc1++;
 	$("#def1").val("Select a definition");
	}
	
	
	
} 

function deletedesgn(th)
{
	//var msg=" 'Save' this change before leaving the page,to make it parmanent";	
	var desgn;	
	var p=$(th).parent().parent();
	//var p1=th.id;	
	
	
	//alert(dnc1);
	p.remove();
	inc1--;
	
	//document.getElementById("ms").innerHTML=msg;
	//$("#message").modal('show');
} 
function goal_change1(str)
{
	//ret();
	var id123=<?php echo $eid; ?>;
	//alert(id123);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
                document.getElementById('def1').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET","change_def1.php?goal=" + str + "&id=" +id123, true);
        xmlhttp.send();		
   }
function ret()
{
	 var id123= <?php echo $eid; ?>;
	//alert(id123);
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
                document.getElementById('demo').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET", "retriver1cmt.php?id=" + id123, true);
        xmlhttp.send();	
	//document.getElementById("idd").value="";
	}




function savr1cmmt1()
{
var comm,comm1;
var course_choices = $('textarea[name="feed1"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
	if(choice1.trim().length<=25)
	comm1="lesschar";
} 	
	var cmt=$('#msrment1').val();
var date=$('#dater1cmt').val();
var goal22=$('#goal1').val();
//alert(goal22);
var def22=$('#def1').val();
//alert(def22);
var id123=<?php echo $eid; ?>;
//alert(id123);
if(date==""||date=="____/__/__")
{
alert("Please select a date");
}
else if(inc1<=11)
{
alert("Please select goals and definition");	
}
else if(comm=="none")
		{alert("Please enter all feedbacks");
		}
		else if(comm1=="lesschar")
		{alert("Please enter more than 25 characters in comment box.");
		}
else
{
	//alert()
	var columnvalue=[];
	var postdata={};
		columnvalue[columnvalue.length]="<?php echo $eid; ?>";
		columnvalue[columnvalue.length]=$('#dater1cmt').val();
$("#deliverables1 tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
		 			columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
						
						
							});	
for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			//if(calculateSum())
			{
			$.ajax({ 
			url:'feedbackinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Saved Successfully!");
					 $('#goal1').prop('disabled', true);
	 					$('#def1').prop('disabled', true);
					//window.location.reload();
					t=1;
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(err); 
				} 
			});
			}					
					
			columnvalue=[];		
					
$("#goal1").val("Select a Goal");					
$("#def1").val("Select a definition");
	$('#dater1cmt').val("____/__/__");
$("#deliverables1 > tbody").html("");	
	//$('#deliverables1').empty();
	inc1=11;

ret();					
			
}}
function accept()
{
var checkedvalue=document.getElementById("agree").checked;
if(checkedvalue)
{
var id="<?php echo $_SESSION['psiid']; ?>";
$.ajax({ 
url:'eAcceptGoals.php',
type:'POST', 
data:{"id":id,"role":"emp"},
success:function(data){
	//alert(data); 
	alert("Successfully Acknowledged");
window.location.href="dashoboard.php";
},
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
}
else
{
$("#message").modal('show');
}
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
