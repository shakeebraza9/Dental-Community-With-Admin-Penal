<?php
ob_start();

require_once("classes/cpdGenerater.class.php");
global $dbF;

$cpdGenerater  =   new cpdGenerater();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$cpdGenerater->cpdGeneraterEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage CpdGenerater']); ?></h2>

            <?php $cpdGenerater->cpdGeneraterEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>