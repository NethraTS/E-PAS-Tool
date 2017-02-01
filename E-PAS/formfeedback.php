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

  <body  onload="RelievingInfo()" >
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


$doc=$bd->findOne(array("psiid"=>$psiid,"psiid"=>$psiid));


$f=0;

if($d["flag2"]=="0")
{
$f=0;
}
elseif($d["flag2"]=="1") 
{$empdoc=$employee->find();
$f=1;
}
elseif($d["flag2"]>="2")
{
$f=2;
}

$flag = $doc["EF"];

echo $flag;

if($doc["EF"]>="2")
{

		$msg="You have completed your Exit Feedback Form..!"; 	
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
          	 <h3 class="mb">Exit Interview Form </h3>
			 
<?php
if($msg==0)
{}
else {
echo "<h3><center>".$msg."</center></h3>";
}
?>
			 
			 
          <p class="pull-right">Page 2</p><br>
          <p>We would appreciate you taking about 8-10 minutes to answer the following questions as honestly as possible. Your responses are treated as confidential. We believe that the information is of vital importance and will assist us analyzing our employee retention and turnover 
         
          
					<div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">           		 
                      <p>
<br> PSI-ID &emsp; : &nbsp;


<!--
<textarea  class="pull-center" id="Comment2" rows="1" cols="50" maxlength="220" value="<?php echo ''.$psiid.'';?>" ></textarea>
 -->
 
 <input type="text" maxlength="4" id="Comment2" size="11" value="<?php echo ''.$psiid.'';?>" readonly> 
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;

  Name &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: &nbsp;

<input type="text" maxlength="30" size="35" id="Comment1" readonly> 

<br><br>            
<br>Project &nbsp; : &nbsp;


<input type="textarea" maxlength="75" size="35" id="Comment3" > 

&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;

Designation &emsp;&emsp;&emsp;: &nbsp;


<input type="textarea" maxlength="75" size="35" id="Comment4" readonly> 


<br><br>    
<br>DOJ &emsp;&emsp; : &nbsp;
         
<input type="textarea" maxlength="10" size="11" id="Comment5" readonly> 

&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;

Date of Relieving&emsp;:&nbsp;
         
<input type="textarea" maxlength="10" size="11" id="Comment6" readonly> 
             
                  	 
  <br><br><br><br>             
                      <form class="form-horizontal style-form" method="get">
                                  <label class="col-sm-1"><b>1</b></label>
                                  <p class="form-static-control col-lg-6"> 
                                      What promoted you to seek alternative employment?
                                       
											 </p>
											 <?php 

//echo '<textarea  class="add-regular" id="Comment7" rows="4" onkeyup="nospaces(this)" cols="70" maxlength="320"></textarea>';
echo '<textarea  class="add-regular" id="Comment7" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';


?>
<br><br><br><br>
                                 <label class="col-sm-1"><b>2</b></label>
                                  <p class="form-static-control col-lg-6"> 
												What do you value/dislike about the Job?
											 </p>
											 <?php 


echo '<textarea  class="add-regular class="pull-right"" id="Comment8" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';




?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>3</b></label>
                                  <p class="form-static-control col-lg-6"> 
												What are your views about Management and leadership, in general, in the job?
											</p>
										 <?php 
echo '<textarea  class="add-regular" id="Comment9" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>4</b></label>
                                  <p class="form-static-control col-lg-6"> 
												What does your new job offer that your job with this company does not?

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment10" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>5</b></label>
                                  <p class="form-static-control col-lg-6"> 
											 Can you offer any other comments that will enable us to understand why you are leaving,<br>
											  how we can improve?
												</p>
												<?php 
echo '<textarea  class="add-regular" id="Comment11" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';

?>

											 
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>6</b></label>
                                  <p class="form-static-control col-lg-6"> 
											 what we can do to become a better company?

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment12" rows="4" onfocusout="nospaces(this)" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>	

							 
                                 <!--label class="col-sm-1"><b>7</b></label>
                                  <p class="form-static-control col-lg-6"> 
												Team follows leading edge of professional and technical best practices.

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment7" rows="4" cols="70" maxlength="320"></textarea>';

?>
											 
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>8</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My work is challenging, stimulating, and rewarding.

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment8" rows="4" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>9</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I am involved in decisions that affect my work.		

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment9" rows="4" cols="70" maxlength="320"></textarea>';

?>
											 
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>10</b></label>
                                  <p class="form-static-control col-lg-6"> 
												My supervisor is actively interested in my professional development and advancement.
										 </p>
										 <?php 
echo '<textarea  class="add-regular" id="Comment10" rows="4" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>11</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I work in an environment that encourages continuous learning.
										 </p>
										 <?php 
echo '<textarea  class="add-regular" id="Comment11" rows="4" cols="70" maxlength="320"></textarea>';

?>
<br><br><br><br>								 
                                 <label class="col-sm-1"><b>12</b></label>
                                  <p class="form-static-control col-lg-6"> 
												I help the team turn strategy into quantifiable goals/actions.

											 </p>
											 <?php 
echo '<textarea  class="add-regular" id="Comment12" rows="4" cols="70" maxlength="320"></textarea>';

?>-->
<br><br>											
											          
			                     
                       </form>
                       </div>
                 <div class="row-mt">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width:103%;margin-left:-15px;">
<div class="form-panel">
<form class="form-horizontal style-form" >
	
        

	
<?php

//$empdoc=$bd->find();

/*foreach($empdoc as $el)
{
	
 if($el["EF"]==2)
  {

  echo '<button type="button" class="btn btn-theme03 pull-left"  data-toggle="modal" data-target="#conf" id="submit" disabled="disabled"><i class="fa fa-check-square "></i>&nbspSubmit</button>';

  }*/

	echo '<button type="button" class="btn btn-theme03 pull-left" data-toggle="modal" data-target="#conf" id="submit"><i class="fa fa-check-square "></i>&nbspSubmit</button>';
	
?>

     	           
    <button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='dashoboard.php'"><i class="fa fa-arrow-left"></i>&nbspBack</button>
<br><br>
         
</form>
</div>
</div>  
</div>     
                       
                       
                  </div>
                  </div>
          
<!-- review form -->          
          	<!--div class="row mt">
          		<div class="col-lg-12"> 
          		<div class="form-panel">  
                  	  <h4 class="mb">Self-Review </h4>
                      <form class="form-horizontal style-form" method="get">
                              <label class="col-sm-2 col-sm-2 control-label">Overall Self-Rating</label>
                              <div class="col-sm-9">-->

                              </div>
                               <br><br><br>

                            
                 
                       </form>
                       </div>
                  </div>
                  </div>
 
   <!-- save and submit buttons -->



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


function sub()
{
	alert("Validating ....");
	
			
var comment1=document.getElementById("Comment1").value;
var comment2=document.getElementById("Comment2").value;
var comment3=document.getElementById("Comment3").value;
var comment4=document.getElementById("Comment4").value;
var comment5=document.getElementById("Comment5").value;
var comment6=document.getElementById("Comment6").value;
var comment7=document.getElementById("Comment7").value;
var comment8=document.getElementById("Comment8").value;
var comment9=document.getElementById("Comment9").value;
var comment10=document.getElementById("Comment10").value;
var comment11=document.getElementById("Comment11").value;
var comment12=document.getElementById("Comment12").value;
var eid=<?php echo $_SESSION["psiid"] ?>;
if(document.getElementById("Comment7").value=="")
  	{
  		alert("Please enter all the fields .")
  		}
  		else if(document.getElementById("Comment8").value=="")
  	{
  		alert("Please enter all the fields.")
  		}
  		else if(document.getElementById("Comment3").value=="")
  	{
  		alert("Please enter all the fields.")
  		}
      else if(document.getElementById("Comment9").value=="")
  	{
  		alert("Please enter all the fields.")
  		}
  		else if(document.getElementById("Comment10").value=="")
  	{
  		alert("Please enter all the fields.")
  		}
  		else if(document.getElementById("Comment11").value=="")
  		{
alert("Please enter all the fields.")  			
  			}
  		else if(document.getElementById("Comment12").value=="")
  	{
  		alert("Please enter all the fields.")
  		}
	
  		
else
{
	
$.ajax({ 
url:'changeEf2.php', 
type:'POST', 
data:{"eid":eid,"comment1":comment1,"comment2":comment2,"comment3":comment3,"comment4":comment4,"comment5":comment5,"comment6":comment6,"comment7":comment7,"comment8":comment8,"comment9":comment9,"comment10":comment10,"comment11":comment11,"comment12":comment12,"sub":"true"}, 
success:function(data){ 
//$("#myModal2").modal('show');
alert("Saved Successfully!"); 

document.getElementById("submit").disabled = true;

window.location.href="dashoboard.php";

//$('<button type="button" class="btn btn-theme03 pull-left disabled" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button>');
//alert(data);
 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});	
	
}
}

/*function Validate() 
{
	
    var val = document.getElementById('Comment7').value;
    
    if (!val.match(/^[a-zA-Z]+$/)) 
    {
        alert("Only alphabets are allowed");
        return false;
    }
    
    return true;
}*/


function nospaces(t)
{

    if (t.value.trim().length == 0)
	{
		alert('Please provide valid comments.');
	    t.focus()
	    return false;
	}

    return true;
}

function RelievingInfo()
{
//alert(e_id);

var e_id = document.getElementById("Comment2").value;
	
	$.ajax({ 
				url:'RelievingInfo.php', 
				type:'POST', 
				data:{"id":e_id,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Accessed Successfully!!");
					//window.location.href="employeedetails.php";
				var json = JSON.parse(data);
			
if(json!=null)
{	

		document.getElementById("Comment4").value = json["Role"];
	  document.getElementById("Comment5").value = json["DOJ"];
	  document.getElementById("Comment6").value = json["LWD"];
	  document.getElementById("Comment1").value = json["Name"];
	  alert("he");
}
else
{
document.getElementById("Comment4").value = "";
  document.getElementById("Comment5").value = "";	
  document.getElementById("Comment6").value = "";
  document.getElementById("Comment1").value = "";	
	
	}				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
	
	
	
	
	
	}
	
function no_back() 
        {
        	alert("hi");
     window.history.foward(-1);
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
				time: '10 sec'
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



  </body>
</html>
{ 