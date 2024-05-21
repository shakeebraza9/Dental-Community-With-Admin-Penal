<?php 
	include_once('global.php');

	$gallery_pk = '1';

	$sql = "SELECT `album` FROM `gallery` WHERE	 `gallery_pk` = ?";
	$data = $dbF->getRow($sql, array($gallery_pk));
	$name = $data['album'];

	$sql2 = "SELECT `image` FROM `gallery_images` WHERE `gallery_id` = ?";
	$data2 = $dbF->getRows($sql2, array($gallery_pk));

	$slider = "";
	 // var_dump($data2);
	 foreach($data2 as $Key => $val){
	 	$link = !empty($val['image']) ? WEB_URL.'/images/'.$val['image'] : "";
	 		$slider .= '
						<div class="detal_s1 swiper-slide">
                            <img src="'.$link.'" alt="" />
                        </div>
	 		';
	 }
?>

<section class="detal_slider_main">
        <div class="Standard">
            <div class="detal_slider_main_inner">
                <h2><?= $name ?></h2>
                <div class="detal_slider swiper mySwiper1">
                    <div class="detal_slider_main swiper-wrapper">
                    	<?= $slider ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>