<?php

$m=new MongoClient();
$db=$m->goals1;

$c1 = $db->selectCollection('RelievingInfo');
$c = $db->selectCollection('BasicDetails');
$id = $_POST['id'];
//$id="1066";
$docs1=$c->find(array('name'=>$id));
foreach($docs1 as $doc)
{

$b1 = array('Name' => $doc["name"]);

//$b[++$i]=$doc["emailid"];
//$b[++$i]=$doc["r1name"];

}
//$docs=$c->find(array('id'=>$id));
$docs2=$c1->find(array('id'=>$id));

foreach($docs2 as $doc1)
{

$b1 = array('Role' => $doc1["role"], 'DOJ' => $doc1["doj"],'LWD' => $doc1["lwd"],'Name' => $doc1["Name"]);

//$b[++$i]=$doc["emailid"];
//$b[++$i]=$doc["r1name"];

}
echo json_encode($b1);
//var_dump($d);
?>
