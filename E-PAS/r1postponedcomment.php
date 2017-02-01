<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;
$n=$db->Notifications;

if(isset($_POST['submit']))
{
$id=$_POST['hiddenid'];
$comment=$_POST['comment'];
$c->update(array("psiid"=>$id),array('$set'=>array("r1PostponementComment"=>$comment)));
$c->update(array("psiid"=>$id),array('$set'=>array("postponedFlag"=>"2")));
header("Location:review1list.php");
}
?>



