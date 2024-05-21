<?php 
ini_set('display_errors', 0);
error_reporting(E_ALL);
include_once("global.php");

global $dbF,$webClass;

$login = $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

$msg  = "";
$chk  = $functions->leaveInsert();
$chk2 = $functions->leaveEdit();
$chk3  = $functions->employeeleaveInsert();
if($chk){
    $msg = "Leave Add Successfully";
}
else if($chk2){
    $msg = "Leave Update Successfully";
}
else if($chk3){
    $msg = "Employee Leave Inserted Successfully";
}

include'dashboardheader.php';

$display = "";
$displayblock = 'style="display:none;"';
 
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){
    $display = 'style="display:none;"';
    $displayblock = 'style="display:block;"';


    
}

?>
<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <div class="right_side">
            <!--<div class="right_side_top">-->
                
            <!--</div>-->
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-12 green_alert alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="calendar">
                <h3 class="main-heading_">Employee Leave Calender</h3>
                <!--<h4 class="c4">&nbsp;</h4>-->
                <a href="javascript:;" <?php echo $display;?>  onclick="employeeleaveform()" class="myevents" title="My Events"><i class="fas fa-plus"></i> <span>Add Leave</span></a>
                <a href="javascript:;" <?php echo $displayblock;?> onclick="leaves()" class="myevents" title="My Events"><i class="fas fa-plus"></i> <span>Add Leave</span></a>
                <!-- myevents -->
                <br>
                <div id='calendar'></div>
                <div class="col44">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-3">Leave Pending<span>
                                <?php echo $functions->countPending() ?></span></a></li>
                            <li><a href="#tabs-1">Leave Accepted <span>
                                <?php echo $functions->countAccepted() ?></span></a></li>
                            <li><a href="#tabs-2">Leave Rejected<span>
                                <?php echo $functions->countRejected() ?></span></a></li>
                            
                            <li <?php echo $display;?>><a href="#tabs-4">Added Leave<span>
                                <?php echo $functions->countAdded() ?></span></a></li>
                            <li class="src-event"><input type="text" id="src-event"><i class="fas fa-search"></i></li>
                        </ul>
                        <div id="tabs-1">
                            <div class="col4_main">
                                <div class="col4_main_left">
                                    <ul>
                                        <?php echo $functions->leaveAccepted() ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- col4_main close -->
                        </div>
                        <div id="tabs-2">
                            <div class="col4_main">
                                <div class="col4_main_left">
                                    <ul>
                                        <?php echo $functions->leaveRejected() ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- col4_main close -->
                        </div>
                        <div id="tabs-3">
                            <div class="col4_main">
                                <div class="col4_main_left">
                                    <ul>
                                        <?php echo $functions->leavePending() ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- col4_main close -->
                        </div>
                        <div id="tabs-4" <?php echo $display;?>>
                            <div class="col4_main">
                                <div class="col4_main_left">
                                    <ul>
                                        <?php echo $functions->leaveAdded() ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- col4_main close -->
                        </div>
                    </div>
                    <!-- tabs close -->
                    <div class="col4_txt_green">
                        Accepted
                    </div>
                    <!-- col4_txt_green close -->
                    <div class="col4_txt_red">
                        Rejected
                    </div>
                    <!-- col4_txt_red close -->
                    <div class="col4_txt_blue">
                        Pending
                    </div>
                    <!-- col4_txt_blue close -->
                </div>
                <!-- col44 close -->
            </div>
            <!-- calendar -->
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.js"></script>
<script>
$('#calendar').fullCalendar({
    header: {
        theme: true,
        left: 'prev,title,next ',
        center: '',
        right: 'month,basicWeek,basicDay,today'
    },
    eventMouseover: function(data, event) {
        
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">title : ' + data.title + '<br>From : ' + data.fdate + '<br>To : ' + data.tdate + '<br>type : ' + data.type + '<br>Status : ' + data.status + '</div>';
       
       if (data.sqltype == 'LEAVES') 
       {
      

        tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Name : ' + data.n_name +'<br>From : ' + data.fdate + '<br>To : ' + data.tdate + '<br>type : ' + data.type + '<br>Status : ' + data.status + '</div>';
        
         tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>Name :</span>  ${data.n_name} <br><span>From :</span>  ${data.fdate} <br><span>To :</span>   ${data.tdate}<br><span>Status :</span>   ${data.status}   </div></div>`;
       }
       if (data.sqltype == 'HOLIDAY') 
      {
       
        // tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">Title : ' + data.title +'<br>Reason : ' + data.reason +'<br>Date : ' + data.start + '</div>';
        
         tooltip = `<div class="tooltiptopicevent" style="border-bottom:15px solid  ${data.color} "><div><div class="arrow"><div style="position:relative">
         <div class="outer"></div><div class="inner"></div></div>
  </div><span>title :</span>  ${data.title} <br><span>Reason :</span>  ${data.reason} <br><span>Date :</span>   ${data.start}   </div></div>`;
      }  
        

        $("body").append(tooltip);
        $(this).mouseover(function(e) {
            $('.tooltiptopicevent').fadeIn('500');
            $('.tooltiptopicevent').fadeTo('10', 1.9);
        }).mousemove(function(e) {
            $('.tooltiptopicevent').css('top', e.pageY + 10);
            $('.tooltiptopicevent').css('left', e.pageX + 20);
        });

    },
    eventMouseout: function(data, event) {
        $(this).css('z-index', 8);
        $('.tooltiptopicevent').remove();

    },
    editable: false,
    eventLimit: true, // allow "more" link when too many events
    eventRender: function(event, element) {
        element.attr('id', event.id);
        element.attr('onclick', event.click);
        element.attr('data-type', event.type);
    },
    events: <?php 
                echo $functions->leavesCalendar();
            ?>
});



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
        $(ths).closest('li').css('background','e5f3f2');
        $(ths).closest('li').fadeOut(800,function(){
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