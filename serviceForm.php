<?php
   
include_once("global.php");
global $webClass;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<!--Header-->
<?php   
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' *.tawk.to *.gstatic.com;");
header("X-Content-Security-Policy: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' *.tawk.to *.gstatic.com;");
header("X-WebKit-CSP: default-src 'self' *.onesignal.com *.tidio.co *.tidiochat.com https://onesignal.com; script-src 'unsafe-inline' 'unsafe-eval' https://smartdentalcompliance.com *.google.com *.googletagmanager.com *.gstatic.com *.onesignal.com https://onesignal.com *.cloudflare.com *.tidio.co *.tidiochat.com  *.jsdelivr.net *.facebook.net; connect-src https://smartdentalcompliance.com *.google-analytics.com *.google.com *.tawk.to wss://*.tawk.to wss://socket.tidio.co https://onesignal.com *.onesignal.com; style-src 'unsafe-inline' *.cloudflare.com https://smartdentalcompliance.com https://onesignal.com *.tawk.to *.googleapis.com; img-src 'self' data: https://smartdentalcompliance.com *.tawk.to *.facebook.com https://www.googletagmanager.com; frame-src 'self' *.google.com *.youtube.com *.live.com *.gocardless.com *.facebook.com; font-src 'self' *.tawk.to *.gstatic.com;");

  

        ?>
<!DOCTYPE html>
<html lang="en">

<head>
<script>
    self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.filter(function(cacheName) {
          // Return true if you want to remove this cache,
          // but remember that caches are shared across
          // the whole origin
        }).map(function(cacheName) {
          return caches.delete(cacheName);
        })
      );
    })
  );
});
</script>

    <?php
        $seo['image']="https://smartdentalcompliance.com/webImages/logo-1240x600.png?magic=01";
        $webClass->AllSeoPrint();
    ?>
    <meta name="robots" content='noindex, nofollow' />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- FAVICON -->
    <link rel="icon" href="<?php echo WEB_URL ?>/webImages/favicon.ico?magic=<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo WEB_URL ?>/webImages/favicon.ico?magic=<?php echo filemtime('./webImages/favicon.ico')?>" type="image/x-icon" />
    <!--Bootstrap css file-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/hover.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/mmenu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/vmenuModule.css">

    <style>
        .soc_ico, .col1_btn, .footer_side{
            display : none !important;
        }
    </style>
     



    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/style.css?magic=<?php echo filemtime('./css/style.css')?>">

    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/owl.carousel.css">
    





    <!-- DESKTOP -->
    <link href="<?php echo WEB_URL ?>/css/style-desktop.css?magic=<?php echo filemtime('./css/style-desktop.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1400px)">
    <!-- TABLET -->
    <link href="<?php echo WEB_URL ?>/css/style-tablet.css?magic=<?php echo filemtime('./css/style-tablet.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
    <!-- MOBILE -->
    <link href="<?php echo WEB_URL ?>/css/style-mobile.css?magic=<?php echo filemtime('./css/style-mobile.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
    <!-- MOBILE SMALL-->
    <link href="<?php echo WEB_URL ?>/css/style-mobile-small.css?magic=<?php echo filemtime('./css/style-mobile-small.css')?>" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)">

    <link rel="stylesheet" href="<?php echo WEB_URL ?>/css/choices.min.css">
    <script src="<?php echo WEB_URL ?>/js/choices.min.js"></script>


   



    <?php $login = $webClass->userLoginCheck();
    if($login){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo WEB_URL ?>/css/style2.css?<?php echo filemtime('./css/style2.css')?>">
    <!-- DESKTOP -->
    <link href="<?php echo WEB_URL ?>/css/style-desktop2.css?magic=<?php echo filemtime('./css/style-desktop2.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:979px) and (max-width:1400px)">
    <!-- TABLET -->
    <link href="<?php echo WEB_URL ?>/css/style-tablet2.css?magic=<?php echo filemtime('./css/style-tablet2.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and (max-width:978px)">
    <!-- MOBILE -->
    <link href="<?php echo WEB_URL ?>/css/style-mobile2.css?magic=<?php echo filemtime('./css/style-mobile2.css')?>" rel="stylesheet" type="text/css" media="only screen and (min-width:461px) and (max-width:767px)">
    
    <!-- MOBILE SMALL-->
    <link href="<?php echo WEB_URL ?>/css/style-mobile-small2.css?magic=<?php echo filemtime('./css/style-mobile-small2.css')?>" rel="stylesheet" type="text/css" media="only screen and (max-width:460px)">
    <?php }else{

        $chk = $webClass->bookingFormSubmit();
        
    } ?>
 
 
  <!-- <link rel="stylesheet" type="text/css" href="<?php //echo WEB_URL ?>/css/black-day.css?magic=<?php //echo filemtime('./css/black-day.css')?>">  -->
    <script src="<?php echo WEB_URL?>/js/jquery.min.js?magic=<?php echo filemtime('./js/jquery.min.js')?>"></script>
<script src="<?php echo WEB_URL ?>/js/jquery.uploadfile.min.js?magic=<?php echo filemtime('./js/jquery.uploadfile.min.js')?>"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc"></script>
   
    <script>
        grecaptcha.ready(function() {
          grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc').then(function(token) {
              console.log(token);
                // document.getElementById('token').value = token;
               var list = document.querySelectorAll('.g-lunchandlearn');
                var n;
                for (n = 0; n < list.length; ++n) {
                    list[n].value= token;
                } 
              
          });
        });
        setInterval(function () {
        grecaptcha.ready(function() {
          grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc').then(function(token) {
              console.log(token);
                // document.getElementById('token').value = token;
               var list = document.querySelectorAll('.g-lunchandlearn');
                var n;
                for (n = 0; n < list.length; ++n) {
                    list[n].value= token;
                } 
              
          });
        });
        }, 120 * 950);
         
  </script>

    <link rel='manifest' href='<?php echo WEB_URL?>/manifest.json?magic=<?php echo filemtime('./manifest.json')?>'>

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

<?php


$webClass->popupFormSubmit();

?>

<body onafterprint="WindowBack()">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8SPBFV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 <?php $box21 = $webClass->getBox('box21');?>
   <?php if(!empty($box21['text'])){?>
   <div class="maintenance">
        <marquee>
            <?php echo $box21['text'] ?>
        </marquee>
    </div>
    <!-- maintenance -->
<?php } ?>

    <div id="cartLoading"></div>
    


    <div class="background_side">
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
            <?php $functions->setFormToken('bookForm'); ?>    
                           <input type="hidden" id="g-bookForm" name="g-bookForm">
    <input type="hidden" name="action" value="bookForm">
            
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
    <div class="col101 col101_webinar">
        <div class="close_popup hvr-pop">
            <i class="fas fa-times"></i>
        </div>
        <h1>Webinar Registration</h1>
        <div class="col101_txt">
            Please fill out this form to register in the webinar.
        </div>
        <h6>PERSONAL DETAILS</h6>
        <form method="post">
            <?php $functions->setFormToken('webinar'); ?>    
            <input type="hidden" id="g-webinarForm" name="g-webinarForm">
            <input type="hidden" name="action" value="webinarForm">
            <input type="hidden" name="form[title]" class="webinarTitle">
            <input type="hidden" name="form[zoomLink]" class="zoomLink">

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
                    <button type="submit" name="submit">
                        Submit Information
                    </button>
                </div>
            </div>
        </form>
    </div> 
    <div class="main_mmenu">
        <div id="page">
            <nav id="menu">
                <ul>
                    <?php
                    $login  =  $webClass->userLoginCheck();
                    if(!$login){
                        echo "<li><a href='login'>Login</a></li>";
                    }
                    else{
                        echo "<li><a href='/main_dashboard'>Dashboard</a></li>";
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


<!-- <li>
</li> -->
                </ul>
<span class="install-app-btn-container">
<a id="installApp" class="install-app-btn"><i class="fas fa-download"></i>Install App</a>
</span>

            </nav>
        </div>
    </div>
    <div class="main_container">
        <header>
            <div class="header_side">
                <?php if(strpos($_SERVER['SCRIPT_NAME'], 'index.php')){ ?>
                <div class="banner_side">
                    <video autoplay muted loop style="width: 100%">
                        <source src="<?php echo WEB_URL ?>/webImages/SDC.webm" type="video/mp4" />
                    </video>

                    <!--<img src="<?php echo WEB_URL ?>/webImages/bs.png" alt="">-->
                    <div class="banner_side_main">
                        <div class="standard">
                            <div class="banner_left">
                                <ul id="banner_">
                                <?php 
                                    $bannersData    =   $webClass->web_banners();
                                    $banners = '';
                                    $banners1 = '';
                                    $bannerscount = 1;
                                    foreach($bannersData as $val){
                                    $title  =   $val['title'];
                                    $text   =   $val['text'];
                                    $image1  =   $val['layer0'];
                                    $image2  =   $val['layer2'];
                                    $link  =   $val['link'];
                                    $linkText  =   $val['layer3']; 
                                    $banners .='<li>
                                        <div class="banner_txt">
                                            <div class="banner_txt_main wow zoomInUp">
                                                <h3>'.$title.'</h3>
                                                <div class="banner_txt_main_">
                                                    '.$text.'
                                                </div>
                                                <div class="col1_btn">
                                                     <a href="#">Get Started</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                                    $bannerscount++;
                                    }
                                    echo $banners;
                                    ?>   
                                </ul>
                            </div>


                        </div>
                    </div>

                </div>
                <?php } else { ?>
                <div class="col1_btn_main wow fadeInRight">
                    <img src="<?php echo WEB_URL ?>/webImages/1.png" alt="" class="hvr-pop">
                </div><!-- col1_btn_main close -->
                <div class="inner_banner">
                    <img src="<?php echo @$bannerImg ?>" alt="">
                    <div class="inner_banner_txt wow fadeInDown">
                        <div class="standard">
                            <h3>
                                <?php echo @$subHeading ?>
                            </h3>
                            <h6>
                                <?php echo @$shrtDesc ?>
                            </h6>
                        </div><!-- standard close -->
                    </div><!-- inner_banner_txt close -->
                </div><!-- inner_banner close -->
                <?php } ?>
                <div class="header_top wow fadeInDown">
                    <div class="standard">
                        <div class="logo_side">
                            <a href="https://smartdentalcompliance.com">
                                <div class="logo_img">
                                    <img src="https://smartdentalcompliance.com/webImages/logo.png?magic=01" alt="">
                                </div>
                                <div class="logo_txt">
                                    <h3>SMART DENTAL</h3>
                                    <h6>COMPLIANCE & TRAINING</h6>
                                </div>
                            </a>
                        </div>
                        <div class="header_top_right">
                            <div class="col1">
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
    echo "<li class='dash-btn'><a href='/main_dashboard'><i class='fas fa-tachometer-alt'></i>Dashboard</a></li>";
}
?>

                    </ul>
                </div>
                                <!-- <div class="col1_btn">
                                    <a href="javascript:;">
                                        Book a Demo </a>
                                </div> -->
                                <?php $login  =  $webClass->userLoginCheck();
                                if(!$login){ ?>
                                <div class="col1_btn">
                                    <?php $box17 = $webClass->getBox('box17'); ?>
                                    <a href="javascript:;">
                                        <?php echo $box17['linkText'] ?>
                                    </a>
                                </div><!-- col1_btn close -->
                                <?php } ?>

                                <div class="menu_side">
                                    <a href="#menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="links_area" style="display: none;">
            <div class="close_side"><i class="fas fa-times"></i></div><!-- close_side close -->
            <div class="u-vmenu">
                <ul>
                    <li><a href="<?php echo WEB_URL; ?>/practice-profile"><i class="fas fa-user"></i>Practice Profile</a></li>
                     <li>
            <a class="<?php if($active=='post_all') echo'active'?>" href="<?php echo WEB_URL; ?>/post_all?type=posts"><i class="fab fa-mixcloud"></i>Intranet</a>
                </li>
                    <li>
                        <a href="<?php echo WEB_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo WEB_URL; ?>/calendar"><i class="fas fa-calendar-alt"></i>Activity Calendar</a>



                           <ul>
             

                <li><a href="<?php echo WEB_URL; ?>/addReminder">My Reminder</a></li>



              </ul>




                    </li>
                    <li>
                        <a href="<?php echo WEB_URL; ?>/reportIssue"><i class="fas fa-users"></i>Reports</a>
  <span data-option="off"></span>

                        <ul>
             

                <li><a href="<?php echo WEB_URL; ?>/reportIssue">Report an issue</a></li>
                 <?php  if($_SESSION['currentUserType'] != 'Employee'){ ?>

   <li><a href="<?php echo WEB_URL; ?>/mock_inspection">Mock Inspection</a></li>
   
   <?php } ?>



              </ul>

              
                    </li>

<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){?>

<?php }else{?>
<li>
<a href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates"><i class="fas fa-list-alt"></i>Compliance Templates</a>
</li>
<?php }?>



                
                    <li>
                        <a href="<?php echo WEB_URL; ?>/myuploads"><i class="fas fa-upload"></i>My Uploads</a>
                    </li>
                    <li>
                        <a href="<?php echo WEB_URL; ?>/cpd"><i class="fas fa-tv"></i>CPD Courses</a>
                        <span data-option="off"></span>
                        <ul>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-form">My Profile</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-activity">My Activity Log</a></li>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-pdp">My PDP</a></li>
                            <?php                           
                            // $sql = "SELECT `setting_val` FROM `ibms_setting` WHERE `setting_name` = 'test_categories'";
                            // $res = $dbF->getRow($sql);
                            // $res = explode(",", $res[0]);
                            // foreach ($res as $field): 
                            // echo'
                            // <li><a href="'.WEB_URL.'/course?Cat='.$field.'">'.$field.'</a> 
                            // ';
                            // endforeach;  
                            ?>
                            <li><a href="<?php echo WEB_URL; ?>/cpd-certificates">My Certificates</a></li>

                            <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){}else{?>
                <li><a href="<?php echo WEB_URL; ?>/assigne_course">Assign CPD Course</a></li>
             <?php } ?>



             
                        </ul>
                    </li>
<!-- <li>
<a href="<?php echo WEB_URL; ?>/resources?category=HR-Management"><i class="fas fa-users"></i>HR Management</a>
<span data-option="off"></span>
<ul>
<li><a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a></li>
<li><a href="<?php echo WEB_URL; ?>/manage-users">My Staff</a>
<li>
<a href="<?php echo WEB_URL; ?>/hrm">Employee Hub</a>
<span data-option="off"></span>
<ul>
<li><a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a></li>
<li><a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a></li>
<li><a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a></li>


</ul>
</li>
<li><a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a></li>
<li><a href="<?php echo WEB_URL; ?>/rota">Rota Management</a></li>
<li><a href="<?php echo WEB_URL; ?>">Payroll</a></li>
<li><a href="<?php echo WEB_URL; ?>/recruitment">Recruitment</a></li>
<li><a href="<?php echo WEB_URL; ?>/rota-reports">Reports</a></li>
<li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a></li>
</ul>
</li> -->


          
    <li>
    <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>

    <a href="#" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i>HR Management</a>
    <?php }else{?>
    <a href="<?php echo WEB_URL; ?>/resources?category=HR-Management" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i>HR Management</a>
    <?php } ?>
     <span data-option="off"></span>
    <ul>
    <li><a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a></li>
    <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ $usermenu =  $_SESSION['superid'];   ?>


    <li><a href="<?php echo WEB_URL; ?>/profile-detail?user=<?php echo $usermenu; ?>" >My Staff</a>
    <?php } else{ $usermenu = $_SESSION['currentUser']; ?>

    <li><a href="<?php echo WEB_URL; ?>/manage-users">My Staff</a>
    <?php } ?>
     <span data-option="off"></span><ul>
    <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a></li>
    <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a></li>
    <!-- <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/instance">Staff Performance</a></li> -->

    <li><a href="leave-reports">Leave Reports</a>
     <span data-option="off"></span><ul>


    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=annual_leave">Annual Leave</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=sick_leave">Sick Leave</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=casual_leave">Casual Leave</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=maternity_leave">Maternity</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=half_day_leave">Half Day Leave</a></li>
    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=furlough_leave">Furlough leave</a></li>


    </ul>
    </li>
    <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-reports">Holiday Entitlement Reports</a></li>
    <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator">Holiday Entitlement Calculate</a></li>

    <li  ><a href="<?php echo WEB_URL; ?>/lieu">OverTime Report</a></li>
    </ul>
    </li>

    <li <?php if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){ echo $sh;} ?>>
    <a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a></li>
    <li><a href="<?php echo WEB_URL; ?>/rota">Rota Management</a></li>
    <li><a href="<?php echo WEB_URL; ?>/personal-document">Personal Documents</a></li>
    <li><a href="<?php echo WEB_URL; ?>/rota-reports">Reports</a>
    <span data-option="off"></span> <ul>
    <?php if( $_SESSION['currentUserType'] == 'Employee' &&  $_SESSION['superUser']['hrreports'] == '0')  { ?>     
    <li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>
    <?php }else{  ?>
    <li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>
    <li ><a href="<?php echo WEB_URL; ?>/policy-report?category=Training">Training Report</a></li>
    <li><a href="<?php echo WEB_URL; ?>/policy-report?category=Recruitment">Recruitment Report</a></li>
    <li><a href="<?php echo WEB_URL; ?>/policy-report?category=Signed Policies">Signed Policies Report</a></li>
    <li><a href="<?php echo WEB_URL; ?>/policy-report?category=Minute Meeting">Minute Meeting Report</a></li>
    <li><a href="<?php echo WEB_URL; ?>/policy-report?category=MHRA">MHRA Alerts Report </a></li>
    <li><a href="<?php echo WEB_URL; ?>/policy-report?category=Additional Document">Additional Document</a></li>  
    <?php } ?>
    </ul>
    </li>
    <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ ?>

    <?php }else{ ?>
    <li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a></li>
    <?php } ?>
    </ul>
    </li>



<li>
<a href="<?php echo WEB_URL; ?>/stock"><i class="fas fa-server"></i>Stock Management</a>
<span data-option="off"></span>
<ul>

 <?php  if(@$_SESSION['currentUserType'] == 'Employee' && ($_SESSION['superUser']['manage_stock'] == '0' || $_SESSION['superUser']['manage_stock'] == '')){ ?>


<!-- <li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li> -->
<!-- <li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li> -->
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<!-- <li>
<a href="javascript:;">Reports</a>
<span data-option="off"></span>
<ul>
<li>
<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>
</li>
</ul>
</li> -->
<?php }else{ ?>



<li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/stockView#tabs-2">Add Existing Stock</a>
</li>





<li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<li>
<a href="javascript:;">Reports</a>
<span data-option="off"></span>
<ul>
<li>
<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>
</li>
</ul>
</li>


    <?php } ?>






</ul>



</li>
                     <li>
                        <a class="<?php if($active=='faq') echo'active'?>" href="<?php echo WEB_URL; ?>/faq"><i class="fas fa-info"></i> FAQ</a></li>
                                <li>
                        <?php 
                        $functions->CheckInBtn();
                        $functions->CheckOutBtn();
                        ?>
                    </li>
                </ul>
                <!--  ul close -->
            </div>
        </div>
        <!-- links_area close -->
        <!-- <div id="pull-chain">
       
         <a href="https://smartdentalcompliance.com/black-friday-deals" class="sales_">Get Black Friday Sale</a>
        <div class="handle remove_21" id ="pull"><img src="<?php echo WEB_URL ?>/webImages/1211.png?123" alt=""></div>
    </div>
    <div class="mobile_view"><a href="https://smartdentalcompliance.com/black-friday-deals"><img src="<?php echo WEB_URL ?>/webImages/11.gif" alt="">
    <img src="<?php echo WEB_URL ?>/webImages/SALE2.png" alt="" class="sale" style="
    margin-left: -9px;
    margin-top: -10px;
"></a></div> -->

<!--Header-->
<?php

$pMmsg = '';

$contactAllow = true;



if(isset($_POST) && !empty($_POST['form']) ){


 if (isset($_POST['g-contactFormSubmit'])) {
    $captcha = $_POST['g-contactFormSubmit'];
} 

 if(!$captcha){
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
        // $contactAllow = false;
    }
    $secret   = "6LcQIscZAAAAAIZtvX0F2x2SxjUdqi9JBNQZgoBm";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    // use json_decode to extract json response
    $responseKeys = json_decode($response,true);

     if(intval($responseKeys["success"]) !== 1) {
        
        $pMmsg = $dbF->hardWords('Please verify that you passed the captcha code.',false);
        // $contactAllow = false;
    }else{




$img="";




$f = '';
$v = '';
$c = 1;
$array = array();



$msg='<table border="1">';
$comment = "";
$type = "";
foreach($_POST['form'] as $key=>$val){
if(strtolower($key) == "service"){
    $type = $val;
}
else if(strtolower($key) == "comment"){
    $comment = $val;
}
else{
    $f .= 'field'.$c.' = ?,';
    $val = (strtolower($key) == "service time") ?  str_replace(':','-', $val) : $val ;
    $v = ucwords(str_replace("_"," ",$key)).':'.$val;
    $array[]= $v;
    $c++;
    }
}

$f = trim($f,",");

$sql = "INSERT INTO  `inHouseFormData` SET ";
 
$sql .= $f.', type = ?, comment = ?';
$data2 = array(str_replace(" ","_",@$type), $comment);
$array = array_merge($array, $data2);
$result = $dbF->setRow($sql,$array,false);
if($dbF->rowCount > 0){
    $pMmsg = $dbF->hardWords('Form has been submitted successfully.',false);
}else{
    $pMmsg = $dbF->hardWords('Form submission failed.',false);
}
  
    }
}

?>

<body
<div class="inner_content">
<div class="text_side_left">
    <div class="standard">
    
<?php
if($pMmsg!=''){
echo "<div class='alert alert-info'>$pMmsg</div>";
}

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
                <h5>Service Form</h5>
                <div class="form_1_">
                    <form method="post">
                        

                         <input type="hidden" id="g-contactFormSubmit" name="g-contactFormSubmit">
    
                        <div class="form_1_side_">Person Name:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<input type="text" placeholder="Your Name" name="form[name]" required value="<?php echo @$userData['name']; ?>">-->
                            <input type="text" placeholder="Person Name" name="form[Person Name]"  value="<?php echo @$userData['name']; ?>">
                        </div>
                        
                        
                        <div class="form_1_side_">Practice Name:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                        
                            <!--<input type="text" placeholder="Your Practice Name" name="form[practice_name]" value="<?php //echo @$userData['practiceName']; ?>">-->
                            <input type="text" placeholder="Practice Name" name="form[Practice Name]" value="">
                        </div>
                        
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Email:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<input type="email" placeholder="Email" name="form[email]" required value="<?php //echo @$userData['email']; ?>">-->
                            <input type="email" placeholder="Email" name="form[Email]"  value="">
                        </div>
                        
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Contact No.:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<input type="phone" placeholder="Your Phone" name="form[phone]" value="<?php //echo @$userData['phone']; ?>">-->
                            <input type="phone" placeholder="Contact No" name="form[Contact No]" value="">
                        </div>
                        
                        <!-- form_2_side close -->
                        
                        <div class="form_1_side_">Service:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<textarea placeholder="Your Message" name="form[message]" required></textarea>-->
                            <select name="form[Service]" required>
                                <option value="">--Select--</option>
                                <option value="callBack">Call Back</option>
                                <option value="demo">Demo</option>
                                <option value="onBoarding">On Boarding</option>
                                <option value="training">Training</option>
                            </select>
                        </div>
                        
                        <!-- form_2_side close -->
                        <div class="form_1_side_">Service Date:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<input type="phone" placeholder="Your Phone" name="form[phone]" value="<?php //echo @$userData['phone']; ?>">-->
                            <input type="date" placeholder="Set" name="form[Service Date]" value="">
                        </div>
                        
                         <!-- form_2_side close -->
                        <div class="form_1_side_">Service Time:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <!--<input type="phone" placeholder="Your Phone" name="form[phone]" value="<?php //echo @$userData['phone']; ?>">-->
                            <input type="time" placeholder="Set" name="form[Service Time]" value="">
                        </div>
                        
                         <div class="form_1_side_">Your Name:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                        
                            <!--<input type="text" placeholder="Your Practice Name" name="form[practice_name]" value="<?php //echo @$userData['practiceName']; ?>">-->
                            <input type="text" placeholder="Your Name" name="form[Your Name]" value="">
                        </div>
                        
                        
                        <div class="form_1_side_">Comment:</div>
                        <!-- form_1_side close -->
                        <div class="form_2_side_ hvr-shadow-radial">
                            <textarea placeholder="Your Message" name="form[Comment]" ></textarea>
                            
                        </div>
                        
                        <!-- form_2_side close -->
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


<?php include_once('footer.php'); ?>