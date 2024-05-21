<?php
ob_start();

include_once("global.php");

global $productClass,$webClass,$dbF,$functions,$db;

$assign_id 	= $_GET['assignid'];
$user_id 	= $_GET['user'];

$test_id = $assign_id.':'.$user_id;

$userDetail = $functions->getWebUser($user_id, 'acc_name');

$sql = "SELECT * FROM `test_result` WHERE `test_id` = ?";
$res = $dbF->getRows($sql, array($test_id));

$sqlPaper = "SELECT * FROM `paper` p JOIN `assigned_paper` ap ON p.`paper_id` = ap.`assign_paper` WHERE ap.`assign_id` = ?";
$resPaper = $dbF->getRow($sqlPaper);

$paperQues = json_decode($resPaper['paper_questions']);
$paperDoamin = $resPaper['paper_questions'];
$total_ques = $resPaper['total_questions'];

$question_answer = array();

foreach ($paperQues as $key => $value) {
	foreach ($value as $row) {
		$sqlCorrect = "SELECT `correct_opt` FROM `questions` WHERE `question_id` = ?";
		$resCorrect = $dbF->getRow($sqlCorrect, array($row));
		$question_answer[$row] = $resCorrect['correct_opt'];
	}
}

foreach ($paperQues as $key => $value) {

	$domain_id = $key;
	$domainDet = $functions->getSubject($domain_id, 'subject_title');
	$domain_name = $domainDet['subject_title'];

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
	echo $domainCorrectCount.'<br>';
}



