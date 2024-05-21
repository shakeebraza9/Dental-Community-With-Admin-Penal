<?php

class web_functions extends  object_class
{
use common_function;
private $hasSeo;

function __construct()
{ 
parent::__construct('3');
$this->setMultiLanguage();
/*Header for Swedish Words , donot define meta utf 8 tag*/
//header('Content-Type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=latin1');
//return webUser Data
$currentUser = webUserSession();


/**
* MultiLanguage keys Use where echo;
* define this class words and where this class will call
* and define words of file where this class will called
**/
global $_e;
$_w=array();
$_w['Loading'] = '' ;
$_w['Like our Facebook Page'] = '' ;
$_w['Follow us on Twitter'] = '' ;
$_w['Follow us on Linkedin'] = '' ;
$_w['LogOut'] = '' ;
$_w['Search'] = '' ;
$_w['WELCOME'] = '' ;
$_w['Subscribe to our Youtube Channel'] = '' ;
$_w['All right reserved'] = '' ;
$_w['Customer Support'] = '' ;
$_w['SUBSCRIBE'] = '' ;
$_w['Enter Email'] = '' ;
$_w['Categories'] = '' ;
$_w['OUR SOCIAL NETWORKS'] = '' ;
$_w['Filter Search'] = '' ;
$_w['Enter Your Email.'] = '';
$_w['Subscribe Now'] = '';
$_w['Cart'] = '' ;
$_w['KUNDSERVICE'] = '' ;
$_w['Need Help'] = '' ;
$_w['Link'] = '' ;
$_w['CHECKOUT'] = '' ;
$_w['LOGIN'] = '' ;
$_w['REGISTER'] = '' ;
$_w['VIEW CART'] = '' ;
$_w['Links'] = '' ;
$_w['Return Policy'] = '' ;
$_w['Shipping Info'] = '' ;
$_w['About Us'] = '' ;
$_w['Home'] = '' ;
$_w['CONTACT US'] = '' ;
$_w['Follow Us'] = '' ;
$_w['FAQ'] = '' ;
$_w['LATEST NEWS'] = '' ;
$_w['Subscribe to Our Newsletter'] = '' ;
$_w['Thank You For Subscribe.'] = '' ;
$_w['Subscribe Fail, You Already Subscribe.'] = '' ;
$_w['Send'] = '' ;
$_w['CUSTOMER SUPPORT'] = '' ;
$_w['MY SHOPPING CART'] = '' ;
$_w['Select Language'] = '' ;
$_w['Member Login'] = '' ;
$_w['CONTINUE SHOPPING'] = '' ;
$_w['SELECT YOUR COUNTRY'] = '' ;
$_w['Your Currency'] = '' ;
$_w['Total'] = '' ;
$_w['SHOPPING CART'] = '' ;
$_w['SUMMARY'] = '' ;
$_w['Quantity'] = '' ;
$_w['No Of Items'] = '' ;
$_w['Catagories'] = '' ;
$_w['Nutritional Information'] = '' ;
$_w['SUMMARY'] = '' ;
$_w['Best Seller'] = '' ;
$_w['FOLLOW US'] = '' ;
$_w['Newsletter Sign up'] = '' ;
$_w['Follow us:'] = '' ;
$_w['Follow us:'] = '' ;
$_w['Sign-up for latest news, exclusive offers, health and cooking tips from Falak Rice.'] = '' ;
$_w['Our Product Range'] = '' ;

$_e    =   $this->dbF->hardWordsMulti($_w,currentWebLanguage(),'Website');


}

public function p404(){
header("Location: ".WEB_URL."/data/404");
}

public function ibms_setting($name){
return $this->functions->ibms_setting($name);
}

public function hardWords($en,$echo = true){
return $this->dbF->hardWords($en,$echo);
}

public function get_searchVal(){
if(isset($_GET['s']) && $_GET['s'] != '')
return $_GET['s'];
return "";
}
/**
* @param $image
* @param string $width
* @param string $height
* @param bool $echo
* @param bool $cache
* @param bool $imageWithWebUrl
* @return string
* Bing image to small, not small to big
*/
public function resizeImage($image,$width='auto',$height='auto',$echo = true,$pngBgColor=false,$imageWithWebUrl=true,$cache=true){
//It has one setting also in src/image.php development folder name
return $this->functions->resizeImage($image,$width,$height,$echo,$pngBgColor,$imageWithWebUrl,$cache);
}

public function webUserId(){
return webUserId();
}
public function webUserOldTempId(){
$userData   = webUserSession();
return $userData['oldTempId'];
}

public function webTempUserId(){
return webTempUserId();
}

public function userLoginCheck(){
return userLoginCheck();
}

public function userLogin($checkToken=true){
if (isset($_POST['email']) && !empty($_POST['email'])
&& isset($_POST['pass']) && !empty($_POST['pass'])
){
if($checkToken==true){
if(!$this->functions->getFormToken('signInUser')){return false;}
}

$email  = $_POST['email'];
$pass   = $_POST['pass'];

$user   = hash("md5", $email);
$pass   = hash("md5", $this->functions->encode($pass));

$sql = "SELECT * FROM `accounts_user` WHERE MD5(acc_email)=? && MD5(acc_pass)=? AND acc_type != '0'";
$data=$this->dbF->getRow($sql,array($user,$pass));

if ($this->dbF->rowCount>0) {
$this->cartUpdateTempUser($data);
$this->cartWishListUpdateTempUser($data);
$this->create_webLogin_session($data);

$_SESSION['webUser']['remember'] = '0';
if(isset($_POST['remember'])){
$_SESSION['webUser']['remember'] = '1';
setRememberMe("webUser",$_SESSION['webUser'],90);
}
return true;
} else {
    $sql = "SELECT * FROM `accounts_user` WHERE MD5(acc_email)= ? ";
    $data=$this->dbF->getRow($sql,array($user));
    if ($this->dbF->rowCount>0) {
        $var = $this->dbF->hardWords('Please Login to Your Account.',false);
        return $var;
    }
    else{
        $var = $this->dbF->hardWords('Account Not Found Or Account Not Verified',false);
        return $var;
    }
}
}
}

public function userLoginApi($inputData){
if (isset($inputData['email']) && !empty($inputData['email'])
&& isset($inputData['pass']) && !empty($inputData['pass'])
){
// if($checkToken==true){
// if(!$this->functions->getFormToken('signInUser')){return false;}
// }

$email  = $inputData['email'];
$pass   = $inputData['pass'];

$user   = hash("md5", $email);
$pass   = hash("md5", $this->functions->encode($pass));

$sql = "SELECT * FROM `accounts_user` WHERE MD5(acc_email)=? && MD5(acc_pass)=? AND acc_type != '0'";
$data=$this->dbF->getRow($sql,array($user,$pass));

if ($this->dbF->rowCount>0) {
$this->cartUpdateTempUser($data);
$this->cartWishListUpdateTempUser($data);
$this->create_webLogin_session($data);

$_SESSION['webUser']['remember'] = '0';
if(isset($_POST['remember'])){
$_SESSION['webUser']['remember'] = '1';
setRememberMe("webUser",$_SESSION['webUser'],90);
}
return true;
} else {
    $sql = "SELECT * FROM `accounts_user` WHERE MD5(acc_email)= ? ";
    $data=$this->dbF->getRow($sql,array($user));
    if ($this->dbF->rowCount>0) {
        $var = $this->dbF->hardWords('Please Login to Your Account.',false);
        return $var;
    }
    else{
        $var = $this->dbF->hardWords('Account Not Found Or Account Not Verified',false);
        return $var;
    }
}
}
}

public function userLogOut($sessionDestroy = false){
if($sessionDestroy){
session_unset();
session_destroy();
}else{
$_SESSION['webUser'] = 'logout';
}
}

public function create_webLogin_session($data){
$_SESSION['webUser']['login']   =   '1';
$_SESSION['webUser']['id']      =   $data['acc_id'];
$_SESSION['webUser']['oldTempId']      =   $_SESSION['webUser']['tempId'];
$_SESSION['webUser']['tempId']  =   "";
$_SESSION['webUser']['email']   =  $data['acc_email'];
$_SESSION['webUser']['name']    =  $data['acc_name'];
$_SESSION['webUser']['type']    =  $data['acc_type'];
$_SESSION['webUser']['image']    =  $data['acc_image'];
$_SESSION['webUser']['backup_login_id']      =   $data['acc_id'];
         
$sql2  = "SELECT setting_val FROM accounts_user_detail WHERE id_user = ? AND setting_name = ? ";
$data2 = $this->dbF->getRow($sql2,array($data['acc_id'],'role'));
//var_dump($data2);
if($this->dbF->rowCount>0){

$_SESSION['webUser']['role']   = $data2['setting_val'];
}
$sql2  = "SELECT * FROM accounts_user_detail WHERE id_user = ? AND setting_name = ? ";
$data2 = $this->dbF->getRow($sql2,array($data['acc_id'],'account_type'));
//var_dump($data2);
if($this->dbF->rowCount>0){

    if ($data2['setting_val'] == 'Practice') {


$_SESSION['webUser']['backup_Practice_id']   = $data2['id_user'];

}
}

$sql1  = "SELECT * FROM accounts_user_detail WHERE id_user = ? AND setting_name =?";
$data1 = $this->dbF->getRow($sql1,array($data['acc_id'],'user_type'));
if($this->dbF->rowCount>0){
$user_type = $data1["setting_val"];
}else{
$user_type = false;
}
$_SESSION['webUser']['user_type']    =  $user_type;

$sql2  = "SELECT * FROM accounts_user_detail WHERE id_user = ? AND setting_name = ?";
$data2 = $this->dbF->getRow($sql2,array($data['acc_id'],'account_type'));
if($this->dbF->rowCount>0){
$account_type = $data2["setting_val"];
}else{
$account_type = false;
}
$_SESSION['webUser']['account_type'] =  $account_type;

}

public function cartUpdateTempUser($data){
if($this->functions->developer_setting('product')=='1'){
$userId     =   $data['acc_id'];
$userData   =   webUserSession();
$tempId     =   $userData['tempId'];

$sql = "UPDATE `cart` SET userId = ?, tempUser  = '' WHERE `tempUser`= ?";
$this->dbF->setRow($sql,array($userId,$tempId));
}
}

public function cartWishListUpdateTempUser($data){
if($this->functions->developer_setting('product')=='1'){
$userId     =   $data['acc_id'];
$userData   =   webUserSession();
$tempId     =    $userData['tempId'];

$sql = "UPDATE `cartwishlist` SET userId = ?, tempUser  = '' WHERE `tempUser`= ?";
$this->dbF->setRow($sql,array($userId,$tempId));
}
}

/**
* @param string columnsNames
* @return BannersData
*/
public function web_banners( $columns='*',$publish = true, $limit = null ){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
# if limit is given then apply it.
$limit     = ( $limit != NULL ) ? $limit : ''; 
$sql       =   "SELECT $columns FROM banners $where  ORDER BY sort ASC {$limit} ";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {

//get title and set into data so developer no need to translate it
if(isset($val['banner_heading'])) {
    $title = getTextFromSerializeArray($val['banner_heading']);
    $data[$i]['title'] = $title;
}

//get shortDesc and set into data so developer no need to translate it
if(isset($val['banner_shrtDesc'])) {
    $desc = getTextFromSerializeArray($val['banner_shrtDesc']);
    $data[$i]['text'] = $desc;
}
if(isset($val['layer0'])) {
$temp = getTextFromSerializeArray($val['layer0']);
$data[$i]['layer0'] = $this->addWebUrlInLink($temp);
}

// if(isset($val['layer1'])) {
//     $temp = getTextFromSerializeArray($val['layer1']);
//     $data[$i]['layer1'] = $this->addWebUrlInLink($temp);
// }

if(isset($val['layer2'])) {
    $temp = getTextFromSerializeArray($val['layer2']);
    $data[$i]['layer2'] = $this->addWebUrlInLink($temp);
}

if(isset($val['layer3'])) {
    $temp = getTextFromSerializeArray($val['layer3']);
    $data[$i]['layer3'] = $temp;
}

//LINK
if(isset($val['banner_link'])) {
    $data[$i]['link'] = $this->addWebUrlInLink($val['banner_link']);
}
$i++;
}
}
return $data;
}








/**
* @param string $columns
* @param bool $publish
* @return MultiArray
*/
public function web_sliderflag($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/


if($publish){
$where = " WHERE publish = '1' ";
}else{
$where = '';
}


// if ($cat == "all") {


// $where = '';
    
//  # code...
// }else{
// $where .= "and shortDesc = '$cat'";
// }




$sql       =   "SELECT $columns FROM tabs $where  ORDER BY sort ASC";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
@$title      =   getTextFromSerializeArray($val['tabs_heading']);
$data[$i]['title'] =   $title;

// get shortDesc and set into data so developer no need to translate it
@$desc      =   getTextFromSerializeArray($val['tabs_shrtDesc']);
$data[$i]['text'] =   $desc;

//LINK
$data[$i]['link']   =   $val['tabs_link'];
$i++;
}
}
return $data;
}




/**
* @param string $columns
* @param bool $publish
* @return MultiArray
*/
public function web_slider($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM newslider $where  ORDER BY sort ASC";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
@$title      =   getTextFromSerializeArray($val['brand_heading']);
$data[$i]['title'] =   $title;

//get shortDesc and set into data so developer no need to translate it
@$desc      =   getTextFromSerializeArray($val['brand_shrtDesc']);
$data[$i]['text'] =   $desc;

//LINK
$data[$i]['link']   =   $val['brand_link'];
$i++;
}
}
return $data;
}
public function web_sliderDiv(){
$brands = $this->web_slider();
$temp = '';
foreach($brands as $val){


$image    =   WEB_URL."/images/".$val['image'];
$link     =   $val['link'];
$text     =   $val['text'];
$title    =   $val['title'];

$temp   .= '
<div class="owl1_inner">
<div class="owl1_img"> <img src="'.$image.'" alt="">
<h3>'.$title.'</h3> </div>
<div class="owl1_txt">
<div class="pg"> '.$text.'</div> <a href="'.$link.'">More info<i class="fas fa-chevron-right"></i></a> </div>
</div>';
}
return $temp;
}



public function web_all_prints($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM fm_news $where  ORDER BY id desc";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
@$title      =   getTextFromSerializeArray($val['heading']);
$data[$i]['title'] =   $title;

//get shortDesc and set into data so developer no need to translate it
@$desc      =   getTextFromSerializeArray($val['dsc']);
$data[$i]['text'] =   $desc;

@$desc      =   getTextFromSerializeArray($val['shortDesc']);
$data[$i]['shortDesc'] =   $desc;


//LINK
// $data[$i]['link']   =   $val['brand_link'];
$i++;
}
}
return $data;
}


public function all_prints(){
$brands = $this->web_all_prints();
$temp = '';
foreach($brands as $val){


// $image    =   WEB_URL."/images/".$val['image'];
$id    = $val['id'];

$countrt     =   $val['shortDesc'];
$text     =   $val['text'];
$title    =   $val['title'];

$temp   .= '

<tr>
            <td>'.$title.'</td>
            <td>'.$text.'</td>
            <td>'.$countrt.'</td>
            <td><a href="'.WEB_URL.'/page-apply-online&cat='.$id.'" target="_blank"><img src="http://www.yourmortgagenow.ca/wp-content/uploads/2016/02/button.png" style="
    width:  100px;
    padding:  5px 0px;
"></a>



            </td>
        </tr>
';
}
return $temp;
}



public function web_flag(){



// var_dump($cats);

$brands = $this->web_sliderflag();
$temp = '';
foreach($brands as $val){


$image    =   WEB_URL."/images/".$val['image'];

$link     =   $val['tabs_link'];
$text     =   $val['text'];
$title    =   $val['title'];

$temp   .= '<div class="col6_box">
 <a href="'.$link.'">
<div class="col6_box_img"> <img src="'.$image.'" alt="'.$title.'"> </div>
<!-- col6_box_img close -->
<div class="col6_box_txt">
<h4>'.$title.'</h4>
<div class="col6_box_txt_main"> '.$text.' </div>
<!-- col6_box_txt_main close -->
</div>
<!-- col6_box_txt close -->
</a>
</div>
<!-- col6_box close -->';
}
return $temp;
}



/**
* @param string $columns
* @param bool $publish
* @return MultiArray
*/
public function web_brands($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM brands $where  ORDER BY id DESC";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
// @$title      =   getTextFromSerializeArray($val['brand_heading']);
// $data[$i]['title'] =   $title;

//get shortDesc and set into data so developer no need to translate it
// @$desc      =   getTextFromSerializeArray($val['brand_shrtDesc']);
// $data[$i]['text'] =   $desc;

// LINK
$data[$i]['link']   =   $val['brand_link'];
$i++;
}
}
return $data;
}

public function web_brands1($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM media_slider $where  ORDER BY sort ASC";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
@$title      =   getTextFromSerializeArray($val['brand_heading']);
$data[$i]['title'] =   $title;

//get shortDesc and set into data so developer no need to translate it
@$desc      =   getTextFromSerializeArray($val['brand_shrtDesc']);
$data[$i]['text'] =   $desc;

//LINK
$data[$i]['link']   =   $val['brand_link'];
$i++;
}
}
return $data;
}

public function get_financial_reports($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM financial_reports $where  ORDER BY id DESC";
$data      =   $this->dbF->getRows($sql);
if($this->dbF->rowCount>0) {
$i      =   0;
$data2  = $data; //for save $data array
$print = '';
foreach ($data2 as $val) {
//get title and set into data so developer no need to translate it
@$title      =   getTextFromSerializeArray($val['testimonial_heading']);
//$link = getTextFromSerializeArray($val['testimonial_image']);
//$link_final = str_replace('{{WEB_URL}}', WEB_URL, $data[$i]['link']);
//$data[$i]['title'] =   $title;
@$title2      =   getTextFromSerializeArray($val['testimonial_shrtDesc']);

//LINK
$data[$i]['link']   =  getTextFromSerializeArray($val['testimonial_image']); 
$data[$i]['linkun'] = str_replace('{{WEB_URL}}', WEB_URL, $data[$i]['link']);

$print .= '
<li>
<a href="'.$data[$i]['linkun'].'" target="_blank"><span><img src="webImages/icon5.png" alt=""></span>
<div class="col2_txt2">
<h6>'.$title.'</h6>
<h5>'.$title2.'</h5></div>
</a>
</li>';

$i++;
}
}
return $print;
}



public function count_media_slider($columns='*',$publish = true){
/**
* $return All,but main array is, [title],[image],[text],[link];
*/
if($publish){
$where = " WHERE publish = '1'";
}else{
$where = '';
}
$sql       =   "SELECT $columns FROM banners $where";
$data      =   $this->dbF->getRows($sql);
$count = $this->dbF->rowCount();
$j = 0;
for($i=1; $i<=$count; $i++){
if($i == 1) {
$data = '<li class="usl-current-parent">
<a href="#'.$i.'" class="usl-pager-'.$j.' usl-current"></a>
</li>';
}
else {
$data .= '<li class="">
<a href="#'.$i.'" class="usl-pager-'.$j.'"></a>
</li>';

}
$j++;


}
// if($this->dbF->rowCount>0) {
//     $i      =   0;
//     $data2  = $data; //for save $data array
//     foreach ($data2 as $val) {
//         //get title and set into data so developer no need to translate it
//         @$title      =   getTextFromSerializeArray($val['brand_heading']);
//         $data[$i]['title'] =   $title;

//         //get shortDesc and set into data so developer no need to translate it
//         @$desc      =   getTextFromSerializeArray($val['brand_shrtDesc']);
//         $data[$i]['text'] =   $desc;

//         //LINK
//         $data[$i]['link']   =   $val['brand_link'];
//         $i++;
//     }
// }
return $data;
}


public function web_brandsDiv(){
$brands = $this->web_brands();
$temp = '';
foreach($brands as $val){
$link    =   $val['link'];
$image    =   WEB_URL."/images/".$val['image'];
$temp   .= '<div class="col5_img"> <a href="'.$link.'"><img src="'.$image.'" alt=""></a> </div>';
}

return $temp;
}

public function financial_reports(){
$brands = $this->get_financial_reports();
$abc = print_r($brands);
$temp = '';
foreach($brands as $val){
// $link     =   $val['link'];
// $text     =   $val['text'];
// $title    =   $val['title'];

$temp = print_r($val);

// $temp   .= ' <div class="slide1 wow fadeInLeft">
//             <a href="'.$link.'">
//             <div class="slide1_img">
//                 <img src="'.$image.'" alt="">
//             </div>
//             <!-- slide1_img close -->
//             <div class="border_side">
//                 <!-- border -->
//             </div>
//             <!-- border_side close -->
//         <div class="btn_slide">
//         '.$title.'
//         </div>

//     </a>
// </div>';

}
return $temp;
}

public function web_brandsDiv1(){
$brands = $this->web_brands1();
$temp = '';
foreach($brands as $val){
$image    =   WEB_URL."/images/".$val['image'];
$link     =   $val['link'];
$text     =   $val['text'];
$title    =   $val['title'];



$temp   .= ' <li><a href="'.$link.'">
<div class="img_box">
<img src="'.$image.'" alt="" class="hvr-grow">
</div>
<!-- img_box close -->
<div class="box_text">
<h4>'.$title.'</h4>
<div class="text_box1">
'.$text.'
</div>
<!-- text_box1 close -->
</div></a>
<!-- box_text close -->
</li>';

}
return $temp;
}




/**
* @param $boxName
* @param bool $textCharacters
* @param bool $headingCharacter
* @param bool $subHeadingCharacters
* @return array
*/
public function getBox($boxName,$textCharacters = false, $headingCharacter = false,$subHeadingCharacters = false){
/* Will Return
$array['heading']
$array['heading2']
$array['text']
$array['link']
$array['linkText']
$array['image']  ;
*/

$sql = "SELECT * FROM `box` WHERE box = ? ";
$data = $this->dbF->getRow($sql,array($boxName));
$lang = currentWebLanguage();

$heading = translateFromSerialize($data['heading']);
$sub_heading =  translateFromSerialize($data['sub_heading']);
$short_desc =  translateFromSerialize($data['short_desc']);
$linkText =  translateFromSerialize($data['linktext']);

$heading        = ($headingCharacter!=false)?substr($heading,0,$headingCharacter)   :   $heading;
$sub_heading    = ($subHeadingCharacters!=false)?substr($sub_heading,0,$subHeadingCharacters)   :   $sub_heading;
$short_desc     = ($textCharacters!=false)?substr($short_desc,0,$textCharacters)    :   $short_desc;

//Link
$link = $data['redirect'];
if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link)){
}else{
$link = WEB_URL.$link;
}

$array = array();
$array['heading']   = $heading;
$array['heading2']  = $sub_heading;
$array['text']      = $short_desc;
$array['link']      = $link;
$array['linkText']  = $linkText;
$array['image']     = WEB_URL.'/images/'.$data['image'];


return $array;
}

/**
* @param $returnStatus
* @return bool
*/
public function bookingFormSubmit(){
    if(isset($_POST['form']['email']) && isset($_POST['g-bookForm'])){
        global $_e;
        

 if (isset($_POST['g-bookForm'])) {
    $captcha = $_POST['g-bookForm'];
} else {
    $captcha = false;
}

if (!$captcha) {
 echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
      echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';
    }else{
    if(!$this->getFormToken('bookForm2')){return false;}
    // var_dump("111");

//... The Captcha is valid you can continue with the rest of your code
//... Add code to filter access using $response . score

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
            $msg.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
            $msg.='</table>';

$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("bookingForm");
$array = array_merge($array, $data2);


// echo $sql;
// var_dump($array);


$this->dbF->setRow($sql,$array,false);




             $msg1 ='';
$dirr = __DIR__."/bookingForm.txt";
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
            $msg1.='<tr> <td>Date Time</td><td>'.date("D j M Y g:i a").'</td> </tr>';
            // $msg1.='</table>';

            $dirr2 = __DIR__."/bookingForm.txt";




$myfile = fopen($dirr2, "w");
// $txt = "Mickey Mouse\n";
fwrite($myfile, $msg1);
// $txt = "Minnie Mouse\n";
// fwrite($myfile, $txt);
fclose($myfile);





            // $to = $this->functions->ibms_setting('Email');
            $to ="booking@smartdentalcompliance.com";
        //   $to ="ahmedattari612@gmail.com";
            $this->functions->send_mail($to,'Booking Form',$msg);
            $nameUser =   $_POST['form']['full name'];
            $to =   $_POST['form']['email'];
            if($this->functions->send_mail($to,'','','bookingForm',$nameUser)){
                echo '<script>
                    alert("Thanks for your interest. Our representative will get in touch with you.");
                </script><script> fbq("track", "CompleteRegistration"); </script>';
            }
            else{
                echo '<script>
                        alert("An Error occured while sending your mail. Please Try Later");
                    </script>';
            }



    }
}


    
 
         
        
    }
}
public function webinarFormSubmit(){
    // var_dump($_POST);
    if(isset($_POST['form']['email']) && isset($_POST['g-webinarForm'])){
        global $_e;

 if (isset($_POST['g-webinarForm'])) {
    $captcha = $_POST['g-webinarForm'];
} else {
    $captcha = false;
}

if (!$captcha) {
 echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';return false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
      echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';return false;
    }else{
// if(!$this->getFormToken('webinar')){return false;}
// var_dump("abc");
//... The Captcha is valid you can continue with the rest of your code
//... Add code to filter access using $response . score

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
            $msg.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
            $msg.='</table>';

$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("webinarForm");
$array = array_merge($array, $data2);


// echo $sql;
// var_dump($array);


$this->dbF->setRow($sql,$array,false);
$msg1 ='';
$dirr = __DIR__."/webinarForm.txt";
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
            $msg1.='<tr> <td>Date Time</td><td>'.date("D j M Y g:i a").'</td> </tr>';
            // $msg1.='</table>';

            $dirr2 = __DIR__."/webinarForm.txt";




$myfile = fopen($dirr2, "w");
// $txt = "Mickey Mouse\n";
fwrite($myfile, $msg1);
// $txt = "Minnie Mouse\n";
// fwrite($myfile, $txt);
fclose($myfile);





            // $to = $this->functions->ibms_setting('Email');
            $to ="booking@smartdentalcompliance.com";
            // $to ="samratbutani@gmail.com";
            $this->functions->send_mail($to,'Webinar Form',$msg);
            $nameUser =   $_POST['form']['full name'];
            $to =   $_POST['form']['email'];
            $webinarTitle =   $_POST['form']['title'];
           $zoomLink =   $_POST['form']['zoomLink'];

           if (strpos($webinarTitle, 'Recorded ') !== false) {
    $emailletter='RecordedWebinarForm';
}else{
    $emailletter='WebinarForm';
}
           
            if($this->functions->send_mail($to,'','',$emailletter,$nameUser,array("zoomLink"=>$zoomLink, "webinarTitle"=>$webinarTitle))){
                echo '<script>
                    alert("Thanks for your interest. Our representative will get in touch with you.");
                </script>';
                return true;
            }
            else{
                echo '<script>
                        alert("An Error occured while sending your mail. Please Try Later");
                    </script>';
            
                return false;
            }



    }
}


    
 
         
        
    }
}


public function freeResoursesFormSubmit(){
    // var_dump($_POST);
    
    if(isset($_POST['form']['email']) && isset($_POST['g-freeResourceForm'])){
        global $_e;

 if (isset($_POST['g-freeResourceForm'])) {
    $captcha = $_POST['g-freeResourceForm'];
} else {
    $captcha = false;
}

if (!$captcha) {
 echo '<script>
         alert("Captcha Did Not Passed. Please Refill The Form.");
       </script>';return false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  
    $response = json_decode($response);

    if ($response->success === false) {
      echo '<script>
            alert("Captcha Did Not Passed. Please Refill The Form.");
            </script>';return false;
    }else{
  
    
    $f = '';
    $v = '';
    $c = 1;
    $file = "";
    $array = array();
    
    $id = $_POST['form']['id'];
    $sql3 = "SELECT `file_link` FROM `free_resources` WHERE `id` = ? ";
    $linkData = $this->dbF->getRow($sql3,array($id));
    $file = $linkData['file_link'];

        foreach($_POST['form'] as $key=>$val){
           
            if($key == 'id'){
                $f .= 'file = ?,';
                $v = $file;
                $array[]= $v;
            }else{
                $f .= 'field'.$c.' = ?,';
                $v = ucwords(str_replace("_"," ",$key)).':'.$val;
                $array[]= $v;
                $c++;
            }
        }
        $f = trim($f,",");
        $tempFile = $file !== "#" ? ($_SERVER['DOCUMENT_ROOT'].'/'. explode('.com/',$file)[1]) : "";
        // var_dump(__DIR__,$tempFile, file_exists($tempFile));
        // exit();
        $sql = "INSERT INTO  `formAllData` SET ";
         
        $sql .= $f.',type = ?';
        $data2 = array("freeResourceFormData");
        $array = array_merge($array, $data2);
        // var_dump($sql, $array);
        // exit();
        $result = $this->dbF->setRow($sql,$array,false);
        
        if($result > 0){
             if(file_exists($tempFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush(); // Flush system output buffer
            readfile($file);
            die();
             }else{
                 
                 echo "<script>
                    alert('File not exist');
                </script>";
             }
            return true;
        // } else {
        //     http_response_code(404);
        //   die();
        // }
    // } else {
    //     die("Invalid file name!");
    // }
        }else{
            return false;
        }



            }
        }    
    }
}
public function freeStaticFormSubmit(){
    // var_dump($_POST);
    
    if(isset($_POST['form']['email']) && isset($_POST['g-freeResourceForm'])){
        global $_e;

 if (isset($_POST['g-freeResourceForm'])) {
    $captcha = $_POST['g-freeResourceForm'];
} else {
    $captcha = false;
}

if (!$captcha) {
 echo '<script>
         alert("Captcha Did Not Passed. Please Refill The Form.");
       </script>';return false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  
    $response = json_decode($response);

    if ($response->success === false) {
      echo '<script>
            alert("Captcha Did Not Passed. Please Refill The Form.");
            </script>';return false;
    }else{
  
    
    $f = '';
    $v = '';
    $c = 1;
    $file = "";
    $array = array();
    
    $id = $_POST['form']['id'];
    $sql3 = "SELECT `file_link` FROM `free_resources` WHERE `id` = '$id' ";
    $linkData = $this->dbF->getRow($sql3);
    $file = "https://smartdentalcompliance.com/uploads/files/free_resources/CONFIDENTIAL_RISK_ASSESSMENT_FOR_STAFF_DURING_COVID-19_(1).pdf";

        foreach($_POST['form'] as $key=>$val){
           
            if($key == 'id'){
                $f .= 'file = ?,';
                $v = $file;
                $array[]= $v;
            }else{
                $f .= 'field'.$c.' = ?,';
                $v = ucwords(str_replace("_"," ",$key)).':'.$val;
                $array[]= $v;
                $c++;
            }
        }
        $f = trim($f,",");
        $tempFile = $file !== "#" ? ($_SERVER['DOCUMENT_ROOT'].'/'. explode('.com/',$file)[1]) : "";
        // var_dump(__DIR__,$tempFile, file_exists($tempFile));
        // exit();
        $sql = "INSERT INTO  `formAllData` SET ";
         
        $sql .= $f.',type = ?';
        $data2 = array("freeResourceFormData");
        $array = array_merge($array, $data2);
        // var_dump($sql, $array);
        // exit();
        $result = $this->dbF->setRow($sql,$array,false);
        
        if($result > 0){
             if(file_exists($tempFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush(); // Flush system output buffer
            readfile($file);
            die();
             }else{
                 
                 echo "<script>
                    alert('File not exist');
                </script>";
             }
            return true;
        // } else {
        //     http_response_code(404);
        //   die();
        // }
    // } else {
    //     die("Invalid file name!");
    // }
        }else{
            return false;
        }



            }
        }    
    }
}

public function popupFormSubmit(){
    if(isset($_POST['action']) &&  $_POST['action'] == "popupForm"){
        global $_e;
        if(!$this->getFormToken('popupForm')){return false;}
        
        // if(isset($_POST['g-recaptcha-response'])){
        //     $captcha=$_POST['g-recaptcha-response'];
        // }
        // if(!$captcha){
        //     echo '<script>
        //             alert("Please verify that you passed the captcha code.");
        //         </script>';
        // }




 if (isset($_POST['g-popupForm'])) {
    $captcha = $_POST['g-popupForm'];
} else {
    $captcha = false;
}

if (!$captcha) {
     echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';return false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
             echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';return false;
    }else{
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
            $msg.='<tr><td>Date Time</td><td>'.date("D j M Y g:i a").'</td></tr>';
            $msg.='</table>';




$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
$sql .= $f.',type = ?';
$data2 = array("homePagePopup");
$array = array_merge($array, $data2);

// echo $sql;
// var_dump($array);
$this->dbF->setRow($sql,$array,false);



             $msg1 ='';
$dirr = __DIR__."/homePagePopup.txt";
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


$dirr = __DIR__."/homePagePopup.txt";




$myfile = fopen($dirr, "w");
// $txt = "Mickey Mouse\n";
fwrite($myfile, $msg1);
// $txt = "Minnie Mouse\n";
// fwrite($myfile, $txt);
fclose($myfile);
 



            // $to = $this->functions->ibms_setting('Email');
            $to ="booking@smartdentalcompliance.com";
            // $to = 'ahmedattari612@gmail.com';
            $this->functions->send_mail($to,'Popup Form',$msg);
            $nameUser =   $_POST['form']['name'];
            $to =   $_POST['form']['email'];
            if($this->functions->send_mail($to,'','','popupForm',$nameUser)){
                echo '<script>
                    alert("Thanks for your interest. Our representative will get in touch with you.");
                    close_newpopup();
                </script>';
            }
            else{
                echo '<script>
                        alert("An Error occured while sending your mail. Please Try Later");
                         close_newpopup();
                    </script>';
            }
            }
        }
    }
}

public function delegates(){
    if(isset($_POST) && !empty($_POST)){
        global $_e;
        if(!$this->getFormToken('delegates')){return false;}


        if (isset($_POST['g-delegates'])) {
    $captcha = $_POST['g-delegates'];
} else {
    $captcha = false;
}

if (!$captcha) {
    echo '<script>
                    alert("Captcha Did Not Passed. Please Refill The Form.");
                </script>';
    $captcha = false;
} else {
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $response = json_decode($response);

    if ($response->success === false) {
         $pMmsg = $dbF->hardWords('Please go back and verify that you passed the captcha code.',false);
    $captcha = false;
    }else{


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
            $msg.='<tr> <td>Date Time</td><td>'.date("D j M Y g:i a").'</td> </tr>';
            $msg.='</table>';



$f = trim($f,",");

$sql = "INSERT INTO  `formAllData` SET ";
 
$sql .= $f.',type = ?';
$data2 = array("delegateForm");
$array = array_merge($array, $data2);


// echo $sql;
// var_dump($array);


$this->dbF->setRow($sql,$array,false);




             $msg1 ='';
$dirr = __DIR__."/delegateForm.txt";
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
            $msg1.='<tr> <td>Date Time</td><td>'.date("D j M Y g:i a").'</td> </tr>';
            // $msg1.='</table>';

            $dirr1 = __DIR__."/delegateForm.txt";




$myfile = fopen($dirr1, "w");
// $txt = "Mickey Mouse\n";
fwrite($myfile, $msg1);
// $txt = "Minnie Mouse\n";
// fwrite($myfile, $txt);
fclose($myfile);



            // $to = $this->functions->ibms_setting('Email');
            $to ="booking@smartdentalcompliance.com";
            $this->functions->send_mail($to,'Order Delegates',$msg);
            $nameUser =   $_POST['form']['name'];
            $to = $_POST['form']['email'];
            if($this->functions->send_mail($to,'','','delegateForm',$nameUser)){
                echo '<script>
                    alert("Thanks for your interest. Our representative will get in touch with you.");
                </script>';
            }
            else{
                echo '<script>
                    alert("An Error occured while sending your mail. Please Try Later");
                </script>';
            }
        }
    }
}
}

public function getPage($page){
        $sql = "SELECT * FROM `pages` WHERE slug = ? AND publish = ?";
        $data = $this->dbF->getRow($sql,array($page,'1'));

        if(!$this->dbF->rowCount){return false;}

        $lang = currentWebLanguage();
        $defaultLang = defaultWebLanguage();

        $heading       =  translateFromSerialize($data['heading']);
        $sub_heading   =  translateFromSerialize($data['sub_heading']);
        $short_desc    =  translateFromSerialize($data['short_desc']);
        $desc          =  translateFromSerialize(($data['dsc']));

        //Link
        $link = $data['redirect'];
        if(preg_match('@http://@i',$link) || preg_match('@https://@i',$link) || $link==''){
        }else{
            $link = WEB_URL.$link;
        }

        $array = array();
        $array['id']      =   $data['page_pk'];
        $array['link']      = $link;
        $array['slug']      = $data['slug'];
        $array['heading']   = $heading;
        $array['heading2']  = $sub_heading;
        $array['short_desc']= $short_desc;
        $array['desc']      = $desc;
        $array['image']     = WEB_URL.'/images/'.$data['page_banner'];
        $array['imagess']     = WEB_URL.'/images/'.$data['banner'];
        $array['comment']   = $data['comment'];
        $array['update']    = $data['dateTime'];
        $array['special_page']    = $data['special_page'];

        return $array;
    }



public function vcode($user, $email) {
$v = round(str_replace("-", "", (crc32(md5($user . $email . 'imedia'))) / 7923));
return $v;
}


public function webSeo(){
//var_dump($_SERVER);
$array = array();
$link = "".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];
$link = str_replace("http://","",$link);
$link = str_replace("https://","",$link);
$link = $this->functions->defaultHttp."".$link;
$link = urldecode($link);
$link = str_replace(WEB_URL,"",$link);
if($link=="/" || $link=="/home" || $link=="/index" || $link=="index.php"){
$link = '/';
}

$sql = "SELECT * FROM seo WHERE pageLink LIKE ? AND publish = '1'";
$data = $this->dbF->getRow($sql,array("%$link%"));

if($this->dbF->rowCount>0){
$array['default']     = '0';
}else{
//check with out Parameter link
$explod = explode('?',$link);
$link   =  preg_replace("/.php/","",$explod[0]); //removing .php from link

$sql = "SELECT * FROM seo WHERE pageLink = ? AND publish = '1'";
$data = $this->dbF->getRow($sql,array($link));
if($this->dbF->rowCount>0){
$array['default']     = '0';
}else {
$sql = "SELECT * FROM seo WHERE pageLink = '/default' AND publish = '1'";
$data = $this->dbF->getRow($sql);
$array['default'] = '1';
}
}

//var_dump($data);
$robots = "";
if(isset($data['sIndex'])){
    if($data['sIndex']=='1'){
        $robots .= "index,";
    }else if($data['sIndex']=='0'){
        $robots .= "noindex,";
    }
}
if(isset($data['sFollow'])){
    if($data['sFollow']=='1'){
        $robots .= " follow";
    }else if($data['sFollow']=='0'){
        $robots .= " nofollow";
    }
}
// $this->dbF->prnt($data);

$array['title']     = translateFromSerialize(isset($data['title']) ? $data['title'] : "");
$array['special']   = translateFromSerialize(isset($data['special']) ? $data['special'] : "");
$array['keywords']  = translateFromSerialize(isset($data['keywords']) ? $data['keywords'] : "");
$array['description'] = translateFromSerialize(isset($data['dsc']) ? $data['dsc'] : "");
$array['canonical'] = translateFromSerialize(isset($data['canonical']) ? $data['canonical'] : "");
$array['sIndex']    = isset($data['sIndex'] ) ? $data['sIndex'] : "";
$array['type']      = isset($data['type'] ) ? $data['type'] : "";
$array['sFollow']   = isset($data['sFollow'] ) ? $data['sFollow'] : "";
$array['reWriteTitle'] = isset($data['rewriteTitle'] ) ? $data['rewriteTitle'] : ""; //rewrite Title with seo title
$array['author']    = translateFromSerialize(isset($data['author']) ? $data['author'] : "");
$array['revisit-after'] = isset($data['revisit-after']) ? $data['revisit-after']  : "";
$array['robots']    = $robots;
$array['link']      = $this->currentUrl(false);

$this->hasSeo = true;
if($this->functions->developer_setting('seo') == '0'){
//if seo 0 from developer setting then blank all seo array
$this->hasSeo = false;
}
return $array;
}

/**
* if seo false from developer setting then blank all seo array, and blank values not print on website
* @param bool|false $all
*/
private function seoBlank($all=false){
global $seo;
if($this->hasSeo==false) {
foreach ($seo as $key => $val) {
if($key == 'title' && $all ==false){
continue;
}
$seo[$key] = '';
}
}
}

public function seo_page_type(){
global $seo;
if(isset($seo["type"])){

}
}

public function seoChange($key,$val){
if(isset($seo["$key"])){
$seo["$key"] = $val;
}
}

public function imediaMeta($echo=true){
$temp = '<meta content="Interactive Media Pakistan - imedia.com.pk" name="author" />'."\n";
if($echo){
echo $temp;
}else{
return $temp;
}
}

public function seoOgGraph($echo=true){
$this->seoBlank(true);
$temp = "";
global $seo;
if(isset($seo['title']) && $seo['title'] != ''){
$temp .= "<meta property='og:title' content='$seo[title]' />\n";
}
if(isset($seo['type']) && $seo['type'] != ''){
$temp .= "<meta property='og:type' content='$seo[type]' />\n";
}
if(isset($seo['description']) && $seo['description'] != ''){
$temp .= "<meta property='og:description' content='$seo[description]' />\n";
}
if(isset($seo['url']) && $seo['url'] != ''){
$temp .= "<meta property='og:url' content='$seo[url]' />\n";
}
if(isset($seo['link']) && $seo['link'] != ''){
$temp .= "<meta property='og:url' content='$seo[link]' />\n";
}

/*Og Product graph*/
if( ($seo['type'] == "product" || $seo['type'] == "og:product" || $seo['type'] == "item")
&& isset($seo['price']) && $seo['price'] != '' && isset($seo['currency']) && $seo['currency'] != ''){
if(isset($seo['title']) && $seo['title'] != ''){
$temp .= "<meta property='product:plural_title' content='$seo[title]' />\n";
}
$temp .= "<meta property='product:price:amount' content='$seo[price]' />\n";
$temp .= "<meta property='product:price:currency' content='$seo[currency]' />\n";

if(isset($seo['shipping']) && $seo['shipping'] != ''){
$temp .= "<meta property='product:shipping_cost:amount' content='$seo[shipping]' />\n";
$temp .= "<meta property='product:shipping_cost:currency' content='$seo[currency]' />\n";
}
}



if(isset($seo['image']) && $seo['image'] != ''){
$temp .= "<meta property='og:image' content='$seo[image]' />\n";
}

$fbIds  = $this->functions->ibms_setting('facebookIntId');
$fbIds  = str_replace(" ","",$fbIds);
$fbIds  = explode(",",$fbIds);
foreach($fbIds as $fbId) {
$temp .= "<meta property='fb:admins' content='".$fbId. "' />\n";
}

if($echo){
echo $temp;
}else{
return $temp;
}
}

public function seoTwitter($echo=true){
$this->seoBlank(true);
$temp = "";
global $seo;


//Twitter only these type of card type
$twitter_type = "summery";
@$seo_type = $seo['type'];
if($seo_type == "photo"){ $twitter_type = "photo";}
elseif($seo_type == "gallery" || $seo_type == "album"){ $twitter_type = "gallery";}
elseif($seo_type == "product" || $seo_type == "item"){ $twitter_type = "product";}

$temp .= "<meta name='twitter:card' content='$twitter_type' />\n";

if(isset($seo['link']) && $seo['link'] != ''){
$temp .= "<meta name='twitter:url' content='$seo[link]' />\n";
}
if(isset($seo['title']) && $seo['title'] != ''){ //Title of content (max 70 characters)
$temp .= "<meta name='twitter:title' content='$seo[title]' />\n";
}
if(isset($seo['description']) && $seo['description'] != ''){ //Description of content (maximum 200 characters)
$temp .= "<meta name='twitter:description' content='$seo[description]' />\n";
}

if(isset($seo['author']) && $seo['author'] != ''){ // @username of content creator
$temp .= "<meta name='twitter:creator' content='$seo[author]' />\n";
}

$temp .= "<meta name='twitter:site' content='@".$this->functions->ibms_setting('TwitterSite')."' />\n";
if(isset($seo['image'])){
$temp .= "<meta name='twitter:image' content='$seo[image]' />\n";
}

/*twitter Product card*/
if(($seo['type'] == "product" || $seo['type'] == "og:product" || $seo['type'] == "item")
&& isset($seo['price']) && $seo['price'] != '' && isset($seo['currency']) && $seo['currency'] != ''){
$temp .= "<meta name='twitter:label1' content='price' />\n";
$temp .= "<meta name='twitter:data1' content='$seo[price] $seo[currency]' />\n";
}


if($echo){
echo $temp;
}else{
return $temp;
}
}

public function seoScheme($echo=true){
$this->seoBlank(true);
$temp = "";
global $seo;
if(isset($seo['title']) && $seo['title'] != ''){
$temp .= "<meta itemprop='name' content='$seo[title]' />\n";
}
if(isset($seo['description']) && $seo['description'] != ''){
$temp .= "<meta itemprop='description' content='$seo[description]' />\n";
}
if(isset($seo['image']) && $seo['image'] != ''){
$temp .= "<meta itemprop='image' content='$seo[image]' />\n";
}
if($echo){
echo $temp;
}else{
return $temp;
}
}

public function seoMetaName($nameVal,$val,$echo=true,$metaNameOrPropertyDefaultName=true){
if($val==""){
return false;
}
$metaName = 'name';
if($metaNameOrPropertyDefaultName===false){
//if false mean meta property
$metaName = 'property';
}else if($metaNameOrPropertyDefaultName!==true && $metaNameOrPropertyDefaultName!==false){
//If you define meta name
$metaName = $metaNameOrPropertyDefaultName;
}

if($echo==true){
echo "<meta $metaName = '$nameVal' content='$val'/>\n";
}else{
return "<meta $metaName = '$nameVal' content='$val'/>\n";
}

}
public function seoTitle($title,$echo = true){
        $site_name = $this->functions->ibms_setting("Site Name");
        $site_name = trim($site_name,"-");
        if(trim($title)==''){$title="Dashboard";}
        $title = trim($title,"-")." - ".$site_name;
        if($echo==true){
            echo "<title>$title</title>\n";
        }else{
            return "<title>$title</title>\n";
        }
}

public function AllSeoPrint(){
global $seo;
foreach($seo as $key=>$val){
//remove extra space from text and remove tags,
//space and tags add form data that fetch from db, or where page heading or desc use as seo
if($key=="special") continue;
$seo[$key] = removeSpace(strip_tags($val));
}

$this->seoBlank();
$this->seoTitle($seo['title']);
$this->seoMetaName('keywords',$seo['keywords']);
$this->seoMetaName('description',$seo['description']);
$this->seoMetaName('canonical',$seo['canonical']);
$this->seoMetaName('author',$seo['author']);
$this->seoMetaName('robots',$seo['robots']);
$this->seoMetaName('revisit-after',$seo['revisit-after']);

$this->seo_page_type();

$this->seoOgGraph();
$this->seoTwitter();
$this->seoScheme();
$this->imediaMeta();

}

public function seoSpecial($echo = true){
global $seo;
$temp = "";
if(!empty($seo['special'])) {
$temp = '<section>
<div class="container-fluid padding-0 my_seo_div">
<div class="standard seoSpecial seo_special_text">
' . $seo['special'] . '
</div>
</div>
</section>';
}
if($echo){
echo $temp;
}else{
return $temp;
}
}
function get_slugname($pg = null) {
global $dbp;

$sql = "SELECT slug FROM `data` WHERE `pageid` = ? ";
$stmt = $dbp->prepare($sql);
$stmt->bindValue(1, $pg, PDO::PARAM_STR);
$stmt->execute();

if( $stmt->rowCount() > 0 ) {
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$result = $row['slug'];
} else {
$result = false;
}


return $result;

}

public function webUserAddSubmit(){
if (isset($_POST['name']) && !empty($_POST['name'])
&& isset($_POST['email']) && !empty($_POST['email'])
){

if(!$this->functions->getFormToken('webUserEdit')){return false;}
try {

$email = strip_tags(strtolower(trim($_POST['email'])));
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
$dayoff = empty($_POST['dayoff']) ? array() : $_POST['dayoff'];

$name   = empty($_POST['name']) ? "" : $_POST['name'];
$pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
$rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];
$pin    = empty($_POST['pin'])  ? "000000" : $_POST['pin'];
$rpin   = empty($_POST['rpin']) ? "" : $_POST['rpin'];
$roll   = empty($_POST['roll']) ? "" : $_POST['roll'];
$img    = empty($_FILES['image']['name'])   ? false      : true;

htmlspecialchars($name);
htmlspecialchars($pass);
htmlspecialchars($rpass);
htmlspecialchars($pin);
htmlspecialchars($rpin);
htmlspecialchars($roll);

$image = "";

if($img){
    $image = $this->functions->uploadSingleImage($_FILES['image'],'profile image');
}

$passwordStatus = false;
if($pass != $rpass){
$msg = 'Password Not Matched!';
$msg = $this->dbF->hardWords($msg,false);
return $msg;
}
if($pass != ''){
$passwordStatus =true;
}


$this->db->beginTransaction();
$date = date('Y-m-d H:i:s');
$weeklyEmail = date('Y-m-d');
$sql = "INSERT INTO  `accounts_user` SET
            `acc_name` = ?,
            `acc_email` = ?,
            `acc_type` = ?,
            `acc_pass` = ?,
            `acc_pin` = ?,
            `acc_image` = ?,
            `roll` = ?,
            `weekly_email` = ?,
            `acc_created` = ?,
            `health_form` = ?,
            `dayoff` = ?

            ";

$password  =  $this->functions->encode($pass);
$pin       =  $this->functions->encode($pin);
$dayoff= implode(",",$dayoff);


$array = array($name,$email,"1",$password,$pin,$image,$roll,$weeklyEmail,$date,'0',$dayoff);
$this->dbF->setRow($sql,$array,false);

$lastId = $this->dbF->rowLastId;

$setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];

$sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
$arry       =   array();
foreach($setting as $key=>$val){
    $sql .= "('$lastId',?,?) ,";
    if (is_array($val)) {
         $val = implode(',',$val);
    }
    $arry[]= $key ;
    $arry[]= $val ;
}
$sql = trim($sql,",");
$this->dbF->setRow($sql,$arry,false);

} else {
$AccLoginInfoT = 'Invalid Email Address! Or Some Thing Went Wrong';
$msg = $AccLoginInfoT;
$msg = $this->dbF->hardWords($msg,false);
return $msg;
}

$this->db->commit();
$msg = $this->dbF->hardWords('Profile Add Successfully!',false);
$mailArray['name'] = $name;
$mailArray['email'] = $email;
$mailArray['password'] =  $rpass;
$mailArray['pin']     =   '000000';
$this->functions->send_mail($email,'','','AccountCreatedFromProfile',$name,$mailArray);
return $msg;

} catch (PDOException $e) {
$msg = "WebUser Add fail please try again.!";
$msg = $this->dbF->hardWords($msg,false);
$this->db->rollBack();
return $msg;
}
}
return "";
}

public function webUserEditSubmit(){
if (isset($_POST['name']) && !empty($_POST['name'])
&& isset($_POST['email']) && !empty($_POST['email'])
&& isset($_POST['oldId']) && !empty($_POST['oldId'])
){

if(!$this->functions->getFormToken('webUserEdit')){return false;}
try {

$email = strip_tags(strtolower(trim($_POST['email'])));
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

$dayoff = empty($_POST['dayoff']) ? array() : $_POST['dayoff'];
$id     = empty($_POST['oldId']) ? "" : $_POST['oldId'];

$name   = empty($_POST['name']) ? "" : $_POST['name'];

 $type   = (trim($_POST['acc_type'])=="") ? "1" : $_POST['acc_type'];
$roll   = empty($_POST['roll']) ? "" : $_POST['roll'];
$pass   = empty($_POST['pass']) ? "" : $_POST['pass'];
$rpass  = empty($_POST['rpass']) ? "" : $_POST['rpass'];
$rpin = empty($_POST['rpin']) ? "" : $_POST['rpin'];
$pin    = empty($_POST['pin']) ? "" : $_POST['pin'];
$img    = empty($_FILES['image']['name'])   ? false      : true;
$old_image = empty($_POST['old_image']) ? "#" : $_POST['old_image'];
$image     = $old_image;
// var_dump($dayoff);exit;
htmlspecialchars($type);
// htmlspecialchars($dayoff);
htmlspecialchars($id);
htmlspecialchars($name);
htmlspecialchars($roll);
htmlspecialchars($pass);
htmlspecialchars($rpass);
htmlspecialchars($rpin);
htmlspecialchars($pin);


if($img){
    $this->functions->deleteOldSingleImage($old_image);
    $image = $this->functions->uploadSingleImage($_FILES['image'],'profile image');
}

$approved = 1;

$passwordStatus = false;
$pinStatus = false;
if($pass != $rpass){
$msg = 'Password Not Matched!';
$msg = $this->dbF->hardWords($msg,false);
return $msg;
}
if($pass != ''){
$passwordStatus =true;
}

if($_POST['rpin'] !='' ){
if($rpin != $pin){
$msg = 'Pin Not Matched!';
$msg = $this->dbF->hardWords($msg,false);
return $msg;
}

}
if($pin != ''){
    $pinStatus =true;
}

$this->db->beginTransaction();
$sql = "UPDATE  accounts_user SET
acc_name = ?,
acc_email = ?,
acc_image = ?,
roll = ?,
acc_type = ?,
dayoff = ?
WHERE acc_id = ?";
$dayoff= implode(",",$dayoff);
$array = array($name,$email,$image,$roll,$type,$dayoff,$id);
$this->dbF->setRow($sql,$array,false);

// =========================notificationDevice======================
        @$userId=intval($_POST['userId']);
        $temp='';
        if(is_array(@$_POST["playerId"])){
        foreach (@$_POST["playerId"] as $key => $value) {

            $temp.=$value.",";
            $x=rtrim($temp,",");
            $update="UPDATE accounts_user SET player_id=? WHERE acc_id=?";
            $array=array($x,$userId);
            $this->dbF->setRow($update,$array);
        }
        }
// =========================notificationDevice======================

if($passwordStatus){
$password  =  $this->functions->encode($pass);
$sql = "UPDATE accounts_user SET
acc_pass = ?,
acc_action = ?
WHERE acc_id = ?";
$array = array($password,$approved,$id);
$this->dbF->setRow($sql,$array,false);
$this->functions->setlog("$name password is change ",$this->functions->UserName($_SESSION['webUser']['id'])." : $id","",$id );
}

if($pinStatus){
    $pin =  $this->functions->encode($pin);
    $sql = "UPDATE  accounts_user SET
            acc_pin = ?
            WHERE acc_id = ?";
    $array = array($pin,$id);
    $this->dbF->setRow($sql,$array,false);
    $this->functions->setlog("$name pin is change",$this->functions->UserName($_SESSION['webUser']['id'])." : $id","",$id );
}
 if ($type == 0 ) {
                         $this->functions->setlog("$name Account is DeActive",$this->functions->UserName($_SESSION['webUser']['id'])." : $id","",$id );
   
                   }
$lastId = $id;
$lastId=intval($lastId);
$setting    = empty($_POST['signUp']) ? array() : $_POST['signUp'];
              
   
$sql = "DELETE FROM `accounts_user_detail` WHERE id_user= ?";
$this->dbF->setRow($sql,array($id));

$sql        =   "INSERT INTO `accounts_user_detail` (`id_user`,`setting_name`,`setting_val`) VALUES ";
$arry       =   array();
foreach($setting as $key=>$val){
         
     if ($key  == 'start_date' || $key  == 'cpd_start_date'|| $key  == 'date_of_birth') 
     {
        $val = date("Y-m-d",strtotime($val));
     } 
    
$sql .= "('$lastId',?,?) ,";
$arry[]= $key ;
$arry[]= $val ;
htmlspecialchars($val);
}
$sql = trim($sql,",");
$this->dbF->setRow($sql,$arry,false);

$sql = "DELETE FROM `notifications` WHERE `user`= ?";
$this->dbF->setRow($sql,array($id));

foreach($_POST['form'] as $key => $value){
    $type  = $value;
    $email = empty($_POST[$value.'_email']) ? "0" : $_POST[$value.'_email'];
    $push  = empty($_POST[$value.'_push']) ? "0" : $_POST[$value.'_push'];
     htmlspecialchars($email);
     htmlspecialchars($type);
     htmlspecialchars($push);
    $sql= "INSERT INTO `notifications`(`user`,`type`,`email`,`push`) VALUES(?,?,?,?)";
    $this->dbF->setRow($sql,array($id,$type,$email,$push));
    // $this->dbF->prnt($a);
}

if(isset($_POST['superUser'])){
$sql = "DELETE FROM `superUser` WHERE `user`= ?";
$this->dbF->setRow($sql,array($id));

foreach($_POST['superUser'] as $key => $value){
    $sql= "INSERT INTO `superUser`(`user`,`type`,`allow`) VALUES(?,?,?)";
    $this->dbF->setRow($sql,array($id,$key,$value));
}
}


} else {
$AccLoginInfoT = 'Invalid Email Address! Or Some Thing Went Wrong';
$msg = $AccLoginInfoT;
$msg = $this->dbF->hardWords($msg,false);
return $msg;
}

$this->db->commit();
$msg = $this->dbF->hardWords('Profile Update Successfully!',false);
return $msg;

} catch (PDOException $e) {
$msg = "WebUser Update fail please try again.!";
$msg = $this->dbF->hardWords($msg,false);
$this->db->rollBack();
return $msg;
}
}
return "";
}

public function webUserInfoArray($data,$settingName){
foreach($data as $val){
if($val['setting_name']==$settingName){
return $val['setting_val'];
}
}
return "";
}

public function accountRole(){
    $sql  = "SELECT `setting_val` FROM `ibms_setting`  WHERE `setting_name`='account_role'";
    $data =  $this->dbF->getRow($sql);
    $ids = explode(",",$data[0]);
    $option = '';
    foreach($ids as $key=>$val){
        $option.= "<option value='$val'>$val</option>";
    }
    return $option;
}
public function responsibility(){
    $sql  = "SELECT `setting_val` FROM `ibms_setting`  WHERE `setting_name`='account_responsibilty'";
    $data =  $this->dbF->getRow($sql);
    $ids = explode(",",$data[0]);
    $option = '';
    $option.= "<option value=''>Select None</option>";
    foreach($ids as $key=>$val){
        $option.= "<option value='$val'>$val</option>";
    }
    return $option;
}

public function notificationsAdd($user){
    $sql  = "SELECT * FROM `notifications` WHERE `user`=?";
    $data =  $this->dbF->getRows($sql,array($user));
    if(empty($data)){
        $sql  = "SELECT * FROM `email_letters` WHERE `type`='user'";
        $datas =  $this->dbF->getRows($sql);
        foreach($datas as $key => $value){
            $this->dbF->setRow("INSERT INTO `notifications`(`user`,`type`,`email`,`push`) VALUES('$user','$value[email_type]','1','1')");
        }
    }
}

public function membership($user)
{
    $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157,163)  AND  order_mandate != '' ";
    $data =  $this->dbF->getRows($sql,array($user));
  
 $pg = 'terms-and-conditions';

 $page  = $this->getPage("$pg");

     $notify = "";
         foreach($data as $val){
    $expire_date = date("d-M-Y",strtotime($val['expire_date']));
    $order_date = date("d-M-Y",strtotime($val['order_date']));
$term_accept_date = date("d-M-Y",strtotime($val['terms_accept_date']));
$pname = $this->getProductName($val['product_id'],'prodet_name');
$order_id=$val['order_id']; 


////////  get $page[desc] and $term_accept_date from terms_sign_By_user
    $sql1  = "SELECT * FROM `terms_sign_By_user` WHERE userId = ? ORDER BY id DESC LIMIT 1";
    $data1 =  $this->dbF->getRow($sql1,array($user));
    if($this->dbF->rowCount>0){
      $term_accept_date = date("d-M-Y", strtotime($data1['termSignDate']));
        $page['desc'] =  $data1['terms'];
    }
            //invoice//
        
        $notify .= '<div class="invoice">
        <table class="cpd-table invoice-table tableIBMS">
        <thead>
        <tr>
        
        <th>I-Id</th>
        <th>Payment Id</th>
        <th>Due Date</th>
        <th>Payment</th>
        <th>Status</th>
        <th>Download</th>
        </tr>
        </thead>
        <tbody>
        ';
        
          $sql = "SELECT * FROM `invoices` WHERE `order_id` = ? AND `invoice_status` IN ('paid','pending_submission','submitted') ORDER BY `due_date` DESC";
        $res = $this->dbF->getRows($sql, array($val['order_id']));
        
        $last_paid_date = '';
        $count = 0;
        foreach ($res as $key => $value) {
        $count++;
        
        $inv_id = $value['invoice_pk'];
        
        $last_paid_date = $value['due_date'];
        $sqls = "SELECT `order_customer` FROM `orders` WHERE order_id=?";
        $datas= $this->dbF->getRow($sqls, array($value['order_id']));
        $chkk = $datas[0];
        $pymt = 'GoCardless';
        $dt = date('Y-m-d', strtotime("+1 months"));
        if($chkk=='manual'){
            $pymt = 'Cash';
            if($value['invoice_status']=='pending' && $value['due_date']<=$dt){
            $pymt .="&nbsp;<button type='button' data-id='$value[invoice_pk]' class='btn btn-primary btn-sm'>Paid</button>";
            }
        }
               $notify .=  "<tr>
        <td>".$value['invoice_pk']."</td>
        <td>".$value['payment_id']."</td>
        <td>".date("d-M-Y", strtotime($value['due_date']))."</td>
        <td>".$value['price']."</td>
        <td>".$value['invoice_status']."</td>
        <td>
        <a href='https://smartdentalcompliance.com/profileinvoiceprint?mailId=". base64_encode($val['order_id'])."&invoiceId=". base64_encode($inv_id)."' target='_blank' data-toggle='tooltip' title='Print Invoice'><i class='fas fa fa-print' style='font-size:20px'></i></a>
        </td>
        </tr>";
        }
        $notify .= '</tbody>
        </table></div>';
      

     $notify .= "
     <div class=''>
         <div class=''>
         <label style='font-weight: bold;display: inline-block;' '>Download&nbsp;&nbsp;&nbsp;</label>
          <a class='anim anim2 ' data-toggle='tooltip' href='downlaodmembership.php?orderid=$order_id' title='Click To Download' style='color: black;' target='_blank'><i class='fas fa-download'></i></a>
         </div>
            <div class=''>
          <label style='font-weight: bold;display: inline-block;' '>Membership Type</label>
         <span style='display: inline-block;'>".translateFromSerialize($pname['prodet_name'])."</span>
         </div>
        
         <div class=''>
           <label style='font-weight: bold;display: inline-block;' '>Order Date</label>
          <span style='display: inline-block;'>$order_date</span></div>
         
          <div class=''>
          <label style='font-weight: bold;display: inline-block;' '>Expiry Date</label>
         <span style='display: inline-block;'> $expire_date </span></div>
         
          
           
        <label style='font-weight: bold;display: inline-block;' '>Term & Condtition</label>
          
           <div class='memberhide' style='width: 35%;overflow-y: scroll;height:440px;'>
           
           $page[desc]
           </div>
          <style>
           .memberhide *{width:auto;}
          </style>
          <div class='form-group'> 
           <label style='font-weight: bold;display: inline-block; color;#000;'>Term & Condition Sign On Date</label>
           <span style='display: inline-block; color;#000; '> $term_accept_date </span></div>
<hr>
       </div>
                

                ";

    }
  
    return $notify;
}




public function notificationsView($user){
    $sql  = "SELECT * FROM `email_letters` WHERE `type`='user'";
    if($_SESSION['currentUserType'] != 'Employee'){
        $sql .= "OR type = 'pm'";
    }else{
        $sql .= "OR type = 'employee'";
    }
    $data =  $this->dbF->getRows($sql);
    $notify = "";
    foreach($data as $key => $val){
        if($_SESSION['currentUserType'] == 'Employee'){
            if($val['email_type'] == 'echeckin' || $val['email_type'] == 'echeckout' || $val['email_type'] == 'echeckinlate' || $val['email_type'] == 'event' || $val['email_type'] == 'covid'){
                continue;
            }
        }
        if($_SESSION['currentUserType'] != 'Employee'){
            if($val['email_type'] == 'uevent'){
                continue;
            }
        }
        $d = $this->dbF->getRow("SELECT `email`,`push` FROM `notifications` WHERE `user`= ? AND `type`= ? ",array($user,$val['email_type']));
        $notify .= "<div class='form-group col-12 col-sm-3'>$val[event]
                    <input type='hidden' name='form[$val[email_type]]' value='$val[email_type]'>
                    <label class='ccheckbox'>
                    <input type='checkbox' value='1' name='$val[email_type]_email' ".((@$d['email'] == '1') ? "checked" : "").">
                    <span class='cmark'></span>Email
                    </label>
                    <label class='ccheckbox'>
                    <input type='checkbox' value='1' name='$val[email_type]_push' ".((@$d['push'] == '1') ? "checked" : "").">
                    <span class='cmark'></span>Push
                    </label>
                </div>";
    }
    return $notify;
}

public function notificationsallowModels(){
    $notify2 = "";
      $result = '';
      
                                $appId="63fc4c4a-7ae4-4883-8b6b-fab933959243";
                                $url_user = $_SESSION['webUser']['id'];
                                $query="SELECT * FROM accounts_user WHERE acc_id=?";
                                
                                $result = $this->dbF->getRows($query,array($url_user));
                                $i=0;
                                foreach ($result as $key => $value) {
                                    $playerId=$value['player_id'];
                                    $explodeComma=explode(",", $playerId);
                                    foreach ($explodeComma as $key => $valueComma) {
                                        $i++;
       
         $response=file_get_contents("https://onesignal.com/api/v1/players/".$valueComma."?app_id=".$appId."");
    $toPrint= json_decode($response,true);
       foreach ($toPrint as $key => $valueR) {
               if($key=="device_model"){
                          $abc=$valueR;
                            }
                if($key=="created_at"){
                     $createdAt = new DateTime("@$valueR");
                       $csf=$createdAt->format('Y-m-d H:i:s');
                             }
                if($key=="id"){
                $playId=$valueR;
                            }
                                           
                             }
                                            
                    $notify2 .= '<div class="">
                               
                                 <input type="hidden" name="userId" value="'.$url_user.'">
                            <div class="removeitem'.$playId.'">
                            <input type="hidden" id="playerId" name="playerId[]" value="'.$playId.'">
                                <span disabled style="font-weight: bold">"'.$abc.'"  Registered On '.$csf.'</span>
                            <a href="javascript:;" class="btn edit_btn" data-toggle="tooltip" title="Delete Device" id="'.$playId.'" onclick="removethis(this.id);"  style="width:37px;">
                                <i class="glyphicon glyphicon-trash trash fa fa-trash"></i>
                                </a>

                                            </div>
                                            </div>';
                                          


                                        }
                                    }


    

   return $notify2;
}

public function allweekend($user){
    
    $notify = "";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($user,'cdashboard'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Compliance Dashboard
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[cdashboard]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[cdashboard]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[cdashboard]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[cdashboard]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'ccalendar'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Compliance Calendar
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[ccalendar]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[ccalendar]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[ccalendar]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[ccalendar]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=?  AND `type`= ? ",array($user,'myuploads'));
    $notify .= "<div class='form-group col-12 col-sm-3'>My Uploads
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[myuploads]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[myuploads]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[myuploads]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[myuploads]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($user,'health_form'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Health Form
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[health_form]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[health_form]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[health_form]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[health_form]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`=?",array($user,'hrdashboard'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Dashboard
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrdashboard]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrdashboard]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrdashboard]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrdashboard]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrreports'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Reports
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrreports]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrreports]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrreports]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrreports]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrrota'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Rota
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrrota]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrrota]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrrota]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrrota]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrqr'));
    $notify .= "<div class='form-group col-12 col-sm-3'>QR Code
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrqr]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrqr]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrqr]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrqr]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hruser'));
    $notify .= "<div class='form-group col-12 col-sm-3'>My Staff
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hruser]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hruser]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hruser]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hruser]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>
                    
                </div>";
    return $notify;

}
public function superUser($user){
    $notify = "";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'cdashboard'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Compliance Dashboard
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[cdashboard]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[cdashboard]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[cdashboard]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[cdashboard]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'ccalendar'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Compliance Calendar
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[ccalendar]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[ccalendar]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[ccalendar]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[ccalendar]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'myuploads'));
    $notify .= "<div class='form-group col-12 col-sm-3'>My Uploads
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[myuploads]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[myuploads]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[myuploads]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[myuploads]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'health_form'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Health Form
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[health_form]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[health_form]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[health_form]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[health_form]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrdashboard'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Dashboard
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrdashboard]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrdashboard]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrdashboard]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrdashboard]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrreports'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Reports
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrreports]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrreports]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrreports]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrreports]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrrota'));
    $notify .= "<div class='form-group col-12 col-sm-3'>HR Rota
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrrota]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrrota]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrrota]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrrota]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hrqr'));
    $notify .= "<div class='form-group col-12 col-sm-3'>QR Code
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hrqr]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hrqr]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hrqr]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hrqr]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
    $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'hruser'));
    $notify .= "<div class='form-group col-12 col-sm-3'>My Staff
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[hruser]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[hruser]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[hruser]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[hruser]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
$d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'superuser_access'));
    $notify .= "<div class='form-group col-12 col-sm-3'>SuperUser Access
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[superuser_access]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[superuser_access]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";
  
   $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'private_folder'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Private Folder
                    <label class='ccheckbox'>
                    <input type='radio' value='off' name='superUser[private_folder]' ".((@$d['allow'] == 'off') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    
                    <label class='ccheckbox'>
                    <input type='radio' value='on' name='superUser[private_folder]' ".((@$d['allow'] == 'on') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";



                   $d = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'manage_stock'));
    $notify .= "<div class='form-group col-12 col-sm-3'>Stock Management
                    <label class='ccheckbox'>
                    <input type='radio' value='0' name='superUser[manage_stock]' ".((@$d['allow'] == '0') ? "checked" : "").">
                    <span class='cmark'></span>Not Access
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='read' name='superUser[manage_stock]' ".((@$d['allow'] == 'read') ? "checked" : "").">
                    <span class='cmark'></span>Read Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='edit' name='superUser[manage_stock]' ".((@$d['allow'] == 'edit') ? "checked" : "").">
                    <span class='cmark'></span>Edit Only
                    </label>
                    <label class='ccheckbox'>
                    <input type='radio' value='full' name='superUser[manage_stock]' ".((@$d['allow'] == 'full') ? "checked" : "").">
                    <span class='cmark'></span>Full Access
                    </label>
                </div>";




    return $notify;
}

public function webUserEdit($page){
$readonly = "";
$hide = "";
if($_SESSION['currentUserType'] == 'Employee' &&  !isset($_SESSION['superUser'])){

    $readonly = "readonly";
    $hide = "style='display:none'";
    $emphide = "style='display:none'";
}

  
 
$action = "";
$cpdchk = "";
$atut = true;
$new = false;

if(isset($_GET['userId']) && isset($_SESSION['superUser'])){
    $id = $_GET['userId'];
   @$SuperUserAccess = $this->dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`= ? AND `type`= ? ",array($_SESSION['superid'],'superuser_access'));
}
else
{
    $id = intval($_SESSION['webUser']['id']);
}
if ($_SESSION['currentUserType'] == 'Employee') {
   $hide = "style='display:none'";
  
}
$superactive= $hide;
if ($_SESSION['currentUserType'] == 'Employee' &&  isset($_SESSION['superUser'])) {
    $superactive = "style='display:block'";
}
$this->notificationsAdd($id);
$required ='';
if($page == 'Add Profile'){
    $new = true; $action = "manage-users"; $cpdchk = "checked"; $atut = false;
     $required = 'required';
     $devicenotification = '';

    


}
else{
    $devicenotification = "dental community";
    $sql    = "SELECT * FROM accounts_user WHERE acc_id = ? ";
    $userData   =   $this->dbF->getRow($sql,array($id));
    $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = ? ";
    $userInfo   = $this->dbF->getRows($sql,array($id));
  

}


$token  =    $this->functions->setFormToken('webUserEdit',false);


echo '
<form class="profile" action="'.$action.'" role="form" method="post" enctype="multipart/form-data">'.$token.'
    <input type="hidden" name="oldId" value="'.@$id.'" />
    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">  
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all"
                    role="tablist">
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0"
    aria-controls="tabs-1" aria-labelledby="ui-id-2" aria-selected="true" aria-expanded="true">
    <a active="" href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1"
        id="ui-id-2">Personal Details</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2"
    aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false">
    <a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Work Details</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3"
    aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false">
    <a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">HR Details</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4"
    aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false">
    <a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">Payment Details</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-5"
    aria-labelledby="ui-id-6" aria-selected="false" aria-expanded="false">
    <a href="#tabs-5" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6">CPD Details</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-6"
    aria-labelledby="ui-id-7" aria-selected="false" aria-expanded="false">
    <a href="#tabs-6" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-7">Password</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-7"
    aria-labelledby="ui-id-8" aria-selected="false" aria-expanded="false">
    <a href="#tabs-7" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-8">Notifications</a>
</li>';

if(($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['superuser_access'] == 'full') || $_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice'){

echo    '
<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-8"
    aria-labelledby="ui-id-9" aria-selected="false" aria-expanded="false">
    <a href="#tabs-8" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-9">Super User</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-9"
    aria-labelledby="ui-id-10" aria-selected="false" aria-expanded="false">
    <a href="#tabs-9" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-10">MemberShip</a>
</li>';
}
else{
echo    '
<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-8"
    aria-labelledby="ui-id-9" aria-selected="false" aria-expanded="false">
    <a href="#tabs-8'.$hide.'" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-9">Super User</a>
</li>

<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-9"
    aria-labelledby="ui-id-10" aria-selected="false" aria-expanded="false">
    <a href="#tabs-9'.$hide.'" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-10">MemberShip</a>
</li>';
 } 

        echo '</ul>
        <div id="tabs-1" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="false" style="display: block;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>Name</label>
                    <input type="text" name="name" value="'.@$userData['acc_name'].'" required vali()">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Practice Name</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'practice name').'" name="signUp[practice name]" '.$readonly.'>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Personal Email</label>
                    <p id="chkDuplicateEmailTXT" style="
    color: red;
"></p>
                    <input type="email" id="chkDuplicateEmail" value="'.@$userData['acc_email'].'" name="email" required>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Personal Contact Number</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'phone').'" name="signUp[phone]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Personal Address</label>
                    <textarea name="signUp[address]">'.@$this->webUserInfoArray($userInfo,'address').'</textarea>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Gender</label>
                    <label>
                        <input type="radio" class="gender" name="signUp[gender]" value="male">&nbsp;Male
                    </label>
                    <label>
                        <input type="radio" class="gender" name="signUp[gender]" value="female">&nbsp;Female
                    </label>
                </div>
                <script>
                    $(document).ready(function(){
                    $(".gender[value=\''.@strtolower($this->webUserInfoArray($userInfo,'gender')).'\']").attr("checked", true);
                    });
                </script>
                <div class="form-group col-12 col-sm-6">
                    <label>Next Of Kin</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'kin_name').'" name="signUp[kin_name]"  vali()">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Next Of Kin Contact Number</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'kin_phone').'" name="signUp[kin_phone]">
                </div>


                ';


                if($atut){
                echo'
                <div class="form-group col-12 col-sm-6">
                    <label>Account Type</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'account_type').'" name="signUp[account_type]" readonly>
                </div>
                <input type="hidden" value="'.@$this->webUserInfoArray($userInfo,'account_under').'" name="signUp[account_under]">';
                }
                else{
                    echo'<input type="hidden" value="Employee" name="signUp[account_type]">
                    <input type="hidden" value="'.$_SESSION['currentUser'].'" name="signUp[account_under]">';
                }
                if($atut){
                echo'
                <div class="form-group col-12 col-sm-6">
                    <label>User Type</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'user_type').'" name="signUp[user_type]" readonly>
                </div>';
                }
                else{
                    echo'<input type="hidden" value="Standard" name="signUp[user_type]">';
                }
                echo '
            </div>';


             $daysss = @$userData['dayoff'];
                $offday = explode(",",$daysss); ?>
                <div class='col-12'>
                <h3>Weekends</h3>
                <strong><p>Please tick your  non-working days</p></strong>
               <label class='ccheckbox'>
                    <input type='checkbox' value='1' name="dayoff[]" <?php if (in_array("1", $offday))  {echo "checked"; }?>>
                    <span class='cmark'></span>Monday
                    </label>
                    <label class='ccheckbox'>
                    <input type='checkbox' value='2' name="dayoff[]" <?php if (in_array("2", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Tuesday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='3' name="dayoff[]" <?php if (in_array("3", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Wednesday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='4' name="dayoff[]" <?php if (in_array("4", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Thusday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='5' name="dayoff[]" <?php if (in_array("5", $offday))  {echo "checked"; }?> >
                    <span class='cmark'></span>Friday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='6' name="dayoff[]" <?php if (in_array("6", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Saturday
                    </label> 
                    <label class='ccheckbox'>
                    <input type='checkbox' value='7' name="dayoff[]" <?php if (in_array("7", $offday))  {echo "checked"; }?>  >
                    <span class='cmark'></span>Sunday
                    </label>
                </div>

<?php
      echo'  </div>
        <div id="tabs-2" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>Practice Address</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'practice_address').'" name="signUp[practice_address]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Work Email Address</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'work_email').'" name="signUp[work_email]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Practice Contact Number</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'practice_contact').'" name="signUp[practice_contact]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Role</label>
                    <Select class="role" name="signUp[role]" '.$readonly.'>
                        '.$this->accountRole().'
                    </select>
                    <script>
                    $(document).ready(function(){
                        $(".role").val("'.@$this->webUserInfoArray($userInfo,'role').'").change();
                    });
                    </script>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Responsibility</label>
                    <Select class="responsibility" name="signUp[responsibility]" '.$readonly.'>
                        '.$this->responsibility().'
                    </select>
                    <script>
                    $(document).ready(function(){
                        $(".responsibility").val("'.@$this->webUserInfoArray($userInfo,'responsibility').'").change();
                    });
                    </script>
                </div>
            </div>
        </div>
        <div id="tabs-3" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>Contract Type</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'contract_type').'" name="signUp[contract_type]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Start Date</label>
                    <input class="datepickerr" type="text" value="'.@date("d-M-Y",strtotime($this->webUserInfoArray($userInfo,'start_date'))).'" name="signUp[start_date]" autocomplete="off" readonly>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Hour Worked (weekly)</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'hours_worked').'" name="signUp[hours_worked]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Salary (per hour)</label>
                    <input type="text" id="txtChar" onkeypress="return isNumberKey(event)" value="'.@$this->webUserInfoArray($userInfo,'salary').'" name="signUp[salary]" '.$readonly.'>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Probation Period End </label>
                    <input type="text" class="datepickerr" value="'.@$this->webUserInfoArray($userInfo,'probation_period_end').'" name="signUp[probation_period_end]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Holiday Entitlement (days)</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'holiday_entitlement').'" name="signUp[holiday_entitlement]" '.$readonly.'>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Date Of Birth</label>
                    <input class="datepickerr" type="text" value="'.@date("d-M-Y",strtotime($this->webUserInfoArray($userInfo,'date_of_birth'))).'" name="signUp[date_of_birth]" autocomplete="off" readonly>
                </div>
            </div>
        </div>
        <div id="tabs-4" aria-labelledby="ui-id-5" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>Bank Name</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'bank_name').'" name="signUp[bank_name]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Sort Code</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'sort_code').'" name="signUp[sort_code]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Account Number</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'account_number').'" name="signUp[account_number]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Bank Account Holder Name</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'account_holder_name').'" name="signUp[account_holder_name]">
                </div>
            </div>
        </div>
        <div id="tabs-5" aria-labelledby="ui-id-6" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>CPD Cycle Start Date</label>
                   <input class="datepickerr" type="text" value="'.@date("d-M-Y",strtotime($this->webUserInfoArray($userInfo,'cpd_start_date'))).'" name="signUp[cpd_start_date]" '.$readonly.'>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>GDC Number</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'gdc_number').'" name="signUp[gdc_number]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>
                    <input '.$cpdchk.' type="checkbox" value="1" name="signUp[cpd_certificates]" '.( (@$this->webUserInfoArray($userInfo,'cpd_certificates') == '1') ? "checked" : "" ).'>
                        Allow My Practice Manager to view my CPD certificates
                    </label>
                </div>
            </div>
        </div>
       
                <hr>';
                    $default="";
                    $defaultvalvalue="";
                if(!$new){echo '<div class="form-group col-12 col-sm-6">
                    <label for="pin">Pin</label>
                    <input pattern="[0-9]+" type="password" name="pin" id="pin" placeholder="Default Pin: 000000" minlength="6" maxlength="6">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="pin">Retype Pin</label>
                    <input pattern="[0-9]+" type="password" name="rpin" id="rpin"  maxlength="6" minlength="6">
                </div>';}else{
                    $default="(Default: welcome)";
                    $defaultvalvalue="welcome";
                }
                echo'<div class="form-group col-12 col-sm-6">
                    <label for="pass">Password '.$default.'</label>
                    <input type="password" onChange="passM();" name="pass" id="pass" placeholder="Default Password: welcome" value="'.$defaultvalvalue.'" >
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="rpass">Retype Password</label>
                    <input type="password" onChange="passM();" onkeyup="passM();" name="rpass" id="rpass"  value="'.$defaultvalvalue.'">
                    <div id="pm"></div>
                </div>
            </div>
        </div>
         <div id="tabs-7" aria-labelledby="ui-id-8" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
             <div class="row">'.$this->notificationsView($id).'
             
          
            </div>
            
             <div id="tabs-6" aria-labelledby="ui-id-7" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label>Interests</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'interests').'" name="signUp[interests]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Post Code</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'post_code').'" name="signUp[post_code]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>City</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'city').'" name="signUp[city]">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Enrollment Number</label>
                    <input type="text" value="'.@$userData['roll'].'" name="roll">
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Country</label>
                    <input type="text" value="'.@$this->webUserInfoArray($userInfo,'country').'" name="signUp[country]">
                </div>
                ';
 if(($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == 'full') || $_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice'){

               echo  '<div class="form-group col-12 col-sm-6" >
                    <label>Account Status</label>
                    <label>
<input type="radio" class="acc_type" name="acc_type" value="1" ';
if(@$userData['acc_type']=="1") { echo "checked"; }
echo'>&nbsp;Active
                    </label>
                    <label>
        <input type="radio"  class="acc_type" name="acc_type" value="0" ';
        if(@$userData['acc_type']=="0" ) { echo "checked"; } 
           echo '>&nbsp;DeActive
                    </label>
                </div>
                <script>
                    $(document).ready(function(){
                        $(".acc_type[value=\''.@$userData['acc_type'].'\']").attr("checked", true);
                    });
                </script>';
                }
                if(!$new){
                echo '
                <div class="form-group col-12 col-sm-6">
                    <label>Account Create</label>
                    <input type="text" value="'.@$userData['acc_created'].'" readonly>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label>Last Update</label>
                    <input type="text" value="'.@$userData['acc_timestamp'].'" readonly>
                </div>';
                }
                echo'
                <div class="form-group col-12 col-sm-6">
                    <label>Profile Image</label>';
                    if(!$new && @$userData['acc_image'] !=''){
                    echo '<img src="images/'.@$userData['acc_image'].'" style="width: 100px">
                    <br>';
                    }
                    echo '<div class="file">
                        <input type="hidden" name="old_image" value="'.@$userData['acc_image'].'">
                        <input type="file" name="image">
                        <i class="fas fa-paperclip"></i>
                        <div>Upload</div>
                    </div>
                </div>
            ';  
              
              
             
                 
                 if (!empty($devicenotification)) {
                 echo '<div class="col-12"><h3>Devices</h3></div>';
               //$this->notificationsallowModels();
            }

      echo '</div>
        <div id="tabs-8" aria-labelledby="ui-id-9" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;">';
        if(($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['superuser_access'] == 'full') || $_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice'){

if($this->webUserInfoArray(@$userInfo,'superuser')=='on'){
       echo '
                <div class="form-group col-12 col-sm-6">
                    <label>Super User</label>
                    <label>
                        <input type="radio" class="superuser" name="signUp[superuser]" value="on" checked >&nbsp;Active

                    </label>
                    <label>
                        <input type="radio" class="superuser" name="signUp[superuser]" value="off">&nbsp;DeActive
                    </label>
                </div>
               ';
}else{
       echo '
                <div class="form-group col-12 col-sm-6">
                    <label>Super User</label>
                    <label>
                        <input type="radio" class="superuser" name="signUp[superuser]" value="on">&nbsp;Active

                    </label>
                    <label>
                        <input type="radio" class="superuser" name="signUp[superuser]" value="off" checked >&nbsp;DeActive
                    </label>
                </div>
                ';
}                
            }
        //          if(($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == 'full') || $_SESSION['currentUserType'] == 'master' || $_SESSION['currentUserType'] == 'practice'){
   
        //   $sup = $this->webUserInfoArray($userInfo,'superuser');
        //   if ($sup == 'off') {
             
        //     $_SESSION['superUser']['cdashboard'] = '0';
        //     $_SESSION['superUser']['ccalendar'] = '0';
        //     $_SESSION['superUser']['health_form'] = '0';
        //     $_SESSION['superUser']['myuploads'] = '0';
        //     $_SESSION['superUser']['hrrota'] = '0';
        //     $_SESSION['superUser']['hrdashboard'] = '0';
        //     $_SESSION['superUser']['hruser'] = '0';
        //     $_SESSION['superUser']['hrreports'] = '0';
        //     $_SESSION['superUser']['hrqr'] = '0';
          

        //   }
        //   }
                echo' <div class="row rowsup">'.$this->superUser($id).'</div>';
           
       echo '</div>
         <div id="tabs-9" aria-labelledby="ui-id-10" class="ui-tabs-panel ui-widget-content ui-corner-bottom"
                    role="tabpanel" aria-hidden="true" style="display: none;"><div style="padding:10px"> ';
        
        $sql  = "SELECT * FROM `orders` WHERE `order_user`=? AND `product_id` IN (1,14,22,23,24,82,87,89,90,139,157)  AND  order_mandate != ''  ";
    $data =  $this->dbF->getRows($sql,array($id));
    echo ' <h3>Membership Detail</h3>';
       if($data == true)
       {
        echo '<div class="">'.$this->membership($id).'</div> <div class ="hideshow"  style="display: none;"></div>
        </div><style>
        .hideshow{
            top: 65px;width: 256px;height: 115px;background-color: #e5f3f2;z-index: 1;position: relative;
        }
        
        @media only screen and (max-width: 461px) {
        
        .hideshow {top: 0px; width: 100%; height: 65px; background-color: #e5f3f2;z-index: 99999999; position: absolute; margin-top: 657px;}}</style>
        
        
        
        ';   
       }
       else
       {
           
          echo "
          <style>
        .hideshow{
           top: 112px; width: 275px; height: 98px; left: 1px; background: var(--bg-color-accent);  z-index: 99999999; position: absolute;
        }
        
        @media only screen and (max-width: 461px) {
        
        .hideshow {top: -574px; width: 100%; height: 65px; background-color: #e5f3f2;z-index: 99999999; position: absolute; margin-top: 657px;}}</style>
          
          <h5>No Data Found</h5><div class='hideshow' style=' '></div>
          
          
          
          "; 
       }
        
    echo '</div></div>
    <button type="submit" name="submit" id="signup_btn" class="submit_class ">Save</button>
    </div>
</form>
'; ?>
<script type="text/javascript">
     $(document).ready(function(){
       
 $("#signup_btn").removeAttr("type","submit");
 $("#signup_btn").removeAttr("name","submit");
});


$("#signup_btn").click(function(){
  

if (document.getElementById("pass").value != '' && document.getElementById("rpass").value == '') {

    alert("Please Enter a Retype Password");
die();
}

});







function passM() {
var pass = document.getElementById("pass").value;
var rpass = document.getElementById("rpass").value;
 

if (pass.length >= 4) {
if (pass == rpass) {
     $("#signup_btn").attr("type","submit");
 $("#signup_btn").attr("name","submit");

 $("signup_btn").attr("type","submit");
document.getElementById("pm").style.color = "green";
document.getElementById("pm").innerHTML = "<?php $this->dbF->hardWords('Password Matched!'); ?>";
document.getElementById("signup_btn").disabled = false;
}
else {
document.getElementById("pm").style.color = "red";
document.getElementById("pm").innerHTML = "<?php $this->dbF->hardWords('Password Not Matched!'); ?>";
document.getElementById("signup_btn").disabled = true;
}
}
else {
document.getElementById("pm").style.color = "orange";
document.getElementById("pm").innerHTML = "<?php $this->dbF->hardWords('Atleat 4 characters!'); ?>";
document.getElementById("signup_btn").disabled = true;
}
if(pass=='' && rpass==''){
document.getElementById("signup_btn").disabled = false;
}
}
function vali() {
var u_l = document.getElementById("user").value.length;
if (u_l <= 3) {
document.getElementById("um").style.color = "red";
document.getElementById("signup_btn").disabled = true;
}
else {
document.getElementById("um").style.color = "black";
document.getElementById("signup_btn").disabled = false;
}
}
function subf() {
var terms = document.getElementById("ch").checked;
if (terms == true) {
document.getElementById("sf").submit();
}
}
$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    
    $(this).parent('div').find('div').text(filename);
});





</script>

<?php
}

public function multiLanguageFlags(){
$currentLang = currentWebLanguage();
$temp = "";
$data   =   unserialize($this->functions->ibms_setting('Languages'));
$link   =   $this->functions->defaultHttp.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$parm = false;
if(!empty($_GET)){
$parm = true;
if(isset($_GET['lang'])){
$old = $_GET['lang'];
foreach($data as $val) {
$link = str_replace("&lang=$val","",$link);
$link = str_replace("?lang=$val","?",$link);
}
}
}

foreach($data as $val){
$link2 = $link;
if($parm){
$link2 .= "&lang=$val";
}else{
$link2 .= "?lang=$val";
}
$active = '';
if($currentLang == $val){
$active = 'active';
}

$countryKey = $this->functions->countryKeyByName($val);
$temp .= "<a href='$link2'>
<div class='$active country flag flag-$countryKey  transition_3 float-shadow'></div>
</a>";
}

return $temp;
}
public function multiLanguage(){
$currentLang = currentWebLanguage();
$temp = "";
$temp .= '<div class="dropdown ">
<button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
'.$currentLang.'
<span class="caret"></span>
</button>
<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">';


$data   =   unserialize($this->functions->ibms_setting('Languages'));
$link   =   $this->functions->defaultHttp.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$parm = false;
if(!empty($_GET)){
$parm = true;
if(isset($_GET['lang'])){
$old = $_GET['lang'];
foreach($data as $val) {
$link = str_replace("&lang=$val","",$link);
$link = str_replace("?lang=$val","?",$link);
}
}
}

foreach($data as $val){
$link2 = $link;
if($parm){
$link2 .= "&lang=$val";
}else{
$link2 .= "?lang=$val";
}
$active = '';
if($currentLang == $val){
$active = 'active';
}

$temp .= "<li class='$active' role='presentation'><a role='menuitem' tabindex='-1' href='$link2'>$val</a></li>";
}

$temp .= '</ul>
</div>';
return $temp;
}


public function setMultiLanguage(){ 
if( isset($_GET['lang']) && lang_define == false ){
unset($_SESSION['klarna_checkout']);
//check is language has
$data   =   unserialize($this->functions->ibms_setting('Languages'));
$lang = $_GET['lang'];
foreach($data as $val){
if($lang == $val){
$_SESSION['webUser']['webLang']  =  $val;
}
}

}elseif( isset($_GET['lang']) ){
//check is language has
$data   =   unserialize($this->functions->ibms_setting('Languages'));
$lang = $_GET['lang'];
foreach($data as $val){
if($lang == $val){
$_SESSION['webUser']['webLang']  =  $val;
}
}
}

}


public function includeScript(){
$temp = <<<HTML

HTML;
return $temp;

}


public function get_product_by_category( $category )
{
return $this->dbF->getRows(' SELECT * FROM `products` WHERE `shortDesc` = ? AND `publish` = 1 ', array($category) );
}




public function print_products( $rows , $catname )
{
$html = <<<HTML

<div id="products_listing" class="productlist_content1">

<h1> {$catname} </h1>

HTML;

foreach ($rows as $row) {
$title       = $this->functions->unserializeTranslate($row['heading']);
$image       = $this->get_product_first_image($row['id']);
$first_image = WEB_URL . '/images/' . $image['image'];
$image_alt   = $image['alt'];

$html .= <<<HTML

<a href="#" class="open_box" data-id="{$row['id']}" >
<div class="product_items">

<table>
<tr>
<td> <img src="{$first_image}" alt="{$image_alt}" style="width:100%;" > </td>
</tr>
</table>

<div class="product_name hvr-shutter-out-horizontal">
{$title}
</div> 

</div> <!-- end of product_items -->
</a>
HTML;

}

$html .= <<<HTML

</div> <!-- end of product_content1 -->

HTML;

return $html;

}

function get_conduct_text($pg) {
    //global $dbp;

    $sql = "SELECT `ethics` FROM `paper` WHERE `paper_id` = ? ";
    $data = $this->dbF->getRow($sql,array($pg));
    return $data[0];
}



public function print_categories( $rows, $heading )
{
global $_e;
// $hardword = $_e['Our Product Range'];

$boxes_array = array('box18','box19');

$html = <<<HTML


<div class="product_content1">

<h1>{$heading}</h1>

<div class="both_products">

HTML;


$i = 0;
foreach ($rows as $row) {
$box = $this->getBox($boxes_array[$i]);

$cat       = urlencode($row['category']);
$cat_image = strtolower(str_replace(' ', '_', $row['category']));
$html .= <<<HTML

<a href="?pcat={$cat}"> 
<div class="product1">
<div class="international_product"> 
{$box['heading']}
</div>
<img src="{$box['image']}" width="100%">  
</div>
</a>
HTML;

$i++;

}


$html .= '

</div>

</div> <!-- end of product_content1 -->';

return $html;

}


public function get_products_bycategory($id)
{
return $this->dbF->getRows("SELECT `id`,`heading`,`category` FROM `products` WHERE category= ? ",array($id));
}



public function get_categories_detail($ids)

{


return $this->dbF->getRows("SELECT  DISTINCT heading , dsc , nutritional_facts , pd.image FROM `products_images` pd INNER JOIN products pf ON pf.id = pd.`product_id` where pf.id= ? GROUP BY pd.product_id",array($ids));



// SELECT
//   *
// FROM
//   `products_images` pd
// INNER JOIN
// //   products pf ON pf.id = pd.`product_id`

// SELECT  heading , dsc , nutritional_facts , pd.image FROM `products_images` pd INNER JOIN products pf ON pf.id = pd.`product_id` GROUP BY pf.id


}





public function get_categories()
{
return $this->dbF->getRows('SELECT DISTINCT `category` FROM `products` WHERE `category` != "" ');    }

// public function get_brandcategories()
// {
// return $this->dbF->getRows('SELECT DISTINCT `category`,`heading` FROM `products` WHERE `category` != "" ');
// }


// brand




















public function get_product_first_image( $product_id )
{
return $this->dbF->getRow(' SELECT * FROM `products_images` WHERE `product_id` = ? ORDER BY `sort` ASC ', array($product_id) );
}

public function get_product_image_spbs( $product_id )
{
return $this->dbF->getRows(' SELECT * FROM `products_images` WHERE `product_id` = ? ORDER BY `sort` ASC ', array($product_id) );
}

public function print_product_image_spbs( $rows )
{

# if array is empty then set default image
if( $rows == array()  ) { 
$rows[0]['image'] = 'image-coming-soon.png'; 
$rows[0]['alt'] = 'Image Coming Soon';
// return false;
}

$html = ' <ul id="slider_1"> ';
foreach ($rows as $row) {
$image_link = WEB_URL . '/images/' . ($row['image']);
$alt        = translateFromSerialize($row['alt']);
$html .= <<<HTML

<li>
<a href="#"> <img src="{$image_link}" alt="{$alt}"></a>
</li>
HTML;

}

$html .= ' </ul>  <!-- end of #slider_1 -->';

return $html;
}

public function get_product_recipes( $product_id )
{
return $this->dbF->getRows(' SELECT * FROM `recipes` WHERE `product_id` = ? AND `publish` = 1 ORDER BY `updated` DESC ', array($product_id) );
}

public function print_product_recipes( $rows )
{

# if array is empty then return, dont print recipes
if( $rows == array()  ) { return false; }

$html = '

<div class="recipe_text">
<h2>Related Recipes</h2>
</div>

<marquee class="recipes" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();" > ';
foreach ($rows as $row) {
$image_link = $this->addWebUrlInLink($row['image']);
$link       = WEB_URL . '/' . $this->db->recipePage . '?recipe=' . base64_encode($row['id']);
$title      = $row['title'];
$html .= <<<HTML

<div class="img_rec">
<a href="{$link}"><img src="{$image_link}" alt="{$title}" ></a>
</div>

HTML;

}

$html .= '</marquee> <!-- end of recipes -->';

return $html;
}

public function get_recipe($recipe_id)
{
return $this->dbF->getRow(' SELECT * FROM `recipes` WHERE `id` = ? AND `publish` = 1 ', array($recipe_id) );
}






public function files($data){

$temp="";   
// echo "<div class='link_side_ul'>";
$temp.="<style>
.info123 span {
color: #ff0000;
text-shadow: 0px 0px #ff0000;
font-size: 13px;
padding: 5px 0px;
/* display: block; */
max-height: 27.77px;
overflow: hidden;
}

</style>";
// var_dump($data);


// $insert = trim($data);

$sql = "SELECT * FROM `file` WHERE `file_position` = ? and `publish` = 1 ORDER BY `id` DESC";
// SELECT * FROM `financial_reports` WHERE `testimonial_position` = "Annual"

$fdata      =   $this->dbF->getRows($sql,array($data));

// $data = $this->dbF->getRow($sql,array($link));


// <div class="info1">
// <h3>Financial Reports</h3>
// <ul>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2016</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Half Yearly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Quarterly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2015</a></li>
// </ul>
// </div>




$temp   .=  "<br /><div class='info123'>
<h4>".$data."</h4><br />
<ul>";

foreach($fdata  as $val){
// $image    =   WEB_URL."/images/".$val['image'];
$title  = getTextFromSerializeArray($val['file_heading']);
$type   = getTextFromSerializeArray($val['file_position']);
$link   = $this->addWebUrlInLink(getTextFromSerializeArray($val['file_image']));

$temp   .= ' 
<li> 
<span><img src="webImages/dot.png" alt=""></span>
<a target="_blank" href="'.$link.'">

'.$title.'

</a>
</li>';
}

$temp .= "</ul></div>




";










// echo "";
return $temp;





}




public function index1(){




$temp="";   
// echo "<div class='link_side_ul'>";
$temp.="";
// var_dump($data);


// $insert = trim($data);

$sql = "SELECT * FROM `file` WHERE `file_position` = ? and `publish` = 1 ORDER BY `file`.`id` DESC limit 4";
// SELECT * FROM `financial_reports` WHERE `testimonial_position` = "Annual"

$fdata      =   $this->dbF->getRows($sql,array("Closing Note"));

// $data = $this->dbF->getRow($sql,array($link));


// <div class="info1">
// <h3>Financial Reports</h3>
// <ul>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2016</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Half Yearly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Quarterly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2015</a></li>
// </ul>
// </div>




$temp   .=  "";

foreach($fdata  as $val){
// $image    =   WEB_URL."/images/".$val['image'];
$title  = getTextFromSerializeArray($val['file_heading']);
$type   = getTextFromSerializeArray($val['file_position']);
$link   = $this->addWebUrlInLink(getTextFromSerializeArray($val['file_image']));

$temp   .= ' 
<li> 
<a target="_blank" href="'.$link.'">

'.$title.'

<span><img src="webImages/icon9.png" alt=""></span>
</a>
</li>';
}






$temp .= "";










// echo "";
return $temp;







}









public function index(){




$temp="";   
// echo "<div class='link_side_ul'>";
$temp.="";
// var_dump($data);


// $insert = trim($data);

$sql = "SELECT * FROM `file` WHERE `file_position` = ? and `publish` = 1 ORDER BY `file`.`id` DESC limit 4";
// SELECT * FROM `financial_reports` WHERE `testimonial_position` = "Annual"

$fdata      =   $this->dbF->getRows($sql,array("Morning Briefing"));

// $data = $this->dbF->getRow($sql,array($link));


// <div class="info1">
// <h3>Financial Reports</h3>
// <ul>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2016</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Half Yearly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Quarterly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2015</a></li>
// </ul>
// </div>




$temp   .=  "";

foreach($fdata  as $val){
// $image    =   WEB_URL."/images/".$val['image'];
$title  = getTextFromSerializeArray($val['file_heading']);
$type   = getTextFromSerializeArray($val['file_position']);
$link   = $this->addWebUrlInLink(getTextFromSerializeArray($val['file_image']));

$temp   .= ' 
<li> 
<a target="_blank" href="'.$link.'">

'.$title.'

<span><img src="webImages/icon9.png" alt=""></span>
</a>
</li>';
}






$temp .= "";










// echo "";
return $temp;







}



public function career_form(){

$temp="";   
$sql = "SELECT * FROM `careers` WHERE `publish` = 1 ORDER BY `date` desc";
$fdata      =   $this->dbF->getRows($sql);
$i      =   0;

foreach($fdata  as $val){

$title  = getTextFromSerializeArray($val['heading']);


$temp   .= '
<div class="main_popup">
<div class="close_popup">
<button id="close_popup">X</button>
</div>
<div class="inner_popup">
<h1>'.$this->dbF->hardWords('Apply Online',false).'</h1>
<h3>'.$title.'</h3>
<form>
<input type="text" placeholder="First Name" class="fi">
<input type="text" placeholder="Last Name" class="si">
<input type="tel" placeholder="Phone" class="fi">
<input type="text" placeholder="Company" class="si">
<input type="email" placeholder="Email">
<div class="file">
<div class="file_left">
<div class="nm">Resume/CV*</div>
<span class="fl">
<input type="file">
<i class="fa fa-paperclip" aria-hidden="true"></i>
Attach Resume/CV
</span>
</div>
<div class="file_right">
<span class="wrd">Supported formats</span>
pdf, docx, doc, jpg, png
</div>
</div>
<input type="text" placeholder="Others (portfolio) Url">
<input type="text" placeholder="Additional Information">
<input type="submit" value="Apply Online">
</form>
</div>
</div><!-- main_popup -->



<script type="text/javascript">
$("#apply'.$i.'").click(function(){
    $(".main_popup").fadeIn(200);
});
</script>
';

$i++;

}












// echo "";
return $temp;





}




public function finance($data){

$temp="<div class='product_side'>";   
// echo "<div class='link_side_ul'>";
//         $temp.="<style>
// .info123 span {
//     color: #ff0000;
//     text-shadow: 0px 0px #ff0000;
//     font-size: 13px;
//     padding: 5px 0px;
//     /* display: block; */
//     max-height: 27.77px;
//     overflow: hidden;
// }

// </style>";
// var_dump($data);


// $insert = trim($data);

$sql = "SELECT * FROM `products` WHERE `shortDesc` = ? and `publish` = 1 ORDER BY `sort` ASC";
// SELECT * FROM `financial_reports` WHERE `testimonial_position` = "Annual"

$fdata      =   $this->dbF->getRows($sql,array(serialize($data)));

// $data = $this->dbF->getRow($sql,array($link));


// <div class="info1">
// <h3>Financial Reports</h3>
// <ul>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2016</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Half Yearly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Quarterly Reports</a></li>
// <li><span><img src="webImages/dot.png" alt=""></span><a href="#">Annual Reports 2015</a></li>
// </ul>
// </div>




// $temp   .=  "<br /><div class='info123'>
//   <h4>".$data."</h4><br />
// <ul>";

foreach($fdata  as $val){
// $image    =   WEB_URL."/images/".$val['image'];
$title  = getTextFromSerializeArray($val['heading']);

$description   = unserialize($val['description']);

$link   = $this->addWebUrlInLink($val['link']);


$image = WEB_URL."/images/".$val['image'];



$temp   .= '<div class="product1">

<div class="product_img"><img src="'.$image.'" alt=""></div>

<div class="product_txt">
<a href="'.$link.'"><h5>'.$title.'</h5></a>
<div class="product_txt1"> '.$description.' </div>

</div>

</div> ';
}

$temp .= "</div>";










// echo "";
return $temp;





}

public function get_category(){
return $this->dbF->getRows('SELECT * FROM `categories` WHERE `under` = 0 '); 
}

public function tabss1(){

$temp="";   
$sql = "SELECT * FROM `tabsnew` WHERE `publish` = 1";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray(base64_decode($val['dsc']));
$temp   .= '
<div id="tabs-'.$id.'">
'.$title.'
</div>
';
}

return $temp;
}
public function award(){

$temp="";   
$sql = "SELECT * FROM `client` WHERE `publish` = 1 order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$image    =  WEB_URL."/images/".$val['image'];
$temp   .= '<div class="inner_awards">
<img src="'.$image.'" alt="">
</div>';
}

return $temp;
}


public function video_gal(){

$temp="";   
$count=1;   
$sql = "SELECT * FROM `video` WHERE `publish` = 1";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$image    =  WEB_URL."/images/".$val['image'];
$title  = getTextFromSerializeArray($val['dsc']);
$temp   .= '
<div class="gallery_img">
<a class="fancybox" href="#inline'.$count.'" data-fancybox-group="inline">
<img src="'.$image.'" alt=""/></a>
<div id="inline'.$count.'" class="vd">
<video controls>
<source src="webImages/album-1.mp4" type="video/mp4">
</video>
</div>
<h3>'.$title.'</h3>
</div>
';

$count++;   

}

return $temp;
}






public function album_main(){

$temp="";   
$sql = "SELECT * FROM `gallery` WHERE `publish` = 1 order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){


$name = $val['album'];
$gallery_pk = $val['gallery_pk'];


$temp   .= '
<div class="gallery_img">';


$sqlo = "SELECT * FROM `gallery_images` WHERE `gallery_id` = ? order by sort asc";
$fdatao      =   $this->dbF->getRows($sqlo,array($gallery_pk));

$count = 1;
foreach($fdatao  as $valp){

$gallery_pk = $valp['gallery_id'];

$image    =  WEB_URL."/images/".$valp['image'];
$dis = "";
if($count == 1){
$dis = "";



}else{

$dis = "display:none";




}

$temp   .= '

<a href="'.$image.'" class="fancybox" style="'.$dis.'" rel="gallery'.$gallery_pk.'">
<img src="'.$image.'" alt="">
</a>';
$count ++;

}
$temp   .= '
<h3>'.$name.'</h3>
</div>
';
}






return $temp;
}




public function tabs11(){

$temp="";   
$sql = "SELECT * FROM `brandss` WHERE `publish` = 1 ORDER BY `sort` ASC";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['brand_shrtDesc']);
$brand_heading  = getTextFromSerializeArray($val['brand_heading']);

$temp   .= '
<div id="tabs-'.$id.'">
<h1 class="wow zoomIn">'.$brand_heading.'</h1>
<div class="tabs_txt">

'.$title.'


</div>';


   
$sql = "SELECT * FROM `brands` WHERE `type` = ? ORDER BY `sort` ASC";
$fdata      =   $this->dbF->getRows($sql,array($id));
foreach($fdata  as $val){


$id    =  $val['id'];
$publish    =  $val['publish'];
// $brand_link    =  $val['brand_link'];
$image    =  WEB_URL."/images/".$val['image'];

$posi = "";
if($publish == 1){
$posi = "rgt";


}else{

$posi = "lft";

}


$brand_heading  = getTextFromSerializeArray($val['brand_heading']);
$brand_shrtDesc  = getTextFromSerializeArray($val['brand_headings']);


$temp   .= '
<div class="tabs_img">
<a href="detail-'.$id.'">
<img src="'.$image.'" alt="">
<div class="brand_title '.$posi.'">
<h1>'.$brand_heading.'</h1>
<h2>'.$brand_shrtDesc.'</h2>
</div>
</a>
</div>
';
}










$temp   .= '
</div>
';
}

return $temp;
}





public function reporttabsdetail(){

$temp="";   
// $sql = "SELECT * FROM `financial_reports` WHERE `publish` = 1 ORDER BY `sort` ASC";
$sql = "SELECT * FROM `categories` WHERE `under` = 0 and `type`='add' order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$ids    =  $val['id'];
$title  = getTextFromSerializeArray($val['name']);
$temp   .= '




<div id="tabs-'.$ids.'">';

$sql = "SELECT * FROM `categories` WHERE `under` = ? order by sort asc";
$fdata      =   $this->dbF->getRows($sql,array($ids));

if($this->dbF->rowCount>0){

foreach($fdata  as $val){
$idq    =  $val['id'];
$title  = getTextFromSerializeArray($val['name']);

$temp   .= '

<div class="investor_main">
<h1>'.$title.'</h1>
<div class="investor_inner">';


 $sql = "SELECT * FROM `financial_reports` WHERE `publish` = 1 and `testimonial_email` = ? ORDER BY `sort` ASC";

$fdata      =   $this->dbF->getRows($sql,array($idq));
if($this->dbF->rowCount>0){

foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['testimonial_heading']);
    $image    = $this->functions->addWebUrlInLink(translateFromSerialize($val['testimonial_image']));

$temp   .= '
<div class="investor_box">
<a href="'.$image.'">
<img src="webImages/pdf-icon.png" alt="">
<span class="dwn">'.$title.'</span>
</a>
</div>';

}
}

$temp   .= '
</div>
</div>';

}}else{

$temp   .= '
<div class="investor_main">
<h1>'.$title.'</h1>
';

 $sqlaaa = "SELECT * FROM `financial_reports` WHERE `publish` = 1 and `testimonial_position` = ? ORDER BY `sort` ASC";

$fdataddddd      =   $this->dbF->getRows($sqlaaa,array($ids));
if($this->dbF->rowCount>0){
    $temp   .= '<div class="investor_inner">';
foreach($fdataddddd  as $valiiiii){

    $image    = $this->functions->addWebUrlInLink(translateFromSerialize($valiiiii['testimonial_image']));
$testimonial_heading  = getTextFromSerializeArray($valiiiii['testimonial_heading']);



$temp   .= '
<div class="investor_box">
<a href="'.$image.'">
<img src="webImages/pdf-icon.png" alt="">
<span class="dwn">
'.$testimonial_heading.'
</span>
</a></div>
';
}
    $temp   .= '</div>';

// var_dump($title);
}elseif($title == "Free-Float of Shares"){

$box = $this->getBox('box19');

$temp   .= '<strong>'.$box['heading'].'</strong>
<div class="main_table">
<span>'.$box['heading2'].' </span>


'.$box['text'].'



</div>';




}


$temp   .= '


</div>



';


}

$temp   .= '
</div>';
}

return $temp;
}






public function tabs1(){

$temp="";   
$sql = "SELECT * FROM `tabs` WHERE `publish` = 1 ORDER BY `sort` ASC";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['tabs_shrtDesc']);
$temp   .= '
<div id="tabs-'.$id.'">
'.$title.'
</div>
';
}

return $temp;
}



public function reportstabss(){

$temp="<ul>";   
$sql = "SELECT * FROM `categories` WHERE `under` = 0 and `type`='add' order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['name']);

$temp   .= '<li><a href="#tabs-'.$id.'">'.$title.'</a></li>';
}
$temp .= "</ul>";
return $temp;
}




public function tabss(){

$temp="<ul class='owl1'>";   
$sql = "SELECT * FROM `tabsnew` WHERE `publish` = 1";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['heading']);

$temp   .= '<li><a href="#tabs-'.$id.'">'.$title.'</a></li>';
}
$temp .= "</ul>";
return $temp;
}

public function tabs(){

$temp="<ul>";   
$sql = "SELECT * FROM `tabs` WHERE `publish` = 1 ORDER BY `sort` ASC";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['tabs_heading']);
$image = WEB_URL."/images/".$val['image'];
$temp   .= '<li><a href="#tabs-'.$id.'"><img src="'.$image.'" alt="">
'.$title.'</a></li>';
}
$temp .= "</ul>";
return $temp;
}






public function commety(){

$temp="";   
$sql = "SELECT * FROM `board_of_directors` WHERE `publish` = 1 order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
 $image    = $this->functions->addWebUrlInLink(translateFromSerialize($val['testimonial_image']));

$title  = getTextFromSerializeArray($val['testimonial_heading']);
$desig  = getTextFromSerializeArray($val['testimonial_position']);
$dsc  = getTextFromSerializeArray(($val['testimonial_shrtDesc']));

$temp   .= '<div class="board_main">
<img src="'.$image.'" alt="">
<div class="board_detail">
<h2>'.$title.'</h2>
<h6>'.$desig.'</h6>
<div class="board_txt">

'.$dsc.'

</div>
</div>
</div>



';
}

return $temp;
}


public function bod(){

$temp="";   
$sql = "SELECT * FROM `messages` WHERE `publish` = 1 ";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$image = WEB_URL."/images/".$val['image'];

$title  = getTextFromSerializeArray($val['heading']);
$desig  = getTextFromSerializeArray($val['shortDesc']);
$dsc  = getTextFromSerializeArray(base64_decode($val['dsc']));

$temp   .= '<div class="board_main">
<img src="'.$image.'" alt="">
<div class="board_detail">
<h2>'.$title.'</h2>
<h6>'.$desig.'</h6>
<div class="board_txt">

'.$dsc.'

</div>
</div>
</div>



';
}

return $temp;
}



public function tabss111(){

$temp="<ul class=''>";   
$sql = "SELECT * FROM `brandss` WHERE `publish` = 1 order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$title  = getTextFromSerializeArray($val['brand_heading']);

$temp   .= '<li><a href="#tabs-'.$id.'">'.$title.'</a></li>';
}
$temp .= "</ul>";
return $temp;
}



public function testimonials(){

$temp="";   
$sql = "SELECT * FROM `testimonial` WHERE `publish` = 1 order by sort asc";
$fdata      =   $this->dbF->getRows($sql);
foreach($fdata  as $val){
$id    =  $val['id'];
$name  = getTextFromSerializeArray($val['testimonial_heading']);
$testimonial_shrtDesc  = getTextFromSerializeArray($val['testimonial_shrtDesc']);
$imageRq     = $this->addWebUrlInLink(getTextFromSerializeArray($val['testimonial_image']));

$testimonial_position  = getTextFromSerializeArray($val['testimonial_position']);




$temp   .= '
<div class="testimonials_inner">
<div class="testimonials_txt">
'.$testimonial_shrtDesc.'
</div>
<div class="testimonials_img">
<img src="'.$imageRq.'" alt="">
<span>'.$name.'</span>
<h4>'.$testimonial_position.'</h4>
</div>
</div>


';
}
return $temp;
}





public function bc(){
global $_e;
$today  = date('Y-m-d');
$sql    = "SELECT * FROM client WHERE publish = '1' ORDER BY `sort` ASC ";
$data   =  $this->dbF->getRows($sql);

$temp = '';
$c  = 0;
foreach($data as $key=>$val){
// $date       = date('M d, Y',strtotime($val['date']));
$heading    = translateFromSerialize($val['client_title']);
// $tabs_headings    = translateFromSerialize($val['tabs_headings']);
// $shortDesc  = translateFromSerialize($val['tabs_shrtDesc']);
$dsc        = translateFromSerialize($val['client_shrtDesc']);
// $imageR     = ($val['image']);

// $link       =  $val['tabs_link'];

// $imageRq     = $this->addWebUrlInLink(getTextFromSerializeArray($val['image']));
$image = WEB_URL."/images/".$val['image'];


// var_dump($c);







if ($c % 2 == 0) {
 $temp .= '



<div class="services_main">
<div class="services_inner"> <img class="lazy" data-src="'.$image.'" alt=""> </div>
<div class="services_inner rg">
<h1>'.$heading.'</h1>
<div class="services_inner_txt"> '.$dsc.'</div>
</div>
</div>


';
}else{

  
$temp .= '


<!-- services_main -->
<div class="services_main">
<div class="services_inner lf">
<h1>'.$heading.'</h1>
<div class="services_inner_txt"> '.$dsc.' </div>
</div>
<div class="services_inner"> <img class="lazy" data-src="'.$image.'" alt=""> </div>
</div>
<!-- services_main -->

';
  
}




$c++;






}

// $temp .= '';
return $temp;
}


public function ta(){
global $_e;
$today  = date('Y-m-d');
$sql2    = "SELECT DISTINCT category FROM service WHERE publish = '1' AND category!='' ORDER BY `sort` ASC";
$data   =  $this->dbF->getRows($sql2);
// var_dump($data);
$temp = '';
$c  = 0;

// $temp='';

foreach($data as $key=>$val){

    $category    = unserialize($val['category']);
    
    $temp .= '
    
<div class="main">
    
    <div class="divider2" style="padding: 100px 0px 0px;">

        <div class="standard">
        
            <h1>'.$category.'</h1>
            
        </div>
    </div>

    <div class="extra">
';



        $category = serialize($category);

        $sql2    = "SELECT * FROM service WHERE publish = '1' AND category=? ORDER BY `sort` ASC ";
        $data2   =  $this->dbF->getRows($sql2,array($category));


        foreach($data2 as $key=>$val){
    
            $heading    = translateFromSerialize($val['service_heading']);
            $link       =  $val['service_link'];
            $imageRq     = $this->addWebUrlInLink(getTextFromSerializeArray($val['service_image']));    


            $temp .= '

            <div class="services_inner services_inner2"> 
            
                <a href="course-'.$link.'"> <img class="lazy" data-src="'.$imageRq.'" alt="">


                <div class="services_inner rg">
                    <h1>'.$heading.' </h1>
                    
                    <div class="services_inner_txt"> 

                    </div>
                </div>

                </a>
            </div>';
            
        
    

    } //second foreach


$temp.='

</div>

</div>'; //main div

// }

// if ($c == '1') { 
//   $box11 = $this->getBox('box11');
// $temp .= '
// <div class="divider2" style="background-image: url('.$box11['image'].'); display:none;">
// <div class="standard">
// <h1>'.$box11['text'].'</h1> </div>
// </div>';


// }




$c++;

} // first foreach


return $temp;
}

public function bookingHTML(){
    $token = $this->setFormToken('bookForm',false);
    if(substr_count($_SERVER['REQUEST_URI'],"black-friday-deal",0 ) > 0){$deal='<input type="hidden" name="form[deal]" value="Black Friday 2022 Deal Form">';}
    else{$deal='';}
    $form = '<div class="bounus">
            <div class="standard">
                <h1>Bonus</h1>
                <img class="bounus-img" src="webImages/bounus-img.svg" alt="">
                <a href="#" class="demo-btn"><span>Start a free Trial</span></a>
                <div class="download-sec">
                    <div class="download-icon"><img src="webImages2/download__.svg" alt=""></div>
                    <div class="download-tex">
                        <h2>Download our FREE Black Friday Mock CQC Inspection Audit 2022 !</h2>
                        <a href="#" class="demo-btn">Download</a>
                    </div>
                </div>

                <div class="SndSecInnerdiv LunchsecondSec ">
                    <h1>Download Mock CQC Inspection Audit 2022 !</h1>
                    <p>We’ve been working hard to compile an end of year cqc mock inspection for Dental Practices. Enter your email address below and we’ll send you the FREE CQC Mock Inspection Audit.</p>
                    <h5>Personal Information</h5>
                    <form action="" method="post">
                        <div class="flexdiv">
                            <input type="hidden" name="form[zoomLink]" class="zoomLink" value="">
                            <input type="text" placeholder="Full Name*">
                            <input type="text" name="" id="" placeholder="Practice Name*">
                        </div>
                        <div class="flexdiv">
                            <input type="text" placeholder="Contact Number*">
                            <input type="text" name="" id="" placeholder="Email Address*">
                        </div>
                        <div class="flexdiv">
                            <button class="btn book">Submit Information</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="standard">
            <div class="more-about more-aout-black">
                <div class="right">
                    <h2>Want to know more about AIOM
                    </h2>
                    <p>Ask about AIOM plans, prices, features or anything else.</p>
                    <a href="">Talk to Sales</a>
                    <a href="">Book a Demo</a>
                </div>
            </div>
        </div>';
    return $form;
}

public function services(){
global $_e;
$sql    = "SELECT * FROM tabs WHERE publish = '1' ORDER BY `sort` ASC ";
$data   =  $this->dbF->getRows($sql);

$temp = '';
foreach($data as $key=>$val){
$id = $val['id'];
$heading        = translateFromSerialize($val['tabs_heading']);
$tabs_headings  = translateFromSerialize($val['tabs_headings']);
$dsc            = translateFromSerialize($val['dsc']);
$tabs_shrtDesc  = translateFromSerialize($val['tabs_shrtDesc']);
$link           = $val['tabs_link'];
$image          = WEB_URL."/images/".($val['image']);

if ($key % 2 == 0) {
if(!empty($tabs_shrtDesc)){
 $temp .= '
<style>
.inner_content .box'.$id.' .col3_right:before  {
    background-image: url('.$image.');
}
</style>
<div class="col3 box'.$id.'">
    <div class="col3_box">
        <div class="standard">
            <h3>'.$heading.'</h3>
            <div class="col3_left_txt">
                '.$tabs_shrtDesc.'
            </div>
            <!-- col3_left_txt close -->
        </div>
        <div class="standard">
            <div class="col3_box_inner">
                <div class="col3_left wow fadeInLeft">
                    '.$dsc.'
                    <div class="col1_btn">
                        <a href="'.$link.'">'.$tabs_headings.'</a>
                    </div>
                    <!-- col1_btn close -->
                </div>
                <!-- col3_left close -->
            </div>
            <!-- col3_box_inner close -->
            <div class="col3_right wow fadeInRight">
                <img src="'.$image.'" alt="">
            </div>
            <!-- col3_right close -->  
        </div>
        <!-- standard close -->        
    </div>
    <!-- col3_box close -->
</div>
<!-- col3 close -->';
}
else{
     $temp .= '
<style>
.inner_content .box'.$id.' .col3_right:before  {
    background-image: url('.$image.');
}
</style>
<div class="col3 box'.$id.'">
    <div class="col3_box">
        <div class="standard">
            <h3>'.$heading.'</h3>
            <div class="col3_box_inner">
                <div class="col3_left wow fadeInLeft">
                    '.$dsc.'
                    <div class="col1_btn">
                        <a href="'.$link.'">'.$tabs_headings.'</a>
                    </div>
                    <!-- col1_btn close -->
                </div>
                <!-- col3_left close -->
            </div>
            <!-- col3_box_inner close -->
            </div>
            <!-- standard close --> 
            <div class="col3_right wow fadeInRight">
                <img src="'.$image.'" alt="">
            </div>
            <!-- col3_right close -->         
    </div>
    <!-- col3_box close -->
</div>
<!-- col3 close -->';
}
}else{
if(!empty($tabs_shrtDesc)){
  $temp .= '
<style>
.inner_content .box'.$id.' .col3_right:before  {
    background-image: url('.$image.');
}
</style>
<div class="col3 box'.$id.'">
    <div class="col3_box">
        <div class="standard">
            <h3>'.$heading.'</h3>
            <div class="col3_left_txt">
                '.$tabs_shrtDesc.'
            </div>
            <!-- col3_left_txt close -->
        </div>
        <div class="standard">
            <div class="col3_box_inner">
                <div class="col3_left wow fadeInLeft">
                    '.$dsc.'
                    <div class="col1_btn">
                        <a href="'.$link.'">'.$tabs_headings.'</a>
                    </div>
                    <!-- col1_btn close -->
                </div>
                <!-- col3_left close -->
            </div>
            <!-- col3_box_inner close -->
            <div class="col3_right wow fadeInRight">
                <img src="'.$image.'" alt="">
            </div>
            <!-- col3_right close -->  
        </div>
        <!-- standard close -->        
    </div>
    <!-- col3_box close -->
</div>
<!-- col3 close -->';   
} else{  
$temp .= '
<style>
.inner_content .box'.$id.' .col2_left:before {
    background-image: url('.$image.');
}
</style>
<div class="col2 box'.$id.'">
    <div class="col2_left wow fadeInLeft">
        <img src="'.$image.'" alt="">
    </div>
    <!-- col2_left close -->
    <div class="col2_box wow fadeInRight">
        <div class="standard">
            <div class="col2_right">
                <h3>'.$heading.'</h3>
                '.$dsc.'
                <div class="col1_btn">
                    <a href="'.$link.'">'.$tabs_headings.'</a>
                </div>
                <!-- col1_btn close -->
            </div>
            <!-- col2_right close -->
        </div>
        <!-- standard close -->
    </div>
    <!-- col2_box close -->
</div>
<!-- col2 close -->';
}
}
}
return $temp;
}



public function newstabs(){
global $_e;
$today  = date('Y-m-d');
$sql    = "SELECT * FROM tabs WHERE publish = '1' ORDER BY `sort` ASC ";
$data   =  $this->dbF->getRows($sql);

$temp = '';
foreach($data as $key=>$val){
// $date       = date('M d, Y',strtotime($val['date']));
$heading    = translateFromSerialize($val['tabs_heading']);
$tabs_headings    = translateFromSerialize($val['tabs_headings']);
// $shortDesc  = translateFromSerialize($val['tabs_shrtDesc']);
// $dsc        = translateFromSerialize($val['dsc']);
// $imageR     = ($val['image']);

$link       =  $val['tabs_link'];

$imageRq     = WEB_URL."/images/".($val['image2']);



$temp .= '




<div class="owl2_inner">
<div class="col2_img"> <img src="'.$imageRq.'" alt=""> </div>
<div class="owl2_txt">
<h2>'.$heading.'</h2> <a href="'.$link.'">'.$tabs_headings.'</a> </div>
</div>




';










}

// $temp .= '';
return $temp;
}
public function appraisalDetailArray($data,$settingName){
foreach($data as $val){
if($val['question_name']==$settingName){
return $val['question_val'];
}
}
return "";
}

 /* customize by waqar hussain 3/2/2021 */    
    public function getTestiMonial(){

        $html_data['video'] = array();
        $html_data['image'] = array();
        
        $video  = "";
        $images = "";

       

        $sql   =   "SELECT * FROM testimonial WHERE testimonial_category='Video' AND publish =  '1' ";
        $data      =   $this->dbF->getRows($sql);

        $testimonial = "";
        
        if($this->dbF->rowCount>0) {
            $i      =   0;
            $data2  = $data; //for save $data array
            foreach ($data2 as $val) {
                if(isset($val['id'])) {
                    $id = getTextFromSerializeArray($val['id']); 
                }
                if(isset($val['video_link'])) {
                    $video_link = getTextFromSerializeArray($val['video_link']); 
                }
                if(isset($val['testimonial_heading'])) {
                    $title = getTextFromSerializeArray($val['testimonial_heading']); 
                }
                if(isset($val['testimonial_shrtDesc'])) {
                    $desc = getTextFromSerializeArray($val['testimonial_shrtDesc']);
                }
                if(isset($val['testimonial_image'])) {
                    $temp = getTextFromSerializeArray($val['testimonial_image']);
                    $image = $this->addWebUrlInLink($temp);
                }
                if(isset($val['testimonial_position'])) {
                    $temp   = getTextFromSerializeArray($val['testimonial_position']);
                    $position  = $this->addWebUrlInLink($temp);
                }
                if(isset($val['testimonial_email'])) {
                    $email = getTextFromSerializeArray($val['testimonial_email']);
                }
                if(isset($val['testimonial_date'])) {
                    $date = getTextFromSerializeArray($val['testimonial_date']);
                }
                //LINK
                if(isset($val['banner_link'])) {
                $lang = currentWebLanguage();
                $datas = @unserialize($val['banner_link']);
                    if ($datas !== false) {
                    @$link = unserialize($val['banner_link']); 

                    $link = $this->functions->addWebUrlInLink($link[$lang]);
          
                    } else {
                     
                    }
                }

           if(!empty($val['video_link'])){
                $video .='<div class="item" data-hash="v'.$id.'">
                        <div class="flex-video"><iframe src="https://www.youtube.com/embed/'.$video_link.'?enablejsapi=1&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation"></iframe>
                            <!-- Make sure to enable the API by appending the "&enablejsapi=1" parameter onto th eURL. -->
                        </div>
                    </div>';
                }else{


 $video .='<div class="item" data-hash="v'.$id.'">
                        <div class="flex-video">

'.$title.'<br>
'.$position.'<br>
'.$desc.'



                         </div>
                    </div>';

                }
                
                $images .='<li>
                            <a href="#v'.$id.'">
                                <img src="'.$image.'" alt="'.$image.'">
                            </a>
                        </li>';                    
                $i++;
            
            } //end of foreach

            $html_data['video'] = $video;
            $html_data['image'] = $images;

        } // end of row count

       return $html_data;
   
    } //function end

}//class End


?>