<?php



ob_start();







require_once("classes/paper.class.php");



global $dbF;







$paper  =   new paper();







//$dbF->prnt($_POST);



//$dbF->prnt($_FILES);



//exit;



$paper->paperEditSubmit();



$allDomain = $paper->getDomains();



$domainOption = '';

foreach ($allDomain as $key => $value) {

    $domainOption .= '<option value="'.$value['subject_id'].'">'.$value['subject_title'].'</option>';

}



?>



<h2 class="sub_heading"><?php echo _uc($_e['Update']); ?></h2>







<?php $paper->paperEdit(); ?>



<script type="text/javascript">

	function addMorePaperDomains(ths){

	    old_index = parseInt($(ths).data('id'));

	    new_index = (old_index);



	    $(ths).remove();



	    domainOption = '<?php echo $domainOption; ?>';



	    var ret_html = '<div class="form-group">'+

	                        '<label class="col-sm-2 col-md-3  control-label"><a data-id="'+new_index+'" onclick="addDomainQuestionsEdit(this)"><i class="fa fa-plus-square fa-2x"></i></a></label>'+

	                        '<div class="col-sm-8  col-md-6">'+

	                            '<select class="form-control domain" name="domain[]" id="domain_'+new_index+'" required>'+

	                                '<option selected disabled>-- Select Subject --</option>'+

	                                domainOption+

	                            '</select>'+

	                        '</div>'+

	                        '<div class="col-sm-2 col-md-3">'+

	                            '<input type="number" class="form-control perDomain" data-index="'+new_index+'" id="perDomain_'+new_index+'" value="" name="perDomain[]" placeholder="Questions Per Domain" onkeyup="getTotalQuestions()" >'+

	                        '</div>'+

	                    '</div>'+

	                    '<input type="button" name="add_more" value="Add More" data-id="'+new_index+'" class="btn btn-lg btn-primary" onclick="addMorePaperDomains(this)" style="float: right"/> </div>'    

	                    ;



	    $('.moreDomains').append(ret_html);



	}


	function getTotalQuestions(){

	    total_quest = 0;

	    $('.perDomain').each(function(index, el) {

	        single_val = parseInt($(this).val());

	        cur_index = $(this).data('index');

	        if(index == cur_index){

	        	index1 = index+1;

	        	$('.limitDomain_'+index1).attr('data-limit', single_val);

	        	console.log(index1+' | '+single_val);

	        }

	        

        	console.log(index+' | '+single_val);

	        total_quest += single_val;

	        

	    });

	    $('#totalQuest').val(total_quest);

	    $('.totalQuestions').html(total_quest);

	}



	function addDomainQuestionsEdit(ths){



	    dataArray = Array();



	    index = $(ths).data('id');



	    domainId = $('#domain_'+index).val();

	    questionLimit = $('#perDomain_'+index).val();



	    pushVal = domainId+'|'+questionLimit;

	    if($.inArray(pushVal, dataArray) === -1) dataArray.push(pushVal);



	    if(dataArray.length > 0){

	        $.ajax({

	            url : 'paper/paper_ajax.php?page=getQuestions',

	            type : 'post',

	            data : {dataArray : dataArray, edit : '1'}

	        }).done(function(res){

	            $('.chooseQuestionsEdit').append(res);

	            $('.chooseQuestionsEdit').focus();

	            // displayPopup();

	        }); 

	    }else{

	        alert('Select Domain(s) First!');

	    }

	    

	}



	$(document).ready(function(){

	    $('.questionCheck').click(function(){

	        console.log('dsadsa');

	        console.log($(this).val());

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
    //  	$('#paperSubmit').attr('disabled','disabled');
    //  }else{
    //  	$('#paperSubmit').removeAttr('disabled');
    //  }

   // });  
}); 

	function countQuestions(ths){

	    domain_id = $(ths).data('id');
        
	     // limitQuest = $(ths).data('limit');
	     limitQuest =  $(".questionCheck").attr('data-limit');
	     console.log(limitQuest+"aaaaaaaaaaaaalimitQuest");
	   
         


        // if (limitQuest == '') 
        // {
        // 	console.log("sssss");
        // 	questionCount = $('.limitDomain_'+domain_id+':checked').length;
        // 	///$(ths).attr("data-limit").val(questionCount);
        // 	limitQuest = $(ths).data('limit').val(questionCount);
        // }

	    questionCount = $('.limitDomain_'+domain_id+':checked').length;
   
	     console.log('questionCount : '+questionCount+' | limitQuest : '+limitQuest);
        
        
         if (questionCount < limitQuest ) {
     	 $('#paperSubmit').attr('disabled','disabled');
         }

        if (questionCount == limitQuest ) {
     	$('#paperSubmit').removeAttr('disabled');
        }

	    if(questionCount > limitQuest){

	        event.preventDefault();

	        // alert('Please Set Number of Question');
	        alert('Question(s) Exceeded Limit');

	    }  

	}


	$(document).ready(function(){
		$('#paperSubmit').on('click', function(){
			quest_count = $('.questionCheck:checked').length;
			// total_quest = $('.totalQuestions').text();
			total_quest = $('.totalQuestions').val();
            
			total_quest = parseInt(total_quest);
            
			if(quest_count < total_quest){
				event.preventDefault();
				alert('Selected Question(s) Less Than Limit');
			}else{
				console.log('quest_count : '+quest_count+' | total_quest : '+total_quest+' | form : '+$('#paperForm').serialize());
				// $('#paperForm').submit();
			}
		});
	});


</script>



<style type="text/css">

    .total_div{

        font-size: 25px;

        font-weight: 600;

        right: 15px;

        top: 7%;

        position: absolute;

    }



    .questionCheck{

        margin-right: 10px !important;

    }



    .mainHeading{

        text-align: center;

        padding-top: 20px;

    }



    .chooseQuestions{

        background-color: #eae9e9;

        margin-bottom: 20px;

        margin-top: 80px;

    }



    .questionsMainDiv{

        padding: 20px;

    }

    

    .singleDomain{

        background-color: #f1f1f1;

        padding: 10px;

        margin-bottom: 10px;

    }

</style>



<?php return ob_get_clean(); ?>