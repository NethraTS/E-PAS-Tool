<?php

function verifyUser($userID, $userPasswd) {
//echo "success";
$link = mysql_connect('65.49.80.204', 'paxtoolslogin', '3ptac#');

if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db('Pax_2015',$link)) {
    echo "Could not select database";
    exit;
} else {
//    echo "Selected the database\n";
}

$sql = "select * from employee_master where employee_id=\"$userID\" and password=aes_encrypt(\"$userPasswd\",'pax123')";

#echo "$sql\n";
$result = mysql_query($sql, $link);

$success = '';
if (!$result) {
    //echo "Some issue\n";
    echo mysql_error();
} else {
//    echo "Inside the else condition\n";
    while ($row = mysql_fetch_assoc($result)) {
         if($row['employee_id']) {
            $success=$row['employee_name'];
         }
    }
}

mysql_close($link);
//echo "success flag is $success\n";

return $success;
//echo "Connected successfully\n";
}

?>
