<?php
$pageTitle="Goods Receive Note";
ob_start();
require_once("classes/receipt.php");
$receipt=new purchase_receipt();

$receipt->purchaseReceiptduplicate();


// $dbF->prnt($_POST); 

?>
<a href="-stock?page=purchaseReceipt" class="btn btn-primary"><?php echo $_e['Back To Goods Receive Note']; ?></a>
<h2 class="sub_heading borderIfNotabs"><?php echo $_e['Duplicate Entry']; ?></h2>
 
 
<?php 

echo '<script>alert("Some Code Are Duplicate please Unique  Enter  ");</script>    ';
 $receipt->receiptListDuplicateEntry();  
 


?>


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
     
  

    

       var availableTags = <?php $receipt->productF->productJSON(); ?>;
       console.log(availableTags);

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
                getstorename_grn(id);
            }
        }).on('focus : click', function(event) {
                $(this).autocomplete("search", "");
        });

        function getstorename_grn(id){
            $.ajax({
            type: "POST",
            url: "stock/stock_ajax.php?page=getstorename_grn",
            data: {id:id},
            success: function(data){
                $('#receipt_store_id').html(data);
            }
            });
        }
        
    });

</script>



<?php return ob_get_clean(); ?>