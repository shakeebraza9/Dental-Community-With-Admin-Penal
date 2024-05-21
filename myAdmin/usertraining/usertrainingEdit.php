<?php
ob_start();

require_once("classes/usertraining.class.php");
global $dbF;

$usertraining  =   new usertraining();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$usertraining->usertrainingEditSubmit();
$usertraining->newusertrainingAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage User Training/Document']); ?></h2>

<?php $usertraining->usertrainingEdit(); ?>

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
                url: 'usertraining/usertraining_ajax.php?page=deleteusertraining',
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