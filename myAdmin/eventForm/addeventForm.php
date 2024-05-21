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
<h2 class="sub_heading"><?php echo _uc($_e['Add Event Forms']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
      <!--   <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Event Forms']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft Event Forms']); ?></a></li> -->
        <li class="active"><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Event Forms']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
       

        <div class="tab-pane fade active in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Event Forms']); ?></h2>
            <?php $eventForm->eventFormNew();  ?>
        </div>
    </div>

<script>

    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteeventForm(ths){
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