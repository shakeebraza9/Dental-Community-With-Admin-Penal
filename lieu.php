<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

include'dashboardheader.php';

$functions->pin();

$display = "";
if($_SESSION['currentUserType'] == 'Employee'){
    $display = 'style="display:none;"';
}

?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <div class="right_side">
            <div class="hr-absence profile">
               
            <div class="cpd-table">
                <div class="cpd-tbl">
                <a class="submit_class" href="<?php echo WEB_URL."/hrm" ?>">Back </a>
                <br>
                    <table>
                         <h3 class="main-heading_"> Overtime Request Hours</h3> 
                           
                        <thead>
                            <tr>
                                <th <?php echo $display?>>Employee</th>
                                <th>Type</th>
                                <th>Hours</th>
                                <th>Status</th>
                                  <th>Note</th>
                                        <th>Update Date Time</th>
                                          <th <?php echo $display;?>>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $functions->lieuRequest(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- cpd-tbl -->
            </div>
            <!-- cpd-table -->
            </div>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
    <?php include_once('dashboardfooter.php'); ?>