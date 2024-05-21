<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

$getId = @$_GET['id'];



$pName = str_replace("_", " ", $getId);
?>
<div class="event_details" id="myform">
    <h3>
     Add a new product
    </h3>
    <div class="form_side">
  
  <form enctype="multipart/form-data" role="form" method="post">

        <div class="row">

       


            <?php echo $functions->setFormToken("addNewProductByUser",false); ?>
            <div class="form-group col-12 col-md-6">
                <label>Product Name</label>
                <input name="slug" type="hidden" value="<?php echo $getId ?>">
                <input name="p_status" type="hidden" value="0">
         

                <input name="pName" placeholder="Product Name" type="text" value="<?php echo $pName; ?>">
            </div>
          



              <div class="form-group col-12 col-md-6 hideShow">
                <label>Product Code</label>
                <!-- <input name="shift_name" placeholder="Shift Name" type="text" required> -->
                <input name="p_code" placeholder="Product Code" type="text" value="">
            </div>



  
   <div class="form-group col-12 col-md-6 hideShow">
                <label>Size</label>
                <!-- <input name="shift_name" placeholder="Shift Name" type="text" required> -->
                <input name="size" placeholder="Size" type="text" value="">
            </div>
            
       <div class="form-group col-12 col-md-6 hideShow">
                <label>color</label>
                <!-- <input name="shift_name" placeholder="Shift Name" type="text" required> -->
                <input name="color" placeholder="color" type="text" value="">
            </div>
            
<!--<div class="form-group col-12 col-md-6">-->
<!--<label>Select Size</label>-->
<!--<select name="size">-->

<!--<option value="">no size</option>-->

<!--<php -->

<!--$sql4 = "SELECT * FROM `scales`";-->
<!--$data4 = $dbF->getRows($sql4);-->

 


<!--foreach ($data4 as $keyS => $valueS) {-->
<!--   ?>-->
<!--<option value="<php echo $valueS['scale_id'] ?>"><php echo $valueS['scale_name'] ?></option>-->



<!--<php-->

<!-- }-->






<!-- ?>-->

<!--</select>-->
<!--</div>-->
<!-- form-group -->





<!--<div class="form-group col-12 col-md-6">-->
<!--<label>Select Color</label>-->
<!--<select name="color">-->
<!--<option value="">no color</option>-->
<!--<php -->

<!--$sql45 = "SELECT * FROM `colors`";-->
<!--$data45 = $dbF->getRows($sql45);-->
<!--foreach ($data45 as $keyC => $valueC) {-->
<!--    ?>-->
<!--<option value="<php echo $valueC['color_id'] ?>"><php echo $valueC['color_name'] ?></option>-->
<!--<php-->

<!--}-->





<!--?>-->



<!--</select>-->
<!--</div>-->
<!-- form-group -->













<div class="form-group col-12 col-md-6">
<label>Select Product Category</label>
<select name="cat">

<option value="">no Category</option>

<?php 

$sqli = "SELECT * FROM `categories` where under =1";
$datai = $dbF->getRows($sqli);

 


foreach ($datai as $keyi => $valuei) {
   ?>
<option value="<?php echo $valuei['id'] ?>"><?php echo translateFromSerialize($valuei['name']) ?></option>





<?php


$sqlij = "SELECT * FROM `categories` where under =?";
$dataij = $dbF->getRows($sqlij,array($valuei['id']));




 foreach ($dataij as $keyj => $valuej): ?>
    

    <option value="<?php echo $valuej['id'] ?>">                - <?php echo translateFromSerialize($valuej['name']) ?></option>



<?php endforeach ?>



<?php

}






?>

</select>
</div>
<!-- form-group -->


<!-- <div class="form-group col-12 col-md-6"> -->

<!-- <div class="btn_new"> -->
<!-- <label>Product Type</label>
<select name="p_status">
<option value="0">Whole Product</option>
<option value="1">Per Piece</option>
</select>
</div>
 -->




            <div class="form-group col-12 col-md-6">
                <label>Product Image</label>
               
               <input type="file" name="Pimg" id="file">
            </div>
            <!-- form-group -->
           




            <div class="col-12">
                <div class="errmsg"></div>
                <input type="submit" class="submit_class" value="Save" id="submit">
            </div>



         </div><!-- END ROW-->
        </form>

         <script>










            $('.slider').on('change', function() {

// $(this).find('input[type=checkbox]').prop("checked", !$(this).find('input[type=checkbox]').prop("checked"));
console.log("asasas");
    if ($(this).find('input[type=checkbox]').is(':checked')) {
          $('.hideShow').slideDown(600);
          // $('.form-group ').slideDown(600);
       
    } else {
        $('.hideShow').slideUp(600);
        // $('.form-group ').slideUp(600);
    
    }
});





$(document).ready(function() {
    $('.time_picker').timepicker({
        hourGrid: 4,
        minuteGrid: 10,
        timeFormat: 'hh:mm tt'
    });

    $('#submit').click(function(e) {
        e.preventDefault();


        pName = $('input[name=pName]').val();
        p_code = $('input[name=p_code]').val();
        size = $('input[name=size]').val();
        color = $('input[name=color]').val();
        p_status = $('input[name=p_status]').val();
        slug = $('input[name=slug]').val();


var users = $('select[name=cat]').val();


// console.log(users);




// if (users){
// console.log(users.length);
// for (var i = 0; i < users.length; i++) {
//     form_data.append('arr[]', users[i]);
// }

// }






      
var file_data = $('#file').prop('files')[0];   
var form_data = new FormData();                  
form_data.append('file', file_data);
form_data.append('slug', slug);

 form_data.append('arr', users);


form_data.append('slug', slug);
form_data.append('p_status', p_status);
form_data.append('color', color);
form_data.append('size', size);
form_data.append('p_code', p_code);
form_data.append('pName', pName);
// form_data.append('users[]', users);







        if (pName == '') {
            $('.errmsg').text('Product Name Is Required');
        }
        else{
            $(this).attr('disabled', true);
            $('.errmsg').text('');
            $.ajax({
                type: 'post',
                   data: form_data,   
                url: 'ajax_call.php?page=customProAdded',
                 mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
            }).done(function(php_script_response) {

resultObj = eval(php_script_response);




var pid= resultObj[0];

var pname= resultObj[1];

var pScaleId= resultObj[2];

var sname= resultObj[3];

var pColorId= resultObj[4];

var cname= resultObj[5];

var storeId= resultObj[6];
var p_status= resultObj[7];
var pcode= resultObj[8];







// var pid = res;

  if(pScaleId ==""){pScaleId = 0;}
    if(pColorId==""){pColorId = 0;}

    scaleVal = " -- "   +   sname;
    colorVal = " -- "   +   cname;

    //if no color or scale has then scale and color name blank to show on temparary
    if(pScaleId == '0'){
        scaleVal = '';
    }
    if(pColorId == '0'){
        colorVal = '';
    }

    var pName = pname + scaleVal +colorVal;
    //    var vendor =$("#receipt_vendor").val();
    // var date    =   $("#receipt_date").val();
    var price   =   parseFloat($("#receipt_price").val());
    var qty     =   parseInt($("#receipt_qty").val());
    // var store   =   parseInt($("#r_store").val());


        var pLocation   =   ($("#pLocation").val());
    var pExpiry   =   ($("#pExpiry").val());
    var minStock   =   ($("#minStock").val());



    
    var store   =   storeId;
    //   var storeName = $("#receipt_store_id option:selected").text();

    var trpid = "p_"+pid+"-"+pScaleId+"-"+pColorId+"-"+store;


    console.log(trpid);








    console.log('addNewProductByUser');
  
    if (document.getElementById("tr_"+trpid)) {

        alert("Duplicate Entry : Product Item already exist in list!");

        document.getElementById(trpid).checked = true;
        checkchange(trpid);
    }
    else if (qty > 0 && pid > 0 ) {
            sr++;
        var text = '';
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
               




var pstatus = p_status;
// var pcode = $(".receipt_product_pcode").val();
 // alert(pstatus);
if ( pstatus == "0" ) {
   for (i = 0; i < 1; i++) {
  text += pcode+" <input type='hidden' name='pcode_"+trpid+"_pd[]' value='"+pcode+"' /> ";
 



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

    




    }    else {  alert("Duplicate Entry : Product Item already exist. Please select product from dropdown suggestion.");}



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

// });




 $(".fixed_side").removeClass("fixed_side_");
        $(".col5").removeClass("col5_");
        $(".myevents-div").removeClass("myevents-div_");
        $(".myevents-div").removeClass("redborder");
        $(".myevents-div").removeClass("blueborder");
        $(".myevents-div").removeClass("greenborder");
        $("[title='chat widget']").parent('div').attr("style", "display: block !important;position: fixed !important");
        setTimeout(function(){
            $(".myevents-form").empty();
             $('.myevents-div #loader').show();
        },1000); 




                // if (data == '1') {
                //     // location.reload();
                // } else {
                //     $(this).removeAttr('disabled', false);
                // }
            });
        }
    });
});
</script>


    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->
