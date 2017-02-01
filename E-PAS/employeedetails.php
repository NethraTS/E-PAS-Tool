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
		

  </head>


  <body onload="calll()">
<?php
$m=new MongoClient();
$db=$m->goals1;
$employee=$db->currentGoalCycle;



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
          	<h3>Employee Details</h3>
                	


          	<div class="row mt">
          		<div class="col-lg-12">
     	<table  class="table table-striped table-hover table-condensed" id="tablehr" align="center"  style="border-collapse:collapse;" cellspacing="0" >

					  <thead>
							  <tr>
						
							     <th>PSI-ID</th>
								  <th>Name</th>
								  <th>Designation</th> 
								  <th>R1 name</th>
								  <th>R1 psi id</th>
								  <th>R2 name</th>
								  <th>R2 psi id</th>	  
								  
								  </tr>
						  </thead>   
						  <tbody>

<?php
$empdoc=$employee->find();


foreach($empdoc as $el)
{
echo '<tr >';
echo '<td>';
echo $el["id"];
echo '</td>';
//echo '<td onclick="view(this)"><a href=#" style="color:#797979">'.$el["name"].'</a></td>';
echo '<td>'.$el["name"].'</td>';
echo '<td>'.$el["desgn"].'</td>';
echo '<td>'.$el["r1name"].'</td>';
echo '<td>'.$el["r1id"].'</td>';
echo '<td>'.$el["r2name"].'</td>';
echo '<td>'.$el["r2id"].'</td>';
echo '</tr>';
} 

?>
					  </tbody>
					  </table>  



          		</div>
          	</div>
			 <!--<div class="col-lg-6">
<button type="button" class="btn btn-theme03 pull-right" onclick="window.location.href='downloadhr.php'"><i class="fa fa-download"></i>&nbspExport</button>
</div> -->
<div class="col-lg-6">
<form  action="insertemployee.php" method="post" enctype="multipart/form-data">
<div class="form-group">
<label style="color:red">Upload .xls file </label> 
<input type="file" name="libfile" accept=".xls" />
</div> 
<button class="btn btn-theme03 btn-sm" type="submit" name="lib" value="lib"><i class="fa fa-spinner"></i>
&nbspUpload</button>
</form> 
<label style="color:red">Enter the employee PSI ID to revert Goal Cycle</label> 
<input type="text" id="psiid1">
<button class="btn btn-theme03 btn-sm" onclick="sub()">&nbspSubmit</button>


</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
       <!-- <div ><label>Employee Name </label><input name="ename" id="ename" /></div> -->
         <form action="saver1r2.php" method="GET">
  <div class="form-group"> <input type="hidden" name="id22" id="id22">
    <label for="desg">Designation:</label>
    <!--<input type="text" class="form-control" id="desg"> -->
     <select id="desgn" name="desgn" class="selectpicker form-control" data-live-search="true" title="Select Designation">
      <?php  $designationlist=$employee->distinct("desgn");
		foreach($designationlist as $key => $v)
		{
   	?>
      <option value="<?php echo $v ?>" ><?php echo $v?></option>
      <?php
      }
    	?>
        
      </select>
  </div>
 <div class="form-group" >
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
</div>
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
      //custom select box
function emp_name(e_id)
{
	$("#name1").attr("readonly", true);
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
{var eid=$('#psiid1').val();
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
