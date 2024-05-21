<?php
include_once("global.php");

global $dbF, $webClass;

$login = $webClass->userLoginCheck();
if (!$login) {
    header('Location: login');
}

include_once('header.php');
include 'dashboardheader.php';
?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            News
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'news'; include 'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
        <div class="pro-src-notif">
            <input type="text" id="pro-src-notif" class=""><i class="fas fa-search"></i>
            
            </div>
<?php
 if($_SESSION['currentUserType'] == 'Employee'){
                            $user = $_SESSION['superid'];
                        }
                        else{
                            $user = $_SESSION['currentUser'];
                       
                        }

   
    $sql  = "SELECT * from notification_record WHERE `user` = '$user'  ORDER BY `Time` DESC";
    $data = $dbF->getRows($sql,array($type));
    foreach ($data as $key => $value) {
        
        $id      = $value['id'];
        $type = translatefromserialize($value['type']);
        $notif = translatefromserialize($value['notification']);
        $date = date('d-M-Y',strtotime($value['Time']));
        $link    = WEB_URL . "/news?id=$id";
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
                
              'completecpd' ;
              
             if ($type == "notlogin30 " ) {$type= "Not logged in 30 days";}
             if ($type =="intranewpost" ) {$type= "Intranet New Post";}
        echo "<div class='notifall'>
          <h4>$date</h4><p><b>( $type )</b>&nbsp;&nbsp;$notif</p></div>";
          //<p>$type</p>
    }


?>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <?php include_once('footer.php');?>