<?php
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
    header('Location: login');
}

// include_once('header.php'); 


include'dashboardheader.php'; 
$functions->pin();
?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side">
            <div class="row justify-content-center">
                <?php
                $user = $_SESSION['currentUser'];
                if($_SESSION['currentUserType'] == 'Master'){
                    $sql = "SELECT `setting_val` AS `user` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$user'";
                    $data = $dbF->getRow($sql);
                    $datas = explode(",","$user,".$data[0]);
                }
                else{
                    $sql = "SELECT * FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`=(SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `setting_val` LIKE '%$user%' AND `id_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE setting_val='Master'))";
                    $data = $dbF->getRow($sql);
                    $datas = explode(",",$data['id_user'].",".$data['setting_val']);
                }
                foreach ($datas as $val) {
                    $sql = "SELECT `userId`,`date` FROM `record` WHERE `rotaOff`!='' AND `userId` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$val' AND `setting_name`='account_under' AND `id_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='Dentist')) AND `date` BETWEEN LAST_DAY(CURRENT_DATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH AND LAST_DAY(CURRENT_DATE())";
                    $data = $dbF->getRows($sql);
                    $x = 0;
                        foreach ($data as $key => $value) {
                            $data1 = $dbF->getRow("SELECT `userId` FROM `record` WHERE `date`='$value[date]' AND `dentist_id`='$value[userId]'");
                            $data2 =  $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$data1[userId]' AND setting_name='role'");
                            $role = $data2[0];
                            $date = date('d-M-Y',strtotime($value['date']));
                            if($role == 'Dental Nurse' || $role == 'Trainee Nurse'){
                                $pid = $functions->PracticeId($data1['userId']);
                                $pname = $functions->UserName($pid);
                                $d = $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_type' AND `id_user`='$pid'");
                                $prole = $d[0];
                                if($x == '0'){
                                    echo "<div class='col-md-12 h66'>$pname ($prole)</div>";
                                    $x++;
                                }
                                $name = $functions->UserName($data1['userId']);
                                $image = $functions->UserImage($data1['userId']);  
                                echo "<div class='col-md-3'>
                                        <div class='user-box'>
                                            <img src='images/$image' alt=''>
                                            <h5>$name</h5>
                                            <h6>$role</h6>
                                            <h6>$date</h6>
                                        </div>
                                    </div>";
                            }
                        }
                }
                ?>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<!-- </div> -->
<!-- index_content -->
<?php include_once('dashboardfooter.php'); ?>