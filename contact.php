<?php
ob_start();
include_once("global.php");
global $webClass;
$email = $functions->ibms_setting('Email');
$phone = $functions->ibms_setting('Phone');
$address = $functions->ibms_setting('address');
$pMmsg = "";
// echo $functions->send_mail('jawwad.rafique007@gmail.com','','','contactFormSubmit','Jawwad');
// 	exit();

if(!empty($_POST)){
	// echo 1;
	$captcha = $_POST['token'];
	$secret   = "6Le7UhYcAAAAAC0BEyyO3TJKK9ZB0HcP4a3tRgFB";
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		// use json_decode to extract json response
	$response = json_decode($response);
	

	if ($response->success === false) {
		$pMmsg = $dbF->hardWords('The form has not been submitted please refill the form and submit.',false);
		$contactAllow = false;
	// echo 2;
	}else{
	// echo 3;
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
		$msg;
		$f = trim($f,",");

		 $functions->saveFormData($f,$array, 'Contact Form');
		 $to = $functions->ibms_setting('Email');

		 $functions->send_mail($to,'Contact Form',$msg);

		$nameUser =   $_POST['form']['name'];
		$to =   $_POST['form']['email'];
		$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);
		$message2="Hello ".ucwords($nameUser).",<br><br>

		$thankT.<br><br>";

		if($functions->send_mail($to,'','','contactFormSubmit',$nameUser)){
			$pMmsg = $thankT;
		} else {
			$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);
			$pMmsg = "$errorT";
		}
	}
}






?>
	<div class="flex p-y-40 contactus">
                    <h2>Contact our Community Team</h2>

                    <div class="addres">
                        <p>
                            <i class="fa-solid fa-phone">
                            </i>
                            <a href="tel:<?= $phone ?>"><?= $phone ?></a>
                        </p>
                        <p>
                            <i class="fa-solid fa-envelope">

                            </i>
                            <a href="mailto:<?= $email ?>">
                                <?= $email ?>
                            </a>
                        </p>
                        <p>
                            <i class="fa-solid fa-location-dot">

                            </i>
                            <a> 
								<?= $address ?>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="practice-form">
                    <h2>
                        Fill in our contact form for more information.
                    </h2>
                    <p>
                        If you have an enquiry about the compliance services we can offer to your practice, please get
                        in touch. A compliance advisor will arrange a consultation and talk through your needs.
                    </p>
                    <?php if(!empty($pMmsg)) { ?>
						<div style="text-align: center; padding: 20px; margin-bottom: 20px; border: 1px solid transparent;
							border-radius: 4px; background-color: #d9edf7; border-color: #bce8f1;">
							<?= $pMmsg ?>
								
							</div>
					<?php } ?>
                    <div class="m-y-50">
                        <form method="POST" >
                            <?php echo $functions->setFormToken("contactForm",false); ?>
                            
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Your Name*" name="form[name]" required>
                                </div>
    
                                <div class="input-feild booking-form">
                                    <input type="email" placeholder="Your email*" name="form[email]" required>
    
                                </div>
    
                                <div class="input-feild booking-form">
                                    <input type="phone" placeholder="Your Phone*" name="form[phone]" required>
    
                                </div>
                            </div>

                            <div class="input-field additional" style="width: 100%;">
                                <textarea name="form[message]" rows="10" placeholder="Your Message" required></textarea>
                            </div>

							<input type="hidden"  name="token" id="token">
                            <button type="submit" class="btn submit-btn hvr-bounce-to-right" value="SUBMIT INFORMATION">Submit Information</button>

                        </form>


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