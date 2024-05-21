 <?php 
 
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once("global.php");

global $dbF,$webClass;

global $productClass;

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Stock Request',false);
}



$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg  = "";
$chk  = $functions->addMakeOrder();
 // echo "<pre>";
 // print_r($_POST);
 // echo "</pre>";

    $orderStartWith = $functions->orderStartWith();



if($chk){

 $msg = "Stock Request Complete";
}
// include_once('header.php'); 

include'dashboardheader.php';
 // $user = $_SESSION['currentUser'];

  // if ($_SESSION['currentUserType'] !='Employee') {
  //                     $u_id = $_SESSION['currentUser'];
  //                 }else
  //                 {
  //                     $u_id = $_SESSION['webUser']['id'];
  //                 }

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


              <div id="tabs">
                        <ul>
                         
                            <li><a active href="#tabs-1">My Stock Request</a></li>
 



                            <li><a href="#tabs-2">Stock Request Form</a></li>
                           
 
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
    <th>PRODUCT</th>
    <th>REFRENCE ID</th>
    <th>REQUEST FROM</th>
    <th>DATE</th>
    <th>NOTE </th>
    <th>COMMENTS </th>



    <?php  if($_SESSION['currentUserType'] == 'Employee' && (@$_SESSION['superUser']['manage_stock'] == '0' || @$_SESSION['superUser']['manage_stock'] == '')){ }else{?>

    <th>ACTION </th>

<?php } ?>

   

  

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





$sqls = "SELECT * FROM `stockOrder`";


// if ($_SESSION['currentUserType'] == 'Employee') {
// $user = $_SESSION['superid'];
// $sqls  .= " where submitBy = '$user'";
// } else {
// $user =$_SESSION['currentUser'];
$sqls  .= " where submitBy = '$userId' or  userId = '$user'";
// }

$sqls  .= " ORDER BY `stockOrder`.`id` DESC";

$variable=$dbF->getRows($sqls);
$i =1;$temp = "";
        foreach ($variable as $key => $value): 


            ?>
   

        
    <tr>

<td>
<?php echo $i ?>

</td>

<td>
<?php 


$sqlsX = "SELECT * FROM `stockOrderDetail` where fKey = ?";

$variableX=$dbF->getRows($sqlsX,array($value['id']));

$a = 1;
foreach ($variableX as $keyX => $valueX) {

$temp = "";

// $sqlsX1 = "SELECT location FROM `product_inventory_detail` where qty_product_id = ?";

// $variableX1=$dbF->getRows($sqlsX1,array($valueX['receipt_product_id']));

// $temp = "";

// foreach ($variableX1 as $keyX1 => $valueX1) {
//     // $temp = "";
// $temp .= $valueX1['location'].",";

// }


// $temp = trim($temp,",");



// $temp .= ")";


 // echo   "<pre> ".$a.") ".$pName          = $productClass->getProductFullNameWeb( $valueX['pid'], $valueX['sid'], $valueX['cis'] ) ." (".$valueX['qty'].") (".$valueX['surgerie'].")</pre>";



 echo   $a.") ".$pName          = $productClass->getProductFullNameWeb( $valueX['pid'], $valueX['sid'], $valueX['cis'] ) ."<br>(Deduct Quantity: ".$valueX['qty'].")<br>(Surgery: ".$valueX['surgerie'].")<hr>";





$a++;

}



 ?>

</td>

<td>
<?php echo $value['oid']; ?>

</td>

 <td>
<?php echo $functions->UserName($value['submitby']); ?>

</td>  
<td>

<?php echo $value['orderdate']; ?>
</td>






<td>

<?php echo $value['note']; ?>
</td>


<td>

<?php 

if($value['comm']){

    echo $value['comm'];
}else{
?>

<!-- <td> -->

 

<textarea name="cOMMENTS<?php echo $value['id']; ?>" id="message<?php echo $value['id']; ?>" style="height: 3em;
    width: 100%;
    padding: 3px
;"  rows="1" cols="10"><?php echo $value['comm']; ?></textarea>


<!-- </td> -->


<?php
}


 ?>



</td>








    <?php  if($_SESSION['currentUserType'] == 'Employee' && (@$_SESSION['superUser']['manage_stock'] == '0' || @$_SESSION['superUser']['manage_stock'] == '')){ }else{?>

 
<td>





<div class="col-10 col-sm-10">
<select name="sTATUS" id="<?php echo $value['status']; ?>" onchange="quick_invoice_update('<?php echo $value['id']; ?>',this);">
<option value="">Select Status :</option>
<option <?php if($value['status'] == '1'){echo "selected";}else{} ?> value="1">Accept</option>
<option  <?php if($value['status'] == '0'){echo "selected";}else{} ?> value="0">Reject</option>
</select>
</div>

<!-- <label class='ccheckbox'>
<input type='checkbox' value='0' name='superUser[cdashboard]'>

<textarea></textarea>


<span class='cmark'></span>

</label> -->



</td>

<?php } ?>





    </tr>
<?php
$i++;

 endforeach ?>
</tbody>



    </table>
    </div> 
    </div> 

     
</div>









                           
<div id="tabs-2"class="inner_forms">
<form class="profile" method="post" action="stockOrder">
<?php echo $functions->setFormToken('addMakeOrder',false); ?>
<div class="inner_forms">


<!-- 
<div class="form-group col-12 col-sm-6">
<label>Order Number :</label> -->
<input type="hidden" readonly="" name="orderPK" value="<?php echo $orderStartWith ?>">
<!-- </div> -->



<div class="form-group-flex">
    <div class="form-group mb-0">

<!-- <input type="text" name="receipt_receiver" value=""> -->

<?php  $functions->receiverDroupdownOptionsID(); ?>
<!--<label for="subject" class="label2">Stock Request From :</label>-->
</div>
    </div>



<div class="form-group-flex">
<div class="form-group-date">
<label for="date" class="label3">Select Date :</label>
<input  class="form-control"id="datepicker" type="text" autocomplete="off" name="order_date" id="expiryDate">
</div>
</div>






<div class="form-group-flex">
<div class="form-group-date">

<label for="tags" class="label3">Note :</label>
<input type="text" id="tags"class="form-control" name="order_note" value="">
</div>
</div>
</div>


    <div class="cpd-table">
               <div class="cpd-tbl tableStock">
              <table id="selected" class="table sTable table-hover">
                <thead>
                    <tr>
                        <th>Name of product</th>
                        <th class="allowProductScale">Product size</th>
                        <th class="allowProductColor">Product color</th>
                        <th>Quantity</th>



             <th>Select Surgery</th>
                       
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
                            <input type="text" class="form-control" id="receipt_product_scale" placeholder="Enter Product Size" readonly value="No Size Avaiable">
                            <input type="hidden" class="form-control receipt_product_scale" data-val="">
                    </td>
                    <td class="allowProductColor">
                            <input type="text" class="form-control" required id="receipt_product_color" placeholder="Enter Product Color" readonly value="No Color Avaiable">
                            <input type="hidden" class="form-control receipt_product_color" data-val="">
                    </td>
                    <td>
                           <input type="number" class="form-control" id="receipt_qty" placeholder="Enter Product Quantity">
                    </td>


                    <td>
                              <?php 
// @$temp      = $data['surgeries'];

// if (empty($temp)) {
$temp = "";
// }

                              echo $allsurgeries = "<select name='surgeries' id='allsurgeries'>

    <option selected disabled value=''>Select Surgeries</option>
    " . $alls = $functions->allsurgeries($_SESSION['currentUser'], $temp) . "
    </select>"; ?>    
</br>
 
<button type="button" onclick="receiptFormValid();" id="AddProduct" class="btn btn-primary" style="
    float: right;
">Add</button>
 



                    </td>
                  
            </tbody>




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
    <th>Surgery</th>
<!--     <th>PRICE</th>
    <th>SKU_NUMBER</th> -->

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

<?php  if($_SESSION['currentUserType'] == 'Employee' && (@$_SESSION['superUser']['manage_stock'] == '0' || @$_SESSION['superUser']['manage_stock'] == '')){ }else{?>

<div class="btn_new">
<label>Deduct Stock :</label>
<label for="inputPassword3" class="switch">
<input type="checkbox"  id="inputPassword3" name="receipt_publish" value="1" checked>
<span class="slider">Yes No</span>
</label>

</div>

<?php } ?>
   <div class="col-12">
  <input type="submit" class="submit_class" value="Submit" name="submit"></div>
</form> 
</div>

                           









     
</div>             
                



        </div>
        </div>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
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
            // $('.submit_class').attr('disabled',true); 
        // return false;
    }else{
 $('#msg').text('');
       // $('.submit_class').attr('disabled',false); 
    }


});






}



    function receiptFormValid(){
    var  codeduplicate = $("#pcodedupicate").val()
    if( $("#receipt_date").val() == "" ||  $(".receipt_product_id").val() == "" /*
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

    // price =parseFloat($("#receipt_price").val());
    // if(price > 0){
    //     $("#receipt_price").val(price)
    // }else{
    //     alert("Product Price Is Not Correct");
    //     return false;
    // }
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


  var selectedCountry = $("#allsurgeries option:selected").val();


console.log(selectedCountry);

    var pName = $("#receipt_product_id").val() + scaleVal +colorVal;
    //    var vendor =$("#receipt_vendor").val();
    var date    =   $("#receipt_date").val();
    // var price   =   parseFloat($("#receipt_price").val());
    var price   =   0;
    var qty     =   parseInt($("#receipt_qty").val());
    var store   =   parseInt($("#r_store").val());
    var store   =   0;
    //   var storeName = $("#receipt_store_id option:selected").text();

    var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;
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
            "<td>Surgeries "+selectedCountry + "<input type='hidden' name='allsurgeries_"+trpid+"' value='Surgeries "+selectedCountry+"' /></td><p id='message1'></p>"+
            //  "<td>"+storeName+"<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
            "</tr>";
               




p_status = 1;

var pstatus = $(".receipt_product_pstatus").val();
var pcode = $(".receipt_product_pcode").val();
 // alert(pstatus);
// if ( pstatus == "0" ) {
//    for (i = 0; i < 1; i++) {
//   text +="This is a per product    <input type='hidden' name='pcode_"+trpid+"_pd[]' placeholder='SKU_NUMBER' style='display: inline-block;width: 50%;' value='"+pcode+"' /> ";
//    text +="<input type='text' class='form-control' style='display: inline-block;width: 50%;' placeholder='Location' name='location_"+trpid+"_pd[]' value='' /><br>";



//   }
// }

// else if ( pstatus == "1" ) {

//     for (i = 0; i < qty; i++) {
//   text +="<input type='text' class='form-control skuTxt' style='display: inline-block;width: 50%;' placeholder='SKU_NUMBER' name='pcode_"+trpid+"_pd[]' value='' />";
//   text +="<input type='text' class='form-control' style='display: inline-block;width: 50%;' placeholder='Location' name='location_"+trpid+"_pd[]' value='' /><br>";
  

//   }
// } 

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
            // alert('SKU_NUMBER already exist');
 $('#msg').text('SKU_NUMBER already exist');
 // $('.submit_class').attr('disabled',true); 

  


         }else{

 $('#msg').text('');
 // $('.submit_class').attr('disabled',false);  

         }
     });



}




        console.log($(this).val());

  
   notBlank();

});



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
    $("#receipt_qty,#receipt_product_id, #receipt_store_id,#receipt_store_id2,#receipt_eqty,#receipt_nqty,#receipt_econd,#receipt_ncond").val("");
    // color(null);
    // scale(null);
}
 function scale(data){
        scaleId = "#receipt_product_scale";
        scaleHiddenClass= ".receipt_product_scale";
        if(data==null){
            $(scaleId).val('Product Size Not Available').attr("readonly","readonly");
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



        // pPrice = "#receipt_price";

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
                 // $(pPrice).val(ui.item.pPriceS);
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

 //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }

function quick_invoice_update(orderid,ths){
    if(secure_delete("Do you want to update?")){
        selected_id = $(ths).val();
        selected_val = $("option:selected",ths).text();
        pre_status = $(ths).attr('id');
      var message = $('textarea#message'+orderid+'').val();

        $.ajax({
            type: 'POST',
              url: 'ajax_call.php?page=updateStockDedeuct',
            data: { orderid:orderid,invoice:selected_id,prev_status:pre_status,message:message }
        }).done(function(data)
        {


            alert('Done...');
            // if(data=='1'){
            //     $(ths).closest(".invoice_quick_select_div").hide(200);
            //     $(ths).closest("td").find(".invoice_status").html(selected_val);
            // }
            // else if(data=='0'){
            //     jAlertifyAlert('<?php //echo _js($_e['Update Fail Please Try Again.']); ?>');
            // }
            // else{
            //     jAlertifyAlert(data);
            // }

        });
    }
}


// $('.switch').on('change', function() {
//     if ($(this).find('input').is(':checked')) {
//           $('.sub-form').slideDown(600);
//           $('.form-group ').slideDown(600);
       
//     } else {
//         $('.sub-form').slideUp(600);
//         $('.form-group ').slideUp(600);
    
//     }
// });


</script>

<?php include_once('dashboardfooter.php'); ?>
<script type="text/javascript">
$("#expiryDate").datepicker({ dateFormat: 'd-M-yy',

 changeMonth: true,
 changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
});



$('textarea').focus(function () {
    $(this).animate({ height: "5em" }, 500);
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