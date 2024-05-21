<?php
ob_start();

require_once("classes/ticket.class.php");
global $dbF;
$webUsers  =   new clientUsers();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$msg = $webUsers->ticketResponseSubmit();
@$id     = $_GET['id'];
@$t_id = $_GET['t_id'];
?>
<h2 class="sub_heading borderIfNotabs"><?php echo $_e['Ticket Response']; ?></h2>
<?php

if ($msg != '') {
    $functions->notificationError($_e['WebUsers'], $msg, 'btn-info');
}

$webUsers->ticketResponse($id, $t_id);

?>



<script src="ticket/js/ticket.js"></script>

<?php return ob_get_clean(); ?>