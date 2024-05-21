<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg  = "";
$functions->insertDirectory();
$functions->insertRooms();
$functions->insertRoomsEDIT();
$functions->insertGroup();
$functions->insertGroupEDIT();
$functions->equipmentDirectory();
$chk  = $functions->practiceProfile();
$onboardCheck  = $functions->onboardingForm();
 // echo "<pre>";
 // print_r($_POST);
 // echo "</pre>";
if($chk){
    $msg = "Practice Profile Update Successfully";
}
if($onboardCheck){
    $msg = "Onboarding Page Data Updated Successfully";
}
// include_once('header.php'); 

include'dashboardheader.php';
 $user = $_SESSION['currentUser'];

  if ($_SESSION['currentUserType'] !='Employee') {
                      $u_id = $_SESSION['currentUser'];
                  }else
                  {
                      $u_id = $_SESSION['webUser']['id'];
                  }

$d_user = $dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ?  AND `type`='superuser_access'",array($u_id));

$d = $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`= ? AND `setting_name`='practice name'",array($user));
$practice_name = $d[0];

$sql = "SELECT * FROM `practiceprofile` WHERE `user_id` =  ? ";
$row = $dbF->getRow($sql,array($user));
if(empty($row)){
   $sql  = 'INSERT INTO `practiceprofile`(`user_id`,`practice_name`, `practice_address`, `telephone`, `staff`, `information`, `surgeries`, `room`, `autoclave`, `disinfectors`, `ultrasonic`, `compressor`, `npm`, `sedation`, `domiciliary`, `practice_logo`, `team_image`) VALUES ("'.$user.'","'.$practice_name.'","","","","","","","","","","","","","","#","#")';
    $dbF->setRow($sql);
    $row['team_image'] = '#';
    $row['practice_logo'] = '#';
}
?>
<div class="index_content mypage health_form">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side profile">
            <div class="right_side_top">
                <h3 class="main-heading_">Practice Profile</h3>
                <div class="change-session">
                    <?php
                    //$functions->changeSession();
                    ?>
                    <?php
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data && $_SESSION['currentUserType'] !='Employee')
                    { ?>
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                    </div>
                    <?php } ?>
                </div>
                <!-- change-session -->
               
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
<?php //if ($_SESSION['currentUserType'] != 'Employee' || $d_user['allow'] == 'full') {
if ($_SESSION['currentUserType'] != 'Employee'){
?>
              <div id="tabs">
                        <ul>
                         
                            <li><a active href="#profile-detail">Profile Detail</a></li>
                            <li><a href="#holiday">Holiday</a></li>
                            <li><a href="#contact-directory">Contact Directory</a></li>
                            <li><a href="#equipmemt-directory">Equipment Directory</a></li>
                            <li><a href="#room-management">Room Management</a></li>
                            <li><a href="#onboarding">Onboarding</a></li>
                            <li><a href="#tabs-7">Group Management</a></li>
                           
                              </ul>  </div> 
                           <div id="profile-detail">
            <form class="profile" method="post" action="practice-profile#profile-detail" enctype="multipart/form-data">
<?php }else{ echo'<div class="profile">'; } ?>
                <?php echo $functions->setFormToken('practiceProfile',false); ?>
                <div class="row">
                    
                    <div class="form-group col-12 col-sm-6">
                        <label>Name of Practice :</label>
                        <input type="text" name="practice_name" value="<?php echo @$row['practice_name'] ?>">
                    </div>
                    <div class="form-group col-12 col-sm-6">
                        <label>Name of Practice Manager :</label>
                        <input type="text" name="practice_manager_name" value="<?php echo @$row['practice_manager_name'] ?>">
                    </div>
                    
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Substitute Lead Name:</label>
                        <input type="text" name="subt_name" value="<?php echo @$row['subtname'] ?>">
                    </div>
                    
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Address of practice :</label>
                        <input type="text" name="practice_address" value="<?php echo @$row['practice_address'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Telephone Number :</label>
                        <input type="text" name="telephone" value="<?php echo @$row['telephone'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Staff :</label>
                        <input type="text" name="staff" value="<?php echo @$row['staff'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Practice Information :</label>
                        <input type="text" name="information" value="<?php echo @$row['information'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Surgeries :</label>
                        <input type="text" name="surgeries" value="<?php echo @$row['surgeries'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Decontamination Room :</label>
                        <input type="text" name="room" value="<?php echo @$row['room'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Autoclave :</label>
                        <input type="text" name="autoclave" value="<?php echo @$row['autoclave'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Washer disinfectors :</label>
                        <input type="text" name="disinfectors" value="<?php echo @$row['disinfectors'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Ultrasonic :</label>
                        <input type="text" name="ultrasonic" value="<?php echo @$row['ultrasonic'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Compressor :</label>
                        <input type="text" name="compressor" value="<?php echo @$row['compressor'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>NHS / Private / Mixed :</label>
                        <input type="text" name="npm" value="<?php echo @$row['npm'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Sedation Offered :</label>
                        <input type="text" name="sedation" value="<?php echo @$row['sedation'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Domiciliary Visit Offered :</label>
                        <input type="text" name="domiciliary" value="<?php echo @$row['domiciliary'] ?>">
                    </div> 
                     <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Number of Radiation Machines :</label>
                        <input type="text" name="number_of_radiation_machines" value="<?php echo @$row['number_of_radiation_machines'] ?>">
                    </div> 
                     <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Serial Number :</label>
                        <input type="text" name="serial_number" value="<?php echo @$row['serial_number'] ?>">
                    </div> 
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Name of RPA Advisor :</label>
                        <input type="text" name="name_of_RPA_advisor" value="<?php echo @$row['name_of_RPA_advisor'] ?>">
                    </div> 
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Name of RPA Supervisor :</label>
                        <input type="text" name="name_of_RPA_supervisor" value="<?php echo @$row['name_of_RPA_supervisor'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Last Service Date :</label>
                        <input type="text" name="Last_service_date" value="<?php echo @$row['Last_service_date'] ?>">
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <label>Laser Protection Advisor :</label>
                        <input type="text" name="laser_protection_advisor" value="<?php echo @$row['laser_protection_advisor'] ?>">
                    </div>
                    <!-- form-group -->
                     <?php 
                //   if ($_SESSION['currentUserType'] != 'Master'){  
                $daysss = $row['dayoff'];
                $offday = explode(",",$daysss);
                // } 
                ?>
             
                 <div class="form-group col-12 col-sm-6">
                        <h3>Weekends</h3>
                        <strong><p>Please tick your practice non-working days</p></strong><br>

                    <label class='ccheckbox'>
                    <input type='checkbox' value='1' name="dayoff[]" <?php if (in_array("1", $offday))  {echo "checked"; }?>>
                    <span class='cmark'></span>Monday
                    </label>
                    <label class='ccheckbox'>
                    <input type='checkbox' value='2' name="dayoff[]" <?php if (in_array("2", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Tuesday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='3' name="dayoff[]" <?php if (in_array("3", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Wednesday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='4' name="dayoff[]" <?php if (in_array("4", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Thusday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='5' name="dayoff[]" <?php if (in_array("5", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Friday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='6' name="dayoff[]" <?php if (in_array("6", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Saturday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='7' name="dayoff[]" <?php if (in_array("7", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Sunday
                    </label>
                   
                    </div>
                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6"></div> 
                        <div class="form-group col-12 col-sm-6">
                        <?php if(@$row['practice_logo'] != "#") { ?>
                        <img src="<?php echo WEB_URL."/images/".@$row['practice_logo'] ?>">
                        <?php } ?>
                        <input type="hidden" name="old_practice_logo" value="<?php echo @$row['practice_logo'] ?>">
                       <?php //if ($_SESSION['currentUserType'] != 'Employee' || $d_user['allow'] == 'full') {
                       if ($_SESSION['currentUserType'] != 'Employee') {
                       ?>

                        <label>Practice Logo :</label>
                        <div class="file">
                            <input type="file" name="practice_logo">
                            <i class="fas fa-paperclip"></i>
                            <div>Upload</div>
                        </div>
                      <?php } ?>
                    </div>

                    <!-- form-group -->
                    <div class="form-group col-12 col-sm-6">
                        <?php if(@$row['team_image'] != "#") { ?>
                        <img src="<?php echo WEB_URL."/images/".@$row['team_image'] ?>">
                        <?php } ?>
                        <input type="hidden" name="old_team_image" value="<?php echo @$row['team_image'] ?>">
                        <?php //if ($_SESSION['currentUserType'] != 'Employee' || $d_user['allow'] == 'full') {
                        if ($_SESSION['currentUserType'] != 'Employee') {
                        ?>

                        <label>Team Picture :</label>
                        <div class="file">
                            <input type="file" name="team_image">
                            <i class="fas fa-paperclip"></i>
                            <div>Upload</div>
                        </div>
                   <?php } ?>
                    </div>
                    <!-- form-group -->
                </div>
                <?php 
                 
                


                // if ($_SESSION['currentUserType'] != 'Employee' || $d_user['allow'] == 'full' || $d_user['allow'] == 'full' ) {
                if ($_SESSION['currentUserType'] != 'Employee' ) {

  ?>
                  



<div class="form-group col-sm-12">
<label>PIN code Verification</label>

<div class="covidshowbtn">
<div class="switch-field">
<input type="radio" id="radio-one" name="pinVarification" value="1" <?php  if($row['pinVarification']=="1" )echo "checked" ; ?>  />
<label for="radio-one">Enable</label>
<input type="radio" id="radio-two" name="pinVarification" value="0" <?php  if($row['pinVarification']=="0" )echo "checked" ; ?>   />
<label for="radio-two">Disable</label>
</div>

</div>
 <input type="submit" class="submit_class" value="Submit Information" name="submit">
</div>



               


            </form>
            </div>
        <div id="holiday">
            <form method="post" class="add_details" action="practice-profile#holiday" enctype="multipart/form-data" >
            <?php echo $functions->setFormToken('holidays',false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <div class="row">
           <div class="form-group col-md-6">
                <label>Date:</label>
                <input class="datepicker date"  type="text" value="" placeholder="Date From" name="datef" required autocomplete="off" >
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Reason:</label>
                <input class=" reason"  type="text" value="" placeholder="Reason" name="reason" required autocomplete="off">
            </div>
            <!-- form-group -->
            
              <div class="form-group col-md-6">
                        <label>Comment</label>
                        <textarea class="comment" name="comment"></textarea>
                    </div>
         
            <div class="form-group col-12">
           
           
          <button style="display: inline-block;" class="submit_class cr" id="" value="Submit Information" name="submit">Submit Information</button>
            <div class="modal-body">
                <p class="statusMsg"></p>
               
            </div>
            
            </div> 
            <!-- form-group -->
            </div>
        </form>
         <?php echo $functions->isholidayShow($user);
        
        


         ?>
        </div>








         <div id="contact-directory">
            <form method="post" class="add_directory" action="practice-profile#contact-directory" id="add_directory">
          
            <div class="row">
           <div class="form-group col-md-6">
                <label>Name:</label>
                <input class="add_directory_name" id="add_directory_name" type="text" value="" placeholder="Name" name="add_directory_name" required autocomplete="off">
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Contact:</label>
                <input class="add_directory_contact" id="add_directory_contact" type="text" value="" placeholder="Contact" name="add_directory_contact" required autocomplete="off">
            </div>
            <!-- form-group -->
            
             
         
            <div class="form-group col-12">
           
           
          <button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>
            
            
            </div> 
            <!-- form-group -->
            </div>
        </form>
         <?php echo '<div class="table_overflow"><table class="table table-hover updateTable">
<thead>
<tr>
 
<th>Name</th>
<th>Contact</th>
<th>Action</th>
   
</tr>    
</thead>
<tbody class="table_data1">';
$user =  intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `insertDirectory` WHERE `practiceID` = '$user' ORDER BY `insertDirectory`.`id` DESC";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$name = $val['name'];
$id = $val['id'];
$phone = $val['phone'];
echo "<tr>
   <td>" . $name . "</td>
   <td>" . $phone . "</td>
   <td><a data-id='$id' onclick='AjaxDelContactScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>
                <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
            </a></td>
   ";


echo "</tr>";
}
echo "</tbody></table></div>";


         ?>
        </div>



              

<div id="equipmemt-directory">             
<form method="post" class="add_equipmemt_directory" action="practice-profile#equipmemt-directory" id="add_equipmemt_directory">
          
            <div class="row">
           <div class="form-group col-md-6">
                <label>Name:</label>
                <input class="equipment_directory_name" id="equipment_directory_name" type="text" value="" placeholder="Name" name="equipment_directory_name" required autocomplete="off">
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                <label>Serial No:</label>
                <input class="serial_number" id="serial_number" type="text" value="" placeholder="Serial number" name="serial_number" required autocomplete="off">
            </div>
            <!-- form-group -->
            <div class="form-group col-md-6">
                        <label>Detail</label>
                        <textarea class="detail" id="detail" name="detail"></textarea>
                    </div>
             
         
            <div class="form-group col-12">
           
           
          <button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>
            
            
            </div> 
            <!-- form-group -->
            </div>
        </form>

  <?php echo '<div class="table_overflow"><table class="table table-hover updateTable2">
<thead>
<tr>
 
<th>Name</th>
<th>Serial Number</th>
<th>Detail</th>
<th>Action</th>
 
   
</tr>    
</thead>
<tbody class="table_dat1">';
$user =  intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `EquipmentDirectory` WHERE `practiceID` = '$user' ORDER BY `EquipmentDirectory`.`id` DESC";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$name = $val['name'];
$id = $val['id'];
$serial_num = $val['serial_num'];
$detail=$val['detail'];
echo "<tr>
   <td>" . $name . "</td>
   <td>" . $serial_num . "</td>
   <td>" . $detail . "</td>
    <td><a data-id='$id' onclick='AjaxDelEquipmentScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>
                <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
            </a></td>
   ";


echo "</tr>";
}
echo "</tbody></table></div>";


         ?>
</div>






<div id="room-management">
<form method="post" class="add_room" action="practice-profile#room-management" id="add_room">

<div class="row">
<div class="form-group col-md-6">
<label>Name:</label>
<input class="add_room_name" id="add_room_name" type="text" value="" placeholder="Name" name="add_room_name" required autocomplete="off">
</div>
<!-- form-group -->
<div class="form-group col-md-6">
<label>Color:</label>


<select name="changeColor" class="changeColor" id="changeColor">
                 

<option value="Black" style="background:black;">Black</option>             
<option value="Navy" style="background:navy;">Navy</option>
<option value="DarkBlue" style="background:darkBlue;">DarkBlue</option>        
<option value="MediumBlue" style="background:MediumBlue;">MediumBlue</option>
<option value="Blue" style="background:blue;">Blue</option>
<option value="DarkGreen" style="background:darkGreen;">DarkGreen</option>
<option value="Green" style="background:green;">Green</option>
<option value="Teal" style="background:teal;">Teal</option>
<option value="DarkCyan" style="background:darkcyan;">DarkCyan</option>
<option value="DeepSkyBlue" style="background:deepskyblue;">DeepSkyBlue</option>
<option value="DarkTurquoise" style="background:darkturquoise;">DarkTurquoise</option>
<option value="MediumSpringGreen" style="background:mediumspringgreen;">MediumSpringGreen</option>
<option value="Lime" style="background:lime;">Lime</option>
<option value="SpringGreen" style="background:springgreen;">SpringGreen</option>
<option value="Aqua" style="background:aqua;">Aqua</option>
<option value="Cyan" style="background:cyan;">Cyan</option>
<option value="MidnightBlue" style="background:midnightblue;">MidnightBlue</option>
<option value="DodgerBlue" style="background:dodgerblue;">DodgerBlue</option>
<option value="LightSeaGreen" style="background:lightseagreen;">LightSeaGreen</option>
<option value="ForestGreen" style="background:forestgreen;">ForestGreen</option>
<option value="SeaGreen" style="background:seagreen;">SeaGreen</option>
<option value="DarkSlateGray" style="background:darkslategray;">DarkSlateGray</option>
<option value="arkSlateGrey" style="background:arkslategrey;">DarkSlateGrey</option>
<option value="LimeGreen" style="background:limegreen;">LimeGreen</option>
<option value="MediumSeaGreen" style="background:mediumseagreen;">MediumSeaGreen</option>
<option value="Turquoise" style="background:turquoise;">Turquoise</option>
<option value="RoyalBlue" style="background:royalblue;">RoyalBlue</option>
<option value="SteelBlue" style="background:steelblue;">SteelBlue</option>
<option value="DarkSlateBlue" style="background:darkslateblue;">DarkSlateBlue</option>
<option value="MediumTurquoise" style="background:mediumturquoise;">MediumTurquoise</option>
<option value="Indigo" style="background:indigo;">Indigo  </option>  
<option value="DarkOliveGreen" style="background:darkolivegreen;">DarkOliveGreen</option>
<option value="CadetBlue" style="background:cadetblue;">CadetBlue</option>
<option value="CornflowerBlue" style="background:cornflowerblue;">CornflowerBlue</option>
<option value="RebeccaPurple" style="background:rebeccapurple;">RebeccaPurple</option>
<option value="MediumAquaMarine" style="background:mediumaquamarine;">MediumAquaMarine</option>
<option value="DimGray" style="background:dimgray;">DimGray</option>
<option value="DimGrey" style="background:dimgrey;">DimGrey</option>
<option value="SlateBlue" style="background:slateblue;">SlateBlue</option>
<option value="OliveDrab" style="background:olivedrab;">OliveDrab</option>
<option value="SlateGray" style="background:slategray;">SlateGray</option>
<option value="SlateGrey" style="background:slategrey;">SlateGrey</option>
<option value="LightSlateGray" style="background:lightslategray;">LightSlateGray</option>
<option value="LightSlateGrey" style="background:lightslategrey;">LightSlateGrey</option>
<option value="MediumSlateBlue" style="background:mediumslateblue;">MediumSlateBlue</option>
<option value="LawnGreen" style="background:lawngreen;">LawnGreen</option>
<option value="Chartreuse" style="background:chartreuse;">Chartreuse</option>
<option value="Aquamarine" style="background:aquamarine;">Aquamarine</option>
<option value="Maroon" style="background:Maroon;">Maroon</option>
<option value="Purple" style="background:purple;">Purple</option>
<option value="Olive" style="background:olive;">Olive</option>
<option value="Gray" style="background:gray;">Gray</option>
<option value="Grey" style="background:grey;">Grey</option>
<option value="SkyBlue" style="background:skyblue;">SkyBlue</option>
<option value="LightSkyBlue" style="background:lightskyblue;">LightSkyBlue</option>
<option value="BlueViolet" style="background:blueviolet;">BlueViolet</option>
<option value="DarkRed" style="background:darkred;">DarkRed</option>
<option value="DarkMagenta" style="background:darkmagenta;">DarkMagenta</option>
<option value="SaddleBrown" style="background:saddlebrown;">SaddleBrown</option>
<option value="DarkSeaGreen" style="background:darkseagreen;">DarkSeaGreen</option>
<option value="LightGreen" style="background:lightgreen;">LightGreen</option>
<option value="MediumPurple" style="background:mediumpurple;">MediumPurple</option>
<option value="DarkViolet" style="background:darkviolet;">DarkViolet</option>
<option value="PaleGreen" style="background:palegreen;">PaleGreen</option>
<option value="DarkOrchid" style="background:darkorchid;">DarkOrchid</option>
<option value="YellowGreen" style="background:yellowgreen;">YellowGreen</option>
<option value="Sienna" style="background:sienna;">Sienna</option>
<option value="Brown" style="background:brown;">Brown</option>
<option value="DarkGray" style="background:darkgray;">DarkGray</option>
<option value="DarkGrey" style="background:darkgrey;">DarkGrey</option>
<option value="LightBlue" style="background:lightblue;">LightBlue</option>
<option value="GreenYellow" style="background:greenyellow;">GreenYellow</option>
<option value="PaleTurquoise" style="background:paleturquoise;">PaleTurquoise</option>
<option value="LightSteelBlue" style="background:lightsteelblue;">LightSteelBlue</option>
<option value="PowderBlue" style="background:powderblue;">PowderBlue</option>
<option value="FireBrick" style="background:firebrick;">FireBrick</option>
<option value="DarkGoldenRod" style="background:darkgoldenrod;">DarkGoldenRod</option>
<option value="MediumOrchid" style="background:mediumorchid;">MediumOrchid</option>
<option value="RosyBrown" style="background:rosybrown;">RosyBrown</option>
<option value="DarkKhaki" style="background:darkkhaki;">DarkKhaki</option>
<option value="Silver" style="background:silver;">Silver</option>
<option value="MediumVioletRed" style="background:mediumvioletred;">MediumVioletRed</option>
<option value="IndianRed" style="background:indianred;">IndianRed </option> 
<option value="Peru" style="background:peru;">Peru</option>
<option value="Chocolate" style="background:chocolate;">Chocolate</option>
<option value="Tan" style="background:tan;">Tan</option>
<option value="TanLightGray" style="background:tanlightgray;">LightGray</option>
<option value="LightGrey" style="background:lightgrey;">LightGrey</option>
<option value="Thistle" style="background:thistle;">Thistle</option>
<option value="Orchid" style="background:orchid;">Orchid</option>
<option value="GoldenRod" style="background:goldenrod;">GoldenRod</option>
<option value="PaleVioletRed" style="background:palevioletred;">PaleVioletRed</option>
<option value="Crimson" style="background:crimson;">Crimson</option>
<option value="Gainsboro" style="background:gainsboro;">Gainsboro</option>
<option value="Plum" style="background:plum;">Plum</option>
<option value="BurlyWood" style="background:burlywood;">BurlyWood</option>
<option value="LightCyan" style="background:lightcyan;">LightCyan</option>
<option value="Lavender" style="background:lavender;">Lavender</option>
<option value="DarkSalmon" style="background:darksalmon;">DarkSalmon</option>
<option value="Violet" style="background:Violet;">Violet</option>
<option value="PaleGoldenRod" style="background:palegoldenrod;">PaleGoldenRod</option>
<option value="LightCoral" style="background:lightcoral;">LightCoral</option>
<option value="Khaki" style="background:khaki;">Khaki</option>
<option value="AliceBlue" style="background:aliceblue;">AliceBlue</option>
<option value="HoneyDew" style="background:honeydew;">HoneyDew</option>
<option value="Azure" style="background:azure;">Azure</option>
<option value="SandyBrown" style="background:sandybrown;">SandyBrown</option>
<option value="Wheat" style="background:wheat;">Wheat</option>
<option value="Beige" style="background:beige;">Beige</option>
<option value="WhiteSmoke" style="background:whitesmoke;">WhiteSmoke</option>
<option value="MintCream" style="background:mintcream;">MintCream</option>
<option value="GhostWhite" style="background:ghostwhite;">GhostWhite</option>
<option value="Salmon" style="background:salmon;">Salmon</option>
<option value="AntiqueWhite" style="background:antiquewhite;">AntiqueWhite</option>
<option value="Linen" style="background:linen;">Linen</option>
<option value="LightGoldenRodYellow" style="background:lightgoldenrodyellow;">LightGoldenRodYellow</option>
<option value="OldLace" style="background:oldLace;">OldLace</option>
<option value="Red" style="background:red;">Red</option>
<option value="Fuchsia" style="background:fuchsia;">Fuchsia</option>
<option value="Magenta" style="background:magenta;">Magenta</option>
<option value="DeepPink" style="background:deeppink;">DeepPink</option>
<option value="OrangeRed" style="background:orangered;">OrangeRed</option>
<option value="Tomato" style="background:tomato;">Tomato</option>
<option value="HotPink" style="background:hotpink;">HotPink</option>
<option value="Coral" style="background:coral;">Coral</option>
<option value="DarkOrange" style="background:darkorange;">DarkOrange</option>
<option value="LightSalmon" style="background:lightsalmon;">LightSalmon</option>
<option value="Orange" style="background:orange;">Orange</option>
<option value="LightPink" style="background:lightPink;">LightPink</option>
<option value="Pink" style="background:pink;">Pink</option>
<option value="Gold" style="background:gold;">Gold</option>
<option value="PeachPuff" style="background:peachpuff;">PeachPuff</option>
<option value="NavajoWhite" style="background:navajowhite;">NavajoWhite</option>
<option value="Moccasin" style="background:moccasin;">Moccasin</option>
<option value="Bisque" style="background:bisque;">Bisque</option>
<option value="MistyRose" style="background:mistyrose;">MistyRose</option>
<option value="BlanchedAlmond" style="background:blanchedalmond;">BlanchedAlmond</option>
<option value="PapayaWhip" style="background:papayawhip;">PapayaWhip</option>
<option value="LavenderBlush" style="background:lavenderblush;">LavenderBlush</option>
<option value="SeaShell" style="background:seashell;">SeaShell</option>
<option value="Cornsilk" style="background:cornsilk;">Cornsilk</option>
<option value="LemonChiffon" style="background:lemonchiffon;">LemonChiffon</option>
<option value="FloralWhite" style="background:floralwhite;">FloralWhite</option>
<option value="Snow" style="background:snow;">Snow</option>
<option value="Yellow" style="background:yellow;">Yellow</option>
<option value="LightYellow" style="background:lightyellow;">LightYellow</option>
<option value="Ivory" style="background:ivory;">Ivory</option>
<option value="White" style="background:white;">White</option>
 
                 </select>


</div>
<!-- form-group -->


<div class="form-group col-md-6">
<label>Description:</label>
<input class="add_room_desc" id="add_room_desc" type="text" value="" placeholder="Description" name="add_room_desc" required autocomplete="off">
</div>
<!-- form-group -->



<div class="form-group col-12">


<button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>


</div> 
<!-- form-group -->
</div>
</form>
<?php echo '<div class="table_overflow"><table class="table table-hover updateTableroom">
<thead>
<tr>

<th>Name</th>
<th>Description</th>
<th>Color</th>
<th>Action</th>

</tr>    
</thead>
<tbody class="table_data1">';
$user =  intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `insertRooms` WHERE `practiceID` = '$user' ORDER BY `insertRooms`.`id` DESC";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$name = $val['name'];
$id = $val['id'];
$desc = $val['desc'];
$color = $val['color'];
echo "<tr style='border-left:10px solid ".$color.";'>
<td>" . $name . "





</td>
<td>" . $desc . "</td>
<td>" . $color . "</td>

<td>
<a data-toggle='tooltip' title='Edit'  class='ablue' style='margin-right: 5px;' id=".$id." onclick='insertRoomsEDIT(this.id)'><i class='fas fa-edit'></i></a>

<a data-id='$id' onclick='AjaxDelRoomScript(this);' class='btn edit_btn secure_delete' style='margin-top: -5px;'>
                <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
            </a></td>
";


echo "</tr>";
}
echo "</tbody></table></div>";


?>
</div>

<div id="onboarding">
<form method="post"  action="practice-profile#onboarding" enctype="multipart/form-data" >
<?php echo $functions->setFormToken('onboardingForm',false); ?>
<div class="row">
<div class="form-group col-md-12 col-sm-6">
        <h3>Welcome Page Details:</h3>
        <div class="form-group col-md-12 col-sm-6">
        <?php if(@$row['welcome_image'] != "#") { ?>
        <img src="<?php echo WEB_URL."/images/".@$row['welcome_image'] ?>">
        <?php } ?>
        <input type="hidden" name="old_welcome_image" value="<?php echo @$row['welcome_image'] ?>">
       <?php if ($_SESSION['currentUserType'] != 'Employee' || $d_user['allow'] == 'full') {?>

        <label>Welcome Image :</label>
        <div class="file">
            <input type="file" name="welcome_image">
            <i class="fas fa-paperclip"></i>
            <div>Upload</div>
        </div>
      <?php } ?>
    </div>
    <div class="form-group col-md-12 col-sm-6">
        <label>Message</label>
        <textarea class="comment" name="welcome_text" style="height: 200px !important;"><?php echo @unserialize($row['welcome_text']); ?></textarea>
    </div> 
</div>

 <div class="form-group col-md-12 col-sm-6">
        <h3>Signed Policies</h3>
        <strong><p>Please tick your signed policies</p></strong><br>
<?php 
if($_SESSION['currentUserType'] == 'Employee'){
    $pid = $functions->PracticeId($_SESSION['superid']);
}
else{
    $pid = $_SESSION['currentUser'];
}

$policiesIds = $row['signec_policies'];

$data = $dbF->getRows("SELECT * FROM `documents` WHERE  `assignto` IN ('all','$user','all:$pid') AND `category`='Signed Policies' ");
                foreach ($data as $key => $value) {
?>
    <label class='ccheckbox'>
        <input type='checkbox' value='<?php echo $value[id]; ?>' name="policies[]" class="policies">
        <span class='cmark'></span> <?php echo $value[title]; ?>
    </label>
<?php } ?>
    <script type="text/javascript">
        $(".policies").each(function(){
            var policyId = $(this).val();
            console.log(policyId);
            if('<?php echo $policiesIds; ?>'.includes(policyId)) {
            
                $(this).prop("checked",true);
            }
        });
    </script>
    </div>
    <!-- form-group -->
    
    
        
<!-- </div> -->
<!-- form-group -->

<div class="form-group col-12">


<button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>


</div> 
<!-- form-group -->
</div>
</form>
</div>
<div id="tabs-7">
<form method="post" class="add_group" action="practice-profile" id="add_group">

<div class="row">
<div class="form-group col-md-6">
<label>Group Name:</label>
<select name ="group_name[]" id="group-select-list">
  <option value="" >Select an Group</option>
  <?php
  $user =  intval($_SESSION['currentUser']);
  $sql="SELECT DISTINCT group_name,group_id FROM `insertGroup` WHERE `practiceID` = '$user' ";
  $dataG = $dbF->getRows($sql);

    foreach ($dataG as $key => $val) {

        echo'<option value="'.$val['group_name'].'::'.$val['group_id'].'">'.$val['group_name'].'</option>';
   } 
  ?>
 <option value="custom">Add More</option>
</select>
<input type="text" id="txt-custom" name="group_name[]" style="display: none;" />
</div>
<!-- form-group -->
<div class="form-group col-md-6">
<label>Users:</label>            

<select name="practiceIds[]"  id="choices-multiple-remove-button" placeholder="Select" multiple>
                    <option  value="">
                        Select user
                    </option>
                    <option  value="<?php echo $_SESSION['webUser']['id']; ?>">
                        <?php echo $functions->PracticeName($_SESSION['webUser']['name']); ?>
                    </option>
                    <?php echo $functions->allEmployees($_SESSION['webUser']['id'], $_SESSION['currentUser']);?> 
                </select>             

 
                


</div>
<!-- form-group -->


<div class="form-group col-md-6">
<label id="add_group_desc1">Description:</label>
<input class="add_group_desc" id="add_group_desc" type="text" value="" placeholder="Description" name="add_group_desc" required autocomplete="off">
</div>
<!-- form-group -->



<div class="form-group col-12">


<button style="display: inline-block;" class="submit_class" value="Submit Information" name="submit">Submit Information</button>


</div> 
<!-- form-group -->
</div>
</form>
<?php echo '<table class="table table-hover updateTableGroup">
<thead>
<tr>

<th>Group Name</th>
<th>Description</th>
<th>Users</th>
<th>Actions</th>


</tr>    
</thead>
<tbody class="table_data">';
$user =  intval($_SESSION['currentUser']);
$sql = "SELECT * FROM `insertGroup` WHERE practiceID='$user'";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$id=$val['id'];
$name = $val['group_name'];
$desc=$val['desc'];
$UserName=$val['users'];
echo "<tr style='background:#f9f9f9;'>
<td>" . $name . "



<td>" . $desc . "</td>
<td>".$functions->UserName($UserName)."</td>

<td><a data-toggle='tooltip' title='Edit'  class='ablue' id=".$id." onclick='insertGroupEDIT(this.id)'><i class='fas fa-edit'></i></a><button class='del-btn' type='button' id=".$id." onclick='dltGroupuser(this.id)'><i class='far fa-trash-alt'></i></button> </td>
";

echo "</tr>";
}
echo "</tbody></table>";


?>
</div>









                          </div>
  <?php }else{ echo '</div>'; } ?>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
    <script type="text/javascript">

        $('.file input').on('change', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});



$(document).ready(function(){
 
$(".cr").on('click', function(event) {
  event.preventDefault();
    date =   $(".date").val();
    reason =  $(".reason").val();
    comment =  $(".comment").val();
    console.log(date);
    self = this;
    event.preventDefault();
    $.ajax({
        type: 'post',
        data: {date:date,reason:reason,comment:comment},
        url: 'ajax_call.php?page=isholiday',    

    }).done(function(data) {
        if (data == '1') {
               $('.statusMsg').html('<span style="color:green;">Your holiday is added.</span></p>');
            $('.cr').attr('disabled', false);
    $(".table_data").load("ajax_holiday");
     // var html = '<tr>';
     // html += '<td></td>';
     // html += '<td>'+date+'</td>';
     // html += '<td>'+reason+'</td>';
     // html += '<td>'+comment+'</td>';
     // html += '<td></td></tr>';
     $('.table_data').append(html);
     $('.add_details').reset();
        }

    });
    
  
 });
 
});
</script>
 <script>
        function AjaxDelScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteisholiday',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
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

        function AjaxDelContactScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteContactDirectory',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
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
        function AjaxDelEquipmentScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteEquipmenttDirectory',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
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
        function AjaxDelRoomScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteRoomManagement',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(ths).closest('tr').css('background','e5f3f2');
        $(ths).closest('tr').fadeOut(800,function(){
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


    </script><script>
$(function() {
// bind 'myForm' and provide a simple callback function
$('#add_directory').ajaxForm(function() {
    // $('#loader').fadeIn(600);
$(".updateTable").load("practice-profile.php .updateTable", function() {
$('#add_directory_name').val("");
    $('#add_directory_contact').val("");
});
// $('#loader').fadeOut(600);
});


});
$(function() {
// bind 'myForm' and provide a simple callback function
$('#add_group').ajaxForm(function() {
    // $('#loader').fadeIn(600);
$(".updateTableGroup").load("practice-profile.php .updateTableGroup", function() {
$('#add_group_name').val("");
    // $('#add_room_contact').val("");
    $('#add_group_desc').val("");
    // $('#changeColor').val("");
});
// $('#loader').fadeOut(600);
});


});

$(function() {
// bind 'myForm' and provide a simple callback function
$('#add_equipmemt_directory').ajaxForm(function() {
    // $('#loader').fadeIn(600);
$(".updateTable2").load("practice-profile.php .updateTable2", function() {
$('#equipment_directory_name').val("");
    $('#serial_number').val("");
    $('#detail').val("");
});
// $('#loader').fadeOut(600);
});


});









$(function() {
// bind 'myForm' and provide a simple callback function
$('#add_room').ajaxForm(function() {
    // $('#loader').fadeIn(600);
$(".updateTableroom").load("practice-profile.php .updateTableroom", function() {
$('#add_room_name').val("");
    // $('#add_room_contact').val("");
    $('#add_room_desc').val("");
    // $('#changeColor').val("");
});
// $('#loader').fadeOut(600);
});


});



    </script>
<script>
    function dltGroupuser(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
                type: 'post',
                data: {id:id},
                url: 'ajax_call.php?page=dltGroupuser',                
            }).done(function(data) {
                if (data == '1') {
                    $('#'+id).parents('tr').hide('slow');
                }
            });
        }
    }
    </script>
    <script>
       $(document).ready(function(){
    
     var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        searchResultLimit:5
      }); 
     
     
 });
let selectEl = document.getElementById('group-select-list');

selectEl.addEventListener('change', (e) => {
  if (e.target.value == 'custom') {
    document.getElementById('txt-custom').style.display = 'block';
 
    
  } else {
    document.getElementById('txt-custom').style.display = 'none';
   
    
  }
});

</script>
<?php include_once('dashboardfooter.php'); ?>