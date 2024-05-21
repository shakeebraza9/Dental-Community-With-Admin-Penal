<?php
ob_start();
require_once("classes/email.class.php");
global $dbF;




$menuC  =   new email();

 //
//  exit();

?>
<h2 class="sub_heading <?php if(!isset($_GET['type'])){ echo "borderIfNotabs"; }?> "><?php echo _uc($_e['Manage Website Menu']); ?></h2>
 <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist" id="MenuTab">
   <!--      <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php //echo _uc($_e['Website Menu']); ?></a></li> -->
        

      <?php  $menuC->allFormdata2(); 
?>



    </ul>
    <div class="tab-content">
      

        


      <?php   $menuC->allFormdataContent2(); 
?>

        
    </div>
<?php


// echo '<h4 class="sub_heading borderIfNotabs">bookingForm.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../bookingForm.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);




// echo '<h4 class="sub_heading borderIfNotabs">delegateForm.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../delegateForm.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);




// echo '<h4 class="sub_heading borderIfNotabs">featureFormSubmit.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../featureFormSubmit.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">fridayDeal.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../fridayDeal.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">healthEmail.txt</h4>';
// $dirr = __DIR__."/../../healthEmail.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">homePagePopup.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../homePagePopup.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">inquiryFormSubmit.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../inquiryFormSubmit.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">contactFormSubmit.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../contactFormSubmit.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);



// echo '<h4 class="sub_heading borderIfNotabs">referfriendSubmitWOLOGIN.txt</h4>';
// echo  '<table border="1">';
// $dirr = __DIR__."/../../referfriendSubmitWOLOGIN.txt";
// $fh = fopen($dirr,'r');
// while ($line = fgets($fh)) {
// echo($line);
// }
// echo  '</table>';
// fclose($fh);
return ob_get_clean();