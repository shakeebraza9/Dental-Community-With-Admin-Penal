<?php 
include_once("global.php"); 
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
     exit();
}

$thankT2 = $dbF->hardWords('Your Initial Compliance Health Check form complete. You can now view your practice compliance health on the dashboard.',false);
?>
<?php include'dashboardheader.php'; ?>
<!-- <script>$(document).ready(function(){mockInspectionForm();});   </script> -->

<div class="index_content mypage health_form">
    <div class="left_right_side">

        <div class="right_side profile">
            <div class="right_side_top">

            </div>
            <!-- right_side_top close -->



            <div>
                <a href="<?= WEB_URL?>/mock_inspection?new" class="submit_class">
                    Add New Mock Inspection
                </a>
            </div>


            <div id="tabs">
                <ul>

                    <li><a active="" href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1"
                            id="ui-id-1">Mock Inspection Form</a></li>

                    <li><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Mock
                            Inspection View</a></li>

                    <li><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Mock
                            Inspection Action Plan</a></li>
                    <!-- <li><a href="https://smartdentalcompliance.com/mock_inspection?new">Mock Inspection NEW</a></li> -->


                </ul>
                <div id="tabs-1">





                    <!-- <h4>Mock Inspection Form</h4> -->

                    <!--     <div class="ihcf-txt">
            </div> -->
                    <form method="post" action="mock_inspection_report" enctype="multipart/form-data">
                        <!-- mock_inspection_report -->


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
                                    <input type="text" name="form[name-of-practice]" placeholder="Name of the practice">
                                </div>
                                <div class="form_1_side_">Name of the practice manager</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-practice-manager]"
                                        placeholder="Name of the practice manager">
                                </div>
                                <div class="form_1_side_">Name of Compliance Champion</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-complianc-champion]" value="Dental Compliance"
                                        placeholder="Name of Compliance Champion">
                                </div>

                                <div class="form_1_side_"> Date Audit Conducted </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" class="datepickerr" name="form[Date-Audit]"
                                        placeholder="Date Audit Conducted">
                                </div>

                                <div class="form_1_side_"> Location of Dental Practice </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[location]" placeholder="Location of Dental Practice">
                                </div>


                                <div class="form_1_side_">Contact Number</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[practice-contact]" placeholder="Contact Number">
                                </div>
                                <div class="form_1_side_">Email</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[email]" placeholder="Email">
                                </div>

                                <?php }elseif (isset($_GET['editId'])) {
                                    $user1 = intval($_SESSION['webUser']['id']);    
                                    @$id =  $_GET['editId'];
                                    $sql  = "SELECT * FROM mock_inspection_report WHERE id = '$id'";
                                    $data = $dbF->getRow($sql);  
                                    // $pid=$data['pid'];
                                    @$htmldata=json_decode($data['all_html'],true); 
                                    if($_SESSION['currentUser']!=$data['pid']){
                                        header('Location: login');
                                    }
                                    ?>
                                <input type="hidden" name="old_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="pid" value="<?php echo $user1; ?>">
                                <div class="form_1_side_">Name of the practice</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-practice]" placeholder="Name of the practice"
                                        value="<?php echo $data['name_of_practice'];?>">
                                </div>
                                <div class="form_1_side_">Name of the practice manager</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-practice-manager]"
                                        placeholder="Name of the practice manager"
                                        value="<?php echo $data['name_of_practice_manager'];?>">
                                </div>
                                <div class="form_1_side_">Name of Compliance Champion</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-complianc-champion]"
                                        placeholder="Name of Compliance Champion"
                                        value="<?php echo $data['name_of_complianc_champion'];?>">
                                </div>

                                <div class="form_1_side_"> Date Audit Conducted </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" class="datepickerr" name="form[Date-Audit]"
                                        placeholder="Date Audit Conducted" value="<?php echo $data['date_audit'];?>">
                                </div>

                                <div class="form_1_side_"> Location of Dental Practice </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[location]" placeholder="Location of Dental Practice"
                                        value="<?php echo $data['location'];?>">
                                </div>


                                <div class="form_1_side_">Contact Number</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[practice-contact]" placeholder="Contact Number"
                                        value="<?php echo $data['practice_contact'];?>">
                                </div>
                                <div class="form_1_side_">Email</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[email]" placeholder="Email"
                                        value="<?php echo $data['email'];?>">
                                </div>

                                <div class="form_1_side_">Detail</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <textarea name="form[Detail]" placeholder="Detail"
                                        value="<?php echo $data['detail'];?>"></textarea>
                                </div>


                                <?php
                                   }
                                   else{

                                   

   $user1 = intval($_SESSION['currentUser']);



?>

                                <input type="hidden" name="pid" value="<?php echo $user1; ?>">



                                <div class="form_1_side_">Name of the practice</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-practice]" value="<?php echo $check[1] ?>"
                                        placeholder="Name of the practice">
                                </div>
                                <div class="form_1_side_">Name of the practice manager</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" value="<?php echo $check[2] ?>"
                                        name="form[name-of-practice-manager]"
                                        placeholder="Name of the practice manager">
                                </div>
                                <div class="form_1_side_">Name of Compliance Champion</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[name-of-complianc-champion]" value="Dental Compliance"
                                        placeholder="Name of Compliance Champion">
                                </div>

                                <div class="form_1_side_"> Date Audit Conducted </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" class="datepickerr" value="<?php echo date('Y-m-d') ?>"
                                        name="form[Date-Audit]" placeholder="Date Audit Conducted">
                                </div>

                                <div class="form_1_side_"> Location of Dental Practice </div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[location]" value="<?php echo $check[4] ?>"
                                        placeholder="Location of Dental Practice">
                                </div>


                                <div class="form_1_side_">Contact Number</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" value="<?php echo $check[3] ?>" name="form[practice-contact]"
                                        placeholder="Contact Number">
                                </div>
                                <div class="form_1_side_">Email</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <input type="text" name="form[email]" value="<?php echo $check[0] ?>"
                                        placeholder="Email">
                                </div>

                                <?php
                                   } if(!isset($_GET['editId'])){?>

                                <div class="form_1_side_">Detail</div>
                                <div class="form_2_side_ hvr-shadow-radial">
                                    <textarea name="form[Detail]" placeholder="Detail"></textarea>
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

                                            <input type="hidden" name="form[cross_infection_audit_question]"
                                                value="Have you carried out a cross infection audit in the last 6 months">

                                            <div class="radio_btnbox">
                                                <div class="form-group form-radio mb-0">
                                                    <label for="cross_infection_audit" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[cross_infection_audit]" value="yes"
                                                            id="cross_infection_audit" <?php
                                                            if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="yes"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">Yes</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="cross_infection_audit2" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[cross_infection_audit]"
                                                            value="your cross infection audit is missing"
                                                            id="cross_infection_audit2" <?php
                                                            if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="your cross infection audit is missing"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">No</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="cross_infection_audit3" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[cross_infection_audit]" value="N/A"
                                                            id="cross_infection_audit3" <?php
                                                            if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="N/A"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">N/A</div>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-0 file_upld" style="display:flex; align-items:center;">
                                                    <input type="file" id="upload" hidden=""
                                                        name="cross_infection_audit_file">
                                                    <label for="upload" class="upload_btn" style="margin-top:0;">Choose
                                                        file</label>
                                                    <span id="file-chosen">No file chosen</span>
                                                </div>
                                            </div>


                                            <!--<input type="radio" name="safe[cross_infection_audit]" value="yes" id="cross_infection_audit" <?php // if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="yes") echo "checked";?>>-->
                                            <!--<label for="cross_infection_audit">Yes</label>-->
                                            <!--<input type="radio" name="safe[cross_infection_audit]" value="your cross infection audit is missing" id="cross_infection_audit2" <?php // if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="your cross infection audit is missing") echo "checked";?>>-->
                                            <!--<label for="cross_infection_audit2">No</label>-->


                                            <!--<input type="radio" name="safe[cross_infection_audit]" value="N/A" id="cross_infection_audit3" <?php // if(@$htmldata['safe']['data']['cross_infection_audit']['value']=="N/A") echo "checked";?>>-->
                                            <!--<label for="cross_infection_audit3">N/A</label>-->
                                            <!--<div class="file">-->
                                            <!--                    <input type="file" name="document" id="file-upload" placeholder="File">-->
                                            <!--                    <i class="fas fa-paperclip"></i>-->
                                            <!--                    <div>Attach</div>-->
                                            <!--                </div>-->

                                        </div>
                                        <!-- <div class="file">
<input type="file" name="cross_infection_audit_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->


                                        <!--<div class="quest-hoverComments">Type Comment:-->
                                        <!--<textarea name="form[cross_infection_audit_comment]" class="form-control"><?php // echo @$htmldata['safe']['data']['cross_infection_audit']['comment'];?></textarea>-->
                                        <!--</div>-->
                                    </div>



                                    <div class="form-group mb-0" style="width:100%; position:relative;">
                                        <label for="description">Type Comment</label>
                                        <textarea name="form[cross_infection_audit_comment]" id="description"
                                            class="form-control" placeholder="Description" cols="30" rows="10"
                                            spellcheck="false"
                                            style="height: 150px;max-height: 150px;"><?php echo @$htmldata['safe']['data']['cross_infection_audit']['comment'];?></textarea>
                                    </div>

                                </div>
                                <div class="sh">
                                    <span>comment</span>
                                    <input type="hidden" class="" value="your cross infection audit is missing">

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
                                            <input type="hidden" name="form[radiograph_audits_question]"
                                                value="Have you carried out radiograph audits in the last 6 months">

                                            <div class="radio_btnbox">
                                                <div class="form-group form-radio mb-0">
                                                    <label for="radiograph_audits" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[radiograph_audits]" value="yes"
                                                            id="radiograph_audits" <?php
                                                            if(@$htmldata['safe']['data']['radiograph_audits']['value']=="yes"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">Yes</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="radiograph_audits2" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[radiograph_audits]"
                                                            value="your radiograph audit is missing"
                                                            id="radiograph_audits2" <?php
                                                            if(@$htmldata['safe']['data']['radiograph_audits']['value']=="your radiograph audit is missing"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">No</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="radiograph_audits3" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[radiograph_audits]" value="N/A"
                                                            id="radiograph_audits3" <?php
                                                            if(@$htmldata['safe']['data']['radiograph_audits']['value']=="N/A"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">N/A</div>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-0 file_upld" style="display:flex; align-items:center;">
                                                    <input type="file" id="upload" name="document" hidden="">
                                                    <label for="upload" class="upload_btn" style="margin-top:0;">Choose
                                                        file</label>
                                                    <span id="file-chosen">No file chosen</span>
                                                </div>
                                            </div>



                                            <!-- <input type="hidden" name="safe[radiograph_audits_id]" value="yes"> -->
                                            <!--<input type="radio" name="safe[radiograph_audits]" value="yes" id="radiograph_audits" <?php //if(@$htmldata['safe']['data']['radiograph_audits']['value']=="yes") echo "checked";?>>-->
                                            <!--<label for="radiograph_audits">Yes</label>-->
                                            <!--<input type="radio" name="safe[radiograph_audits]" value="your radiograph audit is missing" id="radiograph_audits2" <?php //if(@$htmldata['safe']['data']['radiograph_audits']['value']=="your radiograph audit is missing") echo "checked";?>>-->
                                            <!--<label for="radiograph_audits2">No</label>-->
                                            <!--<input type="radio" name="safe[radiograph_audits]" value="N/A" id="radiograph_audits3" <?php //if(@$htmldata['safe']['data']['radiograph_audits']['value']=="N/A") echo "checked";?>>-->
                                            <!--<label for="radiograph_audits3">N/A</label>-->

                                            <!--<div class="file">-->
                                            <!--        <input type="file" name="document" id="file-upload" placeholder="File">-->
                                            <!--        <i class="fas fa-paperclip"></i>-->
                                            <!--        <div>Attach</div>-->
                                            <!--</div>-->






                                        </div>


                                        <!-- <div class="file">
<input type="file" name="radiograph_audits_file">
<i class="fas fa-paperclip"></i>
<div>Upload</div>
</div> -->

                                        <!--<div class="quest-hoverComments">Type Comment:-->
                                        <!--<textarea name="form[radiograph_audits_comment]" class="form-control"><?php //echo @$htmldata['safe']['data']['radiograph_audits']['comment'];?></textarea>-->
                                        <!--</div>-->

                                        <div class="form-group mb-0" style="width:100%; position:relative;">
                                            <label for="description">Type Comment</label>
                                            <textarea name="form[radiograph_audits_comment]" id="description"
                                                class="form-control" placeholder="Description" cols="30" rows="10"
                                                spellcheck="false"
                                                style="height: 150px;max-height: 150px;"><?php echo @$htmldata['safe']['data']['radiograph_audits']['comment'];?></textarea>
                                        </div>


                                    </div>

                                </div>
                                <div class="sh">
                                    <span>comment:</span>
                                    <input type="text" class="" value="your radiograph audit is missing">

                                </div>

                                <!-- <hr> -->
                            </div>
                            <!-- question -->

                            <div class="question">

                                <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right; z-index:9;">';
  }else{
?>
                                <input class="submit_class" type="submit" value="Save" name="save"
                                    style="margin-right: 20px; float: right;z-index:9">
                                <?php }?>
                                <hr>
                            </div>
                            <!-- question -->

                            <!--  <input class="submit_class" type="submit" value="Save"> -->


                        </div>
                        <!-- quest-box -->

                        <div class="quest-box">

                            <div class="question">
                                <div class="numb">3.</div>
                                <div class="quest">
                                    <div class="quest-inner">
                                        <div class="q">
                                            Do you have an up to date fire risk assessment of the practice


                                        </div>
                                        <div class="inputs mockinspection">
                                            <input type="hidden" name="form[up_to_date_fire_risk_assessment_question]"
                                                value="Do you have an up to date fire risk assessment of the practice">

                                            <div class="radio_btnbox">
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_fire_risk_assessment" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_fire_risk_assessment]" value="yes"
                                                            id="up_to_date_fire_risk_assessment" <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="yes"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">Yes</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_fire_risk_assessment2" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_fire_risk_assessment]"
                                                            value="your up to date fire risk assessment missing"
                                                            id="up_to_date_fire_risk_assessment2" <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="your up to date fire risk assessment missing"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">No</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_fire_risk_assessment3" class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_fire_risk_assessment]" value="N/A"
                                                            id="up_to_date_fire_risk_assessment3" <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="N/A"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">N/A</div>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-0 file_upld" style="display:flex; align-items:center;">
                                                    <input type="file" id="upload" name="document" hidden="">
                                                    <label for="upload" class="upload_btn" style="margin-top:0;">Choose
                                                        file</label>
                                                    <span id="file-chosen">No file chosen</span>
                                                </div>
                                            </div>





                                            <!-- <input type="hidden" name="form[general_practice_risk_assessment_id]" value="54"> -->
                                            <!--<input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="yes" id="up_to_date_fire_risk_assessment" <?php //if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="yes") echo "checked";?>>-->
                                            <!--<label for="up_to_date_fire_risk_assessment">Yes</label>-->
                                            <!--<input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="your up to date fire risk assessment missing" id="up_to_date_fire_risk_assessment" <?php //if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="your up to date fire risk assessment missing") echo "checked";?>>-->
                                            <!--<label for="up_to_date_fire_risk_assessment">No</label>-->
                                            <!--<input type="radio" name="safe[up_to_date_fire_risk_assessment]" value="N/A" id="up_to_date_fire_risk_assessment3" <?php //if(@$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['value']=="N/A") echo "checked";?>>-->
                                            <!--<label for="up_to_date_fire_risk_assessment3">N/A</label>-->
                                            <!--<div class="file">-->
                                            <!--    <input type="file" name="document" id="file-upload" placeholder="File">-->
                                            <!--    <i class="fas fa-paperclip"></i>-->
                                            <!--    <div>Attach</div>-->
                                            <!--</div>-->




                                        </div>
                                        <!--<div class="quest-hoverComments">Type Comment:-->
                                        <!--    <textarea name="form[up_to_date_fire_risk_assessment_comment]" class="form-control"><?php //echo @$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['comment'];?></textarea>-->
                                        <!--</div>-->

                                        <div class="form-group mb-0" style="width:100%; position:relative;">
                                            <label for="description">Type Comment</label>
                                            <textarea name="form[up_to_date_fire_risk_assessment_comment]"
                                                id="description" class="form-control" placeholder="Description"
                                                cols="30" rows="10" spellcheck="false"
                                                style="height: 150px;max-height: 150px;"><?php echo @$htmldata['safe']['data']['up_to_date_fire_risk_assessment']['comment'];?></textarea>
                                        </div>


                                    </div>
                                </div>
                                <div class="sh">
                                    <span>comment:</span>
                                    <input type="text" class="" value="your up to date fire risk assessment missing">

                                </div>

                                <hr>
                            </div>
                            <!-- question -->

                            <div class="question">
                                <div class="numb">4.</div>
                                <div class="quest">
                                    <div class="quest-inner">
                                        <div class="q">
                                            Do you have an up to date legionella risk assessment of the practice

                                        </div>
                                        <!--                                 <span><i class="fa fa-info-circle"></i></span> -->
                                        <div class="inputs mockinspection">
                                            <input type="hidden"
                                                name="form[up_to_date_legionella_risk_assessment_question]"
                                                value=" Do you have an up to date legionella risk assessment of the practice">

                                            <div class="radio_btnbox">
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_legionella_risk_assessment"
                                                        class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_legionella_risk_assessment]"
                                                            value="yes" id="up_to_date_legionella_risk_assessment" <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="yes"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">Yes</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_legionella_risk_assessment2"
                                                        class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_legionella_risk_assessment]"
                                                            value="your up to date legionella risk assessment missing"
                                                            id="up_to_date_legionella_risk_assessment2" <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="your up to date legionella risk assessment missing"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">No</div>
                                                    </label>
                                                </div>
                                                <div class="form-group form-radio mb-0">
                                                    <label for="up_to_date_legionella_risk_assessment3"
                                                        class="rad-label">
                                                        <input type="radio" class="rad-input"
                                                            name="safe[up_to_date_legionella_risk_assessment]"
                                                            value="N/A" id="up_to_date_legionella_risk_assessment3"
                                                            <?php
                                                            if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="N/A"
                                                            ) echo "checked" ;?>>
                                                        <div class="rad-design"></div>
                                                        <div class="rad-text">N/A</div>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-0 file_upld" style="display:flex; align-items:center;">
                                                    <input type="file" id="upload" name="document" hidden="">
                                                    <label for="upload" class="upload_btn" style="margin-top:0;">Choose
                                                        file</label>
                                                    <span id="file-chosen">No file chosen</span>
                                                </div>
                                            </div>






                                            <!-- <input type="hidden" name="form[fire_risk_assessment_id]" value="yes"> -->
                                            <!--<input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="yes" id="up_to_date_legionella_risk_assessment" <?php //if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="yes") echo "checked";?>>-->
                                            <!--<label for="up_to_date_legionella_risk_assessment">Yes</label>-->
                                            <!--<input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="your up to date legionella risk assessment missing" id="up_to_date_legionella_risk_assessment2" <?php //if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="your up to date legionella risk assessment missing") echo "checked";?>>-->
                                            <!--<label for="up_to_date_legionella_risk_assessment2">No</label>-->
                                            <!--<input type="radio" name="safe[up_to_date_legionella_risk_assessment]" value="N/A" id="up_to_date_legionella_risk_assessment3" <?php //if(@$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['value']=="N/A") echo "checked";?>>-->
                                            <!--<label for="up_to_date_legionella_risk_assessment3">N/A</label>-->

                                            <!--<div class="file">-->
                                            <!--                    <input type="file" name="document" id="file-upload" placeholder="File">-->
                                            <!--                    <i class="fas fa-paperclip"></i>-->
                                            <!--                    <div>Attach</div>-->
                                            <!--                </div>-->





                                        </div>



                                        <!--<div class="quest-hoverComments">Type Comment:<br><br>-->
                                        <!--<textarea name="form[up_to_date_legionella_risk_assessment_comment]" class="form-control"><?php //echo @$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['comment'];?></textarea>-->
                                        <!--</div>-->

                                        <div class="form-group mb-0" style="width:100%; position:relative;">
                                            <label for="description">Type Comment</label>
                                            <textarea name="form[up_to_date_legionella_risk_assessment_comment]"
                                                id="description" class="form-control" placeholder="Description"
                                                cols="30" rows="10" spellcheck="false"
                                                style="height: 150px;max-height: 150px;"><?php echo @$htmldata['safe']['data']['up_to_date_legionella_risk_assessment']['comment'];?></textarea>
                                        </div>

                                    </div>
                                </div>

                                <div class="sh">
                                    <span>comment:</span>
                                    <input type="text" class=""
                                        value="your up to date legionella risk assessment missing">

                                </div>

                                <!-- <hr> -->
                            </div>
                            <!-- question -->
                            <div class="question">

                                <?php
if($_SESSION['userType']=='Trial')
  {
     echo'<input class="submit_class" type="button" onclick="alertbx()" value="Save" name ="" style="margin-right: 20px; float: right;">';
  }else{
?>
                                <input class="submit_class" type="submit" value="Save" name="save"
                                    style="margin-right: 20px; float: right;">
                                <?php }?>
                                <hr>
                            </div>


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
            </div>
            <div id="tabs-2">


                <?php 
echo '<table class="table table-hover updateTable">
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
                        <!--<h3 style="float: left;">Action Plan</h3>-->
                        <a href="<?php echo WEB_URL ?>/mock-actionplan" class="submit_class"
                            style="float: right;padding: 0 10px;max-width: max-content;" target="_blank">Show Completed
                            Action Plan</a>
                        <form method="post">
                            <?php echo $functions->setFormToken('mock-inspection-plan',false); ?>
                            <div class="cpd-tbl">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Action Name</th>
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

                                            <td></td><td></td>
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
        function dltMockPlans(id) {
            var result = confirm("Are you sure you want to delete?");
            if (result) {
                $.ajax({
                    type: 'post',
                    data: { id: id },
                    url: 'ajax_call.php?page=dltMockPlan',
                }).done(function (data) {
                    if (data == '1') {
                        $('#' + id).parents('tr').hide('slow');
                    }
                });
            }
        }
    </script>

    <script>



        $('.quest span').on('click', function () {
            $(this).parents('.quest').find('.quest-hover').addClass('not');
            $('.quest .quest-hover:not(.not)').slideUp(300);
            $(this).parents('.quest').find('.quest-hover').removeClass('not');
            $(this).parents('.quest').find('.quest-hover').slideToggle(300);

        });
        $('input[type=radio]').on('click', function () {
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
        $(document).on('change', '.file input', function () {
            filename = this.files[0].name;
            $(this).parent('div').find('div').text(filename);
        });
    </script>

    <style type="text/css">
        .quest-inner {

            display: flex;
        }


        .quest-hoverComments {

            display: contents;
        }

        .health_form form .question .quest {
            max-width: unset;
        }


        .health_form form .question .quest .quest-inner .inputs {

            width: 92px;
        }

        .health_form form .question .quest .quest-inner .inputs {

            width: inherit;
        }
    </style>


    <?php include_once('dashboardfooter.php'); ?>