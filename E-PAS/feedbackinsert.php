<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->goals1;
$c=$db->GoalsToBeReviewed;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);
//var_dump($data);

$doc=$c->findOne(array("id"=>$data[0]));

//if($doc["flag"]=="0"||$doc["flag"]=="1")
{	  
  //var_dump($data);
	$length=count($data);
	$forlooplimit=intval(ceil($length/3));
 $x=2;
 $dc=1;
 	//store the measurements and descriptions for each category
	for($i=1;$i<$forlooplimit;$i++)
	{
		if(strpos($data[$x],"d")===0)
		{
			
			if(empty($data[$x+1]) && empty($data[$x+2]))
			{
				$x=$x+3;
			}
			else {		
				$newdata = array("r1overallcomment"=> array(
					"date"=>$data[1],
					"goal"=>($data[++$x]),
					"measure"=>($data[++$x]),
					"comment"=>($data[++$x])
			));
				++$x;
				$dc++;
				$c->update(array("id" => $data[0]),array('$addToSet'=>$newdata));
				
			}
		}
		
	}
	
	
}
?>