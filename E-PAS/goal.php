<?php
session_start();include session_timeout.php;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 

<!--slider and pips-->
     <link rel="stylesheet" href="slider/jquery-ui.css"> 
		<script src="slider/jquery-1.10.2.js"></script> 
		<script src="slider/jquery-ui.js"></script>
		<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
		<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 

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
</style>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

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
     <h3>Employee Name</h3>  
  	 	<button class="btn btn-sm btn-theme03 pull-left" style="margin-left:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
		
  	  </div>

<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th> 
                        <th>Status</th>                                                                							
							</tr>		           
		           </thead>
		           <tbody>
							<tr> 
							  <td> hgs ddfdfdf sdfds</td>
							  <td> dsfdsfddferw</td>
							  <td> fgdffdgdfg trtfggbv</td>
							  <td> fggffg fg ytyhgngvbnbvn</td>
							  <td>completed</td>
							</tr>
						
							</tr>
					  </tbody>
					  </table>

                 <label class=" col-lg-1 pull-left">weightage</label>              
					  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">
					
					 <label class="col-lg-2 pull-left">Self-Rating</label>
					 <div class="slider col-lg-2 green" id="ds" name="E-"></div>								
				
					<button type="button" class="btn btn-sm btn-info pull-right" style="margin-right:10px;" name="del">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>				  
	         
	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                        <th>Description</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>  
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
						</tbody>
			      </table>

				    <label class=" col-lg-1 pull-left">weightage</label>              
					  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">
					
					 <label class="col-lg-2 pull-left">Self-Rating</label>
					 <div class="slider col-lg-2 green" id="ds" name="E-"></div>								
				
					<button type="button" class="btn btn-sm btn-info pull-right" style="margin-right:10px;" name="qual">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>				  

	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th> 
                        <th>Status</th>                                                               							                                                                							
							</tr>		           
		           </thead>
		           <tbody>
					  </tbody>
			      </table>

					    <label class=" col-lg-1 pull-left">weightage</label>              
					  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">
					
					 <label class="col-lg-2 pull-left">Self-Rating</label>
					 <div class="slider col-lg-2 green" id="ds" name="E-"></div>								
				
					<button type="button" class="btn btn-sm btn-info pull-right" style="margin-right:10px;" name="comp">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>				  

			    </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
					  </tbody>
					  </table>	

				    <label class=" col-lg-1 pull-left">weightage</label>              
					  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">
					
					 <label class="col-lg-2 pull-left">Self-Rating</label>
					 <div class="slider col-lg-2 green" id="ds" name="E-"></div>								
				
					<button type="button" class="btn btn-sm btn-info pull-right" style="margin-right:10px;" name="orgcon">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>				  

	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
					  </tbody>
			      </table>

					    <label class=" col-lg-1 pull-left">weightage</label>              
					  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">
					
					 <label class="col-lg-2 pull-left">Self-Rating</label>
					 <div class="slider col-lg-2 green" id="ds" name="E-"></div>								
				
					<button type="button" class="btn btn-sm btn-info pull-right" style="margin-right:10px;" name="valadd">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>				  

	         </div>
		    </div>

	 </div>

<!--button-->
		  <div class="row mt">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	  <div class="col-lg-7">
                <button class="btn btn-theme03 pull-right">
                  <i class="fa fa-check"></i>&nbsp&nbsp Approve/Finalise/Accept
                </button>
               </div> 
            </div>
          </div>
         </div>
         
		</section><! --/wrapper -->

      </section><!-- /MAIN CONTENT -->

      <!--main content end-->

<div id="addGoal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add A Goal</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="">
							              
                        <div class="form-group">
                        	<input type="hidden"  name="hiddenid" id="hiddenid">
                            <label style="color:hotpink;" for="name" class="control-label"> The Goal category:</label>
									<p class="form-control-static">Deliverables</p>
							   </div>
								<div class="form-group">
                            <label style="color:hotpink;" for="name" class="control-label">Measurement</label>
                            <textarea class="form-control" id="msrment" name="msrment" rows="3"></textarea>
                        </div>                    
                      <div class="form-group">
                            <label style="color:hotpink;" for="name" class="control-label"> Description</label>
                            <textarea class="form-control" id="descr" name="descr" rows="3"	 placeholder="Give a brief description about the target"></textarea>                            
                        </div>                       
                        <div class="modal-footer">
                   			<button type="button" class="btn" name="refreshOnClose" style="background:grey;color:black" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" id="sav" name="sav">Save</button>
                    			<button type="button" class="btn btn-info" name="goalplus">Add another goal</button>
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>

 
<div id="r1comment" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body">
                 <form role="form" method="POST" action="">
                 							              
                        <div class="form-group">
                        	<input type="hidden"  name="hiddenid" id="hiddenid">
                            <label style="color:hotpink;" class="control-label"> The Goal is categorised as:</label>
									<P class="form-control-static">Organizational/Project Contribution</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">Goal Description</label>
									<P class="form-control-static">The goal description goes here...</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">Goal Measure</label>
									<P class="form-control-static">fcn nf,dm nfd,v,dfirewliwjwle</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">the weight given to the goal</label>
									<P class="form-control-static">20</P>
                        </div>
								<div class="form-group">
                          <label style="color:hotpink;" class="control-label">The Goal target period is</label>
									<P class="form-control-static">Quarterly</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" for="name" class="control-label">Your Comment/ suggestion</label>
                            <textarea class="form-control" id="r1c" name="r1c" rows="3"></textarea>
                        </div>
								<div class="form-group">
									<label style="color:hotpink;marging-left:-5pxpx;" class="col-lg-2 pull-left control-label">Rating</label>								
                             <div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-4 green" id="r1dsv" name="0"></div>                            
                        </div>
                         <br><br>                    
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" name="sav"><i class="fa fa-save"></i>&nbsp&nbsp Save</button> 
                    			<button type="button" class="btn btn-info" name="nxt"><i class="fa fa-space-shuttle"></i>&nbsp&nbsp Next</button>
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>
 
  
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
                            <label style="color:hotpink;" class="control-label"> The Goal is categorised as:</label>
									 <P class="form-control-static">Organizational/Project Contribution</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" for="name" class="control-label">Goal Description</label>
									<P class="form-control-static">The goal description goes here...</P>
                        </div>
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">Goal measure</label>
									<P class="form-control-static">fcn nf,dm nfd,v,dfirewliwjwle</P>
                        </div>
                        <div class="form-group">
                           <label style="color:hotpink;" class="control-label">the weight given to the goal</label>
									<P class="form-control-static">20</P>
                        </div>
								<div class="form-group">
                          <label style="color:hotpink;" class="control-label">The Goal target period is</label>
									<P class="form-control-static">Quarterly</P>									
                        </div>
								<div class="form-group">
                          <label style="color:hotpink;" class="control-label">Manager's Comments</label>
									<P class="form-control-static">nbmf sdfdfsdfsdffsdf g fsd dfsdfs  tyj dsg we</P>									
                        </div> 
								<div class="form-group">
                          <label style="color:hotpink;" class="control-label">Manager's Rating</label>
									<P class="form-control-static">E</P>									
                        </div>                                               
                        <div class="form-group">
                            <label style="color:hotpink;" class="control-label">Comments</label>
                            <textarea class="form-control" id="msrment" name="msrment" rows="3" placeholder="Add your suggestions/comments here.."></textarea>
                        </div>                                            
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    			<button type="submit" class="btn btn-primary" name="sav"><i class="fa fa-save"></i>&nbsp&nbspSave</button> 
                    			<button type="button" class="btn btn-info" name="nxt"><i class="fa fa-space-shuttle"></i>&nbsp&nbspNext</button>
                       </div>  
                    </form>             
                </div>
            </div>
        </div>
    </div>
    
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
   Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <!--<script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>-->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
 <link href="bootstrap-toggle-master/css/bootstrap2-toggle.min.css" rel="stylesheet">    

<script type="text/javascript" >
var rv={"":0,"E-":1,"E- mid":2,"E- high":3,"E":4,"E mid":5,"E high":6,"E+":7,"E+ mid":8,"E+ high":9,"X":10};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({
	min:1,
	max:10});
	

// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','','','E','','','E+','','','X'],  
    prefix: "",  
    suffix: ""
   });
$('#ds').slider( "option", "value",rv[$('#ds').attr("name")]); //to set slider value

});

</script>

<script type="text/javascript" >
var inc1=1;
var inc2=1;
var inc3=1;
var inc4=1;
var inc5=1;

$("[name=del]").click(function(event){
	$("#addGoal").modal('show');	
});  

$("[name=qual]").click(function(event){
	$("#addGoal").modal('show');	
});  

$("[name=comp]").click(function(event){
		$("#addGoal").modal('show');	
});  

$("[name=orgcon]").click(function(event){
		$("#addGoal").modal('show');	
});  

$("[name=valadd]").click(function(event){
		$("#addGoal").modal('show');	
});  

$('[name=addgoals]').on("click",function()
{
	$("#addGoal").modal('show');	
});
	
$('.r2c').on("click",function()
{
	$("#r2comment").modal('show');	
});

function goback()
{
	window.location.href="gmanagerlist.php";	
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
