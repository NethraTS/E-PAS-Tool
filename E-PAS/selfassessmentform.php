<?php
session_start();include session_timeout.php;
include 'secure.php';
require('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
 
   <?php include 'stylesheets.php'; ?>
   
       <link href="Gritter-master/css/jquery.gritter.css" rel="stylesheet">

<!--slider and pips-->
     <link rel="stylesheet" href="slider/jquery-ui.css"> 
		<script src="slider/jquery-1.10.2.js"></script> 
		<script src="slider/jquery-ui.js"></script>
		<link rel="stylesheet" href="slider/jquery-ui-slider-pips.css">
		<script type="text/javascript" src="slider/jquery-ui-slider-pips.js" ></script> 

<style >textarea { width: 100%; }</style>

<script type="text/javascript" >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script>
var ar={"":0,"E-":1,"E":2,"E+":3,"X":4};
$(function() {

// First of all attach a slider to an element.
$('.slider').slider({min:1,max:4});

$('#dsv').slider( "option", "value",ar[$('#dsv').attr("name")]); //to set slider value
$('#qsv').slider( "option", "value",ar[$('#qsv').attr("name")]); //to set slider value
$('#csv').slider( "option", "value",ar[$('#csv').attr("name")]); //to set slider value
$('#ocsv').slider( "option", "value",ar[$('#ocsv').attr("name")]); //to set slider value
$('#vasv').slider( "option", "value",ar[$('#vasv').attr("name")]); //to set slider value

// Then you can give it pips and labels!  
$('.slider').slider('pips', {  
    first: 'label',  
    last: 'label',  
    rest: 'label',  
    labels: ['E-','E','E+','X'],  
    prefix: "",  
    suffix: ""      
	});

});
</script>

</head>

<body>
<?php

$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$fl=$db->deadlineFlags;
$n=$db->Notifications;
$db1=$m->goals1;
$c1=$db1->GoalsToBeReviewed;

//$eid=$_GET['eid'];
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$doc1=$c1->findOne(array("id"=>$psiid));
$doc=$bd->findOne(array("psiid"=>$psiid));


$d=$c->findOne(array("psiid"=>$_SESSION["psiid"]));

$f=0;

if($d["flag1"]=="0")
{
	$f=0;	
}
elseif($d["flag1"]=="1") 
{
	$f=1;	
}	
elseif($d["flag1"]>="2")
{
	$f=2;	
}

$postponed=0;
$msg=0;
$SADFObj=$fl->findOne(array("name"=>"SAdeadlineOver"));
if($SADFObj["flag"]=="0")
	{}
elseif($SADFObj["flag"]=="1")
{
	$ESADFObj=$fl->findOne(array("name"=>"ESAdeadlineOver"));
	if($ESADFObj["flag"]=="0")
	{
		$deadlineobj=$n->findOne(array("name"=>"ExtendedSelfAppraisals"));
		$msg="The last Date for Self-Appraisal submission is".$deadlineobj["Deadline"].".Please, SUBMIT your competed forms before the aforesaid date.";
	}
	elseif($ESADFObj["flag"]=="1")
	{
		if($d["postponedFlag"]=="1")
		{
			$f=2;
			$postponed=1;
			$msg="Self-Appraisal Deadline has expired.Your Review Process is postponed to the next review cycle."; 	
		}
	}
}

$pod=$n->findOne(array("name"=>"portalOpening"));
$r1=$n->findOne(array("name"=>"review1"));
$today = date("d-m-Y");
$today_time = strtotime($today);
$sadeadline = date('d-m-Y', strtotime('-5 days', strtotime($r1["Deadline"])));
//echo $today;
//echo $pod["Date"];

if (strtotime($pod["Date"]) <= $today_time) 
	$reviewstarted=1;	
else 
	$reviewstarted=0;

if (strtotime($sadeadline) <= $today_time) 
	{
		$deadlineexpired=1;
		$f=2;
	}
else 
	$deadlineexpired=0;

//echo $deadlineexpired;

	

?>

  <section id="container" >

<?php include 'headerandsidebar.php'; ?>    	       	  
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3>Self-Assessment</h3>
          	<p class="pull-right">Page 1</p>
          	<table> 
 <tr><td>
<?php   
      echo '<h3>'.$doc1["id"].'- '.$doc1["name"];?></td></tr>';
     
     <tr><td>
<?php echo 'Type: '.$doc1["gType"].' Goals <br> <br> <p> Overall Weightage : 100 <class="form-class-static" id="Cweight"></p>';
?></td><td>
<?php
echo '<div class="col-lg-11">';
echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th><center>Deliverables</center></th><th><center>Quality</center></th><th><center>Initiatives/ Ownership</center></th><th><center>Organizational/ Project Contribution</center></th><th><center>Strategic Planning /Value Addition</center></th></tr>';
echo '<tr><td><center>'.$doc1['gWtshr']['delhr'].'%</center></td><td><center>'.$doc1['gWtshr']['qualhr'].'%</center></td><td><center>'.$doc1['gWtshr']['comphr'].'%</center></td><td><center>'.$doc1['gWtshr']['orgconthr'].'%</center></td><td><center>'.$doc1['gWtshr']['valaddhr'].'%</center></td></tr>';
echo '</table>';
echo '</div>';
?></td><td></table>
          	<div class="row mt">
          		<div class="col-lg-12">
<?php
if($msg==0)
{}
else {
echo "<h3><center>".$msg."</center></h3>";
}
?>          		
          <!--Place your content here. -->
<!-- first table- deliverables -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4 data-toggle="tooltip" data-placement="top" data-original-title="Deliverable goals should be written around activities that have quantifiable products or services provided upon the completion of the project.">Deliverables</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="deliverables">
		                          <thead>
		                          <tr>
		                             
		                             
		                              <th>Goal</th>
		                              <th>Accomplishment</th> 
		               
		                          </tr>
		                          </thead>
		                          <tbody> 
<?php		                          

if($f==0)
{
	for($i=1;$i<2;$i++)
	{
			$maxm=count($doc1["Deliverables"]);
	//	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
		//echo 'alert("$i")';
		echo '<tr class="rows" id="d'.$i.'">';
		echo '<td><textarea id="area1" rows="4" cols="50" maxlength="200">'.decrypt($doc1["Deliverables"][$j]["msrmt"]).':NA:'.decrypt($doc1["Deliverables"][$j]["defgoal"]).'</textarea></td>';
		echo '<td><textarea id="area2" rows="4" cols="60" maxlength="240">'.decrypt($doc1["Deliverables"][$j]["employeecomment"]).'</textarea></td>';
		echo '</tr>';
		$dc++;		
		}
			if($dc==0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	echo '</tbody>';
	echo '</table>';

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="dsv" name="E-"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow1()">Add Row</button>';
	
}
elseif($f==1)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
   	if($d["appraisal"][$j]["parameter"]=="deliverables")
     {
   	 	echo '<tr class="rows" id="d'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
    if($dc==0)
    {
			echo '<tr class="rows" id="d1">';
			echo '<td><textarea rows="4" cols="50" maxlength="200"></textarea></td>';
			echo '<td><textarea rows="4" cols="60" maxlength="240"></textarea></td>';
			echo '</tr>';
	 }
	echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="dsv" name="'.decrypt($d["selfRatings"]["deliverables"]).'"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow1()">Add Row</button>';
	echo '<button type="button" class="btn btn-sm btn-info pull-left" onclick="RemoveaRow()" id="removeRow">Remove a Row</button>';
}
elseif($f==2)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
	   if($d["appraisal"][$j]["parameter"]=="deliverables")
     {
   	 	echo '<tr class="rows" id="d'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider green col-lg-2 col-md-2 col-sm-2 col-xs-3 noslider" id="dsv" name="'.decrypt($d["selfRatings"]["deliverables"]).'"></div>';
}	
?>


		 </div>

    		</div>
<!-- second table- quality -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4 data-toggle="tooltip" data-placement="top" data-original-title="Quality goals should be written around activities that mean high accuracy, compliance with applicable standards, and high customer satisfaction.">Quality</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="quality">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          

if($f==0)
{
	for($i=1;$i<2;$i++)
	{
		$maxm=count($doc1["Quality"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
		
		echo '<tr class="rows" id="q'.$i.'">';
		echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($doc1["Quality"][$j]["msrmt"]).':NA:'.decrypt($doc1["Quality"][$j]["defgoal"]).'</textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc1["Quality"][$j]["employeecomment"]).'</textarea></td>';
		echo '</tr>';
		$dc++;
		}
		if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";  	
	}
	echo '</tbody>';
	echo '</table>';

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="qsv" name="E-"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow2()">Add Row</button>';
}
elseif($f==1)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="quality")
     {
   	 	echo '<tr class="rows" id="q'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
    if($dc==0)
    {
	echo '<tr class="rows" id="q1">';
	echo '<td><textarea rows="4" cols="50" maxlength="200"></textarea></td>';
	echo '<td><textarea rows="4" cols="60" maxlength="240"></textarea></td>';
	echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="qsv" name="'.decrypt($d["selfRatings"]["quality"]).'"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow2()">Add Row</button>';
}
elseif($f==2)
{
$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="quality")
     {
   	 	echo '<tr class="rows" id="q'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 noslider green" id="qsv" name="'.decrypt($d["selfRatings"]["quality"]).'"></div>';
}	
?>
			  </div>
    		</div>
<!-- third table- competency -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4 data-toggle="tooltip" data-placement="top" data-original-title="Initiative goals should be written around activities that define skills, ability to perform, capacity and knowledge. This ultimately increases the productivity and greater revenue for the organization."> Initiatives/Ownership</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="competency">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          

if($f==0)
{
	for($i=1;$i<2;$i++)
	{
		$maxm=count($doc1["Competency"]);
		$dc=0;	
		for($j=0;$j<$maxm;$j++)
		{	 	
		echo '<tr class="rows" id="c'.$i.'">';
		echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($doc1["Competency"][$j]["msrmt"]).':'.decrypt($doc1["Competency"][$j]["descr"]).':'.decrypt($doc1["Competency"][$j]["defgoal"]).'</textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc1["Competency"][$j]["employeecomment"]).'</textarea></td>';
		echo '</tr>';
		$dc++;
		}
		if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";
	}
	echo '</tbody>';
	echo '</table>';

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green"  id="csv" name="E-"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow3()">Add Row</button>';
}
elseif($f==1)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="competency")
     {
   	 	echo '<tr class="rows" id="c'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
    if($dc==0)
    {
		echo '<tr class="rows" id="c1">';
		echo '<td><textarea rows="4" cols="50" maxlength="200"></textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240"></textarea></td>';
		echo '</tr>';
	 }
	echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green"  id="csv" name="'.decrypt($d["selfRatings"]["competency"]).'"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow3()">Add Row</button>';
}
elseif($f==2)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="competency")
     {
   	 	echo '<tr class="rows" id="c'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 noslider green" name="'.decrypt($d["selfRatings"]["competency"]).'" id="csv"></div>';
}	
?>
				  </div>
    		</div>   		

<!-- fourth table- organisational contribution -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4 data-toggle="tooltip" data-placement="top" data-original-title="Organizational goals should be written around activities that contribute to the organization’s ability to move forward – increasing revenues, decreasing costs, improving the customer experience.">Organizational/Project Contributions</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="orgcontribution">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          

if($f==0)
{
	for($i=1;$i<2;$i++)
	{
		$maxm=count($doc1["OrgContribution"]);
	$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
		echo '<tr class="rows" id="oc'.$i.'">';
		echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($doc1["OrgContribution"][$j]["msrmt"]).':'.decrypt($doc1["OrgContribution"][$j]["descr"]).':'.decrypt($doc1["OrgContribution"][$j]["defgoal"]).'</textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc1["OrgContribution"][$j]["employeecomment"]).'</textarea></td>';
		echo '</tr>';
		$dc++;
		}
		if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";	  
	}
	echo '</tbody>';
	echo '</table>';

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="ocsv" name="E-"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow4()">Add Row</button>';
}
elseif($f==1)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="organisational contribution")
     {
   	 	echo '<tr class="rows" id="oc'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
    if($dc==0)
    {
			echo '<tr class="rows" id="oc1">';
			echo '<td><textarea rows="4" cols="50" maxlength="200"></textarea></td>';
			echo '<td><textarea rows="4" cols="60" maxlength="240"></textarea></td>';
			echo '</tr>';
	 }	
	echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2  col-md-2 col-sm-2 col-xs-3 green" id="ocsv" name="'.decrypt($d["selfRatings"]["organisationalContribution"]).'"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow4()">Add Row</button>';
}
elseif($f==2)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="organisational contribution")
     {
   	 	echo '<tr class="rows" id="oc'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
    }
   echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 noslider green" id="ocsv" name="'.decrypt($d["selfRatings"]["organisationalContribution"]).'"></div>';
}	
?>
			  </div>
    		</div>   		   		

<!-- fifth table- value addition -->
								<div class="col-md-12" style="padding-bottom:20px">
	                  	  <div class="content-panel" style="padding-bottom:40px">
	                  	  	  <h4 data-toggle="tooltip" data-placement="top" data-original-title="Value addition goals should be written around activities that allow you to contribute to the organization’s success. While doing the activities listed in your job description are important, your value add moves beyond these activities to produce high measurable results for the organization.">Strategic Planning /Value Addition</h4>
	                  	  <!--	  <hr> -->
		                      <table class="table" id="valueaddition">
		                          <thead>
		                          <tr>
		                              <th>Goal</th>
		                              <th>Accomplishment</th>
		                          </tr>
		                          </thead>
		                          <tbody>
<?php		                          

if($f==0)
{
	$maxm=count($doc1["ValueAddition"]);
	$dc=0;
	for($i=1;$i<2;$i++)
	{
		for($j=0;$j<$maxm;$j++)
		{	
		echo '<tr class="rows" id="va'.$i.'">';
		echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($doc1["ValueAddition"][$j]["msrmt"]).':'.decrypt($doc1["ValueAddition"][$j]["descr"]).':'.decrypt($doc1["ValueAddition"][$j]["defgoal"]).'</textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc1["ValueAddition"][$j]["employeecomment"]).'</textarea></td>';
		echo '</tr>';
      $dc++;
		}
		if($dc===0)
  	 		echo "<tr><td><b style='color:lightpink'>Goals Not  set for this category...</b></td></tr>";   	
	}
	echo '</tbody>';
	echo '</table>';

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="vasv" name="E-"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow5()">Add Row</button>';
}
elseif($f==1)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="value addition")
     {
   	 	echo '<tr class="rows" id="va'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
   }
   if($dc==0)
   {
		echo '<tr class="rows" id="va1">';
		echo '<td><textarea rows="4" cols="50" maxlength="200"></textarea></td>';
		echo '<td><textarea rows="4" cols="60" maxlength="240"></textarea></td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 green" id="vasv" name="'.decrypt($d["selfRatings"]["valueAddition"]).'"></div>';
	echo '<button type="button" class="btn btn-sm btn-info pull-right" onclick="Addrow5()">Add Row</button>';
}
elseif($f==2)
{
	$m=count($d["appraisal"]);
	$dc=0;
	for($j=0;$j<$m;$j++)
	{ 
     if($d["appraisal"][$j]["parameter"]=="value addition")
     {
   	 	echo '<tr class="rows" id="va'.$d["appraisal"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly">'.decrypt($d["appraisal"][$j]["goal"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly">'.decrypt($d["appraisal"][$j]["accomplishment"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	
   }
   echo '</tbody>';
	echo '</table>';	

	echo '<label class="col-lg-2 pull-left">Self-Rating</label>';
	echo '<div class="slider col-lg-2 col-md-2 col-sm-2 col-xs-3 noslider green" id="vasv" name="'.decrypt($d["selfRatings"]["valueAddition"]).'"></div>';
}	
?>
   
				  </div>
    		</div>   		   		
    
   <!-- save and submit buttons -->

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 showback" style="width:97%;margin-left:13px;">
<div class="col-lg-6">
<?php
if($f==2)
{
	echo '<button type="button" class="btn btn-theme03 pull-left disable" onclick="sav()"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
else 
{
	echo '<button type="button" class="btn btn-theme03 pull-left" onclick="sav()"><i class="fa fa-floppy-o"></i>&nbspSave</button> </div>';
}
?>	           
<div class="col-lg-6">
<button type="button" id="next" class="btn btn-theme03 pull-right" onclick="next()"><i class="fa fa-arrow-right"></i>&nbspNext</button> 
</div>  </div>

  
</div> </div>	</div>		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->


<div id="myModal1" class="modal fade">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                 <form role="form">
							    <h4><center>The Self Assessment has been saved.</center></h4>          
                 <div class="modal-footer">
                   			<a class="btn btn-info close" data-dismiss="modal" name="ok">OK</a> 
                       </div>        
                    </form>             
                </div>
            </div>
        </div>
    </div>



      <!--footer start-->
     <?php include 'footer.php'; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
<!--   <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> -->
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->      
    <script src="slider/js/bootstrap-slider.js"></script>
  		<script src="jQuery-ui-Slider-Pips-master/src/js/jquery-ui-slider-pips.js"></script>    

<script src="Gritter-master/js/jquery.gritter.js"></script>
 <script src="Gritter-master/js/jquery.gritter.min.js"></script>
	

<script type="text/javascript">
	$('#add-regular').focus(function(){

			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<b style="text-shadow:none;">A regular notice!</b>',
				// (string | mandatory) the text inside the notification
				text: 'Only 240 characters are allowed in the Text Area.Please, ensure your goals and accomlishments <i><b style="color:yellow">donot exceed the 240-characters</b></i> limit.',
				// (string | optional) the image to display on the left
				
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: false,
				// (int | optional) the time you want it to be alive for before fading out
				time: '5000'
			});

			return false;

		});
		</script>  		
<script type="text/javascript">
var portalopened="<?php echo $reviewstarted; ?>";
var deadlineexpired="<?php echo $deadlineexpired; ?>";
//alert(portalopened);
if(portalopened==1)
{}
else{
$("#myModal2").modal('show');
}


if(deadlineexpired==1)
{
alert("The Deadline expired");
}
</script>
  		
<script>
//custom select box
$(function(){
  $('select.styled').customSelect();
});
</script>


<script type="text/javascript" >
$('.slider').slider();
$(".disable").prop('disabled',true); 
$(".noslider").slider('disable');
var postponed="<?php echo $postponed; ?>";
if(postponed==1)
	$("#next").prop('disabled',true);
</script>

<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var val;
var v={1:"E-",2:"E",3:"E+",4:"X"};

function sav()
{
	//alert("hi");
	var dsv = $( "#dsv" ).slider( "option", "value" ); //to get slider value
	var qsv = $( "#qsv" ).slider( "option", "value" ); //to get slider value
	var csv = $( "#csv" ).slider( "option", "value" ); //to get slider value
	var ocsv = $( "#ocsv" ).slider( "option", "value" ); //to get slider value
	var vasv = $( "#vasv" ).slider( "option", "value" ); //to get slider value
	columnvalue[columnvalue.length]="<?php echo $psiid;?>";
	columnvalue[columnvalue.length]=v[dsv];
	columnvalue[columnvalue.length]=v[qsv];
	columnvalue[columnvalue.length]=v[csv];
	columnvalue[columnvalue.length]=v[ocsv];
	columnvalue[columnvalue.length]=v[vasv];
	$("#deliverables tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		//alert(columnvalue[columnvalue.length]);
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#quality tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#competency tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#orgcontribution tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#valueaddition tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	/*var qcount=0;
for(j=3;j<columnvalue.length;j++)
if(columnvalue[j]==0)
qcount++;
alert(columnvalue.length);
if(qcount>=1)
alert("Please, rate all the questions in the questionairre before submit.");
else*/
{
	for (i=0;i<columnvalue.length;i++)
	{
		postdata[i]=columnvalue[i];
	}
	unique=JSON.stringify(postdata);
//alert(unique);
/*if(document.getElementById("area1").value=="")
  	{
  		alert("Please enter all the fields .")
  		}
  else
  {*/		


	$.ajax({ 
		url:'sa1insert.php', 
		type:'POST', 
		data:{json:unique}, 
		success:function(data){ 
			$("#myModal1").modal('show'); 
alert("Saved Successfully!");
//alert(data); 
		}, 
		error:function(xhr,desc,err){ 
			alert(err); 
		} 
	});
	columnvalue=[];
}
}

</script>

<script type="text/javascript" >
	
function next()
{
	//alert();
	sav();
			window.location.href="questionnaire.php"; 
		
}

</script>



<script type="text/javascript" >
var columnvalue=[];
var postdata={};
var unique = {};
var v={1:"E-",2:"E",3:"E+",4:"X"};
function sub()
{
var r=confirm("No changes can be made after 'submit'. Are you sure?");
if (r==true) {
	var dsv = $( "#dsv" ).slider( "option", "value" ); //to get slider value
	var qsv = $( "#qsv" ).slider( "option", "value" ); //to get slider value
	var csv = $( "#csv" ).slider( "option", "value" ); //to get slider value
	var ocsv = $( "#ocsv" ).slider( "option", "value" ); //to get slider value
	var vasv = $( "#vasv" ).slider( "option", "value" ); //to get slider value
	columnvalue[columnvalue.length]="<?php echo $psiid;?>";
	columnvalue[columnvalue.length]=v[dsv];
	columnvalue[columnvalue.length]=v[qsv];
	columnvalue[columnvalue.length]=v[csv];
	columnvalue[columnvalue.length]=v[ocsv];
	columnvalue[columnvalue.length]=v[vasv]; 
	$("#deliverables tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		alert(columnvalue[columnvalue.length]);
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#quality tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#competency tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#orgcontribution tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
	$("#valueaddition tr.rows").each(function(){
		columnvalue[columnvalue.length]=this.id;
		columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
		columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
	});
var qcount=0;
for(j=3;j<columnvalue.length;j++)
if(columnvalue[j]==0)
qcount++;

if(qcount>=1)
alert("Please, answer all the questions in the questionairre before submit.");
else
{
	for (i=0;i<columnvalue.length;i++)
	{
		postdata[i]=columnvalue[i];
	}
	unique=JSON.stringify(postdata);
//alert(unique);
	$.ajax({ 
		url:'sa1insert.php', 
		type:'POST', 
		data:{json:unique}, 
		success:function(data){ 
//alert(data); 
		}, 
		error:function(xhr,desc,err){ 
			alert("fail"); 
		} 
	});
	var id="<?php echo $psiid;?>";
	$.ajax(
	{
		url:'submitsaform1.php',
		type:'POST',
		data:{"id":id,"sub":"true"}, 
		success:function(data){ 
//alert(data); 
		},
		failure:function(xhr,desc,err){
			alert("fail");	
		}
	});
	}
columnvalue=[];
}

</script>
<script type="text/javascript" >
var inc1=11;
var inc2=21;
var inc3=31;
var inc4=41;
var inc5=51;
var dec1=-11;
function Addrow1()
{
	$('table#deliverables > tbody').append('<tr class="rows" id="d'+inc1+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc1++;
}
function Addrow2()
{
	$('table#quality > tbody').append('<tr class="rows" id="q'+inc2+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc2++;
}
function Addrow3()
{
	$('table#competency > tbody').append('<tr class="rows" id="c'+inc3+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc3++;
}
function Addrow4()
{
	$('table#orgcontribution > tbody').append('<tr class="rows" id="oc'+inc4+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc4++;
}
function Addrow5()
{
	$('table#valueaddition > tbody').append('<tr class="rows" id="va'+inc5+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	inc5++;
}
function RemoveaRow()
{
	//alert("hi");
	
	$('table#deliverables > tbody').remove('<tr class="rows" id="d'+dec1+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
	dec1++;
	alert(dec1);
	 /*var row = th.parentNode.parentNode;
  row.parentNode.removeChild(row);*/
	
	}
	/* $("#tbUser").on('click','.btnDelete',function(){
    $(this).closest('tr').remove();
      
    });*/

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
