<?php
ob_start();

require_once("classes/ticket.class.php");
global $dbF;
$webUsers  =   new clientUsers();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$msg = $webUsers->ticketEditSubmit();
@$id     = $_GET['id'];
?>
<a href="-ticket?page=ticket" class="btn btn-primary"><?php echo $_e['Back To WebUsers']; ?></a>
<h2 class="sub_heading borderIfNotabs"><?php echo $_e['Edit User Info']; ?></h2>

<?php

if ($msg != '') {
    $functions->notificationError($_e['WebUsers'], $msg, 'btn-info');
}
$webUsers->ticketEdit($id);

?>



<script src="ticket/js/ticket.js"></script>


<?php return ob_get_clean(); ?>