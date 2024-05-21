<?php
ob_start();

require_once("classes/webinar.class.php");
global $dbF;

$webinar  =   new webinar();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$webinar->webinarEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Webinar']); ?></h2>

            <?php $webinar->webinarEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>