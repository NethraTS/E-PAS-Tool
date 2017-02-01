<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=EPAS_Goals_status_". date('Y-M-d h:i:s').".xls"); 
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$g=$db->GoalsToBeReviewed;
//echo $_SESSION['psiid'];
?>
<style type="text/css">
th{
	background-color:#A9BCF5;
}
table
{
	text-align:center;
}
td
{
		text-align:center;
}
</style>

				
							  <!--<tr>
								  <th>Manager Name</th>
								  <th>Total Employees</th>
								  <th>Finalised Employees</th>
							  </tr> -->
					
						
						  <?php
							$r2docs=$c->find(array('r2id'=>$_SESSION['psiid']));
							//$r2doc=$c->findOne(array('r2id'=>$_SESSION['psiid']));
							$count1=1;
							
							foreach($r2docs as $doc)
							{
								$b[]=$doc["r1name"];
								$psiidArray[]=$doc["r1id"];
							}										
							$a[]=(array_unique($b));
							(sort($a[0]));				
							$r1psi[]= (array_unique($psiidArray));
							//var_dump($psiidArray);
							//echo $r1psi[0][3];
							(sort($r1psi[0]));
							//var_dump($r1psi);
							echo "EPAS - Employees Goal Status on ".date('d-m-Y H:i');
							echo "<table >";
							for($i=0;$i<count($r1psi[0]);$i++)							
							{
							echo '<tr id="e'.$count1.'">';
							echo '<td colspan="3"><b>Manager Name : '.$a[0][$i].'( PSI - '.$r1psi[0][$i].')'.'<b></td>';
							/* $cursor=$c->find(array('r1id'=>$r1psi[0][$i]));
							echo '<td>'.$cursor->count().'</td>';
								$cursor1=$g->find(array('r1id'=>$r1psi[0][$i],'rFlag'=>array('$gte' => "4")));
							echo '<td>'.$cursor1->count().'</td>'; */						
							echo '</tr>';
	
						// echo '<tr id="m'.$count1.'" class="collapse out"><td colspan="4">  '; 	
                
					?>
						<tr>
						<td colspan="3">
               					 <table  >		
                 <thead >
               
               
               
               						<tr >
                                <th>PSI ID</th>
                                <th>Name</th>
                                <th>Status</th>
                   					</tr>   
                   					</thead>  
                   					 <tbody > 
                                                    	<?php 
												
							//echo	 '<div id="m'.$count1.'" style="display:none;padding-top:20px;">';								      
								     			$cursor1=$c->find(array('r1id'=>$r1psi[0][$i]));
								     		//	echo $r1psi[0][$i] ;
												foreach($cursor1 as $doc)							      
												{ $status="";
								      		?>
											<tr>
											  <td><?php echo $doc['id']; ?></td>
											  <td><?php echo $doc['name']; ?></td>
											  <td>
												  <?php
												 
												   $cursor1=$g->find(array('r1id'=>$r1psi[0][$i],'id'=>$doc['id'])); 
												   foreach($cursor1 as $v)
													{
														if($v['rFlag']==4)
														{
															$status = "Reviewer 1 Completed";
														}
														else if($v['rFlag']==0)
														{
															$status= "Employee comment is pending";
														}
														elseif($v['r2Finalcomment']==1)
														{
															$status= "Completed the goals and Approved";
														}
														elseif($v['rFlag']==6)
														{
															$status= "Completed the goals and Reviewed";
														}
														elseif($v['rFlag']==5)
														{
															$status= "Completed the goals and Needs to be Reviewed";
														}
														
													}														
													if ($status=="")
													{
														 echo "Not Acknowledged"; 
													}
													else
													{
														echo $status;
													}
													
												  ?>											  
											  
											  </td>
											</tr>							 
											 <?php } ?>  
    
	 				 
	 				 </tbody>	 
	 				 </table>		
	 				 </td>
	 				 </tr>
	 			 				
											 
									
							
								<?php

			
							$count1++;
							
							}
							?>
						
   </tbody>	 				
	 				  </table>			
                


