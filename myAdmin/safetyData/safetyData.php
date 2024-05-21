<?php
ob_start();

require_once("classes/safetyData.class.php");
global $dbF;

$safetyData  =   new safetyData();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$safetyData->safetyDataEditSubmit();
$safetyData->newsafetyDataAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Files']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Files']); ?></a></li>
        <li><a href="#draft" role="tab" data-toggle="tab"><?php echo _uc($_e['Draft']); ?></a></li>
        <!-- <li><a href="#sort" role="tab" data-toggle="tab"><?php echo _uc($_e['Sort Files']); ?></a></li> -->
        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New File']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Files']); ?></h2>
            <?php $safetyData->safetyDataView();  ?>
        </div>

        <div class="tab-pane fade in container-fluid" id="draft">
            <h2  class="tab_heading"><?php echo _uc($_e['Draft']); ?></h2>
            <?php $safetyData->safetyDataDraft();  ?>
        </div>

        <!-- <div class="tab-pane fade in container-fluid" id="sort">
            <h2  class="tab_heading"><?php echo _uc($_e['Sort Files']); ?></h2>
            <?php $safetyData->safetyDataSort();  ?>
        </div> -->

        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New File']); ?></h2>
            <?php $safetyData->safetyDataNew();  ?>
        </div>
    </div>

<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteSafetyData(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'safetyData/safetyData_ajax.php?page=deleteSafetyData',
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

    $(document).ready(function() {

        $( ".sortDiv .activeSort" ).sortable({
            handle: '.albumSortTop',
            containment: "parent",
            update : function () {
                serial = $(this).sortable('serialize');
                $.ajax({
                    url: 'safetyData/safetyData_ajax.php?page=safetyDataSort',
                    type: "post",
                    data: serial,
                    error: function(){
                        jAlertifyAlert("<?php echo ($_e['There is an error, Please Refresh Page and Try Again']); ?>");
                    }
                });
            }
        });
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
 

// ====================================
  $(document).ready(function() {
 $('#make-switch1').on('switch-change', function (e, data) {
            console.log(data.value);
        if(data.value  == false ){
        console.log("bad");
        $('.layer1').attr("name","file");
        $(".ly1").show();
        $(".ly0").hide();
        $(".ly3").hide();
        $('.layer0').removeAttr("name");
      }
      else
      {

        console.log("good");
        $(".ly0").show();
        $(".ly3").show();
        $(".ly1").hide();
        $('.ly0 .layer0').attr("name","file");
       $('.ly1 .layer1').removeAttr("name");


        
      }
           
               });  

      
    });
</script>
<?php return ob_get_clean(); ?>