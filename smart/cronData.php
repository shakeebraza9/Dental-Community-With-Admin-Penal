<?php
include("global.php");
$todayDate = date('d-M-Y');
$todayDate2 = date('Y-m-d');

$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND ( `rotaOff` = '' OR `rotaOff` = '0' ) AND `timeFrom` !='00:00' AND `timeTo` !='00:00'  AND checkin ='' ";//`rotaOff` NOT IN('Holiday','Day Off','Sick')
$data = $dbF->getRows($sql);
foreach($data as $key => $value){
    $user = $value['userId'];
    $inbefore   = date('H:i',(strtotime($value['timeFrom'])-900));
    $inlate     = date('H:i',(strtotime($value['timeFrom'])+900));
    $outbefore  = date('H:i',(strtotime($value['timeTo'])-900));
    $outlate    = date('H:i',(strtotime($value['timeTo'])+900));
    $sql1 = "INSERT INTO `cronData`(`user`,`type`,`time`,`event_Date`) VALUES('$user','checkinbefore','$inbefore','$todayDate2')";
    $sql2 = "INSERT INTO `cronData`(`user`,`type`,`time`,`event_Date`,`event_Date`) VALUES('$user','inlate','$inlate','$todayDate2')";
    $sql3 = "INSERT INTO `cronData`(`user`,`type`,`time`,`event_Date`) VALUES('$user','checkoutbefore','$outbefore','$todayDate2')";
    $sql4 = "INSERT INTO `cronData`(`user`,`type`,`time`,`event_Date`) VALUES('$user','checkoutlate','$outlate','$todayDate2')";
    $dbF->setRow($sql1);
    $dbF->setRow($sql2);
    $dbF->setRow($sql3);
    $dbF->setRow($sql4);
}
                   

    //                  $a = "SELECT MAX(acc_id) FROM accounts_user";
    //                     $d = $dbF->getRow($a);
    //                     $d[0];


    //                     $sqlnewuser = "SELECT * FROM accounts_user WHERE acc_id = '$d[0]' ";
    //                     $datanewuser = $dbF->getRow($sqlnewuser);
    //                     $datanewuser['acc_created'];

    // $start_date = date('d-M-Y',strtotime($datanewuser['acc_created']));
    // $date = strtotime($start_date);
    // $date = strtotime("+7 day", $date);
    // $UserDate = date('d-M-Y', $date);
    
    // This block of code will extract all new created acc since last week and if they completed one week then send
    // notification to that user and set log
    $sqlnewuser = "SELECT * FROM accounts_user WHERE acc_created between date_sub(now(),INTERVAL 1 WEEK) and now()";
    $datanewuser = $dbF->getRows($sqlnewuser);
        foreach($datanewuser as $key => $value){
            $id = $value['acc_id']; 
            $start_date = date('d-M-Y',strtotime($value['acc_created'])) ;
            $date = strtotime($start_date);
            $date = strtotime("+7 day", $date);
            $UserDate = date('d-M-Y', $date);
           
            $edit_id = "";
            $title = "";
            $title_id = "";
            if ( $UserDate == $todayDate) {
                    $functions->setlog(
                        "One week notification publish to (".$this->UserName($id).":".$id.")",
                        $this->UserName($id) . " : $id",
                        $edit_id, $title . " : " . $title_id);
                        $functions->notifications('oneweek', $id);
            }   
        }



$sql0  = "SELECT acc_id FROM accounts_user WHERE acc_type = '0' ";
$data0 =  $dbF->getRows($sql0);
foreach($data0 as $key => $value){
$dbF->setRow("DELETE FROM `cronData` WHERE `user`='$value[acc_id]'");
}
    

//   if ( $UserDate == $todayDate) {
//          $functions->notifications('oneweek');
        
//      }