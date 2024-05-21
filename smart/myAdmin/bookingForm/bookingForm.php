<?php
ob_start();

require_once("classes/bookingForm.class.php");
global $dbF;

$bookingForm  =   new bookingForm();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$bookingForm->bookingFormEditsubmit();
$bookingForm->newbookingFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Bookings']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Bookings']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft Bookings']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Booking']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Bookings']); ?></h2>
            <?php $bookingForm->bookingFormView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft Bookings']); ?></h2>
            <?php $bookingForm->bookingFormDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Booking']); ?></h2>
            <?php $bookingForm->bookingFormNew();  ?>
        </div>
    </div>

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
                url: 'bookingForm/bookingForm_ajax.php?page=deletebookingForm',
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