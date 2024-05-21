<?php 
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
if(!empty($_GET['id'])){
@$id = @$_GET['id'];
$sql = "SELECT * FROM `practiceprofile` WHERE `user_id` = '$id'";
$data = $dbF->getRow($sql,array($id));
 $fill_user = @$data['user'];
$username = $functions->UserName($fill_user);
$option =  $functions->leavetype();
 
                $daysss = $data['dayoff'];
                $offday = explode(",",$daysss);
            }
 ?>
<div class="event_details" id="myform">
<?php if(empty($_GET['id'])){  ?>
    <h3>Days Off Form <?php echo '('.$username.')' ?></h3>
<?php }
        else { ?>
    <h3>Days Off Form</h3>
<?php } ?>
    <div class="form_side">
        
    </div><!-- form_side close -->
</div><!-- event_details -->
<script>
$(function() {
    $( "#from, #tto" ).datepicker({
        defaultDate: "+1w",
          changeMonth: true,
          changeYear: true, 
          showButtonPanel:true,
       // numberOfMonths: 1,
       
    });
});
</script>