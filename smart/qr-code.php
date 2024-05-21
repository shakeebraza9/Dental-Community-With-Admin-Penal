<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){
    header('Location: dashboard');
    exit();
}

include_once('header.php');

include'dashboardheader.php';

$msg  = "";
$user = intval($_SESSION['currentUser']);

if(isset($_POST['newqr'])){
    $date = date('d-M-Y h:i A');
    $qr = base64_encode($date."||".$user);
   
   // htmlspecialchars($qr);
   
      $sqldata = "UPDATE `accounts_user` SET `acc_qr`='$qr' WHERE `acc_id`= ? ";
    $data = $dbF->setRow($sqldata,array($user));
    if($dbF->rowCount){
        $msg  = "QR Code Update Successfully";
    }
}
else{
    $sqldata = "SELECT `acc_qr` FROM `accounts_user` WHERE `acc_id`= ? ";
    $data = $dbF->getRow($sqldata,array($user));
    $qr = $data['acc_qr'];
    if(!empty($qr)){
        $udate = explode('||',base64_decode($qr))[0];
        $udate = "Last Updated on ".$udate;
    }
}
?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Rota Management
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>


               <div data-toggle="tooltip" title="Help Video" class="help" onclick="video('EJUtPIhK-Bg')"><i class="fa fa-question-circle"></i></div>

               
            <div class="qr">
                <?php if($_SESSION['currentUserType'] != 'Employee' || @$_SESSION['superUser']['hrqr'] == 'edit' || @$_SESSION['superUser']['hrqr'] == 'full'){ ?>
                <form method="post">
                    <input type="submit" class="submit_class" value="Generate New QR Code" name="newqr">
                </form>
                <?php } ?>
                <span><?php echo @$udate ?></span>
                <h3><?php echo $functions->PracticeName($user); ?></h3>
                <div id="qr"></div>
            </div>
            <!-- qr -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <script>
    $(document).ready(function() {
        var qr = [{
            config: {
                text: "<?php echo $qr ?>", // Content
                width: 500, // Widht
                height: 500, // Height
                colorDark: "#b93895", // Dark color
                colorLight: "#fff", // Light color
                quietZone: 0,
                PI: '#f2701d',
                PO: '#01abbf',
                AI: '#01abbf',
                AO: '#f2701d',
                logo: "webImages/qr.png", // LOGO
                logoWidth: 150,
                logoHeight: 150,
                timing: '#fcc429',
                logoBackgroundTransparent: true, // Whether use transparent image, default is false
                dotScale: 0.7,
                // logoBackgroundColor: '#fff',
                // PI_TL: '#b7d28d', // Position Inner - Top Left 
                // PO_TL: '#aa5b71', // Position Outer - Top Right
                // PI_TR: '#b7d28d', // Position Inner - Top Left 
                // PO_TR: '#aa5b71', // Position Outer - Top Right
                // timing_V: '#00B2EE',
                // timing_H: '#00B2EE',
                // backgroundImage: 'logo.png',
                // backgroundImageAlpha: 1,
                // autoColor: false,
                // binarize: false,                     
                // title: 'Title', // Title
                // titleFont: "bold 18px Arial", // Title font
                // titleColor: "#004284", // Title Color
                // titleBackgroundColor: "#fff", // Title Background
                // titleHeight: 70, // Title height, include subTitle
                // titleTop: 25, // Title draw position(Y coordinate), default is 30
                // subTitle: 'subTitle', // Subtitle content
                // subTitleFont: "14px Arial", // Subtitle font
                // subTitleColor: "#004284", // Subtitle color
                // subTitleTop: 40, // Subtitle drwa position(Y coordinate), default is 50
                // version: 5,
                correctLevel: QRCode.CorrectLevel.H // L, M, Q, H
            }
        }]
        var qr = new QRCode(document.getElementById("qr"), qr[0].config);
    });
    </script>
    <?php include_once('footer.php'); ?>