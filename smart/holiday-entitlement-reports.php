<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}  

if(!isset($_GET['date_hreport']) && !isset($_GET['date2_hreport'])){
    $_GET['date_hreport'] = date('Y').'-01-01';
    $_GET['date2_hreport'] = date('Y').'-12-31';
}

// var_dump($_SESSION['superid']);



                    // $user = $_SESSION['currentUser'];
                    



                      // $user =  $_SESSION['webUser']['id'];
                            // $SuperUserAccess = $dbF->getRow("SELECT allow FROM superUser WHERE user='$user' AND type='superuser_access'");
                            //echo "<h1>" . print_r($SuperUserAccess) . "</hr>";
                            // $SuperUserAccess = $SuperUserAccess['allow'];
                            //echo "<h1>" . $SuperUserAccess ."</h1>";
                            // $data = $dbF->getRows($sql);
        if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
              $user = $_SESSION['superid'];
        }
    else{
      $user = $_SESSION['currentUser'];
        }

    $sql1  = "SELECT * FROM `accounts_user` WHERE  `acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND `acc_type`='1'";

                            $data1 = $dbF->getRows($sql1);
                            
                                

?>
 
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            COVID Screening
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side">
            <div class="form-group">
                <h2> Holiday Entitlement Reports </h2>
                    <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>
              <form action="holiday-entitlement-reports" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>Date From</label>
                    <input class="" id="from" type="text" name="date_hreport" value="<?php if(empty(@$_GET['date_hreport'])) echo @$_GET['date2_hreport']; else echo @$_GET['date_hreport']; ?>" autocomplete="off" >
                        </div>
                        <div class="form-group col-12 col-md-6" >
                            <label>Date To </label>

                              <input class="" id="tto" type="text" name="date2_hreport" value="<?php echo @$_GET['date2_hreport'] ?>" autocomplete="off" >
                        </div>
                        <div class="form-group col-12">
                            <input style="margin-top: 0" type="submit" class="submit_class" value="Show Report" name="submit">
                        </div>
                    </div>
                </form>
                  <a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator"  data-toggle='tooltip' title='Click Go Holiday Entitlement Calculate' style="float: right;font-size: 30px;width: 57px;margin-top: -24px;"> <i class="fas fa-calculator"></i> </a>
            <div class="cpd-table">
                <div class="cpd-tbl datable">
                    <table>
                        <thead>
                            <tr>
                                <th>Name of Employee</th>
                                <th>Monthly Hours Worked</th>
                                <th>Monthly Holiday Entitlement </th>
                                <th>Contracted Hours</th>
                                <th>Annual Holiday Entitlement</th>
                                <th>Holiday Taken</th>
                                <th>Holiday Remaining</th> 
                               <!--  <th>Overtime</th>
                                <th>Annual Holiday Entitlement</th>---->
                                



                            </tr>
                        </thead>
                        <tbody>
                           
                           
                           

          <?php foreach ($data1 as $key => $value1){ 

                    if (!empty($_GET['date_hreport'])) {
                        // echo $_GET['date_hreport'];
                        $datereport  = date('Y-m-d',strtotime($_GET['date_hreport']));
                    }
                    else{
                          $datereport  = date('Y-m-d');
                    }

                    if (!empty($_GET['date2_hreport'])) {
                          
                          $datereport2 = date('Y-m-d',strtotime($_GET['date2_hreport']));
                    }
                    else  {
                          $datereport2 =  date('Y-m-d');
                    }

                     $user =  $value1['acc_id'];
                    $totalHourSum = $extra = $less = $holidayEntitlement = $whours = 0;
                    $d = $dbF->getRow("SELECT setting_val FROM accounts_user_detail WHERE id_user='$user' AND setting_name='start_date'");



                    if($d['setting_val'] != ""){




                    $start_date = date('Y-m-d',strtotime($d[0]));
                    $sql = "SELECT * FROM `record` WHERE `userId`='$value1[acc_id]' AND `hour` !='0' AND `date` BETWEEN DATE_SUB('$datereport', INTERVAL DAYOFMONTH('$datereport')-1 DAY) AND '$datereport2' AND `date`>'$start_date'";
                    
                    // if(isset($_GET['date_hreport']) && isset($_GET['date2_hreport'])){
                        
                    //     $sql .= "`date` BETWEEN DATE_SUB('$datereport', INTERVAL DAYOFMONTH('$datereport')-1 DAY) AND '$datereport2' AND `date`>'$start_date'";
                        
                    // }else{
                    //     $sql .= "`date` BETWEEN `YEAR()-01-01` AND `YEAR()-12-31` AND `date`>'$start_date'";
                    // }
           
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
}else{

   $start_date = date('Y-m-d',strtotime('1970-01-01'));

}
                    $leavesH = $dbF->getRow("SELECT SUM(`hours`) FROM `leaves` WHERE `user`='$value1[acc_id]' AND `status`='Accepted' AND `type`='Annual Leave'");
                    $lieuAll = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$value1[acc_id]' AND `status`='Accepted'");
                    $lieuLess = $dbF->getRow("SELECT SUM(`hours`) FROM `lieu` WHERE `user`='$value1[acc_id]' AND `status`='Accepted' AND `type`='Late/Leave/Less'");

                    // $holidayEntitlement = $holidayEntitlement - $leavesH[0];

                    $extra = $extra - $lieuAll[0];

                    $less = $less - $lieuLess[0];
                    
                    if($d[0] == ''){
                        $holidayEntitlement = $extra = $less = $whours = $totalHourSum = 0;
                    }
                     $hours = (12.07 / 100)*$holidayEntitlement;
                   


          $hw = $dbF->getRow("SELECT * FROM accounts_user_detail WHERE id_user='$value1[acc_id]' AND setting_name='hours_worked'");
          $he = $dbF->getRow("SELECT * FROM accounts_user_detail WHERE id_user='$value1[acc_id]' AND setting_name='holiday_entitlement'");  
   

 // $echo ="SELECT  FROM accounts_user_detail WHERE id_user IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') AND setting_name='holiday_entitlement'";


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

if(!empty($_GET['date_hreport'])){
    $tk2 = $dbF->getRows("SELECT * FROM `leaves` WHERE `user`='$user' AND `fill_user` = '$value1[acc_id]' AND `status`='Accepted' AND `type`='Annual Leave'  AND `from_date`>='$datereport' AND `to_date`<='$datereport2'"); 
}
else{
    $tk2 = $dbF->getRows("SELECT * FROM `leaves` WHERE `user`='$user' AND `fill_user` = '$value1[acc_id]' AND `status`='Accepted' AND `type`='Annual Leave' ");
}


// var_dump($tk2);

$day = 0;
$total = 0;
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

 $days;
$j = $days;
$num = 0;
                while($num <= $j) {
                    
 //$from_date."<br>";


     if(strtotime($from_date) > strtotime($startDateNew) || $from_date < strtotime($EndDate)) {



                   $num++;

              $from_date = date("Y-m-d",strtotime("+1 day", strtotime($from_date)));
     
   
      
  }


    } 
//echo $num;
    $total +=$num;

}
//echo "<br>";
 // echo $total;


                                    
                       $he_tk = "";
                       @$he_tk =  ($he['setting_val'] - $total);


                                echo "<tr>";
                              
                                echo   "<td>" .  $value1['acc_name'] ."</td>"; 
                                //$user =  $value1['acc_id']; 

                               echo "<td>" .  $whours ."</td>";
                               echo "<td>".round($hours,1)." </td>";
                               echo "<td>".  $hw['setting_val']." Hours</td>";
                               echo "<td>".  $he['setting_val']." Days</td>";
                               echo "<td>". $total." Days</td>";
                               echo "<td>". $he_tk ." Days</td>"; 
                             echo "<tr>";
                             $total = 0;   
                             $num = 0;
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
    <script>
 $(function() {
    $( "#from, #tto" ).datepicker({
        defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
     yearRange: "-100:+0",
      
        onSelect: function( selectedDate ) {
            if(this.id == 'from'){
              // var dateMin = $('#from').datepicker("getDate");
              var dateMin = $('#from').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 30); // Min Date = Selected + 1d
              var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + nn); // Max Date = Selected + 31d
              $('#tto').datepicker("option","minDate",rMin);
              $('#tto').datepicker("option","maxDate",rMax);                    
            }

        }
    });
});
    </script>
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();
</script>
<?php include_once('footer.php'); ?>