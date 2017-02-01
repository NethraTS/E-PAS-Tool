

<form class="form-horizontal" action="batch_goaldefinition.php" method="post" enctype="multipart/form-data">
<div class="form-group">
<label style="color:red">Upload .xls file </label> <br>
<input type="file" name="libfile" accept=".xls" />
</div> <br>
<button class="btn btn-theme03 btn-sm" type="submit" name="lib" value="lib"><i class="fa fa-spinner"></i>
&nbsp Upload</button>
</form> 

<?php
$con = new Mongo;
$db = $con->goals1;

$c = $db->selectCollection('goal_definition');
//db.goal_definition.update({"definition.name":"AUTOMATION WITH ZERO SCRIPT REJECTION"},{$set:{"definition.$.category":"TEST AND AUTOMATION"}},{upsert:true});
if(isset($_POST['lib']))
{
include 'reader.php';
$excel = new Spreadsheet_Excel_Reader();
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/E-PAS/xlsrepo/');


	//defined the image size
	define('MAX_FILE_SIZE', 2000000);
	$fileName = $_FILES['libfile']['name'];
	$tmpName = $_FILES['libfile']['tmp_name'];
	$fileSize = $_FILES['libfile']['size'];
	$fileType = $_FILES['libfile']['type'];
	// get the file extension 

$ext = substr(strrchr($fileName, "."), 1);
	//Added by Rajesh to check on the file format which is getting uploaded
	if ($ext != "xls") {
	header('location:batch_goaldefinition.php?status="Please upload .xls format. Try Again!!!"'); 
	exit;
	}
	// generate the random file name
	$randName = md5(rand() * time());

	// image name with extension
	$myfile = $randName . '.' . $ext;
	// save image path
	$path = UPLOAD_PATH . $myfile;
	//echo $fileSize;
	if ($fileSize > 0 && $fileSize <= MAX_FILE_SIZE) {
		//echo "$path\n";
		//echo "$tmpName\n";
		//store image to the upload directory
		$result = move_uploaded_file($tmpName,$path);



		if (!$result) {
			//echo "Error uploading file";
			header('location:batch_goaldefinition.php?status="Error uploading File"'); 
			exit;
		}else {

			$xlsfile = "xlsrepo/".$myfile;
		//	echo $xlsfile;
		}
	}

 $excel->read($xlsfile);
$x=1;
$header=array("name","category"); //first row of xls file       
$body=array();      //content of the xls file 
echo "<table>";
while($x<=$excel->sheets[0]['numRows']) { // reading row by row
	echo "\t<tr>\n";
	$y=1;
	while($y<=$excel->sheets[0]['numCols']) {// reading column by column
		$cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
/*
		if($x==1)  //get the first row for header
		{				            
			$header[$x][$y]=$cell;  //to store xls header
		}
		else{
			$body[$x][$y]=$cell;  //to store xls content
		} */
		$body[$x][$y]=$cell;  //to store xls content
		echo "\t\t<td>$cell</td>\n";  // get each cells values
		$y++;
	}  
	 echo "\t</tr>\n";
	$x++;
}
echo "</table>";
 var_dump($header);
 
 
$finalArray=array();  
//Need to change the goal value manualy in below line
$c->insert(array("goal"=>"QUALITY","definition"=>array()));

foreach($body as $i)
{
		
	$finalArray=array_combine($header,$i); 	
	var_dump($finalArray);
	$c->update(array("goal"=>"QUALITY"),array('$push'=>array("definition"=>$finalArray)));	    
	//$c->update(array("goal"=>"DELIVERABLES"),array('$set'=>array("definition.name"=>"TEST AND AUTOMATION exaasdasmple","definition.category"=>"TEST AND AUTOMATION exaasdasmple")),array("upsert"=>"true"));
	//$json.=json_encode($finalArray).",";
}        
//	$c->update(array("definition.name"=>"AUTOMATION WITH ZERO SCRIPT REJECTION"),array('$set'=>array("definition.$.category"=>"TEST AND AUTOMATION exaasdasmple")));
//$c->update(array("goal"=>"DELIVERABLES"),array('$set'=>array("definition.name"=>"TEST AND AUTOMATION exaasdasmple","definition.category"=>"TEST AND AUTOMATION exaasdasmple")),array("upsert"=>"true"));
//$c->update(array("goal"=>"DELIVERABLES"),array('$set'=>array("definition.$.category"=>"TEST AND AUTOMATION exaasdasmple")),array("upsert"=>"true"));
//$c->update(array("goal"=>"DELIVERABLES"),array('$push'=>array("definition"=>array("name"=>"asa","category"=>"asda"))));
unlink($path); //delete the document from xlsrepo directory

  }


//$c->insert(array("goal"=>"DELIVERABLES","definition"=>array("name"=>"asasd","category"=>"demo","default_text"=>"")));
//$c->update(array("definition.name"=>"AUTOMATION WITH ZERO SCRIPT REJECTION"),array('$set'=>array("definition.$.category"=>"TEST AND AUTOMATION exaasdasmple")));
//echo "updated";

?>
