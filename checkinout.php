<?php 
include("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}


// include_once('header.php');

if($_GET['type'] == 'checkin_rota_not'){
    // $types = 'checkin rota not';
    $types = 'Check In Without Rota';
    $time = 'Time In';
    $token = 'checkin_rota_not';
}
if($_GET['type'] == 'lunch_time_checkin'){
    $types = 'Lunch Time Checkin';
    $time = 'Time In';
    $token = 'lunch_time_checkin';
}
if($_GET['type'] == 'lunch_time_checkout'){
    $types = 'Lunch Time Checkout';
    $time = 'Time Out';
    $token = 'lunch_time_checkout';
}
if($_GET['type'] == 'checkin'){
    $types = 'Check In';
    $time = 'Time In';
    $token = 'checkin';
}
if($_GET['type'] == 'checkout') {
    $types = 'Check Out';
    $time = 'Time Out';
    $token = 'checkout';
}
if ($_GET['type'] == 'checkoutForget') {
   
   $types = 'Check Out';
    $time = '';
    $token = 'checkoutForget';  
}

include_once'dashboardheader.php';

?>
<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            <?php echo $types; ?>
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'hrm'; ?>
        </div>
        <!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    $functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
            </div>
            <?php
            if($token=="checkin_rota_not"){
             echo '<h3 class="main-heading_">Check In</h3> ';
            }elseif($token=="checkout"){
              echo '<h3 class="main-heading_">Check Out</h3> ';  
            }elseif($token=="lunch_time_checkin"){
              echo '<h3 class="main-heading_">Lunch Time-In</h3> ';  
            }elseif($token=="lunch_time_checkout"){
              echo '<h3 class="main-heading_">Lunch Time-Out</h3> ';  
            }else{
                echo '<h3 class="main-heading_"></h3> ';
            }
            
            ?>
            <!-- right_side_top close -->
            <div class="profile rota"> 
            <!--main_dashboard-->
            <form method="post" enctype="multipart/form-data" id = "checkinout">
                    <div class="checkin-phone">
                    <?php echo $functions->setFormToken($token,false); ?>
                    <input name="shift" type="hidden" value="<?php echo @$_GET['shift'] ?>">
                     <input name="type" type="hidden" value="<?php echo $token ?>">
                    <?php 
                    if($_SESSION['webUser']['account_type'] == 'Employee'){ ?>
                    <input name="time" type="hidden" value="<?php echo date('H:i')?>">
                    
                    
                    
                <!--<form method="post"  enctype="multipart/form-data" id = "checkinout">-->
                <!--    <div class="checkin-phone">-->
                <!--    <?php //echo $functions->setFormToken($token,false); ?>-->
                <!--    <input name="shift" type="hidden" value="<?php //echo $_GET['shift'] ?>">-->
                <!--    <?php //if($_SESSION['webUser']['account_type'] == 'Employee'){ ?>-->
                <!--    <input name="time" type="hidden" value="<?php //echo date('H:i')?>">-->
                <!--    <input name="type" type="hidden" value="<?php //echo $token ?>">-->
                    
                    
                   
                    <?php 
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { ?>
                 <label style="text-align: center;">Place the camera on your phone in front of the QR code to scan in. This will allow you to check in.<br>
                 If the scanner doesn’t work, manually check in using the Manual Check In button.<br>
                 If you forgot to check in, please press forgot to check in and add information
</label>
                    <div id="errmsg"></div>
                    <div id="msg" class="alert alert-success" style="display: none;"> <?php $dbF->hardWords('QR Code Scan Successfully.'); ?></div>

                    <div class="canvas">
                        <div class="scan"></div>
                        <span class="tl"></span>
                        <span class="tr"></span>
                        <video muted playsinline id="qr-video"></video>
                        <span class="bl"></span>
                        <span class="br"></span>
                    </div>
                    <input type="submit" class="submit_class" value="<?php echo $types ?>" name="submit"></div>


                     <input type="button" id="showmanual"  class="submit_class" value="Checkin manual">
         
     
                    <div id="tab-checkin" style="display:none">
                     <div class="row">
                        <div class="form-group col-12">
    
                            <label>Comments</label>
                            <input name="comment" placeholder="Comments" type="text">
                        </div>
                    </div>
                    <input class="timepicker" type="submit" class="submit_class" value="<?php echo $types ?>" name="submit">

                    </div>


<script>
         $("#showmanual").click(function(){
         $("#showmanual").hide();
         $('#tab-checkin').show();
         $('.checkin-phone').hide();

});
</script>

                    <?php } else { ?>
                    <div class="row">
                        <div class="form-group col-12">
    
                            <label>Comments</label>
                            <input name="comment" placeholder="Comments" type="text">
                        </div>
                    </div>
                    <input type="submit" class="submit_class" value="<?php echo $types ?>" name="submit">


                    <?php } ?>
                    <?php } else { ?>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="<?php echo $time ?>">
                                <?php echo $time ?> :</label>
                            <input name="time" placeholder="<?php echo $time ?>" type="text" class="timepicker" required>
                        </div>
                    </div>
                    <input type="submit" class="submit_class" value="<?php echo $types ?>" name="submit">
                    <?php } ?>
                </form>
            </div>
            <!-- profile rota -->
        </div>
        <!-- right_side close -->
    </div></div>
    <!-- left_right_side -->
   <script type="module">
        import QrScanner from "./js/qr-scanner.min.js";
    QrScanner.WORKER_PATH = './js/qr-scanner-worker.min.js';

$(document).ready(function(){

    const video = document.getElementById('qr-video');
    const scanner = new QrScanner(video, result => ajax(result));
    scanner.start();

    function ajax(result){
        var time = $('input[name=time]').val();
        var type = $('input[name=type]').val();
          var ar = "ajaxrequest";
        $.ajax({
        type: 'post',
        data: {
            qr:result,
            time:time,
            type:type,
            ar:ar
            },
        url: 'ajax_call.php?page=checkinout',                
        }).done(function(data) { 
            //  alert("ssssssssssssssss"+data);
            if (data.trim() == '1') {
                window.location.href='dashboard';
            }
            else{
                $('#errmsg').text(data);
            }
        });
        scanner.stop();
        $('.canvas').css('display',"none");
        $('#msg').css('display',"block");
    }


});

$('form').on('submit', function(e){
    e.preventDefault();
    
    let type = $('input[name=type]').val();
    let time = $('input[name=time]').val();
    let comment = $('input[name=comment]').val();
    let shift = $('input[name=shift]').val();
    let ar = "manualRequest";

    $.ajax({
        type: 'post',
        url: 'ajax_call.php?page=checkinout',
        // data: $('form').serialize,
        data: {
            time:time,
            comment:comment,
            shift:shift,
            type:type,
            ar:ar
        },
        success: function(data){
            window.location.href='main_dashboard';
        }
    })
    
});

</script>
<?php include_once('dashboardfooter.php'); ?>