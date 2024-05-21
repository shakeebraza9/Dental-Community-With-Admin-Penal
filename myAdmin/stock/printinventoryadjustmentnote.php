<?php
include_once('../global.php');
$id = $_GET['id'];

$sql = "SELECT * FROM `purchase_receipt_ian` WHERE receipt_pk='$id'";
$data1 = $dbF->getRow($sql);

$sql = "SELECT * FROM `purchase_receipt_pro_ian` WHERE receipt_id='$id'";
$data2 = $dbF->getRows($sql);

$ian = $data1['ian'];
$date = $data1['receipt_date'];
$reason = $data1['reason'];
$description = $data1['description'];
$inspected = $data1['inspected_by'];
$approved = $data1['approved_by'];
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
	<title>Inventory Adjustment Note</title>
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
<center>Inventory Adjustment Note</center>
<br>
<table>
	<tr><td>IAN:</td><td colspan="2"><?php echo $ian ?></td></tr>
	<tr><td>Date:</td><td colspan="2"><?php echo $date ?></td></tr>
	<tr><td>Reason:</td><td colspan="2"><?php echo $reason ?></td></tr>
	<tr><td>Description:</td><td colspan="2"><?php echo $description ?></td></tr>
	<tr><td></td></tr>
	<tbody class="br">
	<tr><td>#</td><td>Serial Number</td><td>Item Name</td><td>Existing Quantity</td><td>New Quantity</td><td>Existing Condition</td><td>New Condition</td></tr>
	<?php 
	$i=1;
	foreach ($data2 as $key => $value) {
	echo "<tr>
		  <td>$i</td>
		  <td>".getNumber($value['receipt_product_id'])."</td>
		  <td>".getName($value['receipt_product_id'])."</td>
		  <td>$value[receipt_product_ec]</td>
		  <td>$value[receipt_product_nc]</td>
		  <td>$value[receipt_product_eqty]</td>
		  <td>$value[receipt_product_nqty]</td>
		  </tr>";
	$i++;
	}
	?>
	</tbody>
	<tr><td></td></tr>
	<tr><td>Note:</td><td colspan="2"><?php echo $note ?></td></tr>
	<tr>
		<td>Inspected By:</td><td><?php echo $inspected ?></td>
		<td>Approved By:</td><td><?php echo $approved ?></td>
	</tr>
	<tr>
		<td>Signature/Date:</td><td>____________________</td>
		<td>Signature/Date:</td><td>____________________</td>
	</tr>
</table>
<script>
	window.print();
</script>
</body>
</html>