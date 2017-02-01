<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
//$c=$db->AppraisalManagement;
$dc = $db->selectCollection('designationCategories');

$cate = strtoupper($_POST['cate']);
//var_dump($cate);
$cate=trim($cate);

$allcate=$dc->find();

foreach($allcate as $doc)
{
	if($doc["category"]==$cate)
	{
		echo "This category already exists";
		exit();		
	}
} 
$dc->insert(array("category"=>$cate,"flag"=>"0"));
echo "inserted successfully";	
?>
