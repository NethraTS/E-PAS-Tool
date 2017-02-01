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

<style >textarea { width: 100%; }</style>

<script type="text/javascript" >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script>
var ar={"":0,"E-":1,"E":2,"E+":3,"X":4};
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

});

/*function load()
{
	var eid=(<?php echo $_SESSION["psiid"]?>);
	
	$.ajax({ 
				url:'Date.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Accessed Successfully!!");
					//window.location.href="employeedetails.php";
				var json = JSON.parse(data);
			alert(json["startdate"]);
if(json!=null)
{	

		document.getElementById("date1").value = json["startdate"];
	  document.getElementById("date2").value = json["LWD"];
	  
	  alert("he");
}
else
{
document.getElementById("date1").value = "";
  document.getElementById("date2").value = "";	
	
	}				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
	
	
	
	
	}*/
</script>

</head>

<body onload="date()">
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$fl=$db->deadlineFlags;
$n=$db->Notifications;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];


$doc=$bd->findOne(array("psiid"=>$psiid));

$ef=$doc1["EF"];

$d=$c->findOne(array("psiid"=>$_SESSION["psiid"]));
$f=0;

if($d["flag1"]=="0")
{
	$f=0;	
}
elseif($d["flag1"]=="1") 
{
	$f=1;	
}	
elseif($d["flag1"]>="2")
{
	$f=2;	
}

$postponed=0;
$msg=0;
$SADFObj=$fl->findOne(array("name"=>"SAdeadlineOver"));
if($SADFObj["flag"]=="0")
	{}
elseif($SADFObj["flag"]=="1")
{
	$ESADFObj=$fl->findOne(array("name"=>"ESAdeadlineOver"));
	if($ESADFObj["flag"]=="0")
	{
		$deadlineobj=$n->findOne(array("name"=>"ExtendedSelfAppraisals"));
		$msg="The last Date for Self-Appraisal submission is".$deadlineobj["Deadline"].".Please, SUBMIT your competed forms before the aforesaid date.";
	}
	elseif($ESADFObj["flag"]=="1")
	{
		if($d["postponedFlag"]=="1")
		{
			$f=2;
			$postponed=1;
			$msg="Self-Appraisal Deadline has expired.Your Review Process is postponed to the next review cycle."; 	
		}
	}
}

$pod=$n->findOne(array("name"=>"portalOpening"));
$r1=$n->findOne(array("name"=>"review1"));
$today = date("d-m-Y");
$today_time = strtotime($today);
$sadeadline = date('d-m-Y', strtotime('-5 days', strtotime($r1["Deadline"])));
//echo $today;
//echo $pod["Date"];

if (strtotime($pod["Date"]) <= $today_time) 
	$reviewstarted=1;	
else 
	$reviewstarted=0;

if (strtotime($sadeadline) <= $today_time) 
	{
		$deadlineexpired=1;
		$f=2;
	}
else 
	$deadlineexpired=0;

//echo $deadlineexpired;

	

?>
<?php /* echo ''.$psiid.'';  */?>  

  <section id="container" >

<?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3>Acceptance of Resignation & Non-Compete Clause</h3>
          	<p class="pull-right">Page 1</p>
          	<div class="row mt">
          		<div class="col-lg-12">
          		
          
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	               	  	  
	                  	  <!--	  <hr> -->
		                      <table>
		                      <p align="justify" style="line-height: 200%; padding:20px;"> <B>
	
Employee ID &nbsp; : &nbsp; <input type="text"  style="border:none" maxlength="4" value="<?php echo ''.$psiid.'';?>" id="date" size="5" readonly> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee Name &nbsp; : &nbsp; <input type="text" style="border:none" maxlength="4" id="empsign" readonly > 
  <br>  <br>

We are in receipt of your letter dated &nbsp; <input  type="text"  style="border:none" maxlength="4" size="10" id="date1" readonly>&nbsp; resigning from the services of the company. Your last working day would be on <input type="text"  style="border:none" maxlength="4" size="10" id="date2" readonly> . 

You are requested to perform the assigned work with commitment and accountability. For a smooth exit formalities HR team should get a clearance email and NDA signed by the 
project manager. While serving notice if we could see any disconnect or breaching the employment terms then the company management have full rights to take the action but not 
limited to termination of employment.Please note that this letter is issued to you indicating acceptance of your resignation by the management. Final relieving and experience letter
will be issued on the day of relieving.Company can terminate this agreement at any point of time if the performance of the employee doesn’t meet company expectations.

<br><br>  Non-Compete Clause: 
<ol type="1"  style="line-height: 200%; padding:0px 45px;" align="justify">
<li> For six (06) months period following the termination of employee’s employment, employee shall not in any capacity, directly or indirectly advise, manage, consult, render or perform services to or for any person or entity or any customer of company which is engaged in a business competitive to that of the company or its customers with whom employee has engaged within any geographical location wherein the company produces, sells or markets its product and&nbsp;&nbsp;&nbsp;services at the time of such termination.
<br><br>
<li> Employee who has worked for multiple customer accounts or customer projects with the company in the past 6 months period, Non-compete clause 1 is applicable for all accounts he worked for.
<br><br>
<li> For a period of six (6) months following the termination of employment with company for any reason, employee will not:
<br>
<ol type="a" style="padding:10px 10px 0px 45px;">
<li>  Accept any offer of employment from any Customer, where employee had worked in a professional capacity with that Customer in the twelve (12) months immediately preceding the termination of employee employment with Company;
 <br>
<li>  Accept any offer of employment from a Named Competitor of Company, if employment with such Named Competitor would involve employee having to work with a Customer with whom employee had worked in the twelve (12) months immediately preceding the termination of employee employment with company.
</ol>
</ol>
<br>
<p align="justify" style="line-height: 200%; padding:0px 20px;"> 
     For the purposes of this Addendum, "Named Competitor" shall mean companies that extend similar or same services to the customer.
<br><br>

<label><input type="checkbox" id="iagree" value="true" onclick="check_date()" ></label>THE UNDERSIGNED HAS READ THIS AGREEMENT IN ITS ENTIRETY AND UNDERSTANDS IT.
<br><br>Reporting Manager  &nbsp;:&nbsp; <input  type="text" maxlength="4" style="border:none" id="repmanager" readonly>

<br><br>Date & Time &nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input  type="text" style="border:none"  size="51" id="HRteam" readonly>


	</B> </p>							
	</table>
	 </div>
 	</div>

    
   <!-- save and submit buttons -->

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 showback" style="width:97%;margin-left:13px;">
<div class="col-lg-6">
          
<div class="col-lg-6">

<button type="button" id="feedbackNext" class="btn btn-theme03 pull-right" onclick="next()">&nbspAccept</button> 
<!--button type="button" id="feedbackSave" class="btn btn-theme03 pull-right" onclick="save_date()">&nbspSave</button> -->
<!--button type="button" id="feedbackSave" class="btn btn-theme03 pull-left" onclick="save()">&nbspSave</button>-->
 <!--label><input type="checkbox" id="iagree" value="true" >I agree</label>-->
         

</div>  </div>


  
</div> </div>	</div>		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->I

      <!--main content end-->


<div id="myModal1" class="modal fade">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                 <form role="form">
							    <h4><center>The Self Assessment has been saved.</center></h4>          
                 <div class="modal-footer">
                   			<a class="btn btn-info close" data-dismiss="modal" name="ok">OK</a> 
                       </div>        
                    </form>             
                </div>
            </div>
        </div>
    </div>



      <!--footer start-->
     <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--   <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->      
    <script src="slider/js/bootstrap-slider.js"></script>
  		<script src="jQuery-ui-Slider-Pips-master/src/js/jquery-ui-slider-pips.js"></script>    

<script src="Gritter-master/js/jquery.gritter.js"></script>
 <script src="Gritter-master/js/jquery.gritter.min.js"></script>
	

<script type="text/javascript">
	$('#add-regular').focus(function(){

			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<b style="text-shadow:none;">A regular notice!</b>',
				// (string | mandatory) the text inside the notification
				text: 'Only 240 characters are allowed in the Text Area.Please, ensure your goals and accomlishments <i><b style="color:yellow">donot exceed the 240-characters</b></i> limit.',
				// (string | optional) the image to display on the left
				
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: false,
				// (int | optional) the time you want it to be alive for before fading out
				time: '5000'
			});

			return false;

		});
		</script>  		
<script type="text/javascript" >
var portalopened="<?php echo $reviewstarted; ?>";
var deadlineexpired="<?php echo $deadlineexpired; ?>";
//alert(portalopened);
if(portalopened==1)
{}
else{
$("#myModal2").modal('show');
}



</script>
  		
<script>
//custom select box
$(function(){
  $('select.styled').customSelect();
});
</script>


<script type="text/javascript">
$('.slider').slider();
$(".disable").prop('disabled',true); 
$(".noslider").slider('disable');
var postponed="<?php echo $postponed; ?>";
if(postponed==1)
	$("#next").prop('disabled',true);
function date()
{
var date = document.getElementById("date").value;
//if(date!=null)
//{
//alert(e_id);
	
	$.ajax({ 
				url:'Date.php', 
				type:'POST', 
				data:{"id":date,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Accessed Successfully!!");
					//window.location.href="employeedetails.php";
				var json = JSON.parse(data);
			
if(json!=null)
{	
       
		document.getElementById("date1").value = json["startdate"];
	  document.getElementById("date2").value = json["LWD"];
	  document.getElementById("empsign").value = json["EMPSIGN"];
	  document.getElementById("repmanager").value = json["REPMANAGER"];
	  //alert("he");
	  
}
else
{
document.getElementById("date1").value = "";
document.getElementById("date2").value = "";
  document.getElementById("empsign").value = "";
 document.getElementById("repmanager").value = "";	
	
	}				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
	
	
	
	
	
	}
	//}
</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var val;
var v={1:"E-",2:"E",3:"E+",4:"X"};

function sav()
{
	var dsv = $( "#dsv" ).slider( "option", "value" ); //to get slider value
	var qsv = $( "#qsv" ).slider( "option", "value" ); //to get slider value
	var csv = $( "#csv" ).slider( "option", "value" ); //to get slider value
	var ocsv = $( "#ocsv" ).slider( "option", "value" ); //to get slider value
	var vasv = $( "#vasv" ).slider( "option", "value" ); //to get slider value
	columnvalue[columnvalue.length]="<?php echo $psiid;?>";
	columnvalue[columnvalue.length]=v[dsv];
	columnvalue[columnvalue.length]=v[qsv];
	columnvalue[columnvalue.length]=v[csv];
	columnvalue[columnvalue.length]=v[ocsv];
	columnvalue[columnvalue.length]=v[vasv];
	$("#deliverables tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#quality tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#competency tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#orgcontribution tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#valueaddition tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	for (i=0;i<columnvalue.length;i++)
	{
		postdata[i]=columnvalue[i];
	}
	unique=JSON.stringify(postdata);
//alert(unique);
	$.ajax({ 
		url:'sa1insert.php', 
		type:'POST', 
		data:{json:unique}, 
		success:function(data){ 
			$("#myModal1").modal('show'); 
//alert("Saved Successfully!");
//alert(data); 
		}, 
		error:function(xhr,desc,err){ 
			alert(err); 
		} 
	});
	columnvalue=[];
}
</script>

<script type="text/javascript" >


function next()
{
	//alert("hii");
	 //var krish=document.getElementById("HRteam").value;	
    //alert(krish);
var checkedStatus=document.getElementById("iagree").checked;
//alert(e_id);	

	if(checkedStatus==true){
  /*
  var d = new Date();
 //alert("d");
var n = d.getTime();
 document.getElementById("HRteam").value = d;	
 document.getElementById("HRteam").disabled = true;  */
 
window.location.href="formfeedback.php";
 }
	
else
	
{
	
alert("Please select I Agree");		
		}
	
//alert("timstamp");
	
var datecapture=document.getElementById("HRteam").value;
var eid=<?php echo $_SESSION["psiid"] ?>;
//alert(eid);
if(document.getElementById("HRteam").value=="")
  	{
  		alert("Please enter all the fields.")
  		}

else
{

$.ajax({ 
url:'datecapture.php', 
type:'POST', 
data:{"eid":eid,"datecapture":datecapture,"sub":"true"}, 
success:function(data){ 
//$("#myModal2").modal('show');
alert("Saved Successfully!"); 

//document.getElementById("submit").disabled = true;

//window.location.href="dashoboard.php";

//$('<button type="button" class="btn btn-theme03 pull-left disabled" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button>');
//alert(data);
 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});	
		
}
}
        




</script>



<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var v={1:"E-",2:"E",3:"E+",4:"X"};
function sub()
{
var r=confirm("No changes can be made after 'submit'. Are you sure?");
if (r==true) {
	var dsv = $( "#dsv" ).slider( "option", "value" ); //to get slider value
	var qsv = $( "#qsv" ).slider( "option", "value" ); //to get slider value
	var csv = $( "#csv" ).slider( "option", "value" ); //to get slider value
	var ocsv = $( "#ocsv" ).slider( "option", "value" ); //to get slider value
	var vasv = $( "#vasv" ).slider( "option", "value" ); //to get slider value
	columnvalue[columnvalue.length]="<?php echo $psiid;?>";
	columnvalue[columnvalue.length]=v[dsv];
	columnvalue[columnvalue.length]=v[qsv];
	columnvalue[columnvalue.length]=v[csv];
	columnvalue[columnvalue.length]=v[ocsv];
	columnvalue[columnvalue.length]=v[vasv]; 
	$("#deliverables tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#quality tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#competency tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#orgcontribution tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#valueaddition tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	for (i=0;i<columnvalue.length;i++)
	{
		postdata[i]=columnvalue[i];
	}
	unique=JSON.stringify(postdata);
//alert(unique);
	$.ajax({ 
		url:'sa1insert.php', 
		type:'POST', 
		data:{json:unique}, 
		success:function(data){ 
//alert(data); 
		}, 
		error:function(xhr,desc,err){ 
			alert("fail"); 
		} 
	});
	var id="<?php echo $psiid;?>";
	$.ajax(
	{
		url:'submitsaform1.php',
		type:'POST',
		data:{"id":id,"sub":"true"}, 
		success:function(data){ 
//alert(data); 
		},
		failure:function(xhr,desc,err){
			alert("fail");	
		}
	});
	}
columnvalue=[];
}


function check_date()
{

	//alert("hi");
var checkedStatus1=document.getElementById("iagree").checked;

if(checkedStatus1==true){
 var d = new Date();
 //alert("d");
var n = d.getTime();
 document.getElementById("HRteam").value = d;	
 var krishna= document.getElementById("HRteam").value;
  document.getElementById("HRteam").disabled = true;
//alert(krishna);



	
	}
	}

</script>
<script type="text/javascript" >
var inc1=11;
var inc2=21;
var inc3=31;
var inc4=41;
var inc5=51;

function Addrow1()
{
	$('table#deliverables > tbody').append('<tr class="rows" id="d'+inc1+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc1++;
}
function Addrow2()
{
	$('table#quality > tbody').append('<tr class="rows" id="q'+inc2+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc2++;
}
function Addrow3()
{
	$('table#competency > tbody').append('<tr class="rows" id="c'+inc3+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc3++;
}
function Addrow4()
{
	$('table#orgcontribution > tbody').append('<tr class="rows" id="oc'+inc4+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc4++;
}
function Addrow5()
{
	$('table#valueaddition > tbody').append('<tr class="rows" id="va'+inc5+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc5++;
}
</script>

<script type="text/javascript" >

/*function save_date()
{
	
	alert("timstamp");
	
var datecapture=document.getElementById("HRteam").value;
var eid=<?php echo $_SESSION["psiid"] ?>;
alert(eid);




$.ajax({ 
url:'datecapture.php', 
type:'POST', 
data:{"eid":eid,"datecapture":datecapture,"sub":"true"}, 
success:function(data){ 
//$("#myModal2").modal('show');
alert("Saved Successfully!"); 

//document.getElementById("submit").disabled = true;

//window.location.href="dashoboard.php";

//$('<button type="button" class="btn btn-theme03 pull-left disabled" data-toggle="modal" data-target="#conf"><i class="fa fa-check-square "></i>&nbspSubmit</button>');
//alert(data);
 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});	

}*/

</script>
<script>
function changeEf2()

{
  //alert("hi");
  	
}
</script>

  </body>
</html>
