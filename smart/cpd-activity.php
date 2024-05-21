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
            
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'cpd-dashboard'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_">CPD Activity</h3>
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    $functions->changeSession();
                    $data = $functions->health_check($_SESSION['currentUser']);
                    ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <div class="cpd-table">
                <div class="cpd-tbl">
                <table>
                    <thead>
                        <tr>
                            <th>Date Course Completed</th>
                            <th>Number of Hours</th>
                            <th>Courses Title</th>
                            <th>GDC Learning Outcomes</th>
                            <th>How did this activity benefit my daily work?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($_SESSION['currentUserType'] == 'Employee'){
                          // $user = $_SESSION['webUser']['id'];
                           $user = $_SESSION['superid'];
                        }
                        else{
                            $user = $_SESSION['currentUser'];
                        }
                        $sql = "SELECT * FROM `assigned_paper` JOIN `paper` ON `paper`.`paper_id` = `assigned_paper`.`assign_paper` WHERE `status`='1' AND `result`='completed' AND `assign_user`='$user'";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
                            $d = $dbF->getRow("SELECT `subject_title` FROM `subjects` WHERE `subject_id`='$value[subject_id]'");
                            $title = $d[0];
                            $c_date = date("d-M-Y",strtotime($value['completion_date']));
                            $hours = round(($value['minutes']/60),2);
                            $gdc = $value['development_outcomes'];
                            $ab = $value['activity_benefit'];
                            echo "<tr>
                                    <td>$c_date</td>
                                    <td>$hours</td>
                                    <td>$title</td>
                                    <td>$gdc</td>
                                    <td><textarea>$ab</textarea><div>$ab</div>
                                    <button type='submit' class='ab_submit submit_class'>Save</button><input type='hidden' value='$value[assign_id]'></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
        $(".ab_submit").on('click', function() {
            txt = $(this).prev('div').prev('textarea').val();
            $(this).prev('div').text(txt);
            id = $(this).next('input').val();
            $.ajax({
                type: 'post',
                data: {txt:txt,id:id},
                url: 'ajax_call.php?page=activity_benefit',                
            }).done(function(data) {
                if (data == '1') {
                    $('input[value='+id+']').prev('button').html('Save&nbsp;&nbsp;<i class="far fa-check-circle"></i>');
                }
                else{
                    $('input[value='+id+']').prev('button').html('Save&nbsp;&nbsp;<i class="fas fa-times"></i>');
                }
            });
        });
    </script>
    <?php include_once('footer.php'); ?>