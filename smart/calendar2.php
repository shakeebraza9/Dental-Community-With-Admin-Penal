<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

$msg  = "";
$chk  = $functions->eventsubmit();
$chk2 = $functions->eventedit();
$redoEvent = $functions->redoEvent();
$chk3 = $functions->myeventsubmit();
$chk4 = $functions->myeventedit();
$chk5 = $functions->myeventdelete();
$chk6 = $functions->bookingsend();
$chk7 = $functions->eventeditAll();
$chk8 = $functions->customlog();
$myeventsSubmit = $functions->myeventsSubmit();
// if($chk){
//     $msg = "Event Submit Successfully";
// }
if($chk){
    $msg = "Event Submit Successfully";
}else if($myeventsSubmit){
    $msg = "Event Submit Successfully";
}
else if($chk2){
    $msg = "Event Edit Successfully";
}else if($redoEvent){
    $msg = "Event Edit Successfully";
}
else if($chk3){
    $msg = "New Custom Event Added Successfully";
}
else if($chk4){
    $msg = "Event Submit Successfully";
}
else if($chk5){
    $msg = "Event Delete Successfully";
}
else if($chk6){
    $msg = "Booking Successfully";
}
else if($chk7){
    $msg = "All Event Submit Successfully";
}
else if($chk8){
    $msg = "Custom Log Request Successfully Sent";
}

include'dashboardheader.php'; 

?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Calendar
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'calendar'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                $functions->changeSession();
                $data = $functions->health_check($_SESSION['currentUser']);
                if($data && $_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['health_form'] == 'read' || @$_SESSION['superUser']['health_form'] == 'edit' || @$_SESSION['superUser']['health_form'] == 'full')
                { ?>
                <div class="col1_btnn">
                    <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                </div>
                <?php } ?>
                </div>
                <!-- change-session -->






                      <div data-toggle="tooltip" title="Help Video" class="help" onclick="video('EJUtPIhK-Bg')"><i class="fa fa-question-circle"></i></div>


                      
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
           <!--  <a style="" href="<?php echo WEB_URL; ?>/action-plan" class=""><i class="fas fa-plus"></i> <span>Action Plan</span></a>
            <div class="calendar"> -->
                

                <h4 class="c4">Upload your compliance activities, by simply clicking on the task created for the allocated day.</h4>
                <a href="javascript:;" onclick="myevents()" class="myevents"><i class="fas fa-plus"></i> <span>Add Events</span></a>
              
                <?php if($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['ccalendar'] == 'edit' || @$_SESSION['superUser']['ccalendar'] == 'full')  {?>

                

            <!--     <a style="position: absolute;right: 180px;" href="javascript:;" onclick="customlog()" class="myevents"><i class="fas fa-plus"></i> <span>Custom Log</span></a> -->
                <!-- myevents -->

                <?php } ?>

                
                <div id='calendar'></div>
                <?php if($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['ccalendar'] == 'edit' || @$_SESSION['superUser']['ccalendar'] == 'full') { 
                    $sql = "SELECT * FROM `userevent` WHERE `due_date` = CURRENT_DATE() AND `due_date` != '' AND `approved`='-1' AND `user`='$_SESSION[currentUser]' AND `title_id` IN (SELECT `id` FROM `eventmanagement` WHERE `recurring_duration` IN ('1 day','1 week'))";
                    $data = $dbF->getRows($sql);
                    if(!empty($data)){
                ?>
                <button class="submit_class" type="button" onclick="eventsAll()" style="height:auto;">Submit all events (Daily/Weekly)</button>
                <?php }} ?>
                
            </div>
            <!-- calendar -->
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.js"></script>
<script>
$('#calendar').fullCalendar({
    header: {
        theme: true,
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
    },
    eventMouseover: function(data, event) {
        if (data.description == "" || data.description == null) {
            dsc = "";
        } else {
            dsc = '<br>description : ' + data.description;
        }
        if (data.due_date == "" || data.due_date == null) {
            due = "";
        } else {
            due = '<br>Due Date : ' + data.due_date;
        }
        if(data.start == "" || data.start == null){
            start = "";
        }
        else{
            var startDate = new Date(data.start);
            var dateStart = new Date(startDate.getTime() - (startDate.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];
            start = '<br>Start Date : ' + dateStart;
        }
        if(data.end == "" || data.end == null){
            end = "";
        }
        else{
            var endDate = new Date(data.end);
            endDate.setDate(endDate.getDate()-1);
            var dateEnd = new Date(endDate.getTime() - (endDate.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];
            end = '<br>End Date : ' + dateEnd;
        }
        
         tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">title : ' + data.title + '<br>Category : ' + data.category + due +'<br>status : ' + data.status + dsc + start + end + '</div>';
         
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
                    // echo "<pre>"; 
                echo $functions->calendarEvents222();
                   // echo "<pre>"; 
            ?>
});
</script>
<script>

        function EditEventFileTrash(indx,ths){
            btn=$('.DelScript'+indx);
            console.log(indx);
            console.log(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=EditEventFileTrash',   
                    data: { indx:indx,ths:ths}
                }).done(function(data)
                {
                 ift =true;
                        console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(btn).closest('div').css('background','e5f3f2');
        $(btn).closest('div').fadeOut(800,function(){
           $(btn).remove();
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
<?php include_once('footer.php'); ?>