<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php');

$msg = "";







include'dashboardheader.php'; ?>
<div class="index_content mypage resources">
   <div class="right_side"> 
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
           Action Plan
        </div>
        <!--link_menu close -->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="cpd-table">
           <!--<a href="<?php echo WEB_URL ?>/mock_inspection#tabs-3" class="submit_class" style="padding: 10px 10px;max-width: max-content;">Show Action Plan</a>-->
          <h3 style="float: left;">Action Plan</h3>
                <a href="<?php echo WEB_URL ?>/mock_inspection#tabs-3" class="submit_class" style="float: right;padding: 0 10px;max-width: max-content;" >Show Action Plan</a>  
            <!-- right_side_top close -->
          <table>
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Assign to</th>
                                    <th>Due date</th>
                                    <th>Status</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($_SESSION['currentUserType'] == 'Employee'){
                                   /// $user = $_SESSION['webUser']['id'];
                                    $user = $_SESSION['superid'];
                                }
                                else{
                                    $user = $_SESSION['currentUser'];
                                }
                                $sql = "SELECT * FROM `mock_actionplan` WHERE (user='$user' OR assign_to='$user') and status=1";
                                $data = $dbF->getRows($sql);
                                foreach ($data as $key => $value) {
                                    $status='pending';
                                    if($value['status']==1){
                                    $status='completed';
                                    $assign=$functions->UserName($value['assign_to']);
                                    }
                                    echo "<tr>
                                            <td>$value[action]</td>
                                            <td>".$functions->UserName($value['assign_to'])."</td>
                                            <td>$value[date]</td>
                                            <td ><button class='btn btn-danger ' style='cursor: pointer;' id='user" . $val['id'] . "' onClick='reply_click(this.id)'>$status</button></td>
                                            
                                          </tr>";
                                }
                                ?>
                               
                            </tbody>
                        </table>
            </div>
                </div>            
        </div>
        <!-- right_side close -->
    </div>
    
    <!-- left_right_side -->
<?php include_once('footer.php'); ?>