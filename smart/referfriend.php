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
                                    <img src="<?php echo WEB_URL ?>/webImages/logo.png?magic=01" alt="">
                                </div>
                                <!-- logo_img close -->
                                <div class="logo_txt">
                                    <h3>SMART DENTAL</h3>
                                    <h6>COMPLIANCE & TRAINING</h6>
                                </div>
                                <!-- logo_txt close -->
                            </a>
                        </div>
                 <img src="<?php echo WEB_URL ?>/webImages/refer.jpeg" alt="">
            <div class="form_side">
  <h3>
   Refer a Friend and Get a Luxury Hamper </br>   </h3> 
      <h2>The referred practice would get 10% off their subscription.
    </h2>
     <form method="post"  enctype="multipart/form-data">
          <?php $functions->setFormToken('referfriend'); ?>
                  <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="text" name="form[name]" value="" placeholder="Your Name" autocomplete="off" required>
                        </div>
                 <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="text" name="form[practicename]" value="" placeholder="Your Practice Name"  autocomplete="off" >
                        </div>


                           <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="text" name="form[contact]" value="" placeholder="Your Contact"  autocomplete="off" >
                        </div>




        <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="hidden"   placeholder=" "  autocomplete="" >
                        </div>
<!-- <hr> -->


                  <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="text" name="form[referPracticeName]" value="" placeholder="Refer Practice Name"  autocomplete="off" >
                        </div>


                           <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="text" name="form[referContact]" value="" placeholder="Refer Contact"  autocomplete="off" >
                        </div>




             



                 <div class="form-group col-sm-6">
                            <label></label>

                            <input class="" type="text" name="form[referAddress]" value="" placeholder="Refer Address"  autocomplete="off" >
                        </div>


    <div class="form-group col-sm-6">
                            <label></label>
                            <input class="" type="hidden"   placeholder=" "  autocomplete="" >
                        </div>

                     
                         <input type="submit" class="submit_class" value="Submit" name="submit" style="display: inline-block;">
               </form>
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