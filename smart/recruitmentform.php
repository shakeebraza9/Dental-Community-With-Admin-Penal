<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

?>
<div class="event_details" id="myform">
    <h3>Personal Documents</h3> 
    <div class="form_side">
        <form method="post" action="personal-document" enctype="multipart/form-data">
            <?php echo $functions->setFormToken('recruitment',false); ?>
            <div class="form-group">
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