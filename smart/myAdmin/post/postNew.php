<?php
ob_start();

require_once("classes/post.class.php");
global $dbF;

$Post  =   new Post();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$Post->newNewsAdd();
?>
<h2 class="sub_heading"><?php echo ($_e['Add New Post']); ?></h2>
        <?php $Post->newsNew();  ?>

    <script>
        $(function(){
            dateJqueryUi();
        });
    </script>
<?php return ob_get_clean(); ?>