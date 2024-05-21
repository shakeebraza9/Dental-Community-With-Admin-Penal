<?php

include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 


$msg = "";
$chk1 = $functions->returnWork();
if($chk1){
    $msg = "Retutn Work Form Submit Successfully";
}

$chk2 = $functions->leiuInsert();
if($chk2){
    $msg = "Overtime Request Form Submit Successfully";
}

$chk3 = $functions->leiuUpdate();
if($chk3){
    $msg = "Overtime Request Form Update Successfully";
}

$chk4 = $functions->amendRota();
if($chk4){
    $msg = "Amend Requests Successfully";
}
$chk4 = $functions->documentInsert_profile_detail();
if($chk4){
    $msg = "Appraisal Reminder Document Insert Successfully";
}
include'dashboardheader.php';

$functions->pin();
$display = "";

if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
    $display = 'style="display:none;"';
}
?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side hrm">
             <?php if($msg !=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
          
            <!-- cpd-main-box -->
           
            <!-- cpd-main-box -->
          
            <div class="hr-absence profile">
                <a class="submit_class" href="<?php echo WEB_URL."/hrm" ?>">Back </a>
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#tabs-1"><?php $functions->absentRequestCount(); ?> Absence Requests</a>
                        </li>
                        <li>
                            <a href="#tabs-2"><?php $functions->lieuRequestCount(); ?> Overtime Request</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-3"><?php $functions->absentTodayCount(); ?> Absent Today</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-4"><?php $functions->sickCount(); ?> Sick Today</a>
                        </li>
                        <li <?php echo $display;?>>
                            <a href="#tabs-5"><?php $functions->lateCount(); ?> Late Today</a>
                        </li>
                    </ul>
                    <!-- hr-absence-box -->
                    <div class="hr-absence-hub" id="tabs-1">
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th <?php echo $display;?>>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Leave Hour</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th <?php ?>>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->absentRequest(); ?>
                                </tbody>
                            </table>
                           
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-2">
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th <?php echo $display;?>>Employee</th>
                                        <th>Type</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                        <th <?php echo $display;?>>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->lieuRequest(); ?>
                                </tbody>
                            </table>
                            <button style='display: inline-block;' class='submit_class' onclick='window.open("lieu")'>View All</button>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-3" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $functions->absentToday(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub" id="tabs-4" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $functions->sick(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                    <div class="hr-absence-hub brn" id="tabs-5" <?php echo $display;?>>
                        <div class="hr-absence-hub-tbl">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Checkin</th>
                                        <th>Late</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $functions->late(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- hr-absence-hub-tbl -->
                    </div>
                    <!-- hr-absence-hub -->
                </div>
            </div>
            <!-- hr-absence -->
         
    </div>
    <!-- close -->
</div>
</div>
<!-- right_side close -->
<!-- </div> -->
<!-- left_right_side -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.css">
<script >
  function AjaxDelScript(ths){
             btn=$(ths);
            console.log(btn);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteleave',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
           $(ths).remove();
        });
          }else{
        alert('Invalid ID.');
          }
                   
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
            }
        };


        //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }

</script>
<?php include_once('dashboardfooter.php'); ?>