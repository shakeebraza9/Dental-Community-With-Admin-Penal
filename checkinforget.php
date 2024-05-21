<?php
error_reporting(0);
ini_set('display_errors', 0);


include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// $chk2 = $functions->checkoutforgetSubmit();
$chk2 = $functions->checkinforgetSubmit();

$msg ='';
     if($chk2){
         $msg = "Check In Forget Form Submit Successfully";
         header('Location: main_dashboard');
}


// include_once('header.php');

//////////////////\checkoutforget?type=checkoutForget\'

if ($_GET['type'] == 'checkinForget') {
   
   $type = 'Check in Forget';
    $time = 'Forget Checkin Time';
    $token = 'checkinforgettoken';  
}

include'dashboardheader.php';


?>
<script>
      function checkinforget(ths){ 

        
        btn=$(ths);
                  
        $('.selectCheckinForget').show();
        $('.checkforgetform').show();
        // $('.comntcheckoutforget').show();
          
           
            $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=checkinforget',
                data: { id:"id"}
            }).done(function(data){
                        console.log(data);
                 
                   
                   // if (data != '111') 
                   // {
                        $('#selectCheckinForget').html(data);
                   // var selectval =  $('#selectCheckOutForget').val();
                   // console.log(selectval);
                   // }
                  
                });
    
      } 

     
</script>

<div class="index_content mypage health_form">
    <div class="left_right_side">

        <div class="link_menu">
            <span>
                <img src="<?= WEB_URL?>/webImages/menu.png" alt="">
            </span>
            <?php echo $type; ?>
        </div>
        <!--link_menu close-->
        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_">Forget CheckIn</h3>
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    //$functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
                  <button  type="button" class="submit_class" name="checkinForget" onclick="checkinforget()" >Forget CheckIn  </button>
            </div>
            <!-- right_side_top close -->
          
            <div class="profile rota  checkforgetform" style="display: none"> 
 
                <form method="post"  enctype="multipart/form-data">
                    <div class="checkin-phone">
                    <?php echo $functions->setFormToken($token,false); ?>
                  
                    <input name="time" type="hidden" value="<?php echo date('H:i')?>">
                    <input name="type" type="hidden" value="<?php echo $token ?>">
           
                    <div class="row">
                        <div class="form-group col-12 ">
                            <label for="<?php echo $time ?>"><?php echo $time ?> :</label>
                           
                           <select name="selectCheckinForget" id="selectCheckinForget">
                           
                            <option>Select CheckIn Forget Date</option>
                            
                           </select>

                           
                        </div>
                       
                         <div class="form-group col-12 comntcheckinforget">
    
                            <label>Comments</label>
                            <input name="comment" placeholder="Comments" type="text">
                        </div>

                        <div class="form-group col-12 ">
    
                            <label>Time</label>
                            <input name="time" placeholder="<?php echo $time ?>" type="text" class="timepicker" required>
                        </div>
                    </div>
                    <input type="submit" class="submit_class" value="Check In" name="submit">

                </form>
                 
            </div>
            <!-- profile rota -->
        <?php if($msg !=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close blankcheckoutforget" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
        </div>
        <!-- right_side close -->
    </div>

<?php include_once('dashboardfooter.php'); ?>