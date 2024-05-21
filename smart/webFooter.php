<?php
global $webClass;
global $functions;
global $_e;
global $webClass;
global $db;
// $version = '19';
//No Need to define global it is just for PHPstrom suggestion list...
// if (($_SESSION['onbordingStatus'] > 6 ) || ($_SESSION['onbordingPracticeStatus'] > 4 )) {
    
?>

        <!-- <?php //$box15 = $webClass->getBox('box15'); ?> -->
        <!-- <h6> -->
            <!-- <?php //echo $box15['heading'] ?> -->
        <!-- </h6> -->
        <!-- <h1> -->
            <!-- <?php //echo $box15['heading2'] ?> -->
        <!-- </h1> -->
        <!-- <div class="col10_txt"> -->
            <!-- <?php //echo $box15['text'] ?> -->
        <!-- </div>col10_txt close -->


<?php if(strpos($_SERVER['SCRIPT_NAME'], 'page.php') || strpos($_SERVER['SCRIPT_NAME'], 'index.php')){ 
}else{
?>
   <div class="col1_btn">
            <a href="javascript:;" onclick="referfriend();">
               Refer a Friend</a>
        </div><!-- col1_btn close -->

<?php
}
?>
<div class="whatsapp"><a href="https://api.whatsapp.com/send?phone=<?php echo $functions->ibms_setting('whatsapp'); ?>" target="_blank">
    <img src="/webImages/whatsapp.webp" width="50" alt="whatsapp"></a></div>
    
    <div class="whatsapp tidio" onclick=" window.open('/liveChat','',' scrollbars=yes,menubar=no,width=450,height=650, resizable=yes,toolbar=no,location=no,status=no')">
<img src="/webImages/chat-bubble.png" width="50" alt="whatsapp"></div>
    
        <section class="grid grid-col90" id="footer"  data-aos="flip-down">
            <div class="block__inner">
                <div class="grid block1x5">
                    <div>
                        <h2 class="footer-heading text-uppercase">Contact us</h2>
                        <ul class="list-unstyled contact">
                            <li><a href="#" class="">4 simple ways </a></li>
                            <li>
                                <a href="mailto:info@smartdentalcompliance.com" class=""><img src="webImages2/email.svg"><span>Email:</span>info@smartdentalcompliance.com</a>
                            </li>
                            <li>
                                <?php $box16 = $webClass->getBox('box16'); ?>
                      <a href="tel:+<?php echo $box16['heading2'] ?>" class=""><img src="webImages2/telephone.svg"><span>Telephone:</span>
                            <?php echo $box16['heading2'] ?></a>
                                
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo $functions->ibms_setting('whatsapp'); ?>" target="_blank" class=""><img src="webImages2/whatsapp.svg"><span>WhatsApp us:</span><?php echo $functions->ibms_setting('whatsapp'); ?></a>
                            </li>
                            <li>
                                <a onclick=" window.open('/liveChat','',' scrollbars=yes,menubar=no,width=450,height=650, resizable=yes,toolbar=no,location=no,status=no')" class=""><img src="webImages2/chat.svg"><span></span>Use our Live Chat</a>
                            </li>
                        </ul>
                    </div>

                    <div>

                        <h2 class="footer-heading text-uppercase">Services</h2>
                        <ul class="list-unstyled">
                            <li><a href="https://smartdentalcompliance.com/page-shop" target="blank" class="">AIOM Software</a></li>
                            <li><a href="https://smartdentalcompliance.com/page-courses" target="blank" class="">Compliance Management Courses</a></li>
                            <li><a href="https://smartdentalcompliance.com/page-shop" target="blank" class="">Platinum Package</a></li>
                            <li><a href="https://smartdentalcompliance.com/page-packages" target="blank" class="">Mock Inspection</a></li>
                            <li><a href="https://smartdentalcompliance.com/page-packages" target="blank" class="">CQC Registration </a></li>
                            <li><a href="https://smartdentalcompliance.com/page-squat-practice" target="blank" class="">Squat Practice Package </a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="footer-heading text-uppercase">Registration</h2>
                        <ul class="list-unstyled">
                            <li><a href="https://smartdentalcompliance.com/#" target="blank" class="">ICO Registration </a></li>
                            <li>
                                <a href="https://smartdentalcompliance.com/#" target="blank" class="iconn"><img src="webImages2/footer_icon.webp" alt="" class=""></a>
                            </li>
                            <li><a href="https://smartdentalcompliance.com/#" target="blank" class="">Registered with the ICO</a></li>


                        </ul>
                    </div>
                    <div>
                        <h2 class="footer-heading text-uppercase">Google Reviews</h2>
                        <!--<ul class="list-unstyled">-->
                        <!--    <li>-->
                        <!--        <a href="https://www.google.com/search?q=smart+dental+compliance&rlz=1C1CHBD_enPK958PK958&sxsrf=ALiCzsa6MagyfQ_p6ry2P5uHzIBxdpGgrA%3A1666356896592&ei=oJZSY7XgI9b8sAeTqLPYDg&oq=smart+d&gs_lcp=Cgdnd3Mtd2l6EAMYADIECCMQJzIECCMQJzIFCAAQkQIyCwgAEIAEELEDEIMBMgUIABCABDIFCAAQgAQyBQgAEIAEMgUIABCABDIFCAAQgAQyBQgAEIAEOgoIABBHENYEELADOg0IABBHENYEELADEMkDOggIABCABBCxAzoKCC4QxwEQ0QMQJzoLCC4QxwEQrwEQkQI6CwguEIAEELEDEIMBOggILhCABBCxAzoLCAAQgAQQsQMQyQNKBAhBGABKBAhGGABQtgdY-xlgxSNoBHABeACAAaMDiAGjEpIBBzItOC4wLjGYAQCgAQHIAQjAAQE&sclient=gws-wiz#lrd=0x48761953008373d1:0xa37a1a01b8ed5e1c,1,,," target="blank" class="iconn">-->
                        <!--             <g:ratingbadge merchant_id=MERCHANT_ID></g:ratingbadge> -->
                        <!--            <img class="g-r-img" src="webImages2/Group 8723.jpg">-->

                        <!--        </a>-->
                        <!--    </li>-->

                        <!--</ul>-->
                        
                        <div class="reviewslider"  >
                            <div class="swiper myswiperfooter">
                                <div class="swiper-wrapper">
                                    
                                    <?php 
                                    $sql = "SELECT * from review where publish = 1";
                                    $data = $dbF->getRows($sql);
                                    
                                    foreach($data as $val){
                                    $img = $val['review_img'];
                                    $link = $val['review_link'];
                                    ?>
                                    
                                    <div class="swiper-slide ">
                                        <a href="<?= $link ?>" target="_blank"><img class="lazyload" data-src="<?= $img ?>"  src="<?= $img ?>" alt=" "></a>
                                    </div>
                                    
                                    <?php
                                    }
                                    ?>
            
                                    
            
                                </div>
                            </div>

                        </div>
                        
                        
                    </div>




        </section>

        <section class="grid grid-col90" id="social-links" >
            <div class="block__inner">
                <div class="custon-grid">
                    <div class="margin social-links">
                        <a href="<?php echo $functions->ibms_setting('youtube'); ?>" target="_blank">
                            <img src="webImages2/youtube.svg" width="50px" height="50px" alt="youtube">
                        </a>
                        <a href="<?php echo $functions->ibms_setting('Linkedin'); ?>" target="_blank">
                            <img src="webImages2/linkdin.svg" width="50px" height="50px" alt="linkedin">
                        </a>

                        <a href="<?php echo $functions->ibms_setting('Instagram'); ?>" target="_blank">
                            <img src="webImages2/insta.svg" width="50px" height="50px" alt="instagram">
                        </a>

                        <a href="<?php echo $functions->ibms_setting('Facebook'); ?>" target="_blank">
                            <img src="webImages2/facebook.svg" width="50px" height="50px" alt="facebook">

                        </a>

                        <!--<a href="<?php echo $functions->ibms_setting('Twitter'); ?>" target="_blank">-->
                        <!--    <img src="webImages2/twitter.svg" width="50px" height="50px" alt="facebook">-->

                        <!--</a>-->






                    </div>




                    
                          <?php 
##### RESPONSIVE MAIN MENU
$css = false;
$mainMenu = $menuClass->menuTypeSingle('footer_menu');
foreach ($mainMenu as $val) {
$insideActive = false;
$innerUl = '';
$menuId = $val['id'];
$mainMenu2 = $menuClass->menuTypeSingle('footer_menu', $menuId);
if (!empty($mainMenu2)) {

foreach ($mainMenu2 as $val2) {
$innerUl3 = '';
$text = ($val2['name']);
$link = $val2['link'];
$innerUl .= '<a target="_blank" href="' . $link . '">' . $text . '</a>';
}
}
$text = ($val['name']);
echo '<div class="margin policy">
      ' . $innerUl . '</div><!-- footer_right_box close -->';
}
?>


                        



                    <div class="margin">

                        <!--<p class="copyright">-->
                           
                        <!--</p>-->
                        <p class="reserved">
                           &copy;  2019-<?php echo date('Y')?> <a href="<?php echo WEB_URL ?>"> SDC</a>, Inc. All Rights Reserved
                        </p>


                    </div>


                    <div class="margin">



                        <?php echo $webClass->ourLogo(); ?>


                     


                    </div>




                </div>


            </div>

        </section>
    </main>


</body>

<script src="<?php echo WEB_URL ?>/js/web_js/owl.carousel.min.js?magic=<?php echo filemtime('./js/web_js/owl.carousel.min.js')?>"></script>
<script src="<?php echo WEB_URL ?>/js/web_js/swiper.js?magic=<?php echo filemtime('./js/web_js/swiper.js')?>"></script>
<script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js "></script>
<script src="<?php echo WEB_URL ?>/js/web_js/aos.js?magic=<?php echo filemtime('./js/web_js/aos.js')?>"></script>
<script src="<?php echo WEB_URL ?>/js/web_js/mmenu.min.all.js?magic=<?php echo filemtime('./js/web_js/mmenu.min.all.js')?>"></script>
<script type="text/javascript" src="<?php echo WEB_URL ?>/js/web_js/lottie.min.js?magic=<?php echo filemtime('./js/web_js/lottie.min.js')?>"></script>
<script type="text/javascript" src="<?php echo WEB_URL ?>/json/RippleEffect.json?magic=<?php echo filemtime('./json/RippleEffect.json')?>"></script>
<script type="text/javascript" src="<?php echo WEB_URL ?>/json/RippleEffect2.json?magic=<?php echo filemtime('./json/RippleEffect2.json')?>"></script>
<script src="<?php echo WEB_URL ?>/js/jquery_ui.js?magic=<?php echo filemtime('./js/jquery_ui.js')?>"></script>
<script src="<?php echo WEB_URL ?>/js/web_js/fancybox.js?magic=<?php echo filemtime('./js/web_js/fancybox.js')?>"></script>
<script>
    $(function() {
        $("#tabs").tabs({

                hide: 'fade',
                show: 'fade'


            });
            
                $(".datepicker").datepicker({ dateFormat: "d-M-yy"})
    });
</script>
<script src="<?php echo WEB_URL ?>/js/web_js/lazy.js?magic=<?php echo filemtime('./js/web_js/lazy.js')?>"></script>
<script src="<?php echo WEB_URL ?>/js/web_js/main.js?magic=<?php echo filemtime('./js/web_js/main.js')?>"></script>
<?php 

    if($login){ 
    
 }else{echo $functions->ibms_setting('Google_Analythics');}
if ((substr_count($_SERVER['REQUEST_URI'], "mock-test") != 1) && (substr_count($_SERVER['REQUEST_URI'], "practice") != 1) && (substr_count($_SERVER['REQUEST_URI'], "review") != 1) && (substr_count($_SERVER['REQUEST_URI'], "editevent_print") != 1) && (substr_count($_SERVER['REQUEST_URI'], "take_test") != 1)) {
// if($_SERVER['REQUEST_URI']!="/editevent_print.php?id=$_GET[id]"||$_SERVER['REQUEST_URI']!="/editevent_print.php?id=$_GET[id]"){
 ?>
<!--<script type="text/javascript" src="https://secure.dawn3host.com/js/209948.js" ></script>-->
<!--<noscript><img alt="" src="https://secure.dawn3host.com/209948.png" style="display:none;" /></noscript>-->
<!--<script async src="https://code.tidio.co/5jkcerlgefgq5htbnq2egktoydjtplwi.js"></script>-->
<?php  }?>

<script>
if(window.navigator && navigator.serviceWorker) {
  navigator.serviceWorker.getRegistrations()
  .then(function(registrations) {
    for(let registration of registrations) {
      registration.unregister();
    }
  });
}
</script>

<script>
if($('#g-contactFormSubmit').length)
{
    grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'contactFormSubmit'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-contactFormSubmit').value = token;
        });
    });

}
if($('#g-bookForm').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'bookForm'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-bookForm').value = token;
        });
    });
}

if($('#g-smallBookForm').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'bookForm'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-smallBookForm').value = token;
        });
    });
}

if($('#g-webinarForm').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'webinarForm'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-webinarForm').value = token;
        });
    });
}

if($('#g-freeResourceForm').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'freeResourceForm'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-freeResourceForm').value = token;
        });
    });
}

if($('#g-fridayDeal').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'fridayDeal'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-fridayDeal').value = token;
        });
    });

}



if($('#g-popupForm').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'popupForm'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-popupForm').value = token;
        });
    });

}

if($('#g-featureFormSubmit').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'featureFormSubmit'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-featureFormSubmit').value = token;
        });
    });

}

if($('#g-inquiryFormSubmit').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'inquiryFormSubmit'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-inquiryFormSubmit').value = token;
        });
    });

}


// if($('#g-lunchandlearn').length)
// {
//      grecaptcha.ready(function() {
//     // do request for recaptcha token
//     // response is promise with passed token
//         grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'lunchandlearn'})
//                   .then(function(token) {
//             // add token value to form
//             document.getElementById('g-lunchandlearn').value = token;
//         });
//     });

// }


if($('#g-referfriendSubmitWOLOGIN').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'referfriendSubmitWOLOGIN'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-referfriendSubmitWOLOGIN').value = token;
        });
    });

}

if($('#g-delegates').length)
{
     grecaptcha.ready(function() {
    // do request for recaptcha token
    // response is promise with passed token
        grecaptcha.execute('6LcQIscZAAAAAGLytR5dCMklULVOUfxXZ6mRmDnc', {action:'delegates'})
                  .then(function(token) {
            // add token value to form
            document.getElementById('g-delegates').value = token;
        });
    });

}
</script>

</html>