
<?php

require_once("classes/invoice.php");
  
        global $adminPanelLanguage;
        $_w                                                  = array();
         $_w['Invoice ID']                             = '';
        $_w['Due Date']                             = '';
        $_w['Price']                             = '';
        $_w['Payment Status']                             = '';
 $_e['INVOICE DETAILS']                             = '';
global $functions;
global $dbF;
  global $_e;



header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Downloadall.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);



?>

<table>
<thead>
<tr>
    
    <th><?php echo _uc('order ID'); ?></th>
    <th><?php echo _uc('product'); ?></th>
    <th><?php echo _uc('Invoice ID'); ?></th>
    <th><?php echo _uc('Customer Name'); ?></th>
    <th><?php echo _uc('Email'); ?></th>
    <th><?php echo _uc('customer ID'); ?></th>
    <th><?php echo _uc('Mandate'); ?></th>
    <th><?php echo _uc('order date'); ?></th>
    <th><?php echo _uc('order validity'); ?></th>
    <th><?php echo _uc('order expire date'); ?></th>
    <th><?php echo _uc('order status'); ?></th>
    <th><?php echo _uc('Payment ID'); ?></th>
    
    <th><?php echo _uc('Due Date'); ?></th>
    <th><?php echo _uc('Price'); ?></th>
    <th><?php echo _uc('invoice status'); ?></th>
    <!-- <th><?php echo _uc('Last Paid Date'); ?></th> -->
    <th><?php echo _uc('Payment Type'); ?></th>
    <!-- <th><?php echo _uc('Invoice Order id'); ?></th> -->
    <!-- <th><?php echo _uc('price per month'); ?></th> -->
</tr>

                        </thead>
<tbody>

<?php

$last_paid_date = '';
$count = 0;
$sqls = "SELECT * FROM `orders` WHERE `order_status` != 'cancelled' ORDER BY `order_id` ";
$res = $dbF->getRows($sqls);

foreach ($res as $key => $value) {
$count++;


$sql = "SELECT * FROM `invoices`  where `order_id` = '$value[order_id]' ORDER BY   `due_date` ASC";

$datas= $dbF->getRows($sql);

foreach ($datas as $val) {

$inv_id = $val['invoice_pk'];

$last_paid_date =date('d-M-Y',strtotime(''.@$val['due_date'])) ;

$chkk = $value['order_customer'];
$invoice_order_id     = $val['order_id'];
$order_order_id     = $value['order_id'];
$order_id_print = $functions->ibms_setting('invoice_key_start_with') . $order_order_id;
$prod_detail = $functions->getProductName($value['product_id'], 'prodet_name');
        $pname = translateFromSerialize($prod_detail['prodet_name']);


$order_email      = $functions->UserEmail($value['order_user']);
$order_user      = $functions->UserName($value['order_user']);
$order_date   =date('d-M-Y',strtotime(''.@$value['order_date']));
$order_price_per_month    = $value['price_per_month'];
$order_status      = $value['order_status'];
$order_validity     = $value['validity'];

$order_expire_date     =date('d-M-Y',strtotime(''.@$value['expire_date'])) ;
$order_mandate     = $value['order_mandate'];
$order_customer     = $value['order_customer'];
$status   = $value['status'];

  
$pymt = 'GoCardless';
$dt = date('Y-m-d', strtotime("+1 months"));
if($chkk=='manual'){
    $pymt = 'Cash';
    if($value['invoice_status']=='pending' && $value['due_date']<=$dt){
    $pymt .="&nbsp;<button type='button' data-id='$vaL[invoice_pk]' class='btn btn-primary btn-sm'>Paid</button>";
    }
}
// <td>$last_paid_date </td>
// <td>$invoice_order_id</td>  
// <td>$order_price_per_month  </td> 


echo "<tr>

<td>$order_id_print</td>  
<td>$pname</td>
<td>".$val['invoice_pk']."</td>
<td>$order_user</td>
<td>$order_email</td>
<td> $order_customer  </td>
<td> $order_mandate   </td>
<td>$order_date </td>
<td>$order_validity      </td>
<td> $order_expire_date</td>
<td>$order_status</td>
<td>".$val['payment_id']."</td>
<td>".$last_paid_date."</td>
<td>".$val['price']."</td>
<td>".$val['invoice_status']."</td>

<td>$pymt</td>


</tr>";
    
}
}

$next_due_date = date('Y-m-d', strtotime("+1 day $last_paid_date"));
$orderId = "";
if(empty($last_paid_date)){
    $next_due_date = date('Y-m-d', strtotime("-1 day"));
}
$sql = "SELECT * FROM `invoices` WHERE `order_id` = ? AND `invoice_status` = 'pending' AND `due_date` > ? ORDER BY `due_date` ASC LIMIT 1";
$res = $dbF->getRow($sql, array($orderId,$next_due_date));
$sqls = "SELECT `order_customer` FROM `orders` WHERE order_id= ? ";
$datas= $dbF->getRow($sqls,array($orderId));
$chkk = $datas[0];
$pymt2 = 'GoCardless';

if(!empty($res)):

$nextcount = $count+1;

$dt = date('Y-m-d', strtotime("+1 months"));
if($chkk=='manual'){
    $pymt2 = 'Cash';
    if($res['due_date']<=$dt){
    $pymt2 .="&nbsp;<button type='button' data-id='$res[invoice_pk]' class='btn-iupdate btn btn-primary btn-sm'>Paid</button>";
    }
}

echo "<tr>
<td>".$nextcount."</td>
<td>".$res['invoice_pk']."</td>
<td>".$res['payment_id']."</td>
<td>".$res['due_date']."</td>
<td>".$res['price']."</td>
<td>".$res['invoice_status']."</td>
<td>$pymt2</td>
</tr>";

endif;

$sql = "SELECT * FROM `invoices` WHERE `order_id` = ? ORDER BY `due_date` DESC LIMIT 1";
$res = $dbF->getRow($sql, array($orderId));

$sql_count = "SELECT count(*) AS 'count' FROM `invoices` WHERE `order_id` = ? AND `invoice_status` = 'pending'";
$res_count = $dbF->getRow($sql_count, array($orderId));
$sqls = "SELECT `order_customer` FROM `orders` WHERE order_id= ? ";
$datas= $dbF->getRow($sqls,array($orderId));
$chkk = $datas[0];
$pymt3 = 'GoCardless';
$dt = date('Y-m-d', strtotime("+1 months"));
if($chkk=='manual'){
    $pymt3 = 'Cash';
    if($res['due_date']<=$dt){
    $pymt3 .="&nbsp;<button type='button' data-id='$res[invoice_pk]' class='btn-iupdate btn btn-primary btn-sm'>Paid</button>";
    }
}

if(!empty($res)):
echo "<tr>
<td>".$res_count['count']."</td>
<td>".$res['invoice_pk']."</td>
<td>".$res['payment_id']."</td>
<td>".$res['due_date']."</td>
<td>".$res['price']."</td>
<td>".$res['invoice_status']."</td>
<td>$pymt3</td>
</tr>";
endif;
?>
</tbody>
</table>
