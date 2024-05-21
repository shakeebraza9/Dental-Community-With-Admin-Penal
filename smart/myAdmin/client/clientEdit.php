<?php
ob_start();

require_once("classes/client.class.php");
global $dbF;

$client  =   new client();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$client->clientEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc('Manage Course'); ?></h2>
<?php $client->clientEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>