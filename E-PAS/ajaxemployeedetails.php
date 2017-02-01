<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$psiid=$_REQUEST['psiid'];
//echo $psiid;
$doc=$c->find(array("psiid"=>$psiid));

//echo $doc;
foreach($doc as $v)
{
echo '<label>Name : '.$v['name'].', Email : '.$v['emailid'].'</label>';	
}
?>




