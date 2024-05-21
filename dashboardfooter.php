
</div>
<footer>
<div class="footer_bottom_side">
                <div class="standard">
                    <div class="dashboard_footer">
                        <div class="tag_footer">
                            © Copyright <?php echo date('Y')?>
                            <a href="<?php echo WEB_URL?>">
                                Dental Community
                            </a>
                            All Rights Reserved.
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
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
    <script src="<?php echo WEB_URL?>/js/jquery.form.js?magics=<?php echo filemtime('./js/jquery.form.js') ?>"></script>
    <script src="<?php echo WEB_URL?>/js/jquery.form.js"></script>
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
    <!-- <script src="https://smartdentalcompliance.com/js/functions.js?magics=1674478464"></script> -->
    <script src="<?php echo WEB_URL?>/js/functions.js?magics=<?php echo filemtime('./js/functions.js') ?>"></script>
    <script src="<?php echo WEB_URL?>/js/script.js"></script>
    <?php 

    if(strpos($_SERVER['SCRIPT_NAME'], 'resources') || strpos($_SERVER['SCRIPT_NAME'], 'post_all')){ 

    ?>
    <script src="<?php echo WEB_URL?>/ckeditor/ckeditor.js"></script>
    <script src="<?php echo WEB_URL?>/ckeditor/adapters/jquery.js"></script>
    <?php } ?>
    <script>
        $(window).load(function () {
            var $grid = $(".grid").isotope({
                // options
            });
        });
    </script>
    <script type="text/javascript" src="js/jquery.format-1.1.js"></script>

    <script type="text/javascript" src="js/jquery.stickynote.js"></script>
    <script type="text/javascript">
        var currentPage = 0;
        $(function () {
            function createNote() { }
            $.fn.stickynote.beforeDelete = function (id) {
                return confirm("Are you OK?!");
            };
            function getNotes() {
                $.get(
                    "notes.php",
                    {
                        page: currentPage,
                    },
                    function (data) {
                        console.log(data.results);
                        currentPage++;
                        $(data.results).each(function () {
                            console.log(this.message);

                            $("#contentSticky").stickynote({
                                text: this.message,
                                author: this.author,
                                time: this.time,
                                id: this.id,
                                user: this.user,
                            });
                        });
                    },
                    "json"
                );
            }
        });
    </script>

    <script>
        // if ("serviceWorker" in navigator) {
        //     navigator.serviceWorker
        //         .register("pwa-sw0123.js?v=v4")
        //         .then((reg) => {
        //             console.log("SW Reg.");
        //         })
        //         .catch((err) => {
        //             console.error(err);
        //         });
        // }

        window.addEventListener("load", function () {
            function updateOnlineStatus(event) {
                var condition = navigator.onLine ? "Live" : "offline";
                if (condition == "offline") {
                    $(".offline").slideDown(300);
                } else {
                    $(".offline").slideUp(300);
                }
            }

            window.addEventListener("online", updateOnlineStatus);
            window.addEventListener("offline", updateOnlineStatus);
        });

        $(function () {
            $("#news").ulslide({
                height: 95,
                effect: {
                    type: "carousel", // slide or fade
                    axis: "y", // x, y
                    showCount: 6,
                    distance: 0,
                },
                pager: "#slide-pager2 a",
                nextButton: ".right_btn3",
                prevButton: ".left_btn3",
                duration: 1000,
                mousewheel: false,
                autoslide: 800,
                easing: "easeInOutBack",
            });
        });
        // newss
        $(window).load(function () {
            var $container = $(".grid");
            $container.isotope();

            $(".blog_fill ul li").on("click", function () {
                $(".blog_fill ul li").removeClass("select-cat");
                $(this).addClass("select-cat");
                var selector = $(this).attr("data-filter");
                $(".grid").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: "linear",
                        queue: false,
                    },
                });
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        // all1
        $(".all9").owlCarousel({
            loop: false,
            items: 1,
            margin: 0,
            nav: true,
            autoHeight: true,
            URLhashListener: true,
            onTranslate: function (event) {
                var currentSlide, player, command;

                currentSlide = $(".owl-item.active");

                player = currentSlide.find(".flex-video iframe").get(0);

                command = {
                    event: "command",
                    func: "pauseVideo",
                };

                if (player != undefined) {
                    player.contentWindow.postMessage(JSON.stringify(command), "*");
                }
            },
        });
    </script>
    <script type="text/javascript">
        $(window).load(function () {
            $(".text_advan").hide();
            $(".text_inter").hide();
            $(".begin").addClass("active_");
        });

        $(window).load(function () {
            $(".begin").click(function () {
                $(".text_begin").show();
                $(".text_inter").hide();
                $(".text_advan").hide();
                $(".begin").addClass("active_");
                $(".advan").removeClass("active_");
                $(".inter").removeClass("active_");
            });
            $(".inter").click(function () {
                $(".text_inter").show();
                $(".text_advan").hide();
                $(".text_begin").hide();
                $(".begin").removeClass("active_");
                $(".inter").addClass("active_");
                $(".advan").removeClass("active_");
            });
            $(".advan").click(function () {
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
            $("#banner").ulslide({
                effect: {
                    type: "slide", // slide or fade
                    axis: "x", // x, y
                    showCount: 0,
                    distance: 20,
                },
                duration: 900,
                nextButton: ".btn_left",
                prevButton: ".btn_right",
                mousewheel: false,
                autoslide: 3000,
                animateOut: "easeOut",
                animateIn: "easeIn",
                direction: "rtl",
            });
            $("#banner_").ulslide({
                effect: {
                    type: "crossfade", // slide or fade
                    axis: "x", // x, y
                    showCount: 0,

                    distance: 20,
                },
                duration: 900,
                nextButton: ".btn_left",
                prevButton: ".btn_right",
                mousewheel: false,
                autoslide: 3000,
                animateOut: "easeOut",
                animateIn: "easeIn",
            });
        });
        // banner

        const actualBtn = document.getElementById("upload");

        const fileChosen = document.getElementById("file-chosen");
        if( actualBtn !==  null){
            
        actualBtn.addEventListener("change", function(){
          fileChosen.textContent = this.files[0].name;
        });
        }
    </script>

</body>

</html>