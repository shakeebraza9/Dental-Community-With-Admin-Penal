<?php 
error_reporting(0);
ini_set('display_errors', 0);
include_once("global.php");
 // include_once("platinum-popup.php");
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

  $id =   intval($_GET['id']);
  if(isset($_SESSION['practiceUser'])){
      $user = intval($_SESSION['practiceUser']);
  }else{
        $user = intval($_SESSION['currentUser']);
  }

// $id = $_GET['id'];
$sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `title_id` FROM `userevent` WHERE `id`='$id')";
$data = $dbF->getRow($sql);
$sqli = "SELECT max(`ue_id`) FROM `usereventForms` where `user` = '$user' AND title_id = '$data[id]'  ORDER BY ue_id DESC LIMIT 1";$datai = $dbF->getRow($sqli);
$usereventFormsPK = $datai[0];
$sql2 = "SELECT * FROM `userevent` WHERE `id`='$id'";
$data2 = $dbF->getRow($sql2);
// var_dump($data2);
 $sql3 = "SELECT * FROM `eventForms` WHERE `title_id`=(SELECT `title_id` FROM `userevent` WHERE `id`='$id') AND `publish`='1' ORDER BY `category`,`id` ";
$data3 = $dbF->getRows($sql3);
$cdate = date("d-M-Y");
   $approved_event=0;
       $display = 'style="display:none;';
    $true = TRUE;
if($data2['approved'] == '1'){
    $approved_event=1;
    $true = false;
    $display = 'style="display:block;"';
    echo "<script>  
    $('.event_details input,.event_details select,.event_details textarea').prop('disabled','disabled');



    $('.event_details input[type=file],.event_details .add-file,.event_details .add-file-btn,.event_details .submit_class,.event_details .ccheckbox,.event_details .showIicon,input[type=checkbox]').hide();
    </script>";
    $cdate = date("d-M-Y",strtotime($data2['dateTime']));
}
?>
<div class="event_details" id="myform">
    <div class="form_heading"><h1>
        <?php echo $data['title'];
         ?>
    </h1></div>

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
                               <?php if (empty($data2['recurring'])) {
                                  
                             echo $data['recurring_duration'];

                               }else{
                                echo $data2['recurring']; 
                               } ?>

                            <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ 
                                if($data['type'] != "updates"){
                            ?>
                             
                                
                             
                             
                                   <?php if ($approved_event != 1) { ?>
                             <a onclick="Edit_recurring_duration()"  id="<?php echo $id ?>" data-type="redborder" data-toggle="tooltip" title="Edit Recurring Duration" class="ablue"><i class="fas fa-edit"></i></a>
                           <?php
                             } } }?>
                            
                            
         
                        </td>
                        <td>
                          <div class="due_date">Due Date :
                                <?php 
 
                                 $_SESSION['currentUserType'];


                                echo $data2duedate =  date("d-M-Y",strtotime($data2['due_date'])) ?>
                                 
<?php 
        if($data['type'] != "updates"){    
            if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ 
                                
?>
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
if($data['type'] != "updates"){            
    if($data['file'] != '#') {
            if(in_array("Audit", $auditEvents) ){
        echo $functions->downloadButton($data['file'],false);
    }

            ?>
    <div class='DelScript'>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="copyEvents(this.id)" id="<?php echo $data['id'] ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a>
<?php



    }else{

    ?>
<a href="javascript:;" class="dbtn" style="float: right;" onclick="copyEvents(this.id)" id="<?php echo $data['id'] ?>" data-toggle="tooltip" title="Customise this event"><i class="fas fa-copy"></i>Customise this event</a>
<?php

    }

}

if($data['type'] != "updates"){
   if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full' || $_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'){ ?>
                             <?php if ($approved_event == 1) {  
                             
                      echo '<a class="dbtn" href="redoEvent?p='.base64_encode($id).'" target="_blank" data-toggle="tooltip" title="Redo Event"><i class="fas fa-redo"></i>&nbsp;&nbsp;Redo Event &nbsp;&nbsp;</a>';
                      
                             } 
                             } 
}

//      if ($approved_event == 1) { 
//     echo '<a class="dbtn" href="redoEvent?p='.base64_encode($id).'" target="_blank" data-toggle="tooltip" title="Redo Event"><i class="fas fa-redo"></i>&nbsp;&nbsp;Redo Event &nbsp;&nbsp;</a>';
// }

echo '</div>';



    echo "<div class='desc'>".$data['desc']."</div>";
    if($data['type'] != "updates"){
    ?>
            <hr>
            <div class="form_side">
                <form method="post" action="calendar" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                    <?php echo $functions->setFormToken('newEvent',false); ?>
                    <input type="hidden" value="<?php echo $id ?>" name="edit_id">
                    <input type="hidden" value="<?php echo $data['id'] ?>" name="title_id">
                    <!----<input type="hidden" value="<?php echo $data2['due_date'] ?>" name="due_date">-----> 
                    <input type="hidden" value="<?php echo $data2['user'] ?>" name="cur_user">
                   
                   <div class="row">
                    <div class="form-group">
                    <?php if($data['radio'] == 'Yes') { ?>
                     <div class="btn_new">
                    <label class="switch">
                        <input type="checkbox" name="desc2" value="Yes" checked>
                        <span class="slider">Yes No</span>
                    </label>
                    </div>
                    <?php } else{
                        echo '<input type="hidden" name="desc2" value="Yes">';
                    } ?>
                    </div>
                    <?php if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
                    }else{ ?>

                     <div class="form-group col-sm-6">
                        <a href="" id="<?php echo $user.":event:".$data['id'] ?>" onclick="changeUserDoc(this.id)" data-toggle="tooltip"  title="Delete Event"><i class="fas fa-trash" style="font-size:22px; margin-top: 5px; color: rgb(42, 48, 66);"></i></a>
                    </div>  
                    <?php }?> 
                    </div>
                    <div class="form-group-flex">
                       <div class="form-group mb-0" <?php echo @$display ?>>
                            <label for="date" class="label3">Completion Date :</label>
                            <input class="datepicker" id="date" type="text" name="date" value="<?php echo $cdate ?>" required autocomplete="off" readonly>
                        </div>
                   
                        <div class="form-group mb-0 duedate" style="display: none;">
                            <label for="due_date" class="label3">Due Date :</label>
                             <input class="datepicker" type="text" value="<?php echo $data2duedate ?>" name="due_date" class="form-control" id="due_date">
                        </div>
                          <input type="hidden" value="<?php echo $data['recurring_duration'] ?>" class="recurring_duration_Hidden" name="recurring_duration_Hidden">
                          <?php $recurring =  $data2['recurring']; ?>
                         <div class="form-group mb-0 Edit_recurring_duration" style="display: none;">  
                            <label for="recurring_duration" class="label3">Edit Recurring Duration :</label>
                            <select name="recurring_duration" id="recurring_duration" class="recurring_duration form-control">
<option value="" >Select Recurring Duration</option>
<option <?php if($recurring == 'Once Check'){echo 'selected';} ?> value="Once Check">Once Check</option>
<option <?php if($recurring == 'Once">'){echo 'selected';} ?> value="Once">Once</option>
<option <?php if($recurring == 'No Recurrence'){echo 'selected';} ?> value="No Recurrence">No Recurrence</option>
<option <?php if($recurring == '1 day'){echo 'selected';} ?> value="1 day">1 day</option>
<option <?php if($recurring == '1 week'){echo 'selected';} ?> value="1 week">1 week</option>
<option <?php if($recurring == '2 weeks'){echo 'selected';} ?> value="2 weeks">2 weeks</option>
<option <?php if($recurring == '3 weeks'){echo 'selected';} ?> value="3 weeks">3 weeks</option>
<option <?php if($recurring == '1 Month'){echo 'selected';} ?> value="1 Month">1 Month</option>
<option <?php if($recurring == '2 Months'){echo 'selected';} ?> value="2 Months">2 Months</option>
<option <?php if($recurring == '3 Months'){echo 'selected';} ?> value="3 Months">3 Months</option>
<option <?php if($recurring == '4 Months'){echo 'selected';} ?> value="4 Months">4 Months</option>
<option <?php if($recurring == '6 Months'){echo 'selected';} ?> value="6 Months">6 Months</option>
<option <?php if($recurring == '12 Months'){echo 'selected';} ?> value="12 Months">12 Months</option>
<option <?php if($recurring == '24 Months'){echo 'selected';} ?> value="24 Months">24 Months</option>
<option <?php if($recurring == '36 Months'){echo 'selected';} ?> value="36 Months">36 Months</option>
<option <?php if($recurring == '60 Months'){echo 'selected';} ?> value="60 Months">60 Months</option>
<option <?php if($recurring == ''){echo 'selected';} ?> value="">Default </option>
                               
                            </select>
                        </div>
                        <!-- form-group -->
                        <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['ccalendar'] == 'edit' || $_SESSION['superUser']['ccalendar'] == 'full'){ 
                            $selected = '';
                            if(strpos($data2['assignto'],'-1') !== false){
                                $selected = 'selected';
                            }
                        ?>
                        <div class="form-group mb-0">
                            <label for="assignto" class="label3">Delegate Task :</label>
                            <select name="assignto" id="assignto" class="assignto form-control">
                                <option value="" >Select Employee</option>
                                <option <?php echo "value='-1.$_SESSION[currentUser]' $selected" ?>>All Employee</option>
                                <?php echo $functions->allEmployee($_SESSION['currentUser'],$data2['assignto']) ?>
                                <option >Unassigned</option>
                                <option disabled>--Groups</option>
                                <?php echo $functions->allGroups($_SESSION['currentUser'],$data2['assignto']) ?>
                            </select>
                        </div>
                        <!-- form-group -->
                    <?php } else { echo "<input type='hidden' value='$data2[assignto]' name='assignto'>";} ?>
                    </div>
                    <div class="sub-form">
                        <?php 
                    if(!empty($data3)){
                        echo "<div class='form_heading'><h4>E-Form</h4></div>";
                    }
                    $var = false;
                    foreach ($data3 as $key => $value) {
                    $question_id =  $value['id']; 
		$sql4 = "SELECT * FROM `usereventForms` WHERE `ue_id`='$id' AND `q_id`='$question_id'";
	    $data4 = $dbF->getRow($sql4);



	// echo    $sql8 = " SELECT * FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` =  (SELECT `ue_id` FROM `usereventForms` ORDER BY ue_id DESC LIMIT 1)";  

if(empty($data2['usereventFormsPK'])){
// $sql8 = "SELECT ue_id,q_id FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` = (SELECT max(`ue_id`) FROM `usereventForms` where `user` = '$user' AND `q_id`='$question_id' AND title_id = '$data[id]'  ORDER BY ue_id DESC LIMIT 1)";



// $sql8 = "SELECT ue_id,q_id FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` = $usereventFormsPK";

	$sql9 = "SELECT * FROM `usereventForms` WHERE ue_id ='$usereventFormsPK' AND `q_id` = '$question_id' and `user` = '$user'" ;
	$data9 = $dbF->getRow($sql9);


}else{
// $sql8 = "SELECT ue_id,q_id FROM `usereventForms` WHERE `user` = '$user' AND `q_id`='$question_id' AND `ue_id` = $data2[usereventFormsPK]";


	$sql9 = "SELECT * FROM `usereventForms` WHERE ue_id ='$data2[usereventFormsPK]' AND `q_id` = '$question_id' and `user` = '$user'" ;
	$data9 = $dbF->getRow($sql9);



}











    
                             
                        
            //              $data8['ue_id'];
                      
                           
                     
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
                            <div class="form-group-radio col-6 col-md-3">
                                <label>&nbsp;</label>
                                <div class="radio_btnbox">
                                    <?php 
                                    $olddata=0;
                                    if(@$data4['radio']!="" || $approved_event==1){
                                        $datatmp=@$data4['radio'];
                                    }else{
                                        $datatmp=@$data9['radio'];
                                        $olddata=1;
                                    }?> 
                                    <div class="form-group form-radio mb-0">
                                        <label for="f<?php echo $key ?>1" class="rad-label">
                                            <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>1" type="radio" class="rad-input" value="Yes" <?php if($datatmp=="Yes" )echo "checked" ; ?>>
                                            <div class="rad-design"></div>
                                            <div class="rad-text">Yes</div>
                                        </label>
                                    </div>
                                    <div class="form-group form-radio mb-0">
                                        <label for="f<?php echo $key ?>2" class="rad-label">
                                            <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>2" type="radio" class="rad-input" value="No" <?php if($datatmp=="No" )echo "checked" ; ?>>
                                            <div class="rad-design"></div>
                                            <div class="rad-text">No</div>
                                        </label>
                                    </div>

                                    <div class="form-group form-radio mb-0">
                                        <label for="f<?php echo $key ?>3" class="rad-label">
                                            <input type="radio" class="rad-input" name="rad">
                                            <input name="form[<?php echo $key ?>][radio]" id="f<?php echo $key ?>3" type="radio" class="rad-input" value="N/A" <?php if($datatmp=="N/A" )echo "checked" ; ?>>
                                            <div class="rad-design"></div>
                                            <div class="rad-text">N/A</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <div class="form-group-flex">
                            <?php if($value['date'] == "Date"){ ?>
                                <div class="form-group mb-0">
                                    <?php if(@$data4['date']!="" || $approved_event==1){
                                        $datatmp=@$data4['date'];
                                    }else{
                                        $datatmp=@$data9['date'];
                                        $olddata=1;
                                    }?>
                                    <label for="date" class="label3">Date :</label>
                                    <input name="form[<?php echo $key ?>][date]" class="form-control" type="date" value="<?php echo $datatmp ?>" id="date">
                                </div>
                            <!-- form-group -->
                            <?php } ?>
                           
                            <?php if($value['time'] == "Time"){ ?>
                            <div class="form-group mb-0">
                                <?php if(@$data4['time']!="" || $approved_event==1){
                                        $datatmp=@$data4['time'];
                                    }else{
                                        $datatmp=@$data9['time'];
                                        $olddata=1;
                                    }?>
                                <label for="time" class="label3">Time :</label>
                                <input name="form[<?php echo $key ?>][time]" class="form-control" type="time" id="time" value="<?php echo $datatmp ?>">
                            </div>
                            <!-- form-group -->
                            <?php } ?>
                            <?php if($value['field1'] != ""){ ?>
                            <div class="form-group mb-0">
                                <?php if($data4['field1'] !="" || $approved_event==1){
                                        $datatmp=$data4['field1'];
                                        $olddata=0;
                                    }else{
                                        $datatmp=$data9['field1'];
                                        $olddata=1;
                                    }?>
                              <label for="<?php echo $value['field1']?>" class="label3">
                                    <?php echo $value['field1']?></label>
                                <input name="form[<?php echo $key ?>][field1]" type="text" class="require form-control" value="<?php echo $datatmp ?>">
                            </div> 

                            <!-- form-group -->
                            <?php } ?>


                            <?php if($value['field2'] != ""){ ?>
                            <div class="form-group mb-0">
                                <?php if($data4['field2']!="" || $approved_event==1){
                                        $datatmp=$data4['field2'];
                                    }else{
                                        $datatmp=$data9['field2'];
                                    }?>
                                <label for="<?php echo $value['field2']?>" class="label3">
                                    <?php echo $value['field2']?></label>
                                <input name="form[<?php echo $key ?>][field2]" type="text" class="require form-control" value="<?php echo $datatmp ?>">
                            </div> 
                            <?php } ?>
                        </div>

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
                    <div class="form-group DelScripted">
                        <?php
                if(!empty($data2)){

                    if($data2['file'] != '#' && trim($data2['file']) != ''){
                        echo "<input type='hidden' name='old_file' value='$data2[file]'>";
                        
                        
                           if(in_array("Audit", $auditEvents) ){ 
                        echo $functions->downloadButton($data2['file'],$id,$true);}
                    }
                }
                ?>
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
                    <?php if($data['category'] == 'Practice Policies'){ ?>
                    <label class="ccheckbox"><input type="checkbox" name="desc" value="Yes"><span class="cmark"></span>I confirm me and all staff have read, understood and signed the policies acknowledgement sheet.</label>
                    <?php }else{ ?>
                    <div class="form-group-fw">
                    <div class="form-group mb-0">
                        <label for="desc" class="label3">Action Plan</label>
                        <textarea name="desc" id="desc" class="form-control"><?php echo $data2['desc'];?></textarea>
                    </div>
                    </div>
                    <div class="form-group-fw">
                    <div class="form-group">
                        <label for="comment" class="label3">Comment:</label>
                        <textarea name="comment" id="comment" class="require form-control"><?php echo $data2['comment'];?></textarea>
                    </div>
                    </div>
                    <!-- form-group -->
                    <!-- form-group -->
                    <?php } ?>

<?php if(
    (($_SESSION['currentUserType'] == 'Employee' || @$_SESSION['superUser']['ccalendar'] == 'full') && $data2['due_date'] <= date('Y-m-d' )) || 
    ($data2['due_date'] <= date('Y-m-d' ) && ($_SESSION['currentUserType'] == 'Practice' || $_SESSION['currentUserType'] == 'Master'  ))
)  { 



?>
                    <label class="ccheckbox"><input type="checkbox" name="confirm" value="1"><span class="cmark"></span>Are You sure this task has been completed (once ticked you can't delete)</label>

                    <?php } 
                    if($_SESSION['userType']=='Trial')
                    { 
                    echo'<input type="button" class="submit_class" value="Submit Information" onclick="alertbx()" name="" style="display: inline-block;">&nbsp;&nbsp;
                    <input type="button" class="submit_class" value="Save Information" name="" onclick="alertbx()" style="display: inline-block;">';
                    }else{?>
                    <input type="submit" class="submit_class" value="Submit Information" name="edit" style="display: inline-block;">&nbsp;&nbsp;
                    <input type="submit" class="submit_class" value="Save Information" name="edit" style="display: inline-block;">
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
          $('.sub-form').slideDown(600);
          $('.form-group ').slideDown(600);
       
    } else {
        $('.sub-form').slideUp(600);
        $('.form-group ').slideUp(600);
    
    }
});
$('.form-right-inner > button').on('click', function() {
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