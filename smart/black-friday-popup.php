<div class="fix-side fix-side2" style="transform: scaleX(1);"></div>
<div class="new-popup black-friday">
   <h1> ~~ BLACK FRIDAY SALE ~~ </h1>
    <h2>Get your FREE Access to the Fastest Growing Practice Management Support</h2>
    <form method="post">
    <?php $functions->setFormToken('popupForm'); ?>


                         <input type="hidden" id="g-popupForm" name="g-popupForm">
    <input type="hidden" name="action" value="popupForm">



    
        <div class="row">
            <div class="col-md-4">
                 <img src="<?php echo WEB_URL ?>/webImages/SDC-black-friday.png?123">
            </div>
            <div class="col-md-7">
                
                <div class="row">
                <!--<label class="col-md-5">Name:</label>-->
                <input class="col-md-7" type="text" name="form[name]" placeholder="Your Name" required>
                <!--<label class="col-md-5">Email Address:</label>-->
                <input class="col-md-7" type="text" name="form[email]" placeholder="Your email" required>
                <!--<label class="col-md-5">Contact Number:</label>-->
                <input class="col-md-7" type="text" name="form[number]" placeholder="Your Phone" required>
                <!--<label class="col-md-5">Practice Details:</label>-->
                <input class="col-md-7" type="text" name="form[practice details]" placeholder="Practice Details" required>
               <!--  <label class="col-md-5">Captcha:</label>
                <div id="recaptcha2"></div> -->
<div class="new-popup-footer">
                <!--<h3>Stay Healthy , Stay Safe , Stay Productive</h3>-->
                <button type="button" onclick="close_newpopup()">Cancel</button>
                <button type="submit">Submit</button>
            </div>
                   <div id="recaptcha3" class="recaptcha3">
                              <input type="hidden" id="token" name="token">
                                </div>


            </div>
            </div>
            
        </div>
    </form>
    <!--<div class="new-popup-bottom">-->
    <!--    www.smartdentalcompliance.com | 0800 689 1061-->
    <!--</div>-->
</div>
<!-- new-popup -->