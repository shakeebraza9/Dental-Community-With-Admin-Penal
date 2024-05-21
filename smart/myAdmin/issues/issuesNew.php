<?php
ob_start();

require_once("classes/issues.class.php");
global $dbF;

$issues  =   new issues();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$issues->newIssuesAdd();
?>
<h2 class="sub_heading"><?php echo ($_e['Add New Issues/Event']); ?></h2>
        <?php $issues->issuesNew();  ?>

    <script>
        $(function(){
            dateJqueryUi();
        });
    </script>
<?php return ob_get_clean(); ?>