<?php   
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.lordicon.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.youtube-nocookie.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' data: *.tawk.to *.gstatic.com *.fonts.googleapis.com;");
header("X-Content-Security-Policy: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.lordicon.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.youtube-nocookie.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' data: *.tawk.to *.gstatic.com *.fonts.googleapis.com;");
header("X-WebKit-CSP: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.google.com *.lordicon.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.live.com *.youtube-nocookie.com *.gocardless.com *.facebook.com; font-src 'self' data: *.tawk.to *.gstatic.com *.fonts.googleapis.com;");

  if (isset($_GET['id'])) {
    $mainId =  base64_decode($_GET['id']);
       $mainId;
     // echo "<br>";
    @$explode =  explode("::",$mainId);
    @$hash = hash("md5", $functions->encode("id=".$explode[0]."&from=".$explode[1]."&to=".$explode[2]));
    // echo "<br>";
    @$id = base64_decode($explode[0]);
    // echo "<br>";
    @$from = base64_decode($explode[1]);
    // echo "<br>";
    @$to = base64_decode($explode[2]);
    // echo "<br>";
    @$hash2 = $explode[3];
    // echo "<br>";
     //echo base64_decode($_GET['from']);

   $datac =  $dbF->getRow("SELECT COUNT(`coupon_id`) FROM `coupon_useage_record` WHERE `coupon_id` = ?",array($id));
   $datap =  $dbF->getRow("SELECT * FROM `product_coupon_spb` WHERE `pCoupon_pk` = ?",array($id));

$todayDate = date("Y-m-d");
  if ($datap['pCoupon_limit'] <= $datac[0] && $datap['pCoupon_to'] <= $todayDate ) {
  // echo $datac[0];
  // echo $datap[0];     
 unset($_SESSION['webUser']['coupon_id']);
 unset($_SESSION['webUser']['coupon_from']);
 unset($_SESSION['webUser']['coupon_to']);
 unset($_SESSION['webUser']['coupon_hash']);
 unset($_SESSION['webUser']['coupon_hash2']);
 
 $hash = '';
 $hash2 = '';
 $from = '';
 $to = '';
  }else{
    if ($hash2 == $hash){
     // echo "<br>";
     // echo $id;
     // echo "<br>";
     // echo $from;
     // echo "<br>";
     // echo $to;
     // echo "<br>";
     // echo $hash;
     // echo "<br>";
     // echo $hash2;
    $productClass->getCoupon_hash($id,$from,$to,$hash,$hash2);
      
     echo "<script>
       alert('Congratulations! You have qualified for promotional offer...');
       location.replace('".WEB_URL."/page-shop'); 

      </script>";
       exit();
       }

     }
}

    
$chk = $webClass->bookingFormSubmit();
$webClass->popupFormSubmit();
        ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $seo['image']="https://smartdentalcompliance.com/webImages/logo-1240x600.png?magic=01";
        $webClass->AllSeoPrint();
    ?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?php echo WEB_URL ?>/webImages/favicon.ico?magic=AIOM<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL ?>/webImages/favicon.ico?magic=AIOM<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/all.min.css?magic=AIOM<?php echo filemtime('./css/web_css/all.min.css')?>"/>
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/owl.carousel.min.css?magic=AIOM<?php echo filemtime('./css/web_css/owl.carousel.min.css')?>"/>
    <link rel="icon" href="<?php echo WEB_URL ?>/webImages2/favicon.ico?magic=AIOM<?php echo filemtime('./webImages2/favicon.ico')?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL ?>/webImages2/favicon.ico?magic=AIOM<?php echo filemtime('./webImages2/favicon.ico')?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/jquery-ui.css?magic=AIOM<?php echo filemtime('./css/jquery-ui.css')?>">
    <!--<link href="http://fonts.googleapis.com/css2?family=Kumbh+Sans&family=Poppins:wght@200;300;400&family=Ubuntu:wght@700;500&display=swap" rel="stylesheet">-->
    <!-- swiper slider -->
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/swiper-bundle.css?magic=AIOM<?php echo filemtime('./css/web_css/swiper-bundle.css')?>" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/aos.css?magic=AIOM<?php echo filemtime('./css/web_css/aos.css')?>" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/fancybox.css?magic=AIOM<?php echo filemtime('./css/web_css/fancybox.css')?>" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/normalize.css?magic=AIOM<?php echo filemtime('./css/web_css/normalize.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/web_css/animation.css?magic=AIOM<?php echo filemtime('/css/web_css/animation.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/web_css/hover.css?magic=AIOM<?php echo filemtime('./css/web_css/hover.css')?>" />
    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/web_css/style.css?magic=<?php echo filemtime('./css/web_css/style.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/web_css/mmenu.css?magic=AIOM<?php echo filemtime('./css/web_css/mmenu.css')?>" />
    <script src="https://www.google.com/recaptcha/api.js?render=6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc"></script>
    <script src="<?php echo WEB_URL ?>/js/web_js/jquery.min.js?magic=AIOM<?php echo filemtime('./js/web_js/jquery.min.js')?>" ></script>

    <!--<title>AIOM</title>-->
    
    
    
    
            <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-K9KTKEHVWN"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
            
              gtag('config', 'G-K9KTKEHVWN');
            </script>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K8SPBFV');</script>
        <!-- End Google Tag Manager -->
        
        
        <!-- Meta Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '237638268323351');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=237638268323351&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->
        
        
        <!-- Meta Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '335579992065502');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=335579992065502&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->
</head>


<body>
<?php if($login){}else{ ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8SPBFV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php } ?>
    
<?php 
if($_GET['page']=='courses'){
  echo'<main class="inner-training">
    <div class="bg" style="background-image:url(webImages2/training-bg.png) ;">';
}elseif($_GET['page']=='packages'){
  echo'<main class="inner-package">
        <div class="bg" style="background-image:url(webImages2/inner-pack.png);">';
}elseif($_GET['page']=='shop'){
  echo'<main class="inner-shop">
        <div class="bg" style="background-image:url(webImages2/shop.png) ;">';
}elseif($_GET['page']=='contact'){
echo '    <main class="inner-contact">
        <div class="bg" style="background-image:url(webImages2/contact-bg.svg);">';
        
}
elseif( $_GET['page']=='reviews'){
echo '    <main class="">
        <div class="bg" style="background-image:url(webImages2/review-bg.webp);">';
        
}elseif($_GET['page']=='about' || $_GET['page']=='cookie-policy' || $_GET['page']=='complaints-policy' || $_GET['page']=='data-protection-policy'){
echo '<main class="our-team-inner">
        <div class="bg" style="background-color: #561d94;">';
}elseif($_GET['page']=='webinar'){
echo '    <main class="inner-webinar">
        <div class="bg" style="background-image:url(webImages2/webinar.png);">';
}elseif($_GET['page']=='free-resources'){
echo '<main class="inner-resourses">
        <div class="bg" style="background-image:url(webImages2/resoursec.webp);">';
}elseif($_GET['page']=='blog'){
echo ' <main class="inner-blog">
        <div class="bg" style="background-image:url(webImages2/blog.png);">';
}elseif($_GET['page']=='features'){
echo '  <main class="">
        <div class="bg" style="background-image: url(webImages2/inner-sqt.webp);">';
}elseif($_GET['page']=='lunchandlearn'){
echo '<main class="inner-lunch">
        <div class="bg" style="background-image:url(webImages2/lunch.png);">';
}elseif($_GET['page']=='feature-form' || $_GET['page']=='general-forms' || $_GET['page']=='book-training-session'){
echo ' <main class="inner-inquery">
        <div class="bg" style="background-image:url(webImages2/contact-bg.svg);">';
}
elseif($_GET['page']=='privacy-policy' || $_GET['page']=='demo'){
    echo' <main class="inner-privicy">
        <div class="bg" style="background-image:url(webImages2/privicy.svg);">';
}elseif($_GET['page']=='squat-practice'){
    echo'<main class="inner-squat">
        <div class="bg" style="background-image: url(webImages2/inner-sqt.webp);">';
}
elseif($_GET['page']=='dental-group'){
    echo'<main class="inner-dental">
        <div class="bg" style="background-image:url(webImages2/dental.png);">';
}elseif($_GET['page']=='black-friday-deal'){

    echo'<main class="inner-black-friday">
        <div class="bg" style="background-image: url(webImages2/bg-bkack-friday.webp);">';
}elseif( $_GET['page']=='smart-consult'){
    echo'<main class="inner-consult">
        <div class="bg" style="background-image:url(webImages2/consult.png);">';
}
elseif($_GET['page']=='compliance-training-day'){
    echo'<main class="inner-face">
        <div class="bg" style="background-image:url(webImages2/face.png);">';
}else{

  echo '<main class="index"><div class="bg-index">';

}
if($_GET['page']!=""){
                    $login  =  $webClass->userLoginCheck();
                    if(!$login){
                        echo '<a href="javascript:;" class="demoBookBtn demo-toggle">Book a Demo</a>';
                    }
                    else{
                   
                    }
}
?>
<div id="loader">
<img src="<?php echo WEB_URL?>/webImages2/logo.webp" alt="Smart Dental Compliance">
</div>
<div class="fix-side"></div>
  
            <div class="col101 col101_webinar ">

                <div class="close_popup hvr-pop">
                    <i class="fas fa-times"></i>
                </div>
                <div class="SndSecInnerdiv Webinar-form">
                    <h1>Webinar Registration</h1>
                    <p>Please fill out this form to register in the webinar.</p>
                    <h5>Personal Information</h5>
                    <form action="<?php echo WEB_URL?>/page-webinar" method="post">
                        <div class="flexdiv">
                           
                            <?php $functions->setFormToken('webinar'); ?>    
                            <input type="hidden" id="g-webinarForm" name="g-webinarForm">
                            <input type="hidden" name="action" value="webinarForm">
                            <input type="hidden" name="form[title]" class="webinarTitle">
                            <input type="hidden" name="form[id]" class="webinarId">
                            <input type="hidden" name="form[zoomLink]" class="zoomLink">
                            <input type="text" name="form[full name]" placeholder="Full Name*" required>
                            <input type="text" name="form[pracice name]" placeholder="Practice Name*">
                        </div>
                        <div class="flexdiv">
                            <input type="text" name="form[contact no]" placeholder="Contact Number*">
                            <input type="email" name="form[email]" placeholder="Email Address*">
                        </div>
                        <div class="flexdiv">
                            <button type="submit" name="submit" class="btn book">Submit Information</button>
                        </div>

                    </form>
                </div>

            </div>
    <div class="col101 col101_free_resource_registration">
        <div class="close_popup hvr-pop">
            <i class="fas fa-times"></i>
        </div>
        <h1>Registration</h1>
        <div class="col101_txt">
            Please fill out this form to download the document.
        </div>
        <h6>PERSONAL DETAILS</h6>
        <form action="<?php echo WEB_URL?>/page-free-resources" method="post" onsubmit="submitFreeResourceForm()">
            <?php $functions->setFormToken('free_resources'); ?>    
            
            <input type="hidden" id="resourceFormSubmit" value="0">
            <input type="hidden" id="g-freeResourceForm" name="g-freeResourceForm">
            <input type="hidden" name="action" value="freeResourceForm">
            <input type="hidden" name="form[title]" class="resourceTitle">
            <input type="hidden" name="form[id]" class="resourceLink">

            <div class="form_input">
                <input type="text" placeholder="Your Full Name" name="form[full name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Practice Name" name="form[pracice name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Contact No" name="form[contact no]" required>
            </div>
            <div class="form_input">
                <input type="email" placeholder="Email Address" name="form[email]" required>
            </div>
            
            <div class="col101_btn_main2">
                <div class="col1_btn">
                    <!-- <button type="submit" name="submit">
                        Submit Information
                    </button> -->
                    <button type="submit" name="submit">Submit</button>
                </div>
            </div>
        </form>
        <script>
            function submitFreeResourceForm(){
                
                document.getElementById('resourceFormSubmit').value = 1;
                $(".fix-side").removeClass("fix_side_");
                $(".col101_free_resource_registration").fadeOut();
            }
        </script>
    </div> 

      <?php if(@$_GET['page'] != 'booking') { ?>
    <div class="col101 col101_book">
        <div class="close_popup hvr-pop">
            <i class="fas fa-times"></i>
        </div>
        <h1>Request a DEMO</h1>
        <div class="col101_txt">
            See how we can help you Pass your next CQC inspection
        </div>
        <h6>COMPANY DETAILS</h6>
        <form method="post">
            <?php $functions->setFormToken('bookForm2'); ?>   
                           <input type="hidden" id="g-bookForm" name="g-bookForm">
    <input type="hidden" name="action" value="bookForm2">
            
            <div class="form_input">
                <input type="text" placeholder="Your Full Name" name="form[full name]" required>
            </div>
            <div class="form_input">
                <input type="text" placeholder="Practice Name" name="form[pracice name]" required>
            </div>
            <div class="form_input">
                <input class="datepicker" type="text" placeholder="When would you like to book the demo" name="form[date]" autocomplete="off">
            </div>
            <div class="form_input">
                <input type="text" placeholder="Contact No" name="form[contact no]" required>
            </div>
            <div class="form_input">
                <input type="email" placeholder="Email Address" name="form[email]" required>
            </div>
            
            <div class="form_input">
                <input placeholder="Time" class="timepicker" type="text" name="form[time]">
            </div>
            <h6>HOW DO YOU KNOW ABOUT US</h6>
            <div class="col101_btn_main">
                <div class="col1_btn">
                    <input id="t1" type="radio" name="form[how_know_about]" value="Google search">
                    <label for="t1">Google search</label>
                </div>
                <div class="col1_btn">
                    <input id="t2" type="radio" name="form[how_know_about]" value="Social Media (Facebook,Twitter,etc)">
                    <label for="t2">Social Media (Facebook,Twitter,etc)</label>
                </div>
                <div class="col1_btn">
                    <input id="t3" type="radio" name="form[how_know_about]" value="Email">
                    <label for="t3">Email</label>
                </div>
                <div class="col1_btn">
                    <input id="t4" type="radio" name="form[how_know_about]" value="Family/Friend">
                    <label for="t4">Family/Friend</label>
                </div>
                <div class="col1_btn">
                    <input id="t4s" type="radio" name="form[how_know_about]" value="Employer">
                    <label for="t4s">Employer</label>
                </div>
                <div class="col1_btn">
                    <input id="t5" type="radio" name="form[how_know_about]" value="Events">
                    <label for="t5">Events</label>
                </div>
                <div class="col1_btn">
                    <input id="t6" type="radio" name="form[how_know_about]" value="Leaflet">
                    <label for="t6">Leaflet</label>
                </div>
                <div class="col1_btn">
                    <input id="t7" type="radio" name="form[how_know_about]" value="Newspaper/Magazine">
                    <label for="t7">Newspaper/Magazine</label>
                </div>
                <div class="col1_btn">
                    <input id="t8" type="radio" name="form[how_know_about]" value="Facebook Groups">
                    <label for="t8">Facebook Groups</label>
                </div>
            </div>
            <div class="col101_btn_main2">
           <!--      <div class="form_input">
                    <div id="recaptcha1"></div>
                </div>
                <br> -->

                             <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="tokenBooking" name="token">
                                </div>


                <div class="col1_btn">
                    <button type="submit" name="submit">
                        Book your personalised practice demo
                    </button>
                </div>
            </div>
        </form>

    </div> <?php } ?>
      
            <header>
                <nav id="menu">
                    <ul>
                       <?php
                    $login  =  $webClass->userLoginCheck();
                    if(!$login){
                        echo "<li><a href='login'>Login</a></li>";
                    }
                    else{
                        echo "<li><a href='".WEB_URL."/main_dashboard'>Dashboard</a></li>";
                    }
                    ##### RESPONSIVE MAIN MENU
                    $css = false;
                    $mainMenu = $menuClass->menuTypeSingle('main_menu');
                    foreach ($mainMenu as $val) {
                    $insideActive = false;
                    $innerUl = '';
                    $menuId = $val['id'];
                    $text = ($val['name']);
                    $link = $val['link'];
                    $mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
                    if (!empty($mainMenu2)) {
                    $innerUl .= '<ul>';
                    foreach ($mainMenu2 as $val2) {
                    $innerUl3 = '';
                    $text = ($val2['name']);
                    $menuId = $val2['id'];
                    $link = $val2['link'];
                    $mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
                    # count the inner level 3 lis
                    $innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
                    $innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
                    if ( $innerUl3count > 0 ) {
                    foreach ($mainMenu3 as $val3) {
                    $innerUl4 = '';
                    $text3       = ($val3['name']);
                    $menuId3     = $val3['id'];
                    $link3       = $val3['link'];
                    $mainMenu4   = $menuClass->menuTypeSingle('main_menu', $menuId3);
                    # count the inner level 3 lis
                    $innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
                    $innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
                    if ( $innerUl4count > 0 ) {
                    foreach ($mainMenu4 as $val4) {
                    $text4       = ($val4['name']);
                    $link4       = $val4['link'];
                    $innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
                    }}
                    $innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
                    $innerUl3 .= '
                    <li><a href="' . $link3 . '">' . $text3 . '</a>
                    ' . $innerUl4 . '
                    </li>';
                    }
                    }
                    $innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
                    $innerUl .= '<li><a href="' . $link . '" target="_blank">' . $text . '</a>' . $innerUl3 . '</li>';

                    }
                    $innerUl .= "</ul><!--2nd array End-->";
                    }
                    $text = ($val['name']);
                    $link = $val['link'];
                    echo '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl . '</li>';
                    }
                    ?>

                    </ul>

                </nav>
                <div class="standard">
                    <div class="logo_side" data-aos="fade-down">
                        <a href="<? echo WEB_URL?>">
                            <div class="logo_img">
                                <!-- <img class="logo" onmouseover="hover(this);" onmouseout="unhover(this);" src=" webImages2/logo_gif.gif " alt=" "> -->
                                <img class="logo " src="<?php echo WEB_URL?>/webImages2/logo.svg " alt=" ">
                            </div>
                            <!-- <div class="logo_txt ">
                            <h3>SMART DENTAL</h3>
                            <h6>COMPLIANCE &amp; TRAINING</h6>
                        </div> -->
                        </a>
                    </div>
                    <div class="menu_icn ">
                        <a href="#menu" class="menu_icn_ " data-aos="fade-down">
                            <img src="<?php echo WEB_URL?>/webImages2/navbar.svg " alt=" " title="menu " />
                        </a>

                    </div>
                    <div class="col1" data-aos="fade-left">
                        <div class="menu_area">
                            <ul>
                       <?php
##### MAIN MENU
$css = false;
$mainMenu = $menuClass->menuTypeSingle('main_menu');
foreach ($mainMenu as $val) {

$insideActive = false;
$innerUl = '';
$menuId = $val['id'];
$text = ($val['name']);
$desc = ($val['short_desc']);

$link = $val['link'];
$mainMenu2 = $menuClass->menuTypeSingle('main_menu', $menuId);
if (!empty($mainMenu2)) {
$innerUl .= '<ul>';
foreach ($mainMenu2 as $val2) {
$innerUl3 = '';
$text = ($val2['name']);
$menuId = $val2['id'];
$link = $val2['link'];
$icon = $val2['icon'];
$desc = ($val2['short_desc']);
$mainMenu3 = $menuClass->menuTypeSingle('main_menu', $menuId);
# count the inner level 3 lis
$innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
$innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
if ( $innerUl3count > 0 ) {
foreach ($mainMenu3 as $val3) {
$innerUl4 = '';
$text3       = ($val3['name']);
$menuId3     = $val3['id'];
$link3       = $val3['link'];
$mainMenu4 = $menuClass->menuTypeSingle('main_menu', $menuId3);
# count the inner level 3 lis
$innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
$innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
if ( $innerUl4count > 0 ) {
foreach ($mainMenu4 as $val4) {
$text4       = ($val4['name']);
$link4       = $val4['link'];

$innerUl4 .= '<li><a href="' . $link4 . '">' . $text4 . '</a></li>';
}}
$innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
$innerUl3 .= '
<li><a href="' . $link3 . '">' . $text3 . '</a>
' . $innerUl4 . '
</li>';
}
}
$innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
$innerUl .= '<li>
                <a href="' . $link . '" target="_blank"> 
                <div class="menu_in"> 
                <img src="'.$icon.'" alt="">
                <div class="menu_in_txt">
                <h2>' . $text . '</h2>
                <p>'  . $desc  . '</p>
                </div>
                </div>
                </a>' . $innerUl3 . 
            '</li>';
}
$innerUl .= "</ul><!--2nd array End-->";
}
$text = ($val['name']);
$link = $val['link'];
$active = $val['active'];

if ($active == '1' || $insideActive) {
// if (!empty($mainMenu2)) {
// $css = true;
// }
//$active = 'active';
}

echo '<li><a href="' . $link . '" class="' . $active . '">' . $text . '</a>' . $innerUl . '</li>';
}

$login  =  $webClass->userLoginCheck();
if(!$login){
    echo "<li><a href='login'>Login</a></li>";
}
else{
    echo "<li class='dash-btn'><a href='".WEB_URL."/main_dashboard'><i class='fas fa-tachometer-alt'></i>Dashboard</a></li>";
}
?>

                            </ul>
                        </div>
                    </div>
                </div>
            </header>

  