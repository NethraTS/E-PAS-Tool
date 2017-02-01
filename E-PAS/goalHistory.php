<?php
session_start();include session_timeout.php;
include 'secure.php';
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
  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->goalHistory;


$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
//$active=$_GET["active"];
$history=$c->find(array("id"=>$psiid));
$r1docs=$c->find(array('r1id'=>$_SESSION['psiid']));

if($r1docs->count()!=0)
{
$active="r1";	
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
 
    	<div class="col-lg-12"> 
       	<div class="form-panel">             	  
             <div class="bs-example">	             
				    <ul class="nav nav-tabs">
<?php

if($active=="r1")
{
	if($_GET['tab']=="2")
	{
	echo '<li ><a data-toggle="tab" href="#r1">My Goal History</a></li>';
	echo '<li class="active" ><a data-toggle="tab" href="#r2">My Team History</a></li>';
	}
	else
	{
	
		echo '<li class="active"><a data-toggle="tab" href="#r1">My Goal History</a></li>';
	echo '<li ><a data-toggle="tab" href="#r2">My Team History</a></li>';
	}
}
if($active=="emp")
{
	
	echo '<li class="active"><a data-toggle="tab" href="#r1">My Goal History</a></li>';	
}


?>
	 				
	 				 </ul>
 
	 				 
   	 <div class="tab-content" style="padding-top:20px;">

<?php
	if($active=="r1")
	{
	if($_GET['tab']=="2")
	{
		echo '<div id="r1" class="tab-pane fade">';
	}
	else
	{
		echo '<div id="r1" class="tab-pane fade in active">';
	}
	}
	else
	{
		echo '<div id="r1" class="tab-pane fade in active">';		
	}
	
?>	
                  <table  class="table table-striped">
                  <thead>
                  <th>Goal Year</th><th>Goal Type</th><th>View</th><th></th><thead>
                  <tbody>
						<?php
						$count=0;
						foreach($history as $v )
						{$count++;
						?>
						<tr>
						<td><?php echo $v['gYear']; ?></td><td><?php echo $v['gType']." - ".$v['gName']; ?></td>
						<td><a href="goalHistoryView.php?gYear=<?php echo $v['gYear'] ?>&gName=<?php echo $v['gName'] ?>">Click Here</a></td>
						</tr>
						<?php
						}
						?>                  
                  </tbody>
                  </table>
	 				 	   </div>

	 				<div id="r1cmt1" class="modal fade">
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
                         <label style="color:hotpink;" class="control-label">Date</label>
                         <div class="input-group date" id="datetimepicker">
	  				<input size="18" class="datetimepickers" id="dater1cmt"  placeholder="Click Here.." ></input>
				</div>
                            <label style="color:hotpink;" class="control-label">Comments</label>
                            <textarea class="form-control" id="msrment1" name="msrment" rows="3" placeholder="Add your suggestions/comments here.."></textarea>
                        </div>                                                                   
                        <div class="modal-footer">
                        <input type="hidden" id="idd" >
                   			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo" data-dismiss="modal">Close</button>
<button class="btn btn-primary" onclick="savr1cmmt(this)" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button>                    			
                    			<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" onclick="ret()">
  									Show all
									</button>
									<div id="demo" style="text-align:left" class="collapse out"><br>
									</div>
                    			 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if($active=="r1")
{
	if($_GET['tab']=="2")
	{
	echo '<div id="r2" class="tab-pane fade in active" >';
	}
	else
	{
			echo '<div id="r2" class="tab-pane fade" >';
	}
}
else
{  
	echo '<div id="r2" class="tab-pane fade">';
}
?>	

<table class="table" id="rev1">
						  <thead>
							  <tr>
							  <th>S no</th>
								  <th>Name</th>
								  <th>Designation</th>
								  <th colspan="4">Goals </th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
							$tg=$db->goalHistory;
							$thistory=$tg->find(array('r1id'=>$psiid));
							$count3=1;
							foreach($thistory as $doc)
							{
							?>
							<tr><td><?php echo $count3 ?></td>
							<td><?php echo $doc['name'] ?></td>
							<td><?php echo $doc['desgn'] ?></td>
								<?php $tgCursor=$tg->find(array('r1id'=>$psiid,'id'=>$doc['id'])); ?>					
							<?php
						
						foreach($tgCursor as $v )
						{
						?>
							<td><a href="goalHistoryView.php?gYear=<?php echo $v['gYear'] ?>&gName=<?php echo $v['gName'] ?>&id=<?php echo $v['id'] ?>"><?php echo $v['gYear'].' '. $v['gType']." - ".$v['gName'];  ?></a></td>
							<?php
							}
							?>
							
							<?php //echo	 '<div id="m'.$count3.'" style="display:none;float:left;padding-top:20px;">';
							?>
							<?php 
							$count3++;							
							} ?>									
							  <table  class="table ">
                  <thead>
                 <!-- <th>List of Goals</th><thead>-->
                  <tbody>	</tr>
								
						<?php
						
						//foreach($thistory as $v )
						{
						?>
						<tr>
						<!--<td><a href="goalHistoryView.php?gYear=<?php echo $v['gYear'] ?>&gName=<?php echo $v['gName'] ?>&id=<?php echo $v['id'] ?>"><?php echo $v['gYear'].' '. $v['gType']." - ".$v['gName'];  ?></a></td>-->
						
						</tr>
						<?php
						}
						?>                  
                  </tbody>
                  </table>
							<?php
							echo '</div>'
							?> 						
							 
                    </tbody>	 				
	 				  </table>

        				
	 				
	 				
	 				
	 				
	 				
	 				</div>
	 					 				
	 		</div>        
	      
	           </div>
	     
	 				 				<?php if(($count)==0&&($count3)==1)
{?>
<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4><?php echo "No Goal Cycle Completed Till Now!!!" ?></h4>             	  
		        


					<br>
	<!--				 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
					 <input type="text" class="col-lg-1" size="10"></input>
					 <label class="col-lg-1">(0-5)</label>-->

	         </div>
		    </div>
		    
		    <?php }?>	
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
                    			<button type="submit" class="btn btn-primary" onclick="savcmmt(this)" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button> 
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
	$('#rev1').dataTable({bFilter: false, bInfo: false});
	$.fn.dataTableExt.sErrMode = 'throw';
	   $('#rev2').DataTable();
	

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
var dat="";
function reviewGoals(t)
	{
		$.fn.dataTableExt.sErrMode = 'throw';
   $('#rev2').DataTable();

		var eid=$(t).parent().prev().prev().prev().prev().prev().prev().html();
		//alert(eid);		
		window.location.href="reviewgoals.php?eid="+eid;
	}
	

function viewGoals(th)
	{
		
		var eid=$(th).parent().prev().prev().prev().prev().prev().html();
		var gtype=$(th).parent().prev().first().find("option:selected").text();
		if(gtype=="")
		{		
		alert("Please add the Goal type ");
		}		
		else
		{
		
		$.ajax({ 
			url:'gtypeinsert.php', 
			type:'POST', 
			data:{"id":eid,"gtype":gtype}, 
			success:function(data){ 
			//	alert(data);
			window.location.href="setgoals.php?eid="+eid;
			}, 
			error:function(xhr,desc,err){ 
				//alert("fail"); 
			} 
		});	
		//window.location.href="setgoals.php";
		$.fn.dataTableExt.sErrMode = 'throw';
   $('#rev2').DataTable();	
   	}
	}
	function viewempGoals(empid)
	{
		window.location.href="r2reviewgoals.php?eid="+empid;
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
function togle1(n)
{

var str1 = "m";
var str2 = n;
var res = str1.concat(n); //m1
$('#'+res).toggle();	
}
//var id,id123;
function savcmmt(th)
{
var cmt=$('#msrment').val();
//alert(id);
//alert(cmt);
$.ajax({
url:'r2Approval.php',
type:'POST',
data:{'id':id,'cmt':cmt},
success:function(data)
{
alert("Comment was entered successfully.");
window.location.reload();
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});	

	}
	
function savr1cmmt(th)
{
var cmt=$('#msrment1').val();
var date=$('#dater1cmt').val();
var id123=$('#idd').val();
//alert(id123);
if(cmt==""||date=="")
{
alert("Please enter all fields");
}
else
{
//alert(id);
//alert(cmt);
$.ajax({
url:'r1comment.php',
type:'POST',
data:{'id':id123,'cmt':cmt,'dat':date},
success:function(data)
{
alert("Comment was entered successfully.");
//$("#r1cmt1").modal("close");
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});
}	

}

function r1cmt(th)
{ 
	//alert(th.parentNode.value);
$("#r1cmt1").modal("show");
 var id123=$(th).closest("tr").find('td:eq(0)').text();
 document.getElementById("idd").value=id123;
//id123=$(th).parent().prev().prev().prev().prev().prev().html();
	//alert(id123);	
//ret(id123);
	}	

function r2comment(th)
{
	//alert(th);
$('#r2comment').modal('show');	
id=$(th).parent().prev().prev().html();	
//alert(id);
}
function ret()
{
	 var id123= document.getElementById("idd").value;
	//alert(id123);
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
                document.getElementById('demo').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET", "retriver1cmt.php?id=" + id123, true);
        xmlhttp.send();	
	//document.getElementById("idd").value="";
	}

</script>


<script type="text/javascript" >
function s1(it)
{
 //alert("onblur");
 dat=$(it).val();	
 if(dat=="")
 alert("please enter the date");
 //alert(dat);
	}

function savedate(it,empid1)
{
//var empid=$(it).parent().parent().prev().prev().prev().html();
//alert(empid1);
//alert(it);
var scheduleddate=$(it).val();
//alert(scheduleddate)
$.ajax({
url:'savegmeetingdate.php',
type:'POST',
data:{'id':empid1,'Mdate':it},
success:function(data)
{
//alert(data);
window.location.href="gmanagerlist.php";
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
var empid1=$(th).parent().prev().prev().prev().html();
var selected=$(th).prev().children().first().val();
//alert(selected);
//var dat=$('#d').val();
//alert(dat);

var msg1="1 on 1 meeting with the employee not scheduled!";
if(selected.length==0)
{
document.getElementById("ms").innerHTML=msg1;	
//$("#message").modal('show');
//alert(msg1);

}
if((dat)=="")
{
//alert(empid1);
alert("Plese enter a date to notify");	

}
else 
{
$.ajax({
url:'notifygmeeting.php',
type:'POST',
data:{'id':empid1},
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

savedate(dat,empid1);
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
var currentdate = new Date(); 
var today = currentdate.getDate() + "-"
+ (currentdate.getMonth()+1)  + "-" 
+ currentdate.getFullYear();
$('.datetimepickers').datetimepicker({
format:"DD-MM-YYYY",
minDate:today,
});
</script>

</body>
</html>
