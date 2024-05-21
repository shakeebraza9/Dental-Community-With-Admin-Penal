<?php

ob_start();



require_once("classes/question.class.php");

global $dbF;



$question  =   new question();



//$dbF->prnt($_POST);

//$dbF->prnt($_FILES);

//exit;

$question->questionEditSubmit();

?>

<h2 class="sub_heading"><?php echo _uc($_e['Update']); ?></h2>



<?php $question->questionEdit(); ?>

<script type="text/javascript">
	function addMoreOptions(ths){
	    var old_index = parseInt($(ths).data('id'));
	    var new_index = (old_index)+1;

	    $(ths).remove();

	    var ret_html = '  <div class="form-group"><label class="col-sm-2 col-md-3  control-label"></label><div class="col-sm-8  col-md-6"><textarea name="options[]" id="Edsc_' + new_index + '" class="form-control ckeditor" placeholder="Options"></textarea></div><div class="col-sm-2 col-md-3"><input type="radio" name="correct" style="width: 30px;height: 30px;" value="'+new_index+'"></div><div class="col-sm-2 col-md-3"><input type="checkbox" name="del" style="width: 30px;height: 30px;"><a class="btn btn-danger" onclick="del_images()">Delete</a></div></div><input type="button" name="add_more" value="Add More" data-id="'+new_index+'" class="btn btn-lg btn-primary" onclick="addMoreOptions(this)" style="float: right"/> </div>';

	    $('.optionsDiv').append(ret_html);
CKEDITOR.replace( 'Edsc_'+new_index+'' );

	    // console.log(ret_html);
	}

	function del_images(){
   $('input[name=del]:checked').parent().parent().remove();

}

</script>

<?php return ob_get_clean(); ?>