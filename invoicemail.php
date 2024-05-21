<?php
ob_start();

include_once("global.php");
global $productClass,$webClass,$dbF,$functions,$db;

@$mailId =  base64_decode($_GET['mailId']);
@$invoiceId =  base64_decode($_GET['invoiceId']);
// var_dump($invoiceId);
$orderUser  = $webClass->webUserId();
if($orderUser=='0'){
$orderUser = $webClass->webTempUserId();
}

$sql            = "SELECT * FROM `orders` WHERE order_id = '$mailId'";
$orderInvoice   =   $dbF->getRow($sql);

if($dbF->rowCount>0){

$prod_detail = $functions->getProductName($orderInvoice['product_id'], 'prodet_name');
$prodet_shortDesc    = $functions->getProductName($orderInvoice['product_id'], 'prodet_shortDesc');
$prodet_shortDesc       = translateFromSerialize($prodet_shortDesc['prodet_shortDesc']);

$sql = "SELECT * FROM `order_detail` WHERE order_id = '$mailId'";
$orderInfo   =   $dbF->getRow($sql);

$sql = "SELECT * FROM `invoices` WHERE `order_id` = ? AND `invoice_pk` = ? AND `invoice_status` IN ('paid','pending_submission','submitted') ORDER BY `due_date` ASC";
$res = $dbF->getRow($sql, array($mailId,$invoiceId));
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
            /* background-color: #ebebeb; */
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
            display: flex;
            justify-content: space-between;
            align-items: center;


        }

        .inner_logo_div {
            width: 100%;
            /* text-align: center; */
            box-sizing: border-box;
            padding: 0;
        }

        .inner_logo_div img {
            max-width: 35%;
            padding: 20px 9px;
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

        /* New Css */
        .company_main {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company1 {
            padding-left: 10px;
        }

        .company1 h1 {
            font-size: 18px;
        }

        .company1 h2 {
            font-size: 15px;
            font-weight: 300;
        }

        .company2 {
            padding-right: 10px;
            padding-top: 20px;
        }

        .company2 table {
            border: 1px solid #b4abab;
            border-collapse: collapse;
        }

        .company2 table tr {
            border: 1px solid #b4abab;
            /* padding: 10px; */
        }

        .company2 table tr td {
            border: 1px solid #b4abab;
            padding: 5px 20px;
        }

        .company2 table tr th {
            border: 1px solid #b4abab;
            padding: 5px 20px;
            font-size: 14px;
            /* letter-spacing: 1px; */
        }

        .bill_main {
            padding-left: 10px;

        }

        .bill_main h1 {
            font-size: 25px;
        }

        .bill_main table td {
            padding-right: 50px;
            font-size: 18px;
            padding-top: 5px;
        }

        .description_main {

            padding-top: 25px;
        }

        .description_main table {
            width: 100%;
            border: 1px solid #ebebeb;
            border-collapse: collapse;
            /* text-align: start; */
        }

        .description_main table tr th {
            text-align: start;
            font-size: 22px;
            padding: 5px 3px;
            background-color: #e1e1e1;
        }

        .description_main table tr th.top_tbl {
            width: 80%;
        }

        .description_main td {
            padding: 8px 3;

        }

        .description_main td:nth-child(1) {
            border-right: 2px solid #ebebeb;

        }


        .tbl_bottom {
            display: grid;
            grid-template-columns: 50% 30% 20%;
            background-color: #e5e5f1;
            font-size: 18px;
            font-weight: 700;
            padding-left: px;
            padding: 10px 2px;

        }


        .top_logo_div_2 {
            padding-right: 10px;
        }
        @media print {
        body {
            size: A4 portrait;
            -webkit-print-color-adjust: exact;
            -webkit-print-color-adjust: exact !important;  
            color-adjust: exact !important;              
            print-color-adjust: exact !important;         
        }
    }

@page {
    size: A4;
    height:
    margin: 5%;
}
 @page :footer {
        display: none
    }
 
    @page :header {
        display: none
    }
    
    </style>
    <div class="container">
        <div class="content_main">
            <div class="inn_content_div">
                <div class="top_logo_div">
                    <div class="inner_logo_div">
                        <img src="<?php echo WEB_URL;?>/webImages/new-logo.png" style="padding:20px;" />
                    </div>
                    <div class="top_logo_div_2">
                        <h1>INVOICE</h1>
                    </div>
                </div>
                 <div class="company_main">
                    <div class="company1">

                    </div>
                    <div class="company2">
                        <table>
                            <tr>
                                <th>INVOICE #</th>
                                <th>DATE</th>
                            </tr>
                            <tr>
                                <td><?php echo $res['invoice_pk']; ?></td>
                                <td><?php 
                                    $date = date('d-M-Y',strtotime($res['due_date']));
                                    echo $date;
                                    ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="bill_main">
                    <h1>Bill to</h1>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <p>Name</p>
                                </td>
                                <td><?php echo $orderInfo['full_name']; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Adress</p>
                                </td>
                                <td><?php echo $orderInfo['address'].", UK"; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Phone</p>
                                </td>
                                <td><?php echo $orderInfo['mobile']; ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Email</p>
                                </td>
                                <td><?php echo $orderInfo['email']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="description_main">
                    <table>
                        <tr>
                            <th class="top_tbl">Description</th>
                            <th>Amount</th>
                        </tr>
                        <div class="table_data">
                            <tr>
                                <td><?php 
                                    $name = translateFromSerialize($prod_detail['prodet_name']);
                                    echo $name." ".$prodet_shortDesc; 
                                    ?></td>
                                <td><?php echo $res['price']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>

                        </div>
                    </table>
                    <div class="tbl_bottom">
                        <div>Thanks from Smart Dental Compliance</div>
                        <div style="text-align: right;padding-right: 10px;">Total Amount</div>
                        <div style="padding-left: 10px;">£ <?php echo $res['price']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo WEB_URL?>/js/jquery.min.js?magic=<?php echo filemtime('./js/jquery.min.js')?>"></script>
<script>
 

      $('#loader').fadeOut(100);
     $(window).load(function() {
      setTimeout(function(){ window.print(); }, 500);
       setTimeout(function(){ window.close(); }, 3000);
    });
    
    </script>
<?php } return ob_get_clean(); ?>