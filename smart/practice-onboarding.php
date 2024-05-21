<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
include_once('header.php');
include_once('dashboardheader.php');

$page = $_GET['page'];
$user = $_SESSION['webUser']['id'];
$sql = "SELECT * FROM `accounts_user` WHERE `acc_id` = $user AND `acc_type` = 1";
$data = $dbF->getRow($sql,false);
$name = $data['acc_name'];
$status = $data['onbording'];

if($login){
        $id = intval($_SESSION['webUser']['id']);
        $sql = "SELECT acc.acc_name as name , acc.acc_email as email, A.setting_val as practiceName, B.setting_val as phone FROM `accounts_user_detail` as A, `accounts_user_detail` as B 
            JOIN `accounts_user` as acc ON B.id_user = acc.acc_id 
            Where A.setting_name = 'practice name' AND B.setting_name = 'phone' AND A.id_user = $id  AND B.id_user =$id ";
        $userData   =   $dbF->getRow($sql);            
        
    }

// if($status > 4 ){    
//     header('Location: main_dashboard');
// }


if(isset($_POST) && !empty($_POST['form']['name']) ){

//  if (isset($_POST['g-contactFormSubmit'])) {
//     $captcha = $_POST['g-contactFormSubmit'];
// } 

//  if(!$captcha){
//         $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
//         $contactAllow = false;
//     }
//     $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
//     $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
//     // use json_decode to extract json response
//     $responseKeys = json_decode($response,true);

//      if(intval($responseKeys["success"]) !== 1) {
         
        
//         $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
//         $contactAllow = false;
    // }else{


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
$formType = "Book_a_15-minute_onboarding_session";

$data2 = array(str_replace(" ","_",$formType));
$array = array_merge($array, $data2);
// $array = $array;
$dbF->setRow($sql,$array,false);

// $sql    = "UPDATE `accounts_user` SET `onbording` = ? WHERE `acc_id` = ?";
// $array   = array(5,$user);
// $this->dbF->setRow($sql,$array,false);


$to = $functions->ibms_setting('Email');

$functions->send_mail($to, "general",$msg);


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

echo $pMmsg = $thankT;
echo '<script>location.reload();</script>';exit();
} else {

$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);

$pMmsg = "$errorT";

}

$contactAllow = false;

}else{

$contactAllow = true;

}
        
    // }
    
}



$sql2    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql2,array($user));

$hobbies = @$functions->webUserInfoArray($userInfo,'hobbies');
if (!empty($hobbies)) {
    
$hobbiesArray = explode(",",$hobbies);
}else{
$hobbiesArray = array();
}
$skills = @$functions->webUserInfoArray($userInfo,'skills');
if (!empty($skills)) {
$skillsArray = explode(",",$skills);
}else{
$skillsArray = array();
}
$user_id = $_SESSION['currentUser'];

$sql = "SELECT * FROM `practiceprofile` WHERE `user_id` =  ? ";
$row = $dbF->getRow($sql,array($user_id));
$practice_name = $row['practice_name'];
$practice_manager_name = $row['practice_manager_name'];
$staff = $row['staff'];
$surgeries = $row['surgeries'];
$npm = $row['npm'];

$userImage = $row['practice_logo'];

$chk1 = $functions->documentInsert();
$msg = "";
if($chk1){
    $msg = "Document Insert Successfully";
}
?>
<div class="fixed_side"></div>
<div class="myevents-div">
    <div class="col5_close">
        <img src="<?php echo WEB_URL; ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
    </div>
    <!-- col5_close close -->
    
   <div id="loader">
        <img src="<?php echo WEB_URL; ?>/webImages/logo.png?magic=01" alt="Smart Dental Compliance">
    </div>
    <!-- loader -->
    <!--<div class="background_side">-->
    <!--</div>-->
    <!-- background_side close -->
    <div class="myevents-form"></div>
</div>

<div class="index_content mypage">
   <div class="left_right_side">
       
    <!--link_menu close -->
        <div class="left_side">
            <?php $active = 'hrm'; include'dashboardmenu.php';?>
        </div>
    <!-- left_side close -->
    
        <div class="right_side">
            <div class="onboard_page">
               
         <?php if ( $status == 0) { ?>   
                <div class="onboard_page_main">
                    
                    <div class="onboardCross">
                        <a href="<?php echo WEB_URL ?>/main_dashboard"><img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop"></a>
                    </div>
                    <div class="onboard-center">
                        <div class="onboard_logo">
                            <a href="<?php echo WEB_URL ?>">
                                <div class="onboard_logo_inner">
                                    <img src="<?php echo WEB_URL ?>/webImages/logo.png?magic=01" >
                                </div>
                                <h1>Smart Dental<h3>Compliance &amp; Training</h3></h1>
                            </a>
                        </div>
                        <div class="onboard_txt">
                            <span><?php $dbF->hardWords('Welcome to the',true); ?></span>
                            <h2><?php $dbF->hardWords('All-In-One',true); ?></h2>
                            <h3><?php $dbF->hardWords('Management Software',true); ?></h3>
                        </div>
                        <div class="onboard_btn">
                            <a href="<?php echo WEB_URL ?>/practice-onboarding?page=upload-your-logo" data-status ="1" class="nextBtn"><?php $dbF->hardWords('Glad you are here, let’s get started with the onboarding process',true); ?> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- login-center -->
                </div>
        <?php }
        // else if ((isset($page) )) {  
            if ($status == 1 ) {
                 $style = "display:block;";
             }else{
                $style = "display:none;";
             }
            ?>
             <div class="smile-center" style="<?php echo $style; ?>">
                    <div class="smile_header">
                        <div class="smile_img">
                            <img src="<?php echo WEB_URL ?>/webImages/profile1.png" >
                        </div>
                        <div class="smile_btn">
                            <a href="<?php echo WEB_URL ?>/practice-onboarding" data-status ="0" class="previousBtn">
                                Previous
                            </a>
                            <a href="javascript:void(0)" id="uploadPhoto" data-status ="2" class="nextBtn">
                                Next
                            </a> &nbsp;
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="smile_txt">
                        <div class="smile_txt_inner">
                        <h2>Let see your practice logo. <span>Upload !</span> your logo,</h2>
                        <h3>for it to reflect on your practice policies and procedures.</h3>
                        <form id="uploadPhotoForm">
                            <input type="hidden" name="dataUrl" id="dataUrl">
                            <input type="file" name="userProfile" id="profileImg">
                        </form>
                        </div>
                        <div class="smile_txt_img">
                            <?php if (!empty($userImage) && $userImage != "#") { ?>
                                <input type="hidden"  value="<?php echo $userImage; ?>" id="oldImage">
                            <?php }else { ?>
                                <input type="hidden"  value="" id="oldImage">
                            <?php } ?>
                                <img src="<?php echo WEB_URL; ?>/images/<?php echo @$userImage; ?>" id="blah" class="smile_txt_img_inner">
                        </div>
                    </div>
                </div>
        <?php 
         if ($status == 2) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        ?>
            
                <div class="info-center info" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <img src="<?php echo WEB_URL ?>/webImages/profile2.png" >
                        </div>
                        <div class="info_btn">
                            <a href="javascript:void(0)" id="previousUploadForm" data-status ="1" class="previousBtn">
                                Previous
                            </a>
                            <a href="javascript:void(0)" id="formSubmit">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt">
                        <br><br>
                        <h2>Practice Profile</h2>
                        <form id="myForm">
                            <div class="form_2_side">
                            <div class="form_1_side">Name of Practice <span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="practice_name" value="<?php echo $practice_name; ?>" id="practice_name" onchange="$('.practice_name').hide();">
                                <div class="practice_name" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Name of Practice Manager <span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="practice_manager_name" value="<?php echo $practice_manager_name; ?>" id="practice_manager_name" onchange="$('.practice_manager_name').hide();">
                                <div class="practice_manager_name" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Number of Staff </div>
                            <!-- form_1_side close -->
                                <input type="text"  name="staff" value="<?php echo $staff; ?>">
                            </div>
                            <!-- form_2_side close -->
                            
                            <div class="form_2_side">
                            <div class="form_1_side">Number of Surgeries </div>
                            <!-- form_1_side close -->
                                <input type="text" name="surgeries" value="<?php echo $surgeries; ?>" >
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">NHS/Private/Mixed Practice </div>
                            <!-- form_1_side close -->
                                <input type="text"  name="npm" value="<?php echo $npm; ?>">
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Non-Working Days</div>
                            <!-- form_1_side close -->
                                <?php 
                                    $daysss = $row['dayoff'];
                                    $offday = explode(",",$daysss);
                                ?>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="1" <?php if (in_array("1", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Mon
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="2" <?php if (in_array("2", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Tue
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="3" <?php if (in_array("3", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Wed
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="4" <?php if (in_array("4", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Thur
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="5" <?php if (in_array("5", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Fri
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="6" <?php if (in_array("6", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Sat
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="dayoff[]" value="7" <?php if (in_array("7", $offday))  {echo "checked"; }?> >
                                    <span class="cmark"></span>Sun
                                </div>
                                
                            </div>
                            <!-- form_2_side close -->
                             
                        </form>
                        <br><br><br>
                    </div>
                </div>
        <?php
         if ($status == 3 ) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        
         ?>        
                 <div class="info-center addEmployee" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <img src="<?php echo WEB_URL ?>/webImages/profile3.png" >
                        </div>
                        <div class="info_btn">
                            <a href="javascript:void(0)" id="previousForm" data-status ="2" class="previousBtn">
                                Previous
                            </a>
                            
                            <a href="javascript:void(0)" id="add-onboarding">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt"> 
                        <br><br>
                        <h2>Add Employee</h2>
                        <br>
                        <h4>Lets add your first employee. You can add the remaining employee within the HR Dashboard</h4>
                        <form id="myForm" class="newEmployee">
                            <input type="hidden" name="signUp[account_under]" value="<?php echo $user; ?>" >
                            <input type="hidden" name="signUp[account_type]" value="Employee" >
                            <div class="form_2_side">
                            <div class="form_1_side">Name of Employee <span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="name"  id="name" onchange="$('.name').hide();">
                                <div class="name" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Employee Email <span>*</span><b style="font-size: 12px;"> (<?php $dbF->hardWords('Use For Login') ;?> )</b></div>
                            <!-- form_1_side close -->
                                <input type="email" name="email" value="" id="emailAddress" onchange="$('.emailAddress').hide();">
                                <div class="emailAddress" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Work Email Address</div>
                            <!-- form_1_side close -->
                                <input type="email" name="signUp[work_email]"  >
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Password <span>*</span> <b style="font-size: 12px;"> (<?php $dbF->hardWords('Default Password = welcome') ;?> )</b></div>
                            <!-- form_1_side close -->
                                <input type="password" name="pass" value="welcome" id="password" onchange="$('.password').hide();">
                                <div class="password" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                        </form>
                        <br><br><br>
                    </div>
                </div>
        <?php
         if ($status == 4 ) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        
         ?>        
                 <div class="info-center add-page" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <!--<a href="<?php echo WEB_URL ?>/main_dashboard"><img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop"></a>-->
                        <img src="<?php echo WEB_URL ?>/webImages/profile4.png" >
                        </div>
                        <div class="info_btn">
                           <a href="javascript:void(0)" id="addEmployee_back" data-status ="3" class="previousBtn">
                                Previous
                            </a>
                            
                            <a href="javascript:void(0)" id="add-page">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt SndSecInnerdiv"> 
                         <br><br>
                        <h2>Book Onboarding Session</h2>
                        <br>
                        <!-- <h4>Lets add your first employee. You can add the remaining employee within the HR Dashboard</h4 -->
                        <!--<form id="myForm" class="newonboarding">-->
                        <!--    <input type="hidden" name="account_under" value="<?php echo $user; ?>" >-->
                            
                        <!--    <div class="form_2_side">-->
                        <!--    <div class="form_1_side">Name<span>*</span></div>-->
                            <!-- form_1_side close -->
                        <!--        <input type="text" name="name"  id="name" onchange="$('.name').hide();">-->
                        <!--        <div class="name" style="display: none; color: red;">field is empty</div>-->
                        <!--    </div>-->
                            <!-- form_2_side close -->
                        <!--    <div class="form_2_side">-->
                        <!--    <div class="form_1_side">Email <span>*</span><b style="font-size: 12px;"> (<?php $dbF->hardWords('Use For Login') ;?> )</b></div>-->
                            <!-- form_1_side close -->
                        <!--        <input type="email" name="email" value="" id="emailAddress" onchange="$('.emailAddress').hide();">-->
                        <!--        <div class="emailAddress" style="display: none; color: red;">field is empty</div>-->
                        <!--    </div>-->
                            <!-- form_2_side close -->
                        <!--    <div class="form_2_side">-->
                        <!--    <div class="form_1_side">Phone</div>-->
                            <!-- form_1_side close -->
                        <!--        <input type="text" name="phone"  >-->
                        <!--    </div>-->
                            <!-- form_2_side close -->
                        <!--    <div class="form_2_side">-->
                        <!--    <div class="form_1_side">Additional information</div>-->
                            <!-- form_1_side close -->
                        <!--        <input type="text" name="information"  >-->
                        <!--    </div>-->
                            <!-- form_2_side close -->
                        <!--</form>-->
                        
                        <form method="post" autocomplete="No" id="myForm" enctype="multipart/form-data" >
                                 <?php $functions->setFormToken('generalFormSubmit'); ?>
                                <input type="hidden" id="g-contactFormSubmit" name="g-contactFormSubmit">
                                    
                                
                                    <div class="form_2_side">
                                    <div class="form_1_side">Practice Name <span>*</span></div>
                                        <input type="text" name="form[practice_name]" id="prac_name" placeholder="Practice Name" value="<?php echo @$userData['practiceName']; ?>" onchange="$('.prac_name').hide();" required>
                                        <div class="prac_name" style="display: none; color: red;">field is empty</div>
                                    </div>
                                    
                                    <div class="form_2_side">
                                    <div class="form_1_side">Full Name <span>*</span></div>
                                        <input type="text" name="form[name]" id="name" placeholder="Full Name" value="<?php echo @$userData['name']; ?>" onchange="$('.name').hide();" required>
                                        <div class="name" style="display: none; color: red;">field is empty</div>
                                    </div>
                                    
                                    <!--<div class="flexdiv"><b>Multi-Site Practice</b>-->
                                    <!--    <div>-->
                                    <!--       <input type="radio" value="Yes" name="form[multi_site_practice]" placeholder="Yes" style="height: 20px;width: 30px; margin:0 10px;">-->
                                    <!--        <b>Yes</b>-->
                                    <!--        <input type="radio" value="No" name="form[multi_site_practice]" placeholder="No" style="height: 20px;width: 30px; margin:0 10px;">-->
                                    <!--        <b>No</b>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <div class="form_2_side">
                                    <div class="form_1_side">Email <span>*</span></div>
                                        <input type="email" name="form[email]" id="emailAddress" placeholder="Email" value="<?php echo @$userData['email']; ?>" onchange="$('.emailAddress').hide();" required>
                                        <div class="emailAddress" style="display: none; color: red;">field is empty</div>
                                    </div>
                                    
                                    <div class="form_2_side">
                                    <div class="form_1_side">Contact No</div>
                                        
                                        <input type="text" name="form[phone]" id="" placeholder="Contact No" value="<?php echo @$userData['phone']; ?>">
                                        
                                    </div>
                                    
                                    <div class="form_2_side_">
                                    <div class="form_1_side">Additional Information</div>
                                        <textarea placeholder="" name="form[additional_information]" ></textarea>
                                    </div>
                                         
                                    <div id="recaptcha3" class="recaptcha3">
                                      <input type="hidden" id="token" name="token">
                                    </div>  
                                    
                                    <input type="submit" class="submit_side nextBtn" data-status ="5" value="SUBMIT INFORMATION">
            
                                    </form>
                        <br><br><br>
                        
                    </div>
                </div>
                
        <?php
        
         if ($status == 5 ) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        
         ?>        
                 <div class="info-center add-page2" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <!--<a href="<?php echo WEB_URL ?>/main_dashboard"><img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop"></a>-->
                        <img src="<?php echo WEB_URL ?>/webImages/profile4.png" >
                        </div>
                        <div class="info_btn">
                           <a href="javascript:void(0)" id="add-page_back" data-status ="4" class="previousBtn">
                                Previous
                            </a>
                            
                            <a href="javascript:void(0)" id="onboard_page_main_next" data-status ="6" class="nextBtn">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt"> 
                        <video controls="" playsinline="" autoplay="" muted="" loop="" style="width:100%">
                            <source src="https://smartdentalcompliance.com/AIOM/webImages/123.mov" type="video/mp4">
                    </video>
                        
                    </div>
                </div>
        
        <?php 
        if ($status == 6) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }   ?>
        
                <div class="onboard_page_main healthForm" style="<?php echo $style; ?>">
                    <div class="onboardCross">
                        <a href="<?php echo WEB_URL ?>/main_dashboard"><img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop"></a>
                    </div>
                    <div class="onboard-center">
                        <div class="onboard_logo">
                            <a href="<?php echo WEB_URL ?>">
                                <div class="onboard_logo_inner">
                                    <img src="<?php echo WEB_URL ?>/webImages/logo.png?magic=01" >
                                </div>
                                <h1>Smart Dental<h3>Compliance &amp; Training</h3></h1>
                            </a>
                        </div>
                        <div class="onboard_txt">
        
                            
                            <h3><?php $dbF->hardWords('Lets get started with the Initial Compliance Check Form. This is short mock inspection to understand what is your practice current compliance health. ',true); ?></h3>
                        </div>
                        <div class="onboard_btn">
                    <?php 
                    $data = $functions->health_check($_SESSION['currentUser']);
                    if($data)
                    { ?>
                    <div class="col1_btnn">
                            <a href="<?php echo WEB_URL ?>/health_check_form" data-status ="5" class="nextBtn"><?php $dbF->hardWords('Lets get you Initial Compliance Check Form',true); ?> <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <?php }else{ ?>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" data-status ="5" class="nextBtn"><?php $dbF->hardWords('Lets get you Initial Compliance Check Form',true); ?> <i class="fas fa-arrow-right"></i></a>
                    <?php } ?>

                        </div>
                    </div>
                    <!-- login-center -->
                </div>  
        
            </div>
        </div>
    </div>

<script>
$(document).ready(function() {
  /////// 1. Select image with file input
  $('#profileImg').on('change', function() {
    var count = this.files.length;

    // for(var i=0; i<count; i++){

    resizeImages(this.files[0], function(dataUrl) {
        // console.log(dataUrl);
            // uploadResizedImages(dataUrl);
            $('#dataUrl').val(dataUrl);
            // $("#blah").removeAttr("src");
            // readURL(this);
    });
    // }
  });

  function resizeImages(file, complete) {
    // read file as dataUrl
    ////////  2. Read the file as a data Url
    var reader = new FileReader();
      // file read
      reader.onload = function(e) {
          // create img to store data url
          ////// 3 - 1 Create image object for canvas to use
          
          var img = new Image();
          
          img.onload = function() {
           /////////// 3-2 send image object to function for manipulation
            complete(resizeInCanvas(img));
          };

          img.src = e.target.result;
          $('#blah').attr('src', img.src);
        }
        // read file
      reader.readAsDataURL(file);
   
  }

});

function resizeInCanvas(img){
  /////////  3-3 manipulate image
 var ibms_size = <?php echo $functions->ibms_setting('uploadImageSize'); ?>;
 var canvas = document.createElement('canvas'),
    max_size = ibms_size,// TODO : pull max size from a site config
    width = img.width,
    height = img.height;

    if(width > <?php echo $functions->ibms_setting('uploadImageSize'); ?> || height > <?php echo $functions->ibms_setting('uploadImageSize'); ?>){
      if (width > height) {
          if (width > max_size) {
              height *= max_size / width;
              width = max_size;
          }
      } else {
          if (height > max_size) {
              width *= max_size / height;
              height = max_size;
          }
      }
    }
           
          //var img1 = new Image();
        //  img1.src = 'logo.png';  //*****For watermark***//
                canvas.width = width;
                canvas.height = height;
                
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                return canvas.toDataURL('image/jpeg',0.7);
                
  //////////4. export as dataUrl
}

function uploadResizedImages(dataUrl){
  // var resizedImage = dataURLToBlob(dataUrl);
  // console.log(resizedImage);
  var prop_id = $('#AjaxFileNewId').val();
  $('#upload_load').show();
  $.ajax({
    url: 'prop_ajax.php?page=uploadResizedImages',
    type: 'post',
    data: {dataUrl:dataUrl, prop_id:prop_id}
  }).done(function(res){
    console.log('helloooo');
    console.log(res);
    $('#upload_load').hide();
  });
}

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // $("#profileImg").change(function(){
    //     $("#blah").removeAttr("src");
    //     readURL(this);
    // });

    $(function () {
        $('.nextBtn').on('click', function () {
           
               var status = $(this).attr('data-status');   
               // var proof = $('.proof').val();   
               // var dbs = $('.dbs').val();   
               // var gdc = $('.gdc').val();   
               // var reference = $('.reference').val();   
              console.log(status);
              $.ajax({
                
                url: '<?php echo WEB_URL; ?>/ajax_call.php?page=onboardStatus',
                cache: false,
                data: {status:status},                         
                type: 'post',
                success: function (result) {
                    console.log(result);
                  if (result == 1) {
                    console.log(result);
                  }
                }
              });
        });


        $('.previousBtn').on('click', function () {
           
               var status = $(this).attr('data-status');   

              $.ajax({
                
                url: '<?php echo WEB_URL; ?>/ajax_call.php?page=onboardStatus',
                cache: false,
                data: {status:status},                         
                type: 'post',
                success: function (result) {
                  if (result == 1) {
                    // console.log(result);
                  }
                }
              });
        });


        $('#uploadPhoto').on('click', function () {
           $("#loader").css("display", "block");
           setTimeout(function () { 

               var dataUrl = $('#dataUrl').val();   
               var file_data = $('#profileImg').prop('files')[0];   
               var oldImage = $('#oldImage').val();   

               var form_data = new FormData();                  
               form_data.append('file', file_data);
               form_data.append('oldImage', oldImage);
               form_data.append('dataUrl', dataUrl);
                // alert(form_data);   
              $.ajax({
                
                url: '<?php echo WEB_URL; ?>/ajax_call.php?page=uploadLogo',
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                
                success: function (result) {
                    
                  if (result == 1) {
                    history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=practice-profile");
                    $(".info").show();
                    $(".smile-center").hide();
                    $("#loader").css("display", "none");
                  }
                }
              });

            }, 1000);  
        });

      });
    $('#previousUploadForm').on('click', function () {
        $("#loader").css("display", "block");
        setTimeout(function () { 
            history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=upload-your-logo");
            $(".smile-center").show();
            $(".info").hide();
            $("#loader").css("display", "none");
        }, 1000);  
    });
    
    $('#addEmployee_back').on('click', function () {
         
        setTimeout(function () { 
            history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=addEmployee");
            $(".addEmployee").show();
            $(".add-page").hide();
          $(".add-page2").hide();
            $(".info").hide();
            $("#loader").css("display", "none");
        }, 1000);  
        $("#loader").css("display", "block");
    });
    
    
     $('#add-page_back').on('click', function () {
         $("#loader").css("display", "block");
        setTimeout(function () { 
            history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=add-page");
            // $(".addEmployee").hide();
            $(".add-page").show();
          $(".add-page2").hide();
            // $(".info").hide();
            $("#loader").css("display", "none");
        }, 1000);  
        
    });
    
    
  


    $(function () {

        $('#formSubmit').on('click', function () {
            var practice_name = $("#practice_name").val();
            var practice_manager_name = $("#practice_manager_name").val();
            
            if (practice_name != "" && practice_manager_name != "" ) {
                $("#loader").css("display", "block");
                setTimeout(function () {   
                  $.ajax({
                    type: 'post',
                    url: '<?php echo WEB_URL; ?>/ajax_call.php?page=practiceProfile',
                    data: $('#myForm').serialize(),
                    success: function (result) {
                      if (result == 1) {
                        history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=addEmployee");
                        $(".addEmployee").show();
                        $(".info").hide();
                      }
                        $("#loader").css("display", "none");
                    }
                  });
                }, 1000);  
            }else{
                if (practice_name == "" && practice_manager_name == "" ) {
                    $(".practice_name").show();
                    $(".practice_manager_name").show();
                    
                }
                if (practice_name == "") {
                    $(".practice_name").show();
                }else if (practice_manager_name == "") {
                    $(".practice_manager_name").show();
                }

            }
        });

        $('#addEmployee').on('click', function () {
         
            var name = $("#name").val();
            var emailAddress = $("#emailAddress").val();
            var password = $("#password").val();
            
            if (name != "" && emailAddress != "" && password != "" ) {
                $("#loader").css("display", "block");
                setTimeout(function () {   
                  $.ajax({
                    type: 'post',
                    url: '<?php echo WEB_URL; ?>/ajax_call.php?page=addEmployee',
                    data: $('.newEmployee').serialize(),
                    success: function (result) {
                      if (result == 1) {
                        
                        // history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=initial-compliance-health-check-form");
                        history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=add-page");
                        $(".healthForm").hide();
                        $(".add-page").show();
                        $(".addEmployee").hide();
                        $(".info").hide();
                      }
                        $("#loader").css("display", "none");
                    }
                  });
                }, 1000);  
            }else{
                if (name == "" && emailAddress == "" && password == "" ) {
                    $(".name").show();
                    $(".emailAddress").show();
                    $(".password").show();
                    
                }
                if (name == "") {
                    $(".name").show();
                }else if (emailAddress == "") {
                    $(".emailAddress").show();
                }else if (password == "") {
                    $(".password").show();
                }

            }
        });
        
        
        $('#add-onboarding').on('click', function () {
            $("#loader").css("display", "block");
          setTimeout(function () { 
            
                        // $(".add-page").hide();
                        history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=add-page");
                        $(".add-page").show();
                        $(".addEmployee").hide();
                        // $(".info").hide();
        
                        // $(".add-page2").show();
                        $("#loader").css("display", "none");
                  
                
          }, 1000);
      });
      
      $('#add-page').on('click', function () {
            var practice_name = $("#prac_name").val();
            var name = $("#name").val();
            var email = $("#emailaddress").val();
            
            if (practice_name != "" && name != "" && email != "" ) {
                $("#loader").css("display", "block");
                setTimeout(function () {
                  
                        history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=add-page2");
                        $(".add-page2").show();
                        $(".add-page").hide();
                      
                        $("#loader").css("display", "none");
                    
                }, 1000);  
            }else{
                if (practice_name == "" && name == "" && email == "" ) {
                    $(".practice_name").show();
                    $(".name").show();
                    $(".emailaddress").show();
                    
                }
                if (practice_name == "") {
                    $(".practice_name").show();
                }else if (name == "") {
                    $(".name").show();
                }
                else if (email == "") {
                    $(".emailaddress").show();
                }

            }
        });
      
    //     $('#add-page').on('click', function () {
    //         $("#loader").css("display", "block");
    //       setTimeout(function () { 
            
    //                     // $(".add-page").hide();
    //                     history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=add-page2");
    //                     $(".add-page2").show();
    //                     $(".add-page").hide();
    //                     $(".info").hide();
        
    //                     // $(".add-page2").show();
    //                     $("#loader").css("display", "none");
                  
                
    //       }, 1000);
    //   });
      
      $('#onboard_page_main_next').on('click', function () {
           $("#loader").css("display", "block");
           setTimeout(function () { 

                    history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=healthForm");
                    $(".healthForm").show();
                    $(".add-page2").hide();
                        // $(".info").hide();
                    $("#loader").css("display", "none");
                
            }, 1000);  
        });
        
        $('#previousForm').on('click', function () {
        $("#loader").css("display", "block");
        setTimeout(function () {   
            history.pushState({}, null, "<?php echo WEB_URL ?>/practice-onboarding?page=practice-profile");
            $(".info").show();
            $(".addEmployee").hide();
            $("#loader").css("display", "none");
        }, 1000);  
        });
        
        

    });
    

</script>
        
<?php include_once('footer.php'); ?>