<?php
ob_start();

require_once("classes/ticket_user.class.php");
global $dbF;

$webUsers  =   new ticketUser();
$msg1 = $webUsers->userEditSubmit();
$msg = $webUsers->userSubmit();
if ($msg != '') {
    $functions->notificationError($_e['WebUsers'], $msg, 'btn-info');
}
if ($msg1 != '') {
    $functions->notificationError($_e['WebUsers'], $msg1, 'btn-info');
}
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs tabs_arrow" role="tablist">
    <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo $_e['Users']; ?></a></li>
    <li class=""><a href="#addNew" role="tab" data-toggle="tab"><?php echo $_e['Add New']; ?></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane fade in active container-fluid" id="home">
        <h2 class="tab_heading"><?php echo $_e['Users']; ?></h2>
        <?php $webUsers->userView(); ?>
    </div>
    <div class="tab-pane fade in container-fluid" id="addNew">
        <h2 class="tab_heading"><?php echo $_e['Add New']; ?></h2>
        <?php $webUsers->userAdd('', true);  ?>
    </div>
</div>

<script src="ticketuser/js/ticket_user.js"></script>
<script>
$(function() {
    tableHoverClasses();
    dateJqueryUi();
});

function UserDelete(ths) {
    btn = $(ths);
    if (secure_delete()) {
        btn.addClass('disabled');
        btn.children('.trash').hide();
        btn.children('.waiting').show();

        id = btn.attr('data-id');
        $.ajax({
            type: 'POST',
            url: 'ticketuser/ticket_user_ajax.php?page=deleteUser',
            data: {
                id: id
            }
        }).done(function(data) {
            ift = true;
            if (data == '1') {
                ift = false;
                btn.closest('tr').hide(1000, function() {
                    $(this).remove()
                });
            } else if (data == '0') {
                jAlertifyAlert('<?php echo $_e['Delete Fail Please Try Again.']; ?>');
            }

            if (ift) {
                btn.removeClass('disabled');
                btn.children('.trash').show();
                btn.children('.waiting').hide();
            }
        });
    }
}


function activeWebUser(ths) {
    btn = $(ths);
    if (secure_delete('<?php echo $_e['Are You Sure You Want TO Update?']; ?>')) {
        btn.addClass('disabled');
        btn.children('.trash').hide();
        btn.children('.waiting').show();

        id = btn.attr('data-id');
        val = btn.attr('data-val');
        $.ajax({
            type: 'POST',
            url: 'webUsers/webUsers_ajax.php?page=activeWebUser',
            data: {
                id: id,
                val: val
            }
        }).done(function(data) {
            ift = true;
            if (data == '1') {
                ift = false;
                btn.closest('tr').hide(1000, function() {
                    $(this).remove()
                });
            } else if (data == '0') {
                jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');
            }
            if (ift) {
                btn.removeClass('disabled');
                btn.children('.trash').show();
                btn.children('.waiting').hide();
            }

        });
    }
}


function activeSponsor(ths) {
    btn = $(ths);
    if (secure_delete('<?php echo $_e['Are You Sure You Want TO Change Sponsor Status?']; ?>')) {
        btn.addClass('disabled');
        btn.children('.trash').hide();
        btn.children('.waiting').show();

        id = btn.attr('data-id');
        val = btn.attr('data-val');
        if (val == '0') {
            val = '1';
        } else {
            val = '0';
        }

        $.ajax({
            type: 'POST',
            url: 'webUsers/webUsers_ajax.php?page=activeSponsor',
            data: {
                id: id,
                val: val
            }
        }).done(function(data) {
            ift = true;
            if (data == '1') {
                ift = false;
                btn.attr('data-val', val);
                btn.children('.trash').removeClass('glyphicon-pushpin');
                btn.children('.trash').removeClass('glyphicon-usd');
                if (val == '1') {
                    btn.children('.trash').addClass('glyphicon-usd');
                    btn.attr('title', '<?php echo  $_e['DeActive Sponsor']; ?>');
                } else {
                    btn.children('.trash').addClass('glyphicon-pushpin');
                    btn.attr('title', '<?php echo $_e['Make Sponsor']; ?>');
                }
            } else if (data == '0') {
                jAlertifyAlert('<?php echo $_e['Update Fail Please Try Again.']; ?>');
            }
            btn.removeClass('disabled');
            btn.children('.trash').show();
            btn.children('.waiting').hide();

        });
    }
}
</script>
<?php return ob_get_clean(); ?>