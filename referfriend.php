<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
 
if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Refer a friend',false);
}

?>
<?php

$pMmsg = '';

$contactAllow = TRUE;
if($contactAllow){

$labelClass = "col-sm-3 padding-0";

$divClass = "col-sm-9";

?>
<div class="referfriend">
<div class="event_details" id="myform">
    
    
    <div class="ecategory">
               
            </div>
            <!-- ecategory -->
    <div class="form-lr">
        <div class="form-left">
           <div class="logo_side">
                            <a href="<?php echo WEB_URL ?>">
                                <div class="logo_img">
                                    <img src="<?php echo WEB_URL ?>/webImages/nav_logo.png" alt="">
                                </div>
                                <!-- logo_img close -->
                                <div class="logo_txt">
                                    <h3>DENTAL COMMUNITY</h3>
                                </div>
                                <!-- logo_txt close -->
                            </a>
                        </div>
                 <!-- <img src="<?php echo WEB_URL ?>/webImages/refer.jpeg" alt=""> -->
            <div class="form_side">
  <h3>
   Refer a Friend and Get a Luxury Hamper and </br> 2-Month Free Subscription added to your contract.   </h3> 
      <h2>The referred practice would get 10% off their subscription.
    </h2>
    <div class="inner_forms">
     <form method="post"  enctype="multipart/form-data" class="main_form">
          <?php $functions->setFormToken('referfriend'); ?>
          <div class="form-group-flex">
                <div class="form-group mb-0">
                    <input class="form-control" type="text" name="form[name]" value="" placeholder="Your Name" autocomplete="off" required>
                    <label for="subject" class="label">Name</label>
                </div>
                 <div class="form-group mb-0">
                    <input class="form-control" type="text" name="form[practicename]" value="" placeholder="Your Practice Name"  autocomplete="off" >
                    <label for="subject" class="label">Practice Name</label>
                </div>
            </div>
                
            <div class="form-group-flex">
                <div class="form-group mb-0">
                    <input class="form-control" type="text" name="form[contact]" value="" placeholder="Your Contact"  autocomplete="off" >
                    <label for="subject" class="label">Contact</label>
                </div>
                    <input class="form-control" type="hidden"   placeholder=" "  autocomplete="" >
                <div class="form-group mb-0">
                    <input class="form-control" type="text" name="form[referPracticeName]" value="" placeholder="Refer Practice Name"  autocomplete="off" >
                    <label for="subject" class="label">Refer Practice Name</label>
                </div>
            </div>
<!-- <hr> -->


                <div class="form-group-flex">
                  <div class="form-group mb-0">
                            <input class="form-control" type="text" name="form[referContact]" value="" placeholder="Refer Contact"  autocomplete="off" >
                            <label for="subject" class="label">Refer Contact</label>
                        </div>


                           <div class="form-group mb-0">
                            
                            <input class="form-control" type="text" name="form[referAddress]" value="" placeholder="Refer Address"  autocomplete="off" >
                            <label for="subject" class="label">Refer Address</label>
                        </div>
                    </div>

                            <input type="hidden"   placeholder=" "  autocomplete="" >

                     
                         <input type="submit" class="submit_class" value="Submit" name="submit" style="display: inline-block;">
               </form>
               </div>
            </div>
            <!-- form_side -->
        </div>
        <!-- form-left -->
    
    </div>
    <!-- form-lr -->
</div>
<!-- event_details -->
</div>
<!-- Referfriend -->

<style type="text/css">.referfriend .form_side h3{

   font-size: 22px;

width: unset;

}

.referfriend .form_side h2{

   

    width: unset;
   font-size: 16px;
    margin: 0 auto 10px;
    color: #f2701d;
    font-weight: 600;
    
}




@media screen and (max-width: 767px) {
 .referfriend .form-group {
    width: 100%;
    max-width: 100%;

 }

 .referfriend .form_side h3 {
 

    font-size: 20px;
   

}


}
 @media screen and (max-width: 461px){
.referfriend .form_side h3 {
    font-size: 14px;
}}



</style>
<?php
}
?>