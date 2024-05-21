<?php 
include_once("global.php"); 
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
     exit();
}





//safe=false,effective=false,wellled=false,responsive=false,caring=false


include_once('header.php');
// if (isset($_POST['safe']) || isset($_POST['effective']) || isset($_POST['responsive']) || isset($_POST['wellled']) || isset($_POST['caring'])) {
?>
<!--  <script>$(document).ready(function(){mockInspectionForm('<?php echo $safescore; ?>','<?php echo $safesarray; ?>','<?php echo $effectivescore; ?>','<?php echo $responsivescore; ?>','<?php echo $wellledscore; ?>','<?php echo $caringscore; ?>');});   </script> -->
<?php
// }
$thankT2 = $dbF->hardWords('Your Initial Compliance Health Check form complete. You can now view your practice compliance health on the dashboard.',false);
?>
<?php include'dashboardheader.php'; ?>
<!-- <script>$(document).ready(function(){mockInspectionForm();});   </script> -->

<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
             Mock Inspection Form
        </div>
        <!--link_menu close-->
     <div class="left_side">
            <?php $active = 'reportIssue'; include'dashboardmenu.php';?>
        </div><!-- left_side close -->
        <div class="right_side mock_inspection">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                    
                    ?>
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->



<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="https://smartdentalcompliance.com/mock_inspection?new"> 
 Add New Mock Inspection
</a>
</div>


             <div id="tabs">
                        <ul>
                         
                            <li><a active href="#tabs-1">Mock Inspection Form</a></li>
                            <li><a href="#tabs-2">Mock Inspection View</a></li>
                            <li><a href="#tabs-3">Mock Inspection Action Plan</a></li>
                            <!-- <li><a href="https://smartdentalcompliance.com/mock_inspection?new">Mock Inspection NEW</a></li> -->
                          
                           
                              </ul>   
                           <div id="tabs-1">






            <!-- <h4>Mock Inspection Form</h4> -->
          
        <!--     <div class="ihcf-txt">
            </div> -->
            <form method="post" action="mock_inspection_report" enctype="multipart/form-data"><!-- mock_inspection_report -->
                

                <?php

                 // $functions->setFormToken('contactFormSubmit');


                    $check = $functions->selectAllPracticeData($_SESSION['currentUser']);


                    // var_dump($check);
                    $fchk = false; ?>
                 <h3 style="padding-bottom: 22px;font-weight: 800;"> Practice Detail </h3> <br>
                       <div class="contact_right req">
                            <div class="form_1_">
                              
                                 <?php if(isset($_GET['new'])){ 
                  


 $user1 = intval($_SESSION['webUser']['id']);

                                    ?> 



                                  <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" placeholder="Name of the practice" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" >
                                    </div>
                                    <div class="form_1_side_">Name of Compliance Champion</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-complianc-champion]" value="Smart Dental Compliance & Training" placeholder="Name of Compliance Champion" >
                                    </div>
                                    
                                    <div class="form_1_side_"> Date Audit Conducted </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Date-Audit]" placeholder="Date Audit Conducted" >
                                    </div>
                                   
                                    <div class="form_1_side_"> Location of Dental Practice  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         <input type="titextme" name="form[location]" placeholder="Location of Dental Practice" >
                                    </div>


                                    <div class="form_1_side_">Contact Number</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[practice-contact]" placeholder="Contact Number" >
                                    </div> 
                                    <div class="form_1_side_">Email</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[email]" placeholder="Email" >
                                    </div>

                                   <?php }elseif (isset($_GET['editId'])) {
                                    $user1 = intval($_SESSION['webUser']['id']);    
                                    @$id =  $_GET['editId'];
                                    $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
                                    $data = $dbF->getRow($sql);  
                                    // $pid=$data['pid'];
                                    $htmldata=json_decode($data['all_html'],true); 
                                    if($_SESSION['currentUser']!=$data['pid']){
                                        header('Location: login');
                                    }
                                    ?>
                                    <input type="hidden" name="old_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" placeholder="Name of the practice" value="<?php echo $data[name_of_practice];?>" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" value="<?php echo $data[name_of_practice_manager];?>" >
                                    </div>
                                    <div class="form_1_side_">Name of Compliance Champion</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-complianc-champion]"  placeholder="Name of Compliance Champion" value="<?php echo $data[name_of_complianc_champion];?>">
                                    </div>
                                    
                                    <div class="form_1_side_"> Date Audit Conducted </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Date-Audit]" placeholder="Date Audit Conducted" value="<?php echo $data[date_audit];?>">
                                    </div>
                                   
                                    <div class="form_1_side_"> Location of Dental Practice  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         <input type="titextme" name="form[location]" placeholder="Location of Dental Practice" value="<?php echo $data[location];?>">
                                    </div>


                                    <div class="form_1_side_">Contact Number</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[practice-contact]" placeholder="Contact Number" value="<?php echo $data[practice_contact];?>">
                                    </div> 
                                    <div class="form_1_side_">Email</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[email]" placeholder="Email" value="<?php echo $data[email ];?>">
                                    </div>

                                    <div class="form_1_side_">Detail</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <textarea name="form[Detail]" placeholder="Detail" value="<?php echo $data[detail];?>"></textarea>
                                    </div>


                                    <?php
                                   }
                                   else{

                                   

   $user1 = intval($_SESSION['currentUser']);



?>

<input type="hidden" name="pid" value="<?php echo $user1; ?>">



 <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-practice]" value="<?php echo $check[1] ?>" placeholder="Name of the practice" >
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" value="<?php echo $check[2] ?>" name="form[name-of-practice-manager]" placeholder="Name of the practice manager" >
                                    </div>
                                    <div class="form_1_side_">Name of Compliance Champion</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-complianc-champion]" value="Smart Dental Compliance & Training" placeholder="Name of Compliance Champion" >
                                    </div>
                                    
                                    <div class="form_1_side_"> Date Audit Conducted </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" value="<?php echo date('Y-m-d') ?>" name="form[Date-Audit]" placeholder="Date Audit Conducted" >
                                    </div>
                                   
                                    <div class="form_1_side_"> Location of Dental Practice  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         <input type="titextme" name="form[location]" value="<?php echo $check[4] ?>" placeholder="Location of Dental Practice" >
                                    </div>


                                    <div class="form_1_side_">Contact Number</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" value="<?php echo $check[3] ?>" name="form[practice-contact]" placeholder="Contact Number" >
                                    </div> 
                                    <div class="form_1_side_">Email</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[email]" value="<?php echo $check[0] ?>" placeholder="Email" >
                                    </div>

<?php
                                   } if(!isset($_GET['editId'])){?>

                                    <div class="form_1_side_">Detail</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <textarea name="form[Detail]" placeholder="Detail" ></textarea>
                                    </div>
                                   <?php } ?>
                                   <!--  <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                   
                                  
                              
                            </div>
                        </div>

                   
                    <hr>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/audit_.png); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Practice Audit</h3>
                  
                    <div class="question">
                        <div class="numb">1.</div>
                        <div class="quest">


<div class="quest-inner">
<div class="q">
Have you carried out a cross infection audit in the last 6 months 
</div>
<!-- <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[cross_infection_audit_question]" value="Have you carried out a cross infection audit in the last 6 months">
<input type="radio" name="safe[cross_infection_audit]" value="yes" id="cross_infection_audit" <?php if($htmldata['safe']['data']['cross_infection_audit']['value']=="yes") echo "checked";?>>
<label for="cross_infection_audit">Yes</label>
<input type="radio" name="safe[cross_infection_audit]" value="your cross infection audit is missing" id="cross_infection_audit2" <?php if($htmldata['safe']['data']['cross_infection_audit']['value']=="your cross infection audit is missing") echo "checked";?>>
<label for="cross_infection_audit2">No</label>


<input type="radio" name="safe[cross_infection_audit]" value="N/A" id="cross_infection_audit3" <?php if($htmldata['safe']['data']['cross_infection_audit']['value']=="N/A") echo "checked";?>>
<label for="cross_infection_audit3">N/A</label>
<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>

</div>
<!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[cross_infection_audit_comment]" class="form-control"><?php echo $htmldata['safe']['data']['cross_infection_audit']['comment'];?></textarea>
</div>
</div>


                           
                        </div>
                        <div class="sh">
                            <span>comment</span>
                            <input type="hidden" class="" value="your cross infection audit is missing" >
                             
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                
                    <div class="question">
                        <div class="numb">2.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  Have you carried out radiograph audits in the last 6 months

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
<div class="inputs mockinspection">
<input type="hidden" name="form[radiograph_audits_question]" value="Have you carried out radiograph audits in the last 6 months">
<!-- <input type="hidden" name="safe[radiograph_audits_id]" value="yes"> -->
<input type="radio" name="safe[radiograph_audits]" value="yes" id="radiograph_audits" <?php if($htmldata['safe']['data']['radiograph_audits']['value']=="yes") echo "checked";?>>
<label for="radiograph_audits">Yes</label>
<input type="radio" name="safe[radiograph_audits]" value="your radiograph audit is missing" id="radiograph_audits2" <?php if($htmldata['safe']['data']['radiograph_audits']['value']=="your radiograph audit is missing") echo "checked";?>>
<label for="radiograph_audits2">No</label>




<input type="radio" name="safe[radiograph_audits]" value="N/A" id="radiograph_audits3" <?php if($htmldata['safe']['data']['radiograph_audits']['value']=="N/A") echo "checked";?>>
<label for="radiograph_audits3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






</div>


<!-- <div class="file">
<input type="file" name="radiograph_audits_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[radiograph_audits_comment]" class="form-control"><?php echo $htmldata['safe']['data']['radiograph_audits']['comment'];?></textarea>
</div>



                            </div>
                           
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your radiograph audit is missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                 
                    <div class="question">
                        <div class="numb">3.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  Have you carried out record keeping audits in the last 6 months

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
<input type="hidden" name="form[record_keeping_audits_question]" value="Have you carried out record keeping audits in the last 6 months">
                                    <!-- <input type="hidden" name="effective[record_keeping_audits_id]" value="yes"> -->
                                    <input type="radio" name="effective[record_keeping_audits]" value="yes" id="record_keeping_audits" <?php if($htmldata['effective']['data']['record_keeping_audits']['value']=="yes") echo "checked";?>>
                                    <label for="record_keeping_audits">Yes</label>
                                    <input type="radio" name="effective[record_keeping_audits]" value="record keeping audit is missing" id="record_keeping_audits2" <?php if($htmldata['effective']['data']['record_keeping_audits']['value']=="record keeping audit is missing") echo "checked";?>>
                                    <label for="record_keeping_audits2">No</label>



<input type="radio" name="effective[record_keeping_audits]" value="N/A" id="record_keeping_audits3" <?php if($htmldata['effective']['data']['record_keeping_audits']['value']=="N/A") echo "checked";?>>
<label for="record_keeping_audits3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>



<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[record_keeping_audits_comment]" class="form-control"><?php echo $htmldata['effective']['data']['record_keeping_audits']['comment'];?><?php echo $htmldata['']['data']['']['comment'];?></textarea>
</div>




                            </div>
                           
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="record keeping audit is missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                   
                    <div class="question">
                        <div class="numb">4.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  Do you a disability access audit for the practice 

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[disability_access_audit_question]" value="Do you a disability access audit for the practice">
            <!-- <input type="hidden" name="responsive[disability_access_audit_id]" value="yes"> -->
<input type="radio" name="responsive[disability_access_audit]" value="yes" id="disability_access_audit" <?php if($htmldata['responsive']['data']['disability_access_audit']['value']=="yes") echo "checked";?>>
                                    <label for="disability_access_audit">Yes</label>
<input type="radio" name="responsive[disability_access_audit]" value="your disability access audit missing" id="disability_access_audit2" <?php if($htmldata['responsive']['data']['disability_access_audit']['value']=="your disability access audit missing") echo "checked";?>>
                                    <label for="disability_access_audit2">No</label>





<input type="radio" name="responsive[disability_access_audit]" value="N/A" id="disability_access_audit3" <?php if($htmldata['responsive']['data']['disability_access_audit']['value']=="N/A") echo "checked";?>>
<label for="disability_access_audit3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[disability_access_audit_comment]" class="form-control"><?php echo $htmldata['responsive']['data']['disability_access_audit']['comment'];?></textarea>
</div>




                            </div>
                           
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your disability access audit missing" >
                          
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">5.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Do you carry out anti microbial audit 

                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[anti_microbial_audit_question]" value="Do you carry out anti microbial audit">
                                    <!-- <input type="hidden" name="wellled[anti_microbial_audit_id]" value="yes"> -->
                                    <input type="radio" name="wellled[anti_microbial_audit]" value="yes" id="anti_microbial_audit" <?php if($htmldata['wellled']['data']['anti_microbial_audit']['value']=="yes") echo "checked";?>>
                                    <label for="anti_microbial_audit">Yes</label>
                                    <input type="radio" name="wellled[anti_microbial_audit]" value="your anti microbial audit missing" id="anti_microbial_audit2" <?php if($htmldata['wellled']['data']['anti_microbial_audit']['value']=="your anti microbial audit missing") echo "checked";?>>
                                    <label for="anti_microbial_audit2">No</label>




                                    <input type="radio" name="wellled[anti_microbial_audit]" value="N/A" id="anti_microbial_audit3" <?php if($htmldata['wellled']['data']['anti_microbial_audit']['value']=="N/A") echo "checked";?>>
<label for="anti_microbial_audit3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>



<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[anti_microbial_audit_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['anti_microbial_audit']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your anti microbial audit missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">6.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  
                            Do you have a waste acceptance audit for the practice
                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[waste_acceptance_audit_question]" value="Do you have a waste acceptance audit for the practice">
                                    <!-- <input type="hidden" name="wellled[waste_acceptance_audit_id]" value="yes"> -->
                                    <input type="radio" name="wellled[waste_acceptance_audit]" value="yes" id="waste_acceptance_audit" <?php if($htmldata['wellled']['data']['waste_acceptance_audit']['value']=="yes") echo "checked";?>>
                                    <label for="waste_acceptance_audit">Yes</label>
                                    <input type="radio" name="wellled[waste_acceptance_audit]" value="your waste acceptance audit missing" id="waste_acceptance_audit2" <?php if($htmldata['wellled']['data']['waste_acceptance_audit']['value']=="your waste acceptance audit missing") echo "checked";?>>
                                    <label for="waste_acceptance_audit2">No</label>





                                    <input type="radio" name="wellled[waste_acceptance_audit]" value="N/A" id="waste_acceptance_audit3" <?php if($htmldata['wellled']['data']['waste_acceptance_audit']['value']=="N/A") echo "checked";?>>
<label for="waste_acceptance_audit3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[waste_acceptance_audit_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['waste_acceptance_audit']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your waste acceptance audit missing" >
                           
                        </div>
 <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>
                        <hr>
                    </div>
                    <!-- question -->
                  
                    <!--  <input class="submit_class" type="submit" value="Save"> -->
          
          
                </div>
                <!-- quest-box -->
             
                <div class="quest-box">

<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/risk_.png) ; background-repeat: no-repeat; background-position: center;"></div>                    <h3>Practice Risk Assessment</h3>
                  
                    <div class="question">
                        <div class="numb">7.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Do you have an up to date fire risk assessment of the practice


                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_fire_risk_assessment_question]" value="Do you have an up to date fire risk assessment of the practice" >
                                    <!-- <input type="hidden" name="form[general_practice_risk_assessment_id]" value="54"> -->
                                    <input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="yes" id="up_to_date_fire_risk_assessment" <?php if($htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_fire_risk_assessment">Yes</label>
                                    <input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="your up to date fire risk assessment missing" id="up_to_date_fire_risk_assessment" <?php if($htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="your up to date fire risk assessment missing") echo "checked";?>>
                                    <label for="up_to_date_fire_risk_assessment">No</label>




<input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="N/A" id="up_to_date_fire_risk_assessment3" <?php if($htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_fire_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>



<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[up_to_date_fire_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['up_to_date_fire_risk_assessment']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date fire risk assessment missing" >
                          
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">8.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Do you have an up to date legionella risk assessment of the practice 

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                     <input type="hidden" name="form[up_to_date_legionella_risk_assessment_question]" value=" Do you have an up to date legionella risk assessment of the practice">
                                    <!-- <input type="hidden" name="form[fire_risk_assessment_id]" value="yes"> -->
                                    <input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="yes" id="up_to_date_legionella_risk_assessment" <?php if($htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_legionella_risk_assessment">Yes</label>
                                    <input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="your up to date legionella risk assessment missing" id="up_to_date_legionella_risk_assessment2" <?php if($htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="your up to date legionella risk assessment missing") echo "checked";?>>
                                    <label for="up_to_date_legionella_risk_assessment2">No</label>



                                    <input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="N/A" id="up_to_date_legionella_risk_assessment3" <?php if($htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_legionella_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[up_to_date_legionella_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                           
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date legionella risk assessment missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">9.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a health and safety risk assessment 

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[health_and_safety_risk_assessment_question]" value="Do you have a health and safety risk assessment">
                                    <!-- <input type="hidden" name="form[health_and_safety_risk_assessment_id]" value="yes"> -->
                                    <input type="radio" name="effective[health_and_safety_risk_assessment]" value="yes" id="health_and_safety_risk_assessment" <?php if($htmldata['effective']['data']['health_and_safety_risk_assessment']['value']=="yes") echo "checked";?>>
                                    <label for="health_and_safety_risk_assessment">Yes</label>
                                    <input type="radio" name="effective[health_and_safety_risk_assessment]" value="your health and safety risk assessment missing" id="health_and_safety_risk_assessment2" <?php if($htmldata['effective']['data']['health_and_safety_risk_assessment']['value']=="your health and safety risk assessment missing") echo "checked";?>>
                                    <label for="health_and_safety_risk_assessment2">No</label>


                                              <input type="radio" name="effective[health_and_safety_risk_assessment]" value="N/A" id="health_and_safety_risk_assessment3" <?php if($htmldata['effective']['data']['health_and_safety_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="health_and_safety_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                                



                                                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[health_and_safety_risk_assessment_comment]" class="form-control"><?php echo $htmldata['effective']['data']['health_and_safety_risk_assessment']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your health and safety risk assessment missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
<div class="question">
<div class="numb">10.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
Do you have a sharp's risk assessment, does this cover all sharps
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[sharps_risk_assessment_question]" value="Do you have a sharp's risk assessment, does this cover all sharps">
<!-- <input type="hidden" name="safe[sharps_risk_assessment_id]" value="64"> -->
<input type="radio" name="safe[sharps_risk_assessment]" value="yes" id="sharps_risk_assessment" <?php if($htmldata['safe']['data']['sharps_risk_assessment']['value']=="yes") echo "checked";?>>
<label for="sharps_risk_assessment">Yes</label>
<input type="radio" name="safe[sharps_risk_assessment]" value="your sharps risk assessment missing" id="sharps_risk_assessment2" <?php if($htmldata['safe']['data']['sharps_risk_assessment']['value']=="your sharps risk assessment missing") echo "checked";?>>
<label for="sharps_risk_assessment2">No</label>


<input type="radio" name="safe[sharps_risk_assessment]" value="N/A" id="sharps_risk_assessment3" <?php if($htmldata['safe']['data']['sharps_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="sharps_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[sharps_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['sharps_risk_assessment']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your sharps risk assessment missing" >

</div>                        <hr>

</div>
<!-- question -->
                   
     

<div class="question">
<div class="numb">11.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
Do you have a COVID-19 risk assessment, does this cover all staff ? 
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[covid_risk_assessment_question]" value="Do you have a COVID-19 risk assessment, does this cover all staff ?">
<!-- <input type="hidden" name="safe[sharps_risk_assessment_id]" value="64"> -->
<input type="radio" name="safe[covid_risk_assessment]" value="yes" id="covid_risk_assessment" <?php if($htmldata['safe']['data']['covid_risk_assessment']['value']=="yes") echo "checked";?>>
<label for="covid_risk_assessment">Yes</label>
<input type="radio" name="safe[covid_risk_assessment]" value="Complete a COVID-19 risk assessment" id="covid_risk_assessment2" <?php if($htmldata['safe']['data']['covid_risk_assessment']['value']=="Complete a COVID-19 risk assessment") echo "checked";?>>
<label for="covid_risk_assessment2">No</label>



<input type="radio" name="safe[covid_risk_assessment]" value="N/A" id="covid_risk_assessment3" <?php if($htmldata['safe']['data']['covid_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="covid_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[covid_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['covid_risk_assessment']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Complete a COVID-19 risk assessment">
</div>                        <hr>

</div>
<!-- question -->


<div class="question">
<div class="numb">12.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
Do you have a general risk assessment for the practice ?  
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[general_risk_assessment_question]" value="Do you have a general risk assessment for the practice ?">
<!-- <input type="hidden" name="safe[sharps_risk_assessment_id]" value="64"> -->
<input type="radio" name="safe[general_risk_assessment]" value="yes" id="general_risk_assessment" <?php if($htmldata['safe']['data']['general_risk_assessment']['value']=="yes") echo "checked";?>>
<label for="general_risk_assessment">Yes</label>
<input type="radio" name="safe[general_risk_assessment]" value="Complete a general risk assessment for the practice" id="general_risk_assessment2" <?php if($htmldata['safe']['data']['general_risk_assessment']['value']=="Complete a general risk assessment for the practice") echo "checked";?>>
<label for="general_risk_assessment2">No</label>


<input type="radio" name="safe[general_risk_assessment]" value="N/A" id="general_risk_assessment3" <?php if($htmldata['safe']['data']['general_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="general_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



</div>
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[general_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['general_risk_assessment']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Complete a general risk assessment for the practice">
</div>
</div>
<!-- question -->


                <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>
  
                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
                <!-- quest-box -->
              
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/logs_.png); background-repeat: no-repeat; background-position: center;"></div>                    
<h3>Practice Logs</h3>
                  
                    <div class="question">
                        <div class="numb">13.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Do you carry out medical emergency drugs log  weekly 

                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[medical_emergency_drugs_log_weekly_question]" value="Do you carry out medical emergency drugs log  weekly">
                                    <!-- <input type="hidden" name="form[medical_emergency_drugs_log_weekly]" value="yes"> -->
                                    <input type="radio" name="safe[medical_emergency_drugs_log_weekly]" value="yes" id="medical_emergency_drugs_log_weekly" <?php if($htmldata['safe']['data']['medical_emergency_drugs_log_weekly']['value']=="yes") echo "checked";?>>
                                    <label for="medical_emergency_drugs_log_weekly">Yes</label>
                                    <input type="radio" name="safe[medical_emergency_drugs_log_weekly]" value="your medical emergency drugs log  weekly missing" id="medical_emergency_drugs_log_weekly2" <?php if($htmldata['safe']['data']['medical_emergency_drugs_log_weekly']['value']=="your medical emergency drugs log  weekly missing") echo "checked";?>>
                                    <label for="medical_emergency_drugs_log_weekly2">No</label>



<input type="radio" name="safe[medical_emergency_drugs_log_weekly]" value="N/A" id="medical_emergency_drugs_log_weekly3" <?php if($htmldata['safe']['data']['medical_emergency_drugs_log_weekly']['value']=="N/A") echo "checked";?>>
<label for="medical_emergency_drugs_log_weekly3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                                                                                                                             <br>
<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[medical_emergency_drugs_log_weekly_comment]" class="form-control"><?php echo $htmldata['safe']['data']['medical_emergency_drugs_log_weekly']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="">
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                 
                    <div class="question">
                        <div class="numb">14.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you carry out first aid box log 

                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[first_aid_box_log_question]" value="Do you carry out first aid box log" >
                                    <!-- <input type="hidden" name="safe[first aid box log_id]" value="yes"> -->
                                    <input type="radio" name="safe[first_aid_box_log]" value="yes" id="first_aid_box_log" <?php if($htmldata['safe']['data']['first_aid_box_log']['value']=="yes") echo "checked";?>>
                                    <label for="first_aid_box_log">Yes</label>
                                    <input type="radio" name="safe[first_aid_box_log]" value="your first aid box log missing" id="first_aid_box_log2" <?php if($htmldata['safe']['data']['first_aid_box_log']['value']=="your first aid box log missing") echo "checked";?>>
                                    <label for="first_aid_box_log2">No</label>


                                    <input type="radio" name="safe[first_aid_box_log]" value="N/A" id="first_aid_box_log3" <?php if($htmldata['safe']['data']['first_aid_box_log']['value']=="N/A") echo "checked";?>>
<label for="first_aid_box_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>



</br>                                <br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[first_aid_box_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['first_aid_box_log']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your first aid box log missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">15.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  Do you carry out defib log 
                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[Do_you_carry_out_defib_log_question]" value="Do you carry out defib log">
                                    <!-- <input type="hidden" name="safe[Do_you_carry_out_defib_log_id]" value="yes"> -->
                                    <input type="radio" name="safe[Do_you_carry_out_defib_log]" value="yes" id="Do_you_carry_out_defib_log" <?php if($htmldata['safe']['data']['Do_you_carry_out_defib_log']['value']=="yes") echo "checked";?>>
                                    <label for="Do_you_carry_out_defib_log">Yes</label>
                                    <input type="radio" name="safe[Do_you_carry_out_defib_log]" value="your carry out defib log  missing" id="Do_you_carry_out_defib_log2" <?php if($htmldata['safe']['data']['Do_you_carry_out_defib_log']['value']=="your carry out defib log  missing") echo "checked";?>>
                                    <label for="Do_you_carry_out_defib_log2">No</label>


<input type="radio" name="safe[Do_you_carry_out_defib_log]" value="N/A" id="Do_you_carry_out_defib_log3" <?php if($htmldata['safe']['data']['Do_you_carry_out_defib_log']['value']=="N/A") echo "checked";?>>
<label for="Do_you_carry_out_defib_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>



                                </br>                                <br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Do_you_carry_out_defib_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['Do_you_carry_out_defib_log']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your carry out defib log  missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">16.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Do you check out medical emergency equipement log 
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[medical_emergency_equipement_log_question]" value="Do you check out medical emergency equipement log " >
                                    <!-- <input type="hidden" name="safe[medical_emergency_equipement_log_id]" value="yes"> -->
                                    <input type="radio" name="safe[medical_emergency_equipement_log]" value="yes" id="medical_emergency_equipement_log" <?php if($htmldata['safe']['data']['medical_emergency_equipement_log']['value']=="yes") echo "checked";?>>
                                    <label for="medical_emergency_equipement_log">Yes</label>
                                    <input type="radio" name="safe[medical_emergency_equipement_log]" value="your medical emergency equipement log missing" id="medical_emergency_equipement_log2" <?php if($htmldata['safe']['data']['medical_emergency_equipement_log']['value']=="your medical emergency equipement log missing") echo "checked";?>>
                                    <label for="medical_emergency_equipement_log2">No</label>



                                    <input type="radio" name="safe[medical_emergency_equipement_log]" value="N/A" id="medical_emergency_equipement_log3" <?php if($htmldata['safe']['data']['medical_emergency_equipement_log']['value']=="N/A") echo "checked";?>>
<label for="medical_emergency_equipement_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                             

                                                             </br>                                <br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[medical_emergency_equipement_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['medical_emergency_equipement_log']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your medical emergency equipement log missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                    
                    <div class="question">
                        <div class="numb">17.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                 Do you carry out surgery logs
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[surgery_logs_question]" value="Do you carry out surgery logs">
                                   <!-- <input type="hidden" name="safe[surgery_logs_id]" value="yes"> -->
                                <input type="radio" name="safe[surgery_logs]" value="yes" id="surgery_logs" <?php if($htmldata['safe']['data']['surgery_logs']['value']=="yes") echo "checked";?>>
                            <label for="surgery_logs">Yes</label>
                            <input type="radio" name="safe[surgery_logs]" value="your surgery_logs missing" id="surgery_logs2" <?php if($htmldata['safe']['data']['surgery_logs']['value']=="your surgery_logs missing") echo "checked";?>>
                            <label for="surgery_logs2">No</label>



                                   <input type="radio" name="safe[surgery_logs]" value="N/A" id="surgery_logs3" <?php if($htmldata['safe']['data']['surgery_logs']['value']=="N/A") echo "checked";?>>
<label for="surgery_logs3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               


                                                                                            </br>                                <br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[surgery_logs_comment]" class="form-control"><?php echo $htmldata['safe']['data']['surgery_logs']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your surgery_logs missin">
                          
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
                      <div class="question">
                        <div class="numb">18.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                 Do you carry out decontamination room log 
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[decontamination_room_log_question]" value=" Do you carry out decontamination room log">
                                   <!-- <input type="hidden" name="safe[decontamination_room_log_id]" value="yes"> -->
                                <input type="radio" name="safe[decontamination_room_log]" value="yes" id="decontamination_room_log" <?php if($htmldata['safe']['data']['decontamination_room_log']['value']=="yes") echo "checked";?>>
                            <label for="decontamination_room_log">Yes</label>
                            <input type="radio" name="safe[decontamination_room_log]" value="your decontamination_room_log missing" id="decontamination_room_log2" <?php if($htmldata['safe']['data']['decontamination_room_log']['value']=="your decontamination_room_log missing") echo "checked";?>>
                            <label for="decontamination_room_log2">No</label>



                                   <input type="radio" name="safe[decontamination_room_log]" value="N/A" id="decontamination_room_log3" <?php if($htmldata['safe']['data']['decontamination_room_log']['value']=="N/A") echo "checked";?>>
<label for="decontamination_room_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                               


                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[decontamination_room_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['decontamination_room_log']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your decontamination_room_log missin">
                          
                        </div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                        <hr>
                    </div>
                    <!-- question --> 
                 <div class="question">
                        <div class="numb">19.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                               Do you carry out autoclave testing log 
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[autoclave_testing_log_question]" value="Do you carry out autoclave testing log ">
                                   <!-- <input type="hidden" name="safe[autoclave_testing_log_id]" value="yes"> -->
                                <input type="radio" name="safe[autoclave_testing_log]" value="yes" id="autoclave_testing_log" <?php if($htmldata['safe']['data']['autoclave_testing_log']['value']=="yes") echo "checked";?>>
                            <label for="autoclave_testing_log">Yes</label>
                            <input type="radio" name="safe[autoclave_testing_log]" value="your autoclave testing log missing" id="autoclave_testing_log2" <?php if($htmldata['safe']['data']['autoclave_testing_log']['value']=="your autoclave testing log missing") echo "checked";?>>
                            <label for="autoclave_testing_log2">No</label>



                            <input type="radio" name="safe[autoclave_testing_log]" value="N/A" id="autoclave_testing_log3" <?php if($htmldata['safe']['data']['autoclave_testing_log']['value']=="N/A") echo "checked";?>>
<label for="autoclave_testing_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               


<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[autoclave_testing_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['autoclave_testing_log']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your autoclave testing log missing" >
                          
                        </div>

                        <hr>
                    </div>
                    <!-- question -->  <!-- question --> 
                 <div class="question">
                        <div class="numb">20.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                               Do you carry out ultrasonic testing log (if in use) 
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[ultrasonic_testing_log_question]" value="Do you carry out ultrasonic testing log (if in use)">
                                   <!-- <input type="hidden" name="safe[ultrasonic_testing_log_id]" value="yes"> -->
                                <input type="radio" name="safe[ultrasonic_testing_log]" value="yes" id="ultrasonic_testing_log" <?php if($htmldata['safe']['data']['ultrasonic_testing_log']['value']=="yes") echo "checked";?>>
                            <label for="ultrasonic_testing_log">Yes</label>
                            <input type="radio" name="safe[ultrasonic_testing_log]" value="your ultrasonic testing log comment missing" id="ultrasonic_testing_log2" <?php if($htmldata['safe']['data']['ultrasonic_testing_log']['value']=="your ultrasonic testing log comment missing") echo "checked";?>>
                            <label for="ultrasonic_testing_log2">No</label>



                                 <input type="radio" name="safe[ultrasonic_testing_log]" value="N/A" id="ultrasonic_testing_log3" <?php if($htmldata['safe']['data']['ultrasonic_testing_log']['value']=="N/A") echo "checked";?>>
<label for="ultrasonic_testing_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[ultrasonic_testing_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['ultrasonic_testing_log']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your ultrasonic testing log comment missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->  <!-- question --> 
                 <div class="question">
                        <div class="numb">21.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                               Do you have a fridge temp monitoring log
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[fridge_temp_monitoring_log_question]" value=" Do you have a fridge temp monitoring log">
                                   <!-- <input type="hidden" name="safe[fridge temp monitoring log_id]" value="yes"> -->
                                <input type="radio" name="safe[fridge_temp_monitoring_log]" value="yes" id="fridge_temp_monitoring_log" <?php if($htmldata['safe']['data']['fridge_temp_monitoring_log']['value']=="yes") echo "checked";?>>
                            <label for="fridge_temp_monitoring_log">Yes</label>
                            <input type="radio" name="safe[fridge_temp_monitoring_log]" value="your have a fridge temp monitoring log missing" id="fridge_temp_monitoring_log2" <?php if($htmldata['safe']['data']['fridge_temp_monitoring_log']['value']=="your have a fridge temp monitoring log missing") echo "checked";?>>
                            <label for="fridge_temp_monitoring_log2">No</label>




                            <input type="radio" name="safe[fridge_temp_monitoring_log]" value="N/A" id="fridge_temp_monitoring_log3" <?php if($htmldata['safe']['data']['fridge_temp_monitoring_log']['value']=="N/A") echo "checked";?>>
<label for="fridge_temp_monitoring_log3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>







                                </div>
                               


<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fridge_temp_monitoring_log_comment]" class="form-control"><?php echo $htmldata['safe']['data']['fridge_temp_monitoring_log']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your have a fridge temp monitoring log missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->  <!-- question --> 
<div class="question">
<div class="numb">22.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
Do you carry out water temp log to prevent legionella 
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[water_temp_log_to_prevent_legionella_question]" value="Do you carry out water temp log to prevent legionella ">
<!-- <input type="hidden" name="safe[critical_examination_report_for_x-ray_units_id]" value="yes"> -->
<input type="radio" name="safe[water_temp_log_to_prevent_legionella]" value="yes" id="water_temp_log_to_prevent_legionella" <?php if($htmldata['safe']['data']['water_temp_log_to_prevent_legionella']['value']=="yes") echo "checked";?>>
<label for="water_temp_log_to_prevent_legionella">Yes</label>
<input type="radio" name="safe[water_temp_log_to_prevent_legionella]" value="your carry out water temp log to prevent legionella missing" id="water_temp_log_to_prevent_legionella2" <?php if($htmldata['safe']['data']['water_temp_log_to_prevent_legionella']['value']=="your carry out water temp log to prevent legionella missing") echo "checked";?>>
<label for="water_temp_log_to_prevent_legionella2">No</label>


 <input type="radio" name="safe[water_temp_log_to_prevent_legionella]" value="N/A" id="water_temp_log_to_prevent_legionella3" <?php if($htmldata['safe']['data']['water_temp_log_to_prevent_legionella']['value']=="N/A") echo "checked";?>>
<label for="water_temp_log_to_prevent_legionella3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[water_temp_log_to_prevent_legionella_comment]" class="form-control"><?php echo $htmldata['safe']['data']['water_temp_log_to_prevent_legionella']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your carry out water temp log to prevent legionella missing" >
</div><hr>
</div>
<!-- question -->




<div class="question">
<div class="numb">23.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
Do you carry out medical emergency equipment log 
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[carry_out_medical_emergency_question]" value="Do you carry out medical emergency equipment log">
<!-- <input type="hidden" name="effective[critical_examination_report_for_x-ray_units_id]" value="yes"> -->
<input type="radio" name="effective[carry_out_medical_emergency]" value="yes" id="carry_out_medical_emergency" <?php if($htmldata['effective']['data']['carry_out_medical_emergency']['value']=="yes") echo "checked";?>>
<label for="carry_out_medical_emergency">Yes</label>
<input type="radio" name="effective[carry_out_medical_emergency]" value="Ensure you have a log of medical emergency equipment" id="carry_out_medical_emergency2" <?php if($htmldata['effective']['data']['carry_out_medical_emergency']['value']=="Ensure you have a log of medical emergency equipment") echo "checked";?>>
<label for="carry_out_medical_emergency2">No</label>


 <input type="radio" name="effective[carry_out_medical_emergency]" value="N/A" id="carry_out_medical_emergency3" <?php if($htmldata['effective']['data']['carry_out_medical_emergency']['value']=="N/A") echo "checked";?>>
<label for="carry_out_medical_emergency3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[carry_out_medical_emergency_comment]" class="form-control"><?php echo $htmldata['effective']['data']['carry_out_medical_emergency']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure you have a log of medical emergency equipment" >
</div><hr>
</div>
<!-- question -->



<div class="question">
<div class="numb">24.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">
If you dispense controlled drugs do you keep a log of this 
</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[dispense_controlled_drugs_question]" value="If you dispense controlled drugs do you keep a log of this">
<!-- <input type="hidden" name="safe[critical_examination_report_for_x-ray_units_id]" value="yes"> -->
<input type="radio" name="safe[dispense_controlled_drugs]" value="yes" id="dispense_controlled_drugs" <?php if($htmldata['safe']['data']['dispense_controlled_drugs']['value']=="yes") echo "checked";?>>
<label for="dispense_controlled_drugs">Yes</label>
<input type="radio" name="safe[dispense_controlled_drugs]" value="Complete a log for controlled drugs" id="dispense_controlled_drugs2" <?php if($htmldata['safe']['data']['dispense_controlled_drugs']['value']=="Complete a log for controlled drugs") echo "checked";?>>
<label for="dispense_controlled_drugs2">No</label>



 <input type="radio" name="safe[dispense_controlled_drugs]" value="N/A" id="dispense_controlled_drugs3" <?php if($htmldata['safe']['data']['dispense_controlled_drugs']['value']=="N/A") echo "checked";?>>
<label for="dispense_controlled_drugs3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[dispense_controlled_drugs_comment]" class="form-control"><?php echo $htmldata['safe']['data']['dispense_controlled_drugs']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Complete a log for controlled drugs" >
</div>
</div>
<!-- question -->
                    <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
              
                <!-- quest-box -->
               
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/equi_.png) ; background-repeat: no-repeat; background-position: center;"></div>                    <h3>Practice Equipement </h3>
                   
                    <div class="question">
                        <div class="numb">25.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                  Was your autoclaved serviced within the last 12 months 
                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[autoclaved_serviced_question]" value="Was your autoclaved serviced within the last 12 months">
                                    <!-- <input type="hidden" name="form[autoclaved serviced_id]" value="139"> -->
                                    <input type="radio" name="safe[autoclaved_serviced]" value="yes" id="autoclaved_serviced" <?php if($htmldata['safe']['data']['autoclaved_serviced']['value']=="yes") echo "checked";?>>
                                    <label for="autoclaved_serviced">Yes</label>
                                    <input type="radio" name="safe[autoclaved_serviced]" value="your autoclaved serviced within the last 12 months missing" id="autoclaved_serviced2" <?php if($htmldata['safe']['data']['autoclaved_serviced']['value']=="your autoclaved serviced within the last 12 months missing") echo "checked";?>>
                                    <label for="autoclaved_serviced2">No</label>



                                     <input type="radio" name="safe[autoclaved_serviced]" value="N/A" id="autoclaved_serviced3" <?php if($htmldata['safe']['data']['autoclaved_serviced']['value']=="N/A") echo "checked";?>>
<label for="autoclaved_serviced3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>




                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[autoclaved_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['autoclaved_serviced']['comment'];?></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your autoclaved serviced within the last 12 months missing" >
                           
                        </div>
<!-- <input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;"> -->

                        <hr>
                    </div>
                    <!-- question -->
                   
                    <div class="question">
                        <div class="numb">26.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Was your compressor serviced within the last 12 months 
                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[compressor_serviced_question]" value="Was your compressor serviced within the last 12 months ">
                                    <!-- <input type="hidden" name="safe[compressor_serviced_id]" value="140"> -->
                                    <input type="radio" name="safe[compressor_serviced]" value="yes" id="compressor_serviced" <?php if($htmldata['safe']['data']['compressor_serviced']['value']=="yes") echo "checked";?>>
                                    <label for="compressor_serviced">Yes</label>
                                    <input type="radio" name="safe[compressor_serviced]" value="your compressor serviced within the last 12 months missing" id="compressor_serviced2" <?php if($htmldata['safe']['data']['compressor_serviced']['value']=="your compressor serviced within the last 12 months missing") echo "checked";?>>
                                    <label for="compressor_serviced2">No</label>


                            <input type="radio" name="safe[compressor_serviced]" value="N/A" id="compressor_serviced3" <?php if($htmldata['safe']['data']['compressor_serviced']['value']=="N/A") echo "checked";?>>
<label for="compressor_serviced3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>

                                                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[compressor_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['compressor_serviced']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your compressor serviced within the last 12 months missing" >
                            <
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                  
                    <div class="question">
                        <div class="numb">27.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Was your oxygen serviced within the last 12 months
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[oxygen_serviced_question]" value="Was your oxygen serviced within the last 12 months">
                                    <!-- <input type="hidden" name="safe[oxygen_serviced_id]" value="156"> -->
                                    <input type="radio" name="safe[oxygen_serviced]" value="yes" id="oxygen_serviced" <?php if($htmldata['safe']['data']['oxygen_serviced']['value']=="yes") echo "checked";?>>
                                    <label for="oxygen_serviced">Yes</label>
                                    <input type="radio" name="safe[oxygen_serviced]" value="your oxygen serviced within the last 12 months missing" id="oxygen_serviced2" <?php if($htmldata['safe']['data']['oxygen_serviced']['value']=="your oxygen serviced within the last 12 months missing") echo "checked";?>>
                                    <label for="oxygen_serviced2">No</label>




<input type="radio" name="safe[oxygen_serviced]" value="N/A" id="oxygen_serviced3" <?php if($htmldata['safe']['data']['oxygen_serviced']['value']=="N/A") echo "checked";?>>
<label for="oxygen_serviced3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[oxygen_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['oxygen_serviced']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your oxygen serviced within the last 12 months missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                   
                    <div class="question">
                        <div class="numb">28.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Was your equipement PAT tested within the last 2 years
                                </div>
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[equipement_PAT_tested_question]" value="Was your equipement PAT tested within the last 2 years">
                                    <!-- <input type="hidden" name="safe[equipement_PAT_tested_id]" value="249"> -->
                                    <input type="radio" name="safe[equipement_PAT_tested]" value="yes" id="equipement_PAT_tested" <?php if($htmldata['safe']['data']['equipement_PAT_tested']['value']=="yes") echo "checked";?>>
                                    <label for="equipement_PAT_tested">Yes</label>
                                    <input type="radio" name="safe[equipement_PAT_tested]" value="your equipement PAT tested within the last 2 years missing" id="equipement_PAT_tested2" <?php if($htmldata['safe']['data']['equipement_PAT_tested']['value']=="your equipement PAT tested within the last 2 years missing") echo "checked";?>>
                                    <label for="equipement_PAT_tested2">No</label>

                                    <input type="radio" name="safe[equipement_PAT_tested]" value="N/A" id="equipement_PAT_tested3" <?php if($htmldata['safe']['data']['equipement_PAT_tested']['value']=="N/A") echo "checked";?>>
<label for="equipement_PAT_tested3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>


                                <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[oxygen_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['equipement_PAT_tested']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your equipement PAT tested within the last 2 years missing" >
                           
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                   
                    <div class="question">
                        <div class="numb">29.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                   Has there been a fixed wire testing within the last 5 years
                                </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[fixed_wire_testing_question]" value="Has there been a fixed wire testing within the last 5 years">
                                    <!-- <input type="hidden" name="safe[fixed_wire_testing_id]" value="yes"> -->
                                    <input type="radio" name="safe[fixed_wire_testing]" value="yes" id="fixed_wire_testing" <?php if($htmldata['safe']['data']['fixed_wire_testing']['value']=="yes") echo "checked";?>>
                                    <label for="fixed_wire_testing">Yes</label>
                                    <input type="radio" name="safe[fixed_wire_testing]" value="your fixed wire testing missing" id="fixed_wire_testing2" <?php if($htmldata['safe']['data']['fixed_wire_testing']['value']=="your fixed wire testing missing") echo "checked";?>>
                                    <label for="fixed_wire_testing2">No</label>


                                                       <input type="radio" name="safe[fixed_wire_testing]" value="N/A" id="fixed_wire_testing3" <?php if($htmldata['safe']['data']['fixed_wire_testing']['value']=="N/A") echo "checked";?>>
<label for="fixed_wire_testing3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fixed_wire_testing_comment]" class="form-control"><?php echo $htmldata['safe']['data']['fixed_wire_testing']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                     <!-- question -->
                   <div class="question">
                        <div class="numb">30.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Was your washer disinfector serviced within the last 12 months </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[washer_disinfector_serviced_question]" value="Was your washer disinfector serviced within the last 12 months">
                                    <!-- <input type="hidden" name="safe[washer_disinfector_serviced_id]" value="yes"> -->
                                    <input type="radio" name="safe[washer_disinfector_serviced]" value="yes" id="washer_disinfector_serviced" <?php if($htmldata['safe']['data']['washer_disinfector_serviced']['value']=="yes") echo "checked";?>>
                                    <label for="washer_disinfector_serviced">Yes</label>
                                    <input type="radio" name="safe[washer_disinfector_serviced]" value="your washer disinfector serviced missing" id="washer_disinfector_serviced2" <?php if($htmldata['safe']['data']['washer_disinfector_serviced']['value']=="your washer disinfector serviced missing") echo "checked";?>>
                                    <label for="washer_disinfector_serviced2">No</label>


                                                        <input type="radio" name="safe[washer_disinfector_serviced]" value="N/A" id="washer_disinfector_serviced3" <?php if($htmldata['safe']['data']['washer_disinfector_serviced']['value']=="N/A") echo "checked";?>>
<label for="washer_disinfector_serviced3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               


                                      <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[washer_disinfector_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['washer_disinfector_serviced']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your washer disinfector serviced missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
                     <div class="question">
                        <div class="numb">31.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Has your fire extinguisher been serviced within the last 12 months </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[fire_extinguisher_been_serviced_question]" value="Has your fire extinguisher been serviced within the last 12 months">
                                    <!-- <input type="hidden" name="safe[fire_extinguisher_been_serviced_id]" value="yes"> -->
                                    <input type="radio" name="safe[fire_extinguisher_been_serviced]" value="yes" id="fire_extinguisher_been_serviced" <?php if($htmldata['safe']['data']['fire_extinguisher_been_serviced']['value']=="yes") echo "checked";?>>
                                    <label for="fire_extinguisher_been_serviced">Yes</label>
                                    <input type="radio" name="safe[fire_extinguisher_been_serviced]" value="your fixed fire extinguisher been serviced missing" id="fire_extinguisher_been_serviced2" <?php if($htmldata['safe']['data']['fire_extinguisher_been_serviced']['value']=="your fixed fire extinguisher been serviced missing") echo "checked";?>>
                                    <label for="fire_extinguisher_been_serviced2">No</label>


                                                           <input type="radio" name="safe[fire_extinguisher_been_serviced]" value="N/A" id="fire_extinguisher_been_serviced3" <?php if($htmldata['safe']['data']['fire_extinguisher_been_serviced']['value']=="N/A") echo "checked";?>>
<label for="fire_extinguisher_been_serviced3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                               
                                      <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fire_extinguisher_been_serviced_comment]" class="form-control"><?php echo $htmldata['safe']['data']['fire_extinguisher_been_serviced']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed fire extinguisher been serviced missing" >
                            
                        </div><hr>
                    </div> 
                     <!-- question -->
                     <div class="question">
                        <div class="numb">32.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you carry out regular tests on your fire alarm systems </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[regular_tests_on_your_fire_alarm_systems_question]" value="Do you carry out regular tests on your fire alarm systems">
                                    <!-- <input type="hidden" name="safe[regular_tests_on_your_fire_alarm_systems_id]" value="yes"> -->
                                    <input type="radio" name="safe[regular_tests_on_your_fire_alarm_systems]" value="yes" id="regular_tests_on_your_fire_alarm_systems" <?php if($htmldata['safe']['data']['regular_tests_on_your_fire_alarm_systems']['value']=="yes") echo "checked";?>>
                                    <label for="regular_tests_on_your_fire_alarm_systems">Yes</label>
                                    <input type="radio" name="safe[regular_tests_on_your_fire_alarm_systems]" value="your regular tests on your fire alarm systems missing" id="regular_tests_on_your_fire_alarm_systems2" <?php if($htmldata['safe']['data']['regular_tests_on_your_fire_alarm_systems']['value']=="your regular tests on your fire alarm systems missing") echo "checked";?>>
                                    <label for="regular_tests_on_your_fire_alarm_systems2">No</label>



                                    <input type="radio" name="safe[regular_tests_on_your_fire_alarm_systems]" value="N/A" id="regular_tests_on_your_fire_alarm_systems3" <?php if($htmldata['safe']['data']['regular_tests_on_your_fire_alarm_systems']['value']=="N/A") echo "checked";?>>
<label for="regular_tests_on_your_fire_alarm_systems3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
                                                                         <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[regular_tests_on_your_fire_alarm_systems_comment]" class="form-control"><?php echo $htmldata['safe']['data']['regular_tests_on_your_fire_alarm_systems']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your regular tests on your fire alarm systems missing" >
                            
                        </div><hr>
                    </div> 
                     <!-- question -->
                     <div class="question">
                        <div class="numb">33.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you carry out checks on your emergency lighting </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[checks_on_your_emergency_lighting_question]" value="Do you carry out checks on your emergency lighting">
                                    <!-- <input type="hidden" name="safe[checks_on_your_emergency_lighting_id]" value="yes"> -->
                                    <input type="radio" name="safe[checks_on_your_emergency_lighting]" value="yes" id="checks_on_your_emergency_lighting" <?php if($htmldata['safe']['data']['checks_on_your_emergency_lighting']['value']=="yes") echo "checked";?>>
                                    <label for="checks_on_your_emergency_lighting">Yes</label>
                                    <input type="radio" name="safe[checks_on_your_emergency_lighting]" value="your emergency lighting missing" id="checks_on_your_emergency_lighting2" <?php if($htmldata['safe']['data']['checks_on_your_emergency_lighting']['value']=="your emergency lighting missing") echo "checked";?>>
                                    <label for="checks_on_your_emergency_lighting2">No</label>


                                                           <input type="radio" name="safe[checks_on_your_emergency_lighting]" value="N/A" id="checks_on_your_emergency_lighting3" <?php if($htmldata['safe']['data']['checks_on_your_emergency_lighting']['value']=="N/A") echo "checked";?>>
<label for="checks_on_your_emergency_lighting3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[checks_on_your_emergency_lighting_comment]" class="form-control"><?php echo $htmldata['safe']['data']['checks_on_your_emergency_lighting']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your emergency lighting missing" >
                            
                        </div>
                    </div>

                  <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
                <!-- quest-box -->
         
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/policis_.png) ; background-repeat: no-repeat; background-position: center;"></div>                    <h3>Practice Policies </h3>
                 
                     <!-- question -->
                         <div class="question">
                        <div class="numb">34.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date cross infection policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[cross_infection_policy_question]" value="Do you have an up to date cross infection policy">
                                    <!-- <input type="hidden" name="safe[fixed_wire_testing_id]" value="yes"> -->
                                    <input type="radio" name="safe[cross_infection_policy]" value="yes" id="cross_infection_policy" <?php if($htmldata['safe']['data']['cross_infection_policy']['value']=="yes") echo "checked";?>>
                                    <label for="cross_infection_policy">Yes</label>
                                    <input type="radio" name="safe[cross_infection_policy]" value="your cross infection policy missing" id="cross_infection_policy2" <?php if($htmldata['safe']['data']['cross_infection_policy']['value']=="your cross infection policy missing") echo "checked";?>>
                                    <label for="cross_infection_policy2">No</label>


                                    <input type="radio" name="safe[cross_infection_policy]" value="N/A" id="cross_infection_policy3" <?php if($htmldata['safe']['data']['cross_infection_policy']['value']=="N/A") echo "checked";?>>
<label for="cross_infection_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
                                                          <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[cross_infection_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['cross_infection_policy']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your cross infection policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">35.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">DO you have an up to date consent policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_consent_policy_question]" value="DO you have an up to date consent policy">
                                    <!-- <input type="hidden" name="effective[up_to_date_consent_policy_id]" value="yes"> -->
                                    <input type="radio" name="effective[up_to_date_consent_policy]" value="yes" id="up_to_date_consent_policy" <?php if($htmldata['effective']['data']['up_to_date_consent_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_consent_policy">Yes</label>
                                    <input type="radio" name="effective[up_to_date_consent_policy]" value="your up to date consent policy missing" id="up_to_date_consent_policy2" <?php if($htmldata['effective']['data']['up_to_date_consent_policy']['value']=="your up to date consent policy missing") echo "checked";?>>
                                    <label for="up_to_date_consent_policy2">No</label>



                                           <input type="radio" name="effective[up_to_date_consent_policy]" value="N/A" id="up_to_date_consent_policy3" <?php if($htmldata['effective']['data']['up_to_date_consent_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_consent_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                                                         <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[up_to_date_consent_policy_comment]" class="form-control"><?php echo $htmldata['effective']['data']['up_to_date_consent_policy']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date consent policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">36.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date recruitmenet policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_recruitmenet_policy_question]" value="Do you have an up to date recruitmenet policy">
                                    <!-- <input type="hidden" name="safe[up_to_date_recruitmenet_policy_id]" value="yes"> -->
                                    <input type="radio" name="safe[up_to_date_recruitmenet_policy]" value="yes" id="up_to_date_recruitmenet_policy" <?php if($htmldata['safe']['data']['up_to_date_recruitmenet_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_recruitmenet_policy">Yes</label>
                                    <input type="radio" name="safe[up_to_date_recruitmenet_policy]" value="your up to date recruitmenet policy missing" id="up_to_date_recruitmenet_policy2" <?php if($htmldata['safe']['data']['up_to_date_recruitmenet_policy']['value']=="your up to date recruitmenet policy missing") echo "checked";?>>
                                    <label for="up_to_date_recruitmenet_policy2">No</label>



                                    <input type="radio" name="safe[up_to_date_recruitmenet_policy]" value="N/A" id="up_to_date_recruitmenet_policy3" <?php if($htmldata['safe']['data']['up_to_date_recruitmenet_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_recruitmenet_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
    <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[up_to_date_recruitmenet_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['up_to_date_recruitmenet_policy']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date recruitmenet policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">37.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date COVID 19 policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_COVID_19_policy_question]" value="Do you have an up to date COVID 19 policy">
                                    <!-- <input type="hidden" name="caring[up_to_date_COVID_19_policy_id]" value="yes"> -->
                                    <input type="radio" name="caring[up_to_date_COVID_19_policy]" value="yes" id="up_to_date_COVID_19_policy" <?php if($htmldata['caring']['data']['up_to_date_COVID_19_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_COVID_19_policy">Yes</label>
                                    <input type="radio" name="caring[up_to_date_COVID_19_policy]" value="your date COVID 19 Policy missing" id="up_to_date_COVID_19_policy2" <?php if($htmldata['caring']['data']['up_to_date_COVID_19_policy']['value']=="your date COVID 19 Policy missing") echo "checked";?>>
                                    <label for="up_to_date_COVID_19_policy2">No</label>



                                     <input type="radio" name="caring[up_to_date_COVID_19_policy]" value="N/A" id="up_to_date_COVID_19_policy3" <?php if($htmldata['caring']['data']['up_to_date_COVID_19_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_COVID_19_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                                   <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[up_to_date_COVID_19_policy_comment]" class="form-control"><?php echo $htmldata['caring']['data']['up_to_date_COVID_19_policy']['comment'];?></textarea>
    </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">38.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date complaint policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_complaint_policy_question]" value="Do you have an up to date complaint policy">
                                    <!-- <input type="hidden" name="caring[up_to_date_complaint_policy_id]" value="yes"> -->
                                    <input type="radio" name="caring[up_to_date_complaint_policy]" value="yes" id="up_to_date_complaint_policy" <?php if($htmldata['caring']['data']['up_to_date_complaint_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_complaint_policy">Yes</label>
                                    <input type="radio" name="caring[up_to_date_complaint_policy]" value="your fup to date complaint policy missing" id="up_to_date_complaint_policy2" <?php if($htmldata['caring']['data']['up_to_date_complaint_policy']['value']=="your fup to date complaint policy missing") echo "checked";?>>
                                    <label for="up_to_date_complaint_policy2">No</label>



                                           <input type="radio" name="caring[up_to_date_complaint_policy]" value="N/A" id="up_to_date_complaint_policy3" <?php if($htmldata['caring']['data']['up_to_date_complaint_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_complaint_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[up_to_date_complaint_policy_comment]" class="form-control"><?php echo $htmldata['caring']['data']['up_to_date_complaint_policy']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fup to date complaint policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
                    <!-- question -->
                         <div class="question">
                        <div class="numb">39.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date referral policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_referral_policy_question]" value="Do you have an up to date referral policy">
                                    <!-- <input type="hidden" name="safe[up_to_date_referral_policy_id]" value="yes"> -->
                                    <input type="radio" name="safe[up_to_date_referral_policy]" value="yes" id="up_to_date_referral_policy" <?php if($htmldata['safe']['data']['up_to_date_referral_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_referral_policy">Yes</label>
                                    <input type="radio" name="safe[up_to_date_referral_policy]" value="your up to date referral policy missing" id="up_to_date_referral_policy2" <?php if($htmldata['safe']['data']['up_to_date_referral_policy']['value']=="your up to date referral policy missing") echo "checked";?>>
                                    <label for="up_to_date_referral_policy2">No</label>




                                         <input type="radio" name="safe[up_to_date_referral_policy]" value="N/A" id="up_to_date_referral_policy3" <?php if($htmldata['safe']['data']['up_to_date_referral_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_referral_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[up_to_date_referral_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['up_to_date_referral_policy']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date referral policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">40.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date safeguarding policy</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[up_to_date_safeguarding_policy_question]" value="Do you have an up to date safeguarding policy">
                                    <!-- <input type="hidden" name="safe[up_to_date_safeguarding_policy_id]" value="yes"> -->
                                    <input type="radio" name="safe[up_to_date_safeguarding_policy]" value="yes" id="up_to_date_safeguarding_policy" <?php if($htmldata['safe']['data']['up_to_date_safeguarding_policy']['value']=="yes") echo "checked";?>>
                                    <label for="up_to_date_safeguarding_policy">Yes</label>
                                    <input type="radio" name="safe[up_to_date_safeguarding_policy]" value="your up to date safeguarding policy missing" id="up_to_date_safeguarding_policy2" <?php if($htmldata['safe']['data']['up_to_date_safeguarding_policy']['value']=="your up to date safeguarding policy missing") echo "checked";?>>
                                    <label for="up_to_date_safeguarding_policy2">No</label>



                                      <input type="radio" name="safe[up_to_date_safeguarding_policy]" value="N/A" id="up_to_date_safeguarding_policy3" <?php if($htmldata['safe']['data']['up_to_date_safeguarding_policy']['value']=="N/A") echo "checked";?>>
<label for="up_to_date_safeguarding_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                              <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[up_to_date_safeguarding_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['up_to_date_safeguarding_policy']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your up to date safeguarding policy missing" >
                            
                        </div>
                        
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
                         <div class="question">
                        <div class="numb">41.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have an up to date medical emergency policy or protocol ?</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[medical_emergency_policy_question]" value="Do you have an up to date medical emergency policy or protocol ?">
                                    <!-- <input type="hidden" name="wellled[medical_emergency_policy_id]" value="yes"> -->
                                    <input type="radio" name="wellled[medical_emergency_policy]" value="yes" id="medical_emergency_policy" <?php if($htmldata['wellled']['data']['medical_emergency_policy']['value']=="yes") echo "checked";?>>
                                    <label for="medical_emergency_policy">Yes</label>
                                    <input type="radio" name="wellled[medical_emergency_policy]" value="your medical emergency policy missing" id="medical_emergency_policy2" <?php if($htmldata['wellled']['data']['medical_emergency_policy']['value']=="your medical emergency policy missing") echo "checked";?>>
                                    <label for="medical_emergency_policy2">No</label>




                                          <input type="radio" name="wellled[medical_emergency_policy]" value="N/A" id="medical_emergency_policy3" <?php if($htmldata['wellled']['data']['medical_emergency_policy']['value']=="N/A") echo "checked";?>>
<label for="medical_emergency_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[medical_emergency_policy_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['medical_emergency_policy']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your medical emergency policy missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
      <!-- question -->
<div class="question">
<div class="numb">42.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do you have wrong site removal policy</div>
<div class="inputs mockinspection">
    <input type="hidden" name="form[wrong_site_removal_policy_question]" value="Do you have wrong site removal policy">
<input type="radio" name="safe[wrong_site_removal_policy]" value="yes" id="wrong_site_removal_policy" <?php if($htmldata['safe']['data']['wrong_site_removal_policy']['value']=="yes") echo "checked";?>>
<label for="wrong_site_removal_policy">Yes</label>
<input type="radio" name="safe[wrong_site_removal_policy]" value="your wrong site removal policy missing" id="wrong_site_removal_policy2" <?php if($htmldata['safe']['data']['wrong_site_removal_policy']['value']=="your wrong site removal policy missing") echo "checked";?>>
<label for="wrong_site_removal_policy2">No</label>
<input type="radio" name="safe[wrong_site_removal_policy]" value="N/A" id="wrong_site_removal_policy3" <?php if($htmldata['safe']['data']['wrong_site_removal_policy']['value']=="N/A") echo "checked";?>>
<label for="wrong_site_removal_policy3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>
</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[wrong_site_removal_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['wrong_site_removal_policy']['comment'];?></textarea>
</div>       
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your wrong site removal policy missing" >
</div><hr>
</div>
<!-- question --> 


<div class="question">
<div class="numb">43.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do you have an up to date business continuity plan</div>
<div class="inputs mockinspection">
    <input type="hidden" name="form[business_continuity_plan_question]" value="Do you have an up to date business continuity plan">
<input type="radio" name="effective[business_continuity_plan]" value="yes" id="business_continuity_plan" <?php if($htmldata['effective']['data']['business_continuity_plan']['value']=="yes") echo "checked";?>>
<label for="business_continuity_plan">Yes</label>
<input type="radio" name="effective[business_continuity_plan]" value="your business continuity plan missing" id="business_continuity_plan2" <?php if($htmldata['effective']['data']['business_continuity_plan']['value']=="your business continuity plan missing") echo "checked";?>>
<label for="business_continuity_plan2">No</label>
<input type="radio" name="effective[business_continuity_plan]" value="N/A" id="business_continuity_plan3" <?php if($htmldata['effective']['data']['business_continuity_plan']['value']=="N/A") echo "checked";?>>
<label for="business_continuity_plan3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>
</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[business_continuity_plan_comment]" class="form-control"><?php echo $htmldata['effective']['data']['business_continuity_plan']['comment'];?></textarea>
</div>       
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your business continuity plan missing" >
</div><hr>
</div>
<!-- question --> 

           




    <div class="question">
    <div class="numb">44.</div>
    <div class="quest">
    <div class="quest-inner">
    <div class="q">Do you have an up to date health and safety policy?</div>
    <div class="inputs mockinspection">
        <input type="hidden" name="form[health_and_safety_policy_question]" value="Do you have an up to date health and safety policy?">
    <input type="radio" name="safe[health_and_safety_policy]" value="yes" id="health_and_safety_policy" <?php if($htmldata['safe']['data']['health_and_safety_policy']['value']=="yes") echo "checked";?>>
    <label for="health_and_safety_policy">Yes</label>
    <input type="radio" name="safe[health_and_safety_policy]" value="your health and safety policy missing" id="health_and_safety_policy2" <?php if($htmldata['safe']['data']['health_and_safety_policy']['value']=="your health and safety policy missing") echo "checked";?>>
    <label for="health_and_safety_policy2">No</label>
    <input type="radio" name="safe[health_and_safety_policy]" value="N/A" id="health_and_safety_policy3" <?php if($htmldata['safe']['data']['health_and_safety_policy']['value']=="N/A") echo "checked";?>>
    <label for="health_and_safety_policy3">N/A</label>

    <div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>
    </div>
    <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[health_and_safety_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['health_and_safety_policy']['comment'];?></textarea>
    </div>       
    </div>
    </div>
    <div class="sh">
    <span>comment:</span>
    <input type="text" class="" value="your health and safety policy missing" >
    </div><hr>
    </div>
    <!-- question --> 




    <div class="question">
    <div class="numb">45.</div>
    <div class="quest">
    <div class="quest-inner">
    <div class="q">Do you have up to date whistleblowing policy ?</div>
    <div class="inputs mockinspection">
        <input type="hidden" name="form[whistleblowing_policy_question]" value="Do you have up to date whistleblowing policy ?">
    <input type="radio" name="safe[whistleblowing_policy]" value="yes" id="whistleblowing_policy" <?php if($htmldata['safe']['data']['whistleblowing_policy']['value']=="yes") echo "checked";?>>
    <label for="whistleblowing_policy">Yes</label>
    <input type="radio" name="safe[whistleblowing_policy]" value="your whistleblowing policy missing" id="whistleblowing_policy2" <?php if($htmldata['safe']['data']['whistleblowing_policy']['value']=="your whistleblowing policy missing") echo "checked";?>>
    <label for="whistleblowing_policy2">No</label>
    <input type="radio" name="safe[whistleblowing_policy]" value="N/A" id="whistleblowing_policy3" <?php if($htmldata['safe']['data']['whistleblowing_policy']['value']=="N/A") echo "checked";?>>
    <label for="whistleblowing_policy3">N/A</label>

    <div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>
    </div>
    <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[whistleblowing_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['whistleblowing_policy']['comment'];?></textarea>
    </div>       
    </div>
    </div>
    <div class="sh">
    <span>comment:</span>
    <input type="text" class="" value="your whistleblowing policy missing" >
    </div><hr>
    </div>
    <!-- question --> 



    <div class="question">
    <div class="numb">46.</div>
    <div class="quest">
    <div class="quest-inner">
    <div class="q">Do you have an up to date equality and diversity policy ?</div>
    <div class="inputs mockinspection">
        <input type="hidden" name="form[equality_and_diversity_policy_question]" value="Do you have an up to date equality and diversity policy ?">
    <input type="radio" name="safe[equality_and_diversity_policy]" value="yes" id="equality_and_diversity_policy" <?php if($htmldata['safe']['data']['equality_and_diversity_policy']['value']=="yes") echo "checked";?>>
    <label for="equality_and_diversity_policy">Yes</label>
    <input type="radio" name="safe[equality_and_diversity_policy]" value="your equality and diversity policy missing" id="equality_and_diversity_policy2" <?php if($htmldata['safe']['data']['equality_and_diversity_policy']['value']=="your equality and diversity policy missing") echo "checked";?>>
    <label for="equality_and_diversity_policy2">No</label>
    <input type="radio" name="safe[equality_and_diversity_policy]" value="N/A" id="equality_and_diversity_policy3" <?php if($htmldata['safe']['data']['equality_and_diversity_policy']['value']=="N/A") echo "checked";?>>
    <label for="equality_and_diversity_policy3">N/A</label>

    <div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>
    </div>
    <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[equality_and_diversity_policy_comment]" class="form-control"><?php echo $htmldata['safe']['data']['equality_and_diversity_policy']['comment'];?></textarea>
    </div>       
    </div>
    </div>
    <div class="sh">
    <span>comment:</span>
    <input type="text" class="" value="your equality and diversity policy missing" >
    </div>
    </div>
    <!-- question --> 



<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
                <!-- quest-box -->
               
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/staff_.png) ; background-repeat: no-repeat; background-position: center;"></div>                    <h3>Staff Management</h3>
                   

<div class="question">
<div class="numb">47.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is there a structure induction programme  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[structured_induction_programme_for_all_staff_question]" value="Is there a structure induction programme">
<!-- <input type="hidden" name="effective[level_1&2_safeguarding_training_certificate_id]" value="yes"> -->
<input type="radio" name="effective[structured_induction_programme_for_all_staff]" value="yes" id="structured_induction_programme_for_all_staff" <?php if($htmldata['effective']['data']['structured_induction_programme_for_all_staff']['value']=="yes") echo "checked";?>>
<label for="structured_induction_programme_for_all_staff">Yes</label>
<input type="radio" name="effective[structured_induction_programme_for_all_staff]" value="Ensure there is a structured induction programme for all staff" id="structured_induction_programme_for_all_staff2" <?php if($htmldata['effective']['data']['structured_induction_programme_for_all_staff']['value']=="Ensure there is a structured induction programme for all staff") echo "checked";?>>
<label for="structured_induction_programme_for_all_staff2">No</label>



   <input type="radio" name="effective[structured_induction_programme_for_all_staff]" value="N/A" id="structured_induction_programme_for_all_staff3" <?php if($htmldata['effective']['data']['structured_induction_programme_for_all_staff']['value']=="N/A") echo "checked";?>>
<label for="structured_induction_programme_for_all_staff3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[structured_induction_programme_for_all_staff_comment]" class="form-control"><?php echo $htmldata['effective']['data']['structured_induction_programme_for_all_staff']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure there is a structured induction programme for all staff" >

</div><hr>
</div>
<!-- question --> 
                   
                    <!-- question -->
                         <div class="question">
                        <div class="numb">48.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all staff have up to date DBS </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[staff_have_up_to_date_DB_question]" value="Do all staff have up to date DBS">
                                    <!-- <input type="hidden" name="safe[staff_have_up_to_date_DB_id]" value="yes"> -->
                                    <input type="radio" name="safe[staff_have_up_to_date_DB]" value="yes" id="staff_have_up_to_date_DB" <?php if($htmldata['safe']['data']['staff_have_up_to_date_DB']['value']=="yes") echo "checked";?>>
                                    <label for="staff_have_up_to_date_DB">Yes</label>
                                    <input type="radio" name="safe[staff_have_up_to_date_DB]" value="your staff have up to date DB missing" id="staff_have_up_to_date_DB2" <?php if($htmldata['safe']['data']['staff_have_up_to_date_DB']['value']=="your staff have up to date DB missing") echo "checked";?>>
                                    <label for="staff_have_up_to_date_DB2">No</label>







                                       <input type="radio" name="safe[staff_have_up_to_date_DB]" value="N/A" id="staff_have_up_to_date_DB3" <?php if($htmldata['safe']['data']['staff_have_up_to_date_DB']['value']=="N/A") echo "checked";?>>
<label for="staff_have_up_to_date_DB3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                       <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[staff_have_up_to_date_DB_comment]" class="form-control"><?php echo $htmldata['safe']['data']['staff_have_up_to_date_DB']['comment'];?></textarea>
</div>  
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your staff have up to date DB missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">49.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all clinical staff have GDC number </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[clinical_staff_have_GDC_number_question]" value="Do all clinical staff have GDC number">
                                    <!-- <input type="hidden" name="safe[clinical_staff_have_GDC_number_id]" value="yes"> -->
                                    <input type="radio" name="safe[clinical_staff_have_GDC_number]" value="yes" id="clinical_staff_have_GDC_number" <?php if($htmldata['safe']['data']['clinical_staff_have_GDC_number']['value']=="yes") echo "checked";?>>
                                    <label for="clinical_staff_have_GDC_number">Yes</label>
                                    <input type="radio" name="safe[clinical_staff_have_GDC_number]" value="your fixed wire testing missing" id="clinical_staff_have_GDC_number2" <?php if($htmldata['safe']['data']['clinical_staff_have_GDC_number']['value']=="your fixed wire testing missing") echo "checked";?>>
                                    <label for="clinical_staff_have_GDC_number2">No</label>









                                       <input type="radio" name="safe[clinical_staff_have_GDC_number]" value="N/A" id="clinical_staff_have_GDC_number3" <?php if($htmldata['safe']['data']['clinical_staff_have_GDC_number']['value']=="N/A") echo "checked";?>>
<label for="clinical_staff_have_GDC_number3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[clinical_staff_have_GDC_number_comment]" class="form-control"><?php echo $htmldata['safe']['data']['clinical_staff_have_GDC_number']['comment'];?></textarea>
</div>  
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">50.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all staff have proof of identification </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[proof_of_identification_question]" value="Do all staff have proof of identification">
                                    <!-- <input type="hidden" name="safe[proof_of_identification_id]" value="yes"> -->
                                    <input type="radio" name="safe[proof_of_identification]" value="yes" id="proof_of_identification" <?php if($htmldata['safe']['data']['proof_of_identification']['value']=="yes") echo "checked";?>>
                                    <label for="proof_of_identification">Yes</label>
                                    <input type="radio" name="safe[proof_of_identification]" value="your staff have proof of identification missing" id="proof_of_identification2" <?php if($htmldata['safe']['data']['proof_of_identification']['value']=="your staff have proof of identification missing") echo "checked";?>>
                                    <label for="proof_of_identification2">No</label>



                                         <input type="radio" name="safe[proof_of_identification]" value="N/A" id="proof_of_identification3" <?php if($htmldata['safe']['data']['proof_of_identification']['value']=="N/A") echo "checked";?>>
<label for="proof_of_identification3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>






                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[proof_of_identification_comment]" class="form-control"><?php echo $htmldata['safe']['data']['proof_of_identification']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your staff have proof of identification missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">51.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all clinical staff have immunisation record </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[staff_have_immunisation_record_question]" value="Do all clinical staff have immunisation record">
                                    <!-- <input type="hidden" name="safe[staff_have_immunisation_record_id]" value="yes"> -->
                                    <input type="radio" name="safe[staff_have_immunisation_record]" value="yes" id="staff_have_immunisation_record" <?php if($htmldata['safe']['data']['staff_have_immunisation_record']['value']=="yes") echo "checked";?>>
                                    <label for="staff_have_immunisation_record">Yes</label>
                                    <input type="radio" name="safe[staff_have_immunisation_record]" value="your staff have immunisation record missing" id="staff_have_immunisation_record2" <?php if($htmldata['safe']['data']['staff_have_immunisation_record']['value']=="your staff have immunisation record missing") echo "checked";?>>
                                    <label for="staff_have_immunisation_record2">No</label>


                                       <input type="radio" name="safe[staff_have_immunisation_record]" value="N/A" id="staff_have_immunisation_record3" <?php if($htmldata['safe']['data']['staff_have_immunisation_record']['value']=="N/A") echo "checked";?>>
<label for="staff_have_immunisation_record3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                              <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[staff_have_immunisation_record_comment]" class="form-control"><?php echo $htmldata['safe']['data']['staff_have_immunisation_record']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your staff have immunisation record missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">52.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you carry out staff appraisals </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[out_staff_appraisals_question]" value="Do you carry out staff appraisals">
                                    <!-- <input type="hidden" name="safe[out_staff_appraisals_id]" value="yes"> -->
                                    <input type="radio" name="safe[out_staff_appraisals]" value="yes" id="out_staff_appraisals" <?php if($htmldata['safe']['data']['out_staff_appraisals']['value']=="yes") echo "checked";?>>
                                    <label for="out_staff_appraisals">Yes</label>
                                    <input type="radio" name="safe[out_staff_appraisals]" value="your out staff appraisals missing" id="out_staff_appraisals2" <?php if($htmldata['safe']['data']['out_staff_appraisals']['value']=="your out staff appraisals missing") echo "checked";?>>
                                    <label for="out_staff_appraisals2">No</label>






                                        <input type="radio" name="safe[out_staff_appraisals]" value="N/A" id="out_staff_appraisals3" <?php if($htmldata['safe']['data']['out_staff_appraisals']['value']=="N/A") echo "checked";?>>
<label for="out_staff_appraisals3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                                                                                             <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[out_staff_appraisals_comment]" class="form-control"><?php echo $htmldata['safe']['data']['out_staff_appraisals']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your out staff appraisals missing">
                            
                        </div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">53.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all staff have cross infection training certificates </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[cross_infection_training_certificates_question]" value="Do all staff have cross infection training certificates">
                                    <!-- <input type="hidden" name="effective[cross_infection_training_certificates_id]" value="yes"> -->
                                    <input type="radio" name="effective[cross_infection_training_certificates]" value="yes" id="cross_infection_training_certificates" <?php if($htmldata['effective']['data']['cross_infection_training_certificates']['value']=="yes") echo "checked";?>>
                                    <label for="cross_infection_training_certificates">Yes</label>
                                    <input type="radio" name="effective[cross_infection_training_certificates]" value="your cross infection training certificates missing" id="cross_infection_training_certificates2" <?php if($htmldata['effective']['data']['cross_infection_training_certificates']['value']=="your cross infection training certificates missing") echo "checked";?>>
                                    <label for="cross_infection_training_certificates2">No</label>




                                           <input type="radio" name="effective[cross_infection_training_certificates]" value="N/A" id="cross_infection_training_certificates3" <?php if($htmldata['effective']['data']['cross_infection_training_certificates']['value']=="N/A") echo "checked";?>>
<label for="cross_infection_training_certificates3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[cross_infection_training_certificates_comment]" class="form-control"><?php echo $htmldata['effective']['data']['cross_infection_training_certificates']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your cross infection training certificates missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">54.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all staff have BLS/Medical emergency training certificate </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[BLS/Medical_emergency_training_certificate_question]" value="Do all staff have BLS/Medical emergency training certificate">
                                    <!-- <input type="hidden" name="effective[BLS/Medical_emergency_training_certificate_id]" value="yes"> -->
                                    <input type="radio" name="effective[BLS/Medical_emergency_training_certificate]" value="yes" id="BLS/Medical_emergency_training_certificate" <?php if($htmldata['effective']['data']['BLS/Medical_emergency_training_certificate']['value']=="yes") echo "checked";?>>
                                    <label for="BLS/Medical_emergency_training_certificate">Yes</label>
                                    <input type="radio" name="effective[BLS/Medical_emergency_training_certificate]" value="your BLS/Medical emergency training certificate missing" id="BLS/Medical_emergency_training_certificate" <?php if($htmldata['effective']['data']['BLS/Medical_emergency_training_certificate']['value']=="your BLS/Medical emergency training certificate missing") echo "checked";?>>
                                    <label for="BLS/Medical_emergency_training_certificate2">No</label>


                                         <input type="radio" name="effective[BLS/Medical_emergency_training_certificate]" value="N/A" id="BLS/Medical_emergency_training_certificate" <?php if($htmldata['effective']['data']['BLS/Medical_emergency_training_certificate']['value']=="N/A") echo "checked";?>>
<label for="Medical_emergency_training_certificate3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[BLS/Medical_emergency_training_certificate_comment]" class="form-control"><?php echo $htmldata['effective']['data']['BLS/Medical_emergency_training_certificate']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your BLS/Medical emergency training certificate missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
<div class="question">
<div class="numb">55.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do all staff have level 1&2 safeguarding training certificate </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[safeguarding_training_certificate_question]" value="Do all staff have level 1&2 safeguarding training certificate">
<!-- <input type="hidden" name="effective[level_1&2_safeguarding_training_certificate_id]" value="yes"> -->
<input type="radio" name="effective[safeguarding_training_certificate]" value="yes" id="safeguarding_training_certificate" <?php if($htmldata['effective']['data']['safeguarding_training_certificate']['value']=="yes") echo "checked";?>>
<label for="safeguarding_training_certificate">Yes</label>
<input type="radio" name="effective[safeguarding_training_certificate]" value="your level 1&2 safeguarding training certificate missing" id="safeguarding_training_certificate2" <?php if($htmldata['effective']['data']['safeguarding_training_certificate']['value']=="your level 1&2 safeguarding training certificate missing") echo "checked";?>>
<label for="safeguarding_training_certificate2">No</label>



      <input type="radio" name="effective[safeguarding_training_certificate]" value="N/A" id="safeguarding_training_certificate3" <?php if($htmldata['effective']['data']['safeguarding_training_certificate']['value']=="N/A") echo "checked";?>>
<label for="safeguarding_training_certificate3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[safeguarding_training_certificate_comment]" class="form-control"><?php echo $htmldata['effective']['data']['safeguarding_training_certificate']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your level 1&2 safeguarding training certificate missing" >

</div><hr>
</div>
<!-- question --> 











<div class="question">
<div class="numb">56.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do all staff have mental capacity training certificate </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[completed_mental_capacity_training_question]" value="Do all staff have mental capacity training certificate">
<!-- <input type="hidden" name="safe[level_1&2_safeguarding_training_certificate_id]" value="yes"> -->
<input type="radio" name="safe[completed_mental_capacity_training]" value="yes" id="completed_mental_capacity_training"  <?php if($htmldata['safe']['data']['completed_mental_capacity_training']['value']=="yes") echo "checked";?>>
<label for="completed_mental_capacity_training">Yes</label>
<input type="radio" name="safe[completed_mental_capacity_training]" value="Ensure all staff have completed mental capacity training" id="completed_mental_capacity_training2" <?php if($htmldata['safe']['data']['completed_mental_capacity_training']['value']=="Ensure all staff have completed mental capacity training") echo "checked";?>>
<label for="completed_mental_capacity_training2">No</label>







   <input type="radio" name="safe[completed_mental_capacity_training]" value="N/A" id="completed_mental_capacity_training3" <?php if($htmldata['safe']['data']['completed_mental_capacity_training']['value']=="N/A") echo "checked";?>>
<label for="completed_mental_capacity_training3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[completed_mental_capacity_training_comment]" class="form-control"><?php echo $htmldata['safe']['data']['completed_mental_capacity_training']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure all staff have completed mental capacity training" >

</div><hr>
</div>
<!-- question --> 






<div class="question">
<div class="numb">57.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do all staff have data protection training certificate  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[data_protection_training_certificate_question]" value="Do all staff have data protection training certificate">
<!-- <input type="hidden" name="safe[level_1&2_safeguarding_training_certificate_id]" value="yes"> -->
<input type="radio" name="safe[data_protection_training_certificate]" value="yes" id="data_protection_training_certificate" <?php if($htmldata['safe']['data']['data_protection_training_certificate']['value']=="yes") echo "checked";?>>
<label for="data_protection_training_certificate">Yes</label>
<input type="radio" name="safe[data_protection_training_certificate]" value="Ensure all staff have completed data protection training" id="data_protection_training_certificate2" <?php if($htmldata['safe']['data']['data_protection_training_certificate']['value']=="Ensure all staff have completed data protection training") echo "checked";?>>
<label for="data_protection_training_certificate2">No</label>







   <input type="radio" name="safe[data_protection_training_certificate]" value="N/A" id="data_protection_training_certificate3" <?php if($htmldata['safe']['data']['data_protection_training_certificate']['value']=="N/A") echo "checked";?>>
<label for="data_protection_training_certificate3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[data_protection_training_certificate_comment]" class="form-control"><?php echo $htmldata['safe']['data']['data_protection_training_certificate']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure all staff have completed data protection training" >

</div><hr>
</div>
<!-- question --> 





<div class="question">
<div class="numb">58.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Do all staff have knowledge and understanding of Gillick Competence  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[understanding_of_Gillick_Competence_question]" value="Do all staff have knowledge and understanding of Gillick Competence ">
<!-- <input type="hidden" name="safe[level_1&2_safeguarding_training_certificate_id]" value="yes"> -->
<input type="radio" name="safe[understanding_of_Gillick_Competence]" value="yes" id="understanding_of_Gillick_Competence" <?php if($htmldata['safe']['data']['understanding_of_Gillick_Competence']['value']=="yes") echo "checked";?>>
<label for="understanding_of_Gillick_Competence">Yes</label>
<input type="radio" name="safe[understanding_of_Gillick_Competence]" value="Ensure all staff have knowledge and understanding of Gillick competency" id="understanding_of_Gillick_Competence2" <?php if($htmldata['safe']['data']['understanding_of_Gillick_Competence']['value']=="Ensure all staff have knowledge and understanding of Gillick competency") echo "checked";?>>
<label for="understanding_of_Gillick_Competence2">No</label>








   <input type="radio" name="safe[understanding_of_Gillick_Competence]" value="N/A" id="understanding_of_Gillick_Competence3" <?php if($htmldata['safe']['data']['understanding_of_Gillick_Competence']['value']=="N/A") echo "checked";?>>
<label for="understanding_of_Gillick_Competence3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[understanding_of_Gillick_Competence_comment]" class="form-control"><?php echo $htmldata['safe']['data']['understanding_of_Gillick_Competence']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure all staff have knowledge and understanding of Gillick competency" >

</div>
</div>
<!-- question --> 

<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
                <!-- quest-box -->
               
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/radi_.png) ; background-repeat: no-repeat; background-position: center;"></div>                    <h3>Radiation Document </h3>
                    
<div class="question">
<div class="numb">59.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are there radiation isolation switches present outside the surgery </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[radiation_isolation_switches_present_question]" value="Are there radiation isolation switches present outside the surgery">
<!-- <input type="hidden" name="safe[HSE_for_radiation_equipement_id]" value="yes"> -->
<input type="radio" name="safe[radiation_isolation_switches_present]" value="yes" id="radiation_isolation_switches_present" <?php if($htmldata['safe']['data']['radiation_isolation_switches_present']['value']=="yes") echo "checked";?>>
<label for="radiation_isolation_switches_present">Yes</label>
<input type="radio" name="safe[radiation_isolation_switches_present]" value="Ensure there are radiation isolation switches present, and signages" id="radiation_isolation_switches_present2" <?php if($htmldata['safe']['data']['radiation_isolation_switches_present']['value']=="Ensure there are radiation isolation switches present, and signages") echo "checked";?>>
<label for="radiation_isolation_switches_present2">No</label>


<input type="radio" name="safe[radiation_isolation_switches_present]" value="N/A" id="radiation_isolation_switches_present3" <?php if($htmldata['safe']['data']['radiation_isolation_switches_present']['value']=="N/A") echo "checked";?>>
<label for="radiation_isolation_switches_present3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[radiation_isolation_switches_present_comment]" class="form-control"><?php echo $htmldata['safe']['data']['radiation_isolation_switches_present']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure there are radiation isolation switches present, and signages" >

</div><hr>
</div>
<!-- question --> 

                    <!-- question -->
                         <div class="question">
                        <div class="numb">60.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you a dedicated RPS, RPS </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[dedicated_RPS_RPS_question]" value="Do you a dedicated RPS, RPS ">
                                    <!-- <input type="hidden" name="safe[dedicated_RPS_RPS_id]" value="yes"> -->
                                    <input type="radio" name="safe[dedicated_RPS_RPS]" value="yes" id="dedicated_RPS_RPS" <?php if($htmldata['safe']['data']['dedicated_RPS_RPS']['value']=="yes") echo "checked";?>>
                                    <label for="dedicated_RPS_RPS">Yes</label>
                                    <input type="radio" name="safe[dedicated_RPS_RPS]" value="your fdedicated RPS, RPS missing" id="dedicated_RPS_RPS2" <?php if($htmldata['safe']['data']['dedicated_RPS_RPS']['value']=="your fdedicated RPS, RPS missing") echo "checked";?>>
                                    <label for="dedicated_RPS_RPS2">No</label>



   <input type="radio" name="safe[dedicated_RPS_RPS]" value="N/A" id="dedicated_RPS_RPS3" <?php if($htmldata['safe']['data']['dedicated_RPS_RPS']['value']=="N/A") echo "checked";?>>
<label for="dedicated_RPS_RPS3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[dedicated_RPS_RPS_comment]" class="form-control"><?php echo $htmldata['safe']['data']['dedicated_RPS_RPS']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fdedicated RPS, RPS missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">61.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you have local rules </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[local_rules_question]" value="Do you have local rules">
                                    <!-- <input type="hidden" name="safe[local rules_id]" value="yes"> -->
                                    <input type="radio" name="safe[local_rules]" value="yes" id="local_rules" <?php if($htmldata['safe']['data']['local_rules']['value']=="yes") echo "checked";?>>
                                    <label for="local_rules">Yes</label>
                                    <input type="radio" name="safe[local_rules]" value="your local rules missing" id="local_rules2" <?php if($htmldata['safe']['data']['local_rules']['value']=="your local rules missing") echo "checked";?>>
                                    <label for="local_rules2">No</label>




   <input type="radio" name="safe[local_rules]" value="N/A" id="local_rules3" <?php if($htmldata['safe']['data']['local_rules']['value']=="N/A") echo "checked";?>>
<label for="local_rules3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[local_rules_comment]" class="form-control"><?php echo $htmldata['safe']['data']['local_rules']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your local rules missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">62.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a radiation risk assessment </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[radiation_risk_assessment_question]" value="Is there a radiation risk assessment">
                                    <!-- <input type="hidden" name="safe[fixed_wire_testing_id]" value="yes"> -->
                                    <input type="radio" name="safe[radiation_risk_assessment]" value="yes" id="radiation_risk_assessment" <?php if($htmldata['safe']['data']['radiation_risk_assessment']['value']=="yes") echo "checked";?>>
                                    <label for="radiation_risk_assessment">Yes</label>
                                    <input type="radio" name="safe[radiation_risk_assessment]" value="your radiation risk assessment missing" id="radiation_risk_assessment2" <?php if($htmldata['safe']['data']['radiation_risk_assessment']['value']=="your radiation risk assessment missing") echo "checked";?>>
                                    <label for="radiation_risk_assessment2">No</label>







   <input type="radio" name="safe[radiation_risk_assessment]" value="N/A" id="radiation_risk_assessment3" <?php if($htmldata['safe']['data']['radiation_risk_assessment']['value']=="N/A") echo "checked";?>>
<label for="radiation_risk_assessment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[radiation_risk_assessment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['radiation_risk_assessment']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your radiation risk assessment missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">63.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there critical examination report for radiation equipement </div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[report_for_radiation_equipement_question]" value="Is there critical examination report for radiation equipement">
                                    <!-- <input type="hidden" name="safe[report_for_radiation_equipement_id]" value="yes"> -->
                                    <input type="radio" name="safe[report_for_radiation_equipement]" value="yes" id="report_for_radiation_equipement" <?php if($htmldata['safe']['data']['report_for_radiation_equipement']['value']=="yes") echo "checked";?>>
                                    <label for="report_for_radiation_equipement">Yes</label>
                                    <input type="radio" name="safe[report_for_radiation_equipement]" value="your report for radiation equipement missing" id="report_for_radiation_equipement2" <?php if($htmldata['safe']['data']['report_for_radiation_equipement']['value']=="your report for radiation equipement missing") echo "checked";?>>
                                    <label for="report_for_radiation_equipement2">No</label>




   <input type="radio" name="safe[report_for_radiation_equipement]" value="N/A" id="report_for_radiation_equipement3" <?php if($htmldata['safe']['data']['report_for_radiation_equipement']['value']=="N/A") echo "checked";?>>
<label for="report_for_radiation_equipement3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[report_for_radiation_equipement_comment]" class="form-control"><?php echo $htmldata['safe']['data']['report_for_radiation_equipement']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your report for radiation equipement missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
<div class="question">
<div class="numb">64.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is the practice registered with the HSE for radiation equipement </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[HSE_for_radiation_equipement_question]" value="Is the practice registered with the HSE for radiation equipement">
<!-- <input type="hidden" name="safe[HSE_for_radiation_equipement_id]" value="yes"> -->
<input type="radio" name="safe[HSE_for_radiation_equipement]" value="yes" id="HSE_for_radiation_equipement" <?php if($htmldata['safe']['data']['HSE_for_radiation_equipement']['value']=="yes") echo "checked";?>>
<label for="HSE_for_radiation_equipement">Yes</label>
<input type="radio" name="safe[HSE_for_radiation_equipement]" value="your HSE for radiation equipement missing" id="HSE_for_radiation_equipement2" <?php if($htmldata['safe']['data']['HSE_for_radiation_equipement']['value']=="your HSE for radiation equipement missing") echo "checked";?>>
<label for="HSE_for_radiation_equipement2">No</label>



<input type="radio" name="safe[HSE_for_radiation_equipement]" value="N/A" id="HSE_for_radiation_equipement3" <?php if($htmldata['safe']['data']['HSE_for_radiation_equipement']['value']=="N/A") echo "checked";?>>
<label for="HSE_for_radiation_equipement3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[HSE_for_radiation_equipement_comment]" class="form-control"><?php echo $htmldata['safe']['data']['HSE_for_radiation_equipement']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your HSE for radiation equipement missing" >

</div><hr>
</div>
<!-- question --> 




<div class="question">
<div class="numb">65.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are rectangular collimators present on the x-ray units  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[present_on_the_x-ray_units_question]" value="Are rectangular collimators present on the x-ray units">
<!-- <input type="hidden" name="safe[HSE_for_radiation_equipement_id]" value="yes"> -->
<input type="radio" name="safe[present_on_the_x-ray_units]" value="yes" id="present_on_the_x-ray_units" <?php if($htmldata['safe']['data']['present_on_the_x-ray_units']['value']=="yes") echo "checked";?>>
<label for="present_on_the_x-ray_units">Yes</label>
<input type="radio" name="safe[present_on_the_x-ray_units]" value="Ensure rectangular collimators are present on the x-ray units" id="present_on_the_x-ray_units" <?php if($htmldata['safe']['data']['present_on_the_x-ray_units']['value']=="Ensure rectangular collimators are present on the x-ray units") echo "checked";?>>
<label for="present_on_the_x-ray_units2">No</label>


<input type="radio" name="safe[present_on_the_x-ray_units]" value="N/A" id="present_on_the_x-ray_units" <?php if($htmldata['safe']['data']['present_on_the_x-ray_units']['value']=="N/A") echo "checked";?>>
<label for="present_on_the_x3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[present_on_the_x-ray_units_comment]" class="form-control"><?php echo $htmldata['safe']['data']['present_on_the_x-ray_units']['comment'];?></textarea>
</div> 
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure rectangular collimators are present on the x-ray units" >

</div>
</div>
<!-- question --> 







<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                    
                   <!--  <input class="submit_class" type="submit" value="Save"> -->
                    <hr>
                </div>
                <!-- quest-box -->
               
                <div class="quest-box">
<div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image:url(webImages/inform_.png); background-repeat: no-repeat; background-position: center;"></div>                    <h3>Practice Information </h3>
                   



<div class="question">
<div class="numb">66.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is dental dam used in line with guidance from the British Endodontic Society when providing root canal treatment ? </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment_question]" value="Is dental dam used in line with guidance from the British Endodontic Society when providing root canal treatment ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment]" value="yes" id="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment" <?php if($htmldata['safe']['data']['guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment']['value']=="yes") echo "checked";?>>
<label for="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment">Yes</label>
<input type="radio" name="safe[guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment]" value="Ensure dental rubber dam is used during root canal procedures and note is made on patient records" id="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment2" <?php if($htmldata['safe']['data']['guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment']['value']=="Ensure dental rubber dam is used during root canal procedures and note is made on patient records") echo "checked";?>>
<label for="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment2">No</label>




<input type="radio" name="safe[guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment]" value="N/A" id="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment3" <?php if($htmldata['safe']['data']['guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment']['value']=="N/A") echo "checked";?>>
<label for="guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['guidance_from_the_British_Endodontic_Society_when_providing_root_canaltreatment']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure dental rubber dam is used during root canal procedures and note is made on patient records" >

</div>
<hr>
</div>
<!-- question -->

 <!-- question -->
                         <div class="question">
                        <div class="numb">67.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do you offer sedation within your practice, if so is there a protocol present</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[you_offer_sedation_within_your_practice_question]" value="Do you offer sedation within your practice, if so is there a protocol present">
                                    <!-- <input type="hidden" name="safe[you_offer_sedation_within_your_practice_id]" value="yes"> -->
                                    <input type="radio" name="safe[you_offer_sedation_within_your_practice]" value="yes" id="you_offer_sedation_within_your_practice" <?php if($htmldata['safe']['data']['you_offer_sedation_within_your_practice']['value']=="yes") echo "checked";?>>
                                    <label for="you_offer_sedation_within_your_practice">Yes</label>
                                    <input type="radio" name="safe[you_offer_sedation_within_your_practice]" value="your offer sedation within your practice missing" id="you_offer_sedation_within_your_practice2" <?php if($htmldata['safe']['data']['you_offer_sedation_within_your_practice']['value']=="your offer sedation within your practice missing") echo "checked";?>>
                                    <label for="you_offer_sedation_within_your_practice2">No</label>




                                    <input type="radio" name="safe[you_offer_sedation_within_your_practice]" value="N/A" id="you_offer_sedation_within_your_practice3" <?php if($htmldata['safe']['data']['you_offer_sedation_within_your_practice']['value']=="N/A") echo "checked";?>>
<label for="you_offer_sedation_within_your_practice3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[you_offer_sedation_within_your_practice_comment]" class="form-control"><?php echo $htmldata['safe']['data']['you_offer_sedation_within_your_practice']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your offer sedation within your practice missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
                    <div class="question">
                        <div class="numb">68.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Does the practice have a process for taking consent from their patient</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[taking_consent_from_their_patient_question]" value="Does the practice have a process for taking consent from their patient">
                                    <!-- <input type="hidden" name="safe[taking_consent_from_their_patient_id]" value="yes"> -->
                                    <input type="radio" name="safe[taking_consent_from_their_patient]" value="yes" id="taking_consent_from_their_patient" <?php if($htmldata['safe']['data']['taking_consent_from_their_patient']['value']=="yes") echo "checked";?>>
                                    <label for="taking_consent_from_their_patient">Yes</label>
                                    <input type="radio" name="safe[taking_consent_from_their_patient]" value="your offer sedation within your practice missing" id="taking_consent_from_their_patient2" <?php if($htmldata['safe']['data']['taking_consent_from_their_patient']['value']=="your offer sedation within your practice missing") echo "checked";?>>
                                    <label for="taking_consent_from_their_patient2">No</label>



                                    <input type="radio" name="safe[taking_consent_from_their_patient]" value="N/A" id="taking_consent_from_their_patient3" <?php if($htmldata['safe']['data']['taking_consent_from_their_patient']['value']=="N/A") echo "checked";?>>
<label for="taking_consent_from_their_patient3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                              <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[taking_consent_from_their_patient_comment]" class="form-control"><?php echo $htmldata['safe']['data']['taking_consent_from_their_patient']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your offer sedation within your practice missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->  
 <!-- question -->
                         <div class="question">
                        <div class="numb">69.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q"> Does the practice have a COSHH Assessment folder for hazard substances</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[COSHH_Assessment_folder_for_hazard_substances_question]" value="Does the practice have a COSHH Assessment folder for hazard substances">
                                    <!-- <input type="hidden" name="responsive[COSHH_Assessment_folder_for_hazard_substances_id]" value="yes"> -->
                                    <input type="radio" name="responsive[COSHH_Assessment_folder_for_hazard_substances]" value="yes" id="COSHH_Assessment_folder_for_hazard_substances" <?php if($htmldata['responsive']['data']['COSHH_Assessment_folder_for_hazard_substances']['value']=="yes") echo "checked";?>>
                                    <label for="COSHH_Assessment_folder_for_hazard_substances">Yes</label>
                                    <input type="radio" name="responsive[COSHH_Assessment_folder_for_hazard_substances]" value="your COSHH Assessment folder for hazard substances missing" id="COSHH_Assessment_folder_for_hazard_substances2" <?php if($htmldata['responsive']['data']['COSHH_Assessment_folder_for_hazard_substances']['value']=="your COSHH Assessment folder for hazard substances missing") echo "checked";?>>
                                    <label for="COSHH_Assessment_folder_for_hazard_substances2">No</label>




                                    <input type="radio" name="responsive[COSHH_Assessment_folder_for_hazard_substances]" value="N/A" id="COSHH_Assessment_folder_for_hazard_substances3" <?php if($htmldata['responsive']['data']['COSHH_Assessment_folder_for_hazard_substances']['value']=="N/A") echo "checked";?>>
<label for="COSHH_Assessment_folder_for_hazard_substances3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[COSHH_Assessment_folder_for_hazard_substances_comment]" class="form-control"><?php echo $htmldata['responsive']['data']['COSHH_Assessment_folder_for_hazard_substances']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your COSHH Assessment folder for hazard substances missing">
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">70.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a procedure for patient to provide feedback on the service they have received</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[feedback_on_the_service_they_have_received_question]" value="Is there a procedure for patient to provide feedback on the service they have received">
                                    <!-- <input type="hidden" name="safe[feedback_on_the_service_they_have_received_id]" value="yes"> -->
                                    <input type="radio" name="safe[feedback_on_the_service_they_have_received]" value="yes" id="feedback_on_the_service_they_have_received" <?php if($htmldata['safe']['data']['feedback_on_the_service_they_have_received']['value']=="yes") echo "checked";?>>
                                    <label for="feedback_on_the_service_they_have_received">Yes</label>
                                    <input type="radio" name="safe[feedback_on_the_service_they_have_received]" value="your feedback on the service they have received missing" id="feedback_on_the_service_they_have_received2" <?php if($htmldata['safe']['data']['feedback_on_the_service_they_have_received']['value']=="your feedback on the service they have received missing") echo "checked";?>>
                                    <label for="feedback_on_the_service_they_have_received2">No</label>




<input type="radio" name="safe[feedback_on_the_service_they_have_received]" value="N/A" id="feedback_on_the_service_they_have_received3" <?php if($htmldata['safe']['data']['feedback_on_the_service_they_have_received']['value']=="N/A") echo "checked";?>>
<label for="feedback_on_the_service_they_have_received3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[feedback_on_the_service_they_have_received_comment]" class="form-control"><?php echo $htmldata['safe']['data']['feedback_on_the_service_they_have_received']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your feedback on the service they have received missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">71.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is the practice registered with the ICO</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[practice_registered_with_the_ICO_question]" value="Is the practice registered with the ICO">
                                    <!-- <input type="hidden" name="caring[practice_registered_with_the_ICO_id]" value="yes"> -->
                                    <input type="radio" name="caring[practice_registered_with_the_ICO]" value="yes" id="practice_registered_with_the_ICO" <?php if($htmldata['caring']['data']['practice_registered_with_the_ICO']['value']=="yes") echo "checked";?>>
                                    <label for="practice_registered_with_the_ICO">Yes</label>
                                    <input type="radio" name="caring[practice_registered_with_the_ICO]" value="your practice registered with the ICO missing" id="practice_registered_with_the_ICO2" <?php if($htmldata['caring']['data']['practice_registered_with_the_ICO']['value']=="your practice registered with the ICO missing") echo "checked";?>>
                                    <label for="practice_registered_with_the_ICO2">No</label>

                                    <input type="radio" name="caring[practice_registered_with_the_ICO]" value="N/A" id="practice_registered_with_the_ICO3" <?php if($htmldata['caring']['data']['practice_registered_with_the_ICO']['value']=="N/A") echo "checked";?>>
<label for="practice_registered_with_the_ICO3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                                                             <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[practice_registered_with_the_ICO_comment]" class="form-control"><?php echo $htmldata['caring']['data']['practice_registered_with_the_ICO']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your practice registered with the ICO missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">72.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Are there consignement notes for waste collection</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[notes_for_waste_collection_question]" value="Are there consignement notes for waste collection">
                                    <!-- <input type="hidden" name="wellled[notes_for_waste_collection_id]" value="yes"> -->
                                    <input type="radio" name="wellled[notes_for_waste_collection]" value="yes" id="notes_for_waste_collection" <?php if($htmldata['wellled']['data']['notes_for_waste_collection']['value']=="yes") echo "checked";?>>
                                    <label for="notes_for_waste_collection">Yes</label>
                                    <input type="radio" name="wellled[notes_for_waste_collection]" value="your fixed wire testing missing" id="notes_for_waste_collection2" <?php if($htmldata['wellled']['data']['notes_for_waste_collection']['value']=="your fixed wire testing missing") echo "checked";?>>
                                    <label for="notes_for_waste_collection2">No</label>


                                           <input type="radio" name="wellled[notes_for_waste_collection]" value="N/A" id="notes_for_waste_collection3" <?php if($htmldata['wellled']['data']['notes_for_waste_collection']['value']=="N/A") echo "checked";?>>
<label for="notes_for_waste_collection3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[notes_for_waste_collection_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['notes_for_waste_collection']['comment'];?></textarea>
</div>  
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">73.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there an up to date SOP reflecting COVID protocol</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[SOP_reflecting_COVID_protocol_question]" value="Is there an up to date SOP reflecting COVID protocol">
                                    <!-- <input type="hidden" name="wellled[SOP_reflecting_COVID_protocol_id]" value="yes"> -->
                                    <input type="radio" name="wellled[SOP_reflecting_COVID_protocol]" value="yes" id="SOP_reflecting_COVID_protocol" <?php if($htmldata['wellled']['data']['SOP_reflecting_COVID_protocol']['value']=="yes") echo "checked";?>>
                                    <label for="SOP_reflecting_COVID_protocol">Yes</label>
                                    <input type="radio" name="wellled[SOP_reflecting_COVID_protocol]" value="our SOP reflecting COVID protocol missing" id="SOP_reflecting_COVID_protocol2" <?php if($htmldata['wellled']['data']['SOP_reflecting_COVID_protocol']['value']=="our SOP reflecting COVID protocol missing") echo "checked";?>>
                                    <label for="SOP_reflecting_COVID_protocol2">No</label>



                                           <input type="radio" name="wellled[SOP_reflecting_COVID_protocol]" value="N/A" id="SOP_reflecting_COVID_protocol3" <?php if($htmldata['wellled']['data']['SOP_reflecting_COVID_protocol']['value']=="N/A") echo "checked";?>>
<label for="SOP_reflecting_COVID_protocol3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[SOP_reflecting_COVID_protocol_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['SOP_reflecting_COVID_protocol']['comment'];?></textarea>
</div>  
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your SOP reflecting COVID protocol missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">74.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a referral tracking procedure</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[referral_tracking_procedure_question]" value="Is there a referral tracking procedure">
                                    <!-- <input type="hidden" name="effective[referral_tracking_procedure_id]" value="yes"> -->
                                    <input type="radio" name="effective[referral_tracking_procedure]" value="yes" id="referral_tracking_procedure" <?php if($htmldata['effective']['data']['referral_tracking_procedure']['value']=="yes") echo "checked";?>>
                                    <label for="referral_tracking_procedure">Yes</label>
                                    <input type="radio" name="effective[referral_tracking_procedure]" value="your fixed wire testing missing" id="referral_tracking_procedure2" <?php if($htmldata['effective']['data']['referral_tracking_procedure']['value']=="your fixed wire testing missing") echo "checked";?>>
                                    <label for="referral_tracking_procedure2">No</label>



                                           <input type="radio" name="effective[referral_tracking_procedure]" value="N/A" id="referral_tracking_procedure3" <?php if($htmldata['effective']['data']['referral_tracking_procedure']['value']=="N/A") echo "checked";?>>
<label for="referral_tracking_procedure3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[referral_tracking_procedure_comment]" class="form-control"><?php echo $htmldata['effective']['data']['referral_tracking_procedure']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">75.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a hearing loop present</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[hearing_loop_present_question]" value="Is there a hearing loop present">
                                    <!-- <input type="hidden" name="effective[hearing_loop_present_id]" value="yes"> -->
                                    <input type="radio" name="effective[hearing_loop_present]" value="yes" id="hearing_loop_present" <?php if($htmldata['effective']['data']['hearing_loop_present']['value']=="yes") echo "checked";?>>
                                    <label for="hearing_loop_present">Yes</label>
                                    <input type="radio" name="effective[hearing_loop_present]" value="your hearing loop present missing" id="hearing_loop_present2" <?php if($htmldata['effective']['data']['hearing_loop_present']['value']=="your hearing loop present missing") echo "checked";?>>
                                    <label for="hearing_loop_present2">No</label>


                                           <input type="radio" name="effective[hearing_loop_present]" value="N/A" id="hearing_loop_present3" <?php if($htmldata['effective']['data']['hearing_loop_present']['value']=="N/A") echo "checked";?>>
<label for="hearing_loop_present3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[hearing_loop_present_comment]" class="form-control"><?php echo $htmldata['effective']['data']['hearing_loop_present']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your hearing loop present missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">76.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Are there signages for sharps, handwashing, dirty clean area</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[handwashing_dirty_clean_area_question]" value="Are there signages for sharps, handwashing, dirty clean area">
                                    <!-- <input type="hidden" name="responsive[handwashing_dirty_clean_area_id]" value="yes"> -->
                                    <input type="radio" name="responsive[handwashing_dirty_clean_area]" value="yes" id="handwashing_dirty_clean_area" <?php if($htmldata['responsive']['data']['handwashing_dirty_clean_area']['value']=="yes") echo "checked";?>>
                                    <label for="handwashing_dirty_clean_area">Yes</label>
                                    <input type="radio" name="responsive[handwashing_dirty_clean_area]" value="your signages for sharps, handwashing, dirty clean area missing" id="handwashing_dirty_clean_area2" <?php if($htmldata['responsive']['data']['handwashing_dirty_clean_area']['value']=="your signages for sharps, handwashing, dirty clean area missing") echo "checked";?>>
                                    <label for="handwashing_dirty_clean_area2">No</label>


                                          <input type="radio" name="responsive[handwashing_dirty_clean_area]" value="N/A" id="handwashing_dirty_clean_area3" <?php if($htmldata['responsive']['data']['handwashing_dirty_clean_area']['value']=="N/A") echo "checked";?>>
<label for="handwashing_dirty_clean_area3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[handwashing_dirty_clean_area_comment]" class="form-control"><?php echo $htmldata['responsive']['data']['handwashing_dirty_clean_area']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your signages for sharps, handwashing, dirty clean area missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">77.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a cleaning protocol</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[cleaning_protocol_question]" value="Is there a cleaning protocol">
                                    <!-- <input type="hidden" name="safe[cleaning_protocol_id]" value="yes"> -->
                                    <input type="radio" name="safe[cleaning_protocol]" value="yes" id="cleaning_protocol" <?php if($htmldata['safe']['data']['cleaning_protocol']['value']=="yes") echo "checked";?>>
                                    <label for="cleaning_protocol">Yes</label>
                                    <input type="radio" name="safe[cleaning_protocol]" value="your cleaning protocol missing" id="cleaning_protocol2" <?php if($htmldata['safe']['data']['cleaning_protocol']['value']=="your cleaning protocol missing") echo "checked";?>>
                                    <label for="cleaning_protocol2">No</label>

                                      <input type="radio" name="safe[cleaning_protocol]" value="N/A" id="cleaning_protocol3" <?php if($htmldata['safe']['data']['cleaning_protocol']['value']=="N/A") echo "checked";?>>
<label for="cleaning_protocol3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[cleaning_protocol_comment]" class="form-control"><?php echo $htmldata['safe']['data']['cleaning_protocol']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your cleaning protocol missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">78.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a process of significant event analysis</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[significant_event_analysis_question]" value="Is there a process of significant event analysis">
                                    <!-- <input type="hidden" name="safe[significant_event_analysis_id]" value="yes"> -->
                                    <input type="radio" name="safe[significant_event_analysis]" value="yes" id="significant_event_analysis" <?php if($htmldata['safe']['data']['significant_event_analysis']['value']=="yes") echo "checked";?>>
                                    <label for="significant_event_analysis">Yes</label>
                                    <input type="radio" name="safe[significant_event_analysis]" value="your significant event analysis missing" id="significant_event_analysis2" <?php if($htmldata['safe']['data']['significant_event_analysis']['value']=="your significant event analysis missing") echo "checked";?>>
                                    <label for="significant_event_analysis2">No</label>

                                        <input type="radio" name="safe[significant_event_analysis]" value="N/A" id="significant_event_analysis3" <?php if($htmldata['safe']['data']['significant_event_analysis']['value']=="N/A") echo "checked";?>>
<label for="significant_event_analysis3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>
                               


                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[significant_event_analysis_comment]" class="form-control"><?php echo $htmldata['safe']['data']['significant_event_analysis']['comment'];?></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your significant event analysis missing" >
                            
                        </div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

                        <hr>
                    </div>
                    <!-- question --> 
 <!-- question -->
                         <div class="question">
                        <div class="numb">79.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Are drugs( antibiotics) kept in securely in a locked cupboard ?</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[securely_in_a_locked_cupboard_question]" value="Are drugs( antibiotics) kept in securely in a locked cupboard ?">
                                    <!-- <input type="hidden" name="safe[securely_in_a_locked_cupboard_id]" value="yes"> -->
                                    <input type="radio" name="safe[securely_in_a_locked_cupboard]" value="yes" id="securely_in_a_locked_cupboard" <?php if($htmldata['safe']['data']['securely_in_a_locked_cupboard']['value']=="yes") echo "checked";?>>
                                    <label for="securely_in_a_locked_cupboard">Yes</label>
                                    <input type="radio" name="safe[securely_in_a_locked_cupboard]" value="your drugs( antibiotics) kept in securely in a locked cupboard missing" id="securely_in_a_locked_cupboard2" <?php if($htmldata['safe']['data']['securely_in_a_locked_cupboard']['value']=="your drugs( antibiotics) kept in securely in a locked cupboard missing") echo "checked";?>>
                                    <label for="securely_in_a_locked_cupboard2">No</label>


                                    <input type="radio" name="safe[securely_in_a_locked_cupboard]" value="N/A" id="securely_in_a_locked_cupboard3" <?php if($htmldata['safe']['data']['securely_in_a_locked_cupboard']['value']=="N/A") echo "checked";?>>
<label for="securely_in_a_locked_cupboard3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[securely_in_a_locked_cupboard_comment]" class="form-control"><?php echo $htmldata['safe']['data']['securely_in_a_locked_cupboard']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your drugs( antibiotics) kept in securely in a locked cupboard missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">80.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is there a Health & Safety poster on display ?</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[Health_Safety_poster_on_display_question]" value="Is there a Health & Safety poster on display ?">
                                    <!-- <input type="hidden" name="safe[Health_Safety_poster_on_display_id]" value="yes"> -->
                                    <input type="radio" name="safe[Health_Safety_poster_on_display]" value="yes" id="Health_Safety_poster_on_display" <?php if($htmldata['safe']['data']['Health_Safety_poster_on_display']['value']=="yes") echo "checked";?>>
                                    <label for="Health_Safety_poster_on_display">Yes</label>
                                    <input type="radio" name="safe[Health_Safety_poster_on_display]" value="your  Health & Safety poster on display missing" id="Health_Safety_poster_on_display2" <?php if($htmldata['safe']['data']['Health_Safety_poster_on_display']['value']=="your  Health & Safety poster on display missing") echo "checked";?>>
                                    <label for="Health_Safety_poster_on_display2">No</label>

                                                <input type="radio" name="safe[Health_Safety_poster_on_display]" value="N/A" id="Health_Safety_poster_on_display3" <?php if($htmldata['safe']['data']['Health_Safety_poster_on_display']['value']=="N/A") echo "checked";?>>
<label for="Health_Safety_poster_on_display3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>
                               <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Health_Safety_poster_on_display_comment]" class="form-control"><?php echo $htmldata['safe']['data']['Health_Safety_poster_on_display']['comment'];?></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your  Health & Safety poster on display missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">81.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Are sharps disposed of in rigid containers with yellow lids labelled with date and located appropriately?</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[yellow_lids_labelled_with_date_and_located_appropriately_question]" value="Are sharps disposed of in rigid containers with yellow lids labelled with date and located appropriately?">
                                    <!-- <input type="hidden" name="safe[yellow_lids_labelled_with_date_and_located_id]" value="yes"> -->
                                    <input type="radio" name="safe[yellow_lids_labelled_with_date_and_located_appropriately]" value="yes" id="yellow_lids_labelled_with_date_and_located_appropriately" <?php if($htmldata['safe']['data']['yellow_lids_labelled_with_date_and_located_appropriately']['value']=="yes") echo "checked";?>>
                                    <label for="yellow_lids_labelled_with_date_and_located_appropriately">Yes</label>
                                    <input type="radio" name="safe[yellow_lids_labelled_with_date_and_located_appropriately]" value="your disposed of in rigid containers with yellow lids labelled with date and located appropriately missing" id="yellow_lids_labelled_with_date_and_located_appropriately2" <?php if($htmldata['safe']['data']['yellow_lids_labelled_with_date_and_located_appropriately']['value']=="your disposed of in rigid containers with yellow lids labelled with date and located appropriately missing") echo "checked";?>>
                                    <label for="yellow_lids_labelled_with_date_and_located_appropriately2">No</label>


                                          <input type="radio" name="safe[yellow_lids_labelled_with_date_and_located_appropriately]" value="N/A" id="yellow_lids_labelled_with_date_and_located_appropriately3" <?php if($htmldata['safe']['data']['yellow_lids_labelled_with_date_and_located_appropriately']['value']=="N/A") echo "checked";?>>
<label for="yellow_lids_labelled_with_date_and_located_appropriately3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



                                </div>
                                                             <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[yellow_lids_labelled_with_date_and_located_appropriately_comment]" class="form-control"><?php echo $htmldata['safe']['data']['yellow_lids_labelled_with_date_and_located_appropriately']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your disposed of in rigid containers with yellow lids labelled with date and located appropriately missing">
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question -->
 <!-- question -->
                         <div class="question">
                        <div class="numb">82.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Is your website up to date</div>
<!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                <div class="inputs mockinspection">
                                    <input type="hidden" name="form[website_up_to_date_question]" value="Is your website up to date">
                                    <!-- <input type="hidden" name="responsive[website_up_to_date_id]" value="yes"> -->
                                    <input type="radio" name="responsive[website_up_to_date]" value="yes" id="website_up_to_date" <?php if($htmldata['responsive']['data']['website_up_to_date']['value']=="yes") echo "checked";?>>
                                    <label for="website_up_to_date">Yes</label>
                                    <input type="radio" name="responsive[website_up_to_date]" value="your fixed wire testing missing" id="website_up_to_date2" <?php if($htmldata['responsive']['data']['website_up_to_date']['value']=="your fixed wire testing missing") echo "checked";?>>
                                    <label for="website_up_to_date2">No</label>



                                    <input type="radio" name="responsive[website_up_to_date]" value="N/A" id="website_up_to_date3" <?php if($htmldata['responsive']['data']['website_up_to_date']['value']=="N/A") echo "checked";?>>
<label for="website_up_to_date3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





                                </div>
                                                                                            <div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[website_up_to_date_comment]" class="form-control"><?php echo $htmldata['responsive']['data']['website_up_to_date']['comment'];?></textarea>
</div> 
                            </div>
                        </div>
                        <div class="sh">
                            <span>comment:</span>
                            <input type="text" class="" value="your fixed wire testing missing" >
                            
                        </div>

                        <hr>
                    </div>
                    <!-- question --> 
                    <!-- question -->
<div class="question">
<div class="numb">83.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Does the practice hold regular team meetings</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[practice_hold_regular_team_meetings_question]" value="Does the practice hold regular team meetings">
<!-- <input type="hidden" name="wellled[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="wellled[practice_hold_regular_team_meetings]" value="yes" id="practice_hold_regular_team_meetings" <?php if($htmldata['wellled']['data']['practice_hold_regular_team_meetings']['value']=="yes") echo "checked";?>>
<label for="practice_hold_regular_team_meetings">Yes</label>
<input type="radio" name="wellled[practice_hold_regular_team_meetings]" value="your practice hold regular team meetings missing" id="practice_hold_regular_team_meetings2" <?php if($htmldata['wellled']['data']['practice_hold_regular_team_meetings']['value']=="your practice hold regular team meetings missing") echo "checked";?>>
<label for="practice_hold_regular_team_meetings2">No</label>





                                    <input type="radio" name="wellled[practice_hold_regular_team_meetings]" value="N/A" id="practice_hold_regular_team_meetings3" <?php if($htmldata['wellled']['data']['practice_hold_regular_team_meetings']['value']=="N/A") echo "checked";?>>
<label for="practice_hold_regular_team_meetings3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[practice_hold_regular_team_meetings_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['practice_hold_regular_team_meetings']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="your practice hold regular team meetings missing" >

</div>
<hr>
</div>
<!-- question --> 













<div class="question">
<div class="numb">84.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is there a sepsis protocol and signage </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[sepsis_protocol_and_signage_question]" value="Is there a sepsis protocol and signage">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[sepsis_protocol_and_signage]" value="yes" id="sepsis_protocol_and_signage" <?php if($htmldata['safe']['data']['sepsis_protocol_and_signage']['value']=="yes") echo "checked";?>>
<label for="sepsis_protocol_and_signage">Yes</label>
<input type="radio" name="safe[sepsis_protocol_and_signage]" value="Ensure there is a sepsis protocol, staff have awareness and signages within the practice" id="sepsis_protocol_and_signage2" <?php if($htmldata['safe']['data']['sepsis_protocol_and_signage']['value']=="Ensure there is a sepsis protocol, staff have awareness and signages within the practice") echo "checked";?>>
<label for="sepsis_protocol_and_signage2">No</label>



                                    <input type="radio" name="safe[sepsis_protocol_and_signage]" value="N/A" id="sepsis_protocol_and_signage3" <?php if($htmldata['safe']['data']['sepsis_protocol_and_signage']['value']=="N/A") echo "checked";?>>
<label for="sepsis_protocol_and_signage3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[sepsis_protocol_and_signage_comment]" class="form-control"><?php echo $htmldata['safe']['data']['sepsis_protocol_and_signage']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure there is a sepsis protocol, staff have awareness and signages within the practice" >

</div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

<hr>
</div>
<!-- question --> 





<div class="question">
<div class="numb">85.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are accident and incident recorded and shared with the team</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[accident_and_incident_recorded_and_shared_question]" value="Are accident and incident recorded and shared with the team">
<!-- <input type="hidden" name="wellled[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="wellled[accident_and_incident_recorded_and_shared]" value="yes" id="accident_and_incident_recorded_and_shared" <?php if($htmldata['wellled']['data']['accident_and_incident_recorded_and_shared']['value']=="yes") echo "checked";?>>
<label for="accident_and_incident_recorded_and_shared">Yes</label>
<input type="radio" name="wellled[accident_and_incident_recorded_and_shared]" value="Ensure accident and incident are shared with the team" id="accident_and_incident_recorded_and_shared2" <?php if($htmldata['wellled']['data']['accident_and_incident_recorded_and_shared']['value']=="Ensure accident and incident are shared with the team") echo "checked";?>>
<label for="accident_and_incident_recorded_and_shared2">No</label>


                                   <input type="radio" name="wellled[accident_and_incident_recorded_and_shared]" value="N/A" id="accident_and_incident_recorded_and_shared3" <?php if($htmldata['wellled']['data']['accident_and_incident_recorded_and_shared']['value']=="N/A") echo "checked";?>>
<label for="accident_and_incident_recorded_and_shared3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[accident_and_incident_recorded_and_shared_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['accident_and_incident_recorded_and_shared']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure accident and incident are shared with the team" >

</div>
<hr>
</div>
<!-- question --> 







<div class="question">
<div class="numb">86.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is the practice registered for MHRA Alters</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[practice_registered_for_MHRA_Alters_question]" value="Is the practice registered for MHRA Alters">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[practice_registered_for_MHRA_Alters]" value="yes" id="practice_registered_for_MHRA_Alters" <?php if($htmldata['safe']['data']['practice_registered_for_MHRA_Alters']['value']=="yes") echo "checked";?>>
<label for="practice_registered_for_MHRA_Alters">Yes</label>
<input type="radio" name="safe[practice_registered_for_MHRA_Alters]" value="Ensure you have signed up to the MHRA Alters" id="practice_registered_for_MHRA_Alters2" <?php if($htmldata['safe']['data']['practice_registered_for_MHRA_Alters']['value']=="Ensure you have signed up to the MHRA Alters") echo "checked";?>>
<label for="practice_registered_for_MHRA_Alters2">No</label>



<input type="radio" name="safe[practice_registered_for_MHRA_Alters]" value="N/A" id="practice_registered_for_MHRA_Alters3" <?php if($htmldata['safe']['data']['practice_registered_for_MHRA_Alters']['value']=="N/A") echo "checked";?>>
<label for="practice_registered_for_MHRA_Alters3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[practice_registered_for_MHRA_Alters_comment]" class="form-control"><?php echo $htmldata['safe']['data']['practice_registered_for_MHRA_Alters']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure you have signed up to the MHRA Alters" >

</div>
<hr>
</div>
<!-- question -->



    




<div class="question">
<div class="numb">87.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is there evidence of recent complaints </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[evidence_of_recent_complaints_question]" value="Is there evidence of recent complaints">
<!-- <input type="hidden" name="wellled[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="wellled[evidence_of_recent_complaints]" value="yes" id="evidence_of_recent_complaints" <?php if($htmldata['wellled']['data']['evidence_of_recent_complaints']['value']=="yes") echo "checked";?>>
<label for="evidence_of_recent_complaints">Yes</label>
<input type="radio" name="wellled[evidence_of_recent_complaints]" value="Ensure there is a record of all complaints" id="evidence_of_recent_complaints2" <?php if($htmldata['wellled']['data']['evidence_of_recent_complaints']['value']=="Ensure there is a record of all complaints") echo "checked";?>>
<label for="evidence_of_recent_complaints2">No</label>


<input type="radio" name="wellled[evidence_of_recent_complaints]" value="N/A" id="evidence_of_recent_complaints3" <?php if($htmldata['wellled']['data']['evidence_of_recent_complaints']['value']=="N/A") echo "checked";?>>
<label for="evidence_of_recent_complaints3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[evidence_of_recent_complaints_comment]" class="form-control"><?php echo $htmldata['wellled']['data']['evidence_of_recent_complaints']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure there is a record of all complaints" >

</div>
<hr>
</div>
<!-- question --> 




<div class="question">
<div class="numb">88.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Is there a practice safeguarding lead and contact for local safeguarding authority </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[practice_safeguarding_lead_and_contact_for_local_safeguarding_question]" value="Is there a practice safeguarding lead and contact for local safeguarding authority">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[practice_safeguarding_lead_and_contact_for_local_safeguarding]" value="yes" id="practice_safeguarding_lead_and_contact_for_local_safeguarding" <?php if($htmldata['safe']['data']['practice_safeguarding_lead_and_contact_for_local_safeguarding']['value']=="yes") echo "checked";?>>
<label for="practice_safeguarding_lead_and_contact_for_local_safeguarding">Yes</label>
<input type="radio" name="safe[practice_safeguarding_lead_and_contact_for_local_safeguarding]" value="Ensure there is a dedicated safeguarding lead and staff are aware of this" id="practice_safeguarding_lead_and_contact_for_local_safeguarding2" <?php if($htmldata['safe']['data']['practice_safeguarding_lead_and_contact_for_local_safeguarding']['value']=="Ensure there is a dedicated safeguarding lead and staff are aware of this") echo "checked";?>>
<label for="practice_safeguarding_lead_and_contact_for_local_safeguarding2">No</label>


<input type="radio" name="safe[practice_safeguarding_lead_and_contact_for_local_safeguarding]" value="N/A" id="practice_safeguarding_lead_and_contact_for_local_safeguarding3" <?php if($htmldata['safe']['data']['practice_safeguarding_lead_and_contact_for_local_safeguarding']['value']=="N/A") echo "checked";?>>
<label for="practice_safeguarding_lead_and_contact_for_local_safeguarding3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[practice_safeguarding_lead_and_contact_for_local_safeguarding_comment]" class="form-control"><?php echo $htmldata['safe']['data']['practice_safeguarding_lead_and_contact_for_local_safeguarding']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure there is a dedicated safeguarding lead and staff are aware of this" >

</div>
<hr>
</div>
<!-- question -->






<div class="question">
<div class="numb">89.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Where nhs prescription are dispensed, is there a prescription log present ?  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[nhs_prescription_are_dispensed_question]" value="Where nhs prescription are dispensed, is there a prescription log present ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[nhs_prescription_are_dispensed]" value="yes" id="nhs_prescription_are_dispensed" <?php if($htmldata['safe']['data']['nhs_prescription_are_dispensed']['value']=="yes") echo "checked";?>>
<label for="nhs_prescription_are_dispensed">Yes</label>
<input type="radio" name="safe[nhs_prescription_are_dispensed]" value="Ensure NHS prescription log is kept" id="nhs_prescription_are_dispensed2" <?php if($htmldata['safe']['data']['nhs_prescription_are_dispensed']['value']=="Ensure NHS prescription log is kept") echo "checked";?>>
<label for="nhs_prescription_are_dispensed2">No</label>




<input type="radio" name="safe[nhs_prescription_are_dispensed]" value="N/A" id="nhs_prescription_are_dispensed3" <?php if($htmldata['safe']['data']['nhs_prescription_are_dispensed']['value']=="N/A") echo "checked";?>>
<label for="nhs_prescription_are_dispensed3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[nhs_prescription_are_dispensed_comment]" class="form-control"><?php echo $htmldata['safe']['data']['nhs_prescription_are_dispensed']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure NHS prescription log is kept" >

</div>
<hr>
</div>
<!-- question -->












<div class="question">
<div class="numb">90.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are prescription pads stored safely within lockable cupboards ?  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[stored_safely_within_lockable_cupboards_question]" value="Are prescription pads stored safely within lockable cupboards ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[stored_safely_within_lockable_cupboards]" value="yes" id="stored_safely_within_lockable_cupboards" <?php if($htmldata['safe']['data']['stored_safely_within_lockable_cupboards']['value']=="yes") echo "checked";?>>
<label for="stored_safely_within_lockable_cupboards">Yes</label>
<input type="radio" name="safe[stored_safely_within_lockable_cupboards]" value="Ensure prescription pad are stored safely" id="stored_safely_within_lockable_cupboards2" <?php if($htmldata['safe']['data']['stored_safely_within_lockable_cupboards']['value']=="Ensure prescription pad are stored safely") echo "checked";?>>
<label for="stored_safely_within_lockable_cupboards2">No</label>



<input type="radio" name="safe[stored_safely_within_lockable_cupboards]" value="N/A" id="stored_safely_within_lockable_cupboards3" <?php if($htmldata['safe']['data']['stored_safely_within_lockable_cupboards']['value']=="N/A") echo "checked";?>>
<label for="stored_safely_within_lockable_cupboards3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[stored_safely_within_lockable_cupboards_comment]" class="form-control"><?php echo $htmldata['safe']['data']['stored_safely_within_lockable_cupboards']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure prescription pad are stored safely" >

</div>
<?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Save" name ="save" style="margin-right: 20px; float: right;">
<?php }?>

<hr>
</div>
<!-- question -->




<div class="question">
<div class="numb">91.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Once sterilized are dental instruments pouched and dated according to the HTM 01-05 protocol ? </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[sterilized_are_dental_instruments_pouched_question]" value="Once sterilized are dental instruments pouched and dated according to the HTM 01-05 protocol ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[sterilized_are_dental_instruments_pouched]" value="yes" id="sterilized_are_dental_instruments_pouched" <?php if($htmldata['safe']['data']['sterilized_are_dental_instruments_pouched']['value']=="yes") echo "checked";?>>
<label for="sterilized_are_dental_instruments_pouched">Yes</label>
<input type="radio" name="safe[sterilized_are_dental_instruments_pouched]" value="Ensure dental instruments are pouched and dated" id="sterilized_are_dental_instruments_pouched2" <?php if($htmldata['safe']['data']['sterilized_are_dental_instruments_pouched']['value']=="Ensure dental instruments are pouched and dated") echo "checked";?>>
<label for="sterilized_are_dental_instruments_pouched2">No</label>


<input type="radio" name="safe[sterilized_are_dental_instruments_pouched]" value="N/A" id="sterilized_are_dental_instruments_pouched3" <?php if($htmldata['safe']['data']['sterilized_are_dental_instruments_pouched']['value']=="N/A") echo "checked";?>>
<label for="sterilized_are_dental_instruments_pouched3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[sterilized_are_dental_instruments_pouched_comment]" class="form-control"><?php echo $htmldata['safe']['data']['sterilized_are_dental_instruments_pouched']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure dental instruments are pouched and dated" >

</div>
<hr>
</div>
<!-- question -->




<div class="question">
<div class="numb">92.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are patient-specific dental appliances were disinfected prior to being sent to a dental laboratory ?</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[disinfected_prior_to_being_sent_to_a_dental_laboratory_question]" value="Are patient-specific dental appliances were disinfected prior to being sent to a dental laboratory ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[disinfected_prior_to_being_sent_to_a_dental_laboratory]" value="yes" id="disinfected_prior_to_being_sent_to_a_dental_laboratory" <?php if($htmldata['safe']['data']['disinfected_prior_to_being_sent_to_a_dental_laboratory']['value']=="yes") echo "checked";?>>
<label for="disinfected_prior_to_being_sent_to_a_dental_laboratory">Yes</label>
<input type="radio" name="safe[disinfected_prior_to_being_sent_to_a_dental_laboratory]" value="Ensure dental appliances are disinfected proper to being sent to the laboratory" id="disinfected_prior_to_being_sent_to_a_dental_laboratory2" <?php if($htmldata['safe']['data']['disinfected_prior_to_being_sent_to_a_dental_laboratory']['value']=="Ensure dental appliances are disinfected proper to being sent to the laboratory") echo "checked";?>>
<label for="disinfected_prior_to_being_sent_to_a_dental_laboratory2">No</label>

<input type="radio" name="safe[disinfected_prior_to_being_sent_to_a_dental_laboratory]" value="N/A" id="disinfected_prior_to_being_sent_to_a_dental_laboratory3" <?php if($htmldata['safe']['data']['disinfected_prior_to_being_sent_to_a_dental_laboratory']['value']=="N/A") echo "checked";?>>
<label for="disinfected_prior_to_being_sent_to_a_dental_laboratory3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>



</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[disinfected_prior_to_being_sent_to_a_dental_laboratory_comment]" class="form-control"><?php echo $htmldata['safe']['data']['disinfected_prior_to_being_sent_to_a_dental_laboratory']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure dental appliances are disinfected proper to being sent to the laboratory" >

</div>
<hr>
</div>
<!-- question -->













<div class="question">
<div class="numb">93.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are staff aware of the Better Oral Health Toolkit?</div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[Better_Oral_Health_Toolkit_question]" value="Are staff aware of the Better Oral Health Toolkit?">
<!-- <input type="hidden" name="effective[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="effective[Better_Oral_Health_Toolkit]" value="yes" id="Better_Oral_Health_Toolkit" <?php if($htmldata['effective']['data']['Better_Oral_Health_Toolkit']['value']=="yes") echo "checked";?>>
<label for="Better_Oral_Health_Toolkit">Yes</label>
<input type="radio" name="effective[Better_Oral_Health_Toolkit]" value="Ensure staff are aware of the Better Oral Health Toolkit" id="Better_Oral_Health_Toolkit2" <?php if($htmldata['effective']['data']['Better_Oral_Health_Toolkit']['value']=="Ensure staff are aware of the Better Oral Health Toolkit") echo "checked";?>>
<label for="Better_Oral_Health_Toolkit2">No</label>


<input type="radio" name="effective[Better_Oral_Health_Toolkit]" value="N/A" id="Better_Oral_Health_Toolkit3" <?php if($htmldata['effective']['data']['Better_Oral_Health_Toolkit']['value']=="N/A") echo "checked";?>>
<label for="Better_Oral_Health_Toolkit3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Better_Oral_Health_Toolkit_comment]" class="form-control"><?php echo $htmldata['effective']['data']['Better_Oral_Health_Toolkit']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure staff are aware of the Better Oral Health Toolkit" >

</div>
<hr>
</div>
<!-- question -->



<div class="question">
<div class="numb">94.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are patient medical histories regularly updated  ? </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[patient_medical_histories_regularly_updated_question]" value="Are patient medical histories regularly updated  ?">
<!-- <input type="hidden" name="effective[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="effective[patient_medical_histories_regularly_updated]" value="yes" id="patient_medical_histories_regularly_updated" <?php if($htmldata['effective']['data']['patient_medical_histories_regularly_updated']['value']=="yes") echo "checked";?>>
<label for="patient_medical_histories_regularly_updated">Yes</label>
<input type="radio" name="effective[patient_medical_histories_regularly_updated]" value="Ensure patient medical histories are updated and recorded under patient notes" id="patient_medical_histories_regularly_updated2" <?php if($htmldata['effective']['data']['patient_medical_histories_regularly_updated']['value']=="Ensure patient medical histories are updated and recorded under patient notes") echo "checked";?>>
<label for="patient_medical_histories_regularly_updated2">No</label>




<input type="radio" name="effective[patient_medical_histories_regularly_updated]" value="N/A" id="patient_medical_histories_regularly_updated3" <?php if($htmldata['effective']['data']['patient_medical_histories_regularly_updated']['value']=="N/A") echo "checked";?>>
<label for="patient_medical_histories_regularly_updated3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[patient_medical_histories_regularly_updated_comment]" class="form-control"><?php echo $htmldata['effective']['data']['patient_medical_histories_regularly_updated']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure patient medical histories are updated and recorded under patient notes" >

</div>
<hr>
</div>
<!-- question -->

   





   <div class="question">
<div class="numb">95.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are external clinical waste bin locked and secured to the wall </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[external_clinical_waste_bin_locked_question]" value="Are external clinical waste bin locked and secured to the wall">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[external_clinical_waste_bin_locked]" value="yes" id="external_clinical_waste_bin_locked" <?php if($htmldata['safe']['data']['external_clinical_waste_bin_locked']['value']=="yes") echo "checked";?>>
<label for="external_clinical_waste_bin_locked">Yes</label>
<input type="radio" name="safe[external_clinical_waste_bin_locked]" value="Ensure external clinical waste bins are locked and secured to the wall" id="external_clinical_waste_bin_locked2" <?php if($htmldata['safe']['data']['external_clinical_waste_bin_locked']['value']=="Ensure external clinical waste bins are locked and secured to the wall") echo "checked";?>>
<label for="external_clinical_waste_bin_locked2">No</label>



<input type="radio" name="safe[external_clinical_waste_bin_locked]" value="N/A" id="external_clinical_waste_bin_locked3" <?php if($htmldata['safe']['data']['external_clinical_waste_bin_locked']['value']=="N/A") echo "checked";?>>
<label for="external_clinical_waste_bin_locked3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[external_clinical_waste_bin_locked_comment]" class="form-control"><?php echo $htmldata['safe']['data']['external_clinical_waste_bin_locked']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure external clinical waste bins are locked and secured to the wall" >

</div>
<hr>
</div>
<!-- question -->





<div class="question">
<div class="numb">96.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Have you implemented the standard operating procedure in line with the national guidance on COVID – 19. </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[national_guidance_on_COVID_question]" value="Have you implemented the standard operating procedure in line with the national guidance on COVID – 19.">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[national_guidance_on_COVID]" value="yes" id="national_guidance_on_COVID" <?php if($htmldata['safe']['data']['national_guidance_on_COVID']['value']=="yes") echo "checked";?>>
<label for="national_guidance_on_COVID">Yes</label>
<input type="radio" name="safe[national_guidance_on_COVID]" value="Ensure SOP is present and staff are aware of it" id="national_guidance_on_COVID2" <?php if($htmldata['safe']['data']['national_guidance_on_COVID']['value']=="Ensure SOP is present and staff are aware of it") echo "checked";?>>
<label for="national_guidance_on_COVID2">No</label>



<input type="radio" name="safe[national_guidance_on_COVID]" value="N/A" id="national_guidance_on_COVID3" <?php if($htmldata['safe']['data']['national_guidance_on_COVID']['value']=="N/A") echo "checked";?>>
<label for="national_guidance_on_COVID3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>




</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[national_guidance_on_COVID_comment]" class="form-control"><?php echo $htmldata['safe']['data']['national_guidance_on_COVID']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure SOP is present and staff are aware of it" >

</div>
<hr>
</div>
<!-- question -->



<div class="question">
<div class="numb">97.</div>
<div class="quest">
<div class="quest-inner">
<div class="q">Are you screening and triaging patients attending the premises before appointment ?  </div>
<!-- <span><i class="fa fa-info-circle"></i></span>
 --><div class="inputs mockinspection">
    <input type="hidden" name="form[triaging_patients_attending_the_premises_before_appointment_question]" value="Are you screening and triaging patients attending the premises before appointment ?">
<!-- <input type="hidden" name="safe[practice_hold_regular_team_meetings_id]" value="yes"> -->
<input type="radio" name="safe[triaging_patients_attending_the_premises_before_appointment]" value="yes" id="triaging_patients_attending_the_premises_before_appointment" <?php if($htmldata['safe']['data']['triaging_patients_attending_the_premises_before_appointment']['value']=="yes") echo "checked";?>>
<label for="triaging_patients_attending_the_premises_before_appointment">Yes</label>
<input type="radio" name="safe[triaging_patients_attending_the_premises_before_appointment]" value="Ensure patient are screened and triaged before appointment" id="triaging_patients_attending_the_premises_before_appointment2" <?php if($htmldata['safe']['data']['triaging_patients_attending_the_premises_before_appointment']['value']=="Ensure patient are screened and triaged before appointment") echo "checked";?>>
<label for="triaging_patients_attending_the_premises_before_appointment2">No</label>



<input type="radio" name="safe[triaging_patients_attending_the_premises_before_appointment]" value="N/A" id="triaging_patients_attending_the_premises_before_appointment3" <?php if($htmldata['safe']['data']['triaging_patients_attending_the_premises_before_appointment']['value']=="N/A") echo "checked";?>>
<label for="triaging_patients_attending_the_premises_before_appointment3">N/A</label>

<div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Attach</div>
                </div>





</div>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[triaging_patients_attending_the_premises_before_appointment_comment]" class="form-control"><?php echo $htmldata['safe']['data']['triaging_patients_attending_the_premises_before_appointment']['comment'];?></textarea>
</div>
</div>
</div>
<div class="sh">
<span>comment:</span>
<input type="text" class="" value="Ensure patient are screened and triaged before appointment" >

</div>
<hr>
</div>
<!-- question -->








                </div>
                <!-- quest-box -->
              <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="" onclick="alertbx()" value="Submit">';
  }else{
?>                       
<input class="submit_class" type="submit" value="Submit">
<?php }?>
               
              
               
            </form>
           </div>


             <div id="tabs-2">


                         <?php echo '<table class="table table-hover updateTable">
<thead>
<tr>
 
<th>Date</th>
<th>Compliance Score
</th>
<th>Action</th>
 
   
</tr>    
</thead>
<tbody class="table_data">';
$user =  intval($_SESSION['currentUser']);
$userW =  intval($_SESSION['webUser']['id']);
$sql = "SELECT * FROM `mock_inspection_report` WHERE `pid` = '$user' OR `pid` = '$userW' ORDER BY `mock_inspection_report`.`date_audit` DESC";
$data = $dbF->getRows($sql);
$cnt  = 0;
foreach ($data as $key => $val) {
$cnt++;
$total_score = $val['total_score'];
$id = $val['id'];
 
$date_audit = $val['date_audit'];
echo "<tr>
   <td>" .date('d-M-Y',strtotime($date_audit)). "</td>
   <td>" . $total_score . "</td>
   <td><a class='apink' href='mock_inspection_report?allhtml=".$id."' data-toggle='tooltip' title='View' target='_blank' ><i class='fas fa-eye'></i></a>
    </td>
   ";


echo "</tr>";
}
echo "</tbody></table>";


         ?>





</div>

             <div id="tabs-3">
<!-- tab3_content -->
<?php
$msg  = "";
$chk  = $functions->Mock_Actionplan();
if($chk){
    $msg = "Mock Action Plan Submit Successfully";
}?>

 

        <div class="right_side">

            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="cpd-table">
                <h3 style="float: left;">Action Plan</h3>
                <a href="<?php echo WEB_URL ?>/mock-actionplan" class="submit_class" style="float: right;padding: 0 10px;max-width: max-content;" target="_blank">Show Completed Action Plan</a>
                <form method="post">
                    <?php echo $functions->setFormToken('mock-inspection-plan',false); ?>
                    <div class="cpd-tbl">
                        <table>
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Assign to</th>
                                    <th>Due date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($_SESSION['currentUserType'] == 'Employee'){
                                   /// $user = $_SESSION['webUser']['id'];
                                    $user = $_SESSION['superid'];
                                }
                                else{
                                    $user = $_SESSION['currentUser'];
                                }
                                $sql = "SELECT * FROM `mock_actionplan` WHERE (user='$user' OR assign_to='$user') and status=0";
                                $data = $dbF->getRows($sql);
                                foreach ($data as $key => $value) {
                                    $status='Pending';
                                    if($value['status']==1){
                                    $status='complete';
                                    echo $assign=$value['assign_to'];

                                    }
                                    echo "<tr>
                                            <td>$value[action]</td>
                                            <td>".$functions->UserName($value['assign_to'])."</td>
                                            <td>$value[date]</td>
                                            <td>$status</td>
                                            <td>
                                            <button class='del-btn' type='button' id='$value[id]' onclick='dltMockPlans(this.id)'><i class='far fa-trash-alt'></i></button>
                                            <button class='del-btn' data-toggle='tooltip' title='Change Status' style='cursor: pointer;' id='$value[id]' onclick='changeStatusMockPlan(this.id)'><i class='fas fa-sync-alt'></i></button>
                                            </td>
                                          </tr>";
                                }
                                ?>
                                <tr class="mockplan">
                                    <td><textarea name="action" style="height: 46px;"></textarea></td>
                                    <td>
                                    <?php
                                     echo '    <select name="assignto" class="actions" >
                                                <option disabled>Select Employee</option>
                                                <option selected value="' . $_SESSION['webUser']['id'] . '">
                                             ' . $functions->PracticeName($_SESSION['webUser']['name']) . ' -- Practice
                                                </option>
                                             ' . $functions->allEmployees($_SESSION['webUser']['id'], $_SESSION['currentUser']) . '
                                            </select>
                                    ';?>
                                    </td>
                                    <td><input class="actions" name="date" type="date"></td>
                                    
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- cpd-tbl -->
                    <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<button type="" name="" onclick="alertbx()" class="submit_class">Save</button>';
  }else{
?>                       
<button type='submit' name="submit" class='submit_class'>Save</button>
<?php }?>
                    
                </form>
            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
  







                </div>

        </div>
        <!-- right_side close -->
        
    </div>
    <!-- left_right_side -->
    <!-- left_right_side -->
    <script>
    function dltMockPlans(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
                type: 'post',
                data: {id:id},
                url: 'ajax_call.php?page=dltMockPlan',                
            }).done(function(data) {
                if (data == '1') {
                    $('#'+id).parents('tr').hide('slow');
                }
            });
        }
    }
    </script>

<script>



$('.quest span').on('click', function() {
    $(this).parents('.quest').find('.quest-hover').addClass('not');
    $('.quest .quest-hover:not(.not)').slideUp(300);
    $(this).parents('.quest').find('.quest-hover').removeClass('not');
    $(this).parents('.quest').find('.quest-hover').slideToggle(300);

});
$('input[type=radio]').on('click', function() {
    var chk = this.value;
    if (chk == 'yes') {
       //$('.CurrentlyUsing input[type=radio]:eq(1)').isSelected();
      //  $(this).('input[type=radio]:eq(1)').val('null');
      // $(this).('input[type=radio]:eq(1)').hide();

    } else {
      // $('.CurrentlyUsing input[type=radio]:eq(0)').isSelected();
      // $(this).('input[type=radio]:eq(0)').val('null');
      //  $(this).('input[type=radio]:eq(0)').hide();

    }

    // if (chk == 'yes') {
    //     $(this).parents('.question').find('.sh').css("display", "inline-block");
    //     $(this).parents('.question').find('.sh').css("display", "none");
    //     $(this).parents('.question').find('input[type=radio]').val('');
    // } else {
    //     $(this).parents('.question').find('input[type=text]').attr('required', true);
    //     $(this).parents('.question').find('input[type=text]').attr('required', false);
    // }
});
$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});
</script>

<style type="text/css">
.quest-inner{

    display: flex;
}


.quest-hoverComments{

display: contents;
}

.health_form form .question .quest {max-width:unset;}


.health_form form .question .quest .quest-inner .inputs {
 
    width: 92px;
}
.health_form form .question .quest .quest-inner .inputs {
     
    width: inherit;
}
</style>


<?php include_once('footer.php'); ?>