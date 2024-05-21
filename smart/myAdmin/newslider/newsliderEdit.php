<?php
ob_start();

require_once("classes/newslider.class.php");
global $dbF;

$brands  =   new newslider();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$brands->newsliderEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Slider']); ?></h2>
<?php $brands->newsliderEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>