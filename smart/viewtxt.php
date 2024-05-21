<?php 
include_once("global.php");
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

include_once('header.php'); 

///$functions->pin();

include'dashboardheader.php';

$display = "";
if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hrreports'] == '0'){
    $display = 'style="display:none;"';
}
            $user = $_SESSION['currentUser'];
        $sql1 = "SELECT * FROM `accounts_user` WHERE `acc_id` =  ? ";
        $data1 = $dbF->getRow($sql1,array($user));
        

       $pSlug =   htmlspecialchars($_GET['pSlug']);
       $explode = explode(":",$pSlug);
         $explode[0];  
         $explode[1]; 
  if ($explode[0] == 'u') {
      $data = $dbF->getRow("SELECT * FROM `userdocuments` WHERE  id = '$explode[1]' ");
  }
  if ($explode[0] == 'd') {   
   
      $data = $dbF->getRow("SELECT * FROM `documents` WHERE  id = '$explode[1]' "); 
  }
  if ($explode[0] == 'm') {   
   
      $data = $dbF->getRow("SELECT * FROM `myuploads` WHERE  id = '$explode[1]' "); 
  }
      
?>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="link_menu">
            <span>
                <img src="webImages/menu.png" alt="">
            </span>
            <!-- COVID Screening -->
        </div>
        <!--link_menu close-->
        <div class="left_side">
            <?php $active = 'resources'; include'dashboardmenu.php';?>
        </div>
        <!-- left_side close -->
        
        <div class="right_side">
            <div style="width:900px; margin: 0 auto">

          <?php if(!empty($data['ytcode'])){
?>
    <div data-toggle="tooltip" title="Help Video" style="top: 0;" class="help" onclick="video('<?php echo $data['ytcode'] ?>')"><i class="fa fa-question-circle"></i></div>
<?php    
} ?>
            <?php 
             
    
    $fileopen = str_replace(WEB_URL, $_SERVER['DOCUMENT_ROOT'].'/', $data['file']);
                       $handle = fopen($fileopen, 'r'); 

                        $contents = stream_get_contents($handle);
                        fclose($handle); ?>
                    <div class="content"> 
                       <?php  echo $contents; ?>
                     </div>
            </div>
        </div>
        <!-- right_side close -->
    </div>
    <!-- left_right_side -->
<script src="<?php echo WEB_ADMIN_URL; ?>/assets/data_table_bs/jquery.dataTables.1.10.2.js"></script>
<script>
    $('.datable table').DataTable();
</script>
<?php include_once('footer.php'); ?>