<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Add Incoming Stock',false);
}


// $dbF->prnt($_SESSION);
$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
$msg  = "";
$chk  = $functions->receiptAdd();
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$grn = $functions->GRN();



if($chk){
$msg = $chk;
}
// include_once('header.php'); 

include'dashboardheader.php';
// $user = $_SESSION['currentUser'];

// if ($_SESSION['currentUserType'] !='Employee') {
// $u_id = $_SESSION['currentUser'];
// }else
// {
// $u_id = $_SESSION['webUser']['id'];
// }

?>
<div class="index_content mypage health_form">
<!-- <div class="left_right_side"> -->

<!-- left_side close -->
<div class="right_side profile">
<div class="right_side_top">


<h4>Stock Management</h4>
</div>
<!-- right_side_top close -->
<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>

<div class="menu_area">
<ul>

<li class="dash-btn"><a href="<?= WEB_URL?>/stockView#tabs-2"><i class="fas fa-plus"></i>Add Existing Stock</a></li>


<li class="dash-btn"><a href="#"><i class="fas fa-plus"></i>Add Incoming Stock</a></li>
<li class="dash-btn"><a href="<?= WEB_URL?>/stockOrder"><i class="fas fa-table"></i>Stock Received</a></li>
<li class="dash-btn"><a href="<?= WEB_URL?>/stockView"><i class="fas fa-list"></i>View Stock Per Locations</a></li>





</ul>
</div>






<div id="tabs">
<ul>

<li><a active href="#tabs-1">Stock Received</a></li>


<?php

if($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['manage_stock'] == 'read' || @$_SESSION['superUser']['manage_stock'] == 'edit' || @$_SESSION['superUser']['manage_stock'] == 'full')
{ ?>


<li><a href="#tabs-2">Add Incoming Stock Form</a></li>


<?php } ?>

</ul>   
<div id="tabs-1">



<div class="resources_search crm_search">


<input type="text" placeholder="Keywords" id="searchpurchaseReceipt" class="searchpurchaseReceipt">
<!-- <button type="submit" id="resources_search"><i class='fas fa-cart-plus'></i>
</button> -->
</div>
<!-- resources_search -->







<div class="cpd-table">
<div class="cpd-tbl tableStock">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>


<th>SNO</th>
<th>Name of Product</th>
<th>Reference Number</th>
<th>Purchasing Date</th>
<th>Receiver</th>
<th>Supplier </th>
<th>Note </th>


</tr>
</thead>
<tbody>


<?php 
$userId =  $_SESSION['webUser']['id'];

$sqls = "SELECT * FROM `purchase_receipt`";


if (isset($_SESSION['practiceUser'])) {
$user =    intval($_SESSION['practiceUser']);
} else {
$user = intval($_SESSION['currentUser']);
}
$sqls  .= " where submitBy = '$userId' or store = '$user'";
// }


$sqls  .= " ORDER BY `purchase_receipt`.`receipt_pk` DESC";


$variable=$dbF->getRows($sqls);
$i =1;$temp = "";
foreach ($variable as $key => $value): 


?>



<tr>

<td>
<?php echo $i ?>


<!-- <a href="purchaseReceipt?edit=<?php echo base64_encode($value['receipt_pk']); ?>#tabs-2" target="_blank" data-toggle="tooltip" title="Edit" class="ablue"><i class="fas fa-edit"></i></a> -->





</td>

<td>
<?php 


$sqlsX = "SELECT * FROM `purchase_receipt_pro` where receipt_id = ?";

$variableX=$dbF->getRows($sqlsX,array($value['receipt_pk']));

$a = 1;
foreach ($variableX as $keyX => $valueX) {

$temp = "";

@$hashVal = $valueX['receipt_product_id'] . ":" . $valueX['receipt_product_scale'] . ":" . $valueX['receipt_product_color'] . ":" . $value['store'];
$hashCart = md5($hashVal);


$sqlsX1 = "SELECT location FROM `product_inventory` where qty_store_id = ? and product_store_hash = ?";
$variableX1=$dbF->getRow($sqlsX1,array($value['store'],$hashCart));

// $variableX1=$dbF->getRows($sqlsX1,array($value['store']));

// $temp = "";

// foreach ($variableX1 as $keyX1 => $valueX1) {
//     // $temp = "";
// $temp .= $valueX1['location'].",";

// }


$temp = trim($temp,",");



// $temp .= ")";


echo   $a.") ".$pName          = $productClass->getProductFullNameWeb( $valueX['receipt_product_id'], $valueX['receipt_product_scale'], $valueX['receipt_product_color'] ) ."<br>(Incoming Quantity: ".$valueX['receipt_qty'].")<br>(Single Price: ".$valueX['receipt_price'].")<br>(Product Code ".$valueX['p_code'].")<br>(Stock storage location: ".$variableX1['location'].")<hr>";



$a++;

}



?>

</td>

<td>
<?php echo $value['grn']; ?>

</td>

<td>
<?php echo $value['receipt_date']; ?>

</td>

<td>

<?php echo $value['receiver']; ?>
</td>


<td>

<?php echo $value['vendor']; ?>
</td>




<td>

<?php echo $value['note']; ?>
</td>
</tr>
<?php
$i++;

endforeach ?>
</tbody>



</table>
</div> 
</div> 


</div>


<div id="tabs-2">
<form class="profile" method="post" action="purchaseReceipt" enctype="multipart/form-data">
<?php echo $functions->setFormToken('purchaseReceiptAdd',false);

if(isset($_GET['edit'])){
$sql = "SELECT * FROM purchase_receipt WHERE receipt_pk=?";
$data = $dbF->getRow($sql,array(base64_decode($_GET['edit'])));
$grn = base64_decode($_GET['edit']).''.$functions->ibms_setting('GRN');
?>
<div class="row">
<input type="hidden" readonly="" name="receipt_grn" value="<?php echo $grn ?>">
<input type="hidden" readonly="" name="purchaseReceiptEditHidden" value="<?php echo $_GET['edit']; ?>">
<div class="form-group-flex">
    <div class="form-group-date">
        <label for="date" class="label3">Purchasing Date :</label>
            <input id="datepicker" class="form-control" type="text" name="receipt_date" autocomplete="off" value="<?php echo $data['receipt_date'] ?>" id="purchaseReceiptDATE">
</div>
    </div>
<input type="hidden" name="receipt_prf" value="">
<input type="hidden" name="receipt_ponumber" value="">
<div class="form-group col-12 col-sm-6">
<label>Receiver :</label>
<?php  $functions->receiverDroupdownOptions(); ?>
</div>
<div class="form-group col-12 col-sm-6">
<label>Supplier :</label>
<input type="text" name="receipt_supplier" value="<?php echo $data['vendor'] ?>">
</div>
<input type="hidden" name="receipt_store_id" value="<?php echo $data['store'] ?>">
<div class="form-group col-12 col-sm-6">
<label>Note :</label>
<input type="text" name="receipt_note" value="<?php echo $data['note'] ?>">
</div>
<div class="cpd-table">
<div class="cpd-tbl tableStock">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th>Name of product</th>
<th class="allowProductScale">Size</th>
<th class="allowProductColor">Color</th>
<th>Quantity</th>
<th>Single price</th>
<th>Stock location</th>
<th>Expiry date</th>
<th>MIN quantity</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="text" class="form-control" id="receipt_product_id" placeholder=" ">
<input type="hidden" class="form-control receipt_product_id" data-val="">
<input type="hidden" class="form-control receipt_product_pcode" data-val="">
<input type="hidden" class="form-control receipt_product_pstatus" data-val="">
<p style="color: red;" class="showNEW"></p>
</td>
<td class="allowProductScale">
<input type="text" class="form-control" id="receipt_product_scale" placeholder=" " readonly value=" ">
<input type="hidden" class="form-control receipt_product_scale" data-val="">
</td>
<td class="allowProductColor">
<input type="text" class="form-control" id="receipt_product_color" placeholder=" " readonly value=" ">
<input type="hidden" class="form-control receipt_product_color" data-val="">
</td>
<td>
<input type="number" min="1" max="100" class="form-control" id="receipt_qty" placeholder=" ">
</td>
<td>
<input type="text" value="" class="form-control" id="receipt_price" placeholder=" ">
</td>
<td>
<input type="text" class="form-control" id="pLocation" placeholder=" ">
</td>
<td class="">
<input type="text" class="form-control" autocomplete="off" id="pExpiry" placeholder=" ">
</td>
<td class="">
<input type="number" min="1" max="100" class="form-control" id="minStock" placeholder=" ">

<!-- <div class="form-group">
<div class="col-sm-10"> -->
<button type="button" onclick="receiptFormValid();" id="AddProduct" class="btn btn-primary" style="
    float: right;
">Add</button>
<!-- </div>
</div> -->


</td>
</tr></tbody>
</table>
</div>
</div>
<!-- <div class="form-group">
<div class="col-sm-10">
<button type="button" onclick="receiptFormValid();" id="AddProduct" class="btn btn-primary">Add Product</button>
</div>
</div> -->
<div class="cpd-table">
<div class="cpd-tbl tableStock">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th> </th>
<th>Name of product</th>
<th>Quantity</th>
<th>Single Price</th>
<th>Stock storage location</th>
<th>Product Expiry date</th>
<th>Minimum Quantity level</th>
<th>Product Code</th>
</tr>
</thead>
<tbody id="vendorProdcutList">

<?php
$sqlsX = "SELECT * FROM `purchase_receipt_pro` where receipt_id = ?";

$variableX=$dbF->getRows($sqlsX,array(base64_decode($_GET['edit'])));

$a = 1;
foreach ($variableX as $keyX => $valueX) {


$sqlsX1 = "SELECT * FROM `product_inventory` where qty_store_id = ? and qty_product_id = ? and qty_product_scale = ? and qty_product_color = ?";

$variableX1=$dbF->getRow($sqlsX1,array($valueX['store'],$valueX['receipt_product_id'],$valueX['receipt_product_scale'],$valueX['receipt_product_color']));



?>

<tr id="tr_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>">

<td><i class="fas fa-trash" id="p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" onclick="deleteTR(this.id)"></i><input type="hidden" name="cart_list[]" value="p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>">

</td>

<td><?php echo $productClass->getProductFullNameWeb( $valueX['receipt_product_id'], $valueX['receipt_product_scale'], $valueX['receipt_product_color'] ); ?><input type="hidden" name="pid_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $valueX['receipt_product_id'] ?>"><input type="hidden" name="pscale_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $valueX['receipt_product_scale'] ?>"><input type="hidden" name="pcolor_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $valueX['receipt_product_color'] ?>">

</td>

<td><?php echo $valueX['receipt_qty'] ?><input type="hidden" name="pqty_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $valueX['receipt_qty'] ?>">

</td>

<td><?php echo $valueX['receipt_price'] ?><input type="hidden" name="pprice_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $valueX['receipt_price'] ?>">

</td><input type="hidden" id="pcodess" name="pcodess" value="<?php echo $valueX['receipt_product_id'] ?>">

<td><?php echo $variableX1['location'] ?><input type="hidden" name="pLocation_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $variableX1['location'] ?>">

</td>

<td><?php echo $variableX1['expiryDate'] ?><input type="hidden" name="pExpiry_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $variableX1['expiryDate'] ?>">

</td>

<td><?php echo $variableX1['min_stock'] ?><input type="hidden" name="minStock_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>" value="<?php echo $variableX1['min_stock'] ?>">

</td>

<?php 


$sqlsX12 = "SELECT p_status FROM `proudct_detail` where prodet_id = ?";

$variableX12=$dbF->getRow($sqlsX12,array($valueX['receipt_product_id']));


if($variableX12['p_status'] == 1){
?>

<td><?php echo $valueX['p_code'] ?> <input type="hidden" name="pcode_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>_pd[]" placeholder="PRODUCT CODE" value="<?php echo $valueX['p_code'] ?>"> 

</td>
<?php }else{

$types   = explode(",",$valueX['p_code']);

foreach ($types as $keye => $valuee) {



?>
<td><?php echo $valuee ?> <input type="hidden" name="pcode_p_<?php echo $valueX['receipt_product_id'] ?>-<?php echo $valueX['receipt_product_scale'] ?>-<?php echo $valueX['receipt_product_color'] ?>-<?php echo $valueX['store'] ?>_pd[]" placeholder="PRODUCT CODE" value="<?php echo $valuee ?>"> 

</td>
<?php 
} } ?>






</tr>


<?php } ?>

</tbody>
</table>
</div> 
</div> 
</div> <!-- add product script div end -->
<p id="msg" style="color: red;"></p>
<input type="submit" class="submit_class"  value="Edit Submit Information" name="submit">
<?php
}else{


if (isset($_SESSION['practiceUser'])) {
$userS =    intval($_SESSION['practiceUser']);
} else {
$userS = intval($_SESSION['currentUser']);
}

?>
<div class="row">
<input type="hidden" readonly="" name="receipt_grn" value="<?php echo $grn ?>">
<div class="form-group col-12 col-sm-6">
<label>Purchasing Date :</label>
<input type="text" name="receipt_date" autocomplete="off" value="" id="purchaseReceiptDATE">
</div>
<input type="hidden" name="receipt_prf" value="">
<input type="hidden" name="receipt_ponumber" value="">
<div class="form-group col-12 col-sm-6">
<label>Receiver :</label>
<?php  $functions->receiverDroupdownOptions(); ?>
</div>
<div class="form-group col-12 col-sm-6">
<label>Supplier :</label>
<input type="text" name="receipt_supplier" value="">
</div>
<input type="hidden" name="receipt_store_id" value="<?php echo $userS; ?>">
<div class="form-group col-12 col-sm-6">
<label>Note :</label>
<input type="text" name="receipt_note" value="">
</div>
<div class="cpd-table">
<div class="cpd-tbl tableStock">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th>Name of product</th>
<th class="allowProductScale">Size</th>
<th class="allowProductColor">Color</th>
<th>Quantity</th>
<th>Single price</th>
<th>Stock location</th>
<th>Expiry date</th>
<th>MIN quantity</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="text" class="form-control" id="receipt_product_id" placeholder=" ">
<input type="hidden" class="form-control receipt_product_id" data-val="">
<input type="hidden" class="form-control receipt_product_pcode" data-val="">
<input type="hidden" class="form-control receipt_product_pstatus" data-val="">
<p style="color: red;" class="showNEW"></p>
</td>
<td class="allowProductScale">
<input type="text" class="form-control" id="receipt_product_scale" placeholder=" " readonly value=" ">
<input type="hidden" class="form-control receipt_product_scale" data-val="">
</td>
<td class="allowProductColor">
<input type="text" class="form-control" id="receipt_product_color" placeholder=" " readonly value=" ">
<input type="hidden" class="form-control receipt_product_color" data-val="">
</td>
<td>
<input type="number" min="1" max="100" class="form-control" id="receipt_qty" placeholder=" ">
</td>
<td>
<input type="text" value="" class="form-control" id="receipt_price" placeholder=" ">
</td>
<td>
<input type="text" class="form-control" id="pLocation" placeholder=" ">
</td>
<td class="">
<input type="text" class="form-control" autocomplete="off" id="pExpiry" placeholder=" ">
</td>
<td class="">
<input type="number" min="1" max="100" class="form-control" id="minStock" placeholder=" ">



<!-- <div class="form-group">
<div class="col-sm-10"> -->
<button type="button" onclick="receiptFormValid();" id="AddProduct" class="btn btn-primary" style="
    float: right;
">Add</button>
<!-- </div>
</div> -->
</td>



</tr></tbody>
</table>
</div>
</div>

<div class="cpd-table">
<div class="cpd-tbl tableStock">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th> </th>
<th>Name of product</th>
<th>Quantity</th>
<th>Single Price</th>
<th>Stock storage location</th>
<th>Product Expiry date</th>
<th>Minimum Quantity level</th>
<th>Product Code</th>
</tr>
</thead>
<tbody id="vendorProdcutList">
</tbody>
</table>
</div> 
</div> 
</div> <!-- add product script div end -->
<p id="msg" style="color: red;"></p>
<?php 
 if($_SESSION['userType']=='Trial')
{
    echo '<input type="button" onclick="alertbx()" class="submit_class"  value="Submit Information">';
}else{?>
<input type="submit" class="submit_class"  value="Submit Information" name="submit">
<?php
}}
?>

</form> 
</div>







</div>             




</div>
</div>
</div>
<!-- right_side close -->
<!-- </div> -->
<!-- left_right_side -->


<?php 
if (isset($_SESSION['practiceUser'])) {
$userSa =    intval($_SESSION['practiceUser']);
} else {
$userSa = intval($_SESSION['currentUser']);
}

 ?>
<script type="text/javascript">

//for small delete in other project
function secure_delete(text){
// text = 'view on alert';
text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

bool=confirm(text);
if(bool==false){return false;}else{return true;}

}

function notBlank(){






$(".skuTxt").each(function(index){
// var  codeduplicate = $(".skuTxt").val()

console.log($( this ).text());
console.log($( this ).val());


if( $( this ).val() == ""){
// alert("PRODUCT CODE Fields Are Empty");
$('#msg').text('PRODUCT CODE Fields Are Empty');
// $('.submit_class').attr('disabled',true); 
// return false;
}else{
$('#msg').text('');
$('.submit_class').attr('disabled',false); 
}


});






}



function receiptFormValid(){
var  codeduplicate = $("#pcodedupicate").val()
if( $("#receipt_date").val() == "" ||  $("#receipt_product_id").val() == "" /*
$(".receipt_product_scale.has").val() == ""  || $(".receipt_product_color.has").val() == "" || */
// ||  $("#receipt_store_id").val() == ""
){
alert("Required Fields Are Empty");
return false;




}



qty =parseInt($("#receipt_qty").val());
if(qty > 0){
$("#receipt_qty").val(qty);
}else{
alert("Product Quantity Is Not Correct");
return false;
}

price =parseFloat($("#receipt_price").val());
if(price > 0){
$("#receipt_price").val(price)
}else{
alert("Product Price Is Not Correct");
return false;
}
addListItem();

}
//////////////////////////////

///////////////////////////
var sr=0;
function addListItem() {
//disable one time required fields
$(".receipt_store_id").val($("#receipt_store_id").val());
$("#store").attr("disabled","disabled");
$("#receipt_date,#receipt_vendor").attr("readonly","readonly");
//disable end


var pid     = parseInt($(".receipt_product_id").val());  


var pScaleId = parseInt($(".receipt_product_scale").val());
var pColorId = parseInt($(".receipt_product_color").val());


if(isNaN(pid)){

if(secure_delete('Are You Sure You Want To Add a Product ?')){

var customProAddedName     = $("#receipt_product_id").val(); 
console.log("custom Product is added in process");
addNewProductByUser(customProAddedName);





// $.ajax({
// url: 'ajax_call.php?page=customProAdded',
// type: 'post',
// data: {
// customProAddedName: customProAddedName
// }
// }).done(function(res) {
// var res = '3';

// console.log(res);



}

}else{


if(isNaN(pScaleId)){pScaleId = 0;}
if(isNaN(pColorId)){pColorId = 0;}

scaleVal = " -- "   +   $("#receipt_product_scale").val();
colorVal = " -- "   +   $("#receipt_product_color").val();

//if no color or scale has then scale and color name blank to show on temparary
if(pScaleId == '0'){
scaleVal = '';
}
if(pColorId == '0'){
colorVal = '';
}

var pName = $("#receipt_product_id").val() + scaleVal +colorVal;
//    var vendor =$("#receipt_vendor").val();
var date    =   $("#receipt_date").val();
var price   =   parseFloat($("#receipt_price").val());
var qty     =   parseInt($("#receipt_qty").val());
var store   =   parseInt($("#r_store").val());


var pLocation   =   ($("#pLocation").val());
var pExpiry   =   ($("#pExpiry").val());
var minStock   =   ($("#minStock").val());

var store   =   '<?php echo $userSa ?>';
//   var storeName = $("#receipt_store_id option:selected").text();

var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;


console.log(trpid);




console.log('ddddddddddddddddddd');

if (document.getElementById("tr_"+trpid)) {

alert("Duplicate Entry : Product Item already exist in list!");

document.getElementById(trpid).checked = true;
checkchange(trpid);
}
else if (qty > 0 && pid > 0 ) {
sr++;
var text = '';
// var loca = '';
var item = "<tr id='tr_"+trpid+ "'>"+
"<td><i class='fas fa-trash' id='"+trpid+ "' onclick='deleteTR(this.id)'></i>" +
"<input type='hidden' name='cart_list[]' value='"+trpid+"' /></td>"+


//   "<td><input type='checkbox' id='"+trpid+ "' onchange='deleteTR(this.id)' value='" + trpid + "' class='checkboxclass' />" +
// "<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
//  "<td>"+date+"<input type='hidden' name='pdate_"+trpid+"' value='"+date+"' /></td>"+
//  "<td>"+vendor+"<input type='hidden' name='pvendor_"+trpid+"' value='"+vendor+"' /></td>"+
"<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
"<input type='hidden' name='pscale_"+trpid+"' value='"+pScaleId+"' />" +
"<input type='hidden' name='pcolor_"+trpid+"' value='"+pColorId+"' /></td>"+
"<td>"+qty + "<input type='hidden' name='pqty_"+trpid+"' value='"+qty+"' /></td>"+
"<td>"+price+"<input type='hidden' name='pprice_"+trpid+"' value='"+price+"' /></td><input type='hidden' id='pcodess' name='pcodess' value='"+pid+"' /><td>"+pLocation+"<input type='hidden' name='pLocation_"+trpid+"' value='"+pLocation+"' /></td><td>"+pExpiry+"<input type='hidden' name='pExpiry_"+trpid+"' value='"+pExpiry+"' /></td><td>"+minStock+"<input type='hidden' name='minStock_"+trpid+"' value='"+minStock+"' /></td><td></td><p id='message1'></p>"+
//  "<td>"+storeName+"<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
"</tr>";





p_status = 0;

var pstatus = $(".receipt_product_pstatus").val();
var pcode = $(".receipt_product_pcode").val();
// alert(pstatus);
if ( pstatus == "0" ) {
for (i = 0; i < 1; i++) {
text += pcode+" <input type='hidden' name='pcode_"+trpid+"_pd[]' placeholder='PRODUCT CODE' value='"+pcode+"' /> ";
// text +="<input type='text' class='form-control' style='display: inline-block;width: 50%;' placeholder='Location' name='location_"+trpid+"_pd[]' value='' /><br>";



}
}

else if ( pstatus == "1" ) {

for (i = 0; i < qty; i++) {
text +="<input type='text' class='form-control skuTxt' placeholder='PRODUCT CODE' name='pcode_"+trpid+"_pd[]' value='' />";
// text +="<input type='text' class='form-control' style='display: inline-block;width: 50%;' placeholder='Location' name='location_"+trpid+"_pd[]' value='' /><br>";


}
} 

$("#vendorProdcutList").append(item);
$("#vendorProdcutList tr:last-child td:last-child").append(text);
blankField();






}


$(".skuTxt").focusout(function(){

result_id = $(this).val();

if(result_id == ""){

notBlank();

}else{

$.ajax({
url: 'ajax_call.php?page=chkDuplicateSKU',
type: 'post',
data: {
result_id: result_id
}
}).done(function(res) {
console.log(res);
if (res == '1') { $(this).val("");
// alert('PRODUCT CODE already exist');
$('#msg').text('PRODUCT CODE already exist');
// $('.submit_class').attr('disabled',true); 




}else{

$('#msg').text('');
$('.submit_class').attr('disabled',false);  

}
});



}




console.log($(this).val());


notBlank();

});




}








}


function checkchange(pid) {
var tr = "tr_" + pid;
if ($('#' + pid).is(":checked")) {
$("#"+tr).addClass("highlitedtd");
}
else {
$("#"+tr).removeClass("highlitedtd");
}
}
function deleteTR(pid) {
var tr = "tr_" + pid;

$("#"+tr).remove();


// if ($('#' + pid).is(":checked")) {
//     $("#"+tr).addClass("highlitedtd");
// }
// else {
//     $("#"+tr).removeClass("highlitedtd");
// }
}


function blankField(){

console.log(blankField);
$("#receipt_qty,#receipt_price,#receipt_product_id, #receipt_store_id,#receipt_store_id2,#receipt_eqty,#receipt_nqty,#receipt_econd,#receipt_ncond,.receipt_product_pstatus,.receipt_product_pcode,.receipt_product_id,#pLocation,#pExpiry,#minStock").val("");
// color(null);
// scale(null);
$(".showNEW").empty();
}
function scale(data,pid,storeId,pActualPrice){
scaleId = "#receipt_product_scale";
scaleHiddenClass= ".receipt_product_scale";


pPrice = "#receipt_price";



pLocation = "#pLocation";
pExpiry = "#pExpiry";
minStock = "#minStock";




if(data==null){
$(scaleId).val('Product Scale Not Available').attr("readonly","readonly");
$(scaleHiddenClass).removeClass("has");
$(scaleHiddenClass).val('0').attr("data-val",'0');
data = [];
}else{
$(scaleId).val('').removeAttr("readonly");
$(scaleHiddenClass).addClass("has");
}

$(scaleId).autocomplete({
source: data,
minLength: 0,
select: function( event, ui ) {
$(scaleHiddenClass).val(ui.item.id).attr("data-val",ui.item.label);

var scaleID = ui.item.id;
var pID = pid;
var storeID = storeId;

$.ajax({
url: 'ajax_call.php?page=md5hashScale',
type: 'post',
data: {scaleID: scaleID,pID: pID,storeID: storeID,pActualPrice: pActualPrice}
}).done(function(res) {

resultObj = eval(res);


var tTL = resultObj[0];
var pLocation1 = resultObj[1];
var pExpiry1 = resultObj[2];
var minStock1 = resultObj[3];








$(pPrice).val(tTL);

$(pLocation).val(pLocation1);
$(pExpiry).val(pExpiry1);
$(minStock).val(minStock1);

});





return scaleID;


}
}).on('focus : click', function(event) {
$(this).autocomplete("search", "");
});
};



function color(data,pid,storeId,pActualPrice,scaleId){
colorId = "#receipt_product_color";
colorHiddenClass= ".receipt_product_color";
pPrice = "#receipt_price";
pLocation = "#pLocation";
pExpiry = "#pExpiry";
minStock = "#minStock";
var a  = $('#receipt_price').val();





$(colorId).css('border','1px solid #ccc');
if(data==null){
$(colorId).val('Product Color Not Available').attr("readonly","readonly");
$(colorHiddenClass).removeClass("has");
$(colorHiddenClass).val('0').attr("data-val",'0');
data = [];
}else{
$(colorId).val('').removeAttr("readonly");
$(colorHiddenClass).addClass("has");
}
$(colorId).autocomplete({
source: data,
minLength: 0,
select: function( event, ui ) {
$(colorHiddenClass).val(ui.item.id).attr("data-val",ui.item.label);
$(colorId).css('border','3px solid #'+ui.item.label);

var b  = scaleId;

console.log(b);
var colorID = ui.item.id;
var pID = pid;
var storeID = storeId;
$.ajax({
url: 'ajax_call.php?page=md5hashcolor',
type: 'post',
data: {colorID: colorID,scaleIdw: b,pID: pID,storeID: storeID,pActualPrice1: a}
}).done(function(res) {
resultObj = eval(res);
var tTL = resultObj[0];
var pLocation1 = resultObj[1];
var pExpiry1 = resultObj[2];
var minStock1 = resultObj[3];
$(pPrice).val(tTL);
$(pLocation).val(pLocation1);
$(pExpiry).val(pExpiry1);
$(minStock).val(minStock1);
});


}



}).on('focus : click', function(event) {
$(this).autocomplete("search", "");
}).data("ui-autocomplete")._renderItem = function (ul, item) {
return $("<li></li>")
.data("item.autocomplete", item)
.css({"margin":"1px 0",
"height": "23px",
"padding":"0"})
.append("<div style='background:#FFF';color:#333;height:100%;'>"+item.label+"</div>")
.appendTo(ul);
};
};
<?php


// $temp = 'false';
//  if($functions->developer_setting('product_Scale')=='1'){
$temp = 'true';
// }
echo "var hasScale = '$temp';";
// $temp = 'false';
//  if($functions->developer_setting('product_color')=='1'){
// $temp = 'true';
// }
echo "var hasColor = '$temp';";
?>
$(function() {
productId="#receipt_product_id";
productHiddenClass = ".receipt_product_id";
productHiddenpcode = ".receipt_product_pcode";
productHiddenstatus = ".receipt_product_pstatus";



pPrice = "#receipt_price";



pLocation = "#pLocation";
pExpiry = "#pExpiry";
minStock = "#minStock";

// $(pPrice).val("ui.item.pstatus");



var availableTags = <?php $functions->productJSON(); ?>;
$(productId).autocomplete({
source: availableTags,
minLength: 0,
select: function( event, ui ) {
$(productHiddenClass).val(ui.item.id);
$(productHiddenClass).attr("data-val",ui.item.id);                
$(productHiddenpcode).attr("data-val",ui.item.pcode);
$(productHiddenpcode).val(ui.item.pcode);
$(pPrice).val(ui.item.pPriceS);

$(pLocation).val(ui.item.pLocation);
$(pExpiry).val(ui.item.pExpiry);
$(minStock).val(ui.item.minStock);

$(productHiddenstatus).attr("data-val",ui.item.pstatus);
$(productHiddenstatus).val(ui.item.pstatus);
if(hasScale == 'true'){
console.log('scalesssssssssssssssssssssssssssss');


console.log(ui.item.scale);
var scaleSelectId =    scale(ui.item.scale,ui.item.id,ui.item.storeID,ui.item.pPriceS);


console.log(scaleSelectId);
console.log("scaleSelectId");


}



if(hasColor == 'true') {
// console.log('color');


color(ui.item.color,ui.item.id,ui.item.storeID,"",scaleSelectId);
}
},
response: function (event, ui) {
if (!ui.content.length) {
$(".showNEW").text("No results found!. You are adding a new product...");               
}
else {
$(".showNEW").empty();
}
},
minLength: 3


        }).on('focus : click', function(event) {
                $(this).autocomplete("search", "");
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var inner_html = '<div class="list_item_container"><div class="image"><img src="' + item.avatar + '"></div><div class="description">' + item.label + '</div></div>';
            return $("<li></li>")
                    .data("ui-autocomplete-item", item)
                    .append(inner_html)
                    .appendTo(ul);
        };


       

    });





</script>

<?php include_once('dashboardfooter.php'); ?>

<script type="text/javascript">
$("#pExpiry").datepicker({ dateFormat: 'd-M-yy',

changeMonth: true,
changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});
</script>
<script type="text/javascript">
$("#purchaseReceiptDATE").datepicker({ dateFormat: 'd-M-yy',

changeMonth: true,
changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});
</script><style type="text/css">


    

.ui-autocomplete .list_item_container {
height: 90px;
padding: 0px;
color: #000;
    }
    .ui-autocomplete img {
width:90px;
height: 90px;
float: left;
    }
    .ui-autocomplete .description {
/*font-style: italic;*/
font-size: 1.1em;
color: #000;
padding: 5px;
margin: 5px;
padding-top: 20px;
    }

#name-list
{
    width: 300px;


    }.expand {
    height: 1em;
    width: 50%;
    padding: 3px;
}
</style>