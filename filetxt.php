<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}
$chk4 = '';

$option = $functions->eventCategory();

include_once('header.php');

include'dashboardheader.php'; ?>


<?php
// if (isset($_POST)) {
//  //echo "ssssssssssssssssssssssssssssssssss";
//  var_dump($_POST);
// }
  $id = htmlspecialchars($_POST['txtid']);
 $id = base64_decode($id); 
if ($_POST['txtid'] != '') {

    
 if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
            $user = intval($_SESSION['superid']);
        }
        else{
            $user = intval($_SESSION['currentUser']);
        }
$sql = "SELECT * FROM `filesmanager` WHERE `assignto` IN ('all','$user') AND  `publish` = '1'AND id = '$id'";
        $data = $dbF->getRow($sql);
       $file = $data['file'];
       $title = $data['title'];
       $sub_sub_category = $data['sub_sub_category'];
       
       $sql1 = "SELECT * FROM `practiceprofile` WHERE `user_id` = '$_SESSION[currentUser]'";
      $data1 = $dbF->getRow($sql1);
      $logo  = $data1['practice_logo'];
       $pname = $data1['practice_name'];
       $sql2 = "SELECT * FROM `userdocuments` WHERE  `user` = '$user' ";
       $data2 = $dbF->getRow($sql2);
      // $desc  = $data2['desc'];
        $desc = $_POST['txt'];
       
        $pmname = "<b>".$data1['practice_manager_name']."</b>";
        $subtname = $data1['subtname'];
        $pmname =  $pmname ." &nbsp; &nbsp;(Substitute PM: ".$subtname .")";
        //$user = $functions->PracticeId($user);
        $contents = '';
               $search = array(',', '.', ' ', '\"', '\'','&','$','`');
              $title = str_replace($search, '', $title);


// $handle = fopen($_SERVER["DOCUMENT_ROOT"].'/uploads/files/resources/smartDoc'.$title.'.el', 'r+'); 
// $contents = stream_get_contents($handle);

$fileopen=str_replace(WEB_URL, $_SERVER['DOCUMENT_ROOT'].'/', $file);
                    $handle = fopen($fileopen, 'r'); 
                    $contents = stream_get_contents($handle);

fclose($handle);
 $contents = str_replace('{{pname}}',$pname,$contents);
 $contents = str_replace('{{pmname}}',$pmname,$contents);
 $contents = str_replace('{{logo}}',$logo,$contents);
 $contents = str_replace('{{description}}',$desc,$contents);
}
$userId = $_SESSION['webUser']['id'];         
$allPractice = $functions->allPractice(@$userId);
 ?>
  <style type="text/css">
    .choices__input{
        width: 250px !important;
    }
</style>
<div class="index_content mypage">
    <div class="left_right_side">
        <div class="standard">
            <div class="profile rota" style="padding-top: 50px;">
                <form method="post" action="myuploads" id="my_form" enctype="multipart/form-data">
                    <?php echo $functions->setFormToken('filetxt',false); ?>
                    <input name="url" type="hidden">
                    <input name="ytcode" type="hidden" value="<?php echo $data['id'] ?>">
                    <input name="file" type="hidden">
                    <div class="row">
                        <?php 
                            if($_SESSION['currentUserType'] == 'Master' ){
                            ?>
                            <div class="form-group col-md-6">
                                <label>Select Practice</label>
                                <select name="practiceIds[]"  id="choices-multiple-remove-button" placeholder="Select" multiple>
                                    <option  value="<?php echo  $_SESSION['webUser']['id']; ?>">
                                        <?php echo   $functions->PracticeName($_SESSION['webUser']['id']) . ' -- Master'; ?>
                                    </option>
                                    <?php echo $allPractice; ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input name="title" type="text" value="<?php echo $data['title'] ?>">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Select Category</label>
                            <select name="category" class="categ">
                                <?php echo $option; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sub Category</label>
                            <input name="sub_category" type="text" value="<?php echo $sub_sub_category ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Add this document to Staff HR file</label>
                            <label class="switch">
                                <input type="checkbox" name="dchk" value="1">
                                <span class="slider">Yes No</span>
                            </label>
                        </div>
                        <div class="form-group document col-md-6" style="display: none;">
                            <label>Document Category</label>
                            <select name="dcategory">
                                <option value="Training">Training</option>
                                <option value="Recruitment">Recruitment</option>
                                <option value="Signed Policies">Signed Policies</option>
                                <option value="Minute Meeting">Minute Meeting</option>
                                <option value="MHRA">MHRA Alerts</option>
                                <option value="Onboarding">Onboarding</option>
                                <option value="Additional Document">Additional Document</option>
                            </select>
                        </div>
                        <div class="form-group document col-md-6" style="display: none;">
                        <label>Document Sub Category</label>
                            <input name="sub_dcategory" type="text" value="<?php echo $sub_sub_category ?>">
                        </div>
                    </div>
                
                <div class="row">
                    <div class="form-group col-12">
                        <div class="errmsg"></div>
                        <textarea hidden="hidden" name='myname' ><?php echo $contents;  ?> </textarea>
                        <input type="submit" class="submit_class" value="Submit"   name="submit">
                    </div>
                </div>
            </div>
        </div>
        <!-- profile rota -->
        <?php 
        // $find = "'"; 
        // $replace = "`"; 
        
        ?>
       <div class="iframe mine"  name="myname" style="width: 50%;height: 50%;position: relative;vertical-align: middle;margin-left: 28%;"><?php echo $contents;  ?></div>
        
       </form>
    </div>
    <!-- left_right_side -->
    <style>
    .left_right_side:before {
        display: none;
    }

    iframe {
        width: 100%;
        height: 800px;
        border: none;
        margin: 20px 0;
    }
    </style>
    <script>
     $(document).ready(function(){
    
     var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        searchResultLimit:5
      }); 
     
     
 });
//      $(document).ready(function(){
//   $("#my_form").on("submit", function () {
//         var hvalue = $('.mine').html();
//         // $(this).append("<input type='hidden' name='myname' value=' " + hvalue + " '/>");
//         $(this).append("<textarea type='hidden' name='myname' >" + hvalue + " </textarea>");
//     });
// });

    $('.switch').on('change', function() {
        if ($(this).find('input').is(':checked')) {
            $('.document').slideDown(600);
        } else {
            $('.document').slideUp(600);
        }


    // $('.submit_class').on('click', function() {
    //     var id = this.id;
    //     var file = localStorage.getItem("url");
    //     $('input[name=url]').val(id);
    //     $('input[name=file]').val(file);
    //     title = $('input[name=title]').val();
    //     if (title == '') {
    //         $('.errmsg').text('All Fields Required');
    //     } else {
    //         $('.errmsg').text('');
    //         $('form').submit();
    //     }
    // });
    });
</script>
    <?php include_once('footer.php'); ?>