<?php
ob_start();

require_once("classes/documents.class.php");
global $dbF;

$documents  =   new documents();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$documents->documentsEditSubmit();
$documents->newdocumentsAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Documents']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Documents']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft Documents']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Document']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Documents']); ?></h2>
            <?php $documents->documentsView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft Documents']); ?></h2>
            <?php $documents->documentsDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Document']); ?></h2>
            <?php $documents->documentsNew();  ?>
        </div>
    </div>

<script>

    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deletedocuments(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'documents/documents_ajax.php?page=deletedocuments',
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
</script>
<?php return ob_get_clean(); ?>