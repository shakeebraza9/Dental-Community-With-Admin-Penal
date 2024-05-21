<?php
ob_start();

require_once("classes/training.class.php");
global $dbF;

$training  =   new training();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$training->trainingEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Training/Document']); ?></h2>
<?php $training->trainingEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });
    
$('#make-switch0').on('change', function() {
var chk = $('.checkboxHidden').val();
if(chk=='1'){
$('#users').show();
$('#users select').attr("name","assignto");
}
else {
$('#users select').removeAttr("name");
$('#users').hide();
}
});
</script>
<?php return ob_get_clean(); ?>