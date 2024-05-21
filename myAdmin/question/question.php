<?php

ob_start();



require_once("classes/question.class.php");

global $dbF;

$question  =   new question();



//$dbF->prnt($_SESSION);

//$dbF->prnt($_FILES);

//exit;

$question->questionEditSubmit();

$question->newquestionAdd();

?>

<h2 class="sub_heading"><?php //echo _uc($_e['Manage Files']); ?></h2>



    <!-- Nav tabs -->

    <ul class="nav nav-tabs tabs_arrow" role="tablist">

        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['View Entries']); ?></a></li>

        <!-- <li><a href="#draft" role="tab" data-toggle="tab"><?php //echo _uc($_e['Draft']); ?></a></li> -->

        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New']); ?></a></li>

    </ul>





    <!-- Tab panes -->

    <div class="tab-content">

    <?php

?>

        <div class="tab-pane fade in active container-fluid" id="home">

            <h2  class="tab_heading"><?php //echo _uc($_e['Files']); ?></h2>

            <?php $question->questionView();  ?>

        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">

            <h2  class="tab_heading"><?php echo _uc($_e['Add New']); ?></h2>

            <?php $question->questionNew();  ?>

        </div>

    </div>



<script>

    $(function(){

        tableHoverClasses();
        dateJqueryUi();

    });



    function deleteQuestion(ths){

        btn=$(ths);

        if(secure_delete()){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            id=btn.attr('data-id');

            $.ajax({

                type: 'POST',

                url: 'question/question_ajax.php?page=deleteQuestion',

                data: { id:id }

            }).done(function(data)

                {

                    ift =true;

                    if(data=='1'){

                        ift = false;

                        btn.closest('tr').hide(1000,function(){$(this).remove()});

                    }

                    else if(data=='0'){

                        jAlertifyAlert('<?php echo _js($_e['Delete Fail Please Try Again.']); ?>');

                    }

                    else{

                        btn.append(data);

                    }

                    if(ift){

                        btn.removeClass('disabled');

                        btn.children('.trash').show();

                        btn.children('.waiting').hide();

                    }



                });

        }

    }


function addMoreOptions(ths){
    var old_index = parseInt($(ths).data('id'));
    var new_index = (old_index)+1;
    correctIndex  = new_index+1;

    $(ths).remove();

    var ret_html = '  <div class="form-group"><label class="col-sm-2 col-md-3  control-label"></label><div class="col-sm-8  col-md-6"><textarea name="options[]" id="Edsc_' + new_index + '" class="form-control ckeditor" placeholder="Options"></textarea></div><div class="col-sm-2 col-md-3"><input type="radio" name="correct" style="width: 30px;height: 30px;" value="'+correctIndex+'"></div><div class="col-sm-2 col-md-3"><input type="checkbox" name="del" style="width: 30px;height: 30px;" value="'+correctIndex+'">    <a class="btn btn-danger" onclick="del_images()" >Delete</a></div></div><input type="button" name="add_more" value="Add More" data-id="'+new_index+'" class="btn btn-lg btn-primary" onclick="addMoreOptions(this)" style="float: right"/> </div>';





    $('.optionsDiv').append(ret_html);
CKEDITOR.replace( 'Edsc_'+new_index+'' );

    console.log(ret_html);
}

function del_images(){
   $('input[name=del]:checked').parent().parent().remove();

}

</script>

<?php return ob_get_clean(); ?>