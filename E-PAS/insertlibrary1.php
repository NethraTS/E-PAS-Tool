<?php
session_start();include session_timeout.php;
include 'reader.php';
$excel = new Spreadsheet_Excel_Reader();

$db=new MongoClient();
$c= $db->AppraisalManagement1;
//$c=$db->appraisalmgmt;
$collection=$c->xlsupload;
$upl=$c->uploaded;
$n=$c->Notifications;
$crc=$c->currentReviewCycle;


$pod=$n->findOne(array("name"=>"portalOpening"));
$today = date("d-m-Y");
$today_time = strtotime($today);
//var_dump($pod);

if($pod==NULL)
{
	//echo "empty";

//	define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . 'xlsrepo/');
	define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/EPAS_test/E-PAS/E-PAS/xlsrepo/');


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
	header('location:adminsettings.php?status="Please upload .xls format. Try Again!!!"'); 
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
			header('location:adminsettings.php?status="Error uploading File"'); 
			exit;
		}else {

			$xlsfile = "xlsrepo/".$myfile;
			//echo $fileName;
		}
	}
}
elseif(strtotime($pod["Date"]) <= $today_time) 
{
	header('location:adminsettings.php?status="Review cycle has already begun.Cannot upload now."');        
	//echo $pod["Date"];
	//echo "Review cycle has already begun.Cannot upload now.";
	exit;
} 
else 
{
        
        define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/EPAS_test/E-PAS/E-PAS/xlsrepo/');
	//define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . 'xlsrepo/');

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
		header('location:adminsettings.php?status="Please upload .xls format. Try Again!!!"'); 
		exit;
	}
	
	
	// generate the random file name
	$randName = md5(rand() * time());

	$notify=$n->findOne(array("name"=>"portalOpening"));
        if ($notify['Date'] == " ") {
            $collection->drop();
            $crc->drop();
        }

	// image name with extension
	$myfile = $randName . '.' . $ext;
	// save image path
	$path = UPLOAD_PATH . $myfile;
	//echo $fileSize;
	if ($fileSize > 0 && $fileSize <= MAX_FILE_SIZE) {
		//echo $path;
		//store image to the upload directory
		$result = move_uploaded_file($tmpName,$path);
		if (!$result) {
			header('location:adminsettings.php?status="Error uploading file"');              
			//   echo "Error uploading file";
			exit;
		}else {

			$xlsfile = "xlsrepo/".$myfile;
			//echo $fileName;
		}
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
	}  
	// echo "\t</tr>\n";
	$x++;
}

$hArray=array();   //header array to store header of the xls file

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
	// $c=count($i);         
	// $c++;
	// $i[$c]="0";
	//var_dump($i);
	//echo count($i);			
	$finalArray=array_combine($hArray,$i);   //used combine header value as key and content as
	try{
		//Geting MongoDB


		// Getting MongoCollection
		$collection->ensureIndex(array('PSIID' => 1), array('unique' => 1));
		$collection->insert($finalArray);
		header('location:createcollections.php?status=libinserted');        
	}catch(MongoException $mongoException){
		header('location:adminsettings.php?status="Duplicate Records are not inserted."');        

		//print $mongoException;
	}			 

	//$json.=json_encode($finalArray).",";
}        
//$doc= rtrim($json,",");
//$doc= $doc."]";
//	echo $finalArray; 			

unlink($path); //delete the document from xlsrepo directory



?>    

