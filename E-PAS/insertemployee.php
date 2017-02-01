<?php
session_start();include session_timeout.php;
include 'reader.php';
$excel = new Spreadsheet_Excel_Reader();

$db=new MongoClient();
$c= $db->goals1;

$collection=$c->currentGoalCycle;
$collection1=$c->xlsupload;
$basic=$c->BasicDetails;
	//echo "empty";

//	define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . 'xlsrepo/');
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
	header('location:employeedetails.php?status="Please upload .xls format. Try Again!!!"'); 
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
			header('location:employeedetails.php?status="Error uploading File"'); 
			exit;
		}else {

			$xlsfile = "xlsrepo/".$myfile;
			//echo $fileName;
		}
	}

 
   
?>
<?php
$excel->read($xlsfile);
$x=1;
$header=array(); //first row of xls file       
$body=array();      //content of the xls file 

while($x<=$excel->sheets[0]['numRows']) { // reading row by row
	//echo "\t<tr>\n";
	$y=1;
	while($y<=$excel->sheets[0]['numCols']) {// reading column by column
		$cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';

		if($x==1)  //get the first row for header
		{				            
			$header[$x][$y]=$cell;  //to store xls header
		}
		else{
			$body[$x][$y]=$cell;  //to store xls content
		}
		//echo "\t\t<td>$cell</td>\n";  // get each cells values
		$y++;
	}$body[$x][$y++]=0;  
	// echo "\t</tr>\n";
	$x++;
}

$hArray=array();   //header array to store header of the xls file
$hArray1=array("id","name","desgn","r1name","r1id","r2name","r2id","r3name","r3id","emailid","r1emailid","r2emailid","r3emailid","flag");
foreach($header as $row1)
{
	$i=0;
	foreach($row1 as $cell)
	{

		$hArray[$i]= $cell;  //read header cells and store in one array				
		$i++;
	}   
}
// $c=count($hArray);
// $hArray[$c]="flag";
//echo count($hArray);
// var_dump($hArray);


/* to map header key with content as value*/  

$finalArray=array();  

foreach($body as $i)
{
		
	$finalArray=array_combine($hArray,$i); 
	$finalArray1=array_combine($hArray1,$i);   //used combine header value as key and content as
	try{
		//Geting MongoDB


		// Getting MongoCollection
		//$collection->ensureIndex(array('PSIID' => 1), array('unique' => 1));
		$collection->insert($finalArray1);
			$basic->insert($finalArray1);
			$collection1->insert($finalArray);
		header('location:employeedetails.php?status=libinserted');        
	}catch(MongoException $mongoException){
		header('location:employeedetails.php?status="Duplicate Records are not inserted."');        

		//print $mongoException;
	}			 

	//$json.=json_encode($finalArray).",";
}        
		

unlink($path); //delete the document from xlsrepo directory

?>    

