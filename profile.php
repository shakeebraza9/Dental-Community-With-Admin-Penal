<?php
include("global.php");
error_reporting(E_ALL);
ini_set('display_errors', 0);

global $webClass;

if($seo['title']==''){
$seo['title'] = 'User Profile';
}

$page = htmlspecialchars($_GET['page']);

$login = $webClass->userLoginCheck();

if(!$login){
header('Location: login');
exit();
}

$msg = $webClass->webUserEditSubmit();

// echo $_POST['checkout_email'];

// include("header.php");

include'dashboardheader.php'; ?>
<div class="index_content mypage health_form">
    <?php
            if($msg!=''){
            echo "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    $msg
                    </div>";
            } ?>
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
           fghfgh
        </div>
        <!--link_menu close-->
        <!-- <div class="left_side">
            <?php //$active = 'dashboard'; include'dashboardmenu.php';?>
        </div> -->
        <!-- left_side close -->
        <div class="right_side profile">
            <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <!-- <h3 class="main-heading_">Profile</h3>
            <div class="right_side_top">
                <div class="col1_btnn col1_btn33">
                    <a href="javascript:;" id="reset_notification">Stop Notification From all Device</a>
                </div>
            </div> -->
            <!-- right_side_top close -->
            
            <!-- <h4><div data-toggle="tooltip" title="Help Video" class="help" onclick="video('ri2JpwN5zlE')"><i class="fa fa-question-circle"></i></div></h4> -->
            <?php $webClass->webUserEdit($page) ?>
        </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
    function removethis(playId)
{
    $('.removeitem'+playId).remove();
}


         function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
 

</script>


<?php include("dashboardfooter.php"); ?>