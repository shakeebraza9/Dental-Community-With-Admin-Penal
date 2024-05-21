<?php
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
    header('Location: login');
}

// include_once('header.php'); 

$msg = $webClass->webUserAddSubmit();

$chk1 = $functions->documentInsert();
if($chk1){
    $msg = "Document Insert Successfully";
}
$chk2 = $functions->documentUpdate();
if($chk2){
    $msg = "Document Update Successfully";
}
$chk3 = $functions->documentAdd();
if($chk3){
    $msg = "Document Add Successfully";
}
if(isset($_GET['folD'])){
    $chk = $functions->deleteDocument();
    if($chk){
        $msg = "Document Delete Successfully";
    }
}
if(isset($_GET['alldocumentidFolder'])){
    $chk = $functions->deleteDocumentall();
    if($chk){
        $msg = "All Document Delete Successfully";
    }
}
include'dashboardheader.php';
$functions->pin();
?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
    
        <!-- link_menu close -->
        <div class="right_side">
            <div class="right_side_top">
                <!-- <div class="change-session"> -->
                    <?php
                        //$functions->changeSession();
                        if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full'){
                    ?>
                    <!-- <div class="col1_btnn"> -->
                        <div data-toggle="tooltip" title="Help Video" style="position: absolute;right: 100%;top: 4px;" class="help" onclick="video('Bt_Ue3gSfjE')"><i class="fa fa-question-circle"></i></div>
                        <?php 
                        if($_SESSION['userType']=='Trial')
                        {
                            echo'<a href="" onclick="alertbx()" class="submit_class"><i class="fas fa-user"></i>&nbsp;&nbsp;Add New User</a>';
                        }
                        else{
                                        
                        ?>
                        <a href="<?php echo WEB_URL; ?>/profile?page=Add Profile" class="submit_class"><i class="fas fa-user"></i>&nbsp;&nbsp;Add New User</a>
                        <?php }?>
                    <!-- </div> -->
                    <?php } ?>
                <!-- </div> -->
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){
                echo "<div class='col-12 green_alert alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$msg</div>";
            } ?>
            <div class="user-box-main">
                    <div class="userPageLoader">
                    <i class="fas fa-sync fa-spin" style="color: #01abbf;"></i>
                    <span style="color: #01abbf;font-weight: bold;"> Loading.....</span>
                </div>
                
                <?php
                
echo "<div class='loadDeactiveUser'><div class='col1_btn'>
<a href='javascript:;' onclick='loadDeactiveUser();'>
Load DeActive Users</a>
</div></div>";
                ?>
            </div>
            <!-- user-box-main -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<!-- </div> -->
<!-- index_content -->
<script>

$(document).ready(function() {
    
    $.ajax({
        url: './ajax_call.php?page=manageUser',         
        contentType: false,
        cache: false,
    }).done(function(response) {

        $('.userPageLoader').hide();
        $('.user-box-main').html(response);
        $('[data-toggle="tooltip"]').tooltip();
        
    });
});
function loadDeactiveUser()
{

$.ajax({
url: '../ajax_call.php?page=loadDeactiveUser',
type: 'post'
// data: { id:id}
}).done(function(data) {
// console.log(data);
// if (data > 0) 
// {
// console.log("This user send email & password")
// }
$('.loadDeactiveUser').remove();

$('.user-box-main').append(data)

});
}



function sendmailrecovery(id)
{
      
      console.log(id);
     $.ajax({
        url: '../ajax_call.php?page=sendmailrecovery',
        type: 'post',
         data: { id:id}
    }).done(function(data) {
        console.log(data);
        if (data > 0) 
        {
            console.log("This user send email & password")
        }

            
           
    });
}
</script>
<?php include_once('dashboardfooter.php'); ?>