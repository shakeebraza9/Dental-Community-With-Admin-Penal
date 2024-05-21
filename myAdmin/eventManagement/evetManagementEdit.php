<?php
ob_start();

require_once("classes/fileManager.class.php");
global $dbF;

$filesManager  =   new filesManager();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$filesManager->filesManagerEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Files']); ?></h2>
<?php $filesManager->filesManagerEdit(); ?>

<script>
    $(function(){
        dateJqueryUi();
    });

</script>
<script type="text/javascript">
$('#make-switch00').on('change', function() {
    console.log("knih");
var chk = $('.checkboxHidden').val();
console.log(chk);
if(chk=='1'){
$('#pro').hide(); 
$('#web').show(); 
}
else {
$('#web').hide(); 
$('#pro').show(); 
}
})
</script>
<?php return ob_get_clean(); ?>