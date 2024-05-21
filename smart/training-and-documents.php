<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

@$category  = htmlspecialchars($_GET['category']);
@$id        = htmlspecialchars($_GET['id']);
if(isset($_GET['id'])){
if(isset($_GET['id'])){
$category  = "Training / Documents";
}

include_once('header.php'); 

if(@$_COOKIE['again'] != 'true'){
    echo "<style>
    .header_side,#loader{
        display: none !important;
    }
    </style>
<div class='login_page'>
    <div class='login_page_main'>
    <div class='login-center'>
            <div class='content_logo'>
                <a href='".WEB_URL."'>
                    <h1>Smart Dental<span>Compliance &amp; Training</span></h1>
                    <h4>Please insert pin to continue in your account</h4>
                </a>
            </div>
            <div class='login_main' id='login_form'>
            <div class='form-group fa-key'>
                <input type='password' name='pin' placeholder='Pin'>
            </div>
            <div id='errmsg'></div>
            <input type='button' name='submit' class='submit_class_login' value='submit'>
            </div>
        </div>
    </div>
</div>
<script>
$('.submit_class_login').on('click', function() {
    pin = $('input[name=pin]').val();
    $.ajax({
        type: 'post',
        data: {pin:pin},
        url: 'ajax_call.php?page=again_login',                
    }).done(function(data) {
        if (data == '1') {
            location.reload();
        }
        else{
            $('#errmsg').text(data);
        }
    });
});
</script>";
exit();
}

$msg = "";
$chk = $functions->TDedit();
$chk1 = $functions->TDeditM();
if($chk){
    $msg = "Save Successfully";
}
if($chk1){
    $msg = "Save Successfully";
}

include'dashboardheader.php'; ?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            <?php echo _uc($category) ?>
        </div>
        <!-- link_menu close -->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side hrm">
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    if(isset($_GET['category'])){
                        $functions->changeSession();
                    }
                    ?>
                    <?php
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                    <div class="col1_btn">
                        <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                    </div>
                    <?php } ?>
                </div><!-- change-session -->
            </div><!-- right_side_top close -->
            <?php if($msg!=''){
                echo "<div class='alert alert-success'>$msg</div>";
                } ?>
            <?php
                if(isset($_GET['category'])){ ?>
            <div class="tble">
                <table>
                    <?php echo $functions->TrainigDocument($_SESSION['currentUser'],$category); ?>
                </table>
            </div>
            <?php }
                else{ ?>
            <form method="post" action="training-and-documents?id=<?php echo $id ?>" enctype="multipart/form-data">
                <?php echo $functions->setFormToken('TrainigDocumentM',false); ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>User</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Completion Date</th>
                            <th>Expiry Date</th>
                            <th>File</th>
                        </thead>
                        <tbody>
                            <?php
                                echo $functions->TDsingle($id);
                            ?>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="manage-users" value="Submit" name="submit">
            </form>
            <?php } ?>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
</div>
<!-- index_content -->
<style>
iframe {
    display: none;
}
</style>
<?php include_once('footer.php'); ?>