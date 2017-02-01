<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->currentGoalCycle;
//$doc=$c->find(array(),array("id"=>1,"name"=>1,"training.0.train"=>1));
$doc=$c->find();

//var_dump($doc);
//echo "hi";
foreach($doc as $c)
{
echo $c["id"];echo "&nbsp&nbsp";
echo $c["name"];echo "&nbsp&nbsp";
echo $c["gName"];echo "&nbsp&nbsp";
echo "<br>";
echo "&nbsp&nbsp";

foreach($c["training"] as $d)
{
echo decrypt($d["train"]); echo "&nbsp&nbsp";echo "&nbsp&nbsp";

}echo "<br>";
echo "<br>";
}

?>

