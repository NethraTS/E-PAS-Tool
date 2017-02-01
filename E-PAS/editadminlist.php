<?php
session_start();include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>
      
 <style>
    .btn
    {
        margin:5px;
    }
    </style>
  </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$db=$m->appraisalmgmt;
$coll=$db->currentReviewCycle;
$n=$db->Notifications;
$bd=$db->BasicDetails;
$adl=$db->adminlist;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc=$bd->findOne(array("psiid"=>$psiid));
$adldoc=$adl->findOne(array("psiid"=>$psiid));



?>


  <section id="container" >
<?php include 'headerandsidebar.php'; ?>    	       	  
	
	<!--   **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

		  		<div class="row mt">
						<div class="col-md-12">
	                  	  <div class="content-panel">
	                  	  	  <h4>Admin list</h4>        
   								<table class="table" id="adminlist">
		                          <thead>
		                          <tr>
								  <th>EMP-ID</th>
								  <th>Name</th>
								  <th>Email-ID</th>
								  <th>Designation</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php	  
$doc=$adl->find();
$num_docs = $doc->count();
if($num_docs>0)
{
foreach($doc as $row){
	echo '<tr id="'.$row['psiid'].'">';
	echo '<td>'.$row['psiid'].'</td>';
   echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['email'].'</td>';
	echo '<td>'.$row['designation'].'</td>';
	echo '<td><button class="btn btn-info btn-xs" onclick="edit1(this);">Edit&nbsp&nbsp</button>';
	echo '<button class="btn btn-danger btn-xs" onclick="del(this);">Remove</button></td>';       
	echo '</tr>';	
	}
}										
?>
                	  	                   
                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->
		  	</div><!-- /row -->
		  				</section><! --/wrapper -->
      <!-- /MAIN CONTENT -->
		  	</section>
		  
<div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">EDIT</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="updateadminlist.php">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="hiddenid" id="hiddenid">
                            <label for="name" class="control-label">EMP-ID :</label>
                            <input type="text" class="form-control" id="Psiid" name="Psiid">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Name :</label>
                            <input type="text" class="form-control" id="Name" name="Name">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">E-Mail ID :</label>
                            <input type="text" class="form-control" id="Mailid" name="Mailid">
                        </div>
								<div class="form-group">
                            <label for="Desgn" class="control-label">Designation</label>
										<select class="form-control" name="Desgn" id="Desgn">
														<option>HR Manager</option>
														<option>HR Admin</option>
														</select>
                        </div>
                      
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" name="edit">Update</button> 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>

     <!--main content end-->
      
      <!--footer start-->
  <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->         
    <!--script for this page-->
    
  <script>
      //custom select box
      $(function(){
          $('select.styled').customSelect();
      });
  </script>

<script type="text/javascript" >
function changepod()
{
$('#d1').prop("readonly",false);	
return false;
}
function r1extend()
{
$('#d3').prop("readonly",false);	
return false;
}
function r2extend()
{
$('#d4').prop("readonly",false);	
return false;
}
function saextend()
{
window.open("extendsadeadline.php");
}
function extendall()
{
$('#d2').prop("readonly",false);	
	
}
</script>

<script type="text/javascript" > 
function edit1(el)
{
var psiid=$(el).parent().parent().attr('id');
$('tr#'+psiid).each(function(){
var id=$('td:eq(0)',this).html();
var aname=$('td:eq(1)',this).html();
var email=$('td:eq(2)',this).html();
var desgn=$('td:eq(3)',this).html();
document.getElementById("hiddenid").value=id;
document.getElementById("Psiid").value=id;
document.getElementById("Name").value=aname;
document.getElementById("Mailid").value=email;
document.getElementById("Desgn").value=desgn;
$("#myModal2").modal('show');
});
}   
</script>	
<script type="text/javascript" >
function del(elem)
{
var psiid=$(elem).parent().parent().attr('id');
var res=confirm("are you sure?");
if(res==true)
{
$.ajax({
url:'deleteadmin.php',
type:'POST',
data:{'id':psiid},
success:function(data)
{
//alert(data);
},
failure:function(xhr,desc,err)	
{
alert("failed");
}	
});
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
