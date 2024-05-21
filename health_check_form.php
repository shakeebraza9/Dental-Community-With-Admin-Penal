<?php 
include_once("global.php"); 

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
     exit();
}
$uid = intval($_SESSION['currentUser']);
$chk = $functions->health_check($uid);
if(!$chk){
    if(@$_SESSION['superUser']['health_form'] == '0'){
        header('Location: dashboard');
        exit();
    }
}

 // include_once('header.php'); 


$thankT2 = $dbF->hardWords('Your Initial Compliance Health Check form complete. You can now view your practice compliance health on the dashboard.',false);
?>
<?php include'dashboardheader.php'; ?>
<div class="index_content mypage health_form">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side">
            <div class="right_side_top">
                            </div>
            <!-- right_side_top close -->
            <h4>Initial Compliance Health Check Form</h4>
            <?php

$pMmsg = '';
$echo = '<div class="">';

$contactAllow = true;

if(isset($_POST) && !empty($_POST) ){ ?>
            <?php

if($functions->getFormToken('contactFormSubmit')){

$img="";

$msg='<br><br><hr><br><br><table border="1">';

$msg .= '<tr>
<td>User</td>
<td>Event Name</td>
<td>Date</td>
<td>File</a></td>
</tr>';

$userid = intval($_SESSION['currentUser']);
 
foreach($_POST['form'] as $key=>$val){
$docname = '#';

if($_POST['form'][$key] == 'yes'){
    $id   = $_POST['form'][$key.'_id'];
    @$date = $_POST['form'][$key.'_date'];
    
     $date = Date('Y-m-d',strtotime($date));
    if(empty($date) || $date < "2000-01-01"){
        $date = date('Y-m-d');
    }
    if(isset($_FILES[$key]) && ($_FILES[$key]["size"])>0) {
        $filename = $functions->uploadSingleFile($_FILES[$key],'files','');

        if($filename==false) {
$docname = '#';
}else{
$docname = WEB_URL."/images/$filename";  
}



    
    }
    else{               
        $docname = '#';
    }

    if(empty($date) || $date < "2000-01-01"){
        $date = date('Y-m-d');
    }
    intval($id);
    $Rdate = $functions->getDate($id);    
    $DueDate = $functions->nextDueDate($Rdate,$date);
    $sql = "INSERT INTO `userevent` (`title_id`,`user`,`file`,`approved`,`desc`,`due_date`,`dateTime`) VALUES (?,?,?,?,?,?,?)";
    $dbF->setRow($sql,array($id, $userid,$docname,"1"," ",$date,$date));
    $title = $functions->eventTitle($id);
    $functions->setlog("Health Check Form Event Complete",$functions->userName($userid)." : ".$userid,"",$id." : ".$title." : ".$date);

        if($DueDate != 'No Recurrence'){
            if($DueDate == 'Once' || $DueDate == 'Once Check'){
                        $sql = "SELECT * FROM `eventmanagement` WHERE `id`=(SELECT `recurrence` FROM `eventmanagement` WHERE `id`= ? )";
                        $data = $dbF->getRow($sql,array($id));
                        $id = $data['id'];
                        intval($id);
                        $DueDate = Date('Y-m-d',strtotime($date.'+'.$data['recurring_duration']));
            }
                $sql =   "INSERT INTO `userevent`(`user`,`title_id`,`due_date`) VALUES (?,?,?)";
                $dbF->setRow($sql,array($userid,$id,$DueDate));
                $functions->setlog("Health Check Form Event Recurrence Create",$functions->userName($userid)." : ".$userid,"",$id." : ".$title);
        }

$msg.= '
<tr>
<td>'.$userid.'</td>
<td>'.ucwords(str_replace("_"," ",$key)).'</td>
<td>'.Date('Y-m-d',strtotime($date)).'</td>
<td><a href="'.$docname.'" download>Download File</a></td>
</tr>
';


$echo .= '<div class="main-row">
<div class="main-row-top">
<h5>'.$_POST['form'][$key.'_q'].'</h5></br>
<h5>Selected option:YES ('.$date.')</h5></br>
'.$_POST['form'][$key.'_comment'].'
</div>     
</div>';





}
    else if($_POST['form'][$key] == 'no'){
        $user  = $_SESSION['currentUser'];
        $id    = $_POST['form'][$key.'_id'];
        $title = $functions->eventTitle($id);
        @$date = $_POST['form'][$key.'_date'];
        if(empty($date) || $date < "2000-01-01"){
            $date = date('Y-m-d');
        }
        $i=7;
            while($i){
            $due_date = Date('Y-m-d',strtotime('+'.$i.'day'));
            if($functions->isWeekend($due_date)){
                $i++;
                continue;
            }
           
           
            $sql = "SELECT COUNT(*) FROM `eventmanagement` WHERE `assignto` IN ('all','$user') AND `id` NOT IN(SELECT `recurrence` FROM `eventmanagement`) AND (`due_date` = ? OR `dateTime` = ?) ";
            $data = $dbF->getRow($sql,array($due_date,$due_date));
            $sql2 = "SELECT COUNT(*) FROM `userevent` WHERE `user`='$user' AND `approved`='-1' AND (`due_date` = ? OR `dateTime` = ?) ";
            $data2 = $dbF->getRow($sql2,array($due_date,$due_date));
            $check = $data[0]+$data2[0];
                if($check < 2){
                    $sql = "INSERT INTO `userevent`(`user`,`title_id`,`dateTime`,`due_date`) VALUES (?,?,?,?)";
                    $dbF->setRow($sql,array($user,$id,$due_date,$date));
                    $functions->setlog("Health Check Form Event Denied",$functions->userName($userid)." : ".$userid,"",$title);
                    break;
                }
                $i++;
            }


$echo .= '<div class="main-row">
<div class="main-row-top">
<h5>'.$_POST['form'][$key.'_q'].'</h5></br>
<h5>Selected option:NO</h5></br>
'.$_POST['form'][$key.'_comment'].'
</div>     
</div>';



    }

    $msg.='<tr><td>'.ucwords(str_replace("_"," ",$key)).'</td>
<td>Comment: '.@$_POST['form'][$key.'_comment'].'</td></tr>';


}

$msg.='<tr><td>Date Time</td><td colspan="2">'.date("D j M Y g:i a").'</td></tr>';

$msg.='</table>';

$to = $functions->ibms_setting('Email');
// $to = 'syeddak123@gmail.com';

$functions->send_mail($to,'Initial Compliance Health Check Form',$msg);


$msg1 ='';
$dirr = __DIR__."/healthEmail.txt";
$fh = fopen($dirr,'r');
while ($line = fgets($fh)) {
$msg1 .=$line;
}



$dirr = __DIR__."/healthEmail.txt";
$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1.$msg);
fclose($myfile);




$functions->push_notification('Initial Compliance Health Form','Hi five. You’ve done it. Thanks for submitting the initial compliance health check form.',$functions->getUserPlayerId($userid));

$nameUser =   $_SESSION['webUser']['name'];

$thankT = $dbF->hardWords('Thank you for submitting the Initial Compliance Health Check form.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','healthEmail',$nameUser)){

$pMmsg = "$thankT";

} else {

$errorT = $dbF->hardWords('Thank you for submitting the Initial Compliance Health Check form.',false);
// $errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);

$pMmsg = "$errorT";

}

$contactAllow = false;

}else{

$contactAllow = true;

}

if($pMmsg!=''){

echo "<div class='alert alert-info'>$pMmsg <a href='./health_check_form'>Click Here to Complete Health Check Form</a> </div>";

}

}
$echo .= '</div>';

echo $echo;
//if($contactAllow){
if(1){
$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";if(isset($_POST['contactFormSubmitToken'])){
}else{

?>
            <div class="ihcf-txt">
                Please fill the initial compliance health form. Input dates where required, and attach the supporting document. You do not attach the document in order to submit the form. You can save each section and come back to it later. All documents uploaded will show up on My Uploads.
            </div>
            <form method="post" enctype="multipart/form-data">
                <?php $functions->setFormToken('contactFormSubmit');
                    $check = $functions->checkHealthForm($_SESSION['currentUser']);
                    $fchk1 = "false"; ?>
                <?php if(!in_array(39,$check) || !in_array(51,$check) || !in_array(41,$check) || !in_array(42,$check) || !in_array(38,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                   <h3>Audits</h3>
                            <?php if(!in_array(39,$check)){ ?>
                           <div class="question">
                        <div class="numb">1.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                     Do you have a completed disability access audit?
                                </div>
                            <div class="form-group-radio">
                                <div class="inputs">
                                    <input type="hidden" name="form[disability_access_audit_id]" value="39">
                                    <input type="hidden" name="form[disability_access_audit_q]" value="Do you have a completed disability access audit?">
                                    <div class="inputs">
                                        <span><i class="fa fa-info-circle"></i></span>
                                            <div class="inputs">
                                                <label for="disability_access_audit" class="rad-label">
                                                <input type="radio" class="rad-input" name="form[disability_access_audit]" value="yes" id="disability_access_audit">
                                                    <div class="rad-design"></div>
                                                    <div class="rad-text">Yes</div>
                                                </label>
                                            </div>
                                    
                                    <div class="form-group form-radio mb-0">
                                        <label for="disability_access_audit2" class="rad-label">
                                            <input type="radio" class="rad-input" name="form[disability_access_audit]" value="no" id="disability_access_audit2">
                                            <div class="rad-design"></div>
                                            <div class="rad-text">No</div>
                                        </label>
                                    </div> 
                                    </div> 
                                </div>
                                <div class="sh">
                                    <span>Last Completion Date:</span>
                                    <input type="text" class="datepicker" name="form[disability_access_audit_date]">
                                    <div class="file">
                                        <input type="file" name="disability_access_audit">
                                        <i class="fas fa-paperclip"></i>
                                        <div>Upload</div>
                                    </div>
                                </div>
                            </div>
                            <div class="quest-hoverComments">Type Comment:<br><br>
                            <textarea name="form[disability_access_audit_comment]" class="form-control"></textarea>
                            </div>
                            
                            </div>
                            </div>
                            </div>
                <!-- question -->            
                    <?php } 
if(!in_array(51,$check)){ ?>
<div class="question">
                  <div class="numb">2.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                     Do you have a completed cross infection audit?
                                </div>
                            <div class="form-group-radio">
                                <div class="inputs">
                                     <input type="hidden" name="form[cross_infection_audit_id]" value="51">
                                    <input type="hidden" name="form[cross_infection_audit_q]"value="Do you have a completed cross infection audit?">
                                    <div class="inputs">
                                        <span><i class="fa fa-info-circle"></i></span>
                                            <div class="form-group form-radio mb-0">
                                                <label for="cross_infection_audit" class="rad-label">
                                                <input type="radio" class="rad-input" name="form[cross_infection_audit_id]" value="yes" id="cross_infection_audit">
                                                    <div class="rad-design"></div>
                                                    <div class="rad-text">Yes</div>
                                                </label>
                                            </div>
                                    
                                    <div class="form-group form-radio mb-0">
                                        <label for="cross_infection_audit2" class="rad-label">
                                            <input type="radio" class="rad-input" name="form[cross_infection_audit_id]" value="no" id="cross_infection_audit2">
                                            <div class="rad-design"></div>
                                            <div class="rad-text">No</div>
                                        </label>
                                    </div> 
                                    </div> 
                                </div>
                                <div class="sh">
                                    <span>Last Completion Date:</span>
                                    <input type="text" class="datepicker" name="form[cross_infection_audit_date]">
                                    <div class="file">
                                        <input type="file" name="cross_infection_audit">
                                        <i class="fas fa-paperclip"></i>
                                        <div>Upload</div>
                                    </div>
                                </div>
                            </div>
                            <div class="quest-hoverComments">Type Comment:<br><br>
                            <textarea name="form[cross_infection_audit_comment]" class="form-control"></textarea>
                            </div>
                            
                            </div>
                            </div>
                            </div>
                         </div>
                                

                <!-- question -->
                    <?php } 
if(!in_array(41,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">3.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a completed radiography audit?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[radiography_audit_id]" value="41">
                                    <input type="hidden" name="form[radiography_audit_q]" value="Do you have a completed radiography audit?">
                                    <input type="radio" name="form[radiography_audit]" value="yes" id="radiography_audit">
                                    <label for="radiography_audit">Yes</label>
                                    <input type="radio" name="form[radiography_audit]" value="no" id="radiography_audit2">
                                    <label for="radiography_audit2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[radiography_audit_comment]" class="form-control"></textarea>
</div>



                            </div>
                            <div class="quest-hover">CQC Mythbusters<br>
                                X-rays: Current regulations for using ionising radiation for medical and dental purposes (both <a href="http://www.sor.org/learning/document-library/ionising-radiations-regulations-1999-irr99-guidance-booklet-0" target="_blank">IRR99</a> and <a href="http://www.sor.org/learning/document-library/irmer-2000-and-irme-amendment-regulations-2006-2011" target="_blank">IR(ME)R2000</a>) place a legal responsibility to establish and maintain quality assurance programmes for dental radiology. The consistent quality of radiographs must be assured through audit. There is an example audit under 'selection criteria for dental radiography 9.2.1' on
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[radiography_audit_date]">
                            <div class="file">
                                <input type="file" name="radiography_audit">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } 
if(!in_array(42,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">4.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a completed record keeping audit?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[record_keeping_audit_id]" value="42">
                                    <input type="hidden" name="form[record_keeping_audit_q]" value="Do you have a completed record keeping audit?">
                                    <input type="radio" name="form[record_keeping_audit]" value="yes" id="record_keeping_audit">
                                    <label for="record_keeping_audit">Yes</label>
                                    <input type="radio" name="form[record_keeping_audit]" value="no" id="record_keeping_audit2">
                                    <label for="record_keeping_audit2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[record_keeping_audit_comment]" class="form-control"></textarea>
</div>



                            </div>
                            <div class="quest-hover">CQC Mythbusters<br>
                                One of the fundamental criteria used to manage risk in a dental practice is keeping good quality clinical records. During inspection we may ask to see parts of a dental care record to corroborate evidence of what staff and patients tell us about the quality of care. In particular, the evidence we gather from the dental care record can help answer these Key Lines of Enquiry (KLOE) which will inform the judgement against the safe and effective key questions:<br>
                                What systems are in place to keep people safe and safeguard them from abuse? (S3)<br>
                                Are people’s needs assessed and care and treatment delivered in line with current legislation, standards and evidence based guidance? (E1)<br>
                                Is people’s consent to care and treatment always sought in line with legislation and guidance? (E4)
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[record_keeping_audit_date]">
                            <div class="file">
                                <input type="file" name="record_keeping_audit">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } 
if(!in_array(38,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">5.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a waste acceptance audit?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[waste_acceptance_audit_id]" value="38">
                                    <input type="hidden" name="form[waste_acceptance_audit_q]" value="Do you have a waste acceptance audit?">
                                    <input type="radio" name="form[waste_acceptance_audit]" value="yes" id="waste_acceptance_audit">
                                    <label for="waste_acceptance_audit">Yes</label>
                                    <input type="radio" name="form[waste_acceptance_audit]" value="no" id="waste_acceptance_audit2">
                                    <label for="waste_acceptance_audit2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[waste_acceptance_audit_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[waste_acceptance_audit_date]">
                            <div class="file">
                                <input type="file" name="waste_acceptance_audit">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } ?>
                     <!--<input type="radio" name="form[fire_risk_assessment]" value="yes" id="fire_risk_assessment">-->
                                 <!--       <label for="fire_risk_assessment">Yes</label>-->
                                 <!--       <input type="radio" name="form[fire_risk_assessment]" value="no" id="fire_risk_assessment2">-->
                                 <!--       <label for="fire_risk_assessment2">No</label>-->


<!--                                <br>-->
<!--<br>-->
<!--<div class="quest-hoverComments">Type Comment:<br><br>-->
<!--<textarea name="form[cross_infection_audit_comment]" class="form-control"></textarea>-->
<!--</div>-->



<!--                            </div>-->
                        <!--    <div class="quest-hover">We will also check these documents:<br>-->
                        <!--        fire risk assessment<br>-->
                        <!--        plans for emergency evacuation<br>-->
                        <!--        details of fire training for staff<br>-->
                        <!--        building control certificate<br>-->
                        <!--        utilities and equipment installation certificates, for example, gas, electric, lifts.</div>-->
                        <!--</div>-->
                        <!--<div class="sh">-->
                        <!--    <span>Last Completion Date:</span>-->
                        <!--    <input type="text" class="datepicker" name="form[fire_risk_assessment_date]">-->
                        <!--    <div class="file">-->
                        <!--        <input type="file" name="fire_risk_assessment">-->
                        <!--        <i class="fas fa-paperclip"></i>-->
                        <!--        <div>Upload</div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        
                        
                    <!--<input class="submit_class" type="submit" value="Save">-->
                    <!--</div>-->
                <!-- quest-box -->
                <?php } 
if(!in_array(54,$check) || !in_array(55,$check) || !in_array(56,$check) || !in_array(64,$check) || !in_array(59,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">


                    <h3>Risk Assessment</h3>
                    <?php if(!in_array(54,$check)){ ?>
                    <div class="question">
                        <div class="numb">3.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a general practice risk assessment?
                                </div>
                            <div class="form-group-radio">
                                <div class="radio_btnbox">
                                    <input type="hidden" name="form[general_practice_risk_assessment_id]" value="54">
                                    <input type="hidden" name="form[general_practice_risk_assessment_q]" value="Do you have a general practice risk assessment?">
                                    <div class="radio_btnbox">
                                        <span><i class="fa fa-info-circle"></i></span>
                                            <div class="form-group form-radio mb-0">
                                                <label for="general_practice_risk_assessment" class="rad-label">
                                                <input type="radio" class="rad-input" name="form[general_practice_risk_assessment]" value="yes" id="general_practice_risk_assessment">
                                                    <div class="rad-design"></div>
                                                    <div class="rad-text">Yes</div>
                                                </label>
                                            </div>
                                    
                                    <div class="form-group form-radio mb-0">
                                        <label for="general_practice_risk_assessment2" class="rad-label">
                                            <input type="radio" class="rad-input" name="form[general_practice_risk_assessment]" value="no" id="general_practice_risk_assessment2">
                                            <div class="rad-design"></div>
                                            <div class="rad-text">No</div>
                                        </label>
                                    </div> 
                                    </div> 
                                </div>
                                <div class="sh">
                                    <span>Last Completion Date:</span>
                                    <input type="text" class="datepicker" name="form[fire_risk_assessment_date]">
                                    <div class="file">
                                        <input type="file" name="fire_risk_assessment">
                                        <i class="fas fa-paperclip"></i>
                                        <div>Upload</div>
                                    </div>
                                </div>
                            </div>
                            <div class="quest-hoverComments">Type Comment:<br><br>
                            <textarea name="form[general_practice_risk_assessment_comment]" class="form-control"></textarea>
                            </div>
                            
                            </div>
                            </div>
                            </div>
                    <!-- question -->
                    <?php } 
if(!in_array(55,$check)){ ?>
                    <div class="question">
                        <div class="numb">4.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a fire risk assessment?
                                </div>
                               
                                
                                <div class="form-group-radio">
                                    <div class="radio_btnbox">
                                        <input type="hidden" name="form[fire_risk_assessment_id]" value="55">
                                        <input type="hidden" name="form[fire_risk_assessment_q]" value="Do you have a fire risk assessment?">
                                        <div class="radio_btnbox">
                                            <span><i class="fa fa-info-circle"></i></span>
                                            <div class="form-group form-radio mb-0">
                                                <label for="fire_risk_assessment" class="rad-label">
                                                    <input type="radio" class="rad-input" id="fire_risk_assessment" name="form[fire_risk_assessment]" value="yes">
                                                    <div class="rad-design"></div>
                                                    <div class="rad-text">Yes</div>
                                                </label>
                                            </div>
                                            <div class="form-group form-radio mb-0">
                                                <label for="fire_risk_assessment2" class="rad-label">
                                                    <input type="radio" class="rad-input" name="form[fire_risk_assessment]" value="no" id="fire_risk_assessment2">
                                                    <div class="rad-design"></div>
                                                    <div class="rad-text">No</div>
                                                </label>
                                            </div>            
                                        </div>
                                    </div>
                                        <div class="sh">
                                            <span>Last Completion Date:</span>
                                            <input type="text" class="datepicker" name="form[fire_risk_assessment_date]">
                                            <div class="file">
                                                <input type="file" name="fire_risk_assessment">
                                                <i class="fas fa-paperclip"></i>
                                                <div>Upload</div>
                                            </div>
                                        </div>
                                </div>
                                
                                 <!--<input type="radio" name="form[fire_risk_assessment]" value="yes" id="fire_risk_assessment">-->
                                 <!--       <label for="fire_risk_assessment">Yes</label>-->
                                 <!--       <input type="radio" name="form[fire_risk_assessment]" value="no" id="fire_risk_assessment2">-->
                                 <!--       <label for="fire_risk_assessment2">No</label>-->


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fire_risk_assessment_comment]" class="form-control"></textarea>
</div>



                            </div>
                            <div class="quest-hover">We will also check these documents:<br>
                                fire risk assessment<br>
                                plans for emergency evacuation<br>
                                details of fire training for staff<br>
                                building control certificate<br>
                                utilities and equipment installation certificates, for example, gas, electric, lifts.</div>
                        </div>
                        <!--<div class="sh">-->
                        <!--    <span>Last Completion Date:</span>-->
                        <!--    <input type="text" class="datepicker" name="form[fire_risk_assessment_date]">-->
                        <!--    <div class="file">-->
                        <!--        <input type="file" name="fire_risk_assessment">-->
                        <!--        <i class="fas fa-paperclip"></i>-->
                        <!--        <div>Upload</div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        
                        
                    <input class="submit_class" type="submit" value="Save">
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(56,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">8.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a legionella risk assessment?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[legionella_risk_assessment_id]" value="56">
                                    <input type="hidden" name="form[legionella_risk_assessment_q]" value="Do you have a legionella risk assessment?">
                                    <input type="radio" name="form[legionella_risk_assessment]" value="yes" id="legionella_risk_assessment">
                                    <label for="legionella_risk_assessment">Yes</label>
                                    <input type="radio" name="form[legionella_risk_assessment]" value="no" id="legionella_risk_assessment2">
                                    <label for="legionella_risk_assessment2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[legionella_risk_assessment_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters :<br>
                                    1. All systems require a risk assessment, however not all systems will require elaborate control measures.<br>
                                    2. All premises are required to have a written waterline management scheme and legionella risk assessment. These schemes should be written by experienced and competent people. A competent person is someone with the necessary skills, knowledge and experience to carry out this function.<br>
                                    3. The registered manager must ensure that all the recommendations of the written scheme and risk assessment are implemented<br>
                                    4. Water and air lines must be fitted with anti-retraction valves in accordance with EU regulations<br>
                                    5. It is mandatory to control Legionella within the dental waterline system, but there is no one single system of treatment which is 100% effective
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[legionella_risk_assessment_date]">
                            <div class="file"><input type="file" name="legionella_risk_assessment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } 
if(!in_array(64,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">9.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a sharps risk assessment?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[sharps_risk_assessment_id]" value="64">
                                    <input type="hidden" name="form[sharps_risk_assessment_q]" value="Do you have a sharps risk assessment?">
                                    <input type="radio" name="form[sharps_risk_assessment]" value="yes" id="sharps_risk_assessment">
                                    <label for="sharps_risk_assessment">Yes</label>
                                    <input type="radio" name="form[sharps_risk_assessment]" value="no" id="sharps_risk_assessment2">
                                    <label for="sharps_risk_assessment2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[sharps_risk_assessment_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">1. Employers ensure that risks from sharps injuries are adequately assessed and appropriate control measures are in place.<br>
                                    2. There is a written practice policy/protocol in place, including a risk assessment explaining why they continue to use traditional local anaesthetic reusable syringes (see 3 and 4 below).<br>
                                    3. The employer should ensure that sharps are only used where they are required.<br>
                                    4. The employer must substitute traditional, unprotected medical sharps with a ‘safer sharp’ where it reasonably practicable to do so.<br>
                                    5. Place secure containers and instructions for safe disposal of medical sharps close to the work area (but not sited on the floor)<br>
                                    6. Regulation 7(6)(c) of COSHH requires systems to dispose of contaminated waste safely.<br>
                                    7. Employees are trained so they know how to work safely and without risk to health with the specific sharps equipment and procedures that they will use.<br>
                                    8. An employee who receives a sharps injury at work must notify their employer as soon as practicable. The employer must ensure they have sufficiently robust arrangements to allow employees to notify them in a timely manner, including where the employee works out-of-office hours or away from the employer’s premises.<br>
                                    9. If an employee has been injured by a sharp that has or may have exposed them to a blood-borne virus, the employer must:<br>
                                    • ensure that the employee has:<br>
                                    o immediate access to medical advice<br>
                                    o has been offered post-exposure prophylaxis and any other medical treatment, as advised by a doctor;<br>
                                    • considered whether the employee should receive counselling
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[sharps_risk_assessment_date]">
                            <div class="file"><input type="file" name="sharps_risk_assessment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } 
if(!in_array(59,$check)){ ?>
                    <!-- <div class="question">
                        <div class="numb">10.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a health &amp; safety risk assessment?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[health_safety_risk_assessment_id]" value="59">
                                    <input type="hidden" name="form[health_safety_risk_assessment_q]" value="Do you have a health &amp; safety risk assessment?">
                                    <input type="radio" name="form[health_safety_risk_assessment]" value="yes" id="health_safety_risk_assessment">
                                    <label for="health_safety_risk_assessment">Yes</label>
                                    <input type="radio" name="form[health_safety_risk_assessment]" value="no" id="health_safety_risk_assessment2">
                                    <label for="health_safety_risk_assessment2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[health_safety_risk_assessment_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[health_safety_risk_assessment_date]">
                            <div class="file"><input type="file" name="health_safety_risk_assessment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- question -->
                    <?php } ?>
                    <hr>
                </div>
                <!-- quest-box -->
                <?php } ?>

            </form>
            <?php
        }
   if(@$fchk1 == "false"){
       $sql = "UPDATE `accounts_user` SET `health_form` = '1' WHERE `acc_id` = ? ";
       $dbF->setRow($sql,array($uid));
       $sql2 = "SELECT `id` FROM `eventmanagement` WHERE `id` NOT IN (SELECT `title_id` FROM `userevent` WHERE `user`='$uid') AND `id` NOT IN (SELECT `recurrence` FROM `eventmanagement`) AND `assignto` IN ('all','$uid')";
       $data2 = $dbF->getRows($sql2);
        $i=7;  $date = Date('Y-m-d');
        foreach ($data2 as $key => $value) {
            while($i){        
          
            $due_date = Date('Y-m-d',strtotime('+'.$i.'day'));
            if($functions->isWeekend($due_date)){
                $i++;
                continue;
            }
            $sql4 = "SELECT COUNT(*) FROM `userevent` WHERE `user`='$uid' AND `approved`='-1' AND (`due_date` = ? OR `dateTime` = ?) ";
            $data4 = $dbF->getRow($sql4,array($due_date,$due_date));
            $check = $data4[0];
                if($check < 2){
                    $sql = "INSERT INTO `userevent`(`user`,`title_id`,`dateTime`,`due_date`) VALUES (?,?,?,?)";
                    $dbF->setRow($sql,array($uid,$value['id'],$due_date,$date));
                    $title = $functions->eventTitle($value['id']);
                    $functions->setlog("Health Check Form Event Create",$functions->userName($uid)." : ".$uid,"",$value['id']." : ".$title);
                    break;
                }
                $i++;
            }
        }
       echo "<div class='alert alert-info'>$thankT2</div>";
    }
}
?>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
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
        $(this).parents('.question').find('.sh').css("display", "inline-flex");
        $(this).parents('.question').find('input[type=date]').attr('required', true);
    } else {
        $(this).parents('.question').find('.sh').css("display", "none");
        $(this).parents('.question').find('input[type=date]').attr('required', false);
    }
});
$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});
</script>
<?php include_once('dashboardfooter.php'); ?>