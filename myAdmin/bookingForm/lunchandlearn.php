<?php
ob_start();

require_once("classes/bookingForm.class.php");
global $dbF;

$bookingForm  =   new bookingForm();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$bookingForm->lunchandlearnFormEditsubmit();
$bookingForm->newlunchandlearnFormAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Lunch And Learn']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Lunch And Learn']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft Lunch And Learn']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Lunch And Learn']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Lunch And Learn']); ?></h2>
            <?php $bookingForm->lunchandlearnFormView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft Lunch And Learn']); ?></h2>
            <?php $bookingForm->lunchandlearnFormDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Lunch And Learn']); ?></h2>
            <?php $bookingForm->lunchandlearnFormNew();  ?>
        </div>
    </div>

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
                url: 'bookingForm/bookingForm_ajax.php?page=lunchandlearn',
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