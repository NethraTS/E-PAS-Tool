<?php
session_start();
include session_timeout.php;
require('auth.php');
include 'secure.php';
include 'checkGRRstatus.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 

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
p
{
word-wrap: break-word;
min-width: 80px;
max-width: 300px;
}

</style>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
$active=$_GET["active"];

$eid=$_GET['eid'];
//$eid="343";
$st=checkstatus($eid);
$doc=$c->findOne(array("id"=>$eid));
//$st="Yes";
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

?>

  <section id="container" >
   <?php include 'headerandsidebar.php'; ?>    	       	  
         
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
 <table> 
 <tr><td>
<?php   
     echo '<h3>'.$doc["id"].'- '.$doc["name"];?></td></tr>
     
     <tr><td>
<?php echo 'Type: '.$doc["gType"].' Goals <br> <br> <p> Overall Weightage : 100 <class="form-class-static" id="Cweight"></p>';
?></td><td>
<?php
echo '<div class="col-lg-11">';
echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th><center>Deliverables</center></th><th><center>Quality</center></th><th><center>Initiatives/ Ownership</center></th><th><center>Organizational/ Project Contribution</center></th><th><center>Strategic Planning /Value Addition</center></th></tr>';
echo '<tr><td><center>'.$doc['gWtshr']['delhr'].'%</center></td><td><center>'.$doc['gWtshr']['qualhr'].'%</center></td><td><center>'.$doc['gWtshr']['comphr'].'%</center></td><td><center>'.$doc['gWtshr']['orgconthr'].'%</center></td><td><center>'.$doc['gWtshr']['valaddhr'].'%</center></td></tr>';
echo '</table>';
echo '</div>';
?></td><td>
  	 <?php
if($active!="emp")
{ 	
  	 	echo '<button class="btn btn-sm btn-theme03 pull-right" id ="back" style="margin-right:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
 	  ';
}
?>
  	   </td>
  </tr>
</table>
  		<!--<button class="btn ag btn-sm btn-theme04 pull-right" name="addGoals">
  	        <i class="fa fa-cogs"></i>&nbsp&nbsp Add Goals
  	   </button>-->

		
  	  

<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  <?php 
 			if($doc['gWts']['del']>=0)
 			{    	
    	?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       
                     <!--  <th>Description</th> --> 
                                                <th>Specifics</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th> 
                        <th>Status</th>                                                                							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
 	elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
	  	 		echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-1"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1">'.decrypt($doc["Deliverables"][$j]["status"]).'</td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
}  	
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Goals Not Eligible for review in this cycle...</b></td></tr>";
}
?>

					  </tbody>
					  </table>

<?php 
if($st=="Yes")
{
	if($doc["rFlag"]>="4")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["del"].'</p></b>';
		echo '<br>';
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.decrypt($doc["AccWeightage"]["deliverables"]).'</p></b>';*/
	}
}
?>

<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Feedback</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php

/*
if($doc['r1overallcomment']=="")
{
echo "No Feebacks Entered";	break;
}
else 
{ */
foreach($doc['r1overallcomment'] as $v1)							
{
		$b[]=$v1["date"];
}										
		$a[]=(array_unique($b));
		(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{


foreach($doc['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date']&&$v1["goal"]=="Deliverables:")
	{

echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 


echo '<br><b>Measurement</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
echo '</li>';		
		}
}


//var_dump($doc['r1overallcomment']);
}
//}



?>
			</div>
		</div>
	</div>



	         </div>
		    </div>
<?php
 }        
//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));
         	
         	 			if($doc['gWts']['qual']>=0)
			{			
			 ?>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                      
                      <!--    <th>Description</th> --> 
                                                <th>Specifics</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>  
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
	  	 		echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-1"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Quality"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1">'.decrypt($doc["Quality"][$j]["status"]).'</td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Goals Not Eligible for review in this cycle...</b></td></tr>";
}
?>
						</tbody>
			      </table>


<?php 
if($st=="Yes")
{
	if($doc["rFlag"]>="4")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';
		echo '<br>';
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.decrypt($doc["AccWeightage"]["quality"]).'</p></b>';*/
	}
}
?>

<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> Feedback</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php

/*
if($doc['r1overallcomment']=="")
{
echo "No Feebacks Entered";	break;
}
else 
{ */
foreach($doc['r1overallcomment'] as $v1)							
{
		$b[]=$v1["date"];
}										
		$a[]=(array_unique($b));
		(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{


foreach($doc['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date']&&$v1["goal"]=="Quality:")
	{

echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 


echo '<br><b>Measurement</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
echo '</li>';		
		}
}


//var_dump($doc['r1overallcomment']);
}
//}



?>
			</div>
		</div>
	</div>


	         </div>
		    </div>
<?php
		}
		//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       
                        <!--  <th>Description</th> --> 
                                                <th>Specifics</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
		           
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
	  	 	echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom"   data-content="'.decrypt($doc["Competency"][$j]["descr"]).'" >'.decrypt($doc["Competency"][$j]["msrmt"]).'</a></p></td>';
  			//echo '<td class="col-lg-1"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-2"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1">'.decrypt($doc["Competency"][$j]["status"]).'</td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Goals Not Eligible for review in this cycle...</b></td></tr>";
}
?>								               									               
					  </tbody>
			      </table>

<?php 
if($st=="Yes")
{
	if($doc["rFlag"]>="4")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';
		echo '<br>';		
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.decrypt($doc["AccWeightage"]["competency"]).'</p></b>';*/
	}
}
?>				
<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Feedback</a>
			</h4>
		</div>
		<div id="collapseThree" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php

/*
if($doc['r1overallcomment']=="")
{
echo "No Feebacks Entered";	break;
}
else 
{ */
foreach($doc['r1overallcomment'] as $v1)							
{
		$b[]=$v1["date"];
}										
		$a[]=(array_unique($b));
		(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{


foreach($doc['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date']&&$v1["goal"]=="Initiatives/ Ownership:")
	{

echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 


echo '<br><b>Measurement</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
echo '</li>';		
		}
}


//var_dump($doc['r1overallcomment']);
}
//}



?>
			</div>
		</div>
	</div>


				
			    </div>
		    </div>
<?php
		}
		//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       
                    <!--    <th>Description</th> --> 
                                                <th>Specifics</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Objective Met","Objective Not Met","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["OrgContribution"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
		
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
	  	 	echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom"   data-content="'.decrypt($doc["OrgContribution"][$j]["descr"]).'" >'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-1"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-2"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1">'.decrypt($doc["OrgContribution"][$j]["status"]).'</td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Goals Not Eligible for review in this cycle...</b></td></tr>";
}
?>							                				 						           
					  </tbody>
					  </table>	

<?php 
if($st=="Yes")
{
	if($doc["rFlag"]>="4")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';
		echo '<br>';
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.decrypt($doc["AccWeightage"]["organisationalContribution"]).'</p></b>';*/
	}
}
?>

<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Contribution Feedback</a>
			</h4>
		</div>
		<div id="collapseFour" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php

/*
if($doc['r1overallcomment']=="")
{
echo "No Feebacks Entered";	break;
}

else 
{ */
//	var_dump();
foreach($doc['r1overallcomment'] as $v1)							
{
		$b[]=$v1["date"];
}										
		$a[]=(array_unique($b));
		(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{


foreach($doc['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date']&&$v1["goal"]=="Organizational/ Project Contribution:")
	{

echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 


echo '<br><b>Measurement</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
echo '</li>';		
		}
}


//var_dump($doc['r1overallcomment']);
}
//}



?>
			</div>
		</div>
	</div>

	         </div>
		    </div>
<?php
			}
		//	$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       
                       <!-- <th>Description</th> --> 
                                                <th>Specifics</th>
                        <th>Employee Comment</th>
                        <th>Reviewer 1 Comment</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["ValueAddition"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
	  	 		echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom"   data-content="'.decrypt($doc["ValueAddition"][$j]["descr"]).'" >'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</a></p></td>';
  			//echo '<td class="col-lg-1"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</p></td>';
  			
  			echo '<td class="col-lg-2"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1">'.decrypt($doc["ValueAddition"][$j]["status"]).'</td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Goals Not Eligible for review in this cycle...</b></td></tr>";
}
?>							                						           
					  </tbody>
			      </table>

<?php
if($st=="Yes")
{
	if($doc["rFlag"]>="4")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';
		echo '<br>';		
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.decrypt($doc["AccWeightage"]["valueAddition"]).'</p></b>';*/
	}
}
?>

	         </div>
		    </div>
<?php } ?>

<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Training</h4>             	  
		         <table class="table" id="training">
		           <thead>
							<tr>
                                                                                     							
                        <th>Training Name</th>    
                        <!--<th>Training Date</th>-->
                       <th>Training Quarter</th> 
                                    <th>Status</th>                                                            							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]<"4")
	{
		echo "<tr><td><b style='color:lightpink'>Review by Manager still pending...</b></td></tr>";
	}
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["training"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
			//echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';	  		
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  		
  			echo '</tr>';
			$dc++;
  	 	}
  	 }   	
  	 if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Training Not  set for this category...</b></td></tr>";  	
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Training Not set for this category...</b></td></tr>";
}
?>							                						           
					  </tbody>
			      </table>

<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Feedback</a>
			</h4>
		</div>
		<div id="collapseFive" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php



foreach($doc['r1overallcomment'] as $v1)							
{
		$b[]=$v1["date"];
}										
		$a[]=(array_unique($b));
		(sort($a[0]));				
//var_dump($a[0]);
//var_dump($b);

for($i=count($a[0]);$i>=0;$i--)				
{


foreach($doc['r1overallcomment'] as $v1)
{
	if($a[0][$i]==$v1['date']&&$v1["goal"]=="Strategic Planning /Value Addition:")
	{

echo '<li class="list-group-item">';
echo '<b>'.$a[0][$i].'</b><br>'; 


echo '<br><b>Measurement</b> : '.$v1['measure'];
echo '<br><b>Comment</b> : '.$v1['comment']; 
echo '<br>'	;	
echo '</li>';		
		}
}


//var_dump($doc['r1overallcomment']);
}




?>
			</div>
		</div>
	</div>

	         </div>
		    </div>


	  	<div class="col-lg-12" style="padding-bottom:20px;height:" id="en"> 
        	<div class="content-panel " >
    	<div class="row" style="padding:10px">
        	<!--  	 <label class="col-lg-3 pull-left"><b>Cumulative Accomplished Weightage</b></label> -->
<?php
//if($doc["rFlag"]>="4")
	//echo '<p class="form-class-static" id="Cweight">'.decrypt($doc["totalAccWt"]).'</p><br><br>';
?>
				 
				  <label class="col-lg-3 pull-left"><b>Reviewer 1 Feedback</b></label>
				  <div class="col-lg-8">
<?php
if($doc["rFlag"]>="4")
	echo '<p class="static-form-control" id="r1feedback" style="max-width:800px;">'.decrypt($doc["r1feedback"]).'</p><br>';
?>
				</div>
				
 			 <label class="col-lg-3 pull-left"><b>Reviewer 2 Feedback</b></label>
				  <div class="col-lg-8" >				
<?php 
if($doc["rFlag"]=="4")
	echo '<textarea rows="4" name="comment" cols="60" maxlength="500" onkeypress="return onlyAlphabets(event,this)" id="r2feedback"></textarea>';
elseif($doc["rFlag"]=="5")
	echo '<textarea rows="4" name="comment" cols="60" maxlength="500" onkeypress="return onlyAlphabets(event,this)" id="r2feedback">'.decrypt($doc["r2feedback"]).'</textarea>';
elseif($doc["rFlag"]>="6")
	echo '<p class="static-form-control" id="r1feedback" style="max-width:800px;">'.decrypt($doc["r2feedback"]).'</p><br>';
?>
		
					</div>	
				</div>
         </div>
       </div> 
	 </div>

<!--button-->
		  <div class="row mt" id="btns">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left" onclick="sav()">
                  <i class="fa  fa-save"></i>&nbsp&nbsp Save
                </button>
               </div> 
               <div class="col-lg-6">
               <button type="button" class="btn btn-sm btn-theme03"  onclick="window.location.href='gmanagerlist.php?active=r2'">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
                <button class="btn btn-theme03 pull-right" onclick="sub()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Submit
                </button>
               </div> 
            </div>
          </div>
         </div>
         
     <?php   if($doc["rFlag"]>="6") 
     { ?>  
         <div class="row mt" id="btns1">
       	
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         
               <div class="col-lg-6">
               <button type="button" class="btn btn-sm btn-theme03 pull-right"  onclick="window.location.href='gmanagerlist.php?active=r2'">
  	        <i class="fa fa-backward"></i>&nbsp&nbsp Back
  	   </button>
                
               </div> 
            </div>
          </div>
         </div>
         
         <?php } ?>
         
         
         
		</section><! --/wrapper -->

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
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>-->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
 <link href="bootstrap-toggle-master/css/bootstrap2-toggle.min.css" rel="stylesheet">    

 <script>$(function () 
      { $("[data-toggle='popover']").popover();
      $(".pop").popover({ trigger: "hover" });
      });
   </script>

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
var st="<?php echo $st; ?>";
var fl="<?php echo $doc['rFlag']; ?>";
//alert(fl);
if(st=="No" || fl< "4")
	$('#en').hide();

if(fl>=6 || fl<4 || st=="No")
	$('#btns').hide();

</script>

<script type="text/javascript">
var t;
function goback()
{
	window.location.href="gmanagerlist.php?active=r2";	
}

function sav()
{
		var comm,comm1;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
	if(choice1.trim().length<=25)
	comm1="lesschar";
	
} 
 
		{	
	t=0;
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	columnvalue[columnvalue.length]=$('#r2feedback').val();		
	for (i=0;i<columnvalue.length;i++)
		{		
			postdata[i]=columnvalue[i];
		}
	unique=JSON.stringify(postdata);
	//alert(unique);
	$.ajax({ 
			url:'gr2commtinsert.php', 
			type:'POST', 
			data:{json:unique}, 
			success:function(data){ 
				//$("#myModal1").modal('show'); 
				alert("Saved Successfully!");
				t=1;				
				//alert(data); 
			}, 
			error:function(xhr,desc,err){ 
				alert(err); 
			} 
		});		
		columnvalue=[];
		//return true;		
}
}

function onlyAlphabets(e, t) {
	var len=t.value.length;
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) ||charCode==8 ||charCode==46||charCode==47||(charCode >= 48 && charCode <= 57)||charCode==13||charCode==32||charCode==40||charCode==41||charCode==92 ||charCode==44||charCode==34||charCode==39||charCode==64||charCode==33||charCode==58)
                {
                	if(len==250)
                	{
                		if(charCode==8)
                		{
                			return true;	
                		}
                		else
                		{
                		alert('Only 250 characters allowed');
                		return false;
                		}	
                	}
                	else
                	{
                    return true;
                   }
                 }
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }	
function sav1()
{
	var comm,comm1;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
	if(choice1.trim().length<=25)
	comm1="lesschar";
	
} 
 
		{	
	t=0;
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	columnvalue[columnvalue.length]=$('#r2feedback').val();		
	for (i=0;i<columnvalue.length;i++)
		{		
			postdata[i]=columnvalue[i];
		}
	unique=JSON.stringify(postdata);
	//alert(unique);
	$.ajax({ 
			url:'gr2commtinsert.php', 
			type:'POST', 
			data:{json:unique}, 
			success:function(data){ 
				//$("#myModal1").modal('show'); 
				//alert("Saved Successfully!");
				t=1;				
				//alert(data); 
			}, 
			error:function(xhr,desc,err){ 
				alert(err); 
			} 
		});		
		columnvalue=[];
		return true;		
}
}


function sub()
{
	if(sav1())
	{	
	var r=confirm("No changes can be made after 'submit'. Do you want to proceed with changes?");
	if (r==true) {	
		//if(t==1)
		{
			//sav();
			var eid="<?php echo $eid; ?>";
			$.ajax({ 
				url:'gr2commtsubmit.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Submitted Successfully and Redirecting to Goals Overview");
					window.location.href="gmanagerlist.php?active=r2";	
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
		}
	}
}}		
</script>




<script type="text/javascript">

function check()
{
var role="<?php echo $role; ?>";
if ( role.indexOf("emp") > -1 ) 
	window.location.href="selfassessmentform.php";
else 
  alert("You are not part of this review cycle.");
}
</script>
<!--
jQuery('<a/>', {
    id: 'foo',
    href: 'http://google.com',
    title: 'Become a Googler',
    rel: 'external',
    text: 'Go to Google!'
}).appendTo('#deliverables'); 
-->
</body>
</html>
