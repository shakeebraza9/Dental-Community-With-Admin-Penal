<?php header('Content-type: application/x-javascript');

require_once(__DIR__.'/../../global.php');

    /**
     * MultiLanguage keys Use where echo;
     * define this class words and where this class will call
     * and define words of file where this class will called
     **/
    global $_e;
    global $adminPanelLanguage;
    $_w=array();
    $_w['Product Scale Not Available'] = '' ;
    $_w['Product Color Not Available'] = '' ;
    $_w['Required Fields Are Empty'] = '' ;
    $_w['Product Quantity Is Not Correct.'] = '' ;
    $_w['Product Price Is Not Correct.'] = '' ;
    $_w['Duplicate Entry : Product Item already exist in list!'] = '' ;
    $_w['Required Fields Are Emptydddddddd'] = '' ;
    $_w['Code Is Duplicate Please Ensert The Unique Code'] = '' ;

    $_e    =   $dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin StockScript');

if(1===2){
//Just for suggestion help <script> if not then page behave like txt page
?>
<script>
    <?php } ?>

 function scale(data){
        scaleId = "#receipt_product_scale";
        scaleHiddenClass= ".receipt_product_scale";
        if(data==null){
            $(scaleId).val("<?php echo _js($_e['Product Scale Not Available']); ?>").attr("readonly","readonly");
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
            $(colorId).val("<?php echo _js($_e['Product Color Not Available']); ?>").attr("readonly","readonly");
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
                .append("<div style='background:#"+item.label+";color:#FFF;height:100%;'>"+item.label+"</div>")
                .appendTo(ul);
        };
    };
   // $("#store").attr("disabled","disabled");



// function duplicateCheck(){  

  
//     if( $("#pcodedupicate").val(codeduplicate)){
//         jAlertifyAlert("<?php echo _js($_e['Code Is Duplicate Please Ensert The Unique Code']); ?>");
//         return false;
//     }



//  }
function receiptFormValid(){
    var  codeduplicate = $("#pcodedupicate").val()
    if( $("#receipt_date").val() == "" ||  $(".receipt_product_id").val() == "" ||/*
        $(".receipt_product_scale.has").val() == ""  || $(".receipt_product_color.has").val() == "" || */
        $("#receipt_store_id").val() == ""
        ){
        jAlertifyAlert("<?php echo _js($_e['Required Fields Are Empty']); ?>");
        return false;
    }
   


    qty =parseInt($("#receipt_qty").val());
    if(qty > 0){
        $("#receipt_qty").val(qty);
    }else{
        jAlertifyAlert("<?php echo _js($_e['Product Quantity Is Not Correct.']); ?>");
        return false;
    }

    price =parseFloat($("#receipt_price").val());
    if(price > 0){
        $("#receipt_price").val(price)
    }else{
        jAlertifyAlert("<?php echo _js($_e['Product Price Is Not Correct.']); ?>");
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
    //   var storeName = $("#receipt_store_id option:selected").text();

    var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;
    if (document.getElementById("tr_"+trpid)) {

        jAlertifyAlert("<?php echo _js($_e['Duplicate Entry : Product Item already exist in list!']); ?>");

        document.getElementById(trpid).checked = true;
        checkchange(trpid);
    }
    else if (qty > 0 && pid > 0 ) {
        sr++;
var text = '';
        var item = "<tr id='tr_"+trpid+ "'>"+
            "<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
            "<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
            //  "<td>"+date+"<input type='hidden' name='pdate_"+trpid+"' value='"+date+"' /></td>"+
            //  "<td>"+vendor+"<input type='hidden' name='pvendor_"+trpid+"' value='"+vendor+"' /></td>"+
            "<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
            "<input type='hidden' name='pscale_"+trpid+"' value='"+pScaleId+"' />" +
            "<input type='hidden' name='pcolor_"+trpid+"' value='"+pColorId+"' /></td>"+
            "<td>"+qty + "<input type='hidden' name='pqty_"+trpid+"' value='"+qty+"' /></td>"+
            "<td>"+price+"<input type='hidden' name='pprice_"+trpid+"' value='"+price+"' /></td><input type='hidden' id='pcodess' name='pcodess' value='"+pid+"' /><td></td><p id='message1'></p>"+
            //  "<td>"+storeName+"<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
            "</tr>";
               




p_status = 1;

var pstatus = $(".receipt_product_pstatus").val();
var pcode = $(".receipt_product_pcode").val();
 // alert(pstatus);
if ( pstatus == "0" ) {
   for (i = 0; i < 1; i++) {
  text +="This is a per product    <input type='hidden' name='pcode_"+trpid+"_pd[]' value='"+pcode+"' /> ";
 



  }
}

else if ( pstatus == "1" ) {

    for (i = 0; i < qty; i++) {
  text +="<input type='text' class='form-control' name='pcode_"+trpid+"_pd[]' value='' />";
  

  }
} 

        $("#vendorProdcutList").append(item);
        $("#vendorProdcutList tr:last-child td:last-child").append(text);
        blankField();

    




    }
}



//Create array of input values
// var values = $('input[name="skunumber[]"]').map(function() {
//   return this.value;
// }).toArray();

$( document ).on( "change", "input[name*='skunumber']", function() {

var allValueArray = $('input[name="skunumber[]"]').map(function() {
if ($(this).val() != '')

return $(this).val()
}).get();

//Create array of duplicates if there are any
var duplicateValueArray = allValueArray.filter(function(element, pos) {
if(allValueArray.indexOf(element) != pos){
    //console.log(element);
   
     alert(element+ " ''Are Duplicate plsease Check ");

return true;
}
else{
return false;
}

});

//check length of duplicate array, if any duplicate element found it is stored in duplicateValueArray after filter out.
if (duplicateValueArray.length != 0){
   
   
  //alert("are duplicate");

return false;

}
else{
    
  // alert("are not duplicate");


return true;
}


});





// $( document ).on( "keyup", "input[name*='skunumber']", function() {
//      console.log($(this).val());
//      var value = $(this).val();
    
//     if (value.indexOf(value) == -1)
//        {
//          avalue.push(value);
        
//        }
//     else
//         {
//             $(this).addClass("duplicate"); 
    
//     }

// });




function blankField(){
    $("#receipt_qty,#receipt_price,#receipt_product_id, #receipt_store_id,#receipt_store_id2,#receipt_eqty,#receipt_nqty,#receipt_econd,#receipt_ncond").val("");
    // color(null);
    // scale(null);
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

function removechecked() {
    $('.highlitedtd').remove();
}


function uncheckall() {
    if($("#vendorProdcutList tr").hasClass('highlitedtd')){
        $( ".checkboxclass" ).prop( "checked",false )
        $("#vendorProdcutList tr").removeClass("highlitedtd");
    }else{
        $( ".checkboxclass" ).prop( "checked",true )
        $("#vendorProdcutList tr").addClass("highlitedtd");
    }
}

function formSubmit(){
    if ( $('#vendorProdcutList tr').length > 0 ) {
        return true;
    }else{
        jAlertifyAlert("Please Add Products");
        return false;
    }
}
function formSubmitDuplicate(){
    if ( $('#vendorProdcutListduplicate').length > 0 ) {
        return true;
    }else{
        jAlertifyAlert("Please Add Products");
        return false;
    }
}

$("#r_store").on('change', function() {
    val = this.value;
    $("#receipt_store_id").val(val).change();
});

// GTN
function receiptFormValid2(){
    if( $("#receipt_date").val() == "" ||  $(".receipt_product_id").val() == "" ||/*
        $(".receipt_product_scale.has").val() == ""  || $(".receipt_product_color.has").val() == "" || */
        $("#receipt_store_id1").val() == "" || $("#receipt_store_id2").val() == ""
        ){
        jAlertifyAlert("<?php echo _js($_e['Required Fields Are Empty']); ?>");
        return false;
    }

    qty =parseInt($("#receipt_qty").val());
    if(qty > 0){
        $("#receipt_qty").val(qty);
    }else{
        jAlertifyAlert("<?php echo _js($_e['Product Quantity Is Not Correct.']); ?>");
        return false;
    }

    addListItem2();

}
function addListItem2() {
    //disable one time required fields
    $(".receipt_store_id1").val($("#receipt_store_id1").val());
    $(".receipt_store_id2").val($("#receipt_store_id2").val());
    $(".receipt_receiver").val($("#receipt_receiver").val());
    $(".receipt_sender").val($("#receipt_sender").val());
    $(".receipt_gtn").val($("#receipt_gtn").val());
    $(".receipt_delivery").val($("#receipt_delivery").val());
    //$("#delivery").attr("disabled","disabled");
    //$("#sender").attr("disabled","disabled");
    //$("#receiver").attr("disabled","disabled");
    //$("#receipt_date,#receipt_grn,#receipt_prf,#receipt_ponumber,#receipt_note").attr("readonly","readonly");
    //disable end


    var pid     = parseInt($(".receipt_product_id").val());

    var pName = $("#receipt_product_id").val() /*+ scaleVal +colorVal*/;
    //    var vendor =$("#receipt_vendor").val();
    var date    =   $("#receipt_date").val();
    var price   =   parseFloat($("#receipt_price").val());
    var qty     =   parseInt($("#receipt_qty").val());
    var store1   =   parseInt($("#receipt_store_id1 option:selected").val());
    var storeName1 = $("#receipt_store_id1 option:selected").text();
    var store2   =   parseInt($("#receipt_store_id2 option:selected").val());
    var storeName2 = $("#receipt_store_id2 option:selected").text();
    var regExp = /\(([^)]+)\)/;
    var oqty = regExp.exec(storeName1);
    var total = null;
    var trigerList = $("input[name^='pqty_p_"+pid+"-"+"-"+store1+"']").each(function(i,e) { 
        total += parseInt(this.value);      
    });
    cqty = total+qty;
    var trpid = "p_"+pid+"-"/*+pScaleId+"-"+pColorId*/+"-"+store1+store2;
    if (document.getElementById("tr_"+trpid)) {

        jAlertifyAlert("<?php echo _js($_e['Duplicate Entry : Product Item already exist in list!']); ?>");

        document.getElementById(trpid).checked = true;
        checkchange(trpid);
    }
    else if(storeName1 == "Select Store" || storeName1 == ""){
        jAlertifyAlert("<?php echo _js('Please Select Store'); ?>");
    }
    else if(storeName2 == "Select Store" || storeName2 == ""){
        jAlertifyAlert("<?php echo _js('Please Select Store'); ?>");
    }
    else if(pName == ""){
        jAlertifyAlert("<?php echo _js('Please Select Product'); ?>");
    }
    else if(oqty[1] < cqty){
        jAlertifyAlert("<?php echo _js('Quantity is higher than available'); ?>");
    }
    else if (qty > 0 && pid > 0 ) {
        sr++;

        var item = "<tr id='tr_"+trpid+ "'>"+
            "<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
            "<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
            "<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
            "<td>"+storeName1 + "<input type='hidden' name='pstore1_"+trpid+"' value='"+store1+"' /></td>"+
            "<td>"+storeName2 + "<input type='hidden' name='pstore2_"+trpid+"' value='"+store2+"' /></td>"+
            "<td>"+qty + "<input type='hidden' name='pqty_"+trpid+"' value='"+qty+"' /></td>"+
            "</tr>";

        $("#vendorProdcutList").append(item);
        blankField();
        $("#receipt_store_id1").prop("disabled","disabled");
    }

}

$("#receipt_store_id1").on('change', function() {
    $("#receipt_store_id2 option").removeAttr('disabled');
    val = this.value;
    $("#receipt_store_id2 option[value='"+val+"']").prop('disabled','disabled');
});

// GTN
// DN
function receiptFormValid3(){
    if( $("#receipt_date").val() == "" ||  $(".receipt_product_id").val() == "" || $("#receipt_store_id").val() == ""
        ){
        jAlertifyAlert("<?php echo _js($_e['Required Fields Are Empty']); ?>");
        return false;
    }

    qty =parseInt($("#receipt_qty").val());
    if(qty > 0){
        $("#receipt_qty").val(qty);
    }else{
        jAlertifyAlert("<?php echo _js($_e['Product Quantity Is Not Correct.']); ?>");
        return false;
    }

    addListItem3();

}
function addListItem3() {
    $(".receipt_type").val($("#type").val());
    $(".receipt_dn").val($("#receipt_dn").val());
    var chk1 = $("#receipt_cp1").val();
    var chk2 = $("#receipt_cp2").val();
    console.log(chk1,chk2);
    if(chk1==''){
        $("#receipt_cp1").remove();
        $(".make-switch").remove();
    }
    if(chk2==''){
        $("#receipt_cp2").remove();
        $(".make-switch").remove();
    }
    //disable one time required fields
    $(".receipt_store_id").val($("#receipt_store_id").val());
    $(".receipt_cp").val($("#receipt_cp select").val());
    $(".receipt_sender").val($("#receipt_sender").val());
    $(".receipt_deliveryby").val($("#receipt_deliveryby").val());
    //$("#receipt_deliveryby").attr("disabled","disabled");
    //$("#sender").attr("disabled","disabled");
    //$("#receipt_ddate,#receipt_dn,#receipt_acd,#prf,#receipt_cpr,#receipt_note,#receipt_cp select").attr("readonly","readonly");
    //disable end

    var pid     = parseInt($(".receipt_product_id").val());

    var pName = $("#receipt_product_id").val() /*+ scaleVal +colorVal*/;
    //    var vendor =$("#receipt_vendor").val();
    var date    =   $("#receipt_date").val();
    var price   =   parseFloat($("#receipt_price").val());
    var qty     =   parseInt($("#receipt_qty").val());
    var store   =   parseInt($("#receipt_store_id option:selected").val());
    var storeName = $("#receipt_store_id option:selected").text();
    var regExp = /\(([^)]+)\)/;
    var oqty = regExp.exec(storeName);
    var total = null;
    var trigerList = $("input[name^='pqty_p_"+pid+"-"+"-"+store+"']").each(function(i,e) { 
        total += parseInt(this.value);      
    });
    cqty = total+qty;
    var trpid = "p_"+pid+"-"/*+pScaleId+"-"+pColorId*/+"-"+store;
    if (document.getElementById("tr_"+trpid)) {

        jAlertifyAlert("<?php echo _js($_e['Duplicate Entry : Product Item already exist in list!']); ?>");

        document.getElementById(trpid).checked = true;
        checkchange(trpid);
    }
    else if(storeName == "Select Store" || storeName == ""){
        jAlertifyAlert("<?php echo _js('Please Select Store'); ?>");
    }
    else if(pName == ""){
        jAlertifyAlert("<?php echo _js('Please Select Product'); ?>");
    }
    else if(oqty[1] < cqty){
        jAlertifyAlert("<?php echo _js('Quantity is higher than available'); ?>");
    }
    else if (qty > 0 && pid > 0 ) {
        sr++;

        var item = "<tr id='tr_"+trpid+ "'>"+
            "<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
            "<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
            "<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
            "<td>"+storeName + "<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
            "<td>"+qty + "<input type='hidden' name='pqty_"+trpid+"' value='"+qty+"' /></td>"+
            "</tr>";

        $("#vendorProdcutList").append(item);
        blankField();
    }

}
$('.make-switch').on('change', function() {
        var chk = $('.checkboxHidden').val();
        if(chk=='1'){
         $('#receipt_cp2').hide(); 
         $('#receipt_cp1').show();  
        }
        else {
        $('#receipt_cp1').hide();  
        $('#receipt_cp2').show();   
         }
});
// DN
// IAN
function receiptFormValid4(){
    if( $("#receipt_date").val() == "" ||  $(".receipt_product_id").val() == "" || $("#receipt_store_id").val() == "" || $("#receipt_nqty").val() == "" || $("#receipt_ncond").val() == ""
        ){
        jAlertifyAlert("<?php echo _js($_e['Required Fields Are Empty']); ?>");
        return false;
    }

    addListItem4();

}
function addListItem4() {
    //disable one time required fields
    $(".receipt_store_id").val($("#receipt_store_id").val());
    $(".receipt_reason").val($("#receipt_reason").val());
    $(".receipt_ian").val($("#receipt_ian").val());
    $(".receipt_inspectedby").val($("#receipt_inspectedby").val());
    //$("#reason").attr("disabled","disabled");
    //$("#inspectedby").attr("disabled","disabled");
    //$("#receipt_date,#receipt_ian,#receipt_description,#receipt_note").attr("readonly","readonly");
    //disable end


    var pid     = parseInt($(".receipt_product_id").val());

    var pName = $("#receipt_product_id").val() /*+ scaleVal +colorVal*/;
    //    var vendor =$("#receipt_vendor").val();
    var date    =   $("#receipt_date").val();
    var price   =   parseFloat($("#receipt_price").val());
    var eqty     =   parseInt($("#receipt_eqty").val());
    var nqty     =   parseInt($("#receipt_nqty").val());
    var econd     =   $("#receipt_econd").val();
    var ncond     =   $("#receipt_ncond").val();
    var store   =   parseInt($("#receipt_store_id option:selected").val());
    var storeName = $("#receipt_store_id option:selected").text();

    var trpid = "p_"+pid+"-"/*+pScaleId+"-"+pColorId*/+"-"+store;
    if (document.getElementById("tr_"+trpid)) {

        jAlertifyAlert("<?php echo _js($_e['Duplicate Entry : Product Item already exist in list!']); ?>");

        document.getElementById(trpid).checked = true;
        checkchange(trpid);
    }
    else if(storeName == "Select Store" || storeName == ""){
        jAlertifyAlert("<?php echo _js('Please Select Store'); ?>");
    }
    else if(pName == ""){
        jAlertifyAlert("<?php echo _js('Please Select Product'); ?>");
    }
    else if (pid > 0 ) {
        sr++;

        var item = "<tr id='tr_"+trpid+ "'>"+
            "<td><input type='checkbox' id='"+trpid+ "' onchange='checkchange(this.id)' value='" + trpid + "' class='checkboxclass' />" +
            "<input type='hidden' name='cart_list[]' value='"+trpid+"' /><span>" + sr + "</span></td>"+
            "<td>"+pName+"<input type='hidden' name='pid_"+trpid+"' value='"+pid+"' />" +
            "<td>"+storeName + "<input type='hidden' name='pstore_"+trpid+"' value='"+store+"' /></td>"+
            "<td>"+eqty + "<input type='hidden' name='peqty_"+trpid+"' value='"+eqty+"' /></td>"+
            "<td>"+nqty + "<input type='hidden' name='pnqty_"+trpid+"' value='"+nqty+"' /></td>"+
            "<td>"+econd + "<input type='hidden' name='pecond_"+trpid+"' value='"+econd+"' /></td>"+
            "<td>"+ncond + "<input type='hidden' name='pncond_"+trpid+"' value='"+ncond+"' /></td>"+
            "</tr>";

        $("#vendorProdcutList").append(item);
        blankField();
    }
}
/////////////////////////////////////////
// $(".imageHolder").click(function () {
//                 img = $(this).find("img").attr('src');
//                 $('#productImgDialog').modal('show');
//                 $("#productImgDialog .modal-body").find("img").attr("src", img).hide().show(600);
//             });
//IAN
<?php
if(1===2){
?>
</script>
<?php } ?>