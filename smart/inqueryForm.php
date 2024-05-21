<?php
ob_start();
include_once("global.php");
global $webClass;
?>
<div class="inner_content">
<div class="text_side_left">
    <div class="standard">
        <div class="map_side_ wow fadeInUp">
           
        </div>
        <!-- map_side_ close -->

<?php

$pMmsg = '';

$contactAllow = true;

if(isset($_POST) && !empty($_POST['form']['name']) ){



 if (isset($_POST['g-inquiryFormSubmit'])) {
    $captcha = $_POST['g-inquiryFormSubmit'];
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


if($functions->getFormToken('inquiryFormSubmit')){

$img="";




$f = '';
$v = '';
$c = 1;
$array = array();



$msg='<table border="1">';

foreach($_POST['form'] as $key=>$val){

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
$data2 = array("inquiryFormSubmit");
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);



$to = $functions->ibms_setting('Email');

$functions->send_mail($to,'Contact Form',$msg);


$msg1 ='';
$dirr = __DIR__."/inquiryFormSubmit.txt";
$fh = fopen($dirr,'r');
while ($line = fgets($fh)) {
$msg1 .=$line;
}
foreach($_POST['form'] as $key=>$val){
$msg1.= '
<tr>
<td>'.ucwords(str_replace("_"," ",$key)).'</td>
<td>'.$val.'</td>
</tr>';
}
$msg1.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
// $msg1.='</table>';
$dirr = __DIR__."/inquiryFormSubmit.txt";
$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1);
fclose($myfile);





$nameUser =   $_POST['form']['name'];

$to =   $_POST['form']['email'];

$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','inquiryFormSubmit',$nameUser)){

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
        <div class="contact_detail">
            
            <!-- contact_left close -->
            <div class="contact_right wow fadeInRight">
                <h5>Inquiry Form</h5>
                <div class="form_1_">
                    <form method="post">
                        <?php $functions->setFormToken('inquiryFormSubmit'); ?>



                         <input type="hidden" id="g-inquiryFormSubmit" name="g-inquiryFormSubmit">
    <input type="hidden" name="action" value="inquiryFormSubmit">



                        <div class="form_1_side_">Full Name:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <input type="text" placeholder="Your Name" name="form[name]" required>
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Email:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <input type="email" placeholder="Your Email" name="form[email]" required>
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Contact No.:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <input type="phone" placeholder="Your Phone" name="form[phone]">
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Practice Detail:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <textarea placeholder="Practice Detail" name="form[message]" required></textarea>
                        </div>
                        <!-- form_2_side close -->
              <!--           <div class="form_1_side_">
                        </div> -->
                        <!-- form_1_side close -->
                     <!--    <div class="form_2_side_">
                            <div id="recaptcha2"></div>
                        </div> -->
                        <!-- form_2_side close -->

                        <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>  

                                
                        <div class="form_1_side_ mbl_side"></div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ form_1">
                            <input type="submit" class="submit_side" value="SUBMIT INFORMATION">
                        </div>
                        <!-- form_2_side close -->
                    </form>
                </div>
                <!-- form_1 close -->
            </div>
            <!-- contact_right close -->
        </div>
        <!-- contact_detail close -->
<?php
}
?>
</div>
    <!-- standard close -->
</div>
<!-- text_side_left close -->
<?php
return ob_get_clean(); ?>