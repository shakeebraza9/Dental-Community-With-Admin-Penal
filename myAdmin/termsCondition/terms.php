<?php
ob_start();

require_once("classes/terms.class.php");
global $dbF;

$terms  =   new terms();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;

$terms->termsEditSubmit();
$terms->newTermsAdd();

?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Terms']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Terms']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft Terms']); ?></a></li>
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Terms']); ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Terms']); ?></h2>
            <?php $terms->termsView();  ?>
        </div>


        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft Terms']); ?></h2>
            <?php $terms->termsDraft();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Terms']); ?></h2>
            <?php $terms->termsNew();  ?>
        </div>
    </div>

<script>
      $(function(){
        tableHoverClasses();
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

    function deleteTerms(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'termsCondition/terms_ajax.php?page=deleteTerms',
                data: { id:id }
            }).done(function(data)
                {
                    ift =true;
                    if(data=='1'){
                        ift = false;
                        btn.closest('tr').hide(1000,function(){$(this).remove()});
                    }
                    else if(data=='0'){
                        jAlertifyAlert('<?php echo ($_e['Delete Fail Please Try Again.']); ?>');
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