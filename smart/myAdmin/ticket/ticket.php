<?php
ob_start();

require_once("classes/ticket.class.php");

global $dbF;

$webUsers  =   new clientUsers();
$msg = $webUsers->ticketEditSubmit();
$msg1 = $webUsers->submitTicket();
$msg2 = $webUsers->ticketResponse();

if ($msg != '') {
    $functions->notificationError($_e['Ticket'], $msg, 'btn-info');
}
if ($msg1 != '') {
    $functions->notificationError($_e['Ticket'], $msg2, 'btn-info');
}
if ($msg2 != '') {
    $functions->notificationError($_e['Ticket'], $msg2, 'btn-info');
}
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs tabs_arrow" role="tablist">
    <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo $_e['Ticket']; ?></a></li>
    <li class=""><a href="#addNew" role="tab" data-toggle="tab"><?php echo $_e['Create Ticket']; ?></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane fade in active container-fluid" id="home">
        <h2 class="tab_heading"><?php echo $_e['Ticket']; ?></h2>
        <?php $webUsers->ticketView(); ?>
    </div>

    <div class="tab-pane fade in container-fluid" id="addNew">
        <h2 class="tab_heading"><?php echo $_e['Create Ticket']; ?></h2>
        <?php $webUsers->ticketAdd('', true);  ?>
    </div>
</div>
</div>


<script src="ticket/js/ticket.js"></script>
<script>
$(function() {
    tableHoverClasses();
    dateJqueryUi();
});

function ticketDelete(ths) {
    btn = $(ths);
    if (secure_delete()) {
        btn.addClass('disabled');
        btn.children('.trash').hide();
        btn.children('.waiting').show();

        id = btn.attr('data-id');
        $.ajax({
            type: 'POST',
            url: 'ticket/ticket_ajax.php?page=deleteTicket',
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

function responseDelete(ths) {
    btn = $(ths);
    if (secure_delete()) {
        btn.addClass('disabled');
        btn.children('.trash').hide();
        btn.children('.waiting').show();

        id = btn.attr('data-id');
        $.ajax({
            type: 'POST',
            url: 'ticket/ticket_ajax.php?page=responseDelete',
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
</script>
<?php return ob_get_clean(); ?>