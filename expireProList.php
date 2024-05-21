<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Expiry Product List',false);
}



$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
$msg  = "";
// $chk  = $functions->addMakeOrder();
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// $orderStartWith = $functions->orderStartWith();



// if($chk){
//     $msg = $chk;
// }
// include_once('header.php'); 

include'dashboardheader.php';
// $user = $_SESSION['currentUser'];

//  if ($_SESSION['currentUserType'] !='Employee') {
//                      $u_id = $_SESSION['currentUser'];
//                  }else
//                  {
//                      $u_id = $_SESSION['webUser']['id'];
//                  }

?>
<div class="index_content mypage health_form">
<!-- <div class="left_right_side"> -->

<!-- left_side close -->


<div class="right_side profile">




<div class="resources_search crm_search">


<input type="text" placeholder="Keywords" id="searchpurchaseReceipt" class="searchpurchaseReceipt">
<!-- <button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>
</button> -->






</div>
<!-- resources_search -->



<div class="cpd-table">
<h3>Expiry Product List</h3>
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name</th>
<th>Product Location</th>
<th>Product Expiry Date</th>
<th>Minimum Quantity level</th>
<th>Product Quantity</th>
</tr>
</thead>
<tbody>
<?php
 $userId =  $_SESSION['webUser']['id'];
        


if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}


$sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' AND `expiryDate`!='' ORDER BY `product_inventory`.`expiryDate` ASC"; //
$data = $dbF->getRows($sql);


foreach ($data as $key => $value) {





$pracName=   $functions->UserName($value['qty_store_id']);            


echo "<tr>
<td> ".$pName          = $productClass->getProductFullNameWeb( $value['qty_product_id'], $value['qty_product_scale'], $value['qty_product_color'] ) ." </td>
<td>$value[location]</td>

<td>$value[expiryDate]</td>



<td>$value[min_stock]</td>
<td>$value[qty_item]</td>


</tr>";



}
?>


</tbody>
</table>
</div>
<!-- cpd-tbl -->
</div>
<!-- cpd-table -->
</div>
</div>
<!-- right_side close -->
<!-- </div> -->
<!-- left_right_side -->

<?php include_once('dashboardfooter.php'); ?>