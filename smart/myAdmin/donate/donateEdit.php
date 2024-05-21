<?php
ob_start();

require_once("classes/donate.class.php");
global $dbF;

$donate  =   new donate();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$donate->donateEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage News']); ?></h2>

            <?php $donate->donateEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>