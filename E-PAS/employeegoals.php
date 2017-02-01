<?php
session_start();
include session_timeout.php;
require('auth.php');
include 'secure.php';
include 'checkGRRstatus.php';
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
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
$st=checkstatus($psiid);
$eid=$psiid;
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
//$st="Yes";
$doc=$c->findOne(array("id"=>$eid));
if($doc['flag']==0)
$notset="Goals not yet set by your manager!!";
if($st=="Yes"&&$doc['flag']>=3)
{
header('Location:employeegoalsreview.php'); 
}
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
  	 <?php if($doc['flag']!=0)
{     
     ?>
    <!--  <html><marquee direction="left" loop="50" width="80%" ><font color="green"> * My Accomplishments tab is editable only once Review starts</font></marquee></html>-->
 <table> 
 <tr><td>
<?php   
     echo '<h3>'.$doc["name"];?></td></tr>
     
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
  	<?php } ?>
</div>


<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  <?php 
 			if($doc['gWts']['del']>=0)
 			{    	
    	?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table table-hover table-striped" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurements</th>
                        
                          <th>Descriptions</th>
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
  			echo '<td class="col-lg-4"><p class="form-control-static"><textarea style="border: none" rows="5" cols="50"  maxlength="240"  readonly="readonly" >'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</textarea></p></td>';
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
$eid=$psiid;
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
                 <th>Measurements</th>
                        
                          <th>Descriptions</th>
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
$eid=$psiid;
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']>=0)
			{
?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table table-hover table-striped" id="competency">
		           <thead>
							<tr>
                          <th>Measurements</th>
                        
                          <th>Descriptions</th>
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
$eid=$psiid;
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table table-hover table-striped" id="orgcontribution">
		           <thead>
							<tr>
                         <th>Measurements</th>
                        
                          <th>Descriptions</th>
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
$eid=$psiid;
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table table-hover table-striped" id="valueaddition">
		           <thead>
							<tr>
                       <th>Measurements</th>
                        
                          <th>Descriptions</th>
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

<?php if($doc['flag']==0)
{?>
<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4><?php echo $notset; ?></h4>             	  
		        


					<br>
	<!--				 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-5)</label>-->

	         </div>
		    </div>
		    
		    <?php }?>
		    
<?php if(count($doc['training'])>0)
{?>	    
<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Trainings</h4>             	  
		         <table class="table table-hover table-striped" id="training">
		           <thead>
							<tr>
                        <th>Training</th>
                   <th></th>
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
  			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
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
<?php } ?>

       	<div class="col-lg-12" style="padding-bottom:20px;display:none;" id="agrmnt"> 
         	<div class="content-panel" style="padding-bottom:40px">
					<b><h4>
		  			<input type="checkbox" value="" id="agree" name="agree">&nbsp&nbsp
						I acknowledge that above Goals are discussed and concluded.</h4></b>
					<button class="btn-sm pull-right btn-theme03 Button"  style="margin-right:25px" onclick="accept()">Accept</button>
					<br>
		    	</div>
		    </div>

	 </div>

<!--button-->
		  <div class="row mt" id="revBtns" style="display:none;">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:50px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left">
                  <i class="fa fa-check"></i>&nbsp&nbsp Save
                </button>
               </div> 
                <div class="col-lg-6">
                <button class="btn btn-theme03 pull-right">
                  <i class="fa fa-check"></i>&nbsp&nbsp Submit
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
                   			<button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal1" >Close</button>
                   			<button type="button" class="btn btn-default" style="display:none" data-dismiss="modal" id="closeModal2" >Ok</button>
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

<script type="text/javascript" >
var fl='<?php echo $doc["flag"]; ?>';
if(fl==2)
 { 
	$('#agrmnt').show(); 
 }

var rfl='<?php echo $doc["Rflag"]; ?>';
if(rfl==1)
{
	$('#revBtns').show();
}
</script>

<script type="text/javascript" >
function goback()
{
	window.location.href="gmanagerlist.php?active=r1";	
}
$('#closeModal2').click(function(){
	//alert("asda");
	window.location.href="dashoboard.php";
	}); 
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
	$('#ms').text("Successfully Acknowledged and redirecting to Dashboard");
	$('#closeModal1').hide();
	$('#closeModal2').show();
	$("#message").modal('show')
	//alert("Successfully Acknowledged and redirecting to Dashboard");
//window.location.href="dashoboard.php";
},
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
}
else
{
$("#message").modal('show')
}
}

</script>

<script type="text/javascript" >
function ajaxindicatorstart(text)
	{
		if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
		jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="482(1).GIF"><div>'+text+'</div></div><div class="bg"></div></div>');
	}
		jQuery('#resultLoading').css({
			'width':'100%',
			'height':'100%',
			'position':'fixed',
			'z-index':'10000000',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto'
		});	
		
		jQuery('#resultLoading .bg').css({
			'background':'#000000',
			'opacity':'0.7',
			'width':'100%',
			'height':'100%',
			'position':'absolute',
			'top':'0'
		});
		jQuery('#resultLoading>div:first').css({
			'width': '250px',
			'height':'75px',
			'text-align': 'center',
			'position': 'fixed',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto',
			'font-size':'16px',
			'z-index':'10',
			'color':'#ffffff'
			
		});

	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeIn(300);
	    jQuery('body').css('cursor', 'wait');
	}

	function ajaxindicatorstop()
	{
	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeOut(300);
	    jQuery('body').css('cursor', 'default');
	}
	
jQuery(document).ajaxStart(function () {
   		//show ajax indicator
		ajaxindicatorstart('Processing.. please wait..');
  }).ajaxStop(function () {
		//hide ajax indicator
		ajaxindicatorstop();
  });

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
