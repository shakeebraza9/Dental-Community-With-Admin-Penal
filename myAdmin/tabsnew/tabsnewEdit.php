<?php
ob_start();

require_once("classes/tabsnew.class.php");
global $dbF;

$tabsnew  =   new tabsnew();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$tabsnew->tabsnewEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Tabs']); ?></h2>

            <?php $tabsnew->tabsnewEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>