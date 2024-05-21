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



   <div class="h3div"></div>
<h3><?php

  $text = $_GET['page'];
   $userS = $_GET['user'];
   $cat = $_GET['cat'];
   $hide = '';
  if ($text == 'Add_Training_Document') {
        echo "Add Training Document";
        $hide = "style='display:none;'";
  }

  else if($text == 'Add_Recruitment_Document'){
    echo "Add Recruitment Document";
     $hide = "style='display:none;'";
  }
  else if($text == 'Private_Folder'){
    echo "Private Folder";
     $hide = "style='display:none;'";
  }
  else  {
    echo "Add Document";
   
  }



 ?> </h3>

    <div class="form_side">
        <form method="post"  enctype="multipart/form-data">
            <?php echo $functions->setFormToken("documentInsert_profile_detail",false); ?>
           
            <input type="hidden" name="user" value="<?php echo $user ?>">
            <div class='sub-form'>
                <h4> </h4>
            </div>
            <?php
            if($data['category'] == 'Signed Policies' || $data['category'] == 'MHRA' ||  $data['category'] == 'Minute Meeting'){
                $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                $ext = pathinfo($data['file'], PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    echo "<iframe style='width: 100%;height:500px;border: none;' src='https://view.officeapps.live.com/op/embed.aspx?src=$data[file]'></iframe>";
                 //   echo "<iframe style='width: 100%;height:500px;border: none;' src='https://docs.google.com/gview?embedded=true&url=$data[file]'></iframe>";
                }
                else{
                    echo "<iframe style='width: 100%;height:500px;border: none;' src='$data[file]'></iframe>";
                }
                if ($type == 'view') {
                    echo "You Signed Policy on ".date('d-M-Y',strtotime(@$data2['completion_date']));
                } else {
                    echo "<label class='ccheckbox'><input type='checkbox' name='desc' value='Yes' checked onclick='return false;'><span class='cmark' ></span>I confirm I have read this Policy</label>";
                }
            } else{ ?>
            <div class="row">
            
           
                <!-- form-group -->
                  <div class="form-group col-12 col-md-6">
                    <label>Title</label>
                    <input name="title" type="text">
                </div>
              
          
            
             <!-- form-group -->
             <?php if($_SESSION['currentUserType'] == 'Employee' ) { ?>
                <div class="form-group col-12 col-md-6">
                    <label>Category</label>
                    <select name="category" id="training-select">
             <option value="Training" <?php if ($_GET['cat'] =='1') {echo 'selected';  }  ?> >Training</option>
                        <option value="Recruitment" <?php if ($_GET['cat'] =='2') {echo 'selected';  }  ?> >Recruitment</option>
                        <option value="Additional Document" <?php if ($_GET['cat'] =='3') {echo 'selected';  }  ?> >Additional Document</option>
                    </select>
                    
                </div>
            <?php }else{ ?>

                <div class="form-group col-12 col-md-6">
                    <label>Category</label>
                    <select name="category" id="training-select">
             <option value="Private Folder" <?php if ($_GET['cat'] =='private') {echo 'selected';  }  ?> >Private Folder</option>
             <option value="Training" <?php if ($_GET['cat'] =='1') {echo 'selected';  }  ?> >Training</option>
                        <option value="Recruitment" <?php if ($_GET['cat'] =='2') {echo 'selected';  }  ?> >Recruitment</option>
                        <option value="Additional Document" <?php if ($_GET['cat'] =='3') {echo 'selected';  }  ?> >Additional Document</option>
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
                <label>Completion Date</label>
                <input class="datepicker" name="c_date" type="text" value="" autocomplete="off" readonly>
            </div> 
           <!-- form-group -->
             <?php if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0') { ?>
                <div class="form-group col-12 col-md-6">
                    <label>Document For</label>
                    <select name="user">
                        <option value="<?php echo $_SESSION['webUser']['id'] ?>"><?php echo $functions->UserName($_SESSION['webUser']['id']) ?></option>
                    </select>
                </div>
                        <?php }else{ ?>

                <div class="form-group col-12 col-md-6">
                    <label>Document For</label>
                    <select name="user">
                        <?php echo $functions->allEmployees($_SESSION['currentUser'],$userS) ?>

                    </select>
                        
                </div>
            <?php } ?>

            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Expiry Date</label>
                <input class="datepicker" name="e_date" type="text" value="" autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Details</label>
                <textarea name="desc" placeholder="Description">  </textarea>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6" >
                <label>File</label>
                <div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Upload</div>
                </div>
            </div> 
            

            <div id="upendappend" class="form-group col-12 col-md-6"></div>
             <div class="form-group col-12 col-md-6" >
               <div class="submit_class" onclick="addmoreupload();" style=" width: 21%;">Add more</div>
            </div>
          
            <script>
                var countadd = 0;
                function addmoreupload(ths)
                {
                    
                    var add ='';
                 // console.log(countadd);
                  if (countadd >= 5 ) 
                  {
                    console.log(countadd);
                       add ='<div class="col-sm-12 alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Only 5 File upload Only</div>';$('#upendappend').append(add) 
                  }
                  else
                  {
                   add = '  <div class="form-group col-12 col-md-6"><label>File</label><div class="file"><input type="file" name="document'+countadd+'" placeholder="File"><i class="fas fa-paperclip"></i><div>Upload</div></div></div>';$('#upendappend').append(add) 
                  }
                  
                 


$(document).on('change', '.file input', function() {
    filename = this.files[0].name;
    
    $(this).parent('div').find('div').text(filename);
});
 
 countadd++;


                }


            </script>
            <!-- form-group -->
            </div>
            <?php } ?>
            <?php
            if($data['category'] != 'Signed Policies' && $data['category'] != 'MHRA' && @$data2['file'] != "#" && @$data2['file'] != ""){
                $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                $file = @$data2['file'];
                $file0 = @$data2['file0'];
                $file1 = @$data2['file1'];
                $file2 = @$data2['file2'];
                $file3 = @$data2['file3'];
                $file4 = @$data2['file4'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $ext0 = pathinfo($file0, PATHINFO_EXTENSION);
                $ext1 = pathinfo($file1, PATHINFO_EXTENSION);
                $ext2 = pathinfo($file2, PATHINFO_EXTENSION);
                $ext3 = pathinfo($file3, PATHINFO_EXTENSION);
                $ext4 = pathinfo($file4, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed) &&  !in_array($ext0, $allowed) && !in_array($ext1, $allowed)  && !in_array($ext2, $allowed)  && !in_array($ext3, $allowed)  && !in_array($ext4, $allowed)) {
                    $anchor = "http://view.officeapps.live.com/op/view.aspx?src=$file";
                    $anchor0 = "http://view.officeapps.live.com/op/view.aspx?src=$file0";
                    $anchor1 = "http://view.officeapps.live.com/op/view.aspx?src=$file1";
                    $anchor2 = "http://view.officeapps.live.com/op/view.aspx?src=$file2";
                    $anchor3 = "http://view.officeapps.live.com/op/view.aspx?src=$file3";
                    $anchor4 = "http://view.officeapps.live.com/op/view.aspx?src=$file4";
                }
                else{
                    $anchor = $file;
                    $anchor0 = $file0;
                    $anchor1 = $file1;
                    $anchor2 = $file2;
                    $anchor3 = $file3;
                    $anchor4 = $file4;
                }

                if ( $data2['file'] !='' ) {
                    echo "<a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a>";
                 }
                 
                if ($data2['file0'] !='') {
                     echo "<a style='font-size: 14px;' class='dbtn' href='$anchor0' target='_blank'>View Document</a>";
                }
                if ($data2['file1'] !='' ) {
                     echo "<a style='font-size: 14px;' class='dbtn' href='$anchor1' target='_blank'>View Document</a>";
                }
                if ($data2['file2'] !='') {
                    echo "<a style='font-size: 14px;' class='dbtn' href='$anchor2' target='_blank'>View Document</a>";
                }
                if ($data2['file3'] !='') {
                   echo "<a style='font-size: 14px;' class='dbtn' href='$anchor3' target='_blank'>View Document</a>";  
                }
                if ($data2['file4'] !='') {
                    echo "<a style='font-size: 14px;' class='dbtn' href='$anchor4' target='_blank'>View Document</a>";  
                }
                // else
                // {

                // echo "<a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a>";
                // }
            }
            ?>
            <input type="submit" class="submit_class" value="Submit" name="submit">
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