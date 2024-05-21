<?php 
error_reporting(0);
ini_set('display_errors', 0);
include_once("global.php");

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

$chk2 = $functions->checkoutforgetSubmit();
$msg ='';
     if($chk2){
         $msg = "Check Out Forget Form Submit Successfully";
         header('Location: main_dashboard');
}


// include_once('header.php');

//////////////////\checkoutforget?type=checkoutForget\'

if ($_GET['type'] == 'checkoutForget') {
   
   $type = 'Check Out Forget';
    $time = 'Forget Checkout Time';
    $token = 'checkoutforgettoken';  
}

include'dashboardheader.php';


?>
<script>
      function checkoutforget(ths){ 

        
        btn=$(ths);
                  
        $('.selectCheckOutForget').show();
        $('.checkforgetform').show();
        // $('.comntcheckoutforget').show();
          
           
            $.ajax({
                type: 'POST',
                url: 'ajax_call.php?page=checkoutforget',
                data: { id:"id"}
            }).done(function(data){
                        console.log(data);
                 
                   
                   // if (data != '111') 
                   // {
                        $('#selectCheckOutForget').html(data);
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

        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_">Forget CheckOut</h3>
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                    //$functions->changeSession();
                ?>
                </div>
                <!-- change-session -->
                  <button  type="button" class="submit_class" name="checkoutForget" onclick="checkoutforget()" >Forget Check Out</button>
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
                           
                           <select name="selectCheckOutForget" id="selectCheckOutForget">
                           
                            <option>Select CheckOut Forget Date</option>
                            
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
                    <input type="submit" class="submit_class btnforget" value="Check Out" name="submit">

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