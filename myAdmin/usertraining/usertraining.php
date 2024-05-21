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

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Completed User Training/Document']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Uncompleted User Training/Document']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New User Training/Document']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Completed User Training/Document']); ?></h2>
            <?php $usertraining->usertrainingView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Uncompleted User Training/Document']); ?></h2>
            <?php $usertraining->usertrainingDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New User Training/Document']); ?></h2>
            <?php $usertraining->usertrainingNew();  ?>
        </div>
    </div>

<script>

    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteusertraining(ths){
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