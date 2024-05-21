<?php
include_once("global.php");

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
            <?php $active = 'post'; include 'dashboardmenu.php';?>
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

            <div class="grid_2">
           



<?php
 

    $getid =  $_GET['pSlug'];
    $type ="post";
    $sql1  = "SELECT * from post where publish = 1 AND type='post' AND id = '$getid' ORDER BY `date`     DESC";
   
    $data1 = $dbF->getRows($sql1); 
            
    foreach ($data1 as $key => $value) {
    $sql2  = "SELECT * from accounts_user where  `acc_id` = '$value[user]'  ";
    $data2 = $dbF->getRow($sql2);
    $sql3  = "SELECT * FROM `comments` where  postid='$value[id]' ORDER BY `comments`.`id` DESC";
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
        $from       = date('Y-m-d H:i:s',strtotime($value['dateTime']));
        $to         = date('Y-m-d H:i:s');
// -------datetime
        $total      = strtotime($to) - strtotime($from);
        $hours      = floor($total / 60 / 60);
        $minutes    = round(($total - ($hours * 60 * 60)) / 60);
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 

        if ($hours == 0) {

           $hd = "$minutes m";
        
             }else if($hours > 24){
              
              $total_d      = strtotime($to) - strtotime($from);
              $days = floor($total_d / 86400);  // (60 * 60 * 24)
              $hd = "$days d";
             }
             else{

              $hd = "$hours h";

             }

       
        
//------- datetime

        $image    = $value['image'];
        $img    = WEB_URL . "/images/$image";
        $acc_image = $data2['acc_image'];   
        $acc_name = $data2['acc_name'];   
       $acc_image = WEB_URL . "/images/$acc_image";
        $link    = WEB_URL . "/view?id=$id";

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
                <div class='imgset'><img src='$acc_image'></div>
                <div class='acc_detail'> 
                   <h4>$acc_name</h4>
                   
                   <p data-toggle='tooltip' title='".date("l jS \of F Y h:i:s A",strtotime($value['dateTime']))."'>$hd   </p>
                
                 
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
              <div class='areatbtn ' >

                 <div class='writecomment'>
                  </div>
                <div class='imgset'> <img src='$viewimagem'></div>
                 <div class='btncomment'>";
              echo "
              <form  action='?' method='post'>
                  <input type='text' class='comment' name='commentintsert' placeholder='Write a Comment'>
                  <input type='hidden' name='postid' value='$id'>
                   <button type='submit' class='print' name='commentsubmit' aria-hidden='true'  ><i class='fa fa-paper-plane' style='margin-left: -2px;'></i></button>
                  </form>
                  
                  </div>
                  </div>
<div class=''>
                  ";

foreach ($data3 as $key => $value3) {
  $viewimage  =  $functions->UserImage($value3['user']);
   $viewimagem = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value3['user']);
   if($viewimage == "#" ||trim($viewimage) == "" ) 
                {
                    
                    $viewimagem= WEB_URL."/webImages/d-profile.png";
                 }
        $from3       = date('Y-m-d H:i:s',strtotime($value3['dateTime']));
        $to3         = date('Y-m-d H:i:s');
// -------datetime
        $total3      = strtotime($to3) - strtotime($from3);
        $hours3      = floor($total3 / 60 / 60);
        $minutes3    = round(($total3 - ($hours3 * 60 * 60)) / 60);
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 

          $hd3 = "";
        if($hours3 == 0){
              $hd3 = "$minutes3 m"; 
          } 
          else if ($hours3 > 24) {

            $total_d3      = strtotime($to3) - strtotime($from3);
            $days3 = floor($total_d3 / 86400);  // (60 * 60 * 24)
             $hd3 = "$days3 d";
        
             }else{
              $hd3 = "$hours3 h";

             }
       
        
//------- datetime
     echo " <div class='viewcomment'>
            <div class='viewacc'> 
           <div class='imgset'> <img src='$viewimagem'></div>
            <div class='darkview'>
            <div class='acc_detail'> 
            <strong style='float: left;cursor: pointer;'>$viewname
            </strong>
     <p data-toggle='tooltip' title='".date("l jS \of F Y h:i:s A",strtotime($value3['dateTime']))."'>$hd3 </p>
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
        <div class="right_detail" style="float: right;">
            

<?php   

$user = $_SESSION['webUser']['id'];
$currentUser = $_SESSION['currentUser'];
$sql5 = "SELECT * FROM `accounts_user` WHERE `acc_id` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$currentUser' AND `setting_name`='account_under' )OR acc_id = '$currentUser '";
        $data5 = $dbF->getRows($sql5);
        $op = ""; 
  
foreach ($data5 as $key => $value5) {
  $viewimage  =  $functions->UserImage($value5['acc_id']);
   $viewimage = WEB_URL . "/images/$viewimage";
  $viewname  =  $functions->UserName($value5['acc_id']);
 // $strViewname=substr($viewname, 0, strrpos($viewname, ' '));
  $viewname = explode(" ", $viewname);
 $strViewname = $viewname[0]." ".$viewname[1]; //Laura

         
            if ($value5['acc_image'] == "#" ||trim($value5['acc_image'] ) == "" ) 
                {
                    
                    $image = WEB_URL."/webImages/d-profile.png";
                 }
                 else
                 {

                    $image = $viewimage;



                 }

     echo " 
            <div class='view_account'> 
           <div class='imgset'> <img src='$image' ></div>
            <div class='darkview'>
            <strong style='float: left;cursor: pointer;'>$strViewname</strong></div>
                 </div>
               ";
    }
  ?> 

        </div>
        <!-- right_detail -->

<div class="all_post_right" >
  

<?php
 

    $currentUser       = $_SESSION['currentUser'];
    $sql6  = "SELECT * from post where publish = 1 AND id !='$getid' AND type='post' AND (`user` IN (SELECT `id_user` FROM `accounts_user_detail` WHERE `setting_val`='$currentUser' AND `setting_name`='account_under') OR user = '$currentUser') ORDER BY `post`.`id` DESC LIMIT 5";

    $data6 = $dbF->getRows($sql6); 
            
    foreach ($data6 as $key => $value6) {
    $sql7  = "SELECT * from accounts_user where  acc_id='$value6[user]' ";
    $data7 = $dbF->getRow($sql7);
    $sql8  = "SELECT * FROM `comments` where  postid='$value6[id]' ORDER BY `id` ASC LIMIT 3";
    $data8 = $dbF->getRows($sql8); 
    $sql9  = "SELECT * FROM `comments` where  postid='$value6[id]'";
    $data9 = $dbF->getRows($sql9);
    // count($data3);
    // count($data4);
     "<br>";
   $cont = count($data9) - count($data8);
 
        $id      = $value6['id'];
        $heading = translatefromserialize($value6['heading']);
        $desc    = translatefromserialize($value6['dsc']);
        $image    = $value6['image'];
        $link    = WEB_URL . "/item-$id";
        $img    = WEB_URL . "/images/$image";
        $acc_image = $data7['acc_image'];   
        $acc_name = $data7['acc_name'];   
       $acc_image = WEB_URL . "/images/$acc_image";
                if ($data7['acc_image'] == "#" ||trim($data7['acc_image'] ) == "" ) 
                {
                    
                    $image = WEB_URL."/webImages/d-profile.png";
                 }
                 else
                 {

                    $image = $acc_image;

                  }
                  // $date    = date('d-M-Y', strtotime($value6['date']));
        $date    = date('d-M-Y', strtotime($value6['date']));
        $datetime    = date('h', strtotime($value6['dateTime']));
        $from4       = date('Y-m-d H:i:s',strtotime($value6['dateTime']));
        $to4         = date('Y-m-d H:i:s');
// -------datetime
        $total4      = strtotime($to4) - strtotime($from4);
        $hours4      = floor($total4 / 60 / 60);
        $minutes4    = round(($total4 - ($hours4 * 60 * 60)) / 60);
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 

          $hd4 = "";
        if($hours4 == 0){
              $hd4 = "$minutes4 m"; 
          } 
          else if ($hours4 > 24) {

            $total_d4      = strtotime($to4) - strtotime($from4);
            $days4 = floor($total_d4 / 86400);  // (60 * 60 * 24)
             $hd4 = "$days4 d";
        
             }else{
              $hd4 = "$hours4 h";

             }
       
               
               echo "
                <div class='news-detail'  >
                 <div class='accimage'> 
               <div class='imgset'>  <img src='$image'></div>
              <div class='acc_detail'> 
                   <h4>$acc_name</h4>
                   <p title='".date("l jS \of F Y h:i:s A",strtotime($value6['dateTime']))."'>$hd4</p>
                   <!----<p title='".$date."'>$date </p>--->
                 
                 </div>
                 </div>
                 <div class='news-detail-box'>
                 <p>'".$desc."'</p>
                 
               <img src='$img' >
                <br>
                <br>
                <a href='$link' > <i class='far fa-comment' ></i>&nbsp;
                <span>".count($data9)."</span>  </a>
                </div>
                
                </div>
                ";
                
             
 

           
    }

?>




</div>
    

        </div>
        <!-- right_side close -->
    </div>

    <!-- left_right_side -->
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
$(window).load(function() {
            var $grid = $('.grid').isotope({
              // options
            });

            });
        }


    </script>
     <!-- delete END Script -->
    

    <?php include_once('footer.php');?>