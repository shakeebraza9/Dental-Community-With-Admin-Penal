<?php
$pageTitle="Goods Transfer Note";
ob_start();
require_once("classes/receipt2.php");
$receipt=new purchase_receipt2();
$receipt->receiptEdit2();
//$dbF->prnt($_POST);

?>
<a href="-stock?page=goodstransfernote" class="btn btn-primary"><?php echo 'Back To Goods Transfer Note'; ?></a>
<h2 class="sub_heading borderIfNotabs"><?php echo 'Edit Goods Transfer Note'; ?></h2>
    
<?php $receipt->newReceiptFormEdit2(); ?>


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
                $('#receipt_store_id1').html(data);
            }
            });
        }

    });

</script>



<?php return ob_get_clean(); ?>