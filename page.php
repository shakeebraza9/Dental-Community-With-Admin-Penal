<?php include("global.php");

require_once(__DIR__ . '/_models/functions/webBlog_functions.php');
global $webClass,$productClass,$functions;

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$blogC = new webBlog_functions();

// if(count($uri_segments) == 4){
//     $bID = $uri_segments[3];
//     $latestBlogDetail = $blogC->getBlogDetail($bID);
//     $shortDesc =  $functions->unserializeTranslate($latestBlogDetail['shortDesc']);
//     //echo "This is description : " . $shortDesc; 
//     //print_r($latestBlogDetail);
//     //exit;
// }

htmlspecialchars($_GET['page']);
if(!isset($_GET['page']) || $_GET['page']==''){
header("HTTP/1.0 404 Not Found");
}
$faq = false;
$servicesPage = false;
$conPage = false;
$contactPage = false;

$careerPage = false;
$gallPage = false;
$feedPage = false;
$inqPage = false;
$brands = false;
$award = false;
$bod = false;
$booking = false;
$inqueryForm = false;
$bookingPage = false;
$packagePage = false;
$servicePage = false;
// var_dump($seo);
$newspage = false;
$pg         = sanitize_slug($_GET['page']);
$page       = $webClass->getPage("$pg");


$pg_id      = $page['id'];
$setting_field  = $functions->setting_fieldsGet($pg_id,'pages');
$loginReq       = $functions->setting_fieldsArray($setting_field,'loginReq');
// $icons          = $functions->setting_fieldsArray($setting_field,'icon');

$bannerImg = $page['image'];
$shrtDesc  = $page['short_desc'];
$heading  = $page['heading'];
$subHeading  = $page['heading2'];
$box19 = $webClass->getBox("box19"); 
$bannerImg   = ( $page['imagess'] ==  WEB_URL . '/images/' || $page['imagess'] === NULL ) ?  $box19['image'] : $page['imagess'];



if ($page['slug'] == "blog") {
	
		if(count($uri_segments) == 4){
	    $bID = $uri_segments[3];
	    $latestBlogDetail = $blogC->getBlogDetail($bID);
	    $shrtDesc =  $functions->unserializeTranslate($latestBlogDetail['shortDesc']);
	    $subHeading = "";
	}
}else if($page['slug'] == "webinar"){
	if(count($uri_segments) == 4){
	    $bID = $uri_segments[3];
	    $data_    = array();
    	$sql_     = "SELECT * from webinar where id='$bID'";
    	$data_    = $dbF->getRow($sql_);

    	$shrtDesc =  $functions->unserializeTranslate($data_['heading']); 
    	//$desc_ = translatefromserialize($data_['dsc']);
    	$date_    = date('d-M-Y', strtotime($data_['date']));
		$subHeading = "";
 
	}
}
 

if( $loginReq == '1' ){
if(!userLoginCheck()){
header('Location: '.WEB_URL.'/login');
}
}

//Redirect If link
$redirectLink = $page['link'];
if($redirectLink!=''){
header("Location: $redirectLink");
exit;
}

global $seo;
if($seo['title']==''  || $seo['reWriteTitle']=='0'){
$seo['title'] = $page['heading'];
}

if($seo['description']=='' || $seo['default'] == '1' ){
$seo['description'] = substr(trim(strip_tags($page['desc'])),0,500); //500 for facebook share
}

$desc1 =  ($page['desc']);
$desc11 =  ($page['desc']);
if(stristr($desc1,'{{contact}}')){
$contactForms = include_once(__DIR__.'/contact.php');
$desc1       = str_replace('{{contact}}',$contactForms,$desc11);
$contactPage = true;
}

if(stristr($desc1,'{{services}}')){
$services = include_once(__DIR__.'/services.php');
$desc1       = str_replace('{{services}}',$services,$desc11);
$servicePage = true;
}


if(stristr($desc1,'{{bookingForm}}')){
$bookingForm = include_once(__DIR__.'/bookingForm.php');
$desc1       = str_replace('{{bookingForm}}',$bookingForm,$desc1);
$bookingPage = true;
}



$surveyFormPage = false;
if(stristr($desc11,'{{surveyForm}}')){
$surveyForm = include_once(__DIR__.'/surveyForm.php');
$desc1       = str_replace('{{surveyForm}}',$surveyForm,$desc11);
$surveyFormPage = true;
}


$freeResources = false;
if(stristr($desc11,'{{freeResourses}}')){
$temp = include_once(__DIR__.'/freeResourses.php');
$desc1       = str_replace('{{freeResourses}}',$temp,$desc11);
$freeResources = true;
}

$generalFormPage = false;
if(stristr($desc11,'{{generalForm}}')){
$generalForms = include_once(__DIR__.'/generalForm.php');
$desc1       = str_replace('{{generalForm}}',$generalForms,$desc11);
$generalFormPage = true;
}

if(stristr($desc11,'{{onboard}}')){
$onboardForms = include_once(__DIR__.'/onboarding.php');
$desc1       = str_replace('{{onboard}}',$onboardForms,$desc11);
$conPage = true;
}

if(stristr($desc11,'{{inqueryForm}}')){
$inqueryForm = include_once(__DIR__.'/inqueryForm.php');
$desc1       = str_replace('{{inqueryForm}}',$inqueryForm,$desc11);
$inqueryForm = true;
}

if(stristr($desc11,'{{Pricing}}')){
$Pricing = include_once(__DIR__.'/Pricing.php');
$desc1       = str_replace('{{Pricing}}',$Pricing,$desc11);
$Pricing = true;
}

if(stristr($desc11,'{{courses}}')){
$cp = include_once(__DIR__.'/sd-courses.php');
$desc1       = str_replace('{{courses}}',$cp,$desc11);
$feedPage = true;
}
if(stristr($desc11,'{{lunchandlearn}}')){
$webClass->bookingFormSubmit();	
$lunchandlearn = include_once(__DIR__.'/lunchandlearn.php');
$desc1       = str_replace('{{lunchandlearn}}',$lunchandlearn,$desc11);
$lunchandlearn = true;
}


if(stristr($desc11,'{{booking}}')){
$webClass->bookingFormSubmit();	
$cp = $webClass->bookingHTML();
$desc1       = str_replace('{{booking}}',$cp,$desc11);
$feedPage = true;
}

if(stristr($desc1,'{{services}}')){
$service = include_once(__DIR__.'/service.php');
$desc1       = str_replace('{{services}}',$service,$desc1);
$servicesPage = true;
}

$academy = false;

if(stristr($desc1,'{{Training_Academy}}')){
$academy = include_once(__DIR__.'/ta.php');
$desc1       = str_replace('{{Training_Academy}}',$academy,$desc1);
$academy = true;
}

$testimonial = false;

if(stristr($desc1,'{{Testimonial}}')){
$testimonial = include_once(__DIR__.'/test.php');
$desc1       = str_replace('{{Testimonial}}',$testimonial,$desc1);
$testimonial = true;
}
$Business = false;
if(stristr($desc1,'{{shop}}')){
$Business = include_once(__DIR__.'/shop.php');
$desc1       = str_replace('{{shop}}',$Business,$desc1);
$Business = true;
}

if(stristr($desc1,'{{blog}}')){
$Business = include_once(__DIR__.'/blog.php');
$desc1       = str_replace('{{blog}}',$Business,$desc1);
$Business = true;
}

if(stristr($desc1,'{{webinar}}')){
$Business = include_once(__DIR__.'/webinar.php');
$desc1    = str_replace('{{webinar}}',$Business,$desc1);
$Business = true;
}

if(stristr($desc1,'{{reviews}}')){
$Business = include_once(__DIR__.'/reviews.php');
$desc1    = str_replace('{{reviews}}',$Business,$desc1);
$Business = true;
}

if(stristr($desc1,'{{feature_form}}')){
$Business = include_once(__DIR__.'/feature_form.php');
$desc1    = str_replace('{{feature_form}}',$Business,$desc1);
$Business = true;
}
if(stristr($desc11,'{{faq}}')){
$faq = include_once(__DIR__.'/faqData.php');
$desc1       = str_replace('{{faq}}',$faq,$desc11);
$faq = true;
}
$squatPractice = false;
if(stristr($desc11,'{{squatPractice}}')){
$temp = include_once(__DIR__.'/squat-practice.php');
$desc1       = str_replace('{{squatPractice}}',$temp,$desc11);
$squatPractice = true;
}


if(stristr($desc1,'{{Books}}')){
$Books = include_once(__DIR__.'/books.php');
$desc1       = str_replace('{{Books}}',$Books,$desc1);
$Books = true;
}

if(stristr($desc1,'{{packages}}')){
$pack = include_once(__DIR__.'/packages.php');
$desc1       = str_replace('{{packages}}',$pack ,$desc1);
$packagePage = true;
}

include("webHeader.php");
?>
<!--  inner Banner --> 
<div class="inner_page_banner" style="background-image: url(<?= $bannerImg ?>)">
     <h1><?= $heading ?></h1>
</div>

 <!-- Page Heading -->
    <div class="Standard">
        <div class="dental-title-wrapper aos-init aos-animate" data-aos="fade-down" data-aos-duration="1500">
            <div class="inner-title">
                <h3><?= $heading ?>
                    <span><img src="<?= WEB_URL?>/webImages/lineheading.png" alt=""></span>
                </h3>
            </div>
        </div>
    </div>
  <!-- Page Heading -->

<?php if($contactPage) { ?>

   <div class="practice-main">
        <div class="Standard">
            <div class="practice-flex">
                <?= $desc1 ?>
            </div>
        </div>
    </div>
<?php }else if($servicePage){ ?>
    <?= $desc1 ?>

<?php }else if($bookingPage){ ?>
    <div class="Standard">
         <?= $desc1 ?>
    </div>

<?php }else if($packagePage){ ?>
    <div class="Standard">
         <?= $desc1 ?>
    </div>
<?php } else { ?>

  <section class="main_text wow flipInX">
        <div class="Standard">
            <div class="main_text_inner pt0">
            	<?= $desc1 ?>
            </div>
        </div>
   </section>

<?php } ?>
<?php include("webFooter.php"); ?>