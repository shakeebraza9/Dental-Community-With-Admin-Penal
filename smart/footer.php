<?php
global $webClass;
global $functions;
global $_e;
global $webClass;
global $db;
$version = '19';
//No Need to define global it is just for PHPstrom suggestion list...
// if (($_SESSION['onbordingStatus'] > 6 ) || ($_SESSION['onbordingPracticeStatus'] > 4 )) {

?>
<div class="col10 wow fadeInUp">
   <div class="standard">
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

     



        <div class="soc_ico">          <a href="<?php echo $functions->ibms_setting('Facebook'); ?>" target="_blank">
                <div class="soc fb hvr-pop"></div>
                <!-- soc close -->
            </a>
            <a href="<?php echo $functions->ibms_setting('Twitter'); ?>" target="_blank">
                <div class="soc tw hvr-pop"></div>
                <!-- soc close -->
            </a>
            <a href="<?php echo $functions->ibms_setting('Linkedin'); ?>" target="_blank">
                <div class="soc in hvr-pop"></div>
                <!-- soc close -->
            </a>
            <a href="<?php echo $functions->ibms_setting('Instagram'); ?>" target="_blank">
                <div class="soc ins hvr-pop"></div>
                <!-- soc close -->
            <!--</a>-->
            <!--<a href="<?php echo $functions->ibms_setting('youtube'); ?>" target="_blank">-->
            <!--    <div class="soc ins hvr-pop"></div>-->
                <!-- soc close -->
            <!--</a>-->
        </div>
        <!-- soc_ico close -->
    </div><!-- standard close -->
</div><!-- col10 close -->
<div class="col11 wow fadeInDown">
</div><!-- col11 close -->
<?php 
// }
 ?>
</div>
<!-- index_content close -->
<div class="whatsapp"><a href="https://api.whatsapp.com/send?phone=<?php echo $functions->ibms_setting('whatsapp'); ?>" target="_blank">
    <img src="/webImages/whatsapp.webp" width="50" alt="whatsapp"></a></div>
    
    <div class="whatsapp" style="bottom: 50px;" onclick=" window.open('/liveChat','',' scrollbars=yes,menubar=no,width=450,height=650, resizable=yes,toolbar=no,location=no,status=no')">
<img src="/webImages/chat-bubble.png" width="50" alt="whatsapp"></div>
<footer>
    <div class="footer_side wow fadeInUp">
         
         
        <div class="standard">
            <div class="footer_left">
                <div class="logo_side">
                    <a href="<?php echo WEB_URL ?>">
                        <div class="logo_img">
                            <img src="<?php echo WEB_URL ?>/webImages/logo.png?magic=<?php echo rand();?>" alt="">
                        </div><!-- logo_img close -->
                        <div class="logo_txt">
                            <h3>SMART DENTAL</h3>
                            <h6>COMPLIANCE & TRAINING</h6>
                        </div><!-- logo_txt close -->
                    </a>
                </div><!-- logo_side close -->
                <ul>
                    <li>
                        <h6>Email:</h6>
                        <a href="mailto:info@smartdentalcompliance.com">
                  info@smartdentalcompliance.com</a>
                    </li>
                    <li>
                        <h6>Call Us:</h6>
                        <?php $box16 = $webClass->getBox('box16'); ?>
                        <a href="tel:+<?php echo $box16['heading2'] ?>">
                            <?php echo $box16['heading2'] ?></a>
                    </li>
                </ul>
               <?php  
          $activeLink = pageLink(false);
                        $activeLink;
                     if ($activeLink ==  WEB_URL.'/index' || $activeLink ==  WEB_URL.'/'  ) {?>
<?php } ?>
<img class="fatesIMG" src="<?php echo WEB_URL ?>/webImages/fastest-growing.png?magic=0" style="bottom: 15px;position: fixed;width: 233px;left: 20px;">
            </div><!-- footer_left close -->
            
            <div class="footer_right">
                <?php 
##### RESPONSIVE MAIN MENU
$css = false;
$mainMenu = $menuClass->menuTypeSingle('footer_menu');
foreach ($mainMenu as $val) {
$insideActive = false;
$innerUl = '';
$menuId = $val['id'];
// $text = ($val['name']);
// $link = $val['link'];
$mainMenu2 = $menuClass->menuTypeSingle('footer_menu', $menuId);
if (!empty($mainMenu2)) {
$innerUl .= '<ul>';
foreach ($mainMenu2 as $val2) {
$innerUl3 = '';
$text = ($val2['name']);
// $menuId = $val2['id'];
$link = $val2['link'];
// $mainMenu3 = $menuClass->menuTypeSingle('footer_menu', $menuId);
# count the inner level 3 lis
// $innerUl3count = ( $mainMenu3 == false ? 0 : count($mainMenu3) ) ;
// $innerUl3 .= ( $innerUl3count > 0 ) ? '<ul>' : '';
// if ( $innerUl3count > 0 ) {
// }
// $innerUl3 .= ( $innerUl3count > 0 ) ? '</ul><!--3rd array End-->' : '';
$innerUl .= '<li><a href="' . $link . '">' . $text . '</a>' . $innerUl3 . '</li>';
}
$innerUl .= "</ul><!--2nd array End-->";
}
$text = ($val['name']);
// $link = $val['link'];
echo '<div class="footer_right_box">
      <h3>' . $text . '</h3>' . $innerUl . '</div><!-- footer_right_box close -->';
}
?>
                <div class="footer_right_box">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Technical Support</a></li>
                        <li><a href="#"><img src="webImages/8.jpg" alt="" class="hvr-pop"></a></li>
                        <li><a href="#">Registered with the ICO </a></li>
                    </ul>
                </div><!-- footer_right_box close -->
            </div><!-- footer_right close -->

                        <div class="new-popup-bottom">
                            <p style="color: gray;">
This site is protected by reCAPTCHA and the Google
    <a href="https://policies.google.com/privacy" style="color: gray;" target="_blank">Privacy Policy</a> and
    <a href="https://policies.google.com/terms" style="color: gray;" target="_blank">Terms of Service</a> apply.
</p>
</div>




        </div><!-- standard close -->
    </div><!-- footer_side close -->


    <div class="footer_bottom_side">
        <div class="standard">
            <div class="tag_footer">
                © Copyright 2019 - <?php echo date('Y')?> <a href="<?php echo WEB_URL ?>"> Smart Dental Compliance </a> All Rights Reserved.
            </div>
            <!-- tag_footer close -->
            <?php echo $webClass->ourLogo(); ?>








        </div>
        <!-- standard close -->


    </div>
    <!-- footer_bottom_side close -->
</footer>
</div>
<!-- main_container close -->

<script src="<?php echo WEB_URL?>/js/jquery.form.js?magics=<?php echo filemtime('./js/jquery.form.js') ?>"></script>

<script src="<?php echo WEB_URL?>/js/bootstrap.min.js"></script>
<script src="<?php echo WEB_URL?>/js/jquery.ulslide.js"></script>
<script src="<?php echo WEB_URL?>/js/jquery.easing.js"></script>
<script src="<?php echo WEB_URL?>/js/mmenu.min.all.js"></script>
<script src="<?php echo WEB_URL?>/js/wow.min.js"></script>
<script src="<?php echo WEB_URL?>/js/jquery_ui.js"></script>
<script src="<?php echo WEB_URL?>/js/jquery-ui-timepicker.js"></script>
<script src="<?php echo WEB_URL?>/js/jquery.fancybox.js"></script>
<script src="<?php echo WEB_URL?>/js/vmenuModule.js"></script>
<script src="<?php echo WEB_URL?>/js/product.php"></script>
<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'qr-code')){
?>
<script src="<?php echo WEB_URL?>/js/qrcode.min.js"></script>
<?php } ?>
<script src="<?php echo WEB_URL?>/js/isotope.pkgd.js"></script>
<script src="<?php echo WEB_URL?>/js/owl.carousel.js"></script>

<script src="<?php echo WEB_URL?>/js/functions.js?magics=<?php echo filemtime('./js/functions.js') ?>"></script>
<?php 

if(strpos($_SERVER['SCRIPT_NAME'], 'resources') || strpos($_SERVER['SCRIPT_NAME'], 'post_all')){ 

?>
<script src="<?php echo WEB_URL?>/ckeditor/ckeditor.js"></script>
<script src="<?php echo WEB_URL?>/ckeditor/adapters/jquery.js"></script>
<?php } ?>
<script>
  $(window).load(function() {
            var $grid = $('.grid').isotope({
              // options
            });

            });
    </script>
    <script type="text/javascript" src="<?php echo WEB_URL ?>/js/jquery.format-1.1.js"></script>
    <?php 
$login = $webClass->userLoginCheck();
    
    if($login){?>
    
 <!-- sticky Noter -->

    <script type="text/javascript" src="<?php echo WEB_URL ?>/js/jquery.stickynote.js"></script>
     <script type="text/javascript">
        var currentPage = 0;
        $(function() {

            

            function createNote() {
            }
            $.fn.stickynote.beforeDelete = function(id) {
                return confirm("Are you OK?!");
            }
            function getNotes() {
                $.get('notes.php', {
                    page: currentPage
                },function(data) {
                console.log(data.results);
                    currentPage++;
                    $(data.results).each(function(){

                      console.log(this.message);

                        $('#contentSticky').stickynote({
                            text: this.message,
                            author: this.author,
                            time: this.time,
                            id: this.id, 
                            user: this.user
                            



                        });
                    });
                }, 'json');


            }

            $(document).ready(function() {
 
           <?php 
           $user = $_SESSION['webUser']['id'];
    $sqls = "SELECT * FROM `notes` WHERE `user` = '$user'";
        $datas = $dbF->getRows($sqls);
            foreach (@$datas as $key => $value) {
                     
                ?>   


                $('.contentSticky').stickynote({

                            text: `<?php echo $value['message'] ?>`,
                            author: '<?php echo $value['author']   ?>',
                            time: '<?php echo date('Y-m-d',strtotime($value['time']))    ?>',
                            user: '<?php echo $value['user']   //$functions->UserName($value['user']) ?>',
                            id:  '<?php echo $value['id'] ?>'             
                            //id: '2',             
                        });
             
<?php } ?>

            });


            $('#more_note').click(function(){
                getNotes();
            });
            $('#create_note').click(function(){
                $('#contentSticky').stickynote({
                    author: 'Smart Dental Compliance',
                    user: <?php echo $_SESSION['webUser']['id'];  //$functions->UserName($value['user']) ?>,   
                });
            });
          



        });


       






    </script>
<!-- sticky Noter -->
<?php   
 }else{}?>
<?php //if($_SESSION['webUser']['login']=="1"){?>
    <script>
    // console.log(navigator);
    //   if ("serviceWorker" in navigator) {
        // if(navigator.onLine){
        //   navigator.serviceWorker.getRegistrations().then(function(registrations) {
        //         for(let registration of registrations) {
        //             console.log(registrations)
        //             registration.unregister()
        //         }}).catch(function(err) {
        //             console.log('Service Worker unregistration failed: ', err);
        //         });
        
        // navigator.serviceWorker.register("./pwa-sw0123.js?v=<?php //echo $version; ?>");
    //   }
    </script>
    <?php //}else{ ?>
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
    <?php //} ?>

  
<script>

window.addEventListener('load', function() {
    function updateOnlineStatus(event) {
        var condition = navigator.onLine ? "Live" : "offline";
        if (condition == "offline") {
            $('.offline').slideDown(300);
        } else {
            $('.offline').slideUp(300);
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
});

 $(function() {
        $('#news').ulslide({
            height: 95,
            effect: {
                type: 'carousel', // slide or fade
                axis: 'y', // x, y
                showCount: 6,
                distance: 0
            },
            pager: '#slide-pager2 a',
            nextButton: '.right_btn3',
            prevButton: '.left_btn3',
            duration: 1000,
            mousewheel: false,
            autoslide: 800,
            easing: 'easeInOutBack'

        });
    });
    // newss
    $(window).load(function() {
        var $container = $('.grid');
        $container.isotope();

        $('.blog_fill ul li').on("click", function() {
            $(".blog_fill ul li").removeClass("select-cat");
            $(this).addClass("select-cat");
            var selector = $(this).attr('data-filter');
            $(".grid").isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });
    });
   
</script>

<script type="text/javascript">
    // all1
      $('.all9').owlCarousel({
        loop: false,
        items: 1,
        margin: 0,
        nav: true,
        autoHeight: true,
        URLhashListener: true,
        onTranslate: function(event) {

            var currentSlide, player, command;

            currentSlide = $('.owl-item.active');

            player = currentSlide.find(".flex-video iframe").get(0);

            command = {
                "event": "command",
                "func": "pauseVideo"
            };

            if (player != undefined) {
                player.contentWindow.postMessage(JSON.stringify(command), "*");

            }

        }
    });



    </script>

    <script type="text/javascript">
    $(window).load(function() {
        $(".text_advan").hide();
        $(".text_inter").hide();
        $(".begin").addClass("active_");
    });

    $(window).load(function() {
        $(".begin").click(function() {
            $(".text_begin").show();
            $(".text_inter").hide();
            $(".text_advan").hide();
            $(".begin").addClass("active_");
            $(".advan").removeClass("active_");
            $(".inter").removeClass("active_");
        });
        $(".inter").click(function() {
            $(".text_inter").show();
            $(".text_advan").hide();
            $(".text_begin").hide();
            $(".begin").removeClass("active_");
            $(".inter").addClass("active_");
            $(".advan").removeClass("active_");
        });
        $(".advan").click(function() {
            $(".text_advan").show();
            $(".text_inter").hide();
            $(".text_begin").hide();
            $(".begin").removeClass("active_");
            $(".inter").removeClass("active_");
            $(".advan").addClass("active_");
        });
    });
    </script>

    <script type="text/javascript">
    $(function() {
        $('#banner').ulslide({
            effect: {
                type: 'slide', // slide or fade
                axis: 'x', // x, y
                showCount: 0,
                distance: 20
            },
            duration: 900,
            nextButton: '.btn_left',
            prevButton: '.btn_right',
            mousewheel: false,
            autoslide: 3000,
            animateOut: 'easeOut',
            animateIn: 'easeIn',
            direction: 'rtl',
        });
        $('#banner_').ulslide({
            effect: {
                type: 'crossfade', // slide or fade
                axis: 'x', // x, y
                showCount: 0,
                distance: 20
            },
            duration: 900,
            nextButton: '.btn_left',
            prevButton: '.btn_right',
            mousewheel: false,
            autoslide: 3000,
            animateOut: 'easeOut',
            animateIn: 'easeIn'
        });
    });
    // banner

    
 



    </script>

</body>
</html>