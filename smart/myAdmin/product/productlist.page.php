<?php

ob_start();

$product = new product();



    /**

     * MultiLanguage keys Use where echo;

     * define this class words and where this class will call

     * and define words of file where this class will called

     **/

    global $_e;

    global $adminPanelLanguage;

    $_w['Product List!'] = '' ;

    $_w['All Products'] = '' ;

    $_w['Drafts'] = '' ;

    $_w['Pending'] = '' ;

    $_w['All Products'] = '' ;

    $_w['Draft'] = '' ;

    $_w['Pending'] = '' ;

    $_w['Delete All Selected Product'] = '' ;

    $_w['Delete Fail Please Try Again.'] = '' ;

    $_w['Filter'] = '' ;

    $_w['Filter Selected'] = '' ;

    $_w['Add to Category'] = '' ;

    $_w['Products Added To Category'] = '' ;

    $_w['Remove From Category'] = '' ;

    $_w['Products Removed From Category'] = '' ;
    $_w['Minimum Stock to Notify'] = '' ;

    $_w[''] = '' ;

    $_w[''] = '' ;

    $_w[''] = '' ;

    $_w[''] = '' ;



    $_e    =   $dbF->hardWordsMulti($_w,$adminPanelLanguage,'Admin ProductView');

?>

<script>

    $(document).ready(function(){

        tableHoverClasses();



        setTimeout(function(){

            $("ul.ColVis_collection .delCheckboxOncolvis").remove();

            $("ul.ColVis_collection li:first-child span").text("SNO");

        },2000);

    });







    function selectProductDel(ths){

       var remove;

       var checkedValues='';

        var i=true;

        btn=$(ths);

        if(secure_delete()){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            $('.dTable tbody input:checkbox:checked, .dTable_ajax tbody input:checkbox:checked').each(function(){

                if(i){

                  remove = ".p_"+ $(this).val();

                  checkedValues= $(this).val();

                  i=false;

                }else{

                    remove += " , .p_"+ $(this).val();

                    checkedValues += ", "+$(this).val();

                }

            });



            if(checkedValues==''){

                alert("No Product Found To Delete.");

                btn.removeClass('disabled');

                btn.children('.trash').show();

                btn.children('.waiting').hide();

                return false;

            }



            $.ajax({

                type: 'POST',

                url: "product_management/product_ajax.php?page=selectedProductDel",

                data: { id:checkedValues }

            }).done(function(data)

                {

                    if(data=='1'){

                        setTimeout(function(){

                            $(remove).hide(700, function(){

                                $(remove).remove();

                                btn.removeClass('disabled');

                                btn.children('.trash').show();

                                btn.children('.waiting').hide();

                            });

                        },300);

                    }

                    else if(data=='0'){

                        btn.removeClass('disabled');

                        btn.children('.trash').show();

                        btn.children('.waiting').hide();

                        jAlertifyAlert('<?php echo _js($_e['Delete Fail Please Try Again.']); ?>');

                    }

                });

        }

    }







</script>



<div ng-app="angular" ng-controller='angularController'>



    <h4 class="sub_heading"><?php echo _uc($_e['Product List!']); ?></h4>





    <!-- Nav tabs -->

    <ul class="nav nav-tabs tabs_arrow" role="tablist" >

        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['All Products']); ?></a></li>

        <li><a href="#product_draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Drafts']); ?></a></li>

        <li><a href="#prodcut_pending" role="tab" data-toggle="tab"><?php echo _uc($_e['Pending']); ?></a></li>
        
      

    </ul>



    <!-- Tab panes -->

    <div class="tab-content">

        <div class="tab-pane fade in active container-fluid" id="home">

            <h2 class="tab_heading"><?php echo _uc($_e['All Products']); ?></h2>

          


                <?php $product->productView(); ?>

        </div>

        <div class="tab-pane fade container-fluid" id="product_draft">

            <h2 class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>

            <?php $product->productDraft(); ?>

        </div>

        <div class="tab-pane fade container-fluid" id="prodcut_pending">

            <h2 class="tab_heading"><?php echo _uc($_e['Pending']); ?></h2>

            <?php $product->productPending(); ?>

        </div>

 
 



        <?php $product->productF->AjaxDelScript('singleProductDel','Product'); ?>



    </div>

    <div class="container-fluid">

        <button style="display:none !important" class="btn btn-danger btn-large" onclick="selectProductDel(this);">

            <i class='glyphicon glyphicon-trash trash'></i>

            <i class='fa fa-refresh waiting fa-spin' style='display: none'></i>

            <?php echo _uc($_e['Delete All Selected Product']); ?>

        </button>

    </div>



</div>



<script>

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    function copyMissingProducts(ths){
        var ids = '<?php echo $missing_products['ids'] ?>';
        // console.log("working"+ids);
        
        $.ajax({
            url: 'product_management/product_ajax.php?page=copyMissingProducts',
            type: 'POST',
            data: { ids : ids}
        }).done(function(res){
            if(res == '1'){
                jAlertifyAlert('<?php echo $_e['Missing Products Copied Successfully.']; ?>');
            }
        });
    }

    function featureItem(ths){

        btn=$(ths);

        val=btn.attr('data-val');

        if(val=='1'){

            start = '<?php echo $_e["Active"]; ?>';

        }else{

            start = '<?php echo $_e["DeActive"]; ?>';

        }

        if(secure_delete("<?php echo _replace("{{state}}",'"+start+"',$_e["Are you sure you want to {{state}} Feature Product?"]); ?>")){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            id=btn.attr('data-id');



            $.ajax({

                type: 'POST',

                url: 'product_management/product_ajax.php?page=featureItem',

                data: { id:id,val:val }

            }).done(function(data)

            {

                ift =true;

                if(data=='1'){

                    if(val=='0'){

                        //location.replace('-email?page=newsLetter');

                        btn.attr('data-val','1');

                        btn.children('.trash').removeClass('glyphicon-star');

                        btn.children('.trash').addClass('glyphicon-star-empty');

                    }else{

                        btn.attr('data-val','0');

                        btn.children('.trash').addClass('glyphicon-star');

                        btn.children('.trash').removeClass('glyphicon-star-empty');

                    }



                }

                else if(data=='0'){

                    jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');

                }



                btn.removeClass('disabled');

                btn.children('.trash').show();

                btn.children('.waiting').hide();



            });

        }

    }



    function trandingItem(ths){

        btn=$(ths);

        val=btn.attr('data-val');

        if(val=='2'){

            start = '<?php echo $_e["Active"]; ?>';

        }else{

            start = '<?php echo $_e["DeActive"]; ?>';

        }

        if(secure_delete("<?php echo _replace("{{state}}",'"+start+"',$_e["Are you sure you want to {{state}} Feature Item 2?"]); ?>")){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            id=btn.attr('data-id');



            $.ajax({

                type: 'POST',

                url: 'product_management/product_ajax.php?page=featureItem',

                data: { id:id,val:val }

            }).done(function(data)

            {

                ift =true;

                if(data=='1'){

                    if(val=='3'){

                        //location.replace('-email?page=newsLetter');

                        btn.attr('data-val','2');

                        btn.children('.trash').removeClass('glyphicon-heart');

                        btn.children('.trash').addClass('glyphicon-heart-empty');

                    }else{

                        btn.attr('data-val','3');

                        btn.children('.trash').addClass('glyphicon-heart');

                        btn.children('.trash').removeClass('glyphicon-heart-empty');

                    }



                }

                else if(data=='0'){

                    jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');

                }



                btn.removeClass('disabled');

                btn.children('.trash').show();

                btn.children('.waiting').hide();



            });

        }

    }





</script>



<script>



$(document).ready(function(){

    $('#hide-show').click(function(event) {

        $('#cate').toggle();

        $('#script-width').toggleClass("dTableWidth");

    });

});



$('input[type=checkbox]').click(function () {

    console.log('checkbox clicked');

    $(this).parent()

        .find('li input[type=checkbox]')

        .prop('checked', $(this)

        .is(':checked'));

    var sibs = false;



    $(this).closest('ul')

        .children('li').each(function () {

            if($('input[type=checkbox]', this).is(':checked')) 

                sibs=true;

    })

    // $(this).parents('ul').prev().prop('checked', sibs);



    // $("input[type='checkbox'] ~ ul input[type='checkbox']").change(function() {

    //     $(this).closest("li:has(li)").children("input[type='checkbox']").prop('checked', $(this).closest('ul').find("input[type='checkbox']").is(':checked'));

    // });

});

var joinTest = '';

var joinTest1 = '';

var favorite = new Array();

$('#fiter_products').click(function(event) {

    favorite = [];

	joinTest1 = '';

    $.each($("input[name='cats[]']:checked"), function(){            

                favorite.push($(this).val());

            });

    joinTest = favorite.join(",");

    console.log('joinTest : '+joinTest);

    fetch_ajax_result_again();

});



function fetch_ajax_result_again() {



    my_dtable = $.fn.dataTable.tables( { visible: true, api: true } );

    $(my_dtable).DataTable().ajax.reload();



}



$('#updateDiscount').click(function(event) {

    $.ajax({

        url: 'product/updateDiscount.php?update=true',

        type: 'post',

    })

    .done(function(res) {

        console.log("success : "+res);

    });

    

});



$('#fiter_selected_products').click(function(){

    joinTest = '';

    $.each($("input[name='cats[]']:checked"), function(){            

                favorite.push($(this).val());

            });

    joinTest1 = favorite.join(",");

    fetch_ajax_result_again();

});



var addCatArray = new Array();

var addProArray = new Array();

$('#add_to_category').click(function(){

    $.each($("input[name='prod_check']:checked"), function(){            

                addProArray.push($(this).val());

            });

    $.each($("input[name='cats[]']:checked"), function(){            

                addCatArray.push($(this).val());

            });

    if(addCatArray.length > 0 && addProArray.length > 0){

        $.ajax({

            type: 'POST',

            url: "product_management/product_ajax.php?page=addProToCat",

            data: { proArray:addProArray, catArray:addCatArray}

        }).done(function(res){

            var msgAlert = '<?php echo $_e["Products Added To Category"]; ?>';

            alert(msgAlert);

        });

    }else{

        var add_error = '<?php echo _uc($_e['Please select categories and products both, It is mandatory']); ?>';

        alert(add_error);

    }

});





var removeCatArray = new Array();

var removeProArray = new Array();

$('#remove_from_category').click(function(){

    $.each($("input[name='prod_check']:checked"), function(){            

                removeProArray.push($(this).val());

            });

    $.each($("input[name='cats[]']:checked"), function(){            

                removeCatArray.push($(this).val());

            });

    if(removeCatArray.length > 0 && removeProArray.length > 0){

        $.ajax({

            type: 'POST',

            url: "product_management/product_ajax.php?page=removeProFromCat",

            data: { proArray:removeProArray, catArray:removeCatArray}

        }).done(function(res){

            var msgAlert = '<?php echo $_e["Products Removed From Category"]; ?>';

            alert(msgAlert);

        });

    }else{

        var remove_error = '<?php echo _uc($_e['Please select categories and products both, It is mandatory']); ?>';

        alert(remove_error);

    }

});


</script>






<?php return ob_get_clean(); ?>