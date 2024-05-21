<?php
ob_start();

require_once("classes/usereventForm.class.php");
global $dbF;

$usereventForm  =   new usereventForm();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$usereventForm->usereventFormEditSubmit();
$usereventForm->newusereventFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage User Event Forms']); ?></h2>

<?php $usereventForm->usereventFormEdit(); ?>

<script>
    
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteuserevent(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'usereventForm/usereventForm_ajax.php?page=deleteusereventForm',
                data: { id:id }
            }).done(function(data)
                {
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