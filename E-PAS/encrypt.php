<?php 
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$coll=$db->currentReviewCycle;

$alldoc=$coll->find();
//var_dump($doc);

foreach($alldoc as $doc)
{
if(in_array($doc["psiid"],$updatedrecord))
{break;}
else 	
array_push($updatedrecord,$doc["psiid"]);
	
if(!empty($doc["normalisedRating"]))
$update_array["normalisedRating"]=encrypt($doc["normalisedRating"]);

if(!empty($doc["overall R1rating"]))
$update_array["overall R1rating"]=encrypt($doc["overall R1rating"]);

if(!empty($doc["overall R2rating"]))
$update_array["overall R2rating"]=encrypt($doc["overall R2rating"]);

if(!empty($doc["overall R3rating"]))
$update_array["overall R3rating"]=encrypt($doc["overall R3rating"]);

if(!empty($doc["overallselfrating"]))
$update_array["overallselfrating"]=encrypt($doc["overallselfrating"]);

if(!empty($doc["personalcomments"]))
$update_array["personalcomments"]=encrypt($doc["personalcomments"]);

if(!empty($doc["r1 feedback"]))
$update_array["r1 feedback"]=encrypt($doc["r1 feedback"]);

if(!empty($doc["r2 feedback"]))
$update_array["r2 feedback"]=encrypt($doc["r2 feedback"]);

if(!empty($doc["r3 feedback"]))
$update_array["r3 feedback"]=encrypt($doc["r3 feedback"]);

if(!empty($doc["selfRatings"]))
$update_array["selfRatings"]=
array("deliverables"=>encrypt($doc["selfRatings"]["deliverables"]),
"quality"=>encrypt($doc["selfRatings"]["quality"]),
"competency"=>encrypt($doc["selfRatings"]["competency"]),
"organisationalContribution"=>encrypt($doc["selfRatings"]["organisationalContribution"]),
"valueAddition"=>encrypt($doc["selfRatings"]["valueAddition"])
);

if(!empty($doc["reviewer1Ratings"]))
$update_array["reviewer1Ratings"]=
array("deliverables"=>encrypt($doc["reviewer1Ratings"]["deliverables"]),
"quality"=>encrypt($doc["reviewer1Ratings"]["quality"]),
"competency"=>encrypt($doc["reviewer1Ratings"]["competency"]),
"organisationalContribution"=>encrypt($doc["reviewer1Ratings"]["organisationalContribution"]),
"valueAddition"=>encrypt($doc["reviewer1Ratings"]["valueAddition"])
);

$appraisal_array=array();

if(!empty($doc["appraisal"]))
{
for($i=0;$i<count($doc["appraisal"]);$i++)
{
if(empty($doc["appraisal"][$i]["reviewer1comment"]))
{
array_push($appraisal_array,
array("parameter"=>$doc["appraisal"][$i]["parameter"],
"cnt"=>$doc["appraisal"][$i]["cnt"],
"goal"=>encrypt($doc["appraisal"][$i]["goal"]),
"accomplishment"=>encrypt($doc["appraisal"][$i]["accomplishment"]),
));
}
else 
{
array_push($appraisal_array,
array("parameter"=>$doc["appraisal"][$i]["parameter"],
"cnt"=>$doc["appraisal"][$i]["cnt"],
"goal"=>encrypt($doc["appraisal"][$i]["goal"]),
"accomplishment"=>encrypt($doc["appraisal"][$i]["accomplishment"]),
"reviewer1comment"=>encrypt($doc["appraisal"][$i]["reviewer1comment"])
));
}
}
}


if(!empty($update_array))
$coll->update(array("psiid"=>$doc["psiid"]),array('$set'=>$update_array));

if(!empty($appraisal_array))
$coll->update(array("psiid"=>$doc["psiid"]),array('$set'=>array("appraisal"=>$appraisal_array)));

unset($appraisal_array);
unset($update_array);

}
?>
