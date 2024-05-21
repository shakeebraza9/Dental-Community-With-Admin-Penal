<?php
ob_start();

require_once("classes/tabs.class.php");
global $dbF;

$tabs  =   new tabs();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$tabs->tabsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Slider']); ?></h2>
<?php $tabs->tabsEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>