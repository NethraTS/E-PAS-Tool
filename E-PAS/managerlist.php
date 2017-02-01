<?php
session_start();include session_timeout.php;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 

<link href="bootstrap-toggle-master/css/bootstrap2-toggle.min.css" rel="stylesheet"> 

<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	 <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

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
.bc
{
background-color:burlywood;
border-color: burlywood;
	}
.rv
{
margin-right:20px;
background-color:palevioletred;
border:white;		
	}
</style>
 </head>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$g=$db->GoalsToBeReviewed;
$allgoal=$g->find();
$alldocs=$c->find();
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
$active=$_GET["active"];
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
  	   <button class="btn btn-sm btn-theme02 pull-right" onclick="window.location.href='employeegoals.php'" style="padding-right:10px;margin-right:25px;">
  	        <i class="fa fa-asterisk"></i>&nbsp&nbsp My Goals
  	   </button>
    	
    	<div class="col-lg-12"> 
       	<div class="form-panel">             	  
             <div class="bs-example">	             
				    <ul class="nav nav-tabs">
<?php
if($active=="r1")
{
	echo '<li class="active"><a data-toggle="tab" href="#r1">My Team</a></li>';
	//echo '<li><a data-toggle="tab" href="#r2">Second level</a></li>';
}
elseif($active=="r2")
{
	echo '<li><a data-toggle="tab" href="#r1">My Team</a></li>';
	echo '<li class="active"><a data-toggle="tab" href="#r2">Second level</a></li>';
}
?>
	 				 </ul>
	 				 
   	 <div class="tab-content" style="padding-top:20px;">

<?php
if($active=="r1")
	echo '<div id="r1" class="tab-pane fade in active">';
else 
	echo '<div id="r1" class="tab-pane fade">';
?>	
                         
                 <table class="table" id="rev1">
		                        <thead>                       
		                               <tr>
								 					 <th>Employee ID</th>
								 					 <th>Name</th>
								 					 <th>Designation</th>
								 					 <th>Schedule a Meeting</th>
								 					 <th>Goal Type</th>
								 					 <th>Action</th>
							 				    </tr>                      
		                        </thead>
		                        <tbody>
<?php 
$gtypes=array("Quarterly","Half-Yearly","Annual");
$count=1;
$r1docs=$c->find(array('r1id'=>$_SESSION['psiid']));
foreach($r1docs as $doc)
{
	echo '<tr id="e'.$count.'">';
	echo '<td>'.$doc["id"].'</td>';
	echo '<td>'.$doc["name"].'</td>';
	echo '<td>'.$doc["desgn"].'</td>';
   echo '<td>                 	  												
				<div class="input-group date" id="datetimepicker'.$count.'">
	  				<input size="18" class="datetimepickers" id="d'.$count.'" onblur="savedate(this)" placeholder="Click Here.." value="'.$doc["r1MeetingDate"].'"></input>
				</div>
				<button type="button" class="btn bc btn-primary btn-xs" onclick="notify(this)">
			 		  <i class="fa fa-mail-forward"></i>&nbsp&nbsp Notify
							 		</button>&nbsp&nbsp		
			</td>
			<td>';
/*	 if($doc["flag"]<="1")
	 {
	  	echo '<select class="gtype">';
	   foreach($gtypes as $k)	
	     echo '<option>'.$k.'</option>';
	   echo '</select>';
	 }*/
	 if($doc["flag"]<="1")
	 {
	 	echo '<select class="gtype">';
      echo '<option>'.$doc["gType"].'</option>';
	   foreach($gtypes as $k)	
	     {
	     	if($doc["gType"]!== $k)
	    	 echo '<option>'.$k.'</option>';
	     } 
	   echo '</select>';	 	
	 }
	 elseif($doc["flag"]>="2")
	 {
	 	echo $doc["gType"];
	 }	  
		
		echo '</td>';
		if($doc["flag"]<"2") { 
		echo '<td>																						 		
				<button type="button" class="btn btn-info btn-xs" onclick="viewGoals(this)">
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Add Goals
				</button>		                          
				<button type="button" class="btn rv btn-primary btn-xs pull-right d" onclick="reviewGoals(this)">
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button>		                          
     		</td>';
     		}
     		else if($doc['flag']>="2")
     		{
     		echo '<td>																						 				                          
				<button type="button" class="btn rv btn-primary btn-xs pull-right " onclick="reviewGoals(this)">
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button>		                          
     		</td>';
     		}
    	 echo '</tr>';
	$count++;
}
 ?>    	 
		                        </tbody>
		            </table>
	 				 	   
	 				</div>

<?php
if($active=="r2")
	echo '<div id="r2" class="tab-pane fade in active">';
else 
	echo '<div id="r2" class="tab-pane fade">';
?>	

        				<table class="table" id="rev2">
						  <thead>
							  <tr>
								  <th>Manager Name</th>
								  <th>Total Employees</th>
								  <th>Finalised Employees</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <tr>
								  <td>Rita</td>
								  <td>7</td>
								  <td><a href="#" onclick="togle1()">3</a>
								  <div id="m1" style="display:none;padding-top:20px;">
								  	 <table style="width:700px;" id="m1l">
								      <thead style="color:green;">
                               <tr> 
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Action</th>
                               </tr>                               							      
								      </thead>
								      <tbody style="color:orange;">
											<tr> 
											  <td>346</td>
											  <td>Sanjay</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp View Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 		
											  </td>
											 </tr> 										      
								      </tbody> 
								    </table>
								   </div>
								 </td>
							  </tr>
							  <tr>
								  <td>John</td>
								  <td>16</td>
								  <td><a href="#" onclick="togle1()">5</a>
								  <div id="m2" style="display:none;padding-top:20px;">
								  	 <table style="width:700px;" id="m2l">
								      <thead style="color:green;">
                               <tr> 
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Action</th>
                               </tr>                               							      
								      </thead>
								      <tbody style="color:orange;">
											<tr> 
											  <td>34</td>
											  <td>Sanjay</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="r2viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbspView Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 													 		
											  </td>
											 </tr> 
											 <tr> 
											  <td>6</td>
											  <td>sujith</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="r2viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbspView Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 													 		
											  </td>
											 </tr>
											 <tr> 
											  <td>763</td>
											  <td>Ram</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="r2viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbspView Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 													 		
											  </td>
											 </tr>										      
								      </tbody> 
								    </table>
								   </div>
								   </td>
							  </tr>
							  <tr>
								  <td>Harry</td>
								  <td>8</td>
								  <td><a href="#" onclick="togle3()">0</a>
								  <div id="m3" style="display:none;padding-top:20px;">
								  	 <table style="width:700px;" id="m3l">
								      <thead style="color:green;">
                               <tr> 
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Action</th>
                               </tr>                               							      
								      </thead>
								      <tbody style="color:orange;">
											<tr> 
											  <td>346</td>
											  <td>Sanjay</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="r2viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbspView Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 													 		
											  </td>
											 </tr> 										      
								      </tbody> 
								    </table>
								   </div>
								   </td>
							  </tr>
							  <tr>
								  <td>Meena</td>
								  <td>9</td>
								  <td><a href="#" onclick="togle4()">9</a>
								  <div id="m4" style="display:none;padding-top:20px;">
								  	 <table style="width:700px;" id="m4l">
								      <thead style="color:green;">
                               <tr> 
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Action</th>
                               </tr>                               							      
								      </thead>
								      <tbody style="color:orange;">
											<tr> 
											  <td>346</td>
											  <td>Sanjay</td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="r2viewGoals(this)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbspView Goals
											 		</button>
											     <button type="button" class="btn btn-info btn-xs" onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve Goals
											 		</button>											 													 		
											  </td>
											 </tr> 										      
								      </tbody> 
								    </table>
								   </div>
								   </td>
							  </tr>
                    </tbody>	 				
	 				  </table>
	 				
	 				</div>
	 					 				
	 		</div>        
	      
	           </div>
	      </div>
		</div>
	 </div>

		</section><! --/wrapper -->

<div id="r2comment" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Comment</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="">							              
                        <div class="form-group">
                        	<input type="hidden" id="hiddenid">                                                                         
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">Comments</label>
                            <textarea class="form-control" id="msrment" name="msrment" rows="3" placeholder="Add your suggestions/comments here.."></textarea>
                        </div>                                                                   
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button> 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>

<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          
							<center><h4><p id="ms"></p></h4></center>               
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>  
                </div>
            </div>
        </div>
    </div>
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->      
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   <b>Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)</b>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

<!--    <script src="assets/js/jquery.js"></script>-->
   	<script src="moment-2.8.4/moment.js"></script>    
   <script src="assets/js/bootstrap.min.js"></script>
   <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>  
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script> 
    <script src="assets/js/jquery.scrollTo.min.js"></script> 
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script> 
    <!--common script for all pages-->
  <script src="assets/js/common-scripts.js"></script>
    <!--script for this page-->

   <script src="bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>

  			
<script type="text/javascript" charset="utf-8">
	$('#rev1').dataTable({paging:false});
	$('#rev2').dataTable();
	$('#m2l').dataTable({ 
   	bFilter: false, 
   	bInfo: false,
   	paging:false              			
  	   });	
  var d=new Date();
	//alert(d);  
  var today=d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();  	 
  $('.datetimepickers').datetimepicker({
		format:"DD-MM-YYYY h:m A",
		minDate:today
	});
$('.d').prop('disabled',true);
</script>
    	
<script type="text/javascript" >
function reviewGoals(t)
	{
		var eid=$(t).parent().prev().prev().prev().prev().prev().html();
		//alert(eid);		
		window.location.href="reviewgoals.php?eid="+eid;
	}
function viewGoals(th)
	{
		var eid=$(th).parent().prev().prev().prev().prev().prev().html();
		var gtype=$(th).parent().prev().first().find("option:selected").text();
		//alert(gtype);
		$.ajax({ 
			url:'gtypeinsert.php', 
			type:'POST', 
			data:{"id":eid,"gtype":gtype}, 
			success:function(data){ 
				//alert(data);
				window.location.href="setgoals.php?eid="+eid;
			}, 
			error:function(xhr,desc,err){ 
				alert("fail"); 
			} 
		});		
		//window.location.href="setgoals.php";	
	}
function r2viewGoals(t)
	{
		window.location.href="r2ApprGoals.php";	
	}
function togle4()
{
$('#m4').toggle();	
}
function togle3()
{
$('#m3').toggle();	
}
function togle2()
{
$('#m2').toggle();	
}
function togle1()
{
$('#m1').toggle();	
}

function r2comment(th)
{
$('#r2comment').modal('show');	
}
</script>


<script type="text/javascript" >
function savedate(it)
{
var empid=$(it).parent().parent().prev().prev().prev().html();
var scheduleddate=$(it).val();
//alert(scheduleddate)
$.ajax({
url:'savegmeetingdate.php',
type:'POST',
data:{'id':empid,'Mdate':scheduleddate},
success:function(data)
{
//alert(data);
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});
}
</script>  

<script type="text/javascript" >
function notify(th)
{
var empid=$(th).parent().parent().prev().prev().prev().html();
var selected=$(th).prev().children().first().val();
//alert(selected);

var msg1="1 on 1 meeting with the employee not scheduled!";
if(selected.length==0)
{
document.getElementById("ms").innerHTML=msg1;	
//$("#message").modal('show');
alert(msg1);
}
else 
{
$.ajax({
url:'notifygmeeting.php',
type:'POST',
data:{'id':empid},
success:function(data){
document.getElementById("ms").innerHTML="The employee has been notified.";	
//$("#message").modal('show');
alert("The employee has been notified");
},
failure:function(xhr,desc,err){
alert("fail");
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
