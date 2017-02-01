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
.ag
{
margin-right:20px;
background-color:salmon;
border:white	
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
     <h3>Employee Name [ Time Period]</h3>  <br>
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
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                   </td>
	                 </tr> 									               
 		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                   </td>
	                 </tr> 									                							
					  </tbody>
					  </table>

                 <label class=" col-lg-3 pull-left"><b>weightage</b></label>              
                 <p class="form-class-static">40%</p>
					<br>
					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
         	   <p class="form-contrl-static">37  (out of 40)</p>
         
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
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Postponed</td>
	                   </td>
	                 </tr> 									               
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                   </td>
	                 </tr> 									               
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                   </td>
	                 </tr> 									                			 				 						           
						</tbody>
			      </table>

				    <label class=" col-lg-3 pull-left"><b>weightage</b></label>
				     <p class="form-class-static">30%</p>              
						<br>					
					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
         	   <p class="form-contrl-static">25  (out of 30)</p>			
					 			
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
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                   </td>
	                </tr>
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Postponed</td>
	                   </td>
	                 </tr> 									               									               
					  </tbody>
			      </table>

					    <label class=" col-lg-3 pull-left"><b>weightage</b></label>
					     <p class="form-class-static">30%</p>                
					<!--  <input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="Wt" name="wt">40%</input>-->
					 <br>					 					
					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
	         	   <p class="form-contrl-static">25  (out of 30)</p>							
									
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
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                 </tr> 									               
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                 </tr> 									                				 						           
					  </tbody>
					  </table>	


				    <label class=" col-lg-3 pull-left"><b>weightage</b></label>              
				     <p class="form-class-static">5%</p>  
					<br>
					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
         	   <p class="form-contrl-static">5  (out of 5)</p>			
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
		             <tr>
		               <td>cd vcv cvccvxcv bfg hnbvnv gfdigujdfksd</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td> rewfdtrg jhbnm bnmnbmbnmbn</td>
							<td> fdrfvcbnb mbnmbnmn bnm nb jkjmbnmbn</td>
							<td>Completed</td>
	                 </tr> 									                						           
					  </tbody>
			      </table>

					    <label class=" col-lg-3 pull-left"><b>weightage</b></label>              
					     <p class="form-class-static">5%</p>  
					<br>
					 <label class="col-lg-3 pull-left"><b>Accomplished Weightage</b></label>
         	   <p class="form-contrl-static">4  (out of 5)</p>			
	         </div>
		    </div>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
  	        	   <label class=" col-lg-3 pull-left"><b>Cumulative Accomlished Weightage</b></label>
         	   <p class="form-contrl-static">89  (out of 100)</p>
         	   <br><br>   
         	   <label class=" col-lg-3 pull-left"><b>Reviewer2 Comments</b></label>
         	   <textarea rows="4" cols="100" maxlength="500" placeholder="Your comments here..."></textarea>  
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
   <b>Contact :Pax Sustenance (internal-tools@paxterrasolutions.com)</b>
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
var rv={"":0,"0":1,"25":2,"50":3,"75":4,"100":5,"E high":6,"E+":7,"E+ mid":8,"E+ high":9,"X":10};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({
	min:1,
	max:5});
	

// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['0%','25%','50%','75%','100%'],  
    prefix: "",  
    suffix: ""
   });
$('#ds1').slider( "option", "value",rv[$('#ds1').attr("name")]); //to set slider value
$('#ds2').slider( "option", "value",rv[$('#ds2').attr("name")]); //to set slider value
$('#ds3').slider( "option", "value",rv[$('#ds3').attr("name")]); //to set slider value
$('#ds4').slider( "option", "value",rv[$('#ds4').attr("name")]); //to set slider value
$('#ds5').slider( "option", "value",rv[$('#ds5').attr("name")]); //to set slider value
});

</script>

<script type="text/javascript" >
function goback()
{
	window.location.href="gmanagerlist.php";	
}

<!--
sjQuery('<a/>', {
    id: 'foo',
    href: 'http://google.com',
    title: 'Become a Googler',
    rel: 'external',
    text: 'Go to Google!'
}).appendTo('#deliverables'); 
-->

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
