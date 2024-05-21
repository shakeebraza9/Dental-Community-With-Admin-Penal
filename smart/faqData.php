<?php 
ob_start();
include_once("global.php");
global $webClass;


// include_once('header.php'); 



// include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}
                            $user = $_SESSION['currentUser'];
                            $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` ='$user'";
                            $data1 = $dbF->getRow($sql1);
 
?>

<div class="inner_content">
<div class="text_side_left">
    <div class="standard">
        <div class="map_side_ wow fadeInUp">
           
        </div>
        <!-- map_side_ close -->


        

     <div style="color: #df5353;" class="alert alert-danger">

<i style="color: #df5353;" class="fas fa-flag"></i> Click on any video below to watch interactive instructions on how to do something.

</div>

            <div class="cpd-table hr-absence profile">
               
               <div id="tabs">
        <ul id="gettabs">
            <?php  
            $sql2 = "SELECT * FROM `faq` GROUP BY `category`";
            $data2 = $dbF->getRows($sql2); 
            $cnt1 = 0;
            foreach ($data2 as $key => $value) {
             $cnt1++;
                ?>
            <li><a href="#tabs-<?php echo $cnt1; ?>" ><?php echo $value['category']; ?></a></li>

           <?php } ?>
            
        </ul>

<?php  
            $sql2 = "SELECT * FROM `faq` GROUP BY `category`";
            $data2 = $dbF->getRows($sql2);
            $cnt2 = 0;
            foreach ($data2 as $key2 => $value2) {
               $cnt2++;
                ?>
    <div id="tabs-<?php echo $cnt2; ?>" >
         <div class="file-box">
        <?php 
$sql2 = "SELECT * FROM `faq`  WHERE `category` = '$value2[category]'";
            $data3 = $dbF->getRows($sql2);
            foreach ($data3 as $key => $value3) {
         ?>
       
       
        <div class="file-box-desc" id="<?php echo $value3['id'] ?>" type="button" onclick="faqview(this.id)"  style="cursor: pointer;">
      

  <a data-toggle="tooltip" title="View"  class="" style="cursor: pointer;">
<i class="fas fa-play-circle"></i>
</a>
<div class="dtitle"><?php echo $value3['title'] ?></div>
<span></span>
</div>
        


 <?php } ?>
 </div>
    </div>
 <?php } ?>

        </div>

            </div>
            <!-- cpd-table -->
        </div>
        <!-- right_side close -->
    </div>
    </div>
    <!-- left_right_side -->
<?php

return ob_get_clean(); 

?>