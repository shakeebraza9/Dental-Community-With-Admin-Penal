<?php
ob_start();

require_once("classes/tabsnew.class.php");
global $dbF;

$tabsnew  =   new tabsnew();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$tabsnew->newTabsAdd();
?>
<h2 class="sub_heading"><?php echo ('Add New Tabs'); ?></h2>
        <?php $tabsnew->tabsnewNew();  ?>

    <script>
        $(function(){
            dateJqueryUi();
        });
    </script>
<?php return ob_get_clean(); ?>