<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

include_once('header.php');
include'dashboardheader.php'; 

  $id =   base64_decode($_GET['id']);
 // echo $id =   $_GET['id'];
//         $sql6 = "SELECT * FROM `userevent` WHERE `id`='$id'";
// $data6 = $dbF->getRow($sql6);
// $tid = $data6['title_id'];
//  $sql5 = "SELECT * FROM `userevent` WHERE `title_id`='$tid' AND `approved` = '1'";
// $data5 = $dbF->getRow($sql5); 

//  echo $tid = $data5['title_id'];
       
// $sql7 = "SELECT * FROM `usereventForms` WHERE `title_id`='$tid'";
// $data7 = $dbF->getRow($sql7);
// echo $data7['field1'];
// echo $data7['field2'];
// echo $data7['radio'];

$user = $_SESSION['currentUser'];
// $id = $_GET['id'];
$sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `title_id` FROM `userevent` WHERE `id`='$id')";
$data = $dbF->getRow($sql);

$sql2 = "SELECT * FROM `userevent` WHERE `id`='$id'";
$data2 = $dbF->getRow($sql2);

 $sql3 = "SELECT * FROM `eventForms` WHERE `title_id`=(SELECT `title_id` FROM `userevent` WHERE `id`='$id') AND `publish`='1' ORDER BY `category`,`id` ";
$data3 = $dbF->getRows($sql3);

$cdate = date("d-M-Y");

    $approved_event=0;
if($data2['approved'] == '1'){
    $approved_event=1;
    echo "<script>  
    $('.event_details input,.event_details select,.event_details textarea').prop('disabled','disabled');
    $('.event_details input[type=file],.event_details .add-file,.event_details .add-file-btn,.event_details .submit_class,.event_details .ccheckbox,input[type=checkbox]').hide();
    </script>";
    $cdate = date("d-M-Y",strtotime($data2['dateTime']));
}
?>
<style>

@media print {
    form * {
        border: none;
        font-weight: bold;
    }
    .event_details,
    .myevents-div{
        padding: 10px 0 !important;
    }
}

.loader {
    display: none;
    }
.form-right {
    display: none;
}

.myevents-div {
    position: relative;
    left: 0%;
    right: 0%;
    width: 90%;
    margin: 0 auto;
    z-index: 999;
    padding: 20px;
    background: #fff;
    border-top: 5px solid #01abbf;
    overflow: visible;
}

.myevents-form {
    min-height: 5px;
}

.myevents-div_ {
    transform: none;
}

.event_details {
    padding-top: 20px !important;
    font-family: "montserratmedium";
    line-height: 1.8;
    width: 500px;
    max-width: 100%;
}
</style>
<h2 style="text-align: center; margin: 2% 0 1% 0;"><?php echo $functions->PracticeName($user);?></h2>
<div class="myevents-div myevents-div_ redborder">


    <div class="myevents-form">
<div class="event_details" id="myform">
    <h3>
        <?php echo $data['title'] ?>
    </h3>
    <div class="ecategory">
                <table>
                    <tr>
                        <td>Category :
                            <?php echo $data['category'] ?>
                        </td>
                        <td>
                            <?php echo ucwords($data['type']) ?>
                        </td>
                        <td>Event Interval :
                            <?php echo $data['recurring_duration'] ?>
                        </td>
                        <td>
                            <div class="due_date">Due Date :
                                <?php 
 
                                 $_SESSION['currentUserType'];

                                echo $data2duedate =  date("d-M-Y",strtotime($data2['due_date'])) ?>

                            </div>

        
         
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ecategory -->
    <div class="form-lr">
        <div class="form-left">
            <?php
    if($data['file'] != '#') {
        echo $functions->downloadButton($data['file']);
    }
    echo "<div class='desc'>".$data['desc']."</div>";
    ?>
            <hr>
            <div class="form_side">
                <form method="post" action="calendar" enctype="multipart/form-data">
                    <?php echo $functions->setFormToken('newEvent',false); ?>
                    <input type="hidden" value="<?php echo $id ?>" name="edit_id">
                    <input type="hidden" value="<?php echo $data['id'] ?>" name="title_id">
                    <!----<input type="hidden" value="<?php echo $data2['due_date'] ?>" name="due_date">----->
                    <input type="hidden" value="<?php echo $data['recurring_duration'] ?>" name="recurring_duration">
                    
                    <?php if($data['radio'] == 'Yes') { ?>
                    <label class="switch">
                        <input type="checkbox" name="desc2" value="Yes" checked>
                        <span class="slider">Yes No</span>
                    </label>
                    <?php } else{
                        echo '<input type="hidden" name="desc2" value="Yes">';
                    } ?>
                        <div class="form-group" style="width: 300px;position: absolute;right: 0;top: -10px;">
                            <label style="display: inline;">Completion Date :</label>
                            <input style="width: 150px;display: inline;" class="datepicker" type="text" name="date" value="<?php echo $cdate ?>" required autocomplete="off" readonly>
                        </div>

                        <!-- form-group -->
                    <div class="sub-form">
                        <?php 
                    if(!empty($data3)){
                        echo "<h4>E-Form</h4>";
                    }
                    $var = false;
                    foreach ($data3 as $key => $value) {
                   
                             echo "<br>";
                         $sql4 = "SELECT * FROM `usereventForms` WHERE `ue_id`='$id' AND `q_id`='$value[id]'";
                     echo "<br>";
                    $question_id =  $value['id'];
                     $data4 = $dbF->getRow($sql4);

                     // echo    $sql8 = " SELECT * FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` =  (SELECT `ue_id` FROM `usereventForms` ORDER BY ue_id DESC LIMIT 1)";  

                      //   $sql8 = "SELECT * FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` = (SELECT `ue_id` FROM `usereventForms` where `user` = '$user' AND `q_id`='$question_id' AND title_id = '$data[id]'  ORDER BY ue_id DESC LIMIT 1)";
                           



                       //    $data8 = $dbF->getRow($sql8);
                            $data8 = "";
                        // $data8['ue_id'];
                      
                    // $sql9 = "SELECT * FROM `usereventForms` WHERE ue_id ='$data8[ue_id]' AND `q_id` = '$data8[q_id]' " ;
                    // $data9 = $dbF->getRow($sql9);
                     $data9 = "";
                     //$user=$_SESSION['webUser']['id'];
                  
                 $value['radio'];
                        $category = $value['category'];
                        if($var != $category){
                            echo "<hr><h6>$category</h6>";
                            $var = $category;
                        }
                        ?>
                        <div class="row">
                        <?php echo '<span class="col-12">'.$value['question'].'</span>'; ?>
                        <input name="form[<?php echo $key ?>][question]" type="hidden" value="<?php echo $value['id'] ?>">
                            <?php if($value['radio'] == "Radio"){ ?>
                            <div class="form-group col-6 col-md-3">
                                <label>&nbsp;</label>
                                <div class="radio-toolbar">
                                   <!--  <?php 
                                    $olddata=0;
                                    if($data4['radio']!="" || $approved_event==1){
                                        $datatmp=$data4['radio'];
                                    }else{
                                        $datatmp=$data9['radio'];
                                        $olddata=1;
                                    }?> -->
                                    <input name="form[<?php echo $key ?>][radio]" id="<?php echo $key ?>1" type="radio" value="Yes" <?php if($datatmp=="Yes" )echo "checked" ; ?>>
                                    <label for="<?php echo $key ?>1">Yes</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="<?php echo $key ?>2" type="radio" value="No" <?php if($datatmp=="No" )echo "checked" ; ?>>
                                    <label for="<?php echo $key ?>2">No</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="<?php echo $key ?>3" type="radio" value="N/A" <?php if($datatmp=="N/A" )echo "checked" ; ?>>
                                    <label for="<?php echo $key ?>3">N/A</label>
                                </div>
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['date'] == "Date"){ ?>
                            <div class="form-group col col-md-3">
                                <?php if($data4['date']!="" || $approved_event==1){
                                        $datatmp=$data4['date'];
                                    }else{
                                        $datatmp=$data9['date'];
                                        $olddata=1;
                                    }?>
                                <label>Date :</label>
                                <input name="form[<?php echo $key ?>][date]" type="date" value="<?php echo $datatmp ?>">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                           
                            <?php if($value['time'] == "Time"){ ?>
                            <div class="form-group col col-md-3">
                                <?php if($data4['time']!="" || $approved_event==1){
                                        $datatmp=$data4['time'];
                                    }else{
                                        $datatmp=$data9['time'];
                                        $olddata=1;
                                    }?>
                                <label>Time :</label>
                                <input name="form[<?php echo $key ?>][time]" type="time" value="<?php echo $datatmp ?>">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['field1'] != ""){ ?>
                            <div class="form-group col">
                                <?php if($data4['field1'] !="" || $approved_event==1){
                                        $datatmp=$data4['field1'];
                                        $olddata=0;
                                    }else{
                                        $datatmp=$data9['field1'];
                                        $olddata=1;
                                    }?>
                              <label for="<?php echo $value['field1']?>">
                                    <?php echo $value['field1']?></label>
                                <input name="form[<?php echo $key ?>][field1]" type="text" value="<?php echo $datatmp ?>">
                            </div> 

                            <!-- form-group -->
                            <?php } ?>


                            <?php if($value['field2'] != ""){ ?>
                            <div class="form-group col">
                                <?php if($data4['field2']!="" || $approved_event==1){
                                        $datatmp=$data4['field2'];
                                    }else{
                                        $datatmp=$data9['field2'];
                                    }?>
                                <label for="<?php echo $value['field2']?>">
                                    <?php echo $value['field2']?></label>
                                <input name="form[<?php echo $key ?>][field2]" type="text" value="<?php echo $datatmp ?>">
                            </div> 
                            <?php } ?>


                        </div>
                        <?php } ?>
                    </div>
                    <!-- sub-form -->
                    <hr>
                    <div class="form-group">
                        <?php
                if(!empty($data2)){
                    if($data2['file'] != '#') {
                        echo "<input type='hidden' name='old_file' value='$data2[file]'>";
                        echo $functions->downloadButton($data2['file']);
                    }
                }
                ?>
                    </div>
                    <!-- form-group -->
                    <?php if($data['category'] == 'Practice Policies'){ ?>
                    <label class="ccheckbox"><input type="checkbox" name="desc" value="Yes"><span class="cmark"></span>I confirm me and all staff have read, understood and signed the policies acknowledgement sheet.</label>
                    <?php }else{ ?>
                    <div class="form-group">
                        <label>Action Plan</label>
                        <textarea name="desc"><?php echo $data2['desc'];?></textarea>
                    </div>
                    <!-- form-group -->
                    <?php } ?>
               </form>
            </div>
            <!-- form_side -->
        </div>
        <!-- form-left -->
        <?php 
$q = "SELECT * FROM `bookingForm` WHERE `event_id` = '$data[id]'";
$d = $dbF->getRow($q);
if(!empty($d)){
?>
        <div class="form-right">
            <div class="form-right-inner">
                <img src="<?php echo $d['image'] ?>" alt="">
                <h4>
                    <?php echo $d['title'] ?>
                </h4>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <!-- stars -->
                <button type="button">Book Now</button>
                <form method="post" action="calendar" enctype="multipart/form-data">
                    <?php echo $functions->setFormToken('newBookingForm',false); ?>
                    <input type="hidden" value="<?php echo $data['title'] ?>" name="event_title">
                    <input type="hidden" value="<?php echo $d['title'] ?>" name="title">
                    <textarea name="desc"></textarea>
                    <button class="submit_class" type="submit" name="submit">Email Now</button>
                </form>
            </div>
            <!-- form-right-inner -->
        </div>
        <!-- form-right -->
        <?php } ?>
    </div>
    <!-- form-lr -->
</div>
<!-- event_details -->
</div></div>
<?php include_once('footer.php'); ?>
<script>
$('[data-toggle="tooltip"]').tooltip(); 

      $('#loader').fadeOut(100);
     $(window).load(function() {
      //This execute when entire finished loaded
    //   window.print();
      setTimeout(function(){ window.print(); }, 500);
      setTimeout(function(){ window.close(); }, 3000);
    });
    
    </script>