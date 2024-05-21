<?php
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            CPD Courses
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'cpd-dashboard'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class='course-detail row'>
            <?php
            if(isset($_GET['id'])){
                @$getID  = $_GET['id'];
                $sql  = "SELECT * FROM `subjects` WHERE `subject_id`='$getID'";
                $data = $dbF->getRow($sql);
                $sql2  = "SELECT * FROM `paper` WHERE `subject_id`='$data[subject_id]'";
                $data2 = $dbF->getRow($sql2);
                $id = base64_encode($data2['paper_id']);
                $link = "practice.php?id=$id";

                if(!empty($data['link'])){
                    $learn = "<div class='quiz_btn_back'>
                                <a href='$data[link]' target='_blank'>Start Learning</a>
                            </div>";
                }
                else{
                    $learn = '';
                }

                if(!empty($data2['paper_id'])){
                    $quiz = "<div class='quiz_btn_back'>
                                <a href='$link' target='_blank'>Start Quiz</a>
                            </div>";
                }
                else{
                    $quiz = '';
                }
                echo "<div class='col-12'>
                        <h2>$data[subject_title]</h2>
                    </div>
                    <div class='col-lg-5'>
                        <img class='rounded img-fluid' src='$data[image]' />
                    </div>
                    <div class='col-lg-7'>
                        <h4>Aim :</h4> $data2[aim]
                        <h4>Objectives :</h4> $data2[objectives]
                    </div>
                    <div class='col-12'>
                        <div class='row align-items-center'>
                            <div class='col-md-7'>
                                <h3>$data[subject_title]<span>&nbsp;&nbsp;(&nbsp;$data[minutes] minutes&nbsp;)</span></h3>
                            </div>
                            <div class='col-md-5 text-right'>
                                $learn$quiz
                            </div>
                        </div>
                    </div>";
                $sql  = "SELECT * FROM `subjects` WHERE `under`=?";
                $data = $dbF->getRows($sql,array($getID));
                if(!empty($data)){
                    echo "<div class='col-12'><hr><h5>Modules</h5></div>";
                    foreach ($data as $key => $value) {
                    $sql2  = "SELECT * FROM `paper` WHERE `subject_id`='$value[subject_id]'";
                    $data2 = $dbF->getRow($sql2);
                    $id = base64_encode($data2['paper_id']);
                    $link = "practice.php?id=$id";

                    if(!empty($value['link'])){
                    $learn = "<div class='quiz_btn_back'>
                                <a href='$value[link]' target='_blank'>Start Learning</a>
                            </div>";
                }
                else{
                    $learn = '';
                }

                if(!empty($data2['paper_id'])){
                    $quiz = "<div class='quiz_btn_back'>
                                <a href='$link' target='_blank'>Start Quiz</a>
                            </div>";
                }
                else{
                    $quiz = '';
                }
                    echo "<div class='col-12'>
                            <div class='row align-items-center'>
                            <div class='col-md-7'>
                                <h6>$value[subject_title]&nbsp;&nbsp;<span>(&nbsp;$value[minutes] minutes&nbsp;)</span></h6>
                            </div>
                            <div class='col-md-5 text-right'>
                                $learn$quiz
                            </div>
                        </div>
                    </div>";
                    }
                }

            } else {
                
                $cat  = @$_GET['Cat'];
                $sql  = "SELECT * FROM `subjects` WHERE `test_category`=? AND `under`='0' AND `publish`='1'";
                $data = $dbF->getRows($sql,array($cat));
                foreach ($data as $key => $value) {
                    $module = $dbF->getRow("SELECT COUNT(*) FROM `subjects` WHERE `under`='$value[subject_id]' AND `publish`='1'");
                    if($module[0] > 0){
                            $mod = "<span>( $module[0]&nbsp;MODULES)</span>";
                        }
                        else{
                            $mod = "";
                        }
                        echo "<div class='col-sm-6 col-lg-4'>
                                <div class='cpd-courses-box'>
                                    <img alt='' src='$value[image]' />
                                    <a href='course?id=$value[subject_id]'>
                                        $value[subject_title]$mod
                                    </a>
                                </div>
                              </div>";
                }
            }
            ?>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
</div>
<!-- index_content -->
<?php
include_once('footer.php');
?>