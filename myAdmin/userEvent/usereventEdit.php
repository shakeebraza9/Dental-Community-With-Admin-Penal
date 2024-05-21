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

<?php $userevent->usereventEdit(); ?>

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