<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php');

$msg = "";







include'dashboardheader.php'; ?>
<div class="index_content mypage resources">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="<?= WEB_URL?>/webImages/menu.png" alt="">
            </span>
           Action Plan
        </div>
        <!--link_menu close -->
       
        <!-- left_side close -->
        <div class="right_side">
           
            <!-- right_side_top close -->
         
               <?php echo $functions->actionplanShowCompleted() ?>
                           
        </div>
        <!-- right_side close -->
    </div>
    
    <!-- left_right_side -->
<?php include_once('dashboardfooter.php'); ?>