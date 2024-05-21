<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

$msg  = "";
$chk  = $functions->eventsubmit();
$chk2 = $functions->eventedit();
$chk3 = $functions->myeventsubmit();
$chk4 = $functions->myeventedit();
$chk5 = $functions->myeventdelete();
$chk6 = $functions->bookingsend();
$chk7 = $functions->eventeditAll();
$chk8 = $functions->customlog();
if($chk){
    $msg = "Event Submit Successfully";
}
else if($chk2){
    $msg = "Event Edit Successfully";
}
else if($chk3){
    $msg = "Event Add Successfully";
}
else if($chk4){
    $msg = "Event Submit Successfully";
}
else if($chk5){
    $msg = "Event Delete Successfully";
}
else if($chk6){
    $msg = "Booking Successfully";
}
else if($chk7){
    $msg = "All Event Submit Successfully";
}
else if($chk8){
    $msg = "Custom Log Request Successfully Sent";
}
include'dashboardheader.php'; 

?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Calendar
        </div>
       
        <div class="right_side">
           
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-12 green_alert alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
          

        <h4 class="c4"> <?php echo _uc(@$_GET['type']); ?> <?php if(@$_GET['type']=="completed"){}else{echo "Over Due";}?> Compliance Activities.</h4>
        <h4 class="c4">Below are your <?php if(@$_GET['type']=="completed"){}else{echo "overdue";}?> <?php echo @$_GET['type']; ?> activities which can be completed on this page or through your activity calender.</h4>
 <div data-toggle="tooltip" title="Help Video" class="help" onclick="video('EJUtPIhK-Bg')"><i class="fa fa-question-circle"></i></div>
               
                <?php if($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['ccalendar'] == 'edit' || @$_SESSION['superUser']['ccalendar'] == 'full') { 
                    $sql = "SELECT * FROM `userevent` WHERE `due_date` = CURRENT_DATE() AND `due_date` != '' AND `approved`='-1' AND `user`='$_SESSION[currentUser]' AND `title_id` IN (SELECT `id` FROM `eventmanagement` WHERE `recurring_duration` IN ('1 day','1 week'))";
                    $data = $dbF->getRows($sql);
                    if(!empty($data)){
                ?>
               
                <?php }} ?>
                <div class="col44">
                    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                       
                           
        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true">
            <a href="#tabs-4" id="ui-id-1" class="ui-tabs-anchor" role="presentation" tabindex="-1">All <?php echo _uc(@$_GET['type']); ?> <?php if(@$_GET['type']=="completed"){}else{echo "OverDue";}?> Event  </a>
        </li>                       
        <li class="src-event">
            <div class="search">
                <input type="text" id="src-event"><i class="fas fa-search"></i>
            </div>
            <select class="tabs_dropdown" name="cm" id="cm">
                <?php 
                if(isset($_GET['type'])){
                $typ = htmlspecialchars($_GET['type']);

                }else{
                //$typ = "mandatory";
                $typ = "all";

                }
                echo $functions->allMandatoryOverDueEvent_user_Title($typ) 
                ?>
            </select>
        </li>
        </ul>
         <div id="tabs-4">
            <div class="col4_line">
          
                            <!-- col4_line close -->
                            <div class="col4_main">
                                <?php //echo $functions->allMandatoryOverDueEvent_user_Title($typ); ?>
                                <div class="col4_main_left ">
                                    <ul>
                                        <?php echo $functions->allMandatoryOverDueEvent_user($typ); ?>
                                    </ul>
                                </div>
                            </div>

                             

                            <!-- col4_main close -->
                        </div>
                     
                    </div>
                    <!-- tabs close -->
                    <div class="col4_txt_blue">
                        My Uploads
                    </div>
                    <!-- col4_txt_blue close -->
                    <div class="col4_txt_green">
                        Recommended
                    </div>
                    <!-- col4_txt_green close -->
                    <div class="col4_txt_red">
                        Mandatory
                    </div>
                    <!-- col4_txt_red close -->
                </div>
                <!-- col44 close -->
            </div>
            <!-- calendar -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->


<?php include_once('dashboardfooter.php'); ?>