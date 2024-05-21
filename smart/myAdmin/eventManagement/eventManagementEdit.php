<?php
ob_start();

require_once("classes/eventManagement.class.php");
global $dbF;

$eventManagement  =   new eventManagement();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$eventManagement->eventManagementEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Event']); ?></h2>
<?php $eventManagement->eventManagementEdit(); ?>

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

$('.recurring_duration').on('change',function(){
var chk = $(this).val();
if(chk == 'Once' || chk == 'Once Check'){
    $('.rd').show(100);
}
else{
    $('.rd').hide(100);
    $('.rd select').val('').change();
}
});
</script>
<?php return ob_get_clean(); ?>