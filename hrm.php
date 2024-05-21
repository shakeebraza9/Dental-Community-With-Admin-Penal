<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

$msg = "";
$chk1 = $functions->returnWork();
if($chk1){
    $msg = "Retutn Work Form Submit Successfully";
}

$chk2 = $functions->leiuInsert();
if($chk2){
    $msg = "Overtime Request Form Submit Successfully";
}

$chk3 = $functions->leiuUpdate();
if($chk3){
    $msg = "Overtime Request Form Update Successfully";
}

$chk4 = $functions->amendRota();
if($chk4){
    $msg = "Amend Requests Successfully";
}
$chk4 = $functions->documentInsert_profile_detail();
if($chk4){
    $msg = "Appraisal Reminder Document Insert Successfully";
}
include'dashboardheader.php';

$functions->pin();

$display = "";

$displayblock = '';
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
    // $display = 'style="display:none;"';
    // $displayblock = 'style="display:inline-block"';

}else{

    // $display = 'style="display: inline-block"';
    // $displayblock = 'style="display:none;"';
}

?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <!-- <div class="right_side hrm"> -->
             <?php if($msg !=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="right_side_top">
                <!-- <h3 class="main-heading_">HR Management</h3>
                <div class="change-session">
                    <?php //$functions->changeSession(); ?>
                </div> -->
                <!-- change-session -->
                <div class="jumbo hrm flex_">
                 <div class="jumbo-left"><div class="cpd-main-box">
                <div class="row mainClass">
                <?php 
                if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
                    $user = $_SESSION['currentUser'];
                    $totalHourSum = $extra = $less = $holidayEntitlement = 0;

                    $sql = "SELECT * FROM `record` WHERE `userId`='$user' AND `hour` !='0'";
                    $data = $dbF->getRows($sql);

                    foreach ($data as $key => $value) {

                        $totalHour = $value['hour'];
                        $hourWorked = $value['hourWorked'];
                        $holidayEntitlement += $hourWorked;
                        $totalHourSum += $totalHour;
                        if($value['rotaOff'] == 'Day Off'){
                            $hourWorked = $totalHour;
                        }
                        $total = abs($totalHour-$hourWorked);
                        if($totalHour <= $hourWorked){
                            $extra += $total; 
                        }
                        else{
                            $less += $total;
                        }
                    }

                    $leavesH = $dbF->getRow("SELECT SUM(`hours`) FROM `leaves` WHERE `user`='$user' AND `status`='Accepted'");
                    $lieuAll = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$user' AND `status`='Accepted'");
                    $lieuLess = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$user' AND `status`='Accepted' AND `type`='Late/Leave/Less'");

                    $holidayEntitlement = $holidayEntitlement - $leavesH[0];

                    $extra = $extra - $lieuAll[0];
                    if($extra<0){$extra=0;}

                    $less = $less - $lieuLess[0];

                    echo "<div class='col-md-4'>
                            <div class='cpd-inner-box hrm_box'>
                                <div class='cpd-box-content'>
                                    <h5>Weekly Hours Worked</h5>
                                    <h3>
                        <span data-toggle='tooltip' title='".$functions->decimal_to_time($totalHourSum)."'><b>$totalHourSum</b> (Total Hours)</span>
                        <span data-toggle='tooltip' title='".$functions->decimal_to_time($extra)."'><b>$extra</b> (Extra Hours)</span>
                        <span data-toggle='tooltip' title='".$functions->decimal_to_time($less)."'><b>$less</b> (Less Hours)</span>
                                    </h3>
                                </div>
                                <div class='imgdiv'>
                                   <span class='avatar_title'><img src='WEB_URL/webImages/hr-c.svg'></span>
                                </div>
                                    <div class='line'></div>
                                </div>
                            </div>";

                    $hours = (12.07 / 100)*$holidayEntitlement;

                    $data = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user' AND setting_name='hours_worked'");
                    $holiday = round((12.07 / 100)*($data[0]*52.14));

                    echo "<div class='col-md-4'>
                                <div class='cpd-inner-box hrm_box'>
                                    <div class='cpd-box-content'>
                                        <h5>Monthly Accumulated  Holiday</h5>
                            <h3 data-toggle='tooltip' title='".$functions->decimal_to_time($hours)."'>".round($hours,1)." Hours</h3>
                                        <h5>Annual Holiday Entitlement</h5>
                                        <h3>$holiday Days</h3>
                                    </div>
                                        <i class='fas fa-users'></i>
                                        <div class='line'></div>
                                    </div>
                                </div>";
                 }
                 ?>
                    <div class="col-md-4" <?php echo $display;?>>
                        <div class="cpd-inner-box hrm_box">
                            <div class="cpd-box-content">
                               
                                <h3>
                                    <?php echo $functions->totalUsers($_SESSION['currentUser']); ?>/<?php echo $functions->presentUsers($_SESSION['currentUser']); ?></h3>
                             <h5>Total Employees / Present Today</h5>
                            </div>
                            <div class="imgdiv">
                             <span class="avatar_title"><img src='<?= WEB_URL?>/webImages/required.png'></span>
                            </div>
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                    <div class="col-md-4" <?php echo $display;?>>
                        <div class="cpd-inner-box hrm_box">
                            <div class="cpd-box-content">
                           
                            <h3><?php echo $functions->pendingLeave($_SESSION['currentUser']); ?></h3>
                            <h5>Pending Leave Applications</h5>
                            </div>
                            <div class="imgdiv">
                             <span class="avatar_title"><img src='<?= WEB_URL?>/webImages/completed.png'></span>
                            </div>
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                    <div class="col-md-4">
                        <div class="cpd-inner-box hrm_box">
                            <div class="cpd-box-content">
                               
                                <h5><span>
                                        <?php echo "<b>".$functions->documentsCount('Training')."</b> (Training)<br><b>".$functions->documentsCount('Recruitment')."</b> (Recruitment)<br><b>".$functions->documentsCount('Signed Policies')?></b> (Signed Policies)</span></h5>
                             <h5>Your Pending Documents</h5>
                            </div>
                            <div class="imgdiv">
                             <span class="avatar_title"><img src='<?= WEB_URL?>/webImages/remaininghours.png'></span>
                            </div>
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>
                </div>
            </div>
            <!-- cpd-main-box --></div>
                <div class="jumbo-right">
                            <div class="jumbo-v">
                                <img src="webImages/jumbovideo.png">
                                <a onclick="video('EJUtPIhK-Bg')"><img src="webImages/jumbobtn.svg"></a>
                            </div>
                            <div><span>Play a Demo Video
                        </span></div>
                    </div>
                   
                </div>
                <!-- jumbo -->
            </div>
            <!-- right_side_top close -->

        <div class="right_side hrm">
            <div class="swap_flex">
                <div class="btn_sec">
                    <button class="submit_class" onclick="lieuform()">Overtime
                        Request Form</button>&nbsp;&nbsp;
                    
                   <button <?php echo $display; ?>   class='submit_class' onclick='employeeleaveform()'> Vacation Form</button>
                  <button  <?php echo $displayblock; ?>  class='submit_class' onclick='leaves()'>Leave Request Form</button>&nbsp;&nbsp;

                    <button <?php echo $display;?> style='display: inline-block;' class='submit_class' onclick='window.open("rotaStatus")'>Schedule Status</button>
                </div>
             <a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator"  class="submit_class"> Vacation Calculate</a>
         </div>
            <div class="hr-absence profile">
                <div class="p-heading"><h3>Leave Record</h3></div>
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#tabs-1"><?php $functions->absentRequestCount(10); ?> Absence Requests</a>
                        </li>
                        <li>
                            <a href="#tabs-2"><?php $functions->lieuRequestCount(); ?> Overtime Request</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-3"><?php $functions->absentTodayCount(); ?> Absent Today</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-4"><?php $functions->sickCount(); ?> Sick Today</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-5"><?php $functions->lateCount(); ?> Late Today</a>
                        </li>
                    </ul>
                    <!-- hr-absence-box -->
                    <div class="hr-absence-hub" id="tabs-1">
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th <?php // echo $display;?>>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Leave Hour</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th <?php ?>>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->absentRequest(10); ?>
                                </tbody>
                            </table>
                            <button class='submit_class' onclick='window.open("leaveDetail")'>View All</button>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-2">
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th <?php echo $display;?>>Employee</th>
                                        <th>Typeeeee</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Update Date Time</th>
                                        <th <?php echo $display;?>>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->lieuRequest(); ?>
                                </tbody>
                            </table>
                            <button style='display: inline-block;' class='submit_class' onclick='window.open("lieu")'>View All</button>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-3" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $functions->absentToday(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-4" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->sick(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub brn" id="tabs-5" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Checkin</th>
                                        <th>Late</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $functions->late(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                </div>
            </div>
            <!-- hr-absence -->
            <?php
                $user = $_SESSION['currentUser'];

                // Main User
                $sql = "SELECT * FROM `accounts_user` WHERE `acc_id`='$user' AND `acc_type`='1'";
                $data = $dbF->getRow($sql);
                $data2 = $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='account_type' AND `id_user`='$data[acc_id]'");
                $role = $data2[0];
                $data2 = $dbF->getRow("SELECT * FROM `record` WHERE `userId`='$data[acc_id]' AND `date`=CURDATE()");
                    $timeFrom   = @$data2['timeFrom'];
                    $timeTo     = @$data2['timeTo'];
                    $checkin    = @$data2['checkin'];
                    $checkout   = @$data2['checkout'];
                    $late = "";

                 @$iamge2 = "d-profile.png";
                 $imageuser = $data['acc_image'];
                  if ($imageuser == "#"||trim($imageuser) == "" ) 
                {
                  
                     $imageuser = @$image2;
                    $imageuser = "webImages/d-profile.png";
                 }
                 else
                 {

                    $imageuser =$functions->resizeImage($data['acc_image'], 'auto',400, false);

                 }

if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
        

         }else{
                echo "<div class='hrm-user main-user' $display>"; 

                         $fill_user   = $_SESSION['webUser']['id'];
         $sql = "SELECT COUNT(*)  FROM `leaves` WHERE `fill_user` = '$data[acc_id]' AND `type` ='Sick' AND MONTH(`dateTime`) = MONTH(CURRENT_DATE()) AND `status` IN ('accepted','Accepted')";
                        $row = $dbF->getRow($sql);
      if ($row[0] >= 3) {
//                         $functions->notifications('uleave3siknes',$fill_user,'3 Sick Leave Warning');
//                         $functions->notifications('aleave3siknes');

// $functions->setlog(" 3 sick Leave warning ",$functions->UserName($fill_user)." : ".$user,"",$user);
                           
                           echo '<img style="margin-left: -100px;margin-right: 65px;width: 50px;height: 50px;" src="'.WEB_URL.'/webImages/sick.png" >';
                       }

                      echo "<span class='hr_role'><i class='fa-solid fa-user-shield'></i> $role</span>
                      <div class='hr_flex'>
                      <div class='hrm-user-img'>
                            <img src='$imageuser'>
                        </div>
                        <!-- hrm-user-img -->
                            <div class='main-user-name'>
                                <h4>$data[acc_name]</h4>
                            </div>
                            </div>
                        <ul>
                            <li class='bold'>Rota:</li>";
                            if(@$data2['rotaOff'] == 'Holiday' || @$data2['rotaOff'] == 'Sick' || @$data2['rotaOff'] == 'Day Off'){
                                echo "<li>$data2[rotaOff]</li><br>";
                            } else if($timeFrom == '00:00' && $timeTo == '00:00' || empty($timeFrom)){
                                echo "<li>N|A </li><br>";
                            } else{
                                echo "<li>$timeFrom - $timeTo </li><br>";
                            }
                            if(@$data2['checkin'] != ''){
                                $time1 = new DateTime($data2['timeFrom']);
                                $time2 = new DateTime($data2['checkin']);
                                $timediff = $time1->diff($time2);
                                $late = $timediff->format('%h hour %i minute')."<br/>";
                                if($data2['checkout'] == ''){
                                    $checkout = 'Present ';
                                }
                                echo "<li class='bold'>Time In / Out:</li>
                                    <li>$checkin - $checkout</li><br>";
                                }
                                if($late > $timeFrom && ($timeFrom != '00:00' && !empty($timeFrom))){
                                    echo "<li class='bold'>Late: </li>
                                    <li>$late</li><br>";
                                }    
                            echo "</ul>
                        </div>
                        <!-- main-user -->
                        <div class='hrm-users'>";

                // All Users
$sql = "SELECT * FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND acc_type='1'";
                $data = $dbF->getRows($sql);
                foreach ($data as $value) {
                    $style = "";
                    $data2 =  $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$value[acc_id]' AND setting_name='role'");
                    $role = @$data2[0];
                    $data2 = $dbF->getRow("SELECT * FROM `record` WHERE `userId`='$value[acc_id]' AND `date`=CURDATE()");
                    $data3 = $dbF->getRow("SELECT COUNT(*) FROM `leaves` WHERE `type`='Sick' AND `status`='accepted' AND `user`='$value[acc_id]' AND YEAR(`dateTime`) = YEAR(CURDATE())");
                    if($data3[0] == '3'){
                        $style = "style='border-color: #f00;background-color: rgba(255, 0, 0, 0.2)'";
                    }

                    $timeFrom   = @$data2['timeFrom'];
                    $timeTo     = @$data2['timeTo'];
                    $checkin    = @$data2['checkin'];
                    $checkout   = @$data2['checkout'];
                    $late = "";

                 $iamge2 = "d-profile.png";
                 $imageuser = $value['acc_image'];
                  if ($imageuser == "#"||trim($imageuser) == "" ) 
                {
                  
                     @$imageuser = @$image2;
                    $imageuser = "webImages/d-profile.png";
                 }
                 else
                 {

                    $imageuser =$functions->resizeImage($value['acc_image'], 'auto',400, false);

                 }

                    echo "<div class='hrm-user' $style>";
 $fill_user   = $_SESSION['webUser']['id'];
 $user   = $_SESSION['currentUser'];
         $sql = "SELECT COUNT(*)  FROM `leaves` WHERE `fill_user` = '$value[acc_id]' AND `type` ='Sick' AND MONTH(`dateTime`) = MONTH(CURRENT_DATE()) AND `status` IN ('accepted','Accepted')";
                        $row = $dbF->getRow($sql);
      if ($row[0] >= 3) {
        $sql1 = "SELECT *  FROM `notification_record` WHERE `user` = '$value[acc_id]' AND `type` = 'uleave3siknes' AND MONTH(`Time`) = MONTH(CURRENT_DATE())";
            $row2 = $dbF->getRow($sql1);
//         if (empty($row2[0])) {
//                         $functions->notifications('uleave3siknes',$value['acc_id']);
//                         $functions->notifications('aleave3siknes',$value['acc_id']);
//         }
                        
// $functions->setlog(" 3 sick Leave warning ",$functions->UserName($fill_user)." : ".$user,"",$user);
                           
                           echo '<img style="margin-right: -2px;width: 50px;height: 50px;" src="'.WEB_URL.'/webImages/sick.png" >';
                       
                     }
                     if($role == "Dentist" || $role == "Dental Nurse"){
                        $doc_rol = "<span class='doc_role'><i class='fa-solid fa-user-doctor'></i> $role</span>";
                     }else{
                        $doc_rol = "<span class='othr_role'><i class='fa-solid fa-user-pen'></i> $role</span>";
                     }
                    
                   echo "
                   $doc_rol
                   <div class='hrm-user-img'>
                            <img src='$imageuser'>
                        </div>
                        <!-- hrm-user-img -->
                        <h4>$value[acc_name]</h4>
                        <ul>
                            <li class='bold'>Rota:</li>";
                            if(@$data2['rotaOff'] == 'Holiday' || @$data2['rotaOff'] == 'Sick' || @$data2['rotaOff'] == 'Day Off'){
                                echo "<li>$data2[rotaOff]</li><br>";
                            } else if($timeFrom == '00:00' && $timeTo == '00:00' || empty($timeFrom)){
                                echo "<li>N|A</li><br>";
                            } else{
                                echo "<li>$timeFrom - $timeTo</li><br>";
                            }
                            if(@$data2['checkin'] != ''){
                                $time1 = new DateTime($data2['timeFrom']);
                                $time2 = new DateTime($data2['checkin']);
                                $timediff = $time1->diff($time2);
                                $late = $timediff->format('%h hour %i minute')."<br/>";
                                if($data2['checkout'] == ''){
                                    $checkout = 'Present';
                                }
                                echo "<li class='bold'>Time In / Out:</li>
                                    <li>$checkin - $checkout</li><br>";
                                }
                            if($late > $timeFrom && ($timeFrom != '00:00' && !empty($timeFrom))){
                                echo "<li class='bold'>Late:</li>
                                <li>$late</li>";
                            }    
                            echo "</ul>
                        </div>
                        <!-- hrm-user -->";
                    }
                    ?>
        </div>
        <!-- hrm-users -->
        <?php } ?>
        <?php
        if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>
        <h4>Your Rota Status</h4>
        <div class="cpd-table">
                <div class="cpd-tbl">
                    <table>
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user = $_SESSION['superid'];
                            $sql = "SELECT * FROM `rotaStatus` WHERE `user`='$user' LIMIT 10";
                            $data = $dbF->getRows($sql);
                            foreach ($data as $key => $value) {
                            $date = date('d-M-Y',strtotime($value['week']))."&nbsp;&nbsp;to&nbsp;&nbsp;".date('d-M-Y',strtotime("$value[week] +7 day"));
                            echo "<tr>
                                    <td>$date</td>
                                    <td>$value[status]</td>
                                    <td><button style='display: inline-block;' class='edit_btn cr' id='$value[id]'>Confirm</button>&nbsp;&nbsp;
                                        <button style='display: inline-block;' class='edit_btn' id='$value[id]' onclick='amendRota(this.id)'>Request Amendment</button></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        <?php } ?>
        <h4>Team Schedule</h4>
        <div class="calendar">
            <div id='calendar'></div>
        </div>
    </div>
    <!-- close -->
</div>
</div>
<!-- right_side close -->
<!-- </div> -->
<!-- left_right_side -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.js"></script>
<script>
$(".cr").on('click', function() {
    id = this.id;
    self = this;
    $.ajax({
        type: 'post',
        data: {id:id},
        url: 'ajax_call.php?page=rotaStatus',                
    }).done(function(data) {
        if (data == '1') {
            $(self).html('Confirm&nbsp;&nbsp;<i class="far fa-check-circle"></i>');
            $(self).parents('tr').find('td:nth-child(2)').text('Confirm');
        }
    });
});

$('#calendar').fullCalendar({
    header: {
        theme: true,
        left: 'prev,title,next ',
        center: '',
        right: 'month,basicWeek,basicDay,today'
    },
     eventMouseover: function(data, event) {
        if (data.sqltype == 'ROTA') 
        {
            
            // if (data.color == '') 
            // {
            //     data.color = '#01abbf'
            // }
            if (data.d_title == 'NULL') 
            {
                data.d_title = 'N/A'
            }

        //  tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.title + '<br>Title : ' + data.n_title + '<br>Dentist Name : ' + data.d_title + '<br>Rota Time: ' + data.RotaTime + '<br>Rota Comment: ' + data.rotaComment + '<br></div>'; 
         
          tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.title} <br><span>Title :</span>  ${data.d_title} <br><span>Rota Time :</span>   ${data.RotaTime}<br><span>Rota Comment :</span>   ${data.rotaComment}   </div></div>`;
         
         
        }
        else if(data.sqltype == 'LEAVES') {
          
         
         
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.n_name +'<br>title : ' + data.title +'<br>From : ' + data.fdate + '<br>To : ' + data.tdate + '<br>type : ' + data.type + '<br>Status : ' + data.status + '</div>';
        
        
              tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.n_name} <br><span>title :</span>  ${data.title} <br><span>From :</span>   ${data.fdate}<br><span>To :</span>   ${data.tdate}<br><span>type :</span>   ${data.type}<br><span>Status :</span>   ${data.status}   </div></div>`;
        
        
        }
        else if(data.anytype == 'anyv') {
          
         // var d = new Date(data.start);
             var date = new Date(data.start);
           var dateString = new Date(date.getTime() - (date.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];

// console.log(dateString);
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.n_name +'<br>title : ' + data.title +'<br>Date: ' + dateString + '</div>';
        
        tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.n_name} <br><span>title :</span>  ${data.title} <br><span>Date :</span>   ${dateString}</div></div>`;
        
        
        }
        else if(data.birth == 'bday') {
          
        var date = new Date(data.start);
           var dateString = new Date(date.getTime() - (date.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];

        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.n_name +'<br>title : ' + data.title +'<br>Date: ' + dateString + '</div>';
        
        tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.n_name} <br><span>title :</span>  ${data.title} <br><span>Date :</span>   ${dateString}</div></div>`;
        
        
        }
         else if(data.appr == 'apr') {
          
         // var d = new Date(data.start);
             var date = new Date(data.start);
           var dateString = new Date(date.getTime() - (date.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];

         // console.log(dateString);
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.n_name +'<br>title : ' + data.title +'<br>Date: ' + dateString + '</div>';
        
         tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.n_name} <br><span>title :</span>  ${data.title} <br><span>Date :</span>   ${dateString}</div></div>`;
        
        }
        $("body").append(tooltip);
     
        $(this).mouseover(function(e) {
            $('.tooltiptopicevent').fadeIn('500');
            $('.tooltiptopicevent').fadeTo('10', 1.9);
        }).mousemove(function(e) {
            $('.tooltiptopicevent').css('top', e.pageY + 10);
            $('.tooltiptopicevent').css('left', e.pageX + 20);
        });

    },
    eventMouseout: function(data, event) {
        $(this).css('z-index', 8);
        $('.tooltiptopicevent').remove();

    },
    columnFormat: {
        week: 'D-MMM-YYYY\ndddd',
    },            
    firstDay: 1,
    defaultView: 'month',
    editable: false,
    eventLimit: true, // allow "more" link when too many events
    eventRender: function(event, element) {
        element.attr('id', event.id);
        element.attr('onclick', event.click);
        element.attr('data-type', event.type);
    },
    events: <?php echo $functions->UsersCalendar() ?>,
    // eventAfterAllRender: function() {
    //     $('.fc-head thead tr').prepend('<th class="fc-day-header fc-widget-header fc-sun">Image</th>');
    //     $('.fc-bg tbody tr').prepend('<td></td>');
    // },
    // eventAfterRender: function(event, element) {
    //     var data = element.parents('.fc-body .fc-content-skeleton table tbody tr').html();
    //     element.parents('.fc-body .fc-content-skeleton table tbody tr').html('<td class="fc-event-container"><img  src="images/' + event.image + '"></td>' + data);
    // }
});
  function AjaxDelScript(ths){
             btn=$(ths);
            console.log(btn);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteleave',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
           $(ths).remove();
        });
          }else{
        alert('Invalid ID.');
          }
                   
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
            }
        };


        //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }

</script>
<?php include_once('dashboardfooter.php'); ?>