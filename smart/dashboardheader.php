<?php 
// if($_SERVER['HTTP_CF_CONNECTING_IP'] != '2407:aa80:15:ba93:7c40:95c3:9970:1a6b' || $_SERVER['HTTP_CF_CONNECTING_IP'] != '111.88.97.91'){
// header('location:under_construction.html');
    
// }
// echo $_SERVER['REMOTE_ADDR'];
// echo $_SERVER['SERVER_NAME'];
// if($_SERVER['HTTP_CF_CONNECTING_IP'] == '2407:aa80:15:9f4c:d9ac:3121:afe7:5f4e'||$_SERVER['REMOTE_ADDR'] == '103.217.177.248'){
//     echo $_SESSION['currentUserType']." :: ";
//     echo $_SESSION['currentUser']." :: ";
//     echo $_SESSION['allUsers']." :: ";
//     echo $_SESSION['superid']." :: ";
//     echo $_SESSION['webUser']['id']." :: <br>";
//     echo $_SESSION['webUser']['backup_Practice_id']." :: <br>";
//     echo $_SESSION['webUser']['backup_login_id']." :: <br><pre>";var_dump($_SESSION);
// }
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
if ($return == false) { 
    
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


// 
?>

<?php if(isset($_SESSION['setLogin'])){ }else{ ?>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
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
</script>
<?php }?>
<?php
$box20 = $webClass->getBox('box20');
if(!empty($box20['text'])){
?>
<div id="dialog" title="Notice">
  <p><?php echo $box20['text']; ?></p>
</div>
<?php }?>

<?php 


// notificataion record/////
 if($_SESSION['currentUserType'] == 'Employee'){
                            $user = $_SESSION['superid'];
                        }
                        else{
                            $user = $_SESSION['currentUser'];
                       
                        }

$onclick    = '';                   
$sqls = "SELECT COUNT(*) FROM `notification_record` WHERE user = '$user' AND `read` = 0 ";
$sqldatas = $dbF->getRow($sqls);
if ($sqldatas[0] >  0 ) {
    $onclick = 'onclick="readnotification(this.id);"';  

}
else{
    echo "<script>$('.num').remove();</script>";
}

?>


<div class="logo_print">
    <img src="webImages/aiom.svg">
</div>
<div class="header_bottom">
   <div class="flex_ h-100">  
        <div class="title"><div class="header_logo"><a href="<?php echo WEB_URL?>"><img src="webImages/aiom.svg"></a></div></div>  

        <div class="header_bottom_right">
            <!--if condion required-->
            

<?php
$user = $_SESSION['webUser']['id'];
// echo '<script>alert("'.$user.'")</script>';
// echo '<script>console.log("'.var_dump($_SESSION).'");</script>';
// var_dump($_SESSION);
$sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139)  AND  order_mandate != '' ";
$data =  $dbF->getRows($sql,array($user));

if($dbF->rowCount > 0 && $_SESSION['currentUserType'] != 'Employee'){
    ?>
<div class="upgrade-btn">
 <?php echo "<span>Upgrade</span>" . "<i class='fas fa-chevron-down'></i>";?>
</div>
<?php
}
?>
              <div data-toggle="tooltip" title="Sticky Notes" class="print stickybtn" onclick="stickynotesClick()"><img src="webImages/file_.svg"></div> 
            <div data-toggle="tooltip" title="Print" class="print" id="<?php echo $user ?>"  onclick="WindowPrint()" > <img src="webImages/printer_.svg"></div> 
            <div data-toggle="tooltip" title="Notifications" class="noti"><img src="webImages/Notification.svg"></div>  
            <span class="line"></span>  
           <!-- <div class="notif print" id="<?php echo $user ?>"  <?php echo $onclick ?> data-toggle="tooltip" title="Notification"><i class="fas fa-globe"></i>   
            <span class="num" ><p><?php  echo $sqldatas[0] ?> </p></span></div> -->

<script>
    function readnotification(user){
        user = user;
        $.ajax({
                type: 'post',
                data: {
                 user: user
                },
                url: 'ajaxnotif',
            }).done(function(data) {
                console.log(data);
                if (data == '2') {
                   $('.num').remove();
                } else {
                  
                    console.log("not");
                }
            });
        }
</script>
<?php
if($_SESSION['webUser']['image']=="#" || $_SESSION['webUser']['image']==""){
  $image='profile_blank.jpg';
}else{
  $image=$_SESSION['webUser']['image'];
}
?>
            <div class="login_side">
                <div class="radiuse-img"><img src="<?php echo  WEB_URL.'/images/'.$image?>"></div> 
                      <div> 
                     <a href="<?php echo WEB_URL; ?>/profile?page=Profile"><h2>  <?php echo $_SESSION['webUser']['name']?> </h2> </a> 
                  <a href="<?php echo WEB_URL; ?>/practice-profile">Practice Profile</a>  
                   </div> 
                
                <!--<a class="logout-mobile" href="<?php echo WEB_URL; ?>/logout">Log out <span><img src="<?php echo WEB_URL; ?>/webImages/2.png" alt=""></span></a>--> 
            </div>  
                 <span onclick="profle_drop_open();" class="profile-drop"><i class="fas fa-chevron-down"></i></span>  
                        <div class="link_menu link_menu__" >  
                <span>  
                    <img src="webImages/menu.png" alt=""> 
                </span> 
            </div>  
            <!-- login_side close --> 
            <!--<div class="account_btn">-->  
            <!--    <ul>--> 
            <!--        <li><a href="<?php echo WEB_URL; ?>/practice-profile">Practice Profile <span><img src="webImages/pp.png" alt=""></span></a></li>--> 
            <!--        <li><a href="<?php echo WEB_URL; ?>/logout">Log out <span><img src="<?php echo WEB_URL; ?>/webImages/2.png" alt=""></span></a></li>-->  
            <!--    </ul>-->  
            <!--</div>-->
            <!-- account_btn close -->
        </div>
        <!-- header_bottom_right close -->
    </div>
    <!-- standard close -->
</div>
<!-- header_bottom close -->
<!--profile drop box start--> 
        <div class="profile_box_full"></div>  
        <div class="profile-drop-box">  
            <div class="bg-h30"></div>  
            <img src="<?php echo  WEB_URL.'/images/'.$image?>">  
            <h2> <b><?php
            // var_dump($_SESSION['webUser']);
             echo $_SESSION['webUser']['name']?></b></h2> 
            <a><?php echo $_SESSION['webUser']['email']?></a> 
            <p>Role: <span><?php echo $_SESSION['webUser']['role']?></span></p> 
            <hr>  
           <a class="flex_" href="<?php echo WEB_URL; ?>/practice-profile"><p>Practice Profile</p><i class="fas fa-file"></i></a> 
           <a class="flex_" href="<?php echo WEB_URL; ?>/profile?page=Profile"><p>Profile</p><i class="fas fa-user"></i></a> 
           <a class="flex_" href="<?php echo WEB_URL; ?>/logout"><p>Logout</p><i class="fas fa-sign-out-alt"></i></a> 
        </div>  
        <script>  
        let element = document.querySelector(".profile_box_full");  
        
          function profle_drop_open(){  
            element.classList.add("profileopen"); 
          } 
          $(".profile_box_full").click(function(){  
            element.classList.remove("profileopen");  
        }); 
        </script> 
        <!--profile drop box close-->
<div class="fixed_side"></div>
<div class="myevents-div">
    <div class="col5_close">
        <img src="<?php echo WEB_URL; ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
    </div>
    <!-- col5_close close -->
    
   <div id="loader">
        <img src="<?php echo WEB_URL; ?>/webImages/logo.png?magic=01" alt="Smart Dental Compliance">
    </div>
    <!-- loader -->
    <!--<div class="background_side">-->
    <!--</div>-->
    <!-- background_side close -->
    <div class="myevents-form"></div>
</div>
<!-- col5 close -->
  <div id="contentSticky" class="contentSticky" style="display: none;">
         <div class="_notes">
      <div class="print createstk" id="create_note" style="top: 47px;right: 1%;z-index: 9;position: absolute;"><i class="fas fa-plus"></i></div>
        <div class="print col5_close col5_close_sticky closestk" style="position: absolute;right: 5%;top: 47px;cursor: pointer;z-index: 9;"><i class="fas fa-arrow-alt-circle-left"></i></div>
        
   </div>

    </div>
    <div id="confirm">
        <!-- <h1 style="display: none;">Hello</h1> -->
    </div>
<!-- Sticky -->
<!-- Sticky -->
<div class="notifys notify sNotif">
    <div class="notify-top">
        <h3>Notifications</h3>
        <i class="fas fa-times"></i>
    </div>
    <a href="javascript:;" class="generalnotif">general notification</a>
    <ul>
        <?php
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
             
            echo "<li><i class='i'>$date</i><b class='b'>$type</b>$notif</li>";
        }
        echo "<a style='display:inline-block;margin-top: 0;' class='submit_class' href='notif'>View All</a>" ;
        ?>
    </ul>
</div>
<!-- Notifications -->
<div class="notify gNotif">
    <div class="notify-top">
        <h3>Notifications</h3>
        <i class="fas fa-times"></i>
    </div>
    <a href="javascript:;" class="staffnotif">staff notification</a>
    <ul>
        <?php
        $sql = "SELECT * from news where publish = 1 AND type='noti' ORDER BY `date` DESC LIMIT 10";
        $data = $dbF->getRows($sql);
        foreach ($data as $key => $value) {
            $heading = translatefromserialize($value['heading']);
            $sdesc = translatefromserialize($value['shortDesc']);
            $date = date('d-M-Y',strtotime($value['date']));
            $ldesc = translatefromserialize($value['dsc']);
            echo "<li><i class='i'>$date</i><b class='b'>$heading</b>$sdesc<br>$ldesc</li>";
        }
        echo "<a style='display:inline-block;margin-top: 0;' class='submit_class' href='news?type=noti'>View All</a>";
        ?>
    </ul>
</div>

<script>
    
$(".generalnotif").click(function(){
    $('.sNotif').hide();
    $('.gNotif').show();
})

$(".staffnotif").click(function(){
    $('.gNotif').hide();
    $('.sNotif').show()
})
    
</script>

<div class="consult-box">
<?php
 if($_SESSION['productid']=='90')
 {
    echo "Upgrade your app to <span>SMART CONSULT</span><a href='javascript:void(0)' class='upgrade-btn_popup'>Upgrade</a>". "<span class ='cross'>x</span>";

 }else{
   echo "Upgrade your app to <span>PLATINUM COMPLIANCE</span><a href='javascript:void(0)' class='upgrade-btn_popup'>Upgrade</a>". "<span class ='cross'>x</span>";

 }
// 
// $box1 = $webClass->getBox("box1");
// echo $box1['heading2'] ."<a href='javascript:void(0)' class='upgrade-btn_popup'>Upgrade</a>". "<span class ='cross'>x</span>";
?>
 </div> 
<!-- Notifications -->
<div class="offline">
    You are currently offline
</div>
<!-- offline -->
<?php
$box19 = $webClass->getBox("box19");

?>
<style>

.notify a{
    padding: 2px 10px;
    background-color: #6f42c1;
    color: white;
    display: block;
    width: fit-content;
    border-radius: 5px;
    float: right;
    margin: 5px;
}

    .num {
      font-size: 14px;
    position: absolute;
    /*right: 280px;*/
    top: 2px;
    border-radius: 34px 28px;
    color: #fff;
    padding: 0px;
    box-shadow: inset 0 -3em 3em rgb(218 22 22), 0 0 0 2px rgb(202 159 159), 0.3em 0.3em 1em rgb(234 10 10 / 11%);
    width: 25px;
    height: 25px;
    font-weight: bolder;
}
.main_container {
    overflow: visible;
}

header .logo_side {
    transform: scale(.7);
    transform-origin: top left;
    vertical-align: top;
}

.col1_btn_main {
    display: none;
}

.inner_banner {
    display: none;
}

.header_side {
    height: 100px;
}

.header_top {
    background-image: url(<?php echo $box19['image']; ?>);
    background-size: cover;
    padding: 15px 0 0;
}

.col10 {
    padding-top: 40px;
}

.logo_print{
    display:none;
}




</style>