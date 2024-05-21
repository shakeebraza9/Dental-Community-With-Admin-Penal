<?php
ob_start();

require_once("classes/webinar.class.php");
global $dbF;

$webinar  =   new webinar();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;

$webinar->newWebinarAdd();

?>
<h2 class="sub_heading"><?php echo ($_e['Add New Webinar']); ?></h2>
        <?php $webinar->webinarNew();  ?>

    <script>
        $(function(){
            dateJqueryUi();
        });
    </script>
<?php return ob_get_clean(); ?>