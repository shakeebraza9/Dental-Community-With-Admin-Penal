<?php
include("global.php");
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

include("header.php");

include'dashboardheader.php'; ?>
<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            <?php echo $page ?>
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'dashboard'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="col1_btnn col1_btn33">
                    <a href="javascript:;" id="reset_notification">Stop Notification From all Device</a>
                </div>
            </div>
            <!-- right_side_top close -->
            <?php
            if($msg!=''){
            echo "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    $msg
                    </div>";
            } ?>
            <h4><div data-toggle="tooltip" title="Help Video" class="help" onclick="video('ri2JpwN5zlE')"><i class="fa fa-question-circle"></i></div><?php echo $page ?></h4>
            <?php $webClass->webUserEdit($page) ?>
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


<?php include("footer.php"); ?>