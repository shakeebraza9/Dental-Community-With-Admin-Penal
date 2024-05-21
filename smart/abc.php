<?php

include("global.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$todayDate = date('d-M-Y');

$sql = "SELECT * FROM `record` WHERE `date` = date(NOW()) AND ( `rotaOff` = '' OR `rotaOff` = '0' ) AND `timeFrom` !='00:00' AND `timeTo` !='00:00'  AND checkin ='' ";//`rotaOff` NOT IN('Holiday','Day Off','Sick')
$data = $dbF->getRows($sql);
foreach($data as $key => $value){
    $user = $value['userId'];
    $inbefore   = date('H:i',(strtotime($value['timeFrom'])-900));
    $inlate     = date('H:i',(strtotime($value['timeFrom'])+900));
    $outbefore  = date('H:i',(strtotime($value['timeTo'])-900));
    $outlate    = date('H:i',(strtotime($value['timeTo'])+900));
    echo $sql1 = "INSERT INTO `cronData`(`user`,`type`,`time`) VALUES('$user','checkinbefore','$inbefore')";
    echo "<br>";
    echo $sql2 = "INSERT INTO `cronData`(`user`,`type`,`time`) VALUES('$user','inlate','$inlate')";
    echo "<br>";
    echo $sql3 = "INSERT INTO `cronData`(`user`,`type`,`time`) VALUES('$user','checkoutbefore','$outbefore')";
    echo "<br>";
    echo $sql4 = "INSERT INTO `cronData`(`user`,`type`,`time`) VALUES('$user','checkoutlate','$outlate')";
    // $dbF->setRow($sql1);
    // $dbF->setRow($sql2);
    // $dbF->setRow($sql3);
    // $dbF->setRow($sql4);



}
                   

                     $a = "SELECT MAX(acc_id) FROM accounts_user";
                        $d = $dbF->getRow($a);
                        $d[0];


                        $sqlnewuser = "SELECT * FROM accounts_user WHERE acc_id = '$d[0]' ";
                        $datanewuser = $dbF->getRow($sqlnewuser);
                        $datanewuser['acc_created'];

    $start_date = date('d-M-Y',strtotime($datanewuser['acc_created']));
    $date = strtotime($start_date);
    $date = strtotime("+7 day", $date);
    $UserDate = date('d-M-Y', $date);



$sql0  = "SELECT acc_id FROM accounts_user WHERE acc_type = '0' ";
$data0 =  $dbF->getRows($sql0);
foreach($data0 as $key => $value){
// $dbF->setRow("DELETE FROM `cronData` WHERE `user`='$value[acc_id]'");
// echo $sql="DELETE FROM `cronData` WHERE `user`='$value[acc_id]'";
}


   if ( $UserDate == $todayDate) {
        //  $functions->notifications('oneweek');
        echo "noti";
        
     }