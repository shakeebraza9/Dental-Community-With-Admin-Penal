<?php 
include_once("global.php");

global $dbF,$webClass;

global $productClass;
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Inventory Adjustment Note',false);
}

$login       =  $webClass->userLoginCheck();
if(!$login){
header('Location: login');
}
$msg  = "";
$chk  = $functions->inventoryadjustmentnote();
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";




$ian = $functions->IAN();
$rid = $functions->RID();

if($chk){
$msg = $chk;
}
include_once('header.php'); 

include'dashboardheader.php';
$user = $_SESSION['currentUser'];

if ($_SESSION['currentUserType'] !='Employee') {
$u_id = $_SESSION['currentUser'];
}else
{
$u_id = $_SESSION['webUser']['id'];
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


<h4>Stock Management</h4>
</div>
<!-- right_side_top close -->
<?php if($msg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $msg; ?>
</div>
<?php } ?>


<div id="tabs">
<ul>

<li><a active href="#tabs-1">View Entries</a></li>
<li><a href="#tabs-2">Add Inventory Adjustment Note</a></li>

</ul>   
<div id="tabs-1">


<div class="cpd-table">
<div class="cpd-tbl">
<table id="selected" class="table sTable table-hover">
<thead>

<tr><th>SNO</th>
<th>Product (Existing qty)(Existing condition)(New qty)(New condition)</th>

<th>IAN</th>
<th>Reason</th>
<th>Inspected By</th>
<th>Date</th>
<th>Description</th>
<th>Note</th>
</tr>
</thead>
<tbody>


<?php 
$userId =  $_SESSION['webUser']['id'];

$sqls = "SELECT * FROM `purchase_receipt_ian`";


if ($_SESSION['currentUserType'] == 'Employee') {
$user = $_SESSION['superid'];
$sqls  .= " where submitBy = '$user'";
} else {
$user = $_SESSION['currentUser'];
$sqls  .= " where submitBy = '$user'";
}



$variable=$dbF->getRows($sqls,array($userId));
$i =1;$temp = "";
foreach ($variable as $key => $value): 


?>



<tr>

<td>
<?php echo $i ?>

</td>

<td>
<?php 


$sqlsX = "SELECT * FROM `purchase_receipt_pro_ian` where receipt_id = ?";

$variableX=$dbF->getRows($sqlsX,array($value['receipt_pk']));

$a = 1;
foreach ($variableX as $keyX => $valueX) {



// $temp .= ")";


echo   "<pre> ".$a.") ".$pName          = $productClass->getProductFullNameWeb( $valueX['receipt_product_id'], $valueX['scaleId'], $valueX['colorId'] ) ." (".$valueX['receipt_product_eqty'].")(".$valueX['receipt_product_ec'].")(".$valueX['receipt_product_nqty'].")(".$valueX['receipt_product_nc'].")</pre>";





$a++;

}



?>

</td>

<th><?php echo $value['ian'] ?></th>
<th><?php echo $value['reason'] ?></th>
<th><?php echo $value['inspected_by'] ?></th>
<th><?php echo $value['receipt_date'] ?></th>
<th><?php echo $value['description'] ?></th>
<th><?php echo $value['note'] ?></th>
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
<form class="profile" method="post" action="inventoryadjustmentnote" enctype="multipart/form-data">
<?php echo $functions->setFormToken('purchaseReceiptAdd',false); ?>






<div class="row">



<div class="form-group col-12 col-sm-6">
<label>IAN :</label>
<input type="text" readonly="" value="<?php echo $ian ?>">
</div>


<div class="form-group col-12 col-sm-6">
<label>Reason :</label>
<input type="text" name="receipt_reason" value="">
</div>


<div class="form-group col-12 col-sm-6">
<label>Inspected By :</label>
<!-- <input type="text" name="receipt_inspectedby" value=""> -->


<?php  $functions->receiverDroupdownOptions(); ?>



</div>





<div class="form-group col-12 col-sm-6">
<label>Date :</label>
<input type="date" name="receipt_date" value="">
</div>


<div class="form-group col-12 col-sm-6">
<label>Description :</label>
<input type="text" name="receipt_description" value="">




</div>




<div class="form-group col-12 col-sm-6">
<label>Note :</label>
<input type="text" name="receipt_note" value="">

<input type="hidden" name="receipt_publish" value="publish">


</div>






<div class="cpd-table">
<div class="cpd-tbl">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th>PRODUCT</th>
<!-- <th>WAREHOUSE</th> -->
<th class="allowProductScale">PRODUCT SCALE</th>
<th class="allowProductColor">PRODUCT COLOR</th>
<th>EXISTING QTY</th>
<th>NEW QTY</th>
<th>EXISTING CONDITION</th>
<th>NEW CONDITION</th>
</tr>
</thead>
<tbody>
<td>
<input type="text" class="form-control" id="receipt_product_id" placeholder="Enter Product Name">
         <input type="hidden" class="form-control receipt_product_id" data-val="">
                            <input type="hidden" class="form-control receipt_product_pcode" data-val="">
                            <input type="hidden" class="form-control receipt_product_pstatus" data-val="">
</td>


<td class="allowProductScale">
<input type="text" class="form-control" id="receipt_product_scale" placeholder="Enter Product Scale" readonly value="No Scale Avaiable">
<input type="hidden" class="form-control receipt_product_scale" data-val="">
</td>
<td class="allowProductColor">
<input type="text" class="form-control" required id="receipt_product_color" placeholder="Enter Product Color" readonly value="No Color Avaiable">
<input type="hidden" class="form-control receipt_product_color" data-val="">
</td>



<td>
<input type="number" class="form-control" id="receipt_eqty" placeholder="Enter Existing Quantity" min="0">
</td>
<td>
<input type="number" class="form-control" id="receipt_nqty" placeholder="Enter New Quantity" min="0">
</td>
<td>
<input type="text" class="form-control" id="receipt_econd" placeholder="Enter Existing Condition">
</td>
<td>
<input type="text" class="form-control" placeholder="Enter New Condition" id="receipt_ncond">


</td>





</tbody>
</table>
</div>
</div>















<div class="form-group">
<div class="col-sm-10">
<button type="button" onclick="receiptFormValid4();" id="AddProduct" class="btn btn-primary">Add Product</button>
</div>
</div>



<div class="cpd-table">
<div class="cpd-tbl">
<table id="selected" class="table sTable table-hover">
<thead>
<tr>
<th>SNO</th>
<th>PRODUCT</th>
<!-- <th>WAREHOUSE</th> -->
<th>EXISTING QTY</th>
<th>NEW QTY</th>
<th>EXISTING CONDITION</th>
<th>NEW CONDITION</th>






</tr>
</thead>
<tbody id="vendorProdcutList">







</tbody>



</table>
</div> 
</div> 




</div> <!-- add product script div end -->

<p id="msg" style="
/*color: rebeccapurple;*/
color: red;
"></p>

<input type="submit" class="submit_class" value="Generate Inventory Adjustment Note" name="submit">
</form> 
</div>







</div>             




</div>
</div>
</div>
<!-- right_side close -->
</div>
<!-- left_right_side -->
<script type="text/javascript">


function notBlank(){






$(".skuTxt").each(function(index){
// var  codeduplicate = $(".skuTxt").val()

console.log($( this ).text());
console.log($( this ).val());


if( $( this ).val() == ""){
// alert("SKU_NUMBER Fields Are Empty");
$('#msg').text('SKU_NUMBER Fields Are Empty');
$('.submit_class').attr('disabled',true); 
// return false;
}else{
$('#msg').text('');
$('.submit_class').attr('disabled',false); 
}


});






}

function receiptFormValid4(){
if( $("#receipt_date").val() == "" ||  $("#receipt_product_id").val() == "" || $("#receipt_nqty").val() == "" || $("#receipt_ncond").val() == ""
){
alert('Required Fields Are Empty');
return false;
}

addListItem4();

}



var sr=0;
function addListItem4() {
//disable one time required fields
// $(".receipt_store_id").val($("#receipt_store_id").val());
$(".receipt_reason").val($("#receipt_reason").val());
$(".receipt_ian").val($("#receipt_ian").val());
$(".receipt_inspectedby").val($("#receipt_inspectedby").val());
//$("#reason").attr("disabled","disabled");
//$("#inspectedby").attr("disabled","disabled");
//$("#receipt_date,#receipt_ian,#receipt_description,#receipt_note").attr("readonly","readonly");
//disable end


var pid     = parseInt($(".receipt_product_id").val());
 var pScaleId = parseInt($(".receipt_product_scale").val());
    var pColorId = parseInt($(".receipt_product_color").val());




if(isNaN(pid)){




var customProAddedName     = $("#receipt_product_id").val(); 
console.log("custom Product is added in process");

$.ajax({
url: 'ajax_call.php?page=customProAdded',
type: 'post',
data: {
customProAddedName: customProAddedName
}
}).done(function(res) {
console.log(res);

var pid = res;









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
var eqty     =   parseInt($("#receipt_eqty").val());
var nqty     =   parseInt($("#receipt_nqty").val());
var econd     =   $("#receipt_econd").val();
var ncond     =   $("#receipt_ncond").val();
// var store   =   parseInt($("#receipt_store_id option:selected").val());
// var storeName = $("#receipt_store_id option:selected").text();


var store   =   0;
var storeName = 'nill';

 var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;
if (document.getElementById("tr_"+trpid)) {

alert('Duplicate Entry : Product Item already exist in list!');

document.getElementById(trpid).checked = true;
checkchange(trpid);
}
// else if(storeName == "Select Store" || storeName == ""){
//     alert("<?php echo _js('Please Select Store'); ?>");
// }
else if(pName == ""){
alert("<?php echo _js('Please Select Product'); ?>");
}
else if (pid > 0 ) {
sr++;

var item = "<tr id='tr_"+trpid+ "'>"+
"<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
"<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
"<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
// "<td>"+storeName + "<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
"<td>"+eqty + "<input type='hidden' name='peqty_"+trpid+"' value='"+eqty+"' /></td>"+ "<input type='hidden' name='pscale_"+trpid+"' value='"+pScaleId+"' />" +
            "<input type='hidden' name='pcolor_"+trpid+"' value='"+pColorId+"' /></td>"+
"<td>"+nqty + "<input type='hidden' name='pnqty_"+trpid+"' value='"+nqty+"' /></td>"+
"<td>"+econd + "<input type='hidden' name='pecond_"+trpid+"' value='"+econd+"' /></td>"+
"<td>"+ncond + "<input type='hidden' name='pncond_"+trpid+"' value='"+ncond+"' /></td>"+
"</tr>";

$("#vendorProdcutList").append(item);
blankField();
}




});


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
var eqty     =   parseInt($("#receipt_eqty").val());
var nqty     =   parseInt($("#receipt_nqty").val());
var econd     =   $("#receipt_econd").val();
var ncond     =   $("#receipt_ncond").val();
// var store   =   parseInt($("#receipt_store_id option:selected").val());
// var storeName = $("#receipt_store_id option:selected").text();


var store   =   0;
var storeName = 'nill';

 var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;
if (document.getElementById("tr_"+trpid)) {

alert('Duplicate Entry : Product Item already exist in list!');

document.getElementById(trpid).checked = true;
checkchange(trpid);
}
// else if(storeName == "Select Store" || storeName == ""){
//     alert("<?php echo _js('Please Select Store'); ?>");
// }
else if(pName == ""){
alert("<?php echo _js('Please Select Product'); ?>");
}
else if (pid > 0 ) {
sr++;

var item = "<tr id='tr_"+trpid+ "'>"+
"<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
"<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
"<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
// "<td>"+storeName + "<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
"<td>"+eqty + "<input type='hidden' name='peqty_"+trpid+"' value='"+eqty+"' /></td>"+ "<input type='hidden' name='pscale_"+trpid+"' value='"+pScaleId+"' />" +
            "<input type='hidden' name='pcolor_"+trpid+"' value='"+pColorId+"' /></td>"+
"<td>"+nqty + "<input type='hidden' name='pnqty_"+trpid+"' value='"+nqty+"' /></td>"+
"<td>"+econd + "<input type='hidden' name='pecond_"+trpid+"' value='"+econd+"' /></td>"+
"<td>"+ncond + "<input type='hidden' name='pncond_"+trpid+"' value='"+ncond+"' /></td>"+
"</tr>";

$("#vendorProdcutList").append(item);
blankField();
}



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
function checkchange(pid) {
var tr = "tr_" + pid;
if ($('#' + pid).is(":checked")) {
$("#"+tr).addClass("highlitedtd");
}
else {
$("#"+tr).removeClass("highlitedtd");
}
}


function blankField(){
$("#receipt_qty,#receipt_price,#receipt_product_id,#receipt_eqty,#receipt_nqty,#receipt_econd,#receipt_ncond,.receipt_product_pstatus,.receipt_product_pcode,.receipt_product_id").val("");
// color(null);
// scale(null);
}


 function scale(data){
        scaleId = "#receipt_product_scale";
        scaleHiddenClass= ".receipt_product_scale";
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
            }
        }).on('focus : click', function(event) {
                $(this).autocomplete("search", "");
            });
    };



    function color(data){
        colorId = "#receipt_product_color";
        colorHiddenClass= ".receipt_product_color";
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

var availableTags = <?php $functions->productJSON(); ?>;
$(productId).autocomplete({
source: availableTags,
minLength: 0,
select: function( event, ui ) {
$(productHiddenClass).val(ui.item.id);
$(productHiddenClass).attr("data-val",ui.item.id);

$(productHiddenpcode).attr("data-val",ui.item.pcode);
$(productHiddenpcode).val(ui.item.pcode);
$(productHiddenstatus).attr("data-val",ui.item.pstatus);
$(productHiddenstatus).val(ui.item.pstatus);
if(hasScale == 'true'){
console.log('scalesssssssssssssssssssssssssssss');


console.log(ui.item.scale);
scale(ui.item.scale);
}
if(hasColor == 'true') {
console.log('color');
color(ui.item.color);
}
}
}).on('focus : click', function(event) {
$(this).autocomplete("search", "");
});
});








</script>

<?php include_once('footer.php'); ?>