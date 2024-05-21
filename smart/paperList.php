<?php 
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
    header("Location: login.php");
}
include_once('header.php'); 
global $dbF,$webClass,$assign_paperr,$paper_iid;

?>

<div class="bg_inner" style="background-image: url(<?php echo WEB_URL ?>/images/box/2018/09/761-363-bg-inner.jpg);background-size: cover;">
    <div class="standard">
        <h1>Paper List</h1>
        <ul>
            <li><a href="<?php echo WEB_URL ?>">Home</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li><a href="javascript:;" class="inner_active">Paper List</a></li>
        </ul>
    </div>
</div>
<!-- bg_inner -->

<div class="quiz">
    <div class="standard">

<?php
$user_id = $webClass -> webUserId();
$user_name = $_SESSION['webUser']['name'];

$sql = "SELECT * FROM `paper`";
$res = $dbF -> getRows($sql);

if (!empty($res)) {
    $i = 1;
    foreach($res as $key => $value) {
        if ($value['publish'] == '1') {
            $id = base64_encode($value['paper_id']);
            $link = "conduct.php?id=$id";
        } else {
            $id = base64_encode($value['paper_id']);
            $link = "practice.php?id=$id";
        }
        echo $paperTitle = "<a class='quiz_name' href='$link'>$i) $value[paper_title]</a><br>";
        $i++;
    }

} else {
    echo '<h3>No Paper Available To Attempt!</h3>';
}
?>

    </div>
    <!-- standard -->
</div>
<!-- quiz -->

<?php include_once('footer.php'); ?>