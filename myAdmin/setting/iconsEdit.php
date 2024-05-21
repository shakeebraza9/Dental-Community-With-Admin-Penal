<?php
ob_start();

require_once("classes/icons.class.php");
global $dbF;

$icons  =   new icons();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$icons->iconsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Icons']); ?></h2>
<?php $icons->iconsEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>