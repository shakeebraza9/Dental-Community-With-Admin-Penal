<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
trait common_function
{
private $developer_setting_array;
private $IBMS_setting_array;
public function projectInfoOnImedia()
{
// For more security also enter link here,,, then encrypt this file

//Now this is done in imedia license file
/*$webUrl2 = "http://localhost/projects/led/website";
$host = "localhost";
if($host == $_SERVER['HTTP_HOST'] && $webUrl2 == WEB_URL){

}else{
echo "Your Domain is change, Please Contact to imedia.com";
$msg = $_SERVER['HTTP_HOST']." New Domain try to Active, Was Allow On ".$webUrl2;
if(isset($_SESSION['mailSend'])){

}else { 
$this->send_mail('info@imedia.com.pk,abid@imedia.com.pk', 'Project Active On New Domain ' . $_SERVER['HTTP_HOST'], "$msg");
$_SESSION['mailSend'] = '1';
}
exit;
}*/

//I was do this code, this code get project link from imedia and check is it match?
//BUt now i think it is use less,,
/*if(isset($_SESSION['sLink']) && $webUrl2 == WEB_URL){

}else {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, licenseLink . "?info=" . PROJECT_ID);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$return = curl_exec($ch);
$file = unserialize($return);
$allow = false;
if ($file['project_url'] == WEB_URL){
if ($file['project_url'] == $webUrl2) {
$allow = true;
}
}

if($allow==false){
echo "Your Domain is change, Please Contact to imedia.com";
exit;
}

$_SESSION['sLink'] = WEB_URL;
}*/
}
public function setlog($title = "untitled", $ref_name = false, $ref_id = "", $desc = "", $transaction = true)
{
if (isset($_SESSION['_email'])) {
$user_email = $_SESSION['_email'];
} else {
$user_email = $this->UserName($_SESSION['webUser']['id']) . " : " . $_SESSION['webUser']['id'];
}
// $ip = $_SERVER['REMOTE_ADDR'];

 $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';



$browser = "";
foreach ($this->getBrowser() as $key => $val) {
$browser .= "$key : $val <br />";
}

$sql = "INSERT INTO `activity_log` (`log_title`, `ref_name`, `ref_id`, `ref_user`, `log_desc`, `log_ip`, `log_browser`)
VALUES (?,?,?,?,?,?,?) ";

$arr = array($title, $ref_name, $ref_id, $user_email, $desc, $ipaddress, $browser);
$this->dbF->setRow($sql, $arr, $transaction);
return true;
}
private function getBrowser()
{
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$bname = 'Unknown';
$platform = 'Unknown';
$version = "";

//First get the platform?
if (preg_match('/linux/i', $u_agent)) {
$platform = 'linux';
} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
$platform = 'mac';
} elseif (preg_match('/windows|win32/i', $u_agent)) {
$platform = 'windows';
}
$ub = "";
// Next get the name of the useragent yes seperately and for good reason
if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
$bname = 'Internet Explorer';
$ub = "MSIE";
} elseif (preg_match('/Firefox/i', $u_agent)) {
$bname = 'Mozilla Firefox';
$ub = "Firefox";
} elseif (preg_match('/Chrome/i', $u_agent)) {
$bname = 'Google Chrome';
$ub = "Chrome";
} elseif (preg_match('/Safari/i', $u_agent)) {
$bname = 'Apple Safari';
$ub = "Safari";
} elseif (preg_match('/Opera/i', $u_agent)) {
$bname = 'Opera';
$ub = "Opera";
} elseif (preg_match('/Netscape/i', $u_agent)) {
$bname = 'Netscape';
$ub = "Netscape";
}

// finally get the correct version number
$known = array('Version', $ub, 'other');
$pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
if (!preg_match_all($pattern, $u_agent, $matches)) {
// we have no matching number just continue
}

// see how many we have
$i = count($matches['browser']);
if ($i != 1) {
//we will have two since we are not using 'other' argument yet
//see if version is before or after the name
if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
$version = $matches['version'][0];
} else {
$version = $matches['version'][1];
}
} else {
$version = $matches['version'][0];
}

// check if we have a number
if ($version == null || $version == "") {
$version = "?";
}

return array(
'userAgent' => $u_agent,
'name' => $bname,
'version' => $version,
'platform' => $platform,
'pattern' => $pattern
);
}
//push
public function push_notification($title, $message, $player_id, $url = "",$debug=false)
{
$url = WEB_URL;
$content = array(
"en" => "$message"
);
$heading = array(
"en" => "$title"
);
// var_dump($heading,$message);
// exit();
$playerId = explode(",", $player_id);
$seg='include_player_ids';
if($player_id=='all'){
    $seg='included_segments';
    $playerId= array('Subscribed Users');
}
$fields = array(
'app_id' => "63fc4c4a-7ae4-4883-8b6b-fab933959243",
$seg => $playerId,
'url' => $url,
'contents' => $content,
'headings' => $heading
);

$fields = json_encode($fields);
if($debug==true){
    print("\nJSON sent:\n");
    print($fields);
}else{
    $msg1="PlayerId: ".$player_id." - Title: ".$title." - Message: ".$message." -  /r/n";
    $dirr = __DIR__."/push.txt";
    $myfile = fopen($dirr, "w");
    fwrite($myfile, $msg1);
    fclose($myfile);
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json; charset=utf-8',
'Authorization: Basic YmQwODYzZDItOTliOS00NmM4LWFmNjItMmUzZTUyZmEyZmUy'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$response = curl_exec($ch);
curl_close($ch);
return $response;
}

public function deletePlayerId()
{
$playerId = $_POST['playerId'];
$playerId = '%'.$playerId."%";
$sql = "SELECT `player_id`,`acc_id` FROM `accounts_user` WHERE `player_id` LIKE ? ";
$data = $this->dbF->getRow($sql,array($playerId));
$user = $data['acc_id'];
$arry = explode(",", $data['player_id']);
foreach ($arry as $key => $value) {
if ($value == $playerId) {
unset($arry[$key]);
}
}
$arry = implode(",", $arry);
$sql = "UPDATE `accounts_user` SET `player_id` = '$arry' WHERE `accounts_user`.`acc_id` = ? ";
$this->dbF->setRow($sql, array($user));
}

public function getUserPlayerId($user)
{
$sql = "SELECT `player_id` FROM `accounts_user` WHERE `acc_id` = ? AND  `acc_id` NOT IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_type`='0') ";
$data = $this->dbF->getRow($sql, array($user));
$playerId = isset($data[0]) ? $data[0] : 0;
return $playerId;
}

// push

public function allEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all',? ) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ? ";
$data = $this->dbF->getRow($sql,array($user,$user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allApprovedEvent($user)
{
$sql = "SELECT COUNT(*) FROM `userevent` WHERE `approved`='1' AND `user`= ? ";
$data = $this->dbF->getRow($sql,array($user));
return $data[0];
}

public function allPercent($val1, $val2)
{
if ($val2 == 0) {
return 0;
} else {
$result = ($val1 / $val2) * 100;
return $result;
}
}
public function allMandatoryOverDueEvent_user($a= 'mandatory')
{



$user = intval($_SESSION['currentUser']);

if($a== "completed"){



$sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`= ? AND `userevent`.`due_date` <= (SELECT CURDATE())  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data2 = $this->dbF->getRows($sql2, array($user));

@$mysql .= $this->setli($data2, 'editevent');
return $mysql;




}


$user = intval($_SESSION['currentUser']);

if($a== "all"){
    
// $sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`!= 'updates' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
  $sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`!= 'updates' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`!= 'updates' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$data = $this->dbF->getRows($sql, array($user, $user));
$data2 = $this->dbF->getRows($sql2);

}else{
// $sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`= ?  AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`= ?  AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";

$sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`= ? AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$data = $this->dbF->getRows($sql, array($user, $a, $user));
$data2 = $this->dbF->getRows($sql2, array($a));

    
}
// $sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND `due_date`<=(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`='$user') AND id NOT IN (SELECT recurrence FROM eventmanagement) ORDER BY `title`";
// $sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`<=(SELECT CURDATE()) ORDER BY `title`";
$mysql = $this->setli($data);
$mysql .= $this->setli($data2, 'editevent');
return $mysql;
}

public function allMandatoryOverDueEvent_user_Title($a= 'mandatory')
{
$user = intval($_SESSION['currentUser']);
if($a== "completed"){

$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`= ? AND `userevent`.`due_date` <= (SELECT CURDATE())  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";


$data = $this->dbF->getRows($sql2, array($user));


$cate = "<option value='all' class='all atv'>All</option>";
foreach ($data as $key => $value) {
$cate .= "<option class='all blue " . str_replace('&', '', str_replace(' ', '', $value['category'])) . " hidden' data-eventtype='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</option>";
}



return $cate;





}


$user = intval($_SESSION['currentUser']);

if($a=='all'){
    
// $sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`!= 'updates' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `userevent`.`title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`!= 'updates' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `userevent`.`title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`) ";

$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`!= 'updates' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$data = $this->dbF->getRows($sql, array($user, $user));
$data2 = $this->dbF->getRows($sql2, array($user));
    
}else{

// $sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`= ? AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`= ? AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";

$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`='$a' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$data = $this->dbF->getRows($sql, array($user, $a, $user));
$data2 = $this->dbF->getRows($sql2, array($user));
// var_dump($data);
    
}
// ============================================//
$sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`= ? AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ?) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`='$a' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
//usort($mysql,'compare_category');
// $cate = "<h5 class='all atv'>All</h5>";
// foreach ($mysql as $key => $value) {
// $cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
// }

$cate = "<option value='all' class='all atv'>All</option>";
foreach ($mysql as $key => $value) {
$cate .= "<option class='all blue " . str_replace('&', '', str_replace(' ', '', $value['category'])) . " hidden' data-eventtype='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</option>";
}










return $cate;
}


public function allMandatoryEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `type`='mandatory' AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ? AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allRecommendedEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `type`='recommended' AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ?  AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql , array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allMandatoryDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql ,  array($user, $user));
$data2 = $this->dbF->getRow($sql2,  array($user));
return $data[0] + $data2[0] + 0;
}

public function MandatoryDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ?  AND ((`userevent`.`due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH))  OR `userevent`.`due_date` IS NULL) AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2,  array($user));
return $data[0] + $data2[0] + 0;
}

public function allMandatoryUnDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `due_date` > DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE  `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` > DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allMandatoryOverDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function MandatoryOverDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ?  AND (`userevent`.`due_date` <= (SELECT CURDATE()) OR `userevent`.`due_date` IS NULL)  AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allRecommendedUnDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='recommended' AND `due_date` > DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ? AND `userevent`.`due_date` > DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allRecommendedDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='recommended' AND `due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function RecommendedDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='recommended' AND `due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ?  AND ((`userevent`.`due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH))  OR `userevent`.`due_date` IS NULL) AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allRecommendedOverDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='recommended' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ? AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function RecommendedOverDueEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='recommended' AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `user`= ?  AND (`userevent`.`due_date` <= (SELECT CURDATE()) OR `userevent`.`due_date` IS NULL) AND `type`='recommended' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function allMandatoryApprovedEvent($user)
{
$sql = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `type`='mandatory' AND `approved`='1' AND `user`= ? AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user));
return $data[0];
}

public function allRecommendedApprovedEvent($user)
{
$sql = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `type`='recommended' AND `approved`='1' AND `user`= ? AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user));
return $data[0];
}

public function allMandatoryUnApprovedEvent($user)
{
$sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `type`='mandatory' AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`)";
$sql2 = "SELECT COUNT(*) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` != '1' AND `user`= ?  AND `type`='mandatory' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user));
return $data[0] + $data2[0] + 0;
}

public function meter($val1, $val2)
{
//allApprovedEvent,(allMandatoryUnApprovedEvent-allMandatoryUnDueEvent-allMandatoryDueEvent)
$result = $val1 - $val2;
if ($result < 0) {
return 0;
} else {
return $result;
}
}




public function makeRecoverySQL($table, $columnName1, $id1, $columnName2='', $id2='', $columnName3='', $id3='')
{

if(!empty($columnName3) && !empty($columnName2))
{
$selectSQL = "SELECT * FROM `" . $table . "` WHERE `" . $columnName1 . "` = '" . $id1 ."' AND `" . $columnName2 . "` = '" . $id2 ."' AND `" . $columnName3 . "` = '" . $id3 . "' ";
}else if(!empty($columnName2) && empty($columnName3))
{
$selectSQL = "SELECT * FROM `" . $table . "` WHERE `" . $columnName1 . "` = '" . $id1 ."' AND `" . $columnName2 . "` = '" . $id2 . "' ";
}
else{
$selectSQL = "SELECT * FROM `" . $table . "` WHERE `" . $columnName1 . "` = '" . $id1 . "' ";
}    

// echo $selectSQL;

$row = $this->dbF->getRows($selectSQL,null,true,true);
$insertSQL =''; 
foreach ($row as $field => $value) {
$insertSQL .= "; INSERT INTO `" . $table . "` SET ";
foreach ($value as $fields => $values) {
$insertSQL .= " `" . $fields . "` = '" . $values . "', ";
}
$insertSQL = trim($insertSQL, ", ");
}
return $insertSQL;
}




public function TrashData($page_name = false, $desc = false, $file = false, $from_user = false, $to_user = false, $table_name = false, $table_id = false, $event_perfom = "", $qImport='')
{
$sql = "INSERT INTO `trashdata`(`delete_page_name`,`delete_desc`,`delete_file`,`delete_from_user`, `delete_to_user`, `delete_table_name`,`delete_table_id`,`event_perfom`,`qImport`) VALUES (?,?,?,?,?,?,?,?,?)";

$array =   array($page_name, $desc, $file, $from_user, $to_user, $table_name, $table_id, $event_perfom, $qImport);

// var_dump($array);


$this->dbF->setRow($sql, $array, false);
}

public function course_dentis_category_title()
{
$user = $_SESSION['currentUser'];

$course_dental_category    = explode(',', $this->ibms_setting('course_dental_category'));

$cate = "<h5 data-filter='*' class='all atv'>All</h5>";
$cate .= "<h5 data-filter='.delegate'>Delegate </h5>";
for ($i = 0; $i < count($course_dental_category); $i++) {

$cate .= "<h5 data-filter='." . str_replace('&', '', str_replace(' ', '', $course_dental_category[$i])) . "'>" . $course_dental_category[$i] . "</h5>";
}


return $cate;
}

public function getUserEventData($id, $columns){
    $sql =  "Select $columns from `userevent` where id = ? ";
    $data = $this->dbF->getRow($sql, array($id));
    return $data[0] ;
}


public function getMyEventData($id, $columns){
    $sql =  "Select $columns from `myevents` where id = ? ";
    $data = $this->dbF->getRow($sql, array($id));
    return @$data[0] ;
}

public function eventUpcomingTitle()
{
$user = intval($_SESSION['currentUser']);
$temp=$this->allGroupsIds($user);
$sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', '$user'$temp ) AND `publish` = '1' AND `due_date`>(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`= ? ) AND id NOT IN (SELECT recurrence FROM eventmanagement) AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')";
$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ? AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`>(SELECT CURDATE()) AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ? AND type='event')";
$data = $this->dbF->getRows($sql, array($user, $user));
$data2 = $this->dbF->getRows($sql2, array($user,$user));
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
usort($mysql, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($mysql as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
return $cate;
}

public function countUpcoming()
{
$user = $_SESSION['currentUser'];
$temp=$this->allGroupsIds($user);
$sql = "SELECT COUNT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', '$user'$temp ) AND `publish` = '1' AND `due_date`>(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`= ? ) AND id NOT IN (SELECT recurrence FROM eventmanagement) AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')";
$sql2 = "SELECT COUNT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`>(SELECT CURDATE()) AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')";
$data = $this->dbF->getRow($sql, array($user, $user));
$data2 = $this->dbF->getRow($sql2, array($user,$user));
return $data[0] + $data2[0] + 0;
}

public function eventUpcoming()
{
$user = intval($_SESSION['currentUser']);
$temp=$this->allGroupsIds($user);
$sql = "SELECT *
FROM   `eventmanagement`
WHERE  `assignto` IN ( 'all', '$user'$temp)
   AND `publish` = '1'
   AND `due_date` > (SELECT Curdate())
   AND id NOT IN(SELECT title_id
                 FROM   `userevent`
                        JOIN `eventmanagement`
                          ON `eventmanagement`.`id` = `userevent`.`title_id`
                 WHERE  `approved` IN ( '1', '0', '-1' )
                        AND `user` =  '$user' )
   AND id NOT IN (SELECT recurrence
                  FROM   eventmanagement)
    AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= '$user'  AND type='event')              
ORDER  BY `title`";
$sql2 = "SELECT `userevent`.`id`,
       `userevent`.`due_date`,
       `userevent`.`dateTime`,
       `title`,
       `category`,
       `type`,
       `userevent`.`file` AS `userfile`,
       `approved`,
       `userevent`.`assignto`
FROM   `userevent`
       JOIN `eventmanagement`
         ON `eventmanagement`.`id` = `userevent`.`title_id`
WHERE  `approved` = '-1'
       AND `user` =  ? 
       AND `userevent`.`assignto` < '1'
       AND `userevent`.`due_date` > (SELECT Curdate())
       AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')
ORDER  BY `title`";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2, array($user,$user));
$mysql = $this->setli($data);
$mysql .= $this->setli($data2, 'editevent');
return $mysql;
}

public function eventDueTitle()
{

$user = $_SESSION['currentUser'];
$sql = "SELECT DISTINCT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `publish` = '1' AND `due_date`<=(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`= ? )  AND id NOT IN (SELECT recurrence FROM eventmanagement) AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')";
$sql2 = "SELECT DISTINCT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`<=(SELECT CURDATE()) AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id= ?  AND type='event')";
$data = $this->dbF->getRows($sql, array($user,$user, $user));
$data2 = $this->dbF->getRows($sql2, array($user,$user));
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
usort($mysql, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($mysql as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
return $cate;
}



public function CpdInsertDocument()
{
if (isset($_POST['submit'])) {

if (!empty($_POST['id'])) {
include('cpd-certificates-savePDF.php');
}
}
}


public function documentClickAbleTitle($Training, $usertmp = fasle)
{
    
   @$url_user = intval($_GET['user']);
if ($url_user > 0) {
$usertmp =  $url_user;
}else if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$usertmp =  intval($_SESSION['webUser']['id']);
} else {
$usertmp =  intval($_SESSION['webUser']['id']);
//$usertmp = intval($_SESSION['currentUser']);
}

$sql1 = "SELECT DISTINCT(`sub_dcategory`) FROM `documents` WHERE `category`= ?  AND `assignto` IN ('all',?, ? )  AND `sub_dcategory` !=''";

$sql2 = "SELECT DISTINCT(`sub_dcategory`) FROM `userdocuments` WHERE `category`= ?  AND `user` = ? AND `sub_dcategory` !=''";
$allUser = 'all:'.$_SESSION['currentUser'];
$data1 = $this->dbF->getRows($sql1, array($Training, $usertmp, $allUser));
$data2 = $this->dbF->getRows($sql2, array($Training, $usertmp));
$mysql = array_merge($data1, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);


$heading = "<h5 style='margin-bottom: 5px;' class='all atv'>All</h5>";
$option = "";
foreach ($mysql as $key => $value) {

$heading .= "<h5 style='margin-bottom: 5px;' class='" . str_replace('.', '', str_replace('&', '', str_replace(' ', '', $value['sub_dcategory']))) . "'>" . $value['sub_dcategory'] . "</h5>";

$option .= "<option value='" .$value['sub_dcategory']. "'>" . $value['sub_dcategory'] . "</option>";


}
return $arrayName = array($heading,$option);

}


public function countTTLDoneStaffDocuments($category, $user, $pid)
{

$ttl = 0;
$ttlDone = 0;

$all = "all:$pid";
$data = $this->dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all',? ,?) AND `category`= ? " , array($user,$all , $category)); 
foreach ($data as $key => $value) {


$this->dbF->getRow("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`= ?   AND `title_id`='$value[id]'",array($user, $category));
if ($this->dbF->rowCount>0) {
$ttlDone++;

}else{


}
$ttl++;
}


return $arrayName = array($ttl,$ttlDone);
}

public function countTTLDoneStaffDocumentsScat($sub_category, $user, $pid)
{

$ttl = 0;
$ttlDone = 0;

$all = "all:$pid";
$data = $this->dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all', ? ,? ) AND `sub_dcategory`= ? ", array($user, $all, $sub_category)); 
foreach ($data as $key => $value) {


$this->dbF->getRow("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `sub_dcategory`= ?   AND `title_id`='$value[id]'",array($user, $sub_category));
if ($this->dbF->rowCount>0) {
$ttlDone++;

}else{


}
$ttl++;
}

if($ttlDone != 0 && $ttlDone != 0){
$percent = $ttlDone/$ttlDone; if(is_int($percent) || is_float($percent)) $percent=number_format( $percent * 100); else $percent=0;
}else{
    $percent=0;
}
if($percent=='Nan'){
    $percent=0;
}

return $arrayName = array($ttl,$ttlDone,$percent);
}


public function countTTLDoneStaffDocumentsWOcat($user, $pid)
{
$ttl = 0;
$ttlDone = 0;
$all = "all:$pid";
$data = $this->dbF->getRows("SELECT id FROM `documents` WHERE `assignto` IN ('all', ? , ? ) order by id", array($user, $all)); 
foreach ($data as $key => $value) {
$this->dbF->getRow("SELECT id FROM `userdocuments` WHERE `user`= ?  AND `title_id`='$value[id]'  order by id",array($user));
if ($this->dbF->rowCount>0) {
$ttlDone++;
}else{
}
$ttl++;
}
return $arrayName = array($ttl,$ttlDone);
}


public function documentClickAbleTitle2($Training, $user)
{
$all = "all:$user";
$user = intval($_SESSION['currentUser']);
$sql = "SELECT DISTINCT(`sub_dcategory`) FROM `userdocuments` WHERE `category`= ? AND `assignto` IN ('all', ? , ? ) ";
$data = $this->dbF->getRows($sql, array($Training, $Training, $all));

$cate = "<h5 class='all atv'>All</h5>";
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace(".", '', str_replace('&', '', str_replace(' ', '', $value[0]))) . "'>" . $value[0] . "</h5>";
}
return $cate;
}

public function countDue()
{
$user = intval($_SESSION['currentUser']);
$temp=$this->allGroupsIds($user);
$sql = "SELECT COUNT(`category`) FROM `eventmanagement` WHERE `assignto` IN ('all','$user'$temp) AND `publish` = '1' AND `due_date`<=(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`='$user') AND id NOT IN (SELECT recurrence FROM eventmanagement) AND `type` !='updates' AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$sql2 = "SELECT COUNT(`category`) FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`<=(SELECT CURDATE()) AND `type` !='updates' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql);
$data2 = $this->dbF->getRow($sql2);
return $data[0] + $data2[0] + 0;
}
public function eventDue()
{
$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND `due_date`<=(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`='$user') AND id NOT IN (SELECT recurrence FROM eventmanagement) AND `type` !='updates' AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ORDER BY `title`";
$sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`<=(SELECT CURDATE()) AND `type` !='updates'  AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ORDER BY `title`";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$mysql = $this->setli($data);
$mysql .= $this->setli($data2, 'editevent');
return $mysql;
}

public function eventProcessTitle()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp) AND `eventmanagement`.`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRows($sql);
usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` > '0' OR `userevent`.`assignto` = '-1.$user') AND `user`='$user' AND `eventmanagement`.`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRows($sql);
usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
}
return $cate;
}

public function countProcess()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp) AND `eventmanagement`.`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql);
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` > '0' OR `userevent`.`assignto` = '-1.$user') AND `user`='$user' AND `eventmanagement`.`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";
$data = $this->dbF->getRow($sql);
}
return $data[0] + 0;
}

public function eventProcess()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT `userevent`.`id`,`title`,`category`,`type`,`userevent`.`due_date`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp)  AND `eventmanagement`.`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ORDER BY `title`";
$data = $this->dbF->getRows($sql);
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT `userevent`.`id`,`userevent`.`color_publish`,`title`,`category`,`type`,`userevent`.`due_date`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` > '0' OR `userevent`.`assignto` = '-1.$user') AND `user`='$user' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ORDER BY `title`";
$data = $this->dbF->getRows($sql);
}
return $this->setli($data, 'editevent');
}

public function eventCompleteTitle()
{

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
// $sql = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp)";
$sql = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1'";
$data = $this->dbF->getRows($sql);
// var_dump($data);
// usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user'";
$data = $this->dbF->getRows($sql);
if(basename($_SERVER['REQUEST_URI']) == "completeallEvent"){
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
}

usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
}
return $cate;
}

public function myEventCompleteTitle()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
$user = intval($_SESSION['webUser']['id']);
if (isset($_SESSION['practiceUser'])) {
$user = intval($_SESSION['superid']);
}
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `assignto` IN ('-1.$d[0]','$user') AND `status`!='deleted'";
$data = $this->dbF->getRows($sql);
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
// $cate .= '<h5 class="completed">Completed</h5>';
// $cate .= '<h5 class="Pending">Pending</h5>';
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
} else {
$user = intval($_SESSION['currentUser']);
// $user = $_SESSION['webUser']['id'];
$sql = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`!='deleted'";
$data = $this->dbF->getRows($sql);
if(basename($_SERVER['REQUEST_URI']) == "completeallMyEvent"){
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
}
usort($data, 'compare_category');
$cate = "<h5 class='all '>All</h5>";
// $cate .= '<h5 class="completed">Completed</h5>';
// $cate .= '<h5 class="Pending">Pending</h5>';
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
}




// return $cate1;
// return $cate2;
// return $cate;
// $this->dbF->prnt($_SESSION);
return $cate;
}

public function countComplete()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp) AND (      

(  `eventmanagement`.`recurring_duration` = 'No Recurrence'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = 'Once'   AND  `userevent`.`due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

(  `eventmanagement`.`recurring_duration` = 'Once Check'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = '1 day'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

(  `eventmanagement`.`recurring_duration` = '1 week' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '2 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '3 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `eventmanagement`.`recurring_duration` = '1 Month' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `eventmanagement`.`recurring_duration` = '2 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '3 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '4 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '6 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 

)";
$data = $this->dbF->getRow($sql);
} else {
$user = intval($_SESSION['currentUser']);
// $user = $_SESSION['webUser']['id'];
$sql = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user'  AND (      

(  `eventmanagement`.`recurring_duration` = 'No Recurrence'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = 'Once'   AND  `userevent`.`due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

(  `eventmanagement`.`recurring_duration` = 'Once Check'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = '1 day'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

(  `eventmanagement`.`recurring_duration` = '1 week' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '2 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '3 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `eventmanagement`.`recurring_duration` = '1 Month' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `eventmanagement`.`recurring_duration` = '2 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '3 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '4 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '6 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 

)";
$data = $this->dbF->getRow($sql);
}
return $data[0] + 0;
}

public function eventCompleteAll()
{

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`title`,`category`,`type` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') ORDER BY `title`,`userevent`.`due_date`";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . ' 




<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['dd'])) . '">(' . date("d-M-Y", strtotime($value['dd'])) . ')</span>


</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['fl'] != '#') {
    $link = explode(",", $value['fl']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
            $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '"  data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '</div><!-- col4_main_left3 close -->
</li>';
}
}
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`title`,`category`,`type` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' ORDER BY `title`,`userevent`.`due_date`";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['dd'])) . '">(' . date("d-M-Y", strtotime($value['dd'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3" style="z-index: 1;">';
if ($value['fl'] != '#') {
    $link = explode(",", $value['fl']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
           $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '"  data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {

    $li .= '';
} else {
    $li .= '<a href="editevent_print.php?id=' . base64_encode($value['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';
}

$li .= '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a></div><!-- col4_main_left3 close -->
</li>';
}
}
}
return $li;
}

public function myEventCompleteAll()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
$user = intval($_SESSION['webUser']['id']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT  * FROM `myevents` WHERE  `status`='complete' AND `assignto` IN ('-1.$d[0]','$user') ORDER BY `title` , `dateTime` DESC";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all blue ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['due_date'])) . '">(' . date("d-M-Y", strtotime($value['due_date'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {

                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
        $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f='. $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="'. $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '<a class="ablue" onclick="submitMYevent(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>
</div><!-- col4_main_left3 close -->
</li>';
}
}
} else {
$user = intval($_SESSION['currentUser']);
// $user = $_SESSION['webUser']['id']; 
$sql = "SELECT  * FROM `myevents` WHERE `user`='$user' AND `status`='complete' ORDER BY `title`  , `dateTime` DESC";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
if (strpos($value['assignto'], '-1') !== false) {
    $assignto = 'All';
} else {
    $assignto = $this->UserName($value['assignto']);
}if(empty($assignto)){

       $assignto = "anonymous";
}

$li .= '<li class="all blue ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['due_date'])) . '">(' . date("d-M-Y", strtotime($value['due_date'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['assignto'] != '') {


    $li .= '<a class="abrown" onclick="submitMYevent(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';
}
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
         $downLink=base64_encode(WEB_URL . '/images/' .$val.":s:".date('d'));




        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f='. $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="'. $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '<a class="ablue" onclick="submitMYevent(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>';
if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'full') {
    $li .= '<a class="ared"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="calendar?sure=' . base64_encode($value['id']."&d=".date('d')) . '"><i class="fas fa-trash"></i></a>';
}
$li .= '</div>
</li>';
}
}
}
return $li;
}

public function eventComplete()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`title`,`category`,`type` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user'$temp)AND 

(      

(  `eventmanagement`.`recurring_duration` = 'No Recurrence'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = 'Once'   AND  `userevent`.`due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

(  `eventmanagement`.`recurring_duration` = 'Once Check'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = '1 day'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

(  `eventmanagement`.`recurring_duration` = '1 week' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '2 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '3 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `eventmanagement`.`recurring_duration` = '1 Month' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `eventmanagement`.`recurring_duration` = '2 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '3 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '4 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '6 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
) ORDER BY `title`";

$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . ' 
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['dd'])) . '">(' . date("d-M-Y", strtotime($value['dd'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['fl'] != '#') {
    $link = explode(",", $value['fl']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
          $downLink=base64_encode($val.":s:".date('d'));


        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '"  data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '</div><!-- col4_main_left3 close -->
</li>';
}
}
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT 
`userevent`.`id`, 
`userevent`.`file` as fl,
`userevent`.`dateTime` as `dt`,
`userevent`.`due_date` as `dd`,
`title`,
`category`,
`type` 

FROM `userevent` 
JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`  

WHERE 
`approved`='1' AND `user`= '$user' AND 

(      

(  `eventmanagement`.`recurring_duration` = 'No Recurrence'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = 'Once'   AND  `userevent`.`due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

(  `eventmanagement`.`recurring_duration` = 'Once Check'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `eventmanagement`.`recurring_duration` = '1 day'   AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

(  `eventmanagement`.`recurring_duration` = '1 week' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '2 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `eventmanagement`.`recurring_duration` = '3 weeks' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `eventmanagement`.`recurring_duration` = '1 Month' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `eventmanagement`.`recurring_duration` = '2 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '3 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '4 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `eventmanagement`.`recurring_duration` = '6 Months' AND  `userevent`.`due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
)  ORDER BY `title`";

$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['dd'])) . '">(' . date("d-M-Y", strtotime($value['dd'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['fl'] != '#' && $value['fl'] != '') {
    $link = explode(",", $value['fl']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
         $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '"  data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a></div><!-- col4_main_left3 close -->
</li>';
}
}
}
return $li;
}

public function actionplanShowCompleted()
{ ?>
<div>
<ul style="text-align: initial;">
<a href="<?php echo WEB_URL ?>/action-plan" class="submit_class">Show Pending Action Plan</a>
<li style="display: none"></li>
<h3 style="margin-left: 34%">Action Plan Completed</h3>
</ul>
<div>
<table class="table table-hover dTable tableIBMS dataTable">
<thead>
<tr>
    <th>sno</th>
    <th>Title Name</th>
    <th>Due Date</th>
    <th>Action plan</th>
    <th>status</th>
</tr>
</thead>
<tbody>
<?php


if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
    $user = intval($_SESSION['superid']);
    $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

    $sql = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`userevent`.`desc` as `dc`,`userevent`.`approved` as `ap`,`title` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `userevent`.`assignto` IN ('-1.$d[0]','$user')AND `userevent`.`desc` !='' AND `userevent`.`approved`  = '1' ORDER BY `title`";
    $data1 = $this->dbF->getRows($sql);



            $sql2 = "SELECT `myevents`.`id`,`myevents`.`actionplan` as actionplanTXT,`myevents`.`file` as fl,`myevents`.`dateTime` as `dt`,`myevents`.`due_date` as `dd`,`myevents`.`desc` as `dc`,`myevents`.`approved` as `ap`,`title` FROM `myevents` WHERE `myevents`.`assignto` IN ('-1.$d[0]','$user')AND `myevents`.`desc` !='' AND `myevents`.`approved`  = '1' ORDER BY `title`";
    $data2 = $this->dbF->getRows($sql2);

$data = array_merge($data1, $data2);




} else {


    $user = intval($_SESSION['currentUser']);
    $sql = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`userevent`.`desc` as `dc`,`userevent`.`approved` as `ap`,`title` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE   `user`='$user' AND `userevent`.`approved` = '1' AND `userevent`.`desc` !=''  ORDER BY `title`";
    $data1 = $this->dbF->getRows($sql);



    $sql2 = "SELECT `myevents`.`id` as asID,`myevents`.`actionplan` as actionplanTXT,`myevents`.`file` as fl,`myevents`.`dateTime` as `dt`,`myevents`.`due_date` as `dd`,`myevents`.`desc` as `dc`,`myevents`.`approved` as `ap`,`title` FROM `myevents`WHERE   `user`='$user' AND `myevents`.`approved` = '1' AND `myevents`.`desc` !=''  ORDER BY `title`";
    $data2 = $this->dbF->getRows($sql2);




$data = array_merge($data1, $data2);




}





$cnt  = 0;
?>
<?php foreach ($data as $key => $val) {
    $cnt++;
    echo "<tr>
   <td>" . $cnt . "</td>
   <td>" . $val['title'] . "</td>
   <td>" . $val['dd'] . "</td>";



    echo "    
   <td>" . $val['dc'] . "</td>";
    if ($val['ap'] == '1') {
        echo "<td><button class='btn btn-success'> Completed </button></td>
      ";
    }



    echo "  </tr>"; ?>
<?php   } ?>
</tbody>
</table>
</div>
</div>
<?php
}
public function actionplanShowPending()
{ ?>
<div class="bg-accent">
<a href="<?php echo WEB_URL ?>/action-plan_completed" class="submit_class">Show Completed Action Plan</a>
<ul style="text-align: initial;">
<li style="display: none;"></li>
<div class="form_heading">
<h3>Action Plan Pending</h3>
</div>
</ul>
<div class="action_pending_">
<table class="table table-hover dTable tableIBMS dataTable">
<thead>
<tr>
    <th>sno</th>
    <th>Title Name</th>
    <th>Due Date</th>
    <th>Action plan</th>
    <th>status</th>
</tr>
</thead>
<tbody>
<?php


if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
     $user = intval($_SESSION['superid']);
    $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

    $sql1 = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`userevent`.`desc` as `dc`,`userevent`.`approved` as `ap`,`title` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `userevent`.`desc` !=''  AND `userevent`.`approved` != '1' ORDER BY `title`";
    $data1 = $this->dbF->getRows($sql1);






        $sql2 = "SELECT `myevents`.`id`,`myevents`.`actionplan` as actionplanTXT,`myevents`.`file` as fl,`myevents`.`dateTime` as `dt`,`myevents`.`due_date` as `dd`,`myevents`.`desc` as `dc`,`myevents`.`approved` as `ap`,`title` FROM `myevents` WHERE `myevents`.`assignto` IN ('-1.$d[0]','$user') AND `myevents`.`desc` !='' AND `myevents`.`actionplan` !=''  AND `myevents`.`approved` != '1' and `status` !='deleted' ORDER BY `title`";
    $data2 = $this->dbF->getRows($sql2);

$data = array_merge($data1, $data2);



} else {


    $user = intval($_SESSION['currentUser']);
    $sql1 = "SELECT `userevent`.`id`,`userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`userevent`.`due_date` as `dd`,`userevent`.`desc` as `dc`,`userevent`.`approved` as `ap`,`title` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE   `user`='$user' AND `userevent`.`desc` !='' AND  `userevent`.`approved` != '1'  ORDER BY `title`";
    $data1 = $this->dbF->getRows($sql1);



    $sql2 = "SELECT `myevents`.`id` as asID,`myevents`.`actionplan` as actionplanTXT,`myevents`.`file` as fl,`myevents`.`dateTime` as `dt`,`myevents`.`due_date` as `dd`,`myevents`.`desc` as `dc`,`myevents`.`approved` as `ap`,`title` FROM `myevents` WHERE   `user`='$user' AND `myevents`.`desc` !='' AND  `myevents`.`approved` != '1' AND `myevents`.`actionplan` !=''  AND `status` !='deleted'  ORDER BY `title`";
    $data2 = $this->dbF->getRows($sql2);




$data = array_merge($data1, $data2);



}





$cnt  = 0;
?>
<?php foreach ($data as $key => $val) {
    $cnt++;
    echo "<tr>
   <td>" . $cnt . "</td>
   <td>" . $val['title'] . "</td>
   <td>" . $val['dd'] . "\n".@$val['actionplanTXT']."</td>";



    echo "    
   <td>" . $val['dc'] . "</td>";


if(isset($val['id'])){

       echo "<td><button class='btn btn-danger ' style='cursor: pointer;' id='user" . $val['id'] . "' onClick='reply_click(this.id)'>Complete</button></td>";
}else{

      echo "<td><button class='btn btn-danger ' style='cursor: pointer;' id='my" . $val['asID'] . "' onClick='reply_click(this.id)'>Complete</button></td>";



}

 










    echo "  </tr>"; ?>
<?php   } ?>
</tbody>
</table>
<script type="text/javascript">
function reply_click(clicked_id) {

    // console.log(clicked_id);
    // die;
    $.ajax({
        type: 'POST',
        url: 'ajax_call.php?page=actionplanComplete',
        data: "value=" + clicked_id,
    }).done(function(data) {
        console.log(data);
        // location.replace('action-plan_completed');
    });



}
</script>
</div>
</div>
<?php
}

function decimal_to_time($dec)
{

// start by converting to seconds
@$seconds = ($dec * 3600);
// we're given hours, so let's get those the easy way
$hours = floor($dec);
// since we've "calculated" hours, let's remove them from the seconds variable
$seconds -= $hours * 3600;
// calculate minutes left
$minutes = floor($seconds / 60);
// remove those from seconds as well
$seconds -= $minutes * 60;
// return the time formatted HH:MM:SS
return $hours . " Hours: " . $minutes . " minutes: ";
}

// lz = leading zero

public function selectUserInfo($user,$col_name){
    
    $sql = "SELECT $col_name from accounts_user where acc_id = $user;";
    $query = $this->dbF->getRow($sql);

    return $query[$col_name];
}


public function setli($data, $page = 'submitevent')
{

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
}else{
    $user = intval($_SESSION['currentUser']);
}

$signup_date = $this->selectUserInfo($user,"acc_created");

// echo "<script>alert('".$signup_date."');</script>";
    
$li = "";
foreach ($data as $key => $value) {
    
    if($value['type'] != 'updates'){
    
        if(empty($value['due_date'])){
        
        $due_date = date("d-M-Y", strtotime($signup_date));;
        
        }else{
            $due_date = date("d-M-Y", strtotime($value['due_date']));
        }
        
    }else{
        $due_date = date("d-M-Y", strtotime($value['due_date']));
    }
    
    if($value['type'] == 'mandatory'){$typeColor="red ";}
    
    else if($value['type'] == 'updates'){$typeColor="purple ";}

    else if($value['type'] == 'recommended'){$typeColor="green ";}
    
    $li .= '<li class="all ' . @$typeColor . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
            <div class="col4_main_left1">
            ' . $value['title'];

    if ($page == 'editevent') {
        
        // if ($value['dateTime'] == '') {
        $li .= ' <span style="position: relative;
            top: 0px;">(' . $due_date . ')</span>';
        // } else {
        // $li .= ' <span>(' . date("d-M-Y", strtotime($value['dateTime'])) . ')</span>';
        // }
    
    } else {
    $li .= ' <span style="position: relative;
        top: 0px;">(' . $due_date . ')</span>';
    }
    
    $li .= '</div>
            <div class="col4_main_left3">';
            
if ($page == 'editevent') {
    
    @$value['color_publish'];
    
    if (@$value['color_publish'] == '1') {
    
    $eventcolor = 'style=" color: #7aff00 !important; cursor: pointer;"';
    } else {
    
    $eventcolor = '';
    echo '<script>$(document).ready(function(){$(".mycolor").addClass("abrown");});</script>';
    }
    
if ($value['approved'] == '0' && $value['assignto'] > 0 && $_SESSION['currentUserType'] != 'Employee') {
$li .= '
<a onclick="' . $page . '(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '" class="agray"><i class="fas fa-user"></i></a>';
} 
else if ($_SESSION['currentUserType'] != 'Employee' && $value['approved'] == '-1' && ($value['assignto'] > 0 || strpos($value['assignto'], '-1') !== false || strpos($value['assignto'], 'G.') !== false )) {
    
    if (strpos($value['assignto'], '-1') !== false) {
        $assignto = 'All';
    }
    else if(strpos($value['assignto'], 'G.') !== false){
        $assign = explode('.',$value['assignto']);
        $assignto = $this->groupName($assign[1]);
    }
    else {
        $assignto = $this->UserName($value['assignto']);
    }

    if(empty($assignto)){
    
           $assignto = "anonymous";
    }

$li .= '
<a class="mycolor" ' . $eventcolor . ' onclick="' . $page . '(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"  ><i class="fas fa-user"></i></a>';
}


if ($value['userfile'] != '#' && trim($value['userfile']) != '') {

$link = explode(",", @$value['userfile']);
$allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
foreach ($link as $key => $val) {

                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
      $downLink=base64_encode($val.":s:".date('d'));



    $ext = pathinfo($val, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
    } else {

        // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
    }
}
}
}
$li .= '
<a onclick="' . $page . '(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" data-toggle="tooltip" title="Upload" class="ablue"><i class="fas fa-edit"></i></a>
</div>
</li>';
}
return $li;
}

// my events
public function countMyEvents()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
//  $user = $_SESSION['superid'];

$user = intval($_SESSION['webUser']['id']);
if (isset($_SESSION['practiceUser'])) {
$user = intval($_SESSION['superid']);
}
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql1 = "SELECT  COUNT(*) FROM `myevents` WHERE (`assignto` IN ('-1.$d[0]','$user'$temp)  OR  `user`='$user' ) AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";


$data1 = $this->dbF->getRow($sql1);

$return = $data1[0] + 0;
} else {
$user1 = intval($_SESSION['currentUser']);
$user = intval($_SESSION['webUser']['id']);

$sql = "SELECT  COUNT(*) FROM `myevents` WHERE `user`='$user1' AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";
$data = $this->dbF->getRow($sql);
$return = $data[0] + 0;
}

return $return;
}

public function myEventsTitle()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
$user = intval($_SESSION['webUser']['id']);
if (isset($_SESSION['practiceUser'])) {
$user = intval($_SESSION['superid']);
}
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `assignto` IN ('-1.$d[0]','$user'$temp) AND `status`!='deleted'";
$data = $this->dbF->getRows($sql);
usort($data, 'compare_category');
$cate = "<h5 class='all atv'>All</h5>";
$cate .= '<h5 class="">Completed</h5>';
$cate .= '<h5 class="">Pending</h5>';
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
} else {
$user = intval($_SESSION['currentUser']);
// $user = $_SESSION['webUser']['id'];
$sql = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`!='deleted'";
$data = $this->dbF->getRows($sql);
usort($data, 'compare_category');
$cate = "<h5 class='all '>All</h5>";
$cate .= '<h5 class="">Completed</h5>';
$cate .= '<h5 class="">Pending</h5>';
foreach ($data as $key => $value) {
$cate .= "<h5 class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "'>" . $value['category'] . "</h5>";
}
}





// return $cate1;
// return $cate2;
// return $cate;
// $this->dbF->prnt($_SESSION);
return $cate;
}

public function myEvents()
{

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
//$user = $_SESSION['webUser']['id']; 
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$temp=$this->allGroupsIds($user);
$sql = "SELECT  * FROM `myevents` WHERE (`assignto` IN ('-1.$d[0]','$user'$temp)  OR  `user`='$user' ) AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";




$data = $this->dbF->getRows($sql);

// $sql = "SELECT  * FROM `myevents` WHERE  `status`='complete' ORDER BY `title`";
// $data = $this->dbF->getRows($sql);

$catName = "";


$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {

if ($value['status'] == 'complete') {
    $complete = 'completed';
    $style = 'style="
background-color: #ffffff8c;
"';


$catName = "- ".str_replace('&', '', str_replace(' ', '', $value['category']));




}else if ($value['status'] == 'pending') {
    $complete = 'Pending';
    $style = 'style="background-color: rgb(251 220 220 / 55%);"';

   $catName = "- ".str_replace('&', '', str_replace(' ', '', $value['category']));

} else {
    $style = '';
    $complete = $value['status'];

    $catName = "";


}
if (strpos($value['assignto'], '-1') !== false) {
    $assignto = 'All';
} else {
    $assignto = $this->UserName($value['assignto']);
}

if(empty($assignto)){

       $assignto = "anonymous";
}




if ($value['color_publish'] == '1') {

    $myeventcolor = 'style=" color: #00ff64 !important; cursor: pointer;"';
} else {
    $myeventcolor = '';
    echo '<script>$(document).ready(function(){$(".mycolor").addClass("abrown");});</script>';
}

// if(empty($catName) && $catName != 'completed'){

$li .= '<li  ' . $style . ' class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . $complete . ' ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span>(' . date("d-M-Y", strtotime($value['due_date'])) . ') '.$catName.' - ' . ucfirst($complete) . '</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
         $downLink=base64_encode(WEB_URL.'/images/'.$val.":s:".date('d'));


        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            
        }
    }
}
if ($value['assignto'] != '') {
    // HERE !!
    $li .= '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';
}
// echo $myeventcolor ;
$li .= '<a class="ablue" onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>';

$li .= '<a class="ared"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="calendar?sure=' . base64_encode($value['id']."&d=".date('d')) . '"><i class="fas fa-trash"></i></a>';


$li .= '  </div><!-- col4_main_left3 close -->
</li>';


// }


}
}
} else {
$user1 = intval($_SESSION['currentUser']);
$user = intval($_SESSION['webUser']['id']);
$sql = "SELECT  * FROM `myevents` WHERE `user`='$user1' AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";
$data = $this->dbF->getRows($sql);
$li = "";
$catName = "";

if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
if ($value['status'] == 'complete') {
    $complete = 'completed';
    $style = 'style="background-color: #ffffff8c;"';

    $catName = "- ".str_replace('&', '', str_replace(' ', '', $value['category']));


}else if ($value['status'] == 'pending') {
    $complete = 'Pending';
    $style = 'style="background-color: rgb(251 220 220 / 55%);"';


      $catName = "- ".str_replace('&', '', str_replace(' ', '', $value['category']));

} else {
    $style = '';
    $complete = $value['status'];
    $catName = "";
}
if (strpos($value['assignto'], '-1') !== false) {
    $assignto = 'All';
} else {
    $assignto = $this->UserName($value['assignto']);
}if(empty($assignto)){

       $assignto = "anonymous";
}

if ($value['color_publish'] == '1') {

    $myeventcolor = 'style=" color: #00ff64 !important; cursor: pointer;"';
} else {

    $myeventcolor = '';
    echo '<script>$(document).ready(function(){$(".mycolor").addClass("abrown");});</script>';
}

// if(empty($catName) && $catName != 'completed'){



$li .= '<li  ' . $style . ' class="all ' . (($value['type'] == 'mandatory') ? 'red ' : '') . $complete . ' ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span>(' . date("d-M-Y", strtotime($value['due_date'])) . ') '.$catName.' - ' . ucfirst($complete) . '</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['assignto'] != '') {

    $li .= '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';
}
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
        $downLink=base64_encode($val.":s:".date('d'));


        $ext = pathinfo($val, PATHINFO_EXTENSION);


        if (!in_array($ext, $allowed)) {

            // if ($value['file'] != "#") {
                $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            // }
        } else {

            // if ($value['file'] != "#") {
                // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            // }
        }
    }
}
$li .= '<a class="apink" onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Edit Event"><i class="fas fa-edit"></i></a>';



$li .= '<a class="apink" onclick="submitMYevent(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Submit Event"><i class="fas fa-file"></i></a>';




// if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'full'){
$li .= '<a class="apink"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="calendar?sure=' . base64_encode($value['id']."&d=".date('d')) . '"><i class="fas fa-trash"></i></a>';
// }
$li .= '</div>
</li>';


// }
}
}
}
return $li;
}
public function myEventsCompleted()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
$user = intval($_SESSION['webUser']['id']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT  * FROM `myevents` WHERE  `status`='complete' ORDER BY `title` , `dateTime` DESC";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
$li .= '<li class="all blue ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['due_date'])) . '">(' . date("d-M-Y", strtotime($value['due_date'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {

                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
        $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f='. $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="'. $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '<a class="ablue" onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>
</div><!-- col4_main_left3 close -->
</li>';
}
}
} else {
$user = intval($_SESSION['currentUser']);
// $user = $_SESSION['webUser']['id']; 
$sql = "SELECT  * FROM `myevents` WHERE `user`='$user' AND `status`!='deleted' ORDER BY `title`  , `dateTime` DESC";
$data = $this->dbF->getRows($sql);
$li = "";
if (!$data) {
$li = "no data found";
} else {
foreach ($data as $key => $value) {
if (strpos($value['assignto'], '-1') !== false) {
    $assignto = 'All';
} else {
    $assignto = $this->UserName($value['assignto']);
}if(empty($assignto)){

       $assignto = "anonymous";
}

$li .= '<li class="all blue ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
' . $value['title'] . '
<span data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime($value['due_date'])) . '">(' . date("d-M-Y", strtotime($value['due_date'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
if ($value['assignto'] != '') {


    $li .= '<a class="abrown" onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';
}
if ($value['file'] != '#') {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
         $downLink=base64_encode(WEB_URL . '/images/' .$val.":s:".date('d'));




        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {

            // $li .= '<a class="apink" href="' . WEB_URL . '/d?f='. $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            $li .= '<a class="apink" href="'. $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
}
$li .= '<a class="ablue" onclick="myevents(this.id)" id="' . $value['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>';
if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'full') {
    $li .= '<a class="ared"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="calendar?sure=' . base64_encode($value['id']."&d=".date('d')) . '"><i class="fas fa-trash"></i></a>';
}
$li .= '</div>
</li>';
}
}
}
return $li;
}



public function deleteReminder($event_id){
    $sql = "DELETE from `cronData` where `event_Id` = ? ";
    $this->dbF->setRow($sql, array($event_id));
}




public function myeventsSubmit()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('myeventsSubmit')) {
return false;
}

 $webUserid = $_SESSION['webUser']['id'];




// echo "myeventsSubmit";
// $this->dbF->prnt($_POST);
$edit_id    = empty($_POST['edit_id'])   ? ""    : $_POST['edit_id'];
$title_id  = empty($_POST['title_id']) ? ""    : $_POST['title_id'];
$desc1     = empty($_POST['desc'])     ? ""    : $_POST['desc'];
$actionplan     = empty($_POST['actionplan'])     ? ""    : $_POST['actionplan'];
$comment     = empty($_POST['comment'])     ? ""    : $_POST['comment'];
$desc2     = empty($_POST['desc2'])    ? "No"    : $_POST['desc2'];
$confirm   = empty($_POST['confirm'])  ? "-1"  : $_POST['confirm'];
$assignto = empty($_POST['assignto'])  ? "0"  : $_POST['assignto'];
$date     = empty($_POST['due_date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['due_date']));
$type     =  empty($_POST['event_type'])   ? ""    : $_POST['event_type'];
if ($_POST['recurring_duration'] == '') {
$_POST['recurring_duration'] = $_POST['recurring_duration_Hidden'];
//$recurring = '';
}

if (empty($_FILES['0']['tmp_name'])) {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'];
} else {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'] . ",";
}

$recurring    = empty($_POST['recurring_duration'])   ? ""  : $_POST['recurring_duration'];
// $recurring_duration    = empty($_POST['recurring_duration'])   ? ""  : $_POST['recurring_duration'];
// $title_id=intval($title_id);
// htmlspecialchars($desc1);
// htmlspecialchars($comment);
// htmlspecialchars($desc2);
// htmlspecialchars($confirm);
// htmlspecialchars($assignto);
// htmlspecialchars($date);
// htmlspecialchars($recurring);


if (isset($_POST['change-session'])) {
$user =    intval($_POST['practiceUser']);
} else {

$user = intval($_SESSION['currentUser']);
}
$title    = $this->myeventsTableTitle($title_id);
$email    = $this->ibms_setting('Email');
if ($recurring == 'No Recurrence' || $recurring == 'Once' || $recurring == 'Once Check') {
$recurring_duration = $this->nextDueDate($recurring);
} else {
$recurring_duration = $this->nextDueDate($recurring, $date);
}
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = '';


if ($confirm == '1') {

if ($this->userCheck($user)) {
$approved = 0;
} else {

$approved = 1;
}
} else {
$approved = $confirm;
}

if($old_file == WEB_URL."/images/"){
  $old_file ="";  
}



$docname = $old_file;
if (empty($_FILES['0']['tmp_name'])) {
$docname = $old_file;
} else {

foreach ($_FILES as $key => $tmpName) {
$filename = $this->uploadSingleFile($tmpName, 'files', '');


if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}

}


$docname = trim($docname, ",");
$docname = trim($docname, "#");
}
try {
$this->db->beginTransaction();




// $sql      =   "INSERT INTO `userevent`(`user`,`assignto`,`title_id`,`file`,`approved`,`desc`,`comment`,`due_date`,`recurring`,`dateTime`) VALUES (?,?,?,?,?,?,?,?,?,?)";
// $array   = array($user, $assignto, $title_id, $docname, $approved, nl2br($desc), $comment, $date, $recurring, $date);
// $this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
if ($approved == 1) {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid = $_SESSION['webUser']['id'];
} else {
    $uid = $_SESSION['currentUser'];
}

$sql      =   "UPDATE `myevents` SET `approved` = ? ,`status` = ? WHERE `id` = ?";
$array   = array(1,"complete",$edit_id);
$this->dbF->setRow($sql, $array, false);
$this->setlog("Event Approved", $this->UserName($uid) . " : $uid",$edit_id, $title . " : " . $title_id);

} else {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid =intval( $_SESSION['webUser']['id']);
} else {
    $uid =intval( $_SESSION['currentUser']);
}
$this->setlog("Event Update", $this->UserName($uid) . " : $uid", "", $title . " : " . $title_id);
}

$form   = empty($_POST['form'])  ? array() : $_POST['form'];
foreach ($form as $key => $value) {
$sql2 = "INSERT INTO `myeventsFilled`(`my_e_id`,`title_id`,`q_id`,`user`,`radio`,`date`,`time`,`field1`,`field2`) VALUES (?,?,?,?,?,?,?,?,?)";

$sqlfetch_id = "SELECT fetch_id FROM `myevents` WHERE `id`=$title_id";
$datafetch_id = $this->dbF->getRow($sqlfetch_id);
$fetch_id = $datafetch_id['fetch_id'];
if(empty($fetch_id)){
    $fetch_id = $title_id;
}



$array2   = array($title_id, $fetch_id, $value['question'], $user, @$value['radio'], @$value['date'], @$value['time'], @$value['field1'], @$value['field2']);
$this->dbF->setRow($sql2, $array2, false);
$lastId = $this->dbF->rowLastId;

// var_dump($_POST); 

// $this->setlog("insertion in table myeventsFilled", $this->UserName($webUserid) . " : $webUserid",$lastId,"my_e_id:".$title_id . " - title_id:" . $fetch_id);


}

if ($recurring == 'Once' || $recurring == 'Once Check') {
$sql = "SELECT * FROM `myevents` WHERE `id`= ? ";
$data = $this->dbF->getRow($sql, array($title_id));
$title_id = intval($data['id']);
$recurring_duration = Date('Y-m-d', strtotime($date . '+' . $data['recurring_duration']));
}

        if ($recurring != 'No Recurrence') {
        if ($approved == 1) {
        if ($desc2 == "Yes") {

        $sql = "SELECT `category`,`desc` FROM `myevents` WHERE `id`=? ";
        $dataX = $this->dbF->getRow($sql, array($title_id));



        $sql      =   "INSERT INTO `myevents`(`user`,`title`,`assignto`,`due_date`,`fetch_id`,`category`,`desc`,`status`,`file`,`recurring_duration`,`comment`,`actionplan`,`type`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        if ($_POST['recurring_duration'] == '1 day') {


            $recurring_duration = $this->nextworkingday($recurring_duration);
            //  if($this->isWeekend($recurring_duration)){
            //     $recurring_duration = Date('Y-m-d',strtotime($recurring_duration.'+ 1 day'));
            // }
        }
        $array   = array($user, $title, $assignto, $recurring_duration,$fetch_id, $dataX['category'], $dataX['desc'], "pending", "#", $recurring, $comment, $actionplan,$type);
        $this->dbF->setRow($sql, $array, false);
        if ($_SESSION['currentUserType'] == 'Employee') {
            $uid = $_SESSION['webUser']['id'];
        } else {
            $uid = $_SESSION['currentUser'];
        }
        $this->setlog("New Event Create", $this->UserName($uid) . " : $uid", "", $title . " : " . $title_id);
    }
}
}

$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {


$lastAssigned = $this->getMyEventData($edit_id,'assignto');

    $sql      =   "UPDATE `myevents` SET `actionplan` = ? ,`comment` = ? ,`file` = ?,`due_date` = ?,`recurring_duration` = ?,`assignto` = ? WHERE `id` = ?";
$array   = array($actionplan, $comment, $docname,$date,$recurring,$assignto,$edit_id);
$this->dbF->setRow($sql, $array, false);

// checking if the same user submit the event whome assign to the it will delete from reminder
if($_SESSION['currentUserType'] == 'Employee' && $lastAssigned == $_SESSION['webUser']['id']){
    $this->deleteReminder($edit_id);
    $this->notifications('event',$_SESSION['webUser']['id'],$title);
}




if ($approved == 0) {
    //   $this->send_mail($email,$title,'','eventsubmit');
}
// echo "$edit_id";

if($lastAssigned != $assignto){
    $this->deleteReminder($edit_id);
    
    if (strpos($assignto, '-1') !== false) {
        // $this->dbF->prnt[$_POST];
        
         $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val='$user'";
         $d = $this->dbF->getRows($q);
        foreach ($d as $key => $value) {
            $this->setReminder($value['id_user'], "eventhasreminder", $edit_id);
            $this->notifications('uevent', $value['id_user'], $title);
        }
    } else {
            $this->setReminder($_POST['assignto'], "eventhasreminder", $edit_id);
            $this->notifications('uevent', $_POST['assignto'], $title);
            // var_dump($user,$_POST['assignto']);
        // $hasreminder = date('Y-m-d');
        // $allus = @$_POST['assignto'];
        // $typeName = "eventhasreminder";
        // $start_date = date('d-M-Y', strtotime($hasreminder));
        // $date = strtotime($start_date);
        // $date = strtotime("+7 day", $date);
        // $Event_one_week_date = date('d-M-Y', $date);
        // $sql = "INSERT INTO `cronData`(`user`,`type`,`event_Id`,`event_Date`)VALUES('$assignto','$typeName','$edit_id','$Event_one_week_date')";
        // $this->dbF->setRow($sql);
        // var_dump($lastAssigned , $assignto);

        

     }
    
}
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function myeventsubmit()
{
if (isset($_POST['submit'])) {
// var_dump($_POST['event_type']);
if (!$this->getFormToken('myEvents')) {
return false;
}

// echo "myeventsubmit";
$title    = empty($_POST['title'])          ? ""    : $_POST['title'];
$desc     = empty($_POST['desc'])           ? ""    : $_POST['desc'];
// $tType     = empty($_POST['tType'])           ? ""    : $_POST['tType'];
$date     = empty($_POST['date'])           ? ""    : date('Y-m-d', strtotime($_POST['date']));
$color_publish = '0';
$category = empty($_POST['category'])       ? ""    : $_POST['category'];
if ($_POST['submit'] == "Save new event") {
  $status = "pending";      
}else{
$status   = empty($_POST['status'])         ? ""    : $_POST['status'];
}
$assignto = empty($_POST['assignto'])       ? ""    : $_POST['assignto'];
$file     = empty($_FILES['document']['name']) ? false : true;
$recurring_duration  = empty($_POST['recurring_duration'])   ? ""   : $_POST['recurring_duration'];
$event_type = empty($_POST['event_type'])          ? ""    : $_POST['event_type'];
// $recurring_duration1  = empty($_POST['recurring_duration1'])   ? ""   : $_POST['recurring_duration1'];

$date1   = empty($_POST['date1'])           ? ""    : date('Y-m-d', strtotime($_POST['date1']));
$title1  = empty($_POST['title1'])   ? ""   : $_POST['title1'];

htmlspecialchars($title);
htmlspecialchars($desc);
htmlspecialchars($date);
htmlspecialchars($color_publish);
htmlspecialchars($category);
htmlspecialchars($status);
htmlspecialchars($assignto);
htmlspecialchars($file);
htmlspecialchars($recurring_duration);
htmlspecialchars($date1);
htmlspecialchars($title1);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
$user =  intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
//$user = $_SESSION['webUser']['id'];
}




$docname = '#';

if ($file) {


$docname =  $this->uploadSingleFile($_FILES['document'], 'files', '');


if($docname==false) {
$docname = '#';
}else{
$docname = WEB_URL . "/images/$docname";
}




} else {
$docname = '#';
}

try {
$this->db->beginTransaction();

$sql    =   "INSERT INTO `myevents`(`title`,`user`,`due_date`,`file`,`assignto`,`category`,`desc`,`status`,`recurring_duration`,`color_publish`,`type`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

$array  = array($title, $user, $date,$docname, $assignto, $category, nl2br($desc), $status, $recurring_duration, $color_publish,$event_type);
$this->dbF->setRow($sql, $array, false);
$lastIda = $this->dbF->rowLastId;
if ($assignto == '-1.' . $_SESSION['currentUser']) {
$val=$this->allUserData($_SESSION['currentUser'],'acc_id');
foreach ($val as $value) {
    $uid=$value['acc_id'];

    $this->notifications('myeventtasks',$uid);
}

} else {
    $this->notifications('myeventtasks',$assignto);
}








// $lastIda = $this->dbF->rowLastIda;   
$title_id = empty($lastIda)  ? ""     : $lastIda;
$question = empty($_POST['question'])  ? array()     : $_POST['question'];
$categoryS = empty($_POST['categoryS'])  ? array()     : $_POST['categoryS'];
// $r    = empty($_POST['rRadio'])     ? array()  : $_POST['rRadio'];
// $d     = empty($_POST['rDate'])      ? array()  : $_POST['rDate'];
// $t     = empty($_POST['rTime'])      ? array()  : $_POST['rTime'];
// $radioData     = empty($_POST['radioData'])      ? array()  : $_POST['radioData'];
$field1   = empty($_POST['field1'])    ? array()     : $_POST['field1'];
$field2   = empty($_POST['field2'])    ? array()     : $_POST['field2'];
$publish  = 1;
    // $this->dbF->prnt($_POST);
    // $this->dbF->prnt($date);
    // $this->dbF->prnt($time);
    // $title_id=intval($title_id);
    // htmlspecialchars($question);
    // htmlspecialchars($categoryS);
    // htmlspecialchars($radio);
    // htmlspecialchars($date);
    // htmlspecialchars($time);
    // htmlspecialchars($field1);
    // htmlspecialchars($field2);
    // intval($publish);


for ($i=0; $i <count($question); $i++) { 
// $r = 'Radio';
// $t = 'Time';
// $d = 'Date';



$r    = empty($_POST['rRadio'][$i])     ? "Not"  : $_POST['rRadio'][$i];
$d     = empty($_POST['rDate'][$i])      ? "Not"  : $_POST['rDate'][$i];
$t     = empty($_POST['rTime'][$i])      ? "Not"  : $_POST['rTime'][$i];





    $sql = "INSERT INTO `myeventform`(`title_id`,`question`,`category`,`radio`,`date`,`time`,`field1`,`field2`,`publish`) VALUES (?,?,?,?,?,?,?,?,?)";







    $arrayd   = array($title_id,$question[$i],$categoryS[$i],$r,$d,$t,$field1[$i],$field2[$i],$publish);
    $this->dbF->setRow($sql,$arrayd,false);

    // var_dump($arrayd);



     
}

// var_dump($arrays);



if ($date1 != '') {
$recurring_duration1  = empty($_POST['recurring_duration1'])   ? ""   : $_POST['recurring_duration1'];


$sql    =   "INSERT INTO `myevents`(`title`,`user`,`due_date`,`file`,`assignto`,`category`,`desc`,`status`,`recurring_duration`,`color_publish`) VALUES (?,?,?,?,?,?,?,?,?,?)";
$array  = array($title1, $user, $date1, $docname, $assignto, $category, nl2br($desc), $status, $recurring_duration1, $color_publish);
$this->dbF->setRow($sql, $array, false);



$lastId1 = $this->dbF->rowLastId;









    // $lastId1 = $this->dbF->rowLastId1;   
    $title_id = empty($lastId1)  ? ""     : $lastId1;
    $question = empty($_POST['question'])  ? array()     : $_POST['question'];
    $categoryS = empty($_POST['categoryS'])  ? array()      : $_POST['categoryS'];
// $r    = empty($_POST['rRadio'])     ? array()  : $_POST['rRadio'];
// $d     = empty($_POST['rDate'])      ? array()  : $_POST['rDate'];
// $t     = empty($_POST['rTime'])      ? array()  : $_POST['rTime'];
    $field1   = empty($_POST['field1'])    ? array()      : $_POST['field1'];
    $field2   = empty($_POST['field2'])    ? array()    : $_POST['field2'];
    $publish  = 1;
    // $this->dbF->prnt($_POST);
    // $this->dbF->prnt($date);
    // $this->dbF->prnt($time);
    // $title_id=intval($title_id);
    // htmlspecialchars($question);
    // htmlspecialchars($categoryS);
    // htmlspecialchars($radio);
    // htmlspecialchars($date);
    // htmlspecialchars($time);
    // htmlspecialchars($field1);
    // htmlspecialchars($field2);
    // intval($publish);



for ($i=0; $i <count($question); $i++) { 

$r    = empty($_POST['rRadio'][$i])     ? "Not"  : $_POST['rRadio'][$i];
$d     = empty($_POST['rDate'][$i])      ? "Not"  : $_POST['rDate'][$i];
$t     = empty($_POST['rTime'][$i])      ? "Not"  : $_POST['rTime'][$i];


    $sql = "INSERT INTO `myeventform`(`title_id`,`question`,`category`,`radio`,`date`,`time`,`field1`,`field2`,`publish`) VALUES (?,?,?,?,?,?,?,?,?)";


    $arrayd   = array($title_id,$question[$i],$categoryS[$i],$r,$d,$t,$field1[$i],$field2[$i],$publish);
    $this->dbF->setRow($sql,$arrayd,false);

    // var_dump($arrayd);



     
}


// var_dump($arrays);




}

$lastId = $this->dbF->rowLastId;

$this->db->commit();
if ($this->dbF->rowCount > 0) {
if (strpos($assignto, '-1') !== false) {
    $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val= ? ";
    $d = $this->dbF->getRows($q, array($user));
    foreach ($d as $key => $value) {
        $this->notifications('uevent', $value['id_user'], $title);
    }
} else {
     $this->notifications('uevent', $assignto, $title);
}
if ($_SESSION['currentUserType'] == 'Employee') {
    $user = $_SESSION['webUser']['id'];
}
// $this->setlog("My Event Create", $this->UserName($user) . " : " . $user, "", $title);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

// public function myeventsubmit()
// {

// if (isset($_POST['submit'])) {
// if (!$this->getFormToken('myEvents')) {
// return false;
// }
// // $this->dbF->prnt($_FILES);
// $title    = empty($_POST['title'])          ? ""    : $_POST['title'];
// $desc     = empty($_POST['desc'])           ? ""    : $_POST['desc'];
// $date     = empty($_POST['date'])           ? ""    : date('Y-m-d', strtotime($_POST['date']));
// $color_publish = '0';
// $category = empty($_POST['category'])       ? ""    : $_POST['category'];
// $status   = empty($_POST['status'])         ? ""    : $_POST['status'];
// $assignto = empty($_POST['assignto'])       ? ""    : $_POST['assignto'];
// $file     = empty($_FILES['document']['name']) ? false : true;
// $recurring_duration  = empty($_POST['recurring_duration'])   ? ""   : $_POST['recurring_duration'];

// $date1   = empty($_POST['date1'])           ? ""    : date('Y-m-d', strtotime($_POST['date1']));
// $title1  = empty($_POST['title1'])   ? ""   : $_POST['title1'];

// htmlspecialchars($title);
// htmlspecialchars($desc);
// htmlspecialchars($date);
// htmlspecialchars($color_publish);
// htmlspecialchars($category);
// htmlspecialchars($status);
// htmlspecialchars($assignto);
// htmlspecialchars($file);
// htmlspecialchars($recurring_duration);
// htmlspecialchars($date1);
// htmlspecialchars($title1);

// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// // $user = $_SESSION['superid'];
// $user =  intval($_SESSION['webUser']['id']);
// } else {
// $user = intval($_SESSION['currentUser']);
// //$user = $_SESSION['webUser']['id'];
// }




// $docname = '#';

// if ($file) {


// $docname =  $this->uploadSingleFile($_FILES['document'], 'files', '');
// } else {
// $docname = '#';
// }

// try {
// $this->db->beginTransaction();

// $sql    =   "INSERT INTO `myevents`(`title`,`user`,`due_date`,`file`,`assignto`,`category`,`desc`,`status`,`recurring_duration`,`color_publish`) VALUES (?,?,?,?,?,?,?,?,?,?)";

// $array  = array($title, $user, $date, $docname, $assignto, $category, nl2br($desc), $status, $recurring_duration, $color_publish);
// $this->dbF->setRow($sql, $array, false);



// if ($date1 != '') {
// $recurring_duration1  = empty($_POST['recurring_duration1'])   ? ""   : $_POST['recurring_duration1'];


// $sql    =   "INSERT INTO `myevents`(`title`,`user`,`due_date`,`file`,`assignto`,`category`,`desc`,`status`,`recurring_duration`,`color_publish`) VALUES (?,?,?,?,?,?,?,?,?,?)";
// $array  = array($title1, $user, $date1, $docname, $assignto, $category, nl2br($desc), $status, $recurring_duration, $color_publish);
// $this->dbF->setRow($sql, $array, false);
// }

// $lastId = $this->dbF->rowLastId;

// $this->db->commit();
// if ($this->dbF->rowCount > 0) {
// if (strpos($assignto, '-1') !== false) {
//     $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val='$user'";
//     $d = $this->dbF->getRows($q);
//     foreach ($d as $key => $value) {
//         $this->notifications('uevent', $value['id_user'], $title);
//     }
// } else {
//     $this->notifications('uevent', $assignto, $title);
// }
// if ($_SESSION['currentUserType'] == 'Employee') {
//     $user = $_SESSION['webUser']['id'];
// }
// $this->setlog("My Event Create", $this->UserName($user) . " : " . $user, "", $title);
// return true;
// } else {
// return false;
// }
// } catch (Exception $e) {
// $this->db->rollBack();
// $this->dbF->error_submit($e);
// return false;
// }
// } // If end
// }


public function myeventedit()
{
// var_dump($_POST);

if (isset($_POST['edit'])) {
if (!$this->getFormToken('myEvents')) {
return false;
}

// $this->dbF->prnt($_FILES);
$id       = empty($_POST['id'])             ? ""    : $_POST['id'];
$title    = empty($_POST['title'])          ? ""    : $_POST['title'];
$title_id  = empty($_POST['title_id']) ? ""    : $_POST['title_id'];

$category = empty($_POST['category'])       ? ""    :$_POST['category'];
$status='complete';
// $status   = empty($_POST['status'])         ? ""    : $_POST['status'];
$assignto = empty($_POST['assignto'])       ? ""    : $_POST['assignto'];
$file      = empty($_FILES['document']['name']) ? false : true;
$confirm    = empty($_POST['confirm'])   ? "-1"  : $_POST['confirm'];
$type      = empty($_POST['event_type'])      ? ""    : $_POST['event_type'];

$edit_id    = empty($_POST['edit_id'])   ? ""    : $_POST['edit_id'];

$desc1      = empty($_POST['desc'])      ? ""    : $_POST['desc'];
$desc2      = empty($_POST['desc2'])     ? "No"  : $_POST['desc2'];
$date       = empty($_POST['date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['date']));
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'];
// var_dump($old_file);
$recurring_duration  = empty($_POST['recurring_duration'])      ? ""    : $_POST['recurring_duration'];
// $id=intval($id);
// $title_id=intval($title_id);
// intval($user);
// htmlspecialchars($title);
// htmlspecialchars($status);
// htmlspecialchars($assignto);
// htmlspecialchars($file);
// htmlspecialchars($confirm);
// htmlspecialchars($edit_id);
// htmlspecialchars($desc1);
// htmlspecialchars($desc2);
// htmlspecialchars($date);
// htmlspecialchars($old_file);
// htmlspecialchars($recurring_duration);

$user = $_POST['cur_user'];
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {

$color_publish = '1';
} else {

$color_publish = "0";
}


$approved = '';

if ($status  == 'complete') {




$approved = 1;
 
}

$docname = '#';
if ($file == true) {
$fname  = '/images/' . $old_file;

$path = parse_url($fname, PHP_URL_PATH);
$name = $_SERVER['DOCUMENT_ROOT'] . $path;
// @unlink($name);
if ($old_file != '#') {

$docname =  $this->uploadSingleFile($_FILES['document'], 'files', '');


if($docname==false) {
$docname = '#';
}else{
$docname = $docname;
}




// ========================TrashData==============================
$ds = "Update My Event File   (:title is" . $_POST['title'] . ")(:User by" . $user . ")(:User of " . $assignto . ")";
$this->TrashData('Activity Calendar', $ds, $old_file, $user, $assignto, 'myevents', $id, 'MY Event Edit');
// ========================TrashData================================
}else{
    
    $docname =  $this->uploadSingleFile($_FILES['document'], 'files', '');


    if($docname==false) {
$docname = '#';
}else{
$docname = $docname;
}




}




} else {

$docname = $old_file;
}



try {
$this->db->beginTransaction();
// var_dump($type);
$lastAssigned = $this->getMyEventData($id,'assignto');
 $sql    =   "UPDATE `myevents` SET
                `title` = ?,
                `due_date` = ?,
                `file` = ?,
                `assignto` = ?,
                `category` = ?,
                `desc` = ?,
                `status` = ?,
                `approved` = ?,
                `recurring_duration` = ?,
                `color_publish` = ?,
                `type`=?
                
                
         WHERE   `id` = '$id'";
$array  = array($title, $date, $docname, $assignto, $category, nl2br($desc1), $status, $approved, $recurring_duration, $color_publish,$type);
$this->dbF->setRow($sql, $array, false);
$last_row_count = $this->dbF->rowCount ;
// var_dump($sql,  $array);


    $fid       = empty($_POST['fid']) ? array()           : $_POST['fid'];
    $question  = empty($_POST['question'])  ? array()     : $_POST['question'];
    $categoryS = empty($_POST['categoryS'])  ? array()    : $_POST['categoryS'];
// $radio    = empty($_POST['radioDataRadio'])     ? array()  : $_POST['radioDataRadio'];
// $date     = empty($_POST['radioDataDate'])      ? array()  : $_POST['radioDataDate'];
// $time     = empty($_POST['radioDataTime'])      ? array()  : $_POST['radioDataTime'];
// $radioData     = empty($_POST['radioData'])      ? array()  : $_POST['radioData'];
    $field1    = empty($_POST['field1'])    ? array()     : $_POST['field1'];
    $field2    = empty($_POST['field2'])    ? array()     : $_POST['field2'];
// $this->dbF->prnt($_POST);
// $r = 'Radio';
// $t = 'Time';
// $d = 'Date';
for ($i=0; $i <count($fid); $i++) { 
    
$r    = empty($_POST['rRadio'][$i])     ? "Not"  : $_POST['rRadio'][$i];
$d     = empty($_POST['rDate'][$i])      ? "Not"  : $_POST['rDate'][$i];
$t     = empty($_POST['rTime'][$i])      ? "Not"  : $_POST['rTime'][$i];




//   if (in_array("Date", $radioData[$i])){
// $d = 'Radio';


//   }

//   if (in_array("Time", $radioData[$i])){

//      $t = 'Time';

//   }


//     if (in_array("Radio", $radioData[$i])){

//      $r = 'Radio';

//   }

$sqlw    =   "UPDATE `myeventform` SET
                `question` = ?,
                `category` = ?,
                `radio` = ?,
                `date` = ?,
                `time` = ?,
                `field1` = ?,
                `field2` = ?             
         WHERE   `id` = ? and `title_id` = ?";
$arrayw  = array($question[$i],$categoryS[$i],$r,$d,$t,$field1[$i],$field2[$i],$fid[$i],$title_id);
$this->dbF->setRow($sqlw, $arrayw, false);

}


    $question = empty($_POST['equestion'])  ? array()     : $_POST['equestion'];
    $categoryS = empty($_POST['ecategoryS'])  ? array()     : $_POST['ecategoryS'];
// $radio    = empty($_POST['eeradioDataRadio'])     ? array()  : $_POST['eradioDataRadio'];
// $date     = empty($_POST['eradioDataDate'])      ? array()  : $_POST['eradioDataDate'];
// $time     = empty($_POST['eradioDataTime'])      ? array()  : $_POST['eradioDataTime'];
// $radioData     = empty($_POST['radioData'])      ? array()  : $_POST['radioData'];


    $field1   = empty($_POST['efield1'])    ? array()     : $_POST['efield1'];
    $field2   = empty($_POST['efield2'])    ? array()     : $_POST['efield2'];
    $publish  = 1;



for ($i=0; $i <count($question); $i++) { 
// $r = 'Radio';
// $t = 'Time';
// $d = 'Date';

$r    = empty($_POST['erRadio'][$i])     ? "Not"  : $_POST['erRadio'][$i];
$d     = empty($_POST['erDate'][$i])      ? "Not"  : $_POST['erDate'][$i];
$t     = empty($_POST['erTime'][$i])      ? "Not"  : $_POST['erTime'][$i];





    $sql = "INSERT INTO `myeventform`(`title_id`,`question`,`category`,`radio`,`date`,`time`,`field1`,`field2`,`publish`) VALUES (?,?,?,?,?,?,?,?,?)";

    $arrayd   = array($title_id,$question[$i],$categoryS[$i],$r,$d,$t,$field1[$i],$field2[$i],$publish);
    $this->dbF->setRow($sql,$arrayd,false);

    // var_dump($arrayd);



     
}




// $this->dbF->prnt($array);
if (@$_POST['recurring_duration'] == 'No Recurrence') {
$date = $this->nextDueDate($_POST['recurring_duration']);
} else {
$date = $this->nextDueDate(@$_POST['recurring_duration'], $date);
}


// if ($recurring_duration != 'No Recurrence') {
// if ($approved == 1) {

//     $sql      =   "INSERT INTO `myevents`(`user`,`title`,`assignto`,`category`,`due_date`,`file`,`status`,`approved`,`recurring_duration`,`color_publish`) VALUES (?,?,?,?,?,?,?,?,?,?)";

//     $this->nextworkingday($date);
//     //        if($this->isWeekend($date)){
//     // $date = Date('Y-m-d',strtotime($date.'+ 1 day'));
//     //        }
//     //         if($this->isWeekend($date)){
//     // $date = Date('Y-m-d',strtotime($date.'+ 1 day'));
//     //        }
//     $array   = array($user, $title, $assignto, $category, $date, '#', 'pending', '-1', $recurring_duration, '0');
//     $this->dbF->setRow($sql, $array, false);








//     $lastId1 = $this->dbF->rowLastId;











//     $question = empty($_POST['equestion'])  ? array()     : $_POST['equestion'];
//     $categoryS = empty($_POST['ecategoryS'])  ? array()     : $_POST['ecategoryS'];
//     // $radio    = empty($_POST['eradio'])     ? array()  : $_POST['eradio'];
//     // $date     = empty($_POST['edateS'])      ? array()  : $_POST['edateS'];
//     // $time     = empty($_POST['etime'])      ? array()  : $_POST['etime'];
//     $field1   = empty($_POST['efield1'])    ? array()     : $_POST['efield1'];
//     $field2   = empty($_POST['efield2'])    ? array()     : $_POST['efield2'];
//     $publish  = 1;

// $eradioData     = empty($_POST['eradioData'])      ? array()  : $_POST['eradioData'];

// for ($i=0; $i <count($question); $i++) { 

// $r    = empty($_POST['erRadio'][$i])     ? "Not"  : $_POST['erRadio'][$i];
// $d     = empty($_POST['erDate'][$i])      ? "Not"  : $_POST['erDate'][$i];
// $t     = empty($_POST['erTime'][$i])      ? "Not"  : $_POST['erTime'][$i];




//     $sql = "INSERT INTO `myeventform`(`title_id`,`question`,`category`,`radio`,`date`,`time`,`field1`,`field2`,`publish`) VALUES (?,?,?,?,?,?,?,?,?)";

//     $arrayd   = array($lastId1,$question[$i],$categoryS[$i],$r,$d,$t,$field1[$i],$field2[$i],$publish);
//     $this->dbF->setRow($sql,$arrayd,false);

//     // var_dump($arrayd);



     
// }




//     // $this->setlog("My Event Update", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
// }
// }


$lastId = $this->dbF->rowLastId;
$this->db->commit();

// not comming here..
// var_dump( $last_row_count);
// exit();
// if ($this->dbF->rowCount > 0) {
if ($last_row_count > 0) {
    
if($_SESSION['currentUserType'] == 'Employee' && $lastAssigned == $_SESSION['webUser']['id']){
    $this->deleteReminder($edit_id);
    $this->notifications('event',$_SESSION['webUser']['id'],$title);
     $user = intval($_SESSION['webUser']['id']);
    $this->setlog("Event '$title' has been completed by: $assignto", $this->UserName($user) . " : " . $user, "", $title . " : " . $id);
}else{
    if($lastAssigned != $assignto) {
        $this->deleteReminder($edit_id);
        if (strpos($assignto, '-1') !== false) {
            $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val='$user'";
            $d = $this->dbF->getRows($q);
            foreach ($d as $key => $value) {
                $user_id = $value['id_user'];
                 $this->notifications('uevent',$value['id_user'],$title);
                 $this->setReminder($value['id_user'], "eventhasreminder", $edit_id);
                 $this->setlog("Event '$title' assigned to user id : $user_id", $this->UserName($user_id) . " : $user", "", $title . " : " . $title_id);
            } 
        } else {
            $this->setlog("Event '$title' assigned to user id : $assignto", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
             $this->setReminder($assignto, "eventhasreminder", $edit_id);
            $this->notifications('uevent',$assignto,$title);
    }
    
}
    
}

return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end

}

public function EmployeeId($id)
{
if (strpos($id, '-1') !== false) {
$ids = null;
$sql = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val= ? ";
$data = $this->dbF->getRows($sql,array($_SESSION['currentUser']));
foreach ($data as $key => $value) {
$ids .= $this->getUserPlayerId($value['id_user']) . ",";
}
return trim($ids, ",");
} else {
return $this->getUserPlayerId($id);
}
}

public function UserEmail($id)
{
$sql = "SELECT acc_email FROM accounts_user WHERE acc_id = ? AND acc_type = ? ";
$data = $this->dbF->getRow($sql,array($id,'1'));
return @$data[0];
}

public function PracticeId($id)
{
// $sql = "SELECT setting_val FROM accounts_user_detail WHERE setting_name= ? AND id_user= ? ";
// $data = $this->dbF->getRow($sql,array('account_under',$id));
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name = ? AND id_user = ? AND 
id_user NOT IN ( SELECT id_user FROM `accounts_user_detail` WHERE setting_name = 'account_type' AND setting_val = 'Master') 
AND id_user NOT IN ( SELECT id_user FROM `accounts_user_detail` WHERE setting_name = 'account_type' AND setting_val = 'Practice') ";
$data = $this->dbF->getRow($sql,array('account_under',$id));
if($data){
 return $data[0];
}
else{
    return $id;
}
// var_dump($data);
// exit();
}

public function allPractice($id, $chk = 0)
{
$op = "";
$sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`= ? AND `id_user`= ? ";
$data = $this->dbF->getRow($sql,array('account_under',$id));
if (!empty($data)) {
$ids = array_unique(explode(',', $data[0]));
foreach ($ids as $key => $value) {
if ($value == $chk) {
$op .= "<option selected value='$value'>" . $this->PracticeName($value) . "</option>";
} else {
$op .= "<option value='$value'>" . $this->PracticeName($value) . "</option>";
}
}
}
return $op;
}


public function allEmployeesNamesOption($id, $chk = 0)
{    
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under' OR acc_id = '$id') AND acc_type='1'";

$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option selected value='$value[acc_name]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_name]'>$value[acc_name]</option>";
}
}
return $op;
}


public function allEmployeesNamesOptionID($id, $chk = 0)
{    
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under' OR acc_id = '$id') AND acc_type='1'";

$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option selected value='$value[acc_id]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_id]'>$value[acc_name]</option>";
}
}
return $op;
}

public function allUserData($id, $col = 'acc_id')
{  
$sql="SELECT $col FROM `accounts_user` WHERE  acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under') OR acc_id = '$id'";
return $data = $this->dbF->getRows($sql);
}

public function allEmployees($id, $chk = 0)
{    
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under') AND `acc_id` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='Master' AND `setting_name`='account_type') OR acc_id = '$id' AND acc_type='1'";

$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option selected value='$value[acc_id]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_id]'>$value[acc_name]</option>";
}
}
return $op;
}
public function allEmployees_view($id, $chk = 0)
{
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under' )";
$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option  value='$value[acc_id]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_id]'>$value[acc_name]</option>";
}
}
return $op;
}


public function allEmployees_view_names_option($id, $chk = 0)
{
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under' )";
$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option  value='$value[acc_name]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_name]'>$value[acc_name]</option>";
}
}
return $op;
}

public function allEmployees_view_names_optionID($id, $chk = 0)
{
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under' )";
$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option  value='$value[acc_id]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_id]'>$value[acc_name]</option>";
}
}
return $op;
}


public function allEmployee($id, $chk = 0)
{
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE acc_type = '1' AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under') AND acc_type='1'";

$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {
$op .= "<option selected value='$value[acc_id]'>$value[acc_name]</option>";
} else {
$op .= "<option value='$value[acc_id]'>$value[acc_name]</option>";
}
}
return $op;
}
public function allEmployeeCheckbox($id, $chk = 0)
{
$id=intval($id);
$sql = "SELECT * FROM `accounts_user` WHERE acc_type = '1' AND ( `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under') OR acc_id = '$id' ) AND acc_type='1'";

$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
if ($value['acc_id'] == $chk) {


$op .= '<input type="checkbox" id="select' . $value['acc_id'] . '" name="duser[]" value="' . $value['acc_id'] . '"><label for="select' . $value['acc_id'] . '">' . $value['acc_name'] . '</label>';
} else {
$op .= '<input type="checkbox" id="select' . $value['acc_id'] . '" name="duser[]" value="' . $value['acc_id'] . '"><label for="select' . $value['acc_id'] . '">' . $value['acc_name'] . '</label>';
}
}
return $op;
}

public function allEvents()
{
$sql  = "SELECT `id`,`title` FROM `eventmanagement` ORDER BY `title`";
$data = $this->dbF->getRows($sql);
$opt  = '';
foreach ($data as $value) {
$opt .= '<option value="' . $value['id'] . '">' . $value['id'] . '-' . $value['title'] . '</option>';
}
return $opt;
}

public function allsurgeries($id, $chk = 0)
{
    
// $sql =  "SELECT * FROM `practiceprofile` where surgeries !=''";
// $data = $this->dbF->getRows($sql);
// foreach ($data as $key => $value) {
//     $number =0;$valcont = 0;$op ="";
// $number = intval($value['surgeries']);
// $user_id = intval($value['user_id']);
// for ($i = 0; $i < $number; $i++) {
// $valcont++;
// $op = "Surgeries ".$valcont;
// $this->dbF->setRow("INSERT INTO `insertRooms`(`practiceID`,`name`) VALUES('$user_id','$op')");
// }
// }
// return true;

$op = "";
$sql =  "SELECT * FROM `insertRooms`   where  `practiceID` = ?";
$data = $this->dbF->getRows($sql,array($id));
$op = "";

$valcont = 0;
foreach ($data as $key => $value) {
 $name = $value['name'];
 $id = $value['id'];
$color = $value['color'];
$desc = $value['desc'];
$valcont++;

if ($chk == $id) {

$op .= "<option selected value='$id' style='background:$color;'>$name - $desc</option>";
} else {

$op .= "<option value='$id' style='background:$color;'>$name - $desc</option>";
}
}

return $op;
}

public function allDentist($id, $chk = 0)
{
$var = "";
$d =  $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name= ? ",array($id,'role'));
if ($d[0] == 'Dentist' || $d[0] == 'Dental Hygienist and Dental Therapist') {
$var = "OR `acc_id`='$id'";
}
$sql = "SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ? AND `setting_name`='account_under' AND `id_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val` IN ('Dentist','Dental Hygienist and Dental Therapist'))) $var AND acc_type='1'";
$data = $this->dbF->getRows($sql, array($id));
$op = "";
foreach ($data as $key => $value) {
$name = $this->UserName($value['acc_id']);
if ($value['acc_id'] == $chk) {
$op .= "<option selected value='$value[acc_id]'>$name</option>";
} else {
$op .= "<option value='$value[acc_id]'>$name</option>";
}
}
return $op;
}

public function groupName($id)
{
$sql = "SELECT `group_name` FROM `insertGroup` WHERE `group_id`= ? ";
$data = $this->dbF->getRow($sql,array($id));
return $data[0];
}

public function UserName($id)
{
$sql = "SELECT `acc_name` FROM `accounts_user` WHERE `acc_id`= ? ";
$data = $this->dbF->getRow($sql,array($id));
return @$data[0];
}

public function UserType($id)
{
$sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`= ? AND `id_user`= ? ";
$data = $this->dbF->getRow($sql,array('account_type',$id));
return @$data[0];
}

public function UserImage($id)
{
$sql = "SELECT `acc_image` FROM `accounts_user` WHERE `acc_id`= ? ";
$data = $this->dbF->getRow($sql,array($id));
return $data[0];
}

public function PracticeName($id)
{
$sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`= ?  AND `id_user`= ? ";
$data = $this->dbF->getRow($sql,array('practice name',$id));
return @$data[0];
}


public function receiverDroupdownOptions()
{
$userCurrentId = $_SESSION['webUser']['id'];
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('superuser',$userCurrentId));
// if($data[0] == 'on'){echo $data[0];}
// else{echo 'off';}

$chk = $_SESSION['webUser']['account_type'];
$SuperUserAccess = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($userCurrentId,'superuser_access'));
if ($chk == 'Master') {
// echo '<select name="receipt_receiver" class="cs">
//     <option disabled>Select Practice</option>
//     <option selected value="' . $_SESSION['webUser']['id'] . '">
//         ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
//     </option>
//      ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '
// </select>';
echo '<select name="receipt_receiver" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployeesNamesOption($_SESSION['allUsers'], $_SESSION['currentUser']) . '
</select>';

} else if ($chk == 'Practice') {
echo '<select name="receipt_receiver" class="cs">
        <option disabled>Select Employee</option>
        <option selected value="' . $this->PracticeName($_SESSION['webUser']['name']) . '">
            ' . $this->PracticeName($_SESSION['webUser']['name']) . ' -- Practice
        </option>
         ' . $this->allEmployeesNamesOption($_SESSION['webUser']['id'], $_SESSION['currentUser']) . '
    </select>';
} else if ($chk == 'Employee' && $data[0] == 'on' &&  $SuperUserAccess[0] == 'full') {



//echo $data[0];
$prcId =   $this->PracticeId($_SESSION['webUser']['id']);
$_SESSION['currentUserType'];
$_SESSION['webUser']['account_type'];

echo '<select name="receipt_receiver" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees_view_names_option($prcId, $_SESSION['webUser']['id']) . '
</select>';}else{

$acN = $this->UserName($_SESSION['webUser']['id']);
echo '<select name="receipt_receiver" class="cs">
    <option value="'.$acN.'">'.$acN.'</option>
</select>';


}
}


public function receiverDroupdownOptionsID()
{
$userCurrentId = intval($_SESSION['webUser']['id']);
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('superuser',$userCurrentId));
// if($data[0] == 'on'){echo $data[0];}
// else{echo 'off';}

$chk = intval($_SESSION['webUser']['account_type']);
$SuperUserAccess = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($userCurrentId,'superuser_access'));
if ($chk == 'Master') {
// echo '<select name="receipt_receiver" class="cs">
//     <option disabled>Select Practice</option>
//     <option selected value="' . $_SESSION['webUser']['id'] . '">
//         ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
//     </option>
//      ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '
// </select>';
echo '<select name="receipt_receiver" id="company" class="form-control">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployeesNamesOptionID($_SESSION['allUsers'], $_SESSION['currentUser']) . '
</select>';

} else if ($chk == 'Practice') {
echo '<select name="receipt_receiver" id="company" class="form-control">
        <option disabled>Select Employee</option>
        <option selected value="' . $this->PracticeName($_SESSION['webUser']['name']) . '">
            ' . $this->PracticeName($_SESSION['webUser']['name']) . ' -- Practice
        </option>
         ' . $this->allEmployeesNamesOptionID($_SESSION['webUser']['id'], $_SESSION['currentUser']) . '
    </select>';
} else if ($chk == 'Employee' && $data[0] == 'on' &&  $SuperUserAccess[0] == 'full') {



//echo $data[0];
$prcId =   $this->PracticeId($_SESSION['webUser']['id']);
$_SESSION['currentUserType'];
$_SESSION['webUser']['account_type'];

echo '<select name="receipt_receiver" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees_view_names_optionID($prcId, $_SESSION['webUser']['id']) . '
</select>';}else{

$acN = $this->UserName($_SESSION['webUser']['id']);
echo '<select name="receipt_receiver" class="cs">
    <option value="'.$acN.'">'.$acN.'</option>
</select>';


}
}

public function changeSession1()
{
$userCurrentId = intval($_SESSION['webUser']['id']);
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('superuser',$userCurrentId));
// if($data[0] == 'on'){echo $data[0];}
// else{echo 'off';}

$chk = intval($_SESSION['webUser']['account_type']);
$SuperUserAccess = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($userCurrentId,'superuser_access'));
// var_dump($_SESSION['webUser']['account_type'],$_SESSION['webUser']['id']);
if($_SESSION['webUser']['account_type']=='CEO'){
   echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
   <form method="post">
<select name="change-session" class="cs">
    <option disabled>Select Master</option>
    <option selected value="' . $_SESSION['webUser']['id'] . '">
        ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
    </option>
    ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '

</select>
</form>';
echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
<form method="post">
<select name="change-session" class="cs">
    <option disabled>Select Practice</option>
    <option selected value="' . $_SESSION['currentUser']. '">
        ' . $this->PracticeName($_SESSION['currentUser']) . ' -- Master
    </option>
     ' . $this->allPractice($_SESSION['currentUser'], $_SESSION['allUsers']) . '
</select>
</form>';

}
elseif ($_SESSION['webUser']['account_type'] == 'Master') {
 if($_SESSION['webUser']['account_type']!='CEO'){
  
echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
<form method="post">
<select name="change-session" class="cs">
    <option disabled>Select Practice</option>
    <option selected value="' . $_SESSION['webUser']['id'] . '">
        ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
    </option>
     ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '
</select>
</form>';}
echo '<form method="post">
<select name="change-session" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees($_SESSION['allUsers'], $_SESSION['currentUser']) . '
</select>
</form>';
echo '
<span>';

if(isset($_POST['change-session']) ){
echo 'Using As &nbsp';
}

echo '<i class="fas fa-user"></i>
' . $this->UserName($_SESSION['currentUser']) . '
</span>';
}
elseif ($_SESSION['webUser']['account_type'] == 'Practice') {
echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
<form method="post">
    <select name="change-session" class="cs">
        <option disabled>Select Employee</option>
        <option selected value="' . $_SESSION['webUser']['id'] . '">
            ' . $this->PracticeName($_SESSION['webUser']['name']) . ' -- Practice
        </option>
         ' . $this->allEmployees($_SESSION['webUser']['id'], $_SESSION['currentUser']) . '
    </select>
</form>
<span>';
if(isset($_POST['change-session']) ){
echo 'Using As &nbsp';
}
echo '<i class="fas fa-user"></i>
' . $this->UserName($_SESSION['currentUser']) . '
</span>';
}
elseif ($_SESSION['webUser']['account_type'] == 'Employee' && $data[0] == 'on' &&  $SuperUserAccess[0] == 'full') {

//echo $data[0];
$prcId =   $this->PracticeId($_SESSION['webUser']['id']);
$_SESSION['currentUserType'];
$_SESSION['webUser']['account_type'];


echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
';
echo '<form method="post">
<select name="change-session" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees_view($prcId, $_SESSION['webUser']['id']) . '
</select>
</form>';
echo '
<span>';

if(isset($_POST['change-session']) ){
echo 'Using As &nbsp';
}

echo '<i class="fas fa-user"></i>
' . $this->UserName($_SESSION['superid']) . '
</span>';
}
}

public function changeSession()
{
$userCurrentId = intval($_SESSION['webUser']['id']);
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('superuser',$userCurrentId));
// if($data[0] == 'on'){echo $data[0];}
// else{echo 'off';}

$chk = intval($_SESSION['webUser']['account_type']);
$SuperUserAccess = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($userCurrentId,'superuser_access'));
// var_dump($chk,$_SESSION['webUser']['account_type']);
if($_SESSION['webUser']['account_type']=='CEO'){
//    echo '<form method="post" title="Reset">
// <button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
// </form>
//    <form method="post">
// <select name="change-session" class="cs">
//     <option disabled>Select Master</option>
//     <option selected value="' . $_SESSION['webUser']['id'] . '">
//         ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
//     </option>
//     ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '

// </select>
// </form>';
// echo '
// <form method="post">
// <select name="change-session" class="cs">
//     <option disabled>Select Practice</option>
//     <option selected value="' . $_SESSION['currentUser']. '">
//         ' . $this->PracticeName($_SESSION['currentUser']) . ' -- Master
//     </option>
//      ' . $this->allPractice($_SESSION['currentUser'], $_SESSION['allUsers']) . '
// </select>
// </form>';

}
elseif ($_SESSION['webUser']['account_type'] == 'Master') {
 if($_SESSION['webUser']['account_type']!='CEO'){
echo '
<span style="font-size: 20px" class="name">';

// if(isset($_POST['change-session']) ){
$user = 'Logged in as: '.$this->UserName($_SESSION['currentUser']);
// }else{

// }

echo '<i class="bx bxs-user"></i>'.@$user.' 
</span>';
echo '
<form class="col5_reset" method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
<form method="post">
<select name="change-session" class="cs">
    <option disabled>Select Practice</option>
    <option selected value="' . $_SESSION['webUser']['id'] . '">
        ' . $this->PracticeName($_SESSION['webUser']['id']) . ' -- Master
    </option>
     ' . $this->allPractice($_SESSION['webUser']['id'], $_SESSION['allUsers']) . '
</select>
</form>';}
echo '<form method="post">
<select name="change-session" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees($_SESSION['allUsers'], $_SESSION['currentUser']) . '
</select>
</form>
';

}
elseif ($_SESSION['webUser']['account_type'] == 'Practice') {

echo '
<span style="font-size: 20px" class="name">';
// if(isset($_POST['change-session']) ){
$user = 'Logged in as: '.$this->UserName($_SESSION['currentUser']);
// }
echo '<i class="bx bxs-user"></i>'.@$user.'
</span>';

echo '<form class="col5_reset" method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
<form method="post">
    <select name="change-session" class="cs">
        <option disabled>Select Employee</option>
        <option selected value="' . $_SESSION['webUser']['id'] . '">
            ' . $this->PracticeName($_SESSION['webUser']['name']) . ' -- Practice
        </option>
         ' . $this->allEmployees($_SESSION['webUser']['id'], $_SESSION['currentUser']) . '
    </select>
</form>
<span>';
if(isset($_POST['change-session']) ){
echo 'Using As &nbsp';
}
// echo '<i class="fas fa-user"></i>
// ' . $this->UserName($_SESSION['currentUser']) . '
// </span>';
echo '<i class="fas fa-user"></i>' 
 .' '.$_SESSION['webUser']['name'].
'</span>';
}
elseif ($_SESSION['webUser']['account_type'] == 'Employee' && @$data[0] == 'on' &&  @$SuperUserAccess[0] == 'full') {

//echo $data[0];
$prcId =   $this->PracticeId($_SESSION['webUser']['id']);
$_SESSION['currentUserType'];
$_SESSION['webUser']['account_type'];


echo '<form method="post" title="Reset">
<button type="submit" name="reset"><i class="fas fa-retweet"></i></button>
</form>
';
echo '<form method="post">
<select name="change-session" class="cs">
    <option selected disabled>Select Employee</option>
     ' . $this->allEmployees_view($prcId, $_SESSION['webUser']['id']) . '
</select>
</form>';
echo '
<span>';

if(isset($_POST['change-session']) ){
echo 'Using As &nbsp';
}

echo '<i class="fas fa-user"></i>
' . $this->UserName($_SESSION['superid']) . '
</span>';
}
}

public function myeventdelete($apiSureId="")
{
$smartQuery = '';
if (!empty($apiSureId)) {
 @$id =  $apiSureId['id'];
}else{
@$idX = base64_decode($_GET['sure']);

$exp = explode("&d=", $idX);
// var_dump($exp);
@$id = $exp[0];
@$idDate = $exp[1];
// return true;
// @$id = $_GET['id'];
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
}
$d = $this->dbF->getRow("SELECT `file`,`title`,`assignto`,`user` FROM `myevents` WHERE `id`= ? ",array($id));
if ($this->dbF->rowCount) {
    $smartQuery .= $this->makeRecoverySQL('myevents','id',$id);
$this->dbF->setRow("DELETE FROM `myevents` WHERE `id`= ? ",array($id));







$this->setlog("My Event Delete", $this->UserName($user) . " : " . $user, $id, $d['title'] . " : " . $id);


$dD = $this->dbF->getRow("SELECT `fetch_id` FROM `myevents` WHERE `fetch_id`= ? ",array($id));
if ($this->dbF->rowCount == 0) {
    $smartQuery .= $this->makeRecoverySQL('myeventform','title_id',$id);
$this->dbF->setRow("DELETE FROM `myeventform` WHERE `title_id`= ? ",array($id));



$this->setlog("My Event Form Delete", $this->UserName($user) . " : " . $user, $id, $d['title'] . " : " . $id);


$smartQuery .= $this->makeRecoverySQL('myeventsFilled','my_e_id',$id,'user',$user);
$this->dbF->setRow("DELETE FROM `myeventsFilled` WHERE `my_e_id`= ? and `user`= ? ",array($id,$user));

$this->setlog("My Event Form filled Delete", $this->UserName($user) . " : " . $user, $id, $d['title'] . " : " . $id);


}else{
// $this->dbF->setRow("DELETE FROM `myeventform` WHERE `title_id`= ? ",array($id));
    $smartQuery .= $this->makeRecoverySQL('myeventsFilled','my_e_id',$id,'user',$user);
$this->dbF->setRow("DELETE FROM `myeventsFilled` WHERE `my_e_id`= ? and `user`= ? ",array($id,$user));


$this->setlog("My Event Form filled Delete", $this->UserName($user) . " : " . $user, $id, $d['title'] . " : " . $id);



}
// ========================TrashData==============================================


// var_dump($smartQuery);
// $smartQuery = base64_encode($smartQuery);

// var_dump($smartQuery);


$ds = "Delete My Event  (Title Name : " . $d['title'] . " ) ";
$this->TrashData('Activity Calendar', $ds, $d['file'], $user, $d['user'], 'myevents', $id, 'MY Event Delete',$smartQuery);
// ========================TrashData==============================================

if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}


return true;
} else {
return false;
}



}

// my events close

public function userCheck($id)
{
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('user_type',$id));
if ($data[0] == 'Premium') {
return true;
} else {
return false;
}
}
public function SuperUserCheck($id)
{
$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE setting_name= ? AND id_user= ? ";
$data = $this->dbF->getRow($sql,array('superuser',$id));
if ($data[0] == 'on') {
echo $data[0];
} else {
echo 'off';
}
}

public function eventTitle($id)
{
$sql = "SELECT title FROM eventmanagement WHERE id= ?";
$data = $this->dbF->getRow($sql,array($id));
return @$data[0];
}

//email
public function dueEvent($user)
{
$sql = "SELECT title FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`='$user') AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`) AND `type` !='updates'";
$sql2 = "SELECT title FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`due_date` BETWEEN DATE_SUB(CURDATE(), INTERVAL -1 DAY) AND DATE_SUB(CURDATE(), INTERVAL -1 MONTH) AND `type` !='updates'";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);
$cate = "<div style='width:95%;margin:auto;'>";
foreach ($mysql as $key => $value) {
$cate .= "<div style='width:20%;margin:10px;padding:5px;text-align:center;background-color:#add8e6;display:inline-block;vertical-align:top;'>" . $value['title'] . "</div>";
}
$cate .= "</div>";
if (empty($mysql)) {
return "<br><br>You Have No Due Events<br><br>";
} else {
return $cate;
}
}
public function overdueEvent($user)
{
$sql = "SELECT title FROM `eventmanagement` WHERE `assignto` IN ('all', ? ) AND `due_date` <= (SELECT CURDATE()) AND `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`= ? ) AND `publish` = '1' AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`) AND `type` !='updates'";
$sql2 = "SELECT title FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`= ?  AND `userevent`.`due_date` <= (SELECT CURDATE()) AND `type` !='updates'";
$data = $this->dbF->getRows($sql,array($user,$user));
$data2 = $this->dbF->getRows($sql2,array($user));
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);
$cate = "<div style='width: 95%;margin: auto;'>";
foreach ($mysql as $key => $value) {
$cate .= "<div style='width:20%;margin:10px;padding:5px;text-align:center;background-color:#ffcccb;display:inline-block;vertical-align:top;'>" . $value['title'] . "</div>";
}
$cate .= "</div>";
if (empty($mysql)) {
return "<br><br>You Have No OverDue Events<br><br>";
} else {
return $cate;
}
}

public function newDocuments()
{
$date = Date('Y-m-d', strtotime('-1 Month'));
$sql  = "SELECT * FROM filesmanager WHERE publish='1' AND `dateTime`> ?  ORDER BY ID DESC";
$data =  $this->dbF->getRows($sql, array($date));
$cate = "<div style='width:95%;margin:auto;'>";
foreach ($data as $key => $value) {
$cate .= "<div style='width:20%;margin:10px;padding:5px;text-align:center;background-color:#b19cd9;display:inline-block;vertical-align:top;'>" . $value['title'] . "</div>";
}
$cate .= "</div>";
if (empty($mysql)) {
return "<br><br>No New Documents<br><br>";
} else {
return $cate;
}
}

public function getDate($id)
{
$sql = "SELECT `recurring_duration` FROM `eventmanagement` WHERE `id`= ? ";
$data = $this->dbF->getRow($sql,array($id));
$recurring_duration = isset($data['recurring_duration']) ? $data['recurring_duration'] : "";
return $recurring_duration;
}

public function nextDueDate($duration, $date = '')
{
if (!empty($duration)) {
if ($duration == "Once" || $duration == 'Once Check' || $duration == 'No Recurrence') {
return $duration;
} else {
return $duration = Date('Y-m-d', strtotime($date . '+' . $duration));
}
} else {
return $duration = Date('Y-m-d', strtotime('+ 12 months'));
}
}


	public function isholidayShow($user,$isApi = false)
{
if (!$isApi) {
    
echo ' <div class="table_overflow">  <table class="table table-hover dTable tableIBMS dataTable">
<thead>
<tr>
<th>sno</th>
<th>Practice Name</th>
<th>Date</th>
<th>Reason</th>
<th>Comment</th>
<th>Action</th>
   
</tr>    
</thead>
<tbody class="table_data">';
}
$user =  intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `isholiday` WHERE `user` = '$user'";
$data = $this->dbF->getRows($sql);
$cnt  = 0;
if ($isApi) {
    foreach ($data as $key => $val) {
        $id = $val['id'];
        $PracticeName = $this->UserName($val['user']);
        $date = $val['date'];
        $reason = $val['reason'];
        $comment = $val['comment'];
        
        $array[]   = array('id'=>$id,'user'=>$PracticeName,'date'=>$date,'reason'=>$reason,'comment'=>$comment);

    }
    return $array;
}else{
foreach ($data as $key => $val) {
$cnt++;
$PracticeName = $this->UserName($val['user']);
$id = $val['id'];
echo "<tr>
   <td>" . $cnt . "</td>
   <td>" . $PracticeName . "</td>
   <td>" . $val['date'] . "</td>
   <td>" . $val['reason'] . "</td>   
   <td>" . $val['comment'] . "</td>
<td><a data-id='$id' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>
                <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
            </a></td>";


echo "</tr>";
}
echo "</tbody></table></div>";
}
}


public function nextworkingday($date)
{



$user = intval($_SESSION['currentUser']);
$sql1 = "SELECT * FROM `isholiday` WHERE `user` = '$user'";
$data1 = $this->dbF->getRows($sql1);
// print_r($data1);

//echo $count = count($data1);
// $isholidayDate =date('Y-m-d',strtotime($data1['date']));

$sql2 = "SELECT * FROM `practiceprofile` WHERE `user_id` = ? ";
$data2 = $this->dbF->getRow($sql2,array($user));
@$days = $data2['dayoff'];
if($days == "1,2,3,4,5,6,7"){
    return "all off";
}
$isweekendDays = explode(",", $days);
//  echo   date('Y-m-d',strtotime($date));
// echo    date('Y-m-d',strtotime($data1['date']));

foreach ($data1 as $key => $value) {

if ($date == $value['date']) {
$date  = date('Y-m-d', strtotime($date . '+ 1 day'));
$date =  $this->nextworkingday($date);
}
}


if (in_array(date('N', strtotime($date)), $isweekendDays)) {
// ;print_r($isweekendDays);
// echo  date('N', strtotime($date)); 
// echo  "<br>"
$date  = date('Y-m-d', strtotime($date . '+ 1 day'));
$date =  $this->nextworkingday($date);
return  $date;
// return  date('Y-m-d',strtotime($date));
}
return  $date;
}

public function isWeekend($date)
{
return (date('N', strtotime($date)) == 7);
}

public function eventsubmit($apiPostData="")
{
if (!empty($apiPostData)){
    $_POST = $apiPostData;
}

if (isset($_POST['submit'])) {
if (!$this->getFormToken('newEvent') && $apiPostData == "") {
return false;
}
// exit();
// $this->dbF->prnt($_POST);
$title_id  = empty($_POST['title_id']) ? ""    : $_POST['title_id'];
$desc1     = empty($_POST['desc'])     ? ""    : $_POST['desc'];
$comment     = empty($_POST['comment'])     ? ""    : $_POST['comment'];
$desc2     = empty($_POST['desc2'])    ? "No"    : $_POST['desc2'];
$confirm   = empty($_POST['confirm'])  ? "-1"  : $_POST['confirm'];
$assignto = empty($_POST['assignto'])  ? "0"  : $_POST['assignto'];
$date     = empty($_POST['date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['date']));
$recurring    = empty($_POST['recurring_duration'])   ? ""  : $_POST['recurring_duration'];
$title_id=intval($title_id);
htmlspecialchars($desc1);
htmlspecialchars($comment);
htmlspecialchars($desc2);
htmlspecialchars($confirm);
htmlspecialchars($assignto);
htmlspecialchars($date);
htmlspecialchars($recurring);
if ($_POST['recurring_duration'] == '') {
$_POST['recurring_duration'] = $_POST['recurring_duration_Hidden'];
//$recurring = '';
}

if (isset($_POST['change-session'])) {
$user =    intval($_POST['practiceUser']);
} else {

$user = intval($_SESSION['currentUser']);
}
$title    = $this->eventTitle($title_id);
$email    = $this->ibms_setting('Email');
if ($_POST['recurring_duration'] == 'No Recurrence' || $_POST['recurring_duration'] == 'Once' || $_POST['recurring_duration'] == 'Once Check') {
$recurring_duration = $this->nextDueDate($_POST['recurring_duration']);
} else {
$recurring_duration = $this->nextDueDate($_POST['recurring_duration'], $date);
}
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = '';


if ($confirm == '1') {

if ($this->userCheck($user)) {
$approved = 0;
} else {

$approved = 1;
}
} else {
$approved = $confirm;
}

if (empty($_FILES['0']['tmp_name'])) {
$docname = '#';
} else {
foreach ($_FILES as $key => $tmpName) {
$filename = $this->uploadSingleFile($tmpName, 'files', '');



// $docname .= WEB_URL . "/images/$filename,";



if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}






}
$docname = trim($docname, ",");
}
try {
$this->db->beginTransaction();
$date;
$sql      =   "INSERT INTO `userevent`(`user`,`assignto`,`title_id`,`file`,`approved`,`desc`,`comment`,`due_date`,`recurring`,`dateTime`) VALUES (?,?,?,?,?,?,?,?,?,?)";
$array   = array($user, $assignto, $title_id, $docname, $approved, nl2br($desc), $comment, $date, $recurring, $date);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
if ($approved == 1) {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid = $_SESSION['webUser']['id'];
} else {
    $uid = $_SESSION['currentUser'];
}
$this->setlog("Event Approved", $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
} else {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid = $_SESSION['webUser']['id'];
} else {
    $uid = $_SESSION['currentUser'];
}
// $this->setlog("Event Update", $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
}

if (!empty($apiPostData)) {
    $form   = empty($_POST['eform2'])  ? array() : json_decode($_POST['eform2'],true);
    // var_dump($form[0]);
}else{
    $form   = empty($_POST['form'])  ? array() : $_POST['form'];
}

foreach ($form as $key => $value) {
$sql2 = "INSERT INTO `usereventForms`(`ue_id`,`title_id`,`q_id`,`user`,`radio`,`date`,`time`,`field1`,`field2`) VALUES (?,?,?,?,?,?,?,?,?)";
$array2   = array($lastId, $title_id, $value['question'], $user, @$value['radio'], @$value['date'], @$value['time'], @$value['field1'], @$value['field2']);
$this->dbF->setRow($sql2, $array2, false);
}

if ($recurring_duration == 'Once' || $recurring_duration == 'Once Check') {
$sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`= ? )";
$data = $this->dbF->getRow($sql, array($title_id));
$title_id = $data['id'];
$recurring_duration = Date('Y-m-d', strtotime($date . '+' . $data['recurring_duration']));
}

if ($recurring_duration != 'No Recurrence') {
if ($approved == 1) {
    if ($desc2 == "Yes") {
        $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`assignto`,`due_date`,`recurring`) VALUES (?,?,?,?,?)";
        if ($_POST['recurring_duration'] == '1 day') {

            $recurring_duration = $this->nextworkingday($recurring_duration);
            //  if($this->isWeekend($recurring_duration)){
            //     $recurring_duration = Date('Y-m-d',strtotime($recurring_duration.'+ 1 day'));
            // }
        }
        $array   = array($user, $title_id, $assignto, $recurring_duration, $recurring);
        $this->dbF->setRow($sql, $array, false);
        $lastId = $this->dbF->rowLastId;
        if ($_SESSION['currentUserType'] == 'Employee') {
            $uid = intval($_SESSION['webUser']['id']);
        } else {
            $uid = intval($_SESSION['currentUser']);
        }
        $this->setlog("New Event Create", $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
    }
}
}

$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
if ($approved == 0) {
    //   $this->send_mail($email,$title,'','eventsubmit');
}
if (strpos($assignto, '-1') !== false) {
    // $this->dbF->prnt[$_POST];

    $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val= ? ";
    $d = $this->dbF->getRows($q, array($user));
    foreach ($d as $key => $value) {
        $this->notifications('uevent', $value['id_user'], $title);
        $this->setlog("Event has been assigned to ".$this->UserName($value['id_user']).":".$value['id_user'], $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
    }
} else {
    if($assignto > 0 && !empty($title_id)){
        $hasreminder = date('Y-m-d');
        $allus = $_POST['assignto'];
        $typeName = "eventhasreminder";
        $start_date = date('Y-m-d', strtotime($hasreminder));
        $date = strtotime($start_date);
        $date = strtotime("+7 day", $date);
        $Event_one_week_date = date('Y-m-d', $date);
        $sql = "INSERT INTO `cronData`(`user`,`type`,`event_Id`,`event_Date`)VALUES(?,?,?,?)";
        $arr = array($allus,$typeName,$title_id,$Event_one_week_date);
        $this->dbF->setRow($sql,$arr);
    }

    // $this->notifications('uevent', $user, $title);
    $this->setlog("Event has been assigned to ".$this->UserName($assignto).":".$assignto, $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
     $this->notifications('uevent', $assignto, $title);
}
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}



public function redoEvent($apiPostData="")
{

if (!empty($apiPostData)) {
    $_POST = $apiPostData;
}

if (isset($_POST['edit'])) {
if (!$this->getFormToken('redoEvent') && $apiPostData == "") {
return false;
}

 $smartQuery = '';


// $this->dbF->prnt($_POST);
$edit_id    = empty($_POST['edit_id'])   ? ""    : $_POST['edit_id'];
$title_id   = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
$due_date   = empty($_POST['due_date'])  ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['due_date']));
$desc1      = empty($_POST['desc'])      ? ""    : $_POST['desc'];
$comment    = empty($_POST['comment'])      ? ""    : $_POST['comment'];
$desc2      = empty($_POST['desc2'])     ? "No"  : $_POST['desc2'];
$date       = empty($_POST['date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['date']));
$confirm    = empty($_POST['confirm'])   ? "-1"  : $_POST['confirm'];
$assignto   = empty($_POST['assignto'])  ? "0"   : $_POST['assignto'];
$recurring    = empty($_POST['recurring_duration'])   ? ""  : $_POST['recurring_duration'];
if ($_POST['recurring_duration'] == '') {
$_POST['recurring_duration'] = $_POST['recurring_duration_Hidden'];
$recurring = '';
}

if (empty($_FILES['0']['tmp_name'])) {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'];
} else {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'] . ",";
}


$user = intval($_POST['cur_user']);

$title      = $this->eventTitle($title_id);
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
//$user =  $_SESSION['webUser']['id'];
$color_publish = '1';
} else {
// $user = $_SESSION['currentUser'];
$color_publish = '0';
}
// if ($_POST['recurring_duration'] == 'No Recurrence' || $_POST['recurring_duration'] == 'Once' || $_POST['recurring_duration'] == 'Once Check') {
// $recurring_duration = $this->nextDueDate($_POST['recurring_duration']);
// } else {
// $recurring_duration = $this->nextDueDate($_POST['recurring_duration'], $due_date);
// }
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = $old_file;

if ($confirm == '1') {
$date = $date;

if ($this->userCheck($user)) {
$approved = 0;
} else {

$approved = 1;
}
} else {
$date = '';
$approved = $confirm;
}
//print_r($_FILES)
if (empty($_FILES['0']['tmp_name'])) {
$docname = $old_file;
} else {

foreach ($_FILES as $key => $tmpName) {
$filename = $this->uploadSingleFile($tmpName, 'files', '');
// $docname .= WEB_URL . "/images/$filename,";


if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}





}


$docname = trim($docname, ",");
$docname = trim($docname, "#");
}
///file is save to trashdata  if Single file is delete  (product_ajax_function)/////


try {
$this->db->beginTransaction(); 
$sql      =   "UPDATE `userevent` SET `file` = ? ,`assignto` = ? ,`desc` = ? ,`comment` = ? , `color_publish` = ? ,`dateTime` = ?, `due_date` = ? WHERE `id` = ?";
$array   = array($docname, $assignto,  nl2br($desc), $comment, $color_publish, $date, $due_date, $edit_id);
$this->setlog("Event '$title' has been redo", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
$this->dbF->setRow($sql, $array, false);
if ($approved == 1) {
// $this->setlog("Event Approved", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
} else {
// $this->setlog("Event Update", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
}


 $smartQuery .= $this->makeRecoverySQL('usereventForms','ue_id',$edit_id);

// ========================TrashData==============================================
$ds = "Delete usereventForms table data";
$this->TrashData('redoEvent function is call', $ds,"", $user, "", 'usereventForms', $edit_id, 'delete query perform',$smartQuery);
// ========================TrashData==============================================

$mysql = "DELETE FROM `usereventForms` WHERE `ue_id`= ? ";
$this->dbF->setRow($mysql, array($edit_id));

if (!empty($apiPostData)) {
    $form   = empty($_POST['eform2'])  ? array() : json_decode($_POST['eform2'],true);
    // var_dump($form[0]);
}else{
    $form   = empty($_POST['form'])  ? array() : $_POST['form'];
}

foreach ($form as $key => $value) {
$sql2 = "INSERT INTO `usereventForms`(`ue_id`,`title_id`,`q_id`,`user`,`radio`,`date`,`time`,`field1`,`field2`) VALUES (?,?,?,?,?,?,?,?,?)";
$array2   = array($edit_id, $title_id, $value['question'], $user, @$value['radio'], @$value['date'], @$value['time'], @$value['field1'], @$value['field2']);
$this->dbF->setRow($sql2, $array2, false);
}

// if ($recurring_duration == 'Once' || $recurring_duration == 'Once Check') {
// $sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`='$title_id')";
// $data = $this->dbF->getRow($sql);
// $title_id = $data['id'];
// $recurring_duration = Date('Y-m-d', strtotime($due_date . '+' . $data['recurring_duration']));
// }

// if ($recurring_duration != 'No Recurrence') {
// if ($approved == 1) {
//     if ($desc2 == "Yes") {
//         $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`assignto`,`due_date`,`color_publish`,`recurring`) VALUES (?,?,?,?,?,?)";
//         if ($_POST['recurring_duration'] == '1 day') {

//             $recurring_duration = $this->nextworkingday($recurring_duration);
//             //  if($this->isWeekend($recurring_duration)){
//             //     $recurring_duration = Date('Y-m-d',strtotime($recurring_duration.'+ 1 day'));
//             // }
//         }
//         $array   = array($user, $title_id, $assignto, $recurring_duration, '0', $recurring);
//         $this->dbF->setRow($sql, $array, false);
//         $this->setlog("New Event Create", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);


//         ////////////////////////---------------------CronData-------------------------------------//     



//         ////////////////////////---------------------CronData-------------------------------------//  

//     }
// }
// }
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($approved == 0) {
//    $this->send_mail($email,$title,'','eventsubmit');
}
if ($_SESSION['currentUserType'] == 'Employee') {


// $this->notifications('event', $user, $title);
} else {


if (strpos($assignto, '-1') !== false) {



    // $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val='$user'";
    // $d = $this->dbF->getRows($q);

    // foreach ($d as $key => $value) {
    //     $this->notifications('uevent',$value['id_user'],$title);
    // }
} else {


    //  $this->notifications('uevent',$assignto,$title);
}





////////////////////////---------------------CronData-------------------------------------//     










////////////////////////---------------------CronData-------------------------------------//   




}
return true;
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}


public function redoMyEvent($data){
        
        if (!$data['edit']) {
            return false;
        }
        // var_dump($data);
        // exit;
        $edit_id    = empty($data['edit_id'])   ? ""    : $data['edit_id'];
        $title_id  = empty($data['title_id']) ? ""    : $data['title_id'];
        $desc1     = empty($data['desc'])     ? ""    : $data['desc'];
        $actionplan     = empty($data['actionplan'])     ? ""    : $data['actionplan'];
        $comment     = empty($data['comment'])     ? ""    : $data['comment'];
        $desc2     = empty($data['desc2'])    ? "No"    : $data['desc2'];
        $confirm   = empty($data['confirm'])  ? "-1"  : $data['confirm'];
        $assignto = empty($data['assignto'])  ? "0"  : $data['assignto'];
        $date     = empty($data['due_date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($data['due_date']));
        $completion_date       =  date('Y-m-d');
        if ($data['recurring_duration'] == '') {
        $data['recurring_duration'] = $data['recurring_duration_Hidden'];
        //$recurring = '';
        }

        if (empty($_FILES['0']['tmp_name'])) {
         $old_file   = empty($data['old_file'])  ? "#"   : $data['old_file'];
        } else {
         $old_file   = empty($data['old_file'])  ? "#"   : $data['old_file'] . ",";
        }

        $recurring    = empty($data['recurring_duration'])   ? ""  : $data['recurring_duration'];


//         if (isset($_POST['change-session'])) {
// $user =    intval($_POST['practiceUser']);
// } else {

$user = intval($_SESSION['currentUser']);
// }

$title    = $this->myeventsTableTitle($title_id);
$email    = $this->ibms_setting('Email');
// if ($recurring == 'No Recurrence' || $recurring == 'Once' || $recurring == 'Once Check') {
// $recurring_duration = $this->functions->nextDueDate($recurring);
// } else {
// $recurring_duration = $this->functions->nextDueDate($recurring, $date);
// }
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = '';


if ($confirm == '1') {
$completionDate = $completion_date;

if ($this->userCheck($user)) {
$approved = 0;
} else {
$approved = 1;
}
} else {
$completionDate = "";    
$approved = $confirm;
}

if($old_file == WEB_URL."/images/"){
  $old_file ="";  
}

$docname = $old_file;
if (empty($_FILES['0']['tmp_name'])) {
$docname = $old_file;
} else {

foreach ($_FILES as $key => $tmpName) {
$filename = $this->uploadSingleFile($tmpName, 'files', '');


if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}

}


$docname = trim($docname, ",");
$docname = trim($docname, "#");

}
try {
$this->db->beginTransaction();


if ($approved == 1) {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid = $_SESSION['webUser']['id'];
} else {
    $uid = $_SESSION['currentUser'];
}


$sql      =   "UPDATE `myevents` SET `approved` = ? ,`status` = ? WHERE `id` = ?";
$array   = array(1,"complete",$edit_id);
$this->dbF->setRow($sql, $array, false);

} else {
if ($_SESSION['currentUserType'] == 'Employee') {
    $uid = $_SESSION['webUser']['id'];
} else {
    $uid = $_SESSION['currentUser'];
}

}
$mysql = "DELETE FROM `myeventsFilled` WHERE `my_e_id`= ? ";
$this->dbF->setRow($mysql, array($edit_id));

$form   = empty($_POST['eform2'])  ? array() : json_decode($_POST['eform2'],true);

foreach ($form as $key => $value) {
$sql2 = "INSERT INTO `myeventsFilled`(`my_e_id`,`title_id`,`q_id`,`user`,`radio`,`date`,`time`,`field1`,`field2`) VALUES (?,?,?,?,?,?,?,?,?)";

$sqlfetch_id = "SELECT fetch_id FROM `myevents` WHERE `id`= ? ";
$datafetch_id = $this->dbF->getRow($sqlfetch_id, array($title_id));
$fetch_id = $datafetch_id['fetch_id'];
if(empty($fetch_id)){
    $fetch_id = $title_id;
}

$array2   = array($title_id, $fetch_id, $value['question'], $user, @$value['radio'], @$value['date'], @$value['time'], @$value['field1'], @$value['field2']);
$this->dbF->setRow($sql2, $array2, false);
$lastId = $this->dbF->rowLastId;


}

// if ($recurring == 'Once' || $recurring == 'Once Check') {
// $sql = "SELECT * FROM `myevents` WHERE `id`=$title_id";
// $data = $this->dbF->getRow($sql);
// $title_id = $data['id'];
// $recurring_duration = Date('Y-m-d', strtotime($date . '+' . $data['recurring_duration']));
// }

//         if ($recurring != 'No Recurrence') {
//         if ($approved == 1) {
//         if ($desc2 == "Yes") {

//         $sql = "SELECT `category`,`desc` FROM `myevents` WHERE `id`=$title_id";
//         $dataX = $this->dbF->getRow($sql);



//         $sql      =   "INSERT INTO `myevents`(`user`,`title`,`assignto`,`due_date`,`fetch_id`,`category`,`desc`,`status`,`file`,`recurring_duration`,`comment`,`actionplan`,`dateTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
//         if ($data['recurring_duration'] == '1 day') {


//             $recurring_duration = $this->functions->nextworkingday($recurring_duration);

//         }
//         $array   = array($user, $title, $assignto, $recurring_duration,$fetch_id, $dataX['category'], $dataX['desc'], "pending", "#", $recurring, $comment, $actionplan,$completionDate);
//         $this->dbF->setRow($sql, $array, false);
//         if ($_SESSION['currentUserType'] == 'Employee') {
//             $uid = $_SESSION['webUser']['id'];
//         } else {
//             $uid = $_SESSION['currentUser'];
//         }

//     }
//     }
//     }

    $lastId = $this->dbF->rowLastId;
    $sql      =   "UPDATE `myevents` SET `desc` = ?,`actionplan` = ? ,`comment` = ? ,`file` = ?,`due_date` = ?,`recurring_duration` = ?,`assignto` = ? , `dateTime`=? WHERE `id` = ?";
    $array   = array($desc,$actionplan, $comment, $docname,$date,$recurring,$assignto,$completionDate,$edit_id);
    $this->dbF->setRow($sql, $array, false);
    if ($this->dbF->rowCount > 0) {







    if ($approved == 0) {
        //   $this->send_mail($email,$title,'','eventsubmit');
    }
    // if (strpos($assignto, '-1') !== false) {
        // $this->dbF->prnt[$data];

        // $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val='$user'";
        // $d = $this->dbF->getRows($q);
        // foreach ($d as $key => $value) {
        //     $this->functions->notifications('uevent', $value['id_user']);
        // }
    // } else {

        // $hasreminder = date('Y-m-d');
        // $allus = @$data['assignto'];
        // $typeName = "eventhasreminder";
        // $start_date = date('d-M-Y', strtotime($hasreminder));
        // $date = strtotime($start_date);
        // $date = strtotime("+7 day", $date);
        // $Event_one_week_date = date('d-M-Y', $date);
        // $sql = "INSERT INTO `cronData`(`user`,`type`,`event_Id`,`event_Date`)VALUES('$assignto','$typeName','$edit_id','$Event_one_week_date')";
        // $this->dbF->setRow($sql);


        // $this->functions->notifications('uevent', $user, $title);

        // $this->functions->notifications('uevent', $assignto, $title);
    // }
    $this->db->commit();
    return true;
    } else {
    return false;
    }
    } catch (Exception $e) {
    $this->db->rollBack();
    $this->dbF->error_submit($e);
    return false;
    }

        }




public function eventedit($apiPostData="")
{
if (!empty($apiPostData)){
    $_POST = $apiPostData;
}
if (isset($_POST['edit'])) {
if (!$this->getFormToken('newEvent') && $apiPostData == "") {
return false;
}

 $smartQuery ='';

// $this->dbF->prnt($_POST);
$edit_id    = empty($_POST['edit_id'])   ? ""    : $_POST['edit_id'];
$title_id   = empty($_POST['title_id'])  ? ""    : $_POST['title_id'];
$due_date   = empty($_POST['due_date'])  ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['due_date']));
$desc1      = empty($_POST['desc'])      ? ""    : $_POST['desc'];
$comment    = empty($_POST['comment'])      ? ""    : $_POST['comment'];
$desc2      = empty($_POST['desc2'])     ? "No"  : $_POST['desc2'];
$date       = empty($_POST['date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['date']));
$confirm    = empty($_POST['confirm'])   ? "-1"  : $_POST['confirm'];
$assignto   = empty($_POST['assignto'])  ? "0"   : $_POST['assignto'];
$recurring  = empty($_POST['recurring_duration'])   ? ""  : $_POST['recurring_duration'];
if ($_POST['recurring_duration'] == '') {
$_POST['recurring_duration'] = $_POST['recurring_duration_Hidden'];
$recurring = '';
}

if (empty($_FILES['0']['tmp_name'])) {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'];
} else {
$old_file   = empty($_POST['old_file'])  ? "#"   : $_POST['old_file'] . ",";
}

$user = intval($_POST['cur_user']);

$title      = $this->eventTitle($title_id);
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
// $user = $_SESSION['superid'];
//$user =  $_SESSION['webUser']['id'];
$color_publish = '1';
} else {
// $user = $_SESSION['currentUser'];
$color_publish = '0';
}
if ($_POST['recurring_duration'] == 'No Recurrence' || $_POST['recurring_duration'] == 'Once' || $_POST['recurring_duration'] == 'Once Check') {
$recurring_duration = $this->nextDueDate($_POST['recurring_duration']);
} else {
$recurring_duration = $this->nextDueDate($_POST['recurring_duration'], $due_date);
}
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = $old_file;

if ($confirm == '1') {
$date = $date;

if ($this->userCheck($user)) {
$approved = 0;
} else {

$approved = 1;
}
} else {
$date = '';
$approved = $confirm;
}
// echo "<br>";
// var_dump($_FILES);





if (empty($_FILES['0']['tmp_name'])) {
$docname = $old_file;
} else {
foreach ($_FILES as $key => $tmpName) {
$filename = $this->uploadSingleFile($tmpName, 'files', '');
// $docname .= WEB_URL . "/images/$filename,";

if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}




}


$docname = trim($docname, ",");
$docname = trim($docname, "#");
}
///file is save to trashdata  if Single file is delete  (product_ajax_function)/////


try {
$this->db->beginTransaction();

$lastAssigned = $this->getUserEventData($edit_id,'assignto');
$sql      =   "UPDATE `userevent` SET `file` = ? ,`assignto` = ? ,`desc` = ? ,`comment` = ? ,`approved` = ? ,`dateTime` = ? , `due_date` = ? , `color_publish` = ?, `recurring` = ?, `usereventFormsPK` = ? WHERE `id` = ?";
$array   = array($docname, $assignto, nl2br($desc), $comment, $approved, $date, $due_date, $color_publish, $recurring, $edit_id, $edit_id);
$this->dbF->setRow($sql, $array, false);
if ($approved == 1) {
// $this->setlog("Event Approved", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
} else {
// $this->setlog("Event Update", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
}



 $smartQuery .= $this->makeRecoverySQL('usereventForms','ue_id',$edit_id);

// ========================TrashData==============================================
$ds = "Delete usereventForms table data";
$this->TrashData('eventedit function is call', $ds,"", $user, "", 'usereventForms', $edit_id, 'delete query perform',$smartQuery);
// ========================TrashData==============================================



$mysql = "DELETE FROM `usereventForms` WHERE `ue_id`=?";
$this->dbF->setRow($mysql, array($edit_id));

if (!empty($apiPostData)) {
    $form   = empty($_POST['eform2'])  ? array() : json_decode($_POST['eform2'],true);
    // var_dump($form[0]);
}else{
    $form   = empty($_POST['form'])  ? array() : $_POST['form'];
}

foreach ($form as $key => $value) {


$sql2 = "INSERT INTO `usereventForms`(`ue_id`,`title_id`,`q_id`,`user`,`radio`,`date`,`time`,`field1`,`field2`) VALUES (?,?,?,?,?,?,?,?,?)";
$array2   = array($edit_id, $title_id, $value['question'], $user, @$value['radio'], @$value['date'], @$value['time'], @$value['field1'], @$value['field2']);
$this->dbF->setRow($sql2, $array2, false);
$lastIdPK = $this->dbF->rowLastId;
}

if ($recurring_duration == 'Once' || $recurring_duration == 'Once Check') {
$sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`= ? )";
$data = $this->dbF->getRow($sql, array($title_id));
$title_id = $data['id'];
$recurring_duration = Date('Y-m-d', strtotime($due_date . '+' . $data['recurring_duration']));
}

if ($recurring_duration != 'No Recurrence') {
if ($approved == 1) {
    if ($desc2 == "Yes") {
        $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`assignto`,`due_date`,`color_publish`,`recurring`,`usereventFormsPK`) VALUES (?,?,?,?,?,?,?)";
        if ($_POST['recurring_duration'] == '1 day') {

            $recurring_duration = $this->nextworkingday($recurring_duration);
            //  if($this->isWeekend($recurring_duration)){
            //     $recurring_duration = Date('Y-m-d',strtotime($recurring_duration.'+ 1 day'));
            // }
        }
        $array   = array($user, $title_id, $assignto, $recurring_duration, '0', $recurring, $edit_id);
        $this->dbF->setRow($sql, $array, false);
        $lastId = $this->dbF->rowLastId;
        $this->setlog("New Event Create", $this->UserName($user) . " : $user",$lastId, $title . " : " . $title_id);


        ////////////////////////---------------------CronData-------------------------------------//     



        ////////////////////////---------------------CronData-------------------------------------//  

    }
}
}

// exit();
$this->db->commit();
if ($approved == 0) {
//    $this->send_mail($email,$title,'','eventsubmit');
}
// var_dump($_SESSION['currentUserType'], $lastAssigned , $_SESSION['webUser']['id'] , $this->getUserEventData($edit_id, 'assignto') , $assignto);
if ($_SESSION['currentUserType'] == 'Employee' && $lastAssigned == $_SESSION['webUser']['id']) {
    $this->deleteReminder($title_id);
    $user =  $_SESSION['webUser']['id'];
    $this->notifications('event', $user, $title);
     $this->setlog("Event '$title' completed by user $id : $this->UserName($user)", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
} 

else {
    if($lastAssigned != $assignto){
        $this->deleteReminder($title_id);
        // $this->notifications('uevent',$assignto,$title);
// }

        if (strpos($assignto, '-1') !== false) {
            $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val= ? ";
            $d = $this->dbF->getRows($q, array($user));
            foreach ($d as $key => $value) {
                $user_id = $value['id_user'];
                $this->notifications('uevent',$value['id_user'],$title);
                $this->setReminder($value['id_user'], "eventhasreminder", $edit_id);
                $this->setlog("Event '$title' assigned to user id : $id", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
            }
            }else{
                $this->setlog("Event '$title' assigned to user id : $assignto", $this->UserName($user) . " : $user", "", $title . " : " . $title_id);
                $this->setReminder($assignto, "eventhasreminder", $edit_id);
                $this->notifications('uevent',$assignto,$title);
            }
} 
// else {


//      $this->notifications('uevent',$assignto,$title);
// // }





////////////////////////---------------------CronData-------------------------------------//     










////////////////////////---------------------CronData-------------------------------------//   




}
return true;
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function eventeditAll()
{

if (isset($_POST['editAll'])) {
if (!$this->getFormToken('newEventAll')) {
return false;
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$due_date   = empty($_POST['due_date'])  ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['due_date']));
$sql = "SELECT * FROM `userevent` WHERE `due_date` = '$due_date' AND `due_date` != '' AND `approved`='-1' AND `user`='$user' AND `title_id` IN (SELECT `id` FROM `eventmanagement` WHERE `recurring_duration` IN ('1 day','1 week'))";
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
$user       = $value['user'];
$edit_id    = $value['id'];
$title_id   = $value['title_id'];
$due_date   = date("d-M-Y", strtotime($value['due_date']));

$desc1      = empty($_POST['desc'])      ? ""    : $_POST['desc'];
$desc2      = "Yes";
$date       = empty($_POST['date'])      ? date('Y-m-d')    :  date('Y-m-d', strtotime($_POST['date']));
$confirm    = '1';
$assignto   =  $value['assignto'];
$old_file   =  $value['file'];
$title      = $this->eventTitle($title_id);
$d = $this->dbF->getRow("SELECT `recurring_duration` FROM `eventmanagement` WHERE `id`= ? ", array($title_id));
$RD = $d['recurring_duration'];

if ($RD == 'No Recurrence' || $RD == 'Once' || $RD == 'Once Check') {
$recurring_duration = $this->nextDueDate($RD);
} else {
$recurring_duration = $this->nextDueDate($RD, $due_date);
}
$desc = $desc1;
if ($desc2 == "No") {
$desc = $desc1 . "-" . $desc2;
}
$docname = $old_file;

if ($confirm == '1') {
if ($this->userCheck($user)) {
    $approved = 0;
} else {
    $approved = 1;
}
} else {
$approved = $confirm;
}
if (empty($_FILES['0']['tmp_name'])) {
$docname = $old_file;
} else {
foreach ($_FILES as $key => $tmpName) {
    $filename = $this->uploadSingleFile($tmpName, 'files', '');
    // $docname .= WEB_URL . "/images/$filename,";


    if($filename==false) {
$docname .= '#';
}else{
$docname .= WEB_URL . "/images/$filename,";
}





}
$docname = trim($docname, ",");
$docname = trim($docname, "#");
}

try {
$this->db->beginTransaction();

$sql      =   "UPDATE `userevent` SET `file` = ? ,`assignto` = ? ,`desc` = ? ,`approved` = ? ,`dateTime` = ? WHERE `id` = ?";
$array   = array($docname, $assignto, nl2br($desc), $approved, $date, $edit_id);
$this->dbF->setRow($sql, $array, false);
if ($approved == 1) {
    if ($_SESSION['currentUserType'] == 'Employee') {
        $uid = $_SESSION['webUser']['id'];
    } else {
        $uid = $_SESSION['currentUser'];
    }
    // $this->setlog("Event Approved", $this->UserName($uid) . " : $uid", "", $title . " : " . $title_id);
} else {
    if ($_SESSION['currentUserType'] == 'Employee') {
        $uid = $_SESSION['webUser']['id'];
    } else {
        $uid = $_SESSION['currentUser'];
    }
    // $this->setlog("Event Update", $this->UserName($uid) . " : $uid", "", $title . " : " . $title_id);
}


if ($recurring_duration == 'Once' || $recurring_duration == 'Once Check') {
    $sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`= ? )";
    $data = $this->dbF->getRow($sql, array($title_id));
    $title_id = $data['id'];
    $recurring_duration = Date('Y-m-d', strtotime($due_date . '+' . $data['recurring_duration']));
}

if ($recurring_duration != 'No Recurrence') {
    if ($approved == 1) {
        if ($desc2 == "Yes") {
            $sql      =   "INSERT INTO `userevent`(`user`,`title_id`,`assignto`,`due_date`) VALUES (?,?,?,?)";
            if ($RD == '1 day') {
                $recurring_duration = $this->nextworkingday($recurring_duration);
                // if($this->isWeekend($recurring_duration)){
                //     $recurring_duration = Date('Y-m-d',strtotime($recurring_duration.'+ 1 day'));
                // }
            }
            $array   = array($user, $title_id, $assignto, $recurring_duration);
            $this->dbF->setRow($sql, $array, false);
            $lastId = $this->dbF->rowLastId;
            if ($_SESSION['currentUserType'] == 'Employee') {
                $uid = $_SESSION['webUser']['id'];
            } else {
                $uid = $_SESSION['currentUser'];
            }
            $this->setlog("New Event Create", $this->UserName($uid) . " : $uid", $lastId, $title . " : " . $title_id);
        }
    }
}

$this->db->commit();
if ($approved == 0) {
    //   $this->send_mail($email,$title,'','eventsubmit');
}
if ($_SESSION['currentUserType'] == 'Employee') {
    $this->notifications('event', $user);
} else {
    if (strpos($assignto, '-1') !== false) {
        $q = "SELECT id_user FROM accounts_user_detail WHERE setting_name='account_under' AND setting_val= ? ";
        $d = $this->dbF->getRows($q, array($user));
        foreach ($d as $key => $value) {
            $this->notifications('event', $value['id_user']);
        }
    } else {
        $this->notifications('event', $assignto);
    }
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // foreach end
return true;
} // If end
}

public function downloadButton($link, $edit_id = false, $linkid = false)
{




$link = explode(",", $link);
$btn = '';
$allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
foreach ($link as $key => $value) {


if ($linkid == true) {
$idAttr = 'idDelScript'. $key;

}else{

$idAttr = 'notinuse';

}


$ext = pathinfo($value, PATHINFO_EXTENSION);
if (!in_array($ext, $allowed)) {
$btn .= " <div class='DelScript" . $key . "'>
<a class='dbtn' id='" . $idAttr . "' href='http://view.officeapps.live.com/op/view.aspx?src=$value' target='_blank' data-toggle='tooltip' title='View/Download'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File &nbsp;&nbsp;</a>";
if ($linkid == true) {

$btn .= "<i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='" . $key . "' onclick='EditEventFileTrash(" . $key . "," . $edit_id . ");' >
              </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
} else {
$btn .= "</div>";
}
} else {
$btn .= "<div class='DelScript" . $key . "'><a class='dbtn' id='" . $idAttr . "' href='$value' target='_blank' data-toggle='tooltip' title='View/Download'><i class='fas fa-file'></i>&nbsp;&nbsp;Download File</a>
";
if ($linkid == true) {
$btn .= "<i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='" . $key . "' onclick='EditEventFileTrash(" . $key . "," . $edit_id . ");' >
              </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
} else {
$btn .= "</div>";
}
}
}
return $btn;
}
public function calendarEvents()
{
$j = '';
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT 
        '#' as href,
        `title`,
        'submitMYevent(this.id)' as click,
        DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
        `id` as id,
         IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf')))as color, 
         `status`,
        `recurring_duration`,
        `category` as category,
        `desc` as description
        FROM `myevents` WHERE (`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user')  AND `status`!='deleted'";

$sql2 = "SELECT 
        '#' as href,
        'editevent(this.id)' as click,
          IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,

        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,
        
        IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color,
        
        `title`,
        `userevent`.`id` as id,
        `userevent`.`recurring`,
        `recurring_duration`,
         `category` as category,
        `userevent`.`desc` as description,
        IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status
         FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user') ";

$sql3 = "SELECT 
        `title`,
        `userevent`.`file` as href,
        DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d') as start,
        '#808080' as color,
        'completed' as status,
        `userevent`.`desc` as description
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE (`userevent`.`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user') AND `approved`='1'  ";






     $dated = date('d-M-Y');
     $currentUserS = $_SESSION['currentUser'];


          $sql3practiceaddreminder = "SELECT 
        `ttitle` as title,         
        '#' as href,
  `ttodate` as start,
        '#cfa635' as color,
        'End' as status,
        'Reminder' as category,
        '' as description
        FROM `practiceaddreminder` WHERE ffromdate <= '$dated' AND ttodate >= '$dated' AND `pid`='$currentUserS'";







// $sql4 = "SELECT   '#808080' as color,
//                  'completed' as status,
//                MAX(`usereventForms`.`field2`) as f2_last_date,
//                 `usereventForms`.`title_id` as title
//                 FROM `usereventForms` JOIN `eventmanagement` ON `eventmanagement`.`id`  = `usereventForms`.`title_id`
//                 WHERE  `user`='$user' ORDER BY f2_last_date DESC";
$sql6 = "SELECT * FROM `userevent` WHERE `approved` = '1' AND user='$user' AND `title_id` = '290' ORDER BY `due_date` desc LIMIT 1";
$data6  = $this->dbF->getRow($sql6);
$ue_id = "";
if ($this->dbF->rowCount>0) {
$ue_id = $data6['id'];

}
// $sql7 = "SELECT * FROM `usereventForms` WHERE ue_id='$data6[id]' AND q_id IN (SELECT id FROM `eventForms` WHERE title_id='290' AND field2='Expiry Date')";
// $data7  = $this->dbF->getRow($sql7);


$sql4 = " SELECT   'green' as color,
          'completed' as status,
    -- DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d') as start,
   `eventForms`.`question` as title
FROM `usereventForms` JOIN `eventForms` ON `eventForms`.`id` = `usereventForms`.`q_id` WHERE user = '$user' AND `ue_id`='$ue_id' AND q_id IN (SELECT id FROM `eventForms` WHERE `title_id`='290' AND `field2`='Expiry Date')";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
$data4 = $this->dbF->getRows($sql4);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);

$data22 = array();
$data23 = array();
$data24 = array();

foreach ($data2 as $key => $value) {

if ($value['recurring'] == '') {

$recurring = $value['recurring_duration'];
} else {

$recurring = $value['recurring'];
}
if ($value['recurring_duration'] == 'Once' || $value['recurring_duration'] == 'Once Check' || $value['recurring_duration'] == 'No Recurrence') {
continue;
}

if ($recurring == '1 day') {
$j = 52;
}
if ($recurring == '1 week') {
$j = 52;
}
if ($recurring == '2 weeks') {
$j = 26;
}
if ($recurring == '3 weeks') {
$j = 18;
}
if ($recurring == '1 Month') {
$j = 12;
}
if ($recurring == '2 Months') {
$j = 8;
}
if ($recurring == '3 Months') {
$j = 6;
}
if ($recurring == '4 Months') {
$j = 4;
}
if ($recurring == '6 Months') {
$j = 3;
}
if ($recurring == '12 Months') {
$j = 2;
}
if ($recurring == '24 Months') {
$j = 2;
}
if ($recurring == '36 Months') {
$j = 2;
}
if ($recurring == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {

$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $recurring));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if ($value['start'] == "all off") {
    continue;
}
array_push($data22, $value);
}
}

foreach ($data as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 52;
}
if ($value['recurring_duration'] == '1 week') {
$j = 52;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 26;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 18;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if ($value['start'] == "all off") {
    continue;
}
if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
array_push($data23, $value);
}
}
$mysql = array_merge($data, $data2, $data3, $data22, $data23,$datasql3practiceaddreminder); //,$data4;

} else {
$user = intval($_SESSION['currentUser']);
$useremp = intval($_SESSION['webUser']['id']);

$sql = "SELECT 
        '#' as href,
        title,
        DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,
        
        IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color,
        
        `id` as id,
        `assignto` as 'assignto',
        `recurring_duration` as 'recurring_duration',
        `desc` as description,
        `category` as category,
        IF(`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status,
        'submitevent(this.id)' as click
FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND id NOT IN (SELECT title_id FROM userevent WHERE user='$user') AND id NOT IN (SELECT recurrence FROM eventmanagement)";

$sql2 = "SELECT 
        '#' as href,
        'editevent(this.id)' as click,
      IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,
        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,
       
        `title`,
        `userevent`.`id` as id,
        `recurring_duration`,
        `userevent`.`recurring`,
        `category` as category,
        `userevent`.`desc` as description,
        IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status,
         IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color
         FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user'";

$sql4 = "SELECT 
        '#' as href,
        `title`,
        'submitMYevent(this.id)' as click,
        DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
        `id` as id,
        IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf')))as color, 
        `status`,
        `recurring_duration`,
        `category` as category,
        `desc` as description
        FROM `myevents` WHERE`user`='$user' AND `status`!='deleted'";

$sql5 = "SELECT 
        `title`,
        '#' as href,
        `userevent`.`id` as id,
        'editevent(this.id)' as click,
        IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as start,
        IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as due_date,
        '#808080' as color,
        'completed' as status,
        `userevent`.`desc` as description,
        `category` as category
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE `user`='$user' AND `approved`='1'  ";



     $dated = date('d-M-Y');
     $currentUserS = intval($_SESSION['currentUser']);


          $sql3practiceaddreminder = "SELECT 
        `ttitle` as title,
        '#' as href,
        `ttodate` as start,
        '#cfa635' as color,
        'End' as status,
        'Reminder' as category,
        '' as description
        FROM `practiceaddreminder` WHERE ffromdate <= '$dated' AND ttodate >= '$dated' AND `pid`='$currentUserS'";





$sql6 = "SELECT * FROM `userevent` WHERE `approved` = '1' AND user='$user' AND `title_id` = '290' ORDER BY `due_date` desc LIMIT 1";
$data6  = $this->dbF->getRow($sql6);

// $sql7 = "SELECT * FROM `usereventForms` WHERE ue_id='$data6[id]' AND q_id IN (SELECT id FROM `eventForms` WHERE title_id='290' AND field2='Expiry Date')";
// $data7  = $this->dbF->getRow($sql7);


$ue_id = "";
if ($this->dbF->rowCount>0) {
$ue_id = $data6['id'];

}

$sql8 = " SELECT   
'green' as color,
'Check Expiry' as category,
'expired' as status,

DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d') as start,
REPLACE( `eventForms`.`question`, 'Have You Checked', 'Expiry For')as title,
DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d')  as due_date
FROM `usereventForms` JOIN `eventForms` ON `eventForms`.`id` = `usereventForms`.`q_id` WHERE `user` = '$user' AND `ue_id`='$ue_id' AND q_id IN (SELECT id FROM `eventForms` WHERE `title_id`='290' AND `field2`='Expiry Date')AND `usereventForms`.`field2` !='' ";




$data  = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data4 = $this->dbF->getRows($sql4);
$data5 = $this->dbF->getRows($sql5);
$data8 = $this->dbF->getRows($sql8);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);
$data3 = array();
$data10 = array();
$data11 = array();

foreach ($data2 as $key => $value) {

if ($value['recurring'] == '') {

$recurring = $value['recurring_duration'];
} else {

$recurring = $value['recurring'];
}
if ($value['recurring_duration'] == 'Once' || $value['recurring_duration'] == 'Once Check' || $value['recurring_duration'] == 'No Recurrence') {
continue;
}

if ($recurring == '1 day') {
$j = 52;
}
if ($recurring == '1 week') {
$j = 52;
}
if ($recurring == '2 weeks') {
$j = 26;
}
if ($recurring == '3 weeks') {
$j = 18;
}
if ($recurring == '1 Month') {
$j = 12;
}
if ($recurring == '2 Months') {
$j = 8;
}
if ($recurring == '3 Months') {
$j = 6;
}
if ($recurring == '4 Months') {
$j = 4;
}
if ($recurring == '6 Months') {
$j = 3;
}
if ($recurring == '12 Months') {
$j = 2;
}
if ($recurring == '24 Months') {
$j = 2;
}
if ($recurring == '36 Months') {
$j = 2;
}
if ($recurring == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {

$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $recurring));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if ($value['start'] == "all off") {
    continue;
}
array_push($data3, $value);
}
}
foreach ($data4 as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 52;
}
if ($value['recurring_duration'] == '1 week') {
$j = 52;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 26;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 18;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if ($value['start'] == "all off") {
    continue;
}
if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
array_push($data10, $value);
}
}

foreach ($data as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 52;
}
if ($value['recurring_duration'] == '1 week') {
$j = 52;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 26;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 18;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if ($value['start'] == "all off") {
    continue;
}
if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
array_push($data11, $value);
}
}
if (!$this->health_check($user)) {
$mysql = array_merge($data, $data2, $data3, $data4, $data5, $data10, $data11,$datasql3practiceaddreminder); //,$data8


//     echo "<!--";
// var_dump($data3);
// var_dump( $data10);
//     echo "---->";

} else {
$mysql = $data4;
}
}
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";
}
public function calendarEventsApi()
{
$j = '';
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql = "SELECT 
            `assignto`,
            IF(SUBSTR(`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `assignto` )) AS assigntoName,
            `category`,
            `file`,
            `due_date`,
            '' AS end,
            DATE_FORMAT(`due_date`,'%Y-%m-%d') AS start,
            `desc` AS description,
            `recurring_duration`,
            `title`,
            `id`,
            IF(`status`='complete' AND approved = '1','complete','myEvent') AS status,
            IF(`type` != '' ,`type`,'recommended') AS eventType,
            'myEvent' AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp
        FROM `myevents` WHERE (`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user')  AND `status`!='deleted'";

$sql2 = "SELECT 
            `userevent`.`assignto`,
            IF(SUBSTR(`userevent`.`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `userevent`.`assignto` )) AS assigntoName,
            `category`,
            `userevent`.`file`,
            `userevent`.`due_date`,
            '' AS end,
            IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,
            `userevent`.`desc` as description,
            `recurring_duration`,
            `title`,
            `userevent`.`id` as id,
            IF(`userevent`.`assignto` > '0' || `userevent`.`assignto` = '-1','assigned',IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming')) AS status,
            IF(`eventmanagement`.`type` = 'mandatory', 'mandatory', IF(`eventmanagement`.`type` = 'recommended', 'recommended', IF(`eventmanagement`.`type` = 'updates', 'updates','recommended'))) AS eventType,
            IF(`eventmanagement`.`type` = 'updates', 'updates', 'eventRecurring')  AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp
         FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user') ";

$sql3 = "SELECT 
            `userevent`.`assignto`,
            IF(SUBSTR(`userevent`.`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `userevent`.`assignto` )) AS assigntoName,
            `category`,
            `userevent`.`file`,
            `userevent`.`due_date`,
            '' AS end,
            DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d') as start,
            `userevent`.`desc` as description,
            `recurring_duration`,
            `title`,
            `userevent`.`id` as id,
            'complete' as status,
            IF(`eventmanagement`.`type` = 'mandatory', 'mandatory', IF(`eventmanagement`.`type` = 'recommended', 'recommended', IF(`eventmanagement`.`type` = 'updates', 'updates','recommended'))) AS eventType,
            'eventRecurring' AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE (`userevent`.`assignto` IN ('-1.$d[0]','$user') OR  `user`='$user') AND `approved`='1'  ";



     $dated = date('d-M-Y');
     $currentUserS = $_SESSION['currentUser'];


          $sql3practiceaddreminder = "SELECT 
            '' AS assignto,
            '' AS assigntoName,
            '' AS category,
            '' AS file,
            '' AS due_date,
            DATE_ADD(DATE_FORMAT(`ttodate`,'%Y-%m-%d'),INTERVAL 1 DAY) as `end`,
            DATE_FORMAT(`ffromdate`,'%Y-%m-%d') as `start`, 
            '' as description,
            '' as recurring_duration,
            `ttitle` as title,
            `id` as id,
            'reminder' as status,
            'reminder' AS eventType,
            'reminder' AS type,
            '' as doneByEmp
        FROM `practiceaddreminder` WHERE `pid`='$currentUserS'";


//////////////   Drug Expiry Reminder Work Not Done Here.....
//////////////   Drug Expiry Reminder Work Not Done Here.....
//////////////   Drug Expiry Reminder Work Not Done Here.....

$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
// $data4 = $this->dbF->getRows($sql4);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);

$mysql = array_merge($data, $data2, $data3,$datasql3practiceaddreminder);
 //,$data4;

} else {
$user = intval($_SESSION['currentUser']);
$useremp = intval($_SESSION['webUser']['id']);

$sql = "SELECT 
            '' AS assignto,
            '' AS assigntoName,
            `category`,
            `file`,
            `due_date`,
            '' AS end,
            DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
            `desc` as description,
            `recurring_duration`,
            `title`,
            `id`,
            IF(`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status,
            IF(`eventmanagement`.`type` = 'mandatory', 'mandatory', IF(`eventmanagement`.`type` = 'recommended', 'recommended', IF(`eventmanagement`.`type` = 'updates', 'updates','recommended'))) AS eventType,
            'eventFirst' AS type,
            '' AS doneByEmp
FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND id NOT IN (SELECT title_id FROM userevent WHERE user='$user' AND title_id IS NOT NULL) AND id NOT IN (SELECT recurrence FROM eventmanagement)";

$sql2 = "SELECT 
            `userevent`.`assignto`,
            IF(SUBSTR(`userevent`.`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `userevent`.`assignto` )) AS assigntoName,
            `category`,
            `userevent`.`file`,
            `userevent`.`due_date`,
            '' AS end,
            IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,
            `userevent`.`desc` as description,
            `recurring_duration`,
            `title`,
            `userevent`.`id` as id,
            IF(`userevent`.`assignto` > '0' || `userevent`.`assignto` = '-1','assigned',IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming')) AS status,
            IF(`eventmanagement`.`type` = 'mandatory', 'mandatory', IF(`eventmanagement`.`type` = 'recommended', 'recommended', IF(`eventmanagement`.`type` = 'updates', 'updates','recommended'))) AS eventType,
            IF(`eventmanagement`.`type` = 'updates', 'updates', 'eventRecurring')  AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' ";

$sql4 = "SELECT 
            `assignto`,
            IF(SUBSTR(`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `assignto` )) AS assigntoName,
            `category`,
            `file`,
            `due_date`,
            '' AS end,
            DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
            `desc` AS description,
            `recurring_duration`,
            `title`,
            `id`,
            IF(`status`='complete' AND approved = '1','complete','myEvent') AS status,
            IF(`type` != '' ,`type`,'recommended') AS eventType,
            'myEvent' AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp
        FROM `myevents` WHERE`user`='$user' AND `status`!='deleted'";

$sql5 = "SELECT 
            `userevent`.`assignto`,
            IF(SUBSTR(`userevent`.`assignto`, 1, 3)='-1.','All',(SELECT `acc_name` FROM `accounts_user` WHERE `acc_id` = `userevent`.`assignto` )) AS assigntoName,
            `category`,
            `userevent`.`file`,
            IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as due_date,
            '' AS end,
            IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as start,
            `userevent`.`desc` as description,
            '' AS `recurring_duration`,
            `title`,
            `userevent`.`id` as id,
            'complete' as status,
            IF(`eventmanagement`.`type` = 'mandatory', 'mandatory', IF(`eventmanagement`.`type` = 'recommended', 'recommended', IF(`eventmanagement`.`type` = 'updates', 'updates','recommended'))) AS eventType,
            'eventRecurring' AS type,
            IF(`color_publish` = '0','0','1') AS doneByEmp 
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE `user`='$user' AND `approved`='1'  ";



     $currentUserS = $_SESSION['currentUser'];

        $sql3practiceaddreminder = "SELECT 
            '' AS assignto,
            '' AS assigntoName,
            '' AS category,
            '' AS file,
            '' AS due_date,
            DATE_ADD(DATE_FORMAT(`ttodate`,'%Y-%m-%d'),INTERVAL 1 DAY) as `end`,
            DATE_FORMAT(`ffromdate`,'%Y-%m-%d') as `start`, 
            '' as description,
            '' as recurring_duration,
            `ttitle` as title,
            `id` as id,
            'reminder' as status,
            'reminder' AS eventType,
            'reminder' AS type,
            '' as doneByEmp
        FROM `practiceaddreminder` WHERE `pid`='$currentUserS'";

//////////////   Drug Expiry Reminder Work Not Done Here.....
//////////////   Drug Expiry Reminder Work Not Done Here.....
//////////////   Drug Expiry Reminder Work Not Done Here.....

$data  = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data4 = $this->dbF->getRows($sql4);
$data5 = $this->dbF->getRows($sql5);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);


if (!$this->health_check($user)) {

        $mysql = array_merge($data, $data2, $data4, $data5,$datasql3practiceaddreminder);
} else {
$mysql = $data4;
}
}
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
return  $newString;
}
public function calendarEvents111($isApi = false)
{
$j = '';
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

$temp=$this->allGroupsIds($user);

$sql = "SELECT 
        '#' as href,
        `title`,
        'submitMYevent(this.id)' as click,
        DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
        `id` as id, 
        IF(`status`='complete' AND approved = '1','#808080',(IF(`type` = 'mandatory', 'redborder',(IF(`type` = 'recommended', 'blueborder',(IF(`color_publish` = '0','#01abbf','#01abbf'))) ))) )as type,";
//         IF(`type` = 'mandatory', 'redborder', IF(`type` = 'recommended', 'blueborder',IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf')))))as type,

if(!$isApi){
    // $sql.= "IF(`type` = 'mandatory', '#ff0000', IF(`type` = 'recommended', '#00b58a', IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf'))))) as color,";
     $sql.= "IF(`status`='complete' AND approved = '1','#808080', (IF(`type` = 'mandatory', '#ff0000', (IF(`type` = 'recommended', '#00b58a', (IF(`color_publish` = '0','#01abbf','#01abbf'))) ))))as color,";
}


$sql.= 
         " 
         `status`,
        `recurring_duration`,
        `category` as category,
        `desc` as description,
        `type` as eventType
        FROM `myevents` WHERE (`assignto` IN ('-1.$d[0]','$user'$temp) OR  `user`='$user')  AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";

$sql2 = "SELECT 
        '#' as href,
        'editevent(this.id)' as click,
          IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,

        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,";

if(!$isApi){
$sql2 .= "IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color,";
}

$sql2 .= " `title`,
        `userevent`.`id` as id,
        `userevent`.`recurring`,
        `recurring_duration`,
         `category` as category,
        `userevent`.`desc` as description,
        IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status
         FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE (`approved`='0' OR `approved`='-1') AND (`userevent`.`assignto` IN ('-1.$d[0]','$user'$temp) OR  `user`='$user') AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$sql3 = "SELECT 
        `title`,
        `userevent`.`id` as id,
        `userevent`.`file` as href,
        'editevent(this.id)' as click,
        DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d') as start,";

if(!$isApi){
$sql3 .= " '#808080' as color,";
}
$sql3 .= " 'completed' as status,
        `userevent`.`desc` as description
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE (`userevent`.`assignto` IN ('-1.$d[0]','$user'$temp) OR  `user`='$user') AND `approved`='1' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ";






     $dated = date('d-M-Y');
     $currentUserS = $_SESSION['currentUser'];


          $sql3practiceaddreminder = "SELECT 
        `ttitle` as title,
        '#' as href,
        DATE_FORMAT(`ffromdate`,'%Y-%m-%d') as `start`, 
        DATE_ADD(DATE_FORMAT(`ttodate`,'%Y-%m-%d'),INTERVAL 1 DAY) as `end`,";

        if(!$isApi){
        $sql3practiceaddreminder .= " '#cfa635' as color,";
        }

        $sql3practiceaddreminder .= " 'End' as status,
        'Reminder' as category,
        '' as description
        FROM `practiceaddreminder` WHERE `pid`='$currentUserS'";







// $sql4 = "SELECT   '#808080' as color,
//                  'completed' as status,
//                MAX(`usereventForms`.`field2`) as f2_last_date,
//                 `usereventForms`.`title_id` as title
//                 FROM `usereventForms` JOIN `eventmanagement` ON `eventmanagement`.`id`  = `usereventForms`.`title_id`
//                 WHERE  `user`='$user' ORDER BY f2_last_date DESC";
$sql6 = "SELECT * FROM `userevent` WHERE `approved` = '1' AND user='$user' AND `title_id` = '290' ORDER BY `due_date` desc LIMIT 1";
$data6  = $this->dbF->getRow($sql6);
$ue_id = "";
if ($this->dbF->rowCount>0) {
$ue_id = $data6['id'];

}
// $sql7 = "SELECT * FROM `usereventForms` WHERE ue_id='$data6[id]' AND q_id IN (SELECT id FROM `eventForms` WHERE title_id='290' AND field2='Expiry Date')";
// $data7  = $this->dbF->getRow($sql7);


$sql4 = " SELECT";

if(!$isApi){
$sql4 .=   "'green' as color,";
}        
        
$sql4 .=   "'completed' as status,
    -- DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d') as start,
   `eventForms`.`question` as title
FROM `usereventForms` JOIN `eventForms` ON `eventForms`.`id` = `usereventForms`.`q_id` WHERE user = '$user' AND `ue_id`='$ue_id' AND q_id IN (SELECT id FROM `eventForms` WHERE `title_id`='290' AND `field2`='Expiry Date')";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
$data4 = $this->dbF->getRows($sql4);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);

$data22 = array();
$data23 = array();
$data24 = array();

foreach ($data2 as $key => $value) {

if ($value['recurring'] == '') {

$recurring = $value['recurring_duration'];
} else {

$recurring = $value['recurring'];
}
if ($value['recurring'] == '' && ($value['recurring_duration'] == 'Once' || $value['recurring_duration'] == 'Once Check' || $value['recurring_duration'] == 'No Recurrence')) {
continue;
}

if ($recurring == '1 day') {
$j = 90;
}
if ($recurring == '1 week') {
$j = 26;
}
if ($recurring == '2 weeks') {
$j = 13;
}
if ($recurring == '3 weeks') {
$j = 10;
}
if ($recurring == '1 Month') {
$j = 12;
}
if ($recurring == '2 Months') {
$j = 8;
}
if ($recurring == '3 Months') {
$j = 6;
}
if ($recurring == '4 Months') {
$j = 4;
}
if ($recurring == '6 Months') {
$j = 3;
}
if ($recurring == '12 Months') {
$j = 2;
}
if ($recurring == '24 Months') {
$j = 2;
}
if ($recurring == '36 Months') {
$j = 2;
}
if ($recurring == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {

$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $recurring));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if($value['start'] == "all off"){
                    continue;
                }
array_push($data22, $value);
}
}

foreach ($data as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 90;
}
if ($value['recurring_duration'] == '1 week') {
$j = 26;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 13;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 10;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if($value['start'] == "all off"){
                    continue;
                }
if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
array_push($data23, $value);
}
}

if($isApi){
    $mysql = array_merge($data, $data2, $data3,$datasql3practiceaddreminder);
}
else{
    $mysql = array_merge($data, $data2, $data3, $data22, $data23,$datasql3practiceaddreminder);
}
 //,$data4;

} 

else {
$user = intval($_SESSION['currentUser']);
$useremp = intval($_SESSION['webUser']['id']);

$signup_date = $this->selectUserInfo($user,'acc_created');

$due_date = date("d-M-Y", strtotime($signup_date));

// DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,

$sql = "SELECT 
        '#' as href,
        title,
        
        IF(`eventmanagement`.`type` = 'updates',DATE_FORMAT(`due_date`, '%Y-%m-%d'),IF(`due_date` = '' ,DATE_FORMAT('$signup_date', '%Y-%m-%d'),DATE_FORMAT(`due_date`,'%Y-%m-%d')) ) as start,
        
        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,"; 
        
        if(!$isApi){
        $sql .= "IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color,";
        }
        
        $sql .= "`id` as id,
        `assignto` as 'assignto',
        `recurring_duration` as 'recurring_duration',
        `desc` as description,
        `category` as category,
        IF(`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status,
        'submitevent(this.id)' as click,
        'eventFirst' as Type2
FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND id NOT IN (SELECT title_id FROM userevent WHERE user='$user' AND title_id IS NOT NULL) AND id NOT IN (SELECT recurrence FROM eventmanagement) AND id NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')";

$sql2 = "SELECT 
        '#' as href,
        'editevent(this.id)' as click,
      IF(`userevent`.`dateTime` = '' || `userevent`.`due_date` > `userevent`.`dateTime`  ,DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d')) as start,
        IF(`eventmanagement`.`type` = 'mandatory', 'redborder', IF(`eventmanagement`.`type` = 'recommended', 'blueborder', IF(`eventmanagement`.`type` = 'updates', 'purpleborder','orangeborder')))as type,

        IF(`eventmanagement`.`type` = 'mandatory', 'mandatory event', IF(`eventmanagement`.`type` = 'recommended', 'recommended event', IF(`eventmanagement`.`type` = 'updates', 'updates event','orangeborder')))as Type1,

        'Event Recurring' as Type2,
       
        `title`,
        `userevent`.`id` as id,
        `recurring_duration`,
        `userevent`.`recurring`,
        `category` as category,
        `userevent`.`desc` as description,
        IF(`userevent`.`due_date`<=(SELECT CURDATE()),'overdue','upcoming') AS status,";

        if(!$isApi){
        $sql2 .= " IF(`eventmanagement`.`type` = 'mandatory', '#ff0000', IF(`eventmanagement`.`type` = 'recommended', '#00b58a', IF(`eventmanagement`.`type` = 'updates', '#a101b9','orangeborder'))) as color,";
        }

        $sql2 .= "        `userevent`.`file` as file
 FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event') ";

$sql4 = "SELECT 
        '#' as href,
        `title`,
        'submitMYevent(this.id)' as click,
        DATE_FORMAT(`due_date`,'%Y-%m-%d') as start,
        `id` as id,
        IF(`status`='complete' AND approved = '1','#808080',(IF(`type` = 'mandatory', 'redborder', (IF(`type` = 'recommended', 'blueborder',( IF(`color_publish` = '0','#01abbf','#01abbf')) )) )) )as type,";
//        IF(`type` = 'mandatory', 'redborder', IF(`type` = 'recommended', 'blueborder',IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf')))))as type,";

        if(!$isApi){
        $sql4 .= "
        IF(`status`='complete' AND approved = '1','#808080',(IF(`type` = 'mandatory', '#ff0000', (IF(`type` = 'recommended', '#00b58a', (IF(`color_publish` = '0','#01abbf','#01abbf')))))) )as color,";
//        IF(`type` = 'mandatory', '#ff0000', IF(`type` = 'recommended', '#00b58a', IF(`status`='complete' AND approved = '1','#808080',(IF(`color_publish` = '0','#01abbf','#01abbf'))))) as color,";

        
        }

        $sql4 .= "'My Event' as Type2,
        `status`,
        `recurring_duration`,
        `category` as category,
        `desc` as description,
        `type` as eventType
        FROM `myevents` WHERE`user`='$user' AND (
(`status`!='deleted' AND `status`!='complete')
OR  (      

( `status`='complete' AND `recurring_duration` = 'No Recurrence'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = 'Once'   AND  `due_date` >= DATE_SUB(date(NOW()), INTERVAL 7 day)) OR

( `status`='complete' AND `recurring_duration` = 'Once Check'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 day'   AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)) OR

( `status`='complete' AND `recurring_duration` = '1 week' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '2 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

( `status`='complete' AND `recurring_duration` = '3 weeks' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR

( `status`='complete' AND `recurring_duration` = '1 Month' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 3 MONTH)) OR 

(  `status`='complete' AND `recurring_duration` = '2 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '3 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '4 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) OR

(  `status`='complete' AND `recurring_duration` = '6 Months' AND  `due_date` >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH))OR( `recurring_duration`  IN ('12 months','24 months','36 months','60 months') ) 
))  ORDER BY  `title` , `dateTime` DESC";

$sql5 = "SELECT 
        `title`,
        '#' as href,
        `userevent`.`id` as id,
        'editevent(this.id)' as click,
        IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as start,
        IF(`userevent`.`due_date` = '',DATE_FORMAT(`userevent`.`dateTime`,'%Y-%m-%d'),DATE_FORMAT(`userevent`.`due_date`,'%Y-%m-%d')) as due_date,";

        if(!$isApi){
        $sql5 .= "'#808080' as color,";
        }

        $sql5 .= " 'completed' as status,
        'Completed Event' as Type1,
        `userevent`.`desc` as description,
        `category` as category
        FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id`
        WHERE `user`='$user' AND `approved`='1' AND `userevent`.`title_id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='event')  ";



     $currentUserS = intval($_SESSION['currentUser']);
    $user = intval($user);

          $sql3practiceaddreminder = "SELECT 
        `ttitle` as title,
        '#' as href,
        DATE_FORMAT(`ffromdate`,'%Y-%m-%d') as `start`, 
        DATE_ADD(DATE_FORMAT(`ttodate`,'%Y-%m-%d'),INTERVAL 1 DAY) as `end`,";
        if(!$isApi){
        $sql3practiceaddreminder .= "'#cfa635' as color,";
        }

        $sql3practiceaddreminder .= "'End' as status,
        'Reminder' as category,
        'Reminder' as Type1,
        'Reminder' as Type2,
        '' as description
        FROM `practiceaddreminder` WHERE `pid`='$currentUserS'";





$sql6 = "SELECT * FROM `userevent` WHERE `approved` = '1' AND user='$user' AND `title_id` = '290' ORDER BY `due_date` desc LIMIT 1";
$data6  = $this->dbF->getRow($sql6);

// $sql7 = "SELECT * FROM `usereventForms` WHERE ue_id='$data6[id]' AND q_id IN (SELECT id FROM `eventForms` WHERE title_id='290' AND field2='Expiry Date')";
// $data7  = $this->dbF->getRow($sql7);


$ue_id = "";
if ($this->dbF->rowCount>0) {
$ue_id = $data6['id'];

}

$sql8 = " SELECT";
if(!$isApi){
$sql8 .= "'green' as color,";
}
$sql8 .= "'Check Expiry' as category,
'expired' as status,

DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d') as start,
REPLACE( `eventForms`.`question`, 'Have You Checked', 'Expiry For')as title,
DATE_FORMAT(`usereventForms`.`field2`,'%Y-%M-%d')  as due_date
FROM `usereventForms` JOIN `eventForms` ON `eventForms`.`id` = `usereventForms`.`q_id` WHERE `user` = '$user' AND `ue_id`='$ue_id' AND q_id IN (SELECT id FROM `eventForms` WHERE `title_id`='290' AND `field2`='Expiry Date')AND `usereventForms`.`field2` !='' ";




$data  = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$data4 = $this->dbF->getRows($sql4);
$data5 = $this->dbF->getRows($sql5);
$data8 = $this->dbF->getRows($sql8);
$datasql3practiceaddreminder = $this->dbF->getRows($sql3practiceaddreminder);
$data3 = array();
$data10 = array();
$data11 = array();

// if ($user!='2938') {

foreach ($data2 as $key => $value) {

if ($value['recurring'] == '') {

$recurring = $value['recurring_duration'];
} else {

$recurring = $value['recurring'];
}
if ($value['recurring'] == '' && $value['recurring_duration'] == 'Once' || $value['recurring_duration'] == 'Once Check' || $value['recurring_duration'] == 'No Recurrence') {
continue;
}

if ($recurring == '1 day') {
$j = 90;
}
if ($recurring == '1 week') {
$j = 26;
}
if ($recurring == '2 weeks') {
$j = 13;
}
if ($recurring == '3 weeks') {
$j = 10;
}
if ($recurring == '1 Month') {
$j = 12;
}
if ($recurring == '2 Months') {
$j = 8;
}
if ($recurring == '3 Months') {
$j = 6;
}
if ($recurring == '4 Months') {
$j = 4;
}
if ($recurring == '6 Months') {
$j = 3;
}
if ($recurring == '12 Months') {
$j = 2;
}
if ($recurring == '24 Months') {
$j = 2;
}
if ($recurring == '36 Months') {
$j = 2;
}
if ($recurring == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {

$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $recurring));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));
if($value['start'] == "all off"){
    continue;
}
array_push($data3, $value);
}
}

foreach ($data4 as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 90;
}
if ($value['recurring_duration'] == '1 week') {
$j = 26;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 13;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 10;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));

if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
if($value['start'] == "all off"){
    continue;
}
array_push($data10, $value);
}
}

// }

foreach ($data as $key => $value) {
if ($value['recurring_duration'] == 'No Recurrence') {
continue;
}
if ($value['recurring_duration'] == '1 day') {
$j = 90;
}
if ($value['recurring_duration'] == '1 week') {
$j = 26;
}
if ($value['recurring_duration'] == '2 weeks') {
$j = 13;
}
if ($value['recurring_duration'] == '3 weeks') {
$j = 10;
}
if ($value['recurring_duration'] == '1 Month') {
$j = 12;
}
if ($value['recurring_duration'] == '2 Months') {
$j = 8;
}
if ($value['recurring_duration'] == '3 Months') {
$j = 6;
}
if ($value['recurring_duration'] == '4 Months') {
$j = 4;
}
if ($value['recurring_duration'] == '6 Months') {
$j = 3;
}
if ($value['recurring_duration'] == '12 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '24 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '36 Months') {
$j = 2;
}
if ($value['recurring_duration'] == '60 Months') {
$j = 2;
}
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($value['start'] . '+' . $value['recurring_duration']));
// if($this->isWeekend($value['start'])){
//     continue;
// }
$value['start'] =  $this->nextworkingday(($value['start']));

if (@$value['approved'] == '1'  || $value['status'] == 'complete') {
    continue;
}
if($value['start'] == "all off"){
    continue;
}
array_push($data11, $value);
}
}

if (!$this->health_check($user)) {

    if($isApi){
        $mysql = array_merge($data, $data2, $data4, $data5,$datasql3practiceaddreminder);
    }
    else{
        $mysql = array_merge($data, $data2, $data3, $data4, $data5, $data10, $data11,$datasql3practiceaddreminder);
    }

 //,$data8


//     echo "<!--";
// var_dump($data2);
// var_dump( $data10);
//     echo "---->";

} else {
        $mysql = array_merge($data4, $data10,$datasql3practiceaddreminder);
}
}

$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";
}

public function resourcesName($category, $user)
{
$user=intval($user);
$sql = "SELECT DISTINCT(`sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `publish` = '1'";
$data = $this->dbF->getRows($sql);
$cate = "<option value='all'>All</option>";
foreach ($data as $key => $value) {
$cate .= "<option value='" . $value['sub_category'] . "'>" . $value['sub_category'] . "</option>";
}
return $cate;
}

public function resourcesData($category, $user)
{
$user=intval($user);
$sql = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `publish` = '1'";
$data = $this->dbF->getRows($sql);
$li = "";
foreach ($data as $key => $value) {
$li .= '<li class="all ' . str_replace(' ', '', $value['sub_category']) . '">
<div class="col4_main_left1">
' . $value['title'] . '
</div><!-- col4_main_left1 close -->
<div class="col4_main_left2">
</div><!-- col4_main_left2 close -->
<div class="col4_main_left3">
<a href="' . $value['file'] . '" download><i class="fas fa-download"></i></a>
</div><!-- col4_main_left3 close -->
</li>';
}
return $li;
}

public function resources($category, $user)
{  

$user=intval($user);

$sql1 = "SELECT DISTINCT(`sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `publish` = '1' ";






$data1 = $this->dbF->getRows($sql1);
// $data2 = $this->dbF->getRows($sql2);
// $mysql = array_merge($data1,$data2);
// $mysql = array_unique($mysql,SORT_REGULAR);
// sort($mysql);
foreach ($data1 as $key => $value1) {
$sql = "SELECT DISTINCT(`sub_sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `sub_category`='$value1[sub_category]' AND `publish` = '1' GROUP BY `sub_sub_category` ORDER BY `sub_sub_category`";
$data = $this->dbF->getRows($sql);
echo "<div class='main-row'>
    <div class='main-row-top'>
        <h5>$value1[sub_category]</h5>
        <i class='fas fa-chevron-down'></i>
    </div>
    <!-- main-row-top -->
    <div class='main-row-down'><ul>";
if (!empty($data)) {

foreach ($data as $key => $value) {
if ($value['sub_sub_category'] != '') {


    $sql = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `sub_sub_category`='$value[sub_sub_category]' AND `sub_sub_category` !='' AND `sub_category`='$value1[sub_category]'AND `publish` = '1' ORDER BY `title`";
    $data = $this->dbF->getRows($sql);
    //<span>('.date('d-M-Y',strtotime($value['dateTime'])).')</span>

    echo "<li><div class='main-row-tops'>
        $value[sub_sub_category]
        <i class='fas fa-chevron-down' style='float: right;'></i>
    
    <!-- main-row-top -->
    <div class='main-row-down'><ul>";
    foreach ($data as $key => $value) {

        $id = base64_encode($value['id']);
        echo '<li class="blue">
<div class="row-title">
 ' . $value['title'] . ' 
</div>
<!-- row-title -->
<div class="row-icons">';
        if ($value['file'] == '#') {
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //     echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
 <!-- row-icons -->
</li>';
        } else {
            $link = explode(",", $value['file']);
            $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
            foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }

                 $downLink=base64_encode($val.":s:".date('d'));



                $ext = pathinfo($val, PATHINFO_EXTENSION);

                if (!in_array($ext, $allowed)) {
                    if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                        if ($ext == 'el') {
                            echo '<a data-toggle="tooltip" title="Edit"  class="ablue" id="' . $id . '" onclick="txtform(this.id)"><i class="fas fa-edit"></i></a>';
                        } else {
                            // echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';

    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';


                        }
                    }
                    if ($ext == 'el') {

                        if ($value['extra_file'] != '') {
                            $ext_extra = pathinfo($value['extra_file'], PATHINFO_EXTENSION);
                            $downLink=base64_encode($value['extra_file'].":s:".date('d'));
                            if (!in_array($ext_extra, $allowed)) {
                                //  $this->dbF->prnt($value['extra_file']);
                                echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $value['extra_file'] . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($value['extra_file'], PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                            } else {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
                                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                            }
                        }
                    } else {
                        // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="cView/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                } else {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                }
            }
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    }
    echo '</ul></div></div></li>
';
} else {



    $sql = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `sub_sub_category`='$value[sub_sub_category]' AND `sub_sub_category` ='' AND `sub_category`='$value1[sub_category]'AND `publish` = '1' ORDER BY `title`";
    $data = $this->dbF->getRows($sql);
    ///<span>('.date('d-M-Y',strtotime($value['dateTime'])).')</span>


    foreach ($data as $key => $value) {

        $id = base64_encode($value['id']);
        echo '<li class="blue">
<div class="row-title">
 ' . $value['title'] . ' 
</div>
<!-- row-title -->
<div class="row-icons">';
        if ($value['file'] == '#') {
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //     echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
 <!-- row-icons -->
</li>';
        } else {
            $link = explode(",", $value['file']);
            $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
            foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
                $downLink=base64_encode($val.":s:".date('d'));



                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                        // echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';


    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';

                    }
                    // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="eView/Download" target="_blank"><i class="fas fa-download"></i></a>';
                } else {

                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                }
            }
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    }
}
}
} //one close






echo "</ul></div>
<!-- main-row-down -->           
</div><!-- main-row -->";
}
}
public function resources2($category, $user){  

$user=intval($user);
    if($_GET['category'] != 'Compliance-Templates' && $_GET['category'] != 'HR-Management' && $_GET['category'] != 'Practice-Management-Resources' ){
        echo "<div class = 'data_not-found'><h3>Data not found</h3></div>" ;
    }else{
        $sql1 = "SELECT DISTINCT(`sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `publish` = '1' ORDER BY sub_category ";
        $data1 = $this->dbF->getRows($sql1, array($category));
        if(!empty($data1)){
            foreach ($data1 as $key => $value1) {
            $sql = "SELECT COUNT(`file`) AS file FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `sub_category`='$value1[sub_category]' AND `publish` = '1'";
            $data = $this->dbF->getRow($sql);
            $sqlInner = "SELECT title FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `sub_category`='$value1[sub_category]' AND `publish` = '1'";
            $dataInner = $this->dbF->getRows($sqlInner);
            // var_dump($dataInner);
            $dataInner2="";
            foreach ($dataInner as $key => $valueInner) {$dataInner2.=$valueInner['title'];}
            // $dataInner=implode(",",$dataInner[]);
            $link = WEB_URL."/resources?category=".$_GET['category'].
            "&sub_category=".$value1['sub_category'];
            echo " <div class='card'>
                    <a href='$link' >
                    <div class='card-top'>
                        <div class='name'>
                            <h5>$value1[sub_category] <span style='display:none'>$dataInner2</span></h5>
                        </div>
                    </div>
                    <div class='card_body'>
                        <div class='files'>
                            <p>Files</p>
                        </div>
                        <div class='files_count'>
                            <p>$data[file]</p>
                        </div>
                    </div>
                    </a>                   
                </div>";
        }
        ?>
                 <div class="card">
                    <a href="javascript:;" onclick="uploadcompliancetemplate('<?php echo str_replace("-"," ",$_GET['category']);?>')">
                    <div class="card-top">
                    <div class="name" style="margin: 15%;text-align: center;">
                    <h5><i class="fa fa-plus" aria-hidden="true"></i> Upload Template <span style="display:none">Add New Upload Template</span></h5>
                    </div>
                    </div>
                    
                    </a>
                </div>
        <?php
        }else{
            echo "<div class = 'data_not-found'><h3>Data not found</h3></div>";
        }
    }
        
}


public function create_row($value){
    // var_dump($value);
    // $link = explode(",", $value['file']);
    // $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    
    // echo "<tr>
    //         <td class='name'>
    //             <h5>".$value['title']."</h5>
    //         </td>
    //         <td>";        
            
    //         foreach ($link as $key => $val) {

    //             $downLink=base64_encode($val.":s:".date('d'));



    //             $ext = pathinfo($val, PATHINFO_EXTENSION);
    //             if (!in_array($ext, $allowed)) {
    //                 if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
    //                     echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';
    //                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                     echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';
    //                     }
    //                 // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="eView/Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                 }else {
    //                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                 }
    //             }
    //             echo "</td></tr>";
    
    
    

//         $id = base64_encode($value['id']);
//         echo '<li class="blue">
// <div class="row-title">
//  ' . $value['title'] . ' 
// </div>
// <!-- row-title -->
// <div class="row-icons">';
//         if ($value['file'] == '#') {
//             // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
//             //     echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" title="Delete"><i class="fas fa-trash"></i></a>';
//             // }
//             echo '</div>
//  <!-- row-icons -->
// </li>';
//         } else {
//             $link = explode(",", $value['file']);
//             $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
//             foreach ($link as $key => $val) {

//                 $downLink=base64_encode($val.":s:".date('d'));



//                 $ext = pathinfo($val, PATHINFO_EXTENSION);
//                 if (!in_array($ext, $allowed)) {
//                     if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
//                         echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';

// if ($ext == 'el') {
//                             echo '<a data-toggle="tooltip" title="Edit"  class="ablue" id="' . $id . '" onclick="txtform(this.id)"><i class="fas fa-edit"></i></a>';
//                         }




//     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

//         echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';






//                     }
//                     // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="eView/Download" target="_blank"><i class="fas fa-download"></i></a>';
//                 } else {
//                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
//                 }
//             }
//             // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
//             //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
//             // }
//             echo '</div>
// <!-- row-icons -->
// </li>';
//         }

        $id = base64_encode($value['id']);

        echo '<li class="blue">
                <div class="row-title">
                 ' . $value['title'] . ' 
                </div><div class="row-icons">';
            if($value['file'] != '#') {
                    $link = explode(",", $value['file']);
                    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
                        foreach ($link as $key => $val) {
                            if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                                continue;
                            }

                            $downLink=base64_encode($val.":s:".date('d'));



                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                if($_SESSION['userType']=='Trial')
                {} 
                elseif (!in_array($ext, $allowed)) {
                    if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                        if ($ext == 'el') {
                            echo '<a data-toggle="tooltip" title="Edit"  class="ablue" id="' . $id . '" onclick="txtform(this.id)"><i class="fas fa-edit"></i></a>';
                        } else {
                        //echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';

    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';


                        }
                    }
                    if ($ext == 'el') {

                        if ($value['extra_file'] != '') {
                            $ext_extra = pathinfo($value['extra_file'], PATHINFO_EXTENSION);
                            $downLink=base64_encode($value['extra_file'].":s:".date('d'));
                            if (!in_array($ext_extra, $allowed)) {
                                //  $this->dbF->prnt($value['extra_file']);
                                echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $value['extra_file'] . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($value['extra_file'], PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                            } else {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
                                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';

                            }
                        }
                    } else {
                        // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="cView/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                } else {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';

                }

                if($_GET['category']=='Compliance-Templates'){
                    $checkUser=$_SESSION['currentUser'];
                    $fileId=base64_decode($id);
                    $sqlCheck="SELECT * FROM `filesmanager` WHERE id='$fileId' AND assignto='$checkUser'";
                    $datacheck = $this->dbF->getRow($sqlCheck);
                    if ($this->dbF->rowCount > 0) {
                echo '<a class="ared" data-toggle="tooltip" title="Delete" id="'.$id.'" onclick="deleteuserCompliance(this)" ><i class="fas fa-trash"></i></a>';
                }
            }

            }
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    
    
}


public function resources_innner_ui($category,$sub_category, $user){
    // var_dump("jawwad");
    $user = intval($user);
    $sub_cat = "SELECT DISTINCT(`sub_sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `sub_category` = ? AND `sub_sub_category` != '' AND `publish` = '1' ORDER BY  sub_sub_category";
    $sub_cat_data = $this->dbF->getRows($sub_cat, array($sub_category));
    if($sub_cat_data){
        $all_size = "SELECT  COUNT(file) AS size FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ?  AND `sub_category` = '$sub_category'  AND `publish` = '1'";
        $all_size_data = $this->dbF->getRow($all_size, array($category));
        // var_dump($all_data);
        echo "<div class='left'>";
        
                echo " <div class='card inner active' data-id='all'>
                            <div class='card-top'>
                                <div class='name'>
                                    <h5>$sub_category</h5>
                                </div>
                            </div>
                            <div class='card_body'>
                                <div class='files'>
                                    <p>Files</p>
                                </div>
                            <div class='files_count'>
                                <p>$all_size_data[size]</p>
                            </div>
                        </div>
                    </div>";
                    
                    foreach($sub_cat_data as $key => $value){
                          $heading = $value['sub_sub_category'];
                          $cur_sub_cat_size = "SELECT  COUNT(file) AS size FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND  `sub_sub_category` = ? AND `publish` = '1' ORDER BY sub_sub_category";
                          $cur_sub_cat_size_data = $this->dbF->getRow($cur_sub_cat_size, array($category, $sub_category, $heading));
                        
                        echo " <div class='card inner' data-id='table_$key'>
                            <div class='card-top'>
                                <div class='name'>
                                    <h5>$value[sub_sub_category]</h5>
                                </div>
                            </div>
                            <div class='card_body'>
                                <div class='files'>
                                    <p>Files</p>
                                </div>
                            <div class='files_count'>
                                <p>$cur_sub_cat_size_data[size]</p>
                            </div>
                        </div>
                    </div>";
                    }
        echo "</div>";
        
        echo "<div class='right'>";
        
        $all = "SELECT  *  FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ?  AND `publish` = '1' ORDER BY title";
        $all_data = $this->dbF->getRows($all,array($category, $sub_category));
        
        $heading = $sub_category;
            // $sub_sub_cat = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `sub_category` = '$sub_category' AND `sub_sub_category` = '$heading' AND `publish` = '1' ORDER BY  sub_sub_category";
            // $sub_sub_cat_data = $this->dbF->getRows($sub_sub_cat);
            echo "<div class='table active main-row-down' id='all'>
                    <div class='heading'><h5>".$heading."</h5></div>
                     <ul>";
                        foreach($all_data as $key => $value){
                            // var_dump($value);
                            $this->create_row($value);
                        }
                echo "</ul>
                </div>";      
                        
        // }
        foreach($sub_cat_data as $key => $value){
            $heading = $value['sub_sub_category'];
            $sub_sub_cat = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND `sub_sub_category` = ? AND `publish` = '1' ORDER BY  title";
            $sub_sub_cat_data = $this->dbF->getRows($sub_sub_cat, array($category,$sub_category, $heading));
            //  <table>
            //             <thead>
            //                 <tr>
            //                     <th>Name</th>
            //                     <th>Action</th>
            //                 </tr>
            //             </thead>
            //             <tbody>
            echo "<div class='table main-row-down' id='table_$key'>
                    <div class='heading'><h5>".$heading."</h5></div>
        
                   <ul>";
                        foreach($sub_sub_cat_data as $key => $value){
                            // var_dump($value);
                            $this->create_row($value);
                        }
                // echo "</tbody>
                //     </table></div>";      
                echo "</ul></div>";
        }
        echo "</div>";
        
    }else{
        $sub_cat = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND `sub_sub_category` = '' AND `publish` = '1' ORDER BY  title";
        $sub_cat_data = $this->dbF->getRows($sub_cat, array($category, $sub_category));
        
        if($sub_cat_data){
            
            echo "<div class='table main-row-down'>
                    <div class='heading'><h5>".$sub_category."</h5></div>
                    <ul>";
                        foreach($sub_cat_data as $key => $value){
                            // var_dump($value);
                            $this->create_row($value);
                        }
                echo "</ul></div>";
            
            
        }else{
            echo "<div class = 'data_not-found'><h3>Data not found</h3></div>";
        }
    }

    
    // var_dump($sub_cat_data, $sub_cat);
}


public function safetyData($category, $user){  

$user=intval($user);
    if($_GET['category'] != 'Safety-Data'){
        echo "<div class = 'data_not-found'><h3>Data not found</h3></div>" ;
    }else{
        $sql1 = "SELECT DISTINCT(`sub_category`) FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `publish` = '1' ORDER BY sub_category ";
        $data1 = $this->dbF->getRows($sql1, array($category));
        if(!empty($data1)){
            foreach ($data1 as $key => $value1) {
            // var_dump($value1);
            $sql = "SELECT COUNT(`file`) AS file FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `sub_category`='$value1[sub_category]' AND `publish` = '1'";
            $data = $this->dbF->getRow($sql);
            $sqlInner = "SELECT title FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `sub_category`='$value1[sub_category]' AND `publish` = '1'";
            $dataInner = $this->dbF->getRows($sqlInner);
            // var_dump($dataInner);
            $dataInner2="";
            foreach ($dataInner as $key => $valueInner) {$dataInner2.=$valueInner['title'];}
            // $dataInner=implode(",",$dataInner[]);
            $link = WEB_URL."/safetyData?category=".$_GET['category'].
            "&sub_category=".$value1['sub_category'];
            echo " <div class='card'>
                    <a href='$link' >
                    <div class='card-top'>
                        <div class='name'>
                            <h5>$value1[sub_category] <span style='display:none'>$dataInner2</span></h5>
                        </div>
                    </div>
                    <div class='card_body'>
                        <div class='files'>
                            <p>Files</p>
                        </div>
                        <div class='files_count'>
                            <p>$data[file]</p>
                        </div>
                    </div>
                    </a>                   
                </div>";
        }
        ?>
                <!-- <div class="card">-->
                <!--    <a href="javascript:;" onclick="uploadsafetydata('<?php echo str_replace("-"," ",$_GET['category']);?>')">-->
                <!--    <div class="card-top">-->
                <!--    <div class="name" style="margin: 15%;text-align: center;">-->
                <!--    <h5><i class="fa fa-plus" aria-hidden="true"></i> Upload Template <span style="display:none">Add New Upload Template</span></h5>-->
                <!--    </div>-->
                <!--    </div>-->
                    
                <!--    </a>-->
                <!--</div>-->
        <?php
        }else{
            echo "<div class = 'data_not-found'><h3>Data not found</h3></div>";
        }
    }
        
}


public function create_row2($value){
    // var_dump($value);
    // $link = explode(",", $value['file']);
    // $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
    
    // echo "<tr>
    //         <td class='name'>
    //             <h5>".$value['title']."</h5>
    //         </td>
    //         <td>";        
            
    //         foreach ($link as $key => $val) {

    //             $downLink=base64_encode($val.":s:".date('d'));



    //             $ext = pathinfo($val, PATHINFO_EXTENSION);
    //             if (!in_array($ext, $allowed)) {
    //                 if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
    //                     echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';
    //                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                     echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';
    //                     }
    //                 // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="eView/Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                 }else {
    //                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
    //                 }
    //             }
    //             echo "</td></tr>";
    
    
    

//         $id = base64_encode($value['id']);
//         echo '<li class="blue">
// <div class="row-title">
//  ' . $value['title'] . ' 
// </div>
// <!-- row-title -->
// <div class="row-icons">';
//         if ($value['file'] == '#') {
//             // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
//             //     echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" title="Delete"><i class="fas fa-trash"></i></a>';
//             // }
//             echo '</div>
//  <!-- row-icons -->
// </li>';
//         } else {
//             $link = explode(",", $value['file']);
//             $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
//             foreach ($link as $key => $val) {

//                 $downLink=base64_encode($val.":s:".date('d'));



//                 $ext = pathinfo($val, PATHINFO_EXTENSION);
//                 if (!in_array($ext, $allowed)) {
//                     if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
//                         echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';

// if ($ext == 'el') {
//                             echo '<a data-toggle="tooltip" title="Edit"  class="ablue" id="' . $id . '" onclick="txtform(this.id)"><i class="fas fa-edit"></i></a>';
//                         }




//     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

//         echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';






//                     }
//                     // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="eView/Download" target="_blank"><i class="fas fa-download"></i></a>';
//                 } else {
//                     echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
//                 }
//             }
//             // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
//             //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
//             // }
//             echo '</div>
// <!-- row-icons -->
// </li>';
//         }

        $id = base64_encode($value['id']);

        echo '<li class="blue">
                <div class="row-title">
                 ' . $value['title'] . ' 
                </div><div class="row-icons">';
            if($value['file'] != '#') {
                    $link = explode(",", $value['file']);
                    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
                        foreach ($link as $key => $val) {
                            if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                                continue;
                            }

                            $downLink=base64_encode($val.":s:".date('d'));



                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                if($_SESSION['userType']=='Trial')
                {} 
                elseif (!in_array($ext, $allowed)) {
                    if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                        if ($ext == 'el') {
                            echo '<a data-toggle="tooltip" title="Edit"  class="ablue" id="' . $id . '" onclick="txtform(this.id)"><i class="fas fa-edit"></i></a>';
                        } else {
                        //echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" class="APIedit ablue" id="' . $val . '"><i class="fas fa-edit"></i></a>';

    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-eye"></i></a>';


                        }
                    }
                    if ($ext == 'el') {

                        if ($value['extra_file'] != '') {
                            $ext_extra = pathinfo($value['extra_file'], PATHINFO_EXTENSION);
                            $downLink=base64_encode($value['extra_file'].":s:".date('d'));
                            if (!in_array($ext_extra, $allowed)) {
                                //  $this->dbF->prnt($value['extra_file']);
                                echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $value['extra_file'] . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($value['extra_file'], PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                            } else {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
                                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';

                            }
                        }
                    } else {
                        // echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="cView/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                } else {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';

                }

                if($_GET['category']=='Safety-Data'){
                    $checkUser=$_SESSION['currentUser'];
                    $fileId=base64_decode($id);
                    $sqlCheck="SELECT * FROM `safetyData` WHERE id='$fileId' AND assignto='$checkUser'";
                    $datacheck = $this->dbF->getRow($sqlCheck);
                    if ($this->dbF->rowCount > 0) {
                echo '<a class="ared" data-toggle="tooltip" title="Delete" id="'.$id.'" onclick="deleteuserSafety(this)" ><i class="fas fa-trash"></i></a>';
                }
            }

            }
            // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full'){
            //      echo'<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="'.WEB_URL."/myuploads?id=".$id.'" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            // }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    
    
}


public function safety_innner_ui($category,$sub_category, $user){
    // var_dump("jawwad");
    $user = intval($user);
    $sub_cat = "SELECT DISTINCT(`sub_sub_category`) FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `sub_category` = ? AND `sub_sub_category` != '' AND `publish` = '1' ORDER BY  sub_sub_category";
    $sub_cat_data = $this->dbF->getRows($sub_cat, array($sub_category));
    if($sub_cat_data){
        $all_size = "SELECT  COUNT(file) AS size FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ?  AND `sub_category` = '$sub_category'  AND `publish` = '1'";
        $all_size_data = $this->dbF->getRow($all_size, array($category));
        // var_dump($all_data);
        echo "<div class='left'>";
        
                echo " <div class='card inner active' data-id='all'>
                            <div class='card-top'>
                                <div class='name'>
                                    <h5>$sub_category</h5>
                                </div>
                            </div>
                            <div class='card_body'>
                                <div class='files'>
                                    <p>Files</p>
                                </div>
                            <div class='files_count'>
                                <p>$all_size_data[size]</p>
                            </div>
                        </div>
                    </div>";
                    
                    foreach($sub_cat_data as $key => $value){
                          $heading = $value['sub_sub_category'];
                          $cur_sub_cat_size = "SELECT  COUNT(file) AS size FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND  `sub_sub_category` = ? AND `publish` = '1' ORDER BY sub_sub_category";
                          $cur_sub_cat_size_data = $this->dbF->getRow($cur_sub_cat_size, array($category, $sub_category, $heading));
                        
                        echo " <div class='card inner' data-id='table_$key'>
                            <div class='card-top'>
                                <div class='name'>
                                    <h5>$value[sub_sub_category]</h5>
                                </div>
                            </div>
                            <div class='card_body'>
                                <div class='files'>
                                    <p>Files</p>
                                </div>
                            <div class='files_count'>
                                <p>$cur_sub_cat_size_data[size]</p>
                            </div>
                        </div>
                    </div>";
                    }
        echo "</div>";
        
        echo "<div class='right'>";
        
        $all = "SELECT  *  FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ?  AND `publish` = '1' ORDER BY title";
        $all_data = $this->dbF->getRows($all,array($category, $sub_category));
        
        $heading = $sub_category;
            // $sub_sub_cat = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`='$category' AND `sub_category` = '$sub_category' AND `sub_sub_category` = '$heading' AND `publish` = '1' ORDER BY  sub_sub_category";
            // $sub_sub_cat_data = $this->dbF->getRows($sub_sub_cat);
            echo "<div class='table active main-row-down' id='all'>
                    <div class='heading'><h5>".$heading."</h5></div>
                     <ul>";
                        foreach($all_data as $key => $value){
                            // var_dump($value);
                            $this->create_row2($value);
                        }
                echo "</ul>
                </div>";      
                        
        // }
        foreach($sub_cat_data as $key => $value){
            $heading = $value['sub_sub_category'];
            $sub_sub_cat = "SELECT * FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND `sub_sub_category` = ? AND `publish` = '1' ORDER BY  title";
            $sub_sub_cat_data = $this->dbF->getRows($sub_sub_cat, array($category,$sub_category, $heading));
            //  <table>
            //             <thead>
            //                 <tr>
            //                     <th>Name</th>
            //                     <th>Action</th>
            //                 </tr>
            //             </thead>
            //             <tbody>
            echo "<div class='table main-row-down' id='table_$key'>
                    <div class='heading'><h5>".$heading."</h5></div>
        
                   <ul>";
                        foreach($sub_sub_cat_data as $key => $value){
                            // var_dump($value);
                            $this->create_row2($value);
                        }
                // echo "</tbody>
                //     </table></div>";      
                echo "</ul></div>";
        }
        echo "</div>";
        
    }else{
        $sub_cat = "SELECT * FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= ? AND `sub_category` = ? AND `sub_sub_category` = '' AND `publish` = '1' ORDER BY  title";
        $sub_cat_data = $this->dbF->getRows($sub_cat, array($category, $sub_category));
        
        if($sub_cat_data){
            
            echo "<div class='table main-row-down'>
                    <div class='heading'><h5>".$sub_category."</h5></div>
                    <ul>";
                        foreach($sub_cat_data as $key => $value){
                            // var_dump($value);
                            $this->create_row2($value);
                        }
                echo "</ul></div>";
            
            
        }else{
            echo "<div class = 'data_not-found'><h3>Data not found</h3></div>";
        }
    }

    
    // var_dump($sub_cat_data, $sub_cat);
}


public function health_check($id)
{
$sql = "SELECT `health_form` FROM `accounts_user` WHERE acc_id = ? ";
$data = $this->dbF->getRow($sql,array($id));
if ($data[0] == '0') {
return true;
} else {
return false;
}
}

public function user_check($id)
{
$sql = "SELECT `acc_action` FROM `accounts_user` WHERE acc_id = ? ";
$data = $this->dbF->getRow($sql,array($id));
if ($data[0] == '0') {
return true;
} else {
return false;
}
}

public function practice_profile($id)
{
$sql = "SELECT * from `practiceprofile` WHERE `user_id` = ? AND `practice_name` != '' AND `practice_address` != '' AND `telephone` != '' AND `staff` != '' AND `information` != '' AND `surgeries` != '' AND `room` != '' AND `autoclave` != '' AND `disinfectors` != '' AND `ultrasonic` != '' AND `compressor` != '' AND `npm` != '' AND `sedation` != '' AND `domiciliary` != ''";
$data = $this->dbF->getRow($sql, array($id));
if (empty($data[0])) {
return true;
} else {
return false;
}
}

public function submitmyuploadsedit()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('myUploadsedit')) {
return false;
}
$getID          = empty($_POST['editid']) ? "" : $_POST['editid'];
$title          = empty($_POST['title'])     ? ""    : $_POST['title'];
$category       = empty($_POST['category'])  ? ""    : $_POST['category'];
$sub_category   = empty($_POST['sub_category'])  ? ""    : $_POST['sub_category'];


$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");

$title          =str_replace($strip, " ", $title);
$category       =str_replace($strip, " ", $category);
$sub_category   =str_replace($strip, " ", $sub_category);





if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
}


try {

$sql  = "UPDATE `myuploads` SET 
            `title` = ?,
           `category`= ?,
           `sub_category` = ?
    WHERE `id` = '$getID'";

$array   = array($title, $category, $sub_category);
	$this->dbF->setRow($sql, $array, false);
if ($this->dbF->rowCount > 0) {
$this->setlog("MyUpload Update", $this->UserName($user) . " : " . $user, "");
return true;
} else {
return false;
}
} catch (Exception $e) {

$this->dbF->error_submit($e);
return false;
}
} // If end

}



    
 
// ali bhai   


public function  viewClientsData($dataType)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
    $user = intval($_SESSION['superid']);

 $sql3 = "SELECT  * FROM `clientAddTbl` WHERE  `userAssign` ='$user' and `dataType` ='$dataType'  

ORDER BY `clientAddTbl`.`sort` DESC

--  ORDER BY CASE WHEN cs = 'On Sales'
-- THEN '1'
--                                 WHEN cs = 'On Demo'  THEN '2'
--                                 WHEN cs = 'Pending Work'  THEN '3'
--                                 WHEN cs = 'Not Started'  THEN '4'
--                                 WHEN cs = 'Live Onboard'  THEN '5'
--                                 WHEN cs = 'Deferred'  THEN '6'
--                                 WHEN cs = 'Canceled'  THEN '7'
--                                 ELSE cs END ORDER BY `clientAddTbl`.`sort` DESC


                                ";

} else {
$user = intval($_SESSION['currentUser']);
$sql3 = "SELECT  * FROM `clientAddTbl` WHERE `loginid`='$user' and `dataType` ='$dataType'

ORDER BY `clientAddTbl`.`sort` DESC
 -- ORDER BY CASE WHEN cs = 'On Sales'  THEN '1'
 --                                WHEN cs = 'On Demo'  THEN '2'
 --                                WHEN cs = 'Pending Work'  THEN '3'
 --                                WHEN cs = 'Not Started'  THEN '4'
 --                                WHEN cs = 'Live Onboard'  THEN '5'
 --                                WHEN cs = 'Deferred'  THEN '6'
 --                                WHEN cs = 'Canceled'  THEN '7'
 --                                ELSE cs END ASC


                                ";
}


$mysql = $this->dbF->getRows($sql3);


echo "<div class='main-row' style='width:100%'>";
echo "<div class='main-row-top' style='background-color:black;'>
<div class='threeDivs'>
<div class='infoDivClass'>Name:</div>
<div class='infoDivClass'>Business Name:</div>
<div class='infoDivClass'>Manager Name:</div>
</div>
<div class='threeDivs' style='width:20%'>
<div class='infoDivClass'>Email:</div>
<div class='infoDivClass'>Phone:</div>
<div class='infoDivClass'>Mobile:</div>
<div class='infoDivClass'>DOB:</div>
<div class='infoDivClass'>Assigned to:</div>
</div>



<div class='onedivs' style='width: 13%;'><div class='infoDivClass'>Address:</div></div>
<div class='onedivs'><div class='infoDivClass'>Service/Plan:</div></div>
<div class='onedivs' style='width: 17%;'><div class='infoDivClass'>Other Details:</div></div>
<div class='unlimitedDivs' style='width: 19%;'><div class='infoDivClass'>Notes:</div></div>
<div class='onedivs'><div class='infoDivClass'>Client Status:</div></div>
<div class='actionDiv'><div class='infoDivClass'>Action:</div></div>";
echo"</div>";
echo"</div>";


foreach ($mysql as $key1 => $value1) {
echo "<div class='main-row div" . ($value1['id']) . "' style='width:100%'>

<div class='main-row-top removeKeyPress' style='background-color:" . ($value1['color']) . "'>

<div class='threeDivs'>
<div class='infoDivClass' data-toggle='tooltip' title='Name:'>" . ($value1['name']) . "</div>
<div class='infoDivClass' data-toggle='tooltip' title='Business Name:'>" .$value1['business_name'] . "</div>
<div class='infoDivClass' data-toggle='tooltip' title='Manager Name:'>" .$value1['manager_name'] . "</div>
</div>



<div class='threeDivs' style='width: 20%;'>
<div class='infoDivClass' data-toggle='tooltip' title='Email:'>" .$value1['email'] . "</div>
<div class='infoDivClass'  data-toggle='tooltip' title='Phone:'>" .$value1['phone'] . "</div>
<div class='infoDivClass'  data-toggle='tooltip' title='Mobile:'>" .$value1['mobile'] . "</div>
<div class='infoDivClass'  data-toggle='tooltip' title='DOB:'>" .$value1['dob'] . "</div>

<div class='infoDivClass' data-toggle='tooltip' title='Assigned to:'>" .$this->UserName($value1['userAssign']) . "</div>
</div>








<div class='onedivs' style='width: 13%;'><div class='infoDivClass' data-toggle='tooltip' title='Address:'>" .$value1['address'] . "</div></div>


<div class='onedivs'><div class='infoDivClass' data-toggle='tooltip' title='Service/Plan:'>" .$value1['userService'] . "</div></div>
<div class='onedivs' style='width: 17%;'><div class='infoDivClass' data-toggle='tooltip' title='Other Details:'>" .$value1['otherDetail'] . "</div></div>
";



echo "<div class='unlimitedDivs' style='width: 19%;'><div class='infoDivClass'  data-toggle='tooltip' title='Notes:'>";
$sql3clientCreateNotes = "SELECT  * FROM `clientCreateNotes` WHERE `fid`='$value1[id]'";
$mysqlvariable = $this->dbF->getRows($sql3clientCreateNotes);
foreach ($mysqlvariable as $keymysqlvariable => $valuemysqlvariable) {

    @$thisID = $valuemysqlvariable['id'] .":".$value1['id'];



echo "<div class='notesLi'>
<div class='row-title'>
<a class='ablue' onclick='addnotescomments(this.id)' id=".$thisID." data-toggle='tooltip' title='Add/View Note Comments'><b>
" .$valuemysqlvariable['heading'] . "</b>
&nbsp;
<span class='row-icons' style='display:contents'>";
$sql3clientCreateNotes1 = "SELECT * FROM `clientCreateNotes_comments` WHERE `fid`='$valuemysqlvariable[id]' ORDER BY `clientCreateNotes_comments`.`id` DESC";
$mysqlvariable1 = $this->dbF->getRow($sql3clientCreateNotes1);



$string = ($mysqlvariable1['heading']);


if (strlen($string) > 82) {
$stringCut = substr($mysqlvariable1['heading'], 0, 82);
$endPoint = strrpos($stringCut, ' ');
//if the string doesn't contain any space then it will cut without word basis.
$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
$string .= '...';
}

if ($this->dbF->rowCount > 0) {
echo "<p class='client_com' style='display:contents'>(".$string." on ".date('d-M-Y H:i', strtotime($mysqlvariable1['dateTime'])).")</p>";
}
echo '
</span>





</a></div>
';



echo '</div>';
}
echo "</div></div>";



echo '<div class="onedivs"><div class="infoDivClass" data-toggle="tooltip" title="Client Status:">' .$value1['cs'] .'</div></div><div class="actionDiv"><div class="infoDivClass"><a class="ablue" onclick="addClient(this.id)" id="' . $value1['id'] . '" data-toggle="tooltip" title="Edit Client"><i class="fas fa-user"></i></a><a id="' . $value1['id'] . '" onclick="AjaxDelScript(this.id)"  data-toggle="tooltip" title="Delete Client"><i class="glyphicon glyphicon-trash trash fa fa-trash" ></i><i class="fa fa-refresh waiting fa-spin fa fa-spinner" style="display: none"></i></a>';




echo '<a class="ablue" onclick="addnotes(this.id)" id="' . $value1['id'] . '" data-toggle="tooltip" title="Add New Notes"><i class="fas fa-clipboard"></i></a>';

echo '<a class="ablue" onclick="changeColor(this.id)" id="' . $value1['id'] . '" data-toggle="tooltip" title="Change Color"><i class="fas fa-paint-brush"></i></a>';


echo '<a class="ablue" onclick="changeStatus(this.id)" id="' . $value1['id'] . '" data-toggle="tooltip" title="Change Status"><i class="fas fa-sync-alt"></i></a>';





echo"</div>
</div>
</div>
<!-- main-row-top -->";
echo "</div><!-- main-row -->";
}
}



public function clientAddTbl_all_users_services()
{
// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
// $user = intval($_SESSION['superid']);
// } else {
// $user = intval($_SESSION['currentUser']);
// }
$sql = "SELECT DISTINCT(`userService`) FROM `clientAddTbl`  WHERE loginid = ? ";
$tempUser = $_SESSION['currentUser']; 

$data2 = $this->dbF->getRows($sql, array($tempUser));


$cate = "<option value='all'>Search By Service/Plan</option><option value='all'>All</option>";
foreach ($data2 as $key => $value) {
$cate .= "<option value='" . $value['userService'] . "'>" . $value['userService'] . "</option>";
}
return $cate;
}
public function pProductSearchOPTION_location()
{
// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
// $user = intval($_SESSION['superid']);
// } else {
// $user = intval($_SESSION['currentUser']);
// }
// $sql = "SELECT DISTINCT(`loginid`) FROM `clientAddTbl` WHERE loginid = '$_SESSION[currentUser]'";

$user = intval($_SESSION['currentUser']);
$users = intval($_SESSION['webUser']['id']);


$sql = "SELECT * FROM `product_inventory`   WHERE `qty_store_id`='$user' OR `qty_store_id`='$users' and `location` !='' group by location";


$data2 = $this->dbF->getRows($sql);


$cate = "<option value='all'>Search By Location </option><option value='all'>All</option>";
foreach ($data2 as $key => $value) {
$cate .= "<option value='" . $value['location'] . "'>" . $value['location'] . "</option>";
}
return $cate;
}

public function pProductSearchOPTION()
{
// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
// $user = intval($_SESSION['superid']);
// } else {
// $user = intval($_SESSION['currentUser']);
// }
// $sql = "SELECT DISTINCT(`loginid`) FROM `clientAddTbl` WHERE loginid = '$_SESSION[currentUser]'";

$user = intval($_SESSION['currentUser']);

$users = intval($_SESSION['webUser']['id']);

$sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' OR `qty_store_id`='$users' group by qty_product_id"; //


$data2 = $this->dbF->getRows($sql);


$cate = "<option value='all'>Search By Product</option><option value='all'>All</option>";
foreach ($data2 as $key => $value) {
$cate .= "<option value='" . $this->getProductFullNameWeb( $value['qty_product_id'], $value['qty_product_scale'], $value['qty_product_color'] ) . "'>" . $this->getProductFullNameWeb( $value['qty_product_id'], $value['qty_product_scale'], $value['qty_product_color'] ) . "</option>";
}
return $cate;
}

public function clientAddTbl_all_users()
{
// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
// $user = intval($_SESSION['superid']);
// } else {
// $user = intval($_SESSION['currentUser']);
// }
$sql = "SELECT DISTINCT(`loginid`) FROM `clientAddTbl` WHERE loginid =  ? ";
$tempUser =intval($_SESSION['currentUser']) ;

$data2 = $this->dbF->getRows($sql, array($tempUser));


$cate = "<option value='all'>Search By User</option><option value='all'>All</option>";
foreach ($data2 as $key => $value) {
$cate .= "<option value='" . $value['loginid'] . "'>" . $this->UserName($value['loginid']) . "</option>";
}
return $cate;
}


public function submitclientstatus()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('clientstatus')) {
return false;
}
$dataType      = empty($_POST['dataType'])     ? ""    : htmlspecialchars($_POST['dataType']);
$loginid      = empty($_POST['loginid'])     ? ""    : htmlspecialchars($_POST['loginid']);
$name      = empty($_POST['name'])     ? ""    : htmlspecialchars($_POST['name']);
$business_name      = empty($_POST['business_name'])     ? ""    : htmlspecialchars($_POST['business_name']);
$manager_name      = empty($_POST['manager_name'])     ? ""    : htmlspecialchars($_POST['manager_name']);
$email      = empty($_POST['email'])     ? ""    : htmlspecialchars($_POST['email']);
$phone      = empty($_POST['phone'])     ? ""    : htmlspecialchars($_POST['phone']);
$mobile      = empty($_POST['mobile'])     ? ""    : htmlspecialchars($_POST['mobile']);
$address      = empty($_POST['address'])     ? ""    : htmlspecialchars($_POST['address']);
$dob      = empty($_POST['dob'])     ? ""    : htmlspecialchars($_POST['dob']);
$userService      = empty($_POST['userService'])     ? ""    : htmlspecialchars($_POST['userService']);
$otherDetail      = empty($_POST['otherDetail'])     ? ""    : htmlspecialchars($_POST['otherDetail']);
$userAssign      = empty($_POST['userAssign'])     ? ""    : htmlspecialchars($_POST['userAssign']);
$color      = empty($_POST['color'])     ? ""    : htmlspecialchars($_POST['color']);
$cs      = empty($_POST['cs'])     ? ""    : htmlspecialchars($_POST['cs']);
if($userService == "Other"){
$userService      = empty($_POST['userService1'])     ? ""    : htmlspecialchars($_POST['userService1']);
}else{
$userService      = empty($_POST['userService'])     ? ""    : htmlspecialchars($_POST['userService']);
}
try {
$this->db->beginTransaction();
$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;
$sql      =   "INSERT INTO `clientAddTbl`(`loginid`,`name`,`business_name`,`manager_name`,`email`,`phone`,`address`,`dob`,`userService`,`otherDetail`,`userAssign`,`color`,`mobile`,`cs`,`dataType`,`sort`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($loginid, $name, $business_name, $manager_name, $email, $phone, $address, $dob, $userService, $otherDetail, $userAssign, $color, $mobile, $cs, $dataType, $maxSort);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}
if($cs=="Hot lead From Show"){
    
$this->setlog("Client Add In Show", $this->UserName($user) . " : " . $user, $lastId, $name);
$msg="<div style='text-align:center;'><img src='https://smartdentalcompliance.com/images/show.jpg' /></div><br><br>
<div style='font-size:16px;'>Dear $name !<br><br><br>Thank you so much for visiting our stand today. We hope you enjoyed talking to our consultant. Here is a 20% off the All In One Management Software code which you can use within the next 60 days to sign up to our software. <br><br>
<div style='text-align:center;'><a style='font-size:36px color:#1B9EAC;' href='https://smartdentalcompliance.com/index.php?id=TVRJPTo6Ojo6OmJiODY2Y2U5NTAwNDU2MDU5YjE3YzQyYzAwYTE2ZGMx'>Sign Up Now And Get Discount</a></div>
<br><br>
Once you have signed up to the software, our consultants would be in touch to book an onboarding call with yourself and team training on using the system. <br><br>
<hr><br><br>
<div style='text-align:center;'>www.smartdentalcompliance.com</div>
<br><br>
</div>
";
$this->send_mail($email, "Smart Dental Compliance 20% Voucher", $msg);
}else{
$this->setlog("Client Add", $this->UserName($user) . " : " . $user, $lastId, $name);
}
$this->db->commit();
if ($this->dbF->rowCount > 0) {
if($cs=="Hot lead From Show"){
    $msg=base64_encode($name."::".$business_name."::".$manager_name."  ADDED !");
    header("location:client-statusform_show?msg=$msg");
}else{
return true;
}
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}











public function clientstatusedit()
{


if (!$this->getFormToken('clientstatusedit')) {
return false;
}


$editid      = empty($_POST['editid'])     ? ""    : htmlspecialchars($_POST['editid']);
$loginid      = empty($_POST['loginid'])     ? ""    : htmlspecialchars($_POST['loginid']);
$name      = empty($_POST['name'])     ? ""    : htmlspecialchars($_POST['name']);
$business_name      = empty($_POST['business_name'])     ? ""    : htmlspecialchars($_POST['business_name']);
$manager_name      = empty($_POST['manager_name'])     ? ""    : htmlspecialchars($_POST['manager_name']);
$email      = empty($_POST['email'])     ? ""    : htmlspecialchars($_POST['email']);
$phone      = empty($_POST['phone'])     ? ""    : htmlspecialchars($_POST['phone']);
$mobile      = empty($_POST['mobile'])     ? ""    : htmlspecialchars($_POST['mobile']);
$address      = empty($_POST['address'])     ? ""    : htmlspecialchars($_POST['address']);
$dob      = empty($_POST['dob'])     ? ""    : htmlspecialchars($_POST['dob']);
$userService      = empty($_POST['userService'])     ? ""    : htmlspecialchars($_POST['userService']);
$otherDetail      = empty($_POST['otherDetail'])     ? ""    : htmlspecialchars($_POST['otherDetail']);
$userAssign      = empty($_POST['userAssign'])     ? ""    : htmlspecialchars($_POST['userAssign']);
$color      = empty($_POST['color'])     ? ""    : htmlspecialchars($_POST['color']);
$cs      = empty($_POST['cs'])     ? ""    : htmlspecialchars($_POST['cs']);
if($userService == "Other"){
$userService      = empty($_POST['userService1'])     ? ""    : htmlspecialchars($_POST['userService1']);
}else{
$userService      = empty($_POST['userService'])     ? ""    : htmlspecialchars($_POST['userService']);

}
$dataType      = empty($_POST['dataType'])     ? ""    : intval($_POST['dataType']);







try {
$this->db->beginTransaction();



$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;





$sql  = "UPDATE `clientAddTbl` SET `name`=?,`business_name`=?,`manager_name`=?,`email`=?,`phone`=?,`address`=?,`dob`=?,`userService`=?,`otherDetail`=?,`userAssign`=?,`color`=?,`mobile`=? ,`cs`=?,`dataType`=?, `sort` = '$maxSort' WHERE `id`='$editid'";







$array   = array($name,$business_name,$manager_name,$email,$phone,$address,$dob,$userService,$otherDetail,$userAssign,$color,@$mobile,@$cs,@$dataType);
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Client Update", $this->UserName($loginid) . " : " . $loginid, $editid, $name);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}


}

public function setReminder($assignto, $type, $edit_id ){
	$hasreminder = date('Y-m-d');
    $allus = @$assignto;
    $typeName = $type;
    $start_date = date('Y-m-d', strtotime($hasreminder));
    $date = strtotime($start_date);
    $date = strtotime("+7 day", $date);
    $Event_one_week_date = date('Y-m-d', $date);
    if($assignto > 0 && $edit_id > 0){
    $sql = "INSERT INTO `cronData`(`user`,`type`,`event_Id`,`event_Date`)VALUES(?,?,?,?)";
    $arr = array($assignto,$typeName,$edit_id,$Event_one_week_date);
    $this->dbF->setRow($sql,$arr);
    }
    // else{
    //     $to = "jawwad@im.com.pk";
    //     $sub = "Assignto is 0 from set_reminder function";
    //     $msg = "Session => ". serialize($_SESSION) .' POST => '.serialize($_POST).' GET => '.serialize($_GET);
    //     mail($to, $sub, $msg);
    // }
    // var_dump($sql);
}







public function addReminder($apiPostData = "")
{
if (!empty($apiPostData)) {
    $_POST = $apiPostData;
}
if (isset($_POST['submit'])) {
if (!$this->getFormToken('addReminder') && $apiPostData == "") {
return false;
}


$usertmp = intval($_SESSION['currentUser']);
$ttitle      = empty($_POST['ttitle'])     ? ""    : htmlspecialchars($_POST['ttitle']);
$ffromdate      = empty($_POST['ffromdate'])     ? ""    : $_POST['ffromdate'];
 $ffromdate = date("Y-m-d", strtotime($ffromdate)); 
$ttodate      = empty($_POST['ttodate'])     ? ""    : $_POST['ttodate'];
 $ttodate = date("Y-m-d", strtotime($ttodate));  

try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `practiceaddreminder`(`pid`,`ttitle`,`ffromdate`,`ttodate`) VALUES (?,?,?,?)";
$array   = array($usertmp, $ttitle, $ffromdate, $ttodate);
$this->dbF->setRow($sql, $array, false);
 $lastId = $this->dbF->rowLastId;

$array   =serialize($array);


$this->setlog("Reminder is added", $this->UserName($usertmp) . " : " . $usertmp, $lastId, $array);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}





public function changeStatus()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('changeStatus')) {
return false;
}


// $userID      = empty($_POST['userID'])     ? ""    : $_POST['userID'];
$cs      = empty($_POST['cs'])     ? ""    : htmlspecialchars($_POST['cs']);
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];

try {
$this->db->beginTransaction();
// $sql      =   "INSERT INTO `clientCreateNotes`(`fid`,`userID`,`heading`) VALUES (?,?,?)";
// $array   = array($refId, $userID, $titlenotes);
// $this->dbF->setRow($sql, $array, false);
// if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
// }

$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;

$sql = "UPDATE `clientAddTbl` SET `cs` = ? , `sort` = ? WHERE `clientAddTbl`.`id` = ? ";
$this->dbF->setRow($sql, array($cs, $maxSort, $refId));





$this->setlog("Status is changed", $this->UserName($user) . " : " . $user, $refId, $cs);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function changeColor()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('changeColor')) {
return false;
}


// $userID      = empty($_POST['userID'])     ? ""    : $_POST['userID'];
$changeColor      = empty($_POST['changeColor'])     ? ""    : $_POST['changeColor'];
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];

try {
$this->db->beginTransaction();
// $sql      =   "INSERT INTO `clientCreateNotes`(`fid`,`userID`,`heading`) VALUES (?,?,?)";
// $array   = array($refId, $userID, $titlenotes);
// $this->dbF->setRow($sql, $array, false);
// if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
// }



$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;


$sql = "UPDATE `clientAddTbl` SET `color` = '$changeColor' , `sort` = '$maxSort' WHERE `clientAddTbl`.`id` = '$refId'";
$this->dbF->setRow($sql);





$this->setlog("Color is changed", $this->UserName($user) . " : " . $user, $refId, $changeColor);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function addnotesTitle()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('addnotesTitle')) {
return false;
}


$userID      = empty($_POST['userID'])     ? ""    : $_POST['userID'];
$titlenotes      = empty($_POST['titlenotes'])     ? ""    : htmlspecialchars($_POST['titlenotes']);
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];

try {
$this->db->beginTransaction();










$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;


$sql = "UPDATE `clientAddTbl` SET  `sort` =  ?  WHERE `clientAddTbl`.`id` = ? ";
$this->dbF->setRow($sql, array($maxSort, $refId));





$sql      =   "INSERT INTO `clientCreateNotes`(`fid`,`userID`,`heading`) VALUES (?,?,?)";
$array   = array($refId, $userID, $titlenotes);
$this->dbF->setRow($sql, $array, false);
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }
$lastId = $this->dbF->rowLastId;
$this->setlog("Note created", $this->UserName($user) . " : " . $userID,$lastId, $titlenotes);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}


public function addnotescomments()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('addnotescomments')) {
return false;
}


$mainId      = empty($_POST['mainId'])     ? ""    : $_POST['mainId'];
$userID      = empty($_POST['userID'])     ? ""    : $_POST['userID'];
$title      = empty($_POST['title'])     ? ""    : htmlspecialchars($_POST['title']);
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];
$comm1      = empty($_POST['comm1'])     ? ""    : htmlspecialchars($_POST['comm1']);
$comm2      = empty($_POST['comm2'])     ? ""    : $_POST['comm2'];

try {
$this->db->beginTransaction();

$q = "SELECT heading FROM clientCreateNotes WHERE heading= ? AND id= ? ";
$this->dbF->getRow($q, array($title, $refId));
if ($this->dbF->rowCount == 0) {




$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;


$sql = "UPDATE `clientAddTbl` SET  `sort` = ? WHERE `clientAddTbl`.`id` = ? ";
$this->dbF->setRow($sql, array($maxSort, $mainId));




$sql = "UPDATE `clientCreateNotes` SET `heading` = ? WHERE `clientCreateNotes`.`id` = ? ";
$this->dbF->setRow($sql, array($title, $refId));


$this->setlog("Note title updated", $this->UserName($userID) . " : " . $userID, $refId, $title);

}


if ($comm1 != "") {




$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;


$sql = "UPDATE `clientAddTbl` SET  `sort` = ? WHERE `clientAddTbl`.`id` = ? ";
$this->dbF->setRow($sql, array($maxSort, $mainId));



$sql      =   "INSERT INTO `clientCreateNotes_comments`(`fid`,`userID`,`heading`) VALUES (?,?,?)";
$array   = array($refId, $userID, $comm1);
$this->dbF->setRow($sql, $array, false);
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }

$lastId = $this->dbF->rowLastId;
$this->setlog("Note comment Added", $this->UserName($userID) . " : " . $userID,$lastId, $comm1);

}

if ($comm2 != "") {




$sqlmax = "SELECT MAX(sort) AS larger FROM clientAddTbl";
$datamax = $this->dbF->getRow($sqlmax);
$maxSort = $datamax['larger']+1;


$sql = "UPDATE `clientAddTbl` SET  `sort` = ? WHERE `clientAddTbl`.`id` = ? ";
$this->dbF->setRow($sql, array($maxSort, $mainId));



$sql      =   "INSERT INTO `clientCreateNotes_comments`(`fid`,`userID`,`heading`) VALUES (?,?,?)";
$array   = array($refId, $userID, $comm2);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }
$this->setlog("Note comment Added", $this->UserName($userID) . " : " . $userID,$lastId, $comm2);

}





$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

// ali bhai  complete
   

public function submitmyuploads()
{

if (isset($_POST['submit'])) {
// if (!$this->getFormToken('myUploads')) {
// return false;
// }
// $title          = empty($_POST['title'])     ? ""    : $_POST['title'];
// $category       = empty($_POST['category'])  ? ""    : $_POST['category'];
// $sub_category   = empty($_POST['sub_category'])  ? ""    : $_POST['sub_category'];
// $dchk           = empty($_POST['dchk'])      ? ""    : $_POST['dchk'];
// $dcategory      = empty($_POST['dcategory']) ? ""    : $_POST['dcategory'];
// $sub_dcategory  = empty($_POST['sub_dcategory']) ? ""    : $_POST['sub_dcategory'];
// $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
//         "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
//         "â€”", "â€“", ",", "<", ">", "/", "?");
// $title          = str_replace($strip," " ,$title);          
// $category       = str_replace($strip," " ,$category);       
// $sub_category   = str_replace($strip," " ,$sub_category);   
// $dchk           = str_replace($strip," " ,$dchk);           
// $dcategory      = str_replace($strip," " ,$dcategory);      
// $sub_dcategory  = str_replace($strip," " ,$sub_dcategory);  
//below for file upload
if(isset($_POST['myUploadsTokens'])){
// $this->dbF->prnt($_POST);
// $this->dbF->prnt($_FILES);
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$filename = pathinfo($title, PATHINFO_FILENAME);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename);          
$category       = str_replace($strip," " ,$category); 
}else{
if (!$this->getFormToken('myUploads')) {
return false;
}

$title          = empty($_POST['title'])     ? ""    : htmlspecialchars($_POST['title']);
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$dchk           = empty($_POST['dchk'])      ? ""    : htmlspecialchars($_POST['dchk']);
$dcategory      = empty($_POST['dcategory']) ? ""    : htmlspecialchars($_POST['dcategory']);
$sub_dcategory  = empty($_POST['sub_dcategory']) ? ""    : htmlspecialchars($_POST['sub_dcategory']);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$title);          
$category       = str_replace($strip," " ,$category);       
$sub_category   = str_replace($strip," " ,$sub_category);   
$dchk           = str_replace($strip," " ,$dchk);           
$dcategory      = str_replace($strip," " ,$dcategory);      
$sub_dcategory  = str_replace($strip," " ,$sub_dcategory); 
}





if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = $_SESSION['superid'];
$userId = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
$userId = "all:" . $_SESSION['currentUser'];
}

$filename = $this->uploadSingleFile($_FILES['document'], 'files', '');
$imageUrlChange = '';

try {
$this->db->beginTransaction();

if (isset($_POST['practiceIds']) && !empty($_POST['practiceIds']))  {
    $practiceIds = $_POST['practiceIds'];
    // $practiceIds = explode(',',$practiceIds);
    $explodeUrl = explode('/',$filename);
    $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
    foreach ($practiceIds as $key => $ids) {
             $user = $ids;                          
             $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
             if (strpos(WEB_URL,'alpha')) {
                $webUrl = $_SERVER['DOCUMENT_ROOT']."/alpha";    
             }else{
                $webUrl = $_SERVER['DOCUMENT_ROOT'];
             }                         
             $uploadedImage = $webUrl."/images/".$filename;
             $copyImage  = $webUrl."/images/".$imageUrlChange;                         
             if ($key == 0) {
                 $docname = WEB_URL."/images/".$filename;
                 $staffFile =  WEB_URL."/images/".$filename;
             }else{
                 
                 
                 // copy($uploadedImage, $copyImage);
                 file_put_contents($copyImage, file_get_contents($uploadedImage));
                 $docname =  WEB_URL."/images/".$imageUrlChange;
                 $staffFile =  WEB_URL."/images/".$imageUrlChange;
                 // return $uploadedImage.'---'.$copyImage."---".$docname;
             }
            $sql      = "INSERT INTO `myuploads`(`title`,`file`,`category`,`sub_category`,`user`,publish) VALUES (?,?,?,?,?,?)";
            $array   = array($title, $docname, $category, $sub_category, $user, '1');
            $this->dbF->setRow($sql, $array, false);
            if ($dchk == '1') {

                $sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                                VALUES (?,?,?,?,?,?)";
                $array   = array($title, $staffFile, $user, $dcategory, $sub_dcategory, '1');
                $this->dbF->setRow($sql, $array, false);
            }
       }   
}else{
    if ($dchk == '1') {
        
     $explodeUrl = explode('/',$filename);
     $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
     $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
     $uploadedImage = "./images/".$filename;
     $copyImage  = "./images/".$imageUrlChange;
     copy($uploadedImage, $copyImage);
}

$docname = '';
$staffFile = '';
if($filename==false) {
$docname .= '#';
$staffFile =  "#";
}else{
$docname .= WEB_URL . "/images/".$filename;
$staffFile =  WEB_URL."/images/".$imageUrlChange;
}

$sql     = "INSERT INTO `myuploads`(`title`,`file`,`category`,`sub_category`,`user`,publish) VALUES (?,?,?,?,?,?)";
$array   = array($title, $docname, $category, $sub_category, $user, '1');
$this->dbF->setRow($sql, $array, false);

if ($dchk == '1') {
$sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                VALUES (?,?,?,?,?,?)";
$array   = array($title, $staffFile, $userId, $dcategory, $sub_dcategory, '1');
$this->dbF->setRow($sql, $array, false);
}

}


if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}
$this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, "", $title);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}



public function submitfiletxt()
{


        if (isset($_POST['title'])) {
            if (!$this->getFormToken('filetxt')) {
                return false;
            }
            // $this->dbF->prnt($_POST); 
            $filename = '';
            $staffFile = '';
            $title      = empty($_POST['title'])     ? ""    : $_POST['title'];
            $category   = empty($_POST['category'])  ? ""    : $_POST['category'];
            $ytcode   = empty($_POST['ytcode'])  ? ""    : $_POST['ytcode'];
            $sub_category   = empty($_POST['sub_category'])  ? ""    : $_POST['sub_category'];
            $dchk       = empty($_POST['dchk'])      ? ""    : $_POST['dchk'];
            $dcategory  = empty($_POST['dcategory']) ? ""    : $_POST['dcategory'];
            $sub_dcategory  = empty($_POST['sub_dcategory']) ? ""    : $_POST['sub_dcategory'];
            $url        = empty($_POST['url'])       ? ""    : $_POST['url'];
            $file       = empty($_POST['file'])      ? ""    : $_POST['file'];

            $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                    "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                    "â€”", "â€“", ",", "<", ">", "/", "?");

            $title          =str_replace($strip, " ", $title);
            $category       =str_replace($strip, " ", $category);
            $sub_category   =str_replace($strip, " ", $sub_category);

            // htmlspecialchars($title);
            // htmlspecialchars($category);
            // htmlspecialchars($sub_category);
            // htmlspecialchars($dchk);
            // htmlspecialchars($dcategory);
            // htmlspecialchars($sub_dcategory); 

            $search = array(',', '.', ' ', '\"', '\'','&','$','`');
            $filetitle = str_replace($search, '', $title);
            //  $search = array(',', '\"', '\'','&','$','`');
            // $title = str_replace($search, '', $title);
              
            $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/resources/" . $filetitle . ".el";
            $filename = $this->uploadDocstxt($_POST['myname'], 'files', $path);
            // $filename = WEB_URL . "/images/" . $filename;

            // $docname = '';
            //     if ($_POST['myname'] !='') {


            // echo  $path = $_SERVER['DOCUMENT_ROOT'] . "/new/uploads/files/resources/userdocument/smartDoc".str_replace(' ', '', $title).".el";
            //   $savepath = WEB_URL . "/uploads/files/resources/userdocument/smartDoc".str_replace(' ', '', $title).".el";
            //          $content = $_POST['myname'];
            //         $fp = fopen($path,"x+");
            //        fwrite($fp,$content);
            //            $file   =  $savepath;
            //        fclose($fp);
            //    }
            if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
                $user = $_SESSION['superid'];
                $userId = $_SESSION['superid'];
            } else {
                $user = $_SESSION['currentUser'];
                $userId = "all:" . $_SESSION['currentUser'];
            }

            // $docname = '';
            //  $docname = $savepath;


            try {
                $this->db->beginTransaction();

            if (isset($_POST['practiceIds']) && !empty($_POST['practiceIds']) )  {
                $practiceIds = $_POST['practiceIds'];
                // $practiceIds = explode(',',$practiceIds);
                $explodeUrl = explode('/',$filename);
                $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
                foreach ($practiceIds as $key => $ids) {
                     $user = $ids;                          
                     $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
                     if (strpos(WEB_URL,'alpha')) {
                        $webUrl = $_SERVER['DOCUMENT_ROOT']."/alpha";    
                     }else{
                        $webUrl = $_SERVER['DOCUMENT_ROOT'];
                     }                         
                     $uploadedImage = $webUrl."/images/".$filename;
                     $copyImage  = $webUrl."/images/".$imageUrlChange;                         
                     if ($key == 0) {
                         $docname = WEB_URL."/images/".$filename;
                         $staffFile =  WEB_URL."/images/".$filename;
                     }else{
                         
                         // copy($uploadedImage, $copyImage);
                         file_put_contents($copyImage, file_get_contents($uploadedImage));
                         $docname =  WEB_URL."/images/".$imageUrlChange;
                         $staffFile =  WEB_URL."/images/".$imageUrlChange;
                         // return $uploadedImage.'---'.$copyImage."---".$docname;
                     }
                    
                    $sql      =   "INSERT INTO `myuploads`(`title`,`file`,`category`,`sub_category`,`user`,publish) VALUES (?,?,?,?,?,?)";
                    $array   = array($title, $docname, $category, $sub_category, $user, '1');
                    $this->dbF->setRow($sql, $array, false);
                    $lastId = $this->dbF->rowLastId;

                    $this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, $lastId, $title);
                    if ($dchk == '1') {

                        $sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                                        VALUES (?,?,?,?,?,?)";
                        $array   = array($title, $staffFile, $user, $dcategory, $sub_dcategory, '1');
                        $this->dbF->setRow($sql, $array, false);
                    }
                }   
            }else{
               if ($dchk == '1') {
                 $explodeUrl = explode('/',$filename);
                 $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
                 $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
                 $uploadedImage = "./images/".$filename;
                 $copyImage  = "./images/".$imageUrlChange;
                 copy($uploadedImage, $copyImage);
                }

             
                if($filename==false) {
                    $filePath .= '#';
                    $staffFile =  "#";
                }else{
                    $filePath = WEB_URL . "/images/".$filename;
                    $staffFile =  WEB_URL."/images/".$imageUrlChange;
                }

                $sql = "INSERT INTO `myuploads`(`title`,`file`,`category`,`sub_category`,`user`,publish) VALUES (?,?,?,?,?,?)";
                $array  = array($title, $filePath, $category, $sub_category, $user, '1');
                $this->dbF->setRow($sql, $array, false);
                $lastId = $this->dbF->rowLastId;

                $this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, $lastId, $title);

                // echo $dchk;
                if ($dchk == '1') {
                    $sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`,`ytcode`)
                                    VALUES (?,?,?,?,?,?,?)";
                    $array   = array($title, $staffFile, $userId, $dcategory, $sub_dcategory, '1', $ytcode);
                    $this->dbF->setRow($sql, $array, false);
                      $lastId = $this->dbF->rowLastId;
                    $this->setlog("MyUploads documents Add", $this->UserName($user) . " : " . $user,$lastId, $title);
                }

            }              
                $this->db->commit();
                if ($this->dbF->rowCount > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                $this->db->rollBack();
                $this->dbF->error_submit($e);
                return false;
            }
        }
    }

public function submitfiles()
{

if (isset($_POST['title'])) {
if (!$this->getFormToken('files')) {
return false;
}

$title          = empty($_POST['title'])     ? ""    : $_POST['title'];
$category       = empty($_POST['category'])  ? ""    : $_POST['category'];
$sub_category   = empty($_POST['sub_category'])  ? "": $_POST['sub_category'];
$dchk           = empty($_POST['dchk'])      ? ""    : $_POST['dchk'];
$dcategory      = empty($_POST['dcategory']) ? ""    : $_POST['dcategory'];
$sub_dcategory  = empty($_POST['sub_dcategory']) ? "": $_POST['sub_dcategory'];
$url            = empty($_POST['url'])       ? ""    : $_POST['url'];
$file           = empty($_POST['file'])      ? ""    : $_POST['file'];










if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = $_SESSION['superid'];
$userId = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
$userId = "all:" . $_SESSION['currentUser'];
}
$filename = $this->uploadDocs($url, 'files', $file);
$docname = '';
if (!empty($filename)) {
$docname .= WEB_URL . "/images/$filename";
$url = "https://script.google.com/macros/s/AKfycbyuk1OhMBi_6g4HeCJ8XAnJMVPGItUgTlCAEw7sVQPohEVLYIaa/exec?id=" . $url;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($curl);
curl_close($curl);
$url = "https://script.google.com/macros/s/AKfycbx24aAS9lcRmRi1XG3iYP4eBtJDt_ec3MUKCBpthg/exec";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($curl);
curl_close($curl);
} else {
$docname = '#';
}

try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `myuploads`(`title`,`file`,`category`,`sub_category`,`user`,publish) VALUES (?,?,?,?,?,?)";
$array   = array($title, $docname, $category, $sub_category, $user, '1');
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, $lastId, $title);
if ($dchk == '1') {
$sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                VALUES (?,?,?,?,?,?)";
$array   = array($title, $docname, $userId, $dcategory, $sub_dcategory, '1');
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->setlog("MyUploads documents Add", $this->UserName($user) . " : " . $user, $lastId, $title);
}




$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function uploadsName()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT DISTINCT(`category`) FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1'";
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `userevent`.`file` !='#' AND `userevent`.`file` !='' AND `userevent`.`file` !='NULL'";
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);
$cate = "<option value='all'>All</option>";
foreach ($mysql as $key => $value) {
$cate .= "<option value='" . $value['category'] . "'>" . $value['category'] . "</option>";
}
return $cate;
}

public function myuploads()
{

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

$sql = "SELECT * FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1' ";
$data = $this->dbF->getRows($sql);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
    $d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
} else {
}


if (!empty($data)) {
foreach($data as $key => $value){
    echo "<div class='main-row' style='display: table;'>
    <div class='main-row-down'>
        <div class='ajax-file-upload-container'></div>
        <ul class='listitems'> ";
$id = base64_encode($value['id']);
         $iddecode = base64_decode($id);
        echo '<li class="" style="display: flex;">
<div class="main-row-tops">
    <div class="main-row-down">
        <ul class="myuploads_files">
    <script>$(document).ready(function () { $(".mycolor").addClass("abrown"); });</script>
 <li class="blue" style="display: flex;">
 <div class="category-title static-cat2">
            <b>' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value['category']) . '</b>
        </div>
<div class="row-title">
 ' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value['title']) . ' <span>(' . date('d-M-Y', strtotime($value['dateTime'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
        if ($value['file'] == '#') {
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" title="Delete"><i class="fas fa-trash"></i></a>';
            }
//             echo '</div>
//  <!-- row-icons -->
// </li>
// </ul>
// </div>
// </div>
// </li>';
        } else {


      if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {

                         echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)"   class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
                     }


            $link = explode(",", $value['file']);
            $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
            foreach ($link as $key => $val) {
                        if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                            continue;
                        }
                 $downLink=base64_encode($val.":s:".date('d'));


                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                   



                    if ($ext == 'el') {

                        // echo '<a class="apink" href="' . WEB_URL . '/view-m:' . $iddecode . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                        echo '<a class="apink" href="' . WEB_URL . '/pagePrint-'.base64_encode('m:'.$iddecode).'" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    } else {

                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

                        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    }
                } else {
          



            //  if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {

            //             echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)"   class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
            //         }

                    if ($ext != 'el') {

                        if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                            continue;
                        }
                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                }


                  




            }
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            }
            echo '</div>
<!-- row-icons -->
</li>
</ul>
</div>
</div>
</li>
</ul>
</div>
</div>';
        }
}
}

echo "

";

}

public function myEventsManagement()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql1 = "SELECT DISTINCT(`category`) FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1'";

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') ORDER BY `userevent`.`due_date` ASC";

//  $sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `assignto` IN ('-1.$d[0]','$user') AND `status`!='deleted'";
$data1 = $this->dbF->getRows($sql1);
$data2 = $this->dbF->getRows($sql2);
// $data3 = $this->dbF->getRows($sql3);
$mysql = array_merge($data1, $data2);
} else {
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`user`='$user'";


$sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`='complete'";
// $sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`!='deleted'";
$data1 = $this->dbF->getRows($sql1);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
$mysql = array_merge($data1, $data2, $data3);
}





$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);
$autoId = 1;
foreach ($mysql as $key => $value1) {
    $myselF = $value1['category'];
$sql = "SELECT DISTINCT(`sub_category`) FROM `myuploads` WHERE `user` = '$user' AND  `publish` = '1' AND `category` = '$value1[category]'";
$data = $this->dbF->getRows($sql);

echo "<div class='main-row' style='display: table;'>
    <div class='main-row-down'>
        <!--<h5>" . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value1['category']) . "</h5>
        <i class='fas fa-chevron-down'></i>-->
        <div class='ajax-file-upload-container'></div>

    <!-- main-row-top -->
<!--<div class='main-row-down'>-->";


 $html = <<<HTML

<script>$("#mulitplefileuploader{$autoId}").uploadFile({url:"myuploads",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",formData:{submit:"{$autoId}",category:"{$myselF}",myUploadsTokens:"{$autoId}"},onSuccess:function(e,t,a){}});</script>
HTML;

echo $html;

echo "<ul class='listitems'> ";


if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

//$sql = "SELECT `userevent`.`file` as 'fl',`userevent`.`title_id`,`type`,`userevent`.`dateTime`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
$sql = "SELECT  DISTINCT(`userevent`.`title_id`)  FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
} else {
$sql = "SELECT  DISTINCT(`userevent`.`title_id`)  FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
//$sql = "SELECT `userevent`.`file` as 'fl',`userevent`.`title_id`,`type`,`userevent`.`dateTime`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]')";
}
$data = $this->dbF->getRows($sql);
if (!empty($data)) {


foreach ($data as $key => $value) {
$title = $this->dbF->getRow("SELECT title FROM `eventmanagement` WHERE id='$value[title_id]'");
$title = $title[0];
// // if($value['fl']=='#'){
// //     continue;
// // }
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

$sql_s = "SELECT `userevent`.`file` as 'fl',`type`,`userevent`.`dateTime`,`userevent`.`due_date`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND (`user`='$user' OR `userevent`.`assignto` IN ('-1.$d[0]','$user')) AND `title_id` = '$value[title_id]'  ORDER BY `userevent`.`due_date` ASC";



$data_s = $this->dbF->getRows($sql_s);



if ($this->dbF->rowCount == 1) {
    foreach ($data_s as $key_s => $value_s) {
        // if($value_s['due_date'] == ''){$value_s['due_date'] = $value_s['dateTime'];}
        echo '<li style="display: flex">
<div class="main-row-tops">
    <div class="main-row-down">
        <ul class="myuploads_files">
    <script>$(document).ready(function () { $(".mycolor").addClass("abrown"); });</script>
 <li class="blue" style="display: flex;">
 <div class="category-title static-cat2">
            <b>' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value1['category']) . '</b>
        </div>
<div class="row-title">
 ' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . ' <span>(' . date('d-M-Y', strtotime($value_s['due_date'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';

        $link = explode(",", $value_s['fl']);
        $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
        foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }

            $downLink=base64_encode($val.":s:".date('d'));


            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {

                if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
                }
            } else {

                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
            }
        }
        echo '<a href="editevent_print.php?id=' . base64_encode($value_s['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        echo '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value_s['id'] . '" data-type="' . (($value_s['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';

        echo '
</div><!-- row-icons -->
</li>
</ul>
</div>
</div>
</li>';
    }
} else {


    echo '<li style="display: flex">
<div class="main-row-tops">
' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . ' 
<i class="fas fa-chevron-down" style="float: right;"></i>
<div class="main-row-down"><ul class=""><!---listitems---->';

    foreach ($data_s as $key_s => $value_s) {
        // if($value_s['due_date'] == ''){$value_s['due_date'] = $value_s['dateTime'];}    
        echo '

<li class="' . (($value_s['type'] == 'mandatory') ? 'red' : '') . '" style="display: flex">
<div class="row-title">
' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . '<span> (' . date('d-M-Y', strtotime($value_s['due_date'])) . ')</span>
</div>

<div class="row-icons">';

        $link = explode(",", $value_s['fl']);
        $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
        foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
            $downLink=base64_encode($val.":s:".date('d'));


            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {

                if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
                }
            } else {

                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                // echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
            }
        }
        echo '<a href="editevent_print.php?id=' . base64_encode($value_s['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        echo '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value_s['id'] . '" data-type="' . (($value_s['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';

        echo '
</div><!-- row-icons -->







</li>';
    }
    echo '</ul></div></div>


</li>';
}
}
} //two close

echo "</ul>
</div>



<!-- main-row-down -->           



</div><!-- main-row -->";
$autoId++;
}

}

public function uploads1()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql1 = "SELECT DISTINCT(`category`) FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1'";

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') ORDER BY `userevent`.`due_date` ASC";

//  $sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `assignto` IN ('-1.$d[0]','$user') AND `status`!='deleted'";
$data1 = $this->dbF->getRows($sql1);
$data2 = $this->dbF->getRows($sql2);
// $data3 = $this->dbF->getRows($sql3);
$mysql = array_merge($data1, $data2);
} else {
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`user`='$user'";


$sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`='complete'";
// $sql3 = "SELECT  DISTINCT(`category`) FROM `myevents` WHERE `user`='$user' AND `status`!='deleted'";
$data1 = $this->dbF->getRows($sql1);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
$mysql = array_merge($data1, $data2, $data3);
}





$mysql = array_unique($mysql, SORT_REGULAR);
sort($mysql);
$autoId = 1;
foreach ($mysql as $key => $value1) {
    $myselF = $value1['category'];
$sql = "SELECT DISTINCT(`sub_category`) FROM `myuploads` WHERE `user` = '$user' AND  `publish` = '1' AND `category` = '$value1[category]'";
$data = $this->dbF->getRows($sql);

echo "<div class='main-row' style='display: table;'>
    <div class='main-row-top'>
        <!--<h5>" . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value1['category']) . "</h5>
        <i class='fas fa-chevron-down'></i>-->
        <div class='ajax-file-upload-container'></div>

    <!-- main-row-top -->
<!--<div class='main-row-down'>-->";


 $html = <<<HTML

<script>$("#mulitplefileuploader{$autoId}").uploadFile({url:"myuploads",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",formData:{submit:"{$autoId}",category:"{$myselF}",myUploadsTokens:"{$autoId}"},onSuccess:function(e,t,a){}});</script>
HTML;

echo $html;

echo "<ul class='listitems'> ";
if (!empty($data)) {

foreach ($data as $key => $value) {
if ($value['sub_category'] != '') {

    echo "
    <li style='display: flex;'><div class='main-row-tops'>" .
        str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value['sub_category']) . "
        <i class='fas fa-chevron-down' style='float:right;'></i>
    
    <!-- main-row-top -->
    <div class='main-row-down'><ul class='myuploads_files'>
    <script>$(document).ready(function () { $('.mycolor').addClass('abrown'); });</script>";
    $sql = "SELECT * FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1' AND sub_category = '$value[sub_category]' AND `category` = '$value1[category]' AND `sub_category` !='' ";
    $data = $this->dbF->getRows($sql);

    foreach ($data as $key => $value) {

        $id = base64_encode($value['id']);
         $iddecode = base64_decode($id);
        echo '<li class="blue" style="display: flex;">
<div class="main-row-tops">
    <div class="main-row-down">
        <ul class="myuploads_files">
    <script>$(document).ready(function () { $(".mycolor").addClass("abrown"); });</script>
 <li class="blue" style="display: flex;">
<div class="row-title">
 ' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value['title']) . ' <span>(' . date('d-M-Y', strtotime($value['dateTime'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
        if ($value['file'] == '#') {
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" title="Delete"><i class="fas fa-trash"></i></a>';
            }
            echo '</div>
 <!-- row-icons -->
</li>
</ul>
</div>
</div>
</li>';
        } else {


      if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {

                         echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)"   class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
                     }


            $link = explode(",", $value['file']);
            $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
            foreach ($link as $key => $val) {
                        if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                            continue;
                        }
                 $downLink=base64_encode($val.":s:".date('d'));


                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                   



                    if ($ext == 'el') {

                        // echo '<a class="apink" href="' . WEB_URL . '/view-m:' . $iddecode . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                        echo '<a class="apink" href="' . WEB_URL . '/pagePrint-'.base64_encode('m:'.$iddecode).'" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    } else {

                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

                        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    }
                } else {
          



            //  if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {

            //             echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)"   class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
            //         }

                    if ($ext != 'el') {

                        if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                            continue;
                        }
                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                }


                  




            }
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    }
    echo "</ul></div></div></li>";
}
if ($value['sub_category'] == '') {



    $sql = "SELECT * FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1' AND sub_category = '$value[sub_category]' AND `category` = '$value1[category]' AND `sub_category` ='' ";
    $data = $this->dbF->getRows($sql);

    foreach ($data as $key => $value) {

        $id = base64_encode($value['id']);
        $iddecode = base64_decode($id);

        echo '<li class="blue" style="display: flex;">
<div class="row-title">
' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $value['title']) . ' <span>(' . date('d-M-Y', strtotime($value['dateTime'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
        if ($value['file'] == '#') {
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" title="Delete"><i class="fas fa-trash"></i></a>';
            }
            echo '</div>
 <!-- row-icons -->
</li>';
        } else {
            $link = explode(",", $value['file']);
            $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
            foreach ($link as $key => $val) {
                        if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                            continue;
                        }
            $downLink=base64_encode($val.":s:".date('d'));


                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                        echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)" class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
                    }


                    if ($ext == 'el') {

                        // echo '<a class="apink" href="' . WEB_URL . '/view-m:' . $iddecode . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                        echo '<a class="apink" href="' . WEB_URL . '/pagePrint-'.base64_encode('m:'.$iddecode).'" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    } else {

                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

                        echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    }
                } else {
                    echo '<a data-toggle="tooltip" title="Edit" href="javascript:;" onclick="myuploadsdit(this.id)" class=" ablue" id="' . $id . '"><i class="fas fa-edit"></i></a>';
                    if ($ext != 'el') {

                        // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                        echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                }
            }
            if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
                echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/myuploads?cnfrm=" . base64_encode($value['id']."&d=".date('d')) . '" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a>';
            }
            echo '</div>
<!-- row-icons -->
</li>';
        }
    }
}
}
} //one close


if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

//$sql = "SELECT `userevent`.`file` as 'fl',`userevent`.`title_id`,`type`,`userevent`.`dateTime`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
$sql = "SELECT  DISTINCT(`userevent`.`title_id`)  FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
} else {
$sql = "SELECT  DISTINCT(`userevent`.`title_id`)  FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]') ORDER BY `userevent`.`due_date` ASC";
//$sql = "SELECT `userevent`.`file` as 'fl',`userevent`.`title_id`,`type`,`userevent`.`dateTime`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `title_id` IN (SELECT id FROM `eventmanagement` WHERE category = '$value1[category]')";
}
$data = $this->dbF->getRows($sql);
if (!empty($data)) {


foreach ($data as $key => $value) {
$title = $this->dbF->getRow("SELECT title FROM `eventmanagement` WHERE id='$value[title_id]'");
$title = $title[0];
// // if($value['fl']=='#'){
// //     continue;
// // }
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

$sql_s = "SELECT `userevent`.`file` as 'fl',`type`,`userevent`.`dateTime`,`userevent`.`due_date`,`userevent`.`id` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND (`user`='$user' OR `userevent`.`assignto` IN ('-1.$d[0]','$user')) AND `title_id` = '$value[title_id]'  ORDER BY `userevent`.`due_date` ASC";



$data_s = $this->dbF->getRows($sql_s);



if ($this->dbF->rowCount == 1) {
    foreach ($data_s as $key_s => $value_s) {
        // if($value_s['due_date'] == ''){$value_s['due_date'] = $value_s['dateTime'];}
        echo '<li class="' . (($value_s['type'] == 'mandatory') ? 'red' : '') . '" style="display: flex">
<div class="main-row-tops">
    <div class="main-row-down">
        <ul class="myuploads_files">
    <script>$(document).ready(function () { $(".mycolor").addClass("abrown"); });</script>
 <li class="blue" style="display: flex;">
<div class="row-title">
 ' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . ' <span>(' . date('d-M-Y', strtotime($value_s['due_date'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';

        $link = explode(",", $value_s['fl']);
        $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
        foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }

            $downLink=base64_encode($val.":s:".date('d'));


            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {

                if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
                }
            } else {

                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
            }
        }
        echo '<a href="editevent_print.php?id=' . base64_encode($value_s['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        echo '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value_s['id'] . '" data-type="' . (($value_s['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';

        echo '
</div><!-- row-icons -->
</li>
</ul>
</div>
</div>
</li>';
    }
} else {


    echo '<li style="display: flex">
<div class="main-row-tops">
' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . ' 
<i class="fas fa-chevron-down" style="float: right;"></i>
<div class="main-row-down"><ul class=""><!---listitems---->';

    foreach ($data_s as $key_s => $value_s) {
        // if($value_s['due_date'] == ''){$value_s['due_date'] = $value_s['dateTime'];}    
        echo '

<li class="' . (($value_s['type'] == 'mandatory') ? 'red' : '') . '" style="display: flex">
<div class="row-title">
' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $title) . '<span> (' . date('d-M-Y', strtotime($value_s['due_date'])) . ')</span>
</div>

<div class="row-icons">';

        $link = explode(",", $value_s['fl']);
        $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
        foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
            $downLink=base64_encode($val.":s:".date('d'));


            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {

                if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'edit' || $_SESSION['superUser']['myuploads'] == 'full') {
                    // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
                }
            } else {

                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                // echo '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-file"></i></a>';
            }
        }
        echo '<a href="editevent_print.php?id=' . base64_encode($value_s['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        echo '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value_s['id'] . '" data-type="' . (($value_s['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';

        echo '
</div><!-- row-icons -->







</li>';
    }
    echo '</ul></div></div>


</li>';
}
}
} //two close





if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
// $user = $_SESSION['superid'];
$user = intval($_SESSION['webUser']['id']);
if (isset($_SESSION['practiceUser'])) {
$user = intval($_SESSION['superid']);
}

$currentUser = intval($_SESSION['currentUser']);
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`= ?",array($user));


// $sqlmyevent = "SELECT DISTINCT(`title`)  FROM `myevents` WHERE  ( `assignto` IN ('-1.$d[0]','$user') OR user = '$user' ) AND category = '$value1[category]' AND `status`!='deleted'";
$sqlmyevent = "SELECT DISTINCT(`title`)  FROM `myevents` WHERE  ( `assignto` IN ('-1.$d[0]','$user') OR user = '$user' ) AND category = '$value1[category]' AND `status`='complete'";
} else {
$user = intval($_SESSION['currentUser']);
// $sqlmyevent = "SELECT DISTINCT(`title`)  FROM `myevents` WHERE user = '$user' AND category = '$value1[category]' AND `status`!='deleted'";
$sqlmyevent = "SELECT DISTINCT(`title`)  FROM `myevents` WHERE user = '$user' AND category = '$value1[category]' AND `status`='complete'";
}

$datamyevent = $this->dbF->getRows($sqlmyevent);
if (!empty($datamyevent)) {




foreach ($datamyevent as $key => $valuemyevent) {

// if ($value['sub_category'] != '') {

echo "
    <li style='display: flex'><div class='main-row-tops'>" .
    str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', _uc($valuemyevent['title'])) . "
        <i class='fas fa-chevron-down' style='float:right;'></i>
    
    <!-- main-row-top -->
    <div class='main-row-down'><ul class='blue' style='display: flex'>";
// $sqlmyevent1 = "SELECT * FROM `myevents` WHERE `user` = '$user'  AND `title` = '$valuemyevent[title]' AND `status`!='deleted' ";

$sqlmyevent1 = "SELECT * FROM `myevents` WHERE `user` = '$user'  AND `title` = '$valuemyevent[title]' AND `status`='complete' ";


$datamyevent1 = $this->dbF->getRows($sqlmyevent1);

foreach ($datamyevent1 as $key => $valuemyevent1) {
    if ($valuemyevent1['status'] == 'complete') {
        $complete = 'completed';
        $style = 'style="background-color: #ffffff8c;"';
    } else {
        $style = '';
        $complete = $valuemyevent1['status'];
    }
    if (strpos($valuemyevent1['assignto'], '-1') !== false) {
        $assignto = 'All';
    } else {
        $assignto = $this->UserName($valuemyevent1['assignto']);
    }if(empty($assignto)){

       $assignto = "anonymous";
}

    if ($valuemyevent1['color_publish'] == '1') {

        $myeventcolor = 'style=" color: #00ff64 !important; cursor: pointer;"';
    } else {
        $myeventcolor = '';
        echo '<script>$(document).ready(function(){$(".mycolor").addClass("abrown");});</script>';
    }
    $id = base64_encode($valuemyevent1['id']);
    $iddecode = base64_decode($id);
    echo '<li class="blue" style="display: flex">
<div class="row-title">
 ' . str_replace(array('Update ', 'Review ', 'Complete ', 'Carry Out ', 'Upload ', ' Due'), '', $valuemyevent1['title']) . ' <span>(' . date('d-M-Y', strtotime($valuemyevent1['due_date'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
    if ($valuemyevent1['file'] == '#') {
        if ($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['myuploads'] == 'full') {
            echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="myuploads?sure=' . base64_encode($valuemyevent1['id']."&d=".date('d')) . '" title="Delete"><i class="fas fa-trash"></i></a>';

            if ($valuemyevent1['assignto'] != '') {

                // echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';


                //  echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Edit Event, Assigned to ' . $assignto . '"><i class="fas fa-edit"></i></a>';


                    // echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="submitMYevent(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Submit Event"><i class="fas fa-user"></i></a>';



            }
            // echo '<a class="ablue" onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>';


                // echo '<a class="ablue" onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Edit Event"><i class="fas fa-edit"></i></a>';


                    echo '<a class="ablue" onclick="submitMYevent(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Submit Event"><i class="fas fa-file"></i></a>';



        }
        echo '</div>
 <!-- row-icons -->
</li>';
    } else {
        $link = explode(",", $valuemyevent1['file']);
        $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
        foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
            $downLink=base64_encode(WEB_URL . '/images/' .$val.":s:".date('d'));

            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                echo '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . WEB_URL . '/images/' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            } else {

                // echo '<a class="apink" href="' . WEB_URL . '/d?f=' .  $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                echo '<a class="apink" href="' .  $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            }
        }



        echo  '<a class="ared"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="myuploads?sure=' . base64_encode($valuemyevent1['id']."&d=".date('d')) . '"><i class="fas fa-trash"></i></a>';

        if ($valuemyevent1['assignto'] != '') {

            // echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';



            //   echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Edit Event, Assigned to ' . $assignto . '"><i class="fas fa-user"></i></a>';


             //       echo '<a  class="mycolor" ' . $myeventcolor . '  onclick="submitMYevent(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Submit Event"><i class="fas fa-user"></i></a>';




        }
        // echo '<a class="ablue" onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Upload"><i class="fas fa-edit"></i></a>';


          //     echo '<a class="ablue" onclick="myevents(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Edit Event"><i class="fas fa-edit"></i></a>';


                    echo '<a class="ablue" onclick="submitMYevent(this.id)" id="' . $valuemyevent1['id'] . '" data-toggle="tooltip" title="Submit Event"><i class="fas fa-edit"></i></a>';
 

        echo '</div>
<!-- row-icons -->
</li>';
    }
}
echo "</ul></div></div></li>";
// }
// if ($value['sub_category'] == '') 
//  {}
}

// foreach ($datamyevent as $key => $valuemyevent) {
//      if ($valuemyevent['file'] != '' && $valuemyevent['file'] != '#' ) {}
//  }







} // three close









echo "</ul>
</div>



<!-- main-row-down -->           



</div><!-- main-row -->";
$autoId++;
}

}

public function submitrecruitment($apiPostData="")
{
     if (!empty($apiPostData)) {
        $_POST = $apiPostData; 
    }
if (isset($_POST['submit'])) {
if(isset($_POST['recruitmentsTokens'])){
// $this->dbF->prnt($_POST);11
// $this->dbF->prnt($_FILES);
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$filename = pathinfo($title, PATHINFO_FILENAME);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename);          
$category       = str_replace($strip," " ,$category); 
$user     =intval( $_SESSION['webUser']['id']);
}else{




if (!$this->getFormToken('recruitment')&& $apiPostData=="") {
return false;
}

$title    = empty($_POST['title'])     ? ""    : $_POST['title'];
$category = empty($_POST['category'])  ? ""    : $_POST['category'];
$user     = $_SESSION['webUser']['id'];




}


$filename = $this->uploadSingleFile($_FILES['document'], 'files', '');
$docname  = '';
// htmlspecialchars($title);
// htmlspecialchars($category);
// htmlspecialchars($user);
// htmlspecialchars($filename);

if (!empty($filename)) {
$docname .= WEB_URL . "/images/$filename";
} else {
$docname = '#';
}



try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `recruitment`(`title`,`file`,`category`,`user`,publish) VALUES (?,?,?,?,?)";
$array   = array($title, $docname, $category, $user, '1');
$this->dbF->setRow($sql, $array, false);

$lastId = $this->dbF->rowLastId;

$this->setlog("Recruitment", $this->UserName($user) . " : " . $user,$lastId, $title);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}


public function practicetraining($apiPostData="")
{
     if (!empty($apiPostData)) {
        $_POST = $apiPostData; 
    }
if (isset($_POST['submit'])) {
if(isset($_POST['practicetraining'])){
    var_dump($_POST);
// $this->dbF->prnt($_POST);11
// $this->dbF->prnt($_FILES);
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$filename = pathinfo($title, PATHINFO_FILENAME);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename);          
$category       = str_replace($strip," " ,$category); 
	// $user     = $_SESSION['webUser']['id'];
$user = $_SESSION['currentUser'];
  // echo "string";
}else{




if (!$this->getFormToken('practicetraining') && $apiPostData=="") {
return false;
}
// $title    = empty($_POST['title'])     ? ""    : $_POST['title'];
$title    = empty($_POST['title'])     ? ""    : $_POST['title'];
$category = empty($_POST['category'])  ? ""    : $_POST['category'];
$description = empty($_POST['description'])  ? ""    : $_POST['description'];
$visible = empty($_POST['visible'])  ? ""    : $_POST['visible'];

$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$title);          
$category       = str_replace($strip," " ,$category);       
$description   = str_replace($strip," " ,$description); 

	// $user     = $_SESSION['webUser']['id'];
$user = intval( $_SESSION['currentUser']);
}


$filename = $this->uploadSingleFile($_FILES['document'], 'files', '');
$docname  = '';
// htmlspecialchars($title);
// htmlspecialchars($category);
// htmlspecialchars($user);
// htmlspecialchars($filename);

if (!empty($filename)) {
$docname .= WEB_URL . "/images/$filename";
} else {
$docname = '#';
}


try {
$this->db->beginTransaction();
if (isset($_POST['practiceIds']) )  {
    $practiceIds = $_POST['practiceIds'];
    $explodeUrl = explode('/',$filename);
    $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
    foreach ($practiceIds as $key => $ids) {
             $user = $ids; 
                                      
             $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
             if (strpos(WEB_URL,'alphaCopy')) {
                $webUrl = $_SERVER['DOCUMENT_ROOT']."/alphaCopy";    
             }else{
                $webUrl = $_SERVER['DOCUMENT_ROOT'];
             }                         
             $uploadedImage = $webUrl."/images/".$filename;
             $copyImage  = $webUrl."/images/".$imageUrlChange;                         
             if ($key == 0) {
                 $docname = WEB_URL."/images/".$filename;
                 $staffFile =  WEB_URL."/images/".$filename;
             }else{
                 
                 
                 // copy($uploadedImage, $copyImage);
                 file_put_contents($copyImage, file_get_contents($uploadedImage));
                 $docname =  WEB_URL."/images/".$imageUrlChange;
                 $staffFile =  WEB_URL."/images/".$imageUrlChange;
                 // return $uploadedImage.'---'.$copyImage."---".$docname;
             }
            // $sql      = "INSERT INTO `practicetraining` (`user`, `title`, `category`, `disc`, `visibleto` , `file`) VALUES (?,?,?,?,?,?)";
            // $array   = array($user, $title, $category, $description,$visible,  $docname);
            // $this->dbF->setRow($sql, $array, false);
            // if ($dchk == '1') {
             if($visible=='all:'){
                $user='all:'.$user;
            }else{
                $user=$user;
            }

            $dcategory="Practice Training";
                $sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                                VALUES (?,?,?,?,?,?)";
                $array   = array($title, $staffFile, $user, $dcategory, $category, '1');
                $this->dbF->setRow($sql, $array, false);
            // }
       }   
}else{
    // if ($dchk == '1') {
        
     $explodeUrl = explode('/',$filename);
     $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2];
     $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
     $uploadedImage = "./images/".$filename;
     $copyImage  = "./images/".$imageUrlChange;
     copy($uploadedImage, $copyImage);

// }

$docname = '';
$staffFile = '';
if($filename==false) {
$docname .= '#';
$staffFile =  "#";
}else{
$docname .= WEB_URL . "/images/".$filename;
$staffFile =  WEB_URL."/images/".$imageUrlChange;
}

// $sql      = "INSERT INTO `practicetraining` (`user`, `title`, `category`, `disc`, `visibleto` , `file`) VALUES (?,?,?,?,?,?)";
//             $array   = array($user, $title, $category, $description,$visible,  $docname);
// $this->dbF->setRow($sql, $array, false);

// if ($dchk == '1') {
if($visible=='all:'){
                $user='all:'.$user;
            }else{
                $user=$user;
            }

        $dcategory="Practice Training";
                $sql = "INSERT INTO `documents`(`title`, `file`,`assignto`,`category`,`sub_dcategory`,`publish`)
                                VALUES (?,?,?,?,?,?)";
                $array   = array($title, $staffFile, $user, $dcategory, $category, '1');
$this->dbF->setRow($sql, $array, false);
// }

}
// $sql      =   "INSERT INTO `recruitment`(`title`,`file`,`category`,`user`,publish) VALUES (?,?,?,?,?)";
// $array   = array($title, $docname, $category, $user, '1');
// $this->dbF->setRow($sql, $array, false);

$lastId = $this->dbF->rowLastId;

$this->setlog("Practice Training", $this->UserName($user) . " : " . $user,$lastId, $title);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function recruitmentName($user)
{
    
$user =  intval($user);
$sql = "SELECT DISTINCT(`category`) FROM `recruitment` WHERE `user` = '$user' AND `publish` = '1'";
$data = $this->dbF->getRows($sql);
$cate = "<option value='all'>All</option>";
foreach ($data as $key => $value) {
$cate .= "<option value='" . $value['category'] . "'>" . $value['category'] . "</option>";
}
return $cate;
}

public function recruitment($user)
{
    $autoId = 1;
$user = intval($user);

$sql = "SELECT DISTINCT(`category`) FROM `recruitment` WHERE `user` = '$user' AND `publish` = '1'";
$row = $this->dbF->getRows($sql);
foreach ($row as $key => $val) {
$sql = "SELECT * FROM `recruitment` WHERE `user` = '$user' AND `category`='$val[category]' AND `publish` = '1'";
$data = $this->dbF->getRows($sql);

$myselF=$val['category'];


echo "<div class='main-row'>
    <div class='main-row-top'>
        <h5>$val[category]</h5>
        <i class='fas fa-chevron-down'></i>
    </div>
    <!-- main-row-top -->
   
   <div class='main-row-down'>";


 $html = <<<HTML
<div  id='recruitmentMultiFile{$autoId}'></div>

<script>$("#recruitmentMultiFile{$autoId}").uploadFile({url:"personal-document",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",formData:{submit:"{$autoId}",category:"{$myselF}",recruitmentsTokens:"{$autoId}",title:""},onSuccess:function(e,t,a){}});</script>
HTML;

echo $html;

echo "<ul> ";



if (!empty($data)) {
foreach ($data as $key => $value) {
$id = base64_encode($value['id']);
echo '<li class="blue">
<div class="row-title">
 ' . $value['title'] . ' <span>(' . date('d-M-Y', strtotime($value['dateTime'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
if ($value['file'] == '#') {
    echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/personal-document?id=" . $id . '" title="Delete"><i class="fas fa-trash"></i></a>
 </div>
 <!-- row-icons -->
</li>';
} else {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG');
    foreach ($link as $key => $val) {



            $downLink=base64_encode($val.":s:".date('d'));


        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo '<a class="apink" href="https://docs.google.com/gview?url=' . $val . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {
            // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            echo '<a class="apink" href="' . $val . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
    echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/personal-document?id=" . $id . '" title="Delete"><i class="fas fa-trash"></i></a>
</div>
<!-- row-icons -->
</li>';
}
}
} //one close

echo "</ul></div>
<!-- main-row-down -->           
</div><!-- main-row -->";

$autoId++;


}
}
public function actionplan($user)
{


$user = intval($_SESSION['currentUser']);
$sql = "SELECT  DISTINCT(`title`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user'";
$row = $this->dbF->getRows($sql);




foreach ($row as $key => $val) {

$sql = "SELECT * FROM `recruitment` WHERE `user` = '$user' AND `category`='$val[category]' AND `publish` = '1'";
$data = $this->dbF->getRows($sql);
echo "<div class='main-row'>
    <div class='main-row-top'>
        <h5>$val[title]</h5>
        <i class='fas fa-chevron-down'></i>
    </div>
    <!-- main-row-top -->
    <div class='main-row-down'><ul>";
if (!empty($data)) {
foreach ($data as $key => $value) {
$id = base64_encode($value['id']);
echo '<li class="blue">
<div class="row-title">
 ' . $value['title'] . ' <span>(' . date('d-M-Y', strtotime($value['dateTime'])) . ')</span>
</div>
<!-- row-title -->
<div class="row-icons">';
if ($value['file'] == '#') {
    echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/personal-document?id=" . $id . '" title="Delete"><i class="fas fa-trash"></i></a>
 </div>
 <!-- row-icons -->
</li>';
} else {
    $link = explode(",", $value['file']);
    $allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG');
    foreach ($link as $key => $val) {



            $downLink=base64_encode($val.":s:".date('d'));



        $ext = pathinfo($val, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo '<a class="apink" href="https://docs.google.com/gview?url=' . $val . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        } else {
                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    continue;
                }
            // echo '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
            echo '<a class="apink" href="' . $val . '" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
        }
    }
    echo '<a class="ared" onclick="return confirm(\'Are you sure you want to delete?\');" href="' . WEB_URL . "/personal-document?id=" . $id . '" title="Delete"><i class="fas fa-trash"></i></a>
</div>
<!-- row-icons -->
</li>';
}
}
} //one close

echo "</ul></div>
<!-- main-row-down -->           
</div><!-- main-row -->";
}
}

public function eventCategory($api=false)
{
$sql  = "SELECT `setting_val` FROM `ibms_setting` WHERE  `setting_name`='eventcategory'";
$data = $this->dbF->getRow($sql);
$opt  = '';
$data = array_filter(array_map('trim', explode(',', $data[0])));
//$this->dbF->prnt($data);
asort($data);
if($api){
    foreach ($data as $val) {
    $opt        .= $val;
    }
}else{
    foreach ($data as $val) {
    $opt        .= '<option value="' . $val . '">' . $val . '</option>';
    }
}
return $opt;
}
public function leavetype($api=false)
{
$sql  = "SELECT `setting_val` FROM `ibms_setting` WHERE  `setting_name`='leavetype'";
$data = $this->dbF->getRow($sql);
$opt  = '';
$data = array_filter(array_map('trim', explode(',', $data[0])));
//$this->dbF->prnt($data);
asort($data);
if($api){
    foreach ($data as $val) {
    $opt        .=$val;
    }
}else{
    foreach ($data as $val) {
    $opt        .= '<option value="' . $val . '">' . $val . '</option>';
    }
}
return $opt;
}

public function eventCategoryedit($check = 0)
{
$sql  = "SELECT `setting_val` FROM `ibms_setting` WHERE  `setting_name`='eventcategory'";
$data = $this->dbF->getRow($sql);
$opt  = '';
$data = array_filter(array_map('trim', explode(',', $data[0])));
//$this->dbF->prnt($data);
asort($data);
foreach ($data as $val) {
if ($val == $check) {
$opt .= '<option selected value="' . $val . '">' . $val . '</option>';
} else {
$opt .= '<option value="' . $val . '">' . $val . '</option>';
}
}
return $opt;
}



// public function getEventCategory($check = 0)
// {
// $sql  = "SELECT `setting_val` FROM `ibms_setting` WHERE  `setting_name`='eventcategory'";
// $data = $this->dbF->getRow($sql);
// $opt  = '';
// // $data = array_filter(array_map(explode(',', $data[0])));
// //$this->dbF->prnt($data);
// // asort($data);
// foreach ($data as $val) {
// if ($val == $check) {
// $opt .= $val;
// } else {
// $opt .= $val;
// }
// }
// return $data['setting_val'];
// }

public function deletemyuploads($apiPostData="")
{
// return true;
     $smartQuery ='';
if (!empty($apiPostData)) {
    @$id = $apiPostData['id'];
    @$idDate = $apiPostData['currentDay'];         
     }else{

@$idX = base64_decode($_GET['cnfrm']);
$exp = explode("&d=", $idX);
// var_dump($exp);
@$id = $exp[0];
@$idDate = $exp[1];
}
if($idDate == date('d')){



$sql1 = "SELECT `file`,`title`,`category`,`sub_category`,`user` FROM `myuploads` WHERE `id`= ? ";
$data =  $this->dbF->getRow($sql1,array($id));

// echo "select * FROM `documents` WHERE `title`='$data[title]' AND `file`='$data[file]'";

// return true;


 $smartQuery .= $this->makeRecoverySQL('documents','title',$data['title'],'file',$data['file']);






$this->dbF->setRow("DELETE FROM `documents` WHERE `title`= ?  AND `file`= ? ", array($data['title'], $data['file']));
// $lastId = $this->dbF->rowLastId;
if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
}
$this->setlog("MyUploads Delete", $this->UserName($user) . " : " . $user,"", $data['title']);
// $path = parse_url($data['file'], PHP_URL_PATH);
// $name = $_SERVER['DOCUMENT_ROOT'] . $path;


 $smartQuery .= $this->makeRecoverySQL('myuploads','id',$id);



$sql2  = "DELETE FROM `myuploads` WHERE id= ? ";
$this->dbF->setRow($sql2, array($id));
if ($this->dbF->rowCount) {
// @unlink($name);
// ========================TrashData=======================================================
$ds = "Delete My Uploads  (Title Name : " . $data['title'] . " ) & (category : " . $data['category'] . " )& (sub_category : " . $data['sub_category'] . " ) ";
$this->TrashData('My Uploads', $ds, $data['file'], $user, $data['user'], 'myuploads', $id, 'MY Uploads Delete',$smartQuery);
// ========================TrashData=======================================================

return true;
} else {
return false;
}

}else{
// var_dump('dsadd');
return false;

}




}

public function deleterecruitment()
{
$userFrom = intval($_SESSION['webUser']['id']);
$id = base64_decode($_GET['id']);
$sql1 = "SELECT * FROM `recruitment` WHERE `id`= ? ";
$data =  $this->dbF->getRow($sql1,array($id));


$smartQuery = "";
$allData = "";
// foreach ($data as $key => $val) {
$allData .= "title : $data[title] <br />";
$allData .= "file : $data[file] <br />";
$allData .= "category : $data[category] <br />";
// }


$this->setlog("Personal Document Delete", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$id, $allData);
// $path = parse_url($data['file'], PHP_URL_PATH);
// $name = $_SERVER['DOCUMENT_ROOT'] . $path;


 $smartQuery .= $this->makeRecoverySQL('recruitment','id',$id);




$sql2  = "DELETE FROM `recruitment` WHERE id= ? ";
$this->dbF->setRow($sql2 , array($id));
if ($this->dbF->rowCount) {
///    @unlink($name);
// ========================TrashData=============================================
$ds = "Personal Document Delete  :title is (" . $data['title'] . ")  & (category is " . $data['category'] . " )";
$this->TrashData('personal Document', $ds, $data['file'], $userFrom, $data['user'], 'recruitment', $id, 'deleterecruitment',$smartQuery);
// ========================TrashData=============================================
return true;
} else {
return false;
}
}

//myupload dashboard

public function countMyUploads()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql  = "SELECT COUNT(`id`) FROM `myuploads` WHERE `user`='$user' AND `publish` = '1' AND `myuploads`.`file` !='#' AND `myuploads`.`file` !='' AND `myuploads`.`file` !='NULL'";
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql2  = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `userevent`.`file` !='#' AND `userevent`.`file` !='' AND `userevent`.`file` !='NULL'";
} else {
$sql2  = "SELECT  COUNT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `userevent`.`file` !='#' AND `userevent`.`file` !='' AND `userevent`.`file` !='NULL'";
}
$data = $this->dbF->getRow($sql);
$data2 = $this->dbF->getRow($sql2);
return $data[0] + $data2[0] + 0;
}


public function eventMyUploadsTitle()
{
   
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT DISTINCT(`category`) FROM `myuploads` WHERE `user`='$user' AND `publish` = '1' AND `myuploads`.`file` !='#' AND `myuploads`.`file` !='' AND `myuploads`.`file` !='NULL'";
$data = $this->dbF->getRows($sql);
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user') AND `userevent`.`file` !='#' AND `userevent`.`file` !='' AND `userevent`.`file` !='NULL'";
} else {
$sql2 = "SELECT  DISTINCT(`category`) FROM `eventmanagement` JOIN `userevent` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user' AND `userevent`.`file` !='#' AND `userevent`.`file` !='' AND `userevent`.`file` !='NULL'";
}
$data2 = $this->dbF->getRows($sql2);
$mysql = array_merge($data, $data2);
$mysql = array_unique($mysql, SORT_REGULAR);
function compare_category($a, $b)
{
return strnatcmp($a['category'], $b['category']);
}
usort($mysql, 'compare_category');
$cate = "<option value='all' class='all atv'>All</option>";
foreach ($mysql as $key => $value) {
$cate .= "<option class='" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "' value = '" . str_replace('&', '', str_replace(' ', '', $value['category'])) . "' >" . $value['category'] . "</option>";
}
return $cate;
}


public function eventMyUploads()
{
    
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

$sql = "SELECT * FROM `myuploads` WHERE `user`='$user' AND `publish` = '1' AND `myuploads`.`file` !='#' AND `myuploads`.`file` !='' AND `myuploads`.`file` !='NULL' ORDER BY `title`";
$data = $this->dbF->getRows($sql);
$li = "";
foreach ($data as $key => $value) {
$li .= '<li class="all blue ' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '" data-eventtype="' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
<div class="ttip" data-toggle="tooltip" title="Update Date: ' . date("d-M-Y", strtotime($value['dateTime'])) . '">(' . date("d-M-Y", strtotime($value['dateTime'])) . ')</div>
' . $value['title'] . '
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
$link = explode(",", $value['file']);
$allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
// foreach ($link as $key => $val) {
// $ext = pathinfo($val, PATHINFO_EXTENSION);
// if (!in_array($ext, $allowed)) {
// $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
// } else {
// $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
// }
// }

  foreach ($link as $key => $val) {

                if ($val == '#' || !$val || $val == '' || $val == 'https://smartdentalcompliance.com/images/') {
                    // echo "hellow";
                    continue;
                    // var_Dump($val);
                    exit();
                }

  $id = base64_encode($value['id']);
        $iddecode = base64_decode($id);

$downLink=base64_encode($val.":s:".date('d'));

                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                      if ($ext == 'el') {

                        // $li .= '<a class="apink" href="' . WEB_URL . '/view-m:' . $iddecode . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                        $li .= '<a class="apink" href="' . WEB_URL . '/pagePrint-'.base64_encode('m:'.$iddecode).'" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    } else {

                        // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';

                        $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    }
                } else {
                   
                    if ($ext != 'el') {

                        // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                        $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                    $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                }
            }
        // $li .='<a href="editevent_print.php?id=' . base64_encode($value['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        // $li .='<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';



$li .= '</div>
</li>';
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0') {
$d = $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'");

$sql = "SELECT `userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`title`,`category`,`type` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `userevent`.`assignto` IN ('-1.$d[0]','$user')  ORDER BY `title`";
} else {
$sql = "SELECT `userevent`.`file` as fl,`userevent`.`dateTime` as `dt`,`title`,`category`,`type` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='1' AND `user`='$user'  ORDER BY `title`";
}
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
if ($value['fl'] == '#' || empty($value['fl'])) {
continue;
}
$li .= '<li class="all blue '. (($value['type'] == 'mandatory') ? 'red ' : '') . str_replace('&', '', str_replace(' ', '', $value['category'])) . '" data-eventtype="' . str_replace('&', '', str_replace(' ', '', $value['category'])) . '">
<div class="col4_main_left1">
<div class="ttip" data-toggle="tooltip" title="Due Date: ' . date("d-M-Y", strtotime(@$value['dt'])) . '">(' . date("d-M-Y", strtotime(@$value['dt'])) . ')</div>
' . $value['title'] . '
</div><!-- col4_main_left1 close -->
';
$li .= '<div class="col4_main_left3">';
$link = explode(",", $value['fl']);
$allowed = array('gif', 'png', 'jpg', 'tiff', 'jpeg', 'bmp', 'webp', 'JPG', 'PNG', 'GIF', 'WEBP', 'TIFF', 'BMP', 'JPEG', 'pdf', 'PDF');
// $id = base64_encode($value['id']);
// $iddecode = base64_decode($id);


   foreach ($link as $key => $val) {
                if ($val == '#' || !$val || $val == '' || $val == WEB_URL.'/images/') {
                    continue;
                }
    $downLink=base64_encode($val.":s:".date('d'));

                $ext = pathinfo($val, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    

                    if ($ext == 'el') {

                        // $li .= '<a class="apink" href="' . WEB_URL . '/view-m:' . $iddecode . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                        $li .= '<a class="apink" href="' . WEB_URL . '/pagePrint-'.base64_encode('m:'.$iddecode).'" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    } else {

                        // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="Download" target="_blank"><i class="fas fa-download"></i></a>';
                        $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '?magic=' . @filemtime($_SERVER['DOCUMENT_ROOT'] . parse_url($val, PHP_URL_PATH)) . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                    }
                } else {
              
                    if ($ext != 'el') {
                        // $li .= '<a class="apink" href="' . WEB_URL . '/d?f=' . $downLink . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                        $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
                    }
                    $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View" target="_blank"><i class="fas fa-file"></i></a>';
                }
            }
        // $li .= '<a href="editevent_print.php?id=' . base64_encode($value['id']) . '" target="_blank" data-toggle="tooltip" title="Print/Save" class="ablue"><i class="fas fa-print"></i></a>';

        // $li .= '<a data-toggle="tooltip" title="View" onclick="editevent(this.id)" id="' . $value['id'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" class="ablue"><i class="fas fa-eye"></i></a>';



// foreach ($link as $key => $val) {
// $ext = pathinfo($val, PATHINFO_EXTENSION);

// if (!in_array($ext, $allowed)) {
// $li .= '<a class="apink" href="http://view.officeapps.live.com/op/view.aspx?src=' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
// } else {
// $li .= '<a class="apink" href="' . $val . '" data-toggle="tooltip" title="View/Download" target="_blank"><i class="fas fa-download"></i></a>';
// }
// }
$li .= '</div>';
$li .= '</li>';
}
echo $li;
}



public function selectAllPracticeData($user)
{
    
$user = intval($user);
$sql = "SELECT * FROM `accounts_user` WHERE `acc_id`='$user'";
$data = $this->dbF->getRow($sql);
if (empty($data)) {
$arry = array();
} else {

 
$arry[] = $data['acc_email'];


$sql = "SELECT * FROM `practiceprofile` WHERE `user_id` =  ? ";
$row = $this->dbF->getRow($sql,array($user));


$arry[] = @$row['practice_name'];
$arry[] = @$row['practice_manager_name'];
$arry[] = @$row['telephone'];
$arry[] = @$row['practice_address'];
 
 
}
return $arry;
}



//myupload dashboard
public function checkHealthForm($user)
{
        
$user = intval($user);
$sql = "SELECT DISTINCT `title_id` FROM `userevent` WHERE `user`='$user'";
$data = $this->dbF->getRows($sql);
if (empty($data)) {
$arry = array();
} else {
foreach ($data as $key => $value) {
$arry[] = $value['title_id'];
}
}
return $arry;
}

public function documentsCount($category)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `userdocuments` WHERE (`expiry_date` > DATE_SUB(CURDATE(), INTERVAL 1 MONTH) OR `expiry_date` IS NULL) AND `user`='$user' AND `category`= ? ";
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `userdocuments` WHERE (`expiry_date` > DATE_SUB(CURDATE(), INTERVAL 1 MONTH) OR `expiry_date` IS NULL) AND `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `category`= ? ";
}
$data = $this->dbF->getRow($sql, array($category));
return $data[0];
}

public function documentInsert_profile_detail()
{

if (isset($_POST['submit'])) {
// if (!$this->getFormToken('documentInsert_profile_detail')) {
// return false;
// }
// var_dump($_POST);
// $this->dbF->prnt($_POST);
// $id       = '-1';
// $title            = empty($_POST['title'])   ? ""    : $_POST['title'];
// $category         = empty($_POST['category'])   ? ""    : $_POST['category'];
// $sub_category     = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category'];
// $user     = empty($_POST['user'])   ? ""    : $_POST['user'];
// $desc     = empty($_POST['desc'])   ? ""    : $_POST['desc'];
// $c_date   = empty($_POST['c_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['c_date']));
// $e_date   = empty($_POST['e_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['e_date']));
// $file       = empty($_POST['file'])      ? ""    : $_POST['file'];
// $file0       = empty($_FILES['document0']['name'])      ? false      : true;
// $file1      = empty($_FILES['document1']['name'])      ? false      : true;
// $file2       = empty($_FILES['document2']['name'])      ? false      : true;
// $file3       = empty($_FILES['document3']['name'])      ? false      : true;
// $file4      = empty($_FILES['document4']['name'])      ? false      : true;
// $filename = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
// $filename0 =  $this->uploadSingleFile(@$_FILES['document0'], 'files', '');
// $filename1 = $this->uploadSingleFile(@$_FILES['document1'], 'files', '');
// $filename2 = $this->uploadSingleFile(@$_FILES['document2'], 'files', '');
// $filename3 = $this->uploadSingleFile(@$_FILES['document3'], 'files', '');
// $filename4 = $this->uploadSingleFile(@$_FILES['document4'], 'files', '');
// if (!empty($filename)) {
// $docname = WEB_URL . "/images/$filename";
// } else {
// $docname = "";
// }
// if (!empty($filename0)) {
// $docname0 = WEB_URL . "/images/$filename0";
// } else {
// $docname0 = "";
// }
// if (!empty($filename1)) {
// $docname1 = WEB_URL . "/images/$filename1";
// } else {
// $docname1 = "";
// }
// if (!empty($filename2)) {
// $docname2 = WEB_URL . "/images/$filename2";
// } else {
// $docname2 = "";
// }
// if (!empty($filename3)) {
// $docname3 = WEB_URL . "/images/$filename3";
// } else {
// $docname3 = "";
// }
// if (!empty($filename4)) {
// $docname4 = WEB_URL . "/images/$filename4";
// } else {
// $docname4 = "";
// }
// for upload files
if (isset($_POST['documentInsert_profile_details'])) {
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$filename = pathinfo($title, PATHINFO_FILENAME);
 $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename); 
$category         = empty($_POST['category'])   ? ""    : $_POST['category'];
$sub_category     = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category'];
$user     = empty($_POST['user'])   ? ""    : $_POST['user'];
$desc     = empty($_POST['desc'])   ? ""    : $_POST['desc'];
$c_date   = empty($_POST['c_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['c_date']));
$e_date   = empty($_POST['e_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['e_date']));
$filename = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
if (!empty($filename)) {
$docname = WEB_URL . "/images/$filename";
} else {
$docname = "";
}
if (!empty($filename0)) {
$docname0 = WEB_URL . "/images/$filename0";
} else {
$docname0 = "";
}
if (!empty($filename1)) {
$docname1 = WEB_URL . "/images/$filename1";
} else {
$docname1 = "";
}
if (!empty($filename2)) {
$docname2 = WEB_URL . "/images/$filename2";
} else {
$docname2 = "";
}
if (!empty($filename3)) {
$docname3 = WEB_URL . "/images/$filename3";
} else {
$docname3 = "";
}
if (!empty($filename4)) {
$docname4 = WEB_URL . "/images/$filename4";
} else {
$docname4 = "";
}
}else{
if (!$this->getFormToken('documentInsert_profile_detail')) {
return false;
}
$title            = empty($_POST['title'])   ? ""    : $_POST['title'];
$category         = empty($_POST['category'])   ? ""    : $_POST['category'];
$sub_category     = empty($_POST['sub_category'])   ? ""    : $_POST['sub_category'];
$user     = empty($_POST['user'])   ? ""    : $_POST['user'];
$desc     = empty($_POST['desc'])   ? ""    : $_POST['desc'];
$c_date   = empty($_POST['c_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['c_date']));
$e_date   = empty($_POST['e_date']) ? date('Y-M-d')    : date('Y-m-d', strtotime($_POST['e_date']));
$file       = empty($_POST['file'])      ? ""    : $_POST['file'];
$file0       = empty($_FILES['document0']['name'])      ? false      : true;
$file1      = empty($_FILES['document1']['name'])      ? false      : true;
$file2       = empty($_FILES['document2']['name'])      ? false      : true;
$file3       = empty($_FILES['document3']['name'])      ? false      : true;
$file4      = empty($_FILES['document4']['name'])      ? false      : true;
$filename = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
$filename0 =  $this->uploadSingleFile(@$_FILES['document0'], 'files', '');
$filename1 = $this->uploadSingleFile(@$_FILES['document1'], 'files', '');
$filename2 = $this->uploadSingleFile(@$_FILES['document2'], 'files', '');
$filename3 = $this->uploadSingleFile(@$_FILES['document3'], 'files', '');
$filename4 = $this->uploadSingleFile(@$_FILES['document4'], 'files', '');
if (!empty($filename)) {
$docname = WEB_URL . "/images/$filename";
} else {
$docname = "";
}
if (!empty($filename0)) {
$docname0 = WEB_URL . "/images/$filename0";
} else {
$docname0 = "";
}
if (!empty($filename1)) {
$docname1 = WEB_URL . "/images/$filename1";
} else {
$docname1 = "";
}
if (!empty($filename2)) {
$docname2 = WEB_URL . "/images/$filename2";
} else {
$docname2 = "";
}
if (!empty($filename3)) {
$docname3 = WEB_URL . "/images/$filename3";
} else {
$docname3 = "";
}
if (!empty($filename4)) {
$docname4 = WEB_URL . "/images/$filename4";
} else {
$docname4 = "";
}
}
$id       = '-1';
try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `userdocuments` (`title_id`,`title`, `category`,`sub_dcategory`, `user`, `file`,`file0`,`file1`,`file2`,`file3`,`file4`,`desc`,`completion_date`, `expiry_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($id, $title, $category, $sub_category, $user, $docname, $docname0, $docname1, $docname2, $docname3, $docname4, $desc, $c_date, $e_date);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end

}
public function documentInsert()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('documentInsert')) {
return false;
}
// var_dump($_POST);
// $this->dbF->prnt($_FILES);
$id       = empty($_POST['id'])     ? ""    : $_POST['id'];
$user     = empty($_POST['user'])   ? ""    : $_POST['user'];
$desc     = empty($_POST['desc'])   ? ""    : $_POST['desc'];
$c_date   = empty($_POST['c_date']) ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['c_date']));
$e_date   = empty($_POST['e_date']) ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['e_date']));



$file       = empty($_POST['file'])      ? ""    : $_POST['file'];

// $img2              = empty($_FILES['team_image']['name'])      ? false      : true;
$file0       = empty($_FILES['document0']['name'])      ? false      : true;
$file1      = empty($_FILES['document1']['name'])      ? false      : true;
$file2       = empty($_FILES['document2']['name'])      ? false      : true;
$file3       = empty($_FILES['document3']['name'])      ? false      : true;
$file4      = empty($_FILES['document4']['name'])      ? false      : true;


$data = $this->dbF->getRow("SELECT * FROM `documents` WHERE `id`= ? ",array($id));
$category = $data['category'];
$sub_dcategory = $data['sub_dcategory'];
$title = $data['title'];
$docname = @$data['file'];
$docname0 = @$data['file0'];
$docname1 = @$data['file1'];
$docname2 = @$data['file2'];
$docname3 = @$data['file3'];
$docname4 = @$data['file4'];


if ($category != 'Signed Policies' && $category != 'MHRA' && $category != 'Minute Meeting') {
$filename = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
$filename0 =  $this->uploadSingleFile(@$_FILES['document0'], 'files', '');
$filename1 = $this->uploadSingleFile(@$_FILES['document1'], 'files', '');
$filename2 = $this->uploadSingleFile(@$_FILES['document2'], 'files', '');
$filename3 = $this->uploadSingleFile(@$_FILES['document3'], 'files', '');
$filename4 = $this->uploadSingleFile(@$_FILES['document4'], 'files', '');
$files = "";
if (!empty($filename)) {
$docname = WEB_URL . "/images/$filename";
$files .= "<a href= '".$docname."' >File 1 </a>"." , ";
} else {
$docname = "";
}
if (!empty($filename0)) {
$docname0 = WEB_URL . "/images/$filename0";
$files .= "<a href= '".$docname0."' >File 2 </a>"." , ";
} else {
$docname0 = "";
}
if (!empty($filename1)) {
$docname1 = WEB_URL . "/images/$filename1";
$files .= "<a href= '".$docname1."' >File 3 </a>"." , ";
} else {
$docname1 = "";
}
if (!empty($filename2)) {
$docname2 = WEB_URL . "/images/$filename2";
$files .= "<a href= '".$docname2."' >File 4 </a>"." , ";
} else {
$docname2 = "";
}
if (!empty($filename3)) {
$docname3 = WEB_URL . "/images/$filename3";
$files .= "<a href= '".$docname3."' >File 5 </a>"." , ";
} else {
$docname3 = "";
}
if (!empty($filename4)) {
$docname4 = WEB_URL . "/images/$filename4";
$files .= "<a href= '".$docname4."' >File 6 </a>"." , ";
} else {
$docname4 = "";
}
$documentsFile = trim($files," , ");
}

try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `userdocuments` (`title_id`,`title`, `category`,`sub_dcategory`, `user`, `file`,`file0`,`file1`,`file2`,`file3`,`file4`,`desc`,`completion_date`, `expiry_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($id, $title, $category, $sub_dcategory, $user, $docname, $docname0, $docname1, $docname2, $docname3, $docname4, $desc, $c_date, $e_date);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {

if ($category == "Recruitment") {
  if (!empty($c_date)) {
        $c_date = date('d-M-Y',strtotime(@$c_date));       
    }
    if (!empty($e_date)) {
        $e_date = date('d-M-Y',strtotime(@$e_date));
    }   
$name  = $this->UserName($user);
$email = $this->UserEmail($user);

$msg ='Hi '.$name.' <br> Category: '.$category.' Title: '.$title.' Completion Date: '.$c_date.' Expiry Date: '.$e_date.' Details: '.$desc.' Files: '.$documentsFile.' 
 <br> Smart Dental Compliance';

$sql  = "SELECT * FROM `notifications` WHERE `type` = 'recruitment' AND `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = 'recruitment'";
$data2 = $this->dbF->getRow($sql2);
$subject = $data2['subject'];
if ($data['push'] == '1') {
$msg2 = $data2['mesaage_notification'];
}

$subject = str_replace('{{name}}', $name, $subject);
$msg2 = str_replace('{{title}}', $title, $msg2);

$msg2 =  strip_tags($msg2);
if ($data['push'] == '1') {
$this->push_notification($subject, $msg2, $this->getUserPlayerId($user));
$sql  = "INSERT INTO `notification_record` (`user`,`type`,`notification`,`playerid`) VALUES (?,?,?,?)";
$array   = array($user, 'recruitment', $msg2, $this->getUserPlayerId($user));
$this->dbF->setRow($sql, $array);
}
if ($data['email'] == '1') {
$this->send_mail($email, "Recruitment (".$title.")", $msg);
}


}
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function documentUpdateExpiry()
{
if (isset($_POST['submit'])) {

    if (!$this->getFormToken('documentUpdateExpiry')) {

    return false;
    }

    $id       = empty($_POST['uid'])      ? ""    : $_POST['uid'];
    $user     = empty($_POST['user'])     ? ""    : $_POST['user'];
    $desc     = empty($_POST['desc'])     ? ""    : $_POST['desc'];
    $c_date   = empty($_POST['c_date'])   ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['c_date']));
    $e_date   = empty($_POST['e_date'])   ? ""    : date('Y-m-d', strtotime($_POST['e_date']));
    $title    = empty($_POST['title'])    ? ""    : $_POST['title'];
    $title_id = empty($_POST['id'])       ? ""    : $_POST['id'];
    $category = empty($_POST['category']) ? ""    : $_POST['category'];
    $sub_dcategory = empty($_POST['sub_dcategory']) ? ""    : $_POST['sub_dcategory'];


    $id=intval($id);
    $user=intval($user);
    htmlspecialchars($desc);
    htmlspecialchars($c_date);
    htmlspecialchars($e_date);
    htmlspecialchars($title);
    htmlspecialchars($title_id);
    htmlspecialchars($category);
    htmlspecialchars($sub_dcategory);

        try { 
        $this->db->beginTransaction();

           $sql = "UPDATE `userdocuments` SET `desc`=?,`completion_date`=?,`expiry_date`=? WHERE `id`=$id";
           $array   = array($desc,$c_date,$e_date);
           $this->dbF->setRow($sql,$array,false);

        // $sql  =   "INSERT INTO `userdocuments` (`title_id`,`title`, `category`,`sub_dcategory`, `user`, `file`,`file0`,`file1`,`file2`,`file3`,`file4`,`desc`,`completion_date`, `expiry_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        // $array   = array($title_id, $title, $category, $sub_dcategory, $user, $docname, $docname0, $docname1, $docname2, $docname3, $docname4, $desc, $c_date, $e_date);
        // $this->dbF->setRow($sql, $array, false);

        $lastId = $this->dbF->rowLastId;
        $this->db->commit();
            if ($this->dbF->rowCount > 0) {
            return true;
            } else {
            return false;
            }
        } catch (Exception $e) {
        $this->db->rollBack();
        $this->dbF->error_submit($e);
        return false;
        }       
    } // If end
}

public function documentUpdate()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('documentUpdate')) {
return false;
}

$id       = empty($_POST['uid'])      ? ""    : $_POST['uid'];
$user     = empty($_POST['user'])     ? ""    : $_POST['user'];
$desc     = empty($_POST['desc'])     ? ""    : $_POST['desc'];
$c_date   = empty($_POST['c_date'])   ? date('Y-m-d')    : date('Y-m-d', strtotime($_POST['c_date']));
$e_date   = empty($_POST['e_date'])   ? ""    : date('Y-m-d', strtotime($_POST['e_date']));
$title    = empty($_POST['title'])    ? ""    : $_POST['title'];
$title_id = empty($_POST['id'])       ? ""    : $_POST['id'];
$category = empty($_POST['category']) ? ""    : $_POST['category'];
$sub_dcategory = empty($_POST['sub_dcategory']) ? ""    : $_POST['sub_dcategory'];
///////////////
$file0       = empty($_FILES['document0']['name'])      ? false      : true;
$file1      = empty($_FILES['document1']['name'])      ? false      : true;
$file2       = empty($_FILES['document2']['name'])      ? false      : true;
$file3       = empty($_FILES['document3']['name'])      ? false      : true;
$file4      = empty($_FILES['document4']['name'])      ? false      : true;

$id=intval($id);
$user=intval($user);
htmlspecialchars($desc);
htmlspecialchars($c_date);
htmlspecialchars($e_date);
htmlspecialchars($title);
htmlspecialchars($title_id);
htmlspecialchars($category);
htmlspecialchars($sub_dcategory);




// $data = $this->dbF->getRow("SELECT * FROM `userdocuments` WHERE `id`='$id'");
// $category = $data['category'];
// $sub_dcategory = $data['sub_dcategory'];
// $docname = $data['file'];
// $docname0 = $data['file0'];
// $docname1 = $data['file1'];
// $docname2 = $data['file2'];
// $docname3 = $data['file3'];
// $docname4 = $data['file4'];

if ($category != 'Signed Policies') {
$filename = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
$filename0 = $this->uploadSingleFile(@$_FILES['document0'], 'files', '');
$filename1 = $this->uploadSingleFile(@$_FILES['document1'], 'files', '');
$filename2 = $this->uploadSingleFile(@$_FILES['document2'], 'files', '');
$filename3 = $this->uploadSingleFile(@$_FILES['document3'], 'files', '');
$filename4 = $this->uploadSingleFile(@$_FILES['document4'], 'files', '');

$files = "";
if (!empty($filename)) {
$docname = WEB_URL . "/images/$filename";
$files .= "<a href= '".$docname."' >File 1 </a>"." , ";
} else {
$docname = "";
}
if (!empty($filename0)) {
$docname0 = WEB_URL . "/images/$filename0";
$files .= "<a href= '".$docname0."' >File 2 </a>"." , ";
} else {
$docname0 = "";
}
if (!empty($filename1)) {
$docname1 = WEB_URL . "/images/$filename1";
$files .= "<a href= '".$docname1."' >File 3 </a>"." , ";
} else {
$docname1 = "";
}
if (!empty($filename2)) {
$docname2 = WEB_URL . "/images/$filename2";
$files .= "<a href= '".$docname2."' >File 4 </a>"." , ";
} else {
$docname2 = "";
}
if (!empty($filename3)) {
$docname3 = WEB_URL . "/images/$filename3";
$files .= "<a href= '".$docname3."' >File 5 </a>"." , ";
} else {
$docname3 = "";
}
if (!empty($filename4)) {
$docname4 = WEB_URL . "/images/$filename4";
$files .= "<a href= '".$docname4."' >File 6 </a>"." , ";
} else {
$docname4 = "";
}
$documentsFile = trim($files," , ");
}

try {
$this->db->beginTransaction();

//    $sql = "UPDATE `userdocuments` SET `file`=?,`desc`=?,`completion_date`=?,`expiry_date`=?,`archive`=? WHERE `id`=$id";
//    $array   = array($docname,$desc,$c_date,$e_date,'1');
//    $this->dbF->setRow($sql,$array,false);

$sql  =   "INSERT INTO `userdocuments` (`title_id`,`title`, `category`,`sub_dcategory`, `user`, `file`,`file0`,`file1`,`file2`,`file3`,`file4`,`desc`,`completion_date`, `expiry_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($title_id, $title, $category, $sub_dcategory, $user, $docname, $docname0, $docname1, $docname2, $docname3, $docname4, $desc, $c_date, $e_date);
$this->dbF->setRow($sql, $array, false);

$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
 if ($category == "Recruitment") {
  if (!empty($c_date)) {
        $c_date = date('d-M-Y',strtotime(@$c_date));       
    }
    if (!empty($e_date)) {
        $e_date = date('d-M-Y',strtotime(@$e_date));
    }   
$name  = $this->UserName($user);
$email = $this->UserEmail($user);

$msg ='Hi '.$name.' <br> Category: '.$category.' Title: '.$title.' Completion Date: '.$c_date.' Expiry Date: '.$e_date.' Details: '.$desc.' Files: '.$documentsFile.' 
 <br> Smart Dental Compliance';

$sql  = "SELECT * FROM `notifications` WHERE `type` = 'recruitment' AND `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = 'recruitment'";
$data2 = $this->dbF->getRow($sql2);
$subject = $data2['subject'];
if ($data['push'] == '1') {
$msg2 = $data2['mesaage_notification'];
}

$subject = str_replace('{{name}}', $name, $subject);
$msg2 = str_replace('{{title}}', $title, $msg2);

$msg2 =  strip_tags($msg2);
if ($data['push'] == '1') {
$this->push_notification($subject, $msg2, $this->getUserPlayerId($user));
$sql  = "INSERT INTO `notification_record` (`user`,`type`,`notification`,`playerid`) VALUES (?,?,?,?)";
$array   = array($user, 'recruitment', $msg2, $this->getUserPlayerId($user));
$this->dbF->setRow($sql, $array);
}
if ($data['email'] == '1') {
$this->send_mail($email, "Recruitment (".$title.")", $msg);
}


}
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function documentAdd()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('documentAdd')) {
return false;
}

$assignto   = empty($_POST['user'])     ? ""    : $_POST['user'];
$title      = empty($_POST['title'])    ? ""    : $_POST['title'];
$category   = empty($_POST['category']) ? ""    : $_POST['category'];
$sub_category   = empty($_POST['sub_category']) ? ""    : $_POST['sub_category'];
$expiry     = empty($_POST['date'])     ? ""    : date('Y-m-d', strtotime($_POST['date']));
$filename   = $this->uploadSingleFile(@$_FILES['document'], 'files', '');
$docname    = "#";
if (!empty($filename)) {
$docname = WEB_URL . "/images/$filename";
}

try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `documents`(
                `title`, `file`,`assignto`,`category`,`sub_dcategory`,`expiry`,`publish`)
                VALUES (?,?,?,?,?,?,?)";

$array   = array($title, $docname, $assignto, $category, $sub_category, $expiry, '1');
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function deleteDocument()
{
    // return true;
$userFrom = $_SESSION['webUser']['id'];

// $id = base64_decode($_GET['id']);


@$idX = base64_decode($_GET['folD']);

$exp = explode("&d=", $idX);
@$id = $exp[0];
@$idDate = $exp[1];
// return $exp;

if($idDate == date('d')){


$sql1 = "SELECT * FROM `userdocuments` WHERE `id`= ? ";
$data =  $this->dbF->getRow($sql1,array($id));

$allData = "";
$smartQuery = "";
// foreach ($data as $key => $val) {
$allData .= "title : $data[title] <br />";
$allData .= "title_id : $data[title_id] <br />";
$allData .= "category : $data[category] <br />";


$file = $data['file'];
$file0 = $data['file0'];
$file1 = $data['file1'];
$file2 = $data['file2'];
$file3 = $data['file3'];
$file4 = $data['file4'];
if (!empty($file)) {
$file = $file . ",";
}
if (!empty($file0)) {
$file0 = $file0 . ",";
}
if (!empty($file1)) {
$file1 = $file1 . ",";
}
if (!empty($file2)) {
$file2 = $file2 . ",";
}
if (!empty($file3)) {
$file3 = $file3 . ",";
}
if (!empty($file4)) {
$file4 = $file4 . ",";
}

$allfiles = $file . $file0 . $file1 . $file2 . $file3 . $file4;
$allfiles = trim($allfiles, ",");


$this->setlog("Document Delete " . $data['title'], $this->UserName($_SESSION['currentUser']) . ' : ' . $_SESSION['currentUser'], $id, $allData.', files :'.$allfiles);
// $path = parse_url($data['file'],PHP_URL_PATH);
// $name = $_SERVER['DOCUMENT_ROOT'].$path;


$smartQuery .= $this->makeRecoverySQL('userdocuments','id',$id);



// ========================TrashData=============================================
$ds = "delete userdocuments File  (title is :" . $data['title'] . ")(category is " . $data['category'] . " )";
$this->TrashData('All HR Files', $ds, $allfiles, $userFrom, $data['user'], 'userdocuments', $id, 'deleteDocument',$smartQuery);
// ========================TrashData=============================================
$sql2  = "DELETE FROM `userdocuments` WHERE id= ? ";
$this->dbF->setRow($sql2, array($id));
if ($this->dbF->rowCount) {
// @unlink($name);

return true;
} else {
return false;
}







}else{

return false;

}
}
public function deleteDocumentallview($id)
{
// return true;

   $smartQuery = '';
$exp = explode("&d=", $id);
@$id = $exp[0];
@$idDate = $exp[1];

if($idDate == date('d')){


$userFrom = $_SESSION['webUser']['id'];

$sql1 = "SELECT * FROM `documents` WHERE `id`= ?";
$data =  $this->dbF->getRow($sql1,array($id));
// $path = $data['file'];
// $path = parse_url($data['file'], PHP_URL_PATH);
// $name = $_SERVER['DOCUMENT_ROOT'] . $path;
  $smartQuery .= $this->makeRecoverySQL('documents','id',$id);

$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$id, $data['title']);
// @unlink($name);
// ========================TrashData=============================================
$ds = "delete documents File (Title :" . $data['title'] . ") (category :" . $data['category'] . " ) (sub category is " . $data['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $data['file'], $userFrom, $data['assignto'], 'documents', $id, 'deleteDocumentall',$smartQuery);
$sql_del = "DELETE FROM `documents` WHERE `id` =  ? ";

$this->dbF->setRow($sql_del, array($id));
// ========================TrashData=============================================

$inIDZ = $this->allINID();
$sql2 = "SELECT * FROM `userdocuments` WHERE `title_id`= ?  and user IN ($inIDZ)";
$data2 =  $this->dbF->getRows($sql2, array($id));
foreach ($data2 as $val) {
$smartQuery = $this->makeRecoverySQL('userdocuments','title_id',$id,'user',$val['user']);
$path = $val['file'];
$path0 = $val['file0'];
$path1 = $val['file1'];
$path2 = $val['file2'];
$path3 = $val['file3'];
$path4 = $val['file4'];

if ($path != '') {
echo "--";

$path = parse_url($val['file'], PHP_URL_PATH);
$name = $_SERVER['DOCUMENT_ROOT'] . $path;

$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file'] . " ) ";


$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);




// @unlink($name);
// ========================TrashData=============================================
$ds = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================


}
if ($path0 != '') {
echo "0";
$path0 = parse_url($val['file0'], PHP_URL_PATH);
$name0 = $_SERVER['DOCUMENT_ROOT'] . $path0;

$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file0'] . " ) ";
$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);



///  @unlink($name0);
// ========================TrashData=============================================
$ds = "All Document Delete file0 (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file0'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================
}

if ($path1 != '') {
echo "1";
$path1 = parse_url($val['file1'], PHP_URL_PATH);
$name1 = $_SERVER['DOCUMENT_ROOT'] . $path1;

$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file1'] . " ) ";
$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);



// @unlink($name1);
// ========================TrashData=============================================
$ds = "All Document Delete file1 (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file1'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================
}

if ($path2 != '') {
echo "2";
$path2 = parse_url($val['file2'], PHP_URL_PATH);
$name2 = $_SERVER['DOCUMENT_ROOT'] . $path2;


$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file2'] . " ) ";
$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);


// @unlink($name2);
// ========================TrashData=============================================
$ds = "All Document Delete file2 (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file2'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================
}

if ($path3 != '') {
echo "3";
$path3 = parse_url($val['file3'], PHP_URL_PATH);
$name3 = $_SERVER['DOCUMENT_ROOT'] . $path3;


$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file3'] . " ) ";
$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);



// @unlink($name3);
// ========================TrashData=============================================
$ds = "All Document Delete file3 (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file3'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================
}
if ($path4 != '') {
echo "4";
$path4 = parse_url($val['file4'], PHP_URL_PATH);
$name4 = $_SERVER['DOCUMENT_ROOT'] . $path4;



$tDESC = "All Document Delete file (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " )(file is " . $val['file4'] . " ) ";
$this->setlog("HR Files deleteDocumentall", $this->UserName($_SESSION['currentUser']) . " : " . $_SESSION['currentUser'],$val['id'], $tDESC);



// @unlink($name4);
// ========================TrashData=============================================
$ds = "All Document Delete file4 (Title :" . $val['title'] . ") (category :" . $val['category'] . " ) (sub category is " . $val['sub_dcategory'] . " ) ";
$this->TrashData('HR Files', $ds, $val['file4'], $userFrom, $val['user'], 'userdocuments', $val['id'], 'deleteDocumentall',$smartQuery);
// ========================TrashData=============================================
}
}



$sql2  = "DELETE FROM `userdocuments` WHERE  title_id =  ?   and user IN ($inIDZ)";
$data2 = $this->dbF->setRow($sql2 , array($id));

if ($data > 0) {
return true;
} else {
return false;
}






}else{

    return false;
}





}





public function allINID (){


 
                if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                    $user = intval($_SESSION['superid']);
                    $sql = "SELECT * FROM `accounts_user` WHERE `acc_id`= ? ";
                    $data = $this->dbF->getRows($sql,array($user));
                }
                else{
                    $user = intval($_SESSION['currentUser']);
                    $sql = "SELECT * FROM `accounts_user` WHERE  `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')  ORDER BY `acc_type` DESC, `acc_name` ASC ";
                    $data = $this->dbF->getRows($sql);
                }

                $q = "";
                foreach ($data as $key => $value) {
                $deactive = "";
                $userid = $value['acc_id'];
                $name  = $value['acc_name'];
                $image = $value['acc_image'];
                $data2 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userid' AND `setting_name`='role'");
                $role = $data2[0];
                // if($value['acc_type'] == '0'){
                //     $deactive = "<div class='deactive'>DeActive</div>";
                // }
               

                //  $image = $value['acc_image'];
               
                //  $iamge2 = "logo.png";
                //   if ($image == "#"||trim($image) == "" ) 
                // {
                //      @$image = @$image2;
                //     @$image = "webImages/d-profile.png";
                //  }
                //  else
                //  {
                     
                //     $image = $functions->resizeImage($value['acc_image'], 'auto',400, false);
                    
                 
                     
                //  }
             $q .=  $value['acc_id'].",";
                }



           $q =    trim($q, ",");
             
return $q;

}
public function deleteDocumentall()
{

//   $id = @$_GET['alldocumentid'];



// $idd = base64_decode($_GET['alldocumentid']);

if(isset($_GET['alldocumentidFolder'])){


@$idX = base64_decode($_GET['alldocumentidFolder']);
}elseif(isset($_GET['alldocumentidPD'])){
@$idX = base64_decode($_GET['alldocumentidPD']);

}


$exp = explode("&d=", $idX);
// var_dump($exp);
@$idd = $exp[0];
@$idDate = $exp[1];






$sql3 = "SELECT * FROM `documents` WHERE `id`= ? ";
$data3 =  $this->dbF->getRow($sql3,array($idd));




$assignto = $data3['assignto'];
if ($assignto == 'all:' . $_SESSION['currentUser']) {

$explode = explode(':', $assignto);
$ex = $explode[1];
} else {

$ex = $data3['assignto'];
$ex;
}



@$_SESSION['superUser']['hruser'];
$currentUser =   $_SESSION['currentUser'];

if ($idd > 0) {




if (@$_SESSION['currentUserType'] == 'Employee' || @$_SESSION['superUser']['hruser'] == 'full') {
// $user = $_SESSION['superid'];
// $SuperPracticeId = $this->PracticeId($user);

// echo $_SESSION['currentUser'];
// var_dump($assignto);
// var_dump($_SESSION['currentUser']);
// echo "<br>";
// echo $ex;
// var_dump($ex);

// die;


// if ($_SESSION['currentUser'] == $ex) {
//echo "i m Employe And super User";
echo  $return = $this->deleteDocumentallview($idX);

// if ($return  == true) 
// {
//    echo "<script> location.replace('".WEB_URL."/profile-detail?user=$_SESSION[webUser][id]'); </script>";

// }

// }
}


if ($_SESSION['webUser']['account_type'] == 'Master') {
// "i m Master";
echo  $return = $this->deleteDocumentallview($idX);
// if ($return  == true) 
//  {
//     echo "<script> location.replace('".WEB_URL."/profile-detail?user=$_SESSION[webUser][id]'); </script>";

//  }
}


if ($_SESSION['currentUserType'] == 'Practice') {  // echo "i m Practice";
echo  $return = $this->deleteDocumentallview($idX);
//    if ($return  == true) 
// {
//   echo "<script> location.replace('".WEB_URL."/profile-detail?user=$_SESSION[webUser][id]'); </script>";

// }
}


}

// if ($title_id  != '') {          

// }  

// else
// {
//      $sql1 = "SELECT `file`,`title` FROM `documents` WHERE `id`='$id'";
//        $data =  $this->dbF->getRow($sql1);
//         $path = $data['file'];
//        $path = parse_url($data['file'],PHP_URL_PATH);
//        $name = $_SERVER['DOCUMENT_ROOT'].$path;

//         $sql_del = "DELETE FROM `documents` WHERE `id` = '$id'";
//         $this->dbF->setRow($sql_del);
//        $this->setlog("All Document Delete",$this->UserName($_SESSION['currentUser'])." : ".$_SESSION['currentUser'],"",$data['title']);
//        @unlink($name);

// }

}

// hr hub

public function covid()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('covid')) {
return false;
}
$q1  = empty($_POST['q1'])    ? "No"  :   $_POST['q1'];
$q1c = empty($_POST['q1c'])   ? ""    :   $_POST['q1c'];
$q2  = empty($_POST['q2'])    ? "No"  :   $_POST['q2'];
$q2c = empty($_POST['q2c'])   ? ""    :   $_POST['q2c'];
$q3  = empty($_POST['q3'])    ? "No"  :   $_POST['q3'];
$q3c = empty($_POST['q3c'])   ? ""    :   $_POST['q3c'];
$q4  = empty($_POST['q4'])    ? "No"  :   $_POST['q4'];
$q4c = empty($_POST['q4c'])   ? ""    :   $_POST['q4c'];
$q5  = empty($_POST['q5'])    ? "No"  :   $_POST['q5'];
$q5c = empty($_POST['q5c'])   ? ""    :   $_POST['q5c'];
$date = date("Y-m-d");
htmlspecialchars($q1);
htmlspecialchars($q1c);
htmlspecialchars($q2);
htmlspecialchars($q2c);
htmlspecialchars($q3);
htmlspecialchars($q3c);
htmlspecialchars($q4);
htmlspecialchars($q4c);
htmlspecialchars($q5);
htmlspecialchars($q5c);
htmlspecialchars($date);
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();
$sql = "INSERT INTO `covid`(`q1`,`q1c`,`q2`,`q2c`,`q3`,`q3c`,`q4`,`q4c`,`q5`,`q5c`,`user`,`date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$array  = array($q1, $q1c, $q2, $q2c, $q3, $q3c, $q4, $q4c, $q5, $q5c, $user, $date);
$this->dbF->setRow($sql, $array, false);
if ($q1 == 'Yes' || $q2 == 'Yes' || $q3 == 'Yes') {
$this->notifications('covid');
}
return true;
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}
}


public function pin()
{
$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `practiceprofile` WHERE `user_id`='$user' and pinVarification = '1'";
$this->dbF->getRow($sql);
if ($this->dbF->rowCount > 0) {



if (@$_COOKIE['again'] != 'true') {
echo "<style>
.header_side,#loader{
display: none !important;
}
</style>
<div class='login_page pin_page'>
<div class='login_page_main'>
<div class='login-center'>
<div class='content_logo'>
    <a href='" . WEB_URL . "'>
        <h1>Dental Community<span>Compliance &amp; Training</span></h1>
        <h4>Please insert pin to continue in your account</h4>
    </a>
</div>
<div class='login_main' id='login_form'>
<div class='form-group fa-key'>
    <input type='password' name='pin' placeholder='Pin' maxlength='6' autocomplete='off'>
    <button type='button'><i class='fa fa-arrow-right'></i></button>
</div>
<div id='errmsg'></div>
</div>
</div>
</div>
</div>
<script>
$('input[name=pin],button').on('keyup click', function() {
$('#errmsg').text();
pin = $('input[name=pin]').val();
if(pin.length == 6){
$.ajax({
type: 'post',
data: {pin:pin},
url: 'ajax_call.php?page=again_login',                
}).done(function(data) {
if (data == '1') {
    location.reload();
}
else{
    $('#errmsg').text(data);
}
});
} else{
$('#errmsg').text('');
}
});
</script>";
exit();
}


}
}



public function insertRoomsEDIT($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (isset($_POST['submit'])) {
if (!$this->getFormToken('insertRoomsEDIT') && $apiPostData == "") {
return false;
}


$changename      = empty($_POST['changename'])     ? ""    : $_POST['changename'];
$changedesc      = empty($_POST['changedesc'])     ? ""    : $_POST['changedesc'];
$changeColor      = empty($_POST['changeColor'])     ? ""    : $_POST['changeColor'];
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];

try {
$this->db->beginTransaction();
 
$user = $_SESSION['webUser']['id'];
  
 

// $sql = "UPDATE `insertRooms` SET `name` = '$changename' , `color` = '$changeColor', `desc` = '$changedesc' WHERE `insertRooms`.`id` = '$refId'";
// $this->dbF->setRow($sql);
$sql = "UPDATE `insertRooms` SET `name` =? , `color` = ?, `desc` = ? WHERE `insertRooms`.`id` =  ? ";
$array   = array($changename , $changeColor,$changedesc, $refId);
$this->dbF->setRow($sql, $array, false);




$this->setlog("Room management data is changed", $this->UserName($user) . " : " . $user, $refId, $changename.'-'.$changedesc.'-'.$changeColor);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} // If end
}

public function practiceProfile($apiPostData = "")
{


if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {

if (!$this->getFormToken('practiceProfile') && $apiPostData == "") {
return false;
}



 // var_dump($_POST);


$dayoff = empty($_POST['dayoff']) ? array() : $_POST['dayoff'];




//  $temp = "";

// for($i=0 ; $i<count($dayoff) ; $i++) {

// echo  $dayoff[$i];

// $offdays  = $dayoff[$i];
// $temp .= $offdays.",";


// }
// $temp=rtrim($temp,', ');


if ($apiPostData != "") {
$day=$dayoff;
}else{
$day = implode(",", $dayoff);
    
}

$day = trim($day,",");


 $pinVarification    = empty($_POST['pinVarification'])    ? "0"  : $_POST['pinVarification'];
$practice_name    = empty($_POST['practice_name'])    ? ""  : $_POST['practice_name'];
$subt_name    = empty($_POST['subt_name'])    ? ""  : $_POST['subt_name'];
$practice_manager_name    = empty($_POST['practice_manager_name'])    ? ""  : $_POST['practice_manager_name'];
$practice_address = empty($_POST['practice_address']) ? ""  : $_POST['practice_address'];
$telephone        = empty($_POST['telephone'])        ? ""  : $_POST['telephone'];
$staff            = empty($_POST['staff'])            ? ""  : $_POST['staff'];
$information      = empty($_POST['information'])      ? ""  : $_POST['information'];
$surgeries        = empty($_POST['surgeries'])        ? ""  : $_POST['surgeries'];
$room             = empty($_POST['room'])             ? ""  : $_POST['room'];
$autoclave        = empty($_POST['autoclave'])        ? ""  : $_POST['autoclave'];
$disinfectors     = empty($_POST['disinfectors'])     ? ""  : $_POST['disinfectors'];
$ultrasonic       = empty($_POST['ultrasonic'])       ? ""  : $_POST['ultrasonic'];
$compressor       = empty($_POST['compressor'])       ? ""  : $_POST['compressor'];
$sedation         = empty($_POST['sedation'])         ? ""  : $_POST['sedation'];
$npm              = empty($_POST['npm'])              ? ""  : $_POST['npm'];
$domiciliary      = empty($_POST['domiciliary'])      ? ""  : $_POST['domiciliary'];

$number_of_radiation_machines      = empty($_POST['number_of_radiation_machines'])      ? ""  : $_POST['number_of_radiation_machines'];
$serial_number      = empty($_POST['serial_number'])      ? ""  : $_POST['serial_number'];
$name_of_RPA_advisor      = empty($_POST['name_of_RPA_advisor'])      ? ""  : $_POST['name_of_RPA_advisor'];
$name_of_RPA_supervisor      = empty($_POST['name_of_RPA_supervisor'])      ? ""  : $_POST['name_of_RPA_supervisor'];
$Last_service_date      = empty($_POST['Last_service_date'])      ? ""  : $_POST['Last_service_date'];
$laser_protection_advisor      = empty($_POST['laser_protection_advisor'])      ? ""  : $_POST['laser_protection_advisor'];



$user             = $_SESSION['currentUser'];
$img1              = empty($_FILES['practice_logo']['name'])   ? false      : true;
$img2              = empty($_FILES['team_image']['name'])      ? false      : true;

$old_practice_logo = empty($_POST['old_practice_logo'])        ? "#"        : $_POST['old_practice_logo'];
$practice_logo     = $old_practice_logo;
$old_team_image    = empty($_POST['old_team_image'])           ? "#"        : $_POST['old_team_image'];
$team_image        = $old_team_image;


// htmlspecialchars($practice_name);
// htmlspecialchars($subt_name);
// htmlspecialchars($practice_manager_name);
// htmlspecialchars($practice_address);
// htmlspecialchars($telephone);
// htmlspecialchars($staff);
// htmlspecialchars($information);
// htmlspecialchars($surgeries);
// htmlspecialchars($room);
// htmlspecialchars($autoclave);
// htmlspecialchars($disinfectors);
// htmlspecialchars($ultrasonic);
// htmlspecialchars($compressor);
// htmlspecialchars($sedation);
// htmlspecialchars($npm);
// htmlspecialchars($domiciliary);
// htmlspecialchars($number_of_radiation_machines);
// htmlspecialchars($serial_number);
// htmlspecialchars($name_of_RPA_advisor);
// htmlspecialchars($name_of_RPA_supervisor);
// htmlspecialchars($Last_service_date);
// htmlspecialchars($user);
// htmlspecialchars($img1);
// htmlspecialchars($img2);
// htmlspecialchars($old_practice_logo);
// htmlspecialchars($practice_logo);



if ($img1) {
$this->deleteOldSingleImage($old_practice_logo);
$practice_logo = $this->uploadSingleImage($_FILES['practice_logo'], 'practice profiles');
}

if ($img2) {
$this->deleteOldSingleImage($old_team_image);
$team_image = $this->uploadSingleImage($_FILES['team_image'],'practice profiles');
}

try {
$this->db->beginTransaction();
$sql  = "UPDATE `practiceprofile` SET `practice_name`=?,`practice_manager_name`=?, `practice_address`=?, `telephone`=?, `staff`=?, `information`=?, `surgeries`=?, `room`=?, `autoclave`=?, `disinfectors`=?, `ultrasonic`=?, `compressor`=?, `npm`=?, `sedation`=?, `domiciliary`=?, `practice_logo`=?, `team_image`=?, `dayoff`=?,`subtname`=?, `number_of_radiation_machines`=?,`serial_number`=?,`name_of_RPA_advisor`=?,`name_of_RPA_supervisor`=?,`Last_service_date`=?,`laser_protection_advisor`=?,`pinVarification`=? WHERE user_id = '$user'";

$array   = array($practice_name, $practice_manager_name, $practice_address, $telephone, $staff, $information, $surgeries, $room, $autoclave, $disinfectors, $ultrasonic, $compressor, $npm, $sedation, $domiciliary, $practice_logo, $team_image, $day, $subt_name, $number_of_radiation_machines, $serial_number, $name_of_RPA_advisor, $name_of_RPA_supervisor, $Last_service_date,$laser_protection_advisor, $pinVarification);
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();

// $this->dbF->prnt($array);


// $this->dbF->prnt($this->dbF->rowCount);
if ($this->dbF->rowCount > 0) {


    




$this->setlog("Practice Profile Update", $this->UserName($user) . " : " . $user,"", "Practice Name : " . $practice_name);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}


public function onboardingForm($apiPostData = "")
{


if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {

if (!$this->getFormToken('onboardingForm') && $apiPostData == "") {
return false;
}


$policies = empty($_POST['policies']) ? "" : $_POST['policies'];
$welcome_text = empty($_POST['welcome_text']) ? "" : serialize($_POST['welcome_text']);


if ($apiPostData != "") {
$policiesString=$policies;
}else{
$policiesString = implode(",", $policies);
    
}

$policiesString = trim($policiesString,",");

$user             = intval($_SESSION['currentUser']);

$img1              = empty($_FILES['welcome_image']['name'])   ? false      : true;
$old_welcome_image = empty($_POST['old_welcome_image'])        ? "#"        : $_POST['old_welcome_image'];
$welcome_image     = $old_welcome_image;

htmlspecialchars($user);
htmlspecialchars($img1);
htmlspecialchars($old_welcome_image);
htmlspecialchars($welcome_image);



if ($img1) {
$this->deleteOldSingleImage($old_welcome_image);
$welcome_image = $this->uploadSingleImage($_FILES['welcome_image'], 'onboarding image');
}

try {
$this->db->beginTransaction();
$sql  = "UPDATE `practiceprofile` SET `welcome_image` =?,`welcome_text`=?,`signec_policies`=? WHERE `user_id` = '$user'";

$array   = array($welcome_image,$welcome_text,$policiesString);
$this->dbF->setRow($sql, $array, false);

$this->db->commit();

if ($this->dbF->rowCount > 0) {

$this->setlog("Onboarding Page Data Updated", $this->UserName($user) . " : " . $user,"","");
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}


public function insertRooms($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (!empty($_POST['add_room_name'])) {

$add_room_name         = empty($_POST['add_room_name'])         ? ""  : $_POST['add_room_name'];
$changeColor              = empty($_POST['changeColor'])              ? ""  : $_POST['changeColor'];
$add_room_desc              = empty($_POST['add_room_desc'])              ? ""  : $_POST['add_room_desc'];
$practiceID             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);


try {
$this->db->beginTransaction();


 $this->dbF->setRow("INSERT INTO `insertRooms`(`loginid`,`practiceID`,`name`,`color`,`desc`) VALUES(?,?,?,?,?)", array($loginid,$practiceID,$add_room_name,$changeColor,$add_room_desc));

// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("room is inserted", $this->UserName($loginid) . " : " . $this->UserName($practiceID),"", "Name : " . $add_room_name."Desc : " . $add_room_desc."Color : " . $changeColor);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end

}

public function insertDirectory($apiPostData = "")
{

if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (!empty($_POST['add_directory_name']) && !empty($_POST['add_directory_contact'])) {
// var_dump($_POST);
$add_directory_name         = empty($_POST['add_directory_name'])         ? ""  : $_POST['add_directory_name'];
$add_directory_contact              = empty($_POST['add_directory_contact'])              ? ""  : $_POST['add_directory_contact'];
$practiceID             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);
try {
$this->db->beginTransaction();


 $this->dbF->setRow("INSERT INTO `insertDirectory`(`loginid`,`practiceID`,`name`,`phone`) VALUES(?,?,?,?)", array($loginid,$practiceID,$add_directory_name,$add_directory_contact));

// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Directory is inserted", $this->UserName($loginid) . " : " . $this->UserName($practiceID),"", "Name : " . $add_directory_name."Contact : " . $add_directory_contact);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function totalUsers()
{
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1'";
$data = $this->dbF->getRow($sql);
return $data[0];
}


public function presentUsers()
{
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `record` WHERE `userId` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `checkin`!=''  AND `date`=CURDATE()";
$data = $this->dbF->getRow($sql);
return $data[0];
}

public function pendingLeave()
{
$user = intval($_SESSION['currentUser']);
// $sql = "SELECT COUNT(*) FROM `leaves` WHERE `fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `status`='pending'";
$sql="SELECT COUNT(*) FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')  AND `acc_type`='1' )OR `fill_user` = '$user') AND (status = '' OR  status = 'pending')";
$data = $this->dbF->getRow($sql);
return $data[0];
}

public function absentTodayCount($limit = false)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT COUNT(*) FROM `record` WHERE `userId` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `date`=CURDATE() AND `checkin`=''";
$data = $this->dbF->getRow($sql);
echo $data[0];
}

public function absentToday($limit = false)
{
if ($limit != '') {
$limit = " ORDER BY `date` LIMIT $limit";
}

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT * FROM `record` WHERE `userId` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `date`=CURDATE() AND `checkin`='' $limit";
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
echo "<tr>
    <td>" . $this->UserName($value['userId']) . "</td>
</tr>";
}
}

public function absentRequestCount($limit = false)
{

//  $status ="AND (status = '' OR  status = 'pending')";
if ($limit != '') {
$limit = " ORDER BY `from_date` LIMIT $limit";
//   $status ="";
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `fill_user`='$user'";
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')  AND `acc_type`='1' )OR `fill_user` = '$user') AND (status = '' OR  status = 'pending')  $limit";
}
$data = $this->dbF->getRow($sql);
echo $data[0];
}


public function absentRequest($limit = false)
{
if ($limit != '') {
$limit = " ORDER BY `from_date` LIMIT $limit";
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$display = 'style="display:none;"';
$sql = "SELECT * FROM `leaves` WHERE `fill_user` IN ('$user','$_SESSION[currentUser]:$user')  $limit";
} else {
$display = null;
$user = intval($_SESSION['currentUser']);
// $sql = "SELECT * FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')  AND `acc_type`='1' )OR `fill_user` = '$user') AND status = 'pending'  ORDER BY `from_date` LIMIT 10"; 
$sql = "SELECT * FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')  AND `acc_type`='1' )OR `fill_user` = '$user')  AND (status = '' OR  status = 'pending')  $limit";
}
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
echo "<tr>
    <td $display>" . $this->UserName($value['fill_user']) . "</td>
    <td>$value[type]</td>
    <td>$value[hours]</td>
    <td>" . date('d-M-Y', strtotime($value['from_date'])) . " - " . date('d-M-Y', strtotime($value['to_date'])) . "</td>
    <td>$value[status]</td>
    <td ><button $display style='display: inherit; vertical-align: middle;' class='edit_btn' id='$value[id]' onclick='leaves(this.id)'><i class='fas fa-edit'></i></button>
   
 

   <button  style='display: inherit; vertical-align: middle;' data-id='$value[id]' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' >
                <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
            </button>
    </td>
</tr>";
}
}

public function sickCount($limit = false)
{
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `fill_user` = '$user' AND `dateTime` = date(NOW())  AND  `type`='Sick'";
} else {
$user = intval($_SESSION['currentUser']);

$sql = "SELECT COUNT(*) FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1')OR `fill_user` = '$user') AND `dateTime` = date(NOW())  AND  `type`='Sick'";
}
$data = $this->dbF->getRow($sql);
echo $data[0];
}

public function sick($limit = false)
{
if ($limit != '') {
$limit = " ORDER BY `from_date` LIMIT $limit";
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT * FROM `leaves` WHERE (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1')OR `fill_user` = '$user') AND `dateTime` = date(NOW())  AND  `type`='Sick'  $limit";
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
echo "<tr>
<td>" . $this->UserName($value['fill_user']) . "</td>
</tr>";
}
}

public function lieuRequestCount($limit = false)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `lieu` WHERE `user`='$user'";
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `lieu` WHERE `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') OR `user` = '$user'";
}
$data = $this->dbF->getRow($sql);
echo $data[0];
}




public function lieuRequest($limit = false)
{
if ($limit != '') {
$limit = " ORDER BY `dateTime` LIMIT $limit";
}
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$display = 'style="display:none;"';
$sql = "SELECT * FROM `lieu` WHERE `user`='$user' $limit ";
} else {
$display = null;
$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `lieu` WHERE `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') OR `user` = '$user' $limit";
}

$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
echo "<tr>
    <td $display>" . $this->UserName($value['user']) . "</td>
    <td>$value[type]</td>
    <td>$value[hours]</td>
    <td>$value[status]</td>
    <td>$value[txtNote]</td>
    <td>$value[DdateTime]</td>
    <td $display><button class='edit_btn' id='$value[id]' onclick='lieuform(this.id)'><i class='fas fa-edit'></i></button></td>
</tr>";
}
}

public function lateCount($limit = false)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

$sql = "SELECT COUNT(*) FROM `record` WHERE (`userId` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') OR `userId` = '$user') AND `date`=CURDATE()  AND `checkin`> `timeFrom` AND`checkin`!='' LIMIT 10"; //IF(`checkin` = '' || `checkin` > `timeFrom`,TRUE,FALSE) as start,
$data = $this->dbF->getRow($sql);
echo $data[0];
}

public function late()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT * FROM `record` WHERE (`userId` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') OR `userId` = '$user') AND `date`=CURDATE()  AND `checkin`> `timeFrom` AND`checkin`!='' LIMIT 10";
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
$time1 = new DateTime($value['timeFrom']);
$time2 = new DateTime($value['checkin']);
$timediff = $time1->diff($time2);
$late = $timediff->format('%h hour %i minute');


if ($late < $value['timeFrom']) {
continue;
}
if ($late < $value['timeFrom']) {
// continue;
echo "<tr>
<td>" . $this->UserName($value['userId']) . "</td>
<td>$value[checkin]</td>
<td>$late</td>
</tr>";
}
}
}

public function rotaStatus()
{
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
$display = null;
$sql = "SELECT * FROM `rotaStatus` WHERE `user`='$user'";
} else {
$display = 'style="display:none;"';
$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `rotaStatus` WHERE `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') LIMIT 10";
}
$data = $this->dbF->getRows($sql);
foreach ($data as $key => $value) {
$date = date('d-M-Y', strtotime($value['week'])) . "&nbsp;&nbsp;to&nbsp;&nbsp;" . date('d-M-Y', strtotime("$value[week] +7 day"));
echo "<tr>
    <td>" . $this->UserName($value['user']) . "</td>
    <td>$date</td>
    <td>$value[status]</td>
    <td $display><button class='edit_btn' id='$value[id]'>Comfirm</button></td>
</tr>";
}
}

public function UsersCalendar()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql1 = "SELECT CONCAT_WS('', `a`.`acc_name`, '-',

CONCAT(TIME_FORMAT(`r`.`timeFrom`, '%H:%i'), ' - ', TIME_FORMAT(`r`.`timeTo`, '%H:%i'))
) AS `title`, '\n',
(SELECT `setting_val`
FROM `accounts_user_detail`
WHERE `id_user`=`a`.`acc_id`
AND `setting_name`='role' ) AS `n_title`,'\n',
(SELECT `acc_name`
FROM `accounts_user`
WHERE `acc_id`=`r`.`dentist_id`)AS `d_title`,'\n',
CONCAT(TIME_FORMAT(`r`.`timeFrom`, '%H:%i'), ' - ', TIME_FORMAT(`r`.`timeTo`, '%H:%i')) AS `RotaTime`,
`r`.`date` AS `start`,
'ROTA' AS `sqltype`,
`r`.`rotaComment` AS `rotaComment`,
`r`.`color` AS `color`,
`a`.`acc_image` AS `image`
FROM `record` `r`
JOIN `accounts_user` `a` ON `r`.`userId` = `a`.`acc_id`
WHERE `r`.`userId`= '$user'AND `rotaOff` NOT IN('Holiday','Day Off','Sick') AND  `r`.`timeFrom` !='00:00' AND `r`.`timeTo` !='00:00' ";



$sql2 = "SELECT
  
`title`,
`from_date` AS `start`,
`to_date` AS `end`,
IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,
`type` AS `type`,
'LEAVES' AS `sqltype`,
`id` AS `id`,
`fill_user` AS `filluser`,
'leaves(this.id)' as `click`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`,
`acc_name` AS `n_name`

FROM `leaves` `l`
JOIN `accounts_user` `a` ON `l`.`fill_user` = `acc_id`
WHERE `fill_user`='$user'"; //AND status = 'accepted'


$sql3 = "SELECT
CONCAT_WS('Working Aniversery-',SPACE(3),`a`.`acc_name`) AS `title`,
IF( YEAR(`setting_val`) =  YEAR(CURDATE()) , DATE_ADD(STR_TO_DATE(`setting_val`,'%Y-%m-%d'), INTERVAL 1 year),  CONCAT(YEAR(`setting_val`), '-', MONTH(`setting_val`), '-', DAY(`setting_val`) ) ) as start,
'#b84487' as `color`,
'anyv' AS `anytype`,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id`
WHERE id_user = '$user'  AND `setting_name`='start_date' AND `setting_val` !='' ";

$sql4 = "SELECT  
CONCAT_WS('Birthday-',SPACE(3),`a`.`acc_name`)  AS `title`,
DATE_FORMAT(`setting_val`,'%Y-%m-%d') AS `start`,
'#b84487' as `color`,
  'bday' AS `birth`,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id` WHERE  id_user = '$user'  AND setting_name ='date_of_birth' AND setting_val !=''";


$sql5 = "SELECT
CONCAT_WS('Appraisal Reminder-',SPACE(3),`a`.`acc_name`) AS `title`,
IF( YEAR(`setting_val`) =  YEAR(CURDATE()) , DATE_ADD(STR_TO_DATE(`setting_val`,'%Y-%m-%d'), INTERVAL 1 year),  CONCAT(YEAR(`setting_val`), '-', MONTH(`setting_val`), '-', DAY(`setting_val`) ) ) as start,
'#b84487' as `color`,

  'apr' AS `appr`,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id`
WHERE id_user = '$user' AND `setting_name`='start_date' AND `setting_val` !='' GROUP BY `id_user` 
";
} else {
$user = intval($_SESSION['currentUser']);
// $sql = "SELECT CONCAT_WS('', `a`.`acc_name`, '\n',
// (SELECT `setting_val`
//  FROM `accounts_user_detail`
//  WHERE `id_user`=`a`.`acc_id`
//    AND `setting_name`='role' ),'\n',
// (SELECT `acc_name`
//  FROM `accounts_user`
//  WHERE `acc_id`=`r`.`dentist_id`),'\n',
//  if(`r`.`timeFrom` IS NULL OR `r`.`timeFrom` = '00:00','N|A',CONCAT(TIME_FORMAT(`r`.`timeFrom`, '%H:%i'), ' - ', TIME_FORMAT(`r`.`timeTo`, '%H:%i')))
//  ) AS `title`,
// `r`.`date` AS `start`,
// `a`.`acc_image` AS `image`
// FROM `record` `r`
// JOIN `accounts_user` `a` ON `r`.`userId` = `a`.`acc_id`
// WHERE `r`.`userId` IN
// (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1')";

$sql1 = "SELECT CONCAT_WS('', `a`.`acc_name`, '  ',

CONCAT(TIME_FORMAT(`r`.`timeFrom`, '%H:%i'), ' - ', TIME_FORMAT(`r`.`timeTo`, '%H:%i'))
) AS `title`, '\n',
(SELECT `setting_val`
FROM `accounts_user_detail`
WHERE `id_user`=`a`.`acc_id`
AND `setting_name`='role' ) AS `n_title`,'\n',
IF((SELECT `acc_name`
FROM `accounts_user`
WHERE `acc_id`=`r`.`dentist_id` )!= '', (SELECT `acc_name`
FROM `accounts_user`
WHERE `acc_id`=`r`.`dentist_id` ),'N/A')  AS `d_title`,'\n',
CONCAT(TIME_FORMAT(`r`.`timeFrom`, '%H:%i'), ' - ', TIME_FORMAT(`r`.`timeTo`, '%H:%i')) AS `RotaTime`,
`r`.`date` AS `start`,
'ROTA' AS `sqltype`,
`r`.`rotaComment` AS `rotaComment`,
`r`.`color` AS `color`,
`a`.`acc_image` AS `image`
FROM `record` `r`
JOIN `accounts_user` `a` ON `r`.`userId` = `a`.`acc_id`
WHERE `r`.`userId` IN
(SELECT `acc_id` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1') AND `r`.`timeFrom` !='00:00' AND `r`.`timeTo` !='00:00' AND `rotaOff` NOT IN('Holiday','Day Off','Sick')";




$sql2 = "SELECT
            CONCAT_WS('', `a`.`acc_name`, '-',

CONCAT('(',`l`.`type`, ')')
) AS `title`, '\n',


`from_date` AS `start`,
`to_date` AS `end`,
IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,
`type` AS `type`,
'LEAVES' AS `sqltype`,
`id` AS `id`,
`fill_user` AS `filluser`,
'leaves(this.id)' as `click`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`,
`acc_name` AS `n_name`

FROM `leaves` `l`
JOIN `accounts_user` `a` ON `l`.`fill_user` = `acc_id`
WHERE `user` IN (SELECT `id_user`FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under')OR `user`='$user'"; //AND status = 'accepted'



$sql3 = "SELECT

IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'), CONCAT_WS('Working Aniversery-',SPACE(3),`a`.`acc_name`),CONCAT('Please correct ',`a`.`acc_name`,' start date'))AS 'title',   


IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'),IF( YEAR(`setting_val`) =  YEAR(CURDATE()) , DATE_ADD(STR_TO_DATE(`setting_val`,'%Y-%m-%d'), INTERVAL 1 year),  CONCAT(YEAR(`setting_val`), '-', MONTH(`setting_val`), '-', DAY(`setting_val`) ) ),  DATE_FORMAT(NOW(), '%Y-%m-%d') ) AS `start`,
'#b84487' as `color`,
  'anyv' AS `anytype`,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id`
WHERE (id_user IN (SELECT `id_user` FROM `accounts_user_detail` `l`  JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id` WHERE `setting_val`='$user' AND `setting_name`='account_under') OR id_user = '$user' ) AND (`setting_name`='start_date' AND `setting_val` !='' )  GROUP BY `id_user`  ";

$sql4 = "SELECT  
IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'), CONCAT_WS('Birthday-',SPACE(3),`a`.`acc_name`),CONCAT('Please correct ',`a`.`acc_name`,' Birthday date'))AS 'title',  

IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'),IF( YEAR(`setting_val`) =  YEAR(CURDATE()) , DATE_ADD(STR_TO_DATE(`setting_val`,'%Y-%m-%d'), INTERVAL 1 year),  CONCAT(YEAR(`setting_val`), '-', MONTH(`setting_val`), '-', DAY(`setting_val`) ) ),  DATE_FORMAT(NOW(), '%Y-%m-%d') ) AS `start`,
'#b84487' as `color`,
  'bday' AS `birth`,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id` WHERE (id_user IN (SELECT `id_user` FROM `accounts_user_detail` `l`  JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id` WHERE `setting_val`='$user' AND `setting_name`='account_under') OR id_user = '$user' )   AND setting_name ='date_of_birth' AND setting_val !=''
";

$add = '"appraisal_reminder_document"';
$th = 'this.id';
$cat = '3';
$sql5 = "SELECT

IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'), CONCAT_WS('Appraisal Reminder-',SPACE(3),`a`.`acc_name`),CONCAT('Please correct ',`a`.`acc_name`,' start date'))AS 'title', 


IF(`setting_val` = DATE_FORMAT(`setting_val`, '%Y-%m-%d'),IF( YEAR(`setting_val`) =  YEAR(CURDATE()) , DATE_ADD(STR_TO_DATE(`setting_val`,'%Y-%m-%d'), INTERVAL 1 year),  CONCAT(YEAR(`setting_val`), '-', MONTH(`setting_val`), '-', DAY(`setting_val`) ) ),  DATE_FORMAT(NOW(), '%Y-%m-%d') ) AS `start`,
'#b84487' as `color`,
  'apr' AS `appr`,
   'documentInsert_profile_detail($add,$th,$cat)' as click,
    `id_user` as id,
`acc_name` AS `n_name`
FROM `accounts_user_detail` `l`
JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id`
WHERE (id_user IN (SELECT `id_user` FROM `accounts_user_detail` `l`  JOIN `accounts_user` `a` ON `l`.`id_user` = `a`.`acc_id` WHERE `setting_val`='$user' AND `setting_name`='account_under') OR id_user = '$user' ) AND `setting_name`='start_date' AND `setting_val` !='' GROUP BY `id_user` 
";
}

$data1 = $this->dbF->getRows($sql1);
$data2 = $this->dbF->getRows($sql2);
$data3 = $this->dbF->getRows($sql3);
$data4 = $this->dbF->getRows($sql4);
$data5 = $this->dbF->getRows($sql5);

foreach ($data2 as $key => $value) {
$date1 = $value['fdate'];
$date2 = $value['tdate'];
if ($value['fdate'] == $value['tdate']) {
continue;
}

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365 * 60 * 60 * 24));
$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


$j = $days;
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($date2));
$value['end'] = Date('Y-m-d', strtotime($date1));
}

array_push($data2, $value);
}




$mysql = array_merge($data1, $data2, $data3, $data4, $data5);
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";
}

// hr hub

// hr hub

public function saveFormData($fields, $data, $type){
        $sql = "INSERT INTO  `surveyFormData` SET ";
        $sql .= $fields.',type = ?';
        $data2 = array($type);
        $array = array_merge($data, $data2);
        $res = $this->dbF->setRow($sql,$array,false);
        return $res;
}

public function bookingsend($apiPostData = "")
{
if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }    
if (isset($_POST['submit'])) {
if (!$this->getFormToken('newBookingForm') && $apiPostData == "") {
return false;
}
$desc        = empty($_POST['desc'])            ? ""    : $_POST['desc'];
$event_title = empty($_POST['event_title'])     ? ""    : $_POST['event_title'];
$title       = empty($_POST['title'])           ? ""    : $_POST['title'];
$to = $this->ibms_setting('Email');
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$name = $this->UserName($user);
$msg = '<table border="1">';
$msg .= '<tr><td>Event Title</td><td>' . $event_title . '</td> </tr>';
$msg .= '<tr><td>Practice Name</td><td>' . $name . '</td> </tr>';
$msg .= '<tr><td>Title</td><td>' . $title . '</td> </tr>';
$msg .= '<tr><td>Description</td><td>' . $desc . '</td> </tr>';
$msg .= '<tr><td>Date Time</td><td>' . date("D j M Y g:i a") . '</td> </tr>';
$msg .= '</table>';



$f = 'field1 = ?,';
$f .= 'field2 = ?,';
$f .= 'field3 = ?,';
$f .= 'field4 = ?';
$sql = "INSERT INTO  `formAllData` SET ";
$sql .= $f.',type = ?';
$data2 = array('Event Title:'. $event_title,'Practice Name:'. $name,'Title:'. $title,'Description:'. $desc,"newBookingForm");
$this->dbF->setRow($sql,$data2,false);
if (!strpos(WEB_URL, 'alpha')) {
$this->send_mail($to, 'Booking Form', $msg);
}
if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}

$this->setlog("Event Booking", $this->UserName($user) . " : " . $user, "", $msg);
return true;
}
}

public function customlog()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('customlog')) {
return false;
}
$desc   = empty($_POST['desc'])            ? ""    : $_POST['desc'];
$title  = empty($_POST['title'])     ? ""    : $_POST['title'];
$frequency  = empty($_POST['frequency'])     ? ""    : $_POST['frequency'];
$to = $this->ibms_setting('Email');
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$name = $this->UserName($user);
$msg = '<table border="1">';
$msg .= '<tr><td>Event Title</td><td>' . $title . '</td> </tr>';
$msg .= '<tr><td>Name</td><td>' . $name . '</td> </tr>';
$msg .= '<tr><td>Frequency</td><td>' . $frequency . '</td> </tr>';
$msg .= '<tr><td>Description</td><td>' . $desc . '</td> </tr>';
$msg .= '<tr><td>Date Time</td><td>' . date("D j M Y g:i a") . '</td> </tr>';
$msg .= '</table>';


$f = 'field1 = ?,';
$f .= 'field2 = ?,';
$f .= 'field3 = ?,';
$f .= 'field4 = ?';
$sql = "INSERT INTO  `formAllData` SET ";
$sql .= $f.',type = ?';
$data2 = array('Event Title:'. $title,'Name:'. $name,'Frequency:'. $frequency,'Description:'. $desc,"customlog");
$this->dbF->setRow($sql,$data2,false);




$this->send_mail($to, 'Custom Log Request', $msg);
if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}
$this->setlog("Custom Log Request", $this->UserName($user) . " : " . $user, "", $msg);
return true;
}
}

// rota

public function shiftName()
{

$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `shift` WHERE `user`='$user'";
$data = $this->dbF->getRows($sql);
echo "<div class='add_shift_div'>";

if ($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full') {
echo "<div class='add_shift_div_inner'>
<li class='addshift'>
    <button type='button' class='submit_class' onclick='addshift()'><i class='fas fa-plus'></i>&nbsp;&nbsp;Add Shift</button>
</li>
</div>
";
echo "</div>";
echo "<ul id='draggable' class='row'>";
echo "<div class='manage_shift_div col-lg-custom'>
<li class='ho' style='background-color: #f2701d;height: auto;padding: 5px;margin-bottom: 5px; width:25%; margin-right:0 !important ; display: inline-block;font-size: 12px;font-weight: bold;'>
    <input type='hidden' value='ho' class='ho'><p>Holiday</p>
</li>
<li class='dyo' style='background-color: #f2701d;height: auto;padding: 5px;margin-bottom: 5px;  width:28%; margin-right:0 !important ; display: inline-block;font-size: 12px;font-weight: bold;'>
    <input type='hidden' value='do' class='dyo'><p>Day off</p>
</li>
<li class='sk' style='background-color: #f2701d;height: auto;padding: 5px;margin-bottom: 5px;  width:20%; margin-right:0 !important ; display: inline-block;font-size: 12px;font-weight: bold;'>
    <input type='hidden' value='sk' class='sk'><p>Sick</p>
</li>
 <li class='sk' style='background-color: #f2701d;height: auto;padding: 5px;margin-bottom: 5px;  width: 16%; display: inline-block;font-size: 12px;font-weight: bold;'>
    <input type='hidden' value='rf' class='rf'><p><i class='fa fa-sync-alt'> </i></p>
</li>
</div>";
foreach ($data as $key => $value) {
$shiftname_r = $value['shift_name'];
echo "<div class='col-lg-custom'>
<li style='background-color: $value[color]'>";
if ($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full') {

echo "<a class='ahide' data-toggle='tooltip' title='Delete' id='$value[id]' onclick='deleteShift(this.id)' ><i class='far fa-trash-alt'></i></a>";

echo "<a class='editshift ahide' data-toggle='tooltip' title='Edit' id='$value[id]' onclick='EditShift(this.id)' ><i class='far fas fa-edit'  ></i></a>";
}
echo "<p>$value[shift_name]</p>
    <p class='ahide'><i class='fas fa-clock'></i>&nbsp;" . $value['timefrom'] . "&nbsp;-&nbsp;" . $value['timeto'] . "</p>
    <p class='ahide'><i class='fa fa-user-md'></i>&nbsp;" . $this->UserName($value['dentist_id']) . "</p>
    <p class='ahide'><i class='fa fa-coffee'></i>&nbsp;$value[break]</p>
    <input type='hidden' value='$value[timefrom]' class='tf'>
    <input type='hidden' value='$value[timeto]' class='tt'>
    <input type='hidden' value='$value[break]' class='bk'>
    <input type='hidden' value='$value[dentist_id]' class='dn'>
    <input type='hidden' value='$value[color]' class='cr'>
    <input type='hidden' value='$shiftname_r' class='sn'>
</li>
</div>";
}
echo " </ul>";








//  echo "  <div class='col-lg-2'>
//     <li style='background-color: #f2701d'>";

//         if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'full'){
//             echo "<a data-toggle='tooltip' title='Delete' id='' onclick='deleteShift(this.id)'><i class='far fa-trash-alt'></i></a>";
//         }
//     echo "<p>Refresh Shift</p><br>
//         <p><i class='fas fa-clock'></i>&nbsp; 00:00 &nbsp;-&nbsp; 00:00 </p>
//         <p><i class='fa fa-user-md'></i>&nbsp;".$this->UserName($value['dentist_id'])."</p>
//         <p><i class='fa fa-coffee'></i>&nbsp;00:00</p>
//         <input type='hidden' value='00:00' class='tf'>
//         <input type='hidden' value='00:00' class='tt'>
//         <input type='hidden' value='00:00' class='bk'>
//         <input type='hidden' value='00:00' class='dn'>
//         <input type='hidden' value='' class='cr'>
//     </li>
// </div>";



}
}

public function newMonthly($new = false)
{


global $_e;
$isEdit = false;
$userId = '';
if ($new) {

$token  = $this->setFormToken('newMonthly', false);
} else {

$isEdit =   true;
$token  =   $this->setFormToken('newMonthly', false);
$id     =   intval($_GET['editId']);
$id     =   base64_decode($id);
$sql    =   "SELECT * FROM record where `date` = ? ";
$data   =   $this->dbF->getRows($sql, array($id));
}

$form_fields = array();

$form_fields[] = array(
'type'  => 'none',
'format' => $token,
);

$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '

<div class="rota-table rota-table-monthly" style="overflow:auto;" id="rota-table">
<h2>My Rota</h2>
<div id="left_scrolling" onmouseover="scroll_up();" onmouseout="stop_scroll();">
    <i class="fas fa-arrow-left" data-toggle="tooltip" title="Left Scrolling"></i>
</div>
<div id="right_scrolling" onmouseover="scroll_down();" onmouseout="stop_scroll();">
    <i class="fas fa-arrow-right" data-toggle="tooltip" title="Right Scrolling"></i>
</div>
<table><thead>'
);

$branchId = 0;
$user = intval($_SESSION['currentUser']);
$sql            = "SELECT `acc_id`,`acc_name`,`acc_image` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1'";

$data2 = $this->dbF->getRows($sql);

$dates = '';
$dt = '';
$dt1 = @$_GET['date'];
$dt2 = @$_GET['date2'];
if ($dt2 == null) {
$dt = $dt1;
} else {
$dt = $dt2;
}
$month = date("m", strtotime($dt));
$year = date("Y", strtotime($dt));
$cal = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$cal;


for ($i = 0; $i < $cal; $i++) {
$todayDate  =   date("d-M-Y", strtotime($dt . " +$i days"));
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));
$day        =   date("l", strtotime($todayDateT));

$dates      .= "<th class='text-center'>$todayDate <br> $day
        <input type='hidden' name='dates[]' value='$todayDateT'/>
        </th>";
}
$form_fields[] = array(
'label' => "Staff Name",
'type'  => 'none',
'format' => "$dates"
);
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</thead>'
);
foreach ($data2 as $val) {
$id     = $val['acc_id'];
$name   = $val['acc_name'];
$image   = $val['acc_image'];

$data = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$id' AND setting_name='hours_worked'");
$hours = "(" . $data[0] . " hours)";
if (empty($data[0])) {
$hours = "N|A";
}
$thisFormFields = '';
$userId = "<input type='hidden' name='users[]' value='$id' />";


$week_date  = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));

if ($dt2 == null) {
$week_date = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));
} else {
$week_date = date("Y-m-d", strtotime((isset($_GET['date2']) ? $_GET['date2'] : date('Y-m-d'))));
}
for ($i = 0; $i < $cal; $i++) {
$ii = $i;
if ($dt1 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
}
$sql        =   "SELECT * FROM record where `date` = ? AND branch = ? AND userId =  ? ";
$data       =   $this->dbF->getRow($sql, array($todayDate,$branchId,$id));

$class = $cursor = $pointer = $hinput = "";

if (@$_GET['type'] == 'reset') {
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id]'>";
$data = NULL;
$hinput   .= "<input type='hidden' value='$data[comment]' name='comment[$todayDate][$id]'>";
}

if (!empty($data)) {
$cursor = "cursor: no-drop;opacity: 0.6;";
$pointer = "pointer-events: none;";
$class = "nodrop";
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id]'>
            <input type='hidden' value='$data[comment]' name='comment[$todayDate][$id]'>";
}

@$temp      = $data['timeFrom'];
if (empty($temp)) {
$temp = "00:00";
}

if ($dt2 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
}

$timeFrom   = "<input data-toggle='tooltip' title='TimeFrom' type='text' placeholder='12:00' value='$temp' name='timeFrom[$todayDate][$id]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_from'/>";
@$temp      = $data['timeTo'];
if (empty($temp)) {
$temp = "00:00";
}
$timeTo     = "<input data-toggle='tooltip' title='TimeTo' type='text' placeholder='14:00' value='$temp' name='timeTo[$todayDate][$id]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_to'/>";





@$temp      = $data['hour'];
if (empty($temp)) {
$temp = "0";
$temp;
}
$totalHours = "<span class='spanStyle'>Total</span><input type='text' min='0' max='24' placeholder='No of hours' value='$temp' name='emp[$todayDate][$id]' pattern='\d+(\.\d*)?' class='rslt inputStyle'/>";

@$temp      = $data['breakTime'];
if (empty($temp)) {
$temp = "00:00";
}

$break_time = "<span class='spanStyle'>Break</span><input type='text' name='breakTime[$todayDate][$id]' placeholder='Break Time' value='$temp' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='inputStyle break'/>";

$checkin   = "<input style='display:none' data-toggle='tooltip' title='Checkin' type='text' value='$data[checkin]' name='checkin[$todayDate][$id]' class='cheksinout'>";

$checkout   = "<input style='display:none' data-toggle='tooltip' title='Checkout' type='text' value='$data[checkout]' name='checkout[$todayDate][$id]' class='cheksinout'>";

@$temp      = $data['rotaComment'];
if (empty($temp)) {
$temp = "";
}

$comment = "<input style='display:none' type='text' name='rotaComment[$todayDate][$id]' placeholder='Comment' value='$temp' class='commentsh'/>";

@$temp      = $data['dentist_id'];
if (empty($temp)) {
$temp = "";
}

$dentist_id = "<select style='display:none' name='dentist_id[$todayDate][$id]' class='dentist_id'>
    <option selected disabled>Select Dentist</option>
    " . $this->allDentist($_SESSION['currentUser'], $temp) . "
    </select>";

@$temp      = $data['surgeries'];

if (empty($temp)) {
$temp = "";
}

$allsurgeries = "<select style='display:none' name='surgeries[$todayDate][$id]' class='allsurgeries'>
    <option selected disabled>Select Surgeries</option>
    " . $this->allsurgeries($_SESSION['currentUser'], $temp) . "
    </select>";

// $row = $this->dbF->getRow("SELECT `color` FROM `shift` WHERE `timefrom`='$data[timeFrom]' AND `timeto`='$data[timeTo]' AND `break`='$data[breakTime]' AND `user`='$user'");
$style = "";
if (!empty($data['color'])) {
$style = "border-color: $data[color]; border-left:5px solid; border-radius:12px;";
}

@$tempH      = $data['rotaOff'];
$box_show_css = $check_box_hide_css = $tempR = '';
$button_hide_css = "style='display:none'";
if (!empty($tempH)) {
$check_box_hide_css = "style='display:none'";
$button_hide_css = "style='display:block'";
$box_show_css = "style='display:none'";
}

//  $refresh = '<a data-toggle="tooltip" title="Refresh" onclick="Refresh()"><i class="fas fa-times" style="cursor: pointer;" ></i></a>';

if ($tempH == 'Day Off') {
$box_show_css = "style='display:block;max-width:100%;flex:auto'";
}


$rotaOff = "<button $button_hide_css class='rota-off btn btn-danger' type='button'>$tempH</button><input class='rota-off-val' value='$tempH' type='hidden' name='rotaOff[$todayDate][$id]' />";
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));

$sqlcheckLeave = "SELECT * FROM `leaves`   where  fill_user = ?  AND `status`='accepted' AND `from_date` = ? ";
//echo "<br>";
$curUser = intval($_SESSION['currentUser']);
$datacheckLeave  = $this->dbF->getRow($sqlcheckLeave, array($id, $todayDateT));
$holidayDate =  "SELECT * FROM `isholiday`   where  `date` = ? AND `user` = ? ";
$dataisholiday = $this->dbF->getRow($holidayDate, array($todayDateT,$curUser));
$holidayDays =  "SELECT * FROM `practiceprofile`   where  `user_id` = ? ";

$staffholidaysdays =  "SELECT * FROM `accounts_user`   where  `acc_id` = ? ";
$staffholidaysdays  = $this->dbF->getRow($staffholidaysdays, array($id));
$dataisholidaydays  = $this->dbF->getRow($holidayDays, array($curUser));
$datacheckLeaveType = $datacheckLeave['type'] . "<br>" . "(LEAVE)";
$days = $dataisholidaydays['dayoff'];
$staffdays = $staffholidaysdays['dayoff'];
$staffdays = explode(",", $staffdays);
$offday = explode(",", $days);
$reason = "";
// echo "<pre>";
// print_r($staffdays);
// echo "</pre>";
if (in_array(date('N', strtotime($todayDateT)), $offday)) {

$reason = "Weekend <br> Holiday";
} elseif (in_array(date('N', strtotime($todayDateT)), $staffdays)) {
$reason = "Staff Not Working <br> Day";
// $reason = "staff Weekend <br> Holiday";
} else {
$reason = $dataisholiday['reason'];
}

if (!empty($datacheckLeave)) {
//   echo "<pre>";
date("Y-m-d", strtotime($datacheckLeave['from_date']));
// echo "</pre>";
date("Y-m-d", strtotime($datacheckLeave['to_date']));
}
date("Y-m-d", strtotime($todayDateT));


// echo "</pre>";

if ($dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $staffdays)) {

$thisFormFields .= "<td class='' style='cursor: unset; opacity: 1; border-bottom: 6px solid lime; border-top-color: lime; border-right-color: lime; border-left-color: lime;'>$userId
$hinput 
<div class='col-12 insertTimeTable' style='z-index: 2; pointer-events: auto;'>
<div class='row'>


<input  type='hidden'  value='' name='edit_lock[$todayDate][$id]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
    <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
<div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
} elseif ($dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $offday)) {
$thisFormFields .= "<td class=''>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>


<input  type='hidden'  value='' name='edit_lock[$todayDate][$id]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
            <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
} elseif (strtotime($todayDate) >=  strtotime($datacheckLeave['from_date']) && strtotime($todayDate) <= strtotime($datacheckLeave['to_date'])) {


$thisFormFields .= "<td class=''>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>


<input  type='hidden'  value='' name='edit_lock[$todayDate][$id]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id]'  />

<input class='backcolor' type='hidden' value='' name='color[$todayDate][$id]'  />
                
<div class='col-12 p-0'> 
<button  class='rota-off btn btn-danger' type='button'>" . str_replace(' ', '<br>', $datacheckLeaveType) . "</button><input class='rota-off-val'  value='$datacheckLeave[type]' type='hidden' name='rotaOff[$todayDate][$id]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id]' placeholder='Comment' value='$datacheckLeave[comment]' class='commentsh'/></div>

</div> </div>


</td>";
} else {
$thisFormFields .= "<td class=' $class' style=\"$cursor\">$userId $hinput 
<div class='col-12 insertTimeTable time ui-droppable' style=\"z-index:2; $pointer$style\">

                <div class='row spd'>
                 
<input  type='hidden'  value='$data[edit_lock]' name='edit_lock[$todayDate][$id]' />

<input class='sn_' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='$data[rshiftname]' name='rshiftname[$todayDate][$id]'  />

                <input class='backcolor' type='hidden' value='$data[color]' name='color[$todayDate][$id]'  />
                
                    <div class='col-12 p-0 vertical-icon'>$rotaOff
                    <span data-toggle='tooltip' title='Dentist' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' {$check_box_hide_css}>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' {$check_box_hide_css}>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
               

                    </div>
                    
                    <div class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                    <div class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                    <div class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                    <div class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                    <div class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                    <div class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$comment</div>
                </div>
                </div>
                
                </td>";
}
$userId     =   '';
}
@$iamge2 = "d-profile.png";
$imageuser = $val['acc_image'];
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $val['acc_image'];
}
$form_fields[] = array(
'label' => "<div class='whours'>$hours</div><span> <img src='$imageuser'>$name</span><button class='shtd' type='button'data-toggle='tooltip' title='Show/Hide'><input type='hidden' name='rota$id' value='1'><i class='fas fa-eye'></i></button>
<button class='ettd' type='button' data-toggle='tooltip' title='Edit'><input type='hidden' name='amend$id' value='0'><i class='fas fa-edit'></i></button>",
'value' => @$this->dailyDataArray($data, $id),
'type'  => 'none',
'format' => "$thisFormFields"
);
}

if ($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full') {
$form_fields[]  = array(
"name"  => 'submit',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => 'Save',
'thisFormat' => '<tr><th></th><th style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'publish',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Publish",
'thisFormat' => '<th style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'amend',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Amend",
'thisFormat' => '<th style="background-color: transparent">{{form}}</th></tr>'
);
}
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</table></div>'
);
$form_fields['form']  = array(
'type'      => 'form',
'class'     => "form-horizontal",
'action'   => 'rota',
'method'   => 'post',
'format'   => '{{form}}'
);
$format = '<tr><th>{{label}}</th>{{form}}</tr>';
$this->print_form($form_fields, $format);
}

public function newDaily($new = false)
{
    
    global $_e;
$isEdit = false;
$userId = '';
$temp1 = '';
if ($new) {

$token  = $this->setFormToken('newDaily', false);
} else {

$isEdit =   true;
$token  =   $this->setFormToken('editDaily', false);
$id     =   intval($_GET['editId']);
$id     =   base64_decode($id);
$sql    =   "SELECT * FROM record where `date` = ? ";
$data   =   $this->dbF->getRows($sql,array($id));
}

$form_fields = array();

$form_fields[] = array(
'type'  => 'none',
'format' => $token,
);

$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '<div class="col-12"><a class="submit_class rota-btn" style="margin-top:0" href="rota?date2=' . date('d-M-Y', strtotime('-7 day ' . @$_GET['date2'])) . '&date=' . date('d-M-Y', strtotime('-7 day ' . @$_GET['date2'])) . '&rotaweeklysubmit=Create+Weekly+Rota">Prev</a>
<a class="submit_class rota-btn" style="margin-top:0" href="rota?date2=' . date('d-M-Y', strtotime('+7 day ' . @$_GET['date2'])) . '&date=' . date('d-M-Y', strtotime('+7 day ' . @$_GET['date2'])) . '&rotaweeklysubmit=Create+Weekly+Rota">Next</a></div>
<div class="rota-table"><h2>My Rota</h2><table><thead>'
);

$branchId = 0;
$user = intval($_SESSION['currentUser']);
$sql            = "SELECT `acc_id`,`acc_name`,`acc_image` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1'";

$data2 = $this->dbF->getRows($sql);

$dates = '';
$dt = '';
$dt1 = @$_GET['date'];
$dt2 = @$_GET['date2'];
if ($dt2 == null) {
$dt = $dt1;
} else {
$dt = $dt2;
}
for ($i = 0; $i < 7; $i++) {
$todayDate  =   date("d-M-Y", strtotime($dt . " +$i days"));
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));
$day        =   date("l", strtotime($todayDateT));

$dates      .= "<th class='text-center'>$todayDate <br> $day
        <input type='hidden' name='dates[]' value='$todayDateT'/>
        </th>";
}
$form_fields[] = array(
'label' => "Staff Name",
'type'  => 'none',
'format' => "$dates"
);
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</thead>'
);
foreach ($data2 as $val) {
$id     = $val['acc_id'];
$name   = $val['acc_name'];
$image   = $val['acc_image'];

$data = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name= ? ",array($id,'hours_worked'));
$hours = "(" . $data[0] . " hours)";

if (empty($data[0])) {
$hours = "N|A";
}



 $sqlSuper = "SELECT `setting_val` FROM `accounts_user_detail` WHERE  `setting_name`='superuser' AND `id_user`= ? ";
                $dataSuper = $this->dbF->getRow($sqlSuper,array($id));
                $superUser= $dataSuper[0];
                 $superUsericon="";
        if($superUser == "on"){
        $superUsericon=$this->dentistIcon('Super User');
      }
$sqlResponsibility =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`=? AND `setting_name`='responsibility'",array($id));
                $responsibility = @$sqlResponsibility[0];
                $responsibilityIcon=$this->dentistIcon($responsibility);                

$dataRole = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name= ? ",array($id,'role'));
$rRole = "(" . $dataRole[0].$responsibilityIcon. ")";

if (empty($dataRole[0])) {
$rRole = "N|A".$responsibilityIcon;
}
if($dataRole[0]=='Dentist'){
    $temp1 = $displayDentist='dentist';
}else{
     $temp1 = $displayDentist='staff';
}




$thisFormFields = '';
$userId = "<input type='hidden' name='users[]' value='$id' />";


$week_date  = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));

if ($dt2 == null) {
$week_date = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));
} else {
$week_date = date("Y-m-d", strtotime((isset($_GET['date2']) ? $_GET['date2'] : date('Y-m-d'))));
}



for ($i = 0; $i < 7; $i++) {
    
    
$ii = $i;
if ($dt1 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
}
$thisFormFields .="<td> <table class='rota-double-table'>";//double shift


$todayDateChk=$todayDate;

for($j=1;$j<3;$j++){
    
    
$sql        =   "SELECT * FROM record where `date` = ? AND branch = ? AND shift = ? AND userId= ?";
$data       =   $this->dbF->getRow($sql, array($todayDateChk, $branchId, $j, $id));

$class = $cursor = $pointer = $hinput = "";

if (@$_GET['type'] == 'reset') {
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id][$j]'>";
$data = NULL;
$hinput   .= "<input type='hidden' value='$data[comment]' name='comment[$todayDate][$id][$j]'>";
}

if (!empty($data)) {
$cursor = "cursor: no-drop;opacity: 0.6;";
$pointer = "pointer-events: none;";
$class = "nodrop";
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id][$j]'>
            <input type='hidden' value='$data[comment]' name='comment[$todayDate][$id][$j]'>";
}

@$temp      = $data['timeFrom'];
if (empty($temp)) {
$temp = "00:00";
}

if ($dt2 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
}

$timeFrom   = "<input data-toggle='tooltip' title='TimeFrom' type='text' placeholder='12:00' value='$temp' name='timeFrom[$todayDate][$id][$j]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_from'/>";
@$temp      = $data['timeTo'];
if (empty($temp)) {
$temp = "00:00";
}
$timeTo     = "<input data-toggle='tooltip' title='TimeTo' type='text' placeholder='14:00' value='$temp' name='timeTo[$todayDate][$id][$j]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_to'/>";





@$temp      = $data['hour'];
if (empty($temp)) {
$temp = "0";
$temp;
}
$totalHours = "<span class='spanStyle'>Total</span><input type='text' min='0' max='24' placeholder='No of hours' value='$temp' name='emp[$todayDate][$id][$j]' pattern='\d+(\.\d*)?' class='rslt inputStyle'/>";

@$temp      = $data['breakTime'];
if (empty($temp)) {
$temp = "00:00";
}

$break_time = "<span class='spanStyle'>Break</span><input type='text' name='breakTime[$todayDate][$id][$j]' placeholder='Break Time' value='$temp' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='inputStyle break'/>";

$check_in = isset($data['checkin']) ? $data['checkin'] : "";
$checkin   = "<input style='display:none' data-toggle='tooltip' title='Checkin' type='text' value='$check_in' name='checkin[$todayDate][$id][$j]' class='cheksinout'>";

$check_out = isset($data['checkout']) ? $data['checkout'] : "";
$checkout   = "<input style='display:none' data-toggle='tooltip' title='Checkout' type='text' value='$check_out' name='checkout[$todayDate][$id][$j]' class='cheksinout'>";

@$temp      = $data['rotaComment'];
if (empty($temp)) {
$temp = "";
}

$comment = "<input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='$temp' class='commentsh'/>";

@$temp      = $data['dentist_id'];
if (empty($temp)) {
$temp = "";
}

$dentist_id = "<select style='display:none' name='dentist_id[$todayDate][$id][$j]' class='dentist_id'>
    <option selected disabled>Select Dentist</option>
    " . $this->allDentist($_SESSION['currentUser'], $temp) . "
    </select>";
@$temp      = $data['surgeries'];

if (empty($temp)) {
$temp = "";
}

$allsurgeries = "<select style='display:none' name='surgeries[$todayDate][$id][$j]' class='allsurgeries'>
    <option selected disabled>Select Surgeries</option>
    " . $alls = $this->allsurgeries($_SESSION['currentUser'], $temp) . "
    </select>";
// echo "<pre>";
// echo $alls;
// echo"</pre>";
// $row = $this->dbF->getRow("SELECT `color` FROM `shift` WHERE `timefrom`='$data[timeFrom]' AND `timeto`='$data[timeTo]' AND `break`='$data[breakTime]' AND `user`='$user'");
$style = "";
if (!empty($data['color'])) {
$style = "background-color: white";
}

if(($dt1 == null)){
    @$tempH      = null;

}
else{
    @$tempH      = $data['rotaOff'];

}
$box_show_css = $check_box_hide_css = $tempR = '';
$button_hide_css = "style='display:none'";
if (!empty($tempH) &&($dt1 == null)) {
$check_box_hide_css = "style='display:none'";
$button_hide_css = "style='display:block'";
$box_show_css = "style='display:none'";
}

//  $refresh = '<a data-toggle="tooltip" title="Refresh" onclick="Refresh()"><i class="fas fa-times" style="cursor: pointer;" ></i></a>';

if ($tempH == 'Day Off'&&($dt1 == null)) {
$box_show_css = "style='display:block;max-width:100%;flex:auto'";
}


$rotaOff = "<button $button_hide_css class='rota-off btn btn-danger' type='button'>$tempH</button><input class='rota-off-val' value='$tempH' type='hidden' name='rotaOff[$todayDate][$id][$j]' />";

$rotaOff .= "<input style='display:none' class='is-not-working' value='$tempH' type='hidden' name='' />";
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));

$sqlcheckLeave = "SELECT * FROM `leaves` where  fill_user = ? AND `status`='accepted' AND ('$todayDateT' BETWEEN from_date AND to_date )";

//  echo "</pre>";
$datacheckLeave  = $this->dbF->getRow($sqlcheckLeave, array($id));
$curUser = intval($_SESSION['currentUser']);
$holidayDate =  "SELECT * FROM `isholiday`   where  `date` = ? AND `user` = ?";
$dataisholiday = $this->dbF->getRow($holidayDate, array($todayDateT, $curUser));
$holidayDays =  "SELECT * FROM `practiceprofile`   where  `user_id` =  ? ";
$dataisholidaydays = $this->dbF->getRow($holidayDays, array($curUser));
$datacheckLeaveType = @$datacheckLeave['type'] . "<br>" . "(LEAVE)";


//echo $todayDate;
//   echo "<br>";
// echo "todayDate".$todayDate;
//   echo "<br>";
//    echo "datacheckLeave". $datacheckLeave['from_date'];
//   echo "<br>";
//   echo "todayDate".$todayDate;
//   echo "<br>";
//   echo "datacheckLeave". $datacheckLeave['to_date'];
//   echo "<br>";




$staffholidaysdays =  "SELECT * FROM `accounts_user`   where  `acc_id` = ? ";
$staffholidaysdays = $this->dbF->getRow($staffholidaysdays, array($id));

$days = @$dataisholidaydays['dayoff'];
$staffdays = $staffholidaysdays['dayoff'];
$staffdays = explode(",", $staffdays);
$offday = explode(",", $days);
$reason = "";
// echo "<pre>";
// print_r($staffdays);
// echo "</pre>";
if (in_array(date('N', strtotime($todayDateT)), $offday)) {

$reason = "Weekend <br> Holiday";
} elseif (in_array(date('N', strtotime($todayDateT)), $staffdays)) {
$reason = "Staff Not Working <br> Day";
// $reason = "staff Weekend <br> Holiday";
} else {
$reason = @$dataisholiday['reason'];
}

// if (!empty($datacheckLeave)) {
//   echo "<pre>";
$checkLeaveFrom =    date("Y-m-d", strtotime(@$datacheckLeave['from_date']));
// echo "</pre>";
$checkLeaveTo =    date("Y-m-d", strtotime(@$datacheckLeave['to_date']));

// }
date("Y-m-d", strtotime($todayDateT));


// echo "</pre>";






if(($tempH == 'Sick' || $tempH == 'Day Off' || $tempH == 'Holiday')&&($dt1 == null)){
    $isdrop = "";
    $cursor = "";
    $style  = "";
}
else{
    $isdrop = "time ui-droppable nodrop";
    $cursor = "cursor: no-drop;opacity: 0.6;";
    $clr=@$data['color'];
    if(@$data['color']==''){
        $clr='#561d94';
    }

    $style = "border-bottom: 6px solid $clr;";}



if (@$dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $staffdays)) {

if(empty($data['timeTo'])||($data['timeTo']=="00:00")){
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">
<div class='row spd'>


    <input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input class='_sn' style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   <input style='display:none' class='is-not-working' value='$reason' type='hidden' name='' />
                   <span data-toggle='tooltip' title='Dentist' class='spanStyle' style='display:none'>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' style='display:none'>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' style='display:none'>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' style='display:none'>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
    <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
<div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
}else{
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">

                <div class='row spd'>
                 
    <input  type='hidden'  value='$data[edit_lock]' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />
<input class='sn_' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='$data[rshiftname]' name='rshiftname[$todayDate][$id][$j]'  />

                <input class='backcolor' type='hidden' value='$data[color]' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0 vertical-icon'>$rotaOff
                    <span data-toggle='tooltip' title='Dentist' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' {$check_box_hide_css}>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' {$check_box_hide_css}>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
               

                    </div>
                    
                    <div class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                    <div class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                    <div class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                    <div class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                    <div class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                    <div class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$comment</div>
                </div>
                </div>
                
                </td>";
}
} elseif (@$dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $offday)) {
$thisFormFields .= "<td class='rota-td'>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>

    <input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
            <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
} elseif ($todayDate >=  $checkLeaveFrom  && $todayDateT <= $checkLeaveTo) {


$thisFormFields .= "<td class='rota-td'>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>

<input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

<input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
<div class='col-12 p-0'> 
<button  class='rota-off btn btn-danger' type='button'>" . str_replace(' ', '<br>', $datacheckLeaveType) . "</button><input class='rota-off-val'  value='$datacheckLeave[type]' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='$datacheckLeave[comment]' class='commentsh'/></div>

</div> </div>


</td>";
} else {
$edit_lock = isset($data['edit_lock']) ? $data['edit_lock'] : "";
$rshiftname = isset($data['rshiftname']) ? $data['rshiftname'] : "";
$color = isset($data['color']) ? $data['color'] : "";
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">

                <div class='row spd'>
                 
    <input  type='hidden'  value='$edit_lock' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input class='sn_' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='$rshiftname' name='rshiftname[$todayDate][$id][$j]'  />

                <input class='backcolor' type='hidden' value='$color' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0 vertical-icon vertical-icon'>$rotaOff
                    <span data-toggle='tooltip' title='Dentist' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' {$check_box_hide_css}>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' {$check_box_hide_css}>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
               

                    </div>
                    
                    <div class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                    <div class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                    <div class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                    <div class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                    <div class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                    <div class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$comment</div>
                </div>
                </div>
                
                </td>";
}

$userId     =   '';
    }
$thisFormFields .="</td> </table>";
}

@$iamge2 = "d-profile.png";
$imageuser = $val['acc_image'];
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $val['acc_image'];
}

$form_fields[] = array(
'label' => "<div class='whours $displayDentist'>$hours</div><span> <img src='$imageuser'>$name$superUsericon</span><button class='shtd' type='button'data-toggle='tooltip' title='Show/Hide'><input type='hidden' name='rota$id' value='1'><i class='fas fa-eye'></i></button>
<button class='ettd' type='button' data-toggle='tooltip' title='Edit'><input type='hidden' name='amend$id' value='0'><i class='fas fa-edit'></i></button> </br> $rRole",
'value' => @$this->dailyDataArray($data, $id),
'type'  => 'none',
'format' => "$thisFormFields"
);
}

if ($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full') {
$form_fields[]  = array(
"name"  => 'submit',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => 'Save',
'thisFormat' => '<tr><th  $displayDentist></th><th style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'publish',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Publish",
'thisFormat' => '<th  $displayDentist  style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'amend',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Amend",
'thisFormat' => '<th style="background-color: transparent">{{form}}</th></tr>'
);
}
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</table></div>'
);
$form_fields['form']  = array(
'type'      => 'form',
'class'     => "form-horizontal",
'action'   => 'rota',
'method'   => 'post',
'format'   => '{{form}}'
);
$format = '<tr class="rotaTr"><th >{{label}}</th>{{form}}</tr>';
$this->print_form($form_fields, $format);
}


public function newDaily_old($new = false)
{
    global $_e;
$isEdit = false;
$userId = '';
if ($new) {

$token  = $this->setFormToken('newDaily', false);
} else {

$isEdit =   true;
$token  =   $this->setFormToken('editDaily', false);
$id     =   intval($_GET['editId']);
$id     =   base64_decode($id);
$sql    =   "SELECT * FROM record where `date` = ? ";
$data   =   $this->dbF->getRows($sql,array($id));
}

$form_fields = array();

$form_fields[] = array(
'type'  => 'none',
'format' => $token,
);

$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '<div class="col-12"><a class="submit_class rota-btn" style="margin-top:0" href="rota?date2=' . date('d-M-Y', strtotime('-7 day ' . @$_GET['date2'])) . '&date=' . date('d-M-Y', strtotime('-7 day ' . @$_GET['date2'])) . '&rotaweeklysubmit=Create+Weekly+Rota">Prev</a>
<a class="submit_class rota-btn" style="margin-top:0" href="rota?date2=' . date('d-M-Y', strtotime('+7 day ' . @$_GET['date2'])) . '&date=' . date('d-M-Y', strtotime('+7 day ' . @$_GET['date2'])) . '&rotaweeklysubmit=Create+Weekly+Rota">Next</a></div>
<div class="rota-table"><h2>My Rota</h2><table><thead>'
);

$branchId = 0;
$user = intval($_SESSION['currentUser']);
$sql            = "SELECT `acc_id`,`acc_name`,`acc_image` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1'";

$data2 = $this->dbF->getRows($sql);

$dates = '';
$dt = '';
$dt1 = @$_GET['date'];
$dt2 = @$_GET['date2'];
if ($dt2 == null) {
$dt = $dt1;
} else {
$dt = $dt2;
}
for ($i = 0; $i < 7; $i++) {
$todayDate  =   date("d-M-Y", strtotime($dt . " +$i days"));
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));
$day        =   date("l", strtotime($todayDateT));

$dates      .= "<th class='text-center'>$todayDate <br> $day
        <input type='hidden' name='dates[]' value='$todayDateT'/>
        </th>";
}
$form_fields[] = array(
'label' => "Staff Name",
'type'  => 'none',
'format' => "$dates"
);
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</thead>'
);
foreach ($data2 as $val) {
$id     = $val['acc_id'];
$name   = $val['acc_name'];
$image   = $val['acc_image'];

$data = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name= ? ",array($id,'hours_worked'));
$hours = "(" . $data[0] . " hours)";

if (empty($data[0])) {
$hours = "N|A";
}



 $sqlSuper = "SELECT `setting_val` FROM `accounts_user_detail` WHERE  `setting_name`='superuser' AND `id_user`= ? ";
                $dataSuper = $this->dbF->getRow($sqlSuper,array($id));
                $superUser= $dataSuper[0];
                 $superUsericon="";
        if($superUser == "on"){
        $superUsericon=$this->dentistIcon('Super User');
      }
$sqlResponsibility =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`=? AND `setting_name`='responsibility'",array($id));
                $responsibility = $sqlResponsibility[0];
                $responsibilityIcon=$this->dentistIcon($responsibility);                

$dataRole = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name= ? ",array($id,'role'));
$rRole = "(" . $dataRole[0].$responsibilityIcon. ")";

if (empty($dataRole[0])) {
$rRole = "N|A".$responsibilityIcon;
}
if($dataRole[0]=='Dentist'){
    $displayDentist='dentist';
}else{
     $displayDentist='staff';
}




$thisFormFields = '';
$userId = "<input type='hidden' name='users[]' value='$id' />";


$week_date  = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));

if ($dt2 == null) {
$week_date = date("Y-m-d", strtotime((isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'))));
} else {
$week_date = date("Y-m-d", strtotime((isset($_GET['date2']) ? $_GET['date2'] : date('Y-m-d'))));
}
for ($i = 0; $i < 7; $i++) {
$ii = $i;
if ($dt1 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
}
$thisFormFields .="<td> <table class='rota-double-table'>";//double shift
for($j=1;$j<3;$j++){
$sql        =   "SELECT * FROM record where `date` = ? AND branch = ? AND shift = ? AND userId= ?";
$data       =   $this->dbF->getRow($sql, array($todayDate, $branchId, $j, $id));

$class = $cursor = $pointer = $hinput = "";

if (@$_GET['type'] == 'reset') {
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id][$j]'>";
$data = NULL;
$hinput   .= "<input type='hidden' value='$data[comment]' name='comment[$todayDate][$id][$j]'>";
}

if (!empty($data)) {
$cursor = "cursor: no-drop;opacity: 0.6;";
$pointer = "pointer-events: none;";
$class = "nodrop";
$hinput   = "<input type='hidden' value='$data[id]' name='id[$todayDate][$id][$j]'>
            <input type='hidden' value='$data[comment]' name='comment[$todayDate][$id][$j]'>";
}

@$temp      = $data['timeFrom'];
if (empty($temp)) {
$temp = "00:00";
}

if ($dt2 == null) {
$todayDate = date("Y-m-d", strtotime($_GET['date'] . " +$i days"));
} else {
$todayDate = date("Y-m-d", strtotime($_GET['date2'] . " +$i days"));
}

$timeFrom   = "<input data-toggle='tooltip' title='TimeFrom' type='text' placeholder='12:00' value='$temp' name='timeFrom[$todayDate][$id][$j]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_from'/>";
@$temp      = $data['timeTo'];
if (empty($temp)) {
$temp = "00:00";
}
$timeTo     = "<input data-toggle='tooltip' title='TimeTo' type='text' placeholder='14:00' value='$temp' name='timeTo[$todayDate][$id][$j]' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='time_to'/>";





@$temp      = $data['hour'];
if (empty($temp)) {
$temp = "0";
$temp;
}
$totalHours = "<span class='spanStyle'>Total</span><input type='text' min='0' max='24' placeholder='No of hours' value='$temp' name='emp[$todayDate][$id][$j]' pattern='\d+(\.\d*)?' class='rslt inputStyle'/>";

@$temp      = $data['breakTime'];
if (empty($temp)) {
$temp = "00:00";
}

$break_time = "<span class='spanStyle'>Break</span><input type='text' name='breakTime[$todayDate][$id][$j]' placeholder='Break Time' value='$temp' pattern='[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}' class='inputStyle break'/>";

$checkin   = "<input style='display:none' data-toggle='tooltip' title='Checkin' type='text' value='$data[checkin]' name='checkin[$todayDate][$id][$j]' class='cheksinout'>";

$checkout   = "<input style='display:none' data-toggle='tooltip' title='Checkout' type='text' value='$data[checkout]' name='checkout[$todayDate][$id][$j]' class='cheksinout'>";

@$temp      = $data['rotaComment'];
if (empty($temp)) {
$temp = "";
}

$comment = "<input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='$temp' class='commentsh'/>";

@$temp      = $data['dentist_id'];
if (empty($temp)) {
$temp = "";
}

$dentist_id = "<select style='display:none' name='dentist_id[$todayDate][$id][$j]' class='dentist_id'>
    <option selected disabled>Select Dentist</option>
    " . $this->allDentist($_SESSION['currentUser'], $temp) . "
    </select>";
@$temp      = $data['surgeries'];

if (empty($temp)) {
$temp = "";
}

$allsurgeries = "<select style='display:none' name='surgeries[$todayDate][$id][$j]' class='allsurgeries'>
    <option selected disabled>Select Surgeries</option>
    " . $alls = $this->allsurgeries($_SESSION['currentUser'], $temp) . "
    </select>";
// echo "<pre>";
// echo $alls;
// echo"</pre>";
// $row = $this->dbF->getRow("SELECT `color` FROM `shift` WHERE `timefrom`='$data[timeFrom]' AND `timeto`='$data[timeTo]' AND `break`='$data[breakTime]' AND `user`='$user'");
$style = "";
if (!empty($data['color'])) {
$style = "background-color: white";
}

if(($dt1 == null)){
    @$tempH      = null;

}
else{
    @$tempH      = $data['rotaOff'];

}
$box_show_css = $check_box_hide_css = $tempR = '';
$button_hide_css = "style='display:none'";
if (!empty($tempH) &&($dt1 == null)) {
$check_box_hide_css = "style='display:none'";
$button_hide_css = "style='display:block'";
$box_show_css = "style='display:none'";
}

//  $refresh = '<a data-toggle="tooltip" title="Refresh" onclick="Refresh()"><i class="fas fa-times" style="cursor: pointer;" ></i></a>';

if ($tempH == 'Day Off'&&($dt1 == null)) {
$box_show_css = "style='display:block;max-width:100%;flex:auto'";
}


$rotaOff = "<button $button_hide_css class='rota-off btn btn-danger' type='button'>$tempH</button><input class='rota-off-val' value='$tempH' type='hidden' name='rotaOff[$todayDate][$id][$j]' />";

$rotaOff .= "<input style='display:none' class='is-not-working' value='$tempH' type='hidden' name='' />";
$todayDateT =   date("Y-m-d", strtotime($dt . " +$i days"));

$sqlcheckLeave = "SELECT * FROM `leaves` where  fill_user = ? AND `status`='accepted' AND ('$todayDateT' BETWEEN from_date AND to_date )";

//  echo "</pre>";
$datacheckLeave  = $this->dbF->getRow($sqlcheckLeave, array($id));
$curUser = intval($_SESSION['currentUser']);
$holidayDate =  "SELECT * FROM `isholiday`   where  `date` = ? AND `user` = ?";
$dataisholiday = $this->dbF->getRow($holidayDate, array($todayDateT, $curUser));
$holidayDays =  "SELECT * FROM `practiceprofile`   where  `user_id` =  ? ";
$dataisholidaydays = $this->dbF->getRow($holidayDays, array($curUser));
$datacheckLeaveType = $datacheckLeave['type'] . "<br>" . "(LEAVE)";


//echo $todayDate;
//   echo "<br>";
// echo "todayDate".$todayDate;
//   echo "<br>";
//    echo "datacheckLeave". $datacheckLeave['from_date'];
//   echo "<br>";
//   echo "todayDate".$todayDate;
//   echo "<br>";
//   echo "datacheckLeave". $datacheckLeave['to_date'];
//   echo "<br>";




$staffholidaysdays =  "SELECT * FROM `accounts_user`   where  `acc_id` = ? ";
$staffholidaysdays = $this->dbF->getRow($staffholidaysdays, array($id));

$days = $dataisholidaydays['dayoff'];
$staffdays = $staffholidaysdays['dayoff'];
$staffdays = explode(",", $staffdays);
$offday = explode(",", $days);
$reason = "";
// echo "<pre>";
// print_r($staffdays);
// echo "</pre>";
if (in_array(date('N', strtotime($todayDateT)), $offday)) {

$reason = "Weekend <br> Holiday";
} elseif (in_array(date('N', strtotime($todayDateT)), $staffdays)) {
$reason = "Staff Not Working <br> Day";
// $reason = "staff Weekend <br> Holiday";
} else {
$reason = $dataisholiday['reason'];
}

// if (!empty($datacheckLeave)) {
//   echo "<pre>";
$checkLeaveFrom =    date("Y-m-d", strtotime($datacheckLeave['from_date']));
// echo "</pre>";
$checkLeaveTo =    date("Y-m-d", strtotime($datacheckLeave['to_date']));

// }
date("Y-m-d", strtotime($todayDateT));


// echo "</pre>";






if(($tempH == 'Sick' || $tempH == 'Day Off' || $tempH == 'Holiday')&&($dt1 == null)){
    $isdrop = "";
    $cursor = "";
    $style  = "";
}
else{
    $isdrop = "time ui-droppable nodrop";
    $cursor = "cursor: no-drop;opacity: 0.6;";
    $clr=$data['color'];
    if($data['color']==''){
        $clr='#561d94';
    }

    $style = "border-left: 6px solid $clr;";}



if ($dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $staffdays)) {

if(empty($data['timeTo'])||($data['timeTo']=="00:00")){
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">
<div class='row spd'>


    <input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input class='_sn' style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   <input style='display:none' class='is-not-working' value='$reason' type='hidden' name='' />
                   <span data-toggle='tooltip' title='Dentist' class='spanStyle' style='display:none'>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' style='display:none'>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' style='display:none'>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' style='display:none'>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
    <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
<div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
}else{
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">

                <div class='row spd'>
                 
    <input  type='hidden'  value='$data[edit_lock]' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />
<input class='sn_' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='$data[rshiftname]' name='rshiftname[$todayDate][$id][$j]'  />

                <input class='backcolor' type='hidden' value='$data[color]' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0 vertical-icon'>$rotaOff
                    <span data-toggle='tooltip' title='Dentist' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' {$check_box_hide_css}>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' {$check_box_hide_css}>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
               

                    </div>
                    
                    <div class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                    <div class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                    <div class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                    <div class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                    <div class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                    <div class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$comment</div>
                </div>
                </div>
                
                </td>";
}
} elseif ($dataisholiday['date'] == $todayDateT || in_array(date('N', strtotime($todayDateT)), $offday)) {
$thisFormFields .= "<td class='rota-td'>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>

    <input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

                  <input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0'> <button  class='rota-off btn btn-danger' type='button'>$reason</button><input  value='$reason' class='rota-off-val' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
            <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='' class='commentsh'/></div>

</div> </div>


</td>";
} elseif ($todayDate >=  $checkLeaveFrom  && $todayDateT <= $checkLeaveTo) {


$thisFormFields .= "<td class='rota-td'>$userId
$hinput 
<div class='col-12 insertTimeTable'>
<div class='row spd'>

<input  type='hidden'  value='' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input style='display:none' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='' name='rshiftname[$todayDate][$id][$j]'  />

<input class='backcolor' type='hidden' value='' name='color[$todayDate][$id][$j]'  />
                
<div class='col-12 p-0'> 
<button  class='rota-off btn btn-danger' type='button'>" . str_replace(' ', '<br>', $datacheckLeaveType) . "</button><input class='rota-off-val'  value='$datacheckLeave[type]' type='hidden' name='rotaOff[$todayDate][$id][$j]' /> 
                   
                    </div>
                    
                <div style='display:none' class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                <div style='display:none' class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                <div style='display:none' class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                <div style='display:none' class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                <div style='display:none' class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                <div style='display:none' class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
             <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div style='display:none' class='rDiv col-11 p-0 m-1' {$check_box_hide_css}><input style='display:none' type='text' name='rotaComment[$todayDate][$id][$j]' placeholder='Comment' value='$datacheckLeave[comment]' class='commentsh'/></div>

</div> </div>


</td>";
} else {
$thisFormFields .= "<td class='$isdrop rota-td' style=\"$cursor$style\">$userId $hinput 
<div class='col-12 insertTimeTable' style=\"z-index:2; $pointer\">

                <div class='row spd'>
                 
    <input  type='hidden'  value='$data[edit_lock]' name='edit_lock[$todayDate][$id][$j]' />
<input  type='hidden'  value='$j' name='shift[$todayDate][$id][$j]' />

<input class='sn_' data-toggle='tooltip' title='Title' type='text' placeholder='No shift Name' value='$data[rshiftname]' name='rshiftname[$todayDate][$id][$j]'  />

                <input class='backcolor' type='hidden' value='$data[color]' name='color[$todayDate][$id][$j]'  />
                
                    <div class='col-12 p-0 vertical-icon'>$rotaOff
                    <span data-toggle='tooltip' title='Dentist' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-user dentist_id'></i>
                    </span>&nbsp;
                    <span data-toggle='tooltip' title='Comment' class='spanStyle' {$check_box_hide_css}>
                        <i class='fas fa-comment-alt commentsh'></i>
                    </span>
                     <span data-toggle='tooltip' title='chekinout' class='spanStyle' {$check_box_hide_css}>
                             <i class='far fa-clock cheksinout' ></i>
                    </span> 
        <span data-toggle='tooltip' title='surgeries' class='spanStyle' {$check_box_hide_css}>
                             <i class='fas fa-bed allsurgeries'></i>
                             
                    </span>
               

                    </div>
                    
                    <div class='col-5 p-0 m-1 time_from_div' {$check_box_hide_css}>$timeFrom</div>
                    <div class='col-5 p-0 m-1 time_to_div' {$check_box_hide_css}>$timeTo</div>
                    <div class='col-5 p-0 m-1 checkin_div' {$check_box_hide_css}>$checkin</div>
                    <div class='col-5 p-0 m-1 checkout_div' {$check_box_hide_css}>$checkout</div>
                    <div class='bDiv col-5 p-0 m-1' {$check_box_hide_css}>$break_time</div>
                    <div class='rDiv col-5 p-0 m-1' {$box_show_css}>$totalHours</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$dentist_id</div>
                <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$allsurgeries</div>
                    <div class='rDiv col-11 p-0 m-1' {$check_box_hide_css}>$comment</div>
                </div>
                </div>
                
                </td>";
}

$userId     =   '';
    }
$thisFormFields .="</td> </table>";
}

@$iamge2 = "d-profile.png";
$imageuser = $val['acc_image'];
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $val['acc_image'];
}

$form_fields[] = array(
'label' => "<div class='whours $displayDentist'>$hours</div><span> <img src='$imageuser'>$name$superUsericon</span><button class='shtd' type='button'data-toggle='tooltip' title='Show/Hide'><input type='hidden' name='rota$id' value='1'><i class='fas fa-eye'></i></button>
<button class='ettd' type='button' data-toggle='tooltip' title='Edit'><input type='hidden' name='amend$id' value='0'><i class='fas fa-edit'></i></button> </br> $rRole",
'value' => @$this->dailyDataArray($data, $id),
'type'  => 'none',
'format' => "$thisFormFields"
);
}

if ($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full') {
$form_fields[]  = array(
"name"  => 'submit',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => 'Save',
'thisFormat' => '<tr><th></th><th style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'publish',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Publish",
'thisFormat' => '<th style="background-color: transparent">{{form}}</th>'
);
$form_fields[]  = array(
"name"  => 'amend',
'id'    => 'ld',
'class' => 'submit_class checkHours',
'type'  => 'submit',
'value' => "Amend",
'thisFormat' => '<th style="background-color: transparent">{{form}}</th></tr>'
);
}
$form_fields[]  = array(
'type'      => 'none',
'thisFormat'   => '</table></div>'
);
$form_fields['form']  = array(
'type'      => 'form',
'class'     => "form-horizontal",
'action'   => 'rota',
'method'   => 'post',
'format'   => '{{form}}'
);
$format = '<tr><th cs>{{label}}</th>{{form}}</tr>';
$this->print_form($form_fields, $format);
}


public function dailyDataArray($data, $userId, $return = 'hour')
{
if (empty($data)) {
return "";
}
foreach ($data as $val) {
if ($userId == $val['userId']) {
return $val[$return];
}
}
return "";
}

public function newDailyAdd()
{
// $this->dbF->prnt($_POST);

if (isset($_POST['submit']) || isset($_POST['publish']) || isset($_POST['amend'])) {

if (!$this->getFormToken('newDaily')) {
return false;
}
global $_e;
$users  =   $_POST['emp'];
$lastId =   0;
foreach ($_POST['dates'] as $key => $date) {
//delete Old if has
$dateT  = date("Y-m-d", strtotime($date));

$branchId = 0;

$_POST['insert']['date']        =   $dateT;


foreach ($_POST['users'] as $userId) {
    for($j=1;$j<3;$j++){
$id = @$_POST['id'][$date][$userId][$j];

$chkID =   $this->dbF->getRow("SELECT COUNT(`id`) as cnt FROM `record` WHERE `userId` = ? AND  `date` = ?  AND  `shift` =  ? ", array($userId, $date, $j));

if ($chkID['cnt'] > 1) {
    if ($_POST['edit_lock'][$date][$userId][$j] == 0) {
        $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` = ? AND edit_lock = 0 AND  `shift` = ? ", array($userId, $date, $j));
    }
}
if ($chkID['cnt'] > 0 &&  empty($id)) {
    $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` =  ? AND edit_lock = 0 AND  `shift` = ? ", array($userId, $date, $j));
}

if (($_POST['timeTo'][$date][$userId][$j] == "00:00" || $_POST['timeFrom'][$date][$userId][$j] == "00:00" || $users[$date][$userId][$j] == '0')) {
    // echo "continue <br>";
    if ($_POST['rotaOff'][$date][$userId][$j] == '') {
        continue;
    }
}

if($_POST['rotaOff'][$date][$userId][$j] == 'Reset' && $_POST['timeTo'][$date][$userId][$j] == "00:00"){
        $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` =  ? AND edit_lock = 0 AND  `shift` = ? ", array($userId, $date, $j));
}



$_POST['insert']['userId']      = $userId;
$_POST['insert']['branch']      = $branchId;

$_POST['insert']['hour']        = $users[$date][$userId][$j];
$_POST['insert']['id']          = @$_POST['id'][$date][$userId][$j];
$_POST['insert']['timeFrom']    = @$_POST['timeFrom'][$date][$userId][$j];
$_POST['insert']['timeTo']      = @$_POST['timeTo'][$date][$userId][$j];

$_POST['insert']['breakTime']   = @$_POST['breakTime'][$date][$userId][$j];
$_POST['insert']['rotaOff']     = @$_POST['rotaOff'][$date][$userId][$j];
$_POST['insert']['comment']     = empty(@$_POST['comment'][$date][$userId][$j]) ? "" : @$_POST['comment'][$date][$userId][$j];
$_POST['insert']['rotaComment'] = @$_POST['rotaComment'][$date][$userId][$j];
$_POST['insert']['dentist_id']  = empty(@$_POST['dentist_id'][$date][$userId][$j]) ? "" : @$_POST['dentist_id'][$date][$userId][$j];
$_POST['insert']['surgeries']  = empty(@$_POST['surgeries'][$date][$userId][$j]) ? "" : @$_POST['surgeries'][$date][$userId][$j];
// var_dump($_POST['insert']['surgeries']);
$_POST['insert']['checkin']     = empty(@$_POST['checkin'][$date][$userId][$j]) ? "" : @$_POST['checkin'][$date][$userId][$j];
$_POST['insert']['checkout']    = empty(@$_POST['checkout'][$date][$userId][$j]) ? "" : @$_POST['checkout'][$date][$userId][$j];

$_POST['insert']['edit_lock']    = empty(@$_POST['edit_lock'][$date][$userId][$j]) ? 0 : @$_POST['checkout'][$date][$userId][$j];
$_POST['insert']['color']    = empty(@$_POST['color'][$date][$userId][$j]) ? "" : @$_POST['color'][$date][$userId][$j];
$_POST['insert']['rshiftname']    = empty(@$_POST['rshiftname'][$date][$userId][$j]) ? "" : @$_POST['rshiftname'][$date][$userId][$j];
$_POST['insert']['shift']    = empty(@$_POST['shift'][$date][$userId][$j]) ? 0 : @$_POST['shift'][$date][$userId][$j];

// echo $_POST['edit_lock'][$date][$userId];
if ($_POST['edit_lock'][$date][$userId][$j] == 0) {
    
    $this->dbF->setRow("DELETE FROM `record` WHERE id= ? ",array($id));
    if ($key == '6') {
        $this->dbF->setRow("DELETE FROM `rotaStatus` WHERE `user`= ?  AND `week`= ? " ,array($userId, $date));
        $this->dbF->setRow("INSERT INTO `rotaStatus`(`user`,`week`) VALUES(?,?)" ,array($userId, $date));
        if (isset($_POST['publish'])) {
            if ($_POST["rota$userId"] == "1") {
                $nots =  $this->notifications('rotaP', $userId);
                // $this->setlog("Rota is publish", $this->UserName($id));
                $this->setlog("Rota is publish", $this->UserName($userId) . " : " . $userId);
            }
        }

        if (isset($_POST['amend'])) {
            
            if ($_POST["amend$userId"] == "1") {
                $nots = $this->notifications('rotaA', $userId);
                // $this->setlog("Rota is Amend", $this->UserName($userId));
                $this->setlog("Rota is Amend", $this->UserName($userId) . " : " . $userId);
            }
        }
    }
}

if ($_POST['edit_lock'][$date][$userId][$j] == 0) {


    $lastId = $this->formInsert('record', $_POST['insert']);
}
}
}

$new['insert'] = "";
}
if ($lastId > 0) {
return true;
}
} // If end
}
public function MonthlyAdd()
{
// $this->dbF->prnt($_POST);

if (isset($_POST['submit']) || isset($_POST['publish']) || isset($_POST['amend'])) {

if (!$this->getFormToken('newMonthly')) {
return false;
}
global $_e;
$users  =   $_POST['emp'];
$lastId =   0;
foreach ($_POST['dates'] as $key => $date) {
//delete Old if has
$dateT  = date("Y-m-d", strtotime($date));

$branchId = 0;

$_POST['insert']['date']        =   $dateT;


foreach ($_POST['users'] as $userId) {

$id = @$_POST['id'][$date][$userId];

$chkID =   $this->dbF->getRow("SELECT COUNT(`id`) as cnt FROM `record` WHERE `userId` = ? AND  `date` = ?", array($userId, $date));
if ($chkID['cnt'] > 1) {
    if ($_POST['edit_lock'][$date][$userId] == 0) {
        $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` = ? AND edit_lock = 0  ", array($userId, $date));
    }
}
if ($chkID['cnt'] > 0 &&  empty($id)) {
    $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` = ? AND edit_lock = 0 ", array($userId, $date));
}

if (($_POST['timeTo'][$date][$userId] == "00:00" || $_POST['timeFrom'][$date][$userId] == "00:00" || $users[$date][$userId] == '0')) {
    // echo "continue <br>";
    if ($_POST['rotaOff'][$date][$userId] == '') {
        continue;
    }
}



$_POST['insert']['userId']      = $userId;
$_POST['insert']['branch']      = $branchId;

$_POST['insert']['hour']        = $users[$date][$userId];
$_POST['insert']['id']          = @$_POST['id'][$date][$userId];
$_POST['insert']['timeFrom']    = @$_POST['timeFrom'][$date][$userId];
$_POST['insert']['timeTo']      = @$_POST['timeTo'][$date][$userId];

$_POST['insert']['breakTime']   = @$_POST['breakTime'][$date][$userId];
$_POST['insert']['rotaOff']     = @$_POST['rotaOff'][$date][$userId];
$_POST['insert']['comment']     = empty(@$_POST['comment'][$date][$userId]) ? "" : @$_POST['comment'][$date][$userId];
$_POST['insert']['rotaComment'] = @$_POST['rotaComment'][$date][$userId];
$_POST['insert']['dentist_id']  = empty(@$_POST['dentist_id'][$date][$userId]) ? "" : @$_POST['dentist_id'][$date][$userId];
$_POST['insert']['surgeries']  = empty(@$_POST['surgeries'][$date][$userId]) ? "" : @$_POST['surgeries'][$date][$userId];
// var_dump($_POST['insert']['surgeries']);
$_POST['insert']['checkin']     = empty(@$_POST['checkin'][$date][$userId]) ? "" : @$_POST['checkin'][$date][$userId];
$_POST['insert']['checkout']    = empty(@$_POST['checkout'][$date][$userId]) ? "" : @$_POST['checkout'][$date][$userId];

$_POST['insert']['edit_lock']    = empty(@$_POST['edit_lock'][$date][$userId]) ? 0 : @$_POST['checkout'][$date][$userId];
$_POST['insert']['color']    = empty(@$_POST['color'][$date][$userId]) ? "" : @$_POST['color'][$date][$userId];
$_POST['insert']['rshiftname']    = empty(@$_POST['rshiftname'][$date][$userId]) ? "" : @$_POST['rshiftname'][$date][$userId];

// echo $_POST['edit_lock'][$date][$userId];
if ($_POST['edit_lock'][$date][$userId] == 0) {
    $this->dbF->setRow("DELETE FROM `record` WHERE id= ? ", array($id));
    if ($key == '6') {
        $this->dbF->setRow("DELETE FROM `rotaStatus` WHERE `user`= ? AND `week`= ? ", array($userId, $date));
        $this->dbF->setRow("INSERT INTO `rotaStatus`(`user`,`week`) VALUES(?,?)", array($userId, $date));
             $lastId = $this->dbF->rowLastId;
        if (isset($_POST['publish'])) {
            if ($_POST["rota$userId"] == "1") {
                $nots =  $this->notifications('rotaP', $userId);
                $this->setlog("Rota is publish", $this->UserName($userId) . " : " . $userId);
                // $this->setlog("Rota is publish", $this->UserName($id),$lastId,$date);
            }
        }

        if (isset($_POST['amend'])) {
            if ($_POST["amend$userId"] == "1") {
                $nots = $this->notifications('rotaA', $userId);
                // $this->setlog("Rota is Amend", $this->UserName($id),$lastId,$date);
                $this->setlog("Rota is Amend", $this->UserName($userId) . " : " . $userId);
            }
        }
    }
}

if ($_POST['edit_lock'][$date][$userId] == 0) {


    $lastId = $this->formInsert('record', $_POST['insert']);
}
}

$new['insert'] = "";
}
if ($lastId > 0) {
return true;
}
} // If end
}

public function massRota()
{
if (isset($_POST['submit'])) {
if ($this->getFormToken('massRotaWeekly') || $this->getFormToken('massRotaMonthly')) {
    // echo '<script>alert("testing")</script>';

global $_e;
if (@$_SESSION['superUser']['hrrota'] == 'read' || @$_SESSION['superUser']['hrrota'] == 'edit' || @$_SESSION['superUser']['hrrota'] == 'full') {
$user = intval($_SESSION['currentUser']);
} else {
$user = intval($_SESSION['webUser']['id']);
}

$sql = "SELECT * FROM accounts_user WHERE acc_id = ? ";
$userData   =   $this->dbF->getRow($sql,array($user));

$sql  = "SELECT `acc_id`,`acc_name` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user'
AND `setting_name`='account_under')";

$data = $this->dbF->getRows($sql);


foreach ($data as $val) {
    
    
$userId = intval($val['acc_id']);
//delete Old if has
if (date('l') == 'Monday') {
$date = date("Y-m-d");
} else {
$date = date("Y-m-d", strtotime("last Monday"));
}

for ($i = 1; $i <= 7; $i++) {
    
$days = $userData['dayoff'];
$offday = explode(",",$days);

if(in_array($i, $offday)){
    continue;
}
else{
    if($i == 1){
    $date  = date("Y-m-d", strtotime($date));
    }
    else{
    $date  = date("Y-m-d", strtotime($date . " +1 day"));
    }
}


$branchId = 0;

// echo "<script>alert('".var_dump($date)."')</script>";

$sql    = "DELETE FROM record WHERE userId = ? AND date= ? ";
$this->dbF->setRow($sql, array($val['acc_id'], $date));

$_POST['insert']['date']        =   $date;
if (empty($val)) {
    $val = 0;
}
$_POST['insert']['userId']  = $userId;

$_POST['insert']['branch']  = $branchId;
$_POST['insert']['hour']    = "7";
$_POST['insert']['shift']    = "1";
$_POST['insert']['timeFrom'] = "09:00";
$_POST['insert']['timeTo']  = "17:00";
$_POST['insert']['breakTime']  = "01:00";
$_POST['insert']['comment']  = "";
$_POST['insert']['rotaComment'] = "";
$_POST['insert']['dentist_id']  = empty(@$_POST['dentist_id'][$date][$userId]) ? 0 : @$_POST['dentist_id'][$date][$userId];
$rotaOff = empty($_POST['rotaOff'][$date][$userId]) ? 0 : $_POST['rotaOff'][$date][$userId];
$_POST['insert']['rotaOff']  = $rotaOff;
$_POST['insert']['color']    = empty(@$_POST['color'][$date][$userId]) ? "" : @$_POST['color'][$date][$userId];

$_POST['insert']['rshiftname']    = empty(@$_POST['rshiftname'][$date][$userId]) ? "" : @$_POST['rshiftname'][$date][$userId];

// echo '<script>alert("testing")</script>';
// var_dump($_POST['insert']);
// exit;

$lastId = $this->formInsert('record', $_POST['insert']);
$new['insert'] = "";
}
}
if ($lastId > 0) {
    
return true;
}

}
else{
    return false;
}
} // If end
}

public function commentSubmit($apiPostData="")
{
if (isset($_POST['commentsubmit'])) {
global $_e;
$comment   = empty($_POST['commentintsert'])      ? ""  : $_POST['commentintsert'];
$postid   = empty($_POST['postid'])      ? ""  : $_POST['postid'];
// $user =  $_SESSION['webUser']['id'];
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}
// htmlspecialchars($comment);
// intval($postid);
// intval($user);

if (!empty($_POST['commentintsert'])) {

$sql  = "INSERT INTO `comments` (`user`,`comment`,`postid`) VALUES (?,?,?)";
$array   = array($user, $comment, $postid);
$this->dbF->setRow($sql, $array);
$lastId = $this->dbF->rowLastId;
 if(!empty($apiPostData)) {
 return $postid;
            }else{
}
$time = date('H:i');
$this->setlog("Set comment on this user", $this->UserName($user) . " : $user", $lastId, $time);
}
} // If end
}
public function feedbackratingSubmit()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('feedbackrating')) {
return false;
}
// $this->dbF->prnt($_POST);
$user             = $_SESSION['webUser']['id'];
$date             =   date('Y-m-d');
$dsc_1            = empty($_POST['feedback'])          ? ""    : $_POST['feedback'];
$dsc_2            = empty($_POST['Reflective'])          ? ""    : $_POST['Reflective'];
$star             = empty($_POST['star'])          ? ""    : $_POST['star'];
$assign_id        = empty($_POST['assign_id'])          ? ""    : $_POST['assign_id'];
$hash = $dsc_1 . "::" . $dsc_2 . "::" . $assign_id;

$hash =  base64_encode($hash);
htmlspecialchars($user);
htmlspecialchars($date);
htmlspecialchars($dsc_1);
htmlspecialchars($dsc_2);
htmlspecialchars($star);
htmlspecialchars($assign_id);
try {
$this->db->beginTransaction();

$sql = "UPDATE `assigned_paper` SET `feedback` = ? , `star` = ? WHERE `assign_id` = ?";



$this->dbF->setRow($sql, array($hash, $star, $assign_id));

$this->db->commit();


$this->setlog("FeedBack Submit", "Feedback", $this->dbF->rowLastId, ("Post Save Successfully"));
} catch (Exception $e) {
if ($returnImage !== false) {
$this->deleteOldSingleImage($returnImage);
}
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->notificationError("PosFeedbackt", ("FeedBack Submit Failed."), 'btn-danger');
}
} // If end
}


public function postSubmit($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {
if (!$this->getFormToken('postadd') && $apiPostData == "") {
return false;
}
/// $this->dbF->prnt($_POST);
// $user           = $_SESSION['webUser']['id'];
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}
$date           =   date('Y-m-d');
$dsc            = empty($_POST['ckeditorcmt'])          ? ""    : $_POST['ckeditorcmt'];
$file           = empty($_FILES['image']['name']) ? false    : true;
$returnImage    = "";
$publish        =  "1";
$publishDate    =  date('Y-m-d');
$ntype          = "post";

$user=intval($user);
htmlspecialchars($date);
htmlspecialchars($dsc);
htmlspecialchars($publish);
htmlspecialchars($publishDate);
htmlspecialchars($ntype);

try {
$this->db->beginTransaction();

$sql      =   "INSERT INTO `post`(
                `user`,
                `date`,
                `dsc`,
                `image`,
                `publish`,
                  `publish_date`,
                 `type`)
                VALUES (?,?,?,?,?,?,?)";

if ($file) {
$returnImage =   $this->uploadSingleImage($_FILES['image'], 'Post');
if ($returnImage == false) {
    throw new Exception('Image File Error');
}
}

$array   = array($user, $date, $dsc, $returnImage, $publish, $publishDate, $ntype);

$this->dbF->setRow($sql, $array, false);
$last_id = $this->db->lastInsertId();
$this->db->commit();
if ($this->dbF->rowCount > 0) {
 if(!empty($apiPostData)) {
return $last_id;
            }else{
}
$content = $dsc;
$data = $this->dbF->getRows("SELECT * FROM `accounts_user` WHERE `acc_type` = '1'");
$id       = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `accounts_user` WHERE  acc_type = '1' AND`acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$id' AND `setting_name`='account_under') AND `acc_id` NOT IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='Master' AND `setting_name`='account_type') OR acc_id = '$id' AND acc_type='1'";
$data = $this->dbF->getRows($sql);
$op = "";
foreach ($data as $key => $value) {
$user=$value['acc_id'];
	$this->notifications('intranewpost', $user);

}
$this->setlog("Added", "Post", $this->dbF->rowLastId, ("Post Save Successfully"));
} else {
$this->notificationError("News", ("News Save Failed."), 'btn-danger');
}
} catch (Exception $e) {
if ($returnImage !== false) {
$this->deleteOldSingleImage($returnImage);
}
$this->db->rollBack();
$this->dbF->error_submit($e);
$this->notificationError("Post", ("Post Save Failed."), 'btn-danger');
}
} // If end
}



public function WeeklySurgeriesResult()
{
    // echo "<pre>";
// echo date('Y-m-01');
// echo "</pre>";
$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-01');
} else {
$date = @$_GET['datev'];
}




if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
$user01 = intval($_SESSION['superid']);
$sql01 = "SELECT * FROM `accounts_user` WHERE `acc_id`= ? and acc_type=1";
$data01 = $this->dbF->getRows($sql01,array($user01));
}
else{
$user01 = intval($_SESSION['currentUser']);
$sql01 = "SELECT * FROM `accounts_user` WHERE  acc_type=1 and (`acc_id`='$user01' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user01' AND `setting_name`='account_under'))  ORDER BY `acc_type` DESC, `acc_name` ASC ";
$data01 = $this->dbF->getRows($sql01);
}

$userid01 ="";

foreach ($data01 as $key01 => $value01) {
 
$userid01 .= $value01['acc_id'].",";


}





$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));
$user       = intval($_SESSION['currentUser']);

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN ?  AND ?
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
echo "<br>";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));
$allStaff = array();
$datesarray1 = array();
$datesarray2 = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$datesarray1[$val['date']] = $val['date'];
$allStaff[$val['date']] = $userid01;
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$datesarray2[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

echo '<div class="rota-table">
<table>
<thead>
    <th>Sno</th>
    <th>Surgeries Name</th>';

foreach ($datesarray1 as $val2) {
$day = date('l', strtotime($val2));
$val2 = date("d-M-Y", strtotime($val2));
echo "<th class='text-center'>$val2 <br> $day</th>";
}

// echo '<th>Total Hours</th>';

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo '<th>Wages Rate</th>
<th>Total Cost</th>';
}

echo '</thead>
<tbody>';
$ii  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
$sqlp = "SELECT * FROM insertRooms WHERE `practiceID` = ? ";
$datap = $this->dbF->getRows($sqlp,array($user));
//var_dump($datap['surgeries']); 
// for ($i = 0; $i < $datap['surgeries']; $i++) {
foreach ($datap as $keypp => $valuepp) {
 
$ii++;





$nammee = $valuepp['name']." - ".$valuepp['desc'];

echo "<tr style='background-color:$valuepp[color]'><td style='white-space: pre-line; border-left-color:$valuepp[color]'>$ii<td style='white-space: pre-line; border-left-color:$valuepp[color]'>$nammee";
foreach ($datesarray2 as $val3) {
echo "<td style='white-space: pre-line; border-left-color:$valuepp[color]'>";
// $day = date('l',strtotime($val2));
$val3 = date("Y-m-d", strtotime($val3));
$val3;
$day;
$record = "SELECT `hour` as `cnt`,
`rotaOff`, 
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,`surgeries`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `a`.`date` = ? AND surgeries = ? 
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
$recorddata = $this->dbF->getRows($record, array($val3, $valuepp['id'], $user, $user));
foreach ($recorddata as $rkey => $rval) {
$data3 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$rval[userId]' AND `setting_name`='responsibility'");
                $responsibility = $data3[0];

         $responsibilityIcon=$this->dentistIcon($responsibility);
if(empty($rval['dentist_id'])){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $rval['user'] .$responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}else{
    echo "<br><i class='fas fa-user'></i>(" . $this->UserName($rval['dentist_id']) . ")<br>&nbsp;&nbsp;&nbsp;" . $rval['user']. $responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}

$a = $allStaff[$val3];
//  $this->dbF->prnt($a);

// echo $val3;
// echo "<br>";
// echo $rval['userId'];

$a =  explode(",", $a);

 $arr[$val3] = array_diff($a, array($rval['userId']));
  // print_r($arr);


}

echo "</td>";
}


echo "</td></td></tr>";
}






// echo "<pre>";
// echo date('Y-m-01');
// echo "</pre>";
$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-01');
} else {
$date = @$_GET['datev'];
}


$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));
$user       = intval($_SESSION['currentUser']);

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` =  ?   
AND `a`.`date` BETWEEN ? AND  ? 
AND  (`a`.`userId` = ?  OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
echo "<br>";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));

$datesarray1 = array();
$datesarray2 = array();
$total = array();
$staffs = array();










foreach ($data as $val) {
$datesarray1[$val['date']] = $val['date'];

$total[$val['date']] = 0;
}
foreach ($data as $val) {
$datesarray2[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;

}

// echo '<div class="rota-table">
// <table>
// <thead>
//     <th>Sno</th>
//     <th>Surgeries Name</th>';

// foreach ($datesarray1 as $val2) {
// $day = date('l', strtotime($val2));
// $val2 = date("d-M-Y", strtotime($val2));
// echo "<th class='text-center'>$val2 <br> $day</th>";
// }

// echo '<th>Total Hours</th>';

// if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
// echo '<th>Wages Rate</th>
// <th>Total Cost</th>';
// }

// echo '</thead>
// <tbody>';
// $ii  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
// $sqlp = "SELECT * FROM insertRooms WHERE `practiceID` = ? ";
// $valuepp = $this->dbF->getRow($sqlp,array($user));
//var_dump($datap['surgeries']); 
// for ($i = 0; $i < $datap['surgeries']; $i++) {
// foreach ($datap as $keypp => $valuepp) {
 
$ii++;





// $nammee = $valuepp['name']." - ".$valuepp['desc'];

echo "<tr><td>$ii<td>Free Staff";
foreach ($datesarray2 as $val3) {
echo "<td>";
// $day = date('l',strtotime($val2));
$val3 = date("Y-m-d", strtotime($val3));
$val3;
$day;
$record = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,`surgeries`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `a`.`date` = ? AND surgeries = '' AND timeFrom !='' AND timeFrom !='00:00' AND rotaOff =''
AND  (`a`.`userId` = ?  OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?   AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
$recorddata = $this->dbF->getRows($record, array($val3,$user,$user));
foreach ($recorddata as $rkey => $rval) {
$data3 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$rval[userId]' AND `setting_name`='responsibility'");
                $responsibility = $data3[0];

         $responsibilityIcon=$this->dentistIcon($responsibility);
if(empty($rval['dentist_id'])){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $rval['user'] .$responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}else{
    echo "<br><i class='fas fa-user'></i>(" . $this->UserName($rval['dentist_id']) . ")<br>&nbsp;&nbsp;&nbsp;" . $rval['user'] .$responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}



}

echo "</td>";
}


echo "</td></td></tr>";
// }
// echo "
// </tbody>
// </table>
// </div>
// $trHideScript";











// echo "<pre>";
// echo date('Y-m-01');
// echo "</pre>";
$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-01');
} else {
$date = @$_GET['datev'];
}


$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));
$user       = intval($_SESSION['currentUser']);

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN ? AND ?
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
echo "<br>";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));

$datesarray1 = array();
$datesarray2 = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$datesarray1[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$datesarray2[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

// echo '<div class="rota-table">
// <table>
// <thead>
//     <th>Sno</th>
//     <th>Surgeries Name</th>';

// foreach ($datesarray1 as $val2) {
// $day = date('l', strtotime($val2));
// $val2 = date("d-M-Y", strtotime($val2));
// echo "<th class='text-center'>$val2 <br> $day</th>";
// }

// // echo '<th>Total Hours</th>';

// if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
// echo '<th>Wages Rate</th>
// <th>Total Cost</th>';
// }

// echo '</thead>
// <tbody>';
// $ii  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
// $sqlp = "SELECT * FROM insertRooms WHERE `practiceID` = ? ";
// $valuepp = $this->dbF->getRow($sqlp,array($user));
//var_dump($datap['surgeries']); 
// for ($i = 0; $i < $datap['surgeries']; $i++) {
// foreach ($datap as $keypp => $valuepp) {
 
$ii++;





// $nammee = $valuepp['name']." - ".$valuepp['desc'];

echo "<tr><td>$ii<td>Holiday Staff";
foreach ($datesarray2 as $val3) {
echo "<td>";
// $day = date('l',strtotime($val2));
$val3 = date("Y-m-d", strtotime($val3));
$val3;
$day;




foreach (explode(",", $allStaff[$val3]) as $rkey1 => $rval1) {

if(!empty($rval1)){


  $record = "SELECT * from leaves where from_date >=  ? and to_date <= ? and user = ? ";



$recorddata = $this->dbF->getRows($record, array($val3, $val3, $rval1));
foreach ($recorddata as $rkey => $rval) {

if(!empty($rval['user'])){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $this->UserName($rval['user']) . "<br><br>";
}else{
 
}

}
}
}

echo "</td>";
}


echo "</td></td></tr>";
// }





 
 
  


// echo "<pre>";
// echo date('Y-m-01');
// echo "</pre>";
$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-01');
} else {
$date = @$_GET['datev'];
}


$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));
$user       = intval($_SESSION['currentUser']);

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN  ?  AND ?
AND  (`a`.`userId` = ?  OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";
echo "<br>";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user ));

$datesarray1 = array();
$datesarray2 = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$datesarray1[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$datesarray2[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

// echo '<div class="rota-table">
// <table>
// <thead>
//     <th>Sno</th>
//     <th>Surgeries Name</th>';

// foreach ($datesarray1 as $val2) {
// $day = date('l', strtotime($val2));
// $val2 = date("d-M-Y", strtotime($val2));
// echo "<th class='text-center'>$val2 <br> $day</th>";
// }

// // echo '<th>Total Hours</th>';

// if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
// echo '<th>Wages Rate</th>
// <th>Total Cost</th>';
// }

// echo '</thead>
// <tbody>';
// $ii  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
// $sqlp = "SELECT * FROM insertRooms WHERE `practiceID` = ? ";
// $valuepp = $this->dbF->getRow($sqlp,array($user));
//var_dump($datap['surgeries']); 
// for ($i = 0; $i < $datap['surgeries']; $i++) {
// foreach ($datap as $keypp => $valuepp) {
 
$ii++;





// $nammee = $valuepp['name']." - ".$valuepp['desc'];

echo "<tr><td>$ii<td>Staff W/O Rota";
foreach ($datesarray2 as $val3) {
echo "<td>";
// $day = date('l',strtotime($val2));
$val3 = date("Y-m-d", strtotime($val3));
$val3;
$day;
$record = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,`surgeries`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `a`.`date` = ? AND (timeFrom ='' OR timeFrom ='00:00') and rotaOff ='' AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`date` ASC";



$recorddata = $this->dbF->getRows($record, array($val3, $user, $user));

if ($this->dbF->rowCount>0) {

foreach ($recorddata as $rkey => $rval) {
$data3 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$rval[userId]' AND `setting_name`='responsibility'");
                $responsibility = $data3[0];

         $responsibilityIcon=$this->dentistIcon($responsibility);
if(empty($rval['dentist_id'])){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $rval['user'] .$responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}else{
    echo "<br><i class='fas fa-user'></i>(" . $this->UserName($rval['dentist_id']) . ")<br>&nbsp;&nbsp;&nbsp;" . $rval['user'] .$responsibilityIcon. "<br>(" . $rval['timeFrom'] . "-" . $rval['timeTo'] . ")<br>";
}

}




}else{

  // $this->dbF->prnt($arr[$val3]);

if(isset($arr[$val3])){
foreach ($arr[$val3] as $rkey => $rval) {

if(!empty($rval)){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $this->UserName($rval) . "<br><br>";
} 
}
}else{
 
foreach (explode(",", $allStaff[$val3]) as $rkey => $rval) {
$data3 =  $this->dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$rval' AND `setting_name`='responsibility'");
                $responsibility = $data3[0];

         $responsibilityIcon=$this->dentistIcon($responsibility);
if(!empty($rval)){
echo "<br><i class='fas fa-user'></i><br>&nbsp;&nbsp;&nbsp;" . $this->UserName($rval) .$responsibilityIcon. "<br><br>";
} 
}

}




// echo "string";

}

echo "</td>";
}


echo "</td></td></tr>";
// }

 








echo "
</tbody>
</table>
</div>
$trHideScript";
}

public function WeeklyWagesResult()
{


$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-d', strtotime('monday this week'));
} else {
$date = @htmlspecialchars($_GET['datev']);
}


$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`shift`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN ? AND ?
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `date`,`a`.`userId` ASC";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));

$dates = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$dates[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

echo '<div class="rota-table">
<table class="table_min_width">
<thead>
    <th>Sno</th>
    <th>Staff Name</th>';

foreach ($dates as $val2) {
$day = date('l', strtotime($val2));
$val2 = date("d-M-Y", strtotime($val2));
echo "<th class='text-center'>$val2 <br> $day</th>";
}

echo '<th>Total Hours</th>';

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo '<th>Wages Rate</th>
<th>Total Cost</th>';
}

echo '</thead>
<tbody>';
$i  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
foreach ($staffs as $key => $val) {
$i++;
$userId = $key;
$name   = $this->staffArrayByDate($val, $userId, '', 'user');
// $image   = $this->staffArrayByDate($val,$userId,'','image');
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo = $this->dbF->getRows($sql, array($userId));
$rate   = floatval($this->webUserInfoArray($userInfo, 'salary'));
$cost   = 0;
$totalHours = 0;
$trid = "tr" . rand();
$trshow = 0;

$imageuser = $this->staffArrayByDate($val, $userId, '', 'image');



@$iamge2 = "d-profile.png";
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $this->staffArrayByDate($val, $userId, '', 'image');
}

echo "<tr id='$trid'>
<th>$i<button class='shtd' type='button'data-toggle='tooltip' title='Show/Hide'><input type='hidden' name='rota$userId' value='1'><i class='fas fa-eye'></i></button></i></th>
<th><span>";  ?>
<img src="<?php echo $imageuser   ?>" >
<?php
echo   " $name</span></th>";

foreach ($dates as $val2) {
 echo "<td><table><tr>";//double shift view
for($i=1;$i<3;$i++){
$date  = $val2;

$timef = $this->staffArrayByDate($val, $userId, $date, 'timeFrom',$i);
$timeFrom =  !empty($timef) ? $timef : "00:00";
$timet = $this->staffArrayByDate($val, $userId, $date, 'timeTo',$i);
$timeTo   =  !empty($timet) ? $timet : "00:00";
$sname = $this->staffArrayByDate($val, $userId, $date, 'rshiftname',$i);
$sn   =  !empty($sname) ? $sname : "";
$btime = $this->staffArrayByDate($val, $userId, $date, 'breakTime',$i);
$break   =  !empty($btime) ? $btime : "00:00";
$time = $this->staffArrayByDate($val, $userId, $date, 'rotaComment',$i);
$rotaComment   =  !empty($time) ? $time : "";
$time = $this->staffArrayByDate($val, $userId, $date, 'dentist_id',$i);
$dentist_id   =  !empty($time) ? $time : "";
$col = $this->staffArrayByDate($val, $userId, $date, 'color',$i);
$color   =  !empty($col) ? $col : "";
//  var_dump($col);

$style = "";

if ($timeFrom != '00:00' && $timeTo != '00:00') {
$hours = $this->staffArrayByDate($val, $userId, $date, 'cnt',$i);
$totalHours += $hours;
$temp = $total[$date];
$total[$date] = $temp + $hours;
}

$rotaOff = $this->staffArrayByDate($val, $userId, $date, 'rotaOff',$i);
if ($rotaOff == 'Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Holiday</div>";
} else if ($rotaOff == 'Day Off') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Day Off</div>";
} else if ($rotaOff == 'Sick') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Sick <br> (LEAVE)</div>";
} else if ($rotaOff == 'Maternity') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Maternity <br> (LEAVE)</div>";
} else if ($rotaOff == 'Annual Leave') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Annual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Casual') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Casual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Half Day') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Half Day <br> (LEAVE)</div>";
} else if ($rotaOff == 'Weekend  Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Weekend <br> Holiday</div>";
} else if ($timeFrom != '00:00' && $timeTo != '00:00') {
$trshow = 1;
$style = "style='border-color: #5bc9d6;'";
$tempT = "$timeFrom&nbsp;-&nbsp;$timeTo<br>
      $hours<br>" . $this->UserName($dentist_id) . "<br><i class='fas fa-coffee'></i>&nbsp;$break<br>$rotaComment";
} else {
$tempT = "<div class='btn btn-danger btn-sm'>N|A - NWD</div>";
}
// $mysql = "SELECT `color` FROM `shift` WHERE `timefrom`='$timef' AND `timeto`='$timet' AND `break`='$btime' AND `user`='$user'";
// $row = $this->dbF->getRow($mysql);

if (!empty($color)) {
$style = "style='border-color: $color;'";
}
echo "<td $style><div class='row' style='display:block;'>$sn<br><p>$tempT</p></div></td>";
}
    echo "</tr></table></td>";
}
if ($trshow == 0) {
$trHideScript .= '<script>$("#' . $trid . '").hide();</script>';
}

$cost = $rate * $totalHours;
$totalRate += $rate;
$totalCost += $cost;
echo "<td id='age' class='rota-result' data-toggle='tooltip' title='" . $this->decimal_to_time($totalHours) . "'><div
>$totalHours</div></td>";

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo "<td class='rota-result'><div>$rate</div></td>
<td class='rota-result'><div>$cost</div></td>";
}
echo "</tr>";
}
echo "</tr>
</tbody>
</table>
</div>
$trHideScript";
}


public function WeeklyWagesResult_old()
{


$branchId   = 0;
if (empty(@$_GET['datev'])) {
$date = date('Y-m-d', strtotime('monday this week'));
} else {
$date = @htmlspecialchars($_GET['datev']);
}


$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`shift`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN ? AND ?
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `date`,`a`.`userId` ASC";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));

$dates = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$dates[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

echo '<div class="rota-table">
<table>
<thead>
    <th>Sno</th>
    <th>Staff Name</th>';

foreach ($dates as $val2) {
$day = date('l', strtotime($val2));
$val2 = date("d-M-Y", strtotime($val2));
echo "<th class='text-center'>$val2 <br> $day</th>";
}

echo '<th>Total Hours</th>';

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo '<th>Wages Rate</th>
<th>Total Cost</th>';
}

echo '</thead>
<tbody>';
$i  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
foreach ($staffs as $key => $val) {
$i++;
$userId = $key;
$name   = $this->staffArrayByDate($val, $userId, '', 'user');
// $image   = $this->staffArrayByDate($val,$userId,'','image');
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo = $this->dbF->getRows($sql, array($userId));
$rate   = floatval($this->webUserInfoArray($userInfo, 'salary'));
$cost   = 0;
$totalHours = 0;
$trid = "tr" . rand();
$trshow = 0;

$imageuser = $this->staffArrayByDate($val, $userId, '', 'image');



@$iamge2 = "d-profile.png";
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $this->staffArrayByDate($val, $userId, '', 'image');
}

echo "<tr id='$trid'>
<th>$i<button class='shtd' type='button'data-toggle='tooltip' title='Show/Hide'><input type='hidden' name='rota$userId' value='1'><i class='fas fa-eye'></i></button></i></th>
<th><span>";  ?>
<img src="<?php echo $imageuser   ?>" >
<?php
echo   " $name</span></th>";

foreach ($dates as $val2) {
 echo "<td><table><tr>";//double shift view
for($i=1;$i<3;$i++){
$date  = $val2;

$timef = $this->staffArrayByDate($val, $userId, $date, 'timeFrom',$i);
$timeFrom =  !empty($timef) ? $timef : "00:00";
$timet = $this->staffArrayByDate($val, $userId, $date, 'timeTo',$i);
$timeTo   =  !empty($timet) ? $timet : "00:00";
$sname = $this->staffArrayByDate($val, $userId, $date, 'rshiftname',$i);
$sn   =  !empty($sname) ? $sname : "";
$btime = $this->staffArrayByDate($val, $userId, $date, 'breakTime',$i);
$break   =  !empty($btime) ? $btime : "00:00";
$time = $this->staffArrayByDate($val, $userId, $date, 'rotaComment',$i);
$rotaComment   =  !empty($time) ? $time : "";
$time = $this->staffArrayByDate($val, $userId, $date, 'dentist_id',$i);
$dentist_id   =  !empty($time) ? $time : "";
$col = $this->staffArrayByDate($val, $userId, $date, 'color',$i);
$color   =  !empty($col) ? $col : "";
//  var_dump($col);

$style = "";

if ($timeFrom != '00:00' && $timeTo != '00:00') {
$hours = $this->staffArrayByDate($val, $userId, $date, 'cnt',$i);
$totalHours += $hours;
$temp = $total[$date];
$total[$date] = $temp + $hours;
}

$rotaOff = $this->staffArrayByDate($val, $userId, $date, 'rotaOff',$i);
if ($rotaOff == 'Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Holiday</div>";
} else if ($rotaOff == 'Day Off') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Day Off</div>";
} else if ($rotaOff == 'Sick') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Sick <br> (LEAVE)</div>";
} else if ($rotaOff == 'Maternity') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Maternity <br> (LEAVE)</div>";
} else if ($rotaOff == 'Annual Leave') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Annual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Casual') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Casual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Half Day') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Half Day <br> (LEAVE)</div>";
} else if ($rotaOff == 'Weekend  Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Weekend <br> Holiday</div>";
} else if ($timeFrom != '00:00' && $timeTo != '00:00') {
$trshow = 1;
$style = "style='border-color: #5bc9d6;'";
$tempT = "$timeFrom&nbsp;-&nbsp;$timeTo<br>
      $hours<br>" . $this->UserName($dentist_id) . "<br><i class='fas fa-coffee'></i>&nbsp;$break<br>$rotaComment";
} else {
$tempT = "<div class='btn btn-danger btn-sm'>N|A - NWD</div>";
}
// $mysql = "SELECT `color` FROM `shift` WHERE `timefrom`='$timef' AND `timeto`='$timet' AND `break`='$btime' AND `user`='$user'";
// $row = $this->dbF->getRow($mysql);

if (!empty($color)) {
$style = "style='border-color: $color;'";
}
echo "<td $style><div class='row' style='display:block;'>$sn<br><p>$tempT</p></div></td>";
}
    echo "</tr></table></td>";
}
if ($trshow == 0) {
$trHideScript .= '<script>$("#' . $trid . '").hide();</script>';
}

$cost = $rate * $totalHours;
$totalRate += $rate;
$totalCost += $cost;
echo "<td id='age' class='rota-result' data-toggle='tooltip' title='" . $this->decimal_to_time($totalHours) . "'><div
>$totalHours</div></td>";

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo "<td class='rota-result'><div>$rate</div></td>
<td class='rota-result'><div>$cost</div></td>";
}
echo "</tr>";
}
echo "</tr>
</tbody>
</table>
</div>
$trHideScript";
}
public function WeeklyWagesResult_old_1()
{

$branchId   = 0;
if (empty(@$_GET['from'])) {
$date = date('Y-m-d', strtotime('monday this week'));
} else {
$date = @$_GET['from'];
}
$from       = date('Y-m-d', strtotime($date));
$to         = date('Y-m-d', strtotime("+6 day " . $from));
$user       = intval($_SESSION['currentUser']);

$sql = "SELECT `hour` as `cnt`,
`rotaOff`,
`timeFrom`,
`timeTo`,
`color`,
`shift`,
`rshiftname`,
`breakTime`,`dentist_id`,`rotaComment`,`userId`,
`branch`,`date`,
(SELECT `acc_name` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
(SELECT `acc_image` FROM `accounts_user` as `b` 
WHERE `b`.`acc_id`=`a`.`userId`)  as `image` 
FROM `record` as `a` 
WHERE `branch` = ?  
AND `a`.`date` BETWEEN ? AND ?
AND  (`a`.`userId` = ? OR `a`.`userId` IN 
(SELECT `id_user` FROM `accounts_user_detail` 
WHERE `setting_val`= ?  AND `setting_name` = 'account_under' )) 
AND userId IN (SELECT acc_id FROM accounts_user WHERE acc_type = '1')  
ORDER BY `a`.`userId`,`date` ASC";
$data = $this->dbF->getRows($sql, array($branchId, $from, $to, $user, $user));

$dates = array();
$total = array();
$staffs = array();
foreach ($data as $val) {
$dates[$val['date']] = $val['date'];
$total[$val['date']] = 0;
}
foreach ($data as $val) {
$staffs[$val['userId']] = $data;
}

echo '<div class="rota-table">
<table>
<thead>
    <th>Sno</th>
    <th>Staff Name</th>';

foreach ($dates as $val2) {
$day = date('l', strtotime($val2));
$val2 = date("d-M-Y", strtotime($val2));
echo "<th class='text-center'>$val2 <br> $day</th>";
}

echo '<th>Total Hours</th>';

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo '<th>Wages Rate</th>
<th>Total Cost</th>';
}

echo '</thead>
<tbody>';
$i  = 0;
$totalRate  = 0;
$totalCost  = 0;
$trHideScript = "";
foreach ($staffs as $key => $val) {
$i++;
$userId = $key;
$userId=intval($userId);
$name   = $this->staffArrayByDate($val, $userId, '', 'user');
// $image   = $this->staffArrayByDate($val,$userId,'','image');
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo = $this->dbF->getRows($sql, array($userId));
$rate   = floatval($this->webUserInfoArray($userInfo, 'salary'));
$cost   = 0;
$totalHours = 0;
$trid = "tr" . rand();
$trshow = 0;

$imageuser = $this->staffArrayByDate($val, $userId, '', 'image');



@$iamge2 = "d-profile.png";
if ($imageuser == "#" || trim($imageuser) == "") {

$imageuser = @$image2;
$imageuser = "webImages/d-profile.png";
} else {

$imageuser = "images/" . $this->staffArrayByDate($val, $userId, '', 'image');
}

echo "<tr id='$trid'>
<th>$i</th>
<th><span>";  ?>
<img src="<?php echo $imageuser   ?>">
<?php
echo   " $name</span></th>";

foreach ($dates as $val2) {
    echo "<td><table><tr>";
       for($i=1;$i<3;$i++){
$date  = $val2;

$timef = $this->staffArrayByDate($val, $userId, $date, 'timeFrom',$i);
$timeFrom =  !empty($timef) ? $timef : "00:00";
$timet = $this->staffArrayByDate($val, $userId, $date, 'timeTo',$i);
$timeTo   =  !empty($timet) ? $timet : "00:00";
$sname = $this->staffArrayByDate($val, $userId, $date, 'rshiftname',$i);
$sn   =  !empty($sname) ? $sname : "";
$btime = $this->staffArrayByDate($val, $userId, $date, 'breakTime',$i);
$break   =  !empty($btime) ? $btime : "00:00";
$time = $this->staffArrayByDate($val, $userId, $date, 'rotaComment',$i);
$rotaComment   =  !empty($time) ? $time : "";
$time = $this->staffArrayByDate($val, $userId, $date, 'dentist_id',$i);
$dentist_id   =  !empty($time) ? $time : "";
$col = $this->staffArrayByDate($val, $userId, $date, 'color',$i);
$color   =  !empty($col) ? $col : "";
//  var_dump($col);

$style = "";

if ($timeFrom != '00:00' && $timeTo != '00:00') {
$hours = $this->staffArrayByDate($val, $userId, $date, 'cnt',$i);
$totalHours += $hours;
$temp = $total[$date];
$total[$date] = $temp + $hours;
}

$rotaOff = $this->staffArrayByDate($val, $userId, $date, 'rotaOff',$i);
if ($rotaOff == 'Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Holiday</div>";
} else if ($rotaOff == 'Day Off') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Day Off</div>";
} else if ($rotaOff == 'Sick') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Sick <br> (LEAVE)</div>";
} else if ($rotaOff == 'Maternity') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Maternity <br> (LEAVE)</div>";
} else if ($rotaOff == 'Annual Leave') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Annual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Casual') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Casual <br> (LEAVE)</div>";
} else if ($rotaOff == 'Half Day') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Half Day <br> (LEAVE)</div>";
} else if ($rotaOff == 'Weekend  Holiday') {
$trshow = 1;
$tempT = "<div class='btn btn-danger btn-sm'>Weekend <br> Holiday</div>";
} else if ($timeFrom != '00:00' && $timeTo != '00:00') {
$trshow = 1;
$style = "style='border-color: #5bc9d6'";
$tempT = "$timeFrom&nbsp;-&nbsp;$timeTo<br>
      $hours<br>" . $this->UserName($dentist_id) . "<br><i class='fas fa-coffee'></i>&nbsp;$break<br>$rotaComment";
} else {
$tempT = "<div class='btn btn-danger btn-sm'>N|A</div>";
}
// $mysql = "SELECT `color` FROM `shift` WHERE `timefrom`='$timef' AND `timeto`='$timet' AND `break`='$btime' AND `user`='$user'";
// $row = $this->dbF->getRow($mysql);

if (!empty($color)) {
$style = "style='border-color: $color;'";
}
echo "<td $style>$sn<br><p>$tempT</p></td>";
}
    echo "</tr></table></td>";
}

if ($trshow == 0) {
$trHideScript .= '<script>$("#' . $trid . '").hide();</script>';
}

$cost = $rate * $totalHours;
$totalRate += $rate;
$totalCost += $cost;
echo "<td class='rota-result'  data-toggle='tooltip' title='" . $this->decimal_to_time($totalHours) . "'><div>$totalHours</div></td>";

if (isset($_GET['page']) && $_GET['page'] == 'fullweekly') {
echo "<td class='rota-result'><div>$rate</div></td>
<td class='rota-result'><div>$cost</div></td>";
}
echo "</tr>";
}
echo "</tr>
</tbody>
</table>
</div>
$trHideScript";
}

public function staffArrayByDate($data, $userId, $date, $get,$shift=1)
{
    // var_dump($data);
foreach ($data as $val) {
$tDate = $val['date'];
    if ($val['date'] == $date && $val['userId'] == $userId && $val['shift'] == $shift) {
return $val[$get];
}
if ($date == '' && $val['userId'] == $userId) {
return $val[$get];
}
}
return "0";
}

public function webUserInfoArray($data, $settingName)
{
foreach ($data as $val) {
if ($val['setting_name'] == $settingName) {
return $val['setting_val'];
}
}
return "";
}

public function notifications($type, $user = "0", $title = NULL)
{
    $msg ="";

if ($user == '0') {
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}
}

$name = $this->UserName($user);
$email = $this->UserEmail($user);
if ($type == 'event' || $type == 'echeckin' || $type == 'echeckout' || $type == 'echeckinlate' || $type == 'echeckoutlate' || $type == 'covid' ||  $type == 'checkoutforget' ||  $type == 'leavesubmit' || $type == 'leaveSubmit' ||  $type == 'aretunrtowork' ||  $type == 'aleave3siknes') {
$user = $this->PracticeId($user);
$email = $this->UserEmail($user);
}
$sql  = "SELECT * FROM `notifications` WHERE `type` = ? AND `user` = ? ";
$data = $this->dbF->getRow($sql,array($type, $user));
// var_dump($sql, $user);
// exit();

$sql2 = "SELECT * FROM `email_letters` WHERE `email_type` = BINARY  ? ";

$data2 = $this->dbF->getRow($sql2, array($type));
$subject = $data2['subject'];
$msgN = $data2['mesaage_notification'];
$msg = $data2['message'];

if($data){
// if(!empty($msg)){
$subject = str_replace('{{name}}', $name, $subject);
$msg = str_replace('{{name}}', $name, $msg);
$title = str_replace('leave', "", $title);
$title = str_replace('Leave', "", $title);
$msg = str_replace('{{title}}', $title, $msg);
$msg = str_replace('{{type}}', $title, $msg);
$msgN = str_replace('{{name}}', $name, $msgN);
$msgN = str_replace('{{title}}', $title, $msgN);
$msgN = str_replace('{{type}}', $title, $msgN);
$msgN =  strip_tags($msgN);
$msg =  strip_tags($msg);
if ($data['push'] == '1' || $data2['type'] == 'admin') {
$this->push_notification($subject, $msgN, $this->getUserPlayerId($user));
// $this->push_notification("Intranet New Post", $msg, $this->getUserPlayerId($user));
}
if ($data['email'] == '1' || $data2['type'] == 'admin') {
    
$this->send_mail($email, $subject, $msg);
}
$sql  = "INSERT INTO `notification_record` (`user`,`type`,`notification`,`playerid`) VALUES (?,?,?,?)";
$array   = array($user, $type, $msgN, $this->getUserPlayerId($user));
$this->dbF->setRow($sql, $array);
}





}

public function checkin_not_rota_set()
{
   
    // var_dump($_POST['submit']);
    // exit();
if (isset($_POST['submit'])) {
if (!$this->getFormToken('checkin_rota_not')) {
if (!isset($_POST['ar'])) {
return false;
}


}
 
$userId = $_SESSION['webUser']['id'];
$time =  date('H:i', strtotime($_POST['time']));
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `userId` = ? ";
$data = $this->dbF->getRow($sql,array($userId));
// var_dump($data);
if (empty($data[0])) {
if (!isset($_POST['comment'])) {
$_POST['comment'] = NULL;
}
@$comment = $_POST['comment'];
if ($_POST['comment'] == "") {
$comment = "<br>";
}
$CurDate =  date('Y-m-d');
$time =  date('H:i', strtotime($_POST['time']));
$sql = "INSERT INTO `record`(`userId`,`timeFrom`, `timeTo`, `date`,`comment`,`checkin`)VALUES (?,?,?,?,?,?)";
$array = array($userId, '00:00', '00:00', $CurDate, $comment, $time);
$this->dbF->setRow($sql, $array);
$lastId = $this->dbF->rowLastId;
}
if (!empty($data)) {
if ($data['timeFrom'] = '00:00' || $data['color'] = '' || $data['timeTo'] = '00:00' || $data['hourWorked'] = '0') {
if (!isset($_POST['comment'])) {
    $_POST['comment'] = NULL;
}
@$comment = $_POST['comment'];
if ($_POST['comment'] == "") {
    $comment = "<br>";
}
$time =  date('H:i', strtotime($_POST['time']));
@$comment = $_POST['comment'];
$sql = "UPDATE `record` SET `checkin`= ? , `comment`= ? ,`rotaOff` = '' WHERE `userId`= ?  AND `date` = date(NOW())";
$arr = array($time, $comment, $userId);
$this->dbF->setRow($sql, $arr);
// $lastId = $this->dbF->rowLastId;
}
}
$this->setlog("Checkin With out Rota", $this->UserName($userId) . " : $userId", "", $time);
$this->notifications('checkin');

return true;
}
}

public function lunch_time_checkin()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('lunch_time_checkin')) {
if (!isset($_POST['ar'])) {

return false;
}

}

$userId = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `lunchtimeInOut` WHERE `dateTime` = date(NOW()) AND `user`= ? AND `lunch_out` ='' ";
$data = $this->dbF->getRow($sql,array($userId));
if (empty($data[0])) {

$time =  date('H:i', strtotime($_POST['time']));
@$comment = htmlspecialchars($_POST['comment']);
if ($_POST['comment'] == "") {
$comment = "<br>";
}
$CurDate =  date('Y-m-d');
$time =  date('H:i', strtotime($_POST['time']));
$sql = "INSERT INTO `lunchtimeInOut`(`user`, `lunch_in`,`comment`,`dateTime`)VALUES (?,?,?,?)";
$array = array($userId, $time, $comment, $CurDate);
$this->dbF->setRow($sql, $array);
$lastId = $this->dbF->rowLastId;
}
$this->setlog("Lunch Time Checkin", $this->UserName($userId) . " : $userId",$lastId, $time);
//$this->notifications('checkin');

return true;
}
}


public function lunch_time_checkout()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('lunch_time_checkout')) {
if (!isset($_POST['ar'])) {

return false;
}

}

$userId = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `lunchtimeInOut` WHERE `dateTime` = date(NOW()) AND `user`= ? AND `lunch_in` !='' AND `lunch_out` ='' ";
$data = $this->dbF->getRow($sql, array($userId));
$id = $data['id'];
if (!empty($data[0])) {

$time =  date('H:i', strtotime($_POST['time']));
@$comment = htmlspecialchars($_POST['comment']);
if ($_POST['comment'] == "") {
$comment = "<br>";
}

$time =  date('H:i', strtotime($_POST['time']));
// $sql = "INSERT INTO `lunchtimeInOut`(`user`, `lunch_out`,`comment`,`dateTime`)VALUES (?,?,?,?)";
$sql = "UPDATE `lunchtimeInOut` SET 
`user` = ?,
`lunch_out` = ?,
`comment` = concat(comment,'<br>$comment')

WHERE user = '$userId' AND `lunch_in` !='' AND `id`= '$id' ";
$array = array($userId, $time);
$this->dbF->setRow($sql, $array);

}
$this->setlog("Lunch Time CheckOut", $this->UserName($userId) . " : $userId",$id, $time);
//$this->notifications('checkin');

return true;
}
}

public function addCoursCPD_multiple_user($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}

if (!$this->getFormToken('rotadeletemultiple') && $apiPostData="") {
return false;
}
// $duser = empty($_POST['duser']) ? array() : explode(",", $_POST['duser']);
$duser = empty($_POST['duser']) ? array() : $_POST['duser'];
$cpdcourse = empty($_POST['cpdcourse']) ? '' : $_POST['cpdcourse'];

// var_dump(count($duser));
// var_dump(is_array($duser));
if(!empty($duser)){
for ($i = 0; $i < count($duser); $i++) {

// echo  $i. "===COUNT==";
// echo "<br>";
// echo $cpdcourse . "===course===";
// echo "<br>";
// echo $duser[$i] . "===user===";
// echo "<br>";


$sql = "INSERT INTO `delegate_cpd_course` (`delegate_user`,`delegate_subject_id`) VALUES (?,?)";
// va/r_dump($duser[$i],$cpdcourse);
$data = $this->dbF->setRow($sql,array($duser[$i],$cpdcourse));
}
if ($this->dbF->rowCount > 0) {
return true;
}else{
    return false;
}

}





}

public function checkin()
{

if (isset($_POST['submit'])) {
if (!$this->getFormToken('checkin')) {
if (!isset($_POST['ar'])) {

return false;
}

}
$userId = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `userId`= ? ";
$data = $this->dbF->getRow($sql, array($userId));
if (empty($data[0])) {
return "Rota Not Found";
}
$time =  date('H:i', strtotime($_POST['time']));
$shift =  htmlspecialchars($_POST['shift']);
@$comment = htmlspecialchars($_POST['comment']);
$sql = "UPDATE `record` SET `checkin`= ? , `comment`= ? WHERE `userId`= ? AND `date` = date(NOW()) AND `shift`= ? ";
$this->dbF->setRow($sql, array($time, $comment, $userId, $shift));
// $lastId = $this->dbF->rowLastId;


$this->setlog("Checkin", $this->UserName($userId) . " : $userId","", $time);
$this->notifications('checkin');
$this->dbF->setRow("DELETE FROM `cronData` WHERE `user`= ? AND `type`= ? OR `type`= ? ", array($userId, 'inlate', 'checkinbefore'));
if ($_SESSION['currentUserType'] == 'Employee') {
$this->notifications('echeckin');
}
return true;
}
}

public function checkoutforgetSubmit()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('checkoutforgettoken')) {
return false;
}
$time = date('H:i', strtotime($_POST['time']));
@$comment = htmlspecialchars($_POST['comment']);
$userId = intval($_SESSION['webUser']['id']);
$email = htmlspecialchars($_SESSION['webUser']['email']);
$name = htmlspecialchars($_SESSION['webUser']['name']);
$dateforget = $_POST['selectCheckOutForget'];
$dateforget=explode("_",$dateforget);
$sql = "SELECT `checkin`,`breakTime`,`timeTo` FROM `record` WHERE `userId`= ? AND `date` = date(NOW())";
$data = $this->dbF->getRow($sql, array($userId));
$checkin = $data[0];
$break = $data[1];
$CurDate =  date('Y-m-d');
$break =$this->calculateTTLBreak($userId,$CurDate);
$time1 = strtotime($checkin);
$time2 = strtotime($time);
$breaktime = date("G", strtotime($break)) * 60 * 60 + date("i", strtotime($break)) * 60;
$difference = round(abs($time2 - $time1 - $breaktime) / 3600, 2);
$Tcomment = 'concat(comment,<br>'.$comment.')';
$sql = "UPDATE `record` SET `checkout`= ?  , `comment`=  ? ,`edit_lock` = '1' WHERE `userId`= ?";
$this->dbF->setRow($sql,array($time,$Tcomment, $userId));
// $lastId = $this->dbF->rowLastId;
$ThankWeSend = $this->dbF->hardWords('Thank you! Check Out Forget.', false);
$this->setlog("CheckoutForget", $this->UserName($userId) . " : $userId","", $time);

$this->notifications('checkoutforget', $userId);

$this->send_mail($email, '', '', 'checkoutforget', $name);

// $this->send_mail($email,'You Check Out Forget','',$name);
return $msg = $ThankWeSend;

return true;
}
}
public function checkinforgetSubmit()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('checkinforgettoken')) {
return false;
}
$userId = $_SESSION['webUser']['id'];
$email  = $_SESSION['webUser']['email'];
$name   = $_SESSION['webUser']['name'];
$dateforget = $_POST['selectCheckinForget'];


// $userId=intval($userId);
// htmlspecialchars($email);
// htmlspecialchars($name);


$time =  date('H:i', strtotime($_POST['time']));
$dateforget=explode("_",$dateforget);
@$comment = $_POST['comment'];
$Tcomment = 'concat(comment,<br>'.$comment.')';
if (isset($dateforget[0]) && isset($dateforget[1])) {
    $sql = "UPDATE `record` SET `checkin` = ?, `comment` = ? WHERE `userId` = ? AND `date` = ? AND `shift` = ?";
    $values = array($time, $Tcomment, $userId, $dateforget[0], $dateforget[1]);
    $this->dbF->setRow($sql, $values);
} else {
    $sql = "UPDATE `record` SET `checkin`= ?  , `comment`= ? WHERE `userId`= ? ";
    $this->dbF->setRow($sql, array($time, $Tcomment, $userId));
}
// $sql = "UPDATE `record` SET `checkin`= ?  , `comment`= ? WHERE `userId`= ? AND `date` = ? AND `shift` = ? ";
// $this->dbF->setRow($sql, array($time, $difference, $Tcomment, $userId, $dateforget[0], $dateforget[1]));
// $lastId = $this->dbF->rowLastId;
$ThankWeSend = $this->dbF->hardWords('Thank you! Check Out Forget.', false);
$this->setlog("CheckoutForget", $this->UserName($userId) . " : $userId","", $time);

$this->notifications('checkoutforget', $userId);

$this->send_mail($email, '', '', 'checkoutforget', $name);

// $this->send_mail($email,'You Check Out Forget','',$name);
return $msg = $ThankWeSend;

return true;
}
}
public function checkout()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('checkout')) {
if (!isset($_POST['ar'])) {

return false;
}

}

$time = date('H:i', strtotime($_POST['time']));
$userId = intval($_SESSION['webUser']['id']);
@$comment =htmlspecialchars($_POST['comment']);
$shift =htmlspecialchars($_POST['shift']);
$sql = "SELECT `checkin`,`breakTime`,`timeTo` FROM `record` WHERE `userId`= ? AND `shift`= ?  AND `date` = date(NOW())";
$data = $this->dbF->getRow($sql, array($userId, $shift));
$checkin = $data[0];
$break = $data[1];
$CurDate =  date('Y-m-d');
$break =$this->calculateTTLBreak($userId,$CurDate);
$time1 = strtotime($checkin);
$time2 = strtotime($time);
$breaktime = date("G", strtotime($break)) * 60 * 60 + date("i", strtotime($break)) * 60;
$difference = round(abs($time2 - $time1 - $breaktime) / 3600, 2);
$Tcomment = 'concat(comment,<br>'.$comment.')';
$sql = "UPDATE `record` SET `checkout`= ? ,`hourWorked`= ? ,`breakTime`= ? , `comment`= ? ,`edit_lock` = '1' WHERE `userId`= ?  AND `shift`= ? AND `date` = date(NOW())";
$this->dbF->setRow($sql,array($time,$difference, $break, $Tcomment, $userId, $shift));
$lastId = $this->dbF->rowLastId;

$this->setlog("Checkout", $this->UserName($userId) . " : $userId","", $time);
$this->notifications('checkout');
$this->dbF->setRow("DELETE FROM `cronData` WHERE `user`= ? AND `type`= ? OR `type` = ? ", array($userId, 'outlate', 'checkoutbefore'));
if ($_SESSION['currentUserType'] == 'Employee') {
$this->notifications('echeckout');
}
return true;
}
}


public function calculateTTLBreak($userId,$CurDate)
{
$sql = "SELECT * FROM `lunchtimeInOut` WHERE  `user`= ?  AND  `dateTime` = ? ";
$data = $this->dbF->getRows($sql, array($userId, $CurDate));
$r = "";
if (!empty($data)) {
foreach ($data as $key => $valueD) {
$dateDiff = intval((strtotime($valueD['lunch_out'])-strtotime($valueD['lunch_in']))/60);
$hours = intval($dateDiff/60);
$minutes = $dateDiff%60;

if(strlen($hours) == 1 && strlen($minutes) == 1){
    $r .= "0".$hours.":0".$minutes.",";
}elseif(strlen($hours) == 2 && strlen($minutes) == 2){
    $r .= $hours.":".$minutes.",";
}elseif(strlen($hours) == 2 && strlen($minutes) == 1){
    $r .= $hours.":0".$minutes.",";
}elseif(strlen($hours) == 1 && strlen($minutes) == 2){
    $r .= "0".$hours.":".$minutes.",";
}






}

$r = trim($r,",");

$getV = explode(",", $r);

$r= "";
if(count($getV) > 1){
    for($i=1 ; $i<count($getV); $i++){
        $secs = strtotime($getV[$i])-strtotime("00:00");
        $getV[$i] = $r = date("H:i",strtotime($getV[$i-1])+$secs);
    }
// $secs = strtotime($getV['1'])-strtotime("00:00");
// $r = date("H:i",strtotime($getV['0'])+$secs);
}elseif(count($getV) < 2){
$r = date("H:i",strtotime($getV['0']));
}
   
    
}
return $r;
}
public function CheckInCheck()
{
$user = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkin`='' AND `userId`='$user' AND `rotaOff` NOT IN('Holiday','Day Off','Sick') AND (`timeFrom` != '00:00' AND `timeTo` !='00:00')";
$data = $this->dbF->getRow($sql);
if (!empty($data)) {
$t1 = date('H:i', (strtotime($data['timeFrom']) - 900));
$t2 = date('H:i');
if ($t1 < $t2) {
if ($_SESSION['currentUserType'] == 'Employee') {
echo "<script>
        var filename = location.pathname.substr(location.pathname.lastIndexOf('/')+1);
        if(filename != 'checkinout'){window.location.href='checkinout?type=checkin'}
    </script>";
return true;
} else {
return false;
}
}
}
}


function someDayOfSignup($emailType,$variation){
 $emailType= $emailType.''.$variation;
 $sql1  = "SELECT * FROM accounts_user WHERE DATE_FORMAT(acc_created, '%Y-%m-%d') = curdate() - INTERVAL $variation DAY AND acc_type = 1 ORDER BY `accounts_user`.`acc_created` DESC";
$data1 =  $this->dbF->getRows($sql1);
if ($this->dbF->rowCount > 0) {
$tableTr = "";  
foreach($data1 as $val){
$id = $val['acc_id'];
$acc_email = $val['acc_email'];
$acc_created = date('d-M-Y',strtotime($val['acc_created']));
$acc_name = $val['acc_name'];
$sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $this->dbF->getRows($sql,array($id));
$account_type =  $this->webUserInfoArray($userInfo,'account_type');
if($account_type != "Employee"){
$sql2 = "SELECT * FROM email_letters WHERE email_type = ?";
$data2 = $this->dbF->getRow($sql2,array($emailType));
$subject = $data2['subject'];
$msg = $data2['message'];
$this->send_mail($acc_email,$subject,$msg);
        
$tableTr .= '<tr>
                <td>' . $acc_name . '</td> 
                <td>' . $acc_email . '</td>
                <td>' . $emailType . '</td>
                <td>' . $account_type . '</td> 
                <td>' . $acc_created . '</td> 
             </tr>';
}
}
return $tableTr;
}else{
    return "";
}
}

public function covidCheck($isApi = false)
{
$user =  intval($_SESSION['webUser']['id']);
$user1 = intval($_SESSION['currentUser']);
$user;
$user1;
$_SESSION['allUsers'];
@$_SESSION['covidhide']['hide'];
$covid = "";
$d = $this->dbF->getRow("SELECT * FROM `covid` WHERE `date` = date(NOW()) AND `user`='$user'");


$c = $this->dbF->getRow("SELECT * FROM accounts_user  WHERE  acc_id = ? ",array($user1));
if (!$isApi) {
    
$covid = "<script>$(document).ready(function(){covid();});</script>";


if (@$_SESSION['covidhide']['hide'] != '0') {



if ($c['covid'] == '1') {

if (empty($d)) {


echo $covid;
} else {
$covid = "";
}
}
}
}else{
    $covid = false;
    if (@$_SESSION['covidhide']['hide'] != '0') {
        if ($c['covid'] == '1') {
            $covid = true;
        }else{
            $covid = false;
        }
    }
    return $covid;
}
}

public function newuserWellcome()
{
$user = intval($_SESSION['webUser']['id']);
//$user = $_SESSION['currentUser'];



$data = $this->dbF->getRow("SELECT * FROM `accounts_user` WHERE `last_login` = '' AND `acc_id` = '$user'");

$data1 = $this->dbF->getRow("SELECT last_login FROM `accounts_user` WHERE `acc_id` = '$user'");

$wellcome = "<script>$(document).ready(function(){newuserWellcome();});</script>";


# code...



if (@$data['wellcome_video'] == '0') {


echo  $wellcome;
return true;
} else {
return false;
}
}


public function referfriendSubmit()
{

$contactAllow = true;

if (isset($_POST['submit']) && !empty($_POST['form']['name'])) {

if ($this->getFormToken('referfriend')) {

$img = "";

$msg = '<table border="1">';


$f = '';
$v = '';
$c = 1;
$array = array();




foreach ($_POST['form'] as $key => $val) {

$msg .= '

<tr>

<td>' . ucwords(str_replace("_", " ", $key)) . '</td>

<td>' . $val . '</td>

</tr>';



$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;


$array[]= $v;



$c++;




}

$msg .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';


$userId = intval($_SESSION['webUser']['id']);

$acc_sql = "SELECT * FROM  `accounts_user` WHERE acc_id  = ? ";
$acc_data =  $this->dbF->getRow($acc_sql, array($userId));


$msg .= '<tr> <td>Refer By</td>  <td>(***Name -' . $aacc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';



$msg .= '</table>';



$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("referfriend");
$array = array_merge($array, $data2);


// echo $sql;
// var_dump($array);


$this->dbF->setRow($sql,$array,false);





$user = intval($_SESSION['webUser']['id']);
$nameUser =   $_POST['form']['name'];

$to =   $_POST['form']['email'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$sql = "DELETE FROM referfriend WHERE `user` = ? ";
$this->dbF->setRow($sql,array($user));

$sql  = "INSERT INTO `referfriend` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '1', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
$thankT = $this->dbF->hardWords('Thank You ' . $nameUser . ' You Refer a Gift Hamper.', false);

$message2 = "Hello " . ucwords($nameUser) . ",<br><br>

$thankT.<br><br>";

$too = $this->ibms_setting('Email');


             $msg1 ='';
$dirr = __DIR__."/referfriend.txt";
$fh = fopen($dirr,'r');
while ($line = fgets($fh)) {
$msg1 .=$line;
}
foreach ($_POST['form'] as $key => $val) {
$msg1 .= '
<tr>
<td>' . ucwords(str_replace("_", " ", $key)) . '</td>
<td>' . $val . '</td>
</tr>';
}
$msg1 .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';
$userId = $_SESSION['webUser']['id'];
$msg1 .= '<tr> <td>Refer By</td>  <td>(***Name -' . $aacc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';

$dirr = __DIR__."/referfriend.txt";
$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1);
fclose($myfile);



// $this->send_mail($too,'Refer a Gift Hamper',$msg);
// $this->send_mail($to,'Refer a Gift Hamper',$nameUser)
if ($this->send_mail($too, 'Refer a Gift Hamper', $msg)) {

$pMmsg = "$thankT";
} else {

$thankT = $this->dbF->hardWords('Thanku You ' . $nameUser . ' You Refer a Gift Hamper.', false);
$errorT = $this->dbF->hardWords('An Error occured while sending your mail. Please Try Later', false);

$pMmsg = "$errorT";
}

$contactAllow = false;
} else {
$contactAllow = true;
}
if ($pMmsg != '') {
// echo "<div class='alert alert-info'>$pMmsg</div>";
}
}
}

public function feedbackFormSubmit()
{

$contactAllow = true;

if (isset($_POST['submit'])) {

if ($this->getFormToken('feedbackForm')) {

$img = "";

$msg = '<table border="1">';


$f = '';
$v = '';
$c = 1;
$array = array();




foreach ($_POST['form'] as $key => $val) {

$msg .= '

<tr>

<td>' . ucwords(str_replace("_", " ", $key)) . '</td>

<td>' . $val . '</td>

</tr>';



$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;


$array[]= $v;



$c++;




}



$msg .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';


$userId = intval($_SESSION['webUser']['id']);

$acc_sql = "SELECT * FROM  `accounts_user` WHERE acc_id  = ? ";
$acc_data =  $this->dbF->getRow($acc_sql, array($userId));

$userName = array('Name :' . $acc_data['acc_name']);
$msg .= '<tr> <td>User Details</td>  <td>(***Name -' . $acc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';



$msg .= '</table>';


$f .= 'field7 =?,';
$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("feedback");

$array = array_merge($array,$userName);
$array = array_merge($array, $data2);

// echo $sql;
// var_dump($array);


$this->dbF->setRow($sql,$array,false);





$user = intval($_SESSION['webUser']['id']);
// $nameUser =   $_POST['form']['name'];

// $to =   $_POST['form']['email'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$sql = "DELETE FROM feedback WHERE `user` = ? ";
$this->dbF->setRow($sql, array($user));

$sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '1', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
$thankT = $this->dbF->hardWords('Thank you for giving your feedback.', false);

// $message2 = "Hello " . ucwords($nameUser) . ",<br><br>

// $thankT.<br><br>";

$too = $this->ibms_setting('Email');


//              $msg1 ='';
// $dirr = __DIR__."/referfriend.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// $msg1 .=$line;
// }
// foreach ($_POST['form'] as $key => $val) {
// $msg1 .= '
// <tr>
// <td>' . ucwords(str_replace("_", " ", $key)) . '</td>
// <td>' . $val . '</td>
// </tr>';
// }
// $msg1 .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';
// $userId = $_SESSION['webUser']['id'];
// $msg1 .= '<tr> <td>Refer By</td>  <td>(***Name -' . $aacc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';

// $dirr = __DIR__."/referfriend.txt";
// $myfile = fopen($dirr, "w");
// fwrite($myfile, $msg1);
// fclose($myfile);



// $this->send_mail($too,'Refer a Gift Hamper',$msg);
// $this->send_mail($to,'Refer a Gift Hamper',$nameUser)
if ($this->send_mail($too, 'FeedBack', $msg)) {

$pMmsg = "$thankT";
} else {

$thankT = $this->dbF->hardWords('Thanku You ' . $nameUser . ' You Refer a Gift Hamper.', false);
$errorT = $this->dbF->hardWords('An Error occured while sending your mail. Please Try Later', false);

$pMmsg = "$errorT";
}

$contactAllow = false;
} else {
$contactAllow = true;
}
if (@$pMmsg != '') {
echo "<div class='alert alert-info'>$pMmsg</div>";
}
}
}

public function referfriendview()
{
$user = intval($_SESSION['webUser']['id']);
//$user = $_SESSION['currentUser'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$referfriend = "<script>$(document).ready(function(){referfriend();});</script>";

// $sql = "SELECT * FROM `referfriend` WHERE  `user` = '$user' AND `datetime` = date(NOW()) ";
//      $data = $this->dbF->getRow($sql);
$sql = "SELECT * FROM `referfriend` WHERE  `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
@$datetime_week = Date('Y-m-d', strtotime($data['datetime'] . '+ 1 week'));
@$datetime_Month = Date('Y-m-d', strtotime($data['datetime'] . '+ 3 month'));

if (empty($data)) {

$sql1 = "SELECT * FROM `accounts_user` WHERE DATE(acc_created) <= DATE(CURDATE() - INTERVAL 3 MONTH) AND `acc_id` = ? ";
$data1 = $this->dbF->getRow($sql1, array($user));


if (!empty($data1)) {

echo $referfriend;
$sql  = "INSERT INTO `referfriend` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
} else {





if ($data['fill'] == "0" &&  $date >= $datetime_week) {

echo  $referfriend;
$this->dbF->setRow("DELETE FROM referfriend WHERE `user` = ? ", array($user));
$date = Date('Y-m-d');
$sql  = "INSERT INTO `referfriend` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
if ($data['fill'] == "1" &&  $date >= $datetime_Month) {
echo  $referfriend;
$this->dbF->setRow("DELETE FROM referfriend WHERE `user` = ? ", array($user));
$date = Date('Y-m-d');
$sql  = "INSERT INTO `referfriend` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
}
}

public function isFeedbackFormView()
{
$user = intval($_SESSION['webUser']['id']);
//$user = $_SESSION['currentUser'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$referfriend = false;

// $sql = "SELECT * FROM `referfriend` WHERE  `user` = '$user' AND `datetime` = date(NOW()) ";
//      $data = $this->dbF->getRow($sql);
$sql = "SELECT * FROM `feedback` WHERE  `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
@$datetime_week = Date('Y-m-d', strtotime($data['datetime'] . '+ 1 week'));
@$datetime_Month = Date('Y-m-d', strtotime($data['datetime'] . '+ 3 month'));

if (empty($data)) {

$sql1 = "SELECT * FROM `accounts_user` WHERE DATE(acc_created) <= DATE(CURDATE() - INTERVAL 3 MONTH) AND `acc_id` = ? ";
$data1 = $this->dbF->getRow($sql1, array($user));


if (!empty($data1)) {

$referfriend = true;
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
} else {





if ($data['fill'] == "0" &&  $date >= $datetime_week) {

$referfriend = true;
// $this->dbF->setRow("DELETE FROM feedback WHERE `user` = '$user'");
$date = Date('Y-m-d');
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
if ($data['fill'] == "1" &&  $date >= $datetime_Month) {
$referfriend = true;
// $this->dbF->setRow("DELETE FROM feedback WHERE `user` = '$user'");
$date = Date('Y-m-d');
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
}
return $referfriend;
}
public function termsView()
{
    $user = intval($_SESSION['webUser']['id']);
    $sql  = "SELECT * FROM `orders` WHERE `order_user`= ? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157)  AND  order_mandate != '' ";
    $data =  $this->dbF->getRows($sql, array($user));
    $productId=@$data[0]['product_id'];
    $sql="SELECT * FROM term_and_condition WHERE status=1 AND productId= ?  ORDER BY Id DESC LIMIT 1";
    $rowTerm = $this->dbF->getRow($sql, array($productId));
    $termId=@$rowTerm['id'];
        if(!empty($termId)){
            $user = intval($_SESSION['currentUser']);
            $userType = $_SESSION['currentUserType'];
            $sql1="SELECT * FROM `terms_sign_By_user` WHERE userId= ?  AND userType= ? AND termId= ? ";
            $termSign = $this->dbF->getRow($sql1, array($user, $userType, $termId));

            if(empty($termSign)){
                return true;
            }
            else{
                return false;
            }
        }
}



public function isreferFriendFormView()
{
$user = intval($_SESSION['webUser']['id']);
//$user = $_SESSION['currentUser'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$referfriend = false;

// $sql = "SELECT * FROM `referfriend` WHERE  `user` = '$user' AND `datetime` = date(NOW()) ";
//      $data = $this->dbF->getRow($sql);
$sql = "SELECT * FROM `referfriend` WHERE  `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
@$datetime_week = Date('Y-m-d', strtotime($data['datetime'] . '+ 1 week'));
@$datetime_Month = Date('Y-m-d', strtotime($data['datetime'] . '+ 3 month'));

if (empty($data)) {

$sql1 = "SELECT * FROM `accounts_user` WHERE DATE(acc_created) <= DATE(CURDATE() - INTERVAL 3 MONTH) AND `acc_id` =  ? ";
$data1 = $this->dbF->getRow($sql1, array($user));


if (!empty($data1)) {

$referfriend = true;
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
} else {





if ($data['fill'] == "0" &&  $date >= $datetime_week) {

$referfriend = true;
// $this->dbF->setRow("DELETE FROM feedback WHERE `user` = '$user'");
$date = Date('Y-m-d');
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
if ($data['fill'] == "1" &&  $date >= $datetime_Month) {
$referfriend = true;
// $this->dbF->setRow("DELETE FROM feedback WHERE `user` = '$user'");
$date = Date('Y-m-d');
// $sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '0', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
}
}
return $referfriend;
}

public function feedbackFormView()
{
$user = intval($_SESSION['webUser']['id']);
//$user = $_SESSION['currentUser'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
$referfriend = "<script>$(document).ready(function(){feedbackForm();});</script>";

// $sql = "SELECT * FROM `referfriend` WHERE  `user` = '$user' AND `datetime` = date(NOW()) ";
//      $data = $this->dbF->getRow($sql);
$sql = "SELECT * FROM `feedback` WHERE  `user` = ? ";
$data = $this->dbF->getRow($sql,array($user));
@$datetime_week = Date('Y-m-d', strtotime($data['datetime'] . '+ 1 week'));
@$datetime_Month = Date('Y-m-d', strtotime($data['datetime'] . '+ 3 month'));

if (empty($data)) {

$sql1 = "SELECT * FROM `accounts_user` WHERE DATE(acc_created) <= DATE(CURDATE() - INTERVAL 3 MONTH) AND `acc_id` =  ? ";
$data1 = $this->dbF->getRow($sql1, array($user));


if (!empty($data1)) {

echo $referfriend;
$sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
} else {





if ($data['fill'] == "0" &&  $date >= $datetime_week) {

echo  $referfriend;
$this->dbF->setRow("DELETE FROM feedback WHERE `user` = ? ", array($user));
$date = Date('Y-m-d');
$sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
if ($data['fill'] == "1" &&  $date >= $datetime_Month) {
echo  $referfriend;
$this->dbF->setRow("DELETE FROM feedback WHERE `user` = ? ", array($user));
$date = Date('Y-m-d');
$sql  = "INSERT INTO `feedback` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
$array   = array($user, '0', '1', $currentDate);
$this->dbF->setRow($sql, $array, false);
}
}
}

public function CheckInBtn()
{
$user = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkin`=''  AND `userId`= ?  AND `rotaOff` NOT IN('Holiday','Day Off','Sick') AND (`timeFrom` != '00:00' AND `timeTo` !='00:00') ";
    $data = $this->dbF->getRows($sql, array($user));
    $count = $this->dbF->rowCount;

$sql2 = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `userId`= ? ";
$data2 = $this->dbF->getRow($sql2, array($user));
    $count2 = $this->dbF->rowCount;
// echo "<script>console.log('"; var_dump($data2);echo "');</script>";

$sql3 = "SELECT * FROM `record` WHERE `date` = date(NOW())  AND `userId`= ?   AND `checkout` ='' AND checkin ='' AND `rotaOff` NOT IN('Holiday','Day Off','Sick') ";
$data3 = $this->dbF->getRow($sql3, array($user));
    $count3 = $this->dbF->rowCount;

$sql6 = "SELECT * FROM `record` WHERE `date` = date(NOW())  AND `userId`= ?   AND `checkout` ='' AND checkin !='' AND `rotaOff` NOT IN('Holiday','Day Off','Sick') ";
$data6 = $this->dbF->getRow($sql6, array($user));
 $count6 = $this->dbF->rowCount;
if($count6==1){return;}
$sql4 = "SELECT * FROM `record` WHERE `date` = date(NOW())  AND `userId`= ?   AND `checkout` !='' AND checkin !='' AND `rotaOff` NOT IN('Holiday','Day Off','Sick') ";
$data4 = $this->dbF->getRow($sql3, array($user));
$count4 = $this->dbF->rowCount;
$button = '';
// $sql5 = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkin`='' AND `userId`=10";
$data5 = $this->dbF->getRow($sql3,  array($user));
$count5 = $this->dbF->rowCount;
$button = '';
if (!empty($data) ) {
    
    // $this->dbF->prnt($data);

    if($count==2){
    // if($data[0]['shift'] != ''){
        
        $currentTime=date("h:i");
        // $currentTime="11:50";
        $timefrom=$data[1]['timeFrom'];
        $timefrom1=$data[0]['timeFrom'];
        $timeto=$data[1]['timeTo'];
        $timeto1=$data[0]['timeTo'];
      
        // var_dump($shift );
        if($timefrom1 < $timefrom) {
                if($timeto>$currentTime){
                   echo $button = '<div data-toggle="tooltip" title="Check In" class="checkin"> <a class="topnav_icons" onclick="window.location.href=\'checkinout?type=checkin&shift='."1".'\'"><span class="material-symbols-outlined"> login </span></a></div>';
                //   echo 1;
                }else{
                        echo $button = '<a onclick="window.location.href=\'checkinout?type=checkin&shift='."2".'\'">Check In</a>';
                    //   echo 2;
                }
        }else{
             echo $button = '<a onclick="window.location.href=\'checkinout?type=checkin&shift='."2".'\'">Check In</a>';
            //  echo 3;
        }
    
       
        
    }else{
        if(!empty($data5)){
        echo $button = '<a onclick="window.location.href=\'checkinout?type=checkin&shift='.$data[0]['shift'].'\'">Check In</a>';}
        // echo 4;
    }
}

if (empty($data2) || $data2['timeFrom'] == "00:00" && $data2['checkin'] == "") {
$txt = 'Do you Wish to Check-in Without Rota';
$txt = "'" . $txt . "'";
echo $button = '<div data-toggle="tooltip" title="Check In" class="checkin"> <a class="topnav_icons" onclick="secure_delete333(' . $txt . '); "><span class="material-symbols-outlined"> login </span></a></div>';
}

    if (!empty($data3) && empty($data4)) {

echo $button = '<a class="topnav_icons" class="" onclick="mycheckout()"><span class="material-symbols-outlined">Check In</span></a> 
<script>
function mycheckout() {
alert("You Have Checked Out Already");
}
</script>';
}
}
public function CheckOutBtn()
{
$user = $_SESSION['webUser']['id'];
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkin`!='' AND `userId`='$user'";
$data = $this->dbF->getRow($sql);
if ($data) {
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkout`!='' AND `userId`='$user'";
$data = $this->dbF->getRow($sql);

$sql1 = "SELECT * FROM `lunchtimeInOut` WHERE `dateTime` = date(NOW()) AND `lunch_in`!='' AND lunch_out = '' AND `user`='$user'";
$data1 = $this->dbF->getRow($sql1);
if (empty($data)) {
echo '<div data-toggle="tooltip" title="Check Out" class="checkin"> <a class="topnav_icons" onclick="window.location.href=\'checkinout?type=checkout\'"><span class="material-symbols-outlined"> logout </span></a></div>';
if (empty($data1)) {
$txt = 'You want to  Go For Lunch';
$txt = "'" . $txt . "'";
echo $button = '<div data-toggle="tooltip" title="Lunch Time"  class="checkin"><a class="topnav_icons lunch_icn " onclick="Lunch_Time(' . $txt . '); "><span class="material-symbols-outlined"> restaurant </span></a></div>';
} else {
$txt = 'Back To Work';
$txt = "'" . $txt . "'";
echo $button = '<div data-toggle="tooltip" title="Lunch Time-Out" class="checkin"><a  class="topnav_icons lunch_icn " onclick="Lunch_TimeOut(' . $txt . '); "><span class="material-symbols-outlined"> timelapse </span></a></div>';
}
}
}
}

public function CheckOutBtnm()
{
$user = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkin`!='' AND checkout = '' AND `userId`= ? ";
$data = $this->dbF->getRow($sql, array($user));
$shift=$data['shift'];
// var_dump($shift);
$count = $this->dbF->rowCount;
if ($data) {
$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND `checkout`!='' AND `userId`= ?  AND `shift`= ? ";
$data = $this->dbF->getRow($sql, array($user, $shift));
$count1 = $this->dbF->rowCount;

$sql1 = "SELECT * FROM `lunchtimeInOut` WHERE `dateTime` = date(NOW()) AND `lunch_in`!='' AND lunch_out = '' AND `user`= ? ";
$data1 = $this->dbF->getRow($sql1, array($user));
    $count2 = $this->dbF->rowCount;
if (empty($data)) {
    if(empty($data1)){
    echo '<button  onclick="window.location.href=\'checkinout?type=checkout&shift='.$shift.'\'">Check Out</button>';}
if (empty($data1)) {
$txt = 'You want to  Go For Lunch';
$txt = "'" . $txt . "'";
echo $button = '<button onclick="Lunch_Time(' . $txt . '); ">Lunch Time in </button>';
} else {
$txt = 'Back To Work';
$txt = "'" . $txt . "'";
echo $button = '<button onclick="Lunch_TimeOut(' . $txt . '); ">Lunch Time Out </button>';
}
}
}
}

public function branchWagesResult()
{
$branchId   = 0;
$from       = date('Y-m-d', strtotime($_GET['from']));
$to         = date('Y-m-d', strtotime($_GET['to']));
$user       = intval($_SESSION['currentUser']);

$sql        = "SELECT SUM(hour) as cnt,SUM(hourWorked) as cnthourWorked,userId,branch,
    (SELECT acc_name FROM accounts_user as b WHERE b.acc_id=a.userId) as user,
    (SELECT acc_image FROM accounts_user as b WHERE b.acc_id=a.userId) as image
     FROM record as a WHERE branch = ?  AND a.date BETWEEN  ? AND  ? AND  (`a`.`userId` = ?  OR `a`.`userId` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?   AND `setting_name`='account_under')) GROUP BY userId";
$data = $this->dbF->getRows($sql, array( $branchId , $from, $to, $user, $user));

echo '<div class="rota-table">
<table>
<thead>
    <th>Sno</th>
    <th>Staff Name</th>
    <th class="text-center">Wages Rate</th>
    <th class="text-center">Total Hours</th>
    <th class="text-center">Total Hours Worked</th>
    <th class="text-center">Total Cost</th>
</thead>
<tbody>';
$i  = 0;
foreach ($data as $val) {
$i++;
$userId     = intval($val['userId']);
$bId        = $val['branch'];
$name       = $val['user'];
$image       = $val['image'];
if($image =='#' || $image ==''){
$image       = 'profile.png';
}else{

}
$hourscnthourWorked      = floatval($val['cnthourWorked']);
$hourscnthourWorked      = number_format($hourscnthourWorked, 2);


$hours      = floatval($val['cnt']);
$hours      = number_format($hours, 2);

$sql        = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $this->dbF->getRows($sql, array( $userId));
$rate       = floatval($this->webUserInfoArray($userInfo, 'salary'));

// $cost       = $rate * $hours;
$cost       = $rate * $hourscnthourWorked;
$cost       = number_format($cost, 2);
echo "<tr>
<th>$i</th>
<th><span><img src='images/$image'>$name</span></th>
<td>$rate</td>
<td id='age'  data-toggle='tooltip'  title= '".$this->decimal_to_time($hours)."'>$hours</td>
<td data-toggle='tooltip'  title= '".$this->decimal_to_time($hourscnthourWorked)."'>$hourscnthourWorked</td>
<td>$cost</td>
</tr>";
}

echo '</tbody>
</table>
</div>';
}

public function staffWagesResult()
{
$staffId = intval($_GET['user']);
$from    = date('Y-m-d', strtotime($_GET['from']));
$to      = date('Y-m-d', strtotime($_GET['to']));

$sql        = "SELECT *,
    (SELECT `acc_name` FROM `accounts_user` as `b` WHERE `b`.`acc_id`=`a`.`userId`) as `user`,
    (SELECT `acc_image` FROM `accounts_user` as `b` WHERE `b`.`acc_id`=`a`.`userId`) as `image`
     FROM `record` as `a` WHERE userId = ?   AND `a`.`date` BETWEEN  ?  AND ? ORDER BY `date`,`shift`";
$data       = $this->dbF->getRows($sql , array( $staffId, $from, $to));

$sql    = "SELECT setting_val FROM accounts_user_detail WHERE  setting_name='branch' AND id_user = ? ";
$bran   = $this->dbF->getRow($sql,array($staffId));
@$branch = $bran['setting_val'];
@$branch = unserialize($branch);
@$branch = $branch[0];

echo  "<div class='rota-table updateTable'>
<table>
<thead>
    <th>Sno</th>
    <th>Staff Name</th>
    <th class='text-center'>Date</th>
    <th class='text-center'>Shift</th>
    <th class='text-center' style='display:none;'>Rota</th>
    <th class='text-center' style='display:none;'>Rota Comment</th>
    <th class='text-center' style='display:none;'>Total Hours</th>
    <th class='text-center'>Checkin/out</th>
    <th class='text-center'>Lunch in/out</th>
    <th class='text-center'>User Comment</th>
    <th class='text-center'>Hours Worked</th>
    
</thead>
<tbody>";
///<th class='text-center'>Wages Rate</th>
//<th class='text-center'>Total Cost</th>
$i = 0;
$totalHour = 0;
$totalwHour = 0;
$totalCost = 0;
$rate = 0;
foreach ($data as $val) {
$i++;
$checkout = '';
$userId     = intval($val['userId']);
$bId        = $val['branch'];
$name       = $val['user'];
$shift       = $val['shift']."-".$val['rshiftname'];
$image      = $val['image'];
$idForFunc      = $val['id'];
$rotaComment = $val['rotaComment'];
$comment    = $val['comment'];
$hours      = floatval($val['hour']);
$hours      = round($hours, 2);
if ((empty($val['hourWorked']) || $val['hourWorked'] == '0') && $val['checkin'] != '') {
$time1 = strtotime($val['checkin']);

// $val['timeTo'] must be replaced by $val['checkout']
// $time2 = strtotime($val['timeTo']);
$time2 = strtotime($val['checkout']);

// if $val['breakTime'] is less than 0 then it must replaced by 0
if($val['breakTime']<1){
    $val['breakTime'] = 0;
}

// $val['breakTime'] is greater then 0 then lunch time must be 0
// $breaktime = date("G", strtotime($val['breakTime'])) * 60 * 60 + date("i", strtotime($val['breakTime'])) * 60;
if($val['breakTime'] > 1){
    $breaktime = date("G", strtotime($val['breakTime'])) * 60 * 60 + date("i", strtotime($val['breakTime'])) * 60;
}else{
    $breaktime = 0;
}


$whours = round(abs($time2 - $time1 - $breaktime) / 3600, 2);
} else {
$whours     = floatval($val['hourWorked']);
$whours     = round($whours, 2);
}

$rota       = $val['timeFrom'] . " - " . $val['timeTo'];
if ($val['checkout'] == '' && $val['checkin'] != ''){ $checkout = 'Missing';$whours     ='';}
else {$checkout = $val['checkout'];}
$checkinout = $val['checkin'] . " - " . $checkout;
$sql        = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $this->dbF->getRows($sql,array($userId));
$rate       = floatval($this->webUserInfoArray($userInfo, 'salary'));
$cost       = $rate * $hours;
$cost       = round($cost, 2);
$totalHour += $hours;
$totalwHour += $whours;
$totalCost += $cost;
$todayDate = date('d-M-Y', strtotime($val['date']));
$todayDateBasic = date('Y-m-d', strtotime($val['date']));
$sql1        = "SELECT * FROM lunchtimeInOut WHERE user =  ? and `dateTime` = ? ";
$lunchdata   = $this->dbF->getRows($sql1,array($userId, $todayDateBasic));
// $this->decimal_to_time($hours); // prints 11:11:11
if($image =='#' || $image ==''){
$image       = WEB_URL.'/images/default_profile.jpg';
}else{
    $image       = WEB_URL.'/images/'.$image;
}

 

 if($checkinout ==' - '){
$checkinout       = 'Missing - Edit';
}else{
}
echo "<tr>
<th>$i</th>
<th><span><img src='$image'>$name</span></th>
<td>{$todayDate}</td>
<td>$shift</td>
<td style='display:none;'>$rota</td>
<td style='display:none;'>$rotaComment</td>
<td id='age'  data-toggle='tooltip'  title= '".$this->decimal_to_time($hours)."' style='display:none;'>$hours</td>
<td onclick='editTiming($idForFunc)' style='cursor: pointer'><a href='javascript:;'>$checkinout</a></td>
<td class='tdnobefore'>";
if ($this->dbF->rowCount > 0) {
foreach ($lunchdata as $key => $value) {

echo "<i class='fa fa-info-circle' data-toggle='tooltip' title='$value[lunch_in]::$value[lunch_out]'></i>";

}

echo "<br>Total Break Time:";
echo $val['breakTime'];
}

echo "</td><td>$comment</td>
<td>$whours</td>

</tr>";
//<td>$rate</td>
/// <td>$cost</td>
}

echo "<tr style='display:none;'>
<th colspan='2'>Total Hours</th><th id='age'  data-toggle='tooltip'  title= '".$this->decimal_to_time($totalHour)."'>$totalHour</th>
</tr>
<tr>
<th colspan='2'>Total Worked Hours</th><th id='age'  data-toggle='tooltip'  title= '".$this->decimal_to_time($totalwHour)."'>$totalwHour</th>
</tr>
";

echo '</tbody>
</table>
</div>';
// <tr>
//     <th colspan='2'>Total Rate</th><th>$rate</th>
// </tr>
// <tr>
//     <th colspan='2'>Total Cost</th><th>$totalCost</th>
// </tr>
}

public function leiuInsert($apiPostData="")
{
if (!empty($apiPostData)) {
        $_POST = $apiPostData; 
    }
if (!$this->getFormToken('lieuInsert') && $apiPostData=="") {
return false;
}

if (isset($_POST['submit'])) {
$type   = empty($_POST['type'])      ? ""  : $_POST['type'];
$hours  = empty($_POST['hours'])     ? ""  : $_POST['hours'];
$txtNote  = empty($_POST['txtNote'])     ? ""  : $_POST['txtNote'];
htmlspecialchars($type);
htmlspecialchars($hours);

if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();

$sql  = "INSERT INTO `lieu` (`user`,`type`,`hours`,`txtNote`) VALUES (?,?,?,?)";
$array   = array($user, $type, $hours, $txtNote);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Overtime Request Insert", $this->UserName($user) . " : " . $user, $lastId, $hours);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function rotadeletemultipleSubmit()
{
if (!$this->getFormToken('rotadeletemultiple')) {
return false;
}
if (isset($_POST['submit'])) {
$from = $_POST['from'];
$to = $_POST['to'];
$user = empty($_POST['duser']) ? array() : $_POST['duser'];
htmlspecialchars($from);
htmlspecialchars($to);
$user=intval($user);
//  echo "<pre>";
// print_r($user);
// echo "</pre>";



try {

for ($i = 0; $i < count($user); $i++) {


$from = date('Y-m-d', strtotime($from));
$to = date('Y-m-d', strtotime($to));
$sql = "DELETE FROM record WHERE userId = ? AND (`date` >= ? AND `date` <=  ?)";


$this->dbF->setRow($sql, array($user[$i], $from, $to));
// $lastId = $this->dbF->rowLastId;
}
$this->db->beginTransaction();

if ($this->dbF->rowCount > 0) {
$this->setlog("Delete rota ", $this->UserName($user) . " : " . $user,"", $hours);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function mockInspectionSubmit()
{
if (!$this->getFormToken('mockInspection')) {
return false;
}

if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}



if (isset($_POST)) {

$name_of_practice     = empty($_POST['name_of_practice'])       ? ""  : $_POST['name_of_practice'];

$name_of_practice_manager     = empty($_POST['name_of_practice_manager'])       ? ""  : $_POST['name_of_practice_manager'];

$name_of_complianc_champion     = empty($_POST['name_of_complianc_champion'])       ? ""  : $_POST['name_of_complianc_champion'];

$date_audit     = empty($_POST['date_audit'])       ? ""  : $_POST['date_audit'];
$location     = empty($_POST['location'])       ? ""  : $_POST['location'];
$practice_contact     = empty($_POST['practice_contact'])       ? ""  : $_POST['practice_contact'];
$email     = empty($_POST['email'])       ? ""  : $_POST['email'];
$detail     = empty($_POST['detail'])       ? ""  : $_POST['detail'];

$safes_finding     = empty($_POST['safes_finding'])       ? ""  : $_POST['safes_finding'];
$effective_finding     = empty($_POST['effective_finding'])       ? ""  : $_POST['effective_finding'];
$responsive_finding     = empty($_POST['responsive_finding'])       ? ""  : $_POST['responsive_finding'];
$wellled_finding     = empty($_POST['wellled_finding'])       ? ""  : $_POST['wellled_finding'];
$caring_finding     = empty($_POST['caring_finding'])       ? ""  : $_POST['caring_finding'];

$safes_core     = empty($_POST['safes_core'])       ? ""  : $_POST['safes_core'];
$effective_score     = empty($_POST['effective_score'])       ? ""  : $_POST['effective_score'];
$wellled_score     = empty($_POST['wellled_score'])       ? ""  : $_POST['wellled_score'];
$caring_score     = empty($_POST['caring_score'])       ? ""  : $_POST['caring_score'];
$responsive_score     = empty($_POST['responsive_score'])       ? ""  : $_POST['responsive_score'];
$allHTML     = empty($_POST['allHTML'])       ? ""  : $_POST['allHTML'];

// htmlspecialchars($name_of_practice);
// htmlspecialchars($name_of_practice_manager);
// htmlspecialchars($name_of_complianc_champion);
// htmlspecialchars($date_audit);
// htmlspecialchars($location);
// htmlspecialchars($practice_contact);
// htmlspecialchars($email);
// htmlspecialchars($detail);
// htmlspecialchars($safes_finding);
// htmlspecialchars($effective_finding);
// htmlspecialchars($responsive_finding);
// htmlspecialchars($wellled_finding);
// htmlspecialchars($caring_finding);
// htmlspecialchars($safes_core);
// htmlspecialchars($effective_score);
// htmlspecialchars($wellled_score);
// htmlspecialchars($caring_score);
// htmlspecialchars($responsive_score);



try {
$this->db->beginTransaction();

$sql  = "INSERT INTO `mock_inspection_report`(
`name_of_practice`,
`name_of_practice_manager`,
`name_of_complianc_champion`,
`date_audit`,
`location`,
`practice_contact`,
`email`,
`detail`,
`all_html`,
`are_services_safe_score`,
`are_services_safe_finding`,
`are_services_effective_score`,
`are_services_effective_finding`,
`are_services_wellled_score`,
`are_services_wellled_finding`,
`are_services_responsive_score`,
`are_services_responsive_finding`,
`are_services_caring_score`,
`are_services_caring_finding`)

VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array(
$name_of_practice,
$name_of_practice_manager,
$name_of_complianc_champion,
$date_audit,
$location,
$practice_contact,
$email,
$detail,
$allHTML,
$safes_core,
$safes_finding,
$effective_score,
$effective_finding,
$wellled_finding,
$wellled_score,
$responsive_score,
$responsive_finding,
$caring_score,
$caring_finding
);
$status = serialize($array);
$this->dbF->setRow($sql, $array);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("mock_inspection_report is inserted", $this->UserName($user) . " : " . $user,$lastId, $status);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function updateTimeINOUT($apiPostData="")
{
if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['id']) && isset($_POST['checkin']) && isset($_POST['checkout'])) {
$id     = empty($_POST['id'])       ? ""  : $_POST['id'];
$checkin   = empty($_POST['checkin'])     ? ""  : $_POST['checkin'];
$checkout  = empty($_POST['checkout'])    ? ""  : $_POST['checkout'];
$breakTime  = empty($_POST['breakTime'])    ? ""  : $_POST['breakTime'];
$comment = empty($_POST['comment'])   ? ""  : $_POST['comment'];
if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}
$time1 = strtotime($checkin);
$time2 = strtotime($checkout);
// $final = $time2-strtotime($breakTime);
$breaktime = date("G", strtotime($breakTime)) * 60 * 60 + date("i", strtotime($breakTime)) * 60;
$hourWorked = round(abs($time2 - $time1 - $breaktime) / 3600, 2);
try {
$this->db->beginTransaction();
$sql  = "UPDATE `record` SET `hourWorked`=?,`checkin`=?,`checkout`=?,`comment`=? WHERE `id`=?";
$array   = array($hourWorked, $checkin, $checkout, $comment,$id);
$status = serialize($array);
// var_dump($array);
// die;
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Checkin/out is Updated", $this->UserName($user) . " : " . $user,$id, $status);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function leiuUpdate($apiPostData="")
{
if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['edit'])) {
if (!$this->getFormToken('lieuUpdate') && $apiPostData=="") {
return false;
}
$id     = empty($_POST['id'])       ? ""  : $_POST['id'];
$type   = empty($_POST['type'])     ? ""  : $_POST['type'];
$hours  = empty($_POST['hours'])    ? ""  : $_POST['hours'];
$txtNote  = empty($_POST['txtNote'])    ? ""  : $_POST['txtNote'];
$status = empty($_POST['status'])   ? "Pending"  : $_POST['status'];
$id=intval($id);
htmlspecialchars($type);
htmlspecialchars($hours);
htmlspecialchars($status);

if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();

$sql  = "UPDATE `lieu` SET `status`=?,`type`=?,`hours`=?,`txtNote`=? WHERE `id`='$id'";
$array   = array($status, $type, $hours, $txtNote);
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Overtime Request Update", $this->UserName($user) . " : " . $user,"", $status);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

// rota

// CPD
public function InitialCPDedit($apiPostData="")
{
     if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['cpdId'])) {
$sum = '';
@$cpdcId =  $_POST['cpdId'];
$cpds = empty($_POST['cpds']) ? array() : $_POST['cpds'];
foreach ($cpds as $key => $value) {
// echo $key;
// echo "<br>";
// echo $value;
// echo "<br>";
$row1 = "SELECT $key FROM `initialCPD` WHERE `id` = ?";
$rowData =  $this->dbF->getRow($row1,array($cpdcId));
if (!empty($rowData)) {


$sum = ($value + $rowData[$key]);
//echo $sum;
$row2 = "UPDATE `initialCPD` SET $key = '$sum'  WHERE `id` =  ? ";
$this->dbF->setRow($row2 ,array($cpdcId) );
return true;
}
}
}
}










public function editStockLocation($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//
}
if (isset($_POST['locationPK'])) {







$row2 = "UPDATE `product_inventory` SET `location` = ?  WHERE `qty_pk` = ? ";
$this->dbF->setRow($row2, array($_POST['location'], $_POST['locationPK']));

return true;

}
}

public function addDeductQty($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//
}
if (isset($_POST['qty_itemPK'])) {







$row2 = "UPDATE `product_inventory` SET `qty_item` = ?  WHERE `qty_pk` = ? ";
$this->dbF->setRow($row2, array($_POST['qty_item'], $_POST['qty_itemPK']));

return true;

}
}



public function editmin_stockPK($apiPostData="")
{
  if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}  
if (isset($_POST['min_stockPK'])) {







$row2 = "UPDATE `product_inventory` SET `min_stock` = ?  WHERE `qty_pk` = ? ";
$this->dbF->setRow($row2, array($_POST['min_stock'], $_POST['min_stockPK']));

return true;

}
}

public function editexpiryDate($apiPostData="")
{
     if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['expiryDatePK']) ) {
$row2 = "UPDATE `product_inventory` SET `expiryDate` = ?  WHERE `qty_pk` = ? ";
$this->dbF->setRow($row2, array($_POST['expiryDate'], $_POST['expiryDatePK']));

return true;

}
}







public function InitialCPD($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {
if (!$this->getFormToken('initial-cpd') && $apiPostData=="") {
return false;
}
$cycle              = empty($_POST['cycle'])                ? ""             : $_POST['cycle'];
$start_date         = empty($_POST['start_date'])           ? date('Y-m-d')  : $_POST['start_date'];
$decontaimatnion    = empty($_POST['decontaimatnion'])      ? "0"  : $_POST['decontaimatnion'];
$medical_emegerncy  = empty($_POST['medical_emegerncy'])    ? "0"  : $_POST['medical_emegerncy'];
$radiation          = empty($_POST['radiation'])            ? "0"  : $_POST['radiation'];
$complaint_handling = empty($_POST['complaint_handling'])   ? "0"  : $_POST['complaint_handling'];
$data_protection    = empty($_POST['data_protection'])      ? "0"  : $_POST['data_protection'];
$fire_safety        = empty($_POST['fire_safety'])          ? "0"  : $_POST['fire_safety'];
$health_safety      = empty($_POST['health_safety'])        ? "0"  : $_POST['health_safety'];
$level_1            = empty($_POST['level_1'])              ? "0"  : $_POST['level_1'];
$level_2            = empty($_POST['level_2'])              ? "0"  : $_POST['level_2'];
$level_3            = empty($_POST['level_3'])              ? "0"  : $_POST['level_3'];
$oral_cancer        = empty($_POST['oral_cancer'])          ? "0"  : $_POST['oral_cancer'];
$first_aid          = empty($_POST['first_aid'])            ? "0"  : $_POST['first_aid'];
$any_courses        = empty($_POST['any_courses'])          ? "0"  : $_POST['any_courses'];
$user               = $_SESSION['webUser']['id'];

htmlspecialchars($cycle);
htmlspecialchars($start_date);
htmlspecialchars($decontaimatnion);
htmlspecialchars($medical_emegerncy);
htmlspecialchars($radiation);
htmlspecialchars($complaint_handling);
htmlspecialchars($data_protection);
htmlspecialchars($fire_safety);
htmlspecialchars($health_safety);
htmlspecialchars($level_1);
htmlspecialchars($level_2);
htmlspecialchars($level_3);
htmlspecialchars($oral_cancer);
htmlspecialchars($first_aid);
htmlspecialchars($any_courses);
$user=intval($user);

try {
$this->db->beginTransaction();

$this->dbF->setRow("UPDATE `accounts_user_detail` SET `setting_val`= ? WHERE `id_user`= ? AND `setting_name`= ? ", array($start_date, $user, 'cpd_start_date'));

$sql  = "INSERT INTO `initialCPD` (`user`, `cycle`, `start_date`, `decontaimatnion`, `medical_emegerncy`, `radiation`, `complaint_handling`, `data_protection`, `fire_safety`, `health_safety`, `level_1`, `level_2`, `level_3`, `oral_cancer`, `first_aid`, `any_courses`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($user, $cycle, $start_date, $decontaimatnion, $medical_emegerncy, $radiation, $complaint_handling, $data_protection, $fire_safety, $health_safety, $level_1, $level_2, $level_3, $oral_cancer, $first_aid, $any_courses);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Initial CPD Form", $this->UserName($user) . " : " . $user,$lastId, $cycle);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function CPD_PDP($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {
if (!$this->getFormToken('cpd-pdp') && $apiPostData=="") {
return false;
}
$cycle      = empty($_POST['cycle'])        ? ""  : $_POST['cycle'];
$practice   = empty($_POST['practice'])     ? ""  : $_POST['practice'];
$outcome    = empty($_POST['outcome'])      ? ""  : $_POST['outcome'];
$benefit    = empty($_POST['benefit'])      ? ""  : $_POST['benefit'];
$maintenace = empty($_POST['maintenace'])   ? ""  : $_POST['maintenace'];
$activity   = empty($_POST['activity'])     ? ""  : $_POST['activity'];

htmlspecialchars($cycle);
htmlspecialchars($practice);
htmlspecialchars($outcome);
htmlspecialchars($benefit);
htmlspecialchars($maintenace);
htmlspecialchars($activity);

if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();

$sql  = "INSERT INTO `cpd_pdp` (`user`, `cycle`, `practice`, `outcome`, `benefit`, `maintenace`, `activity`) VALUES (?,?,?,?,?,?,?)";
$array   = array($user, $cycle, $practice, $outcome, $benefit, $maintenace, $activity);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("PDP", $this->UserName($user) . " : " . $user,$lastId, $activity);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function requiredHours()
{
if ($_SESSION['currentUserType'] == 'Employee') {
//$user = $_SESSION['webUser']['id'];
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`= ? ";
$data = $this->dbF->getRow($sql,array($user));
if (@$data[0] == 'Dental Nurse') {
$hours = 50;
} else if (@$data[0] == 'Dentist') {
$hours = 150;
} else if (@$data[0] == 'Trainee Nurse') {
$hours = 50;
} else if (@$data[0] == 'Receptionist') {
$hours = 50;
} else if (@$data[0] == 'Dental Hygienist and Dental Therapist') {
$hours = 75;
} else {
$hours = 50;
}
return $hours;
}
public function completedHours()
{
if ($_SESSION['currentUserType'] == 'Employee') {
//$user = $_SESSION['webUser']['id'];
$user = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
}
$datarow = $this->dbF->getRow("SELECT * FROM `initialCPD` WHERE `user` = ? ",array($user));
$start_date =  @$datarow['start_date'];
$start_date =  date("Y", strtotime($start_date));
$fiveYearOld = date("Y", strtotime("-5 years"));


$decontaimatnion =    @$datarow['decontaimatnion'];
$medical_emegerncy =   @$datarow['medical_emegerncy'];
$radiation =           @$datarow['radiation'];
$complaint_handling = @$datarow['complaint_handling'];
$data_protection =    @$datarow['data_protection'];
$fire_safety =         @$datarow['fire_safety'];
$health_safety =        @$datarow['health_safety'];
$level_1 =             @$datarow['level_1'];
$level_2 =              @$datarow['level_2'];
$level_3 =               @$datarow['level_3'];
$oral_cancer =           @$datarow['oral_cancer'];
$any_courses =          @$datarow['any_courses'];

if ($start_date > $fiveYearOld) {

$sum = intval($decontaimatnion) + intval($medical_emegerncy) + intval($medical_emegerncy) + intval($radiation) + intval($complaint_handling) + intval($data_protection) + intval($fire_safety) + intval($health_safety) + intval($level_1) + intval($level_2) + intval($level_3) + intval($oral_cancer) + intval($any_courses);
} else {
$sum = 0;
}

$sql = "SELECT SUM(`minutes`) FROM `assigned_paper` WHERE `assign_user`=  ?  AND `result`='completed' AND `assign_paper` IN (SELECT `paper_id` FROM `paper` WHERE `subject_id` IN (SELECT `subject_id` FROM `subjects` WHERE `under`='0'))";
$sql2 = "SELECT SUM(`minutes`) FROM `assigned_paper` WHERE `assign_user`= ? AND `result`='completed' AND `assign_paper` IN (SELECT `paper_id` FROM `paper` WHERE `subject_id` IN (SELECT `subject_id` FROM `subjects` WHERE `under`!='0'))";
$data = $this->dbF->getRow($sql, array($user));
$data2 = $this->dbF->getRow($sql2, array($user));
$hours = ($data[0] + $data2[0]) / 60;
return round($sum + $hours, 2);
}

public function cpdAllow()
{
if ($_SESSION['currentUserType'] != $_SESSION['webUser']['account_type']) {
$data = $this->dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user= ?  AND setting_name = 'cpd_certificates'",  array(intval($_SESSION['currentUser'])));
if ($data[0] == '1') {
return false;
} else {
return true;
}
} else {
return false;
}
}

// CPD

// product management

/**
* @param $id
* @return string
*/
public function getScaleNameWeb($id)
{
if ($id == '0') {
return "";
}
$sql = "SELECT `prosiz_name` FROM `product_size` WHERE `prosiz_id` =  ? ";
$data = $this->dbF->getRow($sql, array($id));
$name = $data['prosiz_name'];
return $name;
}

public function getProductNameWeb($pid, $slug = false)
{
if ($pid == '0') {
return "";
}



 $sql  = " SELECT `slug`, `prodet_name` FROM `proudct_detail` WHERE `prodet_id` = ? AND product_update = '1' ";
$data = $this->dbF->getRow($sql, array($pid));
if ( $this->dbF->rowCount > 0 ) {
$name = translateFromSerialize($data['prodet_name']);
if ($slug) {
$name = array( 'prodet_name' => $name, 'slug' => $data['slug'] );
}
return $name;
}
return false;
}

/**
* @param $id
* @return string
*/
public function getColorNameWeb($id)
{
if ($id == '0') {
return "";
}
$sql = "SELECT `proclr_name` FROM `product_color` WHERE `propri_id` = ?";
$data = $this->dbF->getRow($sql, array($id));
$name = $data['proclr_name'];
return $name;
}
public function getProductFullNameWeb($pid, $scaleId, $colorId)
{
$pName = $this->getProductNameWeb($pid);
if ($pName == false) {
return false;
}
if ($scaleId != '0') {
$sName = $this->getScaleNameWeb($scaleId);
} else {
$sName = "";
}
if ($colorId != '0') {
$cName = $this->getColorNameWeb($colorId);
// $cName = "<span style='background:#$cName;padding: 5px 12px;color: #fff;font-size: 11px;border-radius: 50px;'>$cName</span>";
// $cName = "$cName";
} else {
$cName = "";
}
$temp = "$pName - $sName - $cName";
$temp = trim($temp, '- ');
return $temp;
}





public function getProductName($id, $field = false)
{

if ($field) {
$column = $field;
} else {
$column = '*';
}

$sql = "SELECT $column FROM `proudct_detail_spb` WHERE `prodet_id` = ?  ";
$res = $this->dbF->getRow($sql, array($id));

return $res;
}

// product management

public function createWebUserAccount($name, $email, $orderId, $settingArray = array(), $cusId='')
{

$aLink = WEB_URL . "/login.php?";
$lastId = "";
$sql = "SELECT * FROM accounts_user WHERE acc_email = ? ";
$accData    = $this->dbF->getRow($sql,array($email));
$already = false;
if ($this->dbF->rowCount > 0) {
$already = true;
$lastId  =   $accData['acc_id'];
} else {
$today  = date("Y-m-d H:i:s");
$unique =   uniqid();
$password  =  $this->encode($unique);
$sql = "INSERT INTO accounts_user SET
acc_name = ?,
acc_email = ?,
acc_cus_id = ?,
acc_pass = ?,
acc_type = '1',
acc_created = '$today'";
$array = array($name, $email,$cusId, $password);

$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;

$sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
$arry       =   array();
foreach ($settingArray as $key => $val) {
$sql .= "('$lastId',?,?) ,";
$arry[] = $key;
$arry[] = $val;
}
$sql = trim($sql, ",");
$this->dbF->setRow($sql, $arry, false);
}

$sql = "UPDATE  `orders` SET
order_user = ?
WHERE order_id = ? ";
$this->dbF->setRow($sql,array($lastId,$orderId), false);

$ThankWeSend = $this->dbF->hardWords('Thank you! We have sent verification email. Please check your email.', false);
if (!$already) {
$password = $this->decode($password);
$setPswrdHash = $email . '--' . $password;
$setPswrdHash = base64_encode($setPswrdHash);
$mailArray['link']        =   $aLink . 'set=' . $setPswrdHash;
$mailArray['password']     =   $password;
$mailArray['pin']     =   '000000';
$this->send_mail($email, '', '', 'accountCreateOnOrder', $name, $mailArray);
return $msg = $ThankWeSend;
}
}

public function orderStartWith(){
            $grn = $this->ibms_setting('orderStartWith');
            $sql="SELECT id FROM `stockOrder` ORDER BY id DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= @$data[0];
        $numb = preg_replace('/\D/', '', $numb);
        @$numb = (int)$numb + 1;
        if(@$data[0] === null){
        return "$grn"."1";
        }
        else{
        return "$grn".$numb;   
        }
    }



public function GRN(){
            $grn = $this->ibms_setting('GRN');
            $sql="SELECT grn FROM `purchase_receipt` ORDER BY receipt_pk DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= isset($data[0]) ? $data[0] : 0;
        $numb = preg_replace('/\D/', '', $numb);
        @$numb = $numb + 1;
        if($data[0] == 0){
        return "$grn"."1";
        }
        else{
        return "$grn".$numb;   
        }
    }





public function receiptAdd($apiPostData=""){
global $_e;

if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}

if(!$this->getFormToken('purchaseReceiptAdd') && $apiPostData==""){
return false;
}



if(isset($_POST['purchaseReceiptEditHidden'])){


$userId =  $_SESSION['webUser']['id'];
if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){

    $lastId= base64_decode($_POST['purchaseReceiptEditHidden']);

 $userIdNAME =    $this->UserName($userId);

$receipt_receiver =  empty($_POST['receipt_receiver']) ?  $userIdNAME : $_POST['receipt_receiver'];

if (isset($_SESSION['practiceUser'])) {
$store =    intval($_SESSION['practiceUser']);
} else {
$store = intval($_SESSION['currentUser']);
}
$sql = "UPDATE  `purchase_receipt` SET `receipt_date`= ? ,`po_number` = ? , `receiver` = ? , `vendor` = ?, `store` = ?, `note` = ?, `Publish` = ?, `submitBy`  = ? WHERE `receipt_pk` = ?";


$arryqwe= array($_POST['receipt_date'],$_POST['receipt_grn'],$receipt_receiver,$_POST['receipt_supplier'],$store,$_POST['receipt_note'],"1", $userId,$lastId);
$this->dbF->setRow($sql,$arryqwe);

$items = array();

$sqlvariabledata  = "SELECT * FROM `purchase_receipt_pro` WHERE `receipt_id`=?";
$variabledata =  $this->dbF->getRows($sqlvariabledata,array($lastId));
foreach ($variabledata as $key => $xVal) {

 $items[] = $xVal['receipt_hash'].":".$xVal['receipt_qty'].":".$xVal['store'];

}

$sqlvv = "DELETE FROM `purchase_receipt_pro` WHERE receipt_id= ?";
$this->dbF->setRow($sqlvv,array($lastId));




$i=0;
foreach($_POST['cart_list'] as $itemId){
$id=$itemId;
$i++;
$temp="pid_".$id;
$pid=abs($_POST[$temp]);
$temp="pscale_".$id;
@$pscale=abs($_POST[$temp]);
$temp="pcode_".$id."_pd";


// var_dump($_POST[$temp]);

$pcode =  empty($_POST[$temp]) ?  array() : $_POST[$temp] ;
for ($i=0; $i < count($pcode) ; $i++) {$sku_pcode = implode(',',$pcode);
}
$temp="pcolor_".$id;
@$pcolor=abs($_POST[$temp]);
$temp="pqty_".$id;
@$pqty=abs($_POST[$temp]);
$temp="pprice_".$id;
@$pprice=abs($_POST[$temp]);
$temp="pLocation_".$id;
@$pLocation=($_POST[$temp]);
$temp="pExpiry_".$id;
@$pExpiry=$_POST[$temp];
$temp="minStock_".$id;
@$minStock=abs($_POST[$temp]);
@$hashVal=$pid.":".$pscale.":".$pcolor.":".$store;
$hash = md5($hashVal);
$qry_order="INSERT INTO `purchase_receipt_pro`(
`receipt_id`,
`receipt_product_id`,
`receipt_product_scale`,
`receipt_product_color`,
`receipt_price`,
`receipt_qty`,
`receipt_hash`,
`p_code`,
`submitBy`,
`store`
) VALUES (?,?,?,?,?,?,?,?,?,?)";
$arry=array($lastId,$pid,$pscale,$pcolor,$pprice,$pqty,$hash,$sku_pcode,$userId,$store);
$this->dbF->setRow($qry_order,$arry);



// $this->dbF->prnt($items);


for ($i=0; $i <count($items) ; $i++) { 

$addQy= $items[$i];

$a = explode(":", $addQy);

$hH= $a[0];
$qQ= $a[1];
$sS= $a[2];

if($hash == $hH && $store == $sS){


$addQTY= $pqty - $qQ;



$sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? and qty_store_id = ?";
$this->dbF->getRow($sqlCheck,array($hash,$store));
if($this->dbF->rowCount>0){
$date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10

// $orderId = "\n".$pLocation;

// $info = ", `location` = CONCAT(location,'$orderId')";



$sql= "UPDATE `product_inventory` SET `qty_item` = qty_item+$addQTY , `updateTime` = ?, `location` = ?, `min_stock` = ?, `expiryDate` = ? WHERE `product_store_hash` = ? and `qty_store_id` = ?";
$this->dbF->setRow($sql,array($date,$pLocation,$minStock,$pExpiry,$hash,$store));

// echo "string";

}else{



$sqlmin_stock = "SELECT `setting_val` FROM `product_setting` WHERE `setting_name` = 'min_stock' and `p_id` = ? ";
$min_stock =  $this->dbF->getRow($sqlmin_stock, array($pid));
$q = $minStock;
if(!empty($min_stock['setting_val']) && empty($minStock)){
$q = $min_stock['setting_val'];
}
$sql = "INSERT INTO `product_inventory`(
`qty_store_id`,
`qty_product_id`,
`qty_product_scale`,
`qty_product_color`,
`qty_item`,
`min_stock`,`location`,`expiryDate`,
`product_store_hash`
) VALUES (?,?,?,?,?,?,?,?,?) ";
$arry=array($store,$pid,$pscale,$pcolor,$pqty,$q,$pLocation,$pExpiry,$hash);
// var_dump($arry);
// die;
$this->dbF->setRow($sql,$arry);
}


}


}







for ($i2=0; $i2 < count($pcode) ; $i2++) { 
$ppid= $pid;
$mysqli1 = "SELECT * FROM  `product_inventory_detail` WHERE  `p_code` = ? AND `qty_product_id` = ?";
$this->dbF->getRow($mysqli1, array($pcode[$i2], $ppid));
if($this->dbF->rowCount>0)
{  
} 
else
{
$sql = "SELECT `p_status` FROM `proudct_detail` WHERE `prodet_id` = ? ";
$pidSelect =  $this->dbF->getRow($sql, array($pid));
if ($pidSelect['p_status'] == 1 ) {
# code...
$detail_Store = $store;
$detail_pid = $pid;
$detail_pscale = $pscale;
$detail_color = $pcolor;
$detail_hash = $hash;
$detail_pcode = $pcode[$i2];
$location_p123= "";
$sql = "INSERT INTO `product_inventory_detail`(
`qty_store_id`,
`qty_product_id`,
`qty_product_scale`,
`qty_product_color`,
`location`,
`product_store_hash`,
`p_code`,
`submitBy`,
`receipt_FK` 
) VALUES (?,'$detail_pid',?,?,?,?,?,?,?) ";
$arry=array($detail_Store,$detail_pscale,$detail_color,$location_p123,$detail_hash,$detail_pcode,$userId,$lastId);
$this->dbF->setRow($sql,$arry);
}
}
} 



} // foreach


$desc= _replace('{{n}}',$i,"Product Quantity Add in {{n}} different products");
if($this->dbF->rowCount>0){
if(!empty($apiPostData)){
    return $returnData = [
        'success' => 1,
        'status' =>201,
        'message' => $desc,
        ];
}else{
    return $desc;
}
}else{
    return false;
}
} // if end




}else{


    $userId =  $_SESSION['webUser']['id'];
if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){

 $userIdNAME =    $this->UserName($userId);



$receipt_receiver =  empty($_POST['receipt_receiver']) ?  $userIdNAME : $_POST['receipt_receiver'];
if (isset($_SESSION['practiceUser'])) {
$store =    intval($_SESSION['practiceUser']);
} else {
$store = intval($_SESSION['currentUser']);
}

$sql="INSERT INTO `purchase_receipt`(`receipt_date`,`grn`, `prf`, `po_number`,`receiver`,`vendor`, `store`,`note`,`Publish`,`submitBy`) VALUES (?,?,?,?,?,?,?,?,?,?)";
$arry= array($_POST['receipt_date'],$this->GRN(),$_POST['receipt_prf'],$_POST['receipt_ponumber'],$receipt_receiver,$_POST['receipt_supplier'],$store,$_POST['receipt_note'],"1", $userId);
$this->dbF->setRow($sql,$arry);
$lastId= $this->dbF->rowLastId;
$i=0;
foreach($_POST['cart_list'] as $itemId){
$id=$itemId;
$i++;
$temp="pid_".$id;
$pid=abs($_POST[$temp]);
$temp="pscale_".$id;
@$pscale=$_POST[$temp];
$temp="pcode_".$id."_pd";
$pcode =  empty($_POST[$temp]) ?  array() : $_POST[$temp] ;
for ($i=0; $i < count($pcode) ; $i++) { 
$sku_pcode = implode(',',$pcode);
}
$temp="pcolor_".$id;
@$pcolor=$_POST[$temp];
$temp="pqty_".$id;
@$pqty=abs($_POST[$temp]);
$temp="pprice_".$id;
@$pprice=abs($_POST[$temp]);
$temp="pLocation_".$id;
@$pLocation=$_POST[$temp];
$temp="pExpiry_".$id;
@$pExpiry=($_POST[$temp]);
$temp="minStock_".$id;
@$minStock=abs($_POST[$temp]);
@$hashVal=$pid.":".$pscale.":".$pcolor.":".$store;
$hash = md5($hashVal);
$qry_order="INSERT INTO `purchase_receipt_pro`(
`receipt_id`,
`receipt_product_id`,
`receipt_product_scale`,
`receipt_product_color`,
`receipt_price`,
`receipt_qty`,
`receipt_hash`,
`p_code`,
`submitBy`,
`store`
) VALUES (?,?,?,?,?,?,?,?,?,?)";
$arry=array($lastId,$pid,$pscale,$pcolor,$pprice,$pqty,$hash,$sku_pcode,$userId,$store);
$this->dbF->setRow($qry_order,$arry);
$sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? and qty_store_id = ?";
$this->dbF->getRow($sqlCheck,array($hash, $store));
if($this->dbF->rowCount>0){
$date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10


// $orderId = "\n".$pLocation;

// $info = ", `location` = CONCAT(location,'$orderId')";


$sql= "UPDATE `product_inventory` SET 
`qty_item` = `qty_item`+$pqty, 
`updateTime` = ?,
`location` = ?,
`min_stock` = ?,
`expiryDate` = ?
WHERE `product_store_hash` = ? AND `qty_store_id` = ?";
$this->dbF->setRow($sql,array($date,$pLocation,$minStock,$pExpiry,$hash,$store));

// echo "string123";
//  $sql= "UPDATE `product_inventory` SET `qty_item` = qty_item+$pqty , `updateTime` = '$date' $info WHERE `product_store_hash` = '$hash' and `qty_store_id` = '$store'";
// $this->dbF->setRow($sql);






}else{
$sqlmin_stock = "SELECT `setting_val` FROM `product_setting` WHERE `setting_name` = 'min_stock' AND `p_id` = ? ";
$min_stock =  $this->dbF->getRow($sqlmin_stock,array($pid));
$q = $minStock;
if(!empty($min_stock['setting_val']) && empty($minStock)){
$q = $min_stock['setting_val'];
}
$sql = "INSERT INTO `product_inventory`(
`qty_store_id`,
`qty_product_id`,
`qty_product_scale`,
`qty_product_color`,
`qty_item`,
`min_stock`,
`location`,
`expiryDate`,
`product_store_hash`
) VALUES (?,?,?,?,?,?,?,?,?) ";
$arry=array($store,$pid,$pscale,$pcolor,$pqty,$q,$pLocation,$pExpiry,$hash);
// var_dump($arry);
// die;
$this->dbF->setRow($sql,$arry);
}
for ($i2=0; $i2 < count($pcode) ; $i2++) { 
$ppid= $pid;
$mysqli1 = "SELECT * FROM  `product_inventory_detail` WHERE  `p_code` = ? AND `qty_product_id` =  ? ";
$this->dbF->getRow($mysqli1,array($pcode[$i2], $ppid));
if($this->dbF->rowCount>0)
{  
} 
else
{
$sql = "SELECT `p_status` FROM `proudct_detail` WHERE `prodet_id` = ? ";
$pidSelect =  $this->dbF->getRow($sql,array($pid));
if ($pidSelect['p_status'] == 1 ) {
# code...
$detail_Store = $store;
$detail_pid = $pid;
$detail_pscale = $pscale;
$detail_color = $pcolor;
$detail_hash = $hash;
$detail_pcode = $pcode[$i2];
$location_p123= "";
$sql = "INSERT INTO `product_inventory_detail`(
`qty_store_id`,
`qty_product_id`,
`qty_product_scale`,
`qty_product_color`,
`location`,
`product_store_hash`,
`p_code`,
`submitBy`,
`receipt_FK` 
) VALUES (?,'$detail_pid',?,?,?,?,?,'$userId','$lastId') ";
$arry=array($detail_Store,$detail_pscale,$detail_color,$location_p123,$detail_hash,$detail_pcode);
$this->dbF->setRow($sql,$arry);
}
}
} 
} // foreach
$desc= _replace('{{n}}',$i,"Product Quantity Add in {{n}} different products");
if($this->dbF->rowCount>0){
if(!empty($apiPostData)){
    return $returnData = [
        'success' => 1,
        'status' =>201,
        'message' => $desc,
        ];
}else{
    return $desc;
}
}else{
    return false;
}
} // if end



}




die;

}




public function addMakeOrder($apiPostData=""){
global $_e;
$returnData=""; 
if (!empty($apiPostData)) {
    $_POST = $apiPostData; 
}
if(!$this->getFormToken('addMakeOrder') && $apiPostData==""){
return false;
}
$userId =  $_SESSION['webUser']['id'];


if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}


if (isset($_POST['receipt_publish'])) {
$receipt_publish =    $_POST['receipt_publish'];
} else {
$receipt_publish = 0;
}



$sql="INSERT INTO `stockOrder`(`oid`,`userId`, `orderdate`, `note`,`submitby`,`status`) VALUES (?,?,?,?,?,?)";
$arry= array($this->orderStartWith(),$user,$_POST['order_date'],$_POST['order_note'],$userId,$receipt_publish);
// $store=$_POST['receipt_store_id'];
$this->dbF->setRow($sql,$arry);
$lastId= $this->dbF->rowLastId;

if (isset($_SESSION['practiceUser'])) {
$store =    intval($_SESSION['practiceUser']);
} else {
$store = intval($_SESSION['currentUser']);
}



         $i=0;

            foreach($_POST['cart_list[]'] as $itemId){

               $id=$itemId;
                $i++;


                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pscale_".$id;
                @$pscale=abs($_POST[$temp]);








                $temp="pcolor_".$id;
                @$pcolor=abs($_POST[$temp]);

                $temp="pqty_".$id;
                @$pqty=abs($_POST[$temp]);




           $temp="allsurgeries_".$id;
                @$allsurgeries=($_POST[$temp]);



                // $temp="pprice_".$id;
                // @$pprice=abs($_POST[$temp]);

                @$hashVal=$pid.":".$pscale.":".$pcolor.":".$store;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `stockOrderDetail`(
                            `fKey`,
                            `pid`,
                            `sid`,
                            `cis`,
                            `surgerie`,
                            `storeid`,
                            `hasH`,
                            `qty`                            

                            ) VALUES (?,?,?,?,?,?,?,?)";
                $arry=array($lastId,$pid,$pscale,$pcolor,$allsurgeries,$store,$hash,$pqty);



                // var_dump($arry);
                // die;
                $this->dbF->setRow($qry_order,$arry);





if ($_POST['receipt_publish'] == '1') {
    # code...

    /////////////////////////////////////
$sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? and qty_store_id = ?";
$this->dbF->getRow($sqlCheck,array($hash, $store));
if($this->dbF->rowCount>0){
$date =date('Y-m-d H:i:s'); //2014-09-24 13:46:10
$qty = 'qty_item-'.$pqty;
$sql= "UPDATE `product_inventory` SET `qty_item` = ? , `updateTime` = ? WHERE `product_store_hash` = ? and `qty_store_id` = ? ";
$arr = array($qty,$date,$hash,$store);
 $this->dbF->setRow($sql,$arr);
}else{
}

}


                  

            } // foreach
            


return $returnData = [
        'success' => 1,
        'status' =>201,
        'message' => "Product Add Successfully",
        ];

}



//my code

// Leave Management
public function countAccepted()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='accepted' AND `fill_user`= ?";
$data = $this->dbF->getRow($sql,array($user));
return $data[0];
} else {
$user = intval($_SESSION['currentUser']);
// $sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='accepted' AND (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user') OR `acc_id`='$user') OR `fill_user` = '$user')";
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='accepted' AND (`user`  = ?  OR `fill_user` = ?  )";
}
$data = $this->dbF->getRow($sql,array($user,$user));
return $data[0];
}

public function countRejected()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='rejected' AND `fill_user`= ? ";
$data = $this->dbF->getRow($sql,array($user));
return $data[0];
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='rejected' AND (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?   AND `setting_name`='account_under') OR `acc_id`= ? ) OR `fill_user` =  ? )";
}
$data = $this->dbF->getRow($sql,array($user, $user, $user));
return $data[0];
}

public function countPending()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE `status`='pending' AND `fill_user`= ? ";
$data = $this->dbF->getRow($sql,array($user));
return $data[0];
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT COUNT(*) FROM `leaves` WHERE (`status`='pending' OR `status` = '') AND ( `fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?   AND `setting_name`='account_under') OR `acc_id`= ? ) OR fill_user =  ?  ) ";
}
$data = $this->dbF->getRow($sql,array($user, $user, $user));
return $data[0];
}

public function countAdded()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT COUNT(*) FROM `record` WHERE `rotaOff`!='' AND `userId` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ? AND `setting_name`='account_under' AND `id_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='Dentist')) AND `date` BETWEEN LAST_DAY(CURRENT_DATE())+ INTERVAL 1 DAY - INTERVAL 1 MONTH AND LAST_DAY(CURRENT_DATE())";
$data = $this->dbF->getRow($sql,array($user));
return $data[0];
}

public function leaveAccepted()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT * FROM `leaves` WHERE `status`='accepted' AND `fill_user`= ? ";
$data = $this->dbF->getRows($sql,array($user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li>
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
    $li .= '<div class="col4_main_left3">
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="edit_btn"><i class="fas fa-edit"></i></a>
</div>';
}
$li .= '</li>';
}
}
return $li;
} else {
$user = intval($_SESSION['currentUser']);
// $sql = "SELECT * FROM `leaves` WHERE `status`='accepted' AND (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user') OR `acc_id`='$user') OR `fill_user` = '$user' )";
$sql = "SELECT * FROM `leaves` WHERE `status`='Accepted' AND (`user`  = ?  OR `fill_user` = ?  )";
}
$data = $this->dbF->getRows($sql,array($user, $user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li>
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
$li .= '<div class="col4_main_left3">
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="edit_btn"><i class="fas fa-edit"></i></a>
</div>';
}
$li .= '</li>';
}
}
return $li;
}

public function leaveRejected()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT * FROM `leaves` WHERE `status`='rejected' AND `fill_user`= ? ";
$data = $this->dbF->getRows($sql,array($user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li class="red">
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
    $li .= '<div class="col4_main_left3">
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="edit_btn"><i class="fas fa-edit"></i></a>
</div>';
}
$li .= '</li>';
}
}
return $li;
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `leaves` WHERE `status`='rejected' AND (`fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?   AND `setting_name`='account_under') OR `acc_id`= ? ) OR `fill_user` = ? )";
}
$data = $this->dbF->getRows($sql,array($user, $user, $user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li class="red">
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
$li .= '<div class="col4_main_left3">
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="edit_btn"><i class="fas fa-edit"></i></a>

 <button data-id="' . $value['id'] . '" onclick="AjaxDelScript(this);" class=" edit_btn secure_delete"  >
                <i class="glyphicon glyphicon-trash trash fa fa-trash" ></i>
                <i class="fa fa-refresh waiting fa-spin fa fa-spinner" style="display: none"></i>
            </button>


</div>';
}
$li .= '</li>';
}
}
return $li;
}

public function leavePending()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT * FROM `leaves` WHERE (`status`='pending' OR `status` = '' ) AND `fill_user`= ? ";
$data = $this->dbF->getRows($sql,array($user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li class="blue">
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
    $li .= '
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="edit_btn"><i class="fas fa-edit"></i></a>
';
}
$li .= '</li>';
}
}
return $li;
} else {
$user =intval($_SESSION['currentUser']);
	$sql = "SELECT * FROM `leaves` WHERE (`status`='pending' OR `status` = '') AND ( `fill_user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?  AND `setting_name`='account_under') OR `acc_id`= ? ) OR fill_user =  ? )";
}
$data = $this->dbF->getRows($sql,array($user,$user,$user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['fill_user']);
$li .= '<li class="blue">
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . ' : ' . $value['type'] . '">
' . $value['title'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['from_date'])) . ' - ' . date("d-M-Y", strtotime($value['to_date'])) . ')</span>
</div><!-- col4_main_left1 close -->';
if ($_SESSION['currentUserType'] != 'Employee' ||  $_SESSION['superUser']['hrrota'] == 'full') {
$li .= '<div class="col4_main_left3">
<a data-toggle="tooltip" title="Edit" onclick="leaves(this.id)" id="' . $value['id'] . '" class="ablue"><i class="fas fa-edit"></i></a>
 <button data-id="' . $value['id'] . '" onclick="AjaxDelScript(this);" class=" edit_btn secure_delete"  >
                <i class="glyphicon glyphicon-trash trash fa fa-trash" ></i>
                <i class="fa fa-refresh waiting fa-spin fa fa-spinner" style="display: none"></i>
            </button>


</div>';
}
$li .= '</li>';
}
}
return $li;
}

public function leaveAdded()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = $_SESSION['superid'];
} else {
$user = intval($_SESSION['currentUser']);
}
$sql = "SELECT * FROM `record` WHERE `rotaOff`!='' AND `userId` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`= ?  AND `setting_name`='account_under' AND `id_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='Dentist')) AND `date` BETWEEN LAST_DAY(CURRENT_DATE())+ INTERVAL 1 DAY - INTERVAL 1 MONTH AND LAST_DAY(CURRENT_DATE())";
$data = $this->dbF->getRows($sql ,array(@$user));
$li = "";
if (!$data) {
$li = "no leave found";
} else {
foreach ($data as $key => $value) {
$name = $this->UserName($value['userId']);
$li .= '<li class="blue">
<div class="col4_main_left1" data-toggle="tooltip" title="' . $name . '">
' . $value['rotaOff'] . '&nbsp;<span>(' . $name . ')</span>
<span>(' . date("d-M-Y", strtotime($value['date'])) . ')</span>
</div><!-- col4_main_left1 close -->
<div class="col4_main_left3">';
$li .= '</li>';
}
}
return $li;
}

public function employeeleaveInsert($apiPostData="")
{

if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (isset($_POST['submit'])) {
if (!$this->getFormToken('employeeleaveInsert') && $apiPostData == "") {
return false;
}
$title  = empty($_POST['title'])     ? ""  : $_POST['title'];
$datef  = empty($_POST['datef'])     ? ""  : date('Y-m-d', strtotime($_POST['datef']));
$datet  = empty($_POST['datet'])     ? ""  : date('Y-m-d', strtotime($_POST['datet']));
$type   = empty($_POST['type'])      ? ""  : $_POST['type'];
$desc   = empty($_POST['comment'])      ? ""  : $_POST['comment'];
$hours  = empty($_POST['hours'])     ? ""  : $_POST['hours'];
$pay    = empty($_POST['pay'])     ? ""  : $_POST['pay'];
$todayDate = date('Y-m-d');
$user = $_SESSION['currentUser'];
$fill_user =   $_POST['fill_user'];

htmlspecialchars($title);
htmlspecialchars($datef);
htmlspecialchars($datet);
htmlspecialchars($type);
htmlspecialchars($desc);
htmlspecialchars($hours);
htmlspecialchars($pay);
htmlspecialchars($todayDate);
$user=intval($user);
$fill_user=intval($fill_user);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$status = empty($_POST['status'])    ? "Pending"  : $_POST['status'];
} else {
$status = empty($_POST['status'])    ? ""  : $_POST['status'];
}




try {
$this->db->beginTransaction();

$sql = "INSERT INTO `leaves`(`title`,`user`,`fill_user`,`from_date`,`to_date`,`hours`,`pay`,`type`,`comment`,`status`,`dateTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($title, $user, $fill_user, $datef, $datet, $hours, $pay, $type, $desc, $status, $todayDate);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
//  $this->notifications('holidayrequest',$user);

if ($this->dbF->rowCount > 0) {
$this->notifications('leavesubmit', $user, $type);
$this->setlog("Leave Add", $this->UserName($fill_user) . " : " . $fill_user, $lastId, $title);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end


}
public function leaveInsert()
{
    // var_dump('leave');
if (isset($_POST['submit'])) {
if (!$this->getFormToken('leave')) {
return false;
}
$title  = empty($_POST['title'])     ? ""  : $_POST['title'];
$datef  = empty($_POST['datef'])     ? ""  : date('Y-m-d', strtotime($_POST['datef']));
$datet  = empty($_POST['datet'])     ? ""  : date('Y-m-d', strtotime($_POST['datet']));
$type   = empty($_POST['type'])      ? ""  : $_POST['type'];
$desc   = empty($_POST['comment'])      ? ""  : $_POST['comment'];
$hours  = empty($_POST['hours'])     ? ""  : $_POST['hours'];
$pay    = empty($_POST['pay'])     ? ""  : $_POST['pay'];

$todayDate = date('Y-m-d');

htmlspecialchars($title);
htmlspecialchars($datef);
htmlspecialchars($datet);
htmlspecialchars($type);
htmlspecialchars($desc);
htmlspecialchars($hours);
htmlspecialchars($pay);
htmlspecialchars($todayDate);

// var_dump($_SESSION['currentUserType'],$_SESSION['superUser']['ccalendar'],$_SESSION['currentUser'], intval($_SESSION['currentUser']));
// exit();
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {
$status = empty($_POST['status'])    ? "Pending"  : $_POST['status'];


$fill_user   = intval($_SESSION['superid']);
$user = intval($_SESSION['currentUser']);
} else {
$status = empty($_POST['status'])    ? ""  : $_POST['status'];
$user = intval($_SESSION['currentUser']);
$fill_user   =  intval($_SESSION['webUser']['id']);
}


try {
$this->db->beginTransaction();

$sql = "INSERT INTO `leaves`(`title`,`user`,`fill_user`,`from_date`,`to_date`,`hours`,`pay`,`type`,`comment`,`status`,`dateTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$array   = array($title, $user, $fill_user, $datef, $datet, $hours, $pay, $type, $desc, $status, $todayDate);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();




//  $this->notifications('holidayrequest',$user);

if ($this->dbF->rowCount > 0) {
$this->notifications('leaveSubmit', $fill_user, $type);
$this->setlog("$type Leave requested by (".$this->UserName($fill_user) . " : " . $fill_user.")", $this->UserName($fill_user) . " : " . $fill_user, $lastId, $title);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function leaveEdit($apiPostData="")
{

if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (isset($_POST['edit'])) {
if (!$this->getFormToken('leave') && $apiPostData == "") {
return false;
}

$id     = empty($_POST['id'])        ? ""  : $_POST['id'];
$title  = empty($_POST['title'])     ? ""  : $_POST['title'];
$datef  = empty($_POST['datef'])     ? ""  : date('Y-m-d', strtotime($_POST['datef']));
$datet  = empty($_POST['datet'])     ? ""  : date('Y-m-d', strtotime($_POST['datet']));
$type   = empty($_POST['type'])      ? ""  : $_POST['type'];
$desc   = empty($_POST['comment'])      ? ""  : $_POST['comment'];
$hours   = empty($_POST['hours'])      ? ""  : $_POST['hours'];
$status = empty($_POST['status'])    ? ""  : $_POST['status'];
$pay = empty($_POST['pay'])    ? ""  : $_POST['pay'];

$id=intval($id);
htmlspecialchars($title);
htmlspecialchars($datef);
htmlspecialchars($datet);
htmlspecialchars($type);
htmlspecialchars($desc);
htmlspecialchars($hours);
htmlspecialchars($status);
htmlspecialchars($pay);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0') {


$user   = intval($_SESSION['superid']);
} else {

$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();

$sql  = "UPDATE `leaves` SET 
            `title` = ?,
            `from_date` = ?,
            `to_date` = ?,
            `type` = ?,
            `hours` = ?,
            `pay` = ?,
            `comment` = ?,
            `status` = ?
    WHERE `id` = '$id'";
$array   = array($title, $datef, $datet, $type, $hours, $pay, $desc, $status);
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
// var_dump($sql, $array, $this->dbF->rowCount);
if ($this->dbF->rowCount > 0) {
$data = $this->dbF->getRow("SELECT `fill_user` FROM `leaves` WHERE `id` =  ? ",array($id));
$filluser =   $data[0];
$user;
if ($status == "Accepted" || $status == "Rejected") {
    if ($status == 'Accepted'  || $status == 'Rejected') {
        $title = $status;
        $this->notifications('uLeaveStatus', $filluser, $status);
    }
    $this->setlog("Leave requested by ". $this->UserName($filluser).":".$filluser." has been ". $status ." by ". $this->UserName($user).":".$user, $this->UserName($user) . " : " . $user, "", $title);
}
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function daysLeaveCalendar()
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT
`title`,'(Leave)',
`from_date` AS `start`, 
 `to_date` AS `end`,
IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,
`type` AS `type`,
 'LEAVES' AS `sqltype`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`
FROM `leaves` WHERE `fill_user`='$user' AND status = 'accepted'";
$sql2 = "SELECT 
  'Holiday' AS `title`,
  `reason` AS `reason`,
   'HOLIDAY' AS `sqltype`,
   `id` AS `id`,
    'leaves(this.id)' as `click`,
  `date` AS `start`
   FROM `isholiday`   where `user` = '$user'";
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT  `a`.`acc_name` AS `n_name`, '\n',
  `title` AS `title`,'(Leave)',
`from_date` AS `start`,
`to_date` AS `end`,
IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,
`type` AS `type`,
`id` AS `id`,
 'LEAVES' AS `sqltype`,
'leaves(this.id)' as `click`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`
FROM `leaves` `l`  JOIN `accounts_user` `a` ON `l`.`fill_user` = `acc_id`
WHERE  `user` IN (SELECT `id_user`FROM `accounts_user_detail` WHERE `setting_val`= ?  AND `setting_name`='account_under')OR `user`= ?  AND `a`.`acc_type` = '1' "; //AND status = 'accepted'

$sql2 = "SELECT 
  'Holiday' AS `title`,
 '#00b58a' AS `color`,
  `reason` AS `reason`,
   'HOLIDAY' AS `sqltype`,
   `id` AS `id`,
  `date` AS `start`
   FROM `isholiday`   where `user` = '$user'";
}
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
// $data3 = $this->dbF->getRows($sql3);
$ddata = array();
foreach ($data as $key => $value) {
$date1 = $value['fdate'];
$date2 = $value['tdate'];
if ($value['fdate'] == $value['tdate']) {
continue;
}

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365 * 60 * 60 * 24));
$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


$j = $days;
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($date2));
$value['end'] = Date('Y-m-d', strtotime($date1));
}

array_push($data, $value);
}
// foreach ($data3 as $key => $value) {

//         $daysss = $value['dayoff'];
//         $offday = explode(",",$daysss);
//          array_push($data3,$offday);

// }
$mysql = array_merge($data, $data2);
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";
}
public function leavesCalendar($isApi = false)
{
if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0') {
$user = intval($_SESSION['superid']);
$sql = "SELECT
`title`,'(Leave)',
`from_date` AS `start`, 
 `to_date` AS `end`,";

if(!$isApi){
$sql .= "IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,";
}

$sql .= " `type` AS `type`,
 'LEAVES' AS `sqltype`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`
FROM `leaves` WHERE `fill_user`='$user' AND status = 'accepted'";
$sql2 = "SELECT 
  'Holiday' AS `title`,
  `reason` AS `reason`,
   'HOLIDAY' AS `sqltype`,
   `id` AS `id`,
    'leaves(this.id)' as `click`,
  `date` AS `start`
   FROM `isholiday`   where `user` = '$user'";
} else {
$user = intval($_SESSION['currentUser']);
$sql = "SELECT  `a`.`acc_name` AS `n_name`, '\n',
  
  CONCAT_WS('', `a`.`acc_name`, '-',

CONCAT('(',`l`.`type`, ')')
) AS `title`, '\n',

`from_date` AS `start`,
`to_date` AS `end`,";

if(!$isApi){
$sql .= "IF(`status` = 'rejected', '#ff0000', if(`status` = 'accepted','#00b58a','#01abbf')) as `color`,";
}

$sql .= " `type` AS `type`,
`id` AS `id`,
 'LEAVES' AS `sqltype`,
'leaves(this.id)' as `click`,
`from_date` AS `fdate`,
`to_date` AS `tdate`,
`status` AS `status`
FROM `leaves` `l`  JOIN `accounts_user` `a` ON `l`.`fill_user` = `acc_id`
WHERE  `user` IN (SELECT `id_user`FROM `accounts_user_detail` WHERE `setting_val`='$user'  AND `setting_name`='account_under')OR `user`='$user' "; //AND status = 'accepted'

$sql2 = "SELECT 
  'Holiday' AS `title`,";

if(!$isApi){
 $sql2 .= " '#00b58a' AS `color`,";
}

 $sql2 .= "`reason` AS `reason`,
   'HOLIDAY' AS `sqltype`,
   `id` AS `id`,
  `date` AS `start`
   FROM `isholiday`   where `user` = '$user'";
}
$data = $this->dbF->getRows($sql);
$data2 = $this->dbF->getRows($sql2);
// $data3 = $this->dbF->getRows($sql3);
$ddata = array();
foreach ($data as $key => $value) {

$date1 = $value['fdate'];
$date2 = $value['tdate'];
if ($value['fdate'] == $value['tdate']) {
continue;
}

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365 * 60 * 60 * 24));
$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


$j = $days;
for ($i = 0; $i < $j; $i++) {
$value['start'] = Date('Y-m-d', strtotime($date2));
$value['end'] = Date('Y-m-d', strtotime($date1));
}

array_push($data, $value);
}
// foreach ($data3 as $key => $value) {

//         $daysss = $value['dayoff'];
//         $offday = explode(",",$daysss);
//          array_push($data3,$offday);

// }
$mysql = array_merge($data, $data2);
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";
}

public function returnWorkGoto()
{
$user = intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `leaves` WHERE `fill_user` = ? AND `type`='Sick' AND `status`='accepted' AND `to_date` < CURDATE() AND `id` NOT IN (SELECT `lid` FROM `returnWork` WHERE `user` =  ? )";
$data = $this->dbF->getRow($sql, array($user, $user));
if (!empty($data)) {
echo "<script>
   var filename = location.pathname.substr(location.pathname.lastIndexOf('/')+1);
  if(filename != 'return-work-form'){window.location.href='return-work-form'}
</script>";
return true;
} else {
return false;
}
}

public function returnWork()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('returnWork')) {
return false;
}
$lid   = empty($_POST['lid'])           ? ""    : $_POST['lid'];
$desc  = empty($_POST['desc'])          ? ""    : $_POST['desc'];
$file  = empty($_FILES['file']['name']) ? false : true;
$user  = $_SESSION['currentUser'];
$c_date   = date('Y-m-d');
$fill_user = $_SESSION['webUser']['id'];

htmlspecialchars($lid);
htmlspecialchars($desc);
htmlspecialchars($user);
htmlspecialchars($c_date);
htmlspecialchars($fill_user);

$docname = '#';

if ($file) {
$docname =  $this->uploadSingleFile($_FILES['file'], 'files', '');




if($docname==false) {
$docname = '#';
}else{
$docname = $docname;
}





} else {
$docname = '#';
}

try {
$this->db->beginTransaction();

$sql1 = "INSERT INTO `userdocuments` (`title`,`sub_dcategory`,`category`, `user`, `file`, `desc`,`completion_date`) VALUES (?,?,?,?,?,?,?)";

$array1   = array($lid, 'Return Work Form', 'Additional Document', $fill_user, $docname, $desc, $c_date);

$this->dbF->setRow($sql1, $array1, false);

$sql = "INSERT INTO `returnWork` (`dsc`,`user`,`lid`,`file`) VALUES (?,?,?,?)";
$array   = array($desc, $fill_user, $lid, $docname);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->notifications('aretunrtowork', $fill_user, 'Return Work Form');
$this->setlog("Return to Work", $this->UserName($user) . " : " . $user, $lastId, $desc);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function amendRota()
{
if (isset($_POST['submit'])) {
if (!$this->getFormToken('amendRota')) {
return false;
}
$id       = empty($_POST['id'])        ? ""  : $_POST['id'];
$details  = empty($_POST['details'])   ? ""  : $_POST['details'];
$user     = $_SESSION['currentUser'];

// $id=intval($id);
// htmlspecialchars($details);
// intval($user);

try {
$this->db->beginTransaction();

$sql  = "UPDATE `rotaStatus` SET `amendments` = ?  WHERE `id` = ?";
$array   = array($details,$id);
$this->dbF->setRow($sql, $array, false);
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Rota Amendments", $this->UserName($user) . " : " . $user, "", $details);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

// Leave Management

private function getFolderFileList($folders)
{
// return 2 times inside files
$files = array();
foreach ($folders as $key => $val) {
$filesTemp = $this->getFolderFiles($val);
if ($filesTemp !== false) {
$files[$val] = $filesTemp;
if ($val != '') {
foreach ($filesTemp as $key2 => $val2) {
    if ($val2 == "js" || $val2 == "css") {
        unset($files[$val][$key2]); //remove array from list
        continue;
    }

    $filesTemp2 = $this->getFolderFiles($val . "/" . $val2);
    if ($filesTemp2 !== false) {
        unset($files[$val][$key2]); //remove array from list
        //check inner folder files and filter
        foreach ($filesTemp2 as $key3 => $val3) {
            if (substr($val3, -4) != ".php") {
                unset($filesTemp2[$key3]); //remove array from list
            }
        }
        $files[$val][$val2] = $filesTemp2;
    } //if file not PHP then remove from array
    elseif (substr($files[$val][$key2], -4) != ".php") {
        unset($files[$val][$key2]); //remove array from list
    }
} //2nd foreach loop end
} //if val != "" end
}
}

if (isset($files[''])) {
foreach ($files[''] as $key3 => $val3) {
if (!is_array($val3)) {
if (substr($val3, -4) != ".php") {
    unset($files[''][$key3]); //remove array from list
}
}
}
}

return $files;
}

private function getFileMd5($fileContent, $replaceSpace = true)
{
if ($replaceSpace) {
$fileContent = str_replace(" ", "", $fileContent);
$fileContent = str_replace("\n", "", $fileContent);
}
$fileContent = md5($fileContent . " Raza@#!");
return $fileContent;
}

private function getMd5OfFiles($files)
{
//Now get MD5 of All files
$md5Files = array();

foreach ($files as $key => $firstFolder) {
foreach ($firstFolder as $key2 => $val) {
if (is_array($val)) {
foreach ($val as $key3 => $val3) {
    if (!is_array($val3)) {
        $fileName       = $key . "/" . $key2 . "/" . $val3;
        $fileContent    = $this->getAdminFile($fileName, false, true);
        $fileContent    = $this->getFileMd5($fileContent);
        $md5Files[$key][$key2][$val3] = $fileContent;
    }
}
} else {
$fileName       = $key . "/" . $val;
$fileContent    = $this->getAdminFile($fileName, false, true);
$fileContent    = $this->getFileMd5($fileContent);
$md5Files[$key][$val] = $fileContent;
}
}
}
return $md5Files;
}

private function checkDeveloperPassword($password = false, $real = true)
{
$mePassword = "imediaRaza@#!";
if ($password == false) {
$password = $this->developer_setting('developerPassword');
}

if ($real) {
if ($password == $mePassword) {
$mePassword = $this->getFileMd5($mePassword);
$this->developer_setting_update('developerPassword', $mePassword);
return true;
}
}
// $password   = $password;
$mePassword = $this->getFileMd5($mePassword);
if ($password == $mePassword) {
return true;
}

return false;
}

public function folderFilesSecurity()
{
$isEditingProject = $this->developer_setting('isProjectEnd');
$projectStatus = $this->developer_setting('developerPassword');
if ($isEditingProject == '1' && $projectStatus != "finish") {
//check password before new md5.. after status complete
$passwordStatus     =  $this->checkDeveloperPassword($projectStatus);
if ($passwordStatus) {
$folders    = $this->getEncryptFolderName();
$files      = $this->getFolderFileList($folders);

$md5Files = $this->getMd5OfFiles($files);
$md5Files = serialize($md5Files);
$this->ibms_setting_update('adminFilesMd5', $md5Files);
$this->developer_setting_update('developerPassword', 'finish');
$this->encryptDeveloperSetting(true);

return true;
} //if end
} // first if end
return false;
}

public function checkCurrentFileMd5($tellActualFile = false)
{
@$md5Files = unserialize($this->ibms_setting('adminFilesMd5'));
$isEditingProject = $this->developer_setting('isProjectEnd');
$projectStatus      =   $this->developer_setting('developerPassword');
//project in edit mode
if ($isEditingProject == '0') {
$passwordStatus     =   $this->checkDeveloperPassword($projectStatus);
if ($passwordStatus) {
//in development mode
return true;
}
} else if ($md5Files != false && $projectStatus == 'finish') {
//if projet is finish then file changing is checking
$folderName     = $this->getLinkFolder();
$AllowFolders   = $this->getEncryptFolderName();
if (in_array($folderName, $AllowFolders)) {
$array = array($folderName);
$files      = $this->getFolderFileList($array);
$newMd5Files = $this->getMd5OfFiles($files); //active folder md5
if ($newMd5Files[$folderName] == $md5Files[$folderName]) {
return true;
} elseif ($tellActualFile) {
$this->findActualFileMd5($newMd5Files[$folderName], $md5Files[$folderName], $folderName);
}
} else {
return true;
}
} else {
if ($this->folderFilesSecurity()) {
return true;
}
}
return false;
}

private function findActualFileMd5($activeFolderMd5, $saveMd5, $folder)
{
/*var_dump($activeFolderMd5);
var_dump($saveMd5)*/;
echo "<h3>Changes Made in these files</h3>";
if ($folder != "") {
$folder = $folder . "/";
}
foreach ($activeFolderMd5 as $key => $val) {
if (is_array($val)) {
foreach ($val as $key2 => $val2) {
if (!is_array($val2)) {
    if ($val2 != $saveMd5[$key][$key2]) {
        echo ADMIN_FOLDER . "/$folder$key/$key2<br>";
    }
}
}
} else {
if ($val != $saveMd5[$key]) {
echo ADMIN_FOLDER . "/$folder$key<br>";
}
}
}
}

public function encryptDeveloperSetting($update = false)
{
//first check is edit mode?
$isEditingProject = $this->developer_setting('isProjectEnd');
if ($isEditingProject == '0') {
return true;
}
$sql = "SELECT setting_val FROM developer_setting ORDER BY id ASC";
$data = $this->dbF->getRows($sql);
$data = serialize($data);
$data = $this->getFileMd5($data);
$dev = $this->ibms_setting('developerSetting');

if ($update) {
$this->ibms_setting_update('developerSetting', $data);
return true;
}
if ($data == $dev) {
return true;
}

return false;
}

public function IbmsLanguages($returnArray = true)
{
$data = $this->ibms_setting('Languages');
if ($data != false) {
$lang = unserialize($data);
if ($returnArray)
return $lang;
else {
if ($lang != false) {
return implode(",", $lang);
}
}
}
return false;
}

public function AdminDefaultLanguage($checkNew = false)
{
//for admin forms data...
if ($checkNew) {
$_SESSION['admin']['lang'] = $this->ibms_setting('Default Language');
return $_SESSION['admin']['lang'];
}
if (isset($_SESSION['admin']['lang'])) {
return $_SESSION['admin']['lang'];
} else {
$_SESSION['admin']['lang'] = $this->ibms_setting('Default Language');
return $_SESSION['admin']['lang'];
}
//return $this->ibms_setting('Default Language');
}

public function unserializeTranslate($serializeData, $lang = false, $serialize = true, $firstKeyIfNotFound = true)
{
$adminLang = $this->AdminDefaultLanguage();

if ($serialize == true) {
@$tempA = unserialize($serializeData);
} else {
@$tempA = $serializeData;
}
//var_dump($tempA);
if ($tempA === false) {
return $serializeData;
}
if ($lang == false) {
@$temp = $tempA[$adminLang];
} else {
@$temp = $tempA[$lang];
}

if ($firstKeyIfNotFound) {
if (($temp === false || empty($temp)) && ($adminLang == 'default')) {
$temp = $tempA[key($tempA)];
}
}

return $temp;
}

public function getAdminPanelLanguage()
{
//for admin text written by developer, like menu, form field names,
$userId = $_SESSION['_uid'];
$sql = "SELECT setting_val from accounts_detail WHERE id_user = ? AND setting_name = ? ";
$data = $this->dbF->getRow($sql,array($userId,'adminLang'));

if ($this->dbF->rowCount > 0) {
return  $data['setting_val'];
} else {
return $this->ibms_setting('Default_Admin_Panel_Language');
}
}

public function AdminPanelLanguage($checkNew = false)
{
if ($checkNew) {
$lang = $this->getAdminPanelLanguage();
$_SESSION['admin']['adminPanelLang'] = $lang;
return $_SESSION['admin']['adminPanelLang'];
}

if (isset($_SESSION['admin']['adminPanelLang'])) {
return $_SESSION['admin']['adminPanelLang'];
} else {
$lang = $this->getAdminPanelLanguage();
$_SESSION['admin']['adminPanelLang'] = $lang;
return $_SESSION['admin']['adminPanelLang'];
}
//return $this->ibms_setting('Default Language');
}

//Make blank client info
public $userData = array(
'acc_id' => '0',
'acc_name' => 'null',
'acc_email' => 'null',
'acc_role' => '0',
'acc_type' => '1'
);
public function WebDefaultLanguage()
{
return $this->ibms_setting('Default Web Language');
}

/**
* @param $settingName
* @return mixed
*/
public function ibms_setting($settingName)
{
if (empty($this->IBMS_setting_array)) {
//save all data in one array so it will stop multi time execute sql query
$this->all_IBMSSetting_data();
}
if (isset($this->IBMS_setting_array[$settingName])) {
return $this->IBMS_setting_array[$settingName];
}

$sql = "SELECT `setting_val` FROM `ibms_setting` WHERE `setting_name` = ?  ";
$data = $this->dbF->getRow($sql,array($settingName));
if ($this->dbF->rowCount > 0) {
return $data[0];
}
return false;
}

/**
* @param $settingName
* @param $val
* @return bool
*/
public function ibms_setting_update($settingName, $val)
{
$sql = "UPDATE `ibms_setting` SET `setting_val` = ? WHERE `setting_name` = ? ";
$this->dbF->setRow($sql, array($val, $settingName));
if ($this->dbF->rowCount > 0) {
return true;
}
return false;
}

private function all_IBMSSetting_data()
{
//save all data in one array so it will stop multi time execute sql query
$sql    = "SELECT setting_name,setting_val FROM `ibms_setting` ";
$data   = $this->dbF->getRows($sql);
$array = array();
foreach ($data as $key => $val) {
$array[$val['setting_name']] = $val['setting_val'];
}
$this->IBMS_setting_array = $array;
}

/**
* @param $settingName
* @return bool
*/
public function developer_setting($settingName)
{
if (empty($this->developer_setting_array)) {
//save all data in one array so it will stop multi time execute sql query
$this->all_developerSetting_data();
}
if (isset($this->developer_setting_array[$settingName])) {
return $this->developer_setting_array[$settingName];
}

$sql = "SELECT `setting_val` FROM `developer_setting` WHERE `setting_name` = ? ";
$data = $this->dbF->getRow($sql, array($settingName));
if ($this->dbF->rowCount > 0) {
return $data[0];
}
return false;
}

private function all_developerSetting_data()
{
//save all data in one array so it will stop multi time execute sql query
if ($this->isAdminLink()) {
$sql    = "SELECT setting_name,setting_val FROM `developer_setting` ";
} else {
//stop extra data on web
$sql = "SELECT setting_name,setting_val FROM `developer_setting` WHERE
  category NOT IN ('banner','graph','blog','news','brand',
            'social','reviews','email','FileManager',
            'order','testimonial') ";
}

$data   = $this->dbF->getRows($sql);
$array = array();
foreach ($data as $key => $val) {
$array[$val['setting_name']] = $val['setting_val'];
}
$this->developer_setting_array = $array;
}

/**
* @param $settingName
* @param $val
* @return bool
*/
public function developer_setting_update($settingName, $val)
{
$sql    = "UPDATE `developer_setting` SET `setting_val` = ? WHERE `setting_name` = ? ";
$data   = $this->dbF->setRow($sql, array($val,$settingName));
if ($this->dbF->rowCount > 0) {
return true;
}
return false;
}

public function setting_fieldsSet($id, $tableName, $beginTransection = true, $setting = 'setting_f')
{
if ($setting == 'setting_f') {
$setting = isset($_POST['setting_f']) ? $_POST['setting_f'] : '';
}

if (!empty($setting)) {
$this->setting_fieldsDelete($id, $tableName, $beginTransection);

$setting    =   empty($_POST['setting_f']) ? array() : $_POST['setting_f'];
$sql        =   "INSERT INTO `setting_fields` (`p_id`,`setting_name`,`setting_val`,`table_name`) VALUES ";
$arry       =   array();
foreach ($setting as $key => $val) {
if (is_array($val)) {
$val = serialize($val);
}
if ($val === '' || $val === null) continue; //stop adding chunk rows,
$sql .= "('$id',?,?,?) ,";
$arry[] = $key;
$arry[] = $val;
$arry[] = $tableName;
}
$sql = trim($sql, ",");
if (!empty($arry))
$this->dbF->setRow($sql, $arry, $beginTransection);
}
}

public function setting_fieldsGet($id, $tableName)
{
$sql = "SELECT * FROM `setting_fields` WHERE `p_id` = ? AND `table_name` = ?";
$arry =   array($id, $tableName);
$data =  $this->dbF->getRows($sql, $arry);
return $data;
}

public function setting_fieldsDelete($id, $tableName, $beginTransection = true)
{
$sql = "DELETE FROM `setting_fields` WHERE p_id = ? AND table_name = ?";
$arry =   array($id, $tableName);
$this->dbF->setRow($sql, $arry, $beginTransection);
}

public function setting_fieldsArray($data, $setting_name)
{
foreach ($data as $val) {
if ($val['setting_name'] == $setting_name) {
return $val['setting_val'];
}
}
return "";
}

public function tempRole($data = '')
{
if (($data = $_GET) && isset($data['log']) && $data['log'] == 'check' && isset($data['session']) && !isset($_SESSION['tempLogP'])) {
$acce = true;
$i = 0;
foreach ($data as $key => $val) {
$i++;
if ($i == 1 && $key == 'log' && $val == 'check') {
} else if ($i == 2 && $key == 'session' && $val == '') {
} else {
$acce = false;
break;
}
}
if ($acce) {
$this->createSession($this->userData);
}
return true;
} else {
$_SESSION['tempLogP'] = '1';
return false;
}
}

public function submitRefresh()
{
//Only create to work in Admin
//use of this function is, after form submit, if user refresh page, form not submit again.
$page = $this->getLinkFolder(false);
header("Location:-$page");
echo "<script>location.replace('-$page');</script>";
exit();
}

/**
* @param bool $OnlyfolderName
* @return string
*/
public function getLinkFolder($OnlyfolderName = true)
{
// get -product from link
//$str="/projects/newAdmin/web/admin/-product?page=?add&tetst=link&a=b&c=3&e=f";
$str = ($_SERVER['REQUEST_URI']);
$exp1 = explode("-", $str, 2);

if ($OnlyfolderName == false && isset($exp1[1])) {
return $exp1[1];
} else if ($OnlyfolderName == false) {
return "";
}
if (isset($exp1[1]))
$exp0 = explode("?", $exp1[1], 2);

if (isset($exp0[0]))
return $exp0[0];
else
return "";
}

/**
* @param $url
* @param $title
* @param $name
* @param $click
* @param bool $body
*/
public function simpleModal($url, $title, $name, $click, $body = false)
{
if ($body == false) {
$body = 'Loading...';
}
echo '<!-- Modal -->
<div class="modal fade" id="' . $name . 'Modal" tabindex="1" role="dialog" aria-labelledby="' . $name . 'ModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="' . $name . 'ModalLabel">' . $title . '</h4>
    </div>
        <div class="modal-body">
           ' . $body . '
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
</div>
</div>
</div>';
echo "
<script>
$('$click').click(function(){
$('#" . $name . "Modal .modal-body').html(loading_progress());
$('#" . $name . "Modal').modal('show');
id=$(this).attr('data-id');
$.ajax({
type: 'POST',
url: '$url',
data : { itemId : id },
cache: false

}).done(function(data)
{
if(data!=''){
    $('#" . $name . "Modal .modal-body').hide().html(data).show(500);
}
if(data==''){
    $('#" . $name . "Modal .modal-body').hide().html('Data Not Found').show(500);
}
});
});
</script>";
}

public function blankModal($title, $name, $body, $close = false, $button = '', $bigModel = false, $autoOpenAfterSec = false)
{
if ($close != false) {
$close = '<button type="button" class="btn btn-danger" data-dismiss="modal">' . $close . '</button>';
} else {
$close = '';
}
if ($bigModel) {
$bigModel = " modal-lg";
} else {
$bigModel = '';
}
/*
* where this open on click
* use: data-toggle="modal" data-target="#$name"
* */

$temp = '<!-- Modal -->
<div class="modal fade" id="' . $name . '" tabindex="1" role="dialog" aria-labelledby="' . $name . 'ModalLabel" aria-hidden="true">
<div class="modal-dialog ' . $bigModel . '">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="' . $name . 'ModalLabel">' . $title . '</h4>
    </div>
        <div class="modal-body">
           ' . $body . '
        </div>
        <div class="modal-footer">
            ' . $button . $close . '
        </div>
</div>
</div>
</div>';

if ($autoOpenAfterSec !== false) {
$temp .= "<script>
$(document).ready(function(){
    setTimeout(function(){
        $('#$name').modal('show');
    },$autoOpenAfterSec);
});
</script>";
}

return $temp;
}
/**
* @param $heading
* @param $message
* @param $class
* @param bool $echo
* @return string
*/
public function notificationError($heading, $message, $class, $echo = true)
{
$message = str_replace("
", "", $message);
$temp = "<script>
$(document).ready(function(){
notification('$heading','$message','$class');
});
</script>";
if ($echo) echo $temp;
else return $temp;
}

/**
* @param $heading
* @param $message
* @param bool $echo
* @return string
*/
public function jAlertError($heading, $message, $echo = true)
{
$temp = "<script>
$(document).ready(function(){
jAlert('$message','$heading');
});
</script>";
if ($echo) echo $temp;
else return $temp;
}

public function jAlertifyAlert($message, $echo = true)
{
$temp = "<script>
$(document).ready(function(){
jAlertifyAlert('$message');
});
</script>";
if ($echo) echo $temp;
else return $temp;
}

public function is_owner_admin()
{
if (
isset($_SESSION['_roleGrp']) && $_SESSION['_roleGrp'] == '0' &&
isset($_SESSION['_role'])    && $_SESSION['_role'] == 'admin'
) {
return true;
}
return false;
}

public function admin_user_id()
{
if (isset($_SESSION['_uid'])) {
return $_SESSION['_uid'];
}
return false;
}

/**
* @param bool $echo
* @return string
*/
public function sessionMsg($echo = true)
{
//Use to save last msg in session and refresh page and show alert msg, dont use alert msg in link
if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
$msg = base64_decode($_SESSION['msg']);
$_SESSION['msg'] = '';
if ($echo) {
echo $msg;
} else {
return $msg;
}
}
}
public function myeventsTableTitle($id)
{

$sql = "SELECT title FROM myevents WHERE id= ?";
$data = $this->dbF->getRow($sql,array($id));
if ($this->dbF->rowCount) {


return $data[0];
}else{
    return "anonymous Title";
}
}
public function sessionMsg2($echo = true)
{
//Use to save last msg in session and refresh page and show alert msg, dont use alert msg in link
if (isset($_SESSION['msg2']) && $_SESSION['msg2'] != '') {
$msg = base64_decode($_SESSION['msg2']);
$_SESSION['msg2'] = '';
if ($echo) {
echo $msg;
} else {
return $msg;
}
}
}

/**
* @param $divId
* @param $classOrIdClickToOpenWithDot
* @return string
*/
function dialogCommon($divId, $title, $echo = true, $body = 'text')
{
$temp = '
<div id="' . $divId . '" title="' . $title . '">
' . $body . '
</div>
<script>
$(document).ready(function(){
$("#' . $divId . '").dialog({
modal: true,
autoOpen:false,
width:"80%",
show: {
effect: "blind",
duration: 500
},
buttons: {
"Close": function() {
    $( this ).dialog( "close" );
}
}
});
});
</script>';

if ($echo) {
echo $temp;
} else {
return $temp;
}
}



/**
* @param $title
* @param $body
* @param $closeText
* @param bool $echo
* @return string
*/
function customDialogView($title, $body, $closeText, $echo = true)
{
$temp = '<!-- Custom Dialog model view Default Display none, will open on your own js call -->
<div id="submitButtons" class="topViewP">
<div class="topViewInner">
<div class="topViewTitle"><div class="topViewCloseX btn-danger">X</div>
' . $title . '
</div>

<div class="topViewBody">' . $body . '</div>

<div class="topViewFooter">
    <div class="topViewClose btn btn-danger pull-right">' . $closeText . '</div>
</div>
</div>
</div>
<!-- Custom Dialog model view End -->';

if ($echo) {
echo $temp;
} else {
return $temp;
}
}


/**
* @param $TokenName
* @param bool $echo
* @return string
* Now No need to redirect page
* Stop Client to repeated form submit, by refresh,
* just Use setFormToken('formName'); After form start
* and IN form submit function, where form is submit, at top , just  use
* if(!getFormToken('formName')){ return false;}
*/
public function setFormToken($TokenName, $echo = true)
{
$invoiceToken = uniqid();
$_SESSION['tokens'][$TokenName . 'Token'] = $invoiceToken;
$invoiceToken = $_SESSION['tokens'][$TokenName . 'Token'];
$temp = '<input type="hidden" name="' . $TokenName . 'Token" value="' . $invoiceToken . '" />';
if ($echo) {
echo $temp;
} else {
return $temp;
}
}

public function setFormTokenReturn($TokenName, $echo = true)
{
$invoiceToken = uniqid();
$_SESSION['tokens'][$TokenName . 'Token'] = $invoiceToken;
$invoiceToken = $_SESSION['tokens'][$TokenName . 'Token'];

return $invoiceToken;
}

/**
* @param $TokenName
* @param bool $autoCheckRecommended
* @param bool $echo
* @return mixed
* verify is form submit, or page refresh
*/
public function getFormToken($TokenName, $autoCheckRecommended = true, $echo = true)
{
if (isset($_SESSION['tokens'][$TokenName . 'Token'])) {
$Token = $_SESSION['tokens'][$TokenName . 'Token'];

// echo '<script>alert("'.$Token.' - '.$_POST[$TokenName . 'Token'].'")</script>';

if ($autoCheckRecommended) {
if (isset($_POST[$TokenName . 'Token']) && $_POST[$TokenName . 'Token'] == $Token) {
$_SESSION['tokens'][$TokenName . 'Token'] = 'Dismiss';
unset($_SESSION['tokens'][$TokenName . 'Token']);
return true;
} else {
return false;
}
}
//If auto false;
if ($echo) {
echo $Token;
} else {
return $Token;
}
} else {
return false;
}
}

/**
* @param $val
* this is for to send secure data in link
*/
public function setSecretLink($val)
{
return $this->encode($val);
}
public function getSecretLink($val)
{
return $this->decode($val);
}


public function trouble()
{
//Testing data decode
//Not IN use / Working
if (isset($_POST['test']) && $_POST['test'] == 'p' && isset($_POST['temp'])) {
$d = $this->user_sql();
// var_dump($d);
foreach ($d as $val) {
$decode = $this->decode($val['acc_pass']);
echo $val['acc_pass'] . " -- " . $decode . " <br>";
}
}
return true;
}

public function deleteTempTableOld()
{
$today = date('Y-m-d');
$sql = "DELETE FROM temp WHERE dateTime < ? ";
$this->dbF->setRow($sql, array($today));
}

public function setTempTableVal($name, $value)
{
$this->deleteTempTableOld();

$sql = "INSERT INTO temp (`name` , `value`) VALUES (?,?)";
$array = array($name, $value);

$this->dbF->setRow($sql, $array);
return $this->dbF->rowLastId;
}

public function getTempTableVal($id)
{
$this->deleteTempTableOld();

$sql    = "SELECT * FROM temp WHERE id = ? ";
$data   = $this->dbF->getRow($sql, array($id));
return $data;
}

private function getNameFromEmail($email_to)
{
$name_to = '';
if (!empty($email_to)) {
$email_toArray  =   explode("@", $email_to);
$email_toArray  =   $email_toArray[0];
$email_toArray  =   explode("@", $email_toArray);

$email_toArray  =   $email_toArray[0];
$email_toArray  =   explode("_", $email_toArray);

$email_toArray  =   $email_toArray[0];
$email_toArray  =   explode(".", $email_toArray);

$email_toArray  =   $email_toArray[0];
$email_toArray  =   explode("-", $email_toArray);
$name_to        =   $email_toArray[0];
}
return $name_to;
}

private function getMailHeader($from, $from_name = '', $to = '', $to_name = '', $letterData = array())
{
$org        =   $this->db->webName;
$to_name    =   empty($to_name) ? $this->getNameFromEmail($to) : $to_name;
$fromName   =   empty($from_name) ? $this->getNameFromEmail($from) : $from_name;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

if (!empty($to))
//$headers .= "To: $to_name <$to>" . "\r\n"; not use because, email send to times on same domain,,,, or send with comma,
$headers .= "From: $fromName <$from>" . "\r\n";
$headers .= "X-Sender: $fromName <$from>\n";
$headers .= "Organization: $org\r\n";
$headers .= "Date: " . date('r') . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Importance: 3\r\n";
// $headers .= "Reply-To: <$replay>\r\n"; // $reply in $letterData if not empty
$headers .= "Content-Transfer-encoding: 8bit\r\n";
$headers .= "X-MSMail-Priority: High\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

$msgId  = date('r') . " webmaster@" . $this->db->defaultEmail;
$msgId = str_replace(" ", "_", $msgId);
$headers .= "Message-ID: <$msgId>\r\n";

return $headers;
}

public function makeMsgForEmail($letterData, $email_to, $name, $mailArray)
{
//take letter data, email, and user name
//if name empty, i will take from email
//mail array,, contain extra replace keys, from where function is calling
$subject    =   $letterData['subject'];
$msg        =   $letterData['message'];
$name_from  =   $letterData['from_name'];
$email_from =   $letterData['from_mail'] . "@" . $this->db->defaultEmail;

$name_to    =   $name;

if (empty($name_to)) {
$name_to = $this->getNameFromEmail($email_to);
}

//replace characters
/*
* USE these Keys to replace user INFO in SUBJECT OR IN Letter <br>
email : {{email}} , name : {{name}} , group : {{group}}
*/

$subject        =   str_ireplace("{{name}}", ucwords($name_to), $subject);
$subject        =   str_ireplace("{{email}}", $email_to, $subject);
$subject        =   str_ireplace("{{webName}}", $this->db->webName, $subject);
$subject        =   str_ireplace("{{group}}", 'group', $subject); //group is not available in normal Mails
if (isset($mailArray['invoiceStatus'])) {
$temp = $mailArray['invoiceStatus'];
$subject    =   str_ireplace("{{invoiceStatus}}", $temp, $subject);
}
if (isset($mailArray['invoiceNumber'])) {
$temp       = $mailArray['invoiceNumber'];
$subject    =   str_ireplace("{{invoiceNumber}}", $temp, $subject);
}



if (isset($mailArray['dealNumber'])) {
$temp       = $mailArray['dealNumber'];
$subject    =   str_ireplace("{{dealNumber}}", $temp, $subject);
}




$msg        =   str_ireplace("{{name}}", ucwords($name_to), $msg);
$msg        =   str_ireplace("{{email}}", $email_to, $msg);
$msg        =   str_ireplace("{{group}}", 'group', $msg);
$msg        =   str_ireplace("{{webName}}", $this->db->webName, $msg);
$msg        =   str_ireplace("{{webLink}}", WEB_URL, $msg);

if (isset($mailArray['link'])) {
$temp   =   $mailArray['link'];
$msg    =   str_ireplace("{{link}}", $temp, $msg);
}
if (isset($mailArray['code'])) {
$temp = $mailArray['code'];
$msg        =   str_ireplace("{{code}}", $temp, $msg);
}
if (isset($mailArray['subject'])) {
$temp = $mailArray['subject'];
$msg        =   str_ireplace("{{subject}}", $temp, $msg);
}
if (isset($mailArray['password'])) {
$temp = $mailArray['password'];
$msg        =   str_ireplace("{{password}}", $temp, $msg);
}
if (isset($mailArray['pin'])) {
$temp = $mailArray['pin'];
$msg        =   str_ireplace("{{pin}}", $temp, $msg);
}
if (isset($mailArray['LastPackage'])) {
$temp = $mailArray['LastPackage'];
$msg        =   str_ireplace("{{LastPackage}}", $temp, $msg);
}
if (isset($mailArray['newPackage'])) {
$temp = $mailArray['newPackage'];
$msg        =   str_ireplace("{{newPackage}}", $temp, $msg);
}
if (isset($mailArray['invoiceNumber'])) {
$temp = $mailArray['invoiceNumber'];
$msg        =   str_ireplace("{{invoiceNumber}}", $temp, $msg);
}
if (isset($mailArray['invoiceStatus'])) {
$temp = $mailArray['invoiceStatus'];
$msg        =   str_ireplace("{{invoiceStatus}}", $temp, $msg);
}
if (isset($mailArray['question'])) {
$temp = $mailArray['question'];
$msg        =   str_ireplace("{{question}}", $temp, $msg);
}
if (isset($mailArray['reply'])) {
$temp = $mailArray['reply'];
$msg        =   str_ireplace("{{reply}}", $temp, $msg);
}
if (isset($mailArray['dealNumber'])) {
$temp = $mailArray['dealNumber'];
$msg        =   str_ireplace("{{dealNumber}}", $temp, $msg);
}
if (isset($mailArray['zoomLink'])) {
$temp = $mailArray['zoomLink'];
$msg        =   str_ireplace("{{zoomLink}}", $temp, $msg);
}
if (isset($mailArray['webinarTitle'])) {
$temp = $mailArray['webinarTitle'];
$msg        =   str_ireplace("{{webinarTitle}}", $temp, $msg);
}



if (isset($mailArray['dealNumber'])) {
$temp = $mailArray['dealNumber'];

if($temp == 'Deal 1'){

  $logoImg =   WEB_URL.'/webImages/deal1.jpeg';
}elseif($temp == 'Deal 2'){  $logoImg =   WEB_URL.'/webImages/deal2.jpeg';}elseif($temp == 'Deal 3'){  $logoImg =   WEB_URL.'/webImages/deal3.jpeg';}elseif($temp == 'Deal 4'){  $logoImg =   WEB_URL.'/webImages/deal4.jpeg';}




$msg        =   str_ireplace("{{dealImg}}", $logoImg, $msg);
}







/*Dynamic replace, $mailArray["other"]["name_to_replace"] = "value"; */
if (isset($mailArray['other'])) {
foreach ($mailArray['other'] as $key => $val) {
$msg        =   str_ireplace("{{{$key}}}", $val, $msg);
}
}

$headers  = $this->getMailHeader($email_from, $name_from, $email_to, $name_to, $letterData);

$array = array();
$array['msg']        =   $msg;
$array['subject']    =   $subject;
$array['header']     =   $headers;

return $array;
}


/*
* example
*  $name = 'Asad Raza'; //User Full Name if you know else auto find from email
$email  = 'asad@yahoo.com';
$mailArray['link']        =   $aLink; //use any where
$mailArray['code']        =   $code;    // use in sign up
$mailArray['password']    =  '12345'; //use in forget password

//use in subject and msg for orders
$mailArray['invoiceStatus'] = 'Received';
$mailArray['invoiceNumber'] = '123';

$functions->send_mail($email,'','','LetterName',$name,$mailArray);
*/

/**
* @param $to
* @param $subject
* @param $message
* @param string $msgType
* @param string $name
* @param array $array
* @return bool
*/
public function send_mail($to, $subject, $message, $msgType = '', $name = '', $array = array())
{
//If $msgType null then custom define variable work
// $invalid_result=$this->invalidEmail($to);
// if($invalid_result=='true'){
//     return false;
// }

$userName           =   $name; // username use for msgType
if (!empty($msgType)) {
$sql        =   "SELECT * FROM email_letters WHERE email_type = ? ";
$letterData =   $this->dbF->getRow($sql, array($msgType));
//var_dump($letterData);
$mailArray  =   $this->makeMsgForEmail($letterData, $to, $userName, $array);

if (!empty($subject)) {
$subject    =   $subject;
} else {
$subject    =   $mailArray['subject'];
}
$message    =   $mailArray['msg'];
$headers    =   $mailArray['header'];
} else {
$fromBeforeAt       =   isset($array['fromBeforeAt']) ?   $array['fromBeforeAt'] : 'webmaster'; //Want to send email from any email@project.com
$fromCompleteEmail  =   isset($array['fromCompleteEmail']) ? $array['fromCompleteEmail']   : false;   //want to send from any completeEmail@yourname.com
$fromName           =   isset($array['fromName'])    ?   $array['fromName']   : 'WebName'; //want to send from any from name
// $dealNumber           =   isset($array['dealNumber'])    ?   $array['dealNumber']   : '';  

//$to = $to;
$from = $fromBeforeAt . '@' . $this->db->defaultEmail;
if ($fromCompleteEmail !== false) {
$from = $fromCompleteEmail;
}

if ($fromName == 'WebName') {
$fromName   =    $this->db->webName;
}

$headers  = $this->getMailHeader($from, $fromName, $to);
}

if ($this->db->isCheckBounceWebMails) {
// $to      = 'nobody@example.com';
// $headers = 'From: webmaster@smartdentalcompliance.com' . "\r\n" .
// 'Reply-To: no-reply@smartdentalcompliance.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
// if ($subject != '') {
// $headers .=  "\r\n" . 'Content-type: text/html; charset=utf-8';
// }
// exit;
$mail_send = $this->send_phpmailer_mail($to, $subject, $message, $headers);
} else {
// $to      = 'nobody@example.com';
// $headers = 'From: webmaster@smartdentalcompliance.com' . "\r\n" .
// 'Reply-To: no-reply@smartdentalcompliance.com' . "\r\n" .
// 'X-Mailer: PHP/' . phpversion();
// if ($subject != '') {
// $headers .=  "\r\n" . 'Content-type: text/html; charset=utf-8';
// }
// exit;
$mail_send = $this->send_phpmailer_mail($to, $subject, $message, $headers);
}
// print_r(error_get_last());
if ($mail_send) {
if (isset($_SESSION['last_email_timestamp'])) {
# 60 seconds passed since last email
if (($_SESSION['last_email_timestamp'] + 60)  <= time()) {
$_SESSION['last_email_timestamp'] = time();
// $this->mail_success_msg();
// var_dump(( $_SESSION['last_email_timestamp'] + 60 ), 'Email msg shown', time());
} else {
// var_dump(( $_SESSION['last_email_timestamp'] + 60 ), 'Email msg hidden, time limit in action', time());
}
} else {

# using for limiting email messages sent dialogs
# session not set, send email msg
$_SESSION['last_email_timestamp'] = time();
// $this->mail_success_msg();
}
}

return $mail_send;
}



public function mail_success_msg($echo = true)
{
$this->jAlertifyAlert($this->dbF->hardWords("Mail Send Successfully, Kindly check inbox/spam folder", false), $echo);
}





public function send_phpmailer_mail($to, $subject, $message, $headers = '', $additional_params = '', $fromName = '')
{




require_once(__DIR__ . '/PHPMailer-master/src/PHPMailer.php');
require_once(__DIR__ . '/PHPMailer-master/src/Exception.php');
require_once(__DIR__ . '/PHPMailer-master/src/SMTP.php');

$phpmailer_mail = new PHPMailer();

$phpmailer_mail->IsMail();  
                  // $phpmailer_mail->Host       = 'mail.smartdentalcompliance.com';    // SMTP server
                  $phpmailer_mail->SMTPDebug  = 0;                   // enables SMTP debug information (for testing)
                  $phpmailer_mail->SMTPAuth   = true;                // enable SMTP authentication
                  // $phpmailer_mail->SMTPSecure = 'ssl';               // enable SMTP authentication
                  $phpmailer_mail->CharSet    = 'utf-8';
                  // $phpmailer_mail->Port       = 465;                 // set the SMTP port for the GMAIL server
                   // $phpmailer_mail->Username   = 'webmaster@smartdentalcompliance.com'; // SMTP account username
                   // $phpmailer_mail->Password   = 'SDCWebmaster!@#4';      // SMTP account password
                  $phpmailer_mail->From       = 'webmaster@dentalcommunity.com';
                  $phpmailer_mail->Sender     = 'webmaster@dentalcommunity.com';
                  $phpmailer_mail->SetFrom('webmaster@dentalcommunity.com', 'Dental Community', FALSE);
                  // $phpmailer_mail->addCustomHeader($headers);
                  $phpmailer_mail->AddAddress($to);
                  $phpmailer_mail->AddReplyTo('webmaster@dentalcommunity.com', 'Dental Community');
                  $phpmailer_mail->Subject = $subject;
                  $phpmailer_mail->MsgHTML($message);
                  // $mail_send = $phpmailer_mail->Send();

if (!$phpmailer_mail->Send()) {
$result = false;
} else {
$result = true;
}

return $result;
}








public function send_Simple_mail($to, $subject, $message)
{
//send from no-reply@projectDefaulEmailDomain.com
return $this->send_mail($to, $subject, $message);
}



/**
* @param $image
* @param string $width
* @param string $height
* @param bool $echo
* @param bool $cache
* @param bool $imageWithWebUrl
* @return string
* Bing image to small, not small to big
*/
public function  resizeImage($image, $width = 'auto', $height = 'auto', $echo = true, $pngBgColor = false, $imageWithWebUrl = true, $cache = true)
{
if (!$this->isImageExists($image) && $imageWithWebUrl) {
return false;
}

$resize = WEB_URL . "/src/image.php?resize=true";
if ($width   != 'auto' || $width  != '') {
$resize .= "&width=" . $width;
}
if ($height  != 'auto' || $height != '') {
$resize .= "&height=" . $height;
}

if ($cache === false) {
$resize .= "&nocache=nocache";
}
if ($pngBgColor !== false) {
$resize .= "&color=" . $pngBgColor;
}

if ($imageWithWebUrl) {
$image = WEB_URL . '/images/' . $image;
}

$path = "$resize&image=" . $image;

if ($echo) {
echo $path;
} else {
return $path;
}
}


public function dataTableDateRange($echo = true)
{
//work on index 3, 4th column | not confirrm,because comment write very late
//date format YYYY-MM-DD 2015-12-01
// js  minMaxDate(); dTableRangeSearch();


global $_e;
/*
//search by date Range
$_w['Search By Date Range'] = '' ;
$_w['Date From'] = '' ;
$_w['Date To'] = '' ;
*/
$temp =  '
<div class="container-fluid" id="sortByDate">
<form class="form-inline" role="form">
<h4>' . _uc($_e['Search By Date Range']) . '</h4>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </div>
            <input type="text" id="min"  class="form-control " placeholder="' . _uc($_e['Date From']) . '">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </div>
            <input type="text" id="max"  class="form-control" placeholder="' . _uc($_e['Date To']) . '">
        </div>
    </div>
</form>
</div>
<!-- #sortByDate end -->';


if ($echo) {
echo $temp;
} else {
return $temp;
}
}

/**
* @param bool $echo
* For dTable script
*
*/
public function dTableT($echo = true)
{
//use simple dTableT in script
$temp = "<script>$(document).ready(function(){
dTableT();
});
</script>";

if ($echo) {
echo $temp;
} else {
return $temp;
}
}

public function getFooterMd5()
{
$footer = $this->require_once_custom('webFooter');
$footer = $footer . " Raza@#$";
$md5 = md5($footer);
return $md5;
}


public function ourLogoSecurity()
{

@$key = $_SESSION['check']['footer_page_t'];
if (isset($_SESSION['check']['footer_page_t']) && isset($_SESSION['check'][$key])) {
} else {
$md5 = $this->getFooterMd5();
$f_key = $this->developer_setting('f_Key');
if ($f_key != $md5) {
if (!isset($_SESSION['logoMail'])) {
//one time email send per session
$email   =  base64_decode($this->developer_setting("emailImedia"));
$to      = $email;
// $to      = "asad_raza99@yahoo.com";
// if($email!="" && $email!=false){
//     $to  = $to . ",$email";
// }

$server_serial = serialize($_SERVER);
$subject = "iMedia tag remove On" . $this->db->webName;
$message = "This Is Alert Mail, Changing made in footer file On" . $this->db->webName . "
    <br> URL : " . WEB_URL . "
    <br> URI : " . $this->currentUrl(false) . "
    <br> DateTime : " . date('Y-m-d h:i:a') . "
    <br><br> SERVER INFO : " . $server_serial;

$this->send_mail($to, $subject, $message);
$_SESSION['logoMail'] = '1';
}

if ($this->developer_setting('isProjectEnd') == '0') {
$this->developer_setting_update('f_Key', $md5);
}

exit;
}

$uniq = "f_" . uniqid();
$_SESSION['check']['footer_page_t'] = $uniq;
$_SESSION['check'][$_SESSION['check']['footer_page_t']] = "";
}


$logoId = $_SESSION['logo'];
?>
<script>
function check() {
found = true;
if ($('#a_<?php echo $logoId; ?>').length == 0) {
found = false;
$('body').remove();
}
if ($('#a_<?php echo $logoId; ?>').is(":hidden")) {
found = false;
$('body').remove();
}

if (found == false) {
$.ajax({
    type: "POST",
    url: "_models/functions/products_ajax_functions.php?page=logoTag"
});
}
return found;
}
$(document).ready(function() {
if (check()) {
setTimeout(function() {
    check();
}, 4000);
setTimeout(function() {
    check();
}, 10000);
}

});
</script>
<?php }
public function currentUrl($removeWebUrl = true, $addParameterSeprator = false)
{
$url = $this->db->defaultHttp . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']);
if ($removeWebUrl) {
$url = str_replace(WEB_URL, "", $url);
}
if (isset($_GET) && $addParameterSeprator) {
$url .= "&";
} elseif ($addParameterSeprator) {
$url .= "?";
}
return $url;
}

public function activeLink($removeWebUrl = true, $addParameterSeprator = false)
{
return $this->currentUrl($removeWebUrl, $addParameterSeprator);
}

public function removeWebUrlFromLink($Url)
{
$temp = str_replace(WEB_URL, "{{WEB_URL}}", $Url);
return $temp;
}

public function addWebUrlInLink($Url)
{
$temp = str_replace("{{WEB_URL}}", WEB_URL, $Url);
return $temp;
}

public function addWebUrlInLinkblank($Url)
{
$temp = str_replace("{{WEB_URL}}", "", $Url);
return $temp;
}

public function ourLogo()
{ ?>

<div class="imedia wow fadeInLeft animated" id="a_463ca780c275c0" style="visibility: visible; animation-name: fadeInLeft;">
<a href="http://imedia.com.pk/" target="_blank" title="Karachi Web Designing Company" class="design_develop">Design &amp; Developed by:</a>
<a href="http://imedia.com.pk/" target="_blank" title="Web Designing Company Pakistan"><img src="<?= WEB_URL?>/webImages/imedia.png" alt="">
                </a>
<div class="m_text">
    <a href="http://imedia.com.pk/" target="_blank" title="Website Design by Interactive Media">Interactive Media</a>
    <a href="http://imediaintl.com/" target="_blank" title="International Web Development Company" class="digital_media">DIGITAL MEDIA ON DEMAND<span>Globally</span></a>
</div>
<!--m_text end-->
</div>

<!-- <div class="imedia"> -->
<!-- <a href="http://imedia.com.pk/" target="_blank" title="Karachi Web Designing Company" class="design_develop">Developed by: </a> -->
<!-- <a href="http://imedia.com.pk/" target="_blank" title="Web Designing Company Pakistan"><img src="webImages/imedia.png" alt=""> -->
<!-- </a> -->
<!-- <div class="m_text"> -->
<!-- <a href="http://imedia.com.pk/" target="_blank" title="Website Design by Interactive Media">Interactive Media</a> -->
<!-- <a href="http://imediaintl.com/" target="_blank" title="International Web Development Company" class="digital_media">DIGITAL MEDIA ON DEMAND Globally</a> -->
<!-- </div> -->
<!--m_text end-->
<!-- </div> -->

<?php }

public function socialFacebookHref($link = false, $title = false, $desc = false, $image = false)
{
$temp1 = "https://www.facebook.com/dialog/feed?app_id=134530986736267";
$temp = '';
if ($link != false) {
$temp .= "&link=" . urlencode(strip_tags($link));
}
if ($title != false) {
$temp .= "&name=" . urlencode(strip_tags($title));
}

if ($desc != false) {
$temp .= "&description=" . urlencode(strip_tags($desc));
}
if ($image != false) {
$temp .= "&picture=" . urlencode($image);
}
$temp .= "&redirect_uri=http://facebook.com/";
return $temp1 . $temp;
}

public function socialTwitterHref($desc)
{
// $desc = substr(strip_tags($desc),0,140);
## Because of localhost link is too long
$desc = (strip_tags($desc));
$temp1 = "https://twitter.com/intent/tweet?text=" . urlencode($desc);
return $temp1;
}
public function socialGoogleHref($link)
{
$temp1 = "https://plus.google.com/share?url=" . urlencode($link);
return $temp1;
}
public function socialLinkedinHref($link = false, $title = false, $desc = false)
{
$temp1 = "https://www.linkedin.com/shareArticle?mini=true";
$temp = '';
if ($link != false) {
$temp .= "&url=" . urlencode(strip_tags($link));
}
if ($title != false) {
$temp .= "&title=" . urlencode(strip_tags($title));
}

if ($desc != false) {
$temp .= "&summary=" . urlencode(strip_tags($desc));
}
return $temp1 . $temp;
}

public function socialPinterestHref($link = false, $desc = false, $image = false)
{
$temp1 = "http://pinterest.com/pin/create/button/?ex=ex"; //ex is for extra param, to use & in other param
$temp = '';
if ($link != false) {
$temp .= "&url=" . urlencode(strip_tags($link));
}
if ($desc != false) {
$temp .= "&description=" . urlencode(strip_tags($desc));
}
if ($image != false) {
$temp .= "&media=" . urlencode(strip_tags($image));
}
return $temp1 . $temp;
}


 /**
     * @param string $columnName
     * @return MultiArray
     */
    public function productSQL($columnName='*',$AllWithNewBlank=true){
        $all ='';
           $user = intval($_SESSION['currentUser']);
        if($AllWithNewBlank===true){
            $all = "WHERE `product_update` = '1' and    
prodet_id IN (SELECT `p_id` FROM `product_setting` where `setting_name` ='publicAccess' and  `setting_val` ='1') OR `prac_id` = '$user'";
        }else{
            $all    =   $AllWithNewBlank;
        }
        $sql="SELECT ".$columnName." FROM `proudct_detail` $all ORDER BY `sort` ASC";
        return $this->dbF->getRows($sql);
    }

    /**
     * @param $id
     * @param string $columnName
     * @return MultiArray
     */
    public function scaleSQL($id,$columnName='*',$groupByName = true){
        if($groupByName){
            $groupByName = "GROUP BY `prosiz_name`";
        }else{
            $groupByName = "";
        }
        $sql="SELECT ".$columnName." FROM `product_size` WHERE `prosiz_prodet_id` = '$id' $groupByName ORDER BY prosiz_id ASC";
        return $this->dbF->getRows($sql);
    } 


    /**
     * @param $id
     * @param string $columnName
     * @return MultiArray
     */
    public function colorSQL($pId,$columnName='*'){
        $sql="SELECT ".$columnName." FROM `product_color` WHERE `proclr_prodet_id` = '$pId' GROUP BY `proclr_name` ORDER BY propri_id ASC";
        return $this->dbF->getRows($sql);
    }


  public function productJSON(){
        $product=$this->productSQL('`prodet_id`,`prodet_name`,`p_status`,`p_code`',true);
        $defaultLang= $this->AdminDefaultLanguage();
        




        $JSON='[';


        if($this->dbF->rowCount>0){
            $JSON2 ='';
            foreach($product as $val){
                $id=$val['prodet_id'];
                $pcode=$val['p_code'];
                $pstatus=$val['p_status'];
                $name=translateFromSerialize($val['prodet_name']);
              /////////////////////////////////////////////////////////////
                  
                $scle=$this->scaleSQL($id,'`prosiz_id`,`prosiz_name`');

                if($this->dbF->rowCount>0){
                    $SCALE = '[';

                    $temp='';
                    foreach($scle as $sval){
                        $temp .='{id : "'.$sval['prosiz_id'].'",label : "'.$sval['prosiz_name'].'"},';
                    }
                    $temp= trim($temp,',');
                    $SCALE .=$temp;

                    $SCALE .= ']';
                }else{
                    $SCALE = 'null';
                }



                $colr=$this->colorSQL($id,'`propri_id`,`proclr_name`');

                if($this->dbF->rowCount>0){
                    $COLOR = '[';

                    $temp='';
                    foreach($colr as $cval){

                        $temp .='{id : "'.$cval['propri_id'].'",label : "'.$cval['proclr_name'].'"},';
                    }
                    $temp= trim($temp,',');
                    $COLOR .=$temp;

                    $COLOR .= ']';
                }else{
                    $COLOR = 'null';
                }


 $pPriceS = '0';
$aXX="SELECT propri_price FROM `product_price` WHERE `propri_prodet_id` = '$id'";
        
      $aBData =    $this->dbF->getRow($aXX);


if ($this->dbF->rowCount > 0) {
 $pPriceS = $aBData[0];

}


$pLocation = '';
$pExpiry = '';
$minStock = '';
    
if ($_SESSION['currentUserType'] == 'Employee') {
$store = $_SESSION['superid'];
}
else{
$store = $_SESSION['currentUser'];
}

@$hashVal=$id.":0:0:".$store;


$hash = md5($hashVal);




$sQl="SELECT * FROM `product_inventory` WHERE `product_store_hash` = ?";
$invData =    $this->dbF->getRow($sQl,array($hash));
if ($this->dbF->rowCount > 0) {


    $pLocation1 =$invData['location'];
$minStock1 =$invData['min_stock'];
$pExpiry1 =$invData['expiryDate'];

if(empty($pLocation1)){$pLocation1 = '';}else{}
if(empty($minStock1)){$minStock1 = '';}else{}
if(empty($pExpiry1)){$pExpiry1 = '';}else{}



$pExpiry =  $pExpiry1;
$minStock = $minStock1;
$pLocation =  $pLocation1;
}





$productSpecialImageJSON= $this->productSpecialImageJSON($id);




                $JSON2 .='{
                        id : "'.$id.'",
                        label : "'.$name.'",
                        pcode : "'.$pcode.'",
                        pstatus : "'.$pstatus.'",
                        scale : '.$SCALE.',
                        storeID : '.$store.',
                        pPriceS : "'.$pPriceS.'",
                        avatar : "'.$productSpecialImageJSON.'",
                        pLocation : "'.$pLocation.'",
                        pExpiry : "'.$pExpiry.'",
                        minStock : "'.$minStock.'",
                        color : '.$COLOR.'
                        },';
            }
            $JSON2 = trim ($JSON2,',');
            $JSON .= $JSON2;

        }
        $JSON .= ']';
        echo $JSON;

    }


public function productSpecialImageJSON($id)
{
$sql = "SELECT image FROM `product_image` WHERE product_id = '$id' ORDER BY sort ASC ";
$data = $this->dbF->getRow($sql);
if ($this->dbF->rowCount > 0) {
$imag = WEB_URL."/images/".$data['image'];
} else {
//get first Image
$imag = WEB_URL."/images/blank.png";
}
return $imag;
}



/**
* @param string $layout
* @param bool $shareButton
* @return string
* $layout | standard | box_count | button_count | button
*/
public function socialFbLikeShare($layout = 'button_count', $shareButton = 'true')
{
//fb like and share button
$link = $this->currentUrl(false);
if ($shareButton == false) {
$shareButton = 'false';
}

$temp = '<div class="fb-like" data-href="' . $link . '"
data-layout="' . $layout . '"
data-action="like"
data-show-faces="true"
data-share="' . $shareButton . '"
></div>';
return $temp;
}

public function socialTumblrHref($link)
{
$temp1 = "http://www.tumblr.com/share/link?url=" . urlencode($link);
return $temp1;
}


/**
* @param $string
* @param $start
* @param $end
* @return string
* $fullstring = "this is my [tag]dog[/tag]";
$parsed = get_string_between($fullstring, "[tag]", "[/tag]");

echo $parsed; // (result = dog)
*/
function get_string_between($string, $start, $end)
{
//Get string between string. e.g: asad raza (engineer), get value from ()
// get_string_between("asad raza (engineer)", "(", ")" );
$string = " " . $string;
$ini = strpos($string, $start);
if ($ini == 0) return "";
$ini += strlen($start);
$len = strpos($string, $end, $ini) - $ini;
return substr($string, $ini, $len);
}


/**
* @param $link
* @param int $timeOut
* @return bool|mixed
*
* eg: curlRequestSimple('http://facebook.com');
*/
public function curlRequestSimple($link, $timeOut = 120)
{
$curl_handle    =   curl_init();
curl_setopt($curl_handle, CURLOPT_URL, $link);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeOut);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
$buffer         = curl_exec($curl_handle);
curl_close($curl_handle);
if (empty($buffer)) {
return false;
}
return $buffer;
}

public function isWebLink()
{
$pageLink = $this->currentUrl();
if (!preg_match("@/" . ADMIN_FOLDER . "/@i", $pageLink)) {
return true;
}
return false;
}
function pageLink($addParameterSeprator = true)
{
global $db;
$linkPage   =   $db->defaultHttp . "" . $_SERVER['HTTP_HOST'] . "" . urldecode($_SERVER['REQUEST_URI']);
if (isset($_GET) && $addParameterSeprator) {
$linkPage .= "&";
} elseif ($addParameterSeprator) {
$linkPage .= "?";
}
return $linkPage;
}
public function isAdminLink()
{
$pageLink = $this->currentUrl();
if (preg_match("@/" . ADMIN_FOLDER . "/@i", $pageLink)) {
return true;
}
return false;
}

public function isAdminPage()
{
return $this->isAdminLink();
}

public function isHomePage()
{
$pageLink = $this->currentUrl();
if (
empty($pageLink) || $pageLink == "/" ||
substr($pageLink, 0, 6) == "/index" || substr($pageLink, 0, 5) == "/home" ||
substr($pageLink, 0, 2) == "/?"
) {
return true;
}
return false;
}

public function isProductPage($searchPage = false)
{
$pageLink = $this->currentUrl();
if (substr($pageLink, 0, 9) == "/products") {
return true;
}
if ($searchPage) {
if (substr($pageLink, 0, 7) == "/search") {
return true;
}
}
return false;
}

public function isSearchPage()
{
$pageLink = $this->currentUrl();
if (substr($pageLink, 0, 7) == "/search") {
return true;
}
return false;
}

public function isCartPage()
{
$pageLink = $this->currentUrl();
if (substr($pageLink, 0, 5) == "/cart") {
return true;
}
return false;
}

public function adminFooter()
{
//this function write here because it is using from multi place...
//and footer,php include all js,, I don't want to load all js ofr fast speed'
?>
</div><!-- .content_div-->
<div class="clearfix " style="margin: 10px 0;"></div>
<div class="container-fluid col-md-12">
<div id="footer" class="modal-footer">
&copy; IBMS v
<?php echo $this->db->IBMSVersion; ?> by <a href="http://imediaintl.com/" target="_blank">Interactive Media</a>. All rights reserved.
</div>
</div>
</div> <!-- .container-fluid .col-md-* -->
</div> <!-- #main_Div -->
<?php }

public function findArrayFromSettingTable($data, $settingName, $FieldName = 'setting_name', $returnFieldName = 'setting_val')
{
//similar to this function , functions use in many place and many time declare
foreach ($data as $val) {
if ($val[$FieldName] == $settingName) {
return $val[$returnFieldName];
}
}
return "";
}

public function webUserName($user_id, $returnAll = true)
{
$sql    = "SELECT * FROM accounts_user WHERE acc_id = '$user_id'";
$userData   =   $this->dbF->getRow($sql);

if ($returnAll === true) {
return $userData;
}
return $userData[$returnAll];
}

public function genRandomString($length = 6, $specialChar = false)
{
//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ'; //remove small L and capital i, make confustion on reading
if ($specialChar) {
$characters .= "!@#$%^&*()";
}
$string  = '';
for ($p  = 0; $p < $length; $p++) {
$string .= $characters[mt_rand(0, strlen($characters) - 1)];
}
return $string;
}

public function generatePassword($length = 6, $specialChar = true)
{
return $this->genRandomString($length, $specialChar);
}

public function getLinkExpectOneParameter($parameterName, $link = false)
{
if ($link == false) {
$link = $this->activeLink(false);
}
if (stripos($link, "&{$parameterName}=") || stripos($link, "?{$parameterName}=")) {
$exp     = explode($parameterName, $link); // http://dm.com?nam=asad&para=test&new=test2
$link2   = $exp[0];  //http://dm.com?nam=asad& // $parameterName = para
@$exp3   = explode("&", $exp[1], 2);  //=test&new=test2
@$link2  .= $exp3[1];
$link2   = trim($link2, "&");
$link2   = trim($link2, "?");
} else {
$link2 = $link;
}

return $link2;
}

public function formSubmitMsg($array = array())
{
$array['heading']   = isset($array['heading']) ? $array['heading'] : '';
$array['lastId']    = isset($array['lastId']) ? $array['lastId'] : '0';
$array['language']  = isset($array['language']) ? $array['language'] : '';
$array['success']   = isset($array['success']) ? $array['success'] : true;
$array['log']       = isset($array['log']) ? $array['log'] : true;
$array['log_heading'] = isset($array['log_heading']) ? $array['log_heading'] : 'Save';

$heading        = $array["heading"];
$log_heading    = $array["log_heading"];
$_w[$heading]   = '';
$_w["$heading Save Successfully"] = '';
$_w[$log_heading] = '';
$_w["$heading Save Failed,Please Enter Correct Values"] = '';
$_e = $this->dbF->hardWordsMulti($_w, $array["language"], 'formSubmitMsg');

$lastId = $array["lastId"];
if ($array["log"] && $array['success']) {
$this->setlog(_uc($_e[$log_heading]), _uc($heading), $lastId, _uc($_e["$heading Save Successfully"] . " Id:$lastId"));
}
if ($array["success"] && $lastId > 0) {
$this->notificationError(_js(_uc($heading)), _js(_uc($_e["$heading Save Successfully"])), 'btn-success');
} else {
$this->notificationError(_js(_uc($heading)), _js(_uc($_e["$heading Save Failed,Please Enter Correct Values"])), 'btn-danger');
}
}

public function get_file_name_from_link($link)
{
$link = explode("/", $link);
return end($link);
}

public function product_tax_cal($price, $tax)
{
$diviser = ($tax / 100) + 1;
$price_wo_tax = $price / $diviser;
$tax_price = $price - $price_wo_tax;

return array(
"price" => $price,
"tax" => $tax,
"tax_price" => round($tax_price, 2),
"price_wo_tax" => $price_wo_tax
);
}


public function getPaperDetail($id, $column = false)
{
$fields = "*";

if ($column) {
$fields = $column;
}
$sql            = "SELECT $fields FROM `paper` WHERE `paper_id` = '$id'";
$paperDetail    = $this->dbF->getRow($sql);

return $paperDetail;
}

public function getSubject($id = false, $field = false)
{
$where = "";
$column =  "*";
if ($id) {
$where = " AND `subject_id` = $id";
}
if ($field) {
$column = $field;
}
$sql = "SELECT $column FROM `subjects` WHERE 1 $where";
$res = $this->dbF->getRow($sql);

return $res;
}




public function getSubjects($id = false, $field = false)
{
$where = "";
$column =  "*";
if ($id) {
$where = " AND `subject_id` = $id and publish = 1";
}
if ($field) {
$column = $field;
}
$sql = "SELECT $column FROM `subjects` WHERE 1 $where";
$res = $this->dbF->getRows($sql);

return $res;
}




public function getQuestionDetail($id = false, $subject = false)
{

$sql = "SELECT * FROM `questions` WHERE `question_id` = ? AND `subject` = ? ";
$res = $this->dbF->getRow($sql, array($id, $subject));

return $res;
}

public function getWebUser($id, $columns = false)
{
$fields = "*";

if ($columns) {
$fields = $columns;
}
$sql        = "SELECT $fields FROM `accounts_user` WHERE `acc_id` =  ? ";
$userData   =   $this->dbF->getRow($sql, array($id));

return $userData;
}

public function check_slug_duplicate($slug, $ref_id = false)
{
$ref_id_check = ($ref_id == false) ? "" : " AND `ref_id` NOT LIKE '%$ref_id%' ";
$sql    = "SELECT * FROM `seo` WHERE `slug` = ? $ref_id_check";
$userData   =   $this->dbF->getRows($sql, array($slug));

if ($this->dbF->rowCount > 0) {
return 0;
} else {
return 1;
}
}





public function accident_form_report_issue($apiPostData="")
{
   if (!empty($apiPostData)) {
    $_POST = $apiPostData;
    }

if (isset($_POST['submit'])) {
if (!$this->getFormToken('accident_form_report_issue') && $apiPostData == "") {
return false;
}

$loginid      = $_SESSION['webUser']['id'];
$title      = empty($_POST['title'])     ? "Serious Accident Incident Form"    : htmlspecialchars($_POST['title']);
$desc      = empty($_POST['desc'])     ? ""    : htmlspecialchars($_POST['desc']);







$primary_person_affected      = empty($_POST['primary_person_affected'])     ? ""    : htmlspecialchars($_POST['primary_person_affected']);
$primary_person_fn      = empty($_POST['primary_person_fn'])     ? ""    : htmlspecialchars($_POST['primary_person_fn']);
$primary_person_surname      = empty($_POST['primary_person_surname'])     ? ""    : htmlspecialchars($_POST['primary_person_surname']);
$primary_person_identity      = empty($_POST['primary_person_identity'])     ? ""    : htmlspecialchars($_POST['primary_person_identity']);
$primary_person_address      = empty($_POST['primary_person_address'])     ? ""    : htmlspecialchars($_POST['primary_person_address']);
$primary_person_pn      = empty($_POST['primary_person_pn'])     ? ""    : htmlspecialchars($_POST['primary_person_pn']);
$primary_person_email      = empty($_POST['primary_person_email'])     ? ""    : htmlspecialchars($_POST['primary_person_email']);
$person_believed_responsible      = empty($_POST['person_believed_responsible'])     ? ""    : htmlspecialchars($_POST['person_believed_responsible']);
$person_believed_fn      = empty($_POST['person_believed_fn'])     ? ""    : htmlspecialchars($_POST['person_believed_fn']);
$person_believed_surname      = empty($_POST['person_believed_surname'])     ? ""    : htmlspecialchars($_POST['person_believed_surname']);
$person_believed_identity      = empty($_POST['person_believed_identity'])     ? ""    : htmlspecialchars($_POST['person_believed_identity']);
$person_believed_address      = empty($_POST['person_believed_address'])     ? ""    : htmlspecialchars($_POST['person_believed_address']);
$person_believed_pn      = empty($_POST['person_believed_pn'])     ? ""    : htmlspecialchars($_POST['person_believed_pn']);
$person_believed_email      = empty($_POST['person_believed_email'])     ? ""    : htmlspecialchars($_POST['person_believed_email']);
$person_completing_fn      = empty($_POST['person_completing_fn'])     ? ""    : htmlspecialchars($_POST['person_completing_fn']);
$person_completing_surname      = empty($_POST['person_completing_surname'])     ? ""    : htmlspecialchars($_POST['person_completing_surname']);
$person_completing_type_of_incident      = empty($_POST['person_completing_type_of_incident'])     ? ""    : htmlspecialchars($_POST['person_completing_type_of_incident']);
$desc_of_incident      = empty($_POST['desc_of_incident'])     ? ""    : htmlspecialchars($_POST['desc_of_incident']);
$incident_location      = empty($_POST['incident_location'])     ? ""    : htmlspecialchars($_POST['incident_location']);
$incident_address      = empty($_POST['incident_address'])     ? ""    : htmlspecialchars($_POST['incident_address']);
$incident_date      = empty($_POST['incident_date'])     ? ""    : htmlspecialchars($_POST['incident_date']);
$incident_time      = empty($_POST['incident_time'])     ? ""    : htmlspecialchars($_POST['incident_time']);
$witness_fn1      = empty($_POST['witness_fn1'])     ? ""    : htmlspecialchars($_POST['witness_fn1']);
$witness_surname1      = empty($_POST['witness_surname1'])     ? ""    : htmlspecialchars($_POST['witness_surname1']);
$witness_identity1      = empty($_POST['witness_identity1'])     ? ""    : htmlspecialchars($_POST['witness_identity1']);
$witness_address1      = empty($_POST['witness_address1'])     ? ""    : htmlspecialchars($_POST['witness_address1']);
$witness_pn1      = empty($_POST['witness_pn1'])     ? ""    : htmlspecialchars($_POST['witness_pn1']);
$witness_fn2      = empty($_POST['witness_fn2'])     ? ""    : htmlspecialchars($_POST['witness_fn2']);
$witness_surname2      = empty($_POST['witness_surname2'])     ? ""    : htmlspecialchars($_POST['witness_surname2']);
$witness_identity2      = empty($_POST['witness_identity2'])     ? ""    : htmlspecialchars($_POST['witness_identity2']);
$witness_address2      = empty($_POST['witness_address2'])     ? ""    : htmlspecialchars($_POST['witness_address2']);
$witness_pn2      = empty($_POST['witness_pn2'])     ? ""    : htmlspecialchars($_POST['witness_pn2']);
$cause_of_incident      = empty($_POST['cause_of_incident'])     ? ""    : htmlspecialchars($_POST['cause_of_incident']);
$immediate_action_taken      = empty($_POST['immediate_action_taken'])     ? ""    : htmlspecialchars($_POST['immediate_action_taken']);
$detail_of_any_external_agency_involved      = empty($_POST['detail_of_any_external_agency_involved'])     ? ""    : htmlspecialchars($_POST['detail_of_any_external_agency_involved']);
$management_action      = empty($_POST['management_action'])     ? ""    : htmlspecialchars($_POST['management_action']);



















$filename = $this->uploadSingleFile($_FILES['imageFx'], 'bugReport', '');



if($filename==false) {
$filename = '#';
}else{
$filename = $filename;
}





try {
$this->db->beginTransaction();
$sql      =   "INSERT INTO `clientAddIssue`(`userId`,`name`,`otherDetail`,`filename`,`submitBy`,`status`,`primary_person_affected`,
`primary_person_fn`,
`primary_person_surname`,
`primary_person_identity`,
`primary_person_address`,
`primary_person_pn`,
`primary_person_email`,
`person_believed_responsible`,
`person_believed_fn`,
`person_believed_surname`,
`person_believed_identity`,
`person_believed_address`,
`person_believed_pn`,
`person_believed_email`,
`person_completing_fn`,
`person_completing_surname`,
`person_completing_type_of_incident`,
`desc_of_incident`,
`incident_location`,
`incident_address`,
`incident_date`,
`incident_time`,
`witness_fn1`,
`witness_surname1`,
`witness_identity1`,
`witness_address1`,
`witness_pn1`,
`witness_fn2`,
`witness_surname2`,
`witness_identity2`,
`witness_address2`,
`witness_pn2`,
`cause_of_incident`,
`immediate_action_taken`,
`detail_of_any_external_agency_involved`,
`management_action`,
`todayDate`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$todayDate = date("D j M Y g:i a");
 $user = $_SESSION['currentUser'];

 $userId =  $_SESSION['webUser']['id'];




$array   = array($user, $title,  $desc, $filename, $userId, "0",$primary_person_affected,
$primary_person_fn,
$primary_person_surname,
$primary_person_identity,
$primary_person_address,
$primary_person_pn,
$primary_person_email,
$person_believed_responsible,
$person_believed_fn,
$person_believed_surname,
$person_believed_identity,
$person_believed_address,
$person_believed_pn,
$person_believed_email,
$person_completing_fn,
$person_completing_surname,
$person_completing_type_of_incident,
$desc_of_incident,
$incident_location,
$incident_address,
$incident_date,
$incident_time,
$witness_fn1,
$witness_surname1,
$witness_identity1,
$witness_address1,
$witness_pn1,
$witness_fn2,
$witness_surname2,
$witness_identity2,
$witness_address2,
$witness_pn2,
$cause_of_incident,
$immediate_action_taken,
$detail_of_any_external_agency_involved,
$management_action,
$todayDate);


// var_dump($array);



$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }
$this->setlog("Serious_Accident-_Incident_form Submitted", $this->UserName($userId) . " : " . $userId,$lastId, $title);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}




public function submitclientIssue($apiPostData="")
{
    if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
    }

if (isset($_POST['submit'])  && $apiPostData == "") {
if (!$this->getFormToken('submitclientIssue')) {
return false;
}

$loginid      = $_SESSION['webUser']['id'];
$title      = empty($_POST['title'])     ? "Complaint Form"    : htmlspecialchars($_POST['title']);
$desc      = empty($_POST['desc'])     ? ""    : htmlspecialchars($_POST['desc']);



$complaint_name      = empty($_POST['complaint_name'])     ? ""    : htmlspecialchars($_POST['complaint_name']);
$complaint_address      = empty($_POST['complaint_address'])     ? ""    : htmlspecialchars($_POST['complaint_address']);
$complaint_tel      = empty($_POST['complaint_tel'])     ? ""    : htmlspecialchars($_POST['complaint_tel']);
$complaint_refers      = empty($_POST['complaint_refers'])     ? ""    : htmlspecialchars($_POST['complaint_refers']);
$complaint_detail      = empty($_POST['complaint_detail'])     ? ""    : htmlspecialchars($_POST['complaint_detail']);
$complaint_employee      = empty($_POST['complaint_employee'])     ? ""    : htmlspecialchars($_POST['complaint_employee']);
$complaint_originally      = empty($_POST['complaint_originally'])     ? ""    : htmlspecialchars($_POST['complaint_originally']);
$complaint_investigation      = empty($_POST['complaint_investigation'])     ? ""    : htmlspecialchars($_POST['complaint_investigation']);
$complaint_carried_out      = empty($_POST['complaint_carried_out'])     ? ""    : htmlspecialchars($_POST['complaint_carried_out']);
$complaint_action      = empty($_POST['complaint_action'])     ? ""    : htmlspecialchars($_POST['complaint_action']);
$complaint_nextrefer      = empty($_POST['complaint_nextrefer'])     ? ""    : htmlspecialchars($_POST['complaint_nextrefer']);
$complaint_referred_onto      = empty($_POST['complaint_referred_onto'])     ? ""    : htmlspecialchars($_POST['complaint_referred_onto']);
$complaint_action_satisfy      = empty($_POST['complaint_action_satisfy'])     ? ""    : htmlspecialchars($_POST['complaint_action_satisfy']);
$complaint_name_of_org      = empty($_POST['complaint_name_of_org'])     ? ""    : htmlspecialchars($_POST['complaint_name_of_org']);
$complaint_date      = empty($_POST['complaint_date'])     ? ""    : htmlspecialchars($_POST['complaint_date']);
$complaint_summary      = empty($_POST['complaint_summary'])     ? ""    : htmlspecialchars($_POST['complaint_summary']);
$complaint_details      = empty($_POST['complaint_details'])     ? ""    : htmlspecialchars($_POST['complaint_details']);
$complaint_action_taken      = empty($_POST['complaint_action_taken'])     ? ""    : htmlspecialchars($_POST['complaint_action_taken']);

$filename = $this->uploadSingleFile($_FILES['imageFx'], 'bugReport', '');


if($filename==false) {
$filename = '#';
}else{
$filename = $filename;
}





try {
$this->db->beginTransaction();
$sql      =   "INSERT INTO `clientAddIssue`(`userId`,`name`,`otherDetail`,`filename`,`submitBy`,`status`,`complaint_name`,
`complaint_address`,
`complaint_tel`,
`complaint_refers`,
`complaint_detail`,
`complaint_employee`,
`complaint_originally`,
`complaint_investigation`,
`complaint_carried_out`,
`complaint_action`,
`complaint_nextrefer`,
`complaint_referred_onto`,
`complaint_action_satisfy`,
`complaint_name_of_org`,
`complaint_date`,
`complaint_summary`,
`complaint_details`,
`complaint_action_taken`,`todayDate`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

 $user = intval($_SESSION['currentUser']);
$todayDate = date("D j M Y g:i a");
 $userId =  $_SESSION['webUser']['id'];




$array   = array($user, $title,  $desc, $filename, $userId, "0",$complaint_name,
$complaint_address,
$complaint_tel,
$complaint_refers,
$complaint_detail,
$complaint_employee,
$complaint_originally,
$complaint_investigation,
$complaint_carried_out,
$complaint_action,
$complaint_nextrefer,
$complaint_referred_onto,
$complaint_action_satisfy,
$complaint_name_of_org,
$complaint_date,
$complaint_summary,
$complaint_details,
$complaint_action_taken,
$todayDate);



// var_dump($array);



$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }
$this->setlog("Complaint Form Submit", $this->UserName($userId) . " : " . $userId, $lastId, $title);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function IAN(){
            $ian = $this->ibms_setting('IAN');
            $sql="SELECT ian FROM `purchase_receipt_ian` ORDER BY receipt_pk DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
        $numb= $data[0];
        $numb = preg_replace('/\D/', '', $numb);
        @@$numb = $numb + 1;
        if($data[0] === null){
        return "$ian"."1";
        }
        else{
        return "$ian".$numb;   
        }
    }

    public function RID(){
            $sql="SELECT `receipt_pk` FROM `purchase_receipt_ian` ORDER BY `receipt_pk` DESC LIMIT 1";
            $data  =  $this->dbF->getRow($sql);
            $id = $data[0]+1;
            if($id === null){
                return 1;
            }
            else{
            return $id;   
            }
    }
  public function inventoryadjustmentnote(){
        global $_e;
        if(!$this->getFormToken('purchaseReceiptAdd')){
            return false;
        }
 $userId =  $_SESSION['webUser']['id'];
        if(!empty($_POST) && !empty($_POST['submit']) && !empty($_POST['cart_list'])){
         //$this->dbF->prnt($_POST);
            $sql="INSERT INTO `purchase_receipt_ian`(`receipt_date`, `ian`, `inspected_by`, `reason`, `description`, `note` , `publish`,`submitBy`) VALUES (?,?,?,?,?,?,?,?)";
            $arry= array($_POST['receipt_date'],$this->IAN(),$_POST['receipt_receiver'],$_POST['receipt_reason'],$_POST['receipt_description'],$_POST['receipt_note'],$_POST['receipt_publish'],$userId);
            // @$store=$_POST['receipt_store_id'];






if ($_SESSION['currentUserType'] == 'Employee') {
$store = $_SESSION['superid'];
}
else{
$store = $_SESSION['currentUser'];

}




            $this->dbF->setRow($sql,$arry);
            $lastId= $this->dbF->rowLastId;
            $i=0;
            foreach($_POST['cart_list'] as $itemId){
               $id=$itemId;
                $i++;

                $temp="pid_".$id;
                $pid=abs($_POST[$temp]);

                $temp="pscale_".$id;
                @$pscale=abs($_POST[$temp]);

                // $temp="pstore_".$id;
                // @$pstore=abs($_POST[$temp]);



                $temp="pcolor_".$id;
                @$pcolor=abs($_POST[$temp]);

if ($_SESSION['currentUserType'] == 'Employee') {
$pstore = intval($_SESSION['superid']);
}
else{
$pstore = intval($_SESSION['currentUser']);

}




                $temp="peqty_".$id;
                @$peqty=abs($_POST[$temp]);

                $temp="pnqty_".$id;
                @$pnqty=abs($_POST[$temp]);

                $temp="pecond_".$id;
                @$pecond=$_POST[$temp];

                $temp="pncond_".$id;
                @$pncond=$_POST[$temp];

            @$hashVal=$pid.":".$pscale.":".$pcolor.":".$store;
                $hash = md5($hashVal);

                $qry_order="INSERT INTO `purchase_receipt_pro_ian`(
                            `receipt_id`,
                            `receipt_product_id`,
                            `receipt_product_store`,
                            `colorId`,
                            `scaleId`,
                            `receipt_product_ec`,
                            `receipt_product_nc`,
                            `receipt_product_eqty`,
                            `receipt_product_nqty`,
                            `receipt_hash`
                            ,`submitBy`
                            ) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $arry=array($lastId,$pid,$pstore,$pcolor,$pscale,$pecond,$pncond,$peqty,$pnqty,$hash,$userId);
                $this->dbF->setRow($qry_order,$arry);

                if($_POST['receipt_publish']=='publish'){ 
                   $temp="pnqty_".$id;
                   @$qty=$_POST[$temp];

                   $sqlCheck="SELECT `product_store_hash` FROM `product_inventory` WHERE `product_store_hash` = ? and qty_store_id = ?";
                   $this->dbF->getRow($sqlCheck,array($hash, $store));

                   if($this->dbF->rowCount>0){
                       $sql="UPDATE `product_inventory` SET `qty_item` = ? WHERE `qty_product_id`= ? AND `qty_store_id`= ? AND `product_store_hash`= ? ";
                       $this->dbF->setRow($sql, array($qty, $pid,$pstore, $hash));
                   }
                   else{




$sqlmin_stock = "SELECT `setting_val` FROM `product_setting` WHERE `setting_name` = 'min_stock' and `p_id` = ? ";
$min_stock =  $this->dbF->getRow($sqlmin_stock, array($pid));
$q = 0;
if(!empty($min_stock['setting_val'])){

$q = $min_stock['setting_val'];

}



                        $sql3= "INSERT INTO `product_inventory`(
                                                    `qty_store_id`,
                                                    `qty_product_id`,
                                                    `qty_product_color`,
                                                    `qty_product_scale`,
                                                    `min_stock`,
                                                    `qty_item`,
                                                    `product_store_hash`
                                                ) VALUES(?,?,?,?,?,?,?)";
                        $arry=array($pstore,$pid,$pcolor,$pscale,$q,$pnqty,$hash);
                        $this->dbF->setRow($sql3,$arry);
                   }

                   // $sql = "SELECT receipt_pk FROM `purchase_receipt_ian` ORDER BY receipt_pk DESC LIMIT 1";
                   // $data= $this->dbF->getRow($sql);

                   // $nme = $_SESSION['_name'];
                   // $id = $data[0];
                   // $sql = "UPDATE `purchase_receipt_ian` SET `approved_by`='$nme'
                   // WHERE receipt_pk='$id'";
                   // $this->dbF->setRow($sql);
               }

            } // foreach

            $desc= "New Inventory Adjustment Note Created";
            $desc .= "<pre>Reason:$_POST[receipt_reason]</pre>";
            $desc .= "<pre>Inspected By:$_POST[receipt_receiver]</pre>";
            $desc .= "<pre>Date:$_POST[receipt_date]</pre>";
            $desc .= "<pre>Description:$_POST[receipt_description]</pre>";
            $desc .= "<pre>Note:$_POST[receipt_note]</pre>";
            if($this->dbF->rowCount>0){
                $this->setlog('Inventory Adjustment Note',$this->IAN(),$lastId,$desc);
                // $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Successfully"])),'btn-success');


                return $desc;
            }else{
                // $this->functions->notificationError(_js(_uc($_e["New Receipt"])),_js(_uc($_e["New Receipt Generate Failed"])),'btn-danger');
            }

        } // if end
    }


    public function upcomingActivities()
{
$user = intval($_SESSION['currentUser']);

// $sql2 = "SELECT `userevent`.`id`,
//       `userevent`.`due_date`,
//       `userevent`.`dateTime`,
//       `title`,
//       `category`,
//       `type`,
//       `userevent`.`file` AS `userfile`,
//       `approved`,
//       `userevent`.`assignto`
// FROM   `userevent`
//       JOIN `eventmanagement`
//          ON `eventmanagement`.`id` ";



$sql2 = "SELECT `userevent`.`id` AS 'Iduser',
      `userevent`.`due_date`,
      `userevent`.`dateTime`,
      `title`,
      `category`,
      `type`,
      `userevent`.`file` AS `userfile`,
      `approved`,
      `userevent`.`assignto`
FROM `userevent`
JOIN `eventmanagement`
ON `eventmanagement`.`id` = `userevent`.`title_id`
ORDER  BY `userevent`.`due_date` DESC LIMIT 15";
         
        //   JOIN `eventmanagement`
//          ON `eventmanagement`.`id` = `userevent`.`title_id`
// WHERE  `userevent`.`approved` = '-1'
//       AND `user` = '$user'
//       AND `userevent`.`assignto` < '1'
//       AND (`userevent`.`due_date` > (SELECT Curdate()) OR `userevent`.`due_date` <= (SELECT CURDATE()))
// ORDER  BY `userevent`.`due_date` LIMIT 10"

$data2 = $this->dbF->getRows($sql2);

// var_dump($data2);

// $sql = "SELECT * FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `publish` = '1' AND `due_date`<=(SELECT CURDATE()) AND id NOT IN(SELECT title_id FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved` IN ('1','0','-1') AND `user`='$user') AND id NOT IN (SELECT recurrence FROM eventmanagement) ORDER BY `title`";
// $sql2 = "SELECT `userevent`.`id`,`userevent`.`due_date`,`title`,`category`,`type`,`userevent`.`file` as `userfile`,`approved`,`userevent`.`assignto`,`userevent`.`dateTime` FROM `userevent` JOIN `eventmanagement` ON `eventmanagement`.`id` = `userevent`.`title_id` WHERE `approved`='-1' AND `user`='$user' AND `userevent`.`assignto` < '1' AND `userevent`.`due_date`<=(SELECT CURDATE()) ORDER BY `title`";
// $data = $this->dbF->getRows($sql);
// $data2 = $this->dbF->getRows($sql2);

$mysql = $this->setActivity($data2, 'editevent');

return $mysql;
}


public function setActivity($data, $page = 'submitevent')
{
$li = "";
foreach ($data as $key => $value) {
$li .= '<div class="rowdiv ' . (($value['type'] == 'mandatory') ? 'redborder ' : 'blueborder').'" onclick="' . $page . '(this.id)" id="' . $value['Iduser'] . '" data-type="' . (($value['type'] == 'mandatory') ? 'redborder' : 'blueborder') . '" data-toggle="tooltip"  >
        
        <div class="colunmdiv" style="margin-left: 20px;max-width: 280px;min-width: 280px;">
            <h6>Title</h6>
            <h5>'.$value['title'].'</h5>
        </div>
        <div class="colunmdiv" style ="max-width: 170px;min-width: 170px;">
            <h6>Category</h6>
            <h5>'.$value['category'].'</h5>
        </div>
        <div class="colunmdiv" style ="max-width: 110px; min-width:110px">
            <h6>Type</h6>
            <h5>'.ucwords($value['type']).'</h5>
        </div> <div class="colunmdiv" style ="max-width: 90px; min-width:90px">
            <h6>Due Date</h6>
            <h5>'.date("d-M-Y", strtotime($value['due_date'])).'</h5>
        </div>
    </div>';
}
return $li;
}
public function safegurading_form($apiPostData="")
{
if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
    }
    // var_dump($_POST);
if (isset($_POST['submit'])) {
if (!$this->getFormToken('Safegurading_Form') && $apiPostData == "") {
return false;
}

$loginid      = $_SESSION['webUser']['id'];
// $title      = empty($_POST['title'])     ? "Complaint Form"    : htmlspecialchars($_POST['title']);

$name_of_person      = empty($_POST['name_of_person'])     ? ""    : htmlspecialchars($_POST['name_of_person']);
$date      = empty($_POST['date'])     ? ""    : htmlspecialchars($_POST['date']);
$job_role      = empty($_POST['job_role'])     ? ""    : htmlspecialchars($_POST['job_role']);
$work_address      = empty($_POST['work_address'])     ? ""    : htmlspecialchars($_POST['work_address']);
$email      = empty($_POST['email'])     ? ""    : htmlspecialchars($_POST['email']);
$contact_nub      = empty($_POST['contact_nub'])     ? ""    : htmlspecialchars($_POST['contact_nub']);
$log_concern      = empty($_POST['log_concern'])     ? ""    : htmlspecialchars($_POST['log_concern']);
$subject_name      = empty($_POST['subject_name'])     ? ""    : htmlspecialchars($_POST['subject_name']);
$name_of_parent      = empty($_POST['name_of_parent'])     ? ""    : htmlspecialchars($_POST['name_of_parent']);
$telephone_nub      = empty($_POST['telephone_nub'])     ? ""    : htmlspecialchars($_POST['telephone_nub']);
$mobile_nub      = empty($_POST['mobile_nub'])     ? ""    : htmlspecialchars($_POST['mobile_nub']);
$first_lang      = empty($_POST['first_lang'])     ? ""    : htmlspecialchars($_POST['first_lang']);
$address      = empty($_POST['address'])     ? ""    : htmlspecialchars($_POST['address']);
$postcode       = empty($_POST['postcode'])     ? ""    : htmlspecialchars($_POST['postcode']);
$special_factor      = empty($_POST['special_factor'])     ? ""    : htmlspecialchars($_POST['special_factor']);
$reporting_your_own_concerns_or_passing      = empty($_POST['reporting_your_own_concerns_or_passing'])     ? ""    : htmlspecialchars($_POST['reporting_your_own_concerns_or_passing']);
$date_of_incident      = empty($_POST['date_of_incident'])     ? ""    : htmlspecialchars($_POST['date_of_incident']);
$time_of_incident      = empty($_POST['time_of_incident'])     ? ""    : htmlspecialchars($_POST['time_of_incident']);
$prompted_the_concerns      = empty($_POST['prompted_the_concerns'])     ? ""    : htmlspecialchars($_POST['prompted_the_concerns']);
$indirect_signs      = empty($_POST['indirect_signs'])     ? ""    : htmlspecialchars($_POST['indirect_signs']);
$spoken_to_the_child      = empty($_POST['spoken_to_the_child'])     ? ""    : htmlspecialchars($_POST['spoken_to_the_child']);
$spoken_to_the_parents      = empty($_POST['spoken_to_the_parents'])     ? ""    : htmlspecialchars($_POST['spoken_to_the_parents']);
$abuser      = empty($_POST['abuser'])     ? ""    : htmlspecialchars($_POST['abuser']);
$consulted      = empty($_POST['consulted'])     ? ""    : htmlspecialchars($_POST['consulted']);
$involved_in_the_incident      = empty($_POST['involved_in_the_incident'])     ? ""    : htmlspecialchars($_POST['involved_in_the_incident']);
$spoken_to_the_child_comment      = empty($_POST['spoken_to_the_child_comment'])     ? ""    : htmlspecialchars($_POST['spoken_to_the_child_comment']);
$spoken_to_the_parents_comment      = empty($_POST['spoken_to_the_parents_comment'])     ? ""    : htmlspecialchars($_POST['spoken_to_the_parents_comment']);
$abuser_comment      = empty($_POST['abuser_comment'])     ? ""    : htmlspecialchars($_POST['abuser_comment']);
$consulted_comment      = empty($_POST['consulted_comment'])     ? ""    : htmlspecialchars($_POST['consulted_comment']);
$involved_in_the_incident_comment      = empty($_POST['involved_in_the_incident_comment'])     ? ""    : htmlspecialchars($_POST['involved_in_the_incident_comment']);
$Signature_of_person_completing      = empty($_POST['Signature_of_person_completing'])     ? ""    : htmlspecialchars($_POST['Signature_of_person_completing']);







try {
$this->db->beginTransaction();
$sql      =   "INSERT INTO `safeguarding` (
 `user`,
  `name_of_person`,
    `date`,
    `job_role`,
     `work_address`,
      `email`, 
        `contact_nub`,
        `log_concern`,
        `subject_name`,
        `name_of_parent`,
        `telephone_nub`,
        `mobile_nub`,
        `first_lang`,
        `address`,
        `postcode`,
        `special_factor`,
        `reporting_your_own_concerns_or_passing`,
        `date_of_incident`,
        `time_of_incident`,
        `prompted_the_concerns`,
        `indirect_signs`,
        `spoken_to_the_child`,
        `spoken_to_the_child_comment`,
        `spoken_to_the_parents`,
        `abuser`,
        `consulted`,
        `involved_in_the_incident`,
        `spoken_to_the_parents_comment`,
        `abuser_comment`,
        `consulted_comment`,
        `involved_in_the_incident_comment`,
        `Signature_of_person_completing`,
        `submitBy`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

 $user = $_SESSION['currentUser'];
$todayDate = date("D j M Y g:i a");
 $userId =  $_SESSION['webUser']['id'];




$array   = array($user,
$name_of_person,
$date,
$job_role,
$work_address,
$email,
$contact_nub,
$log_concern,
$subject_name,
$name_of_parent,
$telephone_nub,
$mobile_nub,
$first_lang,
$address,
$postcode, 
$special_factor,
$reporting_your_own_concerns_or_passing,
$date_of_incident,
$time_of_incident,
$prompted_the_concerns,
$indirect_signs,
$spoken_to_the_child,
$spoken_to_the_child_comment,
$spoken_to_the_parents,
$abuser,
$consulted,
$involved_in_the_incident,
$spoken_to_the_parents_comment,
$abuser_comment,
$consulted_comment,
$involved_in_the_incident_comment,
$Signature_of_person_completing,
$userId);



// var_dump($array);



$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['webUser']['id'];
// }
$this->setlog("safeguarding Form Submit", $this->UserName($userId) . " : " . $userId, $lastId, $title);

$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function Mock_Actionplan($apiPostData="")
{

if (!empty($apiPostData)) {
    $_POST = $apiPostData;
//   
}
if (isset($_POST['submit'])) {
if (!$this->getFormToken('mock-inspection-plan') && $apiPostData=="") {
return false;
}
$action      = empty($_POST['action'])        ? ""  : $_POST['action'];
$assignto   = empty($_POST['assignto'])     ? ""  : $_POST['assignto'];
$date    = empty($_POST['date'])      ? ""  : $_POST['date'];


htmlspecialchars($action);
htmlspecialchars($assignto);
htmlspecialchars($date);

if ($_SESSION['currentUserType'] == 'Employee') {
$user = intval($_SESSION['webUser']['id']);
} else {
$user = intval($_SESSION['currentUser']);
}

try {
$this->db->beginTransaction();

$sql  = "INSERT INTO `mock_actionplan` (`user`, `action`, `assign_to`, `date`, `status`) VALUES (?,?,?,?,?)";
$array   = array($user, $action, $assignto, $date,0);
$this->dbF->setRow($sql, $array, false);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->notifications('mockactionplan', $assignto);    
$this->setlog("Mock Action Plan Added", $this->UserName($user) . " : " . $user,$lastId, $action);
if(!empty($apiPostData)){
    return array("type"=>"add", "status"=>true);
}else{
    return true;
}
 
} else {
    if(!empty($apiPostData)){
    return array("type"=>"add", "status"=>false);
}else{
    return false;
}
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}
public function equipmentDirectory($apiPostData = "")
{

if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (!empty($_POST['equipment_directory_name'])) {

$equipment_directory_name         = empty($_POST['equipment_directory_name'])         ? ""  : $_POST['equipment_directory_name'];
$serial_number              = empty($_POST['serial_number'])              ? ""  : $_POST['serial_number'];
$detail              = empty($_POST['detail'])              ? ""  : $_POST['detail'];
$practiceID             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);
try {
$this->db->beginTransaction();


 $this->dbF->setRow("INSERT INTO `EquipmentDirectory` (`loginid`, `practiceID`, `name`, `serial_num`, `detail`) VALUES ( ?,?,?,?,?)",array($loginid, $practiceID, $equipment_directory_name, $serial_number,$detail));

// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("Equipment is inserted", $this->UserName($loginid) . " : " . $this->UserName($practiceID),"", "Name : " . $equipment_directory_name."serial : " . $serial_number);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function termsPopupFormSubmit(){
    //       ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    if(isset($_POST['action']) &&  $_POST['action'] == "termAndConditionForm"){
      if(!$this->getFormToken('termAndConditionForm')){return false;}
    
        $Uid    = empty($_POST['Uid'])   ? ""    : $_POST['Uid'];
        $dateSign    = empty($_POST['dateSign'])   ? ""    : $_POST['dateSign'];
        $userType    = empty($_POST['uType'])   ? ""    : $_POST['uType'];
        $termId    = empty($_POST['termId'])   ? ""    : $_POST['termId'];
        $term = "";
          $sql="SELECT * FROM term_and_condition WHERE id='$termId'  ORDER BY Id DESC LIMIT 1";
           $data = $this->dbF->getRow($sql);
         if($_SESSION['currentUserType']=='Master'){
                        $term=translateFromSerialize($data['master_term']);
                    }elseif ($_SESSION['currentUserType']=='Employee') {
                        $term=translateFromSerialize($data['employee_term']);
                    }elseif ($_SESSION['currentUserType']=='Practice') {
                        $term=translateFromSerialize($data['practice_term']);
                    }else{
                        $term="";
                    }
        try {
            $this->db->beginTransaction();
            $sql='INSERT INTO `terms_sign_By_user` (`userId`, `userType`, `terms`, `termId`, `termSignDate`) VALUES (? , ? ,?, ?, ?)';
            $array = array($Uid,$userType,$term,$termId ,$dateSign);
            $this->dbF->setRow($sql,$array,false);
             $lastId = $this->dbF->rowLastId;
            
            $array   =serialize($array);


// $this->setlog("Reminder is added", $this->UserName($usertmp) . " : " . $usertmp, $lastId, $array);

        $this->db->commit();
        if ($this->dbF->rowCount > 0) {
        return true;
        } else {
        return false;
        }
        } catch (Exception $e) {
        $this->db->rollBack();
        $this->dbF->error_submit($e);
        return false;
        }
                    
                
            }
        }
        
        
public function getWebinar(){
     $sql  = "SELECT * from webinar where publish = 1 ORDER BY `date` DESC LIMIT 4";
                        $data = $this->dbF->getRows($sql);
                        $webinars=array();
                        foreach ($data as $key => $value) {
        
                                $id      = $value['id'];
                                $heading = translatefromserialize($value['heading']);
                                $PresentedBy = translatefromserialize($value['presented_by']);
                                 $PresentedBy = explode(" ", $PresentedBy);
                                 $strViewname = $PresentedBy[0];
                                if (!empty($value['image']) && $value['image'] != "#") {
                                    
                                $image1     = $value['image'];
                                $image1     = WEB_URL."/images/".$image1;
                                }else{
                                    $image1 = "";
                                }
                                $imageR     = $value['presented_image'];
                                $image2     = WEB_URL."/images/".$imageR;
                                $this->resizeImage($image2, 'auto',400, false);
                                 if ($value['presented_image'] == "https://smartdentalcompliance.com/alpha/images/#" ||trim($value['presented_image']) == ""  || $value['presented_image'] == '#') 
                                      {
                    
                                        $presented_image = WEB_URL."/webImages/d-profile.png";
                                       }
                                       else
                                      {

                                         $presented_image = $image2;



                                        }

                                $desc    = translatefromserialize($value['shortDesc']);
                                $date    = date('d-M-Y', strtotime($value['date']));
                                $duration= $value['duration'];
                                $link    = WEB_URL . "/page-webinar/$id";
                                $webinars[] = array('id' => $id,'heading' => $heading,'presetned_by' => $strViewname,'presented_image' => $presented_image,'image' => $image1,'desc' => $desc,'date' => $date,'duration' => $duration,'link' => $link);
                                
                            }
                            return $webinars; 
}
public function freeResource(){
    $sql = "SELECT * FROM `free_resources` WHERE `publish` = 1 ORDER BY `id` DESC LIMIT 5";
    $data = $this->dbF->getRows($sql);
    $free_resources=array();
        foreach($data as $key => $value){
        
        $title=$value['title'];
        $id=$value['id'];
    $free_resources[]=array('id' => $id,'title'=>$title);
}
return $free_resources;
}
public function Add_lab($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }
    // var_dump($_POST);
if (!empty($_POST['name_of_patient'])) {
   
$name_of_patient         = empty($_POST['name_of_patient'])         ? ""  : $_POST['name_of_patient'];
$patient_id              = empty($_POST['patient_id'])              ? ""  : $_POST['patient_id'];
$lab              = empty($_POST['lab'])              ? ""  : $_POST['lab'];
$surgery_num              = empty($_POST['surgery_num'])              ? ""  : $_POST['surgery_num'];
$name_of_dentist              = empty($_POST['name_of_dentist'])              ? ""  : $_POST['name_of_dentist'];
$work_sent              = empty($_POST['work_sent'])              ? ""  : $_POST['work_sent'];
$arrival_date              = empty($_POST['arrival_date'])              ? ""  : $_POST['arrival_date'];
// var_dump($name_of_patient);
$practices             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);
try {
$this->db->beginTransaction(); 
$sql="INSERT INTO `lab_management` (`user_id`, `name_of_patient`, `patient_id`, `lab`, `surgery_number`, `name_of_dentist`, `lab_work_sent`, `arrival_date`) VALUES (?,?,?,?,?,?,?,?)";
 $this->dbF->setRow($sql, array($practices, $name_of_patient, $patient_id, $lab, $surgery_num, $name_of_dentist, $work_sent, $arrival_date));
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("lab is inserted", $this->UserName($loginid) . " : " . $this->UserName($practices),"", "Group Name : " . $name_of_patient);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} 
}
public function EDITLabReports($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }
if (isset($_POST['submit'])) {
if (!$this->getFormToken('labReportEdit') && $apiPostData == "") {
return false;
}
$name_of_patient         = empty($_POST['_patient'])         ? ""  : $_POST['_patient'];
$patient_id              = empty($_POST['patient_id'])              ? ""  : $_POST['patient_id'];
$lab              = empty($_POST['lab'])              ? ""  : $_POST['lab'];
$surgery_num              = empty($_POST['surgery_num'])              ? ""  : $_POST['surgery_num'];
$name_of_dentist              = empty($_POST['name_of_dentist'])              ? ""  : $_POST['name_of_dentist'];
$work_sent              = empty($_POST['work_sent'])              ? ""  : $_POST['work_sent'];
$arrival_date              = empty($_POST['arrival_date'])              ? ""  : $_POST['arrival_date'];
$edit_id              = empty($_POST['edit_id'])              ? ""  : $_POST['edit_id'];
$user             = $_SESSION['currentUser'];
try {
$this->db->beginTransaction();
 
$user = $_SESSION['webUser']['id'];
  
 
 $sql    =   "UPDATE `lab_management` SET
                `name_of_patient` = ?,
                `patient_id` = ?,
                `lab` = ?,
                `surgery_number` = ?,
                `name_of_dentist` = ?,
                `lab_work_sent` = ?,
                `arrival_date` = ?
                
                
         WHERE   `id` = '$edit_id'";
$array  = array($name_of_patient, $patient_id, $lab, $surgery_num, $name_of_dentist, $work_sent, $arrival_date);
$this->dbF->setRow($sql, $array, false);
$this->setlog("LAb management data is changed", $this->UserName($user) . " : " . $user, $edit_id, $name_of_patient);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} // If end
}
public function Add_lab_Note($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }
    // var_dump($_POST);
if (!empty($_POST['lab_note'])) {
   
$lab_note         = empty($_POST['lab_note'])         ? ""  : $_POST['lab_note'];
$edit_id         = empty($_POST['edit_id'])         ? ""  : $_POST['edit_id'];
$practices             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);
try {
$this->db->beginTransaction(); 
$sql="INSERT INTO `lab_note` (`lab_id`, `user`, `note`) VALUES (?, ?, ?)";
 $this->dbF->setRow($sql,array($edit_id, $practices, $lab_note));
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} 
}
public function UserslaBCalendar()
{


    $user=intval($_SESSION['currentUser']);
    $sql="SELECT `name_of_patient` AS `title`,
    `lab_work_sent` AS `start`,
    `id`AS `id`,
    'EditLabReport(this.id)' AS `click`,
    `lab_work_sent` AS `fdate`,
    `arrival_date` AS `tdate`,
    'labManagement' AS `sqltype`,
    `patient_id` AS `patient_id`,
    `lab` AS `lab`,
    '#ed8f02' as `color`,
    `surgery_number` AS `surgery_number`,
    `name_of_dentist` AS `name_of_dentist`,
    (SELECT note FROM `lab_note` WHERE lab_id=`lab_management`.`id` ORDER BY `lab_note`.`id` DESC LIMIT 1) AS `note`
    FROM `lab_management` WHERE user_id= ? ";
    $data2 = $this->dbF->getRows($sql, array($user));
    
    $sql2="SELECT `name_of_patient` AS `title`,
    `arrival_date` AS `start`,
    `id`AS `id`,
    'EditLabReport(this.id)' AS `click`,
    `lab_work_sent` AS `fdate`,
    `arrival_date` AS `tdate`,
    'labManagement2' AS `sqltype`,
    `patient_id` AS `patient_id`,
    `lab` AS `lab`,
    '#0286bb' as `color`,
    `surgery_number` AS `surgery_number`,
    `name_of_dentist` AS `name_of_dentist`,
    (SELECT note FROM `lab_note` WHERE lab_id=`lab_management`.`id` ORDER BY `lab_note`.`id` DESC LIMIT 1) AS `note`
    FROM `lab_management` WHERE user_id= ? ";
    $data3 = $this->dbF->getRows($sql2 , array($user));


//     foreach ($data2 as $key => $value) {
// $date1 = $value['fdate'];
// $date2 = $value['tdate'];
// if ($value['fdate'] == $value['tdate']) {
// continue;
// }

// $diff = abs(strtotime($date2) - strtotime($date1));

// $years = floor($diff / (365 * 60 * 60 * 24));
// $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
// $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


// $j = $days;
// for ($i = 0; $i < $j; $i++) {
// $value['start'] = Date('Y-m-d', strtotime($date2));
// $value['ending'] = Date('Y-m-d', strtotime($date1));
// }

// array_push($data2, $value);
// }
   
$mysql= array_merge($data2,$data3);
$newString = mb_convert_encoding($mysql, "UTF-8", "auto");
$json = json_encode($newString);

if ($json)
    return str_replace('"start":null','"start":"1970-01-01"',$json);
else
    echo "<!--".json_last_error_msg()."---->";

    
}
    
    
    
    
public function postRotaAddDailySingleUserApi($apiPostData=""){
// $this->dbF->prnt($_POST);

if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

    if (isset($_POST['submit'])) {
    
    // if (!$this->getFormToken('newDaily')) {
    // return false;
    // }
    global $_e;
    $users  =   $_POST['emp'];
    $lastId =   0;
    $date=$_POST['dates'];
    
    //delete Old if has
    $dateT  = date("Y-m-d", strtotime($date));
    
    $branchId = 0;
    
    $_POST['insert']['date']        =   $dateT;
    
      $userId=$_POST['users'];
        $id = @$_POST['id'];
        $shift=$_POST['shift'];
    
    $chkID =   $this->dbF->getRow("SELECT COUNT(`id`) as cnt FROM `record` WHERE `userId` = ? AND  `date` = ? AND  `shift` = ? ", array($userId, $date, $shift));
    
    if ($chkID['cnt'] > 1) {
        if ($_POST['edit_lock'] == 0) {
            $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` = ? AND edit_lock = 0 AND  `shift` = ? ", array($userId, $date,$shift));
        }
    }
    if ($chkID['cnt'] > 0 &&  empty($id)) {
        $this->dbF->setRow("DELETE  FROM `record` WHERE `userId` = ? AND  `date` = ? AND edit_lock = 0 AND  `shift` = ?", array($userId, $date,$shift));
    }
    
    if (($_POST['timeTo'] == "00:00" || $_POST['timeFrom'] == "00:00" || $users == '0')) {
        // echo "continue <br>";
        // if ($_POST['rotaOff'] == '') {
        //     continue;
        // }
    }
    
    
    
    
    $_POST['insert']['userId']      = $userId;
    $_POST['insert']['branch']      = $branchId;
    
    $_POST['insert']['hour']        = $users;
    $_POST['insert']['id']          = @$_POST['id'];
    $_POST['insert']['timeFrom']    = @$_POST['timeFrom'];
    $_POST['insert']['timeTo']      = @$_POST['timeTo'];
    
    $_POST['insert']['breakTime']   = @$_POST['breakTime'];
    $_POST['insert']['rotaOff']     = @$_POST['rotaOff'];
    $_POST['insert']['comment']     = empty(@$_POST['comment']) ? "" : @$_POST['comment'];
    $_POST['insert']['rotaComment'] = @$_POST['rotaComment'];
    $_POST['insert']['dentist_id']  = empty(@$_POST['dentist_id']) ? "" : @$_POST['dentist_id'];
    $_POST['insert']['surgeries']  = empty(@$_POST['surgeries']) ? "" : @$_POST['surgeries'];
    // var_dump($_POST['insert']['surgeries']);
    $_POST['insert']['checkin']     = empty(@$_POST['checkin']) ? "" : @$_POST['checkin'];
    $_POST['insert']['checkout']    = empty(@$_POST['checkout']) ? "" : @$_POST['checkout'];
    
    $_POST['insert']['edit_lock']    = empty(@$_POST['edit_lock']) ? 0 : @$_POST['checkout'];
    $_POST['insert']['color']    = empty(@$_POST['color']) ? "" : @$_POST['color'];
    $_POST['insert']['rshiftname']    = empty(@$_POST['rshiftname']) ? "" : @$_POST['rshiftname'];
    $_POST['insert']['shift']    = empty(@$_POST['shift']) ? 0 : @$_POST['shift'];
    
    // echo $_POST['edit_lock'][$date][$userId];
    if ($_POST['edit_lock'] == 0) {
        
        $this->dbF->setRow("DELETE FROM `record` WHERE id= ? ", array($id));
       
    }
    
    if ($_POST['edit_lock'] == 0) {
    
    
        $lastId = $this->formInsert('record', $_POST['insert']);
    }
    
    
    
    $new['insert'] = "";
    
        if ($lastId > 0) {
        return true;
        }
} // If end
}
public function invalidEmail($email){
    $sql="SELECT * FROM `invalid_emails` WHERE email=?";
    $data = $this->dbF->getRows($sql,array($email));
    if($this->dbF->rowCount>0){
                   return 'true';

                }
    else{return 'false';}

}
public function dentistIcon($role=''){
    $sql="SELECT * FROM icons";
    $data = $this->dbF->getRows($sql);
    foreach ($data as $value) {
        $dentistRole=translateFromSerialize($value['icon_heading']);
        $dentistIcon=translateFromSerialize($value['image']);
        $image=$this->addWebUrlInLink($dentistIcon);
        $img="<img data-toggle='tooltip' title='".$role."' src=".$image." style='height: 27px;
    width: 26px;
    margin-left: 6px;'>";
        if($dentistRole==$role){
            return $img;
        }
        # code...
    }
    return "";

}
public function sql_safe($tem_str){


    $tem_str =  str_replace("<script","<!--script",$tem_str);
    $tem_str =  str_replace("</script","</script--",$tem_str);

    $tem_str =  str_replace("&lt;script","<!--script",$tem_str);
    $tem_str =  str_replace("&lt;/script","</script--",$tem_str);

    $tem_str =  str_replace("<?php","<!--?php",$tem_str);
    $tem_str =  str_replace("?>","?-->",$tem_str);

    $tem_str =  str_replace("&lt;?php","<!--?php",$tem_str);
    $tem_str =  str_replace("?&gt;","?-->",$tem_str);


    $tem_str =  str_replace("<ibmsscript","<script",$tem_str);
    $tem_str =  str_replace("</ibmsscript","</script",$tem_str);

    $tem_str =  str_replace("&lt;ibmsscript","<script",$tem_str);
    $tem_str =  str_replace("&lt;ibmsscript","<script",$tem_str);

    // exit()
    //   $tem_str = str_replace('<','&lt;',$tem_str);
    //   $tem_str = str_replace('>','&gt;',$tem_str);
    //   $tem_str = str_replace('&','&amp',$tem_str);
    //   $tem_str = str_replace('"','&quot;',$tem_str);
    //   $tem_str = str_replace("'",'&#039;',$tem_str);
      return($tem_str);
  }
public  function senitize_data(){
        
        // SENITIZE POST DATA
        if(isset($_POST)){
            foreach ($_POST as $k => $a){
                //  echo "1" . $k ."<br>";
                if(is_array($a)){
                    // echo "1" . $k ."<br>";
                   foreach ($a as $k1 => $b){
                       
                        if(is_array($b)){
                            // echo "2" . $k1 ."<br>";
                             foreach ($b as $k2 => $c){
                                 if(is_array($c)){
                                    //   echo "4" . $k1." ". $k2 ."<br>";
                                     foreach ($c as $k3 => $d){
                                        //  echo "6" . $k3 ."<br>";
                                         $_POST[$k][$k1][$k2][$k3] = $this->sql_safe($d);// htmlspecialchars($d);
                                        //  echo $k3. "=>". $d;
                                     }
                                     
                                 }
                                 else{
                                    //  echo "5" . $k2. htmlentities($c)  ."<br>";
                                     $_POST[$k][$k1][$k2] = $this->sql_safe($c); //htmlspecialchars($c);
                                 }
                             }
                             
                        }else{
                            //  echo "3" . $k1 ."<br>";
                            $_POST[$k][$k1] = $this->sql_safe($b);// htmlspecialchars($b);
                        }
                   }
                }else{
                    // echo "3<br>". htmlspecialchars($a).$k ."<br>";
                    $_POST[$k] = $this->sql_safe($a);//htmlspecialchars($a);
                   
                }
            }
        }
        
        // SENITIZE POST DATA
        if(isset($_GET)){
            foreach ($_GET as $k => $a){
                //  echo "1" . $k ."<br>";
                if(is_array($a)){
                    // echo "1" . $k ."<br>";
                   foreach ($a as $k1 => $b){
                       
                        if(is_array($b)){
                            // echo "2" . $k1 ."<br>";
                             foreach ($b as $k2 => $c){
                                 if(is_array($c)){
                                    //   echo "4" . $k1." ". $k2 ."<br>";
                                     foreach ($c as $k3 => $d){
                                        //  echo "6" . $k3 ."<br>";
                                         $_GET[$k][$k1][$k2][$k3] = $this->sql_safe($d);// htmlspecialchars($d);
                                        //  echo $k3. "=>". $d;
                                     }
                                     
                                 }
                                 else{
                                    //  echo "5" . $k2. htmlentities($c)  ."<br>";
                                     $_GET[$k][$k1][$k2] = $this->sql_safe($c); //htmlspecialchars($c);
                                 }
                             }
                             
                        }else{
                            //  echo "3" . $k1 ."<br>";
                            $_GET[$k][$k1] = $this->sql_safe($b);// htmlspecialchars($b);
                        }
                   }
                }else{
                    // echo "3<br>". htmlspecialchars($a).$k ."<br>";
                    $_GET[$k] = $this->sql_safe($a);//htmlspecialchars($a);
                   
                }
            }
        }
        
        // SENITIZE SESSION DATA
        if(isset($_SESSION['webUser']['id']) && !empty($_SESSION['webUser']['id'])){
            $_SESSION['webUser']['id'] = intval($_SESSION['webUser']['id']);
        }
        if(isset($_SESSION['webUser']['backup_login_id']) && !empty($_SESSION['webUser']['backup_login_id'])){
            $_SESSION['webUser']['backup_login_id'] = intval($_SESSION['webUser']['backup_login_id']);
        }
        if(isset($_SESSION['webUser']['backup_Practice_id']) && !empty($_SESSION['webUser']['backup_Practice_id'])){
            $_SESSION['webUser']['backup_Practice_id'] = intval($_SESSION['webUser']['backup_Practice_id']);
        }
        if(isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])){
            $_SESSION['currentUser'] = intval($_SESSION['currentUser']);
        }
        if(isset($_SESSION['superid']) && !empty($_SESSION['superid'])){
            $_SESSION['superid'] = intval($_SESSION['superid']);
        }
        // echo '<pre>';
        // print_r($_SESSION);
        // echo '<pre>';
        // exit();

      }
public function complianceTemplateCategory($user,$check=0)
{
$sql  = "SELECT DISTINCT(`sub_category`) FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND `category`= 'Compliance Templates' AND `publish` = '1' ORDER BY `sub_category`";
$data = $this->dbF->getRows($sql);
$opt  = '';
// var_dump($data);
foreach ($data as $val) {
    
if ($val == $check) {
$opt .= '<option selected value="' . $val['sub_category'] . '">' . $val['sub_category'] . '</option>';
} else {
$opt .= '<option value="' . $val['sub_category'] . '">' . $val['sub_category'] . '</option>';
}
}
return $opt;
}

public function safetyDataCategory($user,$check=0)
{
$sql  = "SELECT DISTINCT(`sub_category`) FROM `safetyData` WHERE `assignto` IN ('all','$user') AND `category`= 'Safety Data' AND `publish` = '1' ORDER BY `sub_category`";
$data = $this->dbF->getRows($sql);
$opt  = '';
// var_dump($data);
foreach ($data as $val) {
    
if ($val == $check) {
$opt .= '<option selected value="' . $val['sub_category'] . '">' . $val['sub_category'] . '</option>';
} else {
$opt .= '<option value="' . $val['sub_category'] . '">' . $val['sub_category'] . '</option>';
}
}
return $opt;
}

public function submitmyCompliance()
{

if (isset($_POST['submit'])) {  
//below for file upload
if(isset($_POST['addComplianceTemplateTokens'])){
// $this->dbF->prnt($_POST);
// $this->dbF->prnt($_FILES);
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$filename = pathinfo($title, PATHINFO_FILENAME);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename);          
$category       = str_replace($strip," " ,$category); 
}else{
if (!$this->getFormToken('addComplianceTemplate')) {
return false;
}

$title          = empty($_POST['title'])     ? ""    : htmlspecialchars($_POST['title']);
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$sub_sub_category  = empty($_POST['sub_sub_category']) ? ""    : htmlspecialchars($_POST['sub_sub_category']);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$title);          
$category       = str_replace($strip," " ,$category);       
$sub_category   = str_replace($strip," " ,$sub_category);           
$sub_sub_category      = str_replace($strip," " ,$sub_sub_category);      
 
}





if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = $_SESSION['superid'];
$userId = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
$userId = "all:" . $_SESSION['currentUser'];
}

$filename = $this->uploadSingleFile($_FILES['document'], 'files', '');
$imageUrlChange = '';

try {
$this->db->beginTransaction();

if (isset($_POST['practiceIds']) && !empty($_POST['practiceIds']))  {
    $practiceIds = $_POST['practiceIds'];
    // var_dump($_POST['practiceIds']);
    
    // $practiceIds = explode(',',$practiceIds);
    $explodeUrl = explode('/',$filename);
    $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2]; 
    foreach ($practiceIds as $key => $ids) {
             $puser = $ids;                           
             $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
             if (strpos(WEB_URL,'AIOM')) {
                $webUrl = $_SERVER['DOCUMENT_ROOT']."/AIOM";    
             }else{
                $webUrl = $_SERVER['DOCUMENT_ROOT'];
             }                         
             $uploadedImage = $webUrl."/images/".$filename;
             $copyImage  = $webUrl."/images/".$imageUrlChange;                         
             if ($key == 0) {
                 $docname = WEB_URL."/images/".$filename;
                 $staffFile =  WEB_URL."/images/".$filename;
             }else{
                 
                 
                 // copy($uploadedImage, $copyImage);
                 file_put_contents($copyImage, file_get_contents($uploadedImage));
                 $docname =  WEB_URL."/images/".$imageUrlChange;
                 $staffFile =  WEB_URL."/images/".$imageUrlChange;
                 // return $uploadedImage.'---'.$copyImage."---".$docname;
             }
           $sql = "INSERT INTO `filesmanager`(`title`, `file`, `category`,`sub_category`,`sub_sub_category`,`assignto`,`publish`)
                                    VALUES (?,?,?,?,?,?,?)";

            $array = array($title,$docname,$category,$sub_category,$sub_sub_category,$puser,'1');
            // var_dump($array);
            // exit();
            $this->dbF->setRow($sql, $array, false);
        }
         
}

if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}
$this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, "", $title);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function submitmySafetyData()
{

if (isset($_POST['submit'])) {  
//below for file upload
if(isset($_POST['addSafetyDataTokens'])){
// $this->dbF->prnt($_POST);
// $this->dbF->prnt($_FILES);
$title          = empty($_FILES['document']['name'])     ? ""    : $_FILES['document']['name'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$filename = pathinfo($title, PATHINFO_FILENAME);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$filename);          
$category       = str_replace($strip," " ,$category); 
}else{
if (!$this->getFormToken('addSafetyData')) {
return false;
}

$title          = empty($_POST['title'])     ? ""    : htmlspecialchars($_POST['title']);
$category       = empty($_POST['category'])  ? ""    :  $_POST['category'];
$sub_category   = empty($_POST['sub_category'])  ? ""    :  $_POST['sub_category'];
$sub_sub_category  = empty($_POST['sub_sub_category']) ? ""    : htmlspecialchars($_POST['sub_sub_category']);
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "/", "?");
$title          = str_replace($strip," " ,$title);          
$category       = str_replace($strip," " ,$category);       
$sub_category   = str_replace($strip," " ,$sub_category);           
$sub_sub_category      = str_replace($strip," " ,$sub_sub_category);      
 
}




echo $_SESSION['superUser'];

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0') {
$user = $_SESSION['superid'];
$userId = $_SESSION['superid'];
} else {
$user = $_SESSION['currentUser'];
$userId = "all:" . $_SESSION['currentUser'];
}

$filename = $this->uploadSingleFile($_FILES['document'], 'files', '');
$imageUrlChange = '';

try {
$this->db->beginTransaction();

if (isset($_POST['practiceIds']) && !empty($_POST['practiceIds']))  {
    $practiceIds = $_POST['practiceIds'];
    // var_dump($_POST['practiceIds']);
    
    // $practiceIds = explode(',',$practiceIds);
    $explodeUrl = explode('/',$filename);
    $filePath = $explodeUrl[0].'/'.$explodeUrl[1].'/'.$explodeUrl[2]; 
    foreach ($practiceIds as $key => $ids) {
             $puser = $ids;                           
             $imageUrlChange = $filePath.'/'.$user.'-'.$explodeUrl[3];
             if (strpos(WEB_URL,'AIOM')) {
                $webUrl = $_SERVER['DOCUMENT_ROOT']."/AIOM";    
             }else{
                $webUrl = $_SERVER['DOCUMENT_ROOT'];
             }                         
             $uploadedImage = $webUrl."/images/".$filename;
             $copyImage  = $webUrl."/images/".$imageUrlChange;                         
             if ($key == 0) {
                 $docname = WEB_URL."/images/".$filename;
                 $staffFile =  WEB_URL."/images/".$filename;
             }else{
                 
                 
                 // copy($uploadedImage, $copyImage);
                 file_put_contents($copyImage, file_get_contents($uploadedImage));
                 $docname =  WEB_URL."/images/".$imageUrlChange;
                 $staffFile =  WEB_URL."/images/".$imageUrlChange;
                 // return $uploadedImage.'---'.$copyImage."---".$docname;
             }
           $sql = "INSERT INTO `safetyData`(`title`, `file`, `category`,`sub_category`,`sub_sub_category`,`assignto`,`publish`)
                                    VALUES (?,?,?,?,?,?,?)";

            $array = array($title,$docname,$category,$sub_category,$sub_sub_category,$puser,'1');
            // var_dump($array);
            // exit();
            $this->dbF->setRow($sql, $array, false);
        }
         
}

if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['webUser']['id'];
}
$this->setlog("MyUploads Add", $this->UserName($user) . " : " . $user, "", $title);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
} // If end
}

public function insertGroup($apiPostData="")
{

    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (!empty($_POST['group_name'])) {
   
$sql="SELECT MAX(id) as max FROM `insertGroup`";
$data = $this->dbF->getRows($sql);
$group_id=$data[0]['max']+1;
$add_group_name         = empty($_POST['group_name'])         ? ""  : $_POST['group_name'];
// var_dump($add_group_name);
if($add_group_name[1]==""){
    $group_name=$add_group_name[0];
   
    $data=explode("::", $group_name);
    $group_name=$data[0];
    $group_id=$data[1];
}else{
    $group_name=$add_group_name[1];

}
$add_group_desc              = empty($_POST['add_group_desc'])              ? ""  : $_POST['add_group_desc'];

$practices             = $_SESSION['currentUser'];
$loginid = intval($_SESSION['webUser']['id']);


try {
$this->db->beginTransaction();
if (isset($_POST['practiceIds']) )  {
    $practiceIds = $_POST['practiceIds'];
    foreach ($practiceIds as $key => $ids) {
             $user = $ids; 

 $this->dbF->setRow("INSERT INTO `insertGroup`(`practiceID`,`group_id`,`group_name`,`users`,`desc`) VALUES('$practices','$group_id','$group_name','$user','$add_group_desc')");
}
         }
// $lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
$this->setlog("group is inserted", $this->UserName($loginid) . " : " . $this->UserName($practices),"", "Group Name : " . $group_name."Desc : " . $add_group_desc);
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} 
}
public function allGroupsIds($id)
{
    $user=$_SESSION['currentUser'];
    $data= $this->dbF->getRows("SELECT Distinct group_id FROM `insertGroup` WHERE users='$id' AND practiceID='$user'");
$temp=",";
$size= sizeof($data);
$i=1;
foreach ($data as $value) {

    if($i!=$size){
        $temp .= "'G.".$value['group_id']."'," ;
     }else{
        $temp .= "'G.".$value['group_id']."'";
     }
     $i++;
}
if($temp==","){return "";}
else{return $temp;}
    }
public function allGroups($id, $assignto = 0)
{
$sql = "SELECT DISTINCT group_id,group_name FROM `insertGroup` where practiceID='$id'";
$data = $this->dbF->getRows($sql);
$op = "";


foreach ($data as $key => $value) {

if('G.'.$value['group_id'] == $assignto){
    $op .= "<option selected value='G.$value[group_id]'>$value[group_name]</option>";
}else{
    $op .= "<option value='G.$value[group_id]'>$value[group_name]</option>";
}

}
return $op;
}
public function insertGroupEDIT($apiPostData="")
{
    if (!empty($apiPostData)) {
        $_POST = $apiPostData;
    }

if (isset($_POST['submit'])) {
if (!$this->getFormToken('insertGroupEDIT') && $apiPostData == "") {
return false;
}


$sql="SELECT MAX(id) as max FROM `insertGroup`";
$data = $this->dbF->getRows($sql);
$group_id=$data[0]['max']+1;
$add_group_name         = empty($_POST['group_name'])         ? ""  : $_POST['group_name'];
// var_dump($add_group_name);
if($add_group_name[1]==""){
    $group_name=$add_group_name[0];
   
    $data=explode("::", $group_name);
    $group_name=$data[0];
    $group_id=$data[1];
}else{
    $group_name=$add_group_name[1];

}


$changedesc      = empty($_POST['changedesc'])     ? ""    : $_POST['changedesc'];
$refId      = empty($_POST['refId'])     ? ""    : $_POST['refId'];

try {
$this->db->beginTransaction();
 
$user = $_SESSION['webUser']['id'];
  
 

$sql = "UPDATE `insertGroup` SET `group_id` = '$group_id' , `group_name` = '$group_name', `desc` = '$changedesc' WHERE `insertGroup`.`id` = '$refId'";
$this->dbF->setRow($sql);





$this->setlog("Group management data is changed", $this->UserName($user) . " : " . $user, $refId, $changename.'-'.$changedesc);
$lastId = $this->dbF->rowLastId;
$this->db->commit();
if ($this->dbF->rowCount > 0) {
return true;
} else {
return false;
}
} catch (Exception $e) {
$this->db->rollBack();
$this->dbF->error_submit($e);
return false;
}
}else{
    return false;
} // If end
}



}// tait end

?>