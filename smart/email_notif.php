<?php
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF, $webClass;

$login = $webClass->userLoginCheck();
if (!$login) {
    header('Location: login');
}

include_once('header.php');
include 'dashboardheader.php';
?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            News
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'news'; include 'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            
            <h3 style = "font-weight:700; margin: 0 0 20px 0">Email Records</h3>
<?php
if (!isset($_GET['id'])) {
    // $type = $_GET['type'];
    
    $user = $_SESSION['webUser']['id'];
 
    $sql  = "SELECT * from email_record where user = '$user' ORDER BY `time` DESC";
    $data = $dbF->getRows($sql);
    foreach ($data as $key => $value) {
        
        $id      = $value['id'];
        
        $subj    = $value['subject'];
        $date    = date('d-M-Y H:i', strtotime($value['time']));
        $link    = WEB_URL . "/email_notif?id=$id";
        
        echo "<div class='news-detail'>
                <h4>($date)</h4>
                <p>{$subj}</p>
                    <a class='submit_class' href='$link'>Read More</a>
                </div>";
    }
} else {
    $data_    = array();
    $id    = intval($_GET['id']);
    $sql_     = "SELECT * from email_record where id= ? ";
    $data_    = $dbF->getRow($sql_,array($id));
    $mail = $data_['mail'];
    // $desc_    = translatefromserialize($data_['shortDesc']);
    $subj    = $data_['subject'];
    $date_    = date('d-M-Y', strtotime($data_['time']));
    
    echo "
    <a class='submit_class' href='".WEB_URL."/email_notif' style='display:block;margin: 0 0 20px 0'>Back</a>
    <div class='news-detail'>
            <h4>({$date_}) {$subj}</h4>
            <p>{$mail}</p>
            
        </div>";
}

?>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <?php include_once('footer.php');?>