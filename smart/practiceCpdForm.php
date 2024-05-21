<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}
 if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['myuploads'] == '0'){
            $user = $_SESSION['superid'];
        }
        else{
            $user = $_SESSION['currentUser'];
        }
        // var_dump($user);
$allPractice = $functions->allPractice(@$user);
// var_dump($allPractice);
?>
<link rel="stylesheet" href="<?php echo WEB_URL ?>/css/choices.min.css">
<script src="<?php echo WEB_URL ?>/js/choices.min.js"></script>
<style type="text/css">
    .choices__input{
        width: 250px !important;
    }
</style>
<div class="event_details" id="myform">
    <h3>Practice Training</h3> 
    <div class="form_side">
        <form method="post" action="practice-training" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('practicetraining',false);
            if( $_SESSION['currentUserType'] == 'Master'){
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
            <div class="form-group" style="display: flex;align-items: center;gap: 0.1rem;">
            <label for="html">Show All Employees:</label>&nbsp;  
             <input type="radio" id="html" name="visible" value="all:" checked>&nbsp;&nbsp;&nbsp;&nbsp;   
             <label for="html">Only Practice Manager:</label>&nbsp;  
             <input type="radio" id="html" name="visible" value="">
             </div>            <div class="form-group">
                <label>Title</label>
                <input name="title" type="text" required>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label>Category</label>
                <input name="category" type="text" required>
            </div>
            
            <!-- form-group -->
            

            <div class="form-group">
                <label>File</label>
                <div class="file">
                    <input type="file" id="file-upload" name="document" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Upload</div>
                </div>
            </div>
            <!-- form-group -->
            <input type="submit" class="submit_class" value="Submit" name="submit">
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