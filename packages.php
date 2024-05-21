<?php
ob_start();
include_once("global.php");
global $webClass;

$sql ="SELECT * FROM `tabs` WHERE publish = '1' ORDER BY sort ASC";
$data = $dbF->getRows($sql);
// $dbF->prnt($data);
foreach($data as $key => $val){
$title = ( isset($val['tabs_heading'])  && !empty($val['tabs_heading']) ) ? getTextFromSerializeArray($val['tabs_heading']) : "";
$desc = ( isset($val['dsc']) && !empty($val['dsc']) ) ? getTextFromSerializeArray($val['dsc']) : "";
$button = ( isset($val['tabs_headings']) && !empty($val['tabs_headings']) ) ? getTextFromSerializeArray($val['tabs_headings']) : "";
$button_link = ( isset($val['tabs_link']) && !empty($val['tabs_link']) ) ? $val['tabs_link'] : "";
$img = ( isset($val['image']) && !empty($val['image']) ) ? WEB_URL.'/images/'.$val['image'] : "";
$i = $key+1;
?>

  <div class="package_container">

  			<?php if($i%2 != 0){ ?>
				<div class="package_img">
                	<img src="<?= $img ?>" alt="">
            	</div>
  			<?php } ?>
            
            <div class="package_content">
                <h2><?= $title  ?></h2>
               	<?= $desc  ?>
                <div class="department-choose-btn package-btn">
                    <a href="<?= $button_link  ?>" class="hvr-bounce-to-right ">
                       	<?= $button  ?>
                    </a>
                </div>
            </div>

            <?php if($i%2 == 0){ ?>
				<div class="package_img">
                	<img src="<?= $img ?>" alt="">
            	</div>
  			<?php } ?>

        </div>
	
<?php 
}
return ob_get_clean(); 
?>