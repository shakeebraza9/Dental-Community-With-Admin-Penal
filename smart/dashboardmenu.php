<?php
$sh = "";
if($_SESSION['currentUserType'] == "Employee"){
    $sh = "style='display:none'";
}
?>
<div class="sideme0nu u-vmenu">
    <ul>
        <!-- <li> -->
            <!-- <button onclick="window.location.mef='post_all?type=posts'">News</button> -->
            <!-- <button onclick="window.location.href='news?type=news'">News</button> -->
        <!-- </li> -->
       
           <li>
            <div class="title header_logo"><img src="webImages/aiom.svg"></div>
        </li>
         <li>
            <a class="<?php if($active=='dashboard')echo'active'?>" href="<?php echo WEB_URL; ?>/main_dashboard"><i class="fas fa-tachometer-alt"></i><span class="links_name">Dashboard</span></a><small class="tooltip_">Dashboard</small>
        </li>
         <li>
            <a class="<?php if($active=='post_all') echo'active'?>" href="<?php echo WEB_URL; ?>/post_all?type=posts"><i class="fab fa-mixcloud"></i><span class="links_name">Intranet</span></a><small class="tooltip_">Intranet</small>
        </li>
        <li>
            <a class="<?php if($active=='dashboard')echo'active'?>" href="<?php echo WEB_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i><span class="links_name">Compliance Dashboard</span></a><small class="tooltip_">Compliance Dashboard</small>
        </li>
        <li>
            <a class="<?php if($active=='calendar')echo'active'?>" href="<?php echo WEB_URL; ?>/calendar"><i class="fas fa-calendar-alt"></i><span class="links_name">Activity Calendar</span></a><small class="tooltip_">Activity Calendar</small>
         






        </li>
        <li>
              <a class="<?php if($active=='reportIssue')echo'active'?>" href="<?php echo WEB_URL; ?>/all-reports"><i class="fas fa-chart-bar"></i><span class="links_name">Reports</span></a><small class="tooltip_">Reports</small>




        </li>
        <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){?>
              
    <?php }else{?>
          <li>
            <a class="<?php if($active=='compliance')echo'active'?>" href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates"><i class="fas fa-list-alt"></i><span class="links_name">Compliance Templates</span></a><small class="tooltip_">Compliance Templates</small>
        </li>
   <?php }?>
        <li>
            <a href="<?php echo WEB_URL; ?>/myuploads" class="<?php if($active=='myuploads')echo'active'?>"><i class="fas fa-upload"></i><span class="links_name">My Uploads</span></a><small class="tooltip_">My Uploads</small>
        </li>
       </li>
        <li>
            <a href="<?php echo WEB_URL; ?>/cpd" class="<?php if($active=='cpd-dashboard')echo'active'?>"><i class="fas fa-tv"></i><span class="links_name">CPD Courses</span></a><small class="tooltip_">CPD Courses</small>
            <span data-option="off"></span>
           <ul>
                <li><a href="<?php echo WEB_URL; ?>/cpd-form">My Profile</a></li>
                <li><a href="<?php echo WEB_URL; ?>/cpd-activity">My Activity Log</a></li>
                <li><a href="<?php echo WEB_URL; ?>/cpd-pdp">My PDP</a></li>
                <?php                           
                // $sql = "SELECT `setting_val` FROM `ibms_setting` WHERE `setting_name` = 'test_categories'";
                // $res = $dbF->getRow($sql);
                // $res = explode(",", $res[0]);
                // foreach ($res as $field): 
                // echo'
                // <li><a href="'.WEB_URL.'/course?Cat='.$field.'">'.$field.'</a> 
                // ';
                // endforeach;  
                ?>
                 <li><a href="<?php echo WEB_URL; ?>/cpd">CPD Courses</a></li>
                <li><a href="<?php echo WEB_URL; ?>/cpd-certificates">My Certificates</a></li>
                <li><a href="<?php echo WEB_URL; ?>/practice-training">Practice Training</a></li>
                 <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){}else{?>
                <li><a href="<?php echo WEB_URL; ?>/assigne_course">Assign CPD Course</a></li>
             <?php } ?>
            </ul>
        </li>
              
           <li>
    <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>
    <a href="#" id="hrManagement" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i><span class="links_name">HR Management</span></a><small class="tooltip_"> HR Management</small>  
    <span data-option="off"></span>
    <?php }else{?>
          <a href="<?php echo WEB_URL; ?>/manage-users" id="hrManagement" class="<?php if($active=='resources')echo'active'?>"><i class="fas fa-users"></i><span class="links_name">HR Management</span></a><small class="tooltip_">HR Management</small> 
    <span data-option="off"></span>    <?php } ?>

            <ul>
                <li><a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a></li>
 <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ $usermenu =  $_SESSION['superid'];   ?>

            
           <li><a href="<?php echo WEB_URL; ?>/profile-detail?user=<?php echo $usermenu; ?>" >My Staff</a>
            <span data-option="off"></span>
<?php } else{ $usermenu = $_SESSION['currentUser']; ?>

                <li><a href="<?php echo WEB_URL; ?>/manage-users">My Staff</a>
                   <span data-option="off"></span>
 <?php } ?>
                    <ul>
                        <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a></li>
                        <li><a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a></li>
                        <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a></li>
                        <!-- <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/instance">Staff Performance</a></li> -->
                       
                <!-- <li><a href="leave-reports">Leave Reports</a>-->
                <!-- <span data-option="off"></span>-->
                <!--    <ul>-->

                        
                <!--     <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=annual_leave">Annual Leave</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=sick_leave">Sick Leave</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=casual_leave">Casual Leave</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=maternity_leave">Maternity</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=half_day_leave">Half Day Leave</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=furlough_leave">Furlough leave</a></li>-->
                <!--    <li><a href="<?php echo WEB_URL; ?>/leave-reports?leaves=Compassionate_leave">Compassionate leave</a></li>-->
                        
                  
                <!--    </ul>-->
                <!--</li>-->
                  <!--<li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-reports">Holiday Entitlement Reports</a></li>-->
                   <li><a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator">Holiday Entitlement Calculator</a></li>
                
                  <!--<li><a href="<?php echo WEB_URL; ?>/lieu" id="lieu">OverTime Report</a></li>-->
                    </ul>
                </li>
                
                <li <?php if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){ echo $sh;} ?>>
                <a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a></li>
                <li><a href="<?php echo WEB_URL; ?>/rota">Rota Management</a></li>
                <li><a href="<?php echo WEB_URL; ?>/personal-document">Personal Documents</a></li>
                <li><a href="<?php echo WEB_URL; ?>/rota-reports">Rota Reports</a>
                  <!--<span data-option="off"></span>-->
                    <!--<ul>-->
 <?php if( $_SESSION['currentUserType'] == 'Employee' &&  $_SESSION['superUser']['hrreports'] == '0')  { ?>     
                        <!--<li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>-->
                      <?php }else{  ?>
                        <!-- <li><a href="<?php echo WEB_URL; ?>/covid">Covid Reports</a></li>-->
                        <!--<li ><a href="<?php echo WEB_URL; ?>/policy-report?category=Training">Training Report</a></li>-->
                        <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Recruitment">Recruitment Report</a></li>-->
                        <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Signed Policies">Signed Policies Report</a></li>-->
                        <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Minute Meeting">Minute Meeting Report</a></li>-->
                        <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=MHRA">MHRA Alerts Report </a></li>-->
                        <!--<li><a href="<?php echo WEB_URL; ?>/policy-report?category=Additional Document">Additional Document</a></li>  -->
                    <?php } ?>
                    <!--</ul>-->
                </li>
                 <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ ?>
               
            <?php }else{ ?>
                 <li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a></li>
           <?php } ?>
            </ul>
        </li>
         









         
        <li>
            <a class="<?php if($active=='stockDashboard') echo'active'?>" href="<?php echo WEB_URL ?>/stock"><i class="fas fa-server"></i><span class="links_name">Stock Management</span></a><small class="tooltip_">Stock Management</small>  
            <span data-option="off"></span>
<ul>

<?php  if($_SESSION['currentUserType'] == 'Employee' && ($_SESSION['superUser']['manage_stock'] == '0' || $_SESSION['superUser']['manage_stock'] == '')){ ?>


<!-- <li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li> -->
<!-- <li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li> -->
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<!-- <li>
<a href="javascript:;">Reports</a>
<ul>
<li>
<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>
</li>
</ul>
</li> -->


<?php }else{ ?>

<li>
<a href="<?php echo WEB_URL ?>/purchaseReceipt">Add Incoming Stock</a>
</li>

<li>
<a href="<?php echo WEB_URL ?>/stockView#tabs-2">Add Existing Stock</a>
</li>


<li>
<a href="<?php echo WEB_URL ?>/stockView">Product List</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>
</li>
<li>
<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>
</li>
<!--<li>-->
<!--<a href="javascript:;">Reports</a>-->
<!--  <span data-option="off"></span>-->
<!--<ul>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/perSurgery">Stock Consumption Per Surgery</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/availableStock">Available Stock</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/mostUseProducts">Most Used Products</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/expireProList">Expiry Product List</a>-->
<!--</li>-->
<!--<li>-->
<!--<a href="<?php echo WEB_URL ?>/mqProList"> Minimum Quantity Product List</a>-->
<!--</li>-->
<!--</ul>-->
<!--</li>-->
<?php } ?>







</ul>
        </li>
  <li>
            <a class="<?php if($active = 'resources') echo'active'?>" href="<?php echo WEB_URL; ?>/lab-management"><i class="fas fa-flask"></i><span class="links_name"> Lab Management</span></a><small class="tooltip_">Lab Management</small></li>
         <?php  
          // $activeLink = pageLink(false);
          //               $activeLink;
          //            if ($activeLink !=  WEB_URL.'/rota'  ) {
          //           $_POST['change-session'] = TRUE;
          //          if (isset($_POST['change-session'])) {
          //        if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['ccalendar'] == 'full'){ 
                    ?>
               <li>
             <a class="<?php if($active=='stock') echo'active'?>" href="#"><i class="fa fa-user-circle"></i><span class="links_name"> Forget To Check In/Out</span></a><small class="tooltip_">Forget To Check In/Out</small> 
             <span data-option="off"></span>
            <ul>
                <li>
                    <a href="<?php echo WEB_URL; ?>/checkoutforget?type=checkoutForget">Forget Check Out</a>
                </li> 

               

                <li>
                    <a href="<?php echo WEB_URL; ?>/checkinforget?type=checkinForget">Forget Check in</a>
                </li>

            
            </ul>
        </li>
       <li>
            <a class="<?php if($active=='faq') echo'active'?>" href="<?php echo WEB_URL; ?>/faq"><i class="fas fa-info"></i><span class="links_name"> FAQ</span></a><small class="tooltip_">FAQ</small></li>
      
         <li>
            <a class="<?php if($active=='trashdata') echo'active'?>" href="<?php echo WEB_URL; ?>/trashdata"><i class="fas fa-eraser"></i><span class="links_name">Trash Data</span></a><small class="tooltip_">Trash Data</small></li>
        <li>
            <?php 
            $var =  $functions->CheckInBtn();
            $var2 = $functions->CheckOutBtn();
             // var_dump($var);
             // echo "<br>";
             // var_dump($var2);
            ?> 
            <script>


function secure_delete333(text){
           
  text = typeof text !== "undefined" ? text : "Are you sure you want to Delete?";

            bool=confirm(text);
                   console.log(bool);
            if(bool==true){
             
                    
                var filename = location.pathname.substr(location.pathname.lastIndexOf('/')+1);
                            if(filename != 'checkinout'){window.location.href='checkinout?type=checkin_rota_not'}
                   
                }
                else{
              
                    console.log("no");
                   
                }
       

        }

  function Lunch_Time(text){
           
  text = typeof text !== "undefined" ? text : "Are you sure you want to Go Lunch?";

            bool=confirm(text);
                   console.log(bool);
            if(bool==true){
             
                    
               window.location.href='checkinout?type=lunch_time_checkin';
                   
                }
                else{
              
                    console.log("no");
                   
                }
       

        }

       function Lunch_TimeOut(text){
        //   /doxu10vne1mw/public_html/AIOM/dashboardmenu.php
  text = typeof text !== "undefined" ? text : "Are you sure you want to Go Lunch?";

            bool=confirm(text);
                   console.log(bool);
            if(bool==true){
             
                    
                 window.location.href='checkinout?type=lunch_time_checkout';
                   
                }
                else{
              
                    console.log("no");
                   
                }
       

        }
        let sidebar = document.querySelector(".left_side"); 
        let closeBtn = document.querySelector("#btn");  
        
        
        function width_250(){ 
            sidebar.classList.toggle("open"); 
          $(".u-vmenu ul ul").css("display", "none"); 
          $('.u-vmenu span[data-option="on"]').attr('data-option', 'off');  
              
        }


</script>

        </li>
        <span class="width-250" onclick="width_250();" data-toggle="tooltip" title="Expand"><i class="fas fa-chevron-right"></i></span>
  <?php 

  // } 
  // } 

  
   // } ?>
        
    </ul>
</div>
<!-- sidemenu close -->