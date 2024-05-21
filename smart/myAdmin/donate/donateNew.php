<?php
ob_start();

require_once("classes/donate.class.php");
global $dbF;

$donate  =   new donate();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$donate->newNewsAdd();
?>
<h2 class="sub_heading"><?php echo ($_e['Add New News/Event']); ?></h2>
        <?php $donate->donateNew();  ?>

    <script>
        $(function(){
            dateJqueryUi();
        });
    </script>
<?php return ob_get_clean(); ?>