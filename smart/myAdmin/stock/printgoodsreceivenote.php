<?php
include_once('../global.php');
$id = $_GET['id'];

$sql = "SELECT * FROM `purchase_receipt` WHERE receipt_pk='$id'";
$data1 = $dbF->getRow($sql);

$sql = "SELECT * FROM `purchase_receipt_pro` WHERE receipt_id='$id'";
$data2 = $dbF->getRows($sql);

$grn = $data1['grn'];
$date = $data1['receipt_date'];
$prf = $data1['prf'];
$po = $data1['po_number'];
$supplier = $data1['supplier'];
$receiver = $data1['receiver'];
$note = $data1['note'];

function getName($id){
	global $dbF;
	$sql = "SELECT prodet_name FROM `proudct_detail` WHERE prodet_id='$id'";
	$data = $dbF->getRow($sql);
	$data = $data[0];
	$data = translateFromSerialize($data);
	return $data;
}

function getNumber($id){
	global $dbF;
	$sql = "SELECT setting_val FROM `product_setting` WHERE p_id='$id' AND setting_name='Serial Number'";
	$data = $dbF->getRow($sql);
	return $data[0];
}

function getSupplier($setting_name,$supplier){
	global $dbF;
	$sql = "SELECT acc_id FROM `accounts_user` WHERE acc_name='$supplier'";
	$data = $dbF->getRow($sql);
	$id = $data[0];
	$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE id_user='$id' AND setting_name='$setting_name'";
	$data = $dbF->getRow($sql);
	return $data[0];
}

function getStore($id){
	global $dbF;
	$sql = "SELECT store_name FROM `store_name` WHERE store_pk='$id'";
	$data = $dbF->getRow($sql);
	return $data[0];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Goods Receive Note</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ADMIN_URL; ?>/assets/bootstrap/css/bootstrap.css"/>
</head>
<style>
	center{
		margin-top: 100px;
		margin-bottom: 10px;
	}
	table{
		width: 850px;
		max-width: 100%;
		margin: auto;
		color: #111;
	}
	table tr td{
		padding: 5px;
	}
	.br tr td{
		border: 1px solid #000;
	}
</style>
<body>
<center>Goods Receive Note</center>
<br>
<table>
	<tr><td>GRN:</td><td colspan="2"><?php echo $grn ?></td></tr>
	<tr><td>Date:</td><td colspan="2"><?php echo $date ?></td></tr>
	<tr><td>PRF:</td><td colspan="2"><?php echo $prf ?></td></tr>
	<tr><td>PO:</td><td colspan="2"><?php echo $po ?></td></tr>
	<tr><td>Supplier:</td><td colspan="2"><?php echo $supplier ?></td></tr>
	<tr><td>Supplier Details:</td><td colspan="2"><?php echo getSupplier('address',$supplier).",".getSupplier('telephone',$supplier) ?></td></tr>
	<tr><td></td></tr>
	<tbody class="br">
	<tr>
		<td>#</td>
		<td>Serial Number</td>
		<td>Item Name</td>
		<td>Warehouse</td>
		<td>Quantity</td>
	</tr>
	<?php 
	$i=1;
	foreach ($data2 as $key => $value) {
	echo "<tr>
		  <td>$i</td>
		  <td>".getNumber($value['receipt_product_id'])."</td>
		  <td>".getName($value['receipt_product_id'])."</td>
		  <td>".getStore($value['receipt_product_color'])."</td>
		  <td>$value[receipt_qty]</td>
		  </tr>";
	$i++;
	}
	?>
	</tbody>
	<tr><td></td></tr>
	<tr><td>Note:</td><td colspan="2"><?php echo $note ?></td></tr>
	<tr><td>Received By:</td><td colspan="2"><?php echo $receiver ?></td></tr>
	<tr><td>Signature:</td><td colspan="2">____________________</td></tr>
</table>
<script>
	window.print();
</script>
</body>
</html>