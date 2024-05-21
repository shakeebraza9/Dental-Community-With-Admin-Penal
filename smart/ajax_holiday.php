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
            $user = $_SESSION['currentUser'];
             $sql = "SELECT * FROM `isholiday` WHERE `user` = '$user'";
            $data = $dbF->getRows($sql);
            $cnt  = 0;
 foreach ($data as $key => $val) { 
                   $cnt++;
                  $PracticeName = $functions->UserName($val['user']);
                  $id = $val['id'];
                 echo "<tr>
                       <td>". $cnt."</td>
                       <td>".$PracticeName."</td>
                       <td>".$val['date']."</td>
                       <td>".$val['reason']."</td>   
                       <td>".$val['comment']."</td>
                <td><a data-id='$id' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>
                                    <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                                    <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
                                </a></td>";
                       

                        echo "</tr>"; 
               } 

?>
