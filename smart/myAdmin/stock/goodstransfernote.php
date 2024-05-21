<?php
$pageTitle="Goods Transfer Note";

ob_start();
require_once("classes/receipt2.php");

$receipt=new purchase_receipt2();
$receipt->receiptAdd2();
// $dbF->prnt($_POST);


if($functions->developer_setting('product_Scale')=='0'){
    echo "<style>.allowProductScale{display:none;}</style>";
}

if($functions->developer_setting('product_color')=='0') {
    echo "<style>.allowProductColor{display:none;}</style>";
}

?>
    <h4 class="sub_heading"><?php echo _uc($_e['Goods Transfer Note']); ?></h4>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Goods Transfer Note View']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
        <li><a href="#trans" role="tab" data-toggle="tab"><?php echo _uc($_e['Transfer Initiated']); ?></a></li>
        <li><a href="#profile" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Goods Transfer Note']); ?></a></li>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['View All Goods Transfer Note']); ?></h2>
            <?php
                $receipt->receiptList2();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailGTN','Goods Transfer Note Info','receipt','.receiptEdit',false);
            ?>
        </div>

        <div class="tab-pane fade container-fluid" id="draft">
            <h2 class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
               <?php
                $receipt->receiptListDraft2();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailGTN','Goods Transfer Note Info','receipt2','.receiptEdit2',false);
               ?>
        </div>

        <div class="tab-pane fade container-fluid" id="trans">
            <h2 class="tab_heading"><?php echo _uc($_e['Transfer Initiated']); ?></h2>
               <?php
                $receipt->receiptListTransfer2();
                $receipt->functions->simpleModal('stock/stock_ajax.php?page=receiptDetailGTN','Goods Transfer Note Info','receipt3','.receiptEdit3',false);
               ?>
        </div>

        <div class="tab-pane fade container-fluid" id="profile">
            <h2 class="tab_heading"><?php echo _uc($_e['Add New Goods Transfer Note']); ?></h2>
                <?php $receipt->newReceiptForm2(); ?>
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
                if($('#receipt_store_id1').attr('disabled')){
                     console.log(data);
                    chk = $('#receipt_store_id1').val();
                    if(!data.includes("value='"+chk+"'")){
                        $("#receipt_product_id").val("");
                        jAlertifyAlert("<?php echo _js('Item not avialable in selected warehouse'); ?>");
                    }
                    else{
                        $('#receipt_store_id1').html(data);
                        $('#receipt_store_id1').val(chk).change();
                    }
                }
                else{
                    $('#receipt_store_id1').html(data);
                }
            }
            });
        }

    });

</script>



<?php return ob_get_clean(); 



?>

