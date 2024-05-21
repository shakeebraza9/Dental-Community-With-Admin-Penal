<?php
ob_start();

require_once("classes/webinar.class.php");
global $dbF;

$webinar  =   new webinar();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$webinar->webinarEditSubmit();
$webinar->newWebinarAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Webinar']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Webinar']); ?></a></li>
        <!-- <li><a href="#pending" role="tab" data-toggle="tab"><?php echo _uc($_e['Pending']); ?></a></li> -->
        <li><a href="#draft" role="tab" data-toggle="tab"><?php   echo _uc($_e['Draft']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Webinar']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active webinar']); ?></h2>
            <?php $webinar->webinarView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="pending">
            <h2  class="tab_heading"><?php echo _uc($_e['Pending']); ?></h2>
            <?php $webinar->webinarPending();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
            <?php $webinar->webinarDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Webinar']); ?></h2>
            <?php $webinar->webinarNew();  ?>
        </div>
    </div>

<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteWebinar(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'webinar/webinar_ajax.php?page=deleteWebinasr',
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