<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg  = "";
$chk  = $functions->CPD_PDP();
if($chk){
    $msg = "PDP Submit Successfully";
}
include_once('header.php'); 

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            CPD Activity
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'cpd-dashboard'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
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
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="cpd-table">
                <h3>Personal Development Plans</h3>
                <form method="post">
                    <?php echo $functions->setFormToken('cpd-pdp',false); ?>
                    <div class="cpd-tbl">
                        <table>
                            <thead>
                                <tr>
                                    <th>Why do I need to learn or maintain for this cycle?</th>
                                    <th>How does this relate to my field of practice?</th>
                                    <th>Which development outcome does it link to?</th>
                                    <th>What benefit will this have to my work?</th>
                                    <th>How will I meet this learning or maintenace need?</th>
                                    <th>When will I complete the activity?</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($_SESSION['currentUserType'] == 'Employee'){
                                   /// $user = $_SESSION['webUser']['id'];
                                    $user = $_SESSION['superid'];
                                }
                                else{
                                    $user = $_SESSION['currentUser'];
                                }
                                $sql = "SELECT * FROM `cpd_pdp` WHERE `user`='$user'";
                                $data = $dbF->getRows($sql);
                                foreach ($data as $key => $value) {
                                    echo "<tr>
                                            <td>$value[cycle]</td>
                                            <td>$value[practice]</td>
                                            <td>$value[outcome]</td>
                                            <td>$value[benefit]</td>
                                            <td>$value[maintenace]</td>
                                            <td>$value[activity]</td>
                                            <td><button class='del-btn' type='button' id='$value[id]' onclick='deletePDP(this.id)'><i class='far fa-trash-alt'></i></button></td>
                                          </tr>";
                                }
                                ?>
                                <tr>
                                    <td><textarea name="cycle"></textarea></td>
                                    <td><textarea name="practice"></textarea></td>
                                    <td><textarea name="outcome"></textarea></td>
                                    <td><textarea name="benefit"></textarea></td>
                                    <td><textarea name="maintenace"></textarea></td>
                                    <td><textarea name="activity"></textarea></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- cpd-tbl -->
                    <button type='submit' name="submit" class='submit_class'>Save</button>
                </form>
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
    function deletePDP(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
                type: 'post',
                data: {id:id},
                url: 'ajax_call.php?page=deletePDP',                
            }).done(function(data) {
                if (data == '1') {
                    $('#'+id).parents('tr').hide('slow');
                }
            });
        }
    }
    </script>
    <?php include_once('footer.php'); ?>