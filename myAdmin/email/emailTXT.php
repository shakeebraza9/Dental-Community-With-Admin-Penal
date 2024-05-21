<?php
ob_start();
require_once("classes/email.class.php");
global $dbF;




$menuC  =   new email();

 //

?>
<h2 class="sub_heading <?php if(!isset($_GET['type'])){ echo "borderIfNotabs"; }?> "><?php echo _uc('Manage Email'); ?></h2>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs_arrow" role="tablist" id="MenuTab">
   <!--      <li class="active"><a href="#home" role="tab" data-toggle="tab"><?php //echo _uc($_e['Website Menu']); ?></a></li> -->
        

      <?php  $menuC->allFormdata(); 
?>



    </ul>

    <div class="tab-content">
      

        


      <?php  $menuC->allFormdataContent(); 
?>

        
    </div>
<?php

return ob_get_clean();