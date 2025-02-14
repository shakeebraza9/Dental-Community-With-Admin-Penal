<?php
ob_start();
require_once("classes/receipt.php");
$receipt=new purchase_receipt();
$receipt->receiptAdd();
//$dbF->prnt($_POST);


if($functions->developer_setting('product_Scale')=='0'){
    echo "<style>.allowProductScale{display:none;}</style>";
}

if($functions->developer_setting('product_color')=='0') {
    echo "<style>.allowProductColor{display:none;}</style>";
}

?>
    <h4 class="sub_heading"><?php echo _uc($_e['Purchase Receipt']); ?></h4>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Purchase View']); ?></a></li>
         <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
         <!-- <li><a href="#duplicateentry" role="tab" data-toggle="tab"><?php echo _uc($_e['Duplicate Entry']); ?></a></li>  -->

        <!-- <li><a href="#profile" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Receipt']); ?></a></li> -->
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['View All Receipts']); ?></h2>
            <?php
                $receipt->receiptList();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetail','Receipt Detail Info','receipt','.receiptEdit',false);
            ?>
        </div> 
       <!--  <div class="tab-pane fade container-fluid" id="duplicateentry">
            <h2  class="tab_heading"><?php echo _uc($_e['View All Duplicate Entrys']); ?></h2>
            <?php
               // $receipt->receiptListDuplicateEntry();
              //  $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetail','Receipt Detail Info','receipt','.receiptEdit',false);
            ?>
        </div>
       -->
        <div class="tab-pane fade container-fluid" id="draft">
            <h2 class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
                <?php
                $receipt->receiptListDraft();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetail','Receipt Detail Info Info','receipt2','.receiptEdit2',false);
            ?>
        </div>
        
        <div class="tab-pane fade container-fluid" id="profile">
            <h2 class="tab_heading"><?php echo _uc($_e['Add New Receipt']); ?></h2>
                <?php $receipt->newReceiptForm(); ?>
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
        productHiddenpcode = ".receipt_product_pcode";
        productHiddenstatus = ".receipt_product_pstatus";

       var availableTags = <?php $receipt->productF->productJSON(); ?>;
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



<?php return ob_get_clean(); ?>