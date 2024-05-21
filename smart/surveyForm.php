<?php
ob_start();
include_once("global.php");
global $webClass;
?><?php

$pMmsg = '';

$contactAllow = true;

$formNo = @$_GET['form'];
// if ($formNo == 1) {
//     $formType = "Feedback Survey";
// }else if ($formNo == 2) {
//     $formType = "Book 10 minutes catch up call";
// }else if ($formNo == 3) {
//     $formType = "Book a 15-minute onboarding session";
// }else if ($formNo == 4) {
//     $formType = "inquiryFormSubmit";
// }

if(isset($_POST) && !empty($_POST['form']) ){


 if (isset($_POST['g-contactFormSubmit'])) {
    $captcha = $_POST['g-contactFormSubmit'];
} 

 if(!$captcha){
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code kindly refresh page.',false);
        $contactAllow = false;
    }
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $responseKeys = json_decode($response,true);

     if(intval($responseKeys["success"]) !== 1) {
        
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code kindly refresh page.',false);
        $contactAllow = false;
    }else{


if($functions->getFormToken('generalFormSubmit')){

// $img="";
$f = '';
$v = '';
$c = 1;
$array = array();
$type = "";


// $msg='<table border="1">';
// var_dump($_POST['form']);

foreach($_POST['form'] as $key=>$val){
if($key == 'formType'){
    $type = $val;
}else if(is_array($val)){
    $temp = "";
   
    foreach($val as $key1 => $val1){
        if(!empty($val1)){
            $temp .=  $key1 == (sizeof($val) - 1) ? $val1 : $val1 .",";
        }
    }
    $f .= 'field'.$c.' = ?,';
    $v = ucwords(str_replace("_"," ",$key)).':'.$temp;
    $array[]= $v;
    $c++;
    // var_dump($temp);
    // exit();
}
else{

$f .= 'field'.$c.' = ?,';
$v = ucwords(str_replace("_"," ",$key)).':'.$val;
$array[]= $v;
$c++;
}
}

// var_dump("dsad");
//     exit();

// $msg.='<tr> <td>Date Time</td>  <td>'.date("D j M Y g:i a").'</td> </tr>';

// $msg.='</table>';



$f = trim($f,",");

$sql = "INSERT INTO  `surveyFormData` SET ";
 
$sql .= $f.', type = ?';
$data2 = array(str_replace(" ","_",@$type));
$array = array_merge($array, $data2);
$dbF->setRow($sql,$array,false);
if($dbF->rowCount > 0){
    $pMmsg = $dbF->hardWords('Your Feedback form has been submitted successfully.',false);
}else{
    $pMmsg = $dbF->hardWords('Form submission failed.',false);
}




// $to = $functions->ibms_setting('Email');

// $functions->send_mail($to, @$formType,$msg);



// $msg1 ='';

// foreach($_POST['form'] as $key=>$val){
// $msg1.= '
// <tr>
// <td>'.ucwords(str_replace("_"," ",$key)).'</td>
// <td>'.$val.'</td>
// </tr>';
// }
// $msg1.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
// $msg1.='</table>';
// $nameUser =   $_POST['form']['name'];

// $to =   $_POST['form']['email'];

// $thankT = $dbF->hardWords('Thanks for your interest. Our representative will get in touch with you.',false);

// $message2="Hello ".ucwords($nameUser).",<br><br>

// $thankT.<br><br>";

// if($functions->send_mail($to,'','','generalFormSubmit',$nameUser)){

// $pMmsg = $thankT;

// } else {

// $errorT = $dbF->hardWords('An Error occured while sending your mail. Please Try Later',false);

// $pMmsg = "$errorT";

// }

$contactAllow = false;

}else{

$contactAllow = true;

}


        
    }
}

// }else{
    


?>
<style>
    .option {
        display: inline-block;
        vertical-align: top;
        /* width: 207px; */
        color: #080808;
        font-size: 16px;
        padding-top: 5px;
        margin-left: 27px;
        }
    .question {
        vertical-align: top;
        /* width: 207px; */
        color: #080808;
        font-size: 16px;
        padding-top: 12px;
        }
    .form_1_side_{
        width : 205px !important;
    }
    input[type=email]{    
    border-radius: 45px !important;
    padding-left: 21px !important;
    }
</style>

<div class="inner_content">
<div class="text_side_left">
    <div class="standard">
    
<?php
if($pMmsg!=''){
echo "<div class='alert alert-info'>$pMmsg</div>";
}

include_once('surveyFormQuestion.php');


if($contactAllow){

    $login = $webClass->userLoginCheck();

    if($login){
        $id = intval($_SESSION['webUser']['id']);
        $sql = "SELECT acc.acc_name as name , acc.acc_email as email, A.setting_val as practiceName, B.setting_val as phone FROM `accounts_user_detail` as A, `accounts_user_detail` as B 
            JOIN `accounts_user` as acc ON B.id_user = acc.acc_id 
            Where A.setting_name = 'practice name' AND B.setting_name = 'phone' AND A.id_user = $id  AND B.id_user =$id ";
        $userData   =   $dbF->getRow($sql);            
        
    }
?>
        <div class="contact_detail">
            
            <div class="contact_right wow fadeInRight">
                <h5><?php echo @$formData[$formNo]['heading']; ?></h5>
                <div class="form_1_">
                    <form method="post">
                        <input type="hidden" name="form[formType]" value="<?php echo @$formData[$formNo]['type']; ?>"/>
                        <?php $functions->setFormToken('generalFormSubmit'); ?>

                         <input type="hidden"  id="g-contactFormSubmit" name="g-contactFormSubmit">
                         
                         <?php
                            foreach($formData[$formNo]['data'] as $key => $val){
                             
                                if($val['type'] == 'radio' || $val['type'] == 'checkbox'){ 
                                    $lable = $val["lable"];
                                    $type = $val['type'];
                                    $name = $val['type'] == 'radio' ? 'form['.$lable.']' : 'form['.$lable.'][]';
                                    $required = $val['type'] == 'radio' ? "required" : "";
                                    if($val['type'] == 'checkbox'){
                                        echo '<input type="hidden" name="'.$name.'" value="" >';
                                    }
                                    echo '
                                        <div class="options">
                                            <div class="question">
                                                '.($key+1) .'. '.$lable.'
                                            </div>';
                                            if(!empty($val['options'])){
                                                foreach($val['options'] as $key2=> $options){
                                                    echo '<div class="option">
                                                        <input type="'.$type.'" name="'.$name.'" value='.$options["value"].' '.$required.'> <label>'.$options["lable"].'</lable>
                                                    </div>';
                                                    
                                                }
                                            }
                                            
                                    echo '
                                        </div>
                                    ';
                                }
                              
                                if($val['type'] == 'rating'){ 
                                    $lable = $val["lable"];
                                    echo '
                                        <div class="options">
                                            <div class="question">
                                                '.($key+1) .'. '.$lable.'
                                            </div>';
                                           
                                        for($i = 1 ; $i <= 5 ; $i++){
                                            echo '<div class="option">
                                                <input type="radio" name="form[rating]" value='.$i.' required> <label>'.$i.' Star</lable>
                                            </div>';
                                            
                                        }
                                            
                                            
                                    echo '
                                        </div>
                                    ';
                                }
                                
                                if($val['type'] == 'text' || $val['type'] == 'email' || $val['type'] == 'textarea'){
                                    $lable = $val["lable"];
                                    $name = $val["name"];
                                    $type = $val["type"];
                                    $text = $val['type'] == 'text' ? true : false;
                                    $email = $val['type'] == 'email' ? true : false;
                                    $textarea = $val['type'] == 'textarea' ? true : false;
                                    $placeholder = $val["placeholder"];
                                    $value = $val["value"];
                                    echo'
                                    <div class="form_1_side_">'.($key+1) .'. '.@$lable.'</div>
                                    <div class="form_2_side_ hvr-shadow-radial">';
                                    
                                        if($text){
                                            echo '<input type="text" placeholder="'.@$placeholder.'" name="form['.$name.']" required value="'.@$value.'">';
                                        }else if($email){
                                            echo '<input type="email" placeholder="'.@$placeholder.'" name="form['.$name.']" required value="'.@$value.'">';
                                        }
                                        else if($textarea){
                                            echo '<textarea placeholder="'.@$placeholder.'" name="form['.$name.']" >'.@$value.'</textarea>';
                                        }

                                    echo '</div>';
                                }
                                
                                // if($val['type'] == 'email'){
                                //     $lable = $val["lable"];
                                //     $name = $val["name"];
                                //     $type = $val["type"];
                                //     $placeholder = $val["placeholder"];
                                //     $value = $val["value"];
                                //     echo'
                                //     <div class="form_1_side_">'.($key+1) .'. '.@$lable.'</div>
                                //     <div class="form_2_side_ hvr-shadow-radial">
                                //         <input type="email" placeholder="'.@$placeholder.'" name="form['.$name.']" required value="'.@$value.'">
                                //     </div>';
                                // }
                            }
                         
                         ?>
    
                        
                        <div class="form_1_side_">
                        </div>
                        
                        <div class="form_1_side_ mbl_side"></div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ form_1">
                            <input type="submit" class="submit_side" value="SUBMIT INFORMATION">
                        </div>
                        <!-- form_2_side close -->
                    </form>
                </div>
                <!-- form_1 close -->
            </div>
            <!-- contact_right close -->
        </div>
        <!-- contact_detail close -->
<?php
}
?>
</div>
    <!-- standard close -->
</div>
<!-- text_side_left close -->
<?php

// }

return ob_get_clean(); ?>