<?php 
include_once('global.php');
$facebook = $functions->ibms_setting('Facebook');
$twiter = $functions->ibms_setting('Twitter');
$instagram = $functions->ibms_setting('Instagram');
$google = $functions->ibms_setting('Google');


$css = false;

$mainMenu = $menuClass->menuTypeSingle('footer_menu');
$innerUl = ''; 
$innerU2 = '';
$menuName = array();

foreach ($mainMenu as $val) {
    $menuId = $val['id'];
    $mName = $val['name'];
    $menuName[] = $mName; 
}


// explore menu 1
$mainMenu2 = $menuClass->menuTypeSingle('footer_menu', 6);
if (!empty($mainMenu2)) {
    $innerUl .= '<ul>';
    foreach ($mainMenu2 as $val2) {
        $innerUl3 = '';
        $text = ($val2['name']);
        $menuId = $val2['id'];
        $link = $val2['link'];
        $mainMenu3 = $menuClass->menuTypeSingle('footer_menu', $menuId);
        // count the inner level 3 lis
        $innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
        $innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
        if ( $innerUl3count > 0 ) {
        }
        $innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
        $innerUl .= '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl3 . '</li>';
    }
    $innerUl .= "</ul><!--2nd array End-->";
}

// explore menu 2
$mainMenu3 = $menuClass->menuTypeSingle('footer_menu', 12);
if (!empty($mainMenu3)) {
    $innerU2 .= '<ul>';
    foreach ($mainMenu3 as $val2) {
        $innerUl4 = '';
        $text = ($val2['name']);
        $menuId = $val2['id'];
        $link = $val2['link'];
        $mainMenu4 = $menuClass->menuTypeSingle('footer_menu', $menuId);
        // count the inner level 3 lis
        $innerUl4count = ( $mainMenu4 == false ? 0 : count($mainMenu4) ) ;
        $innerUl4 .= ( $innerUl4count > 0 ) ? '<ul>' : '';
        if ( $innerUl4count > 0 ) {
        }
        $innerUl4 .= ( $innerUl4count > 0 ) ? '</ul><!--3rd array End-->' : '';
        $innerU2 .= '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl3 . '</li>';
    }
    $innerU2 .= "</ul><!--2nd array End-->";
}

$email =  $functions->ibms_setting('Email');
$phone =  $functions->ibms_setting('Phone');
$address =  $functions->ibms_setting('address');

$box12 =  $webClass->getBox('box12');
?>


            <footer>
    <div class="footer_wrapper">
        <div class="footer_inner">
            <div class="Standard">
                <div class="footer_body">
                    <div class="footer_content">
                        <div class="logo_img">
                            <img src="webImages/nav_logo.png" alt="Logo" />
                            <p class="footer_text">
                                Welcome to Dental Community Compliance
                            </p>
                        </div>
                        
                        <div class="social_icons_list">
                            <a href="<?= $facebook ?>"><i class="fa-brands fa-square-facebook facebook"></i></a>
                            <a href="<?= $twiter ?>"><i class="fa-brands fa-twitter twitter"></i></a>
                            <a href="<?= $instagram ?>"><i class="fa-brands fa-instagram linked"></i></a>
                            <a href="<?= $google ?>"><i class="fa-brands fa-linkedin-in instagram"></i></a>
                        </div>
                    </div>
                    <div class="explore">
                        <h6><?= $menuName[0] ?></h6>
                        <div class="links_container">
                            <div class="links_01">
                                <?= $innerUl ?> 
                            </div>
                            <div class="links_02">
                                <?= $innerU2 ?> 
                            </div>
                        </div>
                    </div>
                    <div class="address">
                        <h6>Contact</h6>
                        <a href="" class="e_mail_address">
                            <span class="icons_color">
                                <ion-icon name="location-sharp" class="icons_design"></ion-icon> 
                            </span><?= $address ?></a>

                            <a href="mailto:<?= $email ?>" class="e_mail_address">
                                <span class="icons_color">
                                    <ion-icon name="mail-open-outline" class="icons_design"></ion-icon>
                                </span>
                                <?= $email ?>
                            </a>
                            <a href="tel:<?= $phone ?>" class="e_mail_address">
                                <span class="icons_color">
                                    <ion-icon name="call-outline" class="icons_design"></ion-icon> </span>
                                    <?= $phone ?>
                                </a>
                            </div>
                            <div class="news_letter">
                                <?= $box12['text'] ?>
                                <!-- <img src="webImages/osha.png" alt="" /> -->
                                <!-- <img src="webImages/hipaa.png" alt="" /> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="footer_last Standard">
                <div class="copyright">
                    <h2>

                       &#169; <?php echo date('Y')?> <span><a href="<?php echo WEB_URL ?>">Dental Community</a></span> All
                       Rights Revserved.
                   </h2>
               </div>
               
               <div class="imedia">
                            <a href="http://imedia.com.pk/" target="_blank" title="Karachi Web Designing Company"
                                class="design_develop">Developed by:
                            </a>
                            <a href="http://imedia.com.pk/" target="_blank" title="Web Designing Company Pakistan"><img
                                    src="webImages/imedia.png" alt="" />
                            </a>
                            <div class="m_text">
                                <a href="http://imedia.com.pk/" target="_blank"
                                    title="Website Design by Interactive Media">Interactive Media</a>
                                <a href="http://imediaintl.com/" target="_blank"
                                    title="International Web Development Company" class="digital_media">DIGITAL MEDIA ON
                                    DEMAND Globally</a>
                            </div>
                        </div>
               


               <?php //echo $webClass->ourLogo(); ?>
           </div>
       </footer>
       </div>
   </body>

   <!-- AOS -->
   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

   <!-- Swiper Script -->

   <script src="<?php echo WEB_URL .'/js/swiper.js?magic='. filemtime('./js/swiper.js') ?>"></script>
   <script src="<?php echo WEB_URL .'/js/WOW.js?magic='. filemtime('./js/WOW.js') ?>"></script>
   <!-- Initialize Swiper -->
   <script src="<?php echo WEB_URL .'/js/jquery.js?magic='. filemtime('./js/jquery.js') ?>"></script>
   <script src="<?php echo WEB_URL .'/js/jquery.ui.js?magic='. filemtime('./js/jquery.ui.js') ?>"></script>
   <script src="<?php echo WEB_URL .'/js/mmenu.min.all.js?magic='. filemtime('./js/mmenu.min.all.js') ?>"></script>
   <script src="<?php echo WEB_URL .'/js/main.js?magic='. filemtime('./js/main.js') ?>"></script>
   <script src="<?php echo WEB_URL?>/ckeditor/ckeditor.js"></script>
   <script src="<?php echo WEB_URL?>/ckeditor/adapters/jquery.js"></script>

   </html>