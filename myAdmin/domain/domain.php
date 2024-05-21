<?php

ob_start();



require_once("classes/domain.class.php");

global $dbF;

$domain  =   new domain();



//$dbF->prnt($_SESSION);

//$dbF->prnt($_FILES);

//exit;

$domain->domainEditSubmit();

$domain->newdomainAdd();

?>

<h2 class="sub_heading"><?php echo _uc('Manage Courses'); ?></h2>



    <!-- Nav tabs -->

    <ul class="nav nav-tabs tabs_arrow" role="tablist">

        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['View Entries']); ?></a></li>

        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>

        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New']); ?></a></li>

    </ul>





    <!-- Tab panes -->

    <div class="tab-content">

    <?php

?>

        <div class="tab-pane fade in active container-fluid" id="home">

            <h2  class="tab_heading"><?php //echo _uc($_e['Files']); ?></h2>

            <?php $domain->domainView();  ?>

        </div>

         <div class="tab-pane fade in container-fluid" id="draft">

            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>

            <?php $domain->domainDraft();  ?>

        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">

            <h2  class="tab_heading"><?php echo _uc($_e['Add New']); ?></h2>

            <?php $domain->domainNew();  ?>

        </div>

    </div>



<script>

    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    $('#make-switch0').on('change', function() {
        var chk = $('.checkboxHidden').val();
        if(chk=='1'){
            $('.shwunder').slideDown('slow');
        }
        else {
            $('.shwunder').slideUp('slow');
        }
    });

    function deleteDomain(ths){

        btn=$(ths);

        if(secure_delete()){

            btn.addClass('disabled');

            btn.children('.trash').hide();

            btn.children('.waiting').show();



            id=btn.attr('data-id');

            $.ajax({

                type: 'POST',

                url: 'domain/domain_ajax.php?page=deleteDomain',

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