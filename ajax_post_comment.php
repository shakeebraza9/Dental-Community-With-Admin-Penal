<?php
// ob_start();
include_once("global.php");
global $webClass;
global $dbF;
$login       =  $webClass->userLoginCheck();
if(!$login){
    header('Location: login');
}
$temp="";   
            $postID = htmlspecialchars($_GET['postid']);
            $user = intval($_SESSION['webUser']['id']);
             $sql = "SELECT * FROM `comment` WHERE `user` = ? ";
            $data = $dbF->getRows($sql,array($user));
            $cnt  = 0;
 foreach ($data as $key => $val) { 
                   $cnt++;
                  $PracticeName = $functions->UserName($val['user']);
                  $id = $val['id'];
                 
                       

                        echo "</tr>"; 
               } 




               

?>
