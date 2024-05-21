<?php
include_once("global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
global $dbF, $webClass;

$login = $webClass->userLoginCheck();
if (!$login) {
    header('Location: login');
}


$chk1 = $functions->commentSubmit();
     $msg ='';
         if($chk1){

            echo  $msg = "Comment Inserted Successfully";
         }

$chk2 = $functions->postSubmit();
     $msg ='';
         if($chk2){

           
            echo  $msg =  "Post Saved Successfully";
         }


 
         
// include_once('header.php');
include 'dashboardheader.php';
?>
<div class="offline">You are currently offline</div>
<div class="index_content mypage">
    <div class="right_side">
        <!-- <div class="link_menu">
            <span>
                <img src="<?= WEB_URL?>/webImages/menu.png" alt="">
            </span>
            News
        </div> -->

    <div class="inner_intranet" >
            
     <?php if($msg!=''){ ?>
     <div class="col-sm-12 alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <?php echo @$msg; ?>
                </div>
            <?php } ?>
    <div class="intranet_profile">
                    <div class="profile_img">
                        <div class="inner_img">
                            <?php
                            if($_SESSION['webUser']['image']=="#" || $_SESSION['webUser']['image']==""){
                              $image='default_profile.jpg';
                            
                            }else{
                              $image=$_SESSION['webUser']['image'];
                             $viewimage  =  $functions->UserImage($_SESSION['webUser']['id']);
                             $viewimagem = WEB_URL . "/images/$viewimage";
                            }
                            
                            ?>
                            <img src=" <?php echo  WEB_URL.'/images/'.$image?>" alt="profile-img">
                            <!--<img src="<?php //echo $viewimagem?>" alt="profile-img">-->
                            
                        </div>
                    </div>

                    <div class="inner_detail">
                        <h1 class="prof_name"><?php echo $_SESSION['webUser']['name']?></h1>
                        <?php
                        $id = $_SESSION['webUser']['id'];
                        $sql    = "SELECT * FROM accounts_user_detail WHERE id_user = '$id'";
                        $userInfo   = $dbF->getRows($sql);
                        ?>
                        <div class="role">
                            <span class="fas fa-user"></span>
                            <a href="#">
                                <p><?php echo $webClass->webUserInfoArray($userInfo,'role');?></p>
                            </a>
                        </div>
                        <div class="role">
                            <span class="fas fa-phone"></span>
                            <a href="tel:<?php echo $webClass->webUserInfoArray($userInfo,'phone');?>">
                                <p><?php echo $webClass->webUserInfoArray($userInfo,'phone');?></p>
                            </a>
                        </div>
                        <div class="role">
                            <span class="fas fa-envelope"></span>
                            <a href="mailto:<?php echo $_SESSION['webUser']['email']?>">
                                <p><?php echo $_SESSION['webUser']['email']?></p>
                            </a>
                        </div>
                        <div class="role">
                            <span class="fas fa-birthday-cake"></span>
                            <p><?php echo $webClass->webUserInfoArray($userInfo,'date_of_birth');?></p>
                        </div>
                        <div class="role">
                            <span class="fas fa-building"></span>
                            <p><?php echo $webClass->webUserInfoArray($userInfo,'address');?></p>
                        </div>

                        <div class="btn">
                            <button class="edt_btn" onclick="window.location='<?php echo WEB_URL; ?>/profile?page=Profile';">Edit Profile</button>
                        </div>
                    </div>

                </div>
<?php 

$user = $_SESSION['webUser']['id'];

  $viewimage  =  $functions->UserImage($_SESSION['webUser']['id']);
   $viewimagem = WEB_URL . "/images/$viewimage";
   $viewnamem  =  $functions->UserName($_SESSION['webUser']['id']);

            if ($viewimage == "#" ||trim($viewimage) == "" ) 
                {
                    
                    $viewimagem= WEB_URL."/images/default_profile.jpg";
                 }
                
 ?>

            <div class="grid">
             <div class='news-detail clickPost' onclick="postadd('<?php echo $user ?>')" >
    
               <div class='imgset'> <img src='<?php echo $viewimagem ?> ' style='    width: 44px;
    height: 45px;
    display: inline-block;
    vertical-align: middle;
    max-height: 48px;
    border-radius: 50%;
    object-fit: cover;'></div>
   <input type='text' class='' name='' placeholder="What's on your mind  <?php echo $viewnamem ?> "    style='border-radius: 18px;background-color: #e7eeef;border: none;height: 33px; padding-left: 15px; width:90%;cursor: pointer;'>
                  <hr>
                  <div class="photoClick">
                  <i class="fas fa-image"></i> Photo's
                  </div>
                
             </div>



<?php
 

    $type = htmlspecialchars($_GET['type']);
    $currentUser       = $_SESSION['currentUser'];
    $sql1  = "SELECT * from post where publish = '1' AND type='post' AND `user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$currentUser' AND `setting_name`='account_under') OR user = '$currentUser' ORDER BY `post`.`id` DESC";
    $data1 = $dbF->getRows($sql1); 
            
    foreach ($data1 as $key => $value) {
    $sql2  = "SELECT * from accounts_user where  `acc_id` = '$value[user]'  ";
    $data2 = $dbF->getRow($sql2);
    $sql3  = "SELECT * FROM `comments` where  postid='$value[id]' ORDER BY `id` DESC LIMIT 3";
    $data3 = $dbF->getRows($sql3); 
    $sql4  = "SELECT * FROM `comments` where  postid='$value[id]'";
    $data4 = $dbF->getRows($sql4);
   
    // count($data3);
    // count($data4);
     "<br>";
   
   $cont = count($data4) - count($data3);
 
        $id      = $value['id'];
        $heading = translatefromserialize($value['heading']);
        $desc    = translatefromserialize($value['dsc']);
        $date    = date('d-M-Y', strtotime($value['date']));
        $datetime    = date('h', strtotime($value['dateTime']));
        $from1       = date('Y-m-d H:i:s',strtotime($value['dateTime']));
        $to1         = date('Y-m-d H:i:s');
// -------datetime
        $total1      = strtotime($to1) - strtotime($from1);
        $hours1      = floor($total1 / 60 / 60);
        $minutes1    = round(($total1 - ($hours1 * 60 * 60)) / 60);
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 

          $hd1 = "";
        if($hours1 == 0){
              $hd1 = "$minutes1 m"; 
          } 
          else if ($hours1 > 24) {

            $total_d1      = strtotime($to1) - strtotime($from1);
            $days1 = floor($total_d1 / 86400);  // (60 * 60 * 24)
             $hd1 = "$days1 d";
        
             }else{
              $hd1 = "$hours1 h";

             }
       
        
//------- datetime

        $image    = $value['image'];
        $img    = WEB_URL . "/images/$image";
        $acc_image = $data2['acc_image'];   
        $acc_name = $data2['acc_name'];   
       $acc_image = WEB_URL . "/images/$acc_image";
        $link    = WEB_URL . "/item-$id";

 if ($data2['acc_image'] == "#" ||trim($data2['acc_image']) == "" ){
                    
                    $acc_image= WEB_URL."/images/default_profile.jpg";
                 }
  if ($value['user'] == 'admin') { 
     
  
 $acc_image = WEB_URL."/webImages/logo.png?magic=01";
  $acc_name = "Dental Community";     
       }

       $dateTime = $value['dateTime'];
     
             
               
               echo "
                <div class='news-detail' >
                 <div class='accimage'> 
                 <div class='imgset'> <img src='$acc_image'></div>
                <div class='acc_detail'> 
                   <h4>$acc_name</h4>
                   
                   <p data-toggle='tooltip' title='".date("l jS \of F Y h:i:s A",strtotime($value['dateTime']))."'>$hd1   </p>
                
                 
                 </div>";
if ($value['user'] == $data2['acc_id']) { 
              echo "<div class='acc_action' style='float:right;'>
                   <a data-id='$id' onclick='AjaxDelScript(this);' class='btn edit_btn secure_delete' style=width: 45px;'>

                                    <i class='fa fa-ellipsis-v' ></i>
                                    <i class='glyphicon glyphicon-trash trash fa fa-trash' ></i>
                                    <i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i>
                                </a>
                   </div>";
}
               echo "</div>
                 <div class='news-detail-box'>
                 <p>{$desc}</p>
                <br>";
                if($image){
                 echo "<img src='$img' ><br>";
                }
                echo "
                </div>
                <br>
                <p class='post_date' data-toggle='tooltip' title='Saturday 9th of April 2022 09:12:40 AM'>
                            $dateTime</p>
                <hr>";
if ($value['user'] != 'admin') {



            echo " <div class='commentbtn' style='cursor: pointer;'>
               <i class='material-symbols-outlined' >chat_bubble</i>&nbsp;
               <span>".count($data4)." Comments</span>
               </div>
                 <hr>
              <div class='areatbtn cmt'>

                 <div class='imgset'> <img src='$viewimagem'></div>
                 <div class='btncomment'>";
              echo "
              <form  action='$link' method='post'>
                  <input type='text' class='comment' name='commentintsert' placeholder='Write a Comment'>
                  <input type='hidden' name='postid' value='$id'>
                   <button type='submit' class='print' name='commentsubmit' aria-hidden='true'  ><i class='fa fa-paper-plane' style='margin-left: -2px;'></i></button>
                  </form>
                  
                  </div>
                  </div>
<div class='cmt cmt1'>
                  ";

foreach ($data3 as $key => $value3) {
  $viewimage  =  $functions->UserImage($value3['user']);
   $viewimage = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value3['user']);
   if ($viewimage == WEB_URL."/images/#" || $viewimage == "#" ||trim($viewimage) == "" ) 
                {
                    
                    $viewimagem= WEB_URL."/images/default_profile.jpg";
                 }else
                 {
                   $viewimagem = $viewimage;
                 }
        //$date    = date('d-M-Y', strtotime($value3['date']));
        $datetime    = date('h', strtotime($value3['dateTime']));
        $from2       = date('Y-m-d H:i:s',strtotime($value3['dateTime']));
        $to2         = date('Y-m-d H:i:s');
// -------datetime
        $total2      = strtotime($to2) - strtotime($from2);
        $hours2      = floor($total2 / 60 / 60);
        $minutes2    = round(($total2 - ($hours2 * 60 * 60)) / 60);
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 

          $hd2 = "";
        if($hours2 == 0){
              $hd2 = "$minutes2 m"; 
          } 
          else if ($hours2 > 24) {

            $total_d2      = strtotime($to2) - strtotime($from2);
            $days2 = floor($total_d2 / 86400);  // (60 * 60 * 24)
             $hd2 = "$days2 d";
        
             }else{
              $hd2 = "$hours2 h";

             }
       
        
//------- datetime
     echo " <div class='viewcomment'>
            <div class='viewacc'> 
            <div class='imgset'> <img src='$viewimagem'></div>
            <div class='darkview'>
            <div class='acc_detail'> 
            <strong style='float: left;cursor: pointer;'>$viewname
            </strong>
     <p data-toggle='tooltip' title='".date("l jS \of F Y h:i:s A",strtotime($value3['dateTime']))."'>$hd2 </p>
           </div>
            <br><span style='padding-left: 5px;'>$value3[comment]</span>
</div>
                 </div>
                </div>";

}
            echo "</div>

            <div class='more_btn'>
                 <a class='viewmore' href=' $link ' >"; if($cont != '0'){echo "See $cont More Comment(s)"; }
                 
                 echo "</a> </div>";

    }
            echo "</div>";


           
    }

?>
        </div>

        <div class="intranet_activity">
                    <div class="active_user">
                        <h4>Co-workers</h4>
                    </div>
<?php   
$user = $_SESSION['webUser']['id'];
$currentUser = $_SESSION['currentUser'];
$sql4 = "SELECT * FROM `accounts_user` WHERE `acc_type` = 1 AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$currentUser' AND `setting_name`='account_under' )OR acc_id = '$currentUser'  ";
        $data5 = $dbF->getRows($sql4);
        $op = ""; 
  
foreach ($data5 as $key => $value4) {
  $viewimage  =  $functions->UserImage($value4['acc_id']);
   $viewimage = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value4['acc_id']);
 // $strViewname=substr($viewname, 0, strrpos($viewname, ' '));
  $viewname = explode(" ", $viewname);
 $strViewname = $viewname[0]; //Laura

        
            if ($value4['acc_image'] == WEB_URL."/images/#" ||trim($value4['acc_image']) == ""  || $value4['acc_image'] == '#') 
                {
                    
                    $image = WEB_URL."/images/default_profile.jpg";
                 }
                 else
                 {

                    $image = $viewimage;



                 }

     echo " 
            <div class='view_account'> 
             <div class='other_user'><img src='$image' ></div>
            <div class='darkview'>
            <strong style='float: left;cursor: pointer;'>$strViewname</strong></div>
                 </div>
               ";
    }



  ?> 
                    <!-- <div class="view_account">
                        <div class="other_user"><img src="webImages/user1.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">John Doe Saim Smith9868563564952</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/images/profile image/2020/04/683-dentist.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Nichola</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/images/profile image/2020/04/369-dentist-male.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Raj</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/images/profile image/2020/05/653-image002.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Sarah</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/images/profile image/2022/10/135-20221020122831-vanilla-12.5s-286px-2.gif">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Mohammed</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Leeanna</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Maria</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Syeda</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/images/profile image/2022/10/290-20221020123034-vanilla-12.5s-286px-1.gif">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Jawwad</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">hina</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">alexa</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">anna</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="webImages/feed.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">Heidih</strong>
                        </div>
                    </div>
                    <div class="view_account">
                        <div class="other_user"><img src="https://smartdentalcompliance.com/webImages/default_profile.jpg">
                        </div>
                        <div class="darkview">
                            <strong style="float: left;cursor: pointer;">areesh</strong>
                        </div>
                    </div> -->
                </div>

        <div class="right_detail">
            

<?php   
$user = $_SESSION['webUser']['id'];
$currentUser = $_SESSION['currentUser'];
$sql4 = "SELECT * FROM `accounts_user` WHERE `acc_type` = 1 AND `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$currentUser' AND `setting_name`='account_under' )OR acc_id = '$currentUser'  ";
        $data5 = $dbF->getRows($sql4);
        $op = ""; 
  
foreach ($data5 as $key => $value4) {
  $viewimage  =  $functions->UserImage($value4['acc_id']);
   $viewimage = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value4['acc_id']);
 // $strViewname=substr($viewname, 0, strrpos($viewname, ' '));
  $viewname = explode(" ", $viewname);
 $strViewname = $viewname[0]; //Laura

        
            if ($value4['acc_image'] == WEB_URL."/images/#" ||trim($value4['acc_image']) == ""  || $value4['acc_image'] == '#') 
                {
                    
                    $image = WEB_URL."/webImages/default_profile.jpg";
                 }
                 else
                 {

                    $image = $viewimage;



                 }

     echo " 
            <div class='view_account'> 
             <div class='imgset'><img src='$image' ></div>
            <div class='darkview'>
            <strong style='float: left;cursor: pointer;'>$strViewname</strong></div>
                 </div>
               ";
    }



  ?> 



        </div>

        </div>
        <!-- right_side close -->
    </div>

    <!-- left_right_side -->

       <!-- isotope  Script -->
      
    <!-- isotope END Script -->
    
    <!-- delete Script -->
    <script>
        function AjaxDelScript(ths){
            btn=$(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deletepost',   
                    data: { itemId:id }
                }).done(function(data)
                {
                    ift =true;
                    //    console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
                     
            var $grid = $('.grid').isotope({
              // options
            });

         

        // Remove row from HTML Table
        $(ths).closest('.news-detail').css('background','e5f3f2');
        $(ths).closest('.news-detail').fadeOut(800,function(){
           $(ths).remove();
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
     <!-- delete END Script -->
    <?php include_once('dashboardfooter.php');?>