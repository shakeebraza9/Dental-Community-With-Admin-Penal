<?php 
include_once("global.php");
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}

$msg  = "";
$chk  = questionInstance();
if($chk){
$msg = "Instance Added Successfully";
}



$msg1  = "";
$chk1  = ratingQuestion();
if($chk1){
$msg1 = "Question Added Successfully";
}





include_once('header.php'); 

include'dashboardheader.php';

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




function acc_name($acc_name){
global $db,$dbF;
$sql = "SELECT acc_name FROM accounts_user where acc_id = '$acc_name'";
$data = $dbF->getRow($sql); 
return $data['acc_name'];

}

if(isset($_GET['do']) && $_GET['do']=='deleteQuestion'){
?>
<?php
$id=(int)$_GET['id'];

$sql = "DELETE FROM `ratingQuestion` WHERE id= ? ";
$dbF->setRow($sql,array($id));
header('Location: rating');


}





function ratingQuestion(){
global $db,$dbF;
if(isset($_POST['submit']) && isset($_POST['ques']) && empty($_POST['title']) ){
if(!getFormToken('ratingQuestion')){return false;}



$ques = empty($_POST['ques']) ? ""  : $_POST['ques'];
$qc = empty($_POST['qc']) ? ""  : $_POST['qc'];
$t0 = empty($_POST['t0']) ? ""  : $_POST['t0'];
$t1 = empty($_POST['t1']) ? ""  : $_POST['t1'];
$pid = $_SESSION['webUser']['id'];


try{
$db->beginTransaction();

$sql  = "INSERT INTO `ratingQuestion`(`pId`,`title`,`t0`,`t1`,`qc`) VALUES (?,?,?,?,?)";
$dbF->setRow($sql,array($pid,$ques,$t0,$t1,$qc));
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

function questionInstance(){
global $db,$dbF,$functions;
if(isset($_POST['submit']) && isset($_POST['title'])){
if(!getFormToken('questionInstance')){return false;}
$today  = date('Y-m-d');
// $pid    = empty($_POST['pid'])    ? ""  : $_POST['pid'];
$title = empty($_POST['title']) ? ""  : $_POST['title'];

$user = intval($_SESSION['webUser']['id']);

 htmlspecialchars($title);





try{
$db->beginTransaction();



$sql  = "INSERT INTO `questionInstance`(`pId`,`dateIs`,title) VALUES (?,?,?)";
$arrayName = array($user,$today,$title);
$dbF->setRow($sql,$arrayName);
$lastId = $dbF->rowLastId;


$sql = "SELECT id_user FROM `accounts_user_detail` WHERE `setting_name` = 'account_under' and `setting_val` = ? ";
$row = $dbF->getRows($sql,array($user));
if(!empty($row)){

foreach ($row as $key => $value) {


$sqli = "SELECT id FROM `ratingQuestion` WHERE `pId` =   ? ";
$rowi = $dbF->getRows($sqli,array($user));
if(!empty($rowi)){
foreach ($rowi as $key => $valuei) {
        intval($valuei['id']);
        intval($value['id_user']);
        intval($user);
$sqlz  = "INSERT INTO `ratingAnswer`(iId,qId,eId,emp_rating_id) VALUES (?,?,?,?)";
$arrayNamez11 = array($lastId,$valuei['id'],$value['id_user'],$user);
$dbF->setRow($sqlz,$arrayNamez11);
}
}

$functions->push_notification('Performance Review','You have been set up to fill a Peer Review on your colleague.',$functions->getUserPlayerId($value['id_user']));
$to = $functions->UserEmail($value['id_user']);
$functions->send_mail($to,'','','review');

}
}




$sq2 = "SELECT id_user FROM `accounts_user_detail` WHERE `setting_name` = 'account_under' and `setting_val` = ";
$row2 = $dbF->getRows($sq2);
if(!empty($row2)){

foreach ($row2 as $key => $val2) {


$sql11 = "SELECT id_user FROM `accounts_user_detail` WHERE `setting_name` = 'account_under' and `setting_val` = '$user' and id_user != $val2[id_user]";
$row11 = $dbF->getRows($sql11);

foreach ($row11 as $key => $valc) {
$dd = "SELECT id FROM `ratingQuestion` WHERE `pId` =  ? ";
$vv = $dbF->getRows($dd,array($user));
if(!empty($vv)){
foreach ($vv as $key => $valuei) {
        intval($valuei['id']);
        intval($val2['id_user']);
        intval($valc['id_user']);
$sqlz  = "INSERT INTO `ratingAnswer`(iId,qId,eId,emp_rating_id) VALUES (?,?,?,?)";
$arrayNamez = array($lastId,$valuei['id'],$val2['id_user'],$valc['id_user']);
$dbF->setRow($sqlz,$arrayNamez);
}
}






}
}




}


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




// }



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
            <?php $active = 'addRating'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <h4>Staff Performance</h4>
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <?php if($msg1!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg1; ?>
            </div>
            <?php } ?>
            <div class="row">
            <div class="col-lg-6">
                <form class="profile" method="post" action="instance" enctype="multipart/form-data">
                	<h3>Performance Review</h3>
                    <?php echo $functions->setFormToken('questionInstance',false); ?>
                        <?php
$user = $_SESSION['webUser']['id'];
$sql = "SELECT * FROM `questionInstance` WHERE `pId` =? ";
$row = $dbF->getRows($sql,array($user));
if(empty($row)){
echo "No Data Found";
}else{?>
                            <table class="table table-hover">
                                <tr>
                                    <th>Date</th>
                                    <th>Name of Review</th>
                                    <th>Action</th>
                                </tr>
                                <?php
foreach ($row as $key => $value) {
$date     = date('Y-M-d',strtotime($value['dateIs']));
$view = base64_encode($value['id']);







?>
                                <tr>
                                    <td>
                                        <?php echo ($date); ?>
                                    </td>
                                    <td>
                                        <?php echo $value['title'];?>
                                    </td>
                                    <td><a href="<?php echo WEB_URL."/result?p=".$view ?>"><i class="fas fa-chart-area"></i>&nbsp;Result</a> &nbsp;<!--<a href="<?php //echo WEB_URL."/view?p=".$view ?>"><i class="fas fa-eye"></i>&nbsp;View</a>--> </td>
                                </tr>
                                <?php }
?>
                            </table>
                        
                        <?php } ?>
                        <hr style="margin: 20px 0;">
                        <div class="row">
                        <div class="form-group col-6">
                            <label>Name of Review :</label>
                            <input type="text" name="title" value="">
                        </div>
                        <!-- form-group -->
                        <div class="form-group col-6">
                        	<label>&nbsp;</label>
                            <input style="margin-top: 0" type="submit" class="submit_class" value="Create Review Form" name="submit">
                        </div>
                        <!-- form-group -->
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <form class="profile" method="post" action="instance" enctype="multipart/form-data">
                	<h3>Questions</h3>
                    <?php echo $functions->setFormToken('ratingQuestion',false); ?>
                    <div class="row">
                        <?php
$user = $_SESSION['webUser']['id'];
$sql = "SELECT * FROM `ratingQuestion` WHERE `pId` = ?";
$row = $dbF->getRows($sql,array($user));
if(empty($row)){
// $sql  = "INSERT INTO `practiceprofile`(`user_id`,`practice_name`, `practice_address`, `telephone`, `staff`, `information`, `surgeries`, `room`, `autoclave`, `disinfectors`, `ultrasonic`, `compressor`, `npm`, `sedation`, `domiciliary`, `practice_logo`, `team_image`) VALUES ('$user','','','','','','','','','','','','','','','#','#')";
// $dbF->setRow($sql);
}else{
foreach ($row as $key => $value) {
# code...

?>
                        <div class="ratingquesting col-12">
                        	<div class="ratingnumb">
                            <?php echo ($key+1) ?>.
                            </div>
                            <?php echo $value['title'] ?>
                            <?php echo '
<a href="#" onclick="con4me('."'".'rating.php?do=deleteQuestion&id='.$value['id'].''."'".','."'".'Are you sure you want to Delete?'."'".')"><i class="fas fa-trash"></i></a>
'; ?>
                        </div>
                        <!-- form-group -->
                        <?php 
}
}
?>
                        <hr style="margin: 20px 0;">
                        <div class="col-12">
                        	<div class="row">
                        <div class="form-group col-12">
                            <label>Create Review Question :</label>
                            <input type="text" name="ques" value="">
                        </div>
                        <!-- form-group -->
                        <div class="form-group col-md-4">
                            <label>Question Caption:</label>
                            <input type="text" name="qc" value="">
                        </div>
                        <!-- form-group -->
                        <div class="form-group col-md-4">
                            <label>Very Bad :</label>
                            <input type="text" name="t0" value="">
                        </div>
                        <!-- form-group -->
                        <div class="form-group col-md-4">
                            <label>Excellent :</label>
                            <input type="text" name="t1" value="">
                        </div>
                        <!-- form-group -->
                    	</div>
                    	<input type="submit" class="submit_class" value="Add New Question" name="submit">
                    	</div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
</div>
<!-- index_content -->
<?php include_once('footer.php'); ?>
<script type="text/javascript">
function con4me(rdir, msg) {

    // console.log("asddddddddddddddd");
    var go_on_link = confirm(msg);
    if (go_on_link == true) {
        location.replace(rdir);
    }
}
</script>