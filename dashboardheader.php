<?php
// header("X-Frame-Options: SAMEORIGIN");
// header("X-Content-Type-Options: nosniff");
// header("Content-Security-Policy: default-src 'self' *.onesignal.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://php8.imdemo.xyz/dental_community/ *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com  *.facebook.net; connect-src https://php8.imdemo.xyz/dental_community/ *.google-analytics.com *.google.com https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://php8.imdemo.xyz/dental_community/ https://onesignal.com *.googleapis.com; img-src 'self' data: https://php8.imdemo.xyz/dental_community/ *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.youtube-nocookie.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' data: *.gstatic.com *.fonts.googleapis.com *.cloudflare.com *.unpkg.com;");
// header("X-Content-Security-Policy: default-src 'self' *.onesignal.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://php8.imdemo.xyz/dental_community/ *.lordicon.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com  *.facebook.net; connect-src https://php8.imdemo.xyz/dental_community/ *.google-analytics.com *.google.com https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://php8.imdemo.xyz/dental_community/ https://onesignal.com *.googleapis.com; img-src 'self' data: https://php8.imdemo.xyz/dental_community/ *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.youtube-nocookie.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' data: *.gstatic.com *.fonts.googleapis.com *.cloudflare.com *.unpkg.com;");
// header("X-WebKit-CSP: default-src 'self' *.onesignal.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://php8.imdemo.xyz/dental_community/ *.google.com *.lordicon.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com  *.facebook.net; connect-src https://php8.imdemo.xyz/dental_community/ *.google-analytics.com *.google.com https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://php8.imdemo.xyz/dental_community/ https://onesignal.com *.googleapis.com; img-src 'self' data: https://php8.imdemo.xyz/dental_community/ *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.live.com *.youtube-nocookie.com *.gocardless.com *.facebook.com; font-src 'self' data: *.gstatic.com *.fonts.googleapis.com *.cloudflare.com *.unpkg.com;");
        ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        // $seo['image']="https://smartdentalcompliance.com/webImages/logo-1240x600.png?magic=01";
        $webClass->AllSeoPrint();
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- FAVICON -->
    <link rel="icon" href="<?php echo WEB_URL ?>/webImages/fav_logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL ?>/webImages/fav_logo.png" type="image/x-icon" />
    <!--Bootstrap css file-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/hover.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/mmenu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/fontawesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/vmenuModule.css">

    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL .'/css/style.css' ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/owl.carousel.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <script src="<?php echo WEB_URL?>/js/jquery.min.js"></script>

    <!-- DESKTOP -->
    <!-- <link href="<?php //echo WEB_URL .'/css/style-desktop.css' ?>" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1400px)"> -->
    <!-- TABLET -->
    <!-- <link href="<?php //echo WEB_URL .'/css/style-tablet.css' ?>" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)"> -->
    <!-- MOBILE -->
    <!-- <link href="<?php //echo WEB_URL .'/css/style-mobile.css' ?>" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)"> -->
    <!-- MOBILE SMALL-->
    <!-- <link href="<?php //echo WEB_URL .'/css/style-mobile-small.css' ?>" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)"> -->
    

    <?php $login = $webClass->userLoginCheck();?>
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/css/style_inuse1.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/css/style_inuse2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL .'/css/dashboard.css' ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/choices.min.css">
    <script src="<?php echo WEB_URL ?>/js/choices.min.js"></script>
    <script src="<?php echo WEB_URL ?>/js/jquery.uploadfile.min.js"></script>
    
 
 
    <link rel='manifest' href='<?php echo WEB_URL?>/manifest.json'>



</head>

<?php
// echo basename($_SERVER['REQUEST_URI']);exit;
$chk = $webClass->bookingFormSubmit();

$webClass->popupFormSubmit();

include_once("platinum-popup.php");

if(isset($_POST['reset']) && isset($_SESSION['practiceUser'])){
   $_SESSION['currentUserType'] = $_SESSION['webUser']['account_type'];
    //$_SESSION['currentUser'] = $_SESSION['practiceUser'];
    $_SESSION['currentUser'] = $_SESSION['webUser']['backup_Practice_id'];
   // $_SESSION['allUsers'] = $_SESSION['webUser']['id'];
    $_SESSION['allUsers'] = $_SESSION['webUser']['backup_login_id'];
  //  $_SESSION['superid'] = $_SESSION['webUser']['id'];
    $_SESSION['superid'] = $_SESSION['webUser']['backup_login_id'];
   unset($_SESSION['practiceUser']);

    

// if($_SERVER['REMOTE_ADDR'] == '103.217.178.162'){
//     echo $_SESSION['currentUserType']." :: ";
//     echo $_SESSION['currentUser']." :: ";
//     echo $_SESSION['allUsers']." :: ";
//     echo $_SESSION['superid']." :: ";
//     echo $_SESSION['webUser']['id']." :: <br>";
//  $d ="SELECT * FROM `superUser` WHERE `user`='$_SESSION[allUsers]' AND user = (SELECT `id_user`  FROM  `accounts_user_detail`  WHERE `id_user` ='$_SESSION[allUsers]' AND `setting_name`= 'superuser' AND `setting_val` = 'on' ) ";
   
// }
  
 
// $data = $dbF->getRows("SELECT * FROM `superUser` WHERE `user`='$_SESSION[webUser][id]' AND user = (SELECT `id_user`  FROM  `accounts_user_detail`  WHERE `id_user` ='$_SESSION[webUser][id]' AND `setting_name`= 'superuser' AND `setting_val` = 'on' ) ");
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

if(isset($_POST['change-session']) ){

    $_SESSION['practiceUser'] = $_SESSION['currentUser'];
    $_SESSION['currentUser'] = $_POST['change-session'];

    $sql2 = "SELECT setting_val FROM accounts_user_detail WHERE id_user= '$_SESSION[currentUser]' AND setting_name='account_type'";
    $data2 = $dbF->getRow($sql2);
    $_SESSION['currentUserType'] = $data2['setting_val'];
    if($data2['setting_val'] != 'Employee'){
        $_SESSION['allUsers'] = $_POST['change-session'];

    }
    else{
        $_SESSION['superid'] = $_SESSION['currentUser'];
        $_SESSION['superUser']['cdashboard'] = '0';
        $_SESSION['superUser']['ccalendar'] = '0';
        $_SESSION['superUser']['health_form'] = '0';
        $_SESSION['superUser']['myuploads'] = '0';
        $_SESSION['superUser']['hrrota'] = '0';
        $_SESSION['superUser']['hrdashboard'] = '0';
        $_SESSION['superUser']['hruser'] = '0';
        $_SESSION['superUser']['hrreports'] = '0';
        $_SESSION['superUser']['hrqr'] = '0';
        $_SESSION['superUser']['access'] = 'full';
         
    }
            $_SESSION['covidhide']['hide'] = '0';
   

}

$functions->termsPopupFormSubmit();
$termViewCheck=$functions->termsView();
if($termViewCheck){
         include_once("termAndConditionPopup.php");
    }
         
            
if(isset($_GET['id'])){
    $editevent_printid=$_GET['id'];
}else{
    $editevent_printid=''; 
}

if($_SERVER['REQUEST_URI']!="/editevent_print.php?id=@$editevent_printid"){
if(strpos($_SERVER['SCRIPT_NAME'], 'redoEvent.php')){ }else{


if(isset($_SESSION['setLogin']) || (substr_count($_SERVER['REQUEST_URI'], "checkinout") > 0)){ 
    $WellcomeReturn = "true"; 
}else{ 
$WellcomeReturn = $functions->newuserWellcome(); 
}
if($_SERVER['REMOTE_ADDR'] != '173.231.200.172'){
$return = $functions->CheckInCheck();
}
//var_dump($return);
if ($WellcomeReturn == false) {
    // $functions->referfriendview(); 
    $showFeedbackForm = $functions->isFeedbackFormView();
    $isreferFriendFormView = $functions->isreferFriendFormView();
    if($showFeedbackForm){
        $functions->feedbackFormView();
    }
    else{
        if($isreferFriendFormView){
        $functions->referfriendview();
        }
        else{
         $functions->covidCheck();
        }
        }
}
if (@$return == false) { 
    
    $functions->returnWorkGoto();
    
}
}
}        

$chk5 = $functions->referfriendSubmit();
if($chk5){
    $msg = "Refer Form Submit Successfully";
}

$fhk = $functions->feedbackFormSubmit();
if($fhk){
    $msg = "Feedback Form Submit Successfully";
}

$plyrid ="not";
if(isset($_SESSION['webUser']['plyrid'])&&!empty($_SESSION['webUser']['plyrid'])){
$plyrid = $_SESSION['webUser']['plyrid'];

}


?>

<?php if(isset($_SESSION['setLogin'])){ }else{ ?>
<!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
var OneSignal = window.OneSignal || [];
OneSignal.push(function() {
    OneSignal.init({
        appId: "63fc4c4a-7ae4-4883-8b6b-fab933959243",
    });
    var isPushSupported = OneSignal.isPushNotificationsSupported();
            // console.log("isPushSupported " + isPushSupported);
            // console.log(document.cookie.indexOf('playerId'));
    if (isPushSupported) {
        OneSignal.getUserId(function(id) {
            // console.log("pppppppppppp"+id);
            // console.log("pppppppppppp"+document.cookie.indexOf('playerId'));
           // if (document.cookie.indexOf('playerId') !=NULL ) {
            //  if (document.cookie.indexOf('playerId') != "-1" ) {
            if (id != null && id != "" ) {
               $.ajax({
                    method: "POST",
                    url: "ajax_call.php?page=chkPlayerId",
                    data: { playerId: id },

                  success: function (data){
                      var chksession = '<?php echo $plyrid ?>';
                     // console.log("<?php //echo "sssssssssssssssssssss".$_SESSION['webUser']['plyrid'] ?>");
                     // console.log("dataaaaaaaaaaaaaaa"+data);
                     // console.log("chksession"+chksession);
                     
                    if (data == "do") 
                    {
                    //  if(chksession != "not"){
            
                        // var result = confirm("Do you want to receive notifications on this device ?");
                        var result = true;
                        if(result==true){ console.log("Updating Player Id......");
                             $.ajax({
                                method: "POST",
                                url: "ajax_call.php?page=setPlayerId",
                                data: { playerId: id },
                                success: function (data){
                                     console.log("Player Id Updated");
                                }
                             });
                        }
                        else{
                    // var status = 'not';        
                    //       $.ajax({
                    // method: "POST",
                    // url: "ajax_call.php?page=setPlayerId",
                    // data: { playerId: id,status:status }
                    //          });
                        }



                    // }  // if(chksession != "not"){
                    
                    }
                    
                   
                    
                    
                  }
                });
                document.cookie = "playerId=" + id;
            

            //   }
            console.log("Player Id " + id);
            }else{
            console.log("Player id is empty" );

              }
        });
    }
});
</script> -->
<?php }?>

<body onafterprint="WindowBack()">

 <?php $box21 = $webClass->getBox('box21');?>
   <?php if(!empty($box21['text'])){?>
   <!-- <div class="maintenance">
        <marquee> -->
            <?php //echo $box21['text'] ?>
        <!-- </marquee>
    </div> -->
    <!-- maintenance -->
<?php } ?>

    <div id="cartLoading"></div>
    
    <!-- <div id="loader">
        <img src="https://smartdentalcompliance.com/webImages/logo.png" alt="Smart Dental Compliance">
    </div> -->

    <div class="fixed_side1"></div>
    <!-- <div class="background_side">
    </div> -->
    <div class="change_user_popup">
        <div class="col5_close">
            <img src="<?php echo WEB_URL?>/webImages/close.png" alt="" class="hvr-pop" />
        </div>
        <div class="col5_close">
            <img src="<?php echo WEB_URL?>/webImages/close.png" alt="" class="hvr-pop" />
        </div>
    <div class="inner_cu">
    <div class="change-session">
        <?php $functions->changeSession();?>
    </div>
    </div>
    </div>

    <?php if(@$_GET['page'] != 'booking' && substr_count($_SERVER['REQUEST_URI'],"black-friday-deal",0 ) == 0) { ?>
    <!-- <div class="col101 col101_book">
        <div class="close_popup hvr-pop">
            <i class="fas fa-times"></i>
        </div>
        <h1>Request a DEMO</h1>
        <div class="col101_txt">
            See how we can help you Pass your next CQC inspection
        </div>
        <h6>COMPANY DETAILS</h6>
        <form method="post">
            <?php $functions->setFormToken('bookForm'); ?>    
                           <input type="hidden" id="g-bookForm" name="g-bookForm">
    <input type="hidden" name="action" value="bookForm">
            
            <div class="form_input">
                <input type="text" placeholder="Your Full Name" name="form[full name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Practice Name" name="form[pracice name]" required>
            </div>
            <div class="form_input">
                <input class="datepicker" type="text" placeholder="When would you like to book the demo" name="form[date]" autocomplete="off">
            </div>
            <div class="form_input">
                <input type="text" placeholder="Contact No" name="form[contact no]" required>
            </div>
            <div class="form_input">
                <input type="email" placeholder="Email Address" name="form[email]" required>
            </div>
            
            <div class="form_input">
                <input placeholder="Time" class="timepicker" type="text" name="form[time]">
            </div>
            <h6>HOW DO YOU KNOW ABOUT US</h6>
            <div class="col101_btn_main">
                <div class="col1_btn">
                    <input id="t1" type="radio" name="form[how_know_about]" value="Google search">
                    <label for="t1">Google search</label>
                </div>
                <div class="col1_btn">
                    <input id="t2" type="radio" name="form[how_know_about]" value="Social Media (Facebook,Twitter,etc)">
                    <label for="t2">Social Media (Facebook,Twitter,etc)</label>
                </div>
                <div class="col1_btn">
                    <input id="t3" type="radio" name="form[how_know_about]" value="Email">
                    <label for="t3">Email</label>
                </div>
                <div class="col1_btn">
                    <input id="t4" type="radio" name="form[how_know_about]" value="Family/Friend">
                    <label for="t4">Family/Friend</label>
                </div>
                <div class="col1_btn">
                    <input id="t4s" type="radio" name="form[how_know_about]" value="Employer">
                    <label for="t4s">Employer</label>
                </div>
                <div class="col1_btn">
                    <input id="t5" type="radio" name="form[how_know_about]" value="Events">
                    <label for="t5">Events</label>
                </div>
                <div class="col1_btn">
                    <input id="t6" type="radio" name="form[how_know_about]" value="Leaflet">
                    <label for="t6">Leaflet</label>
                </div>
                <div class="col1_btn">
                    <input id="t7" type="radio" name="form[how_know_about]" value="Newspaper/Magazine">
                    <label for="t7">Newspaper/Magazine</label>
                </div>
                <div class="col1_btn">
                    <input id="t8" type="radio" name="form[how_know_about]" value="Facebook Groups">
                    <label for="t8">Facebook Groups</label>
                </div>
            </div>
            <div class="col101_btn_main2"> -->
           <!--      <div class="form_input">
                    <div id="recaptcha1"></div>
                </div>
                <br> -->

                             <!-- <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="tokenBooking" name="token">
                                </div>


                <div class="col1_btn">
                    <button type="submit" name="submit">
                        Book your personalised practice demo
                    </button>
                </div>
            </div>
        </form>
    </div> --> <?php } ?>

    <!-- <div class="col101 col101_free_resource_registration">
        <div class="close_popup hvr-pop">
            <i class="fas fa-times"></i>
        </div>
        <h1>Registration</h1>
        <div class="col101_txt">
            Please fill out this form to download the document.
        </div>
        <h6>PERSONAL DETAILS</h6>
        <form action="/page-free-resources" method="post" onsubmit="submitFreeResourceForm()">
            <?php $functions->setFormToken('free_resources'); ?>    
            
            <input type="hidden" id="resourceFormSubmit" value="0">
            <input type="hidden" id="g-freeResourceForm" name="g-freeResourceForm">
            <input type="hidden" name="action" value="freeResourceForm">
            <input type="hidden" name="form[title]" class="resourceTitle">
            <input type="hidden" name="form[id]" class="resourceLink">

            <div class="form_input">
                <input type="text" placeholder="Your Full Name" name="form[full name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Practice Name" name="form[pracice name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Contact No" name="form[contact no]" required>
            </div>
            <div class="form_input">
                <input type="email" placeholder="Email Address" name="form[email]" required>
            </div>
            
            <div class="col101_btn_main2">
                <div class="col1_btn">
                    <button type="submit" name="submit">
                        Submit Information
                    </button>
                </div>
            </div>
        </form>
        <script>
            function submitFreeResourceForm(){
                
                document.getElementById('resourceFormSubmit').value = 1;
                $(".background_side").fadeToggle(), $(".col101_free_resource_registration").fadeToggle()
            }
        </script>
    </div>  -->

    <div class="main_container">
        <div class="links_area" >
            <div class="close_side"><i class="fas fa-times"></i></div><!-- close_side close -->
            <div class="u-vmenu">
                <ul>
                    <li><a href="<?php echo WEB_URL; ?>/practice-profile"><i class="fas fa-user"></i>Practice Profile</a></li>
                    <li><a href="<?php echo WEB_URL; ?>/main_dashboard"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a class="<?php if($active=='post_all') echo'active'?>" href="<?php echo WEB_URL; ?>/post_all?type=posts"><i class="fab fa-mixcloud"></i>Social</a></li>
                    <li><a href="<?php echo WEB_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i>Compliance Dashboard</a></li>
                    <li><a href="<?php echo WEB_URL; ?>/calendar"><i class="fas fa-calendar-alt"></i>Activity Calendar</a>
                        <ul>
                            <li><a href="<?php echo WEB_URL; ?>/addReminder">My Reminder</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo WEB_URL; ?>/all-reports"><i class="fas fa-chart-bar"></i>Reports</a></li>
                    <li>
                    <a href="<?php echo WEB_URL; ?>/safetyData?category=Safety-Data"><i class="fas fa-list-alt"></i>Safety Data Sheet Templates</a>
                    </li>

<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){?>

<?php }else{?>
<li>
<a href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates"><i class="fas fa-list-alt"></i>Compliance Templates</a>
</li>
<?php }?>



                
                    <li><a href="<?php echo WEB_URL; ?>/myuploads"><i class="fas fa-upload"></i>My Uploads</a></li>
                    <li><a href="<?php echo WEB_URL; ?>/cpd"><i class="fas fa-tv"></i>CE Courses</a>
                        <span data-option="off"></span>
                        <ul>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-form">My Profile</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-activity">My Activity Log</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-pdp">My PDP</a></li>
                            <?php                           
                            // $sql = "SELECT `setting_val` FROM `ibms_setting` WHERE `setting_name` = 'test_categories'";
                            // $res = $dbF->getRow($sql);
                            // $res = explode(",", $res[0]);
                            // foreach ($res as $field): 
                            // echo'
                            // <li><a href="'.WEB_URL.'/course?Cat='.$field.'">'.$field.'</a> 
                            // ';
                            // endforeach;  
                            ?>
                            <li><a href="<?php echo WEB_URL; ?>/cpd">CE Courses</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-certificates">My Certificates</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/practice-training">Practice Training</a></li>

                            <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){}else{?>
                            <li><a href="<?php echo WEB_URL; ?>/assigne_course">Assign CE Course</a></li>
             <?php } ?>



             
                        </ul>
                    </li>
<!-- <li>
<a href="<?php echo WEB_URL; ?>/resources?category=HR-Management"><i class="fas fa-users"></i>HR Management</a>
<span data-option="off"></span>
<ul>
<li><a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a></li>
<li><a href="<?php echo WEB_URL; ?>/manage-users">My Staff</a>
<li>
<a href="<?php echo WEB_URL; ?>/hrm">Employee Hub</a>
<span data-option="off"></span>
<ul>
<li><a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a></li>
<li><a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a></li>
<li><a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a></li>


</ul>
</li>
<li><a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a></li>
<li><a href="<?php echo WEB_URL; ?>/rota">Rota Management</a></li>
<li><a href="<?php echo WEB_URL; ?>">Payroll</a></li>
<li><a href="<?php echo WEB_URL; ?>/recruitment">Recruitment</a></li>
<li><a href="<?php echo WEB_URL; ?>/rota-reports">Reports</a></li>
<li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a></li>
</ul>
</li> -->


          
    <li>
    <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>

    <a href="#" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i>HR Management</a>
    <?php }else{?>
    <a href="<?php echo WEB_URL; ?>/manage-users" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i>HR Management</a>
    <?php } ?>
     <span data-option="off"></span>
    <ul>
    <li><a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a></li>
    <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ $usermenu =  $_SESSION['superid'];   ?>


    <li><a href="<?php echo WEB_URL; ?>/profile-detail?user=<?php echo $usermenu; ?>" >My Staff</a>
    <?php } else{ $usermenu = $_SESSION['currentUser']; ?>

    <li><a href="<?php echo WEB_URL; ?>/manage-users">My Staff</a>
    <?php } ?>
     <span data-option="off"></span><ul>
    <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a></li>
    <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a></li>
    <!-- <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/instance">Staff Performance</a></li> -->

    <!--<li><a href="leave-reports">Leave Reports</a>-->
    <!-- <span data-option="off"></span><ul>-->


    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=annual_leave">Annual Leave</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=sick_leave">Sick Leave</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=casual_leave">Casual Leave</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=Compassionate_leave">Compassionate leave</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=maternity_leave">Maternity</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=half_day_leave">Half Day Leave</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=furlough_leave">Furlough leave</a></li>-->


    <!--</ul>-->
    <!--</li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-reports">Holiday Entitlement Reports</a></li>-->
    <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator">Holiday Entitlement Calculator</a></li>

    <!--<li  ><a href="<?php echo WEB_URL; ?>/lieu">OverTime Report</a></li>-->
    </ul>
    </li>

    <li <?php if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){ echo $sh;} ?>>
    <a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a></li>
    <li><a href="<?php echo WEB_URL; ?>/rota">Rota Management</a></li>
    <li><a href="<?php echo WEB_URL; ?>/personal-document">Personal Documents</a></li>
    <li><a href="<?php echo WEB_URL; ?>/rota-reports">Rota Reports</a>
    <!--<span data-option="off"></span> <ul>-->
    <?php if( $_SESSION['currentUserType'] == 'Employee' &&  $_SESSION['superUser']['hrreports'] == '0')  { ?>     
    <!--<li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>-->
    <?php }else{  ?>
    <!--<li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>-->
    <!--<li ><a href="<?php echo WEB_URL; ?>/policy-report?category=Training">Training Report</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Recruitment">Recruitment Report</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Signed Policies">Signed Policies Report</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Minute Meeting">Minute Meeting Report</a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=MHRA">MHRA Alerts Report </a></li>-->
    <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Additional Document">Additional Document</a></li>  -->
    <?php } ?>
    <!--</ul>-->
    <!--</li>-->
    <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ ?>

    <?php }else{ ?>
    <li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a></li>
    <?php } ?>
    </ul>
    </li>



<li>
<a href="<?php echo WEB_URL; ?>/stock"><i class="fas fa-server"></i>Stock Management</a>
<span data-option="off"></span>
<ul>

 <?php  if(@$_SESSION['currentUserType'] == 'Employee' && ($_SESSION['superUser']['manage_stock'] == '0' || $_SESSION['superUser']['manage_stock'] == '')){ ?>


<!-- <li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li> -->
<!-- <li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li> -->
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<!-- <li>
<a href="javascript:;">Reports</a>
<span data-option="off"></span>
<ul>
<li>
<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>
</li>
</ul>
</li> -->
<?php }else{ ?>



<li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/stockView#tabs-2">Add Existing Stock</a>
</li>





<li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<!--<li>-->
<!--<a href="javascript:;">Reports</a>-->
<!--<span data-option="off"></span>-->
<!--<ul>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>-->
<!--</li>-->
<!--</ul>-->
<!--</li>-->


    <?php } ?>






</ul>



</li>
<li>
            <a class="<?php if($active = 'resources') echo'active'?>" href="<?php echo WEB_URL; ?>/lab-management"><i class="fas fa-flask"></i>Lab Management</a></li>
               <li>
             <a class="<?php if($active=='stock') echo'active'?>" href="#"><i class="fa fa-user-circle"></i>Forget To Check In/Out</a> 
             <span data-option="off"></span>
            <ul>
                <li>
                    <a href="<?php echo WEB_URL; ?>/checkoutforget?type=checkoutForget">Forget Check Out</a>
                </li> 

               

                <li>
                    <a href="<?php echo WEB_URL; ?>/checkinforget?type=checkinForget">Forget Check in</a>
                </li>

            
            </ul>
        </li>
         <li>
                        <a class="<?php if($active=='faq') echo'active'?>" href="<?php echo WEB_URL; ?>/faq"><i class="fas fa-info"></i> FAQ</a></li>
         <li>
            <a class="<?php if($active=='trashdata') echo'active'?>" href="<?php echo WEB_URL; ?>/trashdata"><i class="fas fa-eraser"></i>Trash Data</a></li>
                    <li class='checkinbutton'>
                        <?php 
                        $functions->CheckInBtn();
                        $functions->CheckOutBtn();
                         // var_dump($var);
             // echo "<br>";
             // var_dump($var2);
                        ?>
                    </li>
        <li style="box-shadow: none;"><span class="install-app-btn-container">
        <a href="https://smartdentalcompliance.com/download" target="_blank" class="install-app-btn"><i class="fas fa-download"></i>Install APP</a>
        </span></li>
                </ul>
                <!--  ul close -->
            </div>
        </div>
        <!-- links_area close -->
        <div class="fixed_side"></div>
         <?php include_once("platinum-popup.php");?>

         <header class="d-block">
            <div class="header_bottom">
                <div class="flex_ h-100">
                    <div class="title">
                        <div class="header_logo">
                            <a href="<?php echo WEB_URL?>" class="logo_nav"><img src="<?php echo WEB_URL?>/webImages/nav_logo.png" /></a>

                            <!-- <form class="nav_search">
                                <div class="search_box">
                                    <input type="text" class="form-control" placeholder="Search..." />
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form> -->

                            <div class="rest_links">
                                <button id="menu_toggler">
                                    <img src="<?php echo WEB_URL?>/webImages/menu.png" alt="" />
                                </button>

                                <div class="rest_links_dropdown">
                                    <div class="innerFlex flex_">
                                        <?php include_once 'dashboardmenu.php';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="logged_in_as">
                        
                            
                           <?php if(isset($_POST['change-session'])){?>
                           <h3>
                            <i class="bx bxs-user"></i> Logged in as:
                            <span style="font-weight: bold"><?php echo $functions->UserName($_SESSION['currentUser'])?><?php //echo $_SESSION['webUser']['name']?></span>
                             </h3>
                       <?php }?>
                          
                            
                       
                    </div>
                  
                   <?php if($_SESSION['currentUserType'] != 'Employee' || isset($_POST['change-session']) || isset($_SESSION['practiceUser']) ){ ?>
                    <div class="header_bottom_right icon_menu">
                        <div data-toggle="tooltip" title="Change User" class="change_user" id="change_user">
                            <a class="topnav_icons">
                                <span class="bx bxs-user-plus"></span>
                            </a>
                        </div>
                        <?php } ?>
                            <?php 
                                        $var =  $functions->CheckInBtn();
                                        $var2 = $functions->CheckOutBtn();
                            ?> 
                            <!--<a href="<?php //echo WEB_URL?>/logout" class="topnav_icons">-->
                            <!--    <span class="material-symbols-outlined">logout</span>-->
                            <!--</a>-->
                       
                        <div data-toggle="tooltip" title="Notifications" class="noti">
                            <a class="topnav_icons">
                                <span class="bx bx-bell bx-tada"></span>
                                <span class="noti_count"></span>
                            </a>
                        </div>
                       
                        <span class="line"></span>

                        <script>
                            function readnotification(user) {
                                user = user;
                                $.ajax({
                                    type: "post",
                                    data: {
                                        user: user,
                                    },
                                    url: "ajaxnotif",
                                }).done(function (data) {
                                    console.log(data);
                                    if (data == "2") {
                                        $(".num").remove();
                                    } else {
                                        console.log("not");
                                    }
                                });
                            }
                        </script>
                        <?php
                        if($_SESSION['webUser']['image']=="#" || $_SESSION['webUser']['image']==""){
                          $image='default_profile.jpg';
                        }else{
                          $image=$_SESSION['webUser']['image'];
                        }
                        ?>
                        <div class="user_profile_drop">
                        <div class="login_side">
                            <div class="radiuse-img">
                                <img src="<?php echo  WEB_URL.'/images/'.$image?>" />
                            </div>
                            <div class="ProfileName">
                                <a href="<?php echo WEB_URL; ?>/profile?page=Profile">
                                    <h2><?php if($_SESSION['currentUserType'] == 'Employee'){
                                    echo $_SESSION['webUser']['name'];
                                    }else{
                                        echo $functions->UserName($_SESSION['currentUser']);
                                    }?></h2>
                                </a>
                                <a href="<?php echo WEB_URL; ?>/practice-profile">Practice Profile</a>
                            </div>
                        </div>
                        <span class="profile-drop"><i class="material-symbols-outlined"
                                id="profile_activator">expand_more</i></span>
                                </div>
                                
                        <div class="link_menu">
                            <span>
                               
                                <img src="<?php echo WEB_URL; ?>/webImages/menu.png" alt="" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
<?php
if(basename($_SERVER['REQUEST_URI']) == "main_dashboard"){
$active = 'main_dashboard';
}
else if(@$_GET['type'] == "posts"){
$active = 'intranet';
}
else if(basename($_SERVER['REQUEST_URI']) == "dashboard" || basename($_SERVER['REQUEST_URI']) == "addReminder" || basename($_SERVER['REQUEST_URI']) == "action-plan" || basename($_SERVER['REQUEST_URI']) == "completeallEvent" || basename($_SERVER['REQUEST_URI']) == "completeallMyEvent" || basename($_SERVER['REQUEST_URI']) == "mock_inspection#tabs-2" || basename($_SERVER['REQUEST_URI']) == "mock-actionplan"){
$active = 'dashboard';
}
else if(basename($_SERVER['REQUEST_URI']) == "calendar"){
$active = 'calendar';

}else if(@$_GET['type'] == "completed"){
$active = 'calendar';

}else if(basename($_SERVER['REQUEST_URI']) == "stock" || basename($_SERVER['REQUEST_URI']) == "purchaseReceipt" || basename($_SERVER['REQUEST_URI']) == "stockView" || basename($_SERVER['REQUEST_URI']) == "stockOrder" || basename($_SERVER['REQUEST_URI']) == "availableStock" || basename($_SERVER['REQUEST_URI']) == "expireProList" || basename($_SERVER['REQUEST_URI']) == "mostUseProducts" || basename($_SERVER['REQUEST_URI']) == "perSurgery" || basename($_SERVER['REQUEST_URI']) == "mqProList"){
$active = 'stock';

}else if(basename($_SERVER['REQUEST_URI']) == "cpd" || basename($_SERVER['REQUEST_URI']) == "cpd-form" || basename($_SERVER['REQUEST_URI']) == "cpd-activity" || basename($_SERVER['REQUEST_URI']) == "cpd-pdp" || basename($_SERVER['REQUEST_URI']) == "cpd-certificates" || basename($_SERVER['REQUEST_URI']) == "practice-training" || basename($_SERVER['REQUEST_URI']) == "assigne_course" || basename($_SERVER['REQUEST_URI']) == "course"){
$active = 'cpd';

}else if(basename($_SERVER['REQUEST_URI']) == "hrm" || basename($_SERVER['REQUEST_URI']) == "manage-users" || basename($_SERVER['REQUEST_URI']) == "qr-code" || basename($_SERVER['REQUEST_URI']) == "personal-document" || basename($_SERVER['REQUEST_URI']) == "rota" || basename($_SERVER['REQUEST_URI']) == "rota-reports" || @$_GET['category'] == "HR-Management"){
$active = 'hrmanagement';

}else if(basename($_SERVER['REQUEST_URI']) == "manage-users" || basename($_SERVER['REQUEST_URI']) == "leaves" || basename($_SERVER['REQUEST_URI']) == "holiday-entitlement" || basename($_SERVER['REQUEST_URI']) == "holiday-entitlement-calculator"){
$active = 'staff';
}
?>

            <div class="left_side">
                <div class="sideme0nu u-vmenu">
                    <ul>
                        <li  class="list <?php if($active=='main_dashboard')echo'active'?>">
                            <a class="highlight" href="<?php echo WEB_URL; ?>/main_dashboard"><i class="fas fa-tachometer-alt"></i><span
                                    class="links_name">Dashboard</span></a>
                        </li>
                        <li class="list <?php if($active=='intranet')echo'active'?>">
                            <a class="highlight" href="<?php echo WEB_URL; ?>/post_all?type=posts"><i class="fa-solid fa-network-wired"></i><span
                                    class="links_name">Social</span></a>
                        </li>
                        <li class="dropdown_link list <?php if($active=='dashboard')echo'active'?>">
                            <a class="highlight" href="<?php echo WEB_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i><span
                                    class="links_name">Compliance Dashboard</span></a>
                            <ul class="dropdown_list_div">
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/addReminder">My Reminders</a>
                                </li>

                                <li>
                                    <a href="<?php echo WEB_URL; ?>/action-plan">My Action Plan</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/completeallEvent">All Completed Events</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/completeallMyEvent">All Completed My Event</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/mock_inspection#tabs-2">My Mock Inspections</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/mock-actionplan">My Mock Inspection Completed Actions</a>
                                </li>
                                
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/safetyData">Safety Data</a>
                                </li>
                                <li class="dropdown_link dropdown_link_sub">
                                    <a href="#" class="highlight" >Report An Issue</a>
                                    <ul class="dropdown_list_div2">
                                        <li>
                                            <a href="<?php echo WEB_URL; ?>/reportIssue">Report Accident Incident</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo WEB_URL; ?>/reportIssue#tabs-add2">Report a Complaint</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo WEB_URL; ?>/Safeguarding_Form">Safegurarding Report</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="list <?php if($active=='calendar')echo'active'?>">
                            <a class="highlight" href="<?php echo WEB_URL; ?>/calendar"><i class="fas fa-calendar-alt"></i><span class="links_name">Activity
                                    Calendar</span></a>
                        </li>

                        <li class="dropdown_link list <?php if($active=='cpd')echo'active'?>">
                            <a href="<?php echo WEB_URL; ?>/cpd" class="highlight"><i class="fas fa-tv"></i><span class="links_name">CE
                                    Courses</span></a>
                            <!-- <span data-option="off"></span> -->
                            <ul class="dropdown_list_div">
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/cpd-form">My Profile</a>
                                </li>

                                <li>
                                    <a href="<?php echo WEB_URL; ?>/cpd-activity">My Activity Log</a>
                                </li>
                                <!-- <li>
                                    <a href="<php echo WEB_URL; ?>/cpd-pdp">My PDP</a>
                                </li> -->
                                <!--<li>-->
                                <!--    <a href="<php echo WEB_URL; ?>/cpd">CE Courses</a>-->
                                <!--</li>-->
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/cpd-certificates">My Certificates</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/practice-training">Practice Training</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/assigne_course">Assign CE Course</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown_link list <?php if($active=='hrmanagement')echo'active'?>">
                            <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>
                                <a href="#" id="hrManagement" class="highlight">
                                    <i class="fas fa-users"></i><span
                                    class="links_name">HR Management</span>
                                </a>
                            <?php }else{?>
                                <a href="<?php echo WEB_URL; ?>/hrm" id="hrManagement" class="highlight">
                                    <i class="fas fa-users"></i><span
                                    class="links_name">HR Management</span>
                                </a>
                            <?php } ?>
                            <!-- <span data-option="off"></span> -->
                            <ul class="dropdown_list_div">
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a>
                                </li>
                                <li <?php if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){ echo $sh;} ?>>
                                    <a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/rota">Schedule Management</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/personal-document">Personal Documents</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/rota-reports">Schedule Reports</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown_link list <?php if($active=='stock')echo'active'?>">
                            <a class="highlight" href="<?php echo WEB_URL ?>/stock"><i class="fas fa-server"></i><span class="links_name">Stock Management</span></a>
                            <!-- <span data-option="off"></span> -->
                            <ul class="dropdown_list_div">
                                <?php  if($_SESSION['currentUserType'] == 'Employee' && (@$_SESSION['superUser']['manage_stock'] == '0' || @$_SESSION['superUser']['manage_stock'] == '')){ ?>
                                    <li>
                                    <a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
                                    </li>

                                <?php }else{ ?>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/stockView#tabs-2">Add Existing Stock</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/stockView">Product List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL; ?>/perSurgery">Stock Consumption Per Surgery Reports</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL; ?>/mostUseProducts">Most Used Products List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo WEB_URL; ?>/mqProList">Minimum Quantity Product List</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li class="dropdown_link list <?php if($active=='staff')echo'active'?>">
                            <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ $usermenu =  $_SESSION['superid'];   ?>
                                <a href="<?php echo WEB_URL; ?>/profile-detail?user=<?php echo $usermenu; ?>" class="highlight" >
                                    <i class="fas fa-users"></i><span class="links_name">My Staff</span>
                                </a>
                            <?php } else{ $usermenu = $_SESSION['currentUser']; ?>
                                <a href="<?php echo WEB_URL; ?>/manage-users" class="highlight">
                                    <i class="fas fa-users"></i><span class="links_name">My Staff</span>
                                </a>
                            <?php } ?>

                            <ul class="dropdown_list_div">
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a>
                                </li>
                                <li>
                                    <a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a>
                                </li>

                                <li>
                                    <a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator">Holiday Entitlement Calculator</a>
                                </li>
                                <li <?php echo $sh ?>>
                                    <a href="<?php echo WEB_URL; ?>/instance">Staff Performance</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <button onclick="secure_delete333('Do you Wish to Check-in Without Rota'); ">
                                Check In
                            </button>
                            <script>
                                function secure_delete333(text) {
                                    text =
                                        typeof text !== "undefined"
                                            ? text
                                            : "Are you sure you want to Delete?";

                                    bool = confirm(text);
                                    console.log(bool);
                                    if (bool == true) {
                                        var filename = location.pathname.substr(
                                            location.pathname.lastIndexOf("/") + 1
                                        );
                                        if (filename != "checkinout") {
                                            window.location.href =
                                                "checkinout?type=checkin_rota_not";
                                        }
                                    } else {
                                        console.log("no");
                                    }
                                }

                                function Lunch_Time(text) {
                                    text =
                                        typeof text !== "undefined"
                                            ? text
                                            : "Are you sure you want to Go Lunch?";

                                    bool = confirm(text);
                                    console.log(bool);
                                    if (bool == true) {
                                        window.location.href =
                                            "checkinout?type=lunch_time_checkin";
                                    } else {
                                        console.log("no");
                                    }
                                }

                                function Lunch_TimeOut(text) {
                                    //   /doxu10vne1mw/public_html/AIOM/dashboardmenu.php
                                    text =
                                        typeof text !== "undefined"
                                            ? text
                                            : "Are you sure you want to Go Lunch?";

                                    bool = confirm(text);
                                    console.log(bool);
                                    if (bool == true) {
                                        window.location.href =
                                            "checkinout?type=lunch_time_checkout";
                                    } else {
                                        console.log("no");
                                    }
                                }
                                let sidebar = document.querySelector(".left_side");
                                let closeBtn = document.querySelector("#btn");

                                function width_250() {
                                    sidebar.classList.toggle("open");
                                    $(".u-vmenu ul ul").css("display", "none");
                                    $('.u-vmenu span[data-option="on"]').attr(
                                        "data-option",
                                        "off"
                                    );
                                }
                            </script>
                        </li>
                    </ul>
                </div>

                <script>
                    $(document).ready(function () {
                        $("#menu_toggler").click(function () {
                            $(".rest_links_dropdown").toggleClass("show");
                        });
                    });
                </script>
            </div>
        </header>
    
    <div class="main_mmenu" style="display: none;">
        <div id="page">
            <nav id="menu">
                <ul>
                    <?php
                    $login  =  $webClass->userLoginCheck();
                    if(!$login){
                        echo "<li><a href='login'>Login</a></li>";
                    }
                    else{
                        echo "<li><a href='/main_dashboard'>Dashboard</a></li>";
                    }
                    ##### RESPONSIVE MAIN MENU
                    $css = false;
                    $mainMenu = $menuClass->menuTypeSingle('main_menu');
                    foreach ($mainMenu as $val) {
                    $insideActive = false;
                    $innerUl = '';
                    $menuId = $val['id'];
                    $text = ($val['name']);
                    $link = $val['link'];
                    $mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
                    if (!empty($mainMenu2)) {
                    $innerUl .= '<ul>';
                    foreach ($mainMenu2 as $val2) {
                    $innerUl3 = '';
                    $text = ($val2['name']);
                    $menuId = $val2['id'];
                    $link = $val2['link'];
                    $mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
                    # count the inner level 3 lis
                    $innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
                    $innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
                    if ( $innerUl3count > 0 ) {
                    foreach ($mainMenu3 as $val3) {
                    $innerUl4 = '';
                    $text3       = ($val3['name']);
                    $menuId3     = $val3['id'];
                    $link3       = $val3['link'];
                    $mainMenu4   = $menuClass->menuTypeSingle('main_menu', $menuId3);
                    # count the inner level 3 lis
                    $innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
                    $innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
                    if ( $innerUl4count > 0 ) {
                    foreach ($mainMenu4 as $val4) {
                    $text4       = ($val4['name']);
                    $link4       = $val4['link'];
                    $innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
                    }}
                    $innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
                    $innerUl3 .= '
                    <li><a href="' . $link3 . '">' . $text3 . '</a>
                    ' . $innerUl4 . '
                    </li>';
                    }
                    }
                    $innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
                    $innerUl .= '<li><a href="' . $link . '" target="_blank">' . $text . '</a>' . $innerUl3 . '</li>';

                    }
                    $innerUl .= "</ul><!--2nd array End-->";
                    }
                    $text = ($val['name']);
                    $link = $val['link'];
                    echo '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl . '</li>';
                    }
                    ?>


<!-- <li>
</li> -->
                </ul>
<span class="install-app-btn-container">
<a id="installApp" class="install-app-btn"><i class="fas fa-download"></i>Install App</a>
</span>

            </nav>
        </div>
    </div>
    <!-- <div class="main_container"> -->

        <header style="display: none;">
            <div class="header_side">
                <?php if(strpos($_SERVER['SCRIPT_NAME'], 'index.php')){ ?>
                <div class="banner_side">
                    <video autoplay muted loop style="width: 100%">
                        <source src="<?php echo WEB_URL ?>/webImages/SDC.webm" type="video/mp4" />
                    </video>

                    <!--<img src="<?php echo WEB_URL ?>/webImages/bs.png" alt="">-->
                    <div class="banner_side_main">
                        <div class="standard">
                            <div class="banner_left">
                                <ul id="banner_">
                                <?php 
                                    $bannersData    =   $webClass->web_banners();
                                    $banners = '';
                                    $banners1 = '';
                                    $bannerscount = 1;
                                    foreach($bannersData as $val){
                                    $title  =   $val['title'];
                                    $text   =   $val['text'];
                                    $image1  =   $val['layer0'];
                                    $image2  =   $val['layer2'];
                                    $link  =   $val['link'];
                                    $linkText  =   $val['layer3']; 
                                    $banners .='<li>
                                        <div class="banner_txt">
                                            <div class="banner_txt_main wow zoomInUp">
                                                <h3>'.$title.'</h3>
                                                <div class="banner_txt_main_">
                                                    '.$text.'
                                                </div>
                                                <div class="col1_btn">
                                                     <a href="#">Get Started</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                                    $bannerscount++;
                                    }
                                    echo $banners;
                                    ?>   
                                </ul>
                            </div>


                        </div>
                    </div>

                </div>
                <?php } else { ?>
                <div class="col1_btn_main wow fadeInRight">
                    <img src="<?php echo WEB_URL ?>/webImages/1.png" alt="" class="hvr-pop">
                </div><!-- col1_btn_main close -->
                <div class="inner_banner">
                    <img src="<?php echo @$bannerImg ?>" alt="">
                    <div class="inner_banner_txt wow fadeInDown">
                        <div class="standard">
                            <h3>
                                <?php echo @$subHeading ?>
                            </h3>
                            <h6>
                                <?php echo @$shrtDesc ?>
                            </h6>
                        </div><!-- standard close -->
                    </div><!-- inner_banner_txt close -->
                </div><!-- inner_banner close -->
                <?php } ?>
                <div class="header_top wow fadeInDown">
                    <div class="standard">
                        <div class="logo_side">
                            <a href="<?php echo WEB_URL?>">
                                <div class="logo_img">
                                    <img src="<?php echo WEB_URL?>/webImages/logo.png" alt="">
                                </div>
                                <div class="logo_txt">
                                    <h3>SMART DENTAL</h3>
                                    <h6>COMPLIANCE & TRAINING</h6>
                                </div>
                            </a>
                        </div>
                        <div class="header_top_right">
                            <div class="col1">
                                <div class="menu_area">
                                    <ul>
<?php
##### MAIN MENU
$css = false;
$mainMenu = $menuClass->menuTypeSingle('main_menu');
foreach ($mainMenu as $val) {
$insideActive = false;
$innerUl = '';
$menuId = $val['id'];
$text = ($val['name']);
$desc = ($val['short_desc']);

$link = $val['link'];
$mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
if (!empty($mainMenu2)) {
$innerUl .= '<ul>';
foreach ($mainMenu2 as $val2) {
$innerUl3 = '';
$text = ($val2['name']);
$menuId = $val2['id'];
$link = $val2['link'];
$icon = $val2['icon'];

$mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
# count the inner level 3 lis
$innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
$innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
if ( $innerUl3count > 0 ) {
foreach ($mainMenu3 as $val3) {
$innerUl4 = '';
$text3       = ($val3['name']);
$menuId3     = $val3['id'];
$link3       = $val3['link'];
$mainMenu4 = $menuClass->menuTypeSingle('main_menu', $menuId3);
# count the inner level 3 lis
$innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
$innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
if ( $innerUl4count > 0 ) {
foreach ($mainMenu4 as $val4) {
$text4       = ($val4['name']);
$link4       = $val4['link'];

$innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
}}
$innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
$innerUl3 .= '
<li><a href="' . $link3 . '">' . $text3 . '</a>
' . $innerUl4 . '
</li>';
}
}
$innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
$innerUl .= '<li>
                <a href="' . $link . '" target="_blank"> 
                <div class="menu_in"> 
                <img src="'.$icon.'" alt="">
                <div class="menu_in_txt">
                <h2>' . $text . '</h2>
                <p>'  . $desc  . '</p>
                </div>
                </div>
                </a>' . $innerUl3 . 
            '</li>';
}
$innerUl .= "</ul><!--2nd array End-->";
}
$text = ($val['name']);
$link = $val['link'];
$active = $val['active'];

if ($active == '1' || $insideActive) {
// if (!empty($mainMenu2)) {
// $css = true;
// }
//$active = 'active';
}

echo '<li><a href="' . $link . '" class="' . $active . '">' . $text . '</a>' . $innerUl . '</li>';
}

$login  =  $webClass->userLoginCheck();
if(!$login){
    echo "<li><a href='login'>Login</a></li>";
}
else{
    echo "<li class='dash-btn'><a href='/main_dashboard'><i class='fas fa-tachometer-alt'></i>Dashboard</a></li>";
}
?>

                    </ul>
                </div>
                                <!-- <div class="col1_btn">
                                    <a href="javascript:;">
                                        Book a Demo </a>
                                </div> -->
                                <?php $login  =  $webClass->userLoginCheck();
                                if(!$login){ ?>
                                <div class="col1_btn">
                                    <?php $box17 = $webClass->getBox('box17'); ?>
                                    <a href="javascript:;">
                                        <?php echo $box17['linkText'] ?>
                                    </a>
                                </div><!-- col1_btn close -->
                                <?php } ?>

                                <div class="menu_side">
                                    <a href="#menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <script>
        
            $(document).ready(function () {
            //     $("body").click(function (event) {
            //         event.preventDefault();
            //         console.log("body clicked");
            //         $(".profile-drop-box").removeClass("show");
            //     });
                
                $("#profile_activator").click(function () {
                    console.log("activator clicked");
                    $(".profile-drop-box").toggleClass("show");
                });
            });
        //     $(document).ready(function() {
        //       		let counter = 1;
                    
        			
        					
        // 			console.log(counter);
        // 				// Add click event listener to button
        // 				$("#profile_activator").click(function(event) {
        // 					console.log("activator clicked");
        // 					$(".profile-drop-box").toggleClass("show");
        // 					counter++;
        // 				});
        				
        // 			}
        			
        // 			else {
        // 				// Add click event listener to body
        // 				$("body").click(function (event) {
        // 					event.preventDefault();
        // 					console.log("body clicked");
        // 					$(".profile-drop-box").removeClass("show");
        // 					counter--;
        // 				});
        // 			}
        // 		});
            
			// Add click event listener to button
// 			$("#profile_activator").click(function(event) {
// 				event.preventDefault(); // prevent default behavior of the button
// 				console.log("activator clicked");
// 				$(".profile-drop-box").toggleClass("show");
// 			});

// 			// Add click event listener to body
// 			$("body").click(function() {
// 				if ($(".profile-drop-box").hasClass("show")) {
// 					console.log("body clicked");
// 					$(".profile-drop-box").removeClass("show");
// 				}
// 			});
// 		});
        </script>
        <div class="profile-drop-box">
            <div class="bg-h30">
                <div class="logout_btn">
                    <div class="details">
                        <h2><b><?php if($_SESSION['currentUserType'] == 'Employee'){
                                    echo $_SESSION['webUser']['name'];
                                    }else{
                                        echo $functions->UserName($_SESSION['currentUser']);
                                    }?></b></h2>
                        <a class="box_head"><span class="__cf_email__"><?php echo $_SESSION['webUser']['email']?></span></a>
                        <p class="box_head" style="width: 100%; text-align: center">
                            Role: <span><?php echo @$_SESSION['webUser']['role']?></span>
                        </p>
                    </div>
                    <div class="buttons">
                        <button onclick="window.location='<?php echo WEB_URL; ?>/logout';">
                            <i class="material-symbols-outlined">logout</i>
                        </button>
                        <br>
                        <form method="post" title="Reset">
                        <button type="submit" name="reset">
                            <i class="material-symbols-outlined">restart_alt</i>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
            <img src="<?php echo WEB_URL; ?>/webImages/download.png">

            <hr>
            <?php if($_SESSION['currentUserType'] != 'Employee'|| isset($_POST['change-session']) || isset($_SESSION['practiceUser']) ){ ?>
            <a class="flex_" href="<?php echo WEB_URL; ?>/allmeter">
                <p>Master Profile</p>
                <i class="bx bx-note"></i>
            </a>
            <?php }?>
            <a class="flex_" href="<?php echo WEB_URL; ?>/profile?page=Profile">
                <p>Profile</p>
                <i class="bx bx-user"></i>
            </a>
            <hr>
            <a class="flex_" href="<?php echo WEB_URL; ?>/faq">
                <p>FAQ</p>
                <i class="fas fa-info"></i>
            </a>
            <a class="flex_" href="<?php echo WEB_URL; ?>/trashdata">
                <p>Trash Data</p>
                <i class="fas fa-eraser"></i>
            </a>
            <a class="flex_" href="<?php echo WEB_URL; ?>/checkinforget?type=checkinForget">
                <p>Forget To Check In</p>
                <i class="fa fa-user-circle"></i>
            </a>
            <a class="flex_" href="<?php echo WEB_URL; ?>/checkoutforget?type=checkoutForget">
                <p>Forget To Check Out</p>
                <i class="fa fa-user-circle"></i>
            </a>
        </div>

        <div class="fixed_side"></div>
        <div class="myevents-div">
            <div class="col5_close">
                <img src="<?php echo WEB_URL; ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
            </div>
            <!-- col5_close close -->
            
           <div id="loader">
                <img src="<?php echo WEB_URL; ?>/webImages/nav_logo.png" alt="Smart Dental Compliance">
            </div>
            <!-- loader -->
            <!--<div class="background_side">-->
            <!--</div>-->
            <!-- background_side close -->
            <div class="myevents-form"></div>
        </div>
        
        
<!--Notifications-->
        <div class="notifys notify">
        <div class="notify-top">
            <h3>Notifications</h3>
            <i class="fas material-symbols-outlined">close</i>
        </div>
        <ul>
            <?php
            $user = $_SESSION['webUser']['id'];
            $sql = "SELECT * from notification_record WHERE user = '$user' ORDER BY `id` DESC  LIMIT 10";
            $data = $dbF->getRows($sql);
            foreach ($data as $key => $value) {
            $type = translatefromserialize($value['type']);
            $notif = translatefromserialize($value['notification']);
            $date = date('d-M-Y',strtotime($value['Time']));
        
             if ($type =="aleave3siknes" ) {$type= "3 Sick Leave Alert";}
             if ($type =="aretunrtowprk" ) {$type= "Return To Work";}
             if ($type =="checkoutforget" ) {$type= "Check Out Forget";}
             if ($type =="leavesubmit" ) {$type= "Leave Submited";}
             if ($type =="uleave3siknes" ) {$type= "3 Sick Leave Alert";}
             if ($type =="uleavestatus" ) {$type= "Leave Status";}
             if ($type =="rotaP" ) {$type= "Rota published";}
             if ($type =="rotaA" ) {$type= "Rota Ammend";}
             if ($type =="echeckin" ) {$type= "Check in";}
             if ($type =="echeckout" ) {$type= "Check out ";}
             if ($type =="checkinbefore" ) {$type= "Check in Before";}
             if ($type =="echeckinlate" ) {$type= "Check in Late";}
             if ($type =="echeckoutlate" ) {$type= "Check out Late";}
             if ($type =="checkoutlate" ) {$type= "Check out Late";}
             if ($type =="uevent" ) {$type= "Events";}
             if ($type =="checkout" ) {$type= "Check out";}
             if ($type =="checkin" ) {$type= "Check in";}
             if ($type =="notlogin30" ) {$type= "Not logged in 30 days";}
             if ($type =="noti" ) {$type= "Notification";}
             if ($type =="covid" ) {$type= "Covid";}
             if ($type =="1warn" ) {$type= "1st Warning";}
             if ($type =="2warn" ) {$type= "2nd Warning";}
             if ($type =="3warn" ) {$type= "3rd Warning";}
             if ($type =="mto" ) {$type= "mto";}
             if ($type =="post" ) {$type= "Post";}
             if ($type =="recruitment" ) {$type= "Recruitment";}
             if ($type =="eventhasreminder" ) {$type= "Event has reminder";}
             if ($type =="completecpd" ) {$type= "CPD Completed";}
             if ($type =="mockactionplan" ) {$type= "Mock action plan";}
             if ($type =="certificateExpire" ) {$type= "certificate has been expire";}
             if ($type =="myeventtasks" ) {$type= "Event Task";}
             if ($type =="intranewpost" ) {$type= "Intranet new post";}
             if ($type =="intranewpost" ) {$type= "Intranet New Post";}
             if ($type =="CPD Completed" ) {$type= "CE Completed";}
       
            echo "<li><i class='i'>$date</i><b class='b'>$type</b>$notif</li>";
        }
        echo "<a style='display:inline-block;margin-top: 0;' class='submit_class' href='notif'>View All</a>" ;
        ?>
        </ul>
    </div>
