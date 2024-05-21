<?php
ob_start();

require_once("classes/post.class.php");
global $dbF;

$post  =   new Post();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$post->PostEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Post']); ?></h2>

            <?php $post->PostEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>