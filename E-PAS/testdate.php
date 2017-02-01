<?php
$today=date("d-m-Y");
$datetime1 = new DateTime("24-02-2015");
$datetime3 = new DateTime($today);
$datetime2 = new DateTime("26-02-2015");
$interval = $datetime3->diff($datetime2);
$diff=$interval->format('%R%a');
//if($diff=="+2")
echo $diff;
echo " ";
echo " ";
echo $today;
?>