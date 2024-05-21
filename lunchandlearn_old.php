<?php
ob_start();

include_once("global.php");
global $webClass;
?>


<h1 style="text-align: center;"></h1>


<?php

$pMmsg = '';

$contactAllow = true;

if(isset($_POST) && !empty($_POST)){

 if (isset($_POST['g-lunchandlearn'])) {
    $captcha = $_POST['g-lunchandlearn'];
} else {
    $captcha = false;
}

if (!$captcha) {
  $pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
    $contactAllow = false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
         $pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
    $contactAllow = false;
    }else{


if($functions->getFormToken('lunchandlearn')){

$img="";

$msg='<table border="1">';

foreach($_POST['form'] as $key=>$val){

$msg.= '

<tr>

<td>'.ucwords(str_replace("_"," ",$key)).'</td>

<td>'.$val.'</td>

</tr>';

}


//saadkhan4069@gmail.com


$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

$msg.='</table>';
 
$to = $functions->ibms_setting('email');
// $to = "saadkhan4069@gmail.com";

$functions->send_mail($to,'Lunch And Learn',$msg);

$nameUser =  $_POST['form']['Name-Of-Practice'];
$numberofdelegates =  $_POST['form']['Number-Of-Delegates'];
$bestday =  $_POST['form']['Best-Day'];
$besttime =  $_POST['form']['Best-time'];
$Nameofpractice =  $_POST['form']['Name-Of-Practice'];
$nameofpracticemanager =  $_POST['form']['Name-Of-Practice-Mmanager'];
$practiceaddress =  $_POST['form']['Practice-Address'];
$practicecontact =  $_POST['form']['Practice-Contact'];
$email =  $_POST['form']['email'];
$Lunchcomment =  $_POST['form']['Lunch-Comment'];
$radios =  $_POST['form']['Is-there-a-plain-wall'];
$radios2 =  $_POST['form']['Would-you-like-a-FREE-Mock-Audit'];



 $sql   =   "INSERT INTO `lunchandlearn` ( `number_of_delegates`, `best_day`,`best_time`, `name_of_practice`, `name_of_practice_manager`, `practice_address`, `practice_contact`, `email`, `lunch_comment`, `Is_there_a_plain_wall`, `would_you_like_a_free_mock_audit`,`approved`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)  ";

$arry  =   array($numberofdelegates,$bestday,$besttime,$Nameofpractice,$nameofpracticemanager,$practiceaddress,$practicecontact,$email,$Lunchcomment,$radios,$radios2,"0");

$dbF->setRow($sql,$arry);
//('$numberofdelegates','$bestday','$Nameofpractice','$nameofpracticemanager','$practiceaddress','$practicecontact','$email','$Lunchcomment','$radios','$radios2')

$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','lunchandlearn',$nameUser)){

$pMmsg = "$thankT";

} else {

$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);

$pMmsg = "$errorT";

}

$contactAllow = false;

}else{

$contactAllow = true;

}
}
}

if($pMmsg!=''){
echo "<div class='alert alert-info'>$pMmsg</div>";
}

}

if($contactAllow){

$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";

?>
         <div  class="inner_content">
             <img class="lunchandlearnIMG" alt="" src="<?php echo WEB_URL ?>/images/download.png" />
            <div class=" wow fadeInUp lunchandlearnDIV" style="visibility: visible;animation-name: fadeInUp;">
                
                
                
                
                
                <div class="standard">
                    <div class="webin">
                        <h2>Lunch and Learn Details</h2>
                        <div class="contact_right req">
                            <div class="form_1_">
                                <form method="post" autocomplete="No" enctype="multipart/form-data" >
                                    <?php $functions->setFormToken('lunchandlearn'); ?>
                                   
                         <input type="hidden" id="g-lunchandlearn" name="g-lunchandlearn">
    <input type="hidden" name="action" value="lunchandlearn">

                                    <div class="form_1_side_">Number of delegates</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Number-Of-Delegates]" placeholder="Number of delegates " required>
                                    </div>
                                    
                                    <div class="form_1_side_"> Best day to Host a Lunch & Learn  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Best-time]" placeholder="Best day for Lunch & Learn" required>
                                    </div>
                                    <div class="form_1_side_"> Best time for Lunch & Learn  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         <input type="time" name="form[Best-Day]" placeholder="Best day to Host a Lunch & Learn" required>
                                    </div>

                                    <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Name-Of-Practice]" placeholder="Name of the practice" required>
                                    </div>

                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" min="1" max="10" name="form[Name-Of-Practice-Mmanager]" placeholder="Name of the practice manager" required>
                                    </div>

                                    <div class="form_1_side_">Practice Address </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Practice-Address]" placeholder="Practice Address" required>
                                    </div>

                                    <div class="form_1_side_">Practice Contact Number</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Practice-Contact]" placeholder="Enter your email" required>
                                    </div>

                                   
                                    <div class="form_1_side_">Email Address </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="email" name="form[email]" placeholder="Enter your Email">
                                    </div>

                                   

                                    <div class="form_1_side_">Lunch Preference Comment:</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <textarea name="form[Lunch-Comment]" placeholder="Add Relevant Details" required></textarea>
                                    </div>
                                     <div class="form_1_side_">
                                       
                                     </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                       Is there a plain wall where the trainer can project the PowerPoint – <br>

                                    </div> 
                                <div class="form_1_side_">
                                       
                                     </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         Yes
                                        <input type="radio" value="true" name="form[Is-there-a-plain-wall]" placeholder="Yes" required>
                                        No
                                        <input type="radio" value="false" name="form[Is-there-a-plain-wall]" placeholder="No" required>
                                    </div>
                                     <div class="form_1_side_">
                                       
                                     </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                     
Would you like a FREE Mock Audit before the training (please note the compliance champion would need 30 minutes to go through this audit with a team member before the lunch and learn session)
                                    </div> 
                                <div class="form_1_side_">
                                       
                                     </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         Yes
                                        <input type="radio" value="1" name="form[Would-you-like-a-FREE-Mock-Audit]" placeholder="Yes" required>
                                        No
                                        <input type="radio" value="0" name="form[Would-you-like-a-FREE-Mock-Audit]" placeholder="No" required>
                                    </div>
                            <!--         <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                               <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>                                
                                    <div class="form_1_side_"></div>
                                    <div class="form_2_side_ form_1">
                                        <input type="submit" class="submit_side" value="Submit">
                                    </div>
 
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- webin close -->
                </div>
                <!-- standard close -->
            </div>
            <br>
            <br>
            <br>        
    </div>
<?php
}
?>

<?php return ob_get_clean(); ?>