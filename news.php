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
<?php
if (!isset($_GET['id'])) {
    $type = $_GET['type'];
 
    $sql  = "SELECT * from news where publish = 1 AND type= ?  ORDER BY `date` DESC";
    $data = $dbF->getRows($sql,array($type));
    foreach ($data as $key => $value) {
        
        $id      = $value['id'];
        $heading = translatefromserialize($value['heading']);
        $desc    = translatefromserialize($value['shortDesc']);
        $date    = date('d-M-Y', strtotime($value['date']));
        $link    = WEB_URL . "/news?id=$id";
        
        echo "<div class='news-detail'>
                <h4>($date) $heading</h4>
                <p>{$desc}</p>
                    <a class='submit_class' href='$link'>Read More</a>
                </div>";
    }
} else {
    $data_    = array();
    $id    = intval($_GET['id']);
    $sql_     = "SELECT * from news where id= ? ";
    $data_    = $dbF->getRow($sql_,array($id));
    $heading_ = translatefromserialize($data_['heading']);
    $desc_    = translatefromserialize($data_['shortDesc']);
    $large    = translateFromSerialize($data_['dsc']);
    $date_    = date('d-M-Y', strtotime($data_['date']));
    
    echo "<div class='news-detail'>
            <h4>({$date_}) {$heading_}</h4>
            <p>{$desc_}</p>
            <p>{$large}</p>
        </div>";
}

?>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
    <?php include_once('footer.php');?>