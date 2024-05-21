<?php 
include("global.php");
include("header.php");
echo'<link rel="stylesheet" type="text/css" href="'.WEB_URL.'/css/style2.css">
    <!-- DESKTOP -->
    <link href="'.WEB_URL.'/css/style-desktop2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1400px)">
    <!-- TABLET -->
    <link href="'.WEB_URL.'/css/style-tablet2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
    <!-- MOBILE -->
    <link href="'.WEB_URL.'/css/style-mobile2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
    <!-- MOBILE SMALL-->
    <link href="'.WEB_URL.'/css/style-mobile-small2.css" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)">';
$msg="";
?>
<?php
if(isset($_POST["code"]) && $_POST["code"]==$_SESSION["rand_code"]){

    if(isset($_POST['email']) && !empty($_POST['email'])){

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            $email=($_POST['email']);
            $sql    = "SELECT * FROM `accounts_user` WHERE `acc_email`='$email' ";
            $data   =   $dbF->getRow($sql);
            if($dbF->rowCount>0){
                $to =   $email;
                $user   = $data['acc_name'];
                $passwordDecode = $functions->decode($data['acc_pass']);

                $aLink  =   WEB_URL.'/login';
                $mailArray['link']        =   $aLink;
                $mailArray['password']    =   $passwordDecode;
                $functions->send_mail($to,'','','accountTrouble',$user,$mailArray);

                $msg    =   "An email is sent. Please check your emails.";
                $msg= $dbF->hardWords($msg,false);
            }
            else{
                $msg="No user found! Please Check Your Email";
                $msg= $dbF->hardWords($msg,false);
            }
        }
        else{
            $msg="Incorrect Email.";
            $msg= $dbF->hardWords($msg,false);
        }
    }
}

elseif(isset($_POST["code"]) && $_POST["code"]!=$_SESSION["rand_code"]){
    $msg="Captcha Code Incorrect. Please try again.";
}
$email = empty($_POST['email']) ? "" : $_POST['email'];
?>
<div class="login_page">
    <div class="login_page_main">
        <div class="login-center">
            <div class="content_logo">
                <a href="<?php echo WEB_URL ?>/login">
                    <h1>Smart Dental<span>Compliance &amp; Training</span></h1>
                    <h4>Login to AIOM</h4>
                </a>
                <h2>Enter your email and we send you a password reset link</h2>
            </div>
            <!-- content_logo close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-danger" style="margin: 8px 0 0;padding: 8px;font-size: 15px;">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="md-card-content large-padding login_main" id="login_form">
                <form method="post" action="?do=resend&r=email" class="again form-horizontal" style="width: 90%;">
                    <div class="form-group fa-envelope">
                        <input type="email" required="" value="<?php echo $email; ?>" name="email" id="username" placeholder="<?php $msg= $dbF->hardWords('Email'); ?>">
                    </div>
                    <img src="captcha.php" alt="<?php $msg= $dbF->hardWords('Please Type The Code.'); ?>" />
                    <div class="form-group fa-lock">
                        <input type="text" name="code" placeholder="<?php $msg= $dbF->hardWords('Please Type Captcha Code'); ?>" required="">
                    </div>
                    <input type="submit" name="submit" class="submit_class_login" value="Send Email">
                </form>
            </div>
        </div>
        <!--  -->
    </div>
</div>
<style>
    #loader{
        display: none;
    }
</style>