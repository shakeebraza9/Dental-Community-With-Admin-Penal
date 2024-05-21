<?php 
include_once("global.php");
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

$id = intval($_GET['id']);



$sql = "SELECT * FROM `faq` WHERE `id`= ? ";
$data = $dbF->getRow($sql,array($id));


?>
<div class="event_details" id="myform">
    <h3>
        <?php echo $data['title'];
       
           ?>
    </h3>
    <div class="form_side">
    
      <div class="faqdetail"><?php echo  $data['dsc'] ?></div> 
    </div>
    <!-- form_side close -->
</div>
