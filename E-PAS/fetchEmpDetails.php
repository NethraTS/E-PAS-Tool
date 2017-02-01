<?php

$m=new MongoClient();
$db=$m->goals1;
$c = $db->selectCollection('BasicDetails');

$id = $_POST['id'];
//$id="1066";

//$docs=$c->find(array('id'=>$id));
$docs1=$c->find(array('id'=>$id));
$i=-1;
foreach($docs1 as $doc)
{

$b = array('email' => $doc["emailID"],'empname' => $doc["name"], 'manager' => $doc["r1name"],'desgn' => $doc["desgn"]);

//$b[++$i]=$doc["emailid"];
//$b[++$i]=$doc["r1name"];

}
echo json_encode($b);
//var_dump($d);
?>
