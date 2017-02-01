
<?php
session_start();include session_timeout.php;
require('auth.php');

//require_once('PHPMailer-master/PHPMailerAutoload.php');
//$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
//$mail->IsSMTP(); // telling the class to use SendMail transport
//$mail->Debugoutput = 'html';		//Optional
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'stylesheets.php'; ?>
<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

<style>
.btn
{
margin:5px;
}
.uc
{
text-transform:uppercase;
}

</style>
</head>

<body onload="myfun()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$db1=$m->AppraisalManagement1;
$desg=$db1->designationCategories;
$coll=$db->currentReviewCycle;
$dc=$db->gradesandweights;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$status=$_GET["status"];

?>


<section id="container" >
<?php include 'headerandsidebar.php'; ?>    	       	  

	<!-- **********************************************************************************************************************************************************
	MAIN CONTENT
	*********************************************************************************************************************************************************** -->

<!--main content start-->
<section id="main-content">
<section class="wrapper">
<h3>Timeline Settings</h3>
<div class="row mt">
	<div class="col-lg-12">
     <div class="content-panel">                  	  
    		<div class="bs-example">
    			<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#dg">Designation and Grades</a></li>
					<li><a data-toggle="tab" href="#gw">Grades and weights</a></li>
										<li><a data-toggle="tab" href="#gd">Goal Definition</a></li>
	 			</ul> <br><br>
    
    		<div class="tab-content">
		
				<div id="dg" class="tab-pane fade in active">				
					
					<label class="col-lg-3">Select a Business Division</label>
					<select class="static-form-control" id="cate1" onchange="cate_change1(this.value)"><option selected disabled>Select a Business Division</option> 
<?php 
$alldc=$desg->find();
foreach($alldc as $cate)
 echo '<option>'.$cate['category'].'</option>';
?> 
 					</select>  
 					  &nbsp&nbsp&nbsp&nbsp
 					<button class="btn btn-xs btn-info" onclick="showbox()" style="background-color:DarkKhaki ;border-color:DarkKhaki;">
 							<i class="fa fa-edit"></i> &nbsp&nbsp 
 								Add a new BU
 					</button>
 					  &nbsp&nbsp&nbsp&nbsp
 					<input type="text" id="newcate" size="45" style="display:none;" onkeypress="return onlyAlphabets(event,this);">
 					<span class="pull-right ht" style="margin-right:60px;display:none;">Type and press 'ENTER' to add a new category...</span>
					<br>	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp			
					<button class="btn btn-xs btn-info" onclick="deletecate()" style="width:284px;margin-left:160px;background-color:wheat;border-color:wheat;color:grey">					
					Click here to Delete the selected BU
					&nbsp&nbsp<i class="fa fa-trash-o"></i>					
					</button>				
					
					<br><br>
					
				 <table class="table" id="grades">
		           <thead>
							<tr>
                        <th>Designation</th>
                        <th>Grade</th>
							</tr>		           
		           </thead>
		           <tbody>
		           </tbody>
		          </table>

						<br>
		           
		<div class="row mt" id="">
       	<div class="col-lg-12" style="padding-bottom:10px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left" id="save_desg" onclick="savegrades()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Save
                </button>
               </div> 
               <div class="col-lg-6">
                <button class="btn btn-theme03 pull-right" id="savebutton" onclick="adddesgn()">
                  <i class="fa fa-plus"></i>&nbsp&nbsp Add a new Designation
                </button>
               </div>                
          </div>
         </div> <br><br>
         					
				</div>
   			<div id="gd" class="tab-pane fade">				
				
					
		             <div class="form-horizontal">
		             <div class="form-group">
		             <div class="col-lg-12">
							 <button class="btn btn-xs btn-info" id="addRemoveDefinition"  onclick="showbox1()" style="background-color:DarkKhaki ;border-color:DarkKhaki;">Remove Definition</button><div id="processadd" >Add a new Definition</div>
 							</div>		             
		             </div>
  <div class="form-group">
  
    <label class="col-lg-2">Select a Goal</label>
    <div class="col-lg-3">
					<select class="static-form-control" id="goal1" onchange="goal_change1(this.value)"><option value="" selected disabled>---SELECT GOAL---</option>
					<option>Deliverables</option>
					<option>Quality</option>
					<option>Initiatives/ Ownership</option>
					<option>Organizational/ Project Contribution</option>
					<option>Strategic Planning /Value Addition</option> 
 					</select>
 	</div>
 	<div class="col-lg-5">
 					<select onchange="goal_division(this.value)" id="division" disabled="true">
 					<option value="" selected disabled>-----SELECT A DIVISION -----</option>
 					<option>Design and Development</option> 
  	 				<option>Test and Automation</option>
  	 				<option>Support</option>
  	 				<option>HR and Admin</option>
<option>Learning and Developmnet</option>
  	 				<option>Inside Sales</option>				
	</select>
	</div>				 
 							
  </div>
  <div style="display:none"  class="form-group" id="definitionSelectArea">
  <label class="col-lg-2"></label>
  <div class="col-lg-9">
		<select id="def1" ><option>---SELECT---</option></select>
 				<button class="btn btn-xs btn-info" onclick="deletedef()" style="background-color:wheat;border-color:wheat;color:grey">					
					<!--Click here to Delete the selected Definition -->
					<i class="fa fa-trash-o"></i>					
					</button>		
  </div> 
  
  </div>
  <div id="goalDefinitionArea">
  <div class="form-group">
  <label class="col-lg-2">Definintion</label><input  type="text" id="newcate1" size="45" class="static-form-control" onkeypress="return onlyAlphabets(event,this);" > 		
 
  </div>
   <div class="form-group">
  <label class="col-lg-2">Description</label><textarea  type="text" id="defaultTextDefinition" size="45"  class="static-form-control" onkeypress="return onlyAlphabets(event,this);"></textarea>		
 	<!--<span class="pull-right ht" style="margin-right:60px;">Type and press 'ENTER' to Add...</span> -->
  </div>
  <div class="form-group">
	<label class="col-lg-2"></label>
	<button class="btn btn-success" name="goal" type="submit" id="submitDefinition" value="Submit">Submit</button>  
  </div>
  </div>
  

    <!--<img src="logo1.png" alt="" /><div class="form-group">
  <label class="col-lg-3">Select a Division </label>
 					<select class="static-form-control" ><option selected disabled>Select a Division</option>
 					</select> 
 						
  </div> -->
  <div class="form-group">
<!--  <label class="col-lg-3">Select a Definition </label> -->
  				
 					<!--<select class="static-form-control" ><option selected disabled>Select a definition</option>
 					</select> --> 
 					
  </div>
  
  <div class="form-group">
  <label class="col-lg-3"></label>
 
  </div>
  
</div>


					
				</div>

     			<div id="gw" class="tab-pane fade">
				<label class="col-lg-2">Select a Business Division</label>
					<select id="cate2" onchange="cate_change2(this.value)"><option selected disabled>Select a Business Division</option> 
<?php 
$alldc=$desg->find();
foreach($alldc as $cate)
 echo '<option>'.$cate['category'].'</option>';
?> 				
					</select>
				 <br><br><br>
				 <table class="table" id="weights">
		           <thead>
							<tr>
                        <th>Grade</th>
                        <th>Deliverables-Wt</th>
                        <th>Quality-Wt</th>
                        <th>Competency-Wt</th>
                        <th>Organizational/ Project Contribution-Wt</th>
                        <th>Strategic Planning /Value Addition-Wt</th>
                        <th>Total</th>                                                                                                
							</tr>		           
		           </thead>
		           <tbody>
		           
		           </tbody>
		          </table>

						<br><br> 
		           
		<div class="row mt" id="">
       	<div class="col-lg-12" style="padding-bottom:10px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-right" onclick="savewts()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Save
                </button>
               </div> 
            </div>
         </div>	
					<br><br>
     			</div>
     		
     		</div>
 			
 			</div>
		</div><!-- /col-lg-4 -->
	</div><!-- /row -->
</div>


</section><! --/wrapper -->
<!-- /MAIN CONTENT -->
</section>

	<!--main content end-->
<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          
							<center><h4><p id="ms"></p></h4></center>               
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" id="close_modal"close data-dismiss="modal">OK</button>
                       </div>  
                </div>
            </div>
        </div>
    </div>
<div style="height:300px"></div>
		<!--footer start-->
<?php include 'footer.php'; ?>     
		<!--footer end-->
		</section>

	<!--	<script src="assets/js/bootstrap.min.js"></script>-->
		<script src="assets/js/jquery.js"></script>

		<!-- js placed at the end of the document so the pages load faster -->
		<!--		<script src="assets/js/jquery.js"></script> -->
		<script src="moment-2.8.4/moment.js"></script>     
		<script src="assets/js/bootstrap.min.js"></script>  
		<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

		<!--common script for all pages-->
		<script src="assets/js/common-scripts.js"></script>
		<script src="bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>
		<!--script for this page-->

<script type="text/javascript" >
$(function() {
	function reposition() {
		var modal = $(this),
		dialog = modal.find('.modal-dialog');
		modal.css('display', 'block');
		
		// Dividing by two centers the modal exactly, but dividing by three
		// or four works better for larger screens.
		dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
	}
	
	// Reposition when a modal is shown
	$('.modal').on('show.bs.modal', reposition);
	
	// Reposition when the window is resized
	$(window).on('resize', function() {
		$('.modal:visible').each(reposition);
	});

});
</script>

<script type="text/javascript" >

$(function(){$('#addRemoveDefinition').click(function() {
	//alert($(this).text())
       $(this).text() == "Add Definition" ? add() : del();
    });
});
function add() {
    $('#addRemoveDefinition').text("Remove Definition");
         $('#processadd').text("Add a new Definition");
 
    // do play
}

function del() {
    $('#addRemoveDefinition').text("Add Definition");
   $('#processadd').text("Remove an added Definition");
    // do pause
}
</script>

<script type="text/javascript" >
 $(document).ready(function(){
    $("#close_modal").click(function(){
        window.location.reload();
    });
}); 
</script>
<script>
//custom select box
function myfun()
{
 document.getElementById("save_desg").disabled = true;
 document.getElementById("savebutton").disabled = true;	
 var a1 = window.location.href.slice(window.location.href.indexOf('=') + 1).split('&');
 var val=unescape(a1)
 if(val=='newgoal')
 {
  var tab='gd';
  $('.nav-tabs a[href="#' + tab + '"]').tab('show');
  }	
}
$(function()
{
	$('select.styled').customSelect();
});

//to ensure that total weight doesnot exceed 100
function selectgrades(th)
{
	var msg="The Cumulative weight should add upto exactly 100.";	
	var r=$(th).parent().parent();
	var total=+$('td:eq(1)',r).children().val() +
				 +$('td:eq(2)',r).children().val() +
				 +$('td:eq(3)',r).children().val() +
				 +$('td:eq(4)',r).children().val() +
				 +$('td:eq(5)',r).children().val();
	if(total>100)
		{
		document.getElementById("ms").innerHTML=msg;
		$("#message").modal('show'); 
		$('td:eq(6)',r).html('exceeds 100 !');	 
		}		
	else
		$('td:eq(6)',r).html(total);	 
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
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode==32 ||charCode==8 ||charCode==47)
                {
                	if(len==49)
                	{
                		if(charCode==8)
                		{
                			return true;	
                		}
                		else
                		{
                		alert('Only 50 characters allowed');
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

function isNumberKey(evt)
{
  	var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
}

function isNumberAlpha(evt)
{
  	var charCode = (evt.which) ? evt.which : event.keyCode
		if((charCode >= 33 && charCode <= 47)||(charCode >= 58 && charCode <= 64)||(charCode >= 91 && charCode <= 96)||charCode >= 123)     
		return false;     
      if ((charCode >= 48 || charCode <= 57)||(charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode==32 ||charCode==8)
    return true;
		else
    return false;
}
      
function cate_change1(str) 
{
 document.getElementById("save_desg").disabled = false;
 document.getElementById("savebutton").disabled = false;
 if (str.length == 0) {
  document.getElementById("cate1").innerHTML = "select a category";
  return;
 } else {
 	//alert(str);
 var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("grades").innerHTML = xmlhttp.responseText;
   $('.uc').attr("size","5");
	$('.uc').attr("maxlength","3");
   $('.disa').prop('disabled',true);
	$('.d').css({
		"background-color":"RosyBrown ",
		"border-color":"RosyBrown " 	
	});
  }
 }
 xmlhttp.open("POST", "change_category.php?category=" + str, true);
 xmlhttp.send();
 }
}
   
function cate_change2(str) 
{
 if (str.length == 0) {
  document.getElementById("cate2").innerHTML = "select a BU";
  return;
 } else {
 	//alert(str);
 var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.status == 200) {         
   document.getElementById("weights").innerHTML = xmlhttp.responseText;
   $('.w').attr("size","5");
	$('.w').attr("maxlength","3");
	$('.disa').prop('disabled',true);
  }
 }
 xmlhttp.open("POST", "change_category2.php?category=" + str, true);
 xmlhttp.send();
 }
}      
 function goal_change1(str){
 		if(str=="Quality" || str =="Deliverables")
 		{
 			
 			$("#division").show();
 			$("#division").prop('disabled', false);
 			//alert($("#division").val())

 		}
 		else{
 			$("#division").val('');
 			
 			$("#division").hide();
 			$("#division").prop('disabled', true);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
                document.getElementById('def1').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET", "change_def.php?goal=" + str, true);
        xmlhttp.send();		
   	}

   }
    function goal_division(str){
 		var division=str;
 		var goal=$("#goal1").val();
 		//alert(goal+" "+division);
       var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
        // alert(xmlhttp.responseText);
                document.getElementById('def1').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET", "change_def.php?goal="+goal+"&division="+division, true);
        xmlhttp.send(); 		
        
   	//$("#division").val("---CLICK HERE TO ADD A NEW GOAL---").html("asdadadsas");
   }

   function store_newdef(goal,def,defaultText,div){
   //	alert(goal+" "+def+" "+defaultText+" "+div+"--dsd--");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {
         var success="Saved Successfully";
        // alert(success);    
			window.location.href="gradesandweights.php?status=newgoal";
         }
        }
        xmlhttp.open("GET", "insertnewgoal.php?goal=" + goal+"&def=" +def+"&defaultText="+defaultText+"&div="+div, true);
        xmlhttp.send();		
   }
   function deletedefinition(goal,def){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {
         var success="Deleted Successfully";
         alert(success);    
			window.location.href="gradesandweights.php?status=newgoal";
         }
        }
        xmlhttp.open("GET", "del_def.php?goal=" + goal+"&def=" +def, true);
        xmlhttp.send();		
   }		
function adddesgn()
{
	$('table#grades > tbody').append('<tr class="rows"><td><input size="50" onkeypress="return onlyAlphabets(event,this)" ></td><td><input class="uc" onkeypress="return isNumberAlpha(event)"></td><td><button class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
	$('.uc').attr("size","5");
	$('.uc').attr("maxlength","3");
	$('.d').css({
		"background-color":"RosyBrown ",
		"border-color":"RosyBrown " 	
	});
}

function savegrades()
{
	var msg="One or more of the grades has been left empty.Please, fill all the fields.";
	var c=0;	
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]=$('#cate1').val();
	//alert(columnvalue);
	$("#grades tr.rows").each(function(){
		if($('td:eq(0)',this).children().length == 0)		
			columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
		else 
		 	columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		
		if($('td:eq(1)',this).children().val()=='')
			c=1;
		else
		 columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
		});
		if(c==1)
		{
			document.getElementById("ms").innerHTML=msg;
			$("#message").modal('show'); 
			return false;
		}	 
		else 
		{	
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'insertgrades.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					msg="Designation Added Successfylly!"
					document.getElementById("ms").innerHTML=msg;
					//window.location.reload();
					$("#message").modal('show');
					
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});		
			columnvalue=[];
		}	
}

function savewts()
{
	var columnvalue=[];
	var postdata={};
	var f=0;
	columnvalue[columnvalue.length]=$('#cate2').val();
		$("#weights tr.w").each(function(){
			if($('td:eq(6)',this).html() == 100)		
			{
				columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(5)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(6)',this).html();	
			}	
			else 
			 {
			 	alert("the total weight for each grades should equal 100. Please, allot the weights accordingly");
				f=1;
			 }															
		});
		if(f==1)
			return false;
		else
		{
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'insertweights.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					
					msg="Grades and Weights Added Successfylly!"
					document.getElementById("ms").innerHTML=msg; 
					$("#message").modal('show');
				//	alert("Saved Successfully!");
				//	alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});		
			columnvalue=[];	
	}
}

function deletedesgn(th)
{
	var msg=" 'Save' this change before leaving the page,to make it parmanent";	
	var desgn;	
	var p=$(th).parent().parent();
	p.remove();
	document.getElementById("ms").innerHTML=msg;
	$("#message").modal('show');
}

function showbox()
{
	
	$('#newcate').show();
	//$('#newcate').select();
	$('.ht').show();
}
function showbox1()
{
	$('#newcate1').show();
	//$('#newcate1').select();
	$('#goalDefinitionArea').toggle();
	$('#definitionSelectArea').toggle();
	$('.ht').show();
	//$('#defaultTextDefinition').show();
}
/*
$('#newcate').keypress(function(event){
 	
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13')
	{
		var nCategory=$('#newcate').val();	
		$.ajax({ 
				url:'insertnewcate.php', 
				type:'POST', 
				data:{'cate':nCategory}, 
				success:function(data){
					alert(data); 
					//document.getElementById("ms").innerHTML=msg;
					//$("#message").modal('show');	
					window.location.reload(); 
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
		});		
	}
}); */
/*$('#defaultTextDefinition').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	
	if(keycode == '13')
	{
		
   }
   
   }); */

$("#submitDefinition").click(function(event){
	
//alert(document.getElementById('goal1').value);
		if(document.getElementById('goal1').value=="")
 		{
 		alert('Select a goal')	
 		}
 		else if(document.getElementById('goal1').value=="Quality"  &&  document.getElementById('division').value=="" || document.getElementById('goal1').value=="Deliverables" && document.getElementById('division').value=="" )
 		{
 			alert('select Division for Deliverables and Quality');
 		}
 		else if(document.getElementById('newcate1').value=="")
 		{
 			alert("Definition Field is empty");
 		}
 		else
 		{
 		//	alert("asdadssa");
 		var div=document.getElementById('division').value;
 	//	alert(div);
		var goal=document.getElementById('goal1').value;
		var def=document.getElementById('newcate1').value;
		var defaultText=document.getElementById('defaultTextDefinition').value;
		//alert(defaultText);
		//alert(goal+" "+def+" "+defaultText+" "+div);
		store_newdef(goal,def,defaultText,div);
		}	
	
	});

function deletecate()
{
	var msg="Select a category to remove!";
	var r;
	var selectedcate=$('#cate1').val();
	if(selectedcate==null)
	{
		document.getElementById("ms").innerHTML=msg;
		$("#message").modal('show');
		return false;
	}
	else 
	{
		r=confirm("Are you sure you want to remove the category : "+selectedcate);
		if(r)
		{
			$.ajax({ 
				url:'removecate.php', 
				type:'POST', 
				data:{'cate':selectedcate}, 
				success:function(data){ 
					document.getElementById("ms").innerHTML="Removed sucessfully";
					$("#message").modal('show');
					window.location.href="gradesandweights.php";
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});				
		}
	}
}
function deletedef()
{
	var msg="Select a definition to remove!";
	var r;
	var selectedcate=$('#def1').val();
	//alert(selectedcate);
	if(selectedcate==null)
	{
		document.getElementById("ms").innerHTML=msg;
		$("#message").modal('show');
		return false;
	}
	else 
	{
		r=confirm("Are you sure you want to remove the category : "+selectedcate);
		if(r)
		{
			var goal=document.getElementById('goal1').value;
			var def=document.getElementById('def1').value;
		
			deletedefinition(goal,def);				
		}
	}
}

</script>




</body>
</html>
