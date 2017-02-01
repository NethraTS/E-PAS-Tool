<?php
session_start();include session_timeout.php;
include 'secure.php';
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
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<style type="text/css">
.ui-slider-range { background: #ef2929; }
.ui-slider-handle { border-color: #ef2929; }
</style>

<script type="text/javascript" >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


<script>
var ar={"E-":1,"E":2,"E+":3,"X":4};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({min:1,max:4,});
$('.qslider').slider({min:1,max:5});
 
$('#overallSR').slider( "option", "value",ar[$('#overallSR').attr("name")]); //to set slider value

$('#1').slider( "option", "value",$('#1').attr("name")); 
$('#2').slider( "option", "value",$('#2').attr("name")); 
$('#3').slider( "option", "value",$('#3').attr("name")); 
$('#4').slider( "option", "value",$('#4').attr("name")); 
$('#5').slider( "option", "value",$('#5').attr("name")); 
$('#6').slider( "option", "value",$('#6').attr("name")); 
$('#7').slider( "option", "value",$('#7').attr("name")); 
$('#8').slider( "option", "value",$('#8').attr("name")); 
$('#9').slider( "option", "value",$('#9').attr("name")); 
$('#10').slider( "option", "value",$('#10').attr("name")); 
$('#11').slider( "option", "value",$('#11').attr("name")); 
$('#12').slider( "option", "value",$('#12').attr("name")); 


 
// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','E','E+','X'],  
    prefix: "",  
    suffix: ""      
});

$('.qslider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['1','2','3','4','5'],  
    prefix: "",  
    suffix: ""      
});

$(".noslider").slider('disable');
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
$d=$c->findOne(array("psiid"=>$_SESSION["psiid"]));
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));

$f=0;

if($d["flag2"]=="0")
{
$f=0;
}
elseif($d["flag2"]=="1") 
{
$f=1;
}
elseif($d["flag2"]>="2")
{
$f=2;
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
          	<h3>Self-Assessment</h3>
          <p class="pull-right">Page 2</p>
          
					<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">           		 
 <div class="pull-right" style="color:green"><b>Rating&nbsp&nbsp&nbsp&nbsp1:low&nbsp&nbsp&nbsp&nbsp5:high</b></div>                       
                  	  <h4 class="mb">Questionnaire </h4>
               
                      <form class="form-horizontal style-form" method="get">
                                  <label class="col-sm-1"><b>1</b></label>
                                  <p class="form-static-control col-lg-6"> 
                                     I am satisfied about the work assigned to me.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="1" name="0"></div>';
elseif($f==1)
echo '<div class="qslider green col-lg-2" id="1" name="'.$d['q1'].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="1" name="'.$d['q1'].'"></div>'; 

?>
											 </p>
<br><br><br><br>
                                 <label class="col-sm-1"><b>2</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I receive useful and constructive feedback about my work.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="2" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="2" name="'.$d['q2'].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="2" name="'.$d['q2'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>3</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My job makes good use of my skills and abilities.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="3" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="3" name="'.$d["q3"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="3" name="'.$d['q3'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>4</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I was given opportunities/responsibilities at workplace.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="4" name="0"></div>';
elseif($f==1)
echo '<div class="qslider green col-lg-2" id="4" name="'.$d["q4"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="4" name="'.$d['q4'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>5</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My ideas and opinions count at work.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="5" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="5" name="'.$d["q5"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="5" name="'.$d['q5'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>6</b></label>
                                  <p class="form-static-control col-lg-6"> 
											 Information and knowledge are shared openly within the team.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="6" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="6" name="'.$d["q6"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="6" name="'.$d['q6'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>7</b></label>
                                  <p class="form-static-control col-lg-6"> 
												Team follows leading edge of professional and technical best practices.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="7" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="7" name="'.$d["q7"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="7" name="'.$d['q7'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>8</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My work is challenging, stimulating, and rewarding.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="8" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="8" name="'.$d["q8"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="8" name="'.$d['q8'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>9</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I am involved in decisions that affect my work.		
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="9" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="9" name="'.$d["q9"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="9" name="'.$d['q9'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>10</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My supervisor is actively interested in my professional development and advancement.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="10" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="10" name="'.$d["q10"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="10" name="'.$d['q10'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>11</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I work in an environment that encourages continuous learning.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="11" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="11" name="'.$d["q11"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="11" name="'.$d['q11'].'"></div>'; 
?>
											 </p>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>12</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I help the team turn strategy into quantifiable goals/actions.
<?php
if($f===0)
echo '<div class="qslider green col-lg-2" id="12" name="0"></div>';
elseif($f===1)
echo '<div class="qslider green col-lg-2" id="12" name="'.$d["q12"].'"></div>';
elseif($f==2)
echo '<div class="qslider green col-lg-2 noslider" id="12" name="'.$d['q12'].'"></div>'; 
?>
											 </p>
<br><br>											
											          
			                     
                       </form>
                       </div>
                  </div>
                  </div>
          
<!-- review form -->          
          	<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb">Self-Review </h4>
                      <form class="form-horizontal style-form" method="get">
                              <label class="col-sm-2 col-sm-2 control-label">Overall Self-Rating</label>
                              <div class="col-sm-9">
<?php
if($f==0)
{  
echo '<div class="slider green col-lg-2" id="overallSR" name="E-"></div>';
}
elseif($f==1)
{ 
echo '<div class="slider green col-lg-2" id="overallSR" name="'.decrypt($d['overallselfrating']).'"></div>';
}
elseif($f==2)
{
echo '<div class="slider green col-lg-2 noslider" id="overallSR" name="'.decrypt($d['overallselfrating']).'"></div>';
}
?>
                              </div>
                               <br><br><br>

                              <label class="col-sm-2 col-sm-2 control-label">Personal comments/ Suggestions</label>
                              <div class="col-sm-9">
<?php 
if($f==0)
{
echo '<textarea  class="add-regular" id="personalComments" rows="4" cols="70" maxlength="320"></textarea>';
}
elseif($f==1)
{
echo '<textarea class="add-regular" id="personalComments" rows="4" cols="70" maxlength="320">'.decrypt($d['personalcomments']).'</textarea>';
}
elseif($f==2)
{
echo '<textarea class="add-regular"  id="personalComments" rows="4" cols="70" readonly="readonly">'.decrypt($d['personalcomments']).'</textarea>';
}
?>
                              </div>
<br><br><br><br><br>
                 
                       </form>
                       </div>
                  </div>
                  </div>

   <!-- save and submit buttons -->
<div class="row-mt">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width:103%;margin-left:-15px;">
<div class="form-panel">
<form class="form-horizontal style-form" >
	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-3">
<?php
if($f==2)
{
echo '<button type="button" class="btn btn-theme03 pull-left disable" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
else {
echo '<button type="button" class="btn btn-theme03 pull-left" onclick="sav();"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
?>	           

	<div class="col-lg-3 col-md-5 col-sm-5 col-xs-4">    
<?php
if($f==2)
{ 
echo '<button type="button" class="btn btn-theme03 pull-left disable" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button> </div>';
}  
else
{ 
echo '<button type="button" class="btn btn-theme03 pull-left" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button> </div>';
}  
?>

    	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-4">           
    <button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='selfassessmentform.php'"><i class="fa fa-arrow-left"></i>&nbspBack</button> </div>
<br><br>            
</form>
</div>
</div>  
</div>


<div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                 <form role="form">							              
                    <h4><center>Your Self-Assessment has been submitted successfully!</center></h4>                      
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-primary" name="ok" onclick="window.location.href='dashoboard.php'">OK</button> 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>

<div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4><center>Your Self-Assessment has been saved!</center></h4>
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-primary close" data-dismiss="modal" name="ok">OK</button> 
                       </div>  
                </div>
            </div>
        </div>
    </div>


<div id="conf" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body">
                 <form role="form" method="POST" action="">
							              
                No changes can be made after submit. Are you sure?      
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" data-dismiss="modal" name="edit" onclick="sub()">Yes</button> 
                       </div>  
                    </form>             
                </div>
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
   <!-- <script src="assets/js/jquery.js"></script> -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>




    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>     -->    
   
    
    <script src="Gritter-master/js/jquery.gritter.js"></script>
 <script src="Gritter-master/js/jquery.gritter.min.js"></script>

  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
  </script>
<script type="text/javascript" >
  $('.slider').slider();
 $(".disable").prop('disabled',true);    
</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var v={0:"not set",1:"E-",2:"E",3:"E+",4:"X"};
function sav()
{
var sv = $( ".slider" ).slider( "option", "value" ); //to get slider value

//$( ".selector" ).slider( "option", "value", 10 ); //setter
columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[sv];
columnvalue[columnvalue.length]=$('#personalComments').val();
columnvalue[columnvalue.length]=$("#1").slider("option","value");
columnvalue[columnvalue.length]=$("#2").slider("option","value");
columnvalue[columnvalue.length]=$("#3").slider("option","value");
columnvalue[columnvalue.length]=$("#4").slider("option","value");
columnvalue[columnvalue.length]=$("#5").slider("option","value");
columnvalue[columnvalue.length]=$("#6").slider("option","value");
columnvalue[columnvalue.length]=$("#7").slider("option","value");
columnvalue[columnvalue.length]=$("#8").slider("option","value");
columnvalue[columnvalue.length]=$("#9").slider("option","value");
columnvalue[columnvalue.length]=$("#10").slider("option","value");
columnvalue[columnvalue.length]=$("#11").slider("option","value");
columnvalue[columnvalue.length]=$("#12").slider("option","value");

for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);
$.ajax({ 
url:'sa2insert.php', 
type:'POST', 
data:{json:unique}, 
success:function(data){ 
$("#myModal2").modal('show');
//alert("Saved Successfully!");
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});

columnvalue=[];
return false;
}
</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var v={0:"not set",1:"E-",2:"E",3:"E+",4:"X"};
function sub()
{
var sv = $( ".slider" ).slider( "option", "value" ); //to get slider value	
columnvalue[columnvalue.length]="<?php echo $psiid; ?>";
columnvalue[columnvalue.length]=v[sv];
columnvalue[columnvalue.length]=$('#personalComments').val();
columnvalue[columnvalue.length]=$("#1").slider("option","value");
columnvalue[columnvalue.length]=$("#2").slider("option","value");
columnvalue[columnvalue.length]=$("#3").slider("option","value");
columnvalue[columnvalue.length]=$("#4").slider("option","value");
columnvalue[columnvalue.length]=$("#5").slider("option","value");
columnvalue[columnvalue.length]=$("#6").slider("option","value");
columnvalue[columnvalue.length]=$("#7").slider("option","value");
columnvalue[columnvalue.length]=$("#8").slider("option","value");
columnvalue[columnvalue.length]=$("#9").slider("option","value");
columnvalue[columnvalue.length]=$("#10").slider("option","value");
columnvalue[columnvalue.length]=$("#11").slider("option","value");
columnvalue[columnvalue.length]=$("#12").slider("option","value");

var qcount=0;
for(j=3;j<columnvalue.length;j++)
if(columnvalue[j]==0)
qcount++;

if(qcount>=1)
alert("Please, rate all the questions in the questionairre before submit.");
else
{
for (i=0;i<columnvalue.length;i++)
{
postdata[i]=columnvalue[i];
}
unique=JSON.stringify(postdata);
//alert(unique);
$.ajax({ 
url:'sa2insert.php', 
type:'POST', 
data:{json:unique}, 
success:function(data){ 
//alert(data);
var id="<?php echo $psiid; ?>";
$.ajax(
{
url:'submitsaform.php',
type:'POST',
data:{"id":id,"sub":"true"}, 
success:function(data){ 
$("#myModal1").modal('show');
//alert(data); 
},
failure:function(xhr,desc,err){
alert("fail1");
}
});
}, 
error:function(xhr,desc,err){ 
alert("fail2"); 
} 
}); 
}
columnvalue=[];
//return false;
}
</script>
<script type="text/javascript" >
	$('.add-regular').focus(function(){

			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<b style="text-shadow:none;">A regular notice!</b>',
				// (string | mandatory) the text inside the notification
				text: 'Only 320 characters are allowed in the Text Area.Please, ensure your comment <i><b style="color:yellow">doesnot exceed the 320-characters</b></i> limit.',
				// (string | optional) the image to display on the left

				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: false,
				// (int | optional) the time you want it to be alive for before fading out
				time: ''
			});

			return false;

		});
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
