<?php
$pageTitle="Inventory Adjustment Note";
ob_start();
require_once("classes/receipt4.php");
$receipt=new purchase_receipt4();
$receipt->receiptAdd4();
// $dbF->prnt($_POST);


if($functions->developer_setting('product_Scale')=='0'){
    echo "<style>.allowProductScale{display:none;}</style>";
}

if($functions->developer_setting('product_color')=='0') {
    echo "<style>.allowProductColor{display:none;}</style>";
}

?>
    <h4 class="sub_heading"><?php echo _uc($_e['Inventory Adjustment Note']); ?></h4>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Inventory Adjustment Note View']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
        <li><a href="#initiated" role="tab" data-toggle="tab"><?php echo _uc($_e['Adjustment Initiated']); ?></a></li>
        <li><a href="#profile" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Inventory Adjustment Note']); ?></a></li>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['View All Inventory Adjustment Note']); ?></h2>
            <?php
                $receipt->receiptList4();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailIAN','Inventory Adjustment Note Info','receipt','.receiptEdit',false);
            ?>
        </div>

        <div class="tab-pane fade container-fluid" id="draft">
            <h2 class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
               <?php
                $receipt->receiptListDraft4();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailIAN','Inventory Adjustment Note Info','receipt2','.receiptEdit2',false);
               ?>
        </div>

        <div class="tab-pane fade container-fluid" id="initiated">
            <h2 class="tab_heading"><?php echo _uc($_e['Adjustment Initiated']); ?></h2>
               <?php
                $receipt->receiptListInitiated4();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailIAN','Inventory Adjustment Note Info','receipt3','.receiptEdit3',false);
               ?>
        </div>

        <div class="tab-pane fade container-fluid" id="profile">
            <h2 class="tab_heading"><?php echo _uc($_e['Add New Inventory Adjustment Note']); ?></h2>
                <?php $receipt->newReceiptForm4(); ?>
        </div>

    </div>

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
               // getstorename(id);
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
                var qty = data['qty'];
                if(data['qty']<1){
                    qty = 0;
                }
                $('#receipt_eqty').val(qty).attr('disabled','disabled');
                $('#receipt_econd').val(data['condition']).attr('disabled','disabled');
            }
            });

        });
            
    });

</script>



<?php return ob_get_clean(); ?>