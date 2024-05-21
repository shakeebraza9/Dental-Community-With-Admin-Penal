<?php

include("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include("webHeader.php");
global $webClass;
global $productClass;
/**
* MultiLanguage keys Use where echo;
* define this class words and where this class will call
* and define words of file where this class will called
**/
global $_e;
$_w = array();
$_w['Show all news'] = '';
$_e = $dbF->hardWordsMulti($_w, currentWebLanguage(), 'Website Index');

 // $webClass->subscribeFormSubmit(); 
?>    

<?php  
// include_once("black-friday-popup.php"); 
 //  include_once("helloween-popup.php");
include_once("indexPOPUP.php");
  ?>
  </div>

        <div class="banner " >
            <?php $login  =  $webClass->userLoginCheck();
                                if(!$login){ ?>
                                <div class="demoBookBtn">
                                    <?php $box17 = $webClass->getBox('box17'); ?>
                                    <a href="javascript:;" class="demo-toggle">
                                        <?php echo $box17['linkText'] ?>
                                    </a>
                                </div><!-- col1_btn close -->
                                <?php } ?>
            <!-- <a href="" class="demo-toggle">Book a Demo</a> -->
            <!--<div id="lottie"></div>-->
            <div class="standard ">
                <div class="bannermain "  data-aos="fade-left">
                    <div class="bannerimg ">
                        <img src="webImages2/aiom.png " alt=" ">
                    </div>
                    <div class="bannnertext ">
                        <h2>More flexible, friendly and smart!</h2>
                        <h1> Get things done with
                            <span>AIOM</span>

                        </h1>
                        <?php
                        $login  =  $webClass->userLoginCheck();
                        if(!$login){
                         echo '<a class="login" href="'.WEB_URL.'/login" target="_blank">Login <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="'.WEB_URL.'/freeTrial" class="freetrail" target="_blank"> Free Trial</a>';
                        }
                        else{
                            echo "<a class='login' href='".WEB_URL."/main_dashboard'> Dashboard</a>";
                        }
?>
                  
                    </div>
                </div>

            </div>

            <div class="cardbanner "  >
                <div class="swiper mySwiper ">
                    <div class="swiper-wrapper ">
                        <div class="swiper-slide ">
                            <img class="lazyload" data-src="./webImages2/card1.png"  src="./webImages2/card1.png" alt=" ">
                        </div>
                        <div class="swiper-slide ">
                            <img class="lazyload" data-src="./webImages2/card2.png "src="./webImages2/card2.png " alt=" ">
                        </div>

                        <div class="swiper-slide ">
                            <img class="lazyload" data-src="./webImages2/card3.png" src="webImages2/card3.png " alt=" ">
                        </div>
                        <div class="swiper-slide ">
                            <img class="lazyload"  data-src="./webImages2/card4.png" src="./webImages2/card4.png " alt=" ">
                        </div>
                        <div class="swiper-slide ">
                            <img class="lazyload" data-src="./webImages2/card5.png" src="./webImages2/card5.png " alt=" ">
                        </div>

                        <div class="swiper-slide ">
                            <img class="lazyload" data-src="./webImages2/card6.png" src="webImages2/card6.png " alt=" ">
                        </div>
                        
                        <div class="swiper-slide ">
                            <img  class="lazyload" data-src="./webImages2/card7.png" src="webImages2/card7.png " alt=" ">
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="tab-section">
            <div class="standard">
                <div class="bannermain">
                    <div class="bannnertext ">
                        <h1 data-aos="fade-left">Activity and Holiday Calendar, together in one place</h1>
                        <h4 data-aos="fade-left">Stay organised and prioritise upcoming events.</h4>
                    </div>
                </div>

                <div id="tabs" data-aos="fade-down">
                    <ul>
                        <li>
                            <a href="#tabs-1"><img  class="lazyload" data-src="webImages2/calaander.svg" src="webImages2/calaander.svg" alt=""><span>Activity Calander</span></a>
                        </li>
                        <li>
                            <a href="#tabs-2"><img  class="lazyload" data-src="webImages2/compliance_.svg" src="webImages2/compliance_.svg" alt=""><span>Compliance Management</span></a>
                        </li> 
                        <li>
                            <a href="#tabs-3"><img   class="lazyload" data-src="webImages2/cpd_.svg"  src="webImages2/cpd_.svg" alt=""><span>CPD Management</span></a>
                        </li>
                        <li>
                            <a href="#tabs-4"><img  class="lazyload" data-src="webImages2/hr_ (2).svg" src="webImages2/hr_ (2).svg" alt=""><span>HR Management</span></a>
                        </li>
                        <li>
                            <a href="#tabs-5"><img  class="lazyload" data-src="webImages2/stock_.svg" src="webImages2/stock_.svg" alt=""><span>Stock Management</span></a>
                        </li>
                        <li>
                            <a href="#tabs-6"><img  class="lazyload" data-src="webImages2/lab.svg" src="webImages2/lab.svg" alt=""><span>Lab Management</span></a>
                        </li>
                    </ul>
                    <div id="tabs-1">
                        <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/calender.webm" type="video/webm"></video>
<!--<video class="lazyload" data-src="webImages2/calender.svg" src="" width="100%" autoplay loop ></video>-->
                        <!--<img  class="lazyload" data-src="webImages2/calender.gif" src="webImages2/calender.gif" alt="">-->
                    </div>
                    <div id="tabs-2">
                         <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/compliance.webm" type="video/webm"></video>
                        <!--<img class="lazyload" data-src="webImages2/compliance.gif" src="webImages2/compliance.gif" alt="">-->
                    </div>
                    <div id="tabs-3">
                         <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/CPD.webm" type="video/webm"></video>
                        <!--<img class="lazyload" data-src="webImages2/CPD.gif" src="webImages2/CPD.gif" alt="">-->
                    </div>
                    <div id="tabs-4">
                         <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/HR.webm" type="video/webm"></video>
                        <!--<img class="lazyload" data-src="webImages2/HR.gif" src="webImages2/HR.gif" alt="">-->
                    </div>
                    <div id="tabs-5">
                         <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/Stock.webm" type="video/webm"></video>
                        <!--<img class="lazyload"  data-src="webImages2/Stock.gif" src="webImages2/Stock.gif" alt="">-->
                    </div>
                    <div id="tabs-6">
                         <video width="100%" loop="true" autoplay="autoplay"  muted><source src="webImages2/LabManagement.webm" type="video/webm"></video>
                        <!--<img class="lazyload" data-src="webImages2/LabManagement.gif" src="webImages2/LabManagement.gif" alt="">-->
                    </div>
                </div>
            </div>
        </div>
        <div class="aiom-dental" data-aos="fade-down">
            <div class="standard">
                <div class="grid grid--col60">
                    <div class="block__inner">
                        <img class="lazyload" data-src="webImages2/aiom.png" src="webImages2/aiom.png" alt="" data-aos="fade-down">
                        <div class="overlay">
                            <h2 data-aos="fade-left">FOR DENTAL GROUPS</h2>
                            <p data-aos="fade-right">The AIOM software is designed to work for small to large dental corporates. Our key features allow area managers and even multiple site managers- to overlook all sites with just a click of a button. Here are some key features:
                            </p>
                        </div>
                        <a data-aos="fade-up" data-fancybox="" href="https://youtu.be/7VRu2yzvLmw">
                        <button class="btn explore">Watch our Videos</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="standard">
            <div class="circle2">
                <div class="grid grid_2">
                    <div class="round-img2">
                        <img class="lazyload" data-src="webImages2/hr.svg" src="webImages2/hr.svg" alt="">
                        <div class="desc2">
                            <h4>CPD Dashboard</h4>
                            <p>Bitesize Verified CPD for you and your team…</p>
                        </div>
                    </div>
                    <div class="round-img2">
                        <img src="webImages2/cpd.svg" alt="">
                        <div class="desc2">
                            <h4>CPD Dashboard</h4>
                            <p>Bitesize Verified CPD for you and your team…</p>
                        </div>
                    </div>


                </div>
                <div class="round-img3">
                    <img src="webImages2/aiomRrounded.svg" alt="">

                </div>
                <div class="grid grid_2">
                    <div class="round-img2">
                        <img src="webImages2/hr.svg" alt="">
                        <div class="desc2">
                            <h4>CPD Dashboard</h4>
                            <p>Bitesize Verified CPD for you and your team…</p>
                        </div>
                    </div>
                    <div class="round-img2">
                        <img src="webImages2/cpd.svg" alt="">
                        <div class="desc2">
                            <h4>CPD Dashboard</h4>
                            <p>Bitesize Verified CPD for you and your team…</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="manage" >
            <div class="">
                <div class="grid grid_2">
                    <div class="image" data-aos="zoom-in-left">
                        <div id="lottie3">

                        </div>
                        <img src="webImages2/preview.webp" alt="">
                    </div>
                    <div class="text" data-aos="zoom-out-right">
                        <h2>Manage everything in one place, promptly!</h2>
                        <p>Manage all your day to day activities with one simple software. Whether it’s updating compliance, completing CPD courses, recruiting staff or calculating annual leave and much more…</p>
                        <a data-fancybox="" href="https://www.youtube.com/watch?v=h2d7maCIOEM" class="btn explore">Explore our platform</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="grid " id="review">
            <div class="block__inner">
                <div class="inner_heading text-center">
                    <h1 class="heading-1">
                        Review Videos
                    </h1>
                </div>
                <div class="inner_main">
                    <div class="grid block1x4">
                        <div class="review-videos review-img-1" data-aos="fade-down">



                            <a data-fancybox href="https://youtu.be/gZ3qrVYCVzY">
                                <div class="details">

                                    <div class="icon">
                                        <img src="webImages2/Group 7037.png" alt="">
                                    </div>

                                    <img src="webImages2/malmin.png" alt="">
                                    <p class="details-txt">Eloise - Wentworth Dental Practice
                                        <!--“My name is Eloise and I'm a practice principal at Windward Dental Practice. So we joined Smart Dental Compliance a couple of weeks ago. We lost our practice manager and we were all really frightened of how we were-->
                                        <!--going to manage everything as a team. But the platform is so easy to use. It's really streamlined and automated, and the girls at Smart Dental have been amazing and they've been so understanding and patient because-->
                                        <!--I am no good at using a computer”-->
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="review-videos review-img-2" data-aos="fade-up">

                            <a data-fancybox href="https://youtu.be/D83hIoz4888">
                                <div class="details">
                                    <div class="icon">
                                        <img src="webImages2/Group 7037.png" alt="">
                                    </div>
                                    <img src="webImages2/new_street_dental_care.png" alt="">
                                    <p class="details-txt"> Clarissa Chen - New Street Dental Care
                                    <!--“Hi, my name is Clarissa and I'm a practice manager at New Street Dental Care and we've been using the all in one management software to manage our staff and practice. The software is totally customizable and tailored-->
                                    <!--    to our practice or your practice. We want it fast. We want it specific daily, weekly e logs for our practice and they were uploaded in minutes. Before this software. Managing the practice was really stressful and-->
                                    <!--    time consuming, but with the all in one management software, I can keep on top of all my compliance CPD courses, team rotas all under one roof.”-->
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="review-videos review-img-3" data-aos="fade-down">

                            <a data-fancybox href="https://youtu.be/5PUVFC7y4J8">
                                <div class="details">
                                    <div class="icon">
                                        <img src="webImages2/Group 7037.png" alt="">
                                    </div>
                                    <img src="webImages2/harley.png" alt="">
                                    <p class="details-txt"> Namrata Patel - Care Dental Group
                                    <!--“Being a dual site manager, it's challenging to be at both practices at the same time. Managing the staff holidays, managing CPD courses becomes really challenging as part of my job. As soon as we signed on to the AIOM-->
                                    <!--    software, the biggest relief was having HR verified CPD courses alongside the compliance all under one platform. I can create ROTAs for both sites and publish them for the team. The staff have more control and can-->
                                    <!--    request and view their holidays”-->
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="review-videos review-img-4" data-aos="fade-down">

                            <a data-fancybox href="https://youtu.be/k8kbFADLBUw">
                                <div class="details">
                                    <div class="icon">
                                        <img src="webImages2/Group 7037.png" alt="">
                                    </div>
                                    <img src="webImages2/maison.png" alt="">
                                    <p class="details-txt"> Alisha Chand - Mansion House Dental Practice
                                    <!--“Hi. My name is Alisha and I'm the practice manager at the Mansion House Dental Practice. We have been using the all in one management software for three years and we just love it. As a single surgery busy practice-->
                                    <!--    manager, it becomes challenging to keep on top of everything the software provides structure and easy automation system to keep on top of everything related to compliance and team management”-->
                                    </p>

                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <div class="standard Trusted" data-aos="fade-down">
            <h1 class="heading-1">
                Trusted by <span>10,000 dental professionals</span> in the UK </h1>
            <div class="grid grid3_ ">

                <div>
                    <img  class="lazyload" data-src="webImages2/serene2.png"  src="webImages2/serene2.png" alt="" data-aos="fade-down">
                </div>
                <div>
                    <img class="lazyload" data-src="webImages2/malmin2.png"  src="webImages2/malmin2.png" alt="" data-aos="fade-up">
                </div>
                <div>
                    <img class="lazyload" data-src="webImages2/almas.png" src="webImages2/almas.png" alt="" data-aos="fade-down">
                </div>
                <div>
                    <img class="lazyload" data-src="webImages2/maison2.png"  src="webImages2/maison2.png" alt="" data-aos="fade-up">
                </div>
                <div>
                    <img class="lazyload" data-src="webImages2/haarly.svg"  src="webImages2/haarly.svg" alt="" data-aos="fade-down">
                </div>

                <div>
                    <img class="lazyload" data-src="webImages2/malmin3_.png"  src="webImages2/malmin3_.png" alt="" data-aos="fade-up">
                </div>

            </div>
        </div>
        <div class="standard">
            <div class="sdc-in-action" data-aos="fade-down">

                <div class="book-a-demo" id="book-a-demo" >
    
                    <video playsinline="" autoplay="" muted="" loop="">
                        <source src="webImages2/AIOM In Action.webm" type="video/webm">
                        Your browser does not support HTML video.
                    </video>

                    <div class="desc">
                        <h1 class="text-center" data-aos="fade-left">Watch SDC in action</h1>
                        <p data-aos="fade-right">Stay organised and prioritise, upcoming events</p>

                        <a data-aos="fade-up" data-fancybox href="https://www.youtube.com/watch?v=h2d7maCIOEM">
                            <img src="webImages2/Group 7037.png" alt="" class="play-button">

                        </a>
                        <?php
                    $login  =  $webClass->userLoginCheck();
                    if(!$login){
                        echo '<a href="'.WEB_URL.'/freeTrial" class="free-trail" target="_blank">Free Trial</a>';
                    }
                    else{
                    }?>
                    </div>

                </div>
            </div>
        </div>

        <div class="Packages" data-aos="fade-up">
            <div class="standard">
                <h2>Packages</h2>
                <div class="swiper mySwiper3">
                    <div class="swiper-wrapper">
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
                                    $banners .='<div class="swiper-slide">
                            <div class="package-main">
                                <div class="package-text">
                                    <h2>'.$title.'
                                    </h2>
                                    <p>'.$text.'</p>
                                </div>
                                <div class="package-image">
                                    <img class="lazyload" data-src="'.$image1.'" src="'.$image1.'" alt="">
                                </div>
                            </div>
                        </div>
';
                                    $bannerscount++;
                                    }
                                    echo $banners;
                                    ?>  
                        
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </div>
        <section class="grid grid-col90" id="replace-complex">
            <div id="lottie7"></div>
            <div class="block__inner">
                <div class="inner_heading text-center">
                    <h1 class="heading-1" data-aos="fade-right">
                        Replace current complex systems with <span>AIOM</span>. Which is simple and easy to use.
                        </h1>
                </div>
                <div class="inner_main">
                    <img src="webImages2/Capture.png" alt="" class="demo-img" data-aos="fade-left">
                </div>



            </div>

        </section>

        <div class="aiom-epert">
            <div class="standard">
                <div class="aiom-main">
                    <div class="aiom-text" data-aos="fade-left" >
                        <h2 >AIOM Experts</h2>
                        <p>
                            Meet the team behind AIOM. Our professional experienced consultants are always there to support you with your compliance and HR activities. You can contact them via phone, email or online chat. 
                        </p>
                    </div>
                    <div class="aiom-image" data-aos="fade-right">
                        <div id="lottie5"></div>
                        <img class="lazyload" data-src="webImages2/aiom-circle.svg"  src="webImages2/aiom-circle.svg" alt="">
                    </div>

                </div>

            </div>
    <div >
            <div class="swiper mySwiper2 ">
                <div class="swiper-wrapper ">
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Sanaya.jpeg" src="./webImages2/team/Sanaya.jpeg" alt=" ">
                                <div class="box-text">
                                    <h4>Vania Rosa </h4>
                                    <span>CQC Registration Manager</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Victoria.jpeg" src="./webImages2/team/Victoria.jpeg" alt=" ">
                                <div class="box-text">
                                    <h4>Victoria Yannagas </h4>
                                    <span>Business Development Manager</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/saba.jpg?v=2" src="./webImages2/team/saba.jpg?v=2" alt=" ">
                                <div class="box-text">
                                    <h4>Saba Arif </h4>
                                    <span>CEO & Founder</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Tiannie.jpeg" src="./webImages2/team/Tiannie.jpeg" alt=" ">
                                <div class="box-text">
                                    <h4>Tiannie Charlesworth
                                    </h4>
                                    <span>Customer Succession Lead</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="swiper-slide ">-->
                    <!--    <div class="box">-->
                    <!--        <div class="box-img">-->
                    <!--            <img class="lazyload" data-src="./webImages2/Jenni.png" src="./webImages2/team/Jenni.png" alt=" ">-->
                    <!--            <div class="box-text">-->
                    <!--                <h4>Jenni Baldwin-->
                    <!--                </h4>-->
                    <!--                <span>Customer Succession Lead</span>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Fauzia.jpeg?v=2" src="./webImages2/team/Fauzia.jpeg?v=2" alt=" ">
                                <div class="box-text">
                                    <h4>Fauzia Wali </h4>
                                    <span>Compliance Consultant</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Anila.jpeg" src="./webImages2/team/Anila.jpeg" alt=" ">
                                <div class="box-text">
                                    <h4>Anila </h4>
                                    <span>Customer Succession Lead</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Catalin.jpeg?v=2" src="./webImages2/team/Catalin.jpeg?v=2" alt=" ">
                                <div class="box-text">
                                    <h4>Catalin Damian </h4>
                                    <span> Software Techinical Support</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Dimitris.jpeg?v=2" src="./webImages2/team/Dimitris.jpeg?v=2" alt=" ">
                                <div class="box-text">
                                    <h4>Dimitri Bezanis </h4>
                                    <span>Software Technical Support</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="box">
                            <div class="box-img">
                                <img class="lazyload" data-src="./webImages2/team/Subhan.jpeg" src="./webImages2/team/Subhan.jpeg" alt=" ">
                                <div class="box-text">
                                    <h4>Subhan Arif </h4>
                                    <span>Technical Engineer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
            </div>
            <a href="https://smartdentalcompliance.com/page-about" class="btn explore">
Explore More Info
</a>
        </div>
        <div class="demo" data-aos="fade-down">
            <div class="standard">
                <div class="demo-main">
                    <div class="sform" data-aos="fade-left">
                        <h2> Book a demo</h2>
                        <form action="" method="post">
                            <?php $functions->setFormToken('bookForm'); ?>   
                           <input type="hidden" id="g-smallBookForm" name="g-bookForm">
                        <input type="hidden" name="action" value="bookForm">
                             <div class="sform-feild"><input type="text" placeholder="Full Name" name="form[full name]"></div>
                            <div class="sform-feild"> <input type="text" placeholder="Email" name="form[email]"></div>
                            <div class="sform-feild"> <input type="text" placeholder="Contact No" name="form[contact no]"></div>
                            <div class="sform-feild"> <input type="text" placeholder="Practice Name" name="form[pracice name]"></div>
                            <button class="btn explore">Request a Demo</button>
                        </form>
                    </div>
                    <div class="simage" data-aos="fade-right">
                        <!--<div id="lottie6"></div>-->
                        <img class="lazyload" data-src="webImages2/laptop.webp" src="webImages2/laptop.webp" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="cards ">
            <div class="standard">
                <div class="grid grid3">
                    <div class="ticker-wrapper-v-image" data-aos="fade-left">
                        <ul class="news-ticker-v-image">
                            <h2>Webinar</h2>
                            <?php 
                            $data=$functions->getwebinar();
                            foreach ($data as $value) {
                                echo'<li>
                                <div class="thumbnail">
                                    
                                        <img src="'.$value['image'].'">
                                        <div class="clear"></div>
                                    
                                </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p>'.$value['heading'].'
                                        </p>
                                        <span>'.$value['presetned_by'].'</span>
                                        <a href="'.WEB_URL.'/page-webinar">Register <img src="webImages2/line.svg" alt=""></a>
                                    </div>
                                </div>
                                <div class="clear"></div>

                            </li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="ticker-wrapper-v-image" data-aos="fade-down">
                        <ul class="news-ticker-v-image">
                            <h2>Free Resources</h2>
                            <?php
                            $data=$functions->freeResource();
                            foreach ($data as $value) {
                            ?>
                            <li>
                                <div class="thumbnail">
                                    <a href="#" target="_blank">
                                        <img src="webImages2/p-file.svg">
                                        <div class="clear"></div>
                                    </a>
                                </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p><?php echo $value['title']?>
                                        </p>
                                        <input type="hidden" value="<?php echo $value['title'] ?>" class="title"/>
                                        <input type="hidden" value="<?php echo $value['id'] ?>" class="file_id"/>
                                        <a href="<?php echo WEB_URL?>/page-free-resources">Download <img src="webImages2/line.svg" alt=""></a>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>

                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="ticker-wrapper-v-image" data-aos="fade-right">
                        <ul class="news-ticker-v-image">
                            <h2>Latest Features On AIOM</h2>

                            <li>
                                <div class="thumbnail">
                                    
                                        <img src="webImages2/l-dashboard.svg">
                                        <div class="clear"></div>
                               
                                </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p>Brand New Dashboard design added
                                        </p>

                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>

                            <li>
                                <div class="thumbnail">
                                 
                                        <img src="webImages2/l-onboarding.svg">
                                        <div class="clear"></div>
                               
                                </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p>New Onboarding Process added
                                        </p>

                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>

                            <li>
                                <div class="thumbnail">
            
                                        <img src="webImages2/l-mock.svg">
                                        <div class="clear"></div>
                                  
                                </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p>New Mock Inspection tool added
                                        </p>

                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>

                            <li>
                                <div class="thumbnail">
                                    
                                        <img src="webImages2/l-reprting.svg">
                                        <div class="clear"></div>
                                     </div>
                                <div class="news-info">

                                    <div class="news-content">
                                        <p>New Reporting tool added
                                        </p>

                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

<?php include('webFooter.php');?>