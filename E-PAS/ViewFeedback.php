<?php

$m=new MongoClient();
$db=$m->goals1;

$c1 = $db->selectCollection('RelievingDetails');
//$c = $db->selectCollection('BasicDetails');
$id = $_POST['id'];
//$id="1058";
//$docs1=$c->find(array('name'=>$id));
/*foreach($docs1 as $doc)
{

$b1 = array('Name' => $doc["name"]);

//$b[++$i]=$doc["emailid"];
//$b[++$i]=$doc["r1name"];

}*/
//$docs=$c->find(array('id'=>$id));
$docs2=$c1->find(array('id'=>$id));

foreach($docs2 as $doc1)
{

$b1 = array('Comm1' => $doc1["mComment1"],'Comm2' => $doc1["mComment2"],'Comm3' => $doc1["mComment3"],'Comm4' => $doc1["mComment4"],'Comm5' => $doc1["mComment5"],'Comm6' => $doc1["mComment6"],'Comm7' => $doc1["mComment7"],'Comm8' => $doc1["mComment8"],'Comm9' => $doc1["mComment9"]);

//$b[++$i]=$doc["emailid"];
//$b[++$i]=$doc["r1name"];

}
echo json_encode($b1);
//var_dump($d);
?>
