<?php 
//session_start();
//include session_timeout.php;
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c = $db->currentReviewCycle;

//$c->update(array(),array("$set"=>array("flag2"=>"11")) , array('multiple' => true));

//$c->update(array(), $update, array('multi' => true));
//db.currentReviewCycle.update({}, {$set: {flag2: 3}}, { multi: true })
$a=$c->update(array(),array('$set'=>array("flag2"=>11)),array('multi'=>true));
//var_dump($a);
//window.location.href="hrviewlist.php";

?>
