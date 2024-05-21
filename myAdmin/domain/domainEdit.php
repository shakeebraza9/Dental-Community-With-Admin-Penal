<?php

ob_start();



require_once("classes/domain.class.php");

global $dbF;



$domain  =   new domain();



// $dbF->prnt($_POST);

//$dbF->prnt($_FILES);

//exit;

$domain->domainEditSubmit();

?>

<h2 class="sub_heading"><?php echo _uc($_e['Update']); ?></h2>



<?php $domain->domainEdit(); ?>

<script>
	$('#make-switch0').on('change', function() {
        var chk = $('.checkboxHidden').val();
        if(chk=='1'){
            $('.shwunder').slideDown('slow');
        }
        else {
            $('.shwunder').slideUp('slow');
        }
    });
</script>

<?php return ob_get_clean(); ?>