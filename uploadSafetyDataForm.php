<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
@$id = htmlspecialchars($_GET['id']);
 $id = base64_decode($id);
@$t = htmlspecialchars($_GET['t']);
if($t == 'Safety-Data'){$t='Safety Data';
}else{$t='Safety Data';}

if (@$_GET['id'] !='') {
    $token = $functions->setFormToken('editSafetyData',false);

} else {
    $token = $functions->setFormToken('addSafetyData',false);
}
// $option = $functions->eventCategory();
// if ($_GET['id'] != '') {

    
 if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
            $user = $_SESSION['superid'];
        }
        else{
            $user = $_SESSION['currentUser'];
        }
// $sql = "SELECT * FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1' AND id = '$id'";
//         $data = $dbF->getRow($sql);

// }
$option = $functions->safetyDataCategory(@$user);
$allPractice = $functions->allPractice(@$user);
?>
<style type="text/css">
    .choices__input{
        width: 250px !important;
    }
</style>
<div class="event_details" id="myform">
    <h3>Upload Safety Data</h3>
    <div class="form_side">
        <form method="post" action="safetyData?category=Safety-Data" enctype="multipart/form-data">
            <?php echo $token ?>
            <!-- <input name="editid" type="hidden" value="<?php echo @$id ?>" > -->
            <input name="category" type="hidden" value="<?php echo @$t ?>" >
            <?php 
             // echo $_SESSION['currentUserType']."-----";
            if($_SESSION['currentUserType'] == 'Master' && !isset($_GET['id'])){
            ?>
            <div class="form-group">
                <label>Select Practice</label>
                <select name="practiceIds[]"  id="choices-multiple-remove-button" placeholder="Select" multiple>
                    <option  value="<?php echo  $_SESSION['webUser']['id']; ?>">
                        <?php echo   $functions->PracticeName($_SESSION['webUser']['id']) . ' -- Master'; ?>
                    </option>
                    <?php echo $allPractice; ?>
                </select>
            </div>
        <?php } ?>
        
            <div class="form-group">
                <label>Title</label>
                <input name="title" type="text" value="" required>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label>Select Category</label>
                <select name="sub_category" class="categ" required>
                    <?php echo $option; ?>
                </select>
            </div>
             <!-- form-group -->
            <div class="form-group">
                <label>Select Sub Category</label>
               <input name="sub_sub_category" value="" type="text">
            </div>
            <!-- form-group -->
            <?php if(@$_GET['id'] == '' ){?>
             
            <!-- form-group -->
            <div class="form-group">
                <label>File</label>
                <div class="file">
                    <input type="file" id="file-upload" name="document" placeholder="File" required>
                    <i class="fas fa-paperclip"></i>
                    <div>Upload</div>
                </div>
            </div>
        <?php } 
        if($_SESSION['userType']=='Trial')
        {
            echo'<input type="button" class="submit_class" value="Submit" onclick="alertbx()" name="">';
        }
        else{?>
            <!-- form-group -->
            <input type="submit" class="submit_class" value="Submit" name="submit">
        <?php }?>
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->
<script>
$(document).ready(function(){
    
     var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        searchResultLimit:5
      }); 
     
     
 });
$('.file input').on('change', function() {
    filename = this.files[0].name;
    $(this).parent('div').find('div').text(filename);
});
$('.switch').on('change', function() {
    if ($(this).find('input').is(':checked')) {
        $('.document').slideDown(600);
    } else {
        $('.document').slideUp(600);
    }
});

var $dropzone = document.querySelector('.form_side');
var input = document.getElementById('file-upload');

$dropzone.ondragover = function (e) { 
  e.preventDefault(); 
  this.classList.add('dragover');
};
$dropzone.ondragleave = function (e) { 
    e.preventDefault();
    this.classList.remove('dragover');
};
$dropzone.ondrop = function (e) {
    e.preventDefault();
    this.classList.remove('dragover');
    input.files = e.dataTransfer.files;
    filename =  e.dataTransfer.files[0].name;
    $('#file-upload').parent('div').find('div').text(filename);




    }



</script>