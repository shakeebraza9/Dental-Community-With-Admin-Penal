<?php 
include_once("global.php");

$login = $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

 $safearray = $_GET['safearray'];
 print_r($safearray);
echo "<br>";

echo "safe".$_GET['safe'];
echo "<br>";
echo "effective".$_GET['effective'];
echo "<br>";
echo "wellled".$_GET['wellled'];
echo "<br>";
echo "responsive".$_GET['responsive'];
echo "<br>";
echo "caring".$_GET['caring'];

 ?>
<div class="event_details" id="myform">


    <h3>Other Details</h3>
   
    <div class="form_side">
  <h3>Overall Score</h3><span></span>Out Of 68
  <h3>Health Meter </h3><span></span>
  <h3>Results</h3>Finding
  
  </ul>


       <form method="post" autocomplete="No" enctype="multipart/form-data" >
                                    <?php $functions->setFormToken('mockInspection'); ?>
                                  
                                   <div class="form_1_side_">Name of the practice</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Name-Of-Practice]" placeholder="Name of the practice" required>
                                    </div>
                                    <div class="form_1_side_">Name of the practice manager</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" min="1" max="10" name="form[Name-Of-Practice-Mmanager]" placeholder="Name of the practice manager" required>
                                    </div>
                                    <div class="form_1_side_">Name of Compliance Champion</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[name-of-complianc-champion]" placeholder="Name of Compliance Champion" required>
                                    </div>
                                    
                                    <div class="form_1_side_"> Date Audit Conducted </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" class="datepickerr" name="form[Best-time]" placeholder="Best day for Lunch & Learn" required>
                                    </div>
                                   
                                    <div class="form_1_side_"> Location of Dental Practice  </div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                         <input type="titextme" name="form[Best-Day]" placeholder="Best day to Host a Lunch & Learn" required>
                                    </div>


                                    <div class="form_1_side_">Contact Number</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[Practice-Contact]" placeholder="Enter Contact Number" required>
                                    </div> 
                                    <div class="form_1_side_">Email</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <input type="text" name="form[email]" placeholder="Enter Email" required>
                                    </div>

                                   

                                    <div class="form_1_side_">Detail:</div>
                                    <div class="form_2_side_ hvr-shadow-radial">
                                        <textarea name="form[Detail]" placeholder="Detail" required></textarea>
                                    </div>
                                    
                                   <!--  <div class="form_1_side_"></div>
                                    <div class="form_2_side_">
                                        <div id="recaptcha2"></div>
                                    </div> -->
                                   
                                    <div class="form_2_side_ form_1">
                                        <input type="submit" class="submit_side" value="Submit">
                                    </div>
 
                                </form>
    </div><!-- form_side close -->

</div><!-- event_details -->

