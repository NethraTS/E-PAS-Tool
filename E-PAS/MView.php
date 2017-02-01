<?php 
ob_start();
session_start();include session_timeout.php;
include 'secure.php';
require('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>
  
  <!--datatable-->
    	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css" type="text/css"/>
<link rel="stylesheet" href="assets/css/bootstrap-select.css">

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-multiselect.js"></script>
<!--<script type="text/javascript" src="assets/js/custom-fields.js"></script>-->
 		<script src="assets/js/bootstrap-select.js"></script>
 		<!-- Include the plugin's CSS and JS: -->
<style type="text/css">
tr td:hover{
   cursor: pointer;
   
}
</style>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
		<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
    	    	 $('#tablehr').dataTable();
//				 $('#example-getting-started').multiselect(); 	  
    	  });
</script>
		
<script type="text/javascript" >

function calll()
{
	


	
}

</script>
<script src="datetime/jquery.datetimepicker.js"></script>
<script type="text/javascript" >

var todayDate="<?php echo date('Y/m/d'); ?>";
var todayTime="<?php echo date('H:i'); ?>";
var dateTime="<?php echo date('Y/m/d H:i') ?>";

  $('.datetimepickers').datetimepicker({
	mask:'9999/19/39 29:59',
	minDate:todayDate,
	minTime:todayTime,
	onSelectDate:function(ct,$i){
		this.setOptions({minTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()<dateTime)
		{
			$input.val("");
		}
	}
});

$('#dater1cmt').datetimepicker({
	//mask:'9999/19/39 29:59',
	maxDate:+todayDate,
	 timepicker:false,
	format:'Y/m/d',
	mask:true
	/*maxTime:todayTime,
	onSelectDate:function(ct,$i){
		this.setOptions({maxTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()>dateTime)
		{
			$input.val("");
		}
	} */
});
</script>
  </head>


  <body onload="calll()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$employee=$db->BasicDetails;
/*$employee1=$db->RelievingDetails;*/

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];




?>
  <section id="container" >
 <?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3>Employee Exit Formality</h3>
                	


          	<div class="row mt">
          		<div class="col-lg-12">
        			
          		
     	<table  class="table table-striped table-hover table-condensed" id="tablehr" align="center"  style="border-collapse:collapse;" cellspacing="0" >

					  <thead>
							  <tr>
						
							     <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  
								  <th>Action</th>
								   <th>View</th>
							     
							     
								
							
								 
								  </tr>
						  </thead>   
						  <tbody>

<?php
$empdoc=$employee->find();
/*$empdoc1=$employee1->find();*/


foreach($empdoc as $el)
{
	if($el["EF"]>=1&&strcmp($name,$el["r1name"])==0)
	{
     if($el["MF"]==0)
     {
		echo '<tr >';
      echo '<td>';
//echo strcmp($name,$el["r1name"]);

      echo $el["id"];

      echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
      echo '<td>'.$el["name"].'</td>';
      echo '<td>'.$el["desgn"].'</td>';

/*echo '<td> completed </td>';*/
      echo '<td><button type="button" class="btn btn-info btn-xs"  onclick="givefeedback(this)" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Give Feedback
				</button>	</td>';
			
	   echo '<td><button type="button" disabled="disabled" class="btn btn-info btn-xs" onclick="viewfeedback()" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp View Feedback
				</button>	</td>';		
 
     echo '</tr>';
     }
     if($el["MF"]==1)
     {
     	echo '<tr >';
      echo '<td>';
//echo strcmp($name,$el["r1name"]);

      echo $el["id"];

      echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
      echo '<td>'.$el["name"].'</td>';
      echo '<td>'.$el["desgn"].'</td>';

/*echo '<td> completed </td>';*/
      echo '<td><button type="button" class="btn btn-info btn-xs" disabled="disabled" onclick="givefeedback(this)" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Give Feedback
				</button>	</td>';
				
        
      echo '<td><type="button" enabled class="btn btn-info btn-xs"  onclick="viewfeedback(this)" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp View Feedback
				</button></td>';
 
     echo '</tr>';
     	
     	
     	
     	}     
     
  }
  }  

?>
					  </tbody>
					  </table>  

<div class="modal fade" id="ManagerfeedbackModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
     <div class="modal-header" style="padding:5px 5px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3><span class="glyphicon glyphicon-pencil"></span> My Feedback</h3>
        </div>
        <div class="modal-body" >
        <form role="form">
            <div class="form-group">
              <label for="psiid"> What promoted you to seek alternative employment?</label>
              
              <input type="text" class="form-control" id="id1"  onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off"  >
            </div>
        <div class="form-group">
              <label for="psiid"> What do you value/dislike about the Job?</label>
              <input type="text" class="form-control" id="id2"  onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off" >
            </div>
       <div class="form-group">
              <label for="doj"> What are your views about Management and leadership, in general, in the job?</label>
			   <input type="text" class="form-control" id="id3" > 
			   
        </div>
        
        
        
         <div class="form-group">
              <label for="doj"> What does your new job offer that your job with this company does not?</label>
			   <input type="email" class="form-control" id="id4" > 
			   
        </div>
        
        <div class="form-group">
              <label for="rep_mng"> Can you offer any other comments that will enable us to understand why you are leaving,<br>
											  how we can improve?</label>
              <input type="text" class="form-control" id="id5" >
            </div>
      
			<div class="form-group">
              <label for="doj"> what we can do to become a better company?</label>
              <input type="text" class="form-control" id="id6" >
            </div>
      
         
           
            
            <!--button type="button" onclick="changeEf()" id="bala" class="btn btn-primary" style="align='center';"><span class="glyphicon glyphicon-on"></span> Submit</button> -->
 
        
        </form>
        </div>
            </div>
       
        </div>
      
    </div>

          		</div>
          	</div>

          		</div>
          	</div>
			 <!--<div class="col-lg-6">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadhr.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div> -->


<!-- Modal -->

  
 <!--div class="form-group" >
      <label class="control-label" for="r1psi">R1 PSI ID : </label>
      <br>
  		<input type="text" class="form-control" name="emp_id" onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off" onkeyup="emp_name(this.value)">
   
    	<label class="control-label" for="r1psi">R1 NAME : </label><br>
      <input type="text" class="form-control" name="name1" id="name1" style="height:30px;"><br>
    	<input type="hidden" class="form-control" name="email" id="email" size="20" style="height:30px;"/>
        
       </div>
     
    <div class="form-group" >
      <label class="control-label" for="r1psi">R2 PSI ID :</label>
  		 <br>
  		<input type="text" class="form-control" name="emp_id22" onkeypress="return numbersonly(event)" id="emp_id22" style="height:30px;" autocomplete="off" onkeyup="emp_name1(this.value)">	
   
      <br>
    	<label class="control-label" for="r1psi">R2 NAME : </label><br>
      <input type="text" class="form-control" name="name22" id="name22" style="height:30px;"><br>
    	<input type="hidden" class="form-control" name="email22" id="email22" size="20" style="height:30px;"/><br>
    </div>
 
      
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>-->
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->

      <!--footer start-->
    <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--    <script src="assets/js/jquery.js"></script>--> 
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

  
  <script>
  
  	
   function changeEf() 
   {
   //	alert("hi");
   	/*var psiid=document.getElementById("psiid").value;*/
	var role=document.getElementById("role").value;
var doj=document.getElementById("doj").value;
var StartDate=document.getElementById("StartDate").value;
var lwd=document.getElementById("lwd").value;
   	var e_id=document.getElementById("psiid").value;
   	//alert("hi");
   	$.ajax({ 
   	       
				url:'enableEF.php', 
				type:'POST', 
				data:{"id":e_id,"role":role,"doj":doj,"StartDate":StartDate,"lwd":lwd,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
				alert("Employee notified successfully");
					//window.location.href="employeedetails.php";
							}, 
				error:function(xhr,desc,err){ 
				//	alert("Err"); 
				} 
			});	

   	}
  

      //custom select box
function emp_name2(e_id)
{
	
	$.ajax({ 
				url:'fetchEmpDetails.php', 
				type:'POST', 
				data:{"id":e_id,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Accessed Successfully!!");
					//window.location.href="employeedetails.php";
				var json = JSON.parse(data);
if(json!=null)
{	
		document.getElementById("EmployeeEmail").value = json["email"];
	  document.getElementById("ManagerName").value = json["manager"];
}
else
{
document.getElementById("EmployeeEmail").value = "";
  document.getElementById("ManagerName").value = "";	
	
	}				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
	
	
	
	
	
	}
function emp_name(e_id)
{

	$("#psiid").attr("readonly", true);
  // $("#email").attr("readonly", true);
  // $("#phone").attr("readonly", true);	
	
	if (e_id.length == 0) {
		return;
	} else {
 		var xmlhttp = new XMLHttpRequest();
 		xmlhttp.onreadystatechange = function() {
 		if (xmlhttp.status == 200) {
  			var details=xmlhttp.responseText;
 			var detail = details.split(",");  	
 			document.getElementById("name1").value = detail[0];
  			document.getElementById('email').value=detail[2];
  		
  }
 }
 xmlhttp.open("POST","n.php?q=" + e_id, true);
 xmlhttp.send();
 }
}   

function sub()
{
	var eid=$('#psiid1').val();
	if(eid!="")
	{
	var r=confirm("The goal cycle will be reverted for the employee. Do you wish to proceed?");
	if (r==true) {	
		//if(t==1)
		{
			//sav();
			
			//alert(eid)
			$.ajax({ 
				url:'revert.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Reverted Successfully!!");
					window.location.href="employeedetails.php";
					//alert(eid)
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
		}
	}
}
else
alert("Please enter valid PSI ID!!")

}

function givefeedback(t)  
{
  	//alert("hi");
   var empid=$(t).parent().prev().prev().prev().html();
   //alert(empid);
  // var empid=$(t).parent().prev().prev().prev().prev().prev().prev().html();
   
   window.location.href="MFeedback.php?eid="+empid;  	
}

function viewfeedback(t)  
{
  	//alert("hi");
  	var empid=$(t).parent().prev().prev().prev().prev().html();
  	//alert(empid);
  //	var empid=$(it).parent().parent().attr('id');
   window.location.href="ViewManagerFeedback.php?eid="+empid;  	
}
function emp_name1(e_id)
{
	$("#name22").attr("readonly", true);
  // $("#email").attr("readonly", true);
  // $("#phone").attr("readonly", true);	
	
	if (e_id.length == 0) {
		return;
	} else {
 		var xmlhttp = new XMLHttpRequest();
 		xmlhttp.onreadystatechange = function() {
 		if (xmlhttp.status == 200) {
  			var details=xmlhttp.responseText;
 			var detail = details.split(",");  	
 			document.getElementById("name22").value = detail[0];
  			document.getElementById('email22').value=detail[2];
  			
  }
 }
 xmlhttp.open("POST","n.php?q=" + e_id, true);
 xmlhttp.send();
 }
}   
      
function numbersonly(e)
{
     var unicode=e.charCode? e.charCode : e.keyCode
     if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
     if (unicode<48||unicode>57) //if not a number
        return false //disable key press
     }
}
      $(function(){
          $('select.styled').customSelect();
      });
      
$('tr').dblclick(function(){  


 //double click on tr
var psiid=$('td',this).eq(0).text(); //get the value in table cell
var name=$('td',this).eq(1).text();
var de=$('td',this).eq(2).text();
var r1psi=$('td',this).eq(4).text();
var r2psi=$('td',this).eq(6).text();
document.getElementById("id22").value =psiid;
document.getElementById("desgn").value =de;
document.getElementById("emp_id").value =r1psi;
document.getElementById("emp_id22").value =r2psi;
document.getElementById("name1").value =emp_name(r1psi);
document.getElementById("name22").value =emp_name1(r2psi);
//alert(de);
$('#myModalLabel').html("PSI ID: "+psiid); //add psiid in title modal
$('#myModalLabel').append("Name "+name); //add name on title modal
$('#myModal').modal('show');
//$('#myModalLabel').html("PSI ID: "+psiid); //add psiid in title modal
//$('#myModalLabel').append(" Name "+name); //add name on title modal

});



//ajax call when changeing psiid in modal
$('#r1psi').change(function() {
    var data = "";
    $.ajax({
        type:"GET",
        url : "ajaxemployeedetails.php",
        data : "psiid="+$(this).val(),
        async: false,
        success : function(response) {
            data = response;
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
$('#r1detailarea').html(data);
       
});
$('#r2psi').change(function() {
    var data = "";
   
    $.ajax({
        type:"GET",
        url : "ajaxemployeedetails.php",
        data : "psiid="+$(this).val(),
        async: false,
        success : function(response) {
            data = response;
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
$('#r2detailarea').html(data);
       
});

  </script>

  
<script type="text/javascript" >
function view(th)
{
var id=$(th).prev().children().first().html();
window.location.href="viewform1.php?eid="+id+"&view=hr";
}
</script>

<script type="text/javascript" >
function clos(it)
{
var id=$(it).parent().parent().children().first().children().html();
//alert(id);
$.ajax({ 
url:'finish.php', 
type:'POST', 
data:{'psiid': id,'role':'hr'},
success:function(data){ 
alert("The Employee's Review has been closed successfully.");
location.reload();
//alert(data); 
}, 
error:function(xhr,desc,err){ 
//alert("fail"); 
} 
});
}

function call()
{
	alert();
	$('#myModal').modal('show');
}

</script>
  
<script type="text/javascript">

function Pager(tableName, itemsPerPage) {
this.tableName = tableName;
this.itemsPerPage = itemsPerPage;
this.currentPage = 1;
this.pages = 0;
this.inited = false;
this.showRecords = function(from, to) {
var rows = document.getElementById(tableName).rows;

// i starts from 1 to skip table header row
for (var i = 1; i < rows.length; i++) {
if (i < from || i > to)
rows[i].style.display = 'none';
else
rows[i].style.display = '';
}
}
this.showPage = function(pageNumber) {
if (! this.inited) {
alert("not inited");
return;
}

var oldPageAnchor = document.getElementById('pg'+this.currentPage);
oldPageAnchor.className = 'pg-normal';
this.currentPage = pageNumber;
var newPageAnchor = document.getElementById('pg'+this.currentPage);
newPageAnchor.className = 'pg-selected';
var from = (pageNumber - 1) * itemsPerPage + 1;
var to = from + itemsPerPage - 1;
this.showRecords(from, to);
}

this.prev = function() {
if (this.currentPage > 1)
this.showPage(this.currentPage - 1);
}

this.next = function() {
if (this.currentPage < this.pages) {
this.showPage(this.currentPage + 1);
}
}

this.init = function() {
var rows = document.getElementById(tableName).rows;
var records = (rows.length - 1);
this.pages = Math.ceil(records / itemsPerPage);
this.inited = true;
}

this.showPageNav = function(pagerName, positionId) {
if (! this.inited) {
alert("not inited");
return;
}
var element = document.getElementById(positionId);
var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> « Prev </span> ';
for (var page = 1; page <= this.pages; page++)
pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> ';
pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next »</span>';
element.innerHTML = pagerHtml;
}
}
</script>

<script type="text/javascript">
var pager = new Pager('tablepaging', 10);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
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
<?php 
ob_start();
session_start();include session_timeout.php;
include 'secure.php';
require('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>
  
  <!--datatable-->
    	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css" type="text/css"/>
<link rel="stylesheet" href="assets/css/bootstrap-select.css">

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-multiselect.js"></script>
<!--<script type="text/javascript" src="assets/js/custom-fields.js"></script>-->
 		<script src="assets/js/bootstrap-select.js"></script>
 		<!-- Include the plugin's CSS and JS: -->
<style type="text/css">
tr td:hover{
   cursor: pointer;
   
}
</style>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
		<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
    	    	 $('#tablehr1').dataTable();
//				 $('#example-getting-started').multiselect(); 	  
    	  });
</script>
		
<script type="text/javascript" >

function calll()
{
	


	
}

</script>
<script src="datetime/jquery.datetimepicker.js"></script>
<script type="text/javascript" >

var todayDate="<?php echo date('Y/m/d'); ?>";
var todayTime="<?php echo date('H:i'); ?>";
var dateTime="<?php echo date('Y/m/d H:i') ?>";

  $('.datetimepickers').datetimepicker({
	mask:'9999/19/39 29:59',
	minDate:todayDate,
	minTime:todayTime,
	onSelectDate:function(ct,$i){
		this.setOptions({minTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()<dateTime)
		{
			$input.val("");
		}
	}
});

$('#dater1cmt').datetimepicker({
	//mask:'9999/19/39 29:59',
	maxDate:+todayDate,
	 timepicker:false,
	format:'Y/m/d',
	mask:true
	/*maxTime:todayTime,
	onSelectDate:function(ct,$i){
		this.setOptions({maxTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()>dateTime)
		{
			$input.val("");
		}
	} */
});
</script>
  </head>


  <body onload="calll()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$employee=$db->BasicDetails;
/*$employee1=$db->RelievingDetails;*/

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];




?>
  <section id="container" >
 <?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3>Employee Exit Formality</h3>
                	


          	<div class="row mt">
          		<div class="col-lg-12">
        			
          		

<div class="modal fade" id="ManagerfeedbackModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
     <div class="modal-header" style="padding:5px 5px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3><span class="glyphicon glyphicon-pencil"></span> My Feedback</h3>
        </div>
        <div class="modal-body" >
        <form role="form">
            <div class="form-group">
              <label for="psiid"> What promoted you to seek alternative employment?</label>
              
              <input type="text" class="form-control" id="id1"  onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off"  >
            </div>
        <div class="form-group">
              <label for="psiid"> What do you value/dislike about the Job?</label>
              <input type="text" class="form-control" id="id2"  onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off" >
            </div>
       <div class="form-group">
              <label for="doj"> What are your views about Management and leadership, in general, in the job?</label>
			   <input type="text" class="form-control" id="id3" > 
			   
        </div>
        
        
        
         <div class="form-group">
              <label for="doj"> What does your new job offer that your job with this company does not?</label>
			   <input type="email" class="form-control" id="id4" > 
			   
        </div>
        
        <div class="form-group">
              <label for="rep_mng"> Can you offer any other comments that will enable us to understand why you are leaving,<br>
											  how we can improve?</label>
              <input type="text" class="form-control" id="id5" >
            </div>
      
			<div class="form-group">
              <label for="doj"> what we can do to become a better company?</label>
              <input type="text" class="form-control" id="id6" >
            </div>
      
         
           
            
            <!--button type="button" onclick="changeEf()" id="bala" class="btn btn-primary" style="align='center';"><span class="glyphicon glyphicon-on"></span> Submit</button> -->
 
        
        </form>
        </div>
            </div>
       
        </div>
      
    </div>

          		</div>
          	</div>

          		</div>
          	</div>
			 <!--<div class="col-lg-6">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadhr.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div> -->


<!-- Modal -->

  
 <!--div class="form-group" >
      <label class="control-label" for="r1psi">R1 PSI ID : </label>
      <br>
  		<input type="text" class="form-control" name="emp_id" onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off" onkeyup="emp_name(this.value)">
   
    	<label class="control-label" for="r1psi">R1 NAME : </label><br>
      <input type="text" class="form-control" name="name1" id="name1" style="height:30px;"><br>
    	<input type="hidden" class="form-control" name="email" id="email" size="20" style="height:30px;"/>
        
       </div>
     
    <div class="form-group" >
      <label class="control-label" for="r1psi">R2 PSI ID :</label>
  		 <br>
  		<input type="text" class="form-control" name="emp_id22" onkeypress="return numbersonly(event)" id="emp_id22" style="height:30px;" autocomplete="off" onkeyup="emp_name1(this.value)">	
   
      <br>
    	<label class="control-label" for="r1psi">R2 NAME : </label><br>
      <input type="text" class="form-control" name="name22" id="name22" style="height:30px;"><br>
    	<input type="hidden" class="form-control" name="email22" id="email22" size="20" style="height:30px;"/><br>
    </div>
 
      
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>-->
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->

      <!--footer start-->
    <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--    <script src="assets/js/jquery.js"></script>--> 
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

  
  <script>
  
  	
   function changeEf() 
   {
   	//alert("hi");
   	/*var psiid=document.getElementById("psiid").value;*/
	var role=document.getElementById("role").value;
var doj=document.getElementById("doj").value;
var StartDate=document.getElementById("StartDate").value;
var lwd=document.getElementById("lwd").value;
   	var e_id=document.getElementById("psiid").value;
   	//alert("hi");
   	$.ajax({ 
   	       
				url:'enableEF.php', 
				type:'POST', 
				data:{"id":e_id,"role":role,"doj":doj,"StartDate":StartDate,"lwd":lwd,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
				alert("Employee notified successfully");
					//window.location.href="employeedetails.php";
							}, 
				error:function(xhr,desc,err){ 
				//	alert("Err"); 
				} 
			});	

   	}
  

      //custom select box
function emp_name2(e_id)
{
	
	$.ajax({ 
				url:'fetchEmpDetails.php', 
				type:'POST', 
				data:{"id":e_id,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Accessed Successfully!!");
					//window.location.href="employeedetails.php";
				var json = JSON.parse(data);
if(json!=null)
{	
		document.getElementById("EmployeeEmail").value = json["email"];
	  document.getElementById("ManagerName").value = json["manager"];
}
else
{
document.getElementById("EmployeeEmail").value = "";
  document.getElementById("ManagerName").value = "";	
	
	}				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
	
	
	
	
	
	}
function emp_name(e_id)
{

	$("#psiid").attr("readonly", true);
  // $("#email").attr("readonly", true);
  // $("#phone").attr("readonly", true);	
	
	if (e_id.length == 0) {
		return;
	} else {
 		var xmlhttp = new XMLHttpRequest();
 		xmlhttp.onreadystatechange = function() {
 		if (xmlhttp.status == 200) {
  			var details=xmlhttp.responseText;
 			var detail = details.split(",");  	
 			document.getElementById("name1").value = detail[0];
  			document.getElementById('email').value=detail[2];
  		
  }
 }
 xmlhttp.open("POST","n.php?q=" + e_id, true);
 xmlhttp.send();
 }
}   

function sub()
{
	var eid=$('#psiid1').val();
	if(eid!="")
	{
	var r=confirm("The goal cycle will be reverted for the employee. Do you wish to proceed?");
	if (r==true) {	
		//if(t==1)
		{
			//sav();
			
			//alert(eid)
			$.ajax({ 
				url:'revert.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Reverted Successfully!!");
					window.location.href="employeedetails.php";
					//alert(eid)
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
		}
	}
}
else
alert("Please enter valid PSI ID!!")

}

function givefeedback(t)  
{
  	//alert("hi");
   var empid=$(t).parent().prev().prev().prev().html();
   //alert(empid);
  // var empid=$(t).parent().prev().prev().prev().prev().prev().prev().html();
   
   window.location.href="MFeedback.php?eid="+empid;  	
}

function Viewfeedback()  
{
  	//alert("hi");
  //	var empid=$(it).parent().parent().attr('id');
   window.location.href="ViewManagerFeedback.php";  	
}
function emp_name1(e_id)
{
	$("#name22").attr("readonly", true);
  // $("#email").attr("readonly", true);
  // $("#phone").attr("readonly", true);	
	
	if (e_id.length == 0) {
		return;
	} else {
 		var xmlhttp = new XMLHttpRequest();
 		xmlhttp.onreadystatechange = function() {
 		if (xmlhttp.status == 200) {
  			var details=xmlhttp.responseText;
 			var detail = details.split(",");  	
 			document.getElementById("name22").value = detail[0];
  			document.getElementById('email22').value=detail[2];
  			
  }
 }
 xmlhttp.open("POST","n.php?q=" + e_id, true);
 xmlhttp.send();
 }
}   
      
function numbersonly(e)
{
     var unicode=e.charCode? e.charCode : e.keyCode
     if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
     if (unicode<48||unicode>57) //if not a number
        return false //disable key press
     }
}
      $(function(){
          $('select.styled').customSelect();
      });
      
$('tr').dblclick(function(){  


 //double click on tr
var psiid=$('td',this).eq(0).text(); //get the value in table cell
var name=$('td',this).eq(1).text();
var de=$('td',this).eq(2).text();
var r1psi=$('td',this).eq(4).text();
var r2psi=$('td',this).eq(6).text();
document.getElementById("id22").value =psiid;
document.getElementById("desgn").value =de;
document.getElementById("emp_id").value =r1psi;
document.getElementById("emp_id22").value =r2psi;
document.getElementById("name1").value =emp_name(r1psi);
document.getElementById("name22").value =emp_name1(r2psi);
//alert(de);
$('#myModalLabel').html("PSI ID: "+psiid); //add psiid in title modal
$('#myModalLabel').append("Name "+name); //add name on title modal
$('#myModal').modal('show');
//$('#myModalLabel').html("PSI ID: "+psiid); //add psiid in title modal
//$('#myModalLabel').append(" Name "+name); //add name on title modal

});



//ajax call when changeing psiid in modal
$('#r1psi').change(function() {
    var data = "";
    $.ajax({
        type:"GET",
        url : "ajaxemployeedetails.php",
        data : "psiid="+$(this).val(),
        async: false,
        success : function(response) {
            data = response;
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
$('#r1detailarea').html(data);
       
});
$('#r2psi').change(function() {
    var data = "";
   
    $.ajax({
        type:"GET",
        url : "ajaxemployeedetails.php",
        data : "psiid="+$(this).val(),
        async: false,
        success : function(response) {
            data = response;
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
$('#r2detailarea').html(data);
       
});

  </script>

  
<script type="text/javascript" >
function view(th)
{
var id=$(th).prev().children().first().html();
window.location.href="viewform1.php?eid="+id+"&view=hr";
}
</script>

<script type="text/javascript" >
function clos(it)
{
var id=$(it).parent().parent().children().first().children().html();
//alert(id);
$.ajax({ 
url:'finish.php', 
type:'POST', 
data:{'psiid': id,'role':'hr'},
success:function(data){ 
alert("The Employee's Review has been closed successfully.");
location.reload();
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert("fail"); 
} 
});
}

function call()
{
	alert();
	$('#myModal').modal('show');
}

</script>
  
<script type="text/javascript">

function Pager(tableName, itemsPerPage) {
this.tableName = tableName;
this.itemsPerPage = itemsPerPage;
this.currentPage = 1;
this.pages = 0;
this.inited = false;
this.showRecords = function(from, to) {
var rows = document.getElementById(tableName).rows;

// i starts from 1 to skip table header row
for (var i = 1; i < rows.length; i++) {
if (i < from || i > to)
rows[i].style.display = 'none';
else
rows[i].style.display = '';
}
}
this.showPage = function(pageNumber) {
if (! this.inited) {
alert("not inited");
return;
}

var oldPageAnchor = document.getElementById('pg'+this.currentPage);
oldPageAnchor.className = 'pg-normal';
this.currentPage = pageNumber;
var newPageAnchor = document.getElementById('pg'+this.currentPage);
newPageAnchor.className = 'pg-selected';
var from = (pageNumber - 1) * itemsPerPage + 1;
var to = from + itemsPerPage - 1;
this.showRecords(from, to);
}

this.prev = function() {
if (this.currentPage > 1)
this.showPage(this.currentPage - 1);
}

this.next = function() {
if (this.currentPage < this.pages) {
this.showPage(this.currentPage + 1);
}
}

this.init = function() {
var rows = document.getElementById(tableName).rows;
var records = (rows.length - 1);
this.pages = Math.ceil(records / itemsPerPage);
this.inited = true;
}

this.showPageNav = function(pagerName, positionId) {
if (! this.inited) {
alert("not inited");
return;
}
var element = document.getElementById(positionId);
var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> « Prev </span> ';
for (var page = 1; page <= this.pages; page++)
pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> ';
pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next »</span>';
element.innerHTML = pagerHtml;
}
}
</script>

<script type="text/javascript">
var pager = new Pager('tablepaging', 10);
pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
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
