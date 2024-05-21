<?php
$sh = "";
if($_SESSION['currentUserType'] == "Employee"){
    $sh = "style='display:none'";
}
?>
<div class="innerGrid grid_">
        <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['cdashboard'] == '0'){?>
              
    <?php }else{?>
          <!-- <li>
            <a class="<?php if($active=='compliance')echo'active'?>" href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates"><i class="fas fa-list-alt"></i><span class="links_name">Compliance Templates</span></a><small class="tooltip_">Compliance Templates</small>
        </li> -->
   <?php }?>
        <!-- <li>
            <a href="<?php echo WEB_URL; ?>/myuploads" class="<?php if($active=='myuploads')echo'active'?>"><i class="fas fa-upload"></i><span class="links_name">My Uploads</span></a><small class="tooltip_">My Uploads</small>
        </li> -->
       <!-- </li> -->
    <div class="singleGrid">
    <ul>
        <li>
            <h4>
                <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){?>
                    <a href="#" id="hrManagement" class="<?php if($active=='resources')echo'active'?>">
                        <i class="fas fa-users"></i>HR Management
                    </a>
                <?php }else{?>
                    <a href="<?php echo WEB_URL; ?>/manage-users" id="hrManagement" class="<?php if($active=='resources')echo'active'?>">
                        <i class="fas fa-users"></i>HR Management
                    </a>
                <?php } ?>
            </h4>

            <ul>
                <li>
                    <a href="<?php echo WEB_URL; ?>/hrm">Employee Dashboard</a>
                </li>
                <li <?php if($_SESSION['currentUserType'] == 'Employee' && @$_SESSION['superUser']['hrqr'] == '0'){ echo $sh;} ?>>
                    <a href="<?php echo WEB_URL; ?>/qr-code">QR Code</a>
                </li>
                <li>
                    <a href="<?php echo WEB_URL; ?>/rota">Rota Management</a>
                </li>
                <li>
                    <a href="<?php echo WEB_URL; ?>/personal-document">Personal Documents</a>
                </li>
                <li>
                    <a href="<?php echo WEB_URL; ?>/rota-reports">Rota Reports</a>
                </li>
                <li>
                    <a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Templates</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="singleGrid">
<ul>
    <li>
        <h4>
            <?php  if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ $usermenu =  $_SESSION['superid'];   ?>
                <a href="<?php echo WEB_URL; ?>/profile-detail?user=<?php echo $usermenu; ?>" >
                    <i class="fas fa-users"></i>My Staff
                </a>
            <?php } else{ $usermenu = $_SESSION['currentUser']; ?>
                <a href="<?php echo WEB_URL; ?>/manage-users" >
                    <i class="fas fa-users"></i>My Staff
                </a>
            <?php } ?>
        </h4>

        <ul>
            <li <?php echo $sh ?>>
                <a href="<?php echo WEB_URL; ?>/manage-users">Staff Profile</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/leaves">Staff Leave Schedule</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/holiday-entitlement">Staff Holiday Entitlement</a>
            </li>

            <li>
                <a href="<?php echo WEB_URL; ?>/holiday-entitlement-calculator">Holiday Entitlement Calculator</a>
            </li>
            <li <?php echo $sh ?>><a href="<?php echo WEB_URL; ?>/instance">Staff Performance</a></li>
        </ul>
    </li>
</ul>
</div>

<div class="singleGrid">
<ul>
    <li>
        <h4>
            <a class="<?php if($active=='stockDashboard') echo'active'?>" href="<?php echo WEB_URL ?>/stock">
                <i class="fas fa-server"></i>Stock Management
            </a>
        </h4>

        <ul>
            <?php  if($_SESSION['currentUserType'] == 'Employee' && (@$_SESSION['superUser']['manage_stock'] == '0' || @$_SESSION['superUser']['manage_stock'] == '')){ ?>
                <li>
                <a href="<?php echo WEB_URL ?>/stockOrder">Stock Request</a>
                </li>

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
            <?php } ?>
        </ul>
    </li>
</ul>
</div>


<div class="singleGrid">
<ul>
    <li>
        <h4>
            <a href="<?php echo WEB_URL; ?>/cpd" class="<?php if($active=='cpd-dashboard')echo'active'?>">
                <i class="fas fa-tv"></i>CE Courses
            </a>
        </h4>

        <ul>
            <li>
                <a href="<?php echo WEB_URL; ?>/cpd-form">My Profile</a>
            </li>

            <li>
                <a href="<?php echo WEB_URL; ?>/cpd-activity">My Activity Log</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/cpd-pdp">My PDP</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/cpd">CE Courses</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/cpd-certificates">My Certificates</a>
            </li>
            <li>
                <a href="<?php echo WEB_URL; ?>/practice-training">Practice Training</a>
            </li>
            <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrdashboard'] == '0'){}else{?>
                <li><a href="<?php echo WEB_URL; ?>/assigne_course">Assign CE Course</a></li>
             <?php } ?>
        </ul>
    </li>
</ul>
</div>

</div>

<div class="singleFlex">
<ul>
    <li>
        <h4>
            <a> <i class="fa-solid fa-link"></i>Other Links </a>
        </h4>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/practice-profile"><i class="fa-solid fa-user"></i>Practice Profile</a>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/main_dashboard"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/post_all?type=posts"><i class="fa-solid fa-network-wired"></i>Social</a>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i>Compliance
            Dashboard</a>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/calendar"><i class="fas fa-calendar-alt"></i>Activity
            Calendar</a>
    </li>
    <!-- <li>
        <a class="" href="<?php echo WEB_URL; ?>/all-reports"><i class="fas fa-chart-bar"></i>Reports</a>
    </li> -->
    <li>
        <a class="" href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates"><i class="fas fa-list-alt"></i>Compliance
            Templates</a>
    </li>
    <li>
        <a href="<?php echo WEB_URL; ?>/myuploads" class=""><i class="fas fa-upload"></i>My Uploads</a>
    </li>
    <!--<li>-->
    <!--    <a href="<?php //echo WEB_URL; ?>/lab-management"><i class="fas fa-flask"></i>Lab Management</a>-->
    <!--</li>-->
</ul>
</div>
