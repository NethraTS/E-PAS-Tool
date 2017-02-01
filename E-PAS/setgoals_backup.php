<?php
session_start();include session_timeout.php;
include 'secure.php';
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
</style>
 </head>

  <body>
<?php
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$gd=$db->goal_definition;
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
          
  	<div class="row mt">

<?php 
	echo '<h3>'.$doc['name'].'</h3>';  
?>  
<?php
foreach ($doc['gWts'] as $v)
{
echo 	$v;
	}
	
?>
     <br>
  	 	<button class="btn btn-sm btn-theme03 pull-left" style="margin-left:20px;" onclick="goback()">
  	        <i class="fa fa-arrow-left"></i>&nbsp&nbsp Back
  	   </button>
		
  	  </div>

<!--goals by category--> 	  
  	 <div class="row mt" id="cate">
  	 <?php 
 			if($doc['gWts']['del']>0)
 			{    	
    	?>
    	        	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	
 
         	        <h4 class="col-lg-4">Deliverables </h4>&nbsp&nbsp&nbsp&nbsp&nbsp
         	        <?php if($doc['flag']>=2)
							{ ?>
								<select class="col-lg-3 disa" id="dgoal" onchange="goal_select(this,<?php echo $doc['flag'];?>)"> 
         	        		<option disabled selected>select a predefined goal</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'DELIVERABLES'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>       	        																																																
         	        </select>
							<? } 
							else {        	        
         	        ?>
         	        
         	        
         	        <select class="col-lg-3" id="dgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'DELIVERABLES'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>       	        																																																
         	        </select>
         	        <?php }?>	                                         	                	           	            	  
		         <table class="table" id="deliverables">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>                                                                                    							
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
  			echo '<td><textarea rows="4" cols="50" readonly="readonly" maxlength="200">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc["Deliverables"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
  	 	}
  	 	   	      
   }
   if($doc["flag"]=="2")
  	 	{
		$maxm=count($doc["Deliverables"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly="readonly" maxlength="200">'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly" maxlength="240">'.decrypt($doc["Deliverables"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
  	 	}
  	 			
  	 	}
   elseif($doc["flag"]>="3")
   {
	   $maxm=count($doc["Deliverables"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="d'.$doc["Deliverables"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["Deliverables"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240" readonly>'.decrypt($doc["Deliverables"][$j]["descr"]).'</textarea></td>';
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
		echo '<input type="number" class="col-lg-1 ac weight" size="10" id="daw" onchange="validate_weight(this.value,'.$doc["gWts"]["del"].',daw)" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["del"].',daw)" value="'.$doc["gWts"]["del"].'"></input></b>';
//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["del"].'</p>';
/*if($doc["flag"]=="0") 
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="dWt">';
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="dWt" value="'.decrypt($doc["Weightage"]["deliverables"]).'">';
elseif($doc["flag"]>="3")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="dWt" readonly value="'.decrypt($doc["Weightage"]["deliverables"]).'">';
*/

?>
         </div>
		    </div>
<?php
 }        
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
         	
         	 			if($doc['gWts']['qual']>0)
			{			
			 ?>
			
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	 
         	   <h4 class="col-lg-4">Quality</h4>&nbsp&nbsp&nbsp&nbsp&nbsp
						<?php if($doc['flag']>=2)
							{ ?>
<select class="col-lg-3 disa" id="qgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'QUALITY'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>          	        																																																
         	        </select>
         	        <?php 
         	        
         	        }
         	        else {
         	        ?> 
         	        
         	        <select class="col-lg-3" id="qgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'QUALITY'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>          	        																																																
         	        </select>
         	        <?php }?>	                                           	           	            	  
		         <table class="table" id="quality">
		           <thead>
							<tr>
                         <th>Measurement</th>
                        <th>Description</th>                        			
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
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc["Quality"][$j]["descr"]).'</textarea></td>';
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
  			echo '<td><textarea rows="4" cols="50" readonly="readonly" maxlength="200">'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly="readonly" maxlength="240">'.decrypt($doc["Quality"][$j]["descr"]).'</textarea></td>';
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
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["Quality"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240" readonly>'.decrypt($doc["Quality"][$j]["descr"]).'</textarea></td>';
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
echo '<input type="number" class="col-lg-1 ac" size="10" id="qaw" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["qual"].',gaw)" value="'.$doc["gWts"]["del"].'"></input></b>'; 
	//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["qual"].'</p>';
/*if($doc["flag"]=="0")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="qWt">';
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="qWt" value="'.decrypt($doc["Weightage"]["quality"]).'">';
elseif($doc["flag"]>="3")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="qWt" readonly value="'.decrypt($doc["Weightage"]["quality"]).'">';
*/

?>

				
	         </div>
		    </div>
			
			<?php
		}
		$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['comp']!=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">             	  
         	   <h4 class="col-lg-4">Initiatives/ Ownership</h4>&nbsp&nbsp&nbsp&nbsp&nbsp
         	   <?php if($doc['flag']>=2)
							{ ?>
							<select class="col-lg-3 disa" id="cgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'INITIATIVES/ OWNERSHIP'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-3" id="cgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'INITIATIVES/ OWNERSHIP'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } ?>	                         	  
         	   <table class="table" id="competency">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
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
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   		      
    }
    elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["Competency"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly maxlength="200">'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly maxlength="240">'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   		      
    } 
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["Competency"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="c'.$doc["Competency"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["Competency"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240" readonly>'.decrypt($doc["Competency"][$j]["descr"]).'</textarea></td>';
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
echo '<input type="number" class="col-lg-1 ac" size="10" id="qaw" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["qual"].',gaw)" value="'.$doc["gWts"]["comp"].'"></input></b>';
	//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["comp"].'</p>';
	/*
if($doc["flag"]=="0")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="cWt">';
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="cWt" value="'.decrypt($doc["Weightage"]["competency"]).'">';
elseif($doc["flag"]>="3")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="cWt" readonly value="'.decrypt($doc["Weightage"]["competency"]).'">';
*/
?>

					
			    </div>
		    </div>
		<?php
		}
		$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['orgcont']!=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">  
         	    <h4 class="col-lg-4">Organizational/ Project Contribution</h4>&nbsp&nbsp&nbsp&nbsp&nbsp
         	    <?php if($doc['flag']>=2)
							{ ?>
							<select class="col-lg-3 disa" id="ocgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'ORGANIZATIONAL/ PROJECT CONTRIBUTION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-3" id="ocgoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								<?php 
									$cursor=$gd->find(array('goal'=>'ORGANIZATIONAL/ PROJECT CONTRIBUTION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>         	        																																																
         	        </select>
         	        <?php } ?>	                         	             	  
		         <table class="table" id="orgcontribution">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
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
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   	        
    }     
    elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["OrgContribution"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly maxlength="200">'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly maxlength="240">'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   	        
    }
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["OrgContribution"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="oc'.$doc["OrgContribution"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["OrgContribution"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240" readonly>'.decrypt($doc["OrgContribution"][$j]["descr"]).'</textarea></td>';
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
echo '<input type="number" class="col-lg-1 ac" size="10" id="qaw" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["orgcont"].',gaw)" value="'.$doc["gWts"]["orgcont"].'" ></input></b>';
	//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["orgcont"].'</p>';
	/*
if($doc["flag"]=="0")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="ocWt">';
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="ocWt" value="'.decrypt($doc["Weightage"]["organisationalContribution"]).'">';
elseif($doc["flag"]>="3")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="ocWt" readonly value="'.decrypt($doc["Weightage"]["organisationalContribution"]).'">';
*/
?>

					
	         </div>
		    </div>
			
			<?php
			}
			$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));

			if($doc['gWts']['valadd']!=0)
			{			
			 ?>
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:40px">
         	   <h4 class="col-lg-4">Strategic Planning /Value Addition</h4> &nbsp&nbsp&nbsp&nbsp&nbsp
         	   <?php if($doc['flag']>=2)
							{ ?>
						<select class="col-lg-3 disa" id="vagoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'STRATEGIC PLANNING /VALUE ADDITION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>        	        																																																
         	        </select>
         	        <?php } else { ?>
         	        <select class="col-lg-3" id="vagoal" onchange="goal_select(this)"> 
         	        		<option disabled selected>select a predefined goal</option>
								 <?php 
									$cursor=$gd->find(array('goal'=>'STRATEGIC PLANNING /VALUE ADDITION'));	
									foreach($cursor as $doc)
									{
							for($i=0;$i<sizeof($doc['definition']);$i++)
							{?> 
							<option><?php  echo $doc['definition'][$i];?></option>
									<?php } }							 
								 ?>        	        																																																
         	        </select>	
         	        <?php } ?>                         	  
		         <table class="table" id="valueaddition">
		           <thead>
							<tr>
                        <th>Measurement</th>
                        <th>Description</th>
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
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   	      
    }
    	elseif($doc["flag"]=="2")
	{
		$maxm=count($doc["ValueAddition"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" readonly maxlength="200">'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" readonly maxlength="240">'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
			echo '</tr>';
     	}   	      
    }   
   
	elseif($doc["flag"]>="3")
	{
		$maxm=count($doc["ValueAddition"]);
		for($j=0;$j<$maxm;$j++)
		{	 
	  	 	echo '<tr class="rows" id="va'.$doc["ValueAddition"][$j]["cnt"].'">';
  			echo '<td><textarea rows="4" cols="50" maxlength="200" readonly>'.decrypt($doc["ValueAddition"][$j]["msrmt"]).'</textarea></td>';
  			echo '<td><textarea rows="4" cols="60" maxlength="240" readonly>'.decrypt($doc["ValueAddition"][$j]["descr"]).'</textarea></td>';
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
echo '<input type="number" class="col-lg-1 ac" size="10" id="qaw" onkeypress="return isNumberKey(event)" onkeyup="validate_weight(this.value,'.$doc["gWts"]["orgcont"].',gaw)" value="'.$doc["gWts"]["valadd"].'" ></input></b>';
	//echo '<p class="static-form-control wt" id="dWt">'.$doc["gWts"]["valadd"].'</p>';
	/* 
if($doc["flag"]=="0")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="vaWt">';
elseif($doc["flag"]=="1" || $doc["flag"]=="2")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="vaWt" value="'.decrypt($doc["Weightage"]["valueAddition"]).'">';
elseif($doc["flag"]>="3")
	echo '<input type="text" size="5" style="margin-right:20px" class="col-lg-1 pull-left" id="vaWt" readonly value="'.decrypt($doc["Weightage"]["valueAddition"]).'">';
*/
?>

					
	         </div>
		    </div>
<?php } ?>
	 </div>

<!--button-->
<?php
$eid=$_GET['eid'];
$doc=$c->findOne(array("id"=>$eid));
if($doc['flag']<"2")
{
?>
		  <div class="row mt" id="btns">
       	<div class="col-lg-12" style="padding-bottom:20px"> 
         	<div class="content-panel" style="padding-bottom:50px"> 
         	  <div class="col-lg-6">
                <button class="btn btn-theme03 pull-left" id="sav" onclick="sav()">
                  <i class="fa fa-check"></i>&nbsp&nbsp Save
                </button>
               </div> 
					<div class="col-lg-6">
                <button class="btn btn-theme03 pull-right" id="sub">
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
$('.disa').prop('disabled',true);
var fl="<?php echo $doc['flag']; ?>";
if(fl>=3)
{
	$(".addG").hide();
	$("#btns").hide();
}
</script>

<script type="text/javascript" >
var inc1=11;
var inc2=21;
var inc3=31;
var inc4=41;
var inc5=51;


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
});

function goal_select(th,td)
{
 var cate=$(th).attr("id");
 var selected=th.value;
 //alert(cate);
 //alert(selected);

	if(cate=="dgoal")
	{
 		$('table#deliverables > tbody').append('<tr class="rows" id="d'+inc1+'"><td>'+selected+'</td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
 		inc1++;
	}
	else if(cate=="qgoal")
	{
		$('table#quality > tbody').append('<tr class="rows" id="q'+inc2+'"><td>'+selected+'</td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc2++;			
	}
	else if(cate=="cgoal")
	{
		$('table#competency > tbody').append('<tr class="rows" id="c'+inc3+'"><td>'+selected+'</td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc3++;			
	}
	else if(cate=="ocgoal")
	{
		$('table#orgcontribution > tbody').append('<tr class="rows" id="oc'+inc4+'"><td>'+selected+'</td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc4++;	
	}
	else if(cate=="vagoal")
	{
		$('table#valueaddition > tbody').append('<tr class="rows" id="va'+inc5+'"><td>'+selected+'</td><td><textarea rows="4" cols="60" maxlength="240"></textarea></td></tr>');
		inc5++;	
	}	
}  
</script>

<script type="text/javascript" >
function revgoals()
{
	window.location.href="reviewgoals.php";
};

function sav()
{
	var columnvalue=[];
	var postdata={};
	//var dw=$('#dWt').val();
	//var qw=$('#qWt').val();
	//var cw=$('#cWt').val();
	//var ocw=$('#ocWt').val();
	//var vaw=$('#vaWt').val();
	//var total=+dw + +qw + +cw + +ocw + +vaw;
	  var dw=$('#daw').val();
	var qw=$('#qaw').val();
	var cw=$('#caw').val();
	var ocw=$('#ocaw').val();
	var vaw=$('#vaaw').val();
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

var sum=dw+qw+cw+ocw+vaw;
if(sum!=100)
{
	alert("Sum of Weights exceeded hundred");
	}
else
{





		   columnvalue[columnvalue.length]="<?php echo $eid; ?>";
		   //columnvalue[columnvalue.length]=dw;
		   //columnvalue[columnvalue.length]=qw;
		   //columnvalue[columnvalue.length]=cw;
		   //columnvalue[columnvalue.length]=ocw;
		   //columnvalue[columnvalue.length]=vaw;	   
			$("#deliverables tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
		 			columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();

				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
			});
			$("#quality tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
				columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();

				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
			});
			$("#competency tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
			});
			$("#orgcontribution tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
	
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
			});
			$("#valueaddition tr.rows").each(function(){
				columnvalue[columnvalue.length]=this.id;
				if($('td:eq(0)',this).children().length == 0)		
					columnvalue[columnvalue.length]=$('td:eq(0)',this).html();
				else 
					columnvalue[columnvalue.length]=$('td:eq(0)',this).children().val();
					
				columnvalue[columnvalue.length]=$('td:eq(1)',this).children().val();
			});
			for (i=0;i<columnvalue.length;i++)
			{		
				postdata[i]=columnvalue[i];
			}
			//alert(columnvalue);
				unique=JSON.stringify(postdata);
			//alert(unique);
			$.ajax({ 
				url:'goalinsert.php', 
				type:'POST', 
				data:{json:unique}, 
				success:function(data){ 
					//$("#myModal1").modal('show'); 
					alert("Saved Successfully!");
					//alert(data); 
				}, 
				error:function(xhr,desc,err){ 
					alert(err); 
				} 
			});
			
		columnvalue=[];
		return true;
		}
};

$('#sub').click(function(e)
{
 var r=confirm("The submission enables the employee to view the goals. Are you sure?");
 if (r==true) {
	if(sav())
	{
	var eid="<?php echo $eid; ?>";
	$.ajax({ 
		url:'r1submitgoals.php', 
		type:'POST', 
		data:{"id":eid,"sub":"true"}, 
		success:function(data){ 
			//$("#myModal1").modal('show'); 
			//alert("Saved Successfully!");
			alert("Submitted Successfully");
			window.location.reload();	
			}, 
		error:function(xhr,desc,err){ 
			alert(err); 
		} 
	});
  }
 }
});

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