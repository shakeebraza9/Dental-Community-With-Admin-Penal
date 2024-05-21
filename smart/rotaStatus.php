<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
           Overtime Request Hours
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_"> Rota Status</h3>
            <div class="cpd-table">
                <div class="cpd-tbl">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Week</th>
                                <th>Status</th>
                                <th>Amendments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user = $_SESSION['currentUser'];
                            $sql = "SELECT * FROM `rotaStatus` WHERE `user` IN (SELECT `acc_id` FROM `accounts_user` WHERE `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1')";
                            $data = $dbF->getRows($sql);
                            foreach ($data as $key => $value) {
                            $date = date('d-M-Y',strtotime($value['week']))."&nbsp;&nbsp;to&nbsp;&nbsp;".date('d-M-Y',strtotime("$value[week] +7 day"));
                            echo "<tr>
                                    <td>".$functions->UserName($value['user'])."</td>
                                    <td>$date</td>
                                    <td>$value[status]</td>
                                    <td>$value[amendments]</td>
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
    <?php include_once('footer.php'); ?>