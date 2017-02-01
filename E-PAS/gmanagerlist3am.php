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

<!--<link href="bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="datetime/jquery.datetimepicker.css"/>
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
$c=$db->currentGoalCycle;
$g=$db->GoalsToBeReviewed;
$allgoal=$g->find();
$alldocs=$c->find();
$active1=$_GET["active"];
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
//$active=$_GET["active"];
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
elseif($active=="r2" || $active=="r1")
{
	if($active1=="r2")
{
		echo '<li ><a data-toggle="tab" href="#r1">My Team</a></li>';
	echo '<li class="active"><a data-toggle="tab" href="#r2">Second level</a></li>';

}
else{
	echo '<li class="active"><a data-toggle="tab" href="#r1">My Team</a></li>';
	echo '<li ><a data-toggle="tab" href="#r2">Second level</a></li>';
}
}
elseif($active=="r")
{
	//echo '<li><a data-toggle="tab" href="#r1">My Team</a></li>';
	echo '<li class="r2"><a data-toggle="tab" href="#r2">My Team</a></li>';
}




?>
	 				
	 				 </ul>
	 				 
	 				 
   	 <div class="tab-content" style="padding-top:20px;">

<?php
if(($active=="r1" || $active=="r2")&&($active1!="r2")) 
	echo '<div id="r1" class="tab-pane fade in active ">';
else 
	echo '<div id="r1" class="tab-pane fade">';
	
?>	
                       	
	<!--<input type="text" value="" id="datetimepicker_mask"/><br><br>-->  
                 <table class="table"  id="rev1">
		                        <thead>                       
		                               <tr>
								 					 <th style="width:70px;">PSI ID</th>
								 					 <th>Name</th>
								 					 <th>Designation</th>
								 					 <th>Schedule a Meeting</th>
								 					 <th>Goal Type</th>
								 					 <th>Action</th>
								 					  <th>Review</th>
								 					<!-- <th>Feedback</th>-->
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
   echo '<td>';
   
   			 if($doc["r1MeetingDate"] != "" || $doc["r1MeetingDate"] != NULL)
   			{echo '                 	  												
				<div class="input-group date" id="datetimepicker'.$count.'">
	  				<input size="18" disabled="disabled" class="datetimepickers" id="d'.$count.'"  placeholder="Click Here.." value="'.$doc["r1MeetingDate"].'"></input>
				</div>';
				}
				else {
				echo'<div class="input-group date" id="datetimepicker'.$count.'">
	  				<input size="18"  class="datetimepickers " id="d'.$count.'" placeholder="Click Here.." value="'.$doc["r1MeetingDate"].'"></input>
				</div>';
				}
				 
				 
				
	 			if($doc["r1MeetingDate"] != "" || $doc["r1MeetingDate"] != NULL)
	 			{
	          echo '<button type="button" disabled="disabled" class="btn bc btn-primary btn-xs" onclick="notify(this)" >
			 		  <i class="fa fa-mail-forward"></i>&nbsp&nbsp Notify
							 		</button>';
					}
					else {
						echo '<button type="button"  class="btn bc btn-primary btn-xs" onclick="notify(this)" >
			 		  <i class="fa fa-mail-forward"></i>&nbsp&nbsp Notify
							 		</button>';
						}	
						 				 				
			echo '</td>
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
	  if($doc["r1MeetingDate"] == "" || $doc["r1MeetingDate"] == NULL) //used to check the r1 meeting scheduled or not
	 {
	 	echo '<select class="gtype" >';
      echo '<option>'.$doc["gType"].'</option>';
	   foreach($gtypes as $k)	
	     {
	     	if($doc["gType"]!== $k)
	    	 echo '<option>'.$k.'</option>';
	     } 
	   echo '</select>';	 	
	 }
	 else if($doc["r1MeetingDate"] !="" || $doc["r1MeetingDate"] != NULL)
	 	 {
	 	echo '<select class="gtype" >';
      echo '<option>'.$doc["gType"].'</option>';
	   foreach($gtypes as $k)	
	     {
	     	if($doc["gType"]!== $k)
	    	 echo '<option>'.$k.'</option>';
	     } 
	   echo '</select>';	 	
	 }
	 else {
	 	echo "Notify for meeting";
	 	}
	 }
	 else if($doc["flag"]>="2")
	 {
	 	
	 	echo $doc["gType"];
	 }
	  
	
		echo '</td>';
		if($doc["flag"]<"2") {
			 
		//echo '<td>';
	if($doc["r1MeetingDate"]=="" || $doc["r1MeetingDate"]==NULL )
	 {																			 		
		echo '	<td><button type="button" class="btn btn-info btn-xs" onclick="gls()" >
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Add Goals
				</button>	</td>	                          
				<td><button type="button" class="btn rv btn-primary btn-xs d" onclick="reviewGoals(this)" disabled="disabled" title="Review Not Yet Started">
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button></td>';
			/*echo '<td>
<div href="#" data-toggle="tooltip" title="Review Not Yet Started">
		<i class="fa fa-comment fa-2x" id="comment" ></i>
		</div>
		</td>';*/
				
				}
				else
	 {																			 		
		echo    '<td><button type="button" class="btn btn-info btn-xs" onclick="viewGoals(this)">
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp Add Goals
				</button></td>		                          
				<td><button type="button" class="btn rv btn-primary btn-xs  d" onclick="reviewGoals(this)">
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button></td>';
				
			/*	echo '<td>
<div href="#" data-toggle="tooltip" title="Review Not Yet Started">
		<i class="fa fa-comment fa-2x" id="comment" ></i>
		</div>
		</td>';*/
				}		                          
     			                          
     		//echo '</td>';
     		
     		}
     		else if(($doc['flag']>"2")&&($doc['flag']<"7"))
     		{
     		
     						echo    '<td><button type="button" class="btn btn-info btn-xs" onclick="viewempGoalsr1(this)">
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp view 
				</button></td>';		  																		 				                          
				echo '<td><button type="button" class="btn rv btn-primary btn-xs  "  onclick="reviewGoals(this)"s>
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button></td>';
						                          
     	
     		if($doc['flag']>"2")
                {
              /*  echo '<td>
<a href="#" data-toggle="tooltip" title="Enter Reviewer Feedbacks if any">
                <i class="fa fa-comment fa-2x" id="comment" onclick="r1cmt(this)"></i>
                </a>
                </td>';*/
         echo '</tr>';
                }
                else {
                	/*echo '<td>
<div href="#" data-toggle="tooltip" title="Review Not Yet Started">
                <i class="fa fa-comment fa-2x" id="comment" ></i>
                </div>
                </td>';*/
                }
        }
        else if($doc['flag']>="7")
     		{
     		
     						echo    '<td><button type="button" class="btn btn-info btn-xs" onclick="viewempGoalsr1(this)">
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp view 
				</button></td>';		  																		 				                          
				echo '<td><button type="button" class="btn rv btn-primary btn-xs  " style="background-color:Green" onclick="reviewGoals(this)"s>
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button></td>';
						                          
     	
     		if($doc['flag']>"2")
                {
                /*echo '<td>
<a href="#" data-toggle="tooltip" title="Enter Reviewer Feedbacks if any">
                <i class="fa fa-comment fa-2x" id="comment" onclick="r1cmt(this)"></i>
                </a>
                </td>';*/
         echo '</tr>';
                }
                else {/*echo '<td>
<div href="#" data-toggle="tooltip" title="Review Not Yet Started">
                <i class="fa fa-comment fa-2x" id="comment" ></i>
                </div>
                </td>';*/}
        }
     		else {
     				echo    '<td><button type="button" class="btn btn-info btn-xs" onclick="viewempGoalsr1(this)">
			 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp view 
				</button></td>';	
     			
     				echo '<td><button type="button" class="btn rv btn-primary btn-xs  " onclick="reviewGoals(this)" disabled="disabled">
			 		  <i class="fa fa-compass"></i>&nbsp&nbsp Review Goals
				</button></td>';
				
				if($doc['flag']>"2")
                {
               /* echo '<td>
<a href="#" data-toggle="tooltip" title="Enter Reviewer Feedbacks if any">
                <i class="fa fa-comment fa-2x" id="comment" onclick="r1cmt(this)"></i>
                </a>
                </td>';*/
         echo '</tr>';
                }
                else {/*echo '<td>
<div href="#" data-toggle="tooltip" title="Review Not Yet Started">
                <i class="fa fa-comment fa-2x" id="comment" ></i>
                </div>
                </td>';*/}
      			
     			}

		

	$count++;
	
}
 ?>    	 
		                        </tbody>
		            </table>
	 				 	   </div>
	 			
	 				<div id="r1cmt1" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Feedback</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="">							              
                        <div class="form-group">
                        	<input type="hidden" id="hiddenid">                                                                         
                        <div class="form-group">
                         <label style="color:hotpink;" class="control-label">Date</label>
                         <div class="input-group date" id="datetimepicker1">
	  				<input size="18"  id="dater1cmt"  placeholder="Click Here.." ></input>
				</div>
				<br>
				 <label >Select a Goal</label>
					<select class="static-form-control" id="goal1" onchange="goal_change1(this.value)"><option value="" selected disabled>Select a Goal</option>
					<option>Deliverables</option>
					<option>Quality</option>
					<option>Initiatives/ Ownership</option>
					<option>Organizational/ Project Contribution</option>
					<option>Strategic Planning /Value Addition</option> 
 					</select>
 
  
  <br><br>

  <label>Select a Measurement</label>
 					<select class="static-form-control col-lg-12" id="def1"><option selected disabled>Select a definition</option>
 					</select>
 					
 					<br>
				<label style="color:hotpink;" class="control-label">Comments</label>
                            <textarea class="form-control" id="msrment1" name="msrment1" rows="3" placeholder="Add your suggestions/comments here.."></textarea>
                        </div>                                                                   
                        <div class="modal-footer">
                        <input type="hidden" id="idd" >
                   			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo" data-dismiss="modal">Close</button>
<button class="btn btn-primary" onclick="savr1cmmt(this)" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button>                    			
                    			<button type="button" class="btn btn-primary" title="Click Here to view comments" data-toggle="collapse" data-target="#demo" onclick="ret()">
  									Show all
									</button>
									<div id="demo" style="text-align:left" class="panel-collapse collapse out"><br>
									
									</div>
                    			 
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(($active=="r2" || $active=="r")&&($active1=="r2"))
	echo '<div id="r2" class="tab-pane fade in active" >';
else 
echo '<div id="r2" class="tab-pane fade " >';
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
						  <?php
							$r2docs=$c->find(array('r2id'=>$_SESSION['psiid']));
							//$r2doc=$c->findOne(array('r2id'=>$_SESSION['psiid']));
							$count1=1;
							foreach($r2docs as $doc)
							{
								$b[]=$doc["r1name"];
							}										
							$a[]=(array_unique($b));
							(sort($a[0]));				
							
			for($i=0;$i<count($a[0]);$i++)							
							{
							echo '<tr id="e'.$count1.'">';
							echo '<td>'.$a[0][$i].'</td>';
							$cursor=$c->find(array('r1name'=>$a[0][$i]));
							echo '<td>'.$cursor->count().'</td>';
							$cursor1=$g->find(array('r1name'=>$a[0][$i],'rFlag'=>array('$gte' => "4")));
							echo '<td>'.$cursor1->count().'</td>';						
	echo '<td><a href="#" id="bala" class="fa fa-plus-circle" data-toggle="tooltip" title="Click Here" data-target="#m'.$count1.'" onclick="togle1('.$count1.')"></td><td></td></tr></a>';
	
						 echo '<td id="m'.$count1.'" class="collapse out">  '; 	
                
					?>
						  
               					 <table style="width:700px;" id="m1l">		
                 <thead style="color:green;">
               
               
               
               						<tr>
                                <th>PSI ID</th>
                                <th>Name</th>
                                <th>Action</th>
                   					</tr>   
                   					</thead>  
                   					 <tbody style="color:orange;"> 
                                                    	<?php 
												
							//echo	 '<div id="m'.$count1.'" style="display:none;padding-top:20px;">';								      
								      $cursor1=$g->find(array('r1name'=>$a[0][$i],'rFlag'=>array('$gte' => "4"))); 
												foreach($cursor1 as $doc)							      
												{
								      ?>
											<tr>
										
											  <td><?php echo $doc['id']; ?></td>
											  <td><?php echo $doc['name']; ?></td>
											  <td> 
											     <button type="button" class="btn btn-info btn-xs" onclick="viewempGoals(<?php echo $doc['id'];?>)">
											 		  <i class="fa fa-folder-open"></i>&nbsp&nbsp View 
											 		</button>
										<?php	    
										$dep=decrypt(($doc["r2Finalcomment"]));
										if($doc["r2Finalcomment"] != "" || $doc["r2Finalcomment"] != NULL)	
										{									    
											 echo 'Approved!!';
											}
											
											else
											{
												echo '<button type="button" class="btn btn-info btn-xs" id="appbtn"  onclick="r2comment(this)">
											 		  <i class="fa fa-check"></i>&nbsp&nbsp Approve 
											 		</button>';
												} 													 		
											 echo ' </td>';
											  
											echo '  <td><label>'
											  
											  .($dep).
											  
											  '</label>
											  
											  </td></tr>';
											  ?>
											 	
									 
											 <?php } ?>  
    
	 				 
	 				 </tbody>	 
	 				 </table>		
	 				 
	 				 </td>
	 			 				 </div>
											 
									
							
								<?php

			
							$count1++;
							
							}
							?>
						
   </tbody>	 				
	 				  </table>			
                
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
   Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)
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

   <!--<script src="bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>   
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
  			
<script type="text/javascript" charset="utf-8">
	$('#rev1').dataTable();
	
	   $('#rev2').dataTable();
	
$.fn.dataTableExt.sErrMode = 'throw';
		
  var d=new Date();
	

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
function viewempGoalsr1(th)
	{
		var eid=$(th).parent().prev().prev().prev().prev().prev().html();
		//alert(eid);
		window.location.href="r1viewgoals.php?eid="+eid;
	}	
$("#m").click(function(e) {
    e.preventDefault();
    // Do your stuff
});

function gls()
{
	
alert("Please click on notify!! ");	
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
{//var r=confirm("The submission enables the employee to view the goals. Are you sure?");

//alert(id);
//alert(cmt);
$.ajax({
url:'r2Approval.php',
type:'POST',
data:{'id':id},
success:function(data)
{
//alert("Comment was entered successfully.");
//window.location.reload();
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
var goal22=$('#goal1').val();
var def22=$('#def1').val();
var id123=$('#idd').val();
//alert(id123);
if(cmt==""||date==""||date=="____/__/__ __:__")
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
data:{'id':id123,'cmt':cmt,'dat':date,'goal22':goal22,'def22':def22},
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
//$('#r2comment').modal('show');	
id=$(th).parent().prev().prev().html();	
//alert(id)
$.ajax({
url:'r2Approval.php',
type:'POST',
data:{'id':id},
success:function(data)
{
//alert("Comment was entered successfully.");
//window.location.reload();

 
},
failure:function(xhr,desc,err)
{
alert("fail");
}
});
$(th).prop("disabled", true);
$(th).text("Approved");
$(th).css( "background-color", "#228B22" );

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
  <!--<script src="datetime/jquery.js"></script> -->
<script src="datetime/jquery.datetimepicker.js"></script>
<script type="text/javascript" >
/*$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd"});
  }); */

  /* var currentdate = new Date(); 
var today = currentdate.getFullYear()+"/"+ (currentdate.getMonth()+1)+"/"+currentdate.getDate() ;
//alert(today); */
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
<script type="text/javascript" >


function goal_change1(str){
	var id123=$('#idd').val();
	//alert(id123);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {  
         if (xmlhttp.status == 200) {    
                document.getElementById('def1').innerHTML=xmlhttp.responseText;
         }
        }
        xmlhttp.open("GET","change_def1.php?goal=" + str + "&id=" +id123, true);
        xmlhttp.send();		
   }





function savedate(it,empid1)
{
//var empid=$(it).parent().parent().prev().prev().prev().html();
//alert(empid1);
//alert(it);
//var scheduleddate=$(it).val();
//alert(scheduleddate)
$.ajax({
url:'savegmeetingdate.php',
type:'POST',
data:{'id':empid1,'Mdate':it},
success:function(data)
{
	//alert()
//alert(data);
alert("The employee has been notified by E-mail.");
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
var dat=$('#d').val();
//alert(dat);

var msg1="1 on 1 meeting with the employee not scheduled!";
if(selected.length==0)
{
document.getElementById("ms").innerHTML=msg1;	
//$("#message").modal('show');
//alert(msg1);

}
if((selected)=="____/__/__ __:__")
{
alert("Plese enter a date to notify");	

}
else 
{
savedate(selected,empid1);
/*$.ajax({
url:'notifygmeeting.php',
type:'POST',
data:{'id':empid1},
success:function(data){
document.getElementById("ms").innerHTML="The employee has been notified.";	
//$on("#message").modal('show');
//alert("The employee has been notified");
},
failure:function(xhr,desc,err){
alert("fail");
}
});*/
//alert("The employee has been notified");


}}
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
/*var currentdate = new Date(); 
var today = currentdate.getDate() + "-"
+ (currentdate.getMonth()+1)  + "-" 
+ currentdate.getFullYear();
$('.datetimepickers').datetimepicker({
format:"DD-MM-YYYY h:m A",
minDate:today,
});
$('.datetimepickers tbody').on('click', function(){  $('.datetimepickers').hide() });
$('.d').prop('disabled',true);

$('.datetimepickers1').datetimepicker({
format:"DD-MM-YYYY h:m A",
maxDate:today,
});
*/
$('.d').prop('disabled',true);

function ajaxindicatorstart(text)
	{
		if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
		jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="482(1).GIF"><div>'+text+'</div></div><div class="bg"></div></div>');
	}
		jQuery('#resultLoading').css({
			'width':'100%',
			'height':'100%',
			'position':'fixed',
			'z-index':'10000000',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto'
		});	
		
		jQuery('#resultLoading .bg').css({
			'background':'#000000',
			'opacity':'0.7',
			'width':'100%',
			'height':'100%',
			'position':'absolute',
			'top':'0'
		});
		jQuery('#resultLoading>div:first').css({
			'width': '250px',
			'height':'75px',
			'text-align': 'center',
			'position': 'fixed',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto',
			'font-size':'16px',
			'z-index':'10',
			'color':'#ffffff'
			
		});

	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeIn(300);
	    jQuery('body').css('cursor', 'wait');
	}

	function ajaxindicatorstop()
	{
	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeOut(300);
	    jQuery('body').css('cursor', 'default');
	}
	
jQuery(document).ajaxStart(function () {
   		//show ajax indicator
		ajaxindicatorstart('Processing.. please wait..');
  }).ajaxStop(function () {
		//hide ajax indicator
		ajaxindicatorstop();
  });

</script>

</body>
</html>
