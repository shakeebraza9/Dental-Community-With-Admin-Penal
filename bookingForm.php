<?php
ob_start();
include_once("global.php");
global $webClass;

$pMmsg = "";
// echo $functions->send_mail('jawwad.rafique007@gmail.com','','','contactFormSubmit','Jawwad');
//  exit();

if(!empty($_POST)){
    $captcha = $_POST['token'];
    $secret   = "6Le7UhYcAAAAAC0BEyyO3TJKK9ZB0HcP4a3tRgFB";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        // use json_decode to extract json response
    $response = json_decode($response);
    

    if ($response->success === false) {
        $pMmsg = $dbF->hardWords('The form has not been submitted please refill the form and submit.',false);
        $contactAllow = false;
    }else{
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
        $msg;
        $f = trim($f,",");

        $functions->saveFormData($f,$array, 'Booking Form');
        $to = $functions->ibms_setting('Email');

        $functions->send_mail($to,'Booking Form',$msg);

        $nameUser =   $_POST['form']['name'];
        $to =   $_POST['form']['email'];
        $thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);
        $message2="Hello ".ucwords($nameUser).",<br><br>

        $thankT.<br><br>";

        if($functions->send_mail($to,'','','bookingFormSubmit',$nameUser)){
            $pMmsg = $thankT;
        } else {
            $errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);
            $pMmsg = "$errorT";
        }
    }
}


?>
<div class="booking-foam">
    <div class="right-foam booking  ">


        <div class="right-side-amergency-form" style="padding-top: 0px;">


            <div class="input-form-amergency">
                <div class="input-form">
                    <?php if(!empty($pMmsg)) { ?>
                        <div style="text-align: center; padding: 20px; margin-bottom: 20px; border: 1px solid transparent;
                        border-radius: 4px; background-color: #d9edf7; border-color: #bce8f1;">
                        <?= $pMmsg ?>

                    </div>
                <?php } ?>
                <form method="POST">
                    <div class="your-name-input booking-form">
                        <label for="">Practice Name<span class="star">*</span></label>
                        <br />
                        <input type="text" name="form[practice_name]" placeholder="Practice Name" required />
                    </div>

                    <div class="your-email-input booking-form">
                        <label for="">Name<span class="star">*</span></label> <br />
                        <input type="text" name="form[name]" placeholder="Name"  required  />
                    </div>
                    <div class="your-email-input booking-form">
                        <label for="">Email<span class="star">*</span></label> <br />
                        <input type="text" name="form[email]" placeholder="Email" required  />
                    </div>
                    <div class="your-email-input booking-form">
                        <label for="">Contact<span class="star">*</span></label> <br />
                        <input type="text" name="form[contact]" placeholder="Contact" required  />
                    </div>
<!-- 
                            <div class="your-email-input center booking-form">

                                <label for="">Multi-Site Practice</label> <br /> <br>
                                <input type="radio" name="practice" value="Yes" id="Yes" /> Yes

                                <input type="radio" name="practice" value="No" id="No" /> No
                            </div>
                        -->

                        <div class="your-email-input additional">
                            <input type="hidden"  name="token" id="token">
                            <label for="">Additional Information</label> <br />
                            <textarea id="w3review" name="form[additional_information]" rows="6" cols="80"
                            placeholder="Additional Information"></textarea>
                        </div>

                        <button type="submit" class="book-appoinmnet-now-submit hvr-bounce-to-right book-btn">
                            Submit Information
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
    grecaptcha.ready(function() {
        grecaptcha.execute('6Le7UhYcAAAAAEOuG9Vtp_zFl16jM6phZDRMYYn0').then(function(token) {
            document.getElementById('token').value = token ;
        });
    });
</script>

<?php return ob_get_clean(); ?>