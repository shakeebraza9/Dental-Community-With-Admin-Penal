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



<?php return ob_get_clean(); ?>