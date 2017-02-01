<?php
session_start();include session_timeout.php;
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  <?php include 'stylesheets.php'; ?>

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
<html><marquee direction="left" loop="50" width="80%" ><font color="green"> * To start a new cycle the exixting cycle should be closed. </font></marquee></html>        
          		<div class="col-lg-12">

<center> 
<br><br><br><br><br><br><br><br><br><br>

<?php
$a=$coll->find()->count();
$b=$coll->find(array("flag2"=>"11"))->count();
if($a==$b)
{
	?>
<button type="button" class="btn btn-lg btn-theme03" data-toggle="modal" data-target="#conf"><i class="fa fa-clock-o"></i>&nbsp&nbsp&nbspStart A New Review Cycle</button>

<?php
}
else
 {

?>
<button type="button" class="btn btn-lg btn-theme03" data-toggle="modal" data-target="#conf"  disabled="disabled"><i class="fa fa-clock-o" ></i>&nbsp&nbsp&nbspStart A New Review Cycle</button>
<?php
}
?>

</center>

          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
<div id="message" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          

							<center><h5><p id="ms"></p></h5></center>
                 
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>  
                </div>
            </div>
        </div>
    </div>

<div id="conf" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">          
							<center><h5><p id="cf">
Starting a new Review Cycle will move current records to History and destory the current cycle. Are you sure?							
							</p></h5></center>
                        <div class="modal-footer">
                   			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   			<button type="button" class="btn btn-default" data-dismiss="modal" name="confirm" onclick="startacycle()">OK</button>
                       </div>
                </div>
            </div>
        </div>
    </div>


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

    <!--script for this page-->
   
   
<script type="text/javascript" >
function startacycle()
{
$.ajax({ 
url:'resetdb.php', 
type:'POST', 
success:function(data){ 
document.getElementById("ms").innerHTML=data;	
$("#message").modal('show');
//alert(data); 
}, 
error:function(xhr,desc,err){ 
alert(err); 
} 
});
}
</script> 

<script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
