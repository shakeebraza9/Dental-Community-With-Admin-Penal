<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Most Used Products Products List',false);
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
<div class="left_right_side">

<!-- left_side close -->


<div class="right_side profile">
<div id="stocktabs"> 
<div class="p-heading"><h3>Stock Records</h3>
<div class="resources_search crm_search">

<input type="text" placeholder="Keywords" id="searchpurchaseReceipt" class="searchpurchaseReceipt">
<i class="fas fa-search"></i>

</div>
</div>

<ul class="stocktabstab" role="tablist">
	<!-- <li>Most Used Products List</a></li> -->
<li><a href="#tabs-Minimum">Most Used Products List</a></li>
</ul>

<div id="tabs-Minimum">
<div class="cpd-table">
<!-- <h3>Most Used Products List</h3> -->
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name</th>
<th>Product Code</th>
<th>Product Image</th>
<th>Product Category</th>

<th>Product Total Used Count</th>

</tr>
</thead>
<tbody>
<?php
if($_SESSION['currentUserType'] == 'Employee'){
// $user = $user = $_SESSION['superid'];
$user = $_SESSION['superid'];
}
else{
$user = $_SESSION['currentUser'];

}


$sqls = "SELECT id,userId FROM `stockOrder`";
$sqls  .= " where userId = '$user'";



// echo $sqls;
$variable=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($variable as $key => $variables) {
$sqls = "SELECT * FROM `stockOrderDetail`";
$sqls  .= " where fKey = '$variables[id]' group by pid,sid,cis";
$var=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($var as $keyc => $valuec) {

// $sqls = "SELECT expiryDate FROM `product_inventory`";
// $sqls  .= " where qty_product_id = '$valuec[pid]' and qty_product_scale = '$valuec[sid]' and qty_product_color = '$valuec[cis]' and qty_store_id = '$user' and expiryDate != '' ";
// $vars=$dbF->getRow($sqls);





         


echo "<tr>
<td> ".$pName          = $productClass->getProductFullNameWeb( $valuec['pid'], $valuec['sid'], $valuec['cis'] ) ." </td>

";





echo "

<td> ".$productClass->p_code( $valuec['pid']) ." </td>
";



if(!empty($productClass->productSpecialImageStock($valuec['pid'], 'main'))){
$pImage = WEB_URL."/images/".$productClass->productSpecialImageStock($valuec['pid'], 'main');
// var_dump($pImage);
echo "<td><img src='$pImage'></img></td>";
}else{

  echo "<td></td>";
}


$aa = "";


if(!empty($productClass->proCategories($valuec['pid']))){


foreach ($productClass->proCategories($valuec['pid']) as $key => $valuesss) {


// for ($i=0; $i <count($productClass->proCategories($asd['0'])); $i++) { 
$aa .= _uc($valuesss)." - ";
}


// trim($aa);



echo "<td>".$aa ."</td>";


}else{

echo "<td></td>";

}




    
$query = "SELECT sum(qty) as ttl FROM `stockOrderDetail`";
$query  .= " where `pid` = '$valuec[pid]' and  `sid` = '$valuec[sid]' and  `cis` = '$valuec[cis]'";
$queryData=$dbF->getRow($query);


if(empty($queryData['ttl'])){

	echo "<td>0</td>";



}else{
echo "<td>".$queryData['ttl']." Quantity Use</td>";

}




echo "







</tr>";





}


}
}










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
</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->

<?php include_once('dashboardfooter.php'); ?>