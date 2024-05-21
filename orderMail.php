<?php
ob_start();

include_once("global.php");
global $productClass,$webClass,$dbF,$functions,$db;

@$id = $_GET['mailId'];

$orderUser  = $webClass->webUserId();
if($orderUser=='0'){
$orderUser = $webClass->webTempUserId();
}

$sql            = "SELECT * FROM `orders` WHERE order_id = '$id'";
$orderInvoice   =   $dbF->getRow($sql);

if($dbF->rowCount>0){

$prod_detail = $functions->getProductName($orderInvoice['product_id'], 'prodet_name');
$prodet_shortDesc    = $functions->getProductName($orderInvoice['product_id'], 'prodet_shortDesc');
$prodet_shortDesc       = translateFromSerialize($prodet_shortDesc['prodet_shortDesc']);

$sql = "SELECT * FROM `order_detail` WHERE order_id = '$id'";
$orderInfo   =   $dbF->getRow($sql);

?>

<body>
    <style>
    * {
        margin: 0;
        padding: 0;
    }

    .container {
        font-family: "Arial", Gadget, sans-serif;
        height: auto;
        width: 760px;
        background-color: #ebebeb;
        margin: 20px auto;
        padding: 20px;
    }

    .content_main {
        height: auto;
        width: 97%;
        background: #FFF;
        margin: 0 auto;
        padding: 10px;
    }

    .inn_content_div {
        border: #ebebeb 1px solid;
        width: 100%;
        height: auto;
    }

    .top_logo_div {
        width: 100%;
        border-bottom: #ebebeb 1px solid;
        display: inline-block;
    }

    .inner_logo_div {
        width: 100%;
        text-align: center;
        box-sizing: border-box;
        padding: 0;
    }

    .inner_logo_div img {
        max-width: 100%;
    }

    .second_details_div {
        height: auto;
        padding: 10px;
    }

    .first_in_div {
        float: left;
        width: 65%;
        box-sizing: border-box;
        padding: 10px;
        text-align: justify;
    }

    .third_div {
        height: auto;
        padding: 10px 5px;
    }

    .details_table {
        font-size: 14px;
    }

    .head_tr td {
        padding: 10px 6px !important;
    }

    .detail_tr>td {
        padding: 6px;
    }

    .lasts_tr>td {
        padding: 10px !important;
    }

    .in_table_pro tr td {
        padding: 4px;
    }

    .head_tr {
        background: #000;
        color: #FFF;
    }

    .detail_tr {
        background: #ebebeb;
        margin: 5px 0;
    }

    .border_td {
        text-align: center;
    }

    .lasts_tr {
        background: #f1f0f0;
        text-align: right;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .center_td {
        text-align: center;
    }

    .forth_div {
        height: auto;
        width: 100%;
        margin-top: 15px;
    }
    </style>
    <div class="container">
        <div class="content_main">
            <div class="inn_content_div">
                <div class="top_logo_div">
                    <div class="inner_logo_div">
                        <img src="<?php echo WEB_URL;?>/webImages/new-logo.png" style="padding:20px;" />
                    </div>
                </div>
                <div class="second_details_div">
                    <div class="second_div">
                        <table width="100%" style=" height:50px;" cellpadding="0" cellspacing="10">
                            <tr>
                                <td>
                                    <?php $dbF->hardWords('Order Date'); ?>:
                                </td>
                                <td>
                                    <?php 
									$date = date('d-M-Y',strtotime($orderInvoice['order_date']));
									echo $date;
									?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $dbF->hardWords('Order Number'); ?>:
                                </td>
                                <td>
                                    <?php echo $functions->ibms_setting('invoice_key_start_with').$orderInvoice['order_id']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" style="vertical-align:top;">
                                    <?php $dbF->hardWords('Billing Address'); ?>:</p>
                                </td>
                                <td>
                                    <?php echo $orderInfo['address'].", UK"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Payment Method:
                                </td>
                                <td>
                                    <?php if($orderInvoice['order_customer'] == 'manual') echo "Cash"; else echo "GoCardless" ; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Name:
                                </td>
                                <td>
                                    <?php echo $orderInfo['full_name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Phone:
                                </td>
                                <td>
                                    <?php echo $orderInfo['mobile']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $dbF->hardWords('E-mail'); ?>:
                                </td>
                                <td>
                                    <?php echo $orderInfo['email']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td>
                                    <?php 
									$name = translateFromSerialize($prod_detail['prodet_name']);
									echo $name." ".$prodet_shortDesc; 
									?>
                                </td>
                            </tr>
                            <tr>
                                <td>Price Per Month</td>
                                <td>
                                    <?php echo 'GBP '.$orderInvoice['price_per_month']; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php } return ob_get_clean(); ?>