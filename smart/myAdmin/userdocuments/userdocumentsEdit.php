<?php
ob_start();

require_once("classes/userdocuments.class.php");
global $dbF;

$userdocuments  =   new userdocuments();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$userdocuments->userdocumentsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage User Documents']); ?></h2>
<?php $userdocuments->userdocumentsEdit(); ?>

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