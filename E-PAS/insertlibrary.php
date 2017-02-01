<?php
require('db.php');
require('auth.php');
include 'reader.php';
$excel = new Spreadsheet_Excel_Reader();
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/appraisalmanagement/xlsrepo/');


//defined the image size
define('MAX_FILE_SIZE', 2000000);

$collection = $db->library;
$fileName = $_FILES['libfile']['name'];
   $tmpName = $_FILES['libfile']['tmp_name'];
   $fileSize = $_FILES['libfile']['size'];
   $fileType = $_FILES['libfile']['type'];
   

// get the file extension 
   $ext = substr(strrchr($fileName, "."), 1);
   // generate the random file name
   $randName = md5(rand() * time());

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
         echo "Error uploading file";
         exit;
      }else {
   
$xlsfile = "xlsrepo/".$myfile;
    
      }
      }
      

?>

  <!--  <table border="1"> -->
<?php

        $excel->read($xlsfile); // set the excel file name here  
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
        
      	
      	;
   /* to map header key with content as value*/     	
       	$finalArray=array();  
 			
			$json="["; 
 			foreach($body as $i)
 			{
 
			$finalArray=array_combine($hArray,$i);   //used combine header value as key and content as
			try{
        // Geting MongoDB
        
 
        // Getting MongoCollection
            //    $collection->ensureIndex(array('PSIID' => 1), array('unique' => 1));
        	$collection->insert($finalArray);
			header('location:manage.php?status=libinserted');        
    		}catch(MongoException $mongoException){
        	print $mongoException;
       
    		}			 
			 			
 			//$json.=json_encode($finalArray).",";
 			}        
			//$doc= rtrim($json,",");
 			//$doc= $doc."]";
		//	echo $finalArray; 			
 		 
 		unlink($path); //delete the document from xlsrepo directory
			
			
        
        
        ?>    

