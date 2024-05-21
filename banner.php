<?php
	include_once('global.php');
	$box2 = $webClass->getBox('box2');

	$bannersData    =   $webClass->web_banners();
	$banners = '';
	$banners1 = '';
	$bannerscount = 1;
	foreach($bannersData as $val){
		$title  =   $val['title'];
		$text   =   $val['text'];
		$link   =   $val['link'];
		$image  =   $val['layer0'];
		$image1  =   $val['layer1'];
		$image2  =   $val['layer2'];
		$image3  =   $val['layer3'];
		$banners .= '

				<div class="swiper-slide main_banner_slider">
                        <img src="'.$image.'" alt="" />
                    </div>


';
}
if(!isset($_SERVER['REDIRECT_QUERY_STRING'])){
?>

 <div class="main-swiper">
            <div class="swiper1">
                <div class="swiper-wrapper">
                	<?= $banners ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        
        <section class="main_section_1">
            <div class="sticky_banne">
                <div class="main_sectin_contain">
                    <img src="<?= $box2['image'] ?>" alt="" class="animate__animated animate__backInDown" />
                    <h1 class="animate__animated animate__bounceInLeft">
                        <?= $box2['heading2'] ?>
                    </h1>
                    <!-- <button>Learn More</button> -->
                    <button class="cssbuttons-io-button animate__animated animate__backInUp">
                    	<a href="<?= $box2['link'] ?>">
                        <?= $box2['linkText'] ?>
	                        <div class="icon">
	                            <img src="<?= WEB_URL ?>/webImages/main_btn_img.svg" alt="" style="width: 20px" />
	                        </div>
                    	</a>
                    </button>
                </div>
            </div>
        </section>


<?php } ?>