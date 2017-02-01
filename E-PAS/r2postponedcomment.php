<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;

if(isset($_POST['submit']))
{
$id=$_POST['postponedid'];
$comment=$_POST['r2comment'];
$c->update(array("psiid"=>$id),array('$set'=>array("r2PostponementComment"=>$comment)));
$c->update(array("psiid"=>$id),array('$set'=>array("postponedFlag"=>"3")));
$r1=$c->findOne(array("psiid"=>$id));
$r1id=$r1["r1id"];
header("Location:completedList.php?r1id=".$r1id."&active=c");
}
?>



