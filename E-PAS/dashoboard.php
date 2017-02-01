<?php
session_start();
include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
  <?php include 'stylesheets.php'; ?>
 <link href=&quot;//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css&quot; rel=&quot;stylesheet&quot;>
    <link href="progressline.css" media="all" rel="stylesheet"> 
   

  </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$db1=$m->goals1;
$c=$db->currentReviewCycle;
$c1=$db->currentGoalCycle;
$bd=$db->BasicDetails;
$bd1=$db1->BasicDetails;
$n=$db->Notifications;

$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

//echo $admin;
$r2id=$c1->find(array('r2id'=>$psiid));
$r1id=$c1->find(array('r1id'=>$psiid));
$empid=$c1->find(array('id'=>$psiid));
if($r2id->count()!=0)
{
 	$goal_role="r2";
}
else if($r1id->count()!=0)
{
	$goal_role="r1";	
}
else if($empid->count()!=0)
{
 $goal_role="emp";	
}
$doc=$bd->findOne(array("psiid"=>$psiid));
$doc1=$bd1->findOne(array("id"=>$psiid));
$ef=$doc1["EF"];

$today = date("d-m-Y");
$today_time = strtotime($today);
$pod=$n->findOne(array("name"=>"portalOpening"));
if (strtotime($pod["Date"]) <= $today_time) 
$reviewstarted=1;	
else 
$reviewstarted=0;

//echo $today;
//echo $pod["Date"];
//echo $reviewstarted;

$d=$c->findOne(array("psiid"=>$psiid));


$flg2=$d["flag2"];
if($d["flag1"]<"2" || $d["flag2"]<"2")
{
$panelflag=1;
$saObj=$n->findOne(array("name"=>"selfAppraisal"));
$esaObj=$n->findOne(array("name"=>"extendedSelfAppraisals"));
if(in_array($psiid,$saObj["employee IDs"]))
{ 
$SAdeadline=$saObj["Deadline"];
}
elseif(in_array($psiid,$esaObj["employee IDs"]))
{
$SAdeadline=$esaObj["Deadline"];	
}
}
elseif($d["flag1"]>="2" && $d["flag1"]<="9" && $d["flag2"]>="2" && $d["flag2"]<="9")
{
$panelflag=2;
$overallSelfRating=$d["overallselfrating"];	
}
elseif($d["flag2"]=="10")
{
$panelflag=3;
}
elseif($d["flag2"]=="11")
{
$panelflag=4;
}

//echo $role;
//echo $_SESSION["enc_key"];
?>
  <section id="container" >
<?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">    
       
          <div class="row"> <br><br></div>
 <?php 
if ($role==="emp")	    
{
	echo '<div class="row">';
	echo '<div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">';
	echo '</div>';
	echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">';
}
else
{
echo '<div class="row">';
echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">';	
}

?>
 <?php if($goal_role=="emp" )                  
       {     
       			echo'        <div class="panel">
                        <a href="employeegoals.php">
                        <div class="panel-heading">
                            <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa   fa-bullseye  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <!-- <div class="huge">12</div> -->
                                    <div><h4>Goals</h4></div>
                                </div>
                            </div>
                        </div>
                      
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>';
        		
        	if($ef>="1")
        	{
        	  if($ef<"2")
        	   {
        		echo'        <div class="panel">
                        <a href="agreement.php">
                        <div class="panel-heading">
                            <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa   fa-bullseye  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <!-- <div class="huge">12</div> -->
                                    <div><h4>Relieving Formalities</h4></div>
                                </div>
                            </div>
                        </div>
                      
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>';
        		}
        }		
        		
        		 
        		
        		}        
        		else {
        			 echo'<div class="panel">
                        <a href="gmanagerlist.php">
                        <div class="panel-heading">
                            <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa   fa-bullseye  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <!-- <div class="huge">12</div> -->
                                    <div><h4>Goals</h4></div>
                                </div>
                            </div>
                        </div>
                      
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>';
        			
        			}   		
        			
        			?>
        			
                
                
                </div>
 <?php
if ($role==="emp")	    
{
echo '<div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">';
echo '</div>';
echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >';
}	
else 
{
echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >';
}
?>            

       <div class="panel">
                          <a onclick="check()" href="#">
                        <div class="panel-heading">
                           
                            <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-list-alt  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Self Assessment</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
                            <?php
                            
                            $today = date("d-m-Y");
										$today_time = strtotime($today);
									
									$pod=$n->findOne(array("name"=>"portalOpening"));
									if (strtotime($pod["Date"]) <= $today_time) 
									{
										//echo $docdate["Deadline"];
										if(strpos($role,"emp") !== false)
										{
										$docdate=$n->findone(array("name"=>"selfAppraisal"));
										$yrdata= strtotime($docdate["Deadline"]);
										$a=explode("-",$docdate["Deadline"]);

										$month=date('F', $yrdata);
										echo "Click Here";
										}
										else 
										{
										echo "You are not part of this Review Cycle.";
										}
									}
									else {
									echo "The Review Cycle has not started yet...";
									}
                            ?>
                            
                            
									<!--<span class="pull-left">Click Here</span> -->                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div></div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
<div class="panel">
                          <a href="#">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-sitemap  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Org Chart</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
									<span class="pull-left">Coming Soon</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>  </div>
                    <?php
if ($goal_role==="emp")	   
{}
else 
{
	echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6  ">';
	echo '<div class="panel">';
echo '<a onclick="check1()" href="#">';
	echo '<div class="panel-heading" >';
	echo '<div class="row" style="margin:0px">';
	echo '<div class="col-xs-3">';
	echo '<i class="fa fa-edit fa-4x"></i>';
	echo '</div>';
	echo '<div class="col-xs-9 text-right">';
	echo '<div><h4>Employee Reviews</h4></div>';
	
	echo '</div>';
	echo '</div></div><div class="panel-footer">';
	echo '<span class="pull-left">Click Here</span>';
	echo '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>';
	echo '<div class="clearfix"></div>';
	echo '</div></a></div></div>';
	
	
/*   echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6  ">';
	echo '<div class="panel">';
	
   echo '<a onclick="managerFeedbacks()" href="#">';
	echo '<div class="panel-heading" >';
	echo '<div class="row" style="margin:0px">';
	echo '<div class="col-xs-3">';
	echo '<i class="fa fa-edit fa-4x"></i>';
	echo '</div>';
	echo '<div class="col-xs-9 text-right">';
	echo '<div><h4>Employee Exit Formality</h4></div>';
	
	echo '</div>';
	echo '</div></div><div class="panel-footer">';
	echo '<span class="pull-left">Click Here</span>';
	echo '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>';
	echo '<div class="clearfix"></div>';
	echo '</div></a></div></div>';*/	
	
	

}
?>
						    <?php if($admin!=="HRM")
                    {
                    	?> 
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
                    <div class="panel">
                          <a href="#">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-group  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Ask HR</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
									<span class="pull-left">Coming Soon</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    </div>
                   <?php     
                   }              
                    if($goal_role==="emp")
                    
                    {
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	}
                    else {
                    ?>
                   
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
                    <div class="panel">
                          <a href="#">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-cubes  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Competency</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
									<span class="pull-left">Coming Soon</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    </div>
                    
                     <?php
                    }
                   ?>       
<?php                   
                    if($admin==="HRM")
                    {
                    ?>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
<div class="panel">
                          <a href="employeedetails.php">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-user  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Employee List</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
									<span class="pull-left">Click Here</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>  </div>
                	
							                    
                    
                    
                    <?php
                    }
                   ?>                  
                           
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
                    <div class="panel">
                          <a href="#">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-trophy  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>R & R</h4></div>
                                </div>
                            </div>
                        </div>
                   
                            <div class="panel-footer">
									<span class="pull-left">Coming Soon</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    </div>
<?php                   
                    if($admin==="HRM")
                    {
                    ?>
<?php
if ($role==="emp")	    
{
echo '<div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">';
echo '</div>';
echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >';
}	
else 
{
echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >';
}
?>            					
</div>   
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" >
<div class="panel">
                          <a href="relievingProcess2.php">
                        <div class="panel-heading">
                           <div class="row" style="margin:0px">
                                <div class="col-xs-3">
                                    <i class="fa  fa-list-alt  fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                    <div><h4>Relieving Formalities</h4></div>
                                </div>
                            </div>
                        </div>   
                    
                   
                            <div class="panel-footer">
                            
									<span class="pull-left">Click Here</span>                              
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    </div>
                    
</div>   						
                     <?php
                    }
                   ?>                  
                          
<div class="row mt"><br><br></div>
<?php
//echo $c->find(array("psiid"=>$psiid));
if($d['psiid'])
{


//echo $panelflag;

?>		
<div class="row">
<div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
</div>
<div class="col-lg-12 col-md-12">
<div class="panel" >
<div class="wz-heading wz-w-label bg-grey">
<div class="progress progress-xs progress-wizard" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
<div class="progress-bar progress-bar-dark active"  style="width: 1%; margin: 0px 11%;"></div>
</div> 

<ul class="wz-steps wz-icon-bw wz-nav-off text-lg">
<li class="col-xs-3" id="cir1">
<a  href="#1" class="prog">
<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
<span class="wz-icon icon-txt text-bold">1</span>
<i class="wz-icon-done fa fa-check"></i>
</span>
<small class=" box-block margin-top-5">Self Assessment</small>
</a>
</li>
<li class="col-xs-3" id="cir2">
<a href="#2"  class="prog">
<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
<span class="wz-icon icon-txt text-bold">2</span>
<i class="wz-icon-done fa fa-check"></i>
</span>
<small class="box-block margin-top-5">Managerial Review</small>
</a>
</li>
<li class="col-xs-3" id="cir3">
<a  href="#3"  class="prog">
<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
<span class="wz-icon icon-txt text-bold">3</span>
<i class="wz-icon-done fa fa-check"></i>
</span>
<small class="box-block margin-top-5">View</small>
</a>
</li>
<li class="col-xs-3" id="cir4">
<a  href="#4"  class="prog">
<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
<span class="wz-icon icon-txt text-bold">4</span>
<i class="wz-icon-done fa fa-check"></i>
</span>
<small class="box-block margin-top-5">Finish</small>
</a>
</li>
</ul>
</div>
<form class="form-horizontal">
<div class="panel-body">
<div class="tab-content">
<div class="tab-pane" id="tab1">
<?php
$today = date("d-m-Y");
$today_time = strtotime($today);
$pod=$n->findOne(array("name"=>"portalOpening"));
if (strtotime($pod["Date"]) <= $today_time) 
{
if(strpos($role,"emp") !== false)
{
$docdate=$n->findone(array("name"=>"selfAppraisal"));
$yrdata= strtotime($docdate["Deadline"]);
$a=explode("-",$docdate["Deadline"]);

$month=date('F', $yrdata);
echo '<b>'."Self-Assessment has started and the timeline to complete is ".$month.", ".$a[0]." ".$a[2].".".'</b>';
}
else 
{
echo "You are not part of this Review Cycle.";
}
}
else {
echo "The Review Cycle has not started yet...";
}
	
	
?>
<div class="margin-bottom-10">

</div>
</div>
<div class="tab-pane" id="tab2" >
Thank you for completing the Self-Assessment on time.<br><br><br>
 Your manager is reviewing it. 
</div>
<div class="tab-pane " id="tab3">
<div class="box-inline">
<?php 
echo 'Hurray!!! Assessment process has been completed.<br><br><br>';
echo 'Click VIEW to see the results.<br><br><br>';
echo '<button class="finish btn btn-info btn-theme" type="button" onclick="finish()">View</button>';
?>
</div>
</div>
<div class="tab-pane " id="tab4">
<div class="box-inline">
<?php 
echo 'Thank You for completing your Review Process.';
?>
</div>
</div>

</div>
</div>
<div class="panel-footer text-right">

</div>
</form>

</div>
</div>
</div>

<?php
}
?>

<div class="row mt"><br><br></div>
				<?php 
				
				?>
<div class="row">
 <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
 </div>
 
</div>

<div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sorry!</h4>
                </div>
                <div class="modal-body">
                 <form role="form">
							    <h3><center>The Review Process has not started yet...</center></h3>          
                 <div class="modal-footer">
                   			<a class="btn btn-info" name="ok" href="dashoboard.php">OK</a> 
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
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" >
		$(document).ready(function(){
var a="<?php echo $panelflag; ?>";
//var a=4;
$('#finished').prop('disabled',true);
			if(a==1)
			{ 
			$("#cir1").addClass("active");
			$("#tab1").addClass("active");
			$(".progress-bar").css("width", "1px");
			}else if(a==2)
			{
			$("#cir2").addClass("active");
			$("#tab2").addClass("active");
			$(".progress-bar").css("width", "26%");
			}else if(a==3)
			{
			$("#cir3").addClass("active");
			$("#tab3").addClass("active");
			$(".progress-bar").css("width", "51%");
			}else if(a==4)
			{
			//$("#cir4").addClass("active");
			$("#tab4").addClass("active");
			$("#cir1").removeClass("active");
			$("#tab1").removeClass("active");			
			$(".progress-bar").css("width", "77.5%");
			}else 
			{
			$("#cir1").removeClass("active");
			$("#tab1").removeClass("active");
			$(".progress-bar").css("width", "0px");
			}
		});
	 </script>

<script type="text/javascript" >
function finish()
{
var id="<?php echo $psiid; ?>";
//alert(id);
window.location.href='viewform1.php?eid='+id+'&view=emp';
/*$.ajax({ 
url:'finish.php', 
type:'POST', 
data:{"psiid":id}, 
success:function(data){ 
alert("Thank you for completing your review.");
location.reload();
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert(err); 
} 
});*/

}
</script>

<script type="text/javascript" >
function check1()
{
var role="<?php echo $role; ?>";
var fl="<?php echo $flg2; ?>";
//alert(fl)
//if(fl>=10||fl=="")
//alert("You are not part of the current review cycle.");
//else 
	window.location.href="review1list.php";  
}
function managerFeedbacks()
{

	window.location.href="MView.php";  
}
function check()
{
//alert("hsdifhsfhk");
var role="<?php echo $role; ?>";
var fl="<?php echo $reviewstarted; ?>";
if(fl==0)
$("#myModal2").modal('show');
else if ( role.indexOf("emp") > -1 ) 
	window.location.href="selfassessmentform.php";
else 
  alert("You are not part of this review cycle.");
}
</script>

  </body>
</html>
