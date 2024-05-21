<?php 
include_once("global.php");
global $dbF,$webClass;
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Black Friday Deals',false);
}
include("header.php");

$contactAllow = true;
$pMmsg  = '';

if (isset($_POST['submit']) && !empty($_POST['form']['name'])) {
// var_dump($_POST);
 if (isset($_POST['g-fridayDeal'])) {
    $captcha = $_POST['g-fridayDeal'];
} else {
    $captcha = false;
}

// if (!$captcha) {
//   $pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
//     $contactAllow = false;
// } else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
         $pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
    $contactAllow = false;
    }else{

  if ($functions->getFormToken('fridayDeal')) {
$contactAllow = false;
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
$nameEmail =   $_POST['form']['email'];
$msg .= '<tr> <td>Date Time</td>  <td>' . date("D j M Y g:i a") . '</td> </tr>';
// $userId = $_SESSION['webUser']['id'];

// $acc_sql = "SELECT * FROM  `accounts_user` WHERE acc_id  = '$userId' ";
// $acc_data =  $this->dbF->getRow($acc_sql);
// $msg .= '<tr> <td>Refer By</td>  <td>(***Name -' . $aacc_data['acc_name'] . '***)(***Email -' . $acc_data['acc_email'] . '***)(Account ID -' . $acc_data['acc_id'] . '***)</td> </tr>';

// $msg .= '<tr> <td>Refer By</td>  <td>' . $nameUser . '</td> </tr>';

$msg .= '</table>';

$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("fridayDeal");
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);


$msg1 ='';
$dirr = __DIR__."/fridayDeal.txt";
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
$dirr = __DIR__."/fridayDeal.txt";
$myfile = fopen($dirr, "w");
fwrite($myfile, $msg1);
fclose($myfile);





            // $to = $this->functions->ibms_setting('Email');
            $toEmail ="booking@smartdentalcompliance.com";
// $toEmail = 'syeddak123@gmail.com';

$functions->send_mail($toEmail,'Refer a Gift Hamper',$msg);




// $user = intval($_SESSION['webUser']['id']);
$to =   $_POST['form']['email'];
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

 
$mailArray =    array();
     $mailArray['dealNumber']    =   $_POST['form']['deal'];

if($functions->send_mail($to,'','','fridayDeal',$nameUser,$mailArray)){
$contactAllow = false;
$pMmsg = "$thankT";
} else {

// $thankT = 'Thanku You ' . $nameUser . ' You Refer a Gift Hamper.';
$errorT = 'An Error occured while sending your mail. Please Try Later';
$contactAllow = true;
$pMmsg = "$errorT";
}


} else {
$contactAllow = true;
}
}
// }
}
?>

<!-- <link rel="stylesheet" type="text/css" href="<?php //echo WEB_URL ?>/css/black-day.css?magic=<?php //echo filemtime('./css/black-day.css')?>"> -->
<?php

//include_once("black-friday-popup.php");

?>

<!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc"></script> -->
<!--  <div id="pull-chain">
       
         <a href="" class="sales_">Get Black Friday Sale</a>
        <div class="handle remove_21" id ="pull"><img src="<?php //echo WEB_URL ?>/webImages/1211.png?123" alt=""></div>
    </div>
    <div class="mobile_view"><a href="#"><img src="<?php //echo WEB_URL ?>/webImages/11.gif" alt="">
    <img src="<?php //echo WEB_URL ?>/webImages/SALE2.png" alt="" class="sale" style="
    margin-left: -9px;
    margin-top: -10px;
"></a></div> -->
<div class="myevents-div myevents-div_Black">
<div class="myevents-form"><div class="referfriend">
<div class="event_details" id="myform">
<div class="form-lr">
<div class="form-left">


    <?php
if($contactAllow){

 

?>




<div class="deals">
    <div class="deal_txt">
    <h2>~~ BLACK FRIDAY SALE ~~</h2>
    </div>
    <div class="col8_main">
        <div class="col8_box">
            <div class="deals_r"> <h2>Deal 1</h2></div>
            <img src="<?php echo WEB_URL ?>/webImages/11.gif" alt="Deal 1">
             
                <ul>
                    <li>50% Discount on Mock Inspection<sub>[1a]</sub> </li>
                    <li>Free One Month sign up to the All In One Management Software<sub>[1b]</sub> </li>
                    <li>Free Demo</li>
                    <li>Free On Call Support</li>   
                </ul>
        </div>
        <div class="col8_box">
            <div class="deals_r"> <h2>Deal 2</h2></div>
           <img src="<?php echo WEB_URL ?>/webImages/11.gif" alt="Deal 2">
                <ul>
                    <li>3 months FREE subscription on the All In One Management software, with compliance, CPD Course, HR Management</li>
                    <li> Stock Management And Many More Features<sub>[2]</sub></li>
                    <li>A Gift Hamper</li>
                    <li>Free Demo</li>
                    <li>Free On Call Support</li>   
                </ul>
        </div>
        <div class="col8_box">
            <div class="deals_r"><h2>Deal 3</h2></div>
             <img src="<?php echo WEB_URL ?>/webImages/11.gif" alt="Deal 3">
                <ul>
                    <li>£100 off our platinum compliance package<sub>[3]</sub></li>
                    <li>A Gift Hamper</li>
                    <li>Free Demo</li>
                    <li>Free On Call Support</li>   
                </ul>
        </div>
        <div class="col8_box">
            <div class="deals_r"><h2>Deal 4</h2></div>
             <img src="<?php echo WEB_URL ?>/webImages/11.gif" alt="Deal 4">
                <ul>
                    <li>20% Off on all our in-house training courses<sub>[4]</sub> </li>
                    
                </ul>
        </div>
        
    </div>
    
</div>


<?php } ?>
<div class="form_side">


<?php
if($contactAllow){

 

?>

<h3>
   BLACK FRIDAY SALE FORM</h3> 
    </h2>

     <form method="post" autocomplete="off">
<?php $functions->setFormToken('fridayDeal'); ?>

       <input type="hidden" id="g-fridayDeal" name="g-fridayDeal">
    <input type="hidden" name="action" value="fridayDeal">



<div class="form-group col-sm-6">
<!--     <label></label> -->
<input class="" type="text" name="form[name]" value="" placeholder="Your Name" autocomplete="off" required>
</div>
<div class="form-group col-sm-6">
<!--     <label></label> -->
<input class="" type="text" name="form[practice name]" value="" placeholder="Your Practice Name"  autocomplete="off" >
</div>


<div class="form-group col-sm-6">
<!--     <label></label> -->
<input class="" type="text" name="form[contact]" value="" placeholder="Your Contact"  autocomplete="off" >
</div>
<div class="form-group col-sm-6">
<!--     <label></label> -->
<input class="" type="email" name="form[email]" value="" placeholder="Your Email"  autocomplete="off" >
</div>

<div class="form-group col-sm-6">
<select name="form[deal]">
    <option value="select deals" disable>------Select Deal-------</option>
    <option value="Deal 1">Deal 1</option>
    <option value="Deal 2">Deal 2</option>
    <option value="Deal 3">Deal 3</option>
    <option value="Deal 4">Deal 4</option>
</select>
</div>
<div id="recaptcha3" class="recaptcha3">
<input type="hidden" id="token" name="token">
</div>


<input type="submit" class="submit_class" value="Submit" name="submit" style="display: inline-block;">
 </form>

<?php
}
?>
 <?php if($pMmsg!=''){ ?>
<div class="col-sm-12 alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $pMmsg; ?>
</div>
<?php } ?>



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
/*.myevents-div{position:fixed;left:0%;right:0%;width:90%;max-width:1000px;margin:0 auto;top:50%;z-index:999;padding:20px 25px 25px;background:#fff;border-top:5px solid #01abbf;transform:scaleX(0) translateY(-50%);transition:.5s;max-height:90%;overflow-y:scroll} 

.myevents-div_ {
transform: scaleX(1) translateY(-50%);
}*/


.myevents-div {
transform: none;
position: unset;
border-top:none;
overflow-y: unset;
}


</style>
<div class="trem">
    <div class="standard">
    <ul>
        <li style="margin-bottom:10px;"><b>Terms and conditions</b></li>
        <li><sub>1a</sub>Only for practices based in London</li>
        <li><sub>1b</sub>Free one month sign up On SmartManage software</li>
        <li><sub>2</sub>The 3 free months would be added to the end of the 12 month contract you would take out for smartmanage software. For new clients only</li>
        <li><sub>3</sub>This is only for the first month payments</li>
        <li><sub>4</sub>only for practices within London</li>
        <li>Deals Validity Only Form 19th November Till 3rd December 2021</li>
    </ul>
    </div>
</div>
<?php include_once('footer.php'); ?>

<script>
// $(document).ready(function(){
//     $("#pull-chain").on("click", function(){
//         $(".handle").css("top","-200px");
//         alert("dfdsfe");
//         $(".sales_").css("top","0");
//     )};
// )};

$(".handle").click(function(){
         $(".handle").addClass("active");
         $(".handle").removeClass("remove_21");
          $("#pull-chain").addClass("active");
        $(".sales_").addClass("active");
    
});
</script>