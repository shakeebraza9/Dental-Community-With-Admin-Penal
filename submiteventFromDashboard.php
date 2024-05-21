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
//   $sql = "SELECT * FROM `myevents` WHERE id=(SELECT `title_id` FROM `myeventform` WHERE `id`='$id')";
// $data = $dbF->getRow($sql);
// var_dump($data);
// if(empty($data)){
    $sql = "SELECT * FROM `myevents` WHERE id='$id'";
    $data = $dbF->getRow($sql);
//     echo "string";
// }
$fetch_id = $data['fetch_id'];
if(empty($data['fetch_id'])){
$fetch_id = $id;
}


$sql2 = "SELECT * FROM `myeventform` WHERE `title_id`='$fetch_id' AND `publish`='1'";
$data2 = $dbF->getRows($sql2);








$cdate = date("d-M-Y");

    $approved_event=0;
   
    $display = 'style="display:none;';
    $true = TRUE;
if($data['approved'] == '1'){
    $approved_event=1;
    $true = false;
    $display = 'style="display:block;"';

    echo "<script>  
    $('.event_details input,.event_details select,.event_details textarea').prop('disabled','disabled');
    $('.event_details input[type=file],.event_details .add-file,.event_details .add-file-btn,.event_details .submit_class,.event_details .ccheckbox,.event_details .showIicon,input[type=checkbox]').hide();
    </script>";
    $cdate = date("d-M-Y",strtotime($data['dateTime']));
}




?>
<div class="event_details" id="myform">
    <h3>
        <?php echo $data['title'] ?>
    </h3>
    
    
    <?php
    
// if($_SESSION['currentUserType'] != 'Employee'){
    
// $user = $_SESSION['webUser']['id'];
        
// $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (89,139,163)  AND  order_mandate != '' ";
// $data2 =  $dbF->getRows($sql,array($user));

// if($dbF->rowCount > 0){
//     // var_dump($data);
    
//     echo '<div class="consult-box" style="margin-top: -18px;display: block;">';

//     // echo "Upgrade your app to <span>PLATINUM COMPLIANCE</span><a href='javascript:void(0)' class='upgrade-btn_popup'>Upgrade</a>". "<span class ='cross'>x</span>";
    
//     echo "Upgrade your app to <span>PLATINUM COMPLIANCE</span><a data-fancybox='' id='90' onclick='upgradePackage(this.id)' class='upgrade' target='_blank'>Upgrade</a>". "<span class ='cross'>x</span>";
    
//     echo ' </div> ';
    
// }


// $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (28,90)  AND  order_mandate != '' ";
// $data2 =  $dbF->getRows($sql,array($user));

// if($dbF->rowCount > 0){
    
//     echo '<div class="consult-box" style="margin-top: -18px;display: block;">';

//     echo "Upgrade your app to <span>SMART CONSULT</span><a data-fancybox='' id='139' onclick='upgradePackage(this.id)' class='upgrade' target='_blank'>Upgrade</a>". "<span class ='cross'>x</span>";

//     echo ' </div> ';

// }

// }

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
                             <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ ?>
                             
                                
                             
                             <a onclick="Edit_recurring_duration()" id="<?php echo $id ?>" data-type="redborder" data-toggle="tooltip" title="Edit Recurring Duration" class="ablue"><i class="fas fa-edit"></i></a>
                           <?php
                             } ?>
                        </td>
                        <td>
                          



                             <div class="due_date">Due Date :
                                <?php 
 
                            



                                echo $data2duedate =  date("d-M-Y",strtotime($data['due_date'])) ?>
                                 
<?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ ?>
                             <?php if ($approved_event != 1) { ?>
                                
                             
                             <a onclick="EditeventDate()" id="<?php echo $id ?>" data-type="redborder" data-toggle="tooltip" title="Edit Due Date" class="ablue"><i class="fas fa-edit"></i></a>
                           <?php
                             } 
                             } 
                            
                            
                             elseif($_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master') { ?>
                               <?php if ($approved_event != 1) { ?>
                                
                             
                             <a onclick="EditeventDate()" id="<?php echo $id ?>" data-type="redborder" data-toggle="tooltip" title="Edit Due Date" class="ablue"><i class="fas fa-edit"></i></a>
                           
                           <?php
                             } 
                             } 
                             ?>
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
            ?>
    <div class='DelScript'>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="myeventsReopen(this.id)" id="<?php echo $data['id'] ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a></div>
<?php



    }else{

    ?>
    <div class='DelScript'>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="myeventsReopen(this.id)" id="<?php echo $data['id'] ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a></div>
<?php

    }
    //echo "<div class='desc'>".$data['desc']."</div>";
    ?>
            <!--<hr>-->
            <div class="form_side">
                <form method="post" action="calendar" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                    <?php echo $functions->setFormToken('myeventsSubmit',false); ?>
  <input type="hidden" value="<?php echo $id ?>" name="edit_id">
                    <input type="hidden" value="<?php echo $data['id'] ?>" name="title_id">
 <input type="hidden" value="<?php echo $data['due_date'] ?>" name="due_date"> 
                    <input type="hidden" value="<?php echo $data['user'] ?>" name="cur_user">
                    
                      <input type="hidden" value="<?php echo @$_SESSION['practiceUser'] ?>" name="practiceUser">
                       <input type="hidden" value="<?php echo @$_SESSION['practiceUser'] ?>" name="practiceUser">

                       <input type="hidden" value="<?php echo $data['file'] ?>" name="old_file">


                        <input type="hidden" value="<?php echo $data['type'] ?>" name="event_type">

                       
                    <?php

            

                

                        echo '<input type="hidden" name="desc2" value="Yes">';
                
                 ?>
                    <div class="row">
             
                         <div class="form-group col-sm-6 duedate" style="display: none;">
                            <label>Due Date :</label>
                             <input class="datepicker" type="text" value="<?php echo $data['due_date'] ?>" name="due_date">
                        </div>

<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == '0'){  echo "<input type='hidden' value='$data[assignto]' name='assignto'>";} else {
$selected = '';
if(strpos(@$data['assignto'],'-1') !== false){
$selected = 'selected';
}
?>



                        <div class="form-group col-sm-6">
                            <label>Delegate Task :</label>
                            <select name="assignto">
                                <option <?php echo "value='-1.$_SESSION[currentUser]' $selected" ?>>All Employee</option>
                                <?php echo $functions->allEmployee($_SESSION['currentUser'],$data['assignto']) ?>
                                <option >Unassigned</option>
                                <option disabled>--Groups</option>
                                <?php echo $functions->allGroups($_SESSION['currentUser']) ?>
                            </select>
                        </div>
                        <?php } ?>
                        <!-- form-group -->
                           <input type="hidden" value="<?php echo $data['recurring_duration'] ?>" class="recurring_duration_Hidden" name="recurring_duration_Hidden">
                        
                         <div class="form-group col-sm-6 Edit_recurring_duration" style="display: none;">
                            <label>Edit Recurring Duration :</label>
                            <select name="recurring_duration" class="recurring_duration">
                           <option value="<?php echo $data['recurring_duration'] ?>"><?php echo $data['recurring_duration'] ?></option>
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
                    if(!empty($data2)){
                        echo "<h4>E-Form</h4>";
                    }
                    $var = false;
                    foreach ($data2 as $key => $value) {
$fetch_id = $data['fetch_id'];
if(empty($data['fetch_id'])){
$fetch_id = $id;
}
                        
$question_id =  $value['id']; 


  $sql4 = "SELECT * FROM `myeventsFilled` WHERE  `q_id`='$question_id'  and `title_id` = '$fetch_id' and my_e_id ='$id'";
$data4 = $dbF->getRow($sql4);


// SELECT * FROM `myeventsFilled` WHERE `q_id`='116' and `title_id` = '1423' and my_e_id ='1425'




// SELECT * FROM `myeventsFilled` WHERE my_e_id ='1425' AND `q_id` = '116' and `user` = '2' and `title_id` = '1423'


  $sql9 = "SELECT * FROM `myeventsFilled` WHERE  `q_id` = '$question_id' and `user` = '$user' and `title_id` = '$fetch_id' ORDER BY `myeventsFilled`.`id` DESC" ;
$data9 = $dbF->getRow($sql9);



// ELECT * FROM `myeventsFilled` WHERE `my_e_id`='1420' AND `q_id`='114' and `title_id` = '1419'

// SELECT * FROM `myeventsFilled` WHERE my_e_id ='1420' AND `q_id` = '114' and `user` = '2' and `title_id` = '1419'







    
                             
                        
            //              $data8['ue_id'];
                      
                           
                     
                     //$user=$_SESSION['webUser']['id'];
                  
                 // $value['radio'];
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
                                    <?php 
                                    $olddata=0;
                                    if(@$data4['radio'] !="" || $approved_event == 1){
                                        @$datatmp=$data4['radio'];
                                    }else{
                                        @$datatmp=$data9['radio'];
                                        $olddata=1;
                                    }?> 
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>1" type="radio" value="Yes" <?php if($datatmp=="Yes" )echo "checked" ; ?>>
                                    <label for="f<?php echo $key ?>1">Yes</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>2" type="radio" value="No" <?php if($datatmp=="No" )echo "checked" ; ?>>
                                    <label for="f<?php echo $key ?>2">No</label>
                                    <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>3" type="radio" value="N/A" <?php if($datatmp=="N/A" )echo "checked" ; ?>>
                                    <label for="f<?php echo $key ?>3">N/A</label>
                                </div>
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['date'] == "Date"){ ?>
                            <div class="form-group col col-md-3">
                                <?php if(@$data4['date']!="" || $approved_event==1){
                                        @$datatmp=$data4['date'];
                                    }else{
                                        @$datatmp=$data9['date'];
                                        $olddata=1;
                                    }?>
                                <label>Date :</label>
                                <input name="form[<?php echo $key ?>][date]" type="date" value="<?php echo $datatmp ?>">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                           
                            <?php if($value['time'] == "Time"){ ?>
                            <div class="form-group col col-md-3">
                                <?php if(@$data4['time']!="" || $approved_event==1){
                                        @$datatmp=$data4['time'];
                                    }else{
                                        @$datatmp=$data9['time'];
                                        $olddata=1;
                                    }?>
                                <label>Time :</label>
                                <input name="form[<?php echo $key ?>][time]" type="time" value="<?php echo $datatmp ?>">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['field1'] != ""){ ?>
                            <div class="form-group col">
                                <?php if(@$data4['field1'] !="" || $approved_event==1){
                                        @$datatmp=$data4['field1'];
                                        $olddata=0;
                                    }else{
                                        @$datatmp=$data9['field1'];
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
                                <?php if(@$data4['field2']!="" || $approved_event==1){
                                        @$datatmp=$data4['field2'];
                                    }else{
                                        @$datatmp=$data9['field2'];
                                    }?>
                                <label for="<?php echo $value['field2']?>">
                                    <?php echo $value['field2']?></label>
                                <input name="form[<?php echo $key ?>][field2]" type="text" value="<?php echo $datatmp ?>">
                            </div> 
                            <?php } ?>

                            <?php if (@$data9['field1']!='' || @$data9['field2']!='' ) {   // if ($olddata==1) {?>
                            <div class="form-group showIicon " style="position: relative;z-index: 1;">
                            <i data-toggle="tooltip" title="Data is Loaded From  Previous Record" style="line-height: 6;margin-left: -68%; cursor: pointer; position: relative; height: 50%;" class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>

                            <?php $olddata=0;$datatmp="";}  ?>
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
                        <textarea name="actionplan"><?php echo $data['actionplan'] ?></textarea>
                    </div> 
                    <div class="form-group">
                        <label>Comment :</label>
                        <textarea name="comment" class="require"><?php echo $data['comment'] ?></textarea>
                    </div>
                    <!-- form-group -->
                    <?php } ?>
               <?php if(
    (($_SESSION['currentUserType'] == 'Employee' || @$_SESSION['superUser']['ccalendar'] == 'full') && $data['due_date'] <= date('Y-m-d' )) || 
    ($data['due_date'] <= date('Y-m-d' ) && ($_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'  ))
)  { 



?>
                    <label class="ccheckbox"><input type="checkbox" name="confirm" value="1"><span class="cmark"></span>Are You sure this task has been completed (once ticked you can't delete)</label>
                    <?php } 
                    if($_SESSION['userType']=='Trial')
                    { 
                        echo'<input type="button" class="submit_class" value="Submit Information" onclick="alertbx()" name="" style="display: inline-block;">&nbsp;&nbsp;
                    <input type="button" class="submit_class" value="Save Information" name="" onclick="alertbx()" style="display: inline-block;">';
                    }
                    else{?>
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