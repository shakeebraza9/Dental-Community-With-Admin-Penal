<?php include("global.php");
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$sql    = "SELECT * FROM `documents` where assignto ='all'";
$userData   =   $dbF->getRows($sql);
foreach($userData as $val){
$username    = "smarthealthcompl_USER";
$password    = 'N5d%t[0onVK2';
$dbname    = 'smarthealthcompl_DBMS';
$servername  = "localhost";
try {
// $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $sqls = "INSERT INTO eventmanagement(`id`, `title`, `due_date`, `recurring_duration`, `recurrence`, `file`, `assignto`, `category`,`type`, `radio`, `desc`, `publish`, `dateTime`) 
//   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
// $stmt = $conn->prepare($sqls);
// $stmt->execute(array($val["id"], $val["title"], $val["due_date"], $val["recurring_duration"], $val["recurrence"], $val["file"], $val["assignto"], $val["category"],$val["type"], $val["radio"], $val["desc"], $val["publish"], $val["dateTime"]));
// $sqlcc    = "SELECT * FROM `eventForms` where title_id ='$val[id]'";
// $userDataccc   =   $dbF->getRows($sqlcc);
// foreach($userDataccc as $valccc){
// $sqls = "INSERT INTO eventForms(`title_id`, `question`, `category`, `radio`, `date`, `time`, `field1`,`field2`, `publish`, `dateTime`) 
//   VALUES (?,?,?,?,?,?,?,?,?,?)";
// $stmt = $conn->prepare($sqls);
// $stmt->execute(array($valccc["title_id"], $valccc["question"], $valccc["category"], $valccc["radio"], $valccc["date"], $valccc["time"], $valccc["field1"],$valccc["field2"], $valccc["publish"], $valccc["dateTime"]));
// }



$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqls = "INSERT INTO documents(`id`, `title`, `file`, `assignto`, `category`, `sub_dcategory`, `expiry`, `publish`,`dateTime`) 
  VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sqls);
$stmt->execute(array($val["id"], $val["title"], $val["file"], $val["assignto"], $val["category"], $val["sub_dcategory"], $val["expiry"], $val["publish"],$val["dateTime"]));







} catch(PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}
$conn = null;
}
?>