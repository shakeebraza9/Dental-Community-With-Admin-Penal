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
    
    echo '<script>alert("'.$key.'")</script>';
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
    
    if($dbF->rowCount > 0){
        $sql = "UPDATE accounts_user set health_form = '1' where acc_id = $userid";
        $dbF->setRow($sql);
    }
    
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

// $to = $functions->ibms_setting('Email');
$to = 'basitabbas2001@gmail.com';

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


// $sql = "SELECT id_user from accounts_user_details where setting_val = 'Trial'";
// $data = $dbF->getRow($sql);

if($pMmsg!=''){

echo "<div class='alert alert-info'>$pMmsg <a href='./main_dashboard'>You can now view your practice compliance health on the dashboard.</a> </div>";

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
                                    <input type="radio" name="form[disability_access_audit]" value="no" id="disability_access_audit2" checked>
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
                                    <input type="radio" name="form[cross_infection_audit]" value="no" id="cross_infection_audit2" checked>
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
                                    <input type="radio" name="form[radiography_audit]" value="no" id="radiography_audit2" checked>
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
                                    <input type="radio" name="form[record_keeping_audit]" value="no" id="record_keeping_audit2" checked>
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
                                    <input type="radio" name="form[waste_acceptance_audit]" value="no" id="waste_acceptance_audit2" checked>
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
 ?>
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