<?php
ob_start();
include_once("global.php");
global $webClass, $dbF;
?>

           
        
        <div class="standard">
<?php 
$sql    = "SELECT * FROM tabs WHERE publish = ? ORDER BY `sort` ASC ";
$data   =  $functions->dbF->getRows($sql, array('1'));

$temp = '';
foreach($data as $key=>$val){
$id = $val['id'];
$heading        = translateFromSerialize($val['tabs_heading']);
$tabs_headings  = translateFromSerialize($val['tabs_headings']);
$dsc            = translateFromSerialize($val['dsc']);
$tabs_shrtDesc  = translateFromSerialize($val['tabs_shrtDesc']);
$link           = $val['tabs_link'];
$image          = WEB_URL."/images/".($val['image']);

if ($key % 2 == 0) {
?>
        
             <div class="service-main">
                <div class="service-image">
                    <img src="<?php echo $image?>" alt="">
                </div>
                <div class="service-text">
                    <h2><?php echo $heading?>
                    </h2>
                    <p><?php echo $dsc?>
                    </p>
                    <a href="<?php echo WEB_URL."/page-shop"?>">
                    <button class="btn book">Book Now</button></a>
                </div>

            </div>
<?php
}else{
?>
<div class="service-main">

                <div class="service-text">
                    <h2><?php echo $heading?>
                    </h2>
                    <p><?php echo $dsc?></p>
                    <a href="<?php echo WEB_URL."/page-shop"?>">
                    <button class="btn book">Book Now</button></a>
                </div>
                <div class="service-image">
                    <img src="<?php echo $image?>" alt="">
                </div>
            </div>
        
<?php
}
}
?>

  
        </div>

<?php
return ob_get_clean(); ?>