<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$msg  = "";
$chk  = $functions->InitialCPD();
if($chk){
    $msg = "Initial CPD Submit Successfully";
}
$chk1  = $functions->InitialCPDedit();
if($chk1){
    $msg = "Initial CPD Submit Successfully";
}
if($_SESSION['currentUserType'] == 'Employee'){
    $user = $_SESSION['superid'];
    
}
else{
    $user = $_SESSION['currentUser'];
}
 $userId = '';
  $Editsbtn = "style='display:none'";
$row = $dbF->getRow("SELECT * FROM `initialCPD` WHERE `user` = '$user'");
if(!empty($row)){
    $userId = $row['id'];
    $readonly = "readonly";
    $sbtn = "style='display:none'"; 
    $Editsbtn = '';
}


   

// include_once('header.php'); 

include'dashboardheader.php';

?>
<style type="text/css">
    input[type="number"] {
    width: 100%;
    border: 1px solid #ccc;
    color: #000;
    padding: 5px 8px;
    font-size: 16px;
    height: 38px;
    border-radius: 5px;
    padding-right: 30px;
    border-radius: 8px;
    border: solid 1px #ededed;
    background-color: #f6f9fd;
}
</style>
<div class="index_content mypage health_form">
    <!-- <div class="left_right_side"> -->
        <!-- left_side close -->
        <div class="right_side">
            <!-- <h3 class="main-heading_">Initial CPD Form</h3> -->
            <div class="right_side_top">
                <div class="change-session">
                    <?php
                        // $functions->changeSession();
                    ?>
                </div>
                <!-- change-session -->
                <?php if($msg!=''){ ?>
                <div class="col-sm-12 alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $msg; ?>
                </div>
                <?php } ?>
                <div class="cpd-txt ce_inner_form">
                    <?php
                    if($_SESSION['currentUserType'] == 'Employee'){
                        $user = $_SESSION['webUser']['id'];
                    }
                    else{
                        $user = $_SESSION['currentUser'];
                    }
                    $sql = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$user'";
                    $data = $dbF->getRow($sql);
                    if(@$data[0] == 'Dental Nurse'|| @$data[0] == 'Trainee Nurse'|| @$data[0] == 'Head Nurse'|| @$data[0] == 'Lead Dental Nurse'|| @$data[0] == 'Reception / Nurse'){ ?>
                    
                    <h5><?php echo @$data[0];?></h5>
                    <div class="inner_forms"> 
                    <h6>GDC CE Requirements</h6>
                        Over a five year cycle, dental nurses are required to achieve 50 hours of CPD, to include a minimum of 50 hours verifiable CPD.
                        <br><br>
                        The highly recommended core topics to be achieved within this cycle should include, as a minimum:
                    <ul>
                        <li>Medical Emergencies – 10 hours per 5 year cycle (2 hours per year of the cycle)</li>
                        <li>Radiography & Radiation Protection – 5 hours per cycle</li>
                        <li>Disinfection & Decontamination – 5 hours per cycle</li>
                    </ul>
                        The following topics are also recommended and should be included as either verifiable or non-verifiable CPD within the 5 year cycle:
                    <ul>
                        <li>Legal and ethical issues</li>
                        <li>Complaints handling</li>
                        <li>Oral Cancer: Early detection</li>
                        <li>Safeguarding children and young people</li>
                        <li>Safeguarding vulnerable adults</li>
                    </ul>
                    <?php } else if( @$data[0] == 'Dentist'|| @$data[0] == 'Doctor'|| @$data[0] == 'Periodontist'|| @$data[0] == 'Endodontist'|| @$data[0] == 'Oral Surgeon'|| @$data[0] == 'Orthodontist'){ ?>
                     <h5><?php echo  @$data[0];?></h5>
                     <h6>GDC CE Requirements</h6>
                        These requirements are effective from 1.1.2018.
                        <br><br>
                        Over a five year cycle, dentists are required to achieve a minimum of 100 hours verifiable CPD, you must complete at least 10 hours of verifiable CPD every two years.
                        <br><br>
                        The highly recommended core topics to be achieved within this cycle should include, as a minimum:
                    <ul>
                        <li>Medical Emergencies – 10 hours per 5 year cycle (2 hours per year of the cycle)</li>
                        <li>Disinfection & Decontamination – 5 hours per cycle</li>
                        <li>Radiography & Radiation Protection – 5 hours per cycle</li>
                    </ul>
                        The following topics are also recommended as they contribute to patient safety and should be included in the 5 year cycle:
                    <ul>
                        <li>Legal and ethical issues</li>
                        <li>Complaints handling</li>
                        <li>Oral Cancer: Early detection</li>
                        <li>Safeguarding children and young people (level 2)</li>
                        <li>Safeguarding vulnerable adults (level 2)</li>
                    </ul>   
                    <?php } else { ?>
                    <h5><?php echo @$data[0];?></h5>
                    <div class="inner_forms">
                    <h6>GDC CE Requirements</h6>
                        Over a five year cycle, dental hygienists and therapists are required to achieve 150 hours of CPD, to include a minimum of 50 hours verifiable CPD.
                        <br><br>
                        Beginning 1st August 2018, this will change, dental hygienists and therapists will be required to achieve a minimum of 75 hours of verifiable CPD in the 5 year cycle.
                        <br><br>
                        The highly recommended core topics to be achieved within this cycle should include, as a minimum:
                    <ul>
                        <li>Medical Emergencies – 10 hours per 5 year cycle (2 hours per year of the cycle)</li>
                        <li>Radiography & Radiation Protection – 5 hours per cycle</li>
                        <li>Disinfection & Decontamination – 5 hours per cycle</li>
                    </ul>
                       The following topics are also recommended and should be included as either verifiable or non-verifiable CPD within the 5 year cycle:
                    <ul>
                        <li>Legal and ethical issues</li>
                        <li>Complaints handling</li>
                        <li>Oral Cancer: Early detection</li>
                        <li>Safeguarding children and young people</li>
                        <li>Safeguarding vulnerable adults</li>
                    </ul>
                    <?php } ?>
                
                <!-- cpd-txt -->
            
            <!-- right_side_top close -->
            <div class="row" <?php echo @$Editsbtn ?>>
            <div class="form-group col-12 col-sm-6"></div>
            <div class="form-group col-12 col-sm-6" >
            <a  href="javascript:;" id="resetCPDbtn" class="submit_class" value="reset" onclick="initialcpdFormReset('<?php echo $userId ?>');" name="reset">Reset</a></div>
           
            </div>
            <form class="profile" method="post" enctype="multipart/form-data">
                <?php echo $functions->setFormToken('initial-cpd',false); ?>
                    <div class="form-group-radio">
                        
                        <div class="radio_btnbox">
                         <div class="form-group form-radio mb-0">
                            <label class="rad-label" <?php echo @$sbtn ?> >
                                
                            <input type="radio" class="rad-input" name="<?php echo @$row['cycle']?>cycle" value="start" <?php echo (@$row['cycle'] == 'start' ? "checked" : "" ) ?> required>&nbsp;&nbsp;
                            <div class="rad-design"></div>
                            <div class="rad-text">Start my Cycle from Scratch</div>
                        </label>
                        </div>
                        <div class="form-group form-radio mb-0">
                        <label class="rad-label">
                            <input type="radio" class="rad-input" name="<?php echo @$row['cycle']?>cycle" value="continue" <?php echo (@$row['cycle'] == 'continue' ? "checked" : "" ) ?>  required>&nbsp;&nbsp;
                        <div class="rad-design"></div>
                        <div class="rad-text">Continue to my current cycle</div>
                        </label>
                        </div>
                    </div>
                         
                           
                            <?php if(@$row['cycle'] == 'start'){ ?>
                             Start my Cycle from Scratch
                            <?php } ?>
                            <?php if(@$row['cycle'] == 'cycle'){ ?>
                             Continue to my current cycle
                            <?php } ?>
                    </div>
                     
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Start Date :</label>
                        <input id="datepicker" type="date" class="datepickerr" name="start_date" value="<?php echo (@$row['start_date'] == '' ? date('Y-m-d') : @$row['start_date'] ) ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                   <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Decontamination :</label><i onclick="initialcpdForm('Decontamination','decontaimatnion','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="decontaimatnion" placeholder="Hours" value="<?php echo @$row['decontaimatnion'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Medical Emergency :</label><i onclick="initialcpdForm('Medical_Emegerncy','medical_emegerncy','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="medical_emegerncy" placeholder="Hours" value="<?php echo @$row['medical_emegerncy'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Radiation :</label><i onclick="initialcpdForm('Radiation','radiation','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="radiation" placeholder="Hours" value="<?php echo @$row['radiation'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                     <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Complaint Handling :</label><i onclick="initialcpdForm('Complaint_Handling','Complaint Handling','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus " <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="complaint_handling" placeholder="Hours" value="<?php echo @$row['complaint_handling'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Data Protection :</label><i onclick="initialcpdForm('Data_Protection','data_protection','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="data_protection" placeholder="Hours" value="<?php echo @$row['data_protection'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Fire Safety :</label><i onclick="initialcpdForm('Fire_Safety','fire_safety','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="fire_safety" placeholder="Hours" value="<?php echo @$row['fire_safety'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Health & Safety :</label><i onclick="initialcpdForm('Health_Safety','health_safety','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="health_safety" placeholder="Hours" value="<?php echo @$row['health_safety'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Safeguarding level 1 :</label><i onclick="initialcpdForm('Safeguarding level 1','level_1','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus " <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="level_1" placeholder="Hours" value="<?php echo @$row['level_1'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Safeguarding level 2 :</label><i onclick="initialcpdForm('Safeguarding_level_2','level_2','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="level_2" placeholder="Hours" value="<?php echo @$row['level_2'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Safeguarding level 3 :</label><i onclick="initialcpdForm('Safeguarding_level_3','level_3','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="level_3" placeholder="Hours" value="<?php echo @$row['level_3'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Oral cancer detection :</label><i onclick="initialcpdForm('Oral_cancer_detection','oral_cancer','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input id="tags" type="number" name="oral_cancer" placeholder="Hours" value="<?php echo @$row['oral_cancer'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">First Aid :</label><i onclick="initialcpdForm('First_Aid','first_aid','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input  id="tags" type="number" name="first_aid" placeholder="Hours" value="<?php echo @$row['first_aid'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group-flex">
                        <div class="form-group">
                        <label class="label3">Any additional courses :</label><i onclick="initialcpdForm('Any_additional_courses','any_courses','<?php echo $userId ?>')" class="fas btn  faCircleCPDForm fa-plus" <?php echo @$Editsbtn ?>></i>
                        <input  id="tags" type="number" name="tags" placeholder="Hours" value="<?php echo @$row['any_courses'] ?>" <?php echo @$readonly ?>>
                    </div>
                    </div>
                    <!-- form-group -->
                
                <div class="footer-bottom">
                    <div class="form-group">
                <input <?php echo @$sbtn ?> type="submit" class="submit_btn" value="Submit Information" name="submit">
                 </div>
                </div>
                </div>
            </form>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
<script>
  

    
   
  
       

$('input[name=cycle]').on('change', function() {
    chk = $(this).val();
    if(chk == 'start'){
        $('.col-sm-6').hide('slow');
    }
    else{
        $('.col-sm-6').show('slow');
    }
});
</script>
<?php include_once('dashboardfooter.php'); ?>