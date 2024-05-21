<?php 
include("global.php");

global $dbF;
echo  $user = intval($_POST['user']);

if($_POST['user'] != '' ){
   
  
   $data = $dbF->setRow("UPDATE `notification_record` SET `read` = 1 WHERE user = ? ",array($user));
     
     if ($data > 0) {
     	return 1;
     }
     else{
     	return 0;
     }
}



 ?>