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
    $token = $functions->setFormToken('min_stockEdit',false);


     $sql = "SELECT * FROM `product_inventory` WHERE `qty_pk` = ? ";
            $data = $dbF->getRow($sql,array($id));






} else {
    $token = $functions->setFormToken('min_stockAdd',false);
}
?>
<div class="event_details" id="myform">
    <h3><?php echo "Add / Update Min Stock"; ?></h3>
    <div class="form_side">



        <div class="form-group"> <label><?php echo $productClass->getProductFullNameWeb( $data['qty_product_id'], $data['qty_product_scale'], $data['qty_product_color'] ); ?></label></div>


    <form method="post" action="<?php echo WEB_URL ?>/stockView">
    <?php echo $token ?>
               <input type="hidden" value="<?php echo $id; ?>" name="min_stockPK">



              <div class="form-group">
                <label style="display: inline-block;font-weight: 600;"> Min Stock Notify</label>
               <!-- <textarea name="txt"  id="ckeditor" class="txt ckeditor"></textarea> -->
               <input type="number" value="<?php echo $data['min_stock'] ?>" name="min_stock" class="txt">
            </div>
           

    <input type="submit" value="Save" class="submit_class">
            
        </form>
    </div>
    <!-- form_side close -->
</div>

