<?php
$pageTitle="Inventory Adjustment Note";
ob_start();
require_once("classes/receipt4.php");
$receipt=new purchase_receipt4();
$receipt->receiptEdit4();
// $dbF->prnt($_POST);

?>
<a href="-stock?page=inventoryadjustmentnote" class="btn btn-primary"><?php echo 'Back To Inventory Adjustment Note'; ?></a>
<h2 class="sub_heading borderIfNotabs"><?php echo 'Edit Inventory Adjustment Note'; ?></h2>
    
<?php $receipt->newReceiptFormEdit4(); ?>


    <script src="stock/js/stock.php"></script>
    <script>
        $(document).ready(function(){
            tableHoverClasses();
            dateJqueryUi();

            minMaxDate();
            dTableRangeSearch();
        });
    </script>

<script type="text/javascript">
<?php
        $temp = 'false';
         if($functions->developer_setting('product_Scale')=='1'){
            $temp = 'true';
         }
        echo "var hasScale = '$temp';";
        $temp = 'false';
         if($functions->developer_setting('product_color')=='1'){
            $temp = 'true';
         }
        echo "var hasColor = '$temp';";
        ?>
    $(function() {
        productId="#receipt_product_id";
        productHiddenClass = ".receipt_product_id";

       var availableTags = <?php $receipt->productF->productJSON2(); ?>;
        $(productId).autocomplete({
            source: availableTags,
            minLength: 0,
            select: function( event, ui ) {
                $(productHiddenClass).val(ui.item.id);
                $(productHiddenClass).attr("data-val",ui.item.label);
                if(hasScale !== 'true'){
                    console.log('scale');
                    scale(ui.item.scale);
                }
                if(hasColor !== 'true') {
                    console.log('color');
                    color(ui.item.color);
                }
                var id = $(this).next('input').val();
                getstorename(id);
            }
        }).on('focus : click', function(event) {
                $(this).autocomplete("search", "");
        });

        function getstorename(id){
            $.ajax({
            type: "POST",
            url: "stock/stock_ajax.php?page=getstorename",
            data: {id:id},
            success: function(data){
                $('#receipt_store_id').html(data);
            }
            });
        }

        $('#receipt_store_id').on('change', function() {
            storeId = $(this).val();
            pId = $('.receipt_product_id').val();
            $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "stock/stock_ajax.php?page=getdetails",
            data: {storeId:storeId,pId:pId},
            success: function(data){
                console.log(data['qty']);
                $('#receipt_eqty').val(data['qty']).attr('disabled','disabled');
                $('#receipt_econd').val(data['condition']).attr('disabled','disabled');
            }
            });

        });
            
    });

    $(".docEditDel").click(function () {
                if (secure_delete()) {
                    id = $(this).attr("data-id");
                    parnt = $(this).closest(".preview");
                    $.ajax({
                        type: "POST",
                        url: 'product_management/product_ajax.php?page=docEditDel',
                        data: {imageId: id}
                    }).done(function (data) {
                        if (data == '1') {
                            parnt.hide(500);
                        } else if (data == '0') {
                            jAlertifyAlert("<?php echo _js('Document Not Delete Please Try Again'); ?>");
                            return false;
                        }
                    });
                }
            });

</script>



<?php return ob_get_clean(); ?>