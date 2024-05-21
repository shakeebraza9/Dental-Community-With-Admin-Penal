<?php
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


    global $dbF;
    global $db;
    global $functions;
    global $webClass;
?>

<!-- bg_inner -->
<?php 
function freeTrialSubmitForm()
{
    // return false;
    global $dbF;
    global $db;
    global $functions;
    global $webClass;
    if (isset($_POST['name']) && !empty($_POST['name'])
        && isset($_POST['email']) && !empty($_POST['email'])
    ){

       if(!$functions->getFormToken('signUpUser')){return false;}


        $useralreadyT = $dbF->hardWords('User Name/Email name already exist',false);
        $TryagainT = $dbF->hardWords('Try again. Or contact administrator.',false);
        $ThankWeSend = $dbF->hardWords('Thank you! We have sent verification email. Please check your email.',false);


        $sql = "SELECT * FROM accounts_user WHERE acc_email = '$_POST[email]'";
        $test   =   $dbF->getRow($sql);
        if($dbF->rowCount>0){
            $msg = "$useralreadyT <br /><br>";
            return $msg;
        }


        $DearT = $dbF->hardWords('Dear',false);
 /*       $ThankForRegT = $dbF->hardWords('Thank you for your registration to our website.',false);
        $verifyT = $dbF->hardWords('Please verify your account from the link below:',false);
        $YourVerifyT = $dbF->hardWords('Your verification code is',false);
        $AccVerifyT = $dbF->hardWords('Account Verification',false);
*/


        $thankYoumsg    =   $dbF->hardWords('Thank you for registering.',false);

        // if (isset($_POST["code"]) && $_POST["code"] != $_SESSION["rand_code"]) {
        //     $msg = $dbF->hardWords('Captcha Code Not Match Please Try Again',false);
        //     return $msg;
        // } else {
            try {
                $email = strip_tags(strtolower(trim($_POST['email'])));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $status = "1"; //pending 0 .. 1 active
                    $name   = empty($_POST['name'])  ? "" : $_POST['name'];
                    
                    $pName   = empty($_POST['signUp']['name_of_practice'])  ? "" : $_POST['signUp']['name_of_practice'];
                    $job_role   = empty($_POST['signUp']['job_role'])  ? "" : $_POST['signUp']['job_role'];
                    $phone   = empty($_POST['signUp']['phone'])  ? "" : $_POST['signUp']['phone'];
                    $postcode   = empty($_POST['signUp']['postcode'])  ? "" : $_POST['signUp']['postcode'];
                    $gdc   = empty($_POST['signUp']['gdc'])  ? "" : $_POST['signUp']['gdc'];
                    $address_of_practice   = empty($_POST['signUp']['address_of_practice'])  ? "" : $_POST['signUp']['address_of_practice'];
                    
                    $today  = date("Y-m-d H:i:s");
                    $dt = strtotime($today);
                    $expireOn=date("Y-m-d", strtotime("+1 week", $dt));

                    // if($pass != $rpass){
                    //     $msg = $dbF->hardWords('Password Not Matched!',false);
                    //     return $msg;
                    // }
                    // $password  =  $functions->encode($pass);
                     
                    $password  =  $functions->encode("welcome123");
                    $db->beginTransaction();
                    $sql = "INSERT INTO accounts_user SET
                                acc_name = ?,
                                acc_email = ?,
                                acc_pass = ?,
                                acc_type = '$status',
                                acc_created = '$today'";
                    $array = array($name,$email,$password);

                    $dbF->setRow($sql,$array,false);
                    $lastId = $dbF->rowLastId;

                    $setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

                    $sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
                    $arry       =   array();
                    foreach($setting as $key=>$val){
                        $sql .= "('$lastId',?,?) ,";
                        $arry[]= $key ;
                        $arry[]= $val ;
                    }
                    $sql = trim($sql,",");
                    $dbF->setRow($sql,$arry,false);
                   $sql2      =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES (?,?,?),(?,?,?),(?,?,?)";
                    $dbF->setRow($sql2,array($lastId,'user_type','Trial',$lastId,'account_type','Practice',$lastId,'date_of_expiry',$expireOn),false);
                    $code   = $webClass->vcode($name, $email);
                    $aLink  = WEB_URL . "/verify.php?a=" . urlencode($email);

                    $SincerelyT = $dbF->hardWords('Sincerely',false);
                    $msg  = "$DearT " . ucwords($name) . ".! <br> $thankYoumsg<br /><br>" . "\n";
                    $mailArray['link']        =   $aLink;
                    $mailArray['code']        =   $code;
                    $mailArray['pin']        =   "000000";
                    $mailArray['password']        =   "welcome123";
                    
                    
                    $functions->send_mail($email,'','','trialAccountCreated',$name,$mailArray);
                    //$msg = $msg;
                } else {
                    $AccLoginInfoT = $dbF->hardWords('Invalid Email Address!',false);
                    $msg = $AccLoginInfoT;
                    return $msg;
                }


                $db->commit();
                $loginReturn = $webClass->userLogin(false);
                if($loginReturn===true){
                    if(isset($_GET['ref']) && ($_GET['ref']=='cart' || $_GET['ref']=='cart.php')){
                        $loc = 'cart.php';
                    }else{
                        $loc = 'viewOrder.php';
                    }
                    echo '<script>
                    //location.replace("'.$loc.'");
                    </script>';
                }
                
                               
    $formType = "Trial Account Signup";

$tmp['form']['name']=$name;
$tmp['form']['practice_name']=$pName;
$tmp['form']['email']=$email;
$tmp['form']['phone']=$phone;
$tmp['form']['postcode']=$postcode;
$tmp['form']['gdc_number']=$gdc;
$tmp['form']['address_of_practice']=$address_of_practice;
$tmp['form']['job_role']=$job_role;
// $tmp['form']['accpunt_created']=$today;
$tmp['form']['account_expiry_date']=$expireOn;


$f = '';
$v = '';
$c = 1;
$arrayfd = array();

$msg1='<table border="1">';
foreach($tmp['form'] as $key=>$val){
if(is_array($val)){$val=implode(",",$val);}
$msg1.= '
<tr>
<td>'.ucwords(str_replace("_"," ",$key)).'</td>
<td>'.$val.'</td>
</tr>';
$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;
$arrayfd[]= $v;
$c++;
}

$msg1.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';
$msg1.='</table>';

$f = trim($f,",");

$sqlfd = "INSERT INTO  `formAllData` SET ";
 
$sqlfd .= $f.',type = ?';
$data2fd = array(str_replace(" ","_",@$formType));
$arrayfd = array_merge($arrayfd, $data2fd);
$dbF->setRow($sqlfd,$arrayfd,false);


$to = $functions->ibms_setting('Email');

$functions->send_mail($to, @$formType,$msg1);


                
                
                
                
                return $msg;
            } catch (PDOException $e) {
                $msg = "$useralreadyT <br /><br>
                    $TryagainT<br><br>";
                $db->rollBack();
                return $msg;
            }
        // }
    }
}

$msg = freeTrialSubmitForm();

?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up For Free Trial</title>
    <link rel="icon" href="https://smartdentalcompliance.com/webImages/favicon.ico?magic=1634280439" type="image/x-icon" />
<link rel="shortcut icon" href="https://smartdentalcompliance.com/webImages/favicon.ico?magic=1634280439" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/style.css?magic=<?php echo filemtime('./css/web_css/style.css')?>" />
</head>
<body>


  
<div class="newlogin_page">
    <div class="newlogin_page_main">
        <div class="newloginLeft">
        

         
        </div>
        <div class="newloginRight">
            <div class="newcontent_logo">
                <a href="<?php echo WEB_URL ?>">
                   <img src="webImages/logo.png" alt="">
                   </a>
            </div>
            <div class="newcontent_logo">
                <a href="<?php echo WEB_URL ?>">
                    <h1>Smart Dental<span>Compliance &amp; Training</span></h1>
                    <h4>Sign Up For Free Trial</h4>
                </a>
            </div>
            <!-- content_logo close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-danger" style="margin: 8px 0 0;padding: 8px;font-size: 15px;">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <form method="post">
                        <?php $functions->setFormToken('signUpUser'); ?>
                    <div class="branches_side_input">
                        <input type="text" name="signUp[name_of_practice]" placeholder="Name of the Practice">
                     
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="name" placeholder="First Name">
                        
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="signUp[surname]" placeholder="Surname">
                      
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="tel" name="signUp[job_role]" placeholder="Job Role">
                       
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="email" name="email" placeholder="Email">
                       
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="tel" name="signUp[phone]" placeholder="Phone #">
                       
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="signUp[postcode]" placeholder="Postcode">
                      
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                        <input type="hidden" name="signUp[gdc]" placeholder="GDC Number">
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <textarea name="signUp[address_of_practice]" placeholder="Address of the Practice"></textarea>
                        
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <input type="submit" class="submit_class_newlogin" value="SUBMIT INFORMATION">
                </form>
       
        </div>
        <!-- login-center -->
    </div>
</div>

    <!-- content_side -->
</body>
</html>