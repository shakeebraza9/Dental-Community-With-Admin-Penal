<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Stock Consumption Per Surgery',false);
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
include_once('header.php'); 

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
<div class="link_menu">
<span>

<img src="webImages/menu.png" alt="">
</span>
Stock Management
</div>
<!--link_menu close-->
<div class="left_side">
<?php $active = 'stockDashboard'; include'dashboardmenu.php';?>
</div>

<!-- left_side close -->


<div class="right_side profile">




<div class="resources_search crm_search">


<input type="text" placeholder="Keywords" id="searchpurchaseReceipt" class="searchpurchaseReceipt">
<!-- <button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>
</button> -->






</div>
<!-- resources_search -->




<div class="cpd-table">
<h3>Stock Consumption Per Surgery</h3>
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name</th>
<th>Product Code</th>
<th>Product Image</th>
<th>Product Category</th>




<?php


 $userId =  $_SESSION['webUser']['id'];
        


if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}





$sqls = "SELECT id,userId FROM `stockOrder`";
$sqls  .= " where submitBy = '$userId' or  userId = '$user'";
$variable=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($variable as $key => $variables) {
$sqls = "SELECT * FROM `stockOrderDetail`";
$sqls  .= " where fKey = '$variables[id]' group by surgerie";
$var=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($var as $keyc => $valuec) {

    


echo "<th>$valuec[surgerie]</th>";




}
}

}
}
?>



<!-- <th>Surgery</th>
<th>Product Total Used Count</th> -->
<!-- <th>Certifcate</th> -->
<!-- <th>User</th> -->
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






              

$count3 = 0;
// $u_id = $_SESSION['currentUser'];
$sqls = "SELECT id,userId FROM `stockOrder`";
$sqls  .= " where submitBy = '$userId' or  userId = '$user'";
$variable=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($variable as $key => $variables) {
$sqls = "SELECT * FROM `stockOrderDetail`";
$sqls  .= " where fKey = '$variables[id]' group by pid,sid,cis";
$var=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($var as $keyc => $valuec) {
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





$sqls1 = "SELECT id,userId FROM `stockOrder`";
$sqls1 .= " where submitBy = '$userId' or  userId = '$user'";
$variable1=$dbF->getRows($sqls1);
if ($dbF->rowCount>0) {
foreach ($variable1 as $key1 => $variables1) {
$sqlsd = "SELECT * FROM `stockOrderDetail`";
$sqlsd  .= " where fKey = '$variables1[id]' group by surgerie";
$vard=$dbF->getRows($sqlsd);
if ($dbF->rowCount>0) {
foreach ($vard as $keycd => $valuecd) {

    
$query = "SELECT sum(qty) as ttl FROM `stockOrderDetail`";
$query  .= " where `pid` = '$valuec[pid]' and  `sid` = '$valuec[sid]' and  `cis` = '$valuec[cis]' and  `surgerie` = '$valuecd[surgerie]'";
$queryData=$dbF->getRow($query);


if(empty($queryData['ttl'])){

	echo "<td>0</td>";



}else{
echo "<td>".$queryData['ttl']." Quantity Use</td>";

}





}
}

}
}




echo "</tr>";
$count3++;



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
<!-- right_side close -->
</div>
<!-- left_right_side -->

<?php include_once('footer.php'); ?>