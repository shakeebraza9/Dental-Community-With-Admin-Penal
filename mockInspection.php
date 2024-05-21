<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Mock Inspection',false);
}



$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
$msg  = "";

include'dashboardheader.php';
?>
<div class="index_content mypage health_form">
<div class="right_side">

<div class="cardDiv">
    <div class="grid-container">
        <a href="<?= WEB_URL?>/mock_inspection">
            <div class="grid-item item1">
                <div class="imgdiv">
                    <!-- -->
                    <span class="avatar_title">
                        <img src="<?= WEB_URL?>/images/box/2023/03/977-20230318120109-0-compliance_management.png" alt="compliance management">
                    </span>
                </div>
                <h4>My Mock Inspections</h4>
            </div>
        </a>
        <a href="<?= WEB_URL?>/mock_inspection#tabs-2">
            <div class="grid-item item2">
                <div class="imgdiv">
                    <span class="avatar_title">
                        <img src="<?= WEB_URL?>/images/box/2023/03/118-20230318120120-0-cpd_courses.png" alt="CPD Courses">
                    </span>
                </div>
                <h4>My Mock Inspection Actions</h4>
            </div>
        </a>
        <a href="<?= WEB_URL?>/mock-actionplan">
            <div class="grid-item item3">
                <div class="imgdiv">
                    <span class="avatar_title">
                        <img src="<?= WEB_URL?>/images/box/2023/03/245-20230318120131-0-hr_management.png" alt="HR management">
                    </span>
                </div>
                <h4>My Mock Inspection Completed Actions</h4>
            </div>
        </a>
    </div>
</div>

</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->

<?php include_once('dashboardfooter.php'); ?>