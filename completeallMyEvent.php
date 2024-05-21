<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

$msg  = "";
// $chk  = $functions->eventsubmit();
// $chk2 = $functions->eventedit();
// $chk3 = $functions->myeventsubmit();
// $chk4 = $functions->myeventedit();
// $chk5 = $functions->myeventdelete();
// $chk6 = $functions->bookingsend();
// $chk7 = $functions->eventeditAll();
// $chk8 = $functions->customlog();
// if($chk){
//     $msg = "Event Submit Successfully";
// }
// else if($chk2){
//     $msg = "Event Edit Successfully";
// }
// else if($chk3){
//     $msg = "Event Add Successfully";
// }
// else if($chk4){
//     $msg = "Event Submit Successfully";
// }
// else if($chk5){
//     $msg = "Event Delete Successfully";
// }
// else if($chk6){
//     $msg = "Booking Successfully";
// }
// else if($chk7){
//     $msg = "All Event Submit Successfully";
// }
// else if($chk8){
//     $msg = "Custom Log Request Successfully Sent";
// }
include'dashboardheader.php'; 

?>
<div class="index_content mypage">
    <div class="left_right_side">
        <!-- left_side close -->
        <div class="right_side">
           
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-12 green_alert alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
          
                

        <h4 class="main-heading_">Completed All My Events.</h4>
               
                <?php if($_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['ccalendar'] == 'edit' || @$_SESSION['superUser']['ccalendar'] == 'full') { 
                    $sql = "SELECT * FROM `userevent` WHERE `due_date` = CURRENT_DATE() AND `due_date` != '' AND `approved`='-1' AND `user`='$_SESSION[currentUser]' AND `title_id` IN (SELECT `id` FROM `eventmanagement` WHERE `recurring_duration` IN ('1 day','1 week'))";
                    $data = $dbF->getRows($sql);
                    if(!empty($data)){
                ?>
               
                <?php }} ?>
                  <div class="col44">
                    <div id="tabs">
                        <ul>
                       
                           
        <li><a href="#tabs-4">Completed</a></li>                       
         <ul class="head_flex">
                            <li class="src-event">
                                <div class="search">
                                    <input type="text" id="src-event"><i class="fas fa-search"></i>
                                </div>
                            </li>
                        </ul>
         <div id="tabs-4">
            <div class="col4_line">
          
                            <!-- col4_line close -->
                            <div class="col4_main">
                                <?php echo $functions->myEventCompleteTitle() ?>
                                <div class="col4_main_left ">
                                    <ul>
                                        <?php echo $functions->myEventCompleteAll() ?>
                                    </ul>
                                </div>
                            </div>

                           

                            <!-- col4_main close -->
                        </div>
                     
                    </div>
                    <!-- tabs close -->
                    <div class="col4_txt_blue">
                        My Uploads
                    </div>
                    <!-- col4_txt_blue close -->
                    <div class="col4_txt_green">
                        Recommended
                    </div>
                    <!-- col4_txt_green close -->
                    <div class="col4_txt_red">
                        Mandatory
                    </div>
                    <!-- col4_txt_red close -->
                </div>
                <!-- col44 close -->
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
         tooltip = '<div class="tooltiptopicevent" style="background-color: ' + data.color + '">title : ' + data.title + '<br>Category : ' + data.category + due +'<br>status : ' + data.status + dsc + '</div>';
         
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
                    echo "<pre>"; 
                echo $functions->calendarEvents();
                    echo "<pre>"; 
            ?>
});
</script>
<?php include_once('dashboardfooter.php'); ?>