<?php
error_reporting(0);
ob_start();
include_once("global.php");
global $webClass,$dbF,$productClass;
if(isset($_GET['id'])){ 
    ?>
<script>
// $(document).ready((function() {
//         selectProduct(<?php echo base64_decode($_GET['id']);?>);
//         $("html, body").animate({
//             scrollTop: 0
//         }, "slow"), $(".background_side").fadeToggle(), $(".col101_cart").fadeToggle(), $("#checkoutBtn").prop("disabled", !0)
// }));
</script>
    <?php
}
$chk = $webClass->delegates();

if(isset($_SESSION['url'])){ ?>
    <script>
        $(window).bind('load', function() {$('#iframe').append('<iframe src="<?php echo @$_SESSION['url']?>"/>');});
    </script>
    <?php unset($_SESSION['url']);
}

?>


<script>

</script>



<div class="tabs">
<ul class="tabs-list">
	<li class="active"><a href="#tab1">Monthly</a></li>
	<li><a href="#tab2">Yearly</a></li>
</ul>
<div class="p_tab" id="tab1" style="display: block;">
<div class="pricing_innerFlex">
    <?php 
        $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `product_update`='1' AND `category`='Monthly'";
        $data = $dbF->getRows($sql);
        foreach ($data as $key => $value) {
                // var_dump($value);
            echo $productClass->pBox($value['prodet_id'],false,'Monthly');
        } ?>
<div class="single_pricing">
<div class="price">
<h1>Custom Pricing</h1>
</div>

<div class="p_detail">
    <p class="pro_name">Over 25 users multi-location practices</p>
</div>
<button class="custom_pricing_btn pricing_btn" id="customprice_btn" data-ref='monthly_payment' >Buy Now</button>
</div>
</div>
</div>

 

<div class="p_tab" id="tab2" style="display: none;">
<div class="pricing_innerFlex">


 <?php 
                        $sql = "SELECT `prodet_id` FROM `proudct_detail_spb` WHERE `product_update`='1' AND `category`='Yearly'";
                        $data = $dbF->getRows($sql);
                        foreach ($data as $key => $value) {
                                // var_dump($value);
                            echo $productClass->pBox($value['prodet_id'],false,'Yearly');
                        } ?>
<div class="single_pricing">
<div class="price">
<h1>Custom Pricing</h1>
</div>

<div class="p_detail">
    <p  class="pro_name" >Over 25 users multi-location practices</p>
</div>
    <button class="pricing_btn" id="customprice_btn" data-ref='yearly_payment'>Buy Now</button>
</div>
</div>
</div>




<?php
return ob_get_clean(); ?>