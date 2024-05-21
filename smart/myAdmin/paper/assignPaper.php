<?php

ob_start();



require_once("classes/assignPaper.class.php");

global $dbF;

$assignPaper  =   new assignPaper();



//$dbF->prnt($_SESSION);

//$dbF->prnt($_FILES);

//exit;

$assignPaper->assignEditSubmit();

$assignPaper->newAssignAdd();

?>

<h2 class="sub_heading"><?php //echo _uc($_e['Manage Files']); ?></h2>



    <!-- Nav tabs -->

    <ul class="nav nav-tabs tabs_arrow" role="tablist">

        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['View Entries']); ?></a></li>

        <!-- <li><a href="#draft" role="tab" data-toggle="tab"><?php //echo _uc($_e['Draft']); ?></a></li> -->

        <!-- <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Assign Paper']); ?></a></li> -->

    </ul>





    <!-- Tab panes -->

    <div class="tab-content">

    <?php

?>

        <div class="tab-pane fade in active container-fluid" id="home">

            <h2  class="tab_heading"><?php //echo _uc($_e['Files']); ?></h2>

            <?php $assignPaper->assignView();  ?>

        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">

            <h2  class="tab_heading"><?php echo _uc($_e['Assign Paper']); ?></h2>

            <?php $assignPaper->assignNew();  ?>

        </div>

    </div>



<script>

    $(function(){

        tableHoverClasses();
        dateJqueryUi();

    });



    function deleteAssignment(ths){

        btn=$(ths);

        if(secure_delete()){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            id=btn.attr('data-id');

            $.ajax({

                type: 'POST',

                url: 'paper/paper_ajax.php?page=deleteAssignedPaper',

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





</script>

<?php return ob_get_clean(); ?>