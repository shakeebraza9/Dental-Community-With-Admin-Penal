<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$msg = "";
$chk = $functions->submitrecruitment();
if($chk){
    $msg = "File Submit Successfully";
}
if(isset($_GET['id'])){
    $chk = $functions->deleterecruitment();
    if($chk){
    $msg = "File Delete Successfully";
    }
}
include'dashboardheader.php'; ?>
<div class="index_content mypage resources">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Personal Documents
        </div>
        <!--link_menu close -->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                ?>
                <div class="col1_btnn col1_btn22">
                    <a href="javascript:;" onclick="recruitment()">Add File</a>
                </div>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="sub-head">Personal Documetns</div>
            <div class="resources_search">
                <select id="optn" class="optn">
                    <?php echo $functions->recruitmentName($_SESSION['currentUser']) ?>
                </select>
                <input type="text" placeholder="Keywords" id="kywd" class="optn">
                <button type="submit" id="resources_search"><i class='fas fa-search'></i></button>
            </div>
            <!-- resources_search -->
            <div class="mr">
                <?php //$functions->recruitment($_SESSION['currentUser']) ?>
                <?php $functions->recruitment($_SESSION['webUser']['id']) ?>
            </div>
            <!-- mr -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<?php include_once('footer.php'); ?>