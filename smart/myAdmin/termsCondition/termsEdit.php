<?php
ob_start();

require_once("classes/terms.class.php");
global $dbF;

$terms =   new terms();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$terms->termsEditSubmit();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Terms']); ?></h2>

<?php $terms->termsEdit(); ?>


<script>
    $(function(){
        dateJqueryUi();
    });
    $('#category').click(function(){
        val = $(this).val();
        if(val=='other'){
            $('#categoryOther').slideDown(500).attr('required','true');
        }else{
            $('#categoryOther').slideUp(500).removeAttr('required');
        }
    });

</script>
<?php return ob_get_clean(); ?>