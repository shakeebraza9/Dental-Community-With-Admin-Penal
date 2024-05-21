<?php
ob_start();

require_once("classes/ticket.class.php");
global $dbF;
$webUsers  =   new clientUsers();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
@$id     = $_GET['id'];
@$t_id = $_GET['t_id'];
?>
<h2 class="sub_heading borderIfNotabs"><?php echo $_e['Ticket Response']; ?></h2>

<?php

$webUsers->responseView($id, $t_id);

$product = false;
//products order reports end 
?>


<style>
.card {
    border: 2px solid #87ba41;
    border-radius: 10px;
    padding: 10px;
    background-color: white;
    margin-bottom: 10px;
    ;
}
</style>
<script src="ticket/js/ticket.js"></script>

<?php return ob_get_clean(); ?>