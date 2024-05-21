<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
  if(isset($_SESSION['practiceUser'])){
      $user = intval($_SESSION['practiceUser']);
  }else{
        $user = intval($_SESSION['currentUser']);
  }

$id =intval($_GET['id']);
$sql = "SELECT * FROM `eventmanagement` WHERE id=(SELECT `title_id` FROM `userevent` WHERE `id`='$id')";
$data = $dbF->getRow($sql);
if(empty($data)){
    $sql = "SELECT * FROM `eventmanagement` WHERE id='$id'";
    $data = $dbF->getRow($sql);
}
$sql2 = "SELECT * FROM `eventForms` WHERE `title_id`='$id' AND `publish`='1'";
$data2 = $dbF->getRows($sql2);
?>
<div class="event_details" id="myform">
    <h3>
        <?php echo $data['title'] ?>
        
    </h3>
     <?php
    
    if($_SESSION['currentUserType'] != 'Employee'){
        
         $user = $_SESSION['webUser']['id'];
         $continue='true';
               
        $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157,163)  AND  order_mandate != '' ";
        $datachk =  $dbF->getRows($sql,array($user));
                if($dbF->rowCount == 0){$continue='false';}

    $q = "SELECT * FROM `bookingForm` WHERE `event_id` = '$data[id]'";
    $d = $dbF->getRow($q);
    
    
    if(!empty($d)&&$continue=='true'){
        
        // (1,14,22,23,24,82,87,89,90,139,157,163)
        
        
        $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (28,90,157)  AND  order_mandate != '' ";
        $dataup =  $dbF->getRows($sql,array($user));
        
        if($dbF->rowCount == 0){
            // var_dump($data);
            
            echo '<div class="consult-box" style="margin-top: -18px;display: block;">';
        
            echo "Upgrade your app to <span>PLATINUM COMPLIANCE</span><a data-fancybox='' id='90' onclick='upgradePackage(this.id)' class='upgrade' target='_blank'>Upgrade</a>". "<span class ='cross'>x</span>";
            
            echo ' </div> ';
            
        }
    }

    $auditEvents=explode(" ",$data['title']);
    
    // var_dump($auditEvents,in_array("Audit", $auditEvents));
    
    if(in_array("Audit", $auditEvents) && $continue=='true'){
        
        $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (139,157,163)  AND  order_mandate != '' ";
        $dataup =  $dbF->getRows($sql,array($user));
        
        if($dbF->rowCount == 0){
            
            echo '<div class="consult-box" style="margin-top: -18px;display: block;">';
        
            echo "Upgrade your app to <span>SMART CONSULT</span><a data-fancybox='' id='139' onclick='upgradePackage(this.id)' class='upgrade' target='_blank'>Upgrade</a>". "<span class ='cross'>x</span>";
        
            echo ' </div> ';

        }
    }
    
    }

    ?>

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
                             <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ 
                                if($data['type'] != "updates"){
                             ?>
                             
                                
                             
                             <a onclick="Edit_recurring_duration()" id="<?php echo $id ?>" data-type="redborder" data-toggle="tooltip" title="Edit Recurring Duration" class="ablue"><i class="fas fa-edit"></i></a>
                           <?php
                                }
                             } ?>
                        </td>
                        <td>
                            <div class="due_date">Due Date :
                                <?php echo date("d-M-Y",strtotime($data['due_date'])) ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ecategory -->
    <div class="form-lr">
        <div class="form-left">
            <?php
if($data['type'] != "updates"){
    if($data['file'] != '#') {
          if(in_array("Audit", $auditEvents) ){
        echo $functions->downloadButton($data['file']);
}
            ?>
    <div class='DelScript'>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="copyEvents(this.id)" id="<?php echo $id ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a></div>
<?php



    }else{

    ?>
    <div class='DelScript'>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="copyEvents(this.id)" id="<?php echo $id ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a></div>
<?php

    }
}
    ?>
 






<?php


    echo "<div class='desc'>".$data['desc']."</div>";
    if($data['type'] != "updates"){
    ?>
            <hr>
            <div class="form_side">
                <form method="post" action="calendar" name="myForm" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <?php echo $functions->setFormToken('newEvent',false); ?>
                    <input type="hidden" value="<?php echo $data['id'] ?>" name="title_id">
                    <!-- <input type="hidden" value="<?php echo $data['recurring_duration'] ?>" name="recurring_duration"> -->
                      <input type="hidden" value="<?php echo $_SESSION[practiceUser] ?>" name="practiceUser">
                     <div class="row">
                    <div class="form-group">
                    <?php if($data['radio'] == 'Yes') { ?>
                    <label class="switch">
                        <input type="checkbox" name="desc2" value="Yes" checked>
                        <span class="slider">Yes No</span>
                    </label>
                    <?php } else{
                        echo '<input type="hidden" name="desc2" value="Yes">';
                    } ?>
                     </div>
                     <?php if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
                    }else{ ?>

                     <div class="form-group col-sm-6">
                        <a href="" id="<?php echo $user.":event:".$id ?>" onclick="changeUserDoc(this.id)" data-toggle="tooltip"  title="Delete Event"><i class="fas fa-trash" style="font-size:22px; margin-top: 5px; color: rgb(86, 29, 148);"></i></a>
                    </div>
                    <?php }?>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Completion Date :</label>
                            <input class="datepicker" type="text" name="date" value="<?php echo date('d-M-Y') ?>" required autocomplete="off" readonly>
                        </div>
                        <!-- form-group -->
                        <div class="form-group col-sm-6">
                            <label>Delegate Task :</label>
                            <select name="assignto">
                                <option selected disabled>Select Employee</option>
                                <option value="-1.<?php echo $_SESSION['currentUser'] ?>">All Employee</option>
                                <?php echo $functions->allEmployee($_SESSION['currentUser']) ?>
                                <option disabled>--Groups</option>
                                <?php echo $functions->allGroups($_SESSION['currentUser']) ?>
                            </select>
                        </div>
                        <!-- form-group -->
                           <input type="hidden" value="<?php echo $data['recurring_duration'] ?>" class="recurring_duration_Hidden" name="recurring_duration_Hidden">
                        
                         <div class="form-group col-sm-6 Edit_recurring_duration" style="display: none;">
                            <label>Edit Recurring Duration :</label>
                            <select name="recurring_duration" class="recurring_duration">
                           <option value="" >Select Recurring Duration</option>
                           <option value="No Recurrence">No Recurrence</option>
                           <option  value="1 day">1 day</option>
                           <option  value="1 week">1 week</option>
                           <option  value="2 weeks">2 weeks</option>
                           <option  value="3 weeks">3 weeks</option>
                           <option  value="1 Month">1 Month</option>
                           <option  value="2 Months">2 Months</option>
                           <option  value="3 Months">3 Months</option>
                           <option  value="4 Months">4 Months</option>
                           <option  value="6 Months">6 Months</option>
                           <option  value="12 Months">12 Months</option>
                           <option  value="24 Months">24 Months</option>
                           <option  value="36 Months">36 Months</option>
                           <option  value="60 Months">60 Months</option>
                           <option  value="">Default</option>
                               
                            </select>
                        </div>
                        <!-- form-group -->
                    </div>
                    <div class="sub-form">
              
                    <?php 
                    if(!empty($data3)){
                        echo "<h4>E-Form</h4>";
                    }
                    $var = false;
                    foreach ($data2 as $key => $value) {
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
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>1" type="radio" value="Yes">
                                    <label for="f<?php echo $key ?>1">Yes</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>2" type="radio" value="No">
                                    <label for="f<?php echo $key ?>2">No</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>3" type="radio" value="N/A">
                                    <label for="f<?php echo $key ?>3">N/A</label>
                                </div>
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['date'] == "Date"){ ?>
                            <div class="form-group col-3">
                                <label>Date :</label>
                                <input name="form[<?php echo $key ?>][date]" type="date">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['time'] == "Time"){ ?>
                            <div class="form-group col-3">
                                <label>Time :</label>
                                <input name="form[<?php echo $key ?>][time]" type="time">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['field1'] != ""){ ?>
                            <div class="form-group col">
                                <label>
                                    <?php echo $value['field1']?> :</label>
                                <input name="form[<?php echo $key ?>][field1]" class="require" type="text">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['field2'] != ""){ ?>
                            <div class="form-group col">
                                <label>
                                    <?php echo $value['field2']?> :</label>
                                <input name="form[<?php echo $key ?>][field2]" class="require" type="text">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- sub-form -->
                    <hr>
                    <div class="form-group">
                        <div class="add-file">
                            <label>Attach File :</label>
                            <div class="file">
                                <input type="file" name="0">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                        <a href="javascript:;" class="add-file-btn"><i class="fas fa-plus"></i> Add More Files</a>
                    </div>
                    <!-- form-group -->
                    <?php 
                if($data['category'] == 'Practice Policies'){ ?>
                    <label class="ccheckbox"><input type="checkbox" name="desc" value="Yes"><span class="cmark"></span>I confirm me and all staff have read, understood and signed the policies acknowledgement sheet.</label>
                    <?php }else{ ?>
                    <div class="form-group">
                        <label>Action Plan :</label>
                        <textarea name="desc"></textarea>
                    </div> 
                    <div class="form-group">
                        <label>Comment :</label>
                        <textarea name="comment" class="require"></textarea>
                    </div>
                    <!-- form-group -->
                    <?php } ?>
                    <?php if($_SESSION['currentUserType'] != 'Employee' || ($_SESSION['superUser']['ccalendar'] == 'edit' || $_SESSION['superUser']['ccalendar'] == 'full')){ ?>
                    <label class="ccheckbox"><input type="checkbox" name="confirm" value="1"><span class="cmark"></span>Are You sure this task has been completed (once ticked you can't delete)</label>
                    <?php }
                    if($_SESSION['userType']=='Trial')
                    {
                        echo '<input type="button" class="submit_class" value="Submit Information" name="" onclick="alertbx()" style="display: inline-block;">&nbsp;&nbsp;
                    <input type="button" class="submit_class" value="Save Information" onclick="alertbx()" name="">';
                    }else{
                    ?>
                    <input type="submit" class="submit_class" value="Submit Information" name="submit" style="display: inline-block;">&nbsp;&nbsp;
                    <input type="submit" class="submit_class" value="Save Information" name="submit" style="display: inline-block;">
                    <?php }?>
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
                    <?php echo $data['title'] ?>
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
    <?php } ?> 
    </div>
    <!-- form-lr -->
</div>
<!-- event_details -->
<script>
$('[data-toggle="tooltip"]').tooltip(); 
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',

     changeMonth: true,
     changeYear: true,
        yearRange: "-80:+20",
        showButtonPanel:true
});
$('.add-file-btn').on('click', function() {
    // var i = $('.add-file input:last-child').attr('name');
     var i =  $(".add-file > div").length;
    if (i == null) { i = 0 }
    i = parseInt(i) + parseInt(1);
    $('.add-file').append('<div class="file"><input type="file" name="' + i + '"><i class="fas fa-paperclip"></i><div>Upload</div></div>');
});
$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});
$('.switch').on('change', function() {
    if ($(this).find('input').is(':checked')) {
        $('.form-group').slideDown(600);
    } else {
        $('.form-group').slideUp(600);
    }
});
$('.form-right-inner button').on('click', function() {
    $(this).slideUp('medium');
    $(this).next('form').slideDown('medium');
});
$(".upgrade-btn_popup").click(function(){
  $(".upgrade-form").fadeIn();
  $(".fixed_side").css("transform", "scaleX(1)")
});
$(".upgrade-btn").click(function(){
    $(this).fadeOut();
  $(".consult-box").fadeIn();
});
$(".cross").click(function(){
  $(".consult-box").fadeOut();
  $(".upgrade-btn").fadeIn();
});
function validateForm(event) {
    // event.preventDefault();
    let radioName  = $(".form_side input[type='radio']");
    let tempCon = false
    let counter = radioName.length/3;
    

      for(let i = 0 ; i < counter; i++){
        if($(`input[name='form[${i}][radio]']:checked`).val() === undefined){
            tempCon = true

        }
    }

 
  // let x = document.forms["myForm"]["comment"].value;
  fieldlist = $('.require');
  fieldlist.map((index,item)=>{
    if((item.value).trim() === ""){
        tempCon = true
    }
  })

  if(tempCon){
    let text = "Are you sure you would like to save an empty/incomplete event ?";
      if (confirm(text) == true) {
        event.submit()
        return true
      }else{
        return false
      }
  }
  else{

    return true
        event.submit()
    }

}
</script>