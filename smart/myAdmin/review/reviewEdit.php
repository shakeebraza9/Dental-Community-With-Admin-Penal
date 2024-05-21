<?php
ob_start();

require_once("classes/review.class.php");
global $dbF;

$review  =   new review();

$review->reviewsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Reviews']); ?></h2>
<?php $review->reviewsEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<?php return ob_get_clean(); ?>