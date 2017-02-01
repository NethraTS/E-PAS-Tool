<?php
session_start();
include session_timeout.php;
require('auth.php');
include 'secure.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <?php include 'stylesheets.php'; ?>
     
   <!-- <link href="progressline.css" media="all" rel="stylesheet">--> 
<link rel="stylesheet" type="text/css" href="datetime/jquery.datetimepicker.css"/>
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
.rg
{
margin-right:20px;
}
.wt
{
color: brown;
margin-right:20px;
font-weight:bold;
}
td{
text-align: justify;
/*padding: 15px;	 */
	}
</style>
 </head>

  
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$gd=$db->goal_definition;
$psiid=$_SESSION["psiid"];
//echo $psiid;
$role=$_SESSION["role"];
$admin=$_SESSION["admin"];
$name=$_SESSION["uname"];
$status=$_GET["status"];
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$flag=$doc["flag"];
?>

<body onload="a(<?php echo $flag ?>)" >
  <section id="container" >
   <?php include 'headerandsidebar.php'; ?>    	       	  
         
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
        <?php
         echo '<h3 style="text-align:left">'.$doc["id"].' - '.$doc["name"]."</h3>"; ?>
       
 <table > 
 <tr><td>
<?php   
     ?></td></tr>
     
     <tr><td>
<?php
if($doc['flag']==0)
 echo 'Type: '.$doc["gType"].' Goals <br> <br> <p> Overall Weightage : <class="form-class-static" id="Cweight"></p>';
else if($doc['flag']==1)
 echo 'Type: '.$doc["gType"].' Goals <br> <br> <p> Overall Weightage : <class="form-class-static" id="Cweight"></p>';
else 
	echo 'Type: '.$doc["gType"].' Goals <br> <br> <p> Overall Weightage : 100</p>';
?></td><td>
<?php
echo '<div class="col-lg-11">';
echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th><center>Deliverables</center></th><th><center>Quality</center></th><th><center>Initiatives/ Ownership</center></th><th><center>Organizational/ Project Contribution</center></th><th><center>Strategic Planning /Value Addition</center></th></tr>';
echo '<tr><td><center>'.$doc['gWtshr']['delhr'].'%</center></td><td><center>'.$doc['gWtshr']['qualhr'].'%</center></td><td><center>'.$doc['gWtshr']['comphr'].'%</center></td><td><center>'.$doc['gWtshr']['orgconthr'].'%</center></td><td><center>'.$doc['gWtshr']['valaddhr'].'%</center></td></tr>';
echo '</table>';
echo '</div>';
?></td><td>
  	 	<button class="btn btn-sm btn-theme03 pull-right" style="margin-right:20px;" onclick="window.location.href='gmanagerlist.php?active=r1'">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
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
         	
 							
         	        <h4 class="col-lg-2">Deliverables  </h4>
         	        <div class="col-lg-9">
         	          <select class="division col-lg-4" id="DELIVERABLES" >
 							 	<option selected>-----SELECT AN AREA-----</option>
 							 	<option>Design and Development</option> 
  	 							<option>Test and Automation</option>
  	 							<option>Support</option>
  	 							<option>HR and Admin</option>
<option>Learning and Developmnet</option>
  	 				<option>Inside Sales</option>
  	 	 					 </select>
  	 	 					
         	        <?php if($doc['flag']>=2)
							{ ?>
								<select class="col-lg-5 disa" id="dgoal" onchange="goal_select(this)"> 
         	        		 <option selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'DELIVERABLES'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php 
									} }							 
								 ?>       	        																																																
         	        </select>
							<?php } 
							else {        	        
         	        ?>
         	        
         	        <!--
         	        <select class="col-lg-5" id="dgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'DELIVERABLES'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>       	        																																																
         	        </select> -->
         	        <select class="col-lg-5" id="dgoal" onchange="goal_select(this)">
         	        <option selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
         	        </select>
         	        <?php }?>
         	          </div>	                                         	                	           	            	  
		         <table class="table table-hover table-striped" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>                                                                                    							
								<th>Specifics </th> 		
							</tr>		           
		           </thead>
		           <tbody>
<?php 

$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
	if($doc["flag"]=="0")
	{
		}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["Deliverables"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
			echo '<td class="col-lg-4"><textarea style="font-weight:bold;border: none" rows="4" cols="30" readonly="readonly" maxlength="200">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td  class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">NA</textarea></td>';
  			echo '<td  class="col-lg-4"><textarea rows="4" cols="40" maxlength="240">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</textarea></td>';
			echo '<td class="col-lg-1"></td>';			
			echo '</tr>';
			
  	 	}
  	 	   	      
   }
   if($doc["flag"]=="2")
  	 	{
		$maxm=count($doc["Deliverables"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">'; 			
  			echo '<td class="col-lg-4"><textarea style="font-weight:bold;border: none" rows="4" cols="30" readonly="readonly" maxlength="200">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">NA</textarea></td>';
  			echo '<td class="col-lg-4"><textarea style="font-style: italic;border: none" rows="4" cols="40" readonly="readonly" maxlength="240">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
  	 	}
  	 			
  	 	}
   elseif($doc["flag"]>="3")
   {
	   $maxm=count($doc["Deliverables"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" maxlength="200" readonly>'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" maxlength="240" readonly>NA</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Deliverables"][$j]["defgoal"]).'</textarea></td>';
						
			echo '</tr>';
  	 	} 
   }     
?>		           
		           </tbody>
					  </table>

  					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="del" onclick="addG1()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  
	         
                 <label class="col-lg-1 pull-left wt">weightage</label>              
<?php 
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$max=$doc["gWts"]["del"]+5;
if($doc["gWts"]["del"]<5)
{
	$min=0;
	}
else{
	$min=$doc["gWts"]["del"]-5;
	}

//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
if($doc["flag"]=="0" || $doc["flag"]=="1" ) 
	echo '<input type="number" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" onkeydown="return false;" min="'.$min.'" max="'.$max.'" id="dWt" onInput="checkLength()" value="'.$doc["gWts"]["del"].'">';
elseif($doc["flag"]>="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" id="dWt" readonly value="'.$doc["gWts"]["del"].'">';

//echo '+-5';
?>
         </div>
		    </div>
<?php
 }        
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
         	
         if($doc['gWts']['qual']>=0)
			{			
			 ?>
			
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	 <div class="col-lg-12"> 
         	   <h4 class="col-lg-2">Quality</h4>
         	    		 <select class="division col-lg-3" id="QUALITY">
 							<option selected>-----SELECT AN AREA-----</option>
 							 	<option>Design and Development</option> 
  	 							<option>Test and Automation</option>
  	 							<option>Support</option>
  	 							<option>HR and Admin</option>
<option>Learning and Developmnet</option>
  	 				<option>Inside Sales</option>
  	 	 					 </select>
						<?php if($doc['flag']>=2)
							{ ?>
<select class="col-lg-3 disa" id="qgoal" onchange="goal_select(this)"> 
         	       <option selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'QUALITY'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>          	        																																																
         	        </select>
         	        <?php 
         	        
         	        }
         	        else {
         	        ?> 
         	      <!--  
         	        <select class="col-lg-3" id="qgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'QUALITY'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>          	        																																																
         	        </select>-->
         	      <select class="col-lg-5" id="qgoal" onchange="goal_select(this)">
         	           <option selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
         	        </select>
         	        <?php }?>	
         	        </div>                                           	           	            	  
		         <table class="table table-hover table-striped" id="quality">
		           <thead>
							<tr>
                       <th>Measurement</th>
                        <th>Description</th>                                                                                    							
								<th>Specifics </th> 		                  			
							</tr>		           
		           </thead>
		           <tbody>
<?php
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
	if($doc["flag"]=="0")
	{}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><textarea style="font-weight:bold;border: none" rows="4" cols="30" maxlength="200" readonly>'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" maxlength="240" readonly>NA</textarea></td>';
			echo '<td class="col-lg-4"><textarea rows="4" cols="40" maxlength="240">'.decrypt($doc["Quality"][$j]["defgoal"]).'</textarea></td>';	
			echo '<td class="col-lg-1"></td>';	
			echo '</tr>';
  			$dc++;
     	}   	         
    }
   elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" readonly="readonly" maxlength="200">'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" readonly="readonly" maxlength="240">NA</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Quality"][$j]["defgoal"]).'</textarea></td>';			
			echo '</tr>';
  			$dc++;
     	}   	         
    }    
	elseif($doc["flag"]>="3")
	 {
		$maxm=count($doc["Quality"]);
		$dc=0;
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="q'.$doc["Quality"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" maxlength="200" readonly>'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" maxlength="240" readonly>NA</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Quality"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
  			$dc++;
     	}   	         
    }  	
?>		           
						</tbody>
			      </table>

					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="qual" onclick="addG2()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  

				    <label class=" col-lg-1 pull-left wt">weightage</label>              
<?php
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$max=$doc["gWts"]["qual"]+5;

if($doc["gWts"]["qual"]<5)
{
	$min=0;
	}
else{
	$min=$doc["gWts"]["qual"]-5;
	}

//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
if($doc["flag"]=="0" || $doc["flag"]=="1" ) 
	echo '<input type="number" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" onkeydown="return false;" min="'.$min.'" max="'.$max.'" id="qWt" onchange value="'.$doc["gWts"]["qual"].'">';
elseif($doc["flag"]>="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" id="qWt" readonly value="'.$doc["gWts"]["qual"].'">';

?>
 </div>
</div>
			
			<?php
		}
		$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4 class="col-lg-4">Initiatives/ Ownership</h4>&nbsp&nbsp&nbsp&nbsp&nbsp
         	   <?php if($doc['flag']>=2)
							{ ?>
							<select class="col-lg-4 disa" id="cgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'INITIATIVES/ OWNERSHIP'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{
								?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-4" id="cgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'INITIATIVES/ OWNERSHIP'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } ?>	                         	  
         	   <table class="table table-hover table-striped" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>                                                                                    							
								<th>Specifics </th> 		
                        
							</tr>		           
		           </thead>
		           <tbody>
<?php
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid)); 
	if($doc["flag"]=="0")
	{}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["Competency"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"> <textarea style="font-weight:bold;border: none" rows="4" cols="30" maxlength="200" readonly>'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
			echo '<td class="col-lg-4"><textarea rows="4" cols="40" maxlength="240">'.decrypt($doc["Competency"][$j]["defgoal"]).'</textarea></td>';			
			echo '<td class="col-lg-1"></td>';			
			echo '</tr>';
     	}   		      
    }
    elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["Competency"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" readonly maxlength="200">'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" readonly maxlength="240">'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Competency"][$j]["defgoal"]).'</textarea></td>';			
			echo '</tr>';
     	}   		      
    } 
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["Competency"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" maxlength="200" readonly>'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" maxlength="240" readonly>'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["Competency"][$j]["defgoal"]).'</textarea></td>';			
			echo '</tr>';
     	}   		      
    }      
?>		           
		           
					  </tbody>
			      </table>

					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="comp" onclick="addG3()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  

					    <label class=" col-lg-1 pull-left wt">weightage</label>              
<?php 
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$max=$doc["gWts"]["comp"]+5;
if($doc["gWts"]["comp"]<5)
{
	$min=0;
	}
else{
	$min=$doc["gWts"]["comp"]-5;
	}


//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
if($doc["flag"]=="0" || $doc["flag"]=="1" ) 
	echo '<input type="number" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" onkeydown="return false;"  min="'.$min.'" max="'.$max.'" id="cWt" onchange value="'.$doc["gWts"]["comp"].'">';
elseif($doc["flag"]>="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" id="cWt" readonly value="'.$doc["gWts"]["comp"].'">';

?>

					
			    </div>
		    </div>
		<?php
		}
		$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4 class="col-lg-4">Organizational/ Project Contribution</h4>&nbsp&nbsp&nbsp&nbsp&nbsp
         	    <?php if($doc['flag']>=2)
							{ ?>
							<select class="col-lg-4 disa" id="ocgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'ORGANIZATIONAL/ PROJECT CONTRIBUTION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-4" id="ocgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'ORGANIZATIONAL/ PROJECT CONTRIBUTION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } ?>	                         	             	  
		         <table class="table table-hover table-striped" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>                                                                                    							
								<th>Specifics </th> 		
							</tr>		           
		           </thead>
		           <tbody>
<?php 
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
	if($doc["flag"]=="0")
	{}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["OrgContribution"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><textarea style="font-weight:bold;border: none" rows="4" cols="30" maxlength="200" readonly>'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
			echo '<td class="col-lg-4"><textarea rows="4" cols="40" maxlength="240">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</textarea></td>';			
			echo '<td class="col-lg-1"></td>';		
			echo '</tr>';
     	}   	        
    }     
    elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["OrgContribution"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" readonly maxlength="200">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" readonly maxlength="240">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
     	}   	        
    }
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["OrgContribution"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" maxlength="200" readonly>'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" maxlength="240" readonly>'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly="readonly" maxlength="240">'.decrypt($doc["OrgContribution"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
     	}   	        
    }     
?>		           
			           
					  </tbody>
					  </table>	

					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="orgcon" onclick="addG4()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  

				    <label class=" col-lg-1 pull-left wt">weightage</label>              
<?php 
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$max=$doc["gWts"]["orgcont"]+5;

if($doc["gWts"]["orgcont"]<5)
{
	$min=0;
	}
else{
	$min=$doc["gWts"]["orgcont"]-5;
	}

//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
if($doc["flag"]=="0" || $doc["flag"]=="1" ) 
	echo '<input type="number" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" onkeydown="return false;" min="'.$min.'" max="'.$max.'" id="ocWt" onchange value="'.$doc["gWts"]["orgcont"].'">';
elseif($doc["flag"]>="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" id="ocWt" readonly value="'.$doc["gWts"]["orgcont"].'">';

?>

					
	         </div>
		    </div>
			
			<?php
			}
			$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']>=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4 class="col-lg-4">Strategic Planning /Value Addition</h4> &nbsp&nbsp&nbsp&nbsp&nbsp
         	   <?php if($doc['flag']>=2)
							{ ?>
						<select class="col-lg-4 disa" id="vagoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'STRATEGIC PLANNING /VALUE ADDITION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>        	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-4" id="vagoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>---CLICK HERE TO ADD A NEW MEASUREMENT---</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'STRATEGIC PLANNING /VALUE ADDITION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i]['name'];?></option>
									<?php } }							 
								 ?>        	        																																																
         	        </select>	
         	        <?php } ?>                         	  
		         <table class="table table-hover table-striped" id="valueaddition">
		           <thead>
							<tr>
                       <th>Measurement</th>
                        <th>Description</th>                                                                                    							
								<th>Specifics </th> 		
 							</tr>		           
		           </thead>
		           <tbody>
<?php 
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
	if($doc["flag"]=="0")
	{}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["ValueAddition"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td class="col-lg-4"><textarea style="font-weight:bold;border: none" rows="4" cols="30" maxlength="200" readonly>'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td class="col-lg-3"><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly maxlength="240">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
			echo '<td class="col-lg-4"><textarea rows="4" cols="40" maxlength="240">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</textarea></td>';
			echo '<td class="col-lg-1"></td>';			
			echo '</tr>';
     	}   	      
    }
    	elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["ValueAddition"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" readonly maxlength="200">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" readonly maxlength="240">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly maxlength="240">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</textarea></td>';			
			echo '</tr>';
     	}   	      
    }   
   
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["ValueAddition"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td><textarea style="font-weight:bold;border: none" rows="4" cols="25" maxlength="200" readonly>'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="50" maxlength="240" readonly>'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
			echo '<td><textarea style="font-style: italic;border: none" rows="4" cols="30" readonly maxlength="240">'.decrypt($doc["ValueAddition"][$j]["defgoal"]).'</textarea></td>';
			echo '</tr>';
     	}   	      
    }    
?>		           
		           
					  </tbody>
			      </table>

					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="valadd" onclick="addG5()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  
					
					   <label class=" col-lg-1 pull-left wt">weightage</label>              
<?php
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
$max=$doc["gWts"]["valadd"]+5;
if($doc["gWts"]["valadd"]<5)
{
	$min=0;
	}
else{
	$min=$doc["gWts"]["valadd"]-5;
	}



//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
if($doc["flag"]=="0" || $doc["flag"]=="1" ) 
	echo '<input type="number" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" onkeydown="return false;"  min="'.$min.'" max="'.$max.'" id="vaWt" onchange value="'.$doc["gWts"]["valadd"].'">';
elseif($doc["flag"]>="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left weightage" id="vaWt" readonly value="'.$doc["gWts"]["valadd"].'">';

?>

					
	         </div>
		    </div>
<?php } ?>

<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4 class="col-lg-11">Trainings</h4>
         	    <h4> <a href="#" data-toggle="tooltip" title="Click to add Trainings"> <button id="train" name="train" style="border:none" onclick="set_training(this)" class="btn btn-default btn-xl">
         	 ADD &nbsp<i class="fa fa-plus"></i>
                            </button></a></h4>
         	    <?php if($doc['flag']>=2)
							{ ?>
						
						
         	        <?php } else { ?>
         	       
								
						
									<?php }	 ?>         	        																																																
         	     
         		                         	             	  
		         <table class="table table-hover table-striped" id="training">
		           <thead>
							<tr>
                        <th>Training Name</th>
                       <th></th>
                       <th>Training Quarter</th>
                  	</tr>		           
		           </thead>
		           <tbody>
	           		
	           		
<?php 
$gstatus=array("Q2 2015","Q3 2015","Q4 2016");
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
	if($doc["flag"]=="0")
	{}	
	elseif($doc["flag"]=="1")
	{
		$maxm=count($doc["training"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td>'.$doc["training"][$j]["cnt"].'&nbsp&nbsp<input type="text" value="'.decrypt($doc["training"][$j]["train"]).'"></td>';
  		   echo '<td><!--&nbsp&nbsp<input  class="datetimepickers" onclick="bala(this)" value="'.($doc["training"][$j]["traindate"]).'">--></td>';
  		  echo '<td><select class="train" id="train-quater" >';
      	echo '<option>'.($doc["training"][$j]["train-quater"]).'</option>';
	   	foreach($gstatus as $k)	
	     	{
	     		if($doc["training"][$j]["train-quater"]!== $k)
	    	 	echo '<option>'.$k.'</option>';
	     	} 
	   	echo '</select></td>';			
			echo '</tr>';
     	}   	      
    }
    	elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["training"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
			echo '<td><!--<p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p>--></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';		
  			echo '</tr>';
     	}   	      
    }   
   
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["training"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="t'.$doc["training"][$j]["cnt"].'">';
  			echo '<td><p class="form-control-static">'.$doc["training"][$j]["cnt"].'&nbsp&nbsp'.decrypt($doc["training"][$j]["train"]).'</p></td>';
  			echo '<td><!--<p class="form-control-static">'.($doc["training"][$j]["traindate"]).'</p>--></td>';  	
			echo '<td><p class="form-control-static">'.($doc["training"][$j]["train-quater"]).'</p></td>';		
  			echo '</tr>';
     	}   	      
    }    
?>	           
					  </tbody>
					  </table>	

					<!--<button type="button" class="btn btn-sm btn-info pull-right addG" style="margin-right:10px;" name="orgcon" onclick="addG4()">
						<i class="fa fa-plus"></i>&nbsp&nbsp Add Goal
					</button>-->				  

				    

					
	         </div>
		    </div>
	 </div>

<!--button-->
<?php
$eid=$_GET['eid'];
$flag=
$doc=$c->findOne(array("id"=>$eid));
$flag=$doc['flag'];
if($doc['flag']<"2")
{
?>
		  <div class="row mt" id="btns">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:50px"> 
         	  <div class="col-lg-6">
                <button type="button" class="btn btn-theme03 pull-left" id="sav" onclick="sav()">
                  <i class="fa  fa-save"></i>&nbsp&nbsp Save
                </button>
               </div> 
               <div class="col-lg-6">
					<button type="button" class="btn btn-sm btn-theme03"  onclick="window.location.href='gmanagerlist.php?active=r1'">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
  	  
					
                <button type="button" class="btn btn-theme03 pull-right" id="sub" onclick="sub()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Submit
                </button>
               </div>                
            </div>
          </div>        
         </div>
    <?php }?>     
		</section><! --/wrapper -->

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

<script src="datetime/jquery.js"></script>
<script src="datetime/jquery.datetimepicker.js"></script>
<script type="text/javascript">


</script>
<script type="text/javascript" >
function load(){
//var t,t1;
//alert("load");
document.getElementById('Cweight').innerHTML=0;
}
$('.disa').prop('disabled',true);
var fl="<?php echo $doc['flag']; ?>";
if(fl>=3||fl==2)
{
	$(".addG").hide();
	$("#btns").hide();
	$("#train").hide();
}

</script>

<script type="text/javascript" >
var dnc1=11;
var dnc2=21;
var dnc3=31;
var dnc4=41;
var dnc5=51;
var dnc6=61;
var inc1=11;
var inc2=21;
var inc3=31;
var inc4=41;
var inc5=51;
var inc6=61;
var defaultTextAreaCount=0;
var defaultTextAreaCount1=0;
var t1;
$(".addG").click(function(e)
{
	if($(this).prev().attr("id")=="deliverables")
     {		
		$('table#deliverables > tbody').append('<tr class="rows" id="d'+inc1+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc1++; 
		}
	 else if($(this).prev().attr("id")=="quality")
     {		
		$('table#quality > tbody').append('<tr class="rows" id="q'+inc2+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc2++; 
		}
	 else if($(this).prev().attr("id")=="competency")
     {		
		$('table#competency > tbody').append('<tr class="rows" id="c'+inc3+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc3++; 
		}
	 else if($(this).prev().attr("id")=="orgcontribution")
     {		
		$('table#orgcontribution > tbody').append('<tr class="rows" id="oc'+inc4+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc4++; 
		}
	 else if($(this).prev().attr("id")=="valueaddition")
     {		
		$('table#valueaddition > tbody').append('<tr class="rows" id="va'+inc5+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc5++; 
		}
		else if($(this).prev().attr("id")=="training")
     {		
		$('table#training > tbody').append('<tr class="rows" id="va'+inc5+'"><td><textarea rows="4" cols="50" maxlength="200"></textarea></td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc6++; 
		}
});
function toTitleCase(str)
{
	//var str = document.getElementById("name").value;
  // str.charAt(0).toUpperCase() + str.slice(1);


    return str.charAt(0).toUpperCase() + str.slice(1);
}

function deletedesgn(th)
{
	//var msg=" 'Save' this change before leaving the page,to make it parmanent";	
	var desgn;	
	var p=$(th).parent().parent();
	var p1=th.id;	
	if((p1.charAt(0)=="d"))
	inc1--;
	else if((p1.charAt(0)=="q"))
	inc2--;
	else if((p1.charAt(0)=="c"))
	inc3--;
	else if((p1.charAt(0)=="o"))
	inc4--;
	else if((p1.charAt(0)=="v"))
	inc5--;
	else if((p1.charAt(0)=="t"))
	inc6--;
	
	//alert(dnc1);
	p.remove();
	
	//document.getElementById("ms").innerHTML=msg;
	//$("#message").modal('show');
}
$("#train").click(function(e) {
    e.preventDefault();
    // Do your stuff
});
function goal_select(th)
{
 var cate=$(th).attr("id");
 
var division="";
if(cate=="dgoal")
{
division=$("#DELIVERABLES").val();
}else if(cate=="qgoal")
{
division=$("#QUALITY").val();	
}
 //alert(cate+" "+division);
 var selected=th.value;
 
defaultTextAreaCount++;
defaultTextAreaCount1++;
				$.ajax({ 
				url:'setDefaultText.php', 
				type:'POST', 
				data:'val='+selected, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert(data);
					//alert(str);
					$("#"+cate+defaultTextAreaCount).val(toTitleCase(data.toLowerCase()));
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(err); 
				} 
			});
	
 //alert(cate);
 //alert(selected);

	if(cate=="dgoal")
	{
 		$('table#deliverables > tbody').append('<tr class="rows" id="d'+inc1+'"><td class="col-lg-4" style="font-weight:bold" >'+division+' : '+selected+'</td><td class="col-lg-3"	>NA</td><td class="col-lg-4"><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="40" maxlength="240" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td class="col-lg-1"><button id="dd'+dnc1+'" class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
 		inc1++;  dnc1++;
 		$("#dgoal").val("---CLICK HERE TO ADD A NEW MEASUREMENT---");
	}
	else if(cate=="qgoal")
	{
		$('table#quality > tbody').append('<tr class="rows" id="q'+inc2+'"><td class="col-lg-4" style="font-weight:bold">'+division+' : '+selected+'</td><td class="col-lg-3">NA</td><td class="col-lg-4" ><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="40" maxlength="240" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td class="col-lg-1" ><button id="qq'+dnc2+'" class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
		inc2++;	dnc2++;
		$("#qgoal").val("---CLICK HERE TO ADD A NEW MEASUREMENT---");		
	}
	else if(cate=="cgoal")
	{
		$('table#competency > tbody').append('<tr class="rows" id="c'+inc3+'"><td class="col-lg-4"  style="font-weight:bold">'+selected+':</td><td class="col-lg-3" ><textarea style="font-style: italic;border: none" id="'+cate+defaultTextAreaCount+'" rows="6" cols="30" maxlength="240" readonly></textarea></td><td class="col-lg-3" ><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="40" maxlength="240" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td class="col-lg-1" ><button id="cc'+dnc3+'" class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
		inc3++;	dnc3++;		
		$("#cgoal").val("---CLICK HERE TO ADD A NEW MEASUREMENT---");
	}
	else if(cate=="ocgoal")
	{
		$('table#orgcontribution > tbody').append('<tr class="rows" id="oc'+inc4+'"><td class="col-lg-4" style="font-weight:bold">'+selected+':</td><td class="col-lg-3"><textarea style="font-style: italic;border: none" id="'+cate+defaultTextAreaCount+'" rows="6" cols="30" maxlength="240" readonly></textarea></td><td class="col-lg-3"><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="40" maxlength="240" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td class="col-lg-1"><button id="oo'+dnc4+'" class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
		inc4++;	dnc4++;
		$("#ocgoal").val("---CLICK HERE TO ADD A NEW MEASUREMENT---");
	}
	else if(cate=="vagoal")
	{
		$('table#valueaddition > tbody').append('<tr class="rows" id="va'+inc5+'"><td class="col-lg-4" style="font-weight:bold">'+selected+':</td><td class="col-lg-3"><textarea style="font-style: italic;border: none" id="'+cate+defaultTextAreaCount+'" rows="6" cols="30" maxlength="240" readonly></textarea></td><td class="col-lg-3"><textarea id="'+cate+defaultTextAreaCount1+'" rows="4" cols="40" maxlength="240" onkeypress="return onlyAlphabets(event,this)"></textarea></td><td class="col-lg-1"><button id="vv'+dnc5+'" class="btn btn-xs btn-info pull-right d" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
		inc5++;	dnc5++;
		$("#vagoal").val("---CLICK HERE TO ADD A NEW MEASUREMENT---");
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
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) ||charCode==8 ||charCode==46||charCode==47||(charCode >= 48 && charCode < 57)||charCode==13||charCode==32||charCode==40||charCode==41||charCode==92||charCode==44||charCode==34||charCode==39||charCode==64||charCode==33||charCode==58)
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
	
	var comm,comm1;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
} 
var course_choices = $('input:text[name="traint1"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")	
	comm1="none";
} 
	t=0;
	//if(calculateSum())	
		{
	var columnvalue=[];
	var postdata={};
	var dw=$('#dWt').val();
	var qw=$('#qWt').val();
	var cw=$('#cWt').val();
	var ocw=$('#ocWt').val();
	var vaw=$('#vaWt').val();
	//var total=+dw + +qw + +cw + +ocw + +vaw;
	
	//if((<?php echo $flag ?>)==0)
	{	  
	  if(dw>0&&inc1<=11)
	  {
	 	 alert("Deliverable not set");return false;
		}	   
	   else if(qw>0&&inc2<=21)
	   {
	  alert("Quality not set");return false;
	   }else if(cw>0&&inc3<=31)
	{  alert("Initiatives/ Ownership not set");return false;}
	   else if(ocw>0&&inc4<=41)
	  {alert("Organizational/ Project Contribution not set");return false;}
	   else if(vaw>0&&inc5<=51)
	  {alert("Strategic Planning /Value Addition not set");return false;}
	  else if(vaw<=0&&inc5>51)
	  {alert("Weightage for Strategic Planning /Value Addition not set");return false;}
	  else if(inc6<=61)
	  {alert("Training not set");return false;}
	    else if(comm1=="none")
	    {alert("Specify a name for training!!");return false;}
	  else if(calculateSum())
	   {
			columnvalue[columnvalue.length]="<?php echo $eid; ?>";
		   columnvalue[columnvalue.length]=dw;
		   columnvalue[columnvalue.length]=qw;
		   columnvalue[columnvalue.length]=cw;
		   columnvalue[columnvalue.length]=ocw;
		   columnvalue[columnvalue.length]=vaw;	   
			$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
		 			columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();

				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
	
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#training tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
						columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
				});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			if(calculateSum())
			{
			$.ajax({ 
			url:'goalinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					//alert("Saved Successfully!");
					//window.location.reload();
					t=1;
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(err); 
				} 
			});
			}
			else
			{
				return false;
				}
		columnvalue=[];
	return true;	
}return false;}
//else
	  }}

function sav()
{
	var comm,comm1;
var course_choices = $('textarea[name="comment"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")
	comm="none";
} 
var course_choices = $('input:text[name="traint1"]'); 
for($i=0;$i<course_choices.length;$i++)
{
	choice1 = course_choices.eq($i).val();
	if(choice1.trim()=="")	
	comm1="none";
} 
	
	t=0;
	//if(calculateSum())	
		{
			var columnvalue=[];
	var postdata={};
	var dw=$('#dWt').val();
	var qw=$('#qWt').val();
	var cw=$('#cWt').val();
	var ocw=$('#ocWt').val();
	var vaw=$('#vaWt').val();
	//var total=+dw + +qw + +cw + +ocw + +vaw;
	
	
{
	if(comm1=="none")
	{
	 // alert("Specify a name for training!!");
	 } else
	  {
			columnvalue[columnvalue.length]="<?php echo $eid; ?>";
		   columnvalue[columnvalue.length]=dw;
		   columnvalue[columnvalue.length]=qw;
		   columnvalue[columnvalue.length]=cw;
		   columnvalue[columnvalue.length]=ocw;
		   columnvalue[columnvalue.length]=vaw;	   
			$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
		 			columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();

				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
	
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
			});
			$("#training tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)
				{		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
					
				}				
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
					columnvalue[columnvalue.length]=$('td:eq(2)',this).children().val();
				});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			//if(calculateSum())
			{
			$.ajax({ 
			url:'goalinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Saved Successfully!");
					window.location.href="setgoals.php?eid=<?php echo $eid; ?>";
					t=1;
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					//alert(err); 
				} 
			});
			}
		columnvalue=[];
	//return true;	
}}
}}
$("#bala").click(function(e) {
    e.preventDefault();
    // Do your stuff
});
function bala(t)
{
	var todayDate="<?php echo date('Y/m/d'); ?>";
var todayTime="<?php echo date('H:i'); ?>";
var dateTime="<?php echo date('Y/m/d H:i') ?>";
	 $('.datetimepickers').datetimepicker({
	//mask:'9999/19/39 29:59',
	minDate:todayDate,
	 timepicker:false,
	format:'Y/m/d',
	mask:true
	/*minTime:todayTime,
	onSelectDate:function(ct,$i){
		this.setOptions({minTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()<dateTime)
		{
			$input.val("");
		}
	}*/
}); 		
	
	
	}
function a(t)
{
	var dw=$('#dWt').val();
	var qw=$('#qWt').val();
	//alert(qw);
	var cw=$('#cWt').val();
	var ocw=$('#ocWt').val();
	var vaw=$('#vaWt').val();
	if(typeof(dWt)=='undefined')
	{
	 var dw=0;	
	}
	if(typeof(ocWt)=='undefined')
	{
	 var ocw=0;	
	}
	if(typeof(qWt)=='undefined')
	{
	 var qw=0;	
	}
	if(typeof(cWt)=='undefined')
	{
	 var cw=0;	
	}
	if(typeof(vaWt)=='undefined')
	{
	 var vaw=0;	
	}
	var total=+dw + +qw + +cw + +ocw + +vaw;
	document.getElementById('Cweight').innerHTML=total;
 t1=t;	
}	
function sub()
{
	
	if(sav1())	
	{		
 var r=confirm("The submission enables the employee to view the goals. Are you sure?");
 if (r==true) {
//alert(t1);
	//if(t1==0||t1==1)
	{	//alert("hi");
	var eid="<?php echo $eid; ?>";
	$.ajax({ 
		url:'r1submitgoals.php', 
		type:'POST', 
		data:{"id":eid,"sub":"true"}, 
		success:function(data){ 
			//$("#myModal1").modal('show'); 
			//alert("Saved Successfully!");
			alert("Goals submitted to employee for Acknowledgement.");
					window.location.href="gmanagerlist.php";
			}, 
		error:function(xhr,desc,err){ 
			//alert(err); 
		} 
	});
  }
  
  }
 
}}
 function calculateSum(){
				
				var sum=0;
				$(".weightage").each(function(){
				if(!isNaN(this.value)&&this.value.length!=0){
				sum+=parseFloat(this.value);
				}});
						//$("#sum").html(sum.toFixed(2));
						if(sum>100)
						{
						alert("Overall weightage is not meeting the criteria it is " +sum+"%");
						return false;
						}else if(sum<100)
						{
							alert("Overall weightage is not meeting the criteria it is " +sum+"%");
							return false;
						}else if(sum==100)
						{
							return true;
						}
			}
			
function set_training(th)
{
 var cate=$(th).attr("id");

// var selected=th.value;

defaultTextAreaCount1++;
		
if(cate=="train")
	{
 		$('table#training > tbody').append('<tr class="rows" id="t'+inc6+'"><td><input class="traint2" name="traint1" type="text" maxlength="100" id="'+cate+defaultTextAreaCount1+'" ></td><td><!--<input  class="datetimepickers" placeholder="Click here for date"  >--></td><td><select name="trainq" id="'+cate+defaultTextAreaCount1+'"><option>Q2 2015</option><option>Q3 2015</option><option>Q4 2016</option></select></td><td><button class="btn btn-xs btn-info pull-right d" id="t'+dnc6+'" onclick="deletedesgn(this)"><i class="fa fa-times"></i>&nbspDelete</td></tr>');
		var todayDate="<?php echo date('Y/m/d'); ?>";
var todayTime="<?php echo date('H:i'); ?>";
var dateTime="<?php echo date('Y/m/d H:i') ?>";

  $('.datetimepickers').datetimepicker({
	//mask:'9999/19/39 29:59',
	minDate:todayDate,
	timepicker:false,
	format:'Y/m/d',
	mask:true
	/*minTime:todayTime, 
	onSelectDate:function(ct,$i){
		this.setOptions({minTime:false});
	},
	onChangeDateTime:function(dp,$input){
		if($input.val()<dateTime)
		{
			$input.val("");
		}
	} */
}); 		
 		
 		inc6++;
	}
		
} 
</script>

<script>



<!-- used to disable selected option from the select menu -->
$(document).ready(function(){
        $("#dgoal").change(function(e){
        	
            var id = $(this).attr("id");
            var value = this.value;
            
            $("select option").each(function(){
                 var idParent = $(this).parent().attr("id");
                 if(id == idParent){
                     if(this.value == value){
                    this.disabled = true;
                    }
                }
            })

        })
           $("#qgoal").change(function(e){
        	
            var id = $(this).attr("id");
            var value = this.value;
            
            $("select option").each(function(){
                 var idParent = $(this).parent().attr("id");
                 if(id == idParent){
                     if(this.value == value){
                    this.disabled = true;
                    }
                }
            })

        }) 
        
        
        
        
        
        
        
    });
    
    /* Ajax script for select division based */
$(document).ready(function(){
	
$(".division").change(function(e){
var v=$(this).val();
var goal = $(this).attr("id");
//alert(goal)
	$.ajax({ 
		url:'divisionAjax.php', 
		type:'POST', 
		dataType:'json',
		data:{"v":v,"goal":goal}, 
		success:function(data){ 
		//alert(data);
			//$("#myModal1").modal('show'); 
			//alert("Saved Successfully!");
			//alert(data)		
			/* used to read response data and write it into select box options */
				
			if(goal=="DELIVERABLES")
			{
			var mySelect = $('#dgoal');
			}else if(goal=="QUALITY")
			{
				
			var mySelect = $('#qgoal');	
			
			}
		 mySelect.val("").html("");
			mySelect.append(
        		$('<option></option>').val("---CLICK HERE TO ADD A NEW MEASUREMENT---").html("---CLICK HERE TO ADD A NEW MEASUREMENT---")
    		);
			if(data != "")
			{
				
			$.each(data, function(val, text) {
    		mySelect.append(
        		$('<option></option>').val(text).html(text)
    		);
			});
			}
			else
			{
				alert("Data not available");
			mySelect.html("---CLICK HERE TO ADD A NEW MEASUREMENT---");
			}
			//here val is key and text is value
			/*------------------------------------------------*/
			
			
				
			}, 
		error:function(xhr,desc,err){ 
		//	alert(err); 
		} 
		});
	})	
});    
    
    
    
    $('.weightage').on('input', function() 
{
	
	var dw=$('#dWt').val();
	var qw=$('#qWt').val();
	//alert(qw);
	var cw=$('#cWt').val();
	var ocw=$('#ocWt').val();
	var vaw=$('#vaWt').val();
	if(typeof(dWt)=='undefined')
	{
	 var dw=0;	
	}
	if(typeof(ocWt)=='undefined')
	{
	 var ocw=0;	
	}
	if(typeof(qWt)=='undefined')
	{
	 var qw=0;	
	}
	if(typeof(cWt)=='undefined')
	{
	 var cw=0;	
	}
	if(typeof(vaWt)=='undefined')
	{
	 var vaw=0;	
	}
	var total=+dw + +qw + +cw + +ocw + +vaw;
	document.getElementById('Cweight').innerHTML=total;
	 
});
</script>
<!----------------------------->
<!-- calculate sum of weightage -->
<!--<script>
$(document).ready(function(){
	$(".weightage").each(function(){
		$(this).change(function(){
			calculateSum();});
						
			});});
			function calculateSum(){
				
				var sum=0;
				$(".weightage").each(function(){
				if(!isNaN(this.value)&&this.value.length!=0){
				sum+=parseFloat(this.value);
				}});
						//$("#sum").html(sum.toFixed(2));
						if(sum>100)
						{
						alert("Range Exceed");
						}else if(sum<100)
						{
							alert("Range is below");
						}
			}
</script> -->
<!------------------------------>

<script type="text/javascript" >

function revgoals()
{
	window.location.href="reviewgoals.php";
};





function goback()
{
	window.location.href="gmanagerlist.php?active=r1";	
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
