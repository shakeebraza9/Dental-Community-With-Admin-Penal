<?php
ob_start();
include_once("global.php");
global $productClass, $webClass, $dbF, $functions, $db;
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$chk = $functions->cpdAllow();

if($chk){
    echo "<h2>You Are Not Allow to View Certificate</h2>";
    exit();
}

$assign_id           = htmlspecialchars($_GET['assignid']);
if(isset($_GET['user'])){
    $user_id = htmlspecialchars($_GET['user']);
}else{
    if($_SESSION['currentUserType'] == 'Employee'){
        $user_id = $_SESSION['superid'];
    }
    else{
        $user_id = $_SESSION['currentUser'];
    }
}
$userDetail          = $functions->getWebUser($user_id, 'acc_name');
$user_name           = $userDetail['acc_name'];

$datasql = "SELECT setting_val FROM accounts_user_detail WHERE id_user= ? AND setting_name = ?";
$data = $dbF->getRow($datasql,array($user_id,'gdc_number'));
$gdc = $data[0];



$sqlPaper = "SELECT * FROM `assigned_paper` WHERE md5(assign_id) = ?";
$resPaper             = $dbF->getRow($sqlPaper, array($assign_id));
$apDateTimestamp      = explode(' ', $resPaper['date_timestamp']);
$exam_date            = $apDateTimestamp[0];
$completion_date   = $resPaper['completion_date'];
$expiry_date          = $resPaper['expiry_date'];
$assign_paper         = $resPaper['assign_paper'];   

$data1 = $dbF->getRow("SELECT * FROM `paper` WHERE `paper_id` = '$assign_paper'");

$aim                  = $data1['aim'];
$objectives           = $data1['objectives'];
$learning_content     = $data1['learning_content'];
$development_outcomes = $data1['development_outcomes'];
$subject_id           = $data1['subject_id'];


$data = $dbF->getRow("SELECT `subject_title`,`minutes` FROM `subjects` WHERE `subject_id` = '$subject_id'");
$title = $data[0];
$minutes = $data['minutes'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Smart Dental Compliance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL;?>/webImages/favicon.ico" type="image/x-icon" />
    <style type="text/css">
    * {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        color: #222;
        line-height: 1.5;
        font-size: 15px;
    }

    .result_main {
        width: 789px;
        position: relative;
        margin: 0 auto;
        background-image: url(webImages/certificate.png);
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        height: 1126px;
    }

    .result_top {
        text-align: center;
        padding-top: 210px
    }

    h2 {
        display: inline-block;
        font-size: 22px;
        font-weight: normal;
    }

    .gdc {
        display: inline-block;
    }

    .result_middle {
        padding: 0 40px;
    }

    .result_middle h5 {
        font-size: 20px;
        font-weight: normal;
    }

    .result_middle p {
        padding-left: 15px;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .result_bottom {
        position: absolute;
        width: 100%;
        bottom: 35px;
        padding: 0 40px;
        font-size: 14px;
    }

    .result_bottom img {
        width: 120px;
        display: block;
        margin-bottom: 5px;
    }

    hr {
        width: 30%;
        position: absolute;
        right: 150px;
        border: 1px solid #222;
    }

    .on{
        line-height: .8;
    }
    </style>
</head>

<body>
    <div class="result_main">
        <div class="result_top">
            <h2><?php echo $user_name; ?></h2>
            <div class="gdc">(GDC NO. <?php echo $gdc ?>)</div><br>
                Attended a Training session on the topic of:<br>
            <h2><?php echo $title; ?></h2><div class="on">on</div>
            <h2><?php echo date('d-M-Y', strtotime($completion_date)); ?></h2>
        </div>
        <!-- result_top -->
        <div class="result_middle">
            <h5>Aim</h5>
            <p><?php echo $aim; ?></p>
            <h5>Objectives</h5>
            <p><?php echo $objectives; ?></p>
            <h5>Learning Content</h5>
            <p><?php echo $learning_content; ?></p>
            <h5>Development Outcomes</h5>
            <p><?php echo $development_outcomes; ?></p>
        </div>
        <!-- result_middle -->
        <div class="result_bottom">
               <?php if ($minutes == '60' ) { ?>
            
            <img src="<?php echo WEB_URL ?>/webImages/stamp1.png">
       <?php } else if ($minutes == '120' ) { ?>
            
            <img src="<?php echo WEB_URL ?>/webImages/stamp2.png">
       
       <?php }  else{ ?>
            
            <img src="<?php echo WEB_URL ?>/webImages/stamp1.png">
       
       <?php } ?>            

         
            <table width="100%"><tr>
        <td>Valid Till <?php echo date('d-M-Y', strtotime($expiry_date)); ?>. <strong>This CPD is subject to quality assurance by<img src="https://smartdentalcompliance.com/webImages/signsaba.jpg" style="width: 80px;position: absolute;display: initial;margin: 0;bottom: 30px;"> </strong><br>We confirm that the information provided on this certificate is full and accurate.</td></tr></table>
            <!-- <hr> -->
        </div>
        <!-- result_bottom -->
    </div>
</body>

</html>