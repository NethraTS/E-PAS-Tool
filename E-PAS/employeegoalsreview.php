<?php
session_start();include session_timeout.php;
include 'secure.php';
include 'checkGRRstatus.php';
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
p
{
word-wrap: break-word;
min-width: 80px;
max-width: 300px;
}
td
{
	text-align: left;
}
</style>
 </head>
 
<?php
$m=new MongoClient();
$db=$m->goals1;
$GR=$db->GoalsToBeReviewed;
$c=$db->currentGoalCycle;
//$eid=$_GET['eid'];
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$eid=$psiid;
$eid=$_SESSION['psiid'];
$st=checkstatus($eid);

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


$doc=$GR->findOne(array("id"=>$eid));
$flag=$doc['flag'];
//echo $st;
//$st="Yes";
if($st=="No"||$doc['flag']<3)
{
header('Location:employeegoals.php'); 
}
?>
 <body onload="a(<?php echo $flag ?> )">
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
/*if($active!="emp")
{ 	
  	 	echo '<button class="btn btn-sm btn-theme03 pull-right" id ="back" style="margin-right:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
 	  ';
} */
echo '<button class="btn btn-sm btn-theme03 pull-right" id ="back" style="margin-right:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
 	  ';
?>
  	   </td>
  </tr>
</table>

<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  <?php 
 			if($doc['gWts']['del']>=0)
 			{    	
    	?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	        <h4>Deliverables</h4>                                        	                	           	            	  
		         <table class="table table-hover table-striped" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       <th>Description</th> 
                                                <th>Specifics</th>
                        <th>My Accomplishments</th>                                                                                   							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
	echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}   	
  	 	if($dc==0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="1")
	{
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Deliverables"][$j]["employeecomment"]).'</textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}   	
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	elseif($doc["rFlag"]>="2")
	{
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["employeecomment"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}   	
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
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
	   $eid=$_SESSION['psiid'];
		$doc=$GR->findOne(array("id"=>$eid));
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["del"].'</p></b>';
}
?>					  
	         </div>
		    </div>
<?php } 
$eid=$psiid;
$doc=$GR->findOne(array("id"=>$eid));
         	
         	 			if($doc['gWts']['qual']>=0)
			{			
?> 

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table table-hover table-striped" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                       
                           <th>Description</th> 
                                                <th>Specifics</th>
                   
                        <th>My Accomplishments</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
	$maxm=count($doc["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
	echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
	}
	elseif($doc["rFlag"]=="1")
	{
	$maxm=count($doc["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
	}
	elseif($doc["rFlag"]>="2")
	{
	$maxm=count($doc["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">NA</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
	}
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
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';	
}
?>
	         </div>
		    </div>
<?php 
}
$eid=$psiid;
$doc=$GR->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']>=0)
			{
?>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4>Initiatives/ Ownership</h4>             	  
         	   <table class="table table-hover table-striped" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                       
                           <th>Description</th> 
                                                <th>Specifics</th>
                   
                        <th>My Accomplishments</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
	$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
		echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"> <textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="1")
	{
	$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	elseif($doc["rFlag"]>="2")
	{
	$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Competency"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
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
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';
}
?>          
			    </div>
		    </div>
<?php
		}
$eid=$psiid;
$doc=$GR->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']>=0)
			{			
			 ?>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4>Organizational/ Project Contribution</h4>             	             	  
		         <table class="table table-hover table-striped" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        
                           <th>Description</th> 
                                                <th>Specifics</th>
                   
                       <th>My Accomplishments</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
	$maxm=count($doc["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';	
  			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";	  	
	}
	elseif($doc["rFlag"]=="1")
	{
	$maxm=count($doc["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</textarea></td>';	
  			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";	  	
	}
	elseif($doc["rFlag"]>="2")
	{
	$maxm=count($doc["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</p></td>';
  			echo '</tr>';
			$dc++;
  	 	} 
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";	  	
	}
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
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';
}

?>
	         </div>
		    </div>
<?php
			}
$eid=$psiid;
$doc=$GR->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']>=0)
			{			
			 ?>

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Strategic Planning /Value Addition</h4>             	  
		         <table class="table table-hover table-striped" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th> 
                                                <th>Specifics</th>
                   
                        <th>My Accomplishments</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
	$maxm=count($doc["ValueAddition"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  					echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";   	
	}
	elseif($doc["rFlag"]=="1")
	{
	$maxm=count($doc["ValueAddition"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo'<td class="col-lg-3"><textarea rows="5" cols="40" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</textarea></td>';	
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";   	
	}
	elseif($doc["rFlag"]>="2")
	{
	$maxm=count($doc["ValueAddition"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-3"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</p></td>';
  			echo '<td class="col-lg-3"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</p></td>';
			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";   	
	}
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
	echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
	echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';
}
?>
	         </div>
		    </div>
<?php } ?>
<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Trainings</h4>             	  
		         <table class="table table-hover table-striped" id="training">
		           <thead>
							<tr>
                      <th>Training Name</th>
                    <!--  <th></th>-->
                       <th>Training Quarter</th>
                       <th>Status</th>
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Finished","Not Finished");
if($st=="Yes")
{
	if($doc["rFlag"]=="0")
	{
	$maxm=count($doc["training"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
		//	echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';	
		echo '<td>';
  			echo '<select class="gtype" id="dsta" name="tstatus" >';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 		  			
  			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Training Not  set for this category...</b></td></tr>";   	
	}
	elseif($doc["rFlag"]=="1")
	{
	$maxm=count($doc["training"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
		//	echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';  			
  				echo '<td>';
  			echo '<select class="gtype" id="dsta" name="tstatus" >';
			echo '<option>'.$doc["training"][$j]["traindate"].'</option>';  			
  			foreach($gstatus as $k)	
	     	{
	     		if(($doc["training"][$j]["traindate"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	      echo '</select></td>';	 		  			
  			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Training Not  set for this category...</b></td></tr>";   	
	}
	elseif($doc["rFlag"]>="2")
	{
	$maxm=count($doc["training"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["Training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
			//echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';  			
  			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>'; 
  			echo '</tr>';
			$dc++;
  	 	}
  	 	if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Training Not  set for this category...</b></td></tr>";   	
	}
}
elseif($st=="No")
{
		echo "<tr><td><b style='color:lightpink'>Training Not  set for this category...</b></td></tr>";
}
?>						                						           
					  </tbody>
			      </table>


	         </div>
		    </div>



	 </div>

<!--button-->
<?php if($st=="Yes")
{?>
		  <div class="row mt" id="revBtns">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:50px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left" onclick="sav()">
                  <i class="fa  fa-save"></i>&nbsp&nbsp Save
                </button>
               </div> 
                <div class="col-lg-6">
                <button class="btn btn-theme03 pull-right" onclick="sub()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Submit
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
var t;
var fl='<?php echo $doc["flag"]; ?>';
if(fl==2)
 { 
	$('#agrmnt').show(); 
 }

var rfl='<?php echo $doc["rFlag"]; ?>';
if(rfl==""||typeof(rfl)=='undefined')
{
	$('#revBtns').hide();
	}

if(rfl>=2)
{
	$('#revBtns').hide();
}
</script>

<script type="text/javascript" >
var t1;
function goback()
{
	window.location.href="dashoboard.php";	
}
function onlyAlphabets(e,t) {
	var len=t.value.length;
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) ||charCode==8 ||charCode==46||charCode==47||(charCode >= 48 && charCode <=57)||charCode==13||charCode==32||charCode==40||charCode==41||charCode==92||charCode==44||charCode==34||charCode==39||charCode==64||charCode==33||charCode==58 )
                {
                	if(len==250)
                	{
                		if(charCode==8)
                		{
                			return true;	
                		}
                		else
                		{
                		alert('Only 25 characters allowed');
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
		var comm,comm1,comm2;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	{
	comm="none";
	}
	if(choice1.trim().length<=25)
	{
		comm1="lesschar";
	}
} 
var course_choices = $('select[name="tstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	
	if(choice1=="Select")
	{
	comm2="Select";
   } 
   }
if(comm=="none")
		{
			alert("Please enter all comments"); return false;
		}
		else if(comm1=="lesschar")
		{
			alert("Please enter more than 25 characters in comment box.");return false;
		}
		else if(comm2=="Select")
		{
			
			alert("Please select the training status!!");
			return false;
		}
		else
		{	
	
	t=0;
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#training tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				//columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'gempcommtinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
				//	alert("Saved Successfully!");
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

function sav()
{
	var comm,comm1,comm2;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	{
	comm="none";
	}
	if(choice1.trim().length<=25)
	{
		comm1="lesschar";
	}
} 
var course_choices = $('select[name="tstatus"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	//alert(choice1);
	if(choice1=="Select")
	{
	comm2="none";
	}
	
} 

//if(comm=="none")
		{//alert("Please enter all comments");
		}
	//	else if(comm1=="lesschar")
		{//alert("Please enter more than 25 characters in comment box.");
		}
		//else if(comm2=="none")
		{//alert("Please select the training status!!");
		}
		//else
		{	
	t=0;
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
					//columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
			});
			$("#training tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				//columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'gempcommtinsert.php', 
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
		}}
function a(t)
{
t1=t;	
//alert(t1);
	
	}



function sub()
{

	if(sav1())
	{
		
	var r=confirm("No changes can be made after 'submit'. Are you sure?");
	if (r==true) {	
		//if(t1==3)
		{
			var eid="<?php echo $eid; ?>";
			$.ajax({ 
				url:'gempcommtsubmit.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Submitted Successfully redirecting to dashboard");
					window.location.href="dashoboard.php";	
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});	
		}
	}
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
</script>

</body>
</html>
