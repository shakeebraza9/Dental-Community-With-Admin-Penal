<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Stock Dashboard',false);
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




if(isset($_GET['del']))

{


$sqls = base64_decode($_GET['del']);

$dbF->setRow("DELETE FROM `addTobasket` WHERE `id`='$sqls'"); 
}









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
<div class="right_side_top">
<h3 class="main-heading_">Stock Management </h3>
  <div class="change-session">
                    <?php
                    $functions->changeSession();
                    ?>
                    <?php
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data && ($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['health_form'] == 'read' || @$_SESSION['superUser']['health_form'] == 'edit' || @$_SESSION['superUser']['health_form'] == 'full'))
                    { ?>
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                    </div>
                    <?php } ?>

                   
                    </div>
<!--<div class="jumbo" style="background-color: #ffcc00;background-image: url(../webImages/dashboardStock.jpg);">-->
<div class="jumbo flex_">
 <div class="jumbo-left">
     <div class="cpd-main-box">
                <div class="row mainClass">

<?php 
$count = 0;
$users=$_SESSION['webUser']['id'];

if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}


$sqls = "SELECT id FROM `addTobasket`";
$sqls  .= " where loginid = '$users' or practId = '$user'";
$variable=$dbF->getRows($sqls);
if ($dbF->rowCount>0) {
foreach ($variable as $key => $variable) {



// $sqls = "SELECT * FROM `stockOrderDetail`";
// $sqls  .= " where fKey = '$variable[id]'";
// $var=$dbF->getRows($sqls);
// if ($dbF->}
// }}rowCount>0) {
// foreach ($var as $keyc => $valuec) {
$count++;
}
}
?>
<div class="col-md-4">
<div class="cpd-inner-box">
<div class="cpd-box-content">
    <h3><?php echo $count ?></h3>
<h5>Shopping Basket</h5>

</div>
<img src="webImages/basket.svg">
<div class="line"></div>
</div>
<!-- cpd-inner-box -->
</div>
<?php 
$count1 = 0;
if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}

// 
// }

 
  $sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' or `qty_store_id`='$users' AND `min_stock` !='' AND `min_stock` !='0'"; //
$var = $dbF->getRows($sql);


if ($dbF->rowCount>0) {
foreach ($var as $keyc => $valuec) {





if($valuec['min_stock'] >= $valuec['qty_item']){$count1++;}

}


}


?>



                 




<div class="col-md-4">
<div class="cpd-inner-box">
<div class="cpd-box-content">
<h3><?php echo $count1 ?></h3>
<h5>Minimum Stock List</h5>

</div>
<img src="webImages/basket.svg">
<div class="line"></div>
</div>
<!-- cpd-inner-box -->
</div>




                 <?php 
$count3 = 0;
if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}

// }


 
  $sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' or `qty_store_id`='$users' AND  `expiryDate` !=''"; //
$var = $dbF->getRows($sql);


if ($dbF->rowCount>0) {
foreach ($var as $keyc => $valuec) {





if(date('d-M-Y') >= $valuec['expiryDate']){$count3++;}

}


}
 ?>

   <div class="col-md-4">
                        <div class="cpd-inner-box">
                            <div class="cpd-box-content">
                                 <h3><?php echo $count3 ?></h3>
                                <h5>Expire Products</h5>
                               
                            </div>
                            <img src="webImages/textwin.svg">
                            <div class="line"></div>
                        </div>
                        <!-- cpd-inner-box -->
                    </div>


                </div>
            </div>
            <!-- cpd-main-box --></div>
<div class="jumbo-right">
                            <div class="jumbo-v">
                                <img src="webImages/jumbovideo.png">
                                <a onclick="video('EJUtPIhK-Bg')"><img src="webImages/jumbobtn.svg"></a>
                            </div>
                            <div><span>Play a Demo Video
                        </span></div>
                    </div>
</div>
<!-- jumbo -->
</div>
<!-- right_side_top close -->






<div id="stocktabs">  
<div class="p-heading"><h3>Stock Records</h3>
<div class="resources_search crm_search">


<input type="text" placeholder="Keywords" id="searchpurchaseReceipt" class="searchpurchaseReceipt">
<i class="fas fa-search"></i>
<!-- <button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>
</button> -->


<!--<button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>-->

<!--<span><?php echo $count ?></span>-->

</button>




</div>
</div>
<ul class="stocktabstab">
<li><a href="#tabs-Minimum">Minimum Quantity Product List</a></li>
<li><a href="#tabs-Expiry">Expiry Product List</a></li>
<li><a href="#tabs-Basket">Shopping Basket</a></li>
</ul>






<!-- resources_search -->

   <div id="tabs-Minimum">




<!-- <div class="resources_search crm_search"> -->

<!-- <select id="pProductSearchOPTION" class="pProductSearchOPTION">
<?php echo $functions->pProductSearchOPTION() ?>
</select>


<select id="pProductSearchOPTION_services" class="pProductSearchOPTION_services">
<?php echo $functions->pProductSearchOPTION_location() ?>
</select>
<input type="text" placeholder="Keywords" id="pProductSearchOPTION_Minimum" class="pProductSearchOPTION_Minimum pProductSearchOPTION"> -->
<!-- <button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>

<span><?php echo $count ?></span>

</button> -->
<!-- </div> -->
<!-- resources_search -->




<div class="cpd-table">
<!--<h3>Minimum Quantity Product List</h3>-->
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name (Quantity)</th>
<th>Product Location (Expiry Date)</th>
<!-- <th>Product Expiry Date</th> -->
<th>Product Description</th>
<!-- <th>User</th> -->



<th>Product Category</th>
<th>Product Image</th>





</tr>
</thead>
<tbody>
<?php
if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}

// }

 
  $sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' or `qty_store_id`='$users' AND `min_stock` !='' AND `min_stock` !='0'  ORDER BY `product_inventory`.`qty_item` ASC"; //
$data = $dbF->getRows($sql);
foreach ($data as $key => $value) {
// var_dump($value['min_stock']);
// var_dump($value['qty_item']);
if($value['min_stock'] >= $value['qty_item']){


$pracName=   $functions->UserName($value['qty_store_id']);            


echo "<tr>
<td>".$productClass->getProductFullNameWeb( $value['qty_product_id'], $value['qty_product_scale'], $value['qty_product_color'] ) ." (".$value['qty_item'].")</td>
<td>$value[location] ($value[expiryDate])</td>
";

// var_dump($productClass->proCategories($asd['0']));
$proProDesc= $productClass->proProDesc($value['qty_product_id']);

echo "<td>".$proProDesc ."</td>";


$aa = "";


if(!empty($productClass->proCategories($value['qty_product_id']))){


foreach ($productClass->proCategories($value['qty_product_id']) as $key => $valuesss) {


// for ($i=0; $i <count($productClass->proCategories($asd['0'])); $i++) { 
$aa .= $valuesss." \n";
}


// trim($aa);



echo "<td>".$aa ."</td>";


}else{

echo "<td></td>";

}







if(!empty($productClass->productSpecialImageStock($value['qty_product_id'], 'main'))){
$pImage = WEB_URL."/images/".$productClass->productSpecialImageStock($value['qty_product_id'], 'main');
// var_dump($pImage);
echo "<td><img src='$pImage'></img></td>";
}else{

  echo "<td></td>";
}

echo"



</tr>";

// continue;

}else{




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


   <div id="tabs-Expiry">



<!-- 
    <div class="resources_search crm_search">
<select id="pProductSearchOPTION" class="pProductSearchOPTION">
<?php echo $functions->pProductSearchOPTION() ?>
</select>
<select id="pProductSearchOPTION_services" class="pProductSearchOPTION_services">
<?php echo $functions->pProductSearchOPTION_location() ?>
</select>
<input type="text" placeholder="Keywords" id="pProductSearchOPTION_serviceskywd" class="pProductSearchOPTION_services pProductSearchOPTION">
<button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i><span><?php echo $count ?></span></button>
</div> -->
<!-- resources_search -->




<div class="cpd-table">
<!--<h3>Expiry Product List</h3>-->
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name (Quantity)</th>
<th>Product Location (Expiry Date)</th>
<!-- <th>Product Expiry Date</th> -->
<!-- <th>Certifcate</th> -->
<th>Product Description</th>


<th>Product Category</th>
<th>Product Image</th>





</tr>
</thead>
<tbody>
<?php
if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}

// }
$sql = "SELECT * FROM `product_inventory`  WHERE `qty_store_id`='$user' or `qty_store_id`='$users' AND `expiryDate`!='' ORDER BY `product_inventory`.`expiryDate` ASC"; //
$data = $dbF->getRows($sql);
foreach ($data as $key => $value) {





$pracName=   $functions->UserName($value['qty_store_id']);            


echo "<tr>
<td>".$productClass->getProductFullNameWeb( $value['qty_product_id'], $value['qty_product_scale'], $value['qty_product_color'] ) ." (".$value['qty_item'].")</td>
<td>$value[location] ($value[expiryDate])</td>
";



$proProDesc= $productClass->proProDesc($value['qty_product_id']);

echo "<td>".$proProDesc ."</td>";





// var_dump($productClass->proCategories($asd['0']));
$aa = "";


if(!empty($productClass->proCategories($value['qty_product_id']))){


foreach ($productClass->proCategories($value['qty_product_id']) as $key => $valuesss) {


// for ($i=0; $i <count($productClass->proCategories($asd['0'])); $i++) { 
$aa .= $valuesss." \n";
}


// trim($aa);



echo "<td>".$aa ."</td>";


}else{

echo "<td></td>";

}







if(!empty($productClass->productSpecialImageStock($value['qty_product_id'], 'main'))){
$pImage = WEB_URL."/images/".$productClass->productSpecialImageStock($value['qty_product_id'], 'main');
// var_dump($pImage);
echo "<td><img src='$pImage'></img></td>";
}else{

  echo "<td></td>";
}

echo"

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



   <div id="tabs-Basket">








<div class="cpd-table">
<!--<h3>Shopping Basket List</h3>-->
<div class="cpd-tbl tableStock">
<table>
<thead>
<tr>
<th>Product Name</th>
<!-- <th>Product Location (Expiry Date)</th> -->

<th>Product Description</th>


<th>Product Category</th>
<th>Product Image</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}

$users=$_SESSION['webUser']['id'];



$sql = "SELECT * FROM `addTobasket`  WHERE `practId`='$user' OR `loginid` ='$users' ORDER BY `addTobasket`.`id` DESC"; //
$data = $dbF->getRows($sql);
foreach ($data as $key => $value) {


$asd =explode(":", $value['hash']);


echo "<tr><td>".$productClass->getProductFullNameWeb($asd['0'],$asd['1'],$asd['2']) ."</td>";


$proProDesc= $productClass->proProDesc($value['qty_product_id']);

echo "<td>".$proProDesc ."</td>";

// var_dump($productClass->proCategories($asd['0']));
$aa = "";


if(!empty($productClass->proCategories($asd['0']))){


foreach ($productClass->proCategories($asd['0']) as $key => $valuesss) {


// for ($i=0; $i <count($productClass->proCategories($asd['0'])); $i++) { 
$aa .= $valuesss." \n";
}


// trim($aa);



echo "<td>".$aa ."</td>";


}else{

echo "<td></td>";

}







if(!empty($productClass->productSpecialImageStock($asd['0'], 'main'))){
$pImage = WEB_URL."/images/".$productClass->productSpecialImageStock($asd['0'], 'main');
// var_dump($pImage);
echo "<td><img src='$pImage'></img></td>";
}else{

  echo "<td></td>";
}

echo "





<td>";





echo '
<a class="del-btn"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\');" href="stock?del=' . base64_encode($value['id']) . '"><i class="fas fa-trash"></i></a>';








echo "
</td>
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






























</div>



</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->



<?php include_once('footer.php'); ?>