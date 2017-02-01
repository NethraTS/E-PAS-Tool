<?php
ob_start();
//session_start();include session_timeout.php;
//include 'secure.php';
//require('auth.php');
require('php2pdf/WriteHTML.php');
$m=new MongoClient();
$db=$m->goals1;


$info=$db->RelievingInfo;
$details=$db->RelievingDetails;
$id=$_REQUEST['id'];

$infoCol=$info->find(array("id"=>$id));
$detailCol=$details->find(array("id"=>$id));

/* to fetch info */
$infostr="";

/*foreach($infoCol as $infoArray)
{
	foreach($infoArray as $infodetails)
	{
		//echo $infodetails;
		$infostr.=$infodetails.", ";
	}
	$infostr.="\n";
} */

foreach($infoCol as $infoArray)
{
	$eid=$infoArray['id'];
	$role=$infoArray['role'];
	$doj=$infoArray['doj'];
	$e_email=$infoArray['EmployeeEmail'];
	$m_name=$infoArray['ManagerName'];
	$sdate=$infoArray['StartDate'];
	$lwd=$infoArray['lwd'];
	$e_name=$infoArray['Name'];
		
}


/* to fetch details */
foreach($detailCol as $detailArray)
{
	$e_id=$detailArray['id'];
	$c1=$detailArray['Comment1'];
	$c2=$detailArray['Comment2'];
	$c3=$detailArray['Comment3'];
	$c4=$detailArray['Comment4'];
	$c5=$detailArray['Comment5'];
	$c6=$detailArray['Comment6'];
	$c7=$detailArray['Comment7'];
	$c8=$detailArray['Comment8'];
	$c9=$detailArray['Comment9'];
	$c10=$detailArray['Comment10'];
	$c11=$detailArray['Comment11'];
	$c12=$detailArray['Comment12'];
	$mc1=$detailArray['mComment1'];
	$mc2=$detailArray['mComment2'];
	$mc3=$detailArray['mComment3'];
	$mc4=$detailArray['mComment4'];
	$mc5=$detailArray['mComment5'];
	$mc6=$detailArray['mComment6'];
	$mc7=$detailArray['mComment7'];
	$mc8=$detailArray['mComment8'];
	$mc9=$detailArray['mComment9'];
	$mc10=$detailArray['mComment10'];
	$mc11=$detailArray['mComment11'];
	$mc12=$detailArray['mComment12'];
   $dt=$detailArray['datecapture'];
}


$pdf=new PDF_HTML();

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);

$pdf->AddPage();
$pdf->Image('logo1.png',18,13,50);
$pdf->WriteHTML('<br><br><br><br>');

$pdf->SetMargins(15, 11, 15);

//$pdf->SetRightMargin(20);
//$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial','',10);
/*
$pdf->SetLeftMargin(20);
$pdf->WriteHTML('<table border="1">');
$pdf->SetFont('Arial','B',14);
$html = '<p> <b> <i> ACCEPTANCE OF RESIGNATION & NON-COMPETE CLAUSE </i></b> </p>';
//$pdf->WriteHTML('<p>'.$infostr.'</p>'); 
$pdf->WriteHTML("$html");

$pdf->SetFont('Arial','',12);
$html = '<br><br><br><p>           We are in receipt of your letter dated  '.$lwd.'  resigning from the services of the company. Your last working day would be on '.$lwd.' . You are requested to perform the assigned work with commitment and accountability. For a smooth exit formalities HR team should get a clearance email and NDA signed by the project manager. While serving notice if we could see any disconnect or breaching the employment terms then the company management have full rights to take the action but no limited to termination of employment.Please note that this letter is issued to you indicating acceptance of your resignation by the management. Final relieving and experience letter will be issued on the day of relieving.Company can terminate this agreement at any point of time if the performance of the employee does not meet company expectations.  </p>';
$pdf->SetLeftMargin(10);
$pdf->WriteHTML("$html");

$html = '<br><br><p><b>Non-Compete Clause : </b> </p><br><br>';
$pdf->WriteHTML("$html");

$pdf->WriteHTML('<p>1.</p>');
$pdf->SetLeftMargin(15);
$html = '<p>For six (06) months period following the termination of employee’s employment, employee shall not in any capacity, directly or indirectly advise, manage, consult, render or perform services to or for any person or entity or any customer of company which is engaged in a business competitive to that of the company or its customers with whom employee has engaged within any geographical location wherein the company produces, sells or markets its product and services at the time of such termination.  </p><br><br>';
$pdf->WriteHTML("$html");
$pdf->SetLeftMargin(10);

$pdf->WriteHTML('<p>2.</p>');
$pdf->SetLeftMargin(15);
$html = '<p>Employee who has worked for multiple customer accounts or customer projects with the company in the past 6 months period, Non-compete clause 1 is applicable for all accounts he worked for. </p><br><br>';
$pdf->WriteHTML("$html");
$pdf->SetLeftMargin(10);

$pdf->WriteHTML('<p>3.</p>');
$pdf->SetLeftMargin(15);
$html = '<p>For a period of six (6) months following the termination of employment with company for any reason, employee will not: </p><br><br>';
$pdf->WriteHTML("$html");
$pdf->SetLeftMargin(10);

<br> <p> Date                    :  </p>
<br> <p> Employee Name :  </p>
<br> <p> Employee ID       :  </p>

*/

//Non-Compete Clause
$html = '<table border="1" ><th><center>                                              <b> <u> ACCEPTANCE OF RESIGNATION & NON-COMPETE CLAUSE </u> </b> </center> </th> <br> <br>

<br>
<td>
<p>Hello '.$e_name.', </p><br><br>
<p>We are in receipt of your letter dated  <u> '.$sdate.' </u>  resigning from the services of the company. Your last working day would be on  <u>'.$lwd.' </u>. </p> <br><br> 
<p>You are requested to perform the assigned work with commitment and accountability. For a smooth exit formalities HR team should get a clearance email and NDA signed by the project manager. While serving notice if we could see any disconnect or breaching the employment terms then the company management have full rights to take the action but no limited to termination of employment. </p> <br> <br>
<p>Please note that this letter is issued to you indicating acceptance of your resignation by the management. Final relieving and experience letter will be issued on the day of relieving. </p><br><br>
<p>Company can terminate this agreement at any point of time if the performance of the employee does not meet company expectations.  </p>
<br><br><p><b><u>Non-Compete Clause:</u></b> </p><br><br>
<p>  1. </p>
<p>  For six (06) months period following the termination of employee’s employment, employee shall not in any capacity, directly or indirectly advise, manage, consult, render or perform services to or for any person or entity or any customer of company which is engaged in a business competitive to that of the company or its customers with whom employee has engaged within any geographical location wherein the company produces, sells or markets its product and services at the time of such termination.  </p><br><br>
<p>  2. </p>
<p>  Employee who has worked for multiple customer accounts or customer projects with the company in the past 6 months period, Non-compete clause 1 is applicable for all accounts he worked for. </p><br><br>
<p>  3. </p>
<p>  For a period of six (6) months following the termination of employment with company for any reason, employee will not: </p><br><br>
<p>  a. </p>
<p>  Accept any offer of employment from any Customer, where employee had worked in a professional capacity with that Customer in the twelve (12) months immediately preceding the termination of employee employment with Company;</p> <br><br>
<p>  b. </p>
<p>  Accept any offer of employment from a Named Competitor of Company, if employment with such Named Competitor would involve employee having to work with a Customer with whom employee had worked in the twelve (12) months immediately preceding the termination of employee employment with company.</p><br><br>
<p>For the purposes of this Addendum, "Named Competitor" shall mean companies that extend similar or same services to the customer.</p><br><br>
<p>THE UNDERSIGNED HAS READ THIS AGREEMENT IN ITS ENTIRETY AND UNDERSTANDS IT.</p><br><br>

<p>Employee Name     : '.$e_name.' </p><br><br>
<p>Reporting Manager  : '.$m_name.' </p><br>
<p>Data & Time  : '.$dt.' </p>

</td>
</table>';

$pdf->WriteHTML("$html");


//Employee Feedback Form
$pdf->AddPage();
$pdf->Image('logo1.png',18,13,50);
$pdf->WriteHTML('<br><br><br><br><br>');
$pdf->SetFont('Arial','',10);

$html = '<table border="1" ><td><b>                                                                     <u>EXIT INTERVIEW FORM</u>: </b> <br><br>
<p>Name                   : </p> '.$e_name.' <br>
<p>Project                 : </p> '.$c3.' <br>
<p>Designation         : </p> '.$role.' <br>
<br><br>
<p>1) What promoted you to seek alternative employment ?</p> <br> <p>   '.$c7.' </p> <br><br>
<p>2) What do you value/dislike about the Job ?</p> <br> <p>   '.$c8.' </p> <br><br>
<p>3) What are your views about Management and leadership, in general, in the job ?</p> <br> <p>   '.$c9.' </p> <br><br>
<p>4) What does your new job offer that your job with this company does not ?</p> <br> <p>   '.$c10.' </p> <br><br>
<p>5) Can you offer any other comments that will enable us to understand why you are leaving, how we can improve?</p> <br> <p>   '.$c11.' </p> <br><br>
<p>6) What we can do to become a better company ?</p> <br> <p>   '.$c12.' </p> <br><br>

</td>
</table>';
$pdf->WriteHTML("$html");


//Manager Feedback Form
$pdf->AddPage();
$pdf->Image('logo1.png',18,13,50);
$pdf->WriteHTML('<br><br><br><br><br>');
$pdf->SetFont('Arial','',10);

$html = '<table border="1" ><td><b>                                                                     <u>MANAGER FEEDBACK FORM</u>: </b> <br><br>

<p>1) Why are you leaving?</p> <br> <p>   '.$mc1.' </p> <br><br>
<p>2) Was your work challenging?</p> <br> <p>   '.$mc2.' </p> <br><br>
<p>3) What are your views about Management and leadership, in general, in the job?</p> <br> <p>   '.$mc3.' </p> <br><br>
<p>4) What three things could your company do to improve?</p> <br> <p>   '.$mc4.' </p> <br><br>
<p>5) Did you feel you were kept up to date on new developments and company policies?</p> <br> <p>   '.$mc5.' </p> <br><br>
<p>6) Were you given the tools to succeed at your job?</p> <br> <p>   '.$mc6.' </p> <br><br>
<p>7) What was your best or worst day on the job?</p> <br> <p>   '.$mc7.' </p> <br><br>
<p>8) If you had a friend looking for a job, would you recommend us? Why or why not?</p> <br> <p>   '.$mc8.' </p> <br><br>
<p>9) Are there any other unresolved issues or additional comments?</p> <br> <p>   '.$mc9.' </p> <br><br>

</td>
</table>';
$pdf->WriteHTML("$html");



$pdf->Output(); 


?>
