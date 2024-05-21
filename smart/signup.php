<?php
include_once("global.php");
include_once('header.php'); 
    global $dbF;
    global $db;
    global $functions;
    global $webClass;
?>
<div class="bg_inner" style="background-image: url(<?php echo WEB_URL ?>/images/box/2018/09/761-363-bg-inner.jpg);background-size: cover;">
<div class="standard">
<h1>SignUp</h1>
<ul>
<li><a href="<?php echo WEB_URL ?>">Home</a></li>
<li><i class="fas fa-chevron-right"></i></li>
<li><a href="javascript:;" class="inner_active">SignUp</a></li>
</ul>
</div>
</div>
<!-- bg_inner -->
<?php 
function signUpSubmit()
{ return false; exit();
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
                    $today  = date("Y-m-d H:i:s");

                    // if($pass != $rpass){
                    //     $msg = $dbF->hardWords('Password Not Matched!',false);
                    //     return $msg;
                    // }
                    // $password  =  $functions->encode($pass);

                    $db->beginTransaction();
                    $sql = "INSERT INTO accounts_user SET
                                acc_name = ?,
                                acc_email = ?,
                                acc_type = '$status',
                                acc_created = '$today'";
                    $array = array($name,$email);

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

                    $code   = $webClass->vcode($name, $email);
                    $aLink  = WEB_URL . "/verify.php?a=" . urlencode($email);

                    $SincerelyT = $dbF->hardWords('Sincerely',false);
                    $msg  = "$DearT " . ucwords($name) . ".! <br> $thankYoumsg<br /><br>" . "\n";
                    $mailArray['link']        =   $aLink;
                    $mailArray['code']        =   $code;
                    $functions->send_mail($email,'','','signUp',$name,$mailArray);
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

// $msg = signUpSubmit();

?>

<div class="content_side signup">
<div class="standard">
    <?php if($msg!=''){ ?>
    <div class="col-sm-12 alert alert-success">
        <?php echo $msg; ?>
    </div>
<?php } ?>
                <div class="form_side">
                    <form method="post">
                        <?php $functions->setFormToken('signUpUser'); ?>
                    <div class="branches_side_input">
                        <input type="text" name="signUp[name_of_practice]" placeholder="Name of the Practice">
                        <label for="Contact-Person">Name of the Practice</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="name" placeholder="First Name">
                        <label for="Designation">First Name</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="signUp[surname]" placeholder="Surname">
                        <label for="Surname">Surname</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="tel" name="signUp[job_role]" placeholder="Job Role">
                        <label for="Job Role">Job Role</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="email" name="email" placeholder="Email">
                        <label for="Email">Email</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="tel" name="signUp[phone]" placeholder="Phone #">
                        <label for="Phone-#">Phone #</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="signUp[postcode]" placeholder="Postcode">
                        <label for="Postcode">Postcode</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="text" name="signUp[gdc]" placeholder="GDC Number">
                        <label for="GDC Number">GDC Number</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <textarea name="signUp[address_of_practice]" placeholder="Address of the Practise"></textarea>
                        <label for="Address of the Practise">Address of the Practise</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <input type="submit" class="submit_class" value="SUBMIT INFORMATION">
                </form>
            </div><!-- form_side close -->
        </div><!-- standard close -->
    </div>
    <!-- content_side -->

<?php 
include_once('footer.php'); ?>