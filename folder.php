<?php
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

$user = $_GET['user'];
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
<div class="event_details profile" id="myform">
    <h3>
        Details<div data-toggle="tooltip" title="Help Video" style="position: absolute;margin-left: 10px;top: 20px;" class="help" onclick="video('Y_yht7E7XIk')"><i class="fa fa-question-circle"></i></div>
    </h3>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Profile</a></li>
            <li><a href="#tabs-2">Training</a></li>
            <li><a href="#tabs-3">Recruitment</a></li>
            <li><a href="#tabs-4">Signed Policies</a></li>
            <li><a href="#tabs-8">Minute Meeting</a></li>
            <li><a href="#tabs-5">MHRA Alerts</a></li>
            <li><a href="#tabs-6">Additional Document</a></li>
            <li><a href="#tabs-7">Archive</a></li>
        </ul>
        
        <div id="tabs-1" class="staff-profile">
            <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd()" ><i class="fas fa-plus"></i>&nbsp;Document</a>
            <?php } ?>

          <?php  

 $image = $userData['acc_image'];

               
                 $iamge2 = "d-profile.png";
                  if ($image == "#"||trim($image) == "" ) 
                {
                     $image = $image2;
                    $image = "webImages/d-profile.png";
                 }
                 else
                 {
                    $image = "images/$userData[acc_image]";
                 }
                   
                //    $image = $functions->resizeImage($image, 'auto', 80, false);

                  ?>
                  
            <a href="profile?page=Edit Profile&userId=<?php echo $user ?>"><i class="fas fa-edit"></i></a>
            <img src="<?php echo $image  ?>">
            <div class="name"><?php echo $userData['acc_name'] ?></div>
            <div class="row">
                <div class="col-sm-6">Email : <?php echo $userData['acc_email'] ?></div>
                <div class="col-sm-6">Role : <?php echo $role ?></div>
                <div class="col-sm-6">Date of Birth : <?php echo $dob ?></div>
                <div class="col-sm-6">Phone : <?php echo $phone ?></div>
                <div class="col-sm-6">GDC Number : <?php echo $gdc ?></div>
                <div class="col-sm-6">Hours Work : <?php echo $hours_worked ?></div>
            </div>
            <br>
            <br>
        </div>
        <div id="tabs-2">
             <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd()" style="color: #f2701d;cursor: pointer;font-size: 18px;right: auto;left: 0;"><i class="fas fa-plus"></i>&nbsp;Document</a>
            <?php } ?>
             <div class="col-sm-12 alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Please Upload The Latest certificates can be added through the add document button 
            </div>
           <div class="file-box">

            <?php
        
         
          // echo   $_SESSION['currentUserType'] ;
          // echo    $_SESSION['superUser']['hruser'] ;
          // echo  $user = $_SESSION['superid'];
                // From Admin
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Training' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    if($value['expiry'] > date('Y-m-d',strtotime('-1 months'))){
                        $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
                    }
                     $id = base64_encode($value['id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-upload'></i></button> 
";
if ($value['assignto'] != 'all') {
    

  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
}
  echo "                       
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='Training' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
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
                                  
                                  $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                            }
                            else
                            { 

                            $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
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

                    if($value['expiry_date'] > date('Y-m-d',strtotime('-1 months'))){
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    // $id = base64_encode($value['id']);

                     $id = base64_encode($value['id']."&d=".date('d'));

                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>";
               // echo $value['title_id'];
                     $data1 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data1['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
}
                           echo " <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                             <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                               $anchor  
                            <div class='dtitle'>$value[title]</div>
                            $button
                        </div>";
                }
            ?>
            </div>
        </div>
        <div id="tabs-3">
             <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd()" style="color: #f2701d;cursor: pointer;font-size: 18px;right: auto;left: 0;"><i class="fas fa-plus"></i>&nbsp;Document</a>
            <?php } ?>
            <div class="file-box">
                <?php
                // From Admin
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Recruitment' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    if($value['expiry'] > date('Y-m-d',strtotime('-1 months'))){
                        $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
                    }

                    echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-upload'></i></button>
";
if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
      // <i class='far fa-file-alt'></i>
       echo "  
                            <a $anchor>
                              <i class='far fa-file-alt'></i>

                            </a>
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='Recruitment' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
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

                             $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)' style='cursor: pointer;'> <i class='far fa-file-alt'></i></a>";
                        }
                        else{
                             $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                <i class='far fa-file-alt'></i>
                            </a>";
                        }
                    }
                    if($value['expiry_date'] > date('Y-m-d',strtotime('-1 months'))){
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    // $id = base64_encode($value['id']);
                     $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>";
                      $data2 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data2['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }}

                          echo "     <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                             <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                                $anchor
                             
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            $button
                        </div>";
                }
            ?>
            </div>
        </div>
        <div id="tabs-4">
            
             <div class="col-sm-12 alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              Click on the tick button to read and sign policies
            </div>
            <div class="file-box">
                <?php
                // From Admin
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Signed Policies' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
       echo "  

                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='Signed Policies' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    // $id = base64_encode($value['id']);
                     $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
        </div>
        <div id="tabs-8">
            <div class="file-box">
                    <?php
                // From Admin
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Minute Meeting' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id  = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
       echo "  

                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='Minute Meeting' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    // $id = base64_encode($value['id']);
                     $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>

        </div><!-- tab-8 End -->
        <div id="tabs-5">
           <div class="file-box">
  <?php
                // From Admin
                $data = $dbF->getRows("SELECT *  FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='MHRA' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                     echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>

                       ";
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
       echo "  

                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            <span>Not Signed</span>
                        </div>";

                    // echo "<div class='file-box-desc'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }

                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='MHRA' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    // $id = base64_encode($value['id']);
                     $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data3['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                          echo " 
                            <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                            <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>
        </div>
        <div id="tabs-6">
               <?php if($_SESSION['currentUserType'] != 'Employee' || $_SESSION['superUser']['hruser'] == 'edit' || $_SESSION['superUser']['hruser'] == 'full') { ?>
                <a onclick="documentsadd()" style="color: #f2701d;cursor: pointer;font-size: 18px;right: auto;left: 0;"><i class="fas fa-plus"></i>&nbsp;Document</a>
            <?php } ?>
            <div class="file-box">
              
                <?php
                // From Admin
                $data = $dbF->getRows("SELECT * FROM `documents` WHERE `assignto` IN ('all','$user','all:$pid') AND `category`='Additional Document' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user')");
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    $expiry = "";
                     if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    if($value['expiry'] > date('Y-m-d',strtotime('-1 months'))){
                        $expiry = "<span>Expiry : ".date('d-M-Y',strtotime($value['expiry']))."</span>";     
                    }

                    echo "<div class='file-box-desc'>
                            <button data-toggle='tooltip' title='Upload' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-upload'></i></button>

                             ";
                             if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$id' style='top: 9px;'><i class='fa fa-times' aria-hidden='true'></i>
</a>";

    }
    }
       echo "  
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            $expiry
                        </div>";
                }
                
                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `category`='Additional Document' AND `archive`='0'");
                foreach ($data as $key => $value) {
                    $anchor = "<a href='#' > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>0";
                    $button = "";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    if($value['expiry_date'] > date('Y-m-d',strtotime('-1 months'))){
                        $button = "<button data-toggle='tooltip' title='Upload' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentUpdate(this.id)'><i class='fas fa-upload'></i></button><span>Expiry : ".date('d-M-Y',strtotime($value['expiry_date']))."</span>";     
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                    ";
                             $data6 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[title_id]' ");
                    if ($data6['assignto'] != 'all') {
if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='manage-users?alldocumentidFolder=$tid' style='top: 83px;'><i class='fa fa-times' aria-hidden='true'></i>
                                  </a>";

 }
 }

                         
                          echo " 
                             <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                             <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                            <a $anchor>
                                <i class='far fa-file-alt'></i>
                            </a>
                            <div class='dtitle'>$value[title]</div>
                            $button
                        </div>";
                }
            ?>
            </div>
        </div>
        <div id="tabs-7">
            <div class="file-box">
                <?php
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`='$user' AND `archive`='1'");
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

                            $anchor = "<a  id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentallfileView(this.id)'> <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                        }
                        else{
                             $anchor = "<a  href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'>  
                                
                            </a>";
                        }
                    }
                    // $id = base64_encode($value['id']);
                     $id = base64_encode($value['id']."&d=".date('d'));
                    echo "<div class='file-box-desc'>
                             <button data-toggle='tooltip' title='View' class='eye' id='$value[title_id]&user=$user&uid=$value[id]' type='button' onclick='documentView(this.id)'><i class='fas fa-eye'></i></button>
                             <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='manage-users?folD=$id'><i class='fas fa-trash-alt'></i></a>
                            $anchor
                                
                            </a>
                            <div class='dtitle'>$value[title]</div>
                        </div>";
                }
            ?>
            </div>

        </div><!-- tab-7 End -->
          
        
    </div>
</div>
<!-- event_details -->
<script>
$("#tabs").tabs();
$('[data-toggle="tooltip"]').tooltip(); 
</script>