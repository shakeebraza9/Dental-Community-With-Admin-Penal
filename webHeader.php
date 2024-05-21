<?php
ob_start();
include_once('global.php');
global $webClass;
$box1 = $webClass->getBox('box1');
$facebook = $functions->ibms_setting('Facebook');
$twiter = $functions->ibms_setting('Twitter');
$instagram = $functions->ibms_setting('Instagram');
$google = $functions->ibms_setting('Google');
	// $dbF->prnt($box2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="icon" type="image/x-icon" href="<?= WEB_URL ?>/webImages/fav_logo.png" />
	<title>Dental Community</title>
	<!-- Jquery Ui -->
	<link rel="stylesheet" href="css/jquery_ui.css" />
	<!-- font-awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
	integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

	<!-- Swiper Link -->
	<script src="https://www.google.com/recaptcha/api.js?render=6Le7UhYcAAAAAEOuG9Vtp_zFl16jM6phZDRMYYn0" > </script>
	<link rel="stylesheet" href="css/swiper.css" />
	<!-- Hover CSS -->
	<link rel="stylesheet" href="css/hover-min.css" />
	<!-- Wow -->
	<link rel="stylesheet" href="css/wow.css" />
	<!-- MMENU -->
	<link rel="stylesheet" href="css/mmenu.css" />
	<!-- AOS -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
	<!-- Animated Css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	<!-- Main CSS -->
 <script src="https://js.stripe.com/v3/"></script>
	<link rel="stylesheet" href="<?php echo WEB_URL .'/css/style.css?magic='. filemtime('./css/style.css') ?>" />
</head>
<body>
        
    
    <script>
        grecaptcha.ready(function() {
        //onload
        grecaptcha.execute('6Le7UhYcAAAAAEOuG9Vtp_zFl16jM6phZDRMYYn0').then(function(token) {
              console.log(token);
                // document.getElementById('token').value = token;
               var list = document.querySelectorAll('.token');
                var n;
                for (n = 0; n < list.length; ++n) {
                    list[n].value= token;
                }

        });
    });
    setInterval(function() {
        grecaptcha.ready(function() {
            grecaptcha.execute('6Le7UhYcAAAAAEOuG9Vtp_zFl16jM6phZDRMYYn0').then(function(token) {
                // console.log(token);
                // document.getElementById('token').value = token;
                var list = document.querySelectorAll('.token');
                var n;
                for (n = 0; n < list.length; ++n) {
                    list[n].value = token;
                }

            });
        });
    }, 120 * 1000);
    </script>
           
           
           
           
           
           <?php

$email = $functions->ibms_setting('Email');
$phone = $functions->ibms_setting('Phone');
$address = $functions->ibms_setting('address');
$pMmsg = "";

    if(!empty($_POST)){
	// echo 1;
	$captcha = $_POST['token'];
	$secret   = "6Le7UhYcAAAAAC0BEyyO3TJKK9ZB0HcP4a3tRgFB";
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
	$response = json_decode($response);
	

	if ($response->success === false) {
		$pMmsg = $dbF->hardWords('The form has not been submitted please refill the form and submit.',false);
		$contactAllow = false;
	}else{
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
            if($key=="PName"){
                $key="Practice Name";
            }
			$v = ucwords(str_replace("_"," ",$key)).':'.$val;
			$array[]= $v;
			$c++;
		}
		$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';
		$msg.='</table>';
		$msg;
		$f = trim($f,",");
        if(isset($_POST['monthly'])){
            $monthYear="WebOrder-Monthly";
        }else{

            $monthYear="WebOrder-Yearly";

        }
        
		 $functions->saveFormData($f,$array, $monthYear);
		 $to = $functions->ibms_setting('Email');
        
		 $functions->send_mail($to,$monthYear,$msg);

		$nameUser =   $_POST['form']['pName'];
		$to =   $_POST['form']['email'];
		$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);
		$message2="Hello ".ucwords($nameUser).",<br><br>

		$thankT.<br><br>";

		if($functions->send_mail($to,'','',$monthYear,$nameUser)){
			$pMmsg = $thankT;

		} else {
			$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);
			$pMmsg = "$errorT";
		}
	}
	}
	






?> 
    <!--POPUP HTML STARTS-->
        <div class="fixed_side"></div>
        
        <div class="customprice_div" id="recurring_payment"> 
                <div class="practice-form">
                        <div class="col5_close">
                            <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                        </div> 
                        <div class="heading">
                            <h1 id="pro_heading">Over 25 users multi-location practices</h1>
                            <h6>Your details</h6>
                        </div>
                        <div class="inner_pricing_form">
                            
                            <form method="POST" action="orderInvoice.php">
                                 <?php echo $functions->setFormToken("WebOrderReadyRecurring",false); ?>
                                <input type="hidden" name="productId"  value=""> 
                                <input type="hidden" name="pname"  value="">
                                <input type="hidden" name="price" value="">
                                <input type="hidden" name="validity" value="">
                                <div class="inputs_flex inputs_flex3">
                                    <div class="input-feild booking-form">
                                        <input type="text" name="pName" value="" placeholder="Practice Name" required="">
                                    </div>
                                    <?php 
                                        $email = isset($_SESSION['webUser']['email']) ? $_SESSION['webUser']['email'] : "";
                                        $disable = isset($_SESSION['webUser']['email']) ? 'disabled' : '';
                                    ?> 
                                    <div class="input-feild booking-form">
                                        <input type="email" name='email' value="<?php echo $email ?>" <?php echo $disable ?>  placeholder="Practice Email Address" required="">
                                    </div>

                                 <div class="input-feild booking-form">
                                        <input type="text"  name="mobile" value=""  placeholder="Practice Number" required="">
                                    </div>
                                </div>
                                
                                <div class="inputs_flex inputs_flex_2">
                                    <div class="input-feild booking-form">
                                        <input type="text"  name="address" value="" placeholder="Practice Address" required="">
                                    </div>
                                    
                                    
                                    <div class="input-feild booking-form">
                                        <input type="text"  name="city" value="" placeholder="Practice City Address" required="">
                                    </div>
                                </div>
                                
                                <!--<div class="input-feild booking-form">-->
                                <!--    <textarea placeholder="Practice City Address" required=""></textarea>-->
                                <!--</div>-->
                                    
    
                                <div class="inputs_flex inputs_flex3">
                                    <div class="input-feild booking-form">
                                        <input type="text"  name="acc_name" value="" placeholder="Account Holder Name" required="">
                                    </div>
                                    
                                   
                                    <div class="input-feild booking-form">
                                        <input type="text" name="acc_no" value="" placeholder="Account Number" required="">
                                    </div>
                                    
                                
                                    <div class="input-feild booking-form">
                                        <input type="text" name="acc_routing_number" value="" placeholder="Routing Number" required="">
                                    </div>
                                </div>
                                
                                <div class="input-field terms_condition">
                                    <div class="input-feild booking-form">
                                        <input type="checkbox" name="terms_and_condition" id="form[terms]" checked required="">
                                        <label for="terms">Terms and Conditions</label>
                                    </div>
                                </div>
                                
                                <button type="submit" name="submit" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" disabled>Proceed to Checkout</button>
                            </form>
    
    
                        </div>
                    </div>
            </div>
        
        <div class="customprice_div" id="oneoff_payment"> 
                <div class="practice-form">
                        <div class="col5_close">
                            <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                        </div> 
                        <div class="heading">
                            <h1 id="pro_heading"></h1>
                            <h6>Your details</h6> 
                        </div>
                        <div class="inner_pricing_form">
                            
                            <form method="POST" action="orderInvoice.php">
                                <?php echo $functions->setFormToken("WebOrderReady",false); ?>
                                <input type="hidden" name="productId"  value=""> 
                                <input type="hidden" name="pname"  value="">
                                <input type="hidden" name="price" value="">
                                <input type="hidden" name="validity" value="">
                               
                                <div class="inputs_flex inputs_flex3">
                                    <div class="input-feild booking-form">
                                        <input type="text" name="pName" placeholder="Practice Name" required="">
                                    </div>
                                    <?php 
                                        $email = isset($_SESSION['webUser']['email']) ? $_SESSION['webUser']['email'] : "";
                                        $disable = !empty($email) ? 'disabled' : '';
                                    ?>
                                    <div class="input-feild booking-form">
                                        <input type="email" name="email" value="<?php echo $email ?>" <?php echo $disable ?> placeholder="Practice Email Address"  required="">
                                    </div>
                                
                                
                                 <div class="input-feild booking-form">
                                        <input type="text" name="mobile" placeholder="Practice Number" required="">
                                    </div>
                                </div>
                                
                                <div class="inputs_flex inputs_flex_2">
                                    <div class="input-feild booking-form">
                                        <input type="text" name="address" placeholder="Practice Address" required="">
                                    </div>
                                    
                                    
                                    <div class="input-feild booking-form">
                                        <input type="text" name="city" placeholder="Practice City Address" required="">
                                    </div>
                                </div>
                                
                                <!--<div class="input-feild booking-form">-->
                                <!--    <textarea placeholder="Practice City Address" required=""></textarea>-->
                                <!--</div>-->
                                
                                <div class="input-field terms_condition">
                                    <div class="input-feild booking-form">
                                        <input type="checkbox" name="terms_and_condition" id="form[terms]" required="">
                                        <label for="terms">Terms and Conditions</label>
                                    </div>
                                </div>
                                
    							<!--<input type="hidden" name="token" class="token" value="03AL8dmw9v7FlJI-HSdQO0wydjmFi5nkUXNumisON-AFmeNoSjdqCLNs2xiHYNaMNXwT052TlU__d_KtfxEMRx4YklhNiJMeRDBjMyBh27a50ByuQAVb-6jDYkVMGM6KCNkoXOxZugryGY4iny8DgfaKF7f1THAsOk5fHfeK9cTDK9bFEfqtjadQxMA_267S8xyY6sMaqKZlgC135A54XVMzcvUzxXqd34osmS7D7xmEvk98BBL3RNCvZwvjYt2nXgrlrDP-Dmxuc3YSvF7TaT2ecwcHERHpE2mrkG9EBl9SKWwGO-_DcfOfHkQlYe8FOnE7AULs4-cObKFiU_PkS6ZC5HRB9eeVqhXOf9eL_EP0SUWqrND6dk1Uw_sGmflm-xHvbjqmfr6xmMiiEFswkuD4I9ZN_jRd9r8TGSJ91reTuK_Mp39JcjMbVP32wDlmqJdAC2oeuA8XXiRMimIP97UnyO8lYL_HWJZq2nqWc0MqtGESuZOaKWZRYFkl8E0kTgCY1_fURJhQx241B63nlYi35JcgnYL6sO4WtrER3fFVtJmAdsZ_C0z12EFOEe_flaIHUHNiiwrCju18aaM5qBsghlftYNx5GzUA">-->
                                <button type="submit" name="submit" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" disabled>Proceed to Checkout</button>
                            </form>
    
    
                        </div>
                    </div>
            </div>
        
        <div class="customprice_div" id="monthly_payment"> 
                <div class="practice-form">
                        <div class="col5_close">
                            <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                        </div> 
                        <div class="heading">
                            <h1 id="pro_heading"></h1>
                            <h6>Your details</h6>
                        </div>
                        <div class="inner_pricing_form">
                            
                            <form method="POST">
                                 <?php echo $functions->setFormToken("WebOrderReady-Monthly",false); ?>
                                <div class="inputs_flex inputs_flex3">
                                    <div class="input-feild booking-form">
                                        <input type="text" placeholder="Your Name*" name="form[name]" required="">
                                    </div>
        
                                    <div class="input-feild booking-form">
                                        <input type="email" placeholder="Your email*" name="form[email]" required="">
        
                                    </div>
        
                                    <div class="input-feild booking-form">
                                        <input type="phone" placeholder="Your Phone*" name="form[phone]" required="">
        
                                    </div>
                                </div>
    
                                <div class="input-field additional" style="width: 100%;">
                                    <textarea name="form[message]" rows="10" placeholder="Your Message" required=""></textarea>
                                </div>
                                <input type="hidden" name="monthly" >
    							<input type="hidden" name="token" class="token" value="">
                                <button type="submit"  name="name" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" >Submit Information</button>
    
                            </form>
    
     
                        </div>
                    </div>
            </div>
        
        <div class="customprice_div" id="yearly_payment">

                <div class="practice-form">
                        <div class="col5_close">
                            <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                        </div> 
                        <div class="heading">
                            <h1 id="pro_heading">Over 25 users multi-location practices</h1>
                            <h6>Your details</h6>
                        </div>
                        <div class="inner_pricing_form">
                            
                            <form method="POST">
                                <input type="hidden" name="contactFormToken" value="646c4c279df3b">                            
                                <div class="inputs_flex inputs_flex3">
                                    <div class="input-feild booking-form">
                                        <input type="text" placeholder="Your Name*" name="form[name]" required="">
                                    </div>
        
                                    <div class="input-feild booking-form">
                                        <input type="email" placeholder="Your email*" name="form[email]" required="">
        
                                    </div>
        
                                    <div class="input-feild booking-form">
                                        <input type="phone" placeholder="Your Phone*" name="form[phone]" required="">
        
                                    </div>
                                </div>
    
                                <div class="input-field additional" style="width: 100%;">
                                    <textarea name="form[message]" rows="10" placeholder="Your Message" required=""></textarea>
                                </div>
    
    							<input type="hidden" name="token" id="token" value="03AL8dmw9a3e-gWrIJqL-E6WN0Iw59pooivfFqhRgmTUtC4BmZ1_ifTQaPArLKaBs0InYPPIOOte85MhjYR20WoPUULKDV8X4g_ljvj7mr9WeISwNDH3yNuzWrbpclgWmAb6hK71eYnPpdyhplDr_P786PYI9JdNN5Q8DXqkw-trYG-A0giNinlasEpqVIV_nzl-CPfUNLCzXLbb_7oFT2bezfLGy-VOQcIo4uMmmWN7kAhYMiGcC6TtaLqzMJYaBjQHWf7mRAY-Bvjye4ewdFQTgvzNOkrucqCRxufoY8v_BW4Jdxcsvl69ZDzyoqWJ7XRWjW8TTVaRWWIZq8mgeaqHN5rij3DJeVO1dZUoFOfPmB8WCV09U49SPLBpNCWREzCB-5Yb7KrBGl8vYGGVww4V0GJYkEumSYn2mN6qUXdH--eAnC5DxtlX05QYNbgBm94PfWoEHgHBJ54pp65L-q7nkBpaYTZu0bRr-iDKY4-eyfePQyGnqJWaP1qwGfiFsDdsqin5OP15oP7y3VKD8PrZRhky7VXha00OI7rrIrZr9D0viUR-2HSczIYGH3Wh66z-NNPh7fTUySVSZHaZVfbZHyspUIdW_ArA">
                                <button type="submit" class="btn submit-btn hvr-bounce-to-right" value="SUBMIT INFORMATION">Submit Information</button>
    
                            </form>
    
    
                        </div>
                    </div>
            </div>
    
        <div class="customprice_div" id="product_price_form">
            <div class="practice-form">
                    <div class="col5_close">
                        <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                    </div>
                    <div class="heading">
                        <h1 id="pro_heading"></h1>
                        <h6>Your details</h6>
                    </div>
                    <div class="inner_pricing_form">
                        
                        <form method="POST">
                            <?php $functions->setFormToken('WebOrderReady-Yearly'); ?>  
                             
                             <input type="hidden" name="productId"  value=""> 
                             <input type="hidden" name="pname"  value="">
                             <input type="hidden" name="price" value="">
                             <input type="hidden" name="validity" value="">

                            <!--<input type="hidden" name="contactFormToken" value="645df2757a838">                            -->
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Name" name="form[pName]" required="">
                                </div>
                                
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Number" name="form[mobile]" required="">
                                </div>
    
                            </div>
                            
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Address" name="form[address]" required="">
                                </div>
                                
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice City Address" name="form[city]" required="">
                                </div>
                            </div>

                            <div class="input-field additional">
                                <div class="input-feild booking-form">
                                    <input type="email" placeholder="Practice Email Address" name="form[email]" required="">
                                </div>
                            </div>
                            
                             <div class="input-field additional">
                                <div class="input-feild booking-form">
                                    <textaera  placeholder="" name="form[message]" required=""></textaera>
                                </div>
                            </div>
                            
                             <div class="input-field additional" >
                                <div class="input-feild booking-form">
                                    <input type="checkbox" name="terms_and_condition" id='form[terms]' required="">
                                    <label for="terms">Terms and Conditions</label>
                                </div>
                            </div> 
                            <div class="input-feild booking-form">
                                    <textarea placeholder="Practice City Address" name="form[message]" required=""></textarea>
                                </div>
                            
                            
							<input type="hidden" name="token" class="token" value="">
                            <button type="submit" name="namee" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" >Proceed to Checkout</button>
                            
                        </form>


                    </div>
                </div>
        </div>
        
         <div class="customprice_div" id="custom_price_form"> 
            <div class="practice-form">
                    <div class="col5_close">
                        <img src="https://php8.imdemo.xyz/dental_community/webImages/close.png?magic=01" alt="" class="hvr-pop">
                    </div> 
                    <div class="heading">
                        <h1 id="pro_heading"></h1>
                        <h6>Your details</h6>
                    </div>
                    <div class="inner_pricing_form">
                        
                        <form method="POST">
                            <?php echo $functions->setFormToken("WebOrderReady-Monthly",false); ?>
                            <input type="hidden" name="contactFormToken" value="645df2757a838">  
                            <div class="inputs_flex">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Name" name="form[pName]" required="">
                                </div>
                                
                                <div class="input-field additional">
                                <div class="input-feild booking-form">
                                    <input type="email" placeholder="Practice Email Address" name="form[email]" required="">
                                </div>
                            </div>
                             <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Number" name="form[mobile]" required="">
                                </div>
    
                            </div>
                            
                            <div class="inputs_flex inputs_flex_2">
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice Address" name="form[address]" required="">
                                </div>
                                
                                
                                <div class="input-feild booking-form">
                                    <input type="text" placeholder="Practice City Address" name="form[city]" required="">
                                </div>
                            
                            </div>
                            <div class="input-feild booking-form">
                                    <textarea placeholder="Practice City Address" name="form[message]" required=""></textarea>
                                </div>
                                
                            <input type="hidden" name="monthly" >
							<input type="hidden" name="token" class="token" value="">
                            <button type="submit" name="name" id="checkoutBtn" class="btn submit-btn hvr-bounce-to-right" >Proceed to Checkout</button>
                        </form>


                    </div>
                </div>
        </div>
      
    <!--POPUP HTML ENDS-->
    
    <nav id="menu">
        <ul>

									<?php
					                    //$login  =  $webClass->userLoginCheck();
					                    // if(!$login){
					                    //     echo "<li><a href='login'>Login</a></li>";
					                    // }
					                    // else{
					                    //     echo "<li><a href='/main_dashboard'>Dashboard</a></li>";
					                    // }
					                    ##### RESPONSIVE MAIN MENU
					                    
					                    $textname=array();
									$css = false;
									$mainMenu = $menuClass->menuTypeSingle('main_menu');
									foreach ($mainMenu as $val) {
										$insideActive = false;
										$innerUl = '';
										$menuId = $val['id'];
										$text = ($val['name']);
										$link = $val['link'];
										$mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
										if (!empty($mainMenu2)) {
											$innerUl .= '<ul>';
											foreach ($mainMenu2 as $val2) {
												$innerUl3 = '';
												$text = ($val2['name']);
												$menuId = $val2['id'];
												$link = $val2['link'];
												$mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
					                    # count the inner level 3 lis
												$innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
												$innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
												if ( $innerUl3count > 0 ) {
													foreach ($mainMenu3 as $val3) {
														$innerUl4 = '';
														$text3       = ($val3['name']);
														$menuId3     = $val3['id'];
														$link3       = $val3['link'];
														$mainMenu4   = $menuClass->menuTypeSingle('main_menu', $menuId3);
					                    # count the inner level 3 lis
														$innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
														$innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
														if ( $innerUl4count > 0 ) {
															foreach ($mainMenu4 as $val4) {
																$text4       = ($val4['name']);
																$link4       = $val4['link'];
																$innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
															}}
															$innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
															$innerUl3 .= '
															<li><a href="' . $link3 . '">' . $text3 . '</a>
															' . $innerUl4 . '
															</li>';
														}
													}
													$innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
													$innerUl .= '<li><a href="' . $link . '" target="_blank">' . $text . '</a>' . $innerUl3 . '</li>';

												}
												$innerUl .= "</ul><!--2nd array End-->";
											}
											$text = ($val['name']);
											$textname[] = $val['name'];
											$link = $val['link'];
											echo '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl . '</li>';
										}
										
										
								// 		$innerU1 = ''; 
        //                                 $innerU2 = '';      
										
										$mainMenu2 = $menuClass->menuTypeSingle('footer_menu', 6);
                                            if (!empty($mainMenu2)) {
                                                // $innerU1 .= '<ul>';
                                                foreach ($mainMenu2 as $val2) { 
                                                    
                                                    
                                                    $innerUl3 = '';
                                                    $ftext = ($val2['name']);
                                                    $menuId = $val2['id'];
                                                    $link = $val2['link'];
                                                    $mainMenu3 = $menuClass->menuTypeSingle('footer_menu', $menuId);
                                                    // count the inner level 3 lis
                                                    $innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
                                                    $innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
                                                    if ( $innerUl3count > 0 ) {
                                                    }
                                                    $innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
                                                    echo  '<li><a href="' . $link . '">' . $ftext . '</a>' . $innerUl3 . '</li>';
                                                        
                                                    
                                                }
                                                //  $innerU1 .= "</ul><!--2nd array End-->";
                                            }
                                            
                                            // explore menu 2
                                            $mainMenu3 = $menuClass->menuTypeSingle('footer_menu', 12);
                                            if (!empty($mainMenu3)) {
                                                // $innerU2 .= '<ul>';
                                                foreach ($mainMenu3 as $val2) {
                                                    $innerUl4 = '';
                                                    $text = ($val2['name']);
                                                    $menuId = $val2['id'];
                                                    $link = $val2['link'];
                                                    $mainMenu4 = $menuClass->menuTypeSingle('footer_menu', $menuId);
                                                    // count the inner level 3 lis
                                                    $innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
                                                    $innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
                                                    if ( $innerUl4count > 0 ) {
                                                    }
                                                    $innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
                                                    
                                                         echo   '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl3 . '</li>';
                                                }
                                                //   $innerU2 .= "</ul><!--2nd array End-->";
                                            }
										?>

									</ul>
    </nav>
    <div class="main_container">
	<section class="main_section_2" style="min-height: <?php  !isset($_SERVER['REDIRECT_QUERY_STRING']) ? '100vh' : '0vh !important' ?> ;">
		<div class="Standard1">
			<header>
				<div class="header_main">
						<div class="header_inner1">
						<div class="mmenu_icon">
                              <a href="#menu">
                                <div class="menu_icn">
                                  <i class="fa fa-bars linked"></i>
                                </div>
                              </a>
                            </div>
					    <div class="header_inner">
							<div class="header_logo">
								<img src="webImages/nav_logo.png" alt="logo" />
							</div>
							<div class="header_nav">
								<ul>

									<?php
					                    //$login  =  $webClass->userLoginCheck();
					                    // if(!$login){
					                    //     echo "<li><a href='login'>Login</a></li>";
					                    // }
					                    // else{
					                    //     echo "<li><a href='/main_dashboard'>Dashboard</a></li>";
					                    // }
					                    ##### RESPONSIVE MAIN MENU
									$css = false;
									$mainMenu = $menuClass->menuTypeSingle('main_menu');
									foreach ($mainMenu as $val) {
										$insideActive = false;
										$innerUl = '';
										$menuId = $val['id'];
										$text = ($val['name']);
										$link = $val['link'];
										$mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
										if (!empty($mainMenu2)) {
											$innerUl .= '<ul>';
											foreach ($mainMenu2 as $val2) {
												$innerUl3 = '';
												$text = ($val2['name']);
												$menuId = $val2['id'];
												$link = $val2['link'];
												$mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
					                    # count the inner level 3 lis
												$innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
												$innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
												if ( $innerUl3count > 0 ) {
													foreach ($mainMenu3 as $val3) {
														$innerUl4 = '';
														$text3       = ($val3['name']);
														$menuId3     = $val3['id'];
														$link3       = $val3['link'];
														$mainMenu4   = $menuClass->menuTypeSingle('main_menu', $menuId3);
					                    # count the inner level 3 lis
														$innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
														$innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
														if ( $innerUl4count > 0 ) {
															foreach ($mainMenu4 as $val4) {
																$text4       = ($val4['name']);
																$link4       = $val4['link'];
																$innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
															}}
															$innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
															$innerUl3 .= '
															<li><a href="' . $link3 . '">' . $text3 . '</a>
															' . $innerUl4 . '
															</li>';
														}
													}
													$innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
													$innerUl .= '<li><a href="' . $link . '" target="_blank">' . $text . '</a>' . $innerUl3 . '</li>';

												}
												$innerUl .= "</ul><!--2nd array End-->";
											}
											$text = ($val['name']);
											$link = $val['link'];
											echo '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl . '</li>';
										}
										?>

									</ul>
								</div>
						</div>
						<div class="header_inner2">
								<div class="header_login">
									<button href="" class="hvr-bounce-to-right">
										<?php 
										$isLogin = $webClass->userLoginCheck();
										if(!$isLogin){
										?><a href="<?= $box1['link'] ?>"><?= $box1['linkText'] ?></a>
										<?php }else{ ?>
											<a href="<?= WEB_URL ?>/main_dashboard">Dashboard</a>
										<?php } ?>
									</button>
								</div>
								
								<div class="header_login header_login_mobile">
									<button href="" class="hvr-bounce-to-right">
										<?php 
										$isLogin = $webClass->userLoginCheck();
										if(!$isLogin){
										?><a href="<?= $box1['link'] ?>" class="menu_icn"><i class="fa-solid fa-right-to-bracket linked"></i></a>
										<?php }else{ ?>
											<a href="<?= WEB_URL ?>/main_dashboard" class="menu_icn"><i class="fa-solid fa-gauge linked"></i></a>
										<?php } ?>
									</button>
								</div>




								<div class="header_social">
									<a href="<?= $facebook ?>"><i class="fa-brands fa-square-facebook linked"></i></a>
									<a href="<?= $twiter ?>"><i class="fa-brands fa-twitter linked"></i></a>
									<a href="<?= $instagram  ?>"><i class="fa-brands fa-instagram linked"></i></a>
									<a href="<?= $google ?>"><i class="fa-brands fa-google-plus-g linked"></i></a>
								</div>
							</div>
						</div>
					</div>
				</header>
			</div>
			<!--  -->
			<!-- Banner -->
			<?php include_once('banner.php') ?>
		</section>