<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
    header('Location: login');
}

include_once('dashboardheader.php'); 
?>



<link rel="stylesheet" href="<?php echo WEB_URL; ?>/css/customAlert.css"/>

<script src="<?php echo WEB_URL; ?>/js/customAlert.js"></script>

<?php
$functions->pin();
// echo "<pre>";var_dump($_POST,$_SESSION['tokens']);echo "</pre>";
// htmlspecialchars($_GET['id']);
// htmlspecialchars($_GET['alldocumentidPD']);
$msg = $webClass->webUserAddSubmit();

$chk1 = $functions->documentInsert();
// var_dump($chk1);
if($chk1){
    $msg = "Document Inserted Successfully";
}
$chk2 = $functions->documentUpdate();
if($chk2){
    $msg = "Document Update Successfully";
}
$chk3 = $functions->documentAdd();
if($chk3){
    $msg = "Document Added Successfully";
}
$chk4 = $functions->documentUpdateExpiry();
if($chk4){
    $msg = "Document Update Successfully";
}
if(isset($_GET['folD'])){
    $chk = $functions->deleteDocument();
    if($chk){
        $msg = "Document Deleted  Successfully";
    }
}
if(isset($_GET['alldocumentidPD'])){
    $chk = $functions->deleteDocumentall();
    if($chk){
        $msg = "All Document Delete Successfully";
    }
}

   

$chk4 = $functions->documentInsert_profile_detail();
if($chk4){
    $msg = "Document Inserted Successfully";
}
if(!empty($msg)){
?>
<script type="text/javascript">
    xdialog.alert("<?php echo $msg; ?>"); 
</script>
<!------------dashboardheader.php------------------------>
<?php
}


if(isset($_POST['change-session']) ){

   echo "<script>location.replace('".WEB_URL."/profile-detail');</script>";
}
//---------dashboardheader.php------------------------>
      ?>

<!------------folder.php------------------------>
            
         <?php

$url_user = "";
 $user1 = '';
   @$url_user = intval($_GET['user']);
   
 if($_GET['user']> 0) {$user = $url_user; $user1 = $_SESSION['currentUser'];}
   else{
     if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                    $user = $_SESSION['superid'];
                 //   echo "Employee";
                }
                else{
                 //   echo "currentUser";
                    $user1 = $_SESSION['currentUser'];
   }
   }
$sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id`=?";
$userData = $dbF->getRow($sql1,array($user));

$sql2 = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='role' AND `id_user`='$user'";
$data = $dbF->getRow($sql2);
$role = $data[0];

$sql3 = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='date_of_birth' AND `id_user`='$user'";
$data = $dbF->getRow($sql3);
$dob = $data[0];

$sql4 = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='phone' AND `id_user`='$user'";
$data = $dbF->getRow($sql4);
$phone = $data[0];

$sql5 = "SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='gdc_number' AND `id_user`='$user'";
$data = $dbF->getRow($sql5);
$gdc = $data[0];

$sqlI ="SELECT `setting_val` FROM `accounts_user_detail` WHERE `setting_name`='hours_worked' AND `id_user`='$user'";
$data = $dbF->getRow($sqlI);
$hours_worked = $data[0];

if($_SESSION['currentUserType'] == 'Employee'){
    $pid = $functions->PracticeId($_SESSION['superid']);
}
else{
    $pid = $_SESSION['currentUser'];
}
?>
<!------------folder.php------------------------>




<div class="index_content mypage">
    <!-- <div class="left_right_side"> -->
        
        <div class="right_side">
             
           <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){?>
             <div></div>
        <?php }else{ ?>
              <!-- user_side close -->
        <div class="user-box-main_new" style="display: none;"> 
            <h3>All User</h3>
            <div class="profile-src-event">
               <input type="text" id="profile-src-event" class=""><i class="fas fa-search"></i>
            </div>
        <div class="user-box-main">
                <?php
                if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                    // $user = $_SESSION['superid'];
                    $sql = "SELECT * FROM `accounts_user` WHERE `acc_id`= ? ";
                    $data = $dbF->getRows($sql,array($user));
                }
                else{
                    // $user1 = $_SESSION['currentUser'];
        $sql = "SELECT * FROM `accounts_user` WHERE  `acc_id`='$user1' OR `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$user1' AND `setting_name`='account_under')  ORDER BY `acc_type` DESC, `acc_name` ASC ";
                    $data = $dbF->getRows($sql);
                }

                 $alluserid='';
                foreach ($data as $key => $value) {
                $deactive = "";
                $userid = $value['acc_id'];
                $name  = $value['acc_name'];
                $image = $value['acc_image']; 
                $alluserid.=$userid.",";
                $data2 =  $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$userid' AND `setting_name`='role'");
                $role = $data2[0];
                if($value['acc_type'] == '0'){
                    $deactive = "<div class='deactive'>DeActive</div>";
                }
               

                 $image = $value['acc_image'];
               
                 $iamge2 = "logo.png";
                  if ($image == "#"||trim($image) == "" ) 
                {
                     $image = @$image2;
                    $image = "webImages/d-profile.png";
                 }
                 else
                 {
                     
                    // $image = "images/$value[acc_image]";
                   $image =  $functions->resizeImage($value['acc_image'], 'auto', 500, false);

                    
                 
                     
                 }
                echo "<div class='user-box'>
                        $deactive

                        <img src='$image' alt=''>
                        <h5>$name</h5>
                        <h6>$role</h6>
                        <button type='button' onclick='folder(this.id)'   id='$userid'>Details</button>
                      

                    <!-----<a href='profile-detail?user=$userid' >Details</a>----->


                    </div>";
                       
                }
                 $uID =   explode(',',$alluserid);
        
             

                 if(!in_array($url_user,$uID)){
                     
                     echo "<script> location.replace('".WEB_URL."/login'); </script>";
                          exit();
                         }
                ?>
            </div>
            </div>
     <?php   } ?>
            <!-- user-box-main -->
      <!-- user_side close -->
<div class="event_details_profile_new" >
    


     <?php if($msg!=''){ ?>
     <div class="col-sm-12 alert alert-success  alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <?php echo @$msg; ?>
                </div>
            <?php } ?>
<div class="event_details profile" id="myform">

<div class="right_side_top">
                <!-- <div class="change-session"> -->
                    <?php
                        //$functions->changeSession();
                        if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full'){
                    ?>
                    <!-- <div class="col1_btnn">
                        <a href="<?php echo WEB_URL; ?>/manage-users" class="submit_class">
                            <i class="fa-solid fa-eye"></i>
                            View All User
                        </a>
                    </div> -->
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL; ?>/manage-users"><i class="fa-solid fa-eye"></i>&nbsp;&nbsp;View All User</a>
                    </div>
                    <div class="col1_btnn">
                        <a href="<?php echo WEB_URL; ?>/profile?page=Add Profile"><i class="fas fa-user"></i>&nbsp;&nbsp;Add New Employee</a>
                    </div>
                    <?php } ?>
                <!-- </div> -->
                <!-- change-session -->
            </div>

      <!---------New adjustment Name--------------->

     <div  class="staff-profile">

<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){ ?>
     <div class="name1"><span><?php echo $userData['acc_name'] ?></span></div>
     <?php } else{  ?>

   <div class="name1"><span><?php echo $userData['acc_name'] ?></span></div>

<?php } ?>
          
        </div>
          <!---------New adjustment Name----END-----------> 
          <?php 
            $private_folder = $dbF->getRow("SELECT `allow` FROM `superUser` WHERE `user`=? AND `type`= ? ",array($user,'private_folder'));   

      // $Privatesql = "SELECT `setting_val` FROM accounts_user_detail WHERE id_user = '$url_user' AND setting_name = 'private_folder' ";
      // $PrivateDate =  $dbF->getRow($Privatesql);    
           ?>
    <div id="tabs">
        <ul id="gettabs">
            <li><a href="#tabs-1">Profile</a></li>
            <li><a href="#tabs-2">Training <?php $echo =  $functions->countTTLDoneStaffDocuments("Training",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
"><?php



if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent)|| is_float($percent)) echo number_format( $percent * 100); else echo "0";

}else{
    echo "0";
}

 ?> %</div></a></li>
            <li><a href="#tabs-3">Recruitment <?php $echo =  $functions->countTTLDoneStaffDocuments("Recruitment",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
"><?php



if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) echo number_format( $percent * 100); else echo "0";

}else{
    echo "0";
}

 ?> %</div></a></li>
            <li><a href="#tabs-4">Signed Policies <?php $echo =  $functions->countTTLDoneStaffDocuments("Signed Policies",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
"><?php



// echo $echo[1].' '.$echo[0];
// var_dump($echo[1],$echo[0]);
if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) echo number_format( $percent * 100); else echo "0";
}else{
    echo "0";
}


 ?> %</div></a></li>
            <li><a href="#tabs-8">Minute Meeting <?php  $echo =  $functions->countTTLDoneStaffDocuments("Minute Meeting",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
">


<?php


if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) echo number_format( $percent * 100); else echo "0";

}else{
    echo "0";
}


 ?> %



</div></a></li>
            <li><a href="#tabs-5">MHRA Alerts <?php $echo =  $functions->countTTLDoneStaffDocuments("MHRA",$user,$pid);  ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
"><?php



if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent)|| is_float($percent)) echo number_format( $percent * 100); else echo "0";

}else{
    echo "0";
}

 ?> %</div></a></li>
            <li><a href="#tabs-6">Additional Document <?php $echo =  $functions->countTTLDoneStaffDocuments("Additional Document",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
"><?php




if($echo[1] != 0 && $echo[0] != 0){
 $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) echo number_format( $percent * 100); else echo "0";
}else{
    echo "0";
}


 ?> %</div></a></li>




            <li style="display: none"><a href="#tabs-7">Archive</a></li>
<?php




// echo "<pre>";var_dump($_SESSION);
if (($_SESSION['currentUserType'] == "Employee" &&  $_SESSION['superUser']['private_folder'] == "on") || ($_SESSION['currentUserType'] == "Master" || $_SESSION['currentUserType'] == "Practice") ) {  


echo '<li ><a href="#tabs-9">Private Folder</a></li>';
             
           
            }
            else
            {  
               $hide = "style='display:none'";
            echo '<li '.$hide.'><a href="#tabs-9">Private Folder</a></li>';
           
           }
            ?>
            <li><a href="#tabs-10">Onboarding <?php  $echo =  $functions->countTTLDoneStaffDocuments("Onboarding",$user,$pid); ?><div data-toggle="tooltip" title="Total: <?php echo $echo[0] ?> , Complete: <?php echo $echo[1] ?>" style="
    position: relative;
    display: inline;
    margin: 5px;
    border: 1px solid;
    padding: 5px;
    border-radius: 20px;
    font-weight: bold;
">


<?php



if($echo[1] != 0 && $echo[0] != 0){

 $percent = $echo[1]/$echo[0]; if(is_int($percent) || is_float($percent)) echo number_format( $percent * 100); else echo "0";
}else{
    echo "0";
}



 ?> %



</div></a></li>
<li><a href="#tabs-11">Appraisal </a></li>
        </ul>
        
       

        <div id="tabs-1" class="staff-profile">

            <?php if($_SESSION['currentUserType'] != 'Employee'  || $_SESSION['superUser']['hruser'] == 'full') { ?>
                 <!-- <a style="margin: 30px -1px;" onclick="documentInsert_profile_detail()"  ><i class="fas fa-plus"></i>&nbsp;Add Document</a> -->

                  
               

            <?php } ?>

          <?php  
 

 $image = $userData['acc_image'];

               

                 // @$iamge2 = "d-profile.png";
                  if ($image == "#"||trim($image) == "" ) 
                {
                     // $image = @$image2;
                    $image = WEB_URL."/images/default_profile.jpg";
                 }
                 else
                 {

                    // $image = "images/$userData[acc_image]";
                    $image =  $functions->resizeImage($userData['acc_image'], 'auto', 500, false);


                 }
                   
                //    $image = $functions->resizeImage($image, 'auto', 80, false);
                     $data2 =  $dbF->getRow("SELECT `setting_val` FROM `accounts_user_detail` WHERE `id_user`='$user' AND `setting_name`='role'");
                $Roleee = $data2[0];
                  ?>
                  
                   



            <!-- <a href="profile?page=Edit Profile&userId=<?php //echo $user ?>"><i class="fas fa-edit"></i></a> -->
            <img src="<?php echo $image  ?>">
            <div class="name"><?php echo $userData['acc_name'] ?>

            <div class="icn">
                <a class="btn-edit" href='profile?page=Edit Profile&userId=<?php echo $_GET['user'] ?>'><i class="fas fa-edit" data-toggle="tooltip" title="" aria-describedby="ui-id-12"></i>
                </a>
                <a class="btn-edit" onclick="documentsadd('Add_Folder','<?php echo $url_user ?>')">
                    <i class="fa-solid fa-folder-plus" data-toggle="tooltip" title="Add folder"></i>
                </a>
            </div>
            </div>


            <div class="details_flex">
                <div class="left">
                    <div class="single_detail">
                        <label for="email">Email: </label>
                        <p><?php echo $userData['acc_email'] ?></p>
                    </div>
                    <div class="single_detail">
                        <label for="dob">Date of Birth: </label>
                        <p><?php echo $dob ?></p>
                    </div>
                    <div class="single_detail">
                        <label for="gdc">GDC Number: </label>
                        <p><?php echo $gdc ?></p>
                    </div>
                </div>
                <div class="right">
                    <div class="single_detail">
                        <label for="role">Role: </label>
                        <p><?php echo $Roleee ?></p>
                    </div>
                    
                    <div class="single_detail">
                        <label for="phone">Phone: </label>
                        <p><?php echo $phone ?></p>
                    </div>
                    <div class="single_detail">
                        <label for="hours">Hours Work: </label>
                        <p><?php echo $hours_worked ?></p>
                    </div>
                </div>
            </div>
            <br>
            <br>
        </div>
        <div id="tabs-2">
             <?php //if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentInsert_profile_detail('Add_Training_Document','<?php echo $url_user ?>','1')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Training</a>
            <?php //} ?>
             <div class="col-sm-12 alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Please upload the latest certificates, can be added through the add document button
            </div>
            <div class="col4_main">
                                <?php 
              // $allsubOptions = $echo[1];                
              $percent_sub_cat_rec =  $functions->countTTLDoneStaffDocumentsScat("Recommended",$user,$pid); 
              $Rpercent= $percent_sub_cat_rec[2]."%";
              $percent_sub_cat_man =  $functions->countTTLDoneStaffDocumentsScat("Mandatory",$user,$pid);
              $Mpercent= $percent_sub_cat_man[2]."%";
                
                 @$allsubOptions=array_filter(explode(" ", @$allsubOptions));
                 echo $heading = "<h5 style='margin-bottom: 5px;' class='all atv'>All</h5>
                 <h5 style='margin-bottom: 5px;' class='Recommended'>Recommended <b>".$Rpercent."</b></h5>
                 <h5 style='margin-bottom: 5px;' class='Mandatory'>Mandatory <b>".$Mpercent."</b></h5>
                 ";
                                
                        ?>        
                    

<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 
$uUUID = $_SESSION['webUser']['id']; 
}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>
<div id='extraupload'></div><div id='extrabutton' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>
<script>var extraObj=$("#extraupload").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='title' value='' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /><input type='hidden' name='category' value='Training' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='date' name='c_date' class='datepicker' autocomplete='off'   value='' /><b>Expiry Date</b><input class='datepicker' name='e_date' type='date' autocomplete='off'   /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#extrabutton").click((function(){console.log("startUpload");extraObj.startUpload()}));</script>

           <div class="file-box">

            <?php 
        
         
          // echo   $_SESSION['currentUserType'] ;
          // echo    $_SESSION['superUser']['hruser'] ;
          // echo  $user = $_SESSION['superid'];
                // From Admin

            if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {

               $data = $dbF->getRows("SELECT * FROM `documents` WHERE (`assignto` IN ('all','$user','all:$pid') AND `category`='Training' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))) AND (`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='documents'))");
              
            }else{
              $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Training' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))");
            }                
            foreach ($data as $key => $value) {
                   $checked="checked"; 
                    $style="";
                    $grey="";
                    $disable="";
                    $button='<a href="" id="'.$user.":documents:".$value['id'].'" onclick="changeUserDoc(this.id)" data-toggle="tooltip" title="Delete Document"><i class="fas fa-eye-slash" style="font-size:20px"></i></a>';
                    $pid =$_SESSION['currentUser'];
                    $sql = "SELECT files_id FROM `practiceFileSelection` WHERE p_id='$pid' AND user_id='$user'";
                    $data = $dbF->getRows($sql);
                    foreach ($data as $val) {
                     if($val['files_id']==$value['id']){
                      $checked="";
                      $disable="disabled";
                      $style="background-color: #ccc;
                        color: #fff;
                        border: 1px solid #ccc;";
                      $grey="color: #ccc;";
                      $button='<a class="ablue" href="" id="'.$user.":documents:".$value['id'].'" onclick="changeUserDoc(this.id)" data-toggle="tooltip" title="Undelete Document"><i class="fas fa-eye" style="font-size:20px"></i></a>';
                     }
                    }
                
                     $value['id'];
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {
                 
                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
 
     // if($value['expiry'] < date('Y-m-d',strtotime('1 months'))){

     //                    $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
     //                }
                     
                  
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)' style='$style' $disable><i class='fas fa-upload'></i></button> 
";
$title=str_replace("&","and",$value['title']);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
      }else{
      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' $disable><i class='fas fa-bell'></i></button> ";
      echo $button;        

}
$id = base64_encode($value['id']."&d=".date('d'));
if (@$value['title_id'] != '-1') {
if ($value['assignto'] != 'all') {
    

  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"         <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px; $style'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px; $style'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
}
}
     if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt' style='$grey'></i></a>";}
               
                    else{echo "<a class='abblue'><i class='far fa-file-alt' style='$grey'></i></a>";}

  echo "                       
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }

                // From User 
                
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `id` IN (SELECT max(`id`) FROM `userdocuments` WHERE `user`= ? AND `category`='Training' GROUP BY `title`) ORDER BY `userdocuments`.`completion_date` DESC",array($user));
           //     $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Training' AND `completion_date` IN (SELECT max(`completion_date`) FROM `userdocuments`) GROUP BY `title` ORDER BY `userdocuments`.`completion_date` DESC",array($user));
                $dupCount = 0;
                foreach ($data as $key => $value) {

                  $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {



                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='')
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><div style='display:inherit;'><span style='margin-right: 11px;'>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";  

                          
                        $button.='<a id="'.$value['title_id'].'&user='.$user.'&uid='.$value['id'].'" onclick="documentView(this.id)" data-toggle="tooltip" title="Update Expiry"><i class="fas fa-edit" style="font-size:20px"></i></a></div>';   
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



// $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
//                             if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


// }





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "</div>";
                }else{


//  $dupCount++;
$dupCount=1;

if($dupCount == 1){

                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='') 
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";



                        $button .= "<div style='display:inherit;'><span style='margin-right: 11px;'>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";
                        $button.='<a id="'.$value['title_id'].'&user='.$user.'&uid='.$value['id'].'" onclick="documentView(this.id)" data-toggle="tooltip" title="Update Expiry"><i class="fas fa-edit" style="font-size:20px"></i></a></div>';     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



$dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


}





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "<span>Total : ".$dataC['ttl']." Record</span></div>";
                


}

                }
              }
            ?>
            </div>
            </div>
        </div>
        
        
        
        <div id="tabs-3">
             <?php // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
              <a onclick="documentInsert_profile_detail('Add_Recruitment_Document','<?php echo $url_user ?>','2')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Recruitment</a>
            <?php // } ?>
              <div class="col4_main">
                  
                <?php $echo =  $functions->documentClickAbleTitle("Recruitment",$_SESSION['webUser']['id']); 

                echo $echo[0];$allsubOptions = $echo[1];
                
                if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 
                
                $uUUID = $_SESSION['webUser']['id']; 
                
                }else{ 
                $uUUID = $userS; 
                } 

?>


<div id='extrauploadRecruitment'></div><div id='extrabuttonRecruitment' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>
<script>
var extraObjRecruitment=$("#extrauploadRecruitment").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='title' value='' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /><input type='hidden' name='category' value='Recruitment' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' class='datepicker' autocomplete='off'   name='c_date' value='' /><b>Expiry Date</b><input type='text' name='e_date' value='' class='datepicker' autocomplete='off'   /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#extrabuttonRecruitment").click((function(){

console.log("startUpload");

extraObjRecruitment.startUpload()}));


</script>



           <div class="file-box">

            <?php 
        
         
          // echo   $_SESSION['currentUserType'] ;
          // echo    $_SESSION['superUser']['hruser'] ;
          // echo  $user = $_SESSION['superid'];
          
                // From Admin
                
             if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {

               $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Recruitment' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user')) AND (`id` NOT IN (SELECT files_id FROM `practiceFileSelection` WHERE user_id='$user' AND type='documents'))");
              
            }else{
               $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Recruitment' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))");
            }  
                foreach ($data as $key => $value) {
                   $checked="checked"; 
                    $style="";
                    $grey="";
                    $disable="";
                    $button='<a href="" id="'.$user.":documents:".$value['id'].'" onclick="changeUserDoc(this.id)" data-toggle="tooltip" title="Delete Document"><i class="fas fa-eye-slash" style="font-size:20px"></i></a>';
                    $pid =$_SESSION['currentUser'];
                    $sql = "SELECT files_id FROM `practiceFileSelection` WHERE p_id='$pid' AND user_id='$user'";
                    $data = $dbF->getRows($sql);
                    foreach ($data as $val) {
                     if($val['files_id']==$value['id']){
                      $checked="";
                      $disable="disabled";
                      $style="background-color: #ccc;
                        color: #fff;
                        border: 1px solid #ccc;";
                      $grey="color: #ccc;";
                      $button='<a class="ablue" href="" id="'.$user.":documents:".$value['id'].'" onclick="changeUserDoc(this.id)" data-toggle="tooltip" title="Undelete Document"><i class="fas fa-eye" style="font-size:20px"></i></a>';
                     }
                    }
                     $value['id'];
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {
                 
                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
 
     // if($value['expiry'] < date('Y-m-d',strtotime('1 months'))){

     //                    $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
     //                }
                     
                  
                echo "<div class='file-box-desc ab all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                    <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)' style='$style' $disable><i class='fas fa-upload'></i></button>";
                
                $title=str_replace("&","and",$value['title']);
                
                if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
                      }else{
                      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' $disable ><i class='fas fa-bell'></i></button> ";
                      echo $button;        
                
                }
                
                
                $id = base64_encode($value['id']."&d=".date('d'));
                if (@$value['title_id'] != '-1') {
                    if ($value['assignto'] != 'all') {
                        
                    
                        if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                        
                        
                            echo"         <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px; $style'><i class='fa fa-times' aria-hidden='true'></i>
                        </a>
                            ";
                        
                        }
                        
                        if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full'){
                            
                            echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px; $style'><i class='fa fa-times' aria-hidden='true'></i>
                            </a>";
                        
                        }
                    
                    }
                }
                
                if($value['file'] !='#'){
                 echo "<a $anchor><i class='far fa-file-alt' style='$grey'></i></a>";
                 
                }
                else{
                    echo "<a ><i class='far fa-file-alt' style='$grey'></i></a>";
                    
                }

                  echo "<div class='dtitle'>$value[title]</div>
                    $expiry
                </div>";
                
                }

                // From User 
                
                // $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Recruitment' GROUP BY `title` ORDER BY `userdocuments`.`completion_date` DESC",array($user));
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `id` IN (SELECT max(`id`) FROM `userdocuments` WHERE `user`= ? AND `category`='Recruitment' GROUP BY `title`) ORDER BY `userdocuments`.`completion_date` DESC",array($user));

                $dupCount = 0;
                foreach ($data as $key => $value) {

                  $dataC = "SELECT count(*) as ttl FROM `userdocuments` WHERE `title`=? and `user`=? AND `category`='Recruitment'";
                  $dataC = $dbF->getRow($dataC,array($value['title'],$user));
                  
                if ($dataC['ttl'] <=1) {



                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='')
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                        
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                        }
                    
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc ABC all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                     
                    if ($value['title_id'] >0) {
                        
                        if ($data1['assignto'] != 'all') {
    
                            if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                                  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                              </a>";
                                
                            } 
                              
                            if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full'){
                        
                                  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                          </a>";
                            }
                        
                        }
                    }
                    
                   echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";
                   
// $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
//                             if ($dataC['ttl'] <=1) {

                 echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


// }

                if($value['file'] !='#'){echo $anchor ;}
                else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                
                echo "<div class='dtitle'>$value[title]</div>";
                            
                    echo $button; 
                    echo "</div>";
                
                                
                }else{


//  $dupCount++;
$dupCount=1;

if($dupCount == 1){

                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='') 
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";



                        $button .= "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc abc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                     
                    if ($value['title_id'] >0) {
                        if ($data1['assignto'] != 'all') {
    
                        if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                            
                              echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                      </a>";
                              } 
                              if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full'){
                        
                                  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                          </a>";
                                }
                        
                        }
                    }
                    
                   echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



                    $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                    
                    if ($dataC['ttl'] <=1) {
                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";
                    }


            if($value['file'] !='#'){echo $anchor ;}
               
            else{echo "<a><i class='far fa-file-alt'></i></a>";}
            
            echo "<div class='dtitle'>$value[title]</div>";
            
             echo $button;


            echo "<span>Total : ".$dataC['ttl']." Record</span></div>";
                


}

                }
              }
            ?>
            </div>
            </div>
        </div>
        
        
        
        
        <div id="tabs-4">
             <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
              <a onclick="documentsadd('Add_Signed_Policies','<?php echo $url_user ?>','1')"class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Signed Policies</a>
            <?php } ?>
             <div class="col-sm-12 alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Click on the tick button to read and sign policies
            </div>
            <div class="col4_main">
                <?php $echo =  $functions->documentClickAbleTitle("Signed Policies",$_SESSION['webUser']['id']); 

echo $echo[0];$allsubOptions = $echo[1];
                ?>
                                
                         
<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>


<!--<div id='extrauploadtabs-4'></div><div id='extrabuttontabs-4' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>-->
<!--<script>-->
<!--var extraObjtabs=$("#extrauploadtabs-4").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='title' value='' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /><input type='hidden' name='category' value='Signed Policies' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' name='c_date' class='datepicker' autocomplete='off'   value='' /><b>Expiry Date</b><input type='text' name='e_date' value='' class='datepicker' autocomplete='off'   /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#extrabuttontabs-4").click((function(){-->

<!--console.log("startUpload");-->

<!--extraObjtabs.startUpload()}));-->


<!--</script>   -->
          
            <div class="file-box">
                <?php
                // From Admin
 $data = $dbF->getRows("SELECT * FROM `documents` WHERE  `assignto` IN ('all','$user','all:$pid') AND `category`='Signed Policies' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user' AND `title_id` > 0 )");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {

                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                       echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>
                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       $title=str_replace("&","and",$value['title']);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
      }else{
      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
    //   echo $button;        

}
                       $id = base64_encode($value['id']."&d=".date('d'));
                        $tid = base64_encode(@$value['title_id']."&d=".date('d'));
                       if (@$value['title_id'] != '-1') {
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
    }
       

                       if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}

                    echo "<div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc all red'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Signed Policies'",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                              if ($ext == 'el') {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                     if ($value['title_id'] != '-1') {          
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>

                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>
                            ";
if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
        echo "<div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
            </div>
        </div>
        
        
        <div id="tabs-8">
            
             <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd('Add_Minute_Meeting','<?php echo $url_user ?>','2')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Minute Meeting</a>
            <?php } ?>
              <div class="col4_main">
    <?php  $echo = $functions->documentClickAbleTitle("Minute Meeting",$_SESSION['webUser']['id']);
echo $echo[0];$allsubOptions = $echo[1];

     ?>



<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>


<!--<div id='mmupload'></div><div id='mmbutton' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>-->
<!--<script>-->
<!--var mmObj=$("#mmupload").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='category' value='Minute Meeting' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' name='c_date' class='datepicker' autocomplete='off'   value='' /><b>Expiry Date</b><input type='text' name='e_date' class='datepicker' autocomplete='off'   value='' /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#mmbutton").click((function(){-->

<!--console.log("startUpload");-->

<!--mmObj.startUpload()}));-->


<!--</script>-->




            <div class="file-box">
                    <?php
                // From Admin
//                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Minute Meeting' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user' AND (`title_id` > 0 OR  `title_id` = -1 ))");
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Minute Meeting' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))"); 
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                        $id  = base64_encode($value['id']."&d=".date('d'));
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                           if ($ext == 'el' ) {

                           $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       $title=str_replace("&","and",$value['title']);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
      }else{
      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
    //   echo $button;        

}
                       // if ($value['title_id'] != '-1') {
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
    // }

if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}


       echo "
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc all red'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Minute Meeting'",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                        if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";
                     $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";
                              if($value['file'] != '#'){  
                           echo " <a $anchor><i class='far fa-file-alt'></i></a>";
                        }else{
                           echo  "<a href='javascript:;' class=''><i class='far fa-file-alt'></i></a>";
                        }
                               
                            
                          echo "  <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
            </div>

        </div><!-- tab-8 End -->
        
        
        <div id="tabs-5">
           <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd('Add_MHRA_Alert','<?php echo $url_user ?>','3')" class="myevents" ><i class="fas fa-plus"></i>&nbsp;Add MHRA Alert</a>
            <?php } ?>

              <div class="col4_main">
                                <?php $echo =  $functions->documentClickAbleTitle("MHRA",$_SESSION['webUser']['id']); 

echo $echo[0];$allsubOptions = $echo[1];
                                ?>




                                <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>


<!--<div id='mHRAupload'></div><div id='mHRAbutton' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>-->
<!--<script>-->
<!--var mHRAObj=$("#mHRAupload").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='category' value='MHRA' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' class='datepicker' name='c_date' autocomplete='off'   value='' /><b>Expiry Date</b><input type='text' class='datepicker' name='e_date' autocomplete='off'   value='' /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#mHRAbutton").click((function(){-->

<!--console.log("startUpload");-->
<!--mHRAObj.startUpload()}));-->
<!--</script>-->




           <div class="file-box">
  <?php
                // From Admin
                $data = $dbF->getRows("SELECT *  FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='MHRA' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user' AND `title_id` > 0)");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        
                        if (!in_array($ext, $allowed)) {
                           if ($ext == 'el' || $ext == 'txt'  || $ext == 'etxt' ) {

                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       $title=str_replace("&","and",$value['title']);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
      }else{
      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
    //   echo $button;        

}
                       $id = base64_encode($value['id']."&d=".date('d'));
                       // if ($value['title_id'] != '-1') {
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
    // }
if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
           echo "  
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc all red'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='MHRA'",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                          
                        if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                               if ($value['title_id'] != '-1') {
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");'href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>
                         ";
                          

if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                          echo " <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
            </div>
        </div>
        
        
        <div id="tabs-6">
               <?php // if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentInsert_profile_detail('Add_Additional_Document','<?php echo $url_user ?>','3')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Additional Document</a>
            <?php // } ?>
              <div class="col4_main">
                                <?php $echo =  $functions->documentClickAbleTitle("Additional Document",$_SESSION['webUser']['id']); 

echo $echo[0]; 

$allsubOptions = $echo[1];
                                ?>




                                <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>



<div id='extrauploadad'></div><div id='extrabuttonad' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>
<script>
var extraObjad=$("#extrauploadad").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='title' value='' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='category' value='Additional Document' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' name='c_date' class='datepicker' autocomplete='off'   value='' /><b>Expiry Date</b><input type='text' name='e_date' value='' class='datepicker' autocomplete='off'   /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#extrabuttonad").click((function(){

console.log("startUpload");

extraObjad.startUpload()}));


</script>



           <div class="file-box">

            <?php 
        
         
          // echo   $_SESSION['currentUserType'] ;
          // echo    $_SESSION['superUser']['hruser'] ;
          // echo  $user = $_SESSION['superid'];
                // From Admin

                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Additional Document' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))"); 
                foreach ($data as $key => $value) {
                     $value['id'];
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {
                 
                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
 
     // if($value['expiry'] < date('Y-m-d',strtotime('1 months'))){

     //                    $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
     //                }
                     
                  
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-upload'></i></button> 
";
$title=str_replace("&","and",$value['title']);

if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
      }else{
      echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
    //   echo $button;        

}
$id = base64_encode($value['id']."&d=".date('d'));
if (@$value['title_id'] != '-1') {
if ($value['assignto'] != 'all') {
    

  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"         <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
}
}
     if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}

  echo "                       
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }

                // From User 
                // $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Additional Document' GROUP BY `title` ORDER BY `userdocuments`.`completion_date` DESC",array($user));
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `id` IN (SELECT max(`id`) FROM `userdocuments` WHERE `user`= ? AND `category`='Additional Document' GROUP BY `title`) ORDER BY `userdocuments`.`completion_date` DESC",array($user));

                $dupCount = 0;
                foreach ($data as $key => $value) {

                  $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {



                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='')
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



// $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
//                             if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


// }





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "</div>";
                }else{


//  $dupCount++;
$dupCount=1;

if($dupCount == 1){

                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='') 
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";



                        $button .= "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



$dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


}





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "<span>Total : ".$dataC['ttl']." Record</span></div>";
                


}

                }
              }
            ?>
            </div>
            </div>
        </div>
        
        
        <div id="tabs-7">
            <div class="file-box">
                <?php
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                       $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) || !in_array($ext0, $allowed) || !in_array($ext1, $allowed) || !in_array($ext2, $allowed) || !in_array($ext3, $allowed) || !in_array($ext4, $allowed)) {
            if ($ext == 'el' || $ext == 'txt'  || $ext == 'etxt' ) {

                           $anchor = "href='".WEB_URL."/view-$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                             $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                
                            </a>";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                             <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                             <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?folD=$id'><i class='fas fa-trash-alt'></i></a>
                          ";
  if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                       echo " <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>

        </div><!-- tab-7 End -->
        
        
         <div id="tabs-9">
                  <a onclick="documentInsert_profile_detail('Private_Folder','<?php echo $url_user ?>','private')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Private Folder</a>
            <?php //} ?>
             
            <div class="col4_main">
                                <?php $echo =  $functions->documentClickAbleTitle("Private Folder",$_SESSION['webUser']['id']); 

echo $echo[0];
          $allsubOptions = $echo[1];                      ?>









<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>


<div id='pfupload'></div><div id='pfbutton' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>
<script>
var pfObj=$("#pfupload").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='category' value='Private Folder' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='date' name='c_date' class='datepicker' autocomplete='off' value='' /><b>Expiry Date</b><input type='date' class='datepicker' autocomplete='off'  name='e_date' value='' /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#pfbutton").click((function(){

console.log("startUpload");

pfObj.startUpload()}));


</script>



           <div class="file-box">

            <?php 
        
         
          // echo   $_SESSION['currentUserType'] ;
          // echo    $_SESSION['superUser']['hruser'] ;
          // echo  $user = $_SESSION['superid'];
                // From Admin

                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Private Folder' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))"); 
                foreach ($data as $key => $value) {
                     $value['id'];
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {
                 
                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
 
     // if($value['expiry'] < date('Y-m-d',strtotime('1 months'))){

     //                    $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
     //                }
                     
                  
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-upload'></i></button> 
";
// $title=str_replace("&","and",$value['title']);

// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
//       }else{
//       echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
//     //   echo $button;        

// }
$id = base64_encode($value['id']."&d=".date('d'));
if (@$value['title_id'] != '-1') {
if ($value['assignto'] != 'all') {
    

  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"         <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
}
}
     if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}

  echo "                       
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }

                // From User 
//                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Private Folder' GROUP BY `title` ORDER BY `userdocuments`.`completion_date` DESC",array($user));
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `id` IN (SELECT max(`id`) FROM `userdocuments` WHERE `user`= ? AND `category`='Private Folder' GROUP BY `title`) ORDER BY `userdocuments`.`completion_date` DESC",array($user));

                $dupCount = 0;
                foreach ($data as $key => $value) {

                  $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {



                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='')
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



// $dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
//                             if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


// }





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "</div>";
                }else{


//  $dupCount++;
$dupCount=1;

if($dupCount == 1){

                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $ext0 = pathinfo($value['file0'], PATHINFO_EXTENSION);
                        $ext1 = pathinfo($value['file1'], PATHINFO_EXTENSION);
                        $ext2 = pathinfo($value['file2'], PATHINFO_EXTENSION);
                        $ext3 = pathinfo($value['file3'], PATHINFO_EXTENSION);
                        $ext4 = pathinfo($value['file4'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed) ) {

                           
                                
                    
                             if ($value['file0'] !='') {
                                
                                if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                            }
                            elseif ($value['file'] !='') 
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                            else
                            { 

                            $anchor = "<a >  
                                <i class='far fa-file-alt'></i>
                            </a>";
                            }
                         
                            
                           
                        }
                        else{
                           
                             if ($value['file0'] !='') {
                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                           
                           }
                        }
                    }

                    if($value['expiry_date'] < date('Y-m-d',strtotime('1 months')) && $value['expiry_date'] > date('Y-m-d',strtotime('-12 months'))){
                          if ($value['title_id'] != '-1') {
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";



                        $button .= "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    }
                    else{
                          if ($value['title_id'] != '-1') {
                        
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button>";     
                    }
                    }
                    if($value['completion_date'] > date('Y-m-d',strtotime('01-Jan-2018'))){
                        $button .= "<span>Completion : ".date('d-M-Y',strtotime($value['completion_date']))."</span>";
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";

               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                            if ($value['title_id'] >0) {
                    if ($data1['assignto'] != 'all') {

if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } 
      if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }

}
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentViewGroup(this.id)'><i class='fas fa-eye'></i></button>";



$dataC = $dbF->getRow("SELECT count(*) as ttl FROM `userdocuments` WHERE `title`='$value[title]' and `user`='$user'");
                            if ($dataC['ttl'] <=1) {


                             echo "<a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";  


}





            if($value['file'] !='#'){echo $anchor ;}
               
                    else{echo "<a><i class='far fa-file-alt'></i></a>";}
                    echo "
                            <div class='dtitle'>$value[title]</div>";



                          
 echo $button;


                        echo "<span>Total : ".$dataC['ttl']." Record</span></div>";
                


}

                }
              }
            ?>
            </div>
            </div>

        </div><!-- tab-9 End -->
        
        
         <div id="tabs-10">
            
             <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd('Onboarding','<?php echo $url_user ?>','4')" class="myevents"><i class="fas fa-plus"></i>&nbsp;Add Onboarding</a>
            <?php } ?>
              <div class="col4_main">
    <?php  $echo = $functions->documentClickAbleTitle("Onboarding",$_SESSION['webUser']['id']);
echo $echo[0];$allsubOptions = $echo[1];

     ?>



<?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { 


$uUUID = $_SESSION['webUser']['id']; 


}else{ 
$userS =  htmlspecialchars($_GET['user']);
$uUUID = $userS; 
} ?>

<!--<div id='onbupload'></div><div id='onbbutton' class='ajax-file-upload-green customBtn' style='display:none;'>Start Upload</div>-->
<!--<script>-->
<!--var mmObj=$("#onbupload").uploadFile({url:"profile-detail",dragDrop:!0,fileName:"document",dragDropStr: "<span><b>Drop files here</b></span>",allowedTypes:"jpg,jpeg,bmp,gif,png,img,txt,pdf,psd,docx,doc,pptx,ppt,xlsx,xlr,xls,csv,pps,zip,gzip,rar,gz,tar,tar.gz,ios,max,dwg,eps,ai,torrent,html,css,js,xml,xhtml,rss,mp4,m4a,mp3,mpg3,3gp,flv,wmv,wav,mqv,mpeg4,swf,mov,mpg,avi,raw,wmv,rm,obj,odt,fodt,ods,fods,odp,fodp,odg,fodg,odf",extraHTML:function(){return"<div><input type='hidden' name='category' value='Minute Meeting' /><input type='hidden' name='submit' value='submit' /><input type='hidden' name='documentInsert_profile_details' value='documentInsert_profile_details' /><input type='hidden' name='user' value='<?php echo $uUUID ?>' /> <br/><b>Sub Category</b><select name='sub_category'><?php echo $allsubOptions; ?><option value=''>other</option></select><b>Completion Date</b><input type='text' name='c_date' class='datepicker' autocomplete='off'   value='' /><b>Expiry Date</b><input type='text' name='e_date' class='datepicker' autocomplete='off'   value='' /><b>Details</b><input type='text' name='desc' value='' /></div>"},autoSubmit:!1});$("#onbbutton").click((function(){-->

<!--console.log("startUpload");-->

<!--mmObj.startUpload()}));-->


<!--</script>-->




            <div class="file-box">
                    <?php
                // From Admin
//                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Minute Meeting' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user' AND (`title_id` > 0 OR  `title_id` = -1 ))");
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Onboarding' AND (`id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `title_id` > 0 AND`user`='$user' AND `title_id` > 0) OR `title` NOT IN (SELECT `title` FROM `userdocuments` WHERE `user`='$user'))"); 
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                        $id  = base64_encode($value['id']."&d=".date('d'));
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        // echo $value['id'];
                        if (!in_array($ext, $allowed)) {
                           if ($ext == 'el' ) {

                           $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
//                       $title=str_replace("&","and",$value['title']);

// if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') {   
//       }else{
//       echo "<button data-toggle='tooltip' title='Remind' id='$user:$title' type='button'  onclick='remindernotification(this.id)' style='top: 46px; $style' ><i class='fas fa-bell'></i></button> ";
//     //   echo $button;        

// }
                       // if ($value['title_id'] != '-1') {
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
    // }

if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}


       echo "
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc all red'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Onboarding'",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                        if ($ext == 'el'  ) {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";
                     $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='profile-detail?user=$user&alldocumentidPD=$tid' style='top: 8px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'><i class='fas fa-trash-alt'></i></a>";
                              if($value['file'] != '#'){  
                           echo " <a $anchor><i class='far fa-file-alt'></i></a>";
                        }else{
                           echo  "<a href='javascript:;' class=''><i class='far fa-file-alt'></i></a>";
                        }
                               
                            
                          echo "  <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
            </div>

        </div><!-- tab-10 End --> 
        
        
          <div id="tabs-11" >

<div class="cpd-table hr-absence profile" id="appraisalForm_main">
<div id="tabs_">
<ul id="gettabs">
    <?php if($_SESSION['currentUserType'] != 'Employee'  || $_SESSION['superUser']['hruser'] == 'full') {  ?>
<li><a href="#tabs-add" >Add</a></li>
<?php } ?>
<li><a href="#tabs-view" id="viewAppraisal">View</a></li>
</ul>
<?php if($_SESSION['currentUserType'] != 'Employee'  || $_SESSION['superUser']['hruser'] == 'full') {  ?>
<div class="alert alert-success appraisalAlert alert-dismissible fade show" role="alert" style="display:none;">
  <span id="appraisalAlertText"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div id="tabs-add">
<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>Staff Appraisal</h3></div>
<div class="form-group "></div><!-- form-group col-12 col-sm-6 -->
<div class="inner_forms">
<form class="profile" onsubmit = "event.preventDefault();" id="appraisalForm" method="post" >
<input type="hidden" name="userId" value="<?php echo $user; ?>">
<div class="row">

<div class="form-group col-12 col-sm-6" style=""><label>Date Appraisal Carried out</label>
 <input class="datepickerr form1Input" id="dateField" type="text" placeholder="Select one"  name="appraisal_date"  autocomplete="off"   onchange="$('#date_err').hide();" style="width: 99%;">
 <i class="fa fa-calendar" aria-hidden="true" style=" margin-left: -27px;"></i>
 <div id="date_err" style="color:red;display: none;">field is empty</div>
</div>
<div class="form-group col-12 col-sm-6" style="">
<label>Name of Practice Appraisee</label>

<select name="appraisee" class="form1Select" id="appraiseeSelect" onchange="$('#appraisee_err').hide();">
    <option value="">Select one</option>
    <?php echo $functions->allEmployees($_SESSION['allUsers'], $_SESSION['currentUser']);  ?>
</select>
<div id="appraisee_err" style="color:red;display: none;">field is not select</div>
</div>

                   
<div  class="form-group-progress">
                  
    <p>
                            <label for="minval-2" class="label3">Communication Skills</label>
                            <input type="text" id="minval-2" style="border:0; color:#0f75bd; font-weight:bold;" disabled="">
                        </p>
                        
                        <div class="form-control" style="border: none !important;">
                            <div id="slider-4" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 1%;"></span></div>
                        </div>
                    </div>
                </div>

        <!--<div class="form-control" style="border: none !important;">-->
        <!-- <div id="slider-4" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 1%;"></span></div>-->
                <!--        </div>-->
                <!--    </div>-->
                </div>
             

    

<?php 

echo '<div class="col-12">


<h3 style="width:100%;">Communication Skills</h3>
<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good personal image</label>
    <div class="inputs">
        <input type="radio" name="questions[personal_image_radio]" value="yes" id="personal_image">
        <label class="radioPointer" for="personal_image">Yes</label>
        <input type="radio" name="questions[personal_image_radio]" value="no" id="personal_image2">
        <label class="radioPointer" for="personal_image2">No</label>        
    </div>    
</div>
<textarea name="questions[personal_image_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse provide a good patient experience</label>
    <div class="inputs">
        <input type="radio" name="questions[patient_experience_radio]" value="yes" id="patient_experience">
        <label class="radioPointer" for="patient_experience">Yes</label>
        <input type="radio" name="questions[patient_experience_radio]" value="no" id="patient_experience2">
        <label class="radioPointer" for="patient_experience2">No</label>        
    </div>    
</div>
<textarea name="questions[patient_experience_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good patient rapport</label>
    <div class="inputs">
        <input type="radio" name="questions[patient_rapport_radio]" value="yes" id="patient_rapport">
        <label class="radioPointer" for="patient_rapport">Yes</label>
        <input type="radio" name="questions[patient_rapport_radio]" value="no" id="patient_rapport2">
        <label class="radioPointer" for="patient_rapport2">No</label>        
    </div>    
</div>
<textarea name="questions[patient_rapport_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good listening skill</label>
    <div class="inputs">
        <input type="radio" name="questions[listening_skill_radio]" value="yes" id="listening_skill">
        <label class="radioPointer" for="listening_skill">Yes</label>
        <input type="radio" name="questions[listening_skill_radio]" value="no" id="listening_skill2">
        <label class="radioPointer" for="listening_skill2">No</label>        
    </div>    
</div>
<textarea name="questions[listening_skill_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse maintains patient confidentiality</label>
    <div class="inputs">
        <input type="radio" name="questions[patient_confidentiality_radio]" value="yes" id="patient_confidentiality">
        <label class="radioPointer" for="patient_confidentiality">Yes</label>
        <input type="radio" name="questions[patient_confidentiality_radio]" value="no" id="patient_confidentiality2">
        <label class="radioPointer" for="patient_confidentiality2">No</label>        
    </div>    
</div>
<textarea name="questions[patient_confidentiality_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good communication with other team members</label>
    <div class="inputs">
        <input type="radio" name="questions[team_members_radio]" value="yes" id="team_members">
        <label class="radioPointer" for="team_members">Yes</label>
        <input type="radio" name="questions[team_members_radio]" value="no" id="team_members2">
        <label class="radioPointer" for="team_members2">No</label>        
    </div>    
</div>
<textarea name="questions[team_members_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good complaint handling skills</label>
    <div class="inputs">
        <input type="radio" name="questions[handling_skills_radio]" value="yes" id="handling_skills">
        <label class="radioPointer" for="handling_skills">Yes</label>
        <input type="radio" name="questions[handling_skills_radio]" value="no" id="handling_skills2">
        <label class="radioPointer" for="handling_skills2">No</label>        
    </div>    
</div>
<textarea name="questions[handling_skills_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has understanding of her role and responsibility</label>
    <div class="inputs">
        <input type="radio" name="questions[responsibility_radio]" value="yes" id="responsibility">
        <label class="radioPointer" for="responsibility">Yes</label>
        <input type="radio" name="questions[responsibility_radio]" value="no" id="responsibility2">
        <label class="radioPointer" for="responsibility2">No</label>        
    </div>    
</div>
<textarea name="questions[responsibility_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse contribute with team meetings</label>
    <div class="inputs">
        <input type="radio" name="questions[team_meetings_radio]" value="yes" id="team_meetings">
        <label class="radioPointer" for="team_meetings">Yes</label>
        <input type="radio" name="questions[team_meetings_radio]" value="no" id="team_meetings2">
        <label class="radioPointer" for="team_meetings2">No</label>        
    </div>    
</div>
<textarea name="questions[team_meetings_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has ability to answer questions asked by patients</label>
    <div class="inputs">
        <input type="radio" name="questions[asked_by_patients_radio]" value="yes" id="asked_by_patients">
        <label class="radioPointer" for="asked_by_patients">Yes</label>
        <input type="radio" name="questions[asked_by_patients_radio]" value="no" id="asked_by_patients2">
        <label class="radioPointer" for="asked_by_patients2">No</label>        
    </div>    
</div>
<textarea name="questions[asked_by_patients_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse presents positive attitude, drive and passion with the role</label>
    <div class="inputs">
        <input type="radio" name="questions[with_the_role_radio]" value="yes" id="with_the_role">
        <label class="radioPointer" for="with_the_role">Yes</label>
        <input type="radio" name="questions[with_the_role_radio]" value="no" id="with_the_role2">
        <label class="radioPointer" for="with_the_role2">No</label>        
    </div>    
</div>
<textarea name="questions[with_the_role_desc]" ></textarea>
</div>

<div class="form-group profile_textarea" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse shows initiative to carry out tasks required within the role</label>
    <div class="inputs">
        <input type="radio" name="questions[within_the_role_radio]" value="yes" id="within_the_role">
        <label class="radioPointer" for="within_the_role">Yes</label>
        <input type="radio" name="questions[within_the_role_radio]" value="no" id="within_the_role2">
        <label class="radioPointer" for="within_the_role2">No</label>        
    </div>    
</div>
<textarea name="questions[within_the_role_desc]" ></textarea>
</div>

</div>
';

?>
</div>

</div>
<input type="hidden" name="lastFormId"  class="lastFormId">
<div class="col-12">
<div class="form-group appraisalBtn ">
    
    <button  name="save" class="save_btn" data-form_type="communication" data-form_id="appraisalForm" onclick="appraisalFormAdd(this);" >Save</button>
    <button  name="next" class="next_btn" onclick="appraisalFormAdd(this);">Next</button>
</div>
</div>
</form>

<form class="profile" onsubmit = "event.preventDefault();" id="appraisalForm2" method="post" style="display:none;">
<input type="hidden" name="userId" value="<?php echo $user; ?>">
<input type="hidden" name="communicationId" id="communicationId">
<div class="row">

<div class="form-group col-12 col-sm-6" style=""><label>Date Appraisal Carried out</label>
 <input class="datepickerr form2Input"  type="text" placeholder="Select one"  name="appraisal_date"  autocomplete="off"   onchange="$('#date_err').hide();" style="width: 99%;">
 <i class="fa fa-calendar" aria-hidden="true" style=" margin-left: -27px;"></i>
 <div id="date_err" style="color:red;display: none;">field is empty</div>
</div>
<div class="form-group col-12 col-sm-6" style="">
<label>Name of Practice Appraisee</label>

<select name="appraisee" class="form2Select"  onchange="$('#appraisee_err').hide();">
    <option value="">Select one</option>
    <?php echo $functions->allEmployees($_SESSION['allUsers'], $_SESSION['currentUser']);  ?>
</select>
<div id="appraisee_err" style="color:red;display: none;">field is not select</div>
</div>
<div id="tabs-add2" style="width:100%">
    <div class="tabImage">
        <img src="<?php echo WEB_URL; ?>/webImages/appraisal2.webp">
    </div>
    

<?php 

echo '

<div class="col-12">
<h3 style="width:100%;">Clinical Skills</h3>
<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in explaining patient`s oral health and dental problems</label>
    <div class="inputs">
        <input type="radio" name="questions[dental_problems_radio]" value="yes" id="dental_problems">
        <label class="radioPointer" for="dental_problems">Yes</label>
        <input type="radio" name="questions[dental_problems_radio]" value="no" id="dental_problems2">
        <label class="radioPointer" for="dental_problems2">No</label>        
    </div>    
</div>
<textarea name="questions[dental_problems_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in explaining patient`s treatment plans and cost when required   </label>
    <div class="inputs">
        <input type="radio" name="questions[treatment_plans_radio]" value="yes" id="treatment_plans">
        <label class="radioPointer" for="treatment_plans">Yes</label>
        <input type="radio" name="questions[treatment_plans_radio]" value="no" id="treatment_plans2">
        <label class="radioPointer" for="treatment_plans2">No</label>        
    </div>    
</div>
<textarea name="questions[treatment_plans_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in explaining patient`s payment options - yes/no -score</label>
    <div class="inputs">
        <input type="radio" name="questions[payment_options_radio]" value="yes" id="payment_options">
        <label class="radioPointer" for="payment_options">Yes</label>
        <input type="radio" name="questions[payment_options_radio]" value="no" id="payment_options2">
        <label class="radioPointer" for="payment_options2">No</label>        
    </div>    
</div>
<textarea name="questions[payment_options_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in carrying out x-ray when required</label>
    <div class="inputs">
        <input type="radio" name="questions[carrying_out_radio]" value="yes" id="carrying_out">
        <label class="radioPointer" for="carrying_out">Yes</label>
        <input type="radio" name="questions[carrying_out_radio]" value="no" id="carrying_out2">
        <label class="radioPointer" for="carrying_out2">No</label>        
    </div>    
</div>
<textarea name="questions[carrying_out_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in assisting the dentist during clinical procedures</label>
    <div class="inputs">
        <input type="radio" name="questions[clinical_procedures_radio]" value="yes" id="clinical_procedures">
        <label class="radioPointer" for="clinical_procedures">Yes</label>
        <input type="radio" name="questions[clinical_procedures_radio]" value="no" id="clinical_procedures2">
        <label class="radioPointer" for="clinical_procedures2">No</label>        
    </div>    
</div>
<textarea name="questions[clinical_procedures_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in carrying out infection control procedures</label>
    <div class="inputs">
        <input type="radio" name="questions[control_procedures_radio]" value="yes" id="control_procedures">
        <label class="radioPointer" for="control_procedures">Yes</label>
        <input type="radio" name="questions[control_procedures_radio]" value="no" id="control_procedures2">
        <label class="radioPointer" for="control_procedures2">No</label>        
    </div>    
</div>
<textarea name="questions[control_procedures_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good surgery hygiene</label>
    <div class="inputs">
        <input type="radio" name="questions[surgery_hygiene_radio]" value="yes" id="surgery_hygiene">
        <label class="radioPointer" for="surgery_hygiene">Yes</label>
        <input type="radio" name="questions[surgery_hygiene_radio]" value="no" id="surgery_hygiene2">
        <label class="radioPointer" for="surgery_hygiene2">No</label>        
    </div>    
</div>
<textarea name="questions[surgery_hygiene_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse keeps her surgery clean and tidy at all times</label>
    <div class="inputs">
        <input type="radio" name="questions[all_times_radio]" value="yes" id="all_times">
        <label class="radioPointer" for="all_times">Yes</label>
        <input type="radio" name="questions[all_times_radio]" value="no" id="all_times2">
        <label class="radioPointer" for="all_times2">No</label>        
    </div>    
</div>
<textarea name="questions[all_times_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in carrying out stock orders</label>
    <div class="inputs">
        <input type="radio" name="questions[stock_orders_radio]" value="yes" id="stock_orders">
        <label class="radioPointer" for="stock_orders">Yes</label>
        <input type="radio" name="questions[stock_orders_radio]" value="no" id="stock_orders2">
        <label class="radioPointer" for="stock_orders2">No</label>        
    </div>    
</div>
<textarea name="questions[stock_orders_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in carrying out decontamination process </label>
    <div class="inputs">
        <input type="radio" name="questions[decontamination_process_radio]" value="yes" id="decontamination_process">
        <label class="radioPointer" for="decontamination_process">Yes</label>
        <input type="radio" name="questions[decontamination_process_radio]" value="no" id="decontamination_process2">
        <label class="radioPointer" for="decontamination_process2">No</label>        
    </div>    
</div>
<textarea name="questions[decontamination_process_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse is competent in disposal of waste</label>
    <div class="inputs">
        <input type="radio" name="questions[disposal_of_waste_radio]" value="yes" id="disposal_of_waste">
        <label class="radioPointer" for="disposal_of_waste">Yes</label>
        <input type="radio" name="questions[disposal_of_waste_radio]" value="no" id="disposal_of_waste2">
        <label class="radioPointer" for="disposal_of_waste2">No</label>        
    </div>    
</div>
<textarea name="questions[disposal_of_waste_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has good computer skills</label>
    <div class="inputs">
        <input type="radio" name="questions[computer_skills_radio]" value="yes" id="computer_skills">
        <label class="radioPointer" for="computer_skills">Yes</label>
        <input type="radio" name="questions[computer_skills_radio]" value="no" id="computer_skills2">
        <label class="radioPointer" for="computer_skills2">No</label>        
    </div>    
</div>
<textarea name="questions[computer_skills_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>I believe the dental nurse has knowledge and understanding of compliance activities</label>
    <div class="inputs">
        <input type="radio" name="questions[compliance_activities_radio]" value="yes" id="compliance_activities">
        <label class="radioPointer" for="compliance_activities">Yes</label>
        <input type="radio" name="questions[compliance_activities_radio]" value="no" id="compliance_activities2">
        <label class="radioPointer" for="compliance_activities2">No</label>        
    </div>    
</div>
<textarea name="questions[compliance_activities_desc]" ></textarea>
</div>

<div class="form-group" style="width:100%">
<div class="appraisal_inner">
    <label>List 3 objectives related to the practice goals for the-year</label>
    <div class="inputs">
        <input type="radio" name="questions[for_the-year_radio]" value="yes" id="for_the-year">
        <label class="radioPointer" for="for_the-year">Yes</label>
        <input type="radio" name="questions[for_the-year_radio]" value="no" id="for_the-year2">
        <label class="radioPointer" for="for_the-year2">No</label>        
    </div>    
</div>
<textarea name="questions[for_the-year_desc]" ></textarea>
</div>
</div>

';

?>
</div>
<input type="hidden" name="lastFormId"  class="lastFormId2">
<div class="form-group appraisalBtn">
    <button   class="back_btn"  onclick="previous();">Back</button>
    <button  name="save" class="save_btn" data-form_type="clinical" data-form_id="appraisalForm2" onclick="appraisalFormAdd(this);" >Save</button>
    <button  name="submit" class="submit_btn" onclick="appraisalFormAdd(this);" >Submit</button>
</div>

</form>

</div>
</div><!-- tabs-add -->
<?php } ?>
<div id="tabs-view">
<div class="crm_search">
<div class="">
<div class="form-group col-12 col-sm-6"><h3 style='width:100%;'>View Staff Appraisal</h3></div>

<div class="resources_search crm_search">
<!-- <select id="clientAddTbl_all_users" class="clientAddTbl_all_users">


<option value="all">Search By Category</option>
<option value="Serious Accident Incident Form">Serious Accident Incident Form</option>
<option value="Complaint Form">Complaint Form</option>



</select> -->


<input type="text" placeholder="Keywords" id="searchIsissue_serviceskywd" class="clientAddTbl_all_users_services clientAddTbl_all_users">
<!-- <button type="submit" id="resources_search"><i class='fas fa-search'></i></button> -->
</div>
<!-- resources_search -->
<?php 
// $currentUser = intval($_SESSION['webUser']['id']);
$sql  = "SELECT * FROM appraisal WHERE user_id = ? AND appraisee_id = ? ORDER BY `id` DESC";
$data = $dbF->getRows($sql,array($user, $pid));

echo '  <div class="cpd-table tableIBMS">


<div class="cpd-tbl">
<table  class="cpd-table tableIBMS">
<thead>
<tr>

<th>Appraisal Date </th>
<th>Given by</th>
<th>Given to</th>
<th>Status</th>
<th>Action</th>


</tr>
</thead>
<tbody>';
foreach ($data as $key => $value) {
$user_id =  $value['user_id'];
$appraisee_id =  $value['appraisee_id'];
$appraisal_date =  $value['appraisal_date'];

$type =  $value['type'];
$status =  $value['status'];

$tp = "Pending";
if($status == "1"){

$tp = "Complete";

}

echo '<tr class="removeKeyPress">
<td>'.Date('d-M-Y',strtotime($appraisal_date)).'</td>
<td>'.$functions->UserName($user_id).'</td>
<td>'.$functions->UserName($appraisee_id).'</td>
<td>'.$tp.'</td>
';


// echo "<td><button class='btn btn-danger' data-toggle='tooltip' title='Change Status' style='cursor: pointer;' id='" . $value['id'] . "' onClick='changeStatuses(this.id)'>";

// // echo $tp;
// echo "<i class='fas fa-sync-alt'></i>";


// echo "</button>";


echo "<td>";
$typess =  $value['type'];
// if($typess == "Complaint Form"){

// echo "<button class='btn btn-danger' data-toggle='tooltip' title='View all details' style='cursor: pointer;' id='" . $value['id'] . "' onClick='viewComplaintIssue(this.id)'><i class='fas fa-clipboard'></i></button>";
// }else{

echo '
<a  class="del-btn" id="' . $value['id'] . '" title="View all details" target="_blank" data-toggle="tooltip"  style="color: white;" onClick="viewCommunication(this.id)"><i class="fas fa-clipboard" ></i></a>&nbsp; ';

// }



// if($typess == "Complaint Form"){

// echo '<a class="btn btn-danger" href="printReports.php?id=' . base64_encode($value['id']) . ':Complaint Form" target="_blank" data-toggle="tooltip" title="Print/Save"><i class="fas fa-print"></i></a>';
// }else{

echo '<a class="del-btn" href="appraisalPrint.php?id=' . base64_encode($value['id']).'" target="_blank" data-toggle="tooltip" title="Print/Save" style="color: white;"><i class="fas fa-print" ></i></a>';
// }



echo "</td>";






echo "

</tr>";
}
?>
</tbody>
</table>
</div><!-- cpd-tbl -->


</div><!-- crm_search -->
</div><!-- tabs-view -->
</div><!-- tabs -->
</div>

</div>


        
    </div>
</div>
</div>
<!-- event_details -->
<script>



        

    // alert( this.text);


           
</script>
<script>
  function appraisalFormAdd(ths){
            var fieldId = $(ths).attr("class");
            var dateValue = $("#dateField").val();
            var appraiseeValue = $("#appraiseeSelect").val();
            var formType = "";
            if (dateValue == "") {
                $("#date_err").show();
            }
            if (appraiseeValue == "") {
                $("#appraisee_err").show();
            }
            if (dateValue != "" && appraiseeValue != "") {
                if (fieldId == "submit_btn") {
                    // $(".lastFormId").val("");
                    formType = "clinical";
                    formId =  '#appraisalForm2';
                    formStatus  = 1;
                }else if (fieldId == "next_btn") {
                    formType = "communication";
                    formId =  '#appraisalForm';
                    formStatus = 0;
                }else if (fieldId == "save_btn") {
                    formType = $(ths).attr("data-form_type");
                    formId =  "#" + $(ths).attr("data-form_id");
                    formStatus = 0;
                }
                console.log(formType+"-----"+formId);
                // return false;
            $.ajax({
                    type: 'post',
                    url: '<?php echo WEB_URL; ?>/ajax_call.php?page=appraisalForm',
                    data: $(formId).serialize()+ '&formStatus=' + formStatus,
                    success: function (result) {
                        console.log(result+"-----");
                      if (result != "") {
                        $(".appraisalAlert").hide();
                        if (fieldId == "submit_btn") {
                            
                            location.reload();
                            
                            var active = $("#tabs_").tabs("option", "active");
                            $("#tabs_").tabs("option", "active", active + 1);

                            $('#appraisalForm')[0].reset();
                            $('#appraisalForm2')[0].reset();
                            
                            $(".form1Input").attr("id","dateField");
                            $(".form1Select").attr("id","appraiseeSelect");

                            $(".form2Input").removeAttr("id");
                            $(".form2Select").removeAttr("id");


                            $("#appraisalForm").show();
                            $("#appraisalForm2").hide();
                            

                            $(".lastFormId").val("");
                            $("#appraisalAlertText").text("Staff Appraisal form submitted successfully.");
                            $(".appraisalAlert").show();
                            
                            
                        }else if (fieldId == "save_btn") {
                                $("#appraisalAlertText").text("Staff Appraisal form saved successfully.");
                                $(".appraisalAlert").show();
                                if(formType == "communication"){
                                    $(".lastFormId").val(result);
                                }else{
                                    $(".lastFormId2").val(result);
                                }
                            }else{
                                
                            $("#appraisalForm2").show();
                            // $(".back_btn").show();
                            // $(".submit_btn").show();
                            // $(".next_btn").hide();
                            $("#appraisalForm").hide();
                            
                            var form1Input = $(".form1Input").val();
                            var form1Select = $(".form1Select").val();
                            $(".form2Input").val(form1Input);
                            $(".form2Select option[value="+form1Select+"]").attr('selected', 'selected');

                            $(".form1Input").removeAttr("id");
                            $(".form1Select").removeAttr("id");
                            
                            $(".form2Input").attr("id","dateField");
                            $(".form2Select").attr("id","appraiseeSelect");

                            $(".lastFormId").val(result);
                            $("#communicationId").val(result);
                            
                        }
                            $('html, body').animate({
                                scrollTop: $("#appraisalForm_main").offset().top
                            }, 2000);
                      }
                    }
                  });
            }else{
                $('html, body').animate({
                    scrollTop: $("#appraisalForm_main").offset().top
                }, 2000);
            }
        }

        function previous(){
            $("#appraisalForm").show();
            // $(".next_btn").show();
            $("#appraisalForm2").hide();
            // $(".back_btn").hide();
            // $(".submit_btn").hide();
            $(".appraisalAlert").hide();

            $(".form1Input").attr("id","dateField");
            $(".form1Select").attr("id","appraiseeSelect");

            $(".form2Input").removeAttr("id");
            $(".form2Select").removeAttr("id");

            $('html, body').animate({
                    scrollTop: $("#appraisalForm_main").offset().top
                }, 2000);
        }

        function AjaxDelScript(indx,ths){
            btn=$('.DelScript'+indx+ths);
            console.log(indx);
            console.log(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteSingleDocumentFileTrash',   
                    data: { indx:indx,ths:ths}
                }).done(function(data)
                {
                 ift =true;
                        console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(btn).closest('div').css('background','e5f3f2');
        $(btn).closest('div').fadeOut(800,function(){
           $(btn).remove();
        });
          }else{
        alert('Invalid ID.');
          }
                   
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
            }
        };


        //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }


  
</script>
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
</div>
<!-- index_content -->
<?php include_once('dashboardfooter.php'); ?>