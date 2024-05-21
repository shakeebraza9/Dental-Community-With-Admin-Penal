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
if (@$_GET['id'] !='') {
    $token = $functions->setFormToken('myUploadsedit',false);

} else {
    $token = $functions->setFormToken('myUploads',false);
}
// $option = $functions->eventCategory();
// if ($_GET['id'] != '') {

    
 if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
            $user = $_SESSION['superid'];
        }
        else{
            $user = $_SESSION['currentUser'];
        }
$sql = "SELECT * FROM `myuploads` WHERE `user` = '$user' AND `publish` = '1' AND id = '$id'";
        $data = $dbF->getRow($sql);

// }
$option = $functions->eventCategoryedit(@$data['category']);
$allPractice = $functions->allPractice(@$user);
?>
<style type="text/css">
    .choices__input{
        width: 250px !important;
    }
</style>
<div class="event_details" id="myform">
    <h3>My Uploads</h3>
    <div class="form_side">
        <form method="post" action="myuploads" enctype="multipart/form-data">
            <?php echo $token ?>
            <input name="editid" type="hidden" value="<?php echo @$id ?>" >
            
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
                <input name="title" type="text" value="<?php echo $data['title'] ?>" required>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label>Select Category</label>
                <select name="category" class="categ" required>
                    <?php echo $option; ?>
                </select>
            </div>
             <!-- form-group -->
            <div class="form-group">
                <label>Select Sub Category</label>
               <input name="sub_category" value="<?php echo $data['sub_category'] ?>" type="text">
            </div>
            <!-- form-group -->
            <?php if(@$_GET['id'] == '' ){?>
             <div class="form-group">
                <label class="switch">
                    <input type="checkbox" name="dchk" value="1">
                    <span class="slider">Yes No</span>
                </label>
                &nbsp;&nbsp;Add this document to Staff HR file
            </div>
            <!-- form-group -->
            <div class="form-group document" style="display: none;">
                <label>Document Category</label>
                <select name="dcategory">
                    <option value="Training">Training</option>
                    <option value="Recruitment">Recruitment</option>
                    <option value="Minute Meeting">Minute Meeting</option>
                    <option value="Signed Policies">Signed Policies</option>
                    <option value="MHRA">MHRA Alerts</option>
                    <option value="Onboarding">Onboarding</option>
                    <option value="Additional Document">Additional Document</option>
                </select>
            </div>
            <!-- form-group -->
            <div class="form-group document" style="display: none;">
                <label>Document Sub Category</label>
                 <input name="sub_dcategory" type="text">
            </div>
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