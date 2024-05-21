<?php
ob_start();

require_once("classes/bookingForm.class.php");
global $dbF;

$bookingForm  =   new myUploads ();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$bookingForm->bookingFormEditSubmit();
$bookingForm->newbookingFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Bookings']); ?></h2>

<?php $bookingForm->bookingFormEdit(); ?>

<script>
    
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deletebookingForm(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'eventForm/bookingForm_ajax.php?page=deletebookingForm',
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


 $(".datepickerr").datepicker({ 
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
       yearRange: "-80:+20",
       showButtonPanel:true
  });
</script>
<?php return ob_get_clean(); ?>