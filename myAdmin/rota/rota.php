<?php
ob_start();

require_once("classes/rota.class.php");
global $dbF;

$rota  =   new rota();

echo $rota->branchWagesForm(true);

if (isset($_GET['submit'])) {
    echo '<h2 class="tab_heading borderIfNotabs">Result</h2>';
    echo $rota->rotaPrint();
    echo $functions->dTableT();
}

?>

<script>
    
   $(function(){
        tableHoverClasses();
        dateJqueryUi();
        dateRangePicker();
    });

    function deleterota(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            from=btn.attr('data-from');
            to=btn.attr('data-to');
            $.ajax({
                type: 'POST',
                url: 'rota/rota_ajax.php?page=deleterota',
                data: { id:id,from:from,to:to }
            }).done(function(data){
                    ift =true;
                    if(data=='1'){
                        ift = false;
                        btn.closest('tr').hide(1000,function(){$(this).remove()});
                    }
                    else if(data=='0'){
                        jAlertifyAlert('<?php echo ($_e['Delete Fail Please Try Again.']); ?>');
                    }
                    else{
                        btn.append(data);
                    }
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
        }
    }

</script>
<?php return ob_get_clean(); ?>