<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}

$msg  = "";
$chk  = ratingQuestion();
if($chk){
$msg = "Question Added Successfully";
}
include_once('header.php'); 

include'dashboardheader.php';


if(isset($_GET['do']) && $_GET['do']=='deleteQuestion'){
?>

<?php
$id=(int)$_GET['id'];

$sql = "DELETE FROM `ratingQuestion` WHERE id= '?'";
$dbF->setRow($sql,array($id));
header('Location: rating');


}



function getFormToken($TokenName,$autoCheckRecommended=true,$echo = true){
if(isset($_SESSION['tokens'][$TokenName.'Token'])){
$Token = $_SESSION['tokens'][$TokenName.'Token'];

if($autoCheckRecommended){
if(isset($_POST[$TokenName.'Token']) && $_POST[$TokenName.'Token']==$Token){
$_SESSION['tokens'][$TokenName.'Token'] = 'Dismiss';
unset($_SESSION['tokens'][$TokenName.'Token']);
return true;
}else{
return false;
}
}
//If auto false;
if($echo){echo $Token;}
else{
return $Token;
}
}else{
return false;
}
}

function ratingQuestion(){
global $db,$dbF;
if(isset($_POST['submit'])){
if(!getFormToken('ratingQuestion')){return false;}



$ques = empty($_POST['ques']) ? ""  : $_POST['ques'];
$qc = empty($_POST['qc']) ? ""  : $_POST['qc'];
$t0 = empty($_POST['t0']) ? ""  : $_POST['t0'];
$t1 = empty($_POST['t1']) ? ""  : $_POST['t1'];
$pid = $_SESSION['webUser']['id'];
try{
$db->beginTransaction();
$sql  = "INSERT INTO `ratingQuestion`(`pId`,`title`,`t0`,`t1`,`qc`) VALUES ('$pid','$ques','$t0','$t1','$qc')";
$dbF->setRow($sql);
$lastId = $dbF->rowLastId;
$db->commit();
if($dbF->rowCount>0){
return true;
}else{
return false;
}
}catch (Exception $e){
$db->rollBack();
$dbF->error_submit($e);
return false;
}
} // If end
}



?>
<div class="index_content mypage health_form">
<div class="left_right_side">
<div class="link_menu">
<span>
<img src="webImages/menu.png" alt="">
</span>
DashBoard
</div>
<!--link_menu close-->
<div class="left_side">
<?php $active = 'rating'; include'dashboardmenu.php';?>
</div>
<!-- left_side close -->
<div class="right_side">
<div class="right_side_top">


<h4>Questionnaire</h4>
</div>
<!-- right_side_top close -->
<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>
<form class="profile" method="post" action="rating" enctype="multipart/form-data">
<?php echo $functions->setFormToken('ratingQuestion',false); ?>
<div class="row">




<?php
$user = $_SESSION['webUser']['id'];
$sql = "SELECT * FROM `ratingQuestion` WHERE `pId` = ? ";
$row = $dbF->getRows($sql,array($user));
if(empty($row)){
// $sql  = "INSERT INTO `practiceprofile`(`user_id`,`practice_name`, `practice_address`, `telephone`, `staff`, `information`, `surgeries`, `room`, `autoclave`, `disinfectors`, `ultrasonic`, `compressor`, `npm`, `sedation`, `domiciliary`, `practice_logo`, `team_image`) VALUES ('$user','','','','','','','','','','','','','','','#','#')";
// $dbF->setRow($sql);
}else{
foreach ($row as $key => $value) {
# code...

?>
<div class="form-group col-6">






<?php echo $value['title'] ?>

<?php echo '

<a href="#" onclick="con4m('."'".'rating.php?do=deleteQuestion&id='.$value['id'].''."'".','."'".'Are you sure you want to Delete?'."'".')"><i class="fas fa-trash"></i></a>



'; ?>

<br>
</div>
<!-- form-group -->


<?php 
}
}
?>
<br>
<hr>

<div class="form-group col-6">
<label>New Question :</label>
<i class="fas fa-add"></i>
<input type="text" name="ques" value="">
</div>
<!-- form-group -->

<div class="form-group col-6">
<label>Question Caption:</label>
<i class="fas fa-add"></i>
<input type="text" name="qc" value="">
</div>
<!-- form-group -->

<div class="form-group col-6">
<label>Text 1 :</label>
<i class="fas fa-add"></i>
<input type="text" name="t0" value="">
</div>
<!-- form-group -->




<div class="form-group col-6">
<label>Text 2 :</label>
<i class="fas fa-add"></i>
<input type="text" name="t1" value="">
</div>
<!-- form-group -->




<br>
<hr>
<input type="submit" class="submit_class" value="Submit Question" name="submit">
</div>
</form>
</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->
</div>
<!-- index_content -->
<?php include_once('footer.php'); ?>