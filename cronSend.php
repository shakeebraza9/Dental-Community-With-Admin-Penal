<?php
include("global.php");

    $date = date('Y-m-d');
     $date2 = date('Y-m-d');
   // $time1;

$time = date('h:i');
//$cureentDate =  date('d-M-Y',strtotime($date));
 //$cureentDate;

$sql = "SELECT * FROM `cronData` WHERE `time` = '$time' AND `event_Date` = '$date' AND `type`!='eventhasreminder'";
$data = $dbF->getRows($sql);

foreach($data as $key => $value){
	$msg = "";
    $id = $value['id'];
    $user = $value['user'];
    $type = $value['type'];


    $functions->notifications($type,$user);
    $account_type = $functions->UserType($user);
    if($account_type == 'Employee' && $type == 'inlate'){
        $functions->notifications('echeckinlate',$user);
    }
     if($account_type == 'Employee' && $type == 'checkoutlate'){
        $functions->notifications('echeckoutlate');

    }

    $dbF->setRow("DELETE FROM `cronData` WHERE `id`='$id'");
}

$sql = "SELECT * FROM `cronData` WHERE `event_Date` = '$date2' AND `type`='eventhasreminder' AND user != 0";
$data = $dbF->getRows($sql);
foreach($data as $key => $value){
	$msg = "";
    $id = $value['id'];
    $user = $value['user'];
    $type = $value['type'];
// echo "DELETE FROM `cronData` WHERE `type`='eventhasreminder' AND `user`='$user'";
    if ($value['type'] == 'eventhasreminder' && $time > `10:00`) 
    {
         $functions->notifications('eventhasreminder',$user);
             $dbF->setRow("DELETE FROM `cronData` WHERE `type`='eventhasreminder' AND `user`='$user'");
            

    }
   
    // $data = $dbF->getRow("SELECT * FROM record WHERE userId = '$user' AND `date` = date(NOW())");
    // $msg = 'From '.$data['timeFrom'].' To'.$data['timeTo'].' User'.$user;
    
    $msg.="$value[type] user=$user id=$id<br>";
}
// $functions->send_mail('mobashir@imedia.com.pk','Cron notify',$msg);


  // $q = "SELECT * FROM `cronData` WHERE `event_time` = '$time'";
  //                       $b  = $dbF->getRow($q);
  //                          $event_date = $b['event_date'];
  //                          $event_user = $b['user'];
  //                          $cron_id = $b['id'];


  //  if ($todayDate ==  $event_date ) {
  //        $functions->notifications('eventhasreminder',$event_user);
  //        $dbF->setRow("DELETE FROM `cronData` WHERE `id`='$cron_id'");
  //    }
$sql='SELECT * FROM `email_queue` ORDER BY id ASC LIMIT 0,30';
$data = $dbF->getRows($sql);

foreach($data as $value){
    $emailto=$value['email_to'];
    $subject=$value['subject'];
    $message=$value['message'];
    $id=$value['id'];
    $functions->send_mail($emailto,$subject,$message);
    $dbF->setRow("DELETE FROM `email_queue` WHERE `id`=?",array($id));

}
