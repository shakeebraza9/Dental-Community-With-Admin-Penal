<script>location.replace('smartdentalcompliance.com');</script>
<?php 
include_once("global.php");
global $webClass;
include("header.php");

  $id = htmlspecialchars($_GET['pSlug']);
$sql    =   "SELECT service_heading,service_shrtDesc FROM service where `service_link` = ? ";
$data   =   $dbF->getRow($sql, array($id));

  if($dbF->rowCount>0) {
//print_r($data);
$brand_heading = translateFromSerialize($data['service_heading']);
 $brand_shrtDesc = translateFromSerialize($data['service_shrtDesc']);

?>

<div class="bg_inner" style="background-image: url(webImages/bg-inner.jpg);background-size: cover;">
<div class="standard">
<h1>Training Academy</h1>
<ul>
<li><a href="<?php echo WEB_URL; ?>">Home</a></li>
<li><i class="fas fa-chevron-right"></i></li>
<li><a href="<?php echo WEB_URL; ?>/page-training-academy">Training Academy</a></li>
<li><i class="fas fa-chevron-right"></i></li>
<li><a href="#" class="inner_active"><?php echo $brand_heading; ?></a></li>
</ul>
</div>
</div>


<div class="services">
<div class="standard">
<div class="section1_inner_detail">
<div class="section1_txt">
<?php echo $brand_shrtDesc ?>
</div>
</div>



























<div class="contact">
<div class="standard">



<h1>Apply Online</h1>
<h6>Enquire about: <?php echo $brand_heading; ?></h6>
<div class="contact_inner">
<div class="contact_txt_inquiry">
Please complete all of the fields marked with an asterisk (*) </div>

    <form method="post" name="">
        
        <?php $webClass->setFormToken('SubscribeForm'); ?>

<!--<input type="hidden" name="contactFormSubmitToken" value="5c5021bd2aff3">-->
<input type="text" placeholder="Your Name *" name="subscribeName" required="">
<input type="text" placeholder="Practice *" name="subscribePractice" required="">
<input type="email" placeholder="Your Email *" name="subscribeEmail" required="">
<input type="phone" placeholder="Your Phone *" name="subscribePhone" required="">
<textarea placeholder="Optional Comments" name="subscribemess"></textarea>
<!--<label class="chk">Compliance Services-->
<!--<input type="checkbox" name="form[Compliance Services]" value="Yes"> <span class="checkmark"></span> </label>-->
<!--<label class="chk">Training Courses-->
<!--<input type="checkbox" name="form[Training Courses]" value="Yes"> <span class="checkmark"></span> </label>-->
<!--<label class="chk">Business Consultancy-->
<!--<input type="checkbox" name="form[Business Consultancy]" value="Yes"> <span class="checkmark"></span> </label>-->
<!--<label class="chk">New Dental Practice Package-->
<!--<input type="checkbox" name="form[New Dental Practice Package]" value="Yes"> <span class="checkmark"></span> </label>-->
<!--<img src="captcha.php?5c5021bd2b041" style="margin: 10px 0;">-->

<!--<input type="text" name="code" class="name_class fx" placeholder="captcha" required="required">-->
<input type="submit" name="subscribeEmailButton" value="Enquire" class="submit_class">



 </form>

</div>
<!-- contact_inner -->
</div>
</div>





















</div>
</div>

<?php }
else{echo "<br><br><br><br><br><br><br><br><br><br><br>No link Found !<br><br><br><br><br><br><br><br><br><br><br>";
} ?>
<?php
include("footer.php");?>
