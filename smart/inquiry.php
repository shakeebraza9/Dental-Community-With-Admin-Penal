<?php

ob_start();

include_once("global.php");

global $webClass;

$pMmsg = '';

$contactAllow = true;

if(isset($_POST) && !empty($_POST) ){ ?>

<?php



if(isset($_POST["code"]) && $_POST["code"]!=$_SESSION["rand_code"]){

$pMmsg = $dbF->hardWords('Captcha Code Not Correct',false);

$contactAllow = true;

}

else{

if($functions->getFormToken('inquiryFormSubmit')){

$img="";



$msg='<table border="1">';

foreach($_POST['form'] as $key=>$val){

$msg.= '

<tr>

<td>'.ucwords(str_replace("_"," ",$key)).'</td>

<td>'.$val.'</td>

</tr>

';

}



// $subject = $_POST['form']['subject'];



$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

$msg.='</table>';



$to = $functions->ibms_setting('fEmail');

$functions->send_mail($to,'Feedback Form',$msg);



$nameUser =   $_POST['form']['name'];

$to =   $_POST['form']['email'];



$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";



if($functions->send_mail($to,'','','inquiryFormSubmit',$nameUser)){

$pMmsg = "$thankT";

} else {

$errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);

$pMmsg = "$errorT";

}

$contactAllow = false;

}else{

$contactAllow = true;

}

}

if($pMmsg!=''){

echo "<div class='alert alert-info'>$pMmsg</div>";

}



}

if($contactAllow){



$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";



?>
<!-- 
<form method="post" action="?submit=1">

<input type="text" placeholder="Name" name="form[Name]" class="name_class fx" required="required">
<input type="email" placeholder="Email" name="form[Email]" class="name_class fx" required="required">
<input type="tel" placeholder="Phone" name="form[Phone]" class="phone_class fx" required="required">
<textarea placeholder="Message" name="form[Message]" class="message_class fx" required="required"></textarea>
<input type="submit" name="submit" value="Submit Information" class="submit_class btn"> 


</form> -->


    <form method="post">

<?php $functions->setFormToken('inquiryFormSubmit'); ?>


<input type="text" placeholder="Name" name="form[name]" class="name_class fx" required="required">

<input type="email" placeholder="Email" name="form[email]" class="name_class fx" required="required">


<input type="tel" placeholder="Phone" name="form[Phone]" class="phone_class fx">



<textarea placeholder="Feedback" name="form[Feedback]" class="message_class fx" required="required"></textarea>


<input type="submit" name="submit" value="Submit Information" class="submit_class btn"> </form>

<?php

}
?>

<?php
return ob_get_clean(); ?>