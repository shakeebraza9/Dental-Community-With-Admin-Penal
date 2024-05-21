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
$msg = "Staff Feedback Added Successfully";
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
$sql = "SELECT acc_name FROM accounts_user where acc_id = ?";
$array = array($acc_name);
$data = $dbF->getRow($sql,$array); 
return $data['acc_name'];

}




 function ratingQuestion(){
global $db,$dbF;
if(isset($_POST['submit'])){
if(!getFormToken('ratingQuestion')){return false;}
try{
$db->beginTransaction();


$user = $_SESSION['currentUser'];
$sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = ?";
$array = array($user);
$row = $dbF->getRows($sql,$array);
if(empty($row)){


}else{
foreach ($row as $key => $value) {

// $sqli = "SELECT * FROM `ratingQuestion` WHERE `id` = '$value[qId]'";
// $rowi = $dbF->getRow($sqli);
$sid= $value['id'];
intval($sid);
$sidx= "txt".$sid;

$x = @$_POST[$sidx];

// var_dump($x);
if ($x === null) {
    # code...
}else{
$sql = "UPDATE `ratingAnswer` SET
answer = '$x'
WHERE `id`= ?";
$dbF->setRow($sql,array($sid));



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
} // If end
}



?>
<div class="index_content mypage health_form addrating">
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
                <h4>Staff Feedback</h4>
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <form class="profile" method="post" action="addRating" enctype="multipart/form-data">
                <?php echo $functions->setFormToken('ratingQuestion',false); ?>
                <?php
$user = $_SESSION['currentUser'];
$sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = ? and answer = ? ";
$array = array($user,'');
$row = $dbF->getRows($sql,$array);



if(empty($row)){
  echo "No Data Found!";
}else{

$sqlv = "SELECT DISTINCT eId FROM `ratingAnswer` WHERE `emp_rating_id` = ? and answer = ? ";
$array = array($user,"");
$getRow = $dbF->getRows($sqlv,$array);
foreach ($getRow as $key => $value) {

?>
                <h3>
                    <?php echo acc_name($value['eId']); ?>
                </h3>
                <div class="row">
                    <?php


$sql = "SELECT * FROM `ratingAnswer` WHERE `emp_rating_id` = ? and answer = ? and eId = ? ";
$array = array($user,'',$value['eId']);
$row = $dbF->getRows($sql,$array);

foreach ($row as $key => $value) {


$sqli = "SELECT * FROM `ratingQuestion` WHERE `id` = ? ";
$array = array($value['qId']);
$rowi = $dbF->getRow($sqli,$array);


?>
                    <div class="ratingquesting-main col-lg-6">
                        <div class="ratingquesting">
                            <div class="ratingnumb">
                                <?php echo ($key+1) ?>.
                            </div>
                            <?php echo $rowi['title'] ?> :
                            <!--<?php echo ucwords($rowi['title']) ?> :-->
                        </div>
                        <input name="txt<?php echo $value['id'] ?>" type="range" min="1" max="10" value="1" class="ratingslider">
                        <div class="col-12">
                            <div class="ratingslidernumb">0</div>
                            <div class="ratingtxt float-left">
                                <?php echo $rowi['t0'] ?>
                            </div>
                            <div class="ratingtxt float-right">
                                <?php echo $rowi['t1'] ?>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php
}
echo "</div><hr>";
} 
} ?>
                    <input type="submit" class="submit_class" value="Submit Question" name="submit">
            </form>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
</div>
<!-- index_content -->
<style>

</style>
<script>
$(".ratingslider").on('change', function() {
    val = $(this).val();
    $(this).next('div').find('.ratingslidernumb').text(val);
});
</script>
<?php include_once('footer.php'); ?>