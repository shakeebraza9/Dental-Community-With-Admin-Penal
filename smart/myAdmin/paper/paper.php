<?php
ob_start();
require_once("classes/paper.class.php");
global $dbF;
$paper  =   new paper();

//$dbF->prnt($_SESSION);
//$dbF->prnt($_FILES);
//exit;

$paper->paperEditSubmit();
$paper->newpaperAdd();
$allDomain = $paper->getDomains();
$domainOption = '';
foreach ($allDomain as $key => $value) {
    $domainOption .= '<option value="'.$value['subject_id'].'">'.$value['subject_title'].'</option>';
}

?>
<h2 class="sub_heading">
    <?php echo _uc('Manage Papers'); ?>
</h2>
<!-- Nav tabs -->
<ul class="nav nav-tabs tabs_arrow" role="tablist">
    <li class="active"><a href="#home" role="tab" data-toggle="tab">
            <?php echo _uc($_e['View Entries']); ?></a></li>
    <li><a href="#newPage" role="tab" data-toggle="tab">
            <?php echo _uc($_e['Add New']); ?></a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane fade in active container-fluid" id="home">
        <h2 class="tab_heading">
            <?php //echo _uc($_e['Files']); ?>
        </h2>
        <?php $paper->paperView();  ?>
    </div>
    <div class="tab-pane fade in container-fluid" id="newPage">
        <?php $paper->paperNew();  ?>
    </div>
</div>
<script>
    $(function() {

    tableHoverClasses();

    dateJqueryUi();

});

function deletePaper(ths) {

    btn = $(ths);

    if (secure_delete()) {

        btn.addClass('disabled');

        btn.children('.trash').hide();

        btn.children('.waiting').show();

        id = btn.attr('data-id');

        $.ajax({

            type: 'POST',

            url: 'paper/paper_ajax.php?page=deletePaper',

            data: {
                id: id
            }

        }).done(function(data)

            {

                ift = true;

                if (data == '1') {

                    ift = false;

                    btn.closest('tr').hide(1000, function() {
                        $(this).remove()
                    });

                } else if (data == '0') {

                    jAlertifyAlert('<?php echo _js("Delete Fail Please Try Again."); ?>');

                } else {

                    btn.append(data);

                }

                if (ift) {

                    btn.removeClass('disabled');

                    btn.children('.trash').show();

                    btn.children('.waiting').hide();

                }

            });

    }

}

function addDomainQuestions(ths) {

    dataArray = Array();

    $('.domain').each(function(index, el) {

        if ($(this).val() != null) {


            console.log($(this).val());

            domainId = $(this).val();

            questionLimit = $('#perDomain_' + index).val();

            pushVal = domainId + '|' + questionLimit;

            if ($.inArray(pushVal, dataArray) === -1) dataArray.push(pushVal);

            // dataArray.push(pushVal);

        }

    });

    if (dataArray.length > 0) {

        $.ajax({

            url: 'paper/paper_ajax.php?page=getQuestions',

            type: 'post',

            data: {
                dataArray: dataArray
            }

        }).done(function(res) {

            $('.chooseQuestions').html(res);

            $('.chooseQuestions').focus();

            // displayPopup();

        });

    } else {

        alert('Select Course First!');

    }

}

$(document).ready(function() {

    $('.questionCheck').click(function() {

        console.log('dsadsa');

        console.log($(this).val());

    });

});

function countQuestions(ths) {

    domain_id = $(ths).data('id');

      // limitQuest = $(ths).data('limit');
       limitQuest =  $(".questionCheck").attr('data-limit');
       console.log(limitQuest+"limitQuest");
       

    questionCount = $('.limitDomain_' + domain_id + ':checked').length;

    console.log('questionCount : ' + questionCount + ' | limitQuest : ' + limitQuest);
          
      if (questionCount < limitQuest ) {
         $('#paperSubmit').attr('disabled','disabled');
         }

        if (questionCount == limitQuest ) {
        $('#paperSubmit').removeAttr('disabled');
        }




    if (questionCount > limitQuest) {

        event.preventDefault();

        alert('Question(s) Exceeded Limit');

    }

}

$(document).ready(function() {
    $('#paperSubmit').on('click', function() {
        quest_count = $('.questionCheck:checked').length;
        total_quest = $('.totalQuestions').text();
        total_quest = parseInt(total_quest);

        console.log('quest_count : ' + quest_count + ' | total_quest : ' + total_quest);

        if (quest_count < total_quest) {
            event.preventDefault();
            alert('Selected Question(s) Less Than Limit');

        } else {
            $('#paperForm').submit();
        }
    });
});

$(document).ready(function(){  


  $( ".perDomain" ).on( "change", function() {
      var val1 = $(this).val();  
      console.log(val1);
        $(".questionCheck").attr('data-limit', val1);
        $(".totalQuestions").attr('value', val1);
        $(".totalQuestions").text(val1);
     quest_count = $('.questionCheck:checked').length;
            
     if (quest_count != val1 ) {
        $('#paperSubmit').attr('disabled','disabled');
     }
     if (quest_count  == val1) {
        $('#paperSubmit').removeAttr('disabled');
     }

    });  

   // $(".perDomain").keyup(function(){  
   //  var val2 =   $(this).val();
   //  console.log(val2);
   //  $(".questionCheck").attr('data-limit', val2);
    // $(".totalQuestions").attr('value', val2);
    // $(".totalQuestions").text(val2);
    // quest_count = $('.questionCheck:checked').length;
            
    //  if (quest_count != val2 ) {
    //      $('#paperSubmit').attr('disabled','disabled');
    //  }else{
    //      $('#paperSubmit').removeAttr('disabled');
    //  }

   // });  
}); 


</script>
<style type="text/css">
.total_div {

    font-size: 25px;

    font-weight: 600;

    right: 15px;

    top: 10px;

    position: absolute;

}



.questionCheck {

    margin-right: 10px !important;

}



.mainHeading {

    text-align: center;

    padding-top: 20px;

}



.chooseQuestions {

    background-color: #eae9e9;

    margin-bottom: 20px;

}



.questionsMainDiv {

    padding: 20px;

}



.singleDomain {

    background-color: #f1f1f1;

    padding: 10px;

    margin-bottom: 10px;

}
</style>
<?php return ob_get_clean(); ?>