<?php 
include_once("global.php");
include_once('header.php'); 

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     include('login.php');
}

$option = $functions->eventCategory();

?>

 <div class="header_bottom">
    <div class="standard">
        <div class="header_bottom_left">
            <ul>
                <li><a href="<?php echo WEB_URL; ?>/dashboard" class="active">Dashboard</a></li>
                <li><a href="<?php echo WEB_URL; ?>/calendar">Activity Calendar</a></li>
                <li><a href="<?php echo WEB_URL; ?>/resources?category=Compliance-Templates">Compliance Templates</a></li>
                <li><a href="#">Courses</a>
                    <ul>
<?php                           
$sql = "SELECT `setting_val` FROM `ibms_setting` WHERE `setting_name` = 'test_categories'";
$res = $dbF->getRow($sql);
$res = explode(",", $res[0]);
foreach ($res as $field): 
echo'
<li><a href="'.WEB_URL.'/course?Cat='.$field.'">'.$field.'</a> 
';
 endforeach;  
 ?>
                    </ul>
                </li>
                <li><a href="<?php echo WEB_URL; ?>/resources?category=HR-Management">HR Management</a>
                    <ul>
                        <li><a href="#">Employee Hub</a>
                            <ul>
                                <li><a href="#">Manage Users</a></li>
                                <li><a href="#">Users Training</a></li>
                                <li><a href="#">Rota Management</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo WEB_URL; ?>/resources?category=Practice-Management-Resources">Practice Management Resources</a></li>
                <li><a href="<?php echo WEB_URL; ?>/myuploads">My Uploads</a></li>
            </ul>
            </div><!-- header_bottom_left close -->
                        <div class="header_bottom_right">
                            <div class="login_side">
                               <a href="<?php echo WEB_URL; ?>/profile?page=Profile">                              
                               <h6>Logged in as:</h6>
                               <h2><?php echo $_SESSION['webUser']['name']?></h2>
                               </a>
                            </div><!-- login_side close -->
                            <div class="account_btn">
                                <ul>
                                    <li><a href="<?php echo WEB_URL; ?>/profile?page=Profile">My Account <span><img src="webImages/1.png" alt=""></span></a></li>
                                    <li><a href="<?php echo WEB_URL; ?>/logout">Log out <span><img src="webImages/2.png" alt=""></span></a></li>
                                </ul>
                            </div><!-- account_btn close -->
                        </div><!-- header_bottom_right close -->
                    </div><!-- standard close -->
                </div><!-- header_bottom close -->
                <div class="content_side">
            <div class="right_side_top">
                <div class="standard">
                    <h3>My Uploads</h3>
                    <div class="col1_btn">
                            <?php
                            $data3 = $functions->health_check($_SESSION['webUser']['id']);
                            if($data3)
                            { ?>
                            <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                            <?php } ?>
                        </div>
                </div><!-- standard close -->
            </div><!-- right_side_top close -->
            <div class="standard">
                <div class="event_details">
                <div class="form_side">
                    <form method="post" action="myuploads" enctype="multipart/form-data">
                        <?php echo $functions->setFormToken('myUploads',false); ?>
                    <div class="branches_side_input branches_side_textarea">
                        <input name="title" placeholder="Title" required>
                        <label for="Title">Title</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input branches_side_textarea">
                        <select name="category" class="form-control categ" required>
                        <?php echo $option; ?>
                        </select>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <div class="branches_side_input">
                        <input type="file" name="document" placeholder="File">
                        <label for="File">File</label>
                        <div class="branches_side_input_bar"></div>
                        <!-- branches_side_input_bar close -->
                    </div>
                    <!-- branches_side_input close -->
                    <input type="submit" class="submit_class" value="SUBMIT" name="submit">
                    </form>
                </div><!-- form_side close -->
                </div><!-- event_details -->
            </div>
        </div>

<style>
    iframe{
        display: none;
    }
</style>
<?php include_once('footer.php'); ?>



