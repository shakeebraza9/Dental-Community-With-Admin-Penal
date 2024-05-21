<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

?>
<?php include("global.php");

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
    
    $setLink = base64_decode($_GET['set']);
    $setExpl = explode('--', $setLink);
    $_POST['email'] = $setExpl[0];
    $_POST['pass']  = $setExpl[1];
    setcookie('again', 'true', time() + (3600*2), "/");
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
    $userData = $dbF->getRow("SELECT tableA.`setting_val` AS userType , tableB.`setting_val` AS expiryDate FROM `accounts_user_detail` AS tableA , `accounts_user_detail` AS tableB WHERE tableA.`setting_name`='user_type' AND tableB.`setting_name`='date_of_expiry' AND tableA.`id_user`= '$userId'  AND tableB.`id_user` = '$userId' ");
    $userType = $userData['userType'];    
    $expiryDate = $userData['expiryDate'];    
    if ($userType == "Trial") {
        
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
        header("Location: dashboard");
    exit();
}else if($loginReturn!=false){
    echo "<script>window.history.replaceState(null, null, window.location.pathname);</script>";
    $msg = $loginReturn;
}

$login       =  $webClass->userLoginCheck();
if($login){
    //if user already login then go to profile
    header("Location: dashboard");
    exit();
}

include("header.php");
echo'<link rel="stylesheet" type="text/css" href="'.WEB_URL.'/css/style2.css">
    <!-- DESKTOP -->
    <link href="'.WEB_URL.'/css/style-desktop2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1400px)">
    <!-- TABLET -->
    <link href="'.WEB_URL.'/css/style-tablet2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
    <!-- MOBILE -->
    <link href="'.WEB_URL.'/css/style-mobile2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
    <!-- MOBILE SMALL-->
    <link href="'.WEB_URL.'/css/style-mobile-small2.css" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)">';
?>

<div class="login_page">
    <div class="login_page_main">
        <div class="login-center">
            <div class="content_logo">
                <a href="<?php echo WEB_URL ?>">
                    <h1>Smart Dental<span>Compliance &amp; Training</span></h1>
                    <h4>Welcome back! Please login to your account</h4>
                </a>
            </div>
            <!-- content_logo close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-danger" style="margin: 8px 0 0;padding: 8px;font-size: 15px;">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <?php include_once(__DIR__."/signup_form.php");?>
        </div>
        <!-- login-center -->
    </div>
</div>
<style>
    .header_side,#loader{
        display: none !important;
    }
</style>

<!-- PWA -->
<script>
// This is the service worker with the Cache-first network

// Add this below content to your HTML page, or add the js file to your page at the very top to register service worker

// Check compatibility for the browser we're running this in
if ("serviceWorker" in navigator) {
    if (navigator.serviceWorker.controller) {
        console.log("[PWA] active service worker found, no need to register");
    } else {
        // Register the service worker
        navigator.serviceWorker
            .register("pwa-sw1121.js?magic=<?php echo filemtime('./pwa-sw1121.js')?>", {
                scope: "./"
            })
            .then(function(reg) {
                console.log("[PWA] Service worker has been registered for scope: " + reg.scope);
            });
    }
}

  
  


let deferredPrompt= null;
let installSource= null;
const installApp = document.getElementById('installApp');

installApp.addEventListener('click', async () => {
    installSource = 'customInstallationButton';

    if (deferredPrompt !== null) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === 'accepted') {
            deferredPrompt = null;
        }

    } else {
        console.log('APP is already installed.');
    }
});
window.addEventListener('beforeinstallprompt', (e) => {
    $('.install-app-btn-container').show();
    deferredPrompt = e;
    installSource = 'nativeInstallCard';

    e.userChoice.then(function (choiceResult) {
        if (choiceResult.outcome === 'accepted') {
            deferredPrompt = null;
        }

    });
});





window.addEventListener('appinstalled', () => {
    deferredPrompt = null;
    const source = installSource || 'browser';
});

async function install() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        console.log(deferredPrompt)
        deferredPrompt.userChoice.then(function(choiceResult) {

            if (choiceResult.outcome === 'accepted') {
                console.log('Your PWA has been installed');
            } else {
                console.log('User chose to not install your PWA');
            }

            deferredPrompt = null;

        });


    }
}

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