<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}









@$id = $_GET['id'];
 // $id = base64_decode($id);
 
if (@$_GET['id'] !='') {
    $token = $functions->setFormToken('txtUploadsedit',false);


     $sql = "SELECT * FROM `product_inventory` WHERE `qty_pk` = ? ";
            $data = $dbF->getRow($sql,array($id));






} else {
    $token = $functions->setFormToken('txtUploads',false);
}
?>







<div class="event_details" id="myform">
    <h3><?php echo "Add / Update Expiry Date"; ?></h3>
    <div class="form_side"> <div class="form-group"> <label><?php echo $productClass->getProductFullNameWeb( $data['qty_product_id'], $data['qty_product_scale'], $data['qty_product_color'] ); ?></label></div>
    <form method="post" action="<?php echo WEB_URL ?>/stockView">
    <?php echo $token ?>
               <input type="hidden" value="<?php echo $id; ?>" name="expiryDatePK">



              <div class="form-group">
                <label style="display: inline-block;font-weight: 600;">Expiry Date</label>
               <!-- <textarea name="txt"  id="ckeditor" class="txt ckeditor"></textarea> -->
               <input type="text" autocomplete="off" value="<?php echo $data['expiryDate'] ?>" id="expiryDate" name="expiryDate">
            </div>
           

    <input type="submit" value="Save" class="submit_class">
            
        </form>
    </div>
    <!-- form_side close -->
</div>

<script type="text/javascript">
$("#expiryDate").datepicker({ dateFormat: 'd-M-yy',

 changeMonth: true,
 changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});
</script>