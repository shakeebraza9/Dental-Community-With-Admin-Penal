<?php
ob_start();

require_once("classes/eventManagement.class.php");
global $dbF;

$eventManagement  =   new eventManagement();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
// $eventManagement->eventManagementEditSubmit();
$eventManagement->newusereventAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Event']); ?></h2>

<?php $eventManagement->usereventEdit(); ?>

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
                url: 'eventManagement/eventManagement_ajax.php?page=deleteuserevent',
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