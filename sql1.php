<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;




 $userId =  $_SESSION['webUser']['id'];
        
$sqls = "SELECT * FROM `proudct_detail`";





$variable=$dbF->getRows($sqls);
$i =1;$temp = "";
foreach ($variable as $key => $value): 


  $sql2      =   "INSERT INTO `product_setting`(`setting_name`,`setting_val`,`p_id`) VALUES ('publicAccess','1','$value[prodet_id]')";
                $dbF->setRow($sql2);

  $sql12      =   "INSERT INTO `product_setting`(`setting_name`,`setting_val`,`p_id`) VALUES ('launchDate','','$value[prodet_id]')";
                $dbF->setRow($sql12);




?>




<?php
$i++;

endforeach ?>
