<?php
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->

        <!-- left_side close -->
        <div class="right_side">
            <div class='course-detail row'>
            <?php
            if(isset($_GET['id'])){
                @$getID  = intval($_GET['id']);
                $sql  = "SELECT * FROM `subjects` WHERE `subject_id`=?";
                $data = $dbF->getRow($sql,array($getID));
                $sql2  = "SELECT * FROM `paper` WHERE `subject_id` = ? ";
                $array = array($data['subject_id']);
                $data2 = $dbF->getRow($sql2,$array);
                $id = base64_encode(@$data2['paper_id']);
                $link = "practice.php?id=$id";
                $color = $data['color'];
                if(!empty($data['link'])){
                    if($_SESSION['userType']=='Trial')
                    {
                       $learn = "<div class='quiz_btn_back'>
                                <a href='' onclick='alertbx()'><i class='fas fa-rocket'></i>&nbsp;Start Learning</a>
                                
                            </div>"; 
                    }else{
                    $learn = "<div class='quiz_btn_back'>
                                <a href='$data[link]' target='_blank'><i class='fas fa-rocket'></i>&nbsp;Start Learning</a>
                                
                            </div>";
                }}
                
                else{
                    $learn = '';
                }

                if(!empty($data2['paper_id'])){
                    if($_SESSION['userType']=='Trial')
                    {
                        $quiz = "<div class='quiz_btn_back'>
                                <a href='' onclick='alertbx()'><i class='fas fa-comments'></i>&nbsp;Start Quiz</a>
                                
                            </div>";
                    }
                    else{
                    $quiz = "<div class='quiz_btn_back'>
                                <a href='$link' target='_blank'><i class='fas fa-comments'></i>&nbsp;Start Quiz</a>
                                
                            </div>";
                    }
                }
                else{
                    $quiz = '';
                }

               $sum = 0;
                $sql  = "SELECT * FROM `subjects` WHERE `under`=?";
                $data1 = $dbF->getRows($sql,array($getID));
                if(!empty($data1)){
                foreach ($data1 as $key => $value) {
                    $sum += $value['minutes'];
                }
                $sum += $data['minutes'];
                }
                else
                {
                     $sum = $data['minutes'];
                }
                $aim = isset($data2['aim']) ? $data2['aim'] : "";
                $objectives = isset($data2['objectives']) ? $data2['objectives'] : "";
                echo" 
                    <div class='coures-detail-left'>
                        <div class='detail_txt'>
                            <h2>$data[subject_title]</h2>
                            <h3>Verified CPD Hours<span>&nbsp;&nbsp;(&nbsp;$sum minutes&nbsp;)</span></h3>
                              
                        </div>
                    </div>
                    
                    <div class='coures-detail-right'>
                            <img class='rounded img-fluid' src='$data[image]'/>
                    </div>
                    
                   

                    <div class='coures-detail-aim'>
                            <h4>Aim :</h4> $aim
                            <br>
                            <br>
                            <h4>Objectives :</h4> $objectives
                    </div> 
                   
                     <div class='course-detail-btn'>
                       <div class='course-btn'>
                    $learn$quiz
                    </div>
                    </div>
                     <div class='coures-detail-aim'>
                           
                    </div>
                ";
                $sum = 0;
                $sql  = "SELECT * FROM `subjects` WHERE `under`=?";
                $data = $dbF->getRows($sql,array($getID));
                if(!empty($data)){
                    echo "<div class='course-detail-btn'>
                    <h5>Modules</h5>";
                    foreach ($data as $key => $value) {
                    $sql2  = "SELECT * FROM `paper` WHERE `subject_id`= ? ";
                     $array = array($data['subject_id']);
                    $data2 = $dbF->getRow($sql2,$array);
                    $id = base64_encode($data2['paper_id']);
                    $link = "practice.php?id=$id";

                    if(!empty($value['link'])){
                        if($_SESSION['userType']=='Trial')
                    {
                        $learn = "<div class='quiz_btn_back'>
                                <a href='' onclick='alertbx()' target='_blank'><i class='fas fa-rocket'></i>&nbsp;Start Learning</a>
                            </div>";
                    }
                    else{
                    $learn = "<div class='quiz_btn_back'>
                                <a href='$value[link]' target='_blank'><i class='fas fa-rocket'></i>&nbsp;Start Learning</a>
                            </div>";
                }}
                else{
                    $learn = '';
                }

                if(!empty($data2['paper_id'])){
                   
if($_SESSION['userType']=='Trial')
  {
    $quiz = "<div class='quiz_btn_back'>
                                <a href='' onclick='alertbx()' target='_blank'><i class='fas fa-comments'></i>&nbsp;Start Quiz</a>
                            </div>";
  }else{
      $quiz = "<div class='quiz_btn_back'>
                                <a href='$link' target='_blank'><i class='fas fa-comments'></i>&nbsp;Start Quiz</a>
                            </div>";
}
                    // $quiz = "<div class='quiz_btn_back'>
                    //             <a href='$link' target='_blank'><i class='fas fa-comments'></i>&nbsp;Start Quiz</a>
                    //         </div>";
                }
                else{
                    $quiz = '';
                }
                echo "<div class='course-detail-btn_left'>
                        <h6>$value[subject_title]&nbsp;&nbsp;<span>(&nbsp;$value[minutes] minutes&nbsp;)</span></h6>
                        
                        <div class='course-detail-btn_right'>
                            $learn$quiz
                        </div>
                    </div>";
                        
                    }
                }

            } else {
                
                $cat  = @$_GET['Cat'];
                $sql  = "SELECT * FROM `subjects` WHERE `test_category`= ? AND `under`='0' AND `publish`='1'";
                $data = $dbF->getRows($sql,array($cat));
                foreach ($data as $key => $value) {
                     


                 $sql = "SELECT COUNT(*) FROM `subjects` WHERE `under`= ? AND `publish`='1'";
                    $module = $dbF->getRow($sql , array($value['subject_id']));
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
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<!-- </div> -->
<!-- index_content -->
<style>
.coures-detail-left:before {
background:  <?php if (empty($color)) {echo "#01abbf";} else{echo $color; }
?>
}

.coures-detail-left{
background:  <?php if (empty($color)) {echo "#01abbf";} else{echo $color; }
?>
}

 
</style>
<?php
include_once('dashboardfooter.php');
?>