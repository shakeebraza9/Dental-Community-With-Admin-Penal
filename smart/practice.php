<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
    header("Location: login.php");
}
$box19 = $webClass->getBox("box19"); 
$bannerImg = $box19['image'];
$subHeading = 'Practice Quiz';
include_once('header.php'); 

$id = base64_decode($_GET['id']);
?>
<?php include'dashboardheader.php'; ?>
<div class="index_content">
    <div class="left_side">
            <?php $active = 'dashboard'; include'dashboardmenu.php';?>
        </div><
    <div class="quiz">
        <div class="standard">
            <div class="heading_col">
                <h3>Practice Quiz</h3>
            </div>
            <!-- heading_col close -->
            <p>
                This is a short Practice quiz for you to take to help familiarize yourself with how to select the questions and their respective answers along with the given options. Your Practice quiz will begin on the next screen.
            </p>
            <div class="quiz_btn">
                <div class="quiz_btn_back">
                    <a href="<?php echo WEB_URL.'/mock-test.php?id='.$_GET['id']; ?>">Next</a>
                </div>
                <!-- quiz_btn_back close -->
            </div>
            <!-- quiz_btn -->
        </div>
        <!-- standard -->
    </div>
    <!-- quiz -->
<style>
    .inner_banner{
        height: 300px;
    }
    @media only screen and (max-width:768px){
        .col1_btn_main{
            display: none !important;
        }
    }
</style>

    <?php include_once('footer.php'); ?>