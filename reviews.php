<?php 

ob_start();
global $dbF, $webClass;

?>
<?php $getTestiMonial = $webClass->getTestiMonial();  ?> 
<div class="inner_content">
    <div class="col14 wow fadeInUp">
        <div class="standard">
            <div class="review_">
                <div class="all9 owl-carousel owl-theme">

                     <?php echo $getTestiMonial['video']; ?>
                    <!-- <div class="item" data-hash="2">
                        <div class="flex-video"><iframe src="https://www.youtube.com/embed/J17CO13geV0?start=60&enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation"></iframe>
                             Make sure to enable the API by appending the "&enablejsapi=1" parameter onto the URL. -->
                    <!-- </div>
                    </div> -->
                     
                </div>
                <div class="review_bot">
                    <ul>
                    <?php echo $getTestiMonial['image']; ?>
                        <!-- <li>
                            <a href="#1">
                                <img src="webImages/rev.png" alt="">
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <!-- Review close -->
        </div>
        <!-- standard close -->
    </div>
    <br>
    <br>
    <br>
</div>
<?php return ob_get_clean(); ?>