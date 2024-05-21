<?php
ob_start();
include_once("global.php");
global $webClass;
?><?php

$pMmsg = '';

$contactAllow = true;

if(isset($_POST) && !empty($_POST['form']['name']) ){

 


 if (isset($_POST['g-contactFormSubmit'])) {
    $captcha = $_POST['g-contactFormSubmit'];
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


if($functions->getFormToken('contactFormSubmit')){

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
$data2 = array("contactFormSubmit");
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);





$to = $functions->ibms_setting('Email');
// $to="samratbutani@gmail.com";
$functions->send_mail($to,'Contact Form',$msg);



$msg1 ='';
$dirr = __DIR__."/contactFormSubmit.txt";
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

$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1);
fclose($myfile);






$nameUser =   $_POST['form']['name'];

$to =   $_POST['form']['email'];

$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','contactFormSubmit',$nameUser)){

$pMmsg = $thankT;
echo "<script> fbq('track', 'CompleteRegistration'); </script>";

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

//... The Captcha is valid you can continue with the rest of your code
//... Add code to filter access using $response . score









if ($response->success==true && $response->score <= 0.5) {
    //Do something to denied access
}




}
    


?>






    <div class=" practice-main">
            <div class="standard">
                <div class="practice-flex">
                    <div class="flex p-y-40 contactus">
                        <h2>Contact our Smart Team</h2>
                    <div class="addres">
                        <?php $box16 = $webClass->getBox('box16'); ?>
                        <p><i class="fa-solid fa-phone"></i> <a href="tel:+<?php echo $box16['heading2'] ?>"><?php echo $box16['heading2'] ?></a></p>
                        <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo $functions->ibms_setting('email'); ?>"><?php echo $functions->ibms_setting('email'); ?></a></p>
                        <p><i class="fa-solid fa-location-dot"></i> <a>Mitre House, 66 Abbey Rd, Enfield EN1 2QN</a></p>
                    </div>
                  </div>
                <div class="practice-form">

                    <h2>Fill in our contact form for more information.</h2>
                    <p>If you have an enquiry about the compliance services we can offer to your practice, please get in touch. A compliance advisor will arrange a consultation and talk through your needs.</p>
                    <?php
                    if($pMmsg!=''){
                    echo "<div class='alert alert-info'>$pMmsg</div>";
                    }
                    ?>
                    <div class="m-y-50">

                        <form method="post" action="">
                             



                            <?php $functions->setFormToken('contactFormSubmit'); ?>
                            <input type="hidden" id="g-contactFormSubmit" id="g-contactFormSubmit" name="g-contactFormSubmit">
                            <input type="hidden" name="action" value="contactFormSubmit">
                            <div class="input-feild"><input type="text" placeholder="Your Name*" name="form[name]" required></div>
                            <div class="input-feild"><input type="email" placeholder="Your email*" name="form[email]" required></div>
                            <div class="input-feild"><input type="phone" placeholder="Your Phone*" name="form[phone]"></div>
                            
                            <div class="input-feild" style="width:100%;"><textarea rows="10" placeholder="Your Message" name="form[message]" required></textarea></div>
                            <button class="btn book" value="SUBMIT INFORMATION">Submit Information</button>
                        </form>
                    </div>


                </div>
                </div>
            </div>
        </div>

<div class="demo">
            <div class="standard">
                <div class="demo-main">
                    <div class="sform">
                        <h2> Book a demo</h2>
                        <form action="">
                            <div class="sform-feild"><input type="text" placeholder="Full Name"></div>
                            <div class="sform-feild"> <input type="text" placeholder="Email"></div>
                            <div class="sform-feild"> <input type="text" placeholder="Company"></div>
                            <button class="btn explore">Request a Demo</button>
                        </form>
                    </div>
                    <div class="simage">
                        <!-- <div id="lottie6"></div> -->
                        <img src="webImages2/laptop.webp" alt="">
                    </div>
                </div>
            </div>
        </div>
<?php

return ob_get_clean(); ?>