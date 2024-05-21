<?php
ob_start();

require_once("classes/userevent.class.php");
global $dbF;

$userevent  =   new userevent();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$userevent->usereventEditSubmit();
$userevent->newusereventAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Event']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Approved Event']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Event']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Approved Event']); ?></h2>
            <?php $userevent->usereventView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
            <?php $userevent->usereventDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Event']); ?></h2>
            <?php $userevent->usereventNew();  ?>
        </div>
    </div>

<script>
    $('.add-file-btn').on('click', function(){
        var i = $('.add-file .input-group:last-child input').attr('name');
        if(i == null){i=0}
        i = parseInt(i)+parseInt(1);
        $('.add-file').append('<div class="input-group"><input type="text"  name="file[]" class="'+i+' form-control" placeholder=""><div class="input-group-addon pointer " onclick="openKCFinderFile($('+"'."+i+"'"+'))"><i class="glyphicon glyphicon-file"></i></div></div>');
    });

    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteuserevent(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'userEvent/userevent_ajax.php?page=deleteuserevent',
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