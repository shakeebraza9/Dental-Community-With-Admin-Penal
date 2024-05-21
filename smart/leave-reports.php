<?php 
include_once("global.php");
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

                            $type= "";
                            $typeheading= "";
   if (@htmlspecialchars($_GET['leaves']) != '') {
      
   if(@htmlspecialchars($_GET['leaves']) == 'annual_leave')
    { $type = "Annual Leave"; $typeheading = "Annual Leave"; }
        if(@htmlspecialchars($_GET['leaves']) == 'sick_leave')
    { $type = "Sick"; $typeheading = "sick leave"; }
        if(@htmlspecialchars($_GET['leaves']) == 'casual_leave')
    { $type = "Casual"; $typeheading = "Casual leave"; }
    if(@htmlspecialchars($_GET['leaves']) == 'Compassionate_leave')
    { $type = "Compassionate leave"; $typeheading = "Compassionate leave"; } 
     if(@htmlspecialchars($_GET['leaves']) == 'maternity_leave')
    { $type = "Maternity"; $typeheading = "Maternity leave"; }
     if(@htmlspecialchars($_GET['leaves']) == 'half_day_leave')
    { $type = "Half Day"; $typeheading = "Half Day leave";}
    if(@htmlspecialchars($_GET['leaves']) == 'furlough_leave')
    { $type = "Furlough"; $typeheading = "Furlough leave";}
 $type =  ' `type` = "'.$type.'" ';
}
else  
{
     $typeheading = "All leave";
     $type =  ' `type` != "" ';
}


                           

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
                <h2> <?php  echo $typeheading . " Report </h2> "; ?>
                    <div class="covidshowbtn">
                        <div class="switch-field">
     
                 </div>
                 </div>
                 </div>

            <div class="cpd-table">
                <div class="cpd-tbl datable">
                    <table>
                        <thead>
                            <tr>
                                <th>Name of Employee</th>
                                <th>Leave type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Status</th>
                                <?php
        if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
                                   
            $user = $_SESSION['currentUser'];
            $user_fill = $_SESSION['webUser']['id'];
        
            $sql1 = "SELECT * FROM `leaves` WHERE $type  AND `user` = ?  AND `fill_user` =  ?   ";



                            $data1 = $dbF->getRows($sql1,array($user,$user_fill));

                                    }
                                    else{

                                       $user = $_SESSION['currentUser'];
         $sql1 = "SELECT * FROM `leaves` WHERE   $type  AND `user` ='$user'  AND (`fill_user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user' AND `setting_name`='account_under') OR user = '$user') ";
                                        $data1 = $dbF->getRows($sql1);
                                    
                                    }
                                  
                        ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data1 as $value) {?>
                             <tr>
                           <td><?php echo $functions->UserName($value['fill_user']); ?></td>
                           <td><?php echo $value['type']; ?></td>
                           <td><?php echo $value['from_date']; ?></td>
                           <td><?php echo $value['to_date']; ?></td>
                           <td><?php echo $value['status']; ?></td>
                           </tr>
                       <?php } ?>
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
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();
</script>
<?php include_once('footer.php'); ?>