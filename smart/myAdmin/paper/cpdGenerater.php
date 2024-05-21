<?php
ob_start();

require_once("classes/cpdGenerater.class.php");
global $dbF;

$cpdGenerater  =   new cpdGenerater();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$cpdGenerater->cpdGeneraterEditSubmit();
$cpdGenerater->newCpdGeneraterAdd();
?>
<h2 class="sub_heading"><?php echo _uc('Manage Cpd Generater'); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active CpdGenerater']); ?></a></li>
        <!-- <li><a href="#pending" role="tab" data-toggle="tab"><?php echo _uc($_e['Pending']); ?></a></li> -->
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New CpdGenerater']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active CpdGenerater']); ?></h2>
            <?php $cpdGenerater->cpdGeneraterView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="pending">
            <h2  class="tab_heading"><?php echo _uc($_e['Pending']); ?></h2>
            <?php $cpdGenerater->cpdGeneraterPending();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
            <?php $cpdGenerater->cpdGeneraterDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New CpdGenerater']); ?></h2>
            <?php $cpdGenerater->cpdGeneraterNew();  ?>
        </div>
    </div>

<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteCpdGenerater(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'cpdGenerater/cpdGenerater_ajax.php?page=deleteCpdGenerater',
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