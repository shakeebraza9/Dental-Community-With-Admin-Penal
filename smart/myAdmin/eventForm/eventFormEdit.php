<?php
ob_start();

require_once("classes/eventForm.class.php");
global $dbF;

$eventForm  =   new eventForm();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$eventForm->eventFormEditSubmit();
$eventForm->neweventFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Event Forms']); ?></h2>

<?php $eventForm->eventFormEdit(); ?>

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
                url: 'eventForm/eventForm_ajax.php?page=deleteeventForm',
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