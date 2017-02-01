<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
$dc = $db->selectCollection('gradesandweights');

$cate = $_POST['cate'];
//var_dump($cate);

$res=$dc->remove(array("category"=>$cate));
echo($res["n"]);
?>