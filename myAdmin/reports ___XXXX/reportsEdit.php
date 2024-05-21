<?php
ob_start();

require_once("classes/reports.class.php");
global $dbF;

$reports  =   new reports();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$reports->reportsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage reports']); ?></h2>

            <?php $reports->reportsEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>