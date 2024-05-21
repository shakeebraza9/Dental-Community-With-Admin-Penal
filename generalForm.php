<?php
ob_start();
include_once("global.php");
global $webClass;
?><?php

$pMmsg = '';

$contactAllow = true;

$formNo = @$_GET['form'];
if ($formNo == 1) {
    $formType = "Book A Call";
}else if ($formNo == 2) {
    $formType = "Book 10 minutes catch up call";
}else if ($formNo == 3) {
    $formType = "Book a 15-minute onboarding session";
}else if ($formNo == 4) {
    $formType = "inquiryFormSubmit";
}else if(substr_count($_SERVER['REQUEST_URI'],"smart-consult",0 ) > 0){$formType = "SmartConsultForm";}

if(isset($_POST) && !empty($_POST['form']['name']) ){


 if (isset($_POST['g-contactFormSubmit'])) {
    $captcha = $_POST['g-contactFormSubmit'];
} 

 if(!$captcha){
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
        $contactAllow = false;
    }
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $responseKeys = json_decode($response,true);

     if(intval($responseKeys["success"]) !== 1) {
        
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
        $contactAllow = false;
    }else{


if($functions->getFormToken('generalFormSubmit')){

$img="";




$f = '';
$v = '';
$c = 1;
$array = array();



$msg='<table border="1">';

foreach($_POST['form'] as $key=>$val){
if(is_array($val)){$val=implode(",",$val);}

$msg.= '

<tr>

<td>'.ucwords(str_replace("_"," ",$key)).'</td>

<td>'.$val.'</td>

</tr>';



$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;


$array[]= $v;



$c++;




}

$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

$msg.='</table>';



$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array(str_replace(" ","_",@$formType));
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);





$to = $functions->ibms_setting('Email');

$functions->send_mail($to, @$formType,$msg);



$msg1 ='';

foreach($_POST['form'] as $key=>$val){
$msg1.= '
<tr>
<td>'.ucwords(str_replace("_"," ",$key)).'</td>
<td>'.$val.'</td>
</tr>';
}
$msg1.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
$msg1.='</table>';
$nameUser =   $_POST['form']['name'];

$to =   $_POST['form']['email'];

$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','generalFormSubmit',$nameUser)){

$pMmsg = $thankT;

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

// }else{
    


?>

    
<?php
if($pMmsg!=''){
echo "<div class='alert alert-info'>$pMmsg</div>";
}

if(true){

    $login = $webClass->userLoginCheck();

    if($login){
        $id = intval($_SESSION['webUser']['id']);
        $sql = "SELECT acc.acc_name as name , acc.acc_email as email, A.setting_val as practiceName, B.setting_val as phone FROM `accounts_user_detail` as A, `accounts_user_detail` as B 
            JOIN `accounts_user` as acc ON B.id_user = acc.acc_id 
            Where A.setting_name = 'practice name' AND B.setting_name = 'phone' AND A.id_user = $id  AND B.id_user =$id ";
        $userData   =   $dbF->getRow($sql);            
        
    }
?>
 <div class="standard">
            <div class="LunchMain m-y-50">
                <div class="LunchfirstSec">
                    
                </div>
                <div class="LunchsecondSec">
                    <div class="SndSecInnerdiv">

                        <h5><?php if ($formType=='inquiryFormSubmit'){echo "<h1>Enquiry Form</h1>";}elseif ($formType=='SmartConsultForm'){echo "<h1>Get Smart Consult Package</h1>";}else{echo @$formType;} ?></h5>
                         <?php
                        if($pMmsg!=''){
                        echo "<div class='alert alert-info'>$pMmsg</div>";
                        }
                        ?>
                        <form method="post" autocomplete="No" enctype="multipart/form-data" >
                         <?php $functions->setFormToken('generalFormSubmit'); ?>
                        <input type="hidden" id="g-contactFormSubmit" name="g-contactFormSubmit">
                            
                        
                            <div class="flexdiv">
                                <input type="text" name="form[practice_name]" id="" placeholder="Practice Name" value="<?php echo @$userData['practiceName']; ?>" required>
                                <input type="text" name="form[name]" id="" placeholder="Full Name" value="<?php echo @$userData['name']; ?>" required>
                            </div>
                            <div class="flexdiv"><b>Multi-Site Practice</b>
                                <div>
                                   <input type="radio" value="Yes" name="form[multi_site_practice]" placeholder="Yes" style="height: 20px;width: 30px; margin:0 10px;">
                                    <b>Yes</b>
                                    <input type="radio" value="No" name="form[multi_site_practice]" placeholder="No" style="height: 20px;width: 30px; margin:0 10px;">
                                    <b>No</b>
                                </div>
                            </div>
                            <div class="flexdiv">
                                <input type="email" name="form[email]" id="" placeholder="Email" value="<?php echo @$userData['email']; ?>
                                " required>
                                <input type="text" name="form[phone]" id="" placeholder="Contact No" value="<?php echo @$userData['phone']; ?>">
                            </div>
                           
                            <?php
                        if ($formNo == 4) {?>
                           
                            <div class="flexdiv flexdiv-full">
                                 <input type="text" placeholder="Job Title" name="form[Job_title]">
                            </div>
<h5>Details of Enquiry</h5>
                            <div class="flexdiv ">
                            <div class="input-checbox">
                                    <div class="chkecbox"><input type="checkbox" value="CPD Training Course" name="form[details_of_Enquiry][]" >
                                    CPD Training Course</div>
                                    <div class="chkecbox"><input type="checkbox" value="Book a Demo of Software" name="form[details_of_Enquiry][]">
                                    Book a Demo of Software</div>
                                     <div class="chkecbox"><input type="checkbox" value="Book Onboarding" name="form[details_of_Enquiry][]">
                                     Book Onboarding </div>
                                     <div class="chkecbox"><input type="checkbox" value="Other" name="form[details_of_Enquiry][]">
                        
                                        Other (Please Specify in Additional Information)</div>
                            </div>
                         <div class="input-checbox">   
                        <div class="chkecbox"><input type="checkbox" value="Technical Help" name="form[details_of_Enquiry][]">
                        Technical Help</div>
                        <div class="chkecbox"><input type="checkbox" value="Squat Practice Help" name="form[details_of_Enquiry][]">
                        Squat Practice Help</div>
                        <div class="chkecbox"><input type="checkbox" value="General Enquiry" name="form[details_of_Enquiry][]">
                        General Enquiry </div></div>

                        
                                </div>
                        <?php
                        }?>
                        <div class="flexdiv"><textarea placeholder="Additional Information" name="form[additional_information]" ></textarea>
                        </div>
                             <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>  
                                        <input type="submit" class="submit_side" value="SUBMIT INFORMATION">

                        </form>
                    </div>
                </div>
            </div>
        </div>

        
                        
<?php
}
?>

<?php

// }

return ob_get_clean(); ?>