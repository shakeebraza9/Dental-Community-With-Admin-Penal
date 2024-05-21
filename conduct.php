<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
    header("Location: login.php");
}

include_once('header.php');

?>
    <div class="bg_inner" style="background-image: url(<?php echo WEB_URL ?>/images/box/2018/09/761-363-bg-inner.jpg);background-size: cover;">
        <div class="standard">
            <h1>Conduct</h1>
            <ul>
                <li><a href="#">Home</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="#" class="inner_active">Conduct</a></li>
            </ul>
        </div>
    </div>
    <!-- bg_inner -->
    <div class="quiz">
        <div class="standard">
            <?php
            $id = base64_decode($_GET['id']);
            echo $webClass->get_conduct_text($id);
            ?>
                <div class="quiz_btn">
                    <div class="quiz_btn_back">
                        <a href="<?php echo " practice.php?id=$_GET[id] ";?>">Next</a>
                    </div>
                    <!-- quiz_btn_back close -->
                </div>
                <!-- quiz_btn -->
        </div>
        <!-- standard -->
    </div>
    <!-- quiz -->

<?php include_once('footer.php'); ?>