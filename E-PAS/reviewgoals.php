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
td
{
	//text-align: justify;
	
}
</style>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;

$eid=$_GET['eid'];
//echo $eid;
$st=checkstatus($eid);
$doc=$c->findOne(array("id"=>$eid));
$psiid=$_SESSION["psiid"];
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];

$status=$_GET["status"];

//$st="Yes";
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
      echo '<h3>'.$doc["id"].'- '.$doc["name"];?></td></tr>';
     
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
                       
                          <!--    <th>Description</th> --> 
                                                <th>Specifics</th>
                   
                        <th>Employee Comments</th>
                        <th>Reviewer 1 Comments</th> 
                        <th>Status</th>                                                                							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["descr"]).'</p></td>';
			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows="5" cols="27" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';
  			echo '<td class="col-lg-1">';
  			echo '<select class="gtype" id="dsta" name="dstatus" >';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 	
			echo '</tr>';
			$dc++;
			
  	 	}
  	 	//echo $doc["rFlag"];
  	 } 
  	 elseif($doc["rFlag"]=="3")
	 {
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Deliverables"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows=5 cols=30 maxlength=240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Deliverables"][$j]["r1comment"]).'</textarea></td>';	
			echo '<td class="col-lg-1"><select class="gstat" id="dsta" name="dstatus">';
      	echo '<option>'.decrypt($doc["Deliverables"][$j]["status"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if(decrypt($doc["Deliverables"][$j]["status"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }
  	 elseif($doc["rFlag"]>="4")
	 {
		$maxm=count($doc["Deliverables"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-1"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Deliverables"][$j]["descr"]).'</p></td>';
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
else {}
?>

					  </tbody>
					  </table>

<?php 
if($st=="Yes")
{
	if($doc["rFlag"]>="2")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["del"].'</p></b>';
	}
	
	echo '<br>';	
	if($doc["rFlag"]=="2")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["del"].',daw)" value="'.$doc["gWts"]["del"].'" size="10" id="daw"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["del"].')</label>';	*/
	}
	elseif($doc["rFlag"]=="3")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac weight" size="10" id="daw" onchange="validate_weight(this.value,'.$doc["gWts"]["del"].',daw)" value="'.$doc["gWts"]["del"].'" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["del"].',daw)" value="'.decrypt($doc["AccWeightage"]["deliverables"]).'"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["del"].')</label>';	*/
	}
	elseif($doc["rFlag"]>="4")
	{
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
<?php } 
//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));
         	
         if($doc['gWts']['qual']>=0)
			{			
?> 

       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px;"> 
         	   <h4>Quality</h4>             	           	            	  
		         <table class="table table-hover table-striped" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                       
                          <!-- <th>Description</th>--> 
                                                <th>Specifics</th>
                   
                        <th>Employee Comments</th>
                        <th>Reviewer 1 Comments</th>  
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Quality"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows="5" cols="27" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';
  			echo '<td class="col-lg-1">';
  			echo '<select class="gstat" id="qsta" name="qstatus" >';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 	
			echo '</tr>';
			$dc++;
  	 	}
  	 	
  	 } 
  	 elseif($doc["rFlag"]=="3")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  			//echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Quality"][$j]["descr"]).'</p></td>';
  			  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</p></td>'; 
  			echo	'<td class="col-lg-3"><textarea rows=5 cols=30 maxlength=240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Quality"][$j]["r1comment"]).'</textarea></td>';	
			echo '<td class="col-lg-1"><select class="gstat" id="qsta" name="qstatus">';
      	echo '<option>'.decrypt($doc["Quality"][$j]["status"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if(decrypt($doc["Quality"][$j]["status"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static">'.decrypt($doc["Quality"][$j]["msrmt"]).'</p></td>';
  		//	echo '<td class="col-lg-1" ><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Quality"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Quality"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Quality"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Quality"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1" >'.decrypt($doc["Quality"][$j]["status"]).'</td>';			
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
//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));
if($st=="Yes")
{
	if($doc["rFlag"]>="2")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';
	}
	
	echo '<br>';	
	if($doc["rFlag"]=="2")
	{
		/*echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="qaw" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["qual"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["qual"].',gaw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["qual"].')</label>';	*/
	}
	elseif($doc["rFlag"]=="3")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac weight" size="10" id="qaw" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["qual"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["qual"].',gaw)" value="'.decrypt($doc["AccWeightage"]["quality"]).'"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["qual"].')</label>';	*/
	}
	elseif($doc["rFlag"]>="4")
	{
		/*echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["qual"].'</p></b>';*/
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
         	   <table class="table table-hover table-striped" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                      
                      <!--         <th>Description</th> --> 
                                                <th>Specifics</th>
                   
                        <th>Employee Comments</th>
                        <th>Reviewer 1 Comments</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
		           
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["Competency"][$j]["descr"]).'" >'.decrypt($doc["Competency"][$j]["msrmt"]).'</a></p></td>';
  	//		echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows="5" cols="27" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';
  			echo '<td class="col-lg-1">';
  			echo '<select class="gstat" id="csta" name="cstatus">';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 	
			echo '</tr>';
			$dc++;
  	 	}
  	 } 
  	 elseif($doc["rFlag"]=="3")
	{
		$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["Competency"][$j]["descr"]).'" >'.decrypt($doc["Competency"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</p></td>'; 
  			echo	'<td class="col-lg-3"><textarea rows=5 cols=30 maxlength=240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["Competency"][$j]["r1comment"]).'</textarea></td>';	
			echo '<td class="col-lg-1"><select class="gstat" id="csta" name="cstatus">';
      	echo '<option>'.decrypt($doc["Competency"][$j]["status"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if(decrypt($doc["Competency"][$j]["status"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["Competency"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["Competency"][$j]["descr"]).'" >'.decrypt($doc["Competency"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-1" ><p style="font-style: italic" class="form-control-static">'.decrypt($doc["Competency"][$j]["descr"]).'</p></td>';
	echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Competency"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Competency"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["Competency"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1" >'.decrypt($doc["Competency"][$j]["status"]).'</td>';			
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
	if($doc["rFlag"]>="2")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';
	}
	
	echo '<br>';	
	if($doc["rFlag"]=="2")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" id="caw" size="10" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["comp"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["comp"].',caw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["comp"].')</label>';	*/
	}
	elseif($doc["rFlag"]=="3")
	{
		/*echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="caw" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["comp"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["comp"].',caw)" value="'.decrypt($doc["AccWeightage"]["competency"]).'"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["comp"].')</label>';	*/
	}
	elseif($doc["rFlag"]>="4")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["comp"].'</p></b>';*/
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
		         <table class="table table-hover table-striped" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        
     <!--   <th>Description</th>--> 
                                                <th>Specifics</th>
                   
                        <th>Employee Comments</th>
                        <th>Reviewer 1 Comments</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["OrgContribution"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["OrgContribution"][$j]["descr"]).'" >'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows="5" cols="27" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';
  			echo '<td class="col-lg-1">';
  			echo '<select class="gstat" id="osta" name="ostatus">';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 	
			echo '</tr>';
			$dc++;
  	 	}
  	 } 
  	 elseif($doc["rFlag"]=="3")
	{
		$maxm=count($doc["OrgContribution"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["OrgContribution"][$j]["descr"]).'" >'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</p></td>'; 
  			echo	'<td class="col-lg-3"><textarea rows=5 cols=30 maxlength=240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["OrgContribution"][$j]["r1comment"]).'</textarea></td>';	
			echo '<td class="col-lg-1"><select class="gstat" id="osta" name="ostatus">';
      	echo '<option>'.decrypt($doc["OrgContribution"][$j]["status"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if(decrypt($doc["OrgContribution"][$j]["status"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
			$dc++;
  	 	}
  	 }
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["OrgContribution"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["OrgContribution"][$j]["descr"]).'" >'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-1" ><p style="font-style: italic" class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["OrgContribution"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1" >'.decrypt($doc["OrgContribution"][$j]["status"]).'</td>';			
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
	if($doc["rFlag"]>="2")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';
	}
	
	echo '<br>';	
	if($doc["rFlag"]=="2")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="ocaw" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["orgcont"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["orgcont"].',ocaw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["orgcont"].')</label>';	*/
	}
	elseif($doc["rFlag"]=="3")
	{
		/*echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="ocaw" onkeypress="return isNumberKey(event)" value="'.decrypt($doc["AccWeightage"]["organisationalContribution"]).'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["orgcont"].',ocaw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["orgcont"].')</label>';	*/
	}
	elseif($doc["rFlag"]>="4")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["orgcont"].'</p></b>';*/
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
<?php }
//$eid=$_GET['eid'];
//$doc=$c->findOne(array("id"=>$eid));

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
                 <!--       <th>Description</th> --> 
                        <th>Specifics</th>
                        <th>Employee Comments</th>
                        <th>Reviewer 1 Comments</th>                                                                 							
                        <th>Status</th>                                                               							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["ValueAddition"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["ValueAddition"][$j]["descr"]).'" >'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-2" ><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</p></td>'; 
  			echo '<td class="col-lg-3"><textarea rows="5" cols="27" maxlength="240" name="comment" onkeypress="return onlyAlphabets(event,this)"></textarea></td>';
  			echo '<td class="col-lg-1">';
  			echo '<select class="gstat" id="vsta" name="vstatus">';
  			foreach($gstatus as $k)	
	      	 echo '<option>'.$k.'</option>';
	      echo '</select></td>';	 	
			echo '</tr>';
			$dc++;
  	 	}
  	 } 
  	 elseif($doc["rFlag"]=="3")
	{
		$maxm=count($doc["ValueAddition"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2"><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["ValueAddition"][$j]["descr"]).'" >'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-2"><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3"><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</p></td>'; 
  			echo	'<td class="col-lg-3"><textarea rows=5 cols=30 maxlength=240" name="comment" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["ValueAddition"][$j]["r1comment"]).'</textarea></td>';	
			echo '<td class="col-lg-1"><select class="gstat" id="vsta" name="vstatus">';
      	echo '<option>'.decrypt($doc["ValueAddition"][$j]["status"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if(decrypt($doc["ValueAddition"][$j]["status"])!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
			$dc++;
  	  }
  	 }
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["ValueAddition"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-2" ><p style="font-weight:bold" class="form-control-static"><a  data-toggle="hover" class="pop all" title="Description"  data-placement="bottom" href="#"   data-content="'.decrypt($doc["ValueAddition"][$j]["descr"]).'" >'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</a></p></td>';
  		//	echo '<td class="col-lg-1" ><p style="font-style: italic" class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</p></td>';
  				echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["employeecomment"]).'</p></td>';
  			echo '<td class="col-lg-3" ><p class="form-control-static">'.decrypt($doc["ValueAddition"][$j]["r1comment"]).'</p></td>';			
			echo '<td class="col-lg-1" >'.decrypt($doc["ValueAddition"][$j]["status"]).'</td>';			
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
	if($doc["rFlag"]>="2")
	{
		echo '<b style="color:brown"><label class="col-lg-1 pull-left">weightage&nbsp:</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';
	}
	
	echo '<br>';	
	if($doc["rFlag"]=="2")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="vaaw" onkeypress="return isNumberKey(event)" value="'.$doc["gWts"]["valadd"].'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["valadd"].',vaaw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["valadd"].')</label>';	*/
	}
	elseif($doc["rFlag"]=="3")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<input type="number" class="col-lg-1 ac" size="10" id="vaaw" onkeypress="return isNumberKey(event)" value="'.decrypt($doc["AccWeightage"]["valueAddition"]).'" onkeyup="validate_weight(this.value,'.$doc["gWts"]["valadd"].',vaaw)"></input></b>';
		echo '<label class="col-lg-1">(0-'.$doc["gWts"]["valadd"].')</label>';	*/
	}
	elseif($doc["rFlag"]>="4")
	{
	/*	echo '<b style="color:brown"><label class="col-lg-3 pull-left">Accomplished Weightage</label>';
		echo '<p class="static-form-control">&nbsp&nbsp'.$doc["gWts"]["valadd"].'</p></b>';*/
	}
}
?>
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
<?php }?>

<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4>Training</h4>             	  
		         <table class="table table-hover table-striped" id="training">
		           <thead>
							<tr>
                        <th>Training Name</th>
                         <!--	<th></th> -->
                       <th>Training Quarter</th>   
                        <th>Status</th>                                             							
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$gstatus=array("Select","Achieved","Not Achieved","Partially Achieved","Deferred");
if($st=="Yes")
{
	if($doc["rFlag"]<"2")
	{
		echo "<tr><td><b style='color:lightpink'>Employee comments pending...</b></td></tr>";
	}
	elseif($doc["rFlag"]=="2")
	{
		$maxm=count($doc["training"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td ><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
//			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  			
  			echo '</tr>';
			$dc++;
  	 	}
  	 } 
  	 elseif($doc["rFlag"]=="3")
	{
		$maxm=count($doc["training"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  		echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'.&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
//echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';  
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p></td>';  				
  			echo '</tr>';
			$dc++;
  	  }
  	 }
  	 elseif($doc["rFlag"]>="4")
	{
		$maxm=count($doc["training"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
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
		echo "<tr><td><b style='color:lightpink'>Training Not Eligible for review in this cycle...</b></td></tr>";
}
?>							                						           
					  </tbody>
			      </table>


	         </div>
		    </div>










	  	<div class="col-lg-12" style="padding-bottom:20px" id="en"> 
        	<div class="content-panel" style="padding-bottom:40px">
        	    <br>  
        	  <!-- <label class="col-lg-3 pull-left"><b>Cumulative Accomplished Weightage</b></label>	<div id="Cweight"></div> -->
<?php
if($doc["rFlag"]=="2")
	echo '<p class="form-class-static" id="Cweight"></p><br><br>';
elseif($doc["rFlag"]>="3")
	echo '<p class="form-class-static" id="Cweight">'.decrypt($doc["totalAccWt"]).'</p><br><br>';
?>
				 
				  <label class="col-lg-3 pull-left"><b>Overall Feedback</b></label>
				  <div class="col-lg-8">
<?php
if($doc["rFlag"]=="2")
	echo '<textarea rows="4" cols="60" maxlength="500" name="comment1" id="r1feedback" onkeypress="return onlyAlphabets(event,this)"></textarea>';
elseif($doc["rFlag"]=="3")
	echo '<td><textarea rows=4 cols=60 maxlength=240" name="comment1" id="r1feedback" onkeypress="return onlyAlphabets(event,this)">'.decrypt($doc["r1feedback"]).'</textarea></td>';
elseif($doc["rFlag"]>="4")
	echo '<p class="static-form-control" id="r1feedback" style="max-width:800px;">'.decrypt($doc["r1feedback"]).'</p><br>';
?>
				</div><br><br><br><br>
				 
         </div>
       </div>
	 </div>

<!--button-->
		  <div class="row mt" id="btns">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left" onclick="sav()">
                  <i class="fa  fa-save"></i> &nbsp&nbsp Save
                </button>
               </div> 
               <div class="col-lg-6">
               <button type="button" class="btn btn-sm btn-theme03"  onclick="window.location.href='gmanagerlist.php?active=r1'">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
  	  
                <button class="btn btn-theme03 pull-right" onclick="sub()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Submit
                </button>
               </div> 
            </div>
          </div>
         </div>
         
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
<script type="text/javascript" >
/*$(document).ready(function(){
$('a').toggle(

function() {
    $('#sidebar').css('left', '0')
}, function() {
    $('#sidebar').css('left', '210px')
})
	
	}); */
	
	
</script>
 <script>$(function () 
      { $("[data-toggle='popover']").popover();
      $(".pop").popover({ trigger: "hover" });
      });
   </script>
<script type="text/javascript" >
function validate_weight(inp_val,max_val,id1)
{
	if((inp_val<0)||(inp_val>max_val))
	{
	 alert('Enter within range');
	 id1.value="";
	}	
}
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
if(st=="No")
	$('#en').hide();

if(fl<2||fl>3 || fl>=4 || st=="No")
	$('#btns').hide();
	
$('.ac').on('input', function() 
{
	
	var dw=$('#daw').val();
	var qw=$('#qaw').val();
	var cw=$('#caw').val();
	var ocw=$('#ocaw').val();
	var vaw=$('#vaaw').val();
	if(typeof(dw)=='undefined')
	{
	 var dw=0;	
	}
	if(typeof(ocw)=='undefined')
	{
	 var ocw=0;	
	}
	if(typeof(qw)=='undefined')
	{
	 var qw=0;	
	}
	if(typeof(cw)=='undefined')
	{
	 var cw=0;	
	}
	if(typeof(vaw)=='undefined')
	{
	 var vaw=0;	
	}
	var total=+dw + +qw + +cw + +ocw + +vaw;
	document.getElementById('Cweight').innerHTML=total;
	 
});

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

<script type="text/javascript">
var t;
function goback()
{
	window.location.href="gmanagerlist.php";	
}

$('button[name=addGoals]').on("click",function(){
	var eid="<?php echo $eid ?>";
	window.location.href="setgoals.php?eid="+eid;	
});
	
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


function sav()
{
var d,q,c,o,v,comm,comm1,comm2,comm3;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
	if(choice1.trim().length<=25)
	comm2="lesschar";
} 
var course_choices = $('textarea[name="comment1"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm1="nofeedback";
	if(choice1.trim().length<=25)
	comm3="lesschar";
} 
//alert(course_choices.length);
//var choice1 = course_choices.eq(0).val();
//var choice2 = course_choices.eq(1).val();   
var course_choices = $('select[name="dstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	d="Select";
}  
 var course_choices = $('select[name="qstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	q="Select";
}  var course_choices = $('select[name="cstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	c="Select";
}  var course_choices = $('select[name="ostatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	o="Select";
}  var course_choices = $('select[name="vstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	v="Select";
}   
  
  
  // alert(choice1);
   //alert(choice2);
//alert($( ".gtype option:selected" ).text());
    
   		 /*var inputs = $(".gtype option:selected");
   		 alert(inputs);
			for(var i = 0; i < inputs.length; i++){
    		alert($(inputs[i]).val());
			}*/
	/*	var foo = []; 
$('.gtype ').each(function(i, selected){ 
  foo[i] = $(selected).text(); 
  alert($(selected).text());
}); */
   

	t=0;
	var dw=$('#daw').val();
	var qw=$('#qaw').val();
	var cw=$('#caw').val();
	var ocw=$('#ocaw').val();
	var vaw=$('#vaaw').val();

	//var d=$('#dsta').val();
	//var q=$('#qsta').val();
	//var c=$('#csta').val();
	//var o=$('#osta').val();
	//var v=$('#vsta').val();

	if((dw=="") ||(qw=="") || (cw=="") ||(ocw=="")||(vaw==""))
	{
	alert('Please fill all the weightage');	
	}
	else
	{
if(typeof(dw)=='undefined')
{
 dw="";
}
if(typeof(qw)=='undefined')
{
 qw="";
}
if(typeof(cw)=='undefined')
{
 cw="";
}
if(typeof(ocw)=='undefined')
{
 ocw="";
}
if(typeof(vaw)=='undefined')
{
 vaw="";
}
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	columnvalue[columnvalue.length]=dw;
	columnvalue[columnvalue.length]=qw;
	columnvalue[columnvalue.length]=cw;
	columnvalue[columnvalue.length]=ocw;
	columnvalue[columnvalue.length]=vaw;	
	if( $('#Cweight').text() >100)
	{
		//alert("The cumulative Accomlished Weight excceeds 100.Please, check the given weights.");		
	}	
	else 
	{
		//if(d=="Select")
		{
		//	alert("Please update the goal status in Deliverables");
		}
		//else if(q=="Select")
		{
		//	alert("Please update the goal status in Quality");
		}
		//else if(c=="Select")
		{
		//	alert("Please update the goal status in Initiatives/Ownership");
			}
		//else if(o=="Select")
		{
		//	alert("Please update the goal status in Organizational/ Project Contribution");
			}
		//else if(v=="Select")
		{//alert("Please update the goal status in Strategic Planning /Value Addition");
		}
		//else if(comm=="none")
		{//alert("Please enter all comments");
		}
		//else if(comm1=="nofeedback")
		{//alert("Please enter overall feedback");
		}
		//else if(comm2=="lesschar")
		{
		//	alert("//Please enter more than 25 characters in comment box.");
		}
		//else if(comm3=="lesschar")
		{
			//alert("//Please enter more than 25 characters in overall feedback.");
		}
		//else
		{	
	columnvalue[columnvalue.length]=$('#Cweight').text();		
	columnvalue[columnvalue.length]=$('#r1feedback').val();
	$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
				///alert(postdata[i]]);
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'gr1commtinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show');
					//alert(data); 
					alert("Saved Successfully!");
					t=1;					
					//return true;				
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(xhr); 
							
					//console.log(xhr);
				} 
			});		
			columnvalue=[];
				
		}}
		}
	//	return true;
}

function sav1()
{
	var d,q,c,o,v,comm,comm1,comm2,comm3;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
	if(choice1.trim().length<=25)
	comm2="lesschar";
} 
var course_choices = $('textarea[name="comment1"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm1="nofeedback";
	if(choice1.trim().length<=25)
	comm3="lesschar";
} 
//alert(course_choices.length);
//var choice1 = course_choices.eq(0).val();
//var choice2 = course_choices.eq(1).val();   
var course_choices = $('select[name="dstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	d="Select";
}  
 var course_choices = $('select[name="qstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	q="Select";
}  var course_choices = $('select[name="cstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	c="Select";
}  var course_choices = $('select[name="ostatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	o="Select";
}  var course_choices = $('select[name="vstatus"]');  
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1=="Select")
	v="Select";
} 
	t=0;
	var dw=$('#daw').val();
	var qw=$('#qaw').val();
	var cw=$('#caw').val();
	var ocw=$('#ocaw').val();
	var vaw=$('#vaaw').val();
	
	//var d=$('#dsta').val();
	//var q=$('#qsta').val();
	//var c=$('#csta').val();
	//var o=$('#osta').val();
	//var v=$('#vsta').val();
	
	if((dw=="") ||(qw=="") || (cw=="") ||(ocw=="")||(vaw==""))
	{
	alert('Please fill all the weightage');	
	}
	else
	{
if(typeof(dw)=='undefined')
{
 dw="";
}
if(typeof(qw)=='undefined')
{
 qw="";
}
if(typeof(cw)=='undefined')
{
 cw="";
}
if(typeof(ocw)=='undefined')
{
 ocw="";
}
if(typeof(vaw)=='undefined')
{
 vaw="";
}
	var columnvalue=[];
	var postdata={};
	columnvalue[columnvalue.length]="<?php echo $eid; ?>";
	columnvalue[columnvalue.length]=dw;
	columnvalue[columnvalue.length]=qw;
	columnvalue[columnvalue.length]=cw;
	columnvalue[columnvalue.length]=ocw;
	columnvalue[columnvalue.length]=vaw;	
	if( $('#Cweight').text() >100)
	{
		alert("The cumulative Accomlished Weight excceeds 100.Please, check the given weights.");		
	}	
	else 
	{
		if(d=="Select")
		{
			alert("Please update the goal status in Deliverables");d="";return false;
		}
		else if(q=="Select")
		{
			alert("Please update the goal status in Quality");return false;
		}
		else if(c=="Select")
		{
			alert("Please update the goal status in Initiatives/Ownership");return false;
			}
		else if(o=="Select")
		{
			alert("Please update the goal status in Organizational/ Project Contribution");return false;
			}
		else if(v=="Select")
		{alert("Please update the goal status in Strategic Planning /Value Addition");return false;
		}
		else if(comm=="none")
		{alert("Please enter all comments");return false;
		}
		else if(comm1=="nofeedback")
		{alert("Please enter the overall feedback");return false;
		}
		else if(comm2=="lesschar")
		{
			alert("Please enter more than 25 characters in comment box.");return false;
		}
		else if(comm3=="lesschar")
		{
			alert("Please enter more than 25 characters in overall feedback.");return false;
		}
		else
		{	
	columnvalue[columnvalue.length]=$('#Cweight').text();		
	columnvalue[columnvalue.length]=$('#r1feedback').val();
	$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				columnvalue[columnvalue.length]=$('td:eq(3)',this).children().val();
				columnvalue[columnvalue.length]=$('td:eq(4)',this).first().find("option:selected").text();
			});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
				///alert(postdata[i]]);
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'gr1commtinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show');
					//alert(data); 
					//alert("Saved Successfully!");
					t=1;					
					//return true;				
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(xhr); 
							
					//console.log(xhr);
				} 
			});		
			columnvalue=[];
				
		return true;}}
		}
	//	return true;
}



function sub()
{
	if(sav1())
	{
	var r=confirm("No changes can be made after 'submit'. Are you sure?");
	if (r==true) {	
		//if(t==1)
		{
			//sav();
			var eid="<?php echo $eid; ?>";
			//alert(eid)
			$.ajax({ 
				url:'gr1commtsubmit.php', 
				type:'POST', 
				data:{"id":eid,"sub":"true"}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Submitted Successfully!! Redirecting to Dashboard");
					window.location.href="gmanagerlist.php";
					//alert(eid)
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
