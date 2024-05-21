<?php 
ob_start();
include("global.php");
global $webClass;
 $id = $_GET['pSlug'];
$sql    =   "SELECT * FROM brands where `id` = ? ";
$data   =   $dbF->getRow($sql, array($id));

  if($dbF->rowCount>0) {
//print_r($data);
$brand_shrtDesc = translateFromSerialize($data['brand_shrtDesc']);
$brand_heading = translateFromSerialize($data['brand_heading']);
$brand_headings = translateFromSerialize($data['brand_headings']);
$images = WEB_URL."/images/".$data['images'];
?>

<div class="product">
<div class="product_img">
<img src="<?php echo $images ?>" alt="">
</div>
<div class="product_title">
<div class="product_inner">
<h1><?php echo $brand_heading ?></h1>
<h2><?php echo $brand_headings ?></h2>
<div class="product_txt">
<?php echo $brand_shrtDesc ?>
</div>
</div>
</div>
</div>
<!-- product -->

<?php }
else{echo "<br><br><br><br><br><br><br><br><br><br><br>No link Found !<br><br><br><br><br><br><br><br><br><br><br>";
} ?>

<?php return ob_get_clean(); ?>