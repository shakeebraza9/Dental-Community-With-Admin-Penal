<?php
ob_start();

require_once("classes/reports.class.php");
global $dbF;

$reports  =   new reports();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
// $reports->newreportsAdd();
?>
<h2 class="sub_heading"><?php echo ($_e['Add New reports/Event']); ?></h2>
        <?php //$reports->reportsNew();  ?>

 <!--    <script>
        $(function(){
            dateJqueryUi();
        });
    </script> -->
<?php return ob_get_clean(); ?>