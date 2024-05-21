<?php
include_once('../global.php');
$id = $_GET['id'];

$sql = "SELECT * FROM `purchase_receipt_dn` WHERE receipt_pk='$id'";
$data1 = $dbF->getRow($sql);

$sql = "SELECT * FROM `purchase_receipt_pro_dn` WHERE receipt_id='$id'";
$data2 = $dbF->getRows($sql);

$type = $data1['type'];
$dn = $data1['dn'];
$date = $data1['receipt_date'];
$prf = $data1['prf'];
$sender = $data1['sender'];
$delivery = $data1['delivery_by'];
$note = $data1['note'];
$cn = $data1['cp'];
$acd = $data1['account_cd'];

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
function getSupplier($setting_name,$supplier){
	global $dbF;
	$sql = "SELECT acc_id FROM `accounts_user` WHERE acc_name='$supplier'";
	$data = $dbF->getRow($sql);
	$id = $data[0];
	$sql = "SELECT setting_val FROM `accounts_user_detail` WHERE id_user='$id' AND setting_name='$setting_name'";
	$data = $dbF->getRow($sql);
	return $data[0];
}
function getStaff($setting_name,$supplier){
	global $dbF;
	$sql = "SELECT acc_id FROM `accounts` WHERE acc_name='$supplier'";
	$data = $dbF->getRow($sql);
	$id = $data[0];
	$sql = "SELECT setting_val FROM `accounts_detail` WHERE id_user='$id' AND setting_name='$setting_name'";
	$data = $dbF->getRow($sql);
	return $data[0];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Delivery Note</title>
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
<?php
if($type=="customer"){
?>
<center>Delivery Note</center>
<br>
<table>
	<tr><td>DN:</td><td colspan="2"><?php echo $dn ?></td></tr>
	<tr><td>Date:</td><td colspan="2"><?php echo $date ?></td></tr>
	<tr><td>PRF:</td><td colspan="2"><?php echo $prf ?></td></tr>
	<tr><td>Customer:</td><td colspan="2"><?php echo $cn ?></td></tr>
	<tr><td>Customer Details:</td><td colspan="2"><?php echo getSupplier('address',$cn).",".getSupplier('telephone',$cn).",".$acd ?></td></tr>
	<tr><td></td></tr>
	<tbody class="br">
	<tr>
		<td>#</td>
		<td>Serial Number</td>
		<td>Item Name</td>
		<td colspan="3">Quantity</td>
	</tr>
	<?php 
	$i=1;
	foreach ($data2 as $key => $value) {
	echo "<tr>
		  <td>$i</td>
		  <td>".getNumber($value['receipt_product_id'])."</td>
		  <td>".getName($value['receipt_product_id'])."</td>
		  <td colspan='3'>$value[receipt_qty]</td>
		  </tr>";
	$i++;
	}
	?>
	</tbody>
	<tr><td></td></tr>
	<tr><td>Note:</td><td colspan="2"><?php echo $note ?></td></tr>
	<tr>
		<td>Released By:</td><td><?php echo $sender ?></td>
		<td>Delivered By:</td><td><?php echo $delivery ?></td>
		<td>Received By:</td><td>____________________</td>
	</tr>
	<tr>
		<td>Signature/Date:</td><td>____________________</td>
		<td>Signature/Date:</td><td>____________________</td>
		<td>Signature/Date:</td><td>____________________</td>
	</tr>
</table>
<?php }
else { ?>
<center>Internal Delivery Note</center>
<br>
<table>
	<tr><td>DN:</td><td colspan="2"><?php echo $dn ?></td></tr>
	<tr><td>Date:</td><td colspan="2"><?php echo $date ?></td></tr>
	<tr><td>PRF:</td><td colspan="2"><?php echo $prf ?></td></tr>
	<tr><td>Customer:</td><td colspan="2"><?php echo $cn ?></td></tr>
	<tr><td>Customer Details:</td><td colspan="2"><?php echo getStaff('phone',$cn).",".$acd ?></td></tr>
	<tr><td></td></tr>
	<tbody class="br">
	<tr>
		<td>#</td>
		<td>Serial Number</td>
		<td>Item Name</td>
		<td>Quantity</td>
		<td colspan="2">Warehouse</td>
	</tr>
	<?php 
	$i=1;
	foreach ($data2 as $key => $value) {
	echo "<tr>
		  <td>$i</td>
		  <td>".getNumber($value['receipt_product_id'])."</td>
		  <td>".getName($value['receipt_product_id'])."</td>
		  <td>$value[receipt_qty]</td>
		  <td colspan='2'>".getStore($value['receipt_product_color'])."</td>
		  </tr>";
	$i++;
	}
	?>
	</tbody>
	<tr><td></td></tr>
	<tr><td>Note:</td><td colspan="2"><?php echo $note ?></td></tr>
	<tr>
		<td>Released By:</td><td><?php echo $sender ?></td>
		<td>Delivered By:</td><td><?php echo $delivery ?></td>
		<td>Received By:</td><td>____________________</td>
	</tr>
	<tr>
		<td>Signature/Date:</td><td>____________________</td>
		<td>Signature/Date:</td><td>____________________</td>
		<td>Signature/Date:</td><td>____________________</td>
	</tr>
</table>
 <?php } ?>
 <script>
	window.print();
</script>
</body>
</html>