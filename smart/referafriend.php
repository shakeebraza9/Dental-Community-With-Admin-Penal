<?php 
include_once("global.php");
global $dbF,$webClass;
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Refer a friend',false);
}
include("header.php");


$contactAllow = true;
$pMmsg  = '';

if (isset($_POST['submit']) && !empty($_POST['form']['name'])) {
// var_dump($_POST);
 if (isset($_POST['g-referfriendSubmitWOLOGIN'])) {
    $captcha = $_POST['g-referfriendSubmitWOLOGIN'];
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


if ($functions->getFormToken('referfriendSubmitWOLOGIN')) {

$img = "";

$f = '';
$v = '';
$c = 1;
$array = array();
$msg = '<table border="1">';

foreach ($_POST['form'] as $key => $val) {

$msg .= '

<tr>

<td>' . ucwords(str_replace("_", " ", $key)) . '</td>

<td>' . $val . '</td>

</tr>';



$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;


$array[]= $v;



$c++;



}
$nameUser =   $_POST['form']['name'];
$msg .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';


// $userId = $_SESSION['webUser']['id'];

// $acc_sql = "SELECT * FROM  `accounts_user` WHERE acc_id  = '$userId' ";
// $acc_data =  $this->dbF->getRow($acc_sql);


// $msg .= '<tr> <td>Refer By</td>  <td>(***Name -' . $aacc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';

$msg .= '<tr> <td>Refer By</td>  <td>' . $nameUser . '</td> </tr>';

$msg .= '</table>';




$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("referfriendSubmitWOLOGIN");
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);




// $user = intval($_SESSION['webUser']['id']);


// $to =   $_POST['form']['email'];
$date = Date('Y-m-d');
$currentDate =  date('Y-m-d', strtotime($date));
// $sql = "DELETE FROM referfriend WHERE `user` = '$user'";
// $this->dbF->setRow($sql);

// $sql  = "INSERT INTO `referfriend` (`user`,`fill`,`show_popup`,`datetime`) VALUES (?,?,?,?)";
// $array   = array($user, '1', '1', $currentDate);
// $this->dbF->setRow($sql, $array, false);
$thankT = 'Thank You ' . $nameUser . ' You Refer a Gift Hamper.';

$message2 = "Hello " . ucwords($nameUser) . ",<br><br>

$thankT.<br><br>";

$too = $functions->ibms_setting('Email');


$msg1 ='';
$dirr = __DIR__."/referfriendSubmitWOLOGIN.txt";
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
$dirr = __DIR__."/referfriendSubmitWOLOGIN.txt";
$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1);
fclose($myfile);




// $too = 'syeddak123@gmail.com';

// $this->send_mail($too,'Refer a Gift Hamper',$msg);
// $this->send_mail($to,'Refer a Gift Hamper',$nameUser)
if ($functions->send_mail($too, 'Refer a Gift Hamper', $msg)) {

$pMmsg = "$thankT";
} else {

$thankT = 'Thanku You ' . $nameUser . ' You Refer a Gift Hamper.';
$errorT = 'An Error occured while sending your mail. Please Try Later';

$pMmsg = "$errorT";
}

$contactAllow = false;
} else {
$contactAllow = true;
}

}

}


}





?>
<!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc"></script> -->
<div class="myevents-div">
<div class="myevents-form"><div class="referfriend">
<div class="event_details" id="myform">
<div class="form-lr">
<div class="form-left">
<img src="<?php echo WEB_URL ?>/webImages/refer.jpeg" alt="">
<div class="form_side">
<h3>
   Refer a Friend and Get a Luxury Hamper </br> </h3> 
      <h2>The referred practice would get 10% off their subscription.
    </h2>
     <form method="post">
          <?php $functions->setFormToken('referfriendSubmitWOLOGIN'); ?>


                         <input type="hidden" id="g-referfriendSubmitWOLOGIN" name="g-referfriendSubmitWOLOGIN">
    <input type="hidden" name="action" value="referfriendSubmitWOLOGIN">




                  <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="text" name="form[name]" value="" placeholder="Your Name" autocomplete="off" required>
                        </div>
                 <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="text" name="form[practicename]" value="" placeholder="Your Practice Name"  autocomplete="off" >
                        </div>


                           <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="text" name="form[contact]" value="" placeholder="Your Contact"  autocomplete="off" >
                        </div>




        <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="hidden"   placeholder=" "  autocomplete="" >
                        </div>
<!-- <hr> -->


                  <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="text" name="form[referPracticeName]" value="" placeholder="Refer Practice Name"  autocomplete="off" >
                        </div>


                           <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="text" name="form[referContact]" value="" placeholder="Refer Contact"  autocomplete="off" >
                        </div>




             



                 <div class="form-group col-sm-6">
                        <!--     <label></label> -->

                            <input class="" type="text" name="form[referAddress]" value="" placeholder="Refer Address"  autocomplete="off" >
                        </div>


    <div class="form-group col-sm-6">
                        <!--     <label></label> -->
                            <input class="" type="hidden"   placeholder=" "  autocomplete="" >
                        </div>
 


   <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>


<?php if($pMmsg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $pMmsg; ?>
</div>
<?php } ?>


                     
                         <input type="submit" class="submit_class" value="Refer" name="submit" style="display: inline-block;">
               </form>
            </div>
            <!-- form_side -->
        </div>
        <!-- form-left -->
    
    </div>
    <!-- form-lr -->
</div>
<!-- event_details -->
</div>
<!-- Referfriend -->
</div>
</div>



<style type="text/css">

    .myevents-div{
        position:unset;
        left:0%;right:0%;width:90%;max-width:1000px;margin:0 auto;top:50%;z-index:999;padding:100px 25px 70px;background:#fff;border-top:none;
   transform: none;
transition:.5s;max-height:90%;overflow-y:unset}

.col10 .col1_btn{display: none;}
.referfriend .form_side h3{
padding-top: 22px;
    font-size: 22px;

width: unset;

}

.referfriend .form_side h2{

   

    width: unset;
   font-size: 16px;
    margin: 0 auto 10px;
    color: #f2701d;
    font-weight: 600;
    padding-bottom: 15px;
}

.myevents-div .form_side input[type="email"],
.myevents-div .form_side input[type="date"],
.myevents-div .form_side input[type="time"],
.myevents-div .form_side input[type="text"],
.myevents-div .form_side input[type="number"],
.myevents-div .form_side select {
    width: 100%;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #666;
    padding: 5px 8px;
    font-size: 15px;
    height: 38px;
    border-radius: 5px;
}

.myevents-div .form_side input[type="color"] {
    border: 1px solid #ccc;
    width: 80px;
    padding: 5px;
    background-color: #fff;
    height: 38px;
}

 
.col1_btn_main {
    top: 40vh;


}

.submit_class {
     height: 50px !important;
  line-height: 50px !important;
  width: 36%;
  color: #fff;
  font-size: 20px;
  text-align: center;
  font-family: "poppinsbold";
  transition: 0.7s;
  border-radius: 30px 30px;
  border: none !important;
  margin-top: 10px;
  cursor: pointer;
  background: #b93895;
}
.submit_class:hover {
 background: #f2701d;
}

@media screen and (max-width: 767px) {
 .referfriend .form-group {
    width: 100%;
    max-width: 100%;

 }

 .referfriend .form_side h3 {
 

    font-size: 20px;
   

}


}
 @media screen and (max-width: 461px){
.referfriend .form_side h3 {
    font-size: 14px;
}}


</style>


<?php include_once('footer.php'); ?>