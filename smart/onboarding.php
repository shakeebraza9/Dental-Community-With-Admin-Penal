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
$userImage = $data['acc_image'];

// var_dump($_SESSION);

if($status > 6){
     header('Location: main_dashboard');
}

$sql2    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
$userInfo   = $dbF->getRows($sql2,array($user));

$hobbies = @$functions->webUserInfoArray($userInfo,'interests');
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
                            <a href="<?php echo WEB_URL ?>/onboarding?page=welcome-to-practice" data-status ="1" class="nextBtn"><?php $dbF->hardWords('Lets get you onboard',true); ?> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- login-center -->
                </div>
        <?php }
         if ( $status == 1) {
        
                $practiceName = $row['practice_name'];
                $message = unserialize($row['welcome_text']);
                $welcomeImage = WEB_URL."/images/".$row['welcome_image'];
             ?>
                 <div class="welcome-center">
                     <div class="onboardCross">
                        <a href="<?php echo WEB_URL ?>/main_dashboard"><img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop"></a>
                    </div>
                    <div class="welcome_txt">
                        
                        <h1>Welcome to (<?php echo $practiceName; ?>)</h1>
                        
                        <div class="welcome_img">
                            <?php if (!empty($row['welcome_image'])) {
                                        $image = $welcomeImage;         
                                    }else{
                                        $image = WEB_URL."/webImages/welcme.png";
                                    } 
                                ?>
                            <img src="<?php echo $image; ?>" >
                        </div>
                        <?php 
                            if(!empty($message)){
                                $text = $message;
                            }else{
                                $text = $dbF->hardWords('We want to welcome you on your first day ! we are very excited to have you at the practice. 
                                
        We embrace hard work, aren’t afraid of the competition and have a crystal clear vision for where we’re going. 
        
        With you joining this team of great people, we can accomplish anything. We’re so glad to have you on our team. 
        
        Welcome Abroad !!!
        ',false);
                            }
                        ?>
                        <div class="message"><?php echo nl2br($text); ?></div>
                        
                    </div>
                    <div class="welcome_btn">
                        <a href="<?php echo WEB_URL ?>/onboarding?page=upload-a-photo" data-status ="2" class="nextBtn"> <i class="fas fa-arrow-right"></i></a>
                    </div> 
                </div>
        <?php }
        // else if ((isset($page) )) {  
            if ($status == 2 ) {
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
                            <a href="<?php echo WEB_URL ?>/onboarding?page=welcome-to-practice" data-status ="1" class="previousBtn">
                                Previous
                            </a>
                            <a href="javascript:void(0)" id="uploadPhoto" data-status ="3" class="nextBtn">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="smile_txt">
                        <div class="smile_txt_inner">
                        <h2>Show us your gorgeous <span>Smile !</span> Upload a photo of yourself</h2>
                        <h3>This picture will help your teammates put a face to your name.</h3>
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
                            <h3><?php echo $_SESSION['webUser']['name']; ?></h3>
                            <h4><?php echo $_SESSION['webUser']['role']; ?></h4>
                        </div>
                    </div>
                </div>
        <?php 
         if ($status == 3) { 
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
                            <a href="javascript:void(0)" id="previousUploadForm" data-status ="2" class="previousBtn">
                                Previous
                            </a>
                            <a href="javascript:void(0)" id="formSubmit" data-status ="4" class="nextBtn">
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>.
                    </div>
                    <div class="info_txt">
                        <h2>Personal Information</h2>
                        <form id="myForm">
                            <div class="form_2_side">
                            <div class="form_1_side">First Name<span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="first_name" value="<?php echo $name; ?>" id="first_name" onchange="$('.first_name').hide();">
                                <div class="first_name" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Surame<span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[surname]" value="<?php echo @$functions->webUserInfoArray($userInfo,'surname') ?>" id="surname" onchange="$('.surname').hide();">
                                <div class="surname" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Nationality</div>
                            <!-- form_1_side close -->
                                <input type="text"  name="signUp[nationality]" value="<?php echo @$functions->webUserInfoArray($userInfo,'surname') ?>">
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Date of Birth<span>*</span></div>
                            <!-- form_1_side close -->
                                <input class="datepickerr" type="text" name="signUp[date_of_birth]" value="<?php echo @date("d-M-Y",strtotime($functions->webUserInfoArray($userInfo,'date_of_birth'))); ?>" id="date_of_birth"  onchange="$('.date_of_birth').hide();">
                                <div class="date_of_birth" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side_">
                            <div class="form_1_side">Personal Address</div>
                            <!-- form_1_side close -->
                                <textarea name="signUp[address]"><?php echo @$functions->webUserInfoArray($userInfo,'address') ?></textarea>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Role<span>*</span></div>
                            <!-- form_1_side close -->
                                <select  name="signUp[role]"  id="role" onchange="$('.role').hide();">
                                    <option value="">Select</option>
                                    <?php echo $webClass->accountRole(); ?>
                                </select>
                                <div class="role" style="display: none; color: red;">field value not select.</div>
                                <script>
                                    $(document).ready(function(){
                                        $("#role").val("<?php echo @$functions->webUserInfoArray($userInfo,'role'); ?>").change();
                                    });
                                </script>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Mobile Number<span>*</span></div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[phone]" value="<?php echo @$functions->webUserInfoArray($userInfo,'phone') ?>" id="phone" onchange="$('.phone').hide();">
                                <div class="phone" style="display: none; color: red;">field is empty</div>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side_">
                            <div class="form_1_side">About</div>
                            <!-- form_1_side close -->
                                <textarea name="signUp[about]"><?php echo @$functions->webUserInfoArray($userInfo,'about') ?></textarea>
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Non-Working Days</div>
                            <!-- form_1_side close -->
                                <?php 
                                    $daysss = $data['dayoff'];
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
                            <div class="form_2_side">
                            <div class="form_1_side">Weekly Working Hours</div>
                            <!-- form_1_side close -->
                                <input type="text"  name="signUp[hours_worked]" value="<?php echo @$functions->webUserInfoArray($userInfo,'hours_worked') ?>">
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">GDC Number</div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[gdc_number]" value="<?php echo @$functions->webUserInfoArray($userInfo,'gdc_number') ?>">
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side">
                            <div class="form_1_side">Scrub Size</div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[size]" value="<?php echo @$functions->webUserInfoArray($userInfo,'size') ?>">
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side hobbies">
                            <div class="form_1_side">Hobbies</div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[interests]"  id="tag-input1" >
                            </div>
                            <!-- form_2_side close -->
                            <div class="form_2_side skills">
                            <div class="form_1_side">Skills</div>
                            <!-- form_1_side close -->
                                <input type="text" name="signUp[skills]" id="tag-input2" >
                            </div>
                            <!-- form_2_side close -->
                             
                        </form>
                    </div>
                </div>
        <?php
         if ($status == 4 ) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        
         ?>        
                 <div class="info-center recruitment" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <img src="<?php echo WEB_URL ?>/webImages/profile3.png" >
                        </div>
                        <div class="info_btn">
                            <a href="javascript:void(0)" id="previousForm" data-status ="3" class="previousBtn">
                                Previous
                            </a>
                            
                            <a href="javascript:void(0)" id="recruitmentSubmit" >
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt recruitment_main">
                        <h2>Recruitment</h2>
                        <h4>Upload your recruitment documents.You can take a picture from the mobile app and attach it.</h4>
                         <?php
                            if (!empty($msg) && $status == 4 ) {
                                echo '<div class="alert alert-success">'.$msg.'</div>';
                            }
                             ?>
                        <div class="alert alert-danger docMissing" style="display:none;"><?php $dbF->hardWords("all documents are required!"); ?></div>
                        <div class="form_2_side">
                            <i class="fas fa-file"></i>
                            <h2>Proof Of Identification</h2>
                            <div class="recruitment_btn">
                                <?php  
                                $sql = "SELECT * FROM `userdocuments` WHERE `user`= ? AND  `title_id` =?";
                                $data = $dbF->getRow($sql,array($user,3311));
                                if ($dbF->rowCount > 0) {
                                ?>
                                <input type="hidden" value="1" class="proof">
                                 <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                            <?php }else{ ?>
                                <input type="hidden" value="0" class="proof">
                                 <button id='3311&user=<?php echo $user; ?>' type='button' onclick='documentInsert(this.id,"1")' >Upload <i class="fas fa-upload"></i></button>
                             <?php } ?>
                            </div>
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_2_side">
                            <i class="fas fa-file"></i>
                            <h2>DBS Number</h2>
                            <div class="recruitment_btn">
                                 <?php  
                                $sql = "SELECT * FROM `userdocuments` WHERE `user`= ? AND  `title_id` =?";
                                $data = $dbF->getRow($sql,array($user,9));
                                if ($dbF->rowCount > 0) {
                                ?>
                                <input type="hidden" value="1" class="dbs">
                                 <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                                <?php }else{ ?>
                                    <input type="hidden" value="0" class="dbs">
                                 <button id='9&user=<?php echo $user; ?>' type='button' onclick='documentInsert(this.id,"1")' >Upload <i class="fas fa-upload"></i></button>
                                 <?php } ?>
                            </div>
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_2_side">
                            <i class="fas fa-file"></i>
                            <h2>GDC Registration</h2>
                            <div class="recruitment_btn">
                                 <?php  
                                $sql = "SELECT * FROM `userdocuments` WHERE `user`= ? AND  `title_id` =?";
                                $data = $dbF->getRow($sql,array($user,8));
                                if ($dbF->rowCount > 0) {
                                ?>
                                <input type="hidden" value="1" class="gdc">
                                 <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                                <?php }else{ ?>
                                    <input type="hidden" value="0" class="gdc">
                                 <button id='8&user=<?php echo $user; ?>' type='button' onclick='documentInsert(this.id,"1")' >Upload <i class="fas fa-upload"></i></button>
                                 <?php } ?>
                            </div>
                        </div>
                        <!-- form_2_side close -->
                        <div class="form_2_side">
                            <i class="fas fa-file"></i>
                            <h2>References</h2>
                            <div class="recruitment_btn">
                                 <?php  
                                $sql = "SELECT * FROM `userdocuments` WHERE `user`= ? AND  `title_id` =?";
                                $data = $dbF->getRow($sql,array($user,10));
                                if ($dbF->rowCount > 0) {
                                ?>
                                <input type="hidden" value="1" class="reference">
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                                <?php }else{ ?>
                                    <input type="hidden" value="0" class="reference">
                                <button id='10&user=<?php echo $user; ?>' type='button' onclick='documentInsert(this.id,"1")' >Upload <i class="fas fa-upload"></i></button>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- form_2_side close -->
                    </div>
                </div>
        
                
        <?php 
        if ($status == 5 ) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        
            ?>
        <div class="info-center policy" style="<?php echo $style; ?>">
                    <div class="info_header">
                        <div class="info_img">
                            <img src="<?php echo WEB_URL ?>/webImages/profile4.png" >
                        </div>
                        <div class="info_btn">
                            <a href="javascript:void(0)" id="previousPage" data-status ="4" class="previousBtn">
                                Previous
                            </a>
                            
                            <a href="javascript:void(0)" id="policySubmit" >
                                Next
                            </a>
                            <a href="<?php echo WEB_URL ?>/main_dashboard" style="background-color: white !important;">
                                <img src="<?php echo WEB_URL ?>/webImages/10.png?magic=01" alt="" class="hvr-pop">
                            </a>
                        </div>
                    </div>
                    <div class="info_txt recruitment_main">
                        <h2>Your Almost done !</h2>
                        <h4>Read and sign the company policies.</h4>
                        <div class="alert alert-danger policyMissing" style="display:none;"><?php $dbF->hardWords("all policies are required!"); ?></div>
                        <?php 
                        // if($_SESSION['currentUserType'] == 'Employee'){
                        //     $pid = $functions->PracticeId($_SESSION['superid']);
                        // }
                        // else{
                            // $pid = $_SESSION['currentUser'];
                        // }
                        //  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                        //     $user = $_SESSION['superid'];
                        // }else{
                            $user = $_SESSION['currentUser'];
                            $currentUser = $_SESSION['webUser']['id'];
                        // }
                        $sql = "SELECT `signec_policies` FROM `practiceprofile` WHERE `user_id` =  ? ";
                        $row = $dbF->getRow($sql,array($user));
                        $policiesIds = $row['signec_policies'];
                        if (!empty($policiesIds)) {
                            
                        $signed_policy = explode(",",$policiesIds);
                        foreach ($signed_policy as $key => $value) {
                            
                         $data = $dbF->getRow("SELECT * FROM `documents` WHERE  `assignto` IN ('all','$user','all:$user') AND `category`='Signed Policies' AND `id` = $value");
                         $titleId = $data['id'];
                         $userdocuments = $dbF->getRow("SELECT * FROM `userdocuments` WHERE `user`='$currentUser' AND `title_id` = '$titleId' ");
                             
                        ?>
                        <div class="form_2_side">
                            <i class="fas fa-file"></i>
                            <h2><?php echo $data['title'] ?> <span>*</span></h2>
                            <div class="recruitment_btn">
                            <?php 
                            if ($dbF->rowCount > 0) {
                            ?>
                                <input type="hidden" value="1" class="policiesAll">
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                            <?php 
                            }else { ?>
                                <input type="hidden" value="0" class="policiesAll">
                                <button data-toggle='tooltip' title='Sign' id='<?php echo $titleId."&user=".$currentUser;  ?>' type='button' onclick='documentInsert(this.id,"1")' >Read and Sign <i class="fas fa-upload"></i></button>
                                
                            <?php } ?>
                            </div>
                        </div>
                    
        
                    <?php                        
                            }
                        }else{ ?>
                            <div class="alert alert-danger"><?php $dbF->hardWords('Policies not found.',true); ?></div>
                        <?php } ?>
                    </div>
                </div>   
        <?php 
        if ($status == 6) { 
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }   ?>
        
                <div class="onboard_page_main thankYou" style="<?php echo $style; ?>">
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
        
                            <h2><?php $dbF->hardWords('Thank You',true); ?></h2>
                            <h3><?php $dbF->hardWords('For Your Interest',true); ?></h3>
                        </div>
                        <div class="onboard_btn">
                            <a href="<?php echo WEB_URL ?>/main_dashboard" data-status ="7" class="nextBtn"><?php $dbF->hardWords('Lets get you dashboard',true); ?> <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- login-center -->
                </div>  
        <?php
         // }
        
         ?>
            </div>
        </div>
    </div>
    
<script src="<?php echo WEB_URL; ?>/js/tagplug.js"></script>
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
               var proof = $('.proof').val();   
               var dbs = $('.dbs').val();   
               var gdc = $('.gdc').val();   
               var reference = $('.reference').val();   
           
                   
              if ((proof == '1' && dbs == '1' && gdc == '1' && reference == '1') || status != 5) {


              $.ajax({
                
                url: '<?php echo WEB_URL; ?>/ajax_call.php?page=onboardStatus',
                cache: false,
                data: {status:status},                         
                type: 'post',
                success: function (result) {
                  if (result == 1) {
                    console.log(result);
                  }
                }
              });
          }
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
                    console.log(result);
                  }
                }
              });
        });

        $('#recruitmentSubmit').on('click', function () {
           $("#loader").css("display", "block");
           setTimeout(function () { 
               var proof = $('.proof').val();   
               var dbs = $('.dbs').val();   
               var gdc = $('.gdc').val();   
               var reference = $('.reference').val();   
              if (proof == '1' && dbs == '1' && gdc == '1' && reference == '1') {
                
                 $.ajax({
                    url: "<?php echo WEB_URL; ?>/ajax_call.php?page=signPoliciesCheck",
                    cache: false,
                    data: "",                         
                    type: 'post',
                    success: function (result) {
                      if (result == 1) {
                        history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=company-policies");
                        $(".policy").show();
                        $(".info").hide();
                        $(".recruitment").hide();
                        $(".smile-center").hide();
                      }else{
                        history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=thank-you");
                        $(".thankYou").show();
                        $(".policy").hide();
                        $(".info").hide();
                        $(".recruitment").hide();
                        $(".smile-center").hide();
                      }
                    }
                  });

              }else{
                $(".docMissing").show();
              }
                $("#loader").css("display", "none");
           
            }, 1000);  
        });

        $('#previousPage').on('click', function () {
            $("#loader").css("display", "block");
            setTimeout(function () {   
                history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=recruitment");
                $(".recruitment").show();
                $(".policy").hide();
                $(".info").hide();
                $(".smile-center").hide();
                $("#loader").css("display", "none");
            }, 1000);  
        });

        $('#policySubmit').on('click', function () {
           $("#loader").css("display", "block");
           setTimeout(function () { 
                var policiesValues = "";
               $(".policiesAll").each(function(){
                 policiesValues += $(this).val();
                
               });
               // console.log(policiesValues);
              if (policiesValues.includes(0)) {
                $(".policyMissing").show();

              }else{
                $.ajax({
                    url: '<?php echo WEB_URL; ?>/ajax_call.php?page=onboardStatus',
                    cache: false,
                    data: {status:6},                         
                    type: 'post',
                    success: function (result) {
                      if (result == 1) {
                        history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=thank-you");
                        $(".thankYou").show();
                        $(".policy").hide();
                        $(".info").hide();
                        $(".recruitment").hide();
                        $(".smile-center").hide();
                      }else{
                        console.log("errr");
                      }
                    }
                  });
                
              }
                $("#loader").css("display", "none");
           
            }, 1000);  
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
                
                url: '<?php echo WEB_URL; ?>/ajax_call.php?page=uploadPhoto',
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                
                success: function (result) {
                    
                  if (result == 1) {
                    history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=personal-information");
                    $(".info").show();
                    $(".recruitment").hide();
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
            history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=upload-a-photo");
            $(".smile-center").show();
            $(".recruitment").hide();
            $(".info").hide();
            $("#loader").css("display", "none");
        }, 1000);  
    });


    $(function () {

        $('#formSubmit').on('click', function () {
            var firstName = $("#first_name").val();
            var surName = $("#surname").val();
            var dateOfBirth = $("#date_of_birth").val();
            var role = $("#role").val();
            var phone = $("#phone").val();
            if (firstName != "" && surName != "" && dateOfBirth !="" && role !="" && phone != "") {
                $("#loader").css("display", "block");
                setTimeout(function () {   
                  $.ajax({
                    type: 'post',
                    url: '<?php echo WEB_URL; ?>/ajax_call.php?page=personalInfo',
                    data: $('#myForm').serialize(),
                    success: function (result) {
                      if (result == 1) {
                        history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=recruitment");
                        $(".info").hide();
                        $(".recruitment").show();
                        $("#loader").css("display", "none");
                      }
                    }
                  });
                }, 1000);  
            }else{
                if (firstName == "" && surName == "" && dateOfBirth == "" && role == "" && phone == "") {
                    $(".first_name").show();
                    $(".surname").show();
                    $(".date_of_birth").show();
                    $(".role").show();
                    $(".phone").show();
                }
                if (firstName == "") {
                    $(".first_name").show();
                }else if (surName == "") {
                    $(".surname").show();
                }else if (dateOfBirth == "") {
                    $(".date_of_birth").show();
                }else if (role == "") {
                    $(".role").show();
                }else if (phone == "") {
                    $(".phone").show();
                }

            }
        });

      });
    $('#previousForm').on('click', function () {
        $("#loader").css("display", "block");
        setTimeout(function () {   
            history.pushState({}, null, "<?php echo WEB_URL ?>/onboarding?page=personal-information");
            $(".recruitment").hide();
            $(".info").show();
            $("#loader").css("display", "none");
        }, 1000);  
    });



    var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate : false,
        max : 10
    });
    var tagInput2 = new TagsInput({
        selector: 'tag-input2',
        duplicate : false,
        max : 10
    });
    
    var arrayFromPHP = <?php echo json_encode($hobbiesArray); ?>;
    var arrayFromPHP2 = <?php echo json_encode($skillsArray); ?>;

    tagInput1.addData(arrayFromPHP);
    tagInput2.addData(arrayFromPHP2);

</script>
        
<?php include_once('footer.php'); ?>