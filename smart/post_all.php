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


 
         
include_once('header.php');
include 'dashboardheader.php';
?>

<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            News
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'post_all'; include 'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        <div class="right_side" >
            
     <?php if($msg!=''){ ?>
     <div class="col-sm-12 alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <?php echo @$msg; ?>
                </div>
            <?php } ?>
<?php 

$user = $_SESSION['webUser']['id'];

  $viewimage  =  $functions->UserImage($_SESSION['webUser']['id']);
   $viewimagem = WEB_URL . "/images/$viewimage";
   $viewnamem  =  $functions->UserName($_SESSION['webUser']['id']);

            if ($viewimage == "#" ||trim($viewimage) == "" ) 
                {
                    
                    $viewimagem= WEB_URL."/webImages/d-profile.png";
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
    $data1 = $dbF->getRows($sql1,array($type)); 
            
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
                    
                    $acc_image= WEB_URL."/webImages/d-profile.png";
                 }
  if ($value['user'] == 'admin') { 
     
  
 $acc_image = "https://smartdentalcompliance.com/webImages/logo.png?magic=01";
  $acc_name = "Smart Dental Compliance";     
       }
     
             
               
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
                <br>
                 <img src='$img' >
                <br>
                </div>
                <br>
                <hr>";
if ($value['user'] != 'admin') {



            echo " <div class='commentbtn' style='cursor: pointer;'>
               <i class='far fa-comment' ></i>&nbsp;
               <span>".count($data4)."</span>
               </div>
                 <hr>
              <div class='areatbtn cmt'>

                 <div class='writecomment'>
                 <a class='viewmore' href=' $link ' >"; if($cont != '0'){echo "View $cont More Comment(s)"; }
                 
                 echo "</a> </div>
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
<div class='cmt'>
                  ";

foreach ($data3 as $key => $value3) {
  $viewimage  =  $functions->UserImage($value3['user']);
   $viewimage = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value3['user']);
   if ($viewimage == "https://smartdentalcompliance.com/images/#" || $viewimage == "#" ||trim($viewimage) == "" ) 
                {
                    
                    $viewimagem= WEB_URL."/webImages/d-profile.png";
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
            echo "</div>";

    }
            echo "</div>";


           
    }

?>
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

        
            if ($value4['acc_image'] == "https://smartdentalcompliance.com/images/#" ||trim($value4['acc_image']) == ""  || $value4['acc_image'] == '#') 
                {
                    
                    $image = WEB_URL."/webImages/d-profile.png";
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
    <?php include_once('footer.php');?>