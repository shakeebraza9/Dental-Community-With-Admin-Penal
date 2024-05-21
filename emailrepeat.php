<?php
include("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$date = Date('Y-m-d');
$q = "SELECT `id_user`,`setting_val` FROM `accounts_user_detail` WHERE `setting_val` IN ('Master','Practice') AND `id_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `notify` = '1') AND
`id_user` NOT IN(SELECT `acc_id` FROM `accounts_user`WHERE acc_type=0) AND
`id_user` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
`id_user` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) ))";
$datas = $dbF->getRows($q);
foreach ($datas as $key => $value) {
$MandatoryOverDueEvent = $functions->MandatoryOverDueEvent($value['id_user']);
$allApprovedEvent = $functions->allApprovedEvent($value['id_user']);
$allMandatoryUnApprovedEvent = $functions->allMandatoryUnApprovedEvent($value['id_user']);
$allMandatoryUnDueEvent = $functions->allMandatoryUnDueEvent($value['id_user']);
$allMandatoryDueEvent = $functions->allMandatoryDueEvent($value['id_user']);
$score = $MandatoryOverDueEvent - ($allApprovedEvent-($allMandatoryUnApprovedEvent-$allMandatoryUnDueEvent-$allMandatoryDueEvent));
if($score > 0){
	intval($value['id_user']);
	htmlspecialchars($score);
	//htmlspecialchars($date);
	 $sql = "INSERT INTO `warning` (`user`, `score`, `date`) VALUES (?,?,?)";
     $dbF->setRow($sql,array($value['id_user'],$score,$date));
}else{
	$sql = "DELETE FROM `warning` WHERE `user`= ?  ";
	$dbF->setRow($sql,array($value['id_user']));
}
}

/* Weekly email */

$sql = "SELECT * FROM `email_letters` WHERE `email_type` = 'weeklyEmail'";
$row = $dbF->getRow($sql);

// $chkDate = date('Y-m-d', strtotime('-6 days'));

// $sql = "SELECT * FROM `accounts_user` WHERE acc_id='2' #AND `weekly_email` < '$chkDate'";
$sql = "SELECT * FROM `accounts_user` WHERE `weekly_email` < DATE_ADD(CURDATE(), INTERVAL -6 DAY) AND `notify` = '1' AND
acc_type=1 AND
`acc_id` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
`acc_id` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) )";
$data = $dbF->getRows($sql);

foreach ($data as $key => $value) {

$id = intval($value['acc_id']);
$name = $value['acc_name'];
$email = $value['acc_email'];
// $email = 'm.anus@imedia.com.pk';
$dueEvent = $functions->dueEvent($id);
$overdueEvent = $functions->overdueEvent($id);
$newDocuments = $functions->newDocuments($id);

$content = "<b>Overdue Events</b>$overdueEvent<b>Due Events</b>$dueEvent<b>New Documents</b>$newDocuments";

$msg = $row['message'];
$msg = str_replace('{{name}}',$name,$msg);
$content = str_replace('{{msg}}',$content,$msg);

$functions->send_mail($email,$row['subject'],$content);

$sql = "UPDATE `accounts_user` SET `weekly_email`='$date' WHERE `acc_id`='$id'";
$dbF->setRow($sql);

}

/* Weekly email */

$sql = "SELECT `id_user`,`setting_val` FROM `accounts_user_detail` WHERE `setting_val` IN ('Master','Practice') AND `id_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `notify` = '1') AND
`id_user` NOT IN(SELECT `acc_id` FROM `accounts_user`WHERE acc_type=0) AND
`id_user` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
`id_user` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) ))";
// $sql = "SELECT `id_user`,`setting_val` FROM `accounts_user_detail` WHERE `id_user`='2'";
$mysql = $dbF->getRows($sql);
foreach ($mysql as $key => $value) {
	$email_template = include(__DIR__."/email.php");
	$sql = "SELECT MIN(`date`) FROM `warning` WHERE user= ?";
	$data = $dbF->getRow($sql,array($value['id_user']));
	$dt = $data[0];
	$startTimeStamp = strtotime($dt);
	$endTimeStamp = strtotime($date);
	$timeDiff = abs($endTimeStamp - $startTimeStamp);
	$numberDays = $timeDiff/86400;
	$count = intval($numberDays);
	$email = $functions->UserEmail($value['id_user']);
	$name = $functions->UserName($value['id_user']);
	if($count == 13){
// 		$functions->push_notification('Compliance Health in Danger','You in danger gurrl.Your compliance health meter is in red.',$functions->getUserPlayerId($value['id_user']));
// 		$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = '1warn'";
// 		$row2 = $dbF->getRow($sql2);
// 		$txt = $row2['message'];
// 		$email_template = str_replace('{{name}}',$name,$email_template);
// 		$content = str_replace('{{msg}}',$txt,$email_template);
// 		$functions->send_mail($email,$row2['subject'],$content);
        $functions->notifications('1warn',$value['id_user']);
	}
	else if($count == 20){
// 		$functions->push_notification('Compliance Health in Danger','Hulk Out! Your compliance health meter is still in the red. Time to be a hero.',$functions->getUserPlayerId($value['id_user']));
// 		$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = '2warn'";
// 		$row2 = $dbF->getRow($sql2);
// 		$txt = $row2['message'];
// 		$email_template = str_replace('{{name}}',$name,$email_template);
// 		$content = str_replace('{{msg}}',$txt,$email_template);
// 		$functions->send_mail($email,$row2['subject'],$content);
        $functions->notifications('2warn',$value['id_user']);
	}
	else if($count == 28){
// 		$functions->push_notification('Compliance Health in Danger','Wake Up! Your compliance health meter has been in the red for 3 weeks. Be near your phone.',$functions->getUserPlayerId($value['id_user']));
// 		$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = '3warn'";
// 		$row2 = $dbF->getRow($sql2);
// 		$txt = $row2['message'];
// 		$email_template = str_replace('{{name}}',$name,$email_template);
// 		$content = str_replace('{{msg}}',$txt,$email_template);
// 		$functions->send_mail($email,$row2['subject'],$content);
		$functions->notifications('3warn',$value['id_user']);
		if($value['setting_val'] == "Practice"){
// 			$sql = "SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$value[id_user]' AND `setting_name`='account_under'";
// 			$data = $dbF->getRow($sql);
// 			$mid = $data[0];
// 			$functions->push_notification('Compliance Health in Danger','Your practice compliance health hasn’t been great for the last 4 weeks.',$functions->getUserPlayerId($mid));
// 			$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = 'mto'";
// 			$row2 = $dbF->getRow($sql2);
// 			$txt = $row2['message'];
// 			$email_template = str_replace('{{name}}',$name,$email_template);
// 			$content = str_replace('{{msg}}',$txt,$email_template);
// 			$functions->send_mail($email,$row2['subject'],$content);
            $functions->notifications('mto',$value['id_user']);
		}
		else{
// 			$functions->push_notification('Compliance Health in Danger','Your practice compliance health hasn’t been great for the last 4 weeks.',$functions->getUserPlayerId($value['id_user']));
// 			$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = 'mto'";
// 			$row2 = $dbF->getRow($sql2);
// 			$txt = $row2['message'];
// 			$email_template = str_replace('{{name}}',$name,$email_template);
// 			$content = str_replace('{{msg}}',$txt,$email_template);
// 			$functions->send_mail($email,$row2['subject'],$content);
			$functions->notifications('mto',$value['id_user']);
		}
	}
}
$data = $functions->dbF->getRows("SELECT * FROM `userdocuments` WHERE 
`category`='Training' AND 
expiry_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND 
DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND 
user NOT IN(SELECT `acc_id` FROM `accounts_user`WHERE acc_type=0) AND
user NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
user NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) )");
	foreach ($data as $value){
    	$title= $value['title'];
    	$user=$value['user'];
 		$functions->notifications('certificateExpire', $user, $title);
 		
    	    }
$functions->send_mail('mobashir@im.com.pk','documents_expiry',json_encode($data));
$data= $functions->dbF->getRows("SELECT `acc_id` FROM `accounts_user` WHERE 
last_login NOT BETWEEN DATE_ADD(CURDATE(), INTERVAL -31 DAY) AND 
DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND 
acc_type=1 AND 
acc_id NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') AND 
acc_id NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_name='account_under' AND (setting_val IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Trial') OR setting_val IN (SELECT acc_id FROM `accounts_user` WHERE acc_type=0)) )");
	foreach ($data as  $value) {
		$user=$value['acc_id'];
		$functions->notifications('notlogin30', $user);

	}
	$functions->send_mail('mobashir@im.com.pk','Not Login',json_encode($data));

?>