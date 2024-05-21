<?php
ob_start();

require_once("classes/bookingForm.class.php");
global $dbF;

$bookingForm  =   new bookingForm();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$bookingForm->lunchandlearnFormEditSubmit();
$bookingForm->newlunchandlearnFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Lunch And Learn']); ?></h2>

<?php $bookingForm->lunchandlearnFormEdit(); ?>

<script>
    
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deletelunchandlearnForm(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'eventForm/bookingForm_ajax.php?page=lunchandlearn',
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