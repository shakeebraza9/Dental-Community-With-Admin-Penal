<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

?>
<?php include("./global.php");

global $webClass;
global $productClass;
$msg = '';

$true = true;
if(isset($_GET['set']) && !empty($_GET['set'])){
    unset($_SESSION['practiceUser']);
    unset($_SESSION['superUser']);
    unset($_SESSION['currentUserType']);
    unset($_SESSION['allUsers']);
    unset($_SESSION['currentUser']);
    unset($_SESSION['superid']);
    unset($_SESSION['webUser']);
    unset($_SESSION['setLogin']);

    $setLink = base64_decode($_GET['set']);
    $setExpl = explode('--', $setLink);
    $_POST['email'] = $setExpl[0];
    $_POST['pass']  = $setExpl[1];
    setcookie('again', 'true', time() + (3600*2), "/");
    $_SESSION['setLogin']     = $_GET['set'];
    $_POST['signInUserToken'] = $functions->setFormTokenReturn('signInUser');
    $true = false;
}


$loginReturn = $webClass->userLogin();

if($loginReturn===true){
    $_SESSION['superUser'] = array();
    $_SESSION['currentUserType'] = $_SESSION['webUser']['account_type'];
    $_SESSION['allUsers']        = $_SESSION['webUser']['id'];
    $_SESSION['currentUser']     = $_SESSION['webUser']['id'];
    
    
    $userId     = $_SESSION['webUser']['id'];
    
    $sqlOrder  = $dbF->getRow("SELECT product_id FROM `orders` WHERE `order_user`='$userId' AND  order_mandate != '' Order by order_id desc limit 1");
    $_SESSION['productid']= $sqlOrder[0];
    
    
    $userData = $dbF->getRow("SELECT tableA.`setting_val` AS userType , tableB.`setting_val` AS expiryDate FROM `accounts_user_detail` AS tableA , `accounts_user_detail` AS tableB WHERE tableA.`setting_name`='user_type' AND tableB.`setting_name`='date_of_expiry' AND tableA.`id_user`= '$userId'  AND tableB.`id_user` = '$userId' ");
    $userType = $userData['userType'];    
    $expiryDate = $userData['expiryDate'];    
    $_SESSION['userType'] = $userData['userType']; 
    if ($_SESSION['userType'] == "Trial" && $expiryDate<=date("Y-m-d")) {
        
        header("Location: ".WEB_URL."/logout");
        return false;
    }
    if($_SESSION['currentUserType'] == 'Employee'){
        $_SESSION['superid']     = $_SESSION['webUser']['id'];
        $data = $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_under' AND `id_user`='$_SESSION[allUsers]'");
        $_SESSION['currentUser'] = $data[0];

     //   $data = $dbF->getRows("SELECT * FROM `superUser` WHERE `user`='$_SESSION[allUsers]' AND user = (SELECT `id_user`  FROM  `accounts_user_detail`  WHERE `id_user` ='$_SESSION[allUsers]' AND `setting_name`= 'superuser' AND `setting_val` = 'on' ) ");
        $data = $dbF->getRows("SELECT * FROM `superUser` WHERE `user`='$_SESSION[allUsers]' AND user = (SELECT `id_user`  FROM  `accounts_user_detail`  WHERE `id_user` ='$_SESSION[allUsers]' AND `setting_name`= 'superuser' AND `setting_val` = 'on' ) ");
        if(empty($data)){
            $_SESSION['superUser']['cdashboard'] = '0';
            $_SESSION['superUser']['ccalendar'] = '0';
            $_SESSION['superUser']['health_form'] = '0';
            $_SESSION['superUser']['myuploads'] = '0';
            $_SESSION['superUser']['hrrota'] = '0';
            $_SESSION['superUser']['hrdashboard'] = '0';
            $_SESSION['superUser']['hruser'] = '0';
            $_SESSION['superUser']['hrreports'] = '0';
            $_SESSION['superUser']['hrqr'] = '0';
        }
        foreach ($data as $key => $value) {
            $_SESSION['superUser'][$value['type']] = $value['allow'];
        }
    }
        $_SESSION['webUser']['backup_Practice_id']   = $_SESSION['currentUser'];
    if($true){
        $dbF->setRow("UPDATE `accounts_user` SET `last_login`= CURRENT_TIMESTAMP WHERE `acc_id`='$_SESSION[allUsers]'");
    }
    $sQl = "SELECT `onbording` FROM `accounts_user` WHERE `acc_type`= ? AND `acc_id`= ? ";
    $data = $dbF->getRow($sQl,array(1,$userId));
    if ($data['onbording'] < 7 && ($_SESSION['currentUserType'] == 'Employee' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master')){
        
        $data2 = $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='practice name' AND `id_user`='$userId'");
        $_SESSION['practiceName'] = $data2[0];
        if ($_SESSION['currentUserType'] == 'Employee') {
            $_SESSION['onbordingStatus'] = $data['onbording'];
            // header("Location: ".WEB_URL."/onboarding");    
        }else{
            $_SESSION['onbordingPracticeStatus'] = $data['onbording'];
            // header("Location: ".WEB_URL."/practice-onboarding");    
        }
    }else{
        $_SESSION['onbordingStatus'] = 1;

    }
        header("Location: main_dashboard");
    exit();
}else if($loginReturn!=false){
    echo "<script>window.history.replaceState(null, null, window.location.pathname);</script>";
    $msg = $loginReturn;
}

$login       =  $webClass->userLoginCheck();
if($login){
    //if user already login then go to profile
    header("Location: main_dashboard");
    exit();
}

include("loginHeader.php");

?>
<div class="main_container loginPage">
    <div class="newlogin_page">
        <img src="<?php echo WEB_URL ?>/webImages/shape_1.gif" class="shape1" alt="tooth shape">
        <div class="newlogin_page_main">
            <div class="newloginRight">
            <div class="newcontent_logo">
                <a href="<?php echo WEB_URL ?>">
                   <img src="<?php echo WEB_URL ?>/webImages/nav_logo.png" alt="">
                   </a>
            </div>
            <!-- content_logo close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-danger" style="margin: 8px 0 0;padding: 8px;font-size: 15px;">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <?php include_once(__DIR__."/signup_form.php");?>
            <div class="newfoot">
            <div class="tag_footer">
                © Copyright <?php echo date('Y')?> <a href="<?php echo WEB_URL ?>"> Dental Community </a> All Rights Reserved.
            </div>
            </div> 
            </div>
        </div>
        <!-- login-center -->
    </div>
</div>
<script>


window.addEventListener('load', function() {
    function updateOnlineStatus(event) {
        var condition = navigator.onLine ? "Live" : "offline";
        if (condition == "offline") {
            $('.offline').slideDown(300);
        } else {
            $('.offline').slideUp(300);
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
});
</script>

<script>
if(window.navigator && navigator.serviceWorker) {
  navigator.serviceWorker.getRegistrations()
  .then(function(registrations) {
    for(let registration of registrations) {
      registration.unregister();
    }
  });
}
</script>