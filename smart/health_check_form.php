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
    if($_SESSION['superUser']['health_form'] == '0'){
        header('Location: dashboard');
        exit();
    }
}

 include_once('header.php'); 


$thankT2 = $dbF->hardWords('Your Initial Compliance Health Check form complete. You can now view your practice compliance health on the dashboard.',false);
?>
<?php include'dashboardheader.php'; ?>
<div class="index_content mypage health_form">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            Initial Compliance Health Check Form
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'dashboard'; include'dashboardmenu.php';?>
        </div><!-- left_side close -->
        <div class="right_side">
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    $functions->changeSession();
                    ?>
                </div>
                <!-- change-session -->
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
<td>Comment: '.$_POST['form'][$key.'_comment'].'</td></tr>';


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
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABN5JREFUWEflmFtoHGUUx883m7i72d3MqhVBxKY01BvG1IdQ3dmoiCLipaFQsxNvkD4VLAoiCorgixVfSkARo77UzEbEaq0PasG22Wn0oTT1iuCtUosKXmayuew22Tn+v0lnnaabnc00DQluHjI7833n+33/c75zzo6gFf4RK5yPVg9gOm8eWFY1hbCs3kxP0JpVBQHIQYOX9DkzWXo20IOrD5BZ2WnrNz29pGr5jKXzhYNE4mYKraCgx61ebdfqAdxrplKTsWhY4GKiVKb7tKI3f8kVbDXMrxVB14YFhCe/snWt4/8LqOZHb2Pma8IqKJroG3tr5tPzpmBYsIXmLX0MDpl3KSTaGwGF0n/YD2hv1xurGuY2Ieg1pBkRLlHPSzNpo3CchFgbBIjD4OBPl4CtxuHtgp1+VPrLMO9iIcRJ/D/hOM4r433dw+l3j66lU1ODVk67I8ju2ZUkDCDTeCna0tE8M3ldxKHd2FC6urAsoL6Cho387VRoc/FBrRAEJ58HArZKFwtnQz1jlt69S6qmCH55bhzb5IgBmN9j9WWOpfOftTlceQiLbYd7LwUzU4VyQeHQEGAju0wPHe4khcfm2HgfYuveBQ+JYQ5Alkcl5Cw3dU7qm76st0aggmq+sFOw0lXbSOUDqR4C/3epTBCctKG+Zd5PEbodC/dj/Als5opzAqx3SByHn1UUMuHKA1hskuLJy62ejdZCC6rD5vc0S89I16aNEYuEolaYs0U9Cxu1P8EKGuYngpzaCsZTbVQqorFQHmaHDLtP61sQzigYeLbV1rNNckzaczXz+7i3YOMaCBgUg/8pzLdauezBWuOlW0WEhpEnqzCp3WY20kQjONU/oVavD63gYgETxucdCs20+t2Gbr0IuGQ5mmgrbbnhF8+m7OKZnb9svXtNaEA1b74umLbMN4BTCMNau2oUvkMivrIi+J5ib/ZD9yAYhd8EiXcsXduBawPPczi0h6DwLZ6d1HDh7giLfbj/Be53hgas1s4aFlAJhDo08pJQlCfgqv0AdiuDaoygnCmDLGgPMl6PLGvz1fPA8ehNW8/0hwc0Rh5DZdhcy8AMN+9oFjxOVPkZgBURT6zxTrF/Y/7Ycw/Ie2NpLk1IlWNEkXVW7sbjoQGDYtBdcMg8RAp1IwEfw8+FjdUYMwoTTCICZeN+O4CXqSkj7yFU3rBz2rbQgG6pq9PNlGLxvTFF2DQ98SuUTpDD31JLMlMrH7rKTU98jJjscpsLYgXXdSED00xQNwMFTpUvaHFrdbQ8NYb1LsS9WXzdLxzxkaPQj4pD61EKe+DqLIAiciw6mxzGJmWs1lPynAFd1zBNo5u5WqYQeepxKB7xQPyug2qytykDLCbn4Ms0ri/yxuDxi3Yu+5R/TiBgI92MNFghceSM3IfDhfi7U8IArITrUSWeGJCuxyZ+wMJucgbkP8TOk4jJQeluh+m5cV173oMMBGzkkIQZU4U8rX50emoTwmB4PuSyA6rG6AsiGnvVmguHOSV9kLIkuh453UQsO6CbH1l0EWJ2PiQS+0kAtcuQ8FLT2YDYjQzkMG5raI7gJOINHQ3/iRJ3iZxzRkwCrhxtucqr2Svm7Raa3jEckXWlaPJ6f0PhA5RvnZbx477A1GqW0JppZhnRFrVU4BvORVk7D4NXPOC/gCfzRzwZcKQAAAAASUVORK5CYII=); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Audits</h3>
                    <?php if(!in_array(39,$check)){ ?>
                    <div class="question">
                        <div class="numb">1.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a completed disability access audit?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[disability_access_audit_id]" value="39">
                                    <input type="hidden" name="form[disability_access_audit_q]" value="Do you have a completed disability access audit?">
                                    <input type="radio" name="form[disability_access_audit]" value="yes" id="disability_access_audit">
                                    <label for="disability_access_audit">Yes</label>
                                    <input type="radio" name="form[disability_access_audit]" value="no" id="disability_access_audit2">
                                    <label for="disability_access_audit2">No</label>
                                </div>

    <br>
    <br>
    <div class="quest-hoverComments">Type Comment:<br><br>
    <textarea name="form[disability_access_audit_comment]" class="form-control"></textarea>
    </div>



                            </div>
                            <div class="quest-hover">CQC Mythbusters<br>
                                Accessibility: All organisations providing services to the public must audit their facilities and ensure they comply with the <a href="http://www.legislation.gov.uk/ukpga/2010/15/contents" target="_blank">Equality Act 2010.</a>
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
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[cross_infection_audit_id]" value="51">
                                    <input type="hidden" name="form[cross_infection_audit_q]" value="Do you have a completed cross infection audit?">
                                    <input type="radio" name="form[cross_infection_audit]" value="yes" id="cross_infection_audit">
                                    <label for="cross_infection_audit">Yes</label>
                                    <input type="radio" name="form[cross_infection_audit]" value="no" id="cross_infection_audit2">
                                    <label for="cross_infection_audit2">No</label>
                                </div>

<br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[cross_infection_audit_comment]" class="form-control"></textarea>
</div>



                            </div>
                            <div class="quest-hover">CQC Mythbusters<br>
                                Infection prevention and control: Establish and operate a quality assurance system that covers the use of effective measures of decontamination and infection control. Complying with <a href="https://www.gov.uk/government/publications/decontamination-in-primary-care-dental-practices" target="_blank">HTM01-05</a> (Decontamination in primary care dental practices) shows there are valid quality assurance systems in place. As a minimum, practices should audit their decontamination processes every six months, with an appropriate review dependent on audit outcomes. The <a href="http://www.ips.uk.net/professional-practice/resources1/dental-audit-tool/" target="_blank">Infection Prevention Society audit tool could</a> be used.
                                the <a href="http://www.fgdp.org.uk/publications/standardsindentistryonline.ashx" target="_blank">Faculty of General Dental Practice (FGDP) Standards in Dentistry online.</a>
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
                    <!-- question -->
                    <?php } 
if(!in_array(41,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(42,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(38,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php } 
if(!in_array(54,$check) || !in_array(55,$check) || !in_array(56,$check) || !in_array(64,$check) || !in_array(59,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAAA9dJREFUWEftmMtPE1EUxs8ZXtpEKYmJ4EZJUIORgGw00gZNXLAT40LamJioC93pCl0aF2pc6JKFj43hsUD8A0wEKWqMQYwLNaJiYiILDdMNlUfn+N15lFJmYGg7VRObEPq4M+d3v3O+c+8dpr/8xX85H/2bgOG+xJNClZU09SRPRgYKvY+rggAU3DhFInN5B2CqljTHCoX0BmS6qHdFbucLiEneIZLThUIGBqgm5kAS8T09Fjmbz2QDBVyCpDN4fzcfyMABC4XMC7Cm90VEaPEUmlQDjLQbKZwmlinU24CXKax0r1/JdQGaYLx4H4EaPOtJSCeNrrgZLNw7OoRJHdVjUc1vPfoGrO59do053Q21nGtScOnLTCDhXQhelxV4GDV3OBsk3J+4QEK38L3vBcIXoAVnXDKDiehi8Dm3VIYHx7fTQuoxxjgKTwJmpwMZCKCV1oWnpnLMk3pXWyagV5qy6g2s2vVk/OBl0yxBKBjuH/toK5KCGiG/tRPuGxuH3Pvwt4iaqwgEkCpCQzQ/O2VCrXNlMdM9P/tFXblMRSyjRatBFPReuzWY6sGFM4pUmAZFaA9y/h6/t+CbejGoB+7tYJYkBjTr8UjNkor8Wo+1tdo9sZiA0gmgdqRpBGk6pDYRAJtgMuqFtDmAfkC/iKrf0QOfs2acF9Y2A+RzMhZpyJgLxtLj0ZoSAWKjw/wJ6m5SgIz/ELWZ0nRDARJr1ZkJ2aZQzi8ZoAqOgC0ZBUWahPkni7HF7ELEAKTpZDxa57g2OEBD2qFWJ6KmUFMha59oARrEs2iiqgYbMWYrxryxUs8pZq79VRnasWE+NWQ6Oas9qXsUzSRslL/C0jZqmljKozPxAwm/bcaqt9EFXFmOt5mdTFEB1XpqOpc5DNW+o462+QW01l2or7JeGarXj7d+LbpJFGD1g8QJLqN+e5l7BMhja0Euu4aWWkwggPZNna2S+jgJRY44iuTCIq0PkdbcSQSXYgcgK2Uqa6rXqFYzTFz2Vihdi3bTgUJtsmvOTWRz41D0GsyOZLeNm/hOFb7XS8FPYBItylvLB8mimkDRXOx1qrNqjLtJjPoMgKb9gLAjSP9Vlf7sHU3uTHBm7vJ7HPW1H1zLFF6/L63FriN8HaICBTQN5rQp91ks29C6DQke0Np2TXrWLVYpqgo1enWFwAGVKnZf7FtpGluzVSBXezajZv0t3/pbcZ3Qfnh6o7f3xXURcAc0N6YBvJircFcPSGvPmRvV9/GvWLirmMbV1aUHtEzzLkdJzwNZyQGdTNhPvnB+xlF2lSdffwzQb8n8B/SrlNe4302zfkcw0dt6AAAAAElFTkSuQmCC'); background-repeat: no-repeat; background-position: center;"></div>


                    <h3>Risk Assessment</h3>
                    <?php if(!in_array(54,$check)){ ?>
                    <div class="question">
                        <div class="numb">6.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a general practice risk assessment?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[general_practice_risk_assessment_id]" value="54">
                                    <input type="hidden" name="form[general_practice_risk_assessment_q]" value="Do you have a general practice risk assessment?">
                                    <input type="radio" name="form[general_practice_risk_assessment]" value="yes" id="general_practice_risk_assessment">
                                    <label for="general_practice_risk_assessment">Yes</label>
                                    <input type="radio" name="form[general_practice_risk_assessment]" value="no" id="general_practice_risk_assessment2">
                                    <label for="general_practice_risk_assessment2">No</label>
                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[general_practice_risk_assessment_comment]" class="form-control"></textarea>
</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Completion Date:</span>
                            <input type="text" class="datepicker" name="form[general_practice_risk_assessment_date]">
                            <div class="file">
                                <input type="file" name="general_practice_risk_assessment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(55,$check)){ ?>
                    <div class="question">
                        <div class="numb">7.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a fire risk assessment?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[fire_risk_assessment_id]" value="55">
                                    <input type="hidden" name="form[fire_risk_assessment_q]" value="Do you have a fire risk assessment?">
                                    <input type="radio" name="form[fire_risk_assessment]" value="yes" id="fire_risk_assessment">
                                    <label for="fire_risk_assessment">Yes</label>
                                    <input type="radio" name="form[fire_risk_assessment]" value="no" id="fire_risk_assessment2">
                                    <label for="fire_risk_assessment2">No</label>
                                </div>


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
                    <!-- question -->
                    <?php } 
if(!in_array(56,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(64,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(59,$check)){ ?>
                    <div class="question">
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
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php } 
if(!in_array(81,$check) || !in_array(134,$check) || !in_array(83,$check) || !in_array(137,$check) || !in_array(74,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABbFJREFUWEftWE1sVFUUPuc+7LS1OOOGKGqEWKUuDEVNiDKlqBsSNxIl0JEYCyasanCjCGo0KpigkQUJGP9iojNi1GK6Mm5KZzQlMRZ3XUigC4MLDDOatjPI3ON338/0vTfvzU8tQow3aaYz83rPd7/zne+cW6ZrfPE1jo/+WwCT2cL7TPIoEaeEpIOZLRIq4v1UlfQrf2YGCkudkZYYTGUn9gipgwg+LaLGWInFQg8YMNriAmu9kkSeZlITxcyGh9sFmczlv2ZRKfN3ouW90o70cW+PpgCTucIHYOlJbHCIWI9AFPZG/iVEl6lKb5OizfjpKW1P39kOyFSugC2cJSK/lTIDN7cE0GNOiN9hln0s+g9iPi1Ca5Dem3Dckv2e+Fac9A5E+QUS+FWEk6VMel2rIP0AzZ7FzMYaCbEMdn710+2Jytx0Vamnlon+wpwMoKbBZr8wXdAiw0rzLWTRm+bg0OEMwD2CX0+Chn589ioCHW4F5KIAmtQiYC9CrwVLKZzsOWL1bii3RYDtwSmXAeGHeN1lp4n0MRbeXswM3HjlAGbz5yHYA2yptaLpkrBkLeZ8XEA/QMMi0ry+kujuKz9+70wzkIti8Ibs928w6RVgbxgBZlAE+0nJYVt7EQs6/BKMP+EoXZeE1QVo9kgraW4LoNFeZ2X+YzC2yRSFJuuIInrQvEfoj7w0BqoY+sRBZk2heABN8UCLJ5YUYPLTwjaIPucBYy0W3r+AwE4xuTpEwcCX+RC+2+pUr5xikT5oNOlokM7gZRysf+f3tLhUt8wgHpxD8G/hQ1tgMUXR6ih6xd7axh5AFAQ+2wmdHVAs++0KJ+mCmSdE6+eVsrbAwvtwrq4gKP0apDCIZ0/6mW0HoFRFBkzLQlubIqVOka7uhu6cOFq9Tkq/DBDHWaltTjFQGt+MAcxm45cGcHxRuBaE9BeHBoxk7NUyQAMKUNaUE913X1eZvc0ygZl+RvBBZyunOpHqbxYA8nq7y6jqRgDcYCynXYAoyBG0z02kRYHdh2KN2jNnPHQRHrbSZpHkHAR/j1cAWvhZ+NyUsRwo8S2yuBf6wwCh99X5ZB3SBQZtMzeadbuRTYKRkGPw8Z3EATl7xhRBpav7mOkmYPEzKP8+ZLofBYCCpjI+g+bQg7FsozZgleytySGSxugU93z+w1ZLVzMAfBnAe/1tMrLV2almKRmduIAn8SCkJweR2p3wx9VIZxJMl/A6j+JAF9ErcIC7FuQQhTAaoNO1aBf0XA6beyTAVC4/brb3CxkWBHAyAgCwRZ5cCC/rYDPLAa5QFXopstuYNBoFwxXMxIPDfBL2R2NxyNhkuPO0DNADtDybT2NKvd+zCwQ97/c6sIGJxjVsAwqpx/cvxheOW8mwNVd/gQGjbYBeIAD5C0a8I2zE9gF8Pbs4lG46c9pWs9QAbe9C1UW1sgCLMc+EGf1XAQZYxJ2lmEk3HbvaAmgCmBM2ugQ1YtD8bbsstgUwlc1fFObfS0Pp3jhxNwPoZzF8z4jas+UqNvcQryN4fTlqw2YAbRazhXnYT6f5vdzRvSpueLW99tLcWfjqhN/a3CYQDB+0CUwdvqbuf7I1gPlRdJbHbA/EBISMPBN9WOO7PGi6VKWje7X/IHUWULuL2LvGD5zJbH60krh+T6OR3p8NdInTcTc9Y1nekBE+SD1AZ6JZ5Z76XNSmjlnzGHxm3MyOcToNVnPwOhnIhpGVu6rEP/qLsw6gXU3uZBy+o9ZMGhcqczcxKUHa0PriV23WC9136+RS+yAoq8UBzBW0/xrQ6N7h2gc0qM7GpTgwsJpp26f7RQG0teWucqJnNEqHxjZY8e4wt+VE13D4+aUHGPxfyokoHaKIbBnUJ7/eGa4oQHMNiLIip4Idi/EvqfLR8ICxaIBxHSD036i2GMSedc+3BbBRRV6N71qa1a4GMC/m/wD/Kft/A+ZAyVasY2SvAAAAAElFTkSuQmCC'); background-repeat: no-repeat; background-position: center;"></div>

                    <h3>Services of Equipment</h3>
                    <?php if(!in_array(81,$check)){ ?>
                    <div class="question">
                        <div class="numb">11.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you had your autoclave serviced?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[autoclave_serviced_id]" value="81">
                                    <input type="hidden" name="form[autoclave_serviced_q]" value="Have you had your autoclave serviced?">
                                    <input type="radio" name="form[autoclave_serviced]" value="yes" id="autoclave_serviced">
                                    <label for="autoclave_serviced">Yes</label>
                                    <input type="radio" name="form[autoclave_serviced]" value="no" id="autoclave_serviced2">
                                    <label for="autoclave_serviced2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[autoclave_serviced_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbuster<br>
                                    Sterilisers are maintained by an appropriate and competent person. As sterilisers are pressure vessels, a suitable written scheme of examination needs to be in place for each one. Once in place, sterilisers need to be examined in accordance with the written scheme of examination. The maximum interval between these safety inspections is 14 months. Current certification must be available for inspection.All decontamination equipment should be validated, tested, maintained and serviced as recommended by the manufacturer. Validation is needed for new decontamination equipment at installation and annually thereafter.A record of every single sterilisation cycle should be made. This record should demonstrate that the steriliser is working within validated parameters such as time, temperature and pressure, using the machine’s own indicated measurements on the display. Records need to be kept for a minimum of two years.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Service Date:</span>
                            <input type="text" class="datepicker" name="form[autoclave_serviced_date]">
                            <div class="file"><input type="file" name="autoclave_serviced">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(134,$check)){ ?>
                    <div class="question">
                        <div class="numb">12.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you had your compressor serviced?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[compressor_serviced_id]" value="134">
                                    <input type="hidden" name="form[compressor_serviced_q]" value="Have you had your compressor serviced?">
                                    <input type="radio" name="form[compressor_serviced]" value="yes" id="compressor_serviced">
                                    <label for="compressor_serviced">Yes</label>
                                    <input type="radio" name="form[compressor_serviced]" value="no" id="compressor_serviced2">
                                    <label for="compressor_serviced2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[compressor_serviced_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Service Date:</span>
                            <input type="text" class="datepicker" name="form[compressor_serviced_date]">
                            <div class="file"><input type="file" name="compressor_serviced">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(83,$check)){ ?>
                    <div class="question">
                        <div class="numb">13.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you had your washer disinfector serviced?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[washer_disinfector_serviced_id]" value="83">
                                    <input type="hidden" name="form[washer_disinfector_serviced_q]" value="Have you had your washer disinfector serviced?">
                                    <input type="radio" name="form[washer_disinfector_serviced]" value="yes" id="washer_disinfector_serviced">
                                    <label for="washer_disinfector_serviced">Yes</label>
                                    <input type="radio" name="form[washer_disinfector_serviced]" value="no" id="washer_disinfector_serviced2">
                                    <label for="washer_disinfector_serviced2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[washer_disinfector_serviced_comment]" class="form-control"></textarea>
</div>


                            </div>
                        </div>
                        <div class="sh">
                            <span>Service Date:</span>
                            <input type="text" class="datepicker" name="form[washer_disinfector_serviced_date]">
                            <div class="file"><input type="file" name="washer_disinfector_serviced">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(137,$check)){ ?>
                    <div class="question">
                        <div class="numb">14.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you had PAT testing on your equipment?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[PAT_testing_on_your_equipment_id]" value="137">
                                    <input type="hidden" name="form[PAT_testing_on_your_equipment_q]" value="Have you had PAT testing on your equipment?">
                                    <input type="radio" name="form[PAT_testing_on_your_equipment]" value="yes" id="PAT_testing_on_your_equipment">
                                    <label for="PAT_testing_on_your_equipment">Yes</label>
                                    <input type="radio" name="form[PAT_testing_on_your_equipment]" value="no" id="PAT_testing_on_your_equipment2">
                                    <label for="PAT_testing_on_your_equipment2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[PAT_testing_on_your_equipment_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters<br>
                                    testing and maintenance of firefighting equipment(extinguishers)<br>
                                    testing and maintenance of all fire safety systems (fire alarms, emergency lighting, mains electrical wiring, gas safety certificate and PAT testing certificate)
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Service Date:</span>
                            <input type="text" class="datepicker" name="form[PAT_testing_on_your_equipment_date]">
                            <div class="file"><input type="file" name="PAT_testing_on_your_equipment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } 
if(!in_array(74,$check)){ ?>
                    <div class="question">
                        <div class="numb">15.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have critical examination report for x-ray units?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[critical_examination_report_for_x-ray_units_id]" value="74">
                                       <input type="hidden" name="form[critical_examination_report_for_x-ray_units_q]" value="Do you have critical examination report for x-ray units?">
                                    <input type="radio" name="form[critical_examination_report_for_x-ray_units]" value="yes" id="critical_examination_report_for_x-ray_units">
                                    <label for="critical_examination_report_for_x-ray_units">Yes</label>
                                    <input type="radio" name="form[critical_examination_report_for_x-ray_units]" value="no" id="critical_examination_report_for_x-ray_units2">
                                    <label for="critical_examination_report_for_x-ray_units2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[critical_examination_report_for_x-ray_units_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">Do you quality assure / performance test the radiography equipment?<br>
                                    Is the X-ray equipment maintained or serviced by an appropriate person? This could be the organisation which installed the equipment
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Service Date:</span>
                            <input type="text" class="datepicker" name="form[critical_examination_report_for_x-ray_units_date]">
                            <div class="file"><input type="file" name="critical_examination_report_for_x-ray_units">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(139,$check) || !in_array(140,$check) || !in_array(156,$check) || !in_array(147,$check) || !in_array(249,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABN5JREFUWEflmFtoHGUUx883m7i72d3MqhVBxKY01BvG1IdQ3dmoiCLipaFQsxNvkD4VLAoiCorgixVfSkARo77UzEbEaq0PasG22Wn0oTT1iuCtUosKXmayuew22Tn+v0lnnaabnc00DQluHjI7833n+33/c75zzo6gFf4RK5yPVg9gOm8eWFY1hbCs3kxP0JpVBQHIQYOX9DkzWXo20IOrD5BZ2WnrNz29pGr5jKXzhYNE4mYKraCgx61ebdfqAdxrplKTsWhY4GKiVKb7tKI3f8kVbDXMrxVB14YFhCe/snWt4/8LqOZHb2Pma8IqKJroG3tr5tPzpmBYsIXmLX0MDpl3KSTaGwGF0n/YD2hv1xurGuY2Ieg1pBkRLlHPSzNpo3CchFgbBIjD4OBPl4CtxuHtgp1+VPrLMO9iIcRJ/D/hOM4r433dw+l3j66lU1ODVk67I8ju2ZUkDCDTeCna0tE8M3ldxKHd2FC6urAsoL6Cho387VRoc/FBrRAEJ58HArZKFwtnQz1jlt69S6qmCH55bhzb5IgBmN9j9WWOpfOftTlceQiLbYd7LwUzU4VyQeHQEGAju0wPHe4khcfm2HgfYuveBQ+JYQ5Alkcl5Cw3dU7qm76st0aggmq+sFOw0lXbSOUDqR4C/3epTBCctKG+Zd5PEbodC/dj/Als5opzAqx3SByHn1UUMuHKA1hskuLJy62ejdZCC6rD5vc0S89I16aNEYuEolaYs0U9Cxu1P8EKGuYngpzaCsZTbVQqorFQHmaHDLtP61sQzigYeLbV1rNNckzaczXz+7i3YOMaCBgUg/8pzLdauezBWuOlW0WEhpEnqzCp3WY20kQjONU/oVavD63gYgETxucdCs20+t2Gbr0IuGQ5mmgrbbnhF8+m7OKZnb9svXtNaEA1b74umLbMN4BTCMNau2oUvkMivrIi+J5ib/ZD9yAYhd8EiXcsXduBawPPczi0h6DwLZ6d1HDh7giLfbj/Be53hgas1s4aFlAJhDo08pJQlCfgqv0AdiuDaoygnCmDLGgPMl6PLGvz1fPA8ehNW8/0hwc0Rh5DZdhcy8AMN+9oFjxOVPkZgBURT6zxTrF/Y/7Ycw/Ie2NpLk1IlWNEkXVW7sbjoQGDYtBdcMg8RAp1IwEfw8+FjdUYMwoTTCICZeN+O4CXqSkj7yFU3rBz2rbQgG6pq9PNlGLxvTFF2DQ98SuUTpDD31JLMlMrH7rKTU98jJjscpsLYgXXdSED00xQNwMFTpUvaHFrdbQ8NYb1LsS9WXzdLxzxkaPQj4pD61EKe+DqLIAiciw6mxzGJmWs1lPynAFd1zBNo5u5WqYQeepxKB7xQPyug2qytykDLCbn4Ms0ri/yxuDxi3Yu+5R/TiBgI92MNFghceSM3IfDhfi7U8IArITrUSWeGJCuxyZ+wMJucgbkP8TOk4jJQeluh+m5cV173oMMBGzkkIQZU4U8rX50emoTwmB4PuSyA6rG6AsiGnvVmguHOSV9kLIkuh453UQsO6CbH1l0EWJ2PiQS+0kAtcuQ8FLT2YDYjQzkMG5raI7gJOINHQ3/iRJ3iZxzRkwCrhxtucqr2Svm7Raa3jEckXWlaPJ6f0PhA5RvnZbx477A1GqW0JppZhnRFrVU4BvORVk7D4NXPOC/gCfzRzwZcKQAAAAASUVORK5CYII=); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Training</h3>
                    <?php if(!in_array(139,$check)){ ?>
                    <div class="question">
                        <div class="numb">16.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have all staff completed Annual Cross Infection Training?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[Annual_Cross_Infection_Training_id]" value="139">
                                    <input type="hidden" name="form[Annual_Cross_Infection_Training_q]" value="Have all staff completed Annual Cross Infection Training?">
                                    <input type="radio" name="form[Annual_Cross_Infection_Training]" value="yes" id="Annual_Cross_Infection_Training">
                                    <label for="Annual_Cross_Infection_Training">Yes</label>
                                    <input type="radio" name="form[Annual_Cross_Infection_Training]" value="no" id="Annual_Cross_Infection_Training2">
                                    <label for="Annual_Cross_Infection_Training2">No</label>
                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Annual_Cross_Infection_Training_comment]" class="form-control"></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>Training Date:</span>
                            <input type="text" class="datepicker" name="form[Annual_Cross_Infection_Training_date]">
                            <div class="file"><input type="file" name="Annual_Cross_Infection_Training">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(140,$check)){ ?>
                    <div class="question">
                        <div class="numb">17.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have all staff completed BLS/Medical emergency training?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[BLS/Medical_emergency_training_id]" value="140">
                                    <input type="hidden" name="form[BLS/Medical_emergency_training_q]" value="Have all staff completed BLS/Medical emergency training?">
                                    <input type="radio" name="form[BLS/Medical_emergency_training]" value="yes" id="BLS/Medical_emergency_training">
                                    <label for="BLS/Medical_emergency_training">Yes</label>
                                    <input type="radio" name="form[BLS/Medical_emergency_training]" value="no" id="BLS/Medical_emergency_training2">
                                    <label for="BLS/Medical_emergency_training2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[BLS/Medical_emergency_training_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Training Date:</span>
                            <input type="text" class="datepicker" name="form[BLS/Medical_emergency_training_date]">
                            <div class="file"><input type="file" name="BLS/Medical_emergency_training">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(156,$check)){ ?>
                    <div class="question">
                        <div class="numb">18.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a safeguarding lead with Level 2 certificate?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[safeguarding_lead_with_Level_2_certificate_id]" value="156">

                                     <input type="hidden" name="form[safeguarding_lead_with_Level_2_certificate_q]" value="Do you have a safeguarding lead with Level 2 certificate?">

                                    <input type="radio" name="form[safeguarding_lead_with_Level_2_certificate]" value="yes" id="safeguarding_lead_with_Level_2_certificate">
                                    <label for="safeguarding_lead_with_Level_2_certificate">Yes</label>
                                    <input type="radio" name="form[safeguarding_lead_with_Level_2_certificate]" value="no" id="safeguarding_lead_with_Level_2_certificate2">
                                    <label for="safeguarding_lead_with_Level_2_certificate2">No</label>
                                </div>


                                

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[safeguarding_lead_with_Level_2_certificate_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">Level 1: for all non-clinical staff (e.g. receptionists and practice managers)<br>
                                    Level 2: for all dentists and dental care professionals<br>
                                    Level 3: for paediatric dentists and paediatric orthodontists (i.e. those who could potentially contribute to assessing, planning, intervening and evaluating the needs of a child or young person and parenting capacity where there are safeguarding / child protection concerns). Level 3 training is not normally required for dentists and dental care professionals working in general dental practice.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Training Date:</span>
                            <input type="text" class="datepicker" name="form[safeguarding_lead_with_Level_2_certificate_date]">
                            <div class="file"><input type="file" name="safeguarding_lead_with_Level_2_certificate">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(249,$check)){ ?>
                    <div class="question">
                        <div class="numb">19.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do all staff taking x-rays have IRMER certification?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[IRMER_certification_id]" value="249">
                                    <input type="hidden" name="form[IRMER_certification_q]" value="Do all staff taking x-rays have IRMER certification?">
                                    <input type="radio" name="form[IRMER_certification]" value="yes" id="IRMER_certification">
                                    <label for="IRMER_certification">Yes</label>
                                    <input type="radio" name="form[IRMER_certification]" value="no" id="IRMER_certification2">
                                    <label for="IRMER_certification2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[IRMER_certification_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Training Date:</span>
                            <input type="text" class="datepicker" name="form[IRMER_certification_date]">
                            <div class="file"><input type="file" name="IRMER_certification">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(147,$check)){ ?>
                    <div class="question">
                        <div class="numb">20.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have all staff completed Level 2 safeguarding training?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[completed_Level_2_safeguarding_training_id]" value="147">

                                     <input type="hidden" name="form[completed_Level_2_safeguarding_training_q]" value="Have all staff completed Level 2 safeguarding training?">
                                    <input type="radio" name="form[completed_Level_2_safeguarding_training]" value="yes" id="completed_Level_2_safeguarding_training">
                                    <label for="completed_Level_2_safeguarding_training">Yes</label>
                                    <input type="radio" name="form[completed_Level_2_safeguarding_training]" value="no" id="completed_Level_2_safeguarding_training2">
                                    <label for="completed_Level_2_safeguarding_training2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[completed_Level_2_safeguarding_training_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">Level 1: for all non-clinical staff (e.g. receptionists and practice managers)<br>
                                    Level 2: for all dentists and dental care professionals<br>
                                    Level 3: for paediatric dentists and paediatric orthodontists (i.e. those who could potentially contribute to assessing, planning, intervening and evaluating the needs of a child or young person and parenting capacity where there are safeguarding / child protection concerns). Level 3 training is not normally required for dentists and dental care professionals working in general dental practice.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Training Date:</span>
                            <input type="text" class="datepicker" name="form[completed_Level_2_safeguarding_training_date]">
                            <div class="file"><input type="file" name="completed_Level_2_safeguarding_training">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(4,$check) || !in_array(141,$check) || !in_array(143,$check) || !in_array(142,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAAA+hJREFUWEftmM9PE1EQx2e2mJaC6ZKQKF7A6F3wYpRW8OZNiAfTaiLGfwC8eVEwJt4Ebx5M1ETbkwEOngVbQkyM5eBRQ0lM8OY2Ym2R7jhv2+2v/dG3pSWY+G6wM+999jvzZmaLcMgXHnI++DcBQ69Sj1DBc+1WlxT6UTgSvJO/enZLdm+LgqF4Ko0Iw7IbeLYj0LRYuE/WzwKoJlIk69yqnRYNS6eWKyARfQfEt0j651Zh7Py02MUF2f0cARmumI1Fujgfr4EPHiJBv+ymsnYcqs2CPzjplpPOCpKezft7z/h3c5tsJB0SWTjTTkSJhRhw8nMFZKdZQGXe66Ge7FkIDrm6b0AiyCPodz0d7mZsvni7AKHJRl7BK9Wi3YCBN58G/X9yj1FH6VpWyTedPmRvhI0odAxQTSRX+M6MeVXMtDdrYMcAjbKj0AICdXuGRNzQopHxjiroGcrBoaMKogJPWwOl31oscqKjCobiyUVEnGgNEKDjOWi8ffz9dCuARcCPP2ORlPAVL8qX7TLX1kJbCnVtHRQXhVU85gaZD3Qvmz1WXUyrUMiNAZXHONQ1KCqr2vXRjaPxZNiEtttPvtWVC2ookXrGTrfd4HgI+JqNhk+rifUhgOJ9tp1ysF8BUp5osQtL+251poLl8M46bUigbGZj4RE1sTbFPvM8rjn22coeBAs8xM60RUGZ3DPggJ5bbWmO/8eqiSHEUuxf8AW61ejjOcQiZ3ygPLADLYJ+z4dd34D20hbliHjUjxjtUX29NszFPm3Zg5TJxnB7BnRqdTzXQcHfMxTYzQmVbtoqreOIuBhqPDXNE6bdGJdhFU/W+noGFMNCYPfXy0YAKuK6GAT4BTQuHyFbQFaRld3gZ+POqUKXuB2umM89A7rlIMPxwfjOGjpaAuya0aLnM0aIE0m+ZChut82iOQbk56V1MICls5Y5fEYHOqSAVWXUOI9s1ltc1qyJglyIv7Csp0TdY4/qN4nERF0uzJv2kaveUNc8hSaARgi415KubKOiD1Q+miQAS76pDCfOoAXSvMGl7mL/EsKpbOeYg7UbG12j/HHD7Yv421io6rjy/uCwU5mpTjEOF0nsSrDFHYVfoLpcv3drAd3Aqs9oFQK9E5DfyVhKTaCnT5sc0Yw0oOIEqzzOflfq960vMeJZ0w9yHou2eXI5LgfIwSOK+MDXD6jzOFWziEsN+Mo/eegCsH5kI+ShYdQyxjUFlAVrtCvVRGAoh6JdT19X+6RD3Cqc6Ve61XtT/DcrYwNKnBIIs7Wdo/HMjilYe5AxsOZ3xG+OQlVeSgYCwSWRk81EOBDAZhBuz/8D7kc94fsX4qyRRwrrIoIAAAAASUVORK5CYII='); background-repeat: no-repeat; background-position: center;"></div>

                    <h3>Registration</h3>
                    <?php if(!in_array(4,$check)){ ?>
                    <div class="question">
                        <div class="numb">21.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a Business Continuity Plan?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[Business_Continuity_Plan_id]" value="4">
                                    <input type="hidden" name="form[Business_Continuity_Plan_q]" value="Do you have a Business Continuity Plan?">
                                    <input type="radio" name="form[Business_Continuity_Plan]" value="yes" id="Business_Continuity_Plan">
                                    <label for="Business_Continuity_Plan">Yes</label>
                                    <input type="radio" name="form[Business_Continuity_Plan]" value="no" id="Business_Continuity_Plan2">
                                    <label for="Business_Continuity_Plan2">No</label>
                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Business_Continuity_Plan_comment]" class="form-control"></textarea>
</div>




                                <div class="quest-hover">CQC Mythbusters<br>
                                    there is a business continuity plan that includes fire risks) together with confirmation of who the responsible person is
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Reviewed Date:</span>
                            <input type="text" class="datepicker" name="form[Business_Continuity_Plan_date]">
                            <div class="file"><input type="file" name="Business_Continuity_Plan">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(141,$check)){ ?>
                    <div class="question">
                        <div class="numb">22.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have a Business liability Insurance?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[Business_liability_Insurance_id]" value="141">
                                    <input type="hidden" name="form[Business_liability_Insurance_q]" value="Do you have a Business liability Insurance?">
                                    <input type="radio" name="form[Business_liability_Insurance]" value="yes" id="Business_liability_Insurance">
                                    <label for="Business_liability_Insurance">Yes</label>
                                    <input type="radio" name="form[Business_liability_Insurance]" value="no" id="Business_liability_Insurance2">
                                    <label for="Business_liability_Insurance2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Business_liability_Insurance_comment]" class="form-control"></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>Expiring Date:</span>
                            <input type="text" class="datepicker" name="form[Business_liability_Insurance_date]">
                            <div class="file"><input type="file" name="Business_liability_Insurance">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(143,$check)){ ?>
                    <div class="question">
                        <div class="numb">23.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you registered with the Health &amp; Safety Executive for radiology equipment (HSE)?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                        <input type="hidden" name="form[Health_Safety_Executive_for_radiology_equipment_id]" value="143">
                                        <input type="hidden" name="form[Health_Safety_Executive_for_radiology_equipment_q]" value="Have you registered with the Health &amp; Safety Executive for radiology equipment (HSE)?">
                                        <input type="radio" name="form[Health_Safety_Executive_for_radiology_equipment]" value="yes" id="Health_Safety_Executive_for_radiology_equipment">
                                        <label for="Health_Safety_Executive_for_radiology_equipment">Yes</label>
                                        <input type="radio" name="form[Health_Safety_Executive_for_radiology_equipment]" value="no" id="Health_Safety_Executive_for_radiology_equipment2">
                                        <label for="Health_Safety_Executive_for_radiology_equipment2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Health_Safety_Executive_for_radiology_equipment_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters<br>
                                    Have you registered with HSE? Where is your certificate?
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Register Date:</span>
                            <input type="text" class="datepicker" name="form[Health_Safety_Executive_for_radiology_equipment_date]">
                            <div class="file"><input type="file" name="Health_Safety_Executive_for_radiology_equipment">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(142,$check)){ ?>
                    <div class="question">
                        <div class="numb">24.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Have you registered with the Information Commission Officer (ICO)?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[Information_Commission_Officer_id]" value="142">
                                    <input type="hidden" name="form[Information_Commission_Officer_q]" value="Have you registered with the Information Commission Officer (ICO)?">
                                    <input type="radio" name="form[Information_Commission_Officer]" value="yes" id="Information_Commission_Officer">
                                    <label for="Information_Commission_Officer">Yes</label>
                                    <input type="radio" name="form[Information_Commission_Officer]" value="no" id="Information_Commission_Officer2">
                                    <label for="Information_Commission_Officer2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[Information_Commission_Officer_comment]" class="form-control"></textarea>
</div>




                            </div>
                        </div>
                        <div class="sh">
                            <span>Expiring Date:</span>
                            <input type="text" class="datepicker" name="form[Information_Commission_Officer_date]">
                            <div class="file"><input type="file" name="Information_Commission_Officer">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(146,$check) || !in_array(148,$check) || !in_array(149,$check) || !in_array(173,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABO9JREFUWEftWE1oXFUUPudNdJKUMtNdUxdWjWtTF6J0Rosb3YgRUTuDKKWCO23c2FKXQnVV6UaEFlFkJiJSwZWgRJ0HdaOJuxajKGjTTekb2k4mNXmn37lvXpx5c9+7L06Ugs4i5M2979zvfOfnfmeYbvEP3+L46L8DcGejVfE8nqNQLodEH16tV/3tiM62MFhu+gsAc2AAkPBCUN//6KggRwZY+sg/wQU6agMiG/RW+/nKsVFA5gaoQMijx5g4kFDew8Ef68HlxrcBsVeyAhS51K5Xp3QN7z/HHr8sJGUK6Yu8wHMBLDX8RWaaGQxhOBfUH34Ha6tYG7eyJGEbe8o2lkVoqV2v7HOx6wRoPC/QfNKQEK23a5XbSo3WCjPvzmKw1PT/xEFjQzY26GAciTSgboCN1lkAmLUZCGoVTnNA9yMHDQAUEfwZ/ojIZ0iBp7JYdAJEjh1Bjp0c8h4xgnHzfpSfchSOmG04mCjkzQJJA0gSpclIAA0Aa57JN0GteiA2Pv7pD3cWb6ye0Od2bX+9/9Bys/U1ET+SyGGTnyPnoBqIDu98BWr2Msk1IV7Q0PS+/xJb7gF3A9EAhxrWn0ORQ9q0katnseXxHqDza8XJ2e7T9/82MkAFMd5dfRLHmzwUCpf1pvBCvoMK1EwCG0oFfWWDaqEnf3hELzB508YO0zkwfXwkgCa3CvR6EsQ6e88WJGzYKtN2oLIpwq96LKf61w3LG/R2Vk9MLZK0GwInXUItXBjKKQcV2veAZ7e1JWUUSzrAtN5FdAZYXszLXoxb+yb+/wDvHbakgempNh+tAFWZFJhbVlLgra3tuHLJrGe82719cq+taKwA03qf6xAnyCznUsKcwSC9aTtwQ+iNAtvXXACz3tU1m4a0AjQ9i/ky8uKl/kP1exTIrv4G7QI1+L6/iHb1/ZDdpn8a/XXaZjctxJBQvJR8IZJWw9/nBWlUEYV3JW8Qc9OIzNhuFjuDTX8ZHv3+bwJEnyzZ5JedQeMR39ctTs70V1aWp3lYtEXA3FRrnSVi+TF3iFVCQZ3Mx+oE/T4I6pVdcfNOawlZIA2QG51f4zGg3GhdQboYsdBTP1ZtmCm3TLsx9y+fhLEzmtwolHUUir/VQlH2cZtUIDLGIGBPA9VhpNGchN5Klmh16kEFGIWWHwCLk/H9rALApYZjRmNRu8le0+8A7IVtkfx6SCSVaHZToKKI8Hw3S/iaS3CadIHqwf5fEAGjZGBPpZhTTeteJ4N/3SqDAjUepMDEYkjySrLJmkGe+BTSYV9yQNoUsNuhqCHXO3D3Yuz9QOONRtEjOtWpGGCha731IlyfwN3bRo69a5NTyMNl7N+jaZNVXHkYDEB0J6hX96QZ6lX9Qb1loqqkK5hJ5rNyFFV8EU5xPDen2XYCjFsOqngZLN4b9a3r5/A8FbHGrW5x4lBSiUT7Vt8XFp2sxoB6pVvc8ZDuK837P+E3nGk4MfrYaZI67otEK3C6rJ7jyjqG9qOD0BP4teGq9sl+FrTPYd9OfPc5gJw3qWDmFAnwZyoPuFxFEh8aJT19os9rxR0PxozFzVtn5AGAOgv3FYEZsNauf6d7MNM8k/fXL2eIsxJY1+IqdwF02fnbOegy3GO2hTCvKrlxFYO+CTBVzcvUPwZQDUcjwqCITROgLoeT6yOHeKsHbnX//wC3ylhy/00TBKBHY9NFggAAAABJRU5ErkJggg=='); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Staff</h3>
                    <?php if(!in_array(146,$check)){ ?>
                    <div class="question">
                        <div class="numb">25.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do all staff have a valid DBS?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[valid_DBS_id]" value="146">
                                    <input type="hidden" name="form[valid_DBS_q]" value="Do all staff have a valid DBS?">
                                    <input type="radio" name="form[valid_DBS]" value="yes" id="valid_DBS">
                                    <label for="valid_DBS">Yes</label>
                                    <input type="radio" name="form[valid_DBS]" value="no" id="valid_DBS2">
                                    <label for="valid_DBS2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[valid_DBS_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">Guidance states that all clinical staff require a DBS check. This includes dentists, dental hygienists, dental hygiene therapists and dental nurses.</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Review Date:</span>
                            <input type="text" class="datepicker" name="form[valid_DBS_date]">
                            <div class="file"><input type="file" name="valid_DBS">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(148,$check)){ ?>
                    <div class="question">
                        <div class="numb">26.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do all staff have proof of identification?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[proof_of_identification_id]" value="148">
                                    <input type="hidden" name="form[proof_of_identification_q]" value="Do all staff have proof of identification?">
                                    <input type="radio" name="form[proof_of_identification]" value="yes" id="proof_of_identification">
                                    <label for="proof_of_identification">Yes</label>
                                    <input type="radio" name="form[proof_of_identification]" value="no" id="proof_of_identification2">
                                    <label for="proof_of_identification2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[proof_of_identification_comment]" class="form-control"></textarea>
</div>




                                <div class="quest-hover">CQC Mythbusters<br>
                                    All staff:<br>
                                    Proof of identity including a recent photograph<br>
                                    A full employment history with explanations for gaps in employment. (We do not expect references from people who started work with the practice before the Health and Social Care 2008 Act, Schedule 3 was implemented in 2014).
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Review Date:</span>
                            <input type="text" class="datepicker" name="form[proof_of_identification_date]">
                            <div class="file"><input type="file" name="proof_of_identification">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(149,$check)){ ?>
                    <div class="question">
                        <div class="numb">27.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do all clinical staff have GDC registration, Hep B, and proof of indemnity?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[GDC_registration_id]" value="149">
                                    <input type="hidden" name="form[GDC_registration_q]" value="Do all clinical staff have GDC registration, Hep B, and proof of indemnity?">
                                    <input type="radio" name="form[GDC_registration]" value="yes" id="GDC_registration">
                                    <label for="GDC_registration">Yes</label>
                                    <input type="radio" name="form[GDC_registration]" value="no" id="GDC_registration2">
                                    <label for="GDC_registration2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[GDC_registration_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters<br>
                                    Documentary evidence of registration or membership of relevant professional bodies, for example GDC<br>
                                    Information about any physical or mental health condition relevant to a person’s capability, after reasonable adjustments are made, to properly carry out tasks they are expected to perform. We do not expect to see the health certificate stating they are suitable for work.<br>
                                    Staff working with vulnerable children or adults, who previously worked with these groups:<br>
                                    or if they previously worked in health or social care: satisfactory evidence of conduct in previous employment
                                    satisfactory verification why their employment in that position ended
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Review Date:</span>
                            <input type="text" class="datepicker" name="form[GDC_registration_date]">
                            <div class="file"><input type="file" name="GDC_registration">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(173,$check)){ ?>
                    <div class="question">
                        <div class="numb">28.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">Do all clinical staff have a PDP plan and annual appraisal
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[PDP_plan_and_annual_appraisal_id]" value="173">
                                    <input type="hidden" name="form[PDP_plan_and_annual_appraisal_q]" value="Do all clinical staff have a PDP plan and annual appraisal">
                                    <input type="radio" name="form[PDP_plan_and_annual_appraisal]" value="yes" id="PDP_plan_and_annual_appraisal">
                                    <label for="PDP_plan_and_annual_appraisal">Yes</label>
                                    <input type="radio" name="form[PDP_plan_and_annual_appraisal]" value="no" id="PDP_plan_and_annual_appraisal2">
                                    <label for="PDP_plan_and_annual_appraisal2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[PDP_plan_and_annual_appraisal_comment]" class="form-control"></textarea>
</div>




                                <div class="quest-hover">CQC Mythbusters<br>
                                    The PDP is personal to the dentist or DCP and an inspector would not normally need to examine it.
                                    We expect providers to be able to demonstrate that they have ensured themselves that staff are up to date with professional practice and have taken steps to comply with CQC requirements. For example, providers could keep a log of staff members training over their General Dental Council CPD cycle.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Review Date:</span>
                            <input type="text" class="datepicker" name="form[PDP_plan_and_annual_appraisal_date]">
                            <div class="file"><input type="file" name="PDP_plan_and_annual_appraisal">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(78,$check) || !in_array(151,$check) || !in_array(233,$check) || !in_array(153,$check) || !in_array(154,$check) || !in_array(86,$check) || !in_array(90,$check) || !in_array(89,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABbFJREFUWEftWE1sVFUUPuc+7LS1OOOGKGqEWKUuDEVNiDKlqBsSNxIl0JEYCyasanCjCGo0KpigkQUJGP9iojNi1GK6Mm5KZzQlMRZ3XUigC4MLDDOatjPI3ON338/0vTfvzU8tQow3aaYz83rPd7/zne+cW6ZrfPE1jo/+WwCT2cL7TPIoEaeEpIOZLRIq4v1UlfQrf2YGCkudkZYYTGUn9gipgwg+LaLGWInFQg8YMNriAmu9kkSeZlITxcyGh9sFmczlv2ZRKfN3ouW90o70cW+PpgCTucIHYOlJbHCIWI9AFPZG/iVEl6lKb5OizfjpKW1P39kOyFSugC2cJSK/lTIDN7cE0GNOiN9hln0s+g9iPi1Ca5Dem3Dckv2e+Fac9A5E+QUS+FWEk6VMel2rIP0AzZ7FzMYaCbEMdn710+2Jytx0Vamnlon+wpwMoKbBZr8wXdAiw0rzLWTRm+bg0OEMwD2CX0+Chn589ioCHW4F5KIAmtQiYC9CrwVLKZzsOWL1bii3RYDtwSmXAeGHeN1lp4n0MRbeXswM3HjlAGbz5yHYA2yptaLpkrBkLeZ8XEA/QMMi0ry+kujuKz9+70wzkIti8Ibs928w6RVgbxgBZlAE+0nJYVt7EQs6/BKMP+EoXZeE1QVo9kgraW4LoNFeZ2X+YzC2yRSFJuuIInrQvEfoj7w0BqoY+sRBZk2heABN8UCLJ5YUYPLTwjaIPucBYy0W3r+AwE4xuTpEwcCX+RC+2+pUr5xikT5oNOlokM7gZRysf+f3tLhUt8wgHpxD8G/hQ1tgMUXR6ih6xd7axh5AFAQ+2wmdHVAs++0KJ+mCmSdE6+eVsrbAwvtwrq4gKP0apDCIZ0/6mW0HoFRFBkzLQlubIqVOka7uhu6cOFq9Tkq/DBDHWaltTjFQGt+MAcxm45cGcHxRuBaE9BeHBoxk7NUyQAMKUNaUE913X1eZvc0ygZl+RvBBZyunOpHqbxYA8nq7y6jqRgDcYCynXYAoyBG0z02kRYHdh2KN2jNnPHQRHrbSZpHkHAR/j1cAWvhZ+NyUsRwo8S2yuBf6wwCh99X5ZB3SBQZtMzeadbuRTYKRkGPw8Z3EATl7xhRBpav7mOkmYPEzKP8+ZLofBYCCpjI+g+bQg7FsozZgleytySGSxugU93z+w1ZLVzMAfBnAe/1tMrLV2almKRmduIAn8SCkJweR2p3wx9VIZxJMl/A6j+JAF9ErcIC7FuQQhTAaoNO1aBf0XA6beyTAVC4/brb3CxkWBHAyAgCwRZ5cCC/rYDPLAa5QFXopstuYNBoFwxXMxIPDfBL2R2NxyNhkuPO0DNADtDybT2NKvd+zCwQ97/c6sIGJxjVsAwqpx/cvxheOW8mwNVd/gQGjbYBeIAD5C0a8I2zE9gF8Pbs4lG46c9pWs9QAbe9C1UW1sgCLMc+EGf1XAQZYxJ2lmEk3HbvaAmgCmBM2ugQ1YtD8bbsstgUwlc1fFObfS0Pp3jhxNwPoZzF8z4jas+UqNvcQryN4fTlqw2YAbRazhXnYT6f5vdzRvSpueLW99tLcWfjqhN/a3CYQDB+0CUwdvqbuf7I1gPlRdJbHbA/EBISMPBN9WOO7PGi6VKWje7X/IHUWULuL2LvGD5zJbH60krh+T6OR3p8NdInTcTc9Y1nekBE+SD1AZ6JZ5Z76XNSmjlnzGHxm3MyOcToNVnPwOhnIhpGVu6rEP/qLsw6gXU3uZBy+o9ZMGhcqczcxKUHa0PriV23WC9136+RS+yAoq8UBzBW0/xrQ6N7h2gc0qM7GpTgwsJpp26f7RQG0teWucqJnNEqHxjZY8e4wt+VE13D4+aUHGPxfyokoHaKIbBnUJ7/eGa4oQHMNiLIip4Idi/EvqfLR8ICxaIBxHSD036i2GMSedc+3BbBRRV6N71qa1a4GMC/m/wD/Kft/A+ZAyVasY2SvAAAAAElFTkSuQmCC'); background-repeat: no-repeat; background-position: center;"></div>

                    <h3>Practice Emergency Equipment</h3>
                    <?php if(!in_array(78,$check)){ ?>
                    <div class="question">
                        <div class="numb">29.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have an emergency drugs box with log sheets?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[emergency_drugs_box_id]" value="78">
                                    <input type="hidden" name="form[emergency_drugs_box_q]" value="Does the practice have an emergency drugs box with log sheets?">
                                    <input type="radio" name="form[emergency_drugs_box]" value="yes" id="emergency_drugs_box">
                                    <label for="emergency_drugs_box">Yes</label>
                                    <input type="radio" name="form[emergency_drugs_box]" value="no" id="emergency_drugs_box2">
                                    <label for="emergency_drugs_box2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[emergency_drugs_box_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC MythBusters:<br>
                                    To manage the more common medical emergencies encountered in general dental practice the following drugs should be available:<br>
                                    adrenaline injection (1:1000, 1mg/ml)<br>
                                    aspirin dispersible (300mg)<br>
                                    Glucagon injection 1mg<br>
                                    Glyceryl trinitrate (GTN) spray (400micrograms / dose)<br>
                                    Midazolam Oromucosal Solution, midazolam 5mg/ml<br>
                                    oral glucose solution / tablets / gel / powder<br>
                                    oxygen<br>
                                    Salbutamol aerosol inhaler (100micrograms / actuation)</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Log:</span>
                            <input type="text" class="datepicker" name="form[emergency_drugs_box_date]">
                            <div class="file"><input type="file" name="emergency_drugs_box">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(151,$check)){ ?>
                    <div class="question">
                        <div class="numb">30.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have a first aid box with log sheets?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[first_aid_box_with_log_sheets_id]" value="151">
                                    <input type="hidden" name="form[first_aid_box_with_log_sheets_q]" value="Does the practice have a first aid box with log sheets?">
                                    <input type="radio" name="form[first_aid_box_with_log_sheets]" value="yes" id="first_aid_box_with_log_sheets">
                                    <label for="first_aid_box_with_log_sheets">Yes</label>
                                    <input type="radio" name="form[first_aid_box_with_log_sheets]" value="no" id="first_aid_box_with_log_sheets2">
                                    <label for="first_aid_box_with_log_sheets2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[first_aid_box_with_log_sheets_comment]" class="form-control"></textarea>
</div>


                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Log:</span>
                            <input type="text" class="datepicker" name="form[first_aid_box_with_log_sheets_date]">
                            <div class="file"><input type="file" name="first_aid_box_with_log_sheets">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(233,$check)){ ?>
                    <div class="question">
                        <div class="numb">31.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have a defibrillator with log sheets?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[defibrillator_with_log_sheets_id]" value="233">
                                    <input type="hidden" name="form[defibrillator_with_log_sheets_q]" value="Does the practice have a defibrillator with log sheets?">
                                    <input type="radio" name="form[defibrillator_with_log_sheets]" value="yes" id="defibrillator_with_log_sheets">
                                    <label for="defibrillator_with_log_sheets">Yes</label>
                                    <input type="radio" name="form[defibrillator_with_log_sheets]" value="no" id="defibrillator_with_log_sheets2">
                                    <label for="defibrillator_with_log_sheets2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[defibrillator_with_log_sheets_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters:<br>
                                    We expect a practice to follow the national guidance issued by the <a href="http://www.resus.org.uk/pages/guide.htm" target="_blank">Resuscitation Council.</a> Immediate access to an automated external defibrillator (AED) in an emergency increases the chances of survival of the patient. Where an AED is not available, we would expect to see a robust and realistic risk assessment detailing how an AED could be accessed in a timely manner, as the emergency services may not always be able to respond in the critical first few minutes of an acute cardiac arrest.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Log:</span>
                            <input type="text" class="datepicker" name="form[defibrillator_with_log_sheets_date]">
                            <div class="file"><input type="file" name="defibrillator_with_log_sheets">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(153,$check)){ ?>
                    <div class="question">
                        <div class="numb">32.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have an oxygen cylinder with log sheets?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[oxygen_cylinder_with_log_sheets_id]" value="153">
                                    <input type="hidden" name="form[oxygen_cylinder_with_log_sheets_q]" value="Does the practice have an oxygen cylinder with log sheets?">
                                    <input type="radio" name="form[oxygen_cylinder_with_log_sheets]" value="yes" id="oxygen_cylinder_with_log_sheets">
                                    <label for="oxygen_cylinder_with_log_sheets">Yes</label>
                                    <input type="radio" name="form[oxygen_cylinder_with_log_sheets]" value="no" id="oxygen_cylinder_with_log_sheets2">
                                    <label for="oxygen_cylinder_with_log_sheets2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[oxygen_cylinder_with_log_sheets_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters:<br>
                                    Oxygen cylinders should be easily portable but also allow adequate flow rates, for example 15 litres per minute, until an ambulance arrives or the patient fully recovers. Consider what size of cylinder to use and whether you need a second one in case the first is at risk of running out.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Log:</span>
                            <input type="text" class="datepicker" name="form[oxygen_cylinder_with_log_sheets_date]">
                            <div class="file"><input type="file" name="oxygen_cylinder_with_log_sheets">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(154,$check)){ ?>
                    <div class="question">
                        <div class="numb">33.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have fire extinguishers?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[fire_extinguishers_id]" value="154">
                                    <input type="hidden" name="form[fire_extinguishers_q]" value="Does the practice have fire extinguishers?">
                                    <input type="radio" name="form[fire_extinguishers]" value="yes" id="fire_extinguishers">
                                    <label for="fire_extinguishers">Yes</label>
                                    <input type="radio" name="form[fire_extinguishers]" value="no" id="fire_extinguishers2">
                                    <label for="fire_extinguishers2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fire_extinguishers_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters<br>
                                    testing and maintenance of firefighting equipment(extinguishers)<br>
                                    testing and maintenance of all fire safety systems (fire alarms, emergency lighting, mains electrical wiring, gas safety certificate and PAT testing certificate)
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Date:</span>
                            <input type="text" class="datepicker" name="form[fire_extinguishers_date]">
                            <div class="file"><input type="file" name="fire_extinguishers">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(86,$check)){ ?>
                    <div class="question">
                        <div class="numb">34.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have emergency equipment in place with log sheets ?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[emergency_equipment_log_sheet_id]" value="86">
                                    <input type="hidden" name="form[emergency_equipment_log_sheet_q]" value="Does the practice have emergency equipment in place with log sheets ?">
                                    <input type="radio" name="form[emergency_equipment_log_sheet]" value="yes" id="emergency_equipment_log_sheet">
                                    <label for="emergency_equipment_log_sheet">Yes</label>
                                    <input type="radio" name="form[emergency_equipment_log_sheet]" value="no" id="emergency_equipment_log_sheet2">
                                    <label for="emergency_equipment_log_sheet2">No</label>
                                </div>



                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[emergency_equipment_log_sheet_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters:<br>
                                    The following is the minimum equipment recommended:<br>
                                    adhesive defibrillator pads<br>
                                    automated external defibrillator (AED)<br>
                                    clear face masks for self-inflating bag (sizes 0,1,2,3,4)<br>
                                    oropharyngeal airways sizes 0,1,2,3,4<br>
                                    oxygen cylinder<br>
                                    oxygen masks with reservoir<br>
                                    oxygen tubing<br>
                                    pocket mask with oxygen port<br>
                                    portable suction e.g. Yankauer<br>
                                    protective equipment – gloves, aprons, eye protection<br>
                                    razor<br>
                                    scissors<br>
                                    self-inflating bag with reservoir (adult)<br>
                                    self-inflating bag with reservoir (child)</div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Date:</span>
                            <input type="text" class="datepicker" name="form[emergency_equipment_log_sheet_date]">
                            <div class="file"><input type="file" name="emergency_equipment_log_sheet">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(90,$check)){ ?>
                    <div class="question">
                        <div class="numb">35.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have fire alarms with regular visual checks ?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[fire_alarms_with_regular_visual_checks_id]" value="90">


                                     <input type="hidden" name="form[fire_alarms_with_regular_visual_checks_q]" value="Does the practice have fire alarms with regular visual checks ?">

                                    <input type="radio" name="form[fire_alarms_with_regular_visual_checks]" value="yes" id="fire_alarms_with_regular_visual_checks">
                                    <label for="fire_alarms_with_regular_visual_checks">Yes</label>
                                    <input type="radio" name="form[fire_alarms_with_regular_visual_checks]" value="no" id="fire_alarms_with_regular_visual_checks2">
                                    <label for="fire_alarms_with_regular_visual_checks2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[fire_alarms_with_regular_visual_checks_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters:<br>
                                    testing and maintenance of firefighting equipment(extinguishers)<br>
                                    testing and maintenance of all fire safety systems (fire alarms, emergency lighting, mains electrical wiring, gas safety certificate and PAT testing certificate)
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Visual Date:</span>
                            <input type="text" class="datepicker" name="form[fire_alarms_with_regular_visual_checks_date]">
                            <div class="file"><input type="file" name="fire_alarms_with_regular_visual_checks">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(89,$check)){ ?>
                    <div class="question">
                        <div class="numb">36.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have emergency lighting ?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[emergency_lighting_id]" value="89">
                                    <input type="hidden" name="form[emergency_lighting_q]" value="Does the practice have emergency lighting ?">
                                    <input type="radio" name="form[emergency_lighting]" value="yes" id="emergency_lighting">
                                    <label for="emergency_lighting">Yes</label>
                                    <input type="radio" name="form[emergency_lighting]" value="no" id="emergency_lighting2">
                                    <label for="emergency_lighting2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[emergency_lighting_comment]" class="form-control"></textarea>
</div>


                                <div class="quest-hover">CQC Mythbusters:<br>
                                    testing and maintenance of firefighting equipment(extinguishers)<br>
                                    testing and maintenance of all fire safety systems (fire alarms, emergency lighting, mains electrical wiring, gas safety certificate and PAT testing certificate)
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="emergency_lighting">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php } 
if(!in_array(256,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAAA1VJREFUWEftmE9S2zAUxp/cRSnNDO4N0hMAywKZhBuUXRMW0BMUTlC4QThBk0WTJfQEpAO0S9ITkN5AzEBhAVY/WQ74jxw/Ow5DZ6ploj8/ve97T5IFPfMmnjkf/ZuAbu90i4SoFoqu8CS9rHTlxrIsND42KBFBt3+2TaS+TDW5oiG9er1eBqQF8GSPSHwmRbsk1DAfqMDmaMsfUxJkOiCpddmsDfIAuv1gc6QuscmFMiBnA6icDRIelKDFaSFnA4jo01xlSLfXWoGpINmAbu9H/UFupS7l5mrCnyGJH+zh9k87vi8LepIFaM/spEdtgHpT00DyAA/PXbq9WookDCSMl5E0wASkEh9tCtgSkgXIzeRHwIwRSknZqr3hzFs2YANe09mb3gRBCbEgm2usY5YFiAR5j7JxmLqqJ5a5krm9kwGO0Xq5gP2fVaI7fUrY21ylzT3WZgLI8Qq3z/MH7J804ME2JI5WhZQd8jzol5k/n7hRgl+l/FA7YPefmFOxP62nQVaSJBbASdOsubZ1XWyW61c9nhXBMiLhfj1bwvUN90yFhBM7srXW5cw7U0BXZ7+6ryMMugLAe5E2AmiHPPo2qUSVDojnwg6AtF8RKWbDyYLaOCQlfsnW6k54FAuQ8wwYF172cWdjV+o7jsBIpHmA5rIQ2Vl8fiTFnv6NB4gbt+c0aH5+RDfXx4i4KTlFAZlC+d0yj0X9HACc9h2uYccxb3ahhPbrQ2NFMBegKcR6YXvDc0C2Vo7c3lkbWR2rrWp/rMR4MAvQz0byzGstdWFt8JUjI/OpMpLRbyIHSaNQE702KaejkwA2SNkE7onN1U7uCGbL5sMMUduWA0D9HFgMINv4fVfXQV9W7eebqwtkraWQv3grm+9GuQHzSOwDJuR7lM4urYk2NgKloo0lcW5A3xL3F9FxeOl5jiRHnVvnw4cCALafBDCQWXsp7NtBsDj8F2/I7LlK1XZGzySCBtC/5MKL+MKQ1YLMtnWbAEiIgIgYNmud8f/IxH3jxYynghmQqH3hdWyAkGBCHeNQKnEwPlPNMYkSY4tkqF/atNaXVSAPJCrewh+ezK3mrqMfS/6Muj4Ktc35OMV6+hXHjI40BdqpxovxpPmfFLDIRv8DFolaeMxfKukuRwb3QbMAAAAASUVORK5CYII='); background-repeat: no-repeat; background-position: center;"></div>

                    <h3>Policies</h3>
                    <div class="question">
                        <div class="numb">37.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you and all staff have read, understood and signed the policies acknowledgement sheet
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[policies_acknowledgement_sheet_id]" value="256">
                                    <input type="hidden" name="form[policies_acknowledgement_sheet_q]" value="Do you and all staff have read, understood and signed the policies acknowledgement sheet">
                                    <input type="radio" name="form[policies_acknowledgement_sheet]" value="yes" id="policies_acknowledgement_sheet">
                                    <label for="policies_acknowledgement_sheet">Yes</label>
                                    <input type="radio" name="form[policies_acknowledgement_sheet]" value="no" id="policies_acknowledgement_sheet2">
                                    <label for="policies_acknowledgement_sheet2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[policies_acknowledgement_sheet_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Review Date:</span>
                            <input type="text" class="datepicker" name="form[policies_acknowledgement_sheet_date]">
                            <div class="file"><input type="file" name="policies_acknowledgement_sheet">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(285,$check) || !in_array(260,$check) || !in_array(262,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABbFJREFUWEftWE1sVFUUPuc+7LS1OOOGKGqEWKUuDEVNiDKlqBsSNxIl0JEYCyasanCjCGo0KpigkQUJGP9iojNi1GK6Mm5KZzQlMRZ3XUigC4MLDDOatjPI3ON338/0vTfvzU8tQow3aaYz83rPd7/zne+cW6ZrfPE1jo/+WwCT2cL7TPIoEaeEpIOZLRIq4v1UlfQrf2YGCkudkZYYTGUn9gipgwg+LaLGWInFQg8YMNriAmu9kkSeZlITxcyGh9sFmczlv2ZRKfN3ouW90o70cW+PpgCTucIHYOlJbHCIWI9AFPZG/iVEl6lKb5OizfjpKW1P39kOyFSugC2cJSK/lTIDN7cE0GNOiN9hln0s+g9iPi1Ca5Dem3Dckv2e+Fac9A5E+QUS+FWEk6VMel2rIP0AzZ7FzMYaCbEMdn710+2Jytx0Vamnlon+wpwMoKbBZr8wXdAiw0rzLWTRm+bg0OEMwD2CX0+Chn589ioCHW4F5KIAmtQiYC9CrwVLKZzsOWL1bii3RYDtwSmXAeGHeN1lp4n0MRbeXswM3HjlAGbz5yHYA2yptaLpkrBkLeZ8XEA/QMMi0ry+kujuKz9+70wzkIti8Ibs928w6RVgbxgBZlAE+0nJYVt7EQs6/BKMP+EoXZeE1QVo9kgraW4LoNFeZ2X+YzC2yRSFJuuIInrQvEfoj7w0BqoY+sRBZk2heABN8UCLJ5YUYPLTwjaIPucBYy0W3r+AwE4xuTpEwcCX+RC+2+pUr5xikT5oNOlokM7gZRysf+f3tLhUt8wgHpxD8G/hQ1tgMUXR6ih6xd7axh5AFAQ+2wmdHVAs++0KJ+mCmSdE6+eVsrbAwvtwrq4gKP0apDCIZ0/6mW0HoFRFBkzLQlubIqVOka7uhu6cOFq9Tkq/DBDHWaltTjFQGt+MAcxm45cGcHxRuBaE9BeHBoxk7NUyQAMKUNaUE913X1eZvc0ygZl+RvBBZyunOpHqbxYA8nq7y6jqRgDcYCynXYAoyBG0z02kRYHdh2KN2jNnPHQRHrbSZpHkHAR/j1cAWvhZ+NyUsRwo8S2yuBf6wwCh99X5ZB3SBQZtMzeadbuRTYKRkGPw8Z3EATl7xhRBpav7mOkmYPEzKP8+ZLofBYCCpjI+g+bQg7FsozZgleytySGSxugU93z+w1ZLVzMAfBnAe/1tMrLV2almKRmduIAn8SCkJweR2p3wx9VIZxJMl/A6j+JAF9ErcIC7FuQQhTAaoNO1aBf0XA6beyTAVC4/brb3CxkWBHAyAgCwRZ5cCC/rYDPLAa5QFXopstuYNBoFwxXMxIPDfBL2R2NxyNhkuPO0DNADtDybT2NKvd+zCwQ97/c6sIGJxjVsAwqpx/cvxheOW8mwNVd/gQGjbYBeIAD5C0a8I2zE9gF8Pbs4lG46c9pWs9QAbe9C1UW1sgCLMc+EGf1XAQZYxJ2lmEk3HbvaAmgCmBM2ugQ1YtD8bbsstgUwlc1fFObfS0Pp3jhxNwPoZzF8z4jas+UqNvcQryN4fTlqw2YAbRazhXnYT6f5vdzRvSpueLW99tLcWfjqhN/a3CYQDB+0CUwdvqbuf7I1gPlRdJbHbA/EBISMPBN9WOO7PGi6VKWje7X/IHUWULuL2LvGD5zJbH60krh+T6OR3p8NdInTcTc9Y1nekBE+SD1AZ6JZ5Z76XNSmjlnzGHxm3MyOcToNVnPwOhnIhpGVu6rEP/qLsw6gXU3uZBy+o9ZMGhcqczcxKUHa0PriV23WC9136+RS+yAoq8UBzBW0/xrQ6N7h2gc0qM7GpTgwsJpp26f7RQG0teWucqJnNEqHxjZY8e4wt+VE13D4+aUHGPxfyokoHaKIbBnUJ7/eGa4oQHMNiLIip4Idi/EvqfLR8ICxaIBxHSD036i2GMSedc+3BbBRRV6N71qa1a4GMC/m/wD/Kft/A+ZAyVasY2SvAAAAAElFTkSuQmCC'); background-repeat: no-repeat; background-position: center;"></div>
                    <h3>Practice Signages</h3>
                    <?php if(!in_array(285,$check)){ ?>
                    <div class="question">
                        <div class="numb">38.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have the following signs displayed in the reception area:<br>
                                    Privacy Policy,<br>
                                    Confidentiality Policy,<br>
                                    Complaint Policy,<br>
                                    Location of medical emergency drugs,<br>
                                    Fire Evacuation Plan,<br>
                                    Safeguarding flowchart,<br>
                                    GDC Standards,<br>
                                    No Smoking Sign,<br>
                                    Sepsis Chart
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[signs_displayed_in_the_reception_area_id]" value="285">

                                     <input type="hidden" name="form[signs_displayed_in_the_reception_area_q]" value="Do you have the following signs displayed in the reception area:<br>
                                    Privacy Policy,<br>
                                    Confidentiality Policy,<br>
                                    Complaint Policy,<br>
                                    Location of medical emergency drugs,<br>
                                    Fire Evacuation Plan,<br>
                                    Safeguarding flowchart,<br>
                                    GDC Standards,<br>
                                    No Smoking Sign,<br>
                                    Sepsis Chart">


                                    <input type="radio" name="form[signs_displayed_in_the_reception_area]" value="yes" id="signs_displayed_in_the_reception_area">
                                    <label for="signs_displayed_in_the_reception_area">Yes</label>
                                    <input type="radio" name="form[signs_displayed_in_the_reception_area]" value="no" id="signs_displayed_in_the_reception_area2">
                                    <label for="signs_displayed_in_the_reception_area2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[signs_displayed_in_the_reception_area_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Completion Log:</span>
                            <input type="text" class="datepicker" name="form[signs_displayed_in_the_reception_area_date]">
                            <div class="file"><input type="file" name="signs_displayed_in_the_reception_area">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(260,$check)){ ?>
                    <div class="question">
                        <div class="numb">39.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have the following signs displayed in the decontamination area:<br>
                                    Sharp’s flowchart<br>
                                    Handwash Protocol<br>
                                    Waste Disposal<br>
                                    Location of medical emergency drugs<br>
                                    Clean to Dirty area workflow
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[signs_displayed_in_the_decontamination_area_id]" value="260">

                                     <input type="hidden" name="form[signs_displayed_in_the_decontamination_area_q]" value="Do you have the following signs displayed in the decontamination area:<br>
                                    Sharp’s flowchart<br>
                                    Handwash Protocol<br>
                                    Waste Disposal<br>
                                    Location of medical emergency drugs<br>
                                    Clean to Dirty area workflow">
                                    <input type="radio" name="form[signs_displayed_in_the_decontamination_area]" value="yes" id="signs_displayed_in_the_decontamination_area">
                                    <label for="signs_displayed_in_the_decontamination_area">Yes</label>
                                    <input type="radio" name="form[signs_displayed_in_the_decontamination_area]" value="no" id="signs_displayed_in_the_decontamination_area2">
                                    <label for="signs_displayed_in_the_decontamination_area2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[signs_displayed_in_the_decontamination_area_comment]" class="form-control"></textarea>
</div>


                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="signs_displayed_in_the_decontamination_area">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(262,$check)){ ?>
                    <div class="question">
                        <div class="numb">40.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you have the following signs displayed in the surgery area:<br>
                                    Clean to dirty Area<br>
                                    Local rules<br>
                                    Location of medical emergency drugs<br>
                                    Needlestick Injury flowchart
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[signs_displayed_in_the_surgery_area_id]" value="262">

                                    <input type="hidden" name="form[signs_displayed_in_the_surgery_area_q]" value="Do you have the following signs displayed in the surgery area:<br>
                                    Clean to dirty Area<br>
                                    Local rules<br>
                                    Location of medical emergency drugs<br>
                                    Needlestick Injury flowchart">


                                    <input type="radio" name="form[signs_displayed_in_the_surgery_area]" value="yes" id="signs_displayed_in_the_surgery_area">
                                    <label for="signs_displayed_in_the_surgery_area">Yes</label>
                                    <input type="radio" name="form[signs_displayed_in_the_surgery_area]" value="no" id="signs_displayed_in_the_surgery_area2">
                                    <label for="signs_displayed_in_the_surgery_area2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[signs_displayed_in_the_surgery_area_comment]" class="form-control"></textarea>
</div>


                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="signs_displayed_in_the_surgery_area">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                    <hr>
                </div>
                <!-- quest-box -->
                <?php }
if(!in_array(170,$check) || !in_array(264,$check) || !in_array(175,$check) || !in_array(43,$check) || !in_array(123,$check)|| !in_array(176,$check) || !in_array(132,$check) || !in_array(177,$check) || !in_array(105,$check)){ $fchk1 = "true"; ?>
                <div class="quest-box">
                    <div style="position: absolute; left: 0; top: 0; border-radius: 50%; height: 86px; width: 86px; background-color: #fff; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAABHNCSVQICAgIfAhkiAAABQpJREFUWEfVWE1sVFUUvue90inFMq8LTECJgBAhhkRMjD+dUnHjwoVVidppE2pqJKxQI0YWJiQuMGpSQ0xYaP1JOjPVSHSha6wzhJgQYQEJi2I1IZq4kJlqcQY69/id++ZNXqczbx6vM6XO5s277/589zvnfPecS2qV/2iV41P/T4DxTO4TYtrWKnZZ80+FkcTRKPPVZdBJ/5hXZMWjTNhoDCs1URhKvHyrczYByNO3OqG/P7NKVN5tIlJRQAYCzA8lluWjxhL4sbYOKounooBcEYD55F4nPpl7IQrIFQMoTEYBuQIArU7F9Jbnm2zzALF6Vt7DuFD7AQaowW0HKCYlS29cogRkjbecQSeT+wgysSNIdqBzT4aRJcyFqVps4ng6+xdkojcIQN6+2aOe3/dPM5BtAbg+nZuE1t7XhMGHmoGT720BGGbhsH1WHUAnlT2soNLG74b7TuCEedX8T+79sNmm2iozJoptNbUEBKt/WfFkIdn/SssAIkj+JEUblkoGQ3D7626069TP93QWi2Nk6/tJUy9bfI3L1iVIzybFPKoIkl1WI0jFvmwENDSDTjp3DemtU2+ieoIbT+c+Rv9RLNDBzGXkMm50Q7hh6wUA/AxvG6AMg0FZTmiAzUwhbBWfe/A3eXaV5s9i0Y2I+uli57oD0u6Nl++xG9ffBsAxLP4Hk3UG4PdzWb1Yj8mWAKwsOkOsj4CiN1lRbynWvdMPrHaDZkzp+mWwfBVgL8LcT5c6u7fWjmkJQCeT/QGLPABgpwFkUGkybEBOTiNLfTifTHR7AFFO3EQ5kc0n+55wQc7/CnAT2Nx+PC/Anx/3byY0QPjUZZjibv9gmFEjEtfLonD2D5St3gDQ79D2jAGtaED6ez5mah2lxkwb87fST9rwesAbj+NyTTSAqewcWdSzCCByemHLSAnr18DgeCm2bsua0vxm5PhZry+6FQvJxFoowQKCwvbay8z9fyf7cyLc4oMyj9fm9QnNIMR1kC26c5EvaYiH0neg7ZiYR8ws2fMi9oDuht2RiJX1OwsWnbR1+StJ/f0sSmmAYPkaVA9jvqN+AQ8NsFEUe/7nB2jMJouR6gKzBTD7O0DtgmGnZRNGasAqAiQllZ5bRbobRP1y0l+iLhsgTovjEN5DfoC1m6kcbcekeKonJYZBBBh8fJ9YIxKD8alcijRv8RbXimbnkokRU2fYKoMofB3MjNeKtoCD+d6XyAWDjxRj3btqpQSMawTJkPhgrR6GZhBRPAeTVYMEJpqD45viHs7P2L0JEgTNu34TOeksTiCqnkAIqysw6/aq7MACyCOOYNwwnilEdkekKHYyZyaY9dZqdBH9ArbMTQEYmJEnQF4FyD4I7nZhyZi2kt77F/VHqpEoSBM2sVvGR9bBRkEi7T3pbMJSKuuyaB2HWdgzpatz/Bgxb8K3WUTpF34fM2M13SU1s0hUW06Sipm/keOKmQ4D6Hugs0MSgmYpVeWYnMUcn9a7uwntg0EMVv3JNfU21+H5EPx0AKAXkFQhk6HzTLxZPMHzwUqATUKSLsKf99RbI/jyCKleEDBExqnaXbsayGMANqOZX4L5ngLYR715kHid1RZ/byk6AdPvkXM46NZrmddvPF3r1FWfJPocQO/1M4hzcScIdJBNr0X7FWxgVI66IBLqAmxYcNfMVFZ0rtkCRgeRNECi3JIVSUKYWqSqFmF863b2Wdb930oAX/UA/wNO+gZW9XLzDAAAAABJRU5ErkJggg=='); background-repeat: no-repeat; background-position: center;"></div>

                    <h3>Practice</h3>
                    <?php if(!in_array(170,$check)){ ?>
                    <div class="question">
                        <div class="numb">41.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice hold regular monthly staff meetings ?
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[regular_monthly_staff_meetings_id]" value="170">
                                    <input type="hidden" name="form[regular_monthly_staff_meetings_q]" value="Does the practice hold regular monthly staff meetings ?">
                                    <input type="radio" name="form[regular_monthly_staff_meetings]" value="yes" id="regular_monthly_staff_meetings">
                                    <label for="regular_monthly_staff_meetings">Yes</label>
                                    <input type="radio" name="form[regular_monthly_staff_meetings]" value="no" id="regular_monthly_staff_meetings2">
                                    <label for="regular_monthly_staff_meetings2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[regular_monthly_staff_meetings_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <span>Last Meeting Date:</span>
                            <input type="text" class="datepicker" name="form[regular_monthly_staff_meetings_date]">
                            <div class="file"><input type="file" name="regular_monthly_staff_meetings">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(264,$check)){ ?>
                    <div class="question">
                        <div class="numb">42.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Is there a radiation protection documents (file/folder) in place ? (radiation risk assessment, local rules, radiation training log, equipment inventory)
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[radiation_protection_documents_id]" value="264">
                                    <input type="hidden" name="form[radiation_protection_documents_q]" value="Is there a radiation protection documents (file/folder) in place ? (radiation risk assessment, local rules, radiation training log, equipment inventory)">
                                    <input type="radio" name="form[radiation_protection_documents]" value="yes" id="radiation_protection_documents">
                                    <label for="radiation_protection_documents">Yes</label>
                                    <input type="radio" name="form[radiation_protection_documents]" value="no" id="radiation_protection_documents2">
                                    <label for="radiation_protection_documents2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[radiation_protection_documents_comment]" class="form-control"></textarea>
</div>


                                <div class="quest-hover">How do you put arrangements for radiation protection into practice?<br>
                                    Have you consulted a radiation protection adviser (RPA) and medical physics expert (MPE)? The same person may fulfill both roles.<br>
                                    Have you documented the arrangements for radiation protection, for example, in a radiation file or folder?<br>
                                    Does an appropriately trained staff member do a walk about visual inspection of X-ray sets to identify any safety faults?<br>
                                    Which staff are involved in taking X-rays and are they trained?<br>
                                    Have staff been trained according to current professional guidelines?</div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="radiation_protection_documents">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(175,$check)){ ?>
                    <div class="question">
                        <div class="numb">43.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Is there an accident/incident log book present ?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[accident/incident_log_book_present_id]" value="175">
                                    <input type="hidden" name="form[accident/incident_log_book_present_q]" value="Is there an accident/incident log book present ?">
                                    <input type="radio" name="form[accident/incident_log_book_present]" value="yes" id="accident/incident_log_book_present">
                                    <label for="accident/incident_log_book_present">Yes</label>
                                    <input type="radio" name="form[accident/incident_log_book_present]" value="no" id="accident/incident_log_book_present2">
                                    <label for="accident/incident_log_book_present2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[accident/incident_log_book_present_comment]" class="form-control"></textarea>
</div>


                                <div class="quest-hover">An employer must<br>
                                    record a sharps injury when they are notified of it, whoever provides that notification<br>
                                    investigate the circumstances and causes of the incident, and<br>
                                    take any action required
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="accident/incident_log_book_present">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(43,$check)){ ?>
                    <div class="question">
                        <div class="numb">44.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Do you offer sedation within the practice, if yes is there a protocol in place ?
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[sedation_within_the_practice_id]" value="43">
                                    <input type="hidden" name="form[sedation_within_the_practice_q]" value="Do you offer sedation within the practice, if yes is there a protocol in place ?">
                                    <input type="radio" name="form[sedation_within_the_practice]" value="yes" id="sedation_within_the_practice">
                                    <label for="sedation_within_the_practice">Yes</label>
                                    <input type="radio" name="form[sedation_within_the_practice]" value="no" id="sedation_within_the_practice2">
                                    <label for="sedation_within_the_practice2">No</label>
                                </div>


                                
                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[sedation_within_the_practice_comment]" class="form-control"></textarea>
</div>


                                <div class="quest-hover">CQC Mythbusters:<br>
                                    The SAAD checklist includes:<br>
                                    General - the type of sedation provided and to what group of patients.<br>
                                    Facilities - ease of access for emergencies services, recovery area and functionality of the dental chair.<br>
                                    Sedation practice and procedure - sedation protocol in place, patient assessment, discharge protocols, emergency contact details and ‘titrating to response’ approach.<br>
                                    Documentation - pre and post-operative patient instructions, patient assessment, contemporaneous record of sedation procedure and consent process.<br>
                                    Practices providing inhalation sedation (RA)-dedicated RA machine which is adequately serviced, maintained and checked and active scavenging system in place where appropriate.<br>
                                    Other equipment - pulse oximeter, blood pressure monitoring machine, supplemental oxygen and emergency medicines in line with BNF guidelines and emergency equipment in line with Resuscitation Council UK recommendations.<br>
                                    Sedative agents - standard operating procedures for sedative agents and reversal agents including labelled syringes, stock control, storage and disposal.<br>
                                    Staffing - competency, maintaining competency, staffing ratios and emergency training.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="sedation_within_the_practice">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(123,$check)){ ?>
                    <div class="question">
                        <div class="numb">45.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Is there a protocol for treating patient with Sepsis (Sepsis policy, flowchart, staff aware of procedure)
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[treating_patient_with_Sepsis_id]" value="123">
                                    <input type="hidden" name="form[treating_patient_with_Sepsis_q]" value="Is there a protocol for treating patient with Sepsis (Sepsis policy, flowchart, staff aware of procedure)">
                                    <input type="radio" name="form[treating_patient_with_Sepsis]" value="yes" id="treating_patient_with_Sepsis">
                                    <label for="treating_patient_with_Sepsis">Yes</label>
                                    <input type="radio" name="form[treating_patient_with_Sepsis]" value="no" id="treating_patient_with_Sepsis2">
                                    <label for="treating_patient_with_Sepsis2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[treating_patient_with_Sepsis_comment]" class="form-control"></textarea>
</div>




                                <div class="quest-hover">CQC Mythbusters<br>
                                    We will ask staff what systems and processes are in place to manage, follow up and refer patients for specialist care when presenting with bacterial infections.<br>
                                    This includes:<br>
                                    treating patients who:<br>
                                    are not responding to conventional oral antibiotic treatment<br>
                                    cannot have their infection drained at an initial appointment<br>
                                    what advice is given to patients, including when they should seek emergency advice or treatment if symptoms worsen or when the dental surgery is closed.<br>
                                    For example: We may ask staff to describe a typical patient journey if a patient has an acute infection associated with a partially erupted lower wisdom tooth and possible limited opening of the jaw. In addition, we may ask to see dental care records to assess how a practice has dealt with previous cases in which a patient has presented with bacterial infection.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="treating_patient_with_Sepsis">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(176,$check)){ ?>
                    <div class="question">
                        <div class="numb">46.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have a process for taking consent from their patient (i.e policy, consent forms )
                                </div>
                                <span><i class="fa fa-info-circle"></i></span>
                                <div class="inputs">
                                    <input type="hidden" name="form[consent_from_their_patient_id]" value="176">
                                    <input type="hidden" name="form[consent_from_their_patient_q]" value="Does the practice have a process for taking consent from their patient (i.e policy, consent forms )">
                                    <input type="radio" name="form[consent_from_their_patient]" value="yes" id="consent_from_their_patient">
                                    <label for="consent_from_their_patient">Yes</label>
                                    <input type="radio" name="form[consent_from_their_patient]" value="no" id="consent_from_their_patient2">
                                    <label for="consent_from_their_patient2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[consent_from_their_patient_comment]" class="form-control"></textarea>
</div>



                                <div class="quest-hover">CQC Mythbusters<br>
                                    We review the practice’s systems and processes for obtaining consent. We may ask dental practitioners and other dental care professionals to describe how and why they ask for consent. We may look at an example of a dental care record to support what we are told.
                                </div>
                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="consent_from_their_patient">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(132,$check)){ ?>
                    <div class="question">
                        <div class="numb">47.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Does the practice have a COSHH Assessment folder for hazard substances
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[COSHH_Assessment_folder_for_hazard_substances_id]" value="132"><input type="hidden" name="form[COSHH_Assessment_folder_for_hazard_substances_q]" value="Does the practice have a COSHH Assessment folder for hazard substances">
                                    <input type="radio" name="form[COSHH_Assessment_folder_for_hazard_substances]" value="yes" id="COSHH_Assessment_folder_for_hazard_substances">
                                    <label for="COSHH_Assessment_folder_for_hazard_substances">Yes</label>
                                    <input type="radio" name="form[COSHH_Assessment_folder_for_hazard_substances]" value="no" id="COSHH_Assessment_folder_for_hazard_substances2">
                                    <label for="COSHH_Assessment_folder_for_hazard_substances2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[COSHH_Assessment_folder_for_hazard_substances_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="COSHH_Assessment_folder_for_hazard_substances">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(177,$check)){ ?>
                    <div class="question">
                        <div class="numb">48.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Is there a procedure for patient to provide feedback on the service they have received
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[patient_to_provide_feedback_id]" value="177">
                                    <input type="hidden" name="form[patient_to_provide_feedback_q]" value="Is there a procedure for patient to provide feedback on the service they have received">
                                    <input type="radio" name="form[patient_to_provide_feedback]" value="yes" id="patient_to_provide_feedback">
                                    <label for="patient_to_provide_feedback">Yes</label>
                                    <input type="radio" name="form[patient_to_provide_feedback]" value="no" id="patient_to_provide_feedback2">
                                    <label for="patient_to_provide_feedback2">No</label>
                                </div>

                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[patient_to_provide_feedback_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="patient_to_provide_feedback">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php }
if(!in_array(105,$check)){ ?>
                    <div class="question">
                        <div class="numb">49.</div>
                        <div class="quest">
                            <div class="quest-inner">
                                <div class="q">
                                    Is there a clear complaint procedure for patient (complaint policy on display or in patient information folder)
                                </div>
                                <div class="inputs">
                                    <input type="hidden" name="form[complaint_procedure_for_patient_id]" value="105">
                                    <input type="hidden" name="form[complaint_procedure_for_patient_q]" value="Is there a clear complaint procedure for patient (complaint policy on display or in patient information folder)">
                                    <input type="radio" name="form[complaint_procedure_for_patient]" value="yes" id="complaint_procedure_for_patient">
                                    <label for="complaint_procedure_for_patient">Yes</label>
                                    <input type="radio" name="form[complaint_procedure_for_patient]" value="no" id="complaint_procedure_for_patient2">
                                    <label for="complaint_procedure_for_patient2">No</label>
                                </div>


                                <br>
<br>
<div class="quest-hoverComments">Type Comment:<br><br>
<textarea name="form[complaint_procedure_for_patient_comment]" class="form-control"></textarea>
</div>



                            </div>
                        </div>
                        <div class="sh">
                            <div class="file"><input type="file" name="complaint_procedure_for_patient">
                                <i class="fas fa-paperclip"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>
                    <!-- question -->
                    <?php } ?>
                    <input class="submit_class" type="submit" value="Save">
                </div>
                <!-- quest-box -->
                <?php } ?>
            </form>
            <?php
        }
   if($fchk1 == "false"){
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
    </div>
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
        $(this).parents('.question').find('.sh').css("display", "inline-block");
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
<?php include_once('footer.php'); ?>