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

    <h3><?php
    $required = "";
    $text = htmlspecialchars($_GET['page']);
   $userS = htmlspecialchars($_GET['user']);
   $cat = htmlspecialchars($_GET['cat']);
   if ($text == 'Add_Signed_Policies') {
       echo 'Add Signed Policies';
   }
   else if ($text == 'Add_Minute_Meeting') {
       echo "Add Minute Meeting";
       $required="required";
       
   }
  else if ($text == 'Add_MHRA_Alert') {
       echo "Add MHRA Alert";
   }
   else if ($text == 'Onboarding') {
       echo "Add Onboading";
   }
 else  {
       echo "Add Folder";
       $hide = "style='display:none;'";
   }
   
    ?></h3>
    <div class="form_side">
        <form method="post"  enctype="multipart/form-data">
            <?php echo $functions->setFormToken("documentAdd",false); ?>
            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label>Title</label>
                    <input name="title" type="text">
                </div>
                <!-- form-group -->
             <?php if($_GET['cat']>0) { ?>

                <div class="form-group col-12 col-md-6">
                    <label>Category</label>
                    <select name="category" id="training-select">
                        <option value="Minute Meeting" <?php if ($_GET['cat'] =='2') {echo 'selected';  }  ?> >Minute Meeting</option>
                        <option value="Signed Policies" <?php if ($_GET['cat'] =='1') {echo 'selected';  }  ?> >Signed Policies</option>
                        <option value="MHRA" <?php if ($_GET['cat'] =='3') {echo 'selected';  }  ?> >MHRA Alerts</option>
                        <option value="Onboarding" <?php if ($_GET['cat'] =='4') {echo 'selected';  }  ?> >Onboarding</option>
                    </select>
                    
                </div>
            <?php }else{ ?>

                <div class="form-group col-12 col-md-6">
                    <label>Category</label>
                    <select name="category" id="training-select">
                        <option value="Training">Training</option>
                        <option value="Recruitment" >Recruitment</option>
                        <option value="Minute Meeting" <?php if ($_GET['cat'] =='2') {echo 'selected';  }  ?> >Minute Meeting</option>
                        <option value="Signed Policies" <?php if ($_GET['cat'] =='1') {echo 'selected';  }  ?> >Signed Policies</option>
                        <option value="MHRA" <?php if ($_GET['cat'] =='3') {echo 'selected';  }  ?> >MHRA Alerts</option>
                        <option value="Onboarding"  >Onboarding</option>
                        <option value="Additional Document">Additional Document</option>
                        <option value="Private Folder">Private Folder</option>
                    </select>
                    
                </div>
            <?php } ?>
  <div class="form-group col-12 col-md-6">
                    <label>Sub Category</label>
                   
                    <input class="" name="sub_category" id="subCat" type="text" autocomplete="off" >
                    
                    <select name="sub_category" id="subCat2" style="display: none;">
                      <option value="Recommended">Recommended</option>
                      <option value="Mandatory">Mandatory</option>
                    </select>
                    
                </div>
                <!-- form-group -->
                <div class="form-group col-12 col-md-6">
                    <label>Expiry Date</label>
                    <input class="datepicker" name="date" type="text" autocomplete="off" readonly>
                </div>
                <!-- form-group -->
                <div class="form-group col-12 col-md-6">
                    <label>Assignto</label>
                    <select name="user">
                       <option value="all:<?php echo $_SESSION['currentUser']?>">All Employee</option>
                        <?php echo $functions->allEmployees($_SESSION['currentUser'],$userS) ?>

                    </select>
                </div>
                <!-- form-group -->
                <div class="form-group col-12"  <?php echo  $hide ?>>
                    <label>File</label>
                    <div class="file">
                        <input type="file" id="file-upload" name="document" placeholder="File" <?php echo $required ?>>
                        <i class="fas fa-paperclip"></i>
                        <div>Upload</div>
                    </div>
                </div>
                <!-- form-group -->
                <div class="form-group col-12">
                    <input type="submit" class="submit_class" value="Submit" name="submit">
                </div>
                <!-- form-group -->
            </div>
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->
<script>
$(".datepicker").datepicker({ dateFormat: 'd-M-yy',

 changeMonth: true,
 changeYear: true,
yearRange: "-80:+20",
showButtonPanel:true,
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
<script>
let selectEl = document.getElementById('training-select');

// $( window ).load(function() {
  // console.log(selectEl);
  if(selectEl.value=='Training'){

    document.getElementById('subCat').style.display = 'none';
    document.getElementById('subCat2').style.display = 'block';
  }
// });

selectEl.addEventListener('change', (e) => {
  if (e.target.value != 'Training') {
    document.getElementById('subCat').style.display = 'block';
    document.getElementById('subCat2').style.display = 'none';
     $('#subCat').attr("name","sub_category");
       $('#subCat2').removeAttr("name");
    
  } else {
    document.getElementById('subCat').style.display = 'none';
   document.getElementById('subCat2').style.display = 'block';
     $('#subCat2').attr("name","sub_category");
       $('#subCat').removeAttr("name");
    
  }
});

</script>