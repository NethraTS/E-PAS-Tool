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
//	$('tabel').dataTable({bFilter: false, bInfo: false});


	
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


  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$employee=$db->BasicDetails;
$employee1=$db->RelievingDetails;
$emp=$db->RelievingInfo;
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
          	<h3>Relieving Process</h3>
                	


          	<div class="row mt">
          		<div class="col-lg-12">
        			<button type="button" class="btn btn-default btn-primary pull-right" data-toggle="modal" data-target="#relievingModal" onclick="bala(this)">Enable Feedback</button>   <br></br>
          		
     	<table  class="table" id="tablehr" align="center"  style="border-collapse:collapse;" cellspacing="0" >

					  <thead>
							  <tr>
						
							     <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  <th>Employee Status</th> 
								  <th>Manager Status</th> 
								  <th>Action</th>
							      <th>Send</th>
								
							
								 
								  </tr>
						  </thead>   
						  <tbody>

<?php
$empdoc=$employee->find();
$empdoc1=$employee1->find();
//$doc=$emp->find("");

//$eid = $e1["id"];

foreach($empdoc as $el)
{

	
 if($el["EF"]==1)
 {
  if($el["MF"]==0)
  {
   
   echo '<tr >';
   echo '<td>';
   echo $el["id"];
   echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
   echo '<td>'.$el["name"].'</td>';
   echo '<td>'.$el["desgn"].'</td>';
   echo '<td> Pending </td>';
   echo '<td> Pending </td>';
   echo '<td><a href=html2pdf.php?id='.$el["id"].' target="_blank"><button type="button" class="btn btn-info btn-xs"  disabled="disabled">
        <i class="fa fa-folder-open"></i>&nbsp&nbsp View PDF
    </button></a></td>';
    
  echo '<td> <a href=sendPDF.php?id='.$el["id"].' ><button type="button" class="btn btn-info btn-xs" disabled="disabled" >
        <i class="fa fa-folder-open"></i>&nbsp&nbsp Send PDF
    </button></a> </td>';
   echo '</tr>';
  }
  if($el["MF"]==1)
  {
   
   echo '<tr >';
   echo '<td>';
   echo $el["id"];
   echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
   echo '<td>'.$el["name"].'</td>';
   echo '<td>'.$el["desgn"].'</td>';
   echo '<td> Pending </td>';
   echo '<td> Completed </td>';
   echo '<td><a href=html2pdf.php?id='.$el["id"].' target="_blank"><button type="button" class="btn btn-info btn-xs"  disabled="disabled">
        <i class="fa fa-folder-open"></i>&nbsp&nbsp View PDF
    </button></a>';
    
  echo '<td> <a href=sendPDF.php?id='.$el["id"].' ><button type="button" class="btn btn-info btn-xs" disabled="disabled" >
        <i class="fa fa-folder-open"></i>&nbsp&nbsp Send PDF
    </button></a> </td>';
   echo '</tr>';
  }
 }

 else if($el["EF"]==2)
 {
  if($el["MF"]==0)
  {
   
   echo '<tr >';
   echo '<td>';
   echo $el["id"];
   echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
   echo '<td>'.$el["name"].'</td>';
   echo '<td>'.$el["desgn"].'</td>';
   echo '<td> Completed </td>';
   echo '<td> Pending </td>';
   echo '<td><a href=html2pdf.php?id='.$el["id"].' target="_blank"><button type="button" class="btn btn-info btn-xs"  >
        <i class="fa fa-folder-open"></i>&nbsp&nbsp View PDF
    </button></a>';
    
  echo '<td> <a href=sendPDF.php?id='.$el["id"].' ><button type="button" class="btn btn-info btn-xs" disabled="disabled">
        <i class="fa fa-folder-open"></i>&nbsp&nbsp Send PDF
    </button></a> </td>';
   echo '</tr>';
  }
  if($el["MF"]==1)
  {
   
   echo '<tr >';
   echo '<td>';
   echo $el["id"];
   /*echo '<button type="button" class="btn bc btn-primary btn-xs" onclick="notify(this)" >
			 		  <i class="fa fa-mail-forward"></i>&nbsp&nbsp Notify
							 		</button>';*/
   echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
   echo '<td>'.$el["name"].'</td>';
   echo '<td>'.$el["desgn"].'</td>';
   echo '<td> Completed </td>';
   echo '<td> Completed </td>';
   echo '<td><a href=html2pdf.php?id='.$el["id"].' target="_blank"><button type="button" class="btn btn-info btn-xs"  enabled="enabled">
        <i class="fa fa-folder-open"></i>&nbsp&nbsp View PDF
    </button></a>';
    
  echo '<td> <a href=sendPDF.php?id='.$el["id"].' onclick="setTimeout(al_msg, 4000);" ><button type="button" class="btn btn-info btn-xs" >
        <i class="fa fa-folder-open"></i>&nbsp&nbsp Send PDF
    </button></a> </td>';
   echo '</tr>';
  }
 }
 
}



/*foreach($empdoc1 as $el1)
{
	if($el1["EF"]==2)
	{
		echo '<tr >';
echo '<td>';
echo $el1["id"];
echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
echo '<td>'.$el1["Comment6"].'</td>';
//echo '<td>'.$el["desgn"].'</td>';

//echo '<td> completed </td>';



//i can add for the fields that i want to reterive
echo '<td> completed </td>';
echo '<td><button type="button" class="btn btn-info btn-xs" onclick="enable(t)" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Download PDF
				</button>	</td>';
echo '<td><button type="button" class="btn btn-info btn-xs" onclick="enable1(t)" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Send PDF
				</button>	</td>';
				

echo '</tr>';
		

		
		
		
		}

} */

?>
					  </tbody>
					  </table>  

<div class="modal fade" id="relievingModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
     <div class="modal-header" style="padding:5px 5px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3><span class="glyphicon glyphicon-lock"></span> Relieving Formality</h3>
        </div>
        <div class="modal-body" >
        <form role="form">
            <div class="form-group">
              <label for="psiid"><span class="glyphicon glyphicon-user"></span> PSI-ID*</label>
              <input type="text" class="form-control" id="psiid" placeholder="Enter psiid" id="emp_id" onkeypress="return numbersonly(event)" style="height:30px;" autocomplete="off" onkeyup="emp_name2(this.value)">
            </div>
         
        <div class="form-group">
              <label for="psiid"><span class="glyphicon glyphicon-user"></span> Name</label>
              <input type="text" class="form-control" id="Name" placeholder="Enter name" onkeypress="return numbersonly(event)" id="emp_id" style="height:30px;" autocomplete="off" readonly >
            </div>
       <div class="form-group">
              <label for="doj"> Role</label>
			   <input type="text" class="form-control" id="role" placeholder="Enter Role" readonly> 
			   
        </div>
        
        
        
         <div class="form-group">
              <label for="doj"> E-mail</label>
			   <input type="email" class="form-control" id="EmployeeEmail" placeholder="Enter E-mail" readonly> 
			   
        </div>
        
        <div class="form-group">
              <label for="rep_mng"> Reporting Manager</label>
              <input type="text" class="form-control" id="ManagerName" placeholder="Enter Reporting Manager" readonly>
            </div>
      
			<div class="form-group">
              <label for="doj"> Date of joining</label>
              <input type="date"  onclick="dateformat()"  class="form-control" id="doj" placeholder="Enter DOJ in yyyy-mm-dd">
            </div>
      
         <div class="form-group">
              <label for="status"> Employee Status</label> <BR>
			  <select class="selectpicker form-control" id="empStatus">  
			   
					<option value="Employee">Employee</option>
					<option value="In notice">In notice</option>
					
				</select>
				
          
            </div>
            
            <div class="form-group">
              <label for="start_date"> Resignation Date MM/DD/YYYY</label>
              <input type="date" onclick="dateformat()" class="form-control" value="<?php echo date("Y-m-d");?>" id="StartDate" placeholder="Enter start date in yy-mm-dd"> 
            </div>
             <?php
				 
				 $date1 = date('Y-m-d',time()+(86400*90));
				
				 ?>
           
           
        
			<div class="form-group">
              <label for="End_date"> Date of Relieving (LWD) MM/DD/YYYY</label>
              <input type="date"  class="form-control clsDatePicker" id="lwd" max="<?php  echo $date1; ?>" min="<?php echo date("Y-m-d");?>" value="<?php  echo $date1; ?>" placeholder="Enter LWD in yy-mm-dd">
              
            </div>
       <?php
       
       $ef=$employee->find(array("id"=>"1066"));
       foreach($ef as $v1)
       {
$efDetails=$v1["EF"];
       	//echo '$psiIdEf';
       	}
       	if($efDetails>1)
       
       {	?>
      <button type="button" onclick="changeEf()" id="bala" class="btn btn-primary" style="align='center';"><span class="glyphicon glyphicon-on"></span> Submit</button> 
            

<?php


}
else {
?>   	
            	   <button type="button" onclick="changeEf()" id="bala" class="btn btn-primary" style="align='center';" ><span class="glyphicon glyphicon-on"></span> Submit</button>
<?php
}
?>            	   
 
        
        </form>
        </div>
            </div>
       
        </div>
      
    </div>

          		</div>
          	</div>
			 <!--<div class="col-lg-6">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadhr.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div> -->



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
  //var check11;
/*function notify(th)
{
var empid1=$(th).parent().html();
var selected=$(th).prev().children().first().val();
//alert(empid1);
var dat=$('#d').val();
//alert(dat);
}*/
    
   function changeEf() 
   {
   	//alert("Please enter all the values");
   	/*var psiid=document.getElementById("psiid").value;*/
		var role=document.getElementById("role").value;
	
//var doj=document.getElementById("doj").value;
	
		var StartDate=document.getElementById("StartDate").value;

		var lwd=document.getElementById("lwd").value;

   	var e_id=document.getElementById("psiid").value;
   	var Name=document.getElementById("Name").value;
   	var EmployeeEmail=document.getElementById("EmployeeEmail").value;
   	var ManagerName=document.getElementById("ManagerName").value;
   	var empStatus=document.getElementById("empStatus").value;
   	var doj=document.getElementById("doj").value;
   	
  	if(e_id=="")
  	{
  		alert("Please fill the employee PSI ID.")
  		}
  		else if(Name=="")
  	{
  		alert("Please fill the employee name.")
  		}
  		else if(role=="")
  	{
  		alert("Please fill the employee role.")
  		}
else if(EmployeeEmail=="")
  	{
  		alert("Please fill the employee email address.")
  		}
  		else if(ManagerName=="")
  	{
  		alert("Please fill the manager name.")
  		}
  		else if(document.getElementById("doj").value=="")
  		{
alert("Please fill the joining date.")  			
  			}
  		else if(empStatus=="Employee")
  	{
  		alert("Please fill the employee status.")
  		}
	else if(StartDate=="")
  	{
  		alert("Please fill the resignation date.")
  		}
		else if(document.getElementById("doj").value>=document.getElementById("StartDate").value)
  		{
      alert("Please fill the valid joining date.")  			
  			}
else if(lwd=="")
  	{
  		alert("Please fill the Date of relieving (LWD).")
  		
  		}
  		
 
else
{
 	
   	$.ajax({ 
   	       
				url:'enableEF.php', 
				type:'POST', 
				data:{"id":e_id,"role":role,"EmployeeEmail":EmployeeEmail,"ManagerName":ManagerName,"StartDate":StartDate,"empStatus":empStatus,"doj":doj,"lwd":lwd,"Name":Name,sub:"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
				alert("Employee notified successfully");
				window.location.href="relievingProcess2.php";
				document.getElementById("psiid").value = "";
				document.getElementById("Name").value = "";
				document.getElementById("role").value = "";
				document.getElementById("psiEmployeeEmailid").value = "";
				document.getElementById("ManagerName").value = "";
				document.getElementById("doj").value = "";
				//document.getElementById("StartDate").value = "";
				//document.getElementById("lwd").value = "":
				
				
					
							}, 
				error:function(xhr,desc,err){ 
				//	alert("Err"); 
				} 
			});	  		
  		  		
  		  		}	
   	
   	}
   	
 

   	
   	
function showDays(firstDate,secondDate){
                
                  

                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  alert( Math.floor(days));

              }function dateformat()
  {
  	var doj=document.getElementById("doj").value;
  
if (preg_match("^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$",doj))
    {
        return true;
    }else{
        return false;
    }
    }
      //custom select box
function emp_name2(e_id)
{
	
	//alert("hi");
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
		document.getElementById("Name").value = json["empname"];
	  document.getElementById("ManagerName").value = json["manager"];
	   document.getElementById("role").value = json["desgn"];
}
else
{
document.getElementById("EmployeeEmail").value = "";
document.getElementById("Name").value = "";
  document.getElementById("ManagerName").value = "";	
   document.getElementById("role").value = json["desgn"];
	
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


//Function to show alert msg when sending mail..
function al_msg()
{
	
alert("Mail sent");	
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


<!-- Function to send PDF -->
	function sendpdf() 
   {
	   alert("email");
	 //  var myVariable = <?php echo $myVariableInPHP ?>
   	//var e_id = document.getElementById("psiid");
alert("email");   	
 
  	
   	 echo '$el["id"]'; 
   	//alert ($el["id"]);
 
   //	alert(e_id);
   	$.ajax({ 
   	       
				url:'sendPDF.php', 
				type:'POST', 
				data:{"id":e_id,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
				alert("PDF sent successfully");
					//window.location.href="employeedetails.php";
							}, 
				error:function(x,e) {
    if (x.status==0) {
        alert('You are offline!!\n Please Check Your Network.');
    } else if(x.status==404) {
        alert('Requested URL not found.');
    } else if(x.status==500) {
        alert('Internel Server Error.');
    } else if(e=='parsererror') {
        alert('Error.\nParsing JSON Request failed.');
    } else if(e=='timeout'){
        alert('Request Time out.');
    } else {
        alert('Unknow Error.\n'+x.responseText);
    }
				}			
				
	//			(xhr,desc,err){ 
	//				alert("Err"); 
				
			});	

   	}


</script>
  



  </body> 
</html>
