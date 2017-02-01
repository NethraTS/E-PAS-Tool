<?php
include 'secure.php';
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$c=$db->currentReviewCycle;
$bd=$db->BasicDetails;

$posted_data = $_POST['json'];
$data =json_decode($posted_data,true);

$d=$c->findOne(array("psiid"=>$data[0]));

if($d["flag2"]=="0")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("flag2"=>"1")));

$c->update(array("psiid" => $data[0]),array('$set'=>array("overallselfrating"=>encrypt($data[1]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array("personalcomments"=>encrypt($data[2]))));

$c->update(array("psiid" => $data[0]),array('$set'=>array(
"q1"=>$data[3],
"q2"=>$data[4],
"q3"=>$data[5],
"q4"=>$data[6],
"q5"=>$data[7],
"q6"=>$data[8],
"q7"=>$data[9],
"q8"=>$data[10],
"q9"=>$data[11],
"q10"=>$data[12],
"q11"=>$data[13],
"q12"=>$data[14]
)));

}
elseif($d["flag2"]=="1")
{
$c->update(array("psiid" => $data[0]),array('$set'=>array("overallselfrating"=>encrypt($data[1]))));
$c->update(array("psiid" => $data[0]),array('$set'=>array("personalcomments"=>encrypt($data[2]))));
$c->update(array("psiid" => $data[0]),array('$set'=>array(
"q1"=>$data[3],
"q2"=>$data[4],
"q3"=>$data[5],
"q4"=>$data[6],
"q5"=>$data[7],
"q6"=>$data[8],
"q7"=>$data[9],
"q8"=>$data[10],
"q9"=>$data[11],
"q10"=>$data[12],
"q11"=>$data[13],
"q12"=>$data[14]
)));
}
elseif($d["flag2"]=="2")
{
if($d["flag1"]=="2" && $d["mailsent"]=="0")
{
$r1=$bd->findOne(array("name"=>$d["r1name"]));
$en=$bd->findOne(array("psiid"=>$data[0]));
$empname=$en["name"];
$mailid=$r1["emailID"];
$subject="Self-Apprasial submitted by ".$empname;
$msg=$empname." has completed the self-appraisal form. You can now schedule a meeting and do the review";
if(mail($mailID,$subject,$msg))
$c->update(array("psiid"=>$data[0]),array('$set'=>array("mailsent"=>"1")));
}
} 
print_r($data);

?>
