<?php
ob_start();

require_once("classes/eventManagement.class.php");
global $dbF;

$eventManagement  =   new eventManagement();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$eventManagement->eventManagementEditSubmit();
$eventManagement->neweventManagementAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Event']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Event']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
     \
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Event']); ?></h2>
            <?php $eventManagement->eventManagementView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
            <?php $eventManagement->eventManagementDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Event']); ?></h2>
            <?php $eventManagement->eventManagementNew();  ?>
        </div>
    </div>

<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteeventManagement(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'eventManagement/eventManagement_ajax.php?page=deleteeventManagement',
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

$('#make-switch0').on('change', function() {
var chk = $('.checkboxHidden').val();
if(chk=='1'){
$('#users').show();
$('#users select').attr("name","assignto");
}
else {
$('#users select').removeAttr("name");
$('#users').hide();
}
});

$('.recurring_duration').on('change',function(){
var chk = $(this).val();
if(chk == 'Once' || chk == 'Once Check'){
    $('.rd').show(100);
}
else{
    $('.rd').hide(100);
    $('.rd select').val('').change();
}
});
</script>
<?php return ob_get_clean(); ?>