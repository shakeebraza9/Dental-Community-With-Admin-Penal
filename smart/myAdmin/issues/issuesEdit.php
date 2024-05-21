<?php
ob_start();

require_once("classes/issues.class.php");
global $dbF;

$issues  =   new issues();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$issues->issuesEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Issues']); ?></h2>

            <?php $issues->issuesEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });
    

</script>
<?php return ob_get_clean(); ?>