<?php
ob_start();
include_once("global.php");
global $webClass;
?>

<?php

$pMmsg = '';

$contactAllow = true;

if(isset($_POST) && !empty($_POST['form']['name']) ){

 if (isset($_POST['g-featureFormSubmit'])) {
    $captcha = $_POST['g-featureFormSubmit'];
} else {
    $captcha = false;
}

if (!$captcha) {
  $pMmsg = $dbF->hardWords('Captcha Did Not Passed. Please Refill The Form.',false);
    $contactAllow = false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
         $pMmsg = $dbF->hardWords('Captcha Did Not Passed. Please Refill The Form.',false);
    $contactAllow = false;
    }else{

if($functions->getFormToken('featureFormSubmit')){

$img="";

$msg='<table border="1">';

foreach($_POST['form'] as $key=>$val){

$msg.= '

<tr>

<td>'.ucwords(str_replace("_"," ",$key)).'</td>

<td>'.$val.'</td>

</tr>';

}

if(isset($_FILES['file']) && ($_FILES["file"]["size"])>0) 
{
$replaced = str_replace(' ', '_', $_FILES["file"]["name"]);
$num=time().rand(10,9999);
$filename=$num.$replaced;
if ($_FILES["file"]["error"] > 0){
// echo "Return Code: ".$_FILES["file"]["error"]."<br />";
}
else{
if (file_exists("uploads/".$_FILES["file"]["name"])){}
else{
    move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/files/".$num.$replaced);
}
}
}
else{

}

//saadkhan4069@gmail.com

$file = empty($filename) ? '' : WEB_URL.'/uploads/files/'.$filename.'';

$filelink  = "<a href={$file}> Download file </a>";

$msg.='<tr> <td>File</td>   <td>'.$filelink.'</td> </tr>';

$msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

$msg.='</table>';
 
$to = $functions->ibms_setting('Email');

$functions->send_mail($to,'Request a feature form',$msg);

$nameUser =   $_POST['form']['name'];

$to =  $_POST['form']['email'];

$thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

$message2="Hello ".ucwords($nameUser).",<br><br>

$thankT.<br><br>";

if($functions->send_mail($to,'','','contactFormSubmit',$nameUser)){

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

}



}


if(true){

$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";

?>
             <div class="standard">
            <div class="LunchMain m-y-50">
                <div class="LunchfirstSec">
                    
                </div>
                <div class="LunchsecondSec">
                    <div class="SndSecInnerdiv">

                        <h1>Feature Form</h1>
                         <?php
                        if($pMmsg!=''){
                        echo "<div class='alert alert-info'>$pMmsg</div>";
                        }
                        ?>
                        <form method="post" autocomplete="No" enctype="multipart/form-data" >
                        <?php $functions->setFormToken('featureFormSubmit'); ?>
                         <input type="hidden" id="g-featureFormSubmit" name="g-featureFormSubmit">
                        <input type="hidden" name="action" value="featureFormSubmit">
                            
                            <div class="flexdiv">
                                           <select name="form[typeOfsuggetion]" required >
                                                <option value="" selected>Select type of suggestion</option>
                                                <option value="Feature">Feature</option>
                                                <option value="Functionality">Functionality</option>
                                                <option value="Improvement">Improvement</option>
                                                <option value="Bug">Bug</option>
                                            </select>
                        
                        
                                            <input type="text" name="form[NameOfSuggetion]" id="" placeholder="Enter the name of suggetion">
                        
                            </div>
                            <div class="flexdiv">
                                <input type="file" name="file" id="" placeholder="Add an attachment/screenshot">
                                <input type="text" name="form[link]" id="" placeholder="Add link">
                            </div>
                        
                            <div class="flexdiv">
                                <input type="number" min="1" max="10" name="form[SuggetionImportants]" id="" placeholder="How important is your suggetion" required>
                                <input type="text" name="form[name]" id="" placeholder="Your Name" required>
                            </div>
                            <div class="flexdiv">
                                <input type="email" name="form[email]" id="" placeholder="Your email" required>
                                <input type="text" name="form[Contact]" id="" placeholder="Your Phone" >
                            </div>
                           
                            <div class="flexdiv">
                                <textarea name="form[SuggetionDetail]" id="" cols="30" rows="8" placeholder="Please describe your suggetion" required></textarea>

                            </div>
                             <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>  
                                        <input type="submit" class="submit_side" value="Submit">

                        </form>
                    </div>
                </div>
            </div>
        </div>


<?php
}
?>
<?php
return ob_get_clean(); ?>