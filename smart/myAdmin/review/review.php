<?php
ob_start();

require_once("classes/review.class.php");
global $dbF;

$review  =   new review();

//$dbF->prnt($_POST);
//$dbF->prnt($_FILES);
//exit;
$review->reviewsEditSubmit();
$review->newReviewsAdd();
?>
<h2 class="sub_heading"><?php echo _uc($_e['Manage Reviews']); ?></h2>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php echo _uc($_e['Active Reviews']); ?></a></li>

        <li><a href="#newPage" role="tab" data-toggle="tab"><?php echo _uc($_e['Add New Review']); ?></a></li>
    </ul>


    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active container-fluid" id="home">
            <h2  class="tab_heading"><?php echo _uc($_e['Active Reviews']); ?></h2>
            <?php $review->reviewView();  ?>
        </div>


        <div class="tab-pane fade in container-fluid" id="newPage">
            <h2  class="tab_heading"><?php echo _uc($_e['Add New Review']); ?></h2>
            <?php $review->reviewsNew();  ?>
        </div>
    </div>

<script>
    $(function(){
        tableHoverClasses();
        dateJqueryUi();
    });

    function deleteReview(ths){
        btn=$(ths);
        if(secure_delete()){
            btn.addClass('disabled');
            btn.children('.trash').hide();
            btn.children('.waiting').show();

            id=btn.attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'review/review_ajax.php?page=deleteReview',
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

    // $(document).ready(function() {

    //     $( ".sortDiv .activeSort" ).sortable({
    //         handle: '.albumSortTop',
    //         containment: "parent",
    //         update : function () {
    //             serial = $(this).sortable('serialize');
    //             $.ajax({
    //                 url: 'banners/banner_ajax.php?page=bannersSort',
    //                 type: "post",
    //                 data: serial,
    //                 error: function(){
    //                     jAlertifyAlert("<?php echo ($_e['There is an error, Please Refresh Page and Try Again']); ?>");
    //                 }
    //             });
    //         }
    //     });
    // });


</script>
<?php return ob_get_clean(); ?>