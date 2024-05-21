<?php 
include_once('global.php');
include_once('webHeader.php');
$box3 = $webClass->getBox('box3');
$box4 = $webClass->getBox('box4');
$box5 = $webClass->getBox('box5');
$box6 = $webClass->getBox('box6');
$box7 = $webClass->getBox('box7');
$box8 = $webClass->getBox('box8');
$box9 = $webClass->getBox('box9');
$box10 = $webClass->getBox('box10');
$box11 = $webClass->getBox('box11');

$pMmsg = "";

	// $dbF->prnt($_POST);
if(!empty($_POST)){
		// $dbF->prnt($_POST);
		//secret
	$captcha = $_POST['token'];
	$secret   = "6Le7UhYcAAAAAC0BEyyO3TJKK9ZB0HcP4a3tRgFB";
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		// use json_decode to extract json response
	$response = json_decode($response);

	if ($response->success === false) {
		$pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
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
			$v = ucwords(str_replace("_"," ",$key)).':'.$val;
			$array[]= $v;
			$c++;
		}
		$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';
		$msg.='</table>';
		$msg;
		$f = trim($f,",");
		
		$sql = "INSERT INTO  `formAllData` SET ";
		$sql .= $f.',type = ?';
		$data2 = array("Schedule_Time_Data");
		$array = array_merge($array, $data2);
		$dbF->setRow($sql,$array,false);
		$to = $functions->ibms_setting('Email');
// $to="samratbutani@gmail.com";
		$functions->send_mail($to,'Schedule Time Data',$msg);
		$nameUser =   $_POST['form']['name'];

		$to =   $_POST['form']['email'];

		$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

		$message2="Hello ".ucwords($nameUser).",<br><br>

		$thankT.<br><br>";

		if($functions->send_mail($to,'','','scheduleFormSubmit',$nameUser)){
			$pMmsg = $thankT;
		} else {
			$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);
			$pMmsg = "$errorT";
		}
	}
}

// echo $pMmsg;
?>

<!-- Why Use Dental Community Compliance? -->
<section class="main_text wow flipInX">
	<div class="Standard">
		<div class="main_text_inner">
			<h1><?= $box3['heading2'] ?></h1>
			<p><?= $box3['text'] ?></p>
		</div>
	</div>
</section>

<!-- section 2 box -->
<div class="Standard">
	<section class="compliance_manager_main">
		<div class="Standard">
			<div class="tab_main_2">
				<div class="compliance_manager_inner">
					<div class="compliance_manager_top">
						<div id="tabs">
							<ul id="tabs_flex">
								<li>
									<a href="#tabs-1"><span><?= $box4['heading2'] ?></span></a>
								</li>
								<li>
									<a href="#tabs-2"><span><?= $box5['heading2'] ?></span></a>
								</li>
								<li>
									<a href="#tabs-3"><span><?= $box5['heading2'] ?></span></a>
								</li>
								<li>
									<a href="#tabs-4"><span><?= $box6['heading2'] ?></span></a>
								</li>
							</ul>
							<div id="tabs-1">
								<!-- <img src="webImages/compilance_manager_img.PNG" alt=""> -->
								<div class="complaince_tab_main">
									<div class="complaince_tab_inner1">
										<img src="<?= $box4['image'] ?>" alt="" />
									</div>
									<div class="complaince_tab_inner2">
										<h2><?= $box4['heading2'] ?></h2>
										<p><?= $box4['text'] ?></p>

										<div class="c_inner2_btn">
											<button class="hvr-bounce-to-right">
												<a href="<?php echo $box8['link'] ?>"><?php echo $box8['linkText']; ?></a>
											</button>
											<button class="hvr-bounce-to-right">
												<a href="<?php echo $box9['link'] ?>"><?php echo $box9['linkText'] ?></a>
											</button>
										</div>

									</div>
								</div>
							</div>
							<div id="tabs-2">
								<div class="complaince_tab_main">
									<div class="complaince_tab_inner1">
										<img src="<?= $box5['image'] ?>" alt="" />
									</div>
									<div class="complaince_tab_inner2">
										<h2><?= $box5['heading2'] ?></h2>
										<p><?= $box5['text'] ?></p>

										<div class="c_inner2_btn">
											<button class="hvr-bounce-to-right">
												<a href="<?= $box8['link'] ?>"><?= $box8['linkText'] ?></a>
											</button>
											<button class="hvr-bounce-to-right">
												<a href="<?= $box['link'] ?>"><?= $box9['linkText'] ?></a>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div id="tabs-3">
								<div class="complaince_tab_main">
									<div class="complaince_tab_inner1">
										<img src="<?= $box6['image'] ?>" alt="" />
									</div>
									<div class="complaince_tab_inner2">
										<h2><?= $box6['heading2'] ?></h2>
										<p><?= $box6['text'] ?></p>
										<div class="c_inner2_btn">
											<button class="hvr-bounce-to-right">
												<a href="<?= $box8['link'] ?>"><?= $box8['linkText'] ?></a>
											</button>
											<button class="hvr-bounce-to-right">
												<a href="<?= $box['link'] ?>"><?= $box9['linkText'] ?></a>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div id="tabs-4">
								<div class="complaince_tab_main">
									<div class="complaince_tab_inner1">
										<img src="<?= $box7['image'] ?>" alt="" />
									</div>
									<div class="complaince_tab_inner2">
										<h2><?= $box7['heading2'] ?></h2>
										<p><?= $box7['text'] ?></p>
										<div class="c_inner2_btn">
											<button class="hvr-pulse">
												<a href="<?= $box8['link'] ?>"><?= $box8['linkText'] ?></a>
											</button>
											<button class="hvr-pulse">
												<a href="<?= $box['link'] ?>"><?= $box9['linkText'] ?></a>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- section 10 -->
		<div class="compliance_manager_bottom_main">
			<div class="compliance_heading_">
				<h2><?= $box10['heading2'] ?></h2>
			</div>
			<div class="compliance_manager_bottom">
				<div class="compliance_manager_bottom1">
					<?= $box10['text'] ?>
				</div>
				<div class="compliance_manager_bottom2">
					<img src="<?= $box10['image'] ?>" alt="" />
				</div>
			</div>
		</div>
	</section>
</div>

<div class="Standard">
	<section class="dentail-department-list">
		<div class="Standard">
			<div class="department-list">
				<?= $box11['text'] ?>
			</div>
			<div class="department-choose-btn">
				<a href="<?= $box11['link'] ?>" class="hvr-bounce-to-right"><?= $box11['linkText'] ?></a>
			</div>
		</div>
	</section>
</div>

<section class="book-doctor">
	<div class="Standard">
		<div class="ammergency-doctor-book">
			<div class="left-side-doctor-image wow bounceInLeft" data-wow-duration="2s">
				<img src="./webImages/book_doctor_img.png" alt="" />
			</div>
			<div class="right-side-amergency-form side-form">
				<!-- <h2>Schedule A Time</h2> -->
				<h2>
					Schedule <span> A Time</span> <br />
					To Chat
				</h2>
				<?php if(!empty($pMmsg)) { ?>
					<div style="text-align: center;
					padding: 20px; margin-bottom: 20px; border: 1px solid transparent;
					border-radius: 4px; background-color: #d9edf7; border-color: #bce8f1;"><?= $pMmsg ?></div>
				<?php } ?>
				<div class="hr-line" id="hr-line"></div>

				<div class="input-form-amergency">
					<div class="input-form">
						<form  method="POST">
							<div class="your-name-input">
								<label for="pName">Practice Name<span class="star">*</span></label>
								<br />
								<input id="pName" type="text" name="form[practice_name]" required />
							</div>

							<div class="your-email-input">
								<label for="name">Name<span class="star">*</span></label> <br />
								<input type="text" id="name" name="form[name]" required />
							</div>
							<div class="your-email-input">
								<label for="email">Email<span class="star">*</span></label> <br />
								<input type="email" name="form[email]" required />
							</div>
							<div class="your-email-input">
								<label for="phone">Phone<span class="star">*</span></label> <br />
								<input type="text" name="form[phone]" id="phone" required />
							</div>

							<input type="hidden" name="token" id="token">


						</div>
					</div>


					<button type="submit" class="book-appoinmnet-now-submit hvr-bounce-to-right">
						Book A Schedule
					</button>
				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	grecaptcha.ready(function() {
		grecaptcha.execute('6Le7UhYcAAAAAEOuG9Vtp_zFl16jM6phZDRMYYn0').then(function(token) {
			document.getElementById('token').value = token ;
		});
	});
</script>

<!-- Gallery section -->
<?php include_once('index__gallery.php') ?>
<?php include_once('webFooter.php') ?>