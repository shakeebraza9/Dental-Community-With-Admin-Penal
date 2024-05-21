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
        <!--<div class="link_menu">-->
        <!--    <span>-->
        <!--        <img src="webImages/menu.png" alt="">-->
        <!--    </span>-->
        <!--    Holiday Entitlement-->
        <!--</div>-->
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_">Staff Holiday Entitlement</h3>
            <div class="cpd-main-box">
                <div class="row mainClass">
                    <?php
                    // $user = $_SESSION['currentUser'];
                    $user = $_SESSION['webUser']['id'];
                    $totalHourSum = $extra = $less = $holidayEntitlement = $whours = 0;
                    $d = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user' AND setting_name='start_date'");
                    $start_date = date('Y-m-d',strtotime($d[0]));
                    $sql = "SELECT * FROM `record` WHERE `userId`='$user' AND `hour` !='0' AND `date` BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) AND CURDATE() AND `date`>'$start_date'";
                    $data = $dbF->getRows($sql);

                    foreach ($data as $key => $value) {

                        $totalHour = $value['hour'];
                        
            if((empty($value['hourWorked']) || $value['hourWorked'] == '0') && $value['checkin'] != ''){
                            $time1 = strtotime($value['checkin']);
                            $time2 = strtotime($value['timeTo']);
                            $breaktime = date("G",strtotime($value['breakTime']))*60*60 + date("i",strtotime($value['breakTime']))*60;
                            $whours += round(abs($time2 - $time1 - $breaktime) / 3600,2);
                            $hourWorked = round(abs($time2 - $time1 - $breaktime) / 3600,2);
                        }
                        else{
                            $whours += $value['hourWorked'];
                            $hourWorked = $value['hourWorked'];
                        }

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

                    $leavesH = $dbF->getRow("SELECT SUM(`hours`) FROM `leaves` WHERE `user`='$user' AND `status`='Accepted' AND `type`='Annual Leave'");
                    $lieuAll = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$user' AND `status`='Accepted'");
                    $lieuLess = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$user' AND `status`='Accepted' AND `type`='Late/Leave/Less'");

                    // $holidayEntitlement = $holidayEntitlement - $leavesH[0];

                    $extra = $extra - $lieuAll[0];

                    $less = $less - $lieuLess[0];
                    
                    if($d[0] == ''){
                        $holidayEntitlement = $extra = $less = $whours = $totalHourSum = 0;
                    }
                    
                    echo "<div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Monthly Hours Worked</h5>
                                    <h3>
                                        <!--<span><b>$totalHourSum</b> (Total Hours)</span>-->
                                        <span><b>$whours</b> (Hours Worked according to check in and out)</span>
                                        <span><b>$extra</b> (Overtime)</span>
                                        <!--<span><b>$less</b> (Less Hours)</span>-->
                                    </h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    
                                </div>
                            </div>";
                 
                    $hours = (12.07 / 100)*$holidayEntitlement;

                    echo "<div class='col-md-4'>
                                <div class='cpd-inner-box'>
                                    <div class='cpd-box-content'>
                                        <h5>Monthly Holiday Entitlement<br><span>(according to worked hours)</span></h5>
                                        <h3>".round($hours,1)." Hours</h3>
                                    </div>
                                        <img src='webImages/hr-c.svg'>
                                        
                                    </div>
                                </div>";

                    $hw = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user' AND setting_name='hours_worked'");
                    $he = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user' AND setting_name='holiday_entitlement'");  

                    



   $start_date;  
  $sdate = $start_date;
  $date  =  date('Y-m-d');
//echo "<br>";
 $EndDate = "";
  $startDateNew =(date('Y',strtotime($date))).date('-m-d',strtotime($sdate));
  @$EndDate  =(date('Y',strtotime($date))).date('-m-d',strtotime($sdate));


if ($startDateNew > $date) {
   $startDateNew = date("Y-m-d", strtotime("-1 year", strtotime($startDateNew)));
   $startDateNew = date("Y-m-d", strtotime("-1 day", strtotime( $startDateNew)));
}
elseif( $date >$startDateNew )
{

$EndDate  =date("Y-m-d", strtotime("+1 year", strtotime( $startDateNew)));
$EndDate  =date("Y-m-d", strtotime("-1 day", strtotime( $EndDate)));

}
else{
  
}



$userfill = $_SESSION['webUser']['id'];
$user = $_SESSION['currentUser'];
 // $tk = $dbF->getRow("SELECT COUNT(*) FROM `leaves` WHERE `user`='$user' AND `fill_user` = '$userfill' AND DATE_FORMAT(`dateTime`,'%Y-%m-%d') > '$EndDate' AND  `status`='Accepted' AND `type`='Annual Leave'"); 

    $tk2 = $dbF->getRows("SELECT * FROM `leaves` WHERE `user`='$user' AND `fill_user` = '$userfill' AND `status`='Accepted' AND `type`='Annual Leave'");
    
    $tk3 = $dbF->getRows("SELECT * FROM `leaves` WHERE `user`='$user' AND `fill_user` = '$userfill' AND `status`='Accepted' AND `type`='Annual Leave' AND YEAR(from_date) = YEAR(CURRENT_DATE())");


$day = 0;
$total = 0;
$cur_total = 0;
//echo "P start date".$startDateNew;
//echo "<br>";
//echo "P end date".$EndDate;
//echo "<br>";
foreach ($tk2 as  $val) {

$from_date = $val['from_date'];
$to_date = $val['to_date'];



$diff = abs(strtotime($to_date) - strtotime($from_date));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

// $days;
$j = $days;
// var_dump($j);
$num = 0;

while($num <= $j) {
                    
     $from_date."<br>";
 
     if(strtotime($from_date) > strtotime($startDateNew) || $from_date < strtotime($EndDate)) {
         
        $num++;
    
        $from_date = date("Y-m-d",strtotime("+1 day", strtotime($from_date)));
      }
} 
//echo $num;

$total +=$num;

}


foreach ($tk3 as  $val2) {

$from_date = $val2['from_date'];
$to_date = $val2['to_date'];

$cur_diff = abs(strtotime($to_date) - strtotime($from_date));

$cur_years = floor($cur_diff / (365*60*60*24));
$cur_months = floor(($cur_diff - $cur_years * 365*60*60*24) / (30*60*60*24));
$cur_days = floor(($cur_diff - $cur_years * 365*60*60*24 - $cur_months*30*60*60*24)/ (60*60*24));

$cur_days;
$j = $cur_days;

$num = 0;

while($num <= $j) {
                    
     $from_date."<br>";
 
     if(strtotime($from_date) > strtotime($startDateNew) || $from_date < strtotime($EndDate)) {
         
        $num++;
    
        $from_date = date("Y-m-d",strtotime("+1 day", strtotime($from_date)));
      }
} 

$cur_total +=$num;

}



                    ?>
                        <div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Contracted Hours</h5>
                                    <h3><?php echo $hw[0] ?> Hours</h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    <div class='line'></div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Annual Holiday Entitlement</h5>
                                    <h3><?php echo $he[0] ?> Days</h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    <!--<div class='line'></div>-->
                            </div>
                        </div>
                        
                        <div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Current Year Holiday Taken</h5>
                                    <h3><?php echo  $cur_total ?> Days</h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    <!--<div class='line'></div>-->
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Current Year Holiday Remaining</h5>
                                    <h3><?php echo ($he[0] - $cur_total) ?> Days</h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    <!--<div class='line'></div>-->
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='cpd-inner-box'>
                                <div class='cpd-box-content'>
                                    <h5>Total Holiday Taken</h5>
                                    <h3><?php echo $total; ?> Days</h3>
                                </div>
                                    <img src='webImages/hr-c.svg'>
                                    <!--<div class='line'></div>-->
                            </div>
                        </div>
                        <!--<div class='col-md-4'>-->
                        <!--    <div class='cpd-inner-box'>-->
                        <!--        <div class='cpd-box-content'>-->
                        <!--            <h5>Holiday Remaining</h5>-->
                        <!--            <h3><?php echo ($he[0] - $total) ?> Days</h3>-->
                        <!--        </div>-->
                        <!--            <img src='webImages/hr-c.svg'>-->
                        <!--            <div class='line'></div>-->
                        <!--    </div>-->
                        <!--</div>-->
                </div>
                <button style="max-width: 188px;" class="submit_class" onclick="lieuform()">Overtime Request Form</button>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <style>
        .cpd-main-box .row > div{
            margin-bottom: 20px;
        }
    </style>
    <?php include_once('footer.php'); ?>