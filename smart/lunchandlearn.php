<?php
ob_start();

include_once("global.php");
global $webClass;
?>


<h1 style="text-align: center;"></h1>


<?php

$pMmsg = '';

$contactAllow = true;

if(!empty($_POST)){

 if (isset($_POST['g-lunchandlearn'])) {
    $captcha = $_POST['g-lunchandlearn'];
}
//else {
//     $captcha = false;
// }

if (!$captcha) {
  $pMmsg = $dbF->hardWords('Somthing Went Wrong. Please Try Again...',false);
    // $contactAllow = false;
} else {
    
    
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
         $pMmsg = $dbF->hardWords('Somthing Went Wrong. Please Try Again...',false);
    // $contactAllow = false;
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


$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

$msg.='</table>';
 
            // $to = $this->functions->ibms_setting('Email');
$to ="booking@smartdentalcompliance.com";


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
$radios3 =  $_POST['form']['Are-you-currently-using-a-compliance-software'];



 $sql   =   "INSERT INTO `lunchandlearn` ( `number_of_delegates`, `best_day`,`best_time`, `name_of_practice`, `name_of_practice_manager`, `practice_address`, `practice_contact`, `email`, `lunch_comment`, `Is_there_a_plain_wall`, `would_you_like_a_free_mock_audit`,`Are_you_currently_using_a_compliance_software`,`approved`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)  ";

$arry  =   array($numberofdelegates,$bestday,$besttime,$Nameofpractice,$nameofpracticemanager,$practiceaddress,$practicecontact,$email,$Lunchcomment,$radios,$radios2,$radios3,"0");

$dbF->setRow($sql,$arry);
//('$numberofdelegates','$bestday','$Nameofpractice','$nameofpracticemanager','$practiceaddress','$practicecontact','$email','$Lunchcomment','$radios','$radios2')

$thankT = $dbF->hardWords('Thank you for booking  Lunch and Learn with us, one of our representative would get in touch in order to confirm your booking.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($email,'','','lunchandlearn',$nameUser)){

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



}

if(true){

$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";

?>
       <div class="standard">
            <div class="LunchMain m-y-50">
                <div class="LunchfirstSec">
                    <h1>Aims</h1>
                    <p>Provide you the team of knowledge and understanding of compliance management</p>
                    <h1>Learning Objective</h1>
                    <ul>
                        <li>
                            <p>Learn to manage compliance within your Dental practice.</p>
                        </li>
                        <li>
                            <p>What are the key lines of enquiry and how to implement them.</p>
                        </li>
                        <li>
                            <p>Staff awareness and responsible in managing compliance activities.</p>
                        </li>
                        <li>
                            <p>Significance of Clinical Audits, Logs, Risk Assessment & Policies.</p>
                        </li>
                        <li>
                            <p>Being prepared for a CQC inspection.</p>
                        </li>
                    </ul>
                    <h1>GDC Outcome</h1>
                    <p>A, B, D</p>
                </div>
                <div class="LunchsecondSec">
                    <div class="SndSecInnerdiv">
                        <h1>Fill in the required information</h1>
                        <p>If you have an enquiry about the compliance services we can offer to your practice, please get in touch. A compliance advisor will arrange a consultation and talk through your needs.</p>
                        <?php
                            if($pMmsg!=''){
                            echo "  <div  class='inner_content'>
                                        <div class='standard'>
                                            <br><div class='alert alert-info'>
                                                $pMmsg
                                            </div>
                                        </div>
                                    </div>";
                            }
                        ?>
                         <form method="post" autocomplete="No" enctype="multipart/form-data" >
                                    <?php $functions->setFormToken('lunchandlearn'); ?>
                                   
                                    <input type="hidden"  class="g-lunchandlearn" id="g-lunchandlearn" name="g-lunchandlearn">
                                     <input type="hidden" name="action" value="lunchandlearn">

                            <div class="flexdiv">
                                <input type="text" name="form[Number-Of-Delegates]" value="<?php echo @$_POST['form']['Number-Of-Delegates']; ?>" placeholder="Number Of Delegates*" required>
                                <input type="text" name="form[Best-Day]" value="<?php echo (!empty(@$_POST['form']['Best-Day'])) ? date('d-M-Y',strtotime(@$_POST['form']['Best-Day'])) : ""; ?>" placeholder="Best Day To Host a Lunch & Learn*" required>
                            </div>
                            <div class="flexdiv">
                                <input type="text" name="form[Best-time]" value="<?php echo @$_POST['form']['Best-time']; ?>" placeholder="Best Time For Lunch & Learn*" required>
                                <input type="text" name="form[Name-Of-Practice]" value="<?php echo @$_POST['form']['Name-Of-Practice']; ?>" id="" placeholder="Name Of The Practice*" required>
                            </div>
                            <div class="flexdiv">
                                <input type="text" name="form[Name-Of-Practice-Mmanager]" value="<?php echo @$_POST['form']['Name-Of-Practice-Mmanager']; ?>" placeholder="Name Of The Practice Manager*">
                                <input type="text" name="form[Practice-Address]" value="<?php echo @$_POST['form']['Practice-Address']; ?>" id="" placeholder="Practice Address*" required>
                            </div>
                            <div class="flexdiv">
                                <input type="text" name="form[Practice-Contact]" value="<?php echo @$_POST['form']['Practice-Contact']; ?>" placeholder="Practice Contact Number*" required>
                                <input type="email" name="form[email]" value="<?php echo @$_POST['form']['email']; ?>" id="" placeholder="Email Address*" required>
                            </div>

                            <div class="flexdiv">
                                <textarea name="form[Lunch-Comment]" id="" cols="30" rows="10" placeholder="Dietary Requirements:*"><?php echo @$_POST['form']['Lunch-Comment']; ?></textarea>
                            </div>

                        <div>
                            <p>Is there a plain wall where the trainer can project the PowerPoint</p>
                            <input type="radio" name="form[Is-there-a-plain-wall]" value="yes"> <span>Yes</span>
                            <input type="radio" name="form[Is-there-a-plain-wall]" value="no"> <span>No</span>
                        </div>
                        <script>
                                        $("input[name='form[Is-there-a-plain-wall]'][value='<?php echo @$_POST['form']['Is-there-a-plain-wall']; ?>']").prop("checked",true);
                                    </script>
                        <div>

                            <p>Would you like a FREE Mock Audit before the training (please note the compliance champion would need 30 minutes to go through this audit with a team member before the lunch and learn session)</p>
                            <input type="radio" name="form[Would-you-like-a-FREE-Mock-Audit]" value="yes"> <span>Yes</span>
                            <input type="radio" name="form[Would-you-like-a-FREE-Mock-Audit]" value="no"> <span>No</span>
                        </div>
                        <script>
                                        $("input[name='form[Would-you-like-a-FREE-Mock-Audit]'][value='<?php echo @$_POST['form']['Would-you-like-a-FREE-Mock-Audit']; ?>']").prop("checked",true);
                         </script>
                        <div>

                            <p>Are you currently using a compliance software</p>
                            <input type="radio" name="form[Are-you-currently-using-a-compliance-software]" value=""> <span>Yes</span>
                            <input type="radio" name="form[Are-you-currently-using-a-compliance-software]" value=""> <span>No</span>
                        </div>
                        <script>
                         $("input[name='form[Are-you-currently-using-a-compliance-software]'][value='<?php echo @$_POST['form']['Are-you-currently-using-a-compliance-software']; ?>']").prop("checked",true);
                        
                        
                        
                        </script> 
                      
                        <input type="submit" class="submit_side" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script>
    if($('#g-lunchandlearn').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'lunchandlearn'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-lunchandlearn').value = token;
        });
    });

}
</script>
<?php
}
?>

<?php return ob_get_clean(); ?>