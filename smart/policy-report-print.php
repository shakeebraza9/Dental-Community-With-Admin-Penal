<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
if($_GET['excel']!=1){
include_once('header.php'); 

$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}
                           if ($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == '0') {
                              $user  = $_SESSION['superid'];
                            }else{
                              $user = $_SESSION['currentUser'];
                            }
                            
                            
                            // $sql1 = "SELECT * FROM `accounts_user` WHERE (`acc_id` ='$user' AND `acc_type`='1' )";
                            // $data1 = $dbF->getRow($sql1);
 
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
                <h2> <?php  echo htmlspecialchars($_GET['category']) . " Report </h2> "; ?><div><a target='_blank' style="float: right;font-weight: bold;" href='<?php echo $_SERVER['PHP_SELF']?>?category=<?php echo htmlspecialchars($_GET['category'])?>&excel=1'>Download as Excel</a></div>
                    <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>
            <div class="cpd-table">
                <div class="cpd-tbl datable"><?php 
}else{
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=report.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
}?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name of Employee</th>
                                <th>Role</th>
                                <?php
                                    if($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == '0'){
                                    $user = $_SESSION['superid'];  
                                    }
                                    else{
                                    $user = $_SESSION['currentUser'];
                                    }
                                    $category = htmlspecialchars($_GET['category']);
                                    $userId = "all:".$_SESSION['currentUser'];
                                    //echo "<h1>" . $userId . "</h1>";
                                    $titles = array(); 
                                    $dates  = array();
                                    $sql  = "SELECT title,id,expiry FROM documents WHERE assignto IN('all:$_SESSION[currentUser]','all') AND category = '$category' ";
                                    $data = $dbF->getRows($sql);
                                    foreach($data as $key => $value){
                                    array_push($titles,$value['id']);
                                    array_push($dates,$value['expiry']);
                                    echo "<th style='text-align: center; vertical-align: middle;'> <br> ". $value['title'] ." <br> </th>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                            $SuperUserAccess = $dbF->getRow("SELECT allow FROM superUser WHERE user='$user' AND type='superuser_access'");
                            //echo "<h1>" . print_r($SuperUserAccess) . "</hr>";
                            $SuperUserAccess = $SuperUserAccess['allow'];
                            //echo "<h1>" . $SuperUserAccess ."</h1>";
                            // $data = $dbF->getRows($sql);
                             
                            if(($_SESSION['currentUserType'] == 'Employee'  && $_SESSION['superUser']['hrreports'] == 'full')   || $_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice'){
                            $user = $_SESSION['currentUser'];
                            }else
                            {
                            $user = $_SESSION['superid'];  
                            }
                            
                            $sql  = "SELECT * FROM `accounts_user` WHERE  (`acc_id`='$user' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under'))  AND`acc_type`='1'";
                            $data = $dbF->getRows($sql);
                            foreach ($data as $key => $value){
                                 $data2 =  $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$value[acc_id]' AND `setting_name`='role'");
                                    $role = $data2[0];
                                    if(empty($role)){
                                    $role='--';
                                    }
                                echo "<tr>
                                <td>" .  $value['acc_name'] ."</td>
                                <td>" .  $role ."</td>";
                                
                                $user =  $value['acc_id'];
                                
                                $data = $dbF->getRows($sql);
                                $i = 0;
                                foreach ($titles as $key => $value){
                                    $value = $titles[$i];
                                    $date  = $dates[$i];
                                    $date = date('d-M-Y',strtotime($date));
                                    $sql  = "SELECT * FROM `userdocuments` WHERE `title_id` = '$value' AND `user`='$user' ORDER BY id DESC";
                                    $data = $dbF->getRow($sql);
                                        if(empty($data)){
                                            echo "<td style='color:#FF6347; text-align: center; vertical-align: middle;'>Due <br>
                                                    <i class='fas fa-times' style='color:#FF6347;'></i>
                                                  </td>";
                                        }else{
                                            $date = date('d-M-Y',strtotime($data['completion_date']));
                                            $expiryDate = new DateTime($data['expiry_date']);
                                            $todayDay   = new DateTime(date("Y-m-d"));
                                            $date2 = date('d-M-Y',strtotime($data['expiry_date']));

                                            // if( $todayDay > $expiryDate){
                                            // $expiryDate = date('d-M-Y',strtotime($data['expiry_date']));
                                            // echo "<td style='color:#FF6347; text-align: center; vertical-align: middle;' >".$expiryDate." <br><a href='" . $data['file'] . "' target='_blank'><i>Expired</i></a></td>";    
                                            // }
                                            // else
                                            // {
                                            // echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." <br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a></td>";
                                            // }
                                            //  if($_GET['excel']!=1){
                                            //      echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." <br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a><br>Signed</td>";
                                            //  }else{
                                            //  echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." Signed</td>";
                                            //  }
                                            if($_GET['excel']!=1){
                                                 
                                                    if($category=='Recruitment' || $category=='Signed Policies' || $category=='Minute Meeting' || $category=='MHRA'){
                                            //  if($expiryDate<$todayDay){
                                            //     echo "<td style='color:#ff6347; text-align: center; vertical-align: middle;'>Expire on<br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-times' style='color:#ff6347;'></i></a><br>
                                            //     ".$date2."</td>";
                                            //  }else{           
                                            if($category=='Recruitment'){
                                            echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." <br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a></td>";
                                            }else{
                                               echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." <br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a><br>Signed</td>"; 
                                            }  
                                                    // }
                                             }
                                             else{
                                                if($expiryDate<$todayDay){
                                                echo "<td style='color:#ff6347; text-align: center; vertical-align: middle;'>Expire on<br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-times' style='color:#ff6347;'></i></a><br>".$date2."</td>";
                                             }else{           
                                             echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." <br><a href='" . $data['file'] . "' target='_blank'><i class='fas fa-check' style='color:#3CB371;'></i></a></td>";}
                                             }
                                                 
                                             
                                             }else{

                                                if($category=='Recruitment' || $category=='Signed Policies' || $category=='Minute Meeting' || $category=='MHRA'){
                                            //          if($expiryDate<$todayDay){
                                            //  echo "<td style='color:#ff6347; text-align: center; vertical-align: middle;'>".$date2." Expire</td>";
                                                    
                                            //         }else{   
                                            if($category=='Recruitment'){
                                                  echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date."</td>";
                                             }else{
                                                  echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date." Signed</td>";
                                             } 
                                        //  }
                                             }
                                             else{
                                                      if($expiryDate<$todayDay){
                                             echo "<td style='color:#ff6347; text-align: center; vertical-align: middle;'>".$date2." Expire</td>";
                                                    
                                                    }else{   
                                             echo "<td style='color:#3CB371; text-align: center; vertical-align: middle;'>".$date."</td>";
                                         }
                                             }
                                             }
                                        }
                                $i++;        
                                }
                                echo "</tr>";    
                            }
                            ?>
                        </tbody>
                    </table>
<?php if($_GET['excel']!=1){ ?>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();
</script>
<?php include_once('footer.php'); 
}?>