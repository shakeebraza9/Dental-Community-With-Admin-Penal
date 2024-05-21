<?php
include_once("global.php");

global $webClass ,$dbF; 
global $productClass, $functions; 


ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
$productClass->orderSubmit();
$productClass->orderUpdate();
// $dbF->prnt($_POST); 
// echo 1;
exit(); 
# used in header.php
define('ORDER_PAGE', TRUE);

// if ( isset($_GET['preview']) && $_GET['preview']=='1' ) {
// }


if (empty($msg)) {
    if (isset($_GET['ds'])) {
        //ds Direct Submit
        $msg = $productClass->cartSubmitForCheckOut(true); // first submit,
    } else {
        $msg = $productClass->cartSubmitForCheckOut(); // first submit,
    }
}

$invoiceId = false;
if (isset($_GET['inv'])) {
    $invoiceId = $_GET['inv'];
} else if ($productClass->orderLastInvoiceId != '0') {
    $invoiceId = $productClass->orderLastInvoiceId;
} else if ($_SESSION['webUser']['lastInvoiceId'] !== false) {
    $invoiceId = $_SESSION['webUser']['lastInvoiceId'];
} else {
    //exit;
}
$_SESSION['webUser']['lastInvoiceId'] = $invoiceId;
$login = false;
if ($webClass->userLoginCheck()) {
    $login = true;
}

# get number of items in invoice
$sql = "SELECT COUNT(*) FROM `order_invoice_product` WHERE `order_invoice_id` = '$invoiceId' ";
$total_order_products = $functions->dbF->getRows($sql);
$total_order_products = array_pop($total_order_products);


$cartReturned = $productClass->viewCheckOutProduct3($invoiceId);
$cartReturn = $cartReturned['temp'];
$cartCustomSizeModals = $cartReturned['sizeModal'];

$submit = $preview = $productClass->preview;
$country = $productClass->currentCountry();
$box19 = $webClass->getBox("box19"); 
$bannerImg = $box19['image'];
$subHeading = 'Checkout';
include("header.php");

?>
    <script>
        $(document).ready(function () {
            id = <?php echo $invoiceId; ?>;
            history.pushState(null, "inv ", "?inv=" + id);
        });
    </script>
    <style>
        .inner_details_container {
            background: #f0f2e5;
            padding: 30px 0;
            min-width: 450px;
        }

        .inner_details_content {
            background: #fff;
            padding: 0 10px;
        }

        .border {
            border-bottom: 1px solid #ddd;
        }

        .paymentOptions {
            display: inline-block;
            width: 100%;
        }

        .paymentOptions img {
            height: 22px;
        }

        .paymentOptions > div {
            min-height: 30px;
            padding: 5px 0;
            margin: 4px;
            text-align: left;
        }

        @media (max-width: 768px) {
            .inner_details_content {
                min-width: 100%;
            }
        }


.detail_cart2{


    display: inline-block;
 
    vertical-align: middle;
    position: relative;
    margin-right: 10px;
}
.img_detail2 {


        display: inline-block;
    vertical-align: middle;
}
.info_cart2 {


        display: inline-block;
    vertical-align: middle;
}

.cart3 {
    padding: 10px; 
    display: block !important;
    background: #fff;
    max-width: 1200px;
    margin: 20px auto;
    position: relative;
    overflow: hidden;
    top: 40px;
    margin-bottom: 80px;
}
    </style>
    <!--Inner Container Starts-->

    <div class="inner_content_page_div container-fluid cart3">


        <div class='content_cart' id='cartViewTable'>
            <div class='head_cart wow fadeInDown'><h1><?php echo $_e['CHECK OUT']; ?></h1></div>
            <div
                class='items_cart wow fadeInDown'><?php echo $total_order_products['COUNT(*)'] . ' ' . $_e['ITEM(s)'] ?></div>

            <div class='one_cart inline_block'>


                <div id="first_option" class='option1 option3 wow fadeInLeft'>1. <?php echo 'PAYMENT OPTION' ?>
                    <div class='d_tick' style="display:none"><img src='<?php echo WEB_URL ?>/images/d_tock.png' alt=''>
                    </div>
                </div>

                <?php if ($submit == false): ?>

                    <div class='area_form3 wow fadeInUp'>
                        <div style="display:none" class='bill_text'><?php echo $_e['Billing Country']; ?></div>

                        <input type='hidden' class='drop_drop' disabled='' readonly='' value='SWEDEN'>

                        <div style="display:none" class='method_type wow fadeInLeft'>
                            <?php echo $_e['Payment Type']; ?>
                        </div><!--method_type end-->


                        <?php if ($invoiceId !== false && $productClass->cartInvoice) {
                                echo "<input type='hidden' id='invoiceId' value='$invoiceId'/>";
                        ?>
                        <?php } ?>


                        <div class="paymentOptions">
                            <!--Credit Cart Option not develop now-->
                            <!--<div class="border radio">
                                        <label><input type="radio" name="paymentType" value="3" class="paymentOptionRadio"><?php /*echo $productClass->productF->paymentArrayFindWeb('3'); */
                            ?> </label>
                                        <img src="images/creditcard.png" class="pull-right"/>
                                        <div class="clearfix"></div>
                                    </div>-->

                            <?php
                            $AllowKlarna = false;
                            //check country , kalrna not allow in some country as a payment method
                            //allow in sweden, norway and Finland
                            if ($functions->developer_setting('klarna') == '1' && preg_match('@SE|NO|FI@', $country)) {
                                $AllowKlarna = true;
                                ?>
                                <!--Klarna Option-->
                                <div class="border radio">
                                    <label><input type="radio" name="paymentType" value="2"
                                                  class="paymentOptionRadio" checked="checked" 
                                        ><?php echo $_e['Klarna = Faktura, Delbetalning, Kort & Internetbank'];
                                        // echo $productClass->productF->paymentArrayFindWeb('2');
                                        echo $productClass->payment_additional_price("2");
                                        ?>
                                    </label>
                                    <img src="images/klarna.png" class="pull-right"/>

                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>

                            <?php
                            $AllowPaypal = false;
                            //check country , payson not allow in some country as a payment method
                            if ($login && $functions->developer_setting('paypal') == '1') {
                                $AllowPaypal = false;
                                ?>
                                <!--PayPal Option-->
                                <div class="border radio">
                                    <label><input type="radio" name="paymentType" value="1"
                                                  class="paymentOptionRadio">
                                        <?php
                                            echo $productClass->productF->paymentArrayFindWeb('1');
                                            echo $productClass->payment_additional_price("1");
                                        ?>
                                    </label>
                                    <img src="images/paypal.png" class="pull-right"/>

                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>

                            <?php
                            $AllowPayson = false;
                            //check country , payson not allow in some country as a payment method
                            //allow in denmark
                            if ($functions->developer_setting('payson') == '1' && preg_match('@DK@', $country)) {
                                $AllowPayson = true;
                                ?>
                                <!--PayPal Option-->
                                <div class="border radio">
                                    <label><input type="radio" name="paymentType" value="5"
                                                  class="paymentOptionRadio">
                                        <?php
                                        echo $productClass->productF->paymentArrayFindWeb('5');
                                        echo $productClass->payment_additional_price("5");
                                        ?>

                                    </label>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>

                            <?php
                            $AllowGoCardless = false;
                            //check country , payson not allow in some country as a payment method
                            //allow in denmark
                            // if ($functions->developer_setting('GoCardless') == '1' && preg_match('@GB@', $country)) {
                                $AllowGoCardless = true;
                                ?>
                                <!--PayPal Option-->
                                <div class="border radio">
                                    <label><input type="radio" name="paymentType" value="9"
                                                  class="paymentOptionRadio">
                                        <?php
                                        echo $productClass->productF->paymentArrayFindWeb('9');
                                        echo $productClass->payment_additional_price("9");
                                        ?>

                                    </label>
                                    <div class="clearfix"></div>
                                </div>
                            <?php //} ?>

                            <?php
                            //check country , cashOnDelivery not allow in some country as a payment method
                            // allow in sweden and norway
                            if (
                                ($login || $functions->ibms_setting('loginForOrder') == '0')
                                && $functions->developer_setting('cashOnDelivery') == '1' ) { ?>
                                <!--Cash on delivery Option-->
                                <div class="border radio">
                                    <label><input type="radio" name="paymentType" value="0"
                                                  class="paymentOptionRadio">
                                        <?php
                                        echo $productClass->productF->paymentArrayFindWeb('0');
                                        echo $productClass->payment_additional_price("0");
                                        ?>
                                    </label>

                                    <div class="clearfix"></div>
                                </div>
                                
                                
                            <?php } ?>








                        </div><!--paymentOssptions end-->


                        <div class='button_area wow fadeInLeft'>
                            <div class='req2'></div>
                            <input type='submit' id="paymentOptionNext" value='<?php echo $_e['NEXT STEP']; ?>'
                                   class='check_btn2'>
                        </div><!--btn_area end-->

                    </div><!--area_form3 end-->

                <?php endif ?>


                <div id="second_option" class='option1 option wow fadeInLeft'>2. <?php echo $_e['DELIVERY']; ?>
                    <div class='d_tick' style="display:none"><img src='<?php echo WEB_URL ?>/images/d_tock.png' alt=''>
                    </div>
                </div>

                <?php if ($submit == false): ?>

                    <div id='cartContinue' class=''>
                        <?php
                        if ($productClass->cartInvoice && $AllowKlarna) {
                            $_GET['inv'] = $invoiceId;
                            $_GET['ajax'] = "a";
                            echo "<div class='klarna_container' ";
                            try {
                                include_once('klarna.php');
                            } catch (Exception $e) {

                            }
                            echo "</div";
                        }
                        ?>
                    </div>

                <?php endif ?>


                <div id="third_option" class='option1 option wow fadeInLeft'>3. <?php echo $_e['ORDER PREVIEW']; ?>
                    <div class='d_tick' style="display:none"><img src='<?php echo WEB_URL ?>/images/d_tock.png' alt=''>
                    </div>
                </div>

                <?php if ($submit):

                    if ($cartReturn === false && $msg == '') {
                        echo "<div id='EmptyCartView' class='alert alert-danger well-sm'>" . $dbF->hardWords('Error, Invoice Not Found Or You are not owner of this Invoice.', false) . "</div>";
                    } else {

                        $functions->mail_success_msg();

                        echo '<div class="alert alert-info" role="alert">';
                        if ($msg != '') {
                            echo $msg . ' ';
                        }

                         echo '<p style="font-size: 12px;"><a href="' . WEB_URL . '/invoicePrint?mailId='.$invoiceId.'&orderId='.hash("md5",$functions->encode($invoiceId)).'">'. $_e['Click to view your invoice OR'] . '</a><br><a href="' . WEB_URL . '/viewOrder">' . $_e['Click to view your previous orders OR'] . '</a><br>';
                        echo '<a href="' . WEB_URL . '/products">' . $_e['Continue Shopping'] . '</a>';
                        echo '</p></div>';

                        echo $cartReturn;
                        echo "<script>$('.one_cart').css('width','100%');</script>";



                        # google analytics ecommerce
                        $google_analytics_ecommerce = '<script>';
                        $google_analytics_ecommerce .= $webClass->generate_google_analytics_ecommerce($invoiceId);
                        $google_analytics_ecommerce .= 'ga(\'ecommerce:send\');';
                        $google_analytics_ecommerce .= '</script>';
                        echo $google_analytics_ecommerce;

                    }

                endif ?>

            </div><!--one_cart end-->

            <?php if ($submit == false): ?>

                <div class='two_cart cart_two inline_block wow fadeInUp'>
                    <div class='summary2'><?php echo $_e['SUMMARY']; ?></div>

                    <div class="sub_box34">
                        <div class="sub_3" style="margin-right: 10px;"><?php echo $_e['SUBTOTAL']; ?>
                            <!-- <img src='<?php echo WEB_URL ?>/images/question_mark.png' alt=''> -->
                            <div class="sub_4"><?php echo $subtotal . ' ' . $currencySymbol; ?></div>
                        </div>

                        <?php
                        ############ 3 For 2 Category START #########
                        global $three_for_2_minus_price;
                        $three_for_2_cat_div = '';
                        if($three_for_2_minus_price > 0){
                        $three_for_2_cat_div = "
                                <div class='sub_3'  style='margin-right: 10px;'>".$_e['Three For Two Category']."
                                    <div class='sub_4'>$three_for_2_minus_price $currencySymbol</div>
                                </div>";
                        }
                        echo $three_for_2_cat_div;
                        ############ 3 For 2 Category END #########
                        ?>



<div class="sub_3" style="margin-right: 10px;">
<?php echo $_e['ESTIMATED DELIVERY & HANDLING']; ?>
<div
class="sub_4"><?php echo "<span class='pShippingPriceTemp' data-real='$shipPrice'>$shipPrice</span>" . ' ' . $currencySymbol; ?></div>



<div class='sub_box34'>
<div class='sub_3 sub_font3'><?php echo $_e['TOTAL']; ?></div>
<div
class='sub_4 sub_font4 '><?php echo "<span class='pGrandTotal' data-total='$grandTotal'>$grandTotal </span>" . ' ' . $currencySymbol; ?></div>
</div><!--sub_box34 end-->
</div>




</div>

              

                   

                    <div class="cart2">
                        <?php
                        if ($msg != '') {
                            echo '<div class="alert alert-info" role="alert">' . $msg . '</div>';
                        }
                        ?>

                        <?php
                        if ($cartReturn === false && $msg == '') {
                            echo "<div id='EmptyCartView' class='alert alert-danger well-sm'>" . $dbF->hardWords('Error, Invoice Not Found Or You are not owner of this Invoice.', false) . "</div>";
                        } else {
                            echo $cartReturn;
                        }
                        ?>


                    </div>
                    <!--Cart2 end-->


                  

                </div><!--two_cart end-->


            <?php endif ?>


        </div>   <!--content_cart end-->


        <?php echo $cartCustomSizeModals; ?>


    </div><!--inner_content_page_div end-->


<?php include("footer.php"); ?>