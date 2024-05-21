<?php
ob_start();

include_once("global.php");

global $productClass,$webClass,$dbF,$functions,$db;

$assign_id 	= htmlspecialchars($_GET['assignid']);
$user_id 	= htmlspecialchars($_GET['user']);

$test_id = $assign_id.':'.$user_id;

$userDetail = $functions->getWebUser($user_id, 'acc_name');
$user_name = $userDetail['acc_name'];

$roll = $functions->getWebUser($user_id, 'roll');



$rolln = $roll['roll'];

$sqlPaper = "SELECT *,ap.`date_timestamp` AS 'exam_date' FROM `paper` p JOIN `assigned_paper` ap ON p.`paper_id` = ap.`assign_paper` WHERE ap.`assign_id` = ?";
$resPaper = $dbF->getRow($sqlPaper, array($test_id));

$pass_percent = $functions->ibms_setting('passing percent');

$paperQues = json_decode($resPaper['paper_questions']);
$paperDoamin = $resPaper['paper_questions'];
$total_ques = $resPaper['total_questions'];
$paper_title = $resPaper['paper_title'];
$pass_top = $resPaper['pass_top'];
$fail_top = $resPaper['fail_top'];
$result_bottom = $resPaper['result_bottom'];
$apDateTimestamp = explode(' ',$resPaper['exam_date']);
$exam_date = $apDateTimestamp[0];
$completion_date   = $resPaper['completion_date'];
$question_answer = array();

foreach ($paperQues as $key => $value) {
	foreach ($value as $row) {
		$sqlCorrect = "SELECT `correct_opt` FROM `questions` WHERE `question_id` = ?";
		$resCorrect = $dbF->getRow($sqlCorrect, array($row));
		$question_answer[$row] = $resCorrect['correct_opt'];
	}
}

// $dbF->prnt($question_answer);

$totalPassQues = 0;
$domainResult = '';
foreach ($paperQues as $key => $value) {

	$domain_id = $key;
	$domainDet = $functions->getSubject($domain_id, 'subject_title');
	$domain_name = $domainDet['subject_title'];
	$domain_total = count($value);

	$sqlResQuestion = "SELECT `question_id`,`chosen_option` FROM `test_result` WHERE `test_id` = ? AND `subjectId` = ? AND `chosen_option` IS NOT NULL";
	$resResQuestion = $dbF->getRows($sqlResQuestion, array($test_id, $domain_id));

	$domainCorrectCount = 0;
	foreach ($resResQuestion as $keyRes => $valueRes) {
		$chosen = $valueRes['chosen_option'];
		$questi = $valueRes['question_id'];
		if($chosen == $question_answer[$questi]){
			$domainCorrectCount++;
		}	
	}
	$totalPassQues += $domainCorrectCount; 

	$domainResult .= '<tr>
						<td class="table_left detail_lebel">'.$domain_name.'</td>
						<td class="table_center detail_lebel">'.$domain_total.'</td>
						<td class="table_center detail_lebel">'.$domainCorrectCount.'</td>
					</tr>';
	//echo $domain_name.' | '.$domain_total.' | '.$domainCorrectCount.'<br>';
}

$obtain_perc = ($totalPassQues/$total_ques)*100;

if($obtain_perc >= $pass_percent){
	$result = 'PASS';
	$result_top = $pass_top;
}else{
	$result = 'FAIL';
	$result_top = $fail_top;
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Dental Consulting Services | Smart Dental Compliances</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo WEB_URL ?>/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo WEB_URL ?>/favicon.png" type="image/x-icon"/>
    <!--Bootstrap css file-->
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/other.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/button.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/style.css">
    
    <!-- DESKTOP -->
    <link href="<?php echo WEB_URL ?>/css/style-desktop.css" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1420px)">
    <!-- TABLET -->
    <link href="<?php echo WEB_URL ?>/css/style-tablet.css" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
    <!-- MOBILE -->
    <link href="<?php echo WEB_URL ?>/css/style-mobile.css" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
    <!-- MOBILE SMALL-->
    <link href="<?php echo WEB_URL ?>/css/style-mobile-small.css" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)"> 

	<style type="text/css">
		body{
			background-color: #fff;
		}
		.result_main{
			width: 650px;
		    position: relative;
		    margin: 0 auto;
		    /*border: 2px solid #dcdada;*/
		    padding: 20px;
		    font-size: 100%;
		}

		.logo img{
		    width: 200px;
		    margin-bottom: 15px;
		}

		.center {
			text-align: center;
		}

		.paper_title{
			margin-bottom: 30px;
			font-size: 15px;
			font-weight: bold;
		}

		.paper_title p{
			margin-bottom: 0px;
		}

		.personal_detail{
			width: 55%;
		}

		.detail_lebel{
			font-weight: bold;
		}

		.result{
			font-weight: bold;
			margin-top: 15px;
			margin-bottom: 15px;
		}

		.result_top, .result_bottom{
			margin-bottom: 15px;
			text-align: justify;
		}

		.result_bottom{
			margin-top: 15px;
			text-align: justify;
		}

		.table_center{
			text-align: center;
		}

		.table_left{
			text-align: left;
			font-weight: bold;
		}

		body:before {
			background-color: white;
		}

		table th{
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="result_main">
		<div class="center content_logo">
		    <div class="logo"> <img src="<?php echo WEB_URL ?>/webImages/logo.png" alt=""> </div>
		    <!-- logo_animation close -->
		    <!-- <div class="logo_text"> <img src="webImages/2.png" alt=""> </div> -->
		    <!-- logo_text close -->
		</div>
		<div class="center paper_title">
			<p>Official Result</p>
			<p><?php echo $paper_title; ?></p>
		</div>
		<div class="personal_detail">
			<table>
				<tr>
					<td class="detail_lebel">Name</td>
					<td>:</td>
					<td style="
    white-space: nowrap;
">&nbsp;&nbsp;&nbsp;<?php echo $user_name; ?></td>
				</tr>
				<tr>
					<td class="detail_lebel">Examination Registration Number</td>
					<td>:</td>
					<td>&nbsp;&nbsp;&nbsp;<?php echo $assign_id; ?></td>
				</tr>
				<tr>
					<td class="detail_lebel">Examination Date</td>
					<td>:</td>
					<td>&nbsp;&nbsp;&nbsp;<?php

    $completion_date     = date('d-m-Y', strtotime($completion_date));

					 echo $completion_date; ?></td>
				</tr>


					<tr>
					<td class="detail_lebel">Enrollment Number</td>
					<td>:</td>
					<td>&nbsp;&nbsp;&nbsp;<?php echo $rolln; ?></td>
				</tr>



			</table>

			<p class="result">Result : <?php echo $result; ?></p>
		</div>
		<div class="result_top">
			<?php echo $result_top; ?>
		</div>

		<?php 	
// var_dump($result);
		// if($result == "PASS"){}elseif($result == "FAIL"){

		 ?>
		<!-- <div class="result_detail">
			<table>
				<thead>
					<tr>
						<th class="table_left">Domain</th>
						<th class="table_center">Total Items</th>
						<th class="table_center">Your Results</th>
					</tr>
				</thead>
				<tbody>
					<?php #echo $domainResult; ?>
				</tbody>
			</table>
		</div> -->

		<div class="result_bottom">
			<?php echo $result_bottom; ?>

		</div>


<div class="center paper_title" style="
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
">
			
			<p><?php echo $functions->ibms_setting('Site Name'); ?></p>
		</div>

	</div>
</body>
</html>