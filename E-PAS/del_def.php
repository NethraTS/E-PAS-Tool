<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$dc = $db->goal_definition;
$goal=strtoupper($_GET['goal']);
$def=strtoupper($_GET['def']);
$goal=trim($goal);
$def=trim($def);
$dc->update(array('goal'=>$goal), array('$pull' => array('definition'=>array('name'=>$def)))); 
echo "inserted successfully";	
?>