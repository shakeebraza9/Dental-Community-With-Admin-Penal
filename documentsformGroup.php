<?php 
include_once("global.php");
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

$id = htmlspecialchars($_GET['id']);
$type = @htmlspecialchars($_GET['type']);
$user = @htmlspecialchars($_GET['user']);

if($type == 'insert'){
    $token = "documentInsert";
}
else if ($type == 'update') {
    $token = "documentUpdate";
    $uid = htmlspecialchars($_GET['uid']);
}
else if ($type == 'view') {
    $uid = htmlspecialchars($_GET['uid']);
    echo "<style>.submit_class,.form-group:last-child{display: none;}input,textarea{pointer-events: none;}</style>";
    $sql = "SELECT * FROM `userdocuments` WHERE `id`=?";
    $data2 = $dbF->getRow($sql,array($uid));
   
    $display = "style=display:none;";


    $userdocumentstitle = @str_replace("'","\'",$data2['title']);
    $userdocumentstitle = @str_replace('"','\"',$userdocumentstitle);

$sqlX = 'SELECT * FROM `userdocuments` WHERE `title`="'.$userdocumentstitle.'" and `user` = "'.$user.'" ORDER BY `userdocuments`.`completion_date` DESC';
   // $data2X = $dbF->getRows($sqlX,array($userdocumentstitle,$user));
    $data2X = $dbF->getRows($sqlX);

}
else if ($type == 'allfile') {
     
     $uid = htmlspecialchars($_GET['uid']);
    echo "<style>.submit_class,.form-group:last-child{display: none;}input,textarea{pointer-events: none;}</style>";
    $sql = "SELECT * FROM `userdocuments` WHERE `id`= ?";
     $data2 = $dbF->getRow($sql,array($uid));
    $c_date = date('d-M-Y',strtotime(@$data2['completion_date']));
    $e_date = date('d-M-Y',strtotime(@$data2['expiry_date']));
    
}

$sql = "SELECT * FROM `documents` WHERE `id`= ?";
$data = $dbF->getRow($sql,array($id));
if ($dbF->rowCount > 0) {


}else{

 $sql = "SELECT * FROM `userdocuments` WHERE `id`= ?";
     $data = $dbF->getRow($sql,array($uid));

}

?>
<div class="event_details" id="myform">
    <h3>
        <?php echo $data['category'] ?>
    </h3>
    <div class="form_side">
        <form method="post" action="profile-detail?user=<?php echo $_GET[user] ?>" enctype="multipart/form-data">
            <?php echo $functions->setFormToken(@$token,false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="uid" value="<?php echo @$uid ?>">
            <input type="hidden" name="user"value="<?php echo $_GET[user] ?>">
            <input type="hidden" name="title" value="<?php echo $data['title'] ?>">
            <input type="hidden" name="category" value="<?php echo $data['category'] ?>">
             <input type="hidden" name="sub_dcategory" value="<?php echo $data['sub_dcategory'] ?>">
            <div class='sub-form'>
                <h4><?php echo $data['title'] ?></h4>
            </div>
            <?php
            if($data['category'] == 'Signed Policies' || $data['category'] == 'MHRA' ||  $data['category'] == 'Minute Meeting'){
                $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                $ext = pathinfo($data['file'], PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    
                     if ($ext == 'el') {
                        
                        $fileopen=str_replace(WEB_URL, $_SERVER['DOCUMENT_ROOT'].'/', $data['file']);
                       $handle = fopen($fileopen, 'r'); 

                        $contents = stream_get_contents($handle);
                        fclose($handle);

                         echo $contents; 
                        
                     }
                     else
                     {
                      echo "<iframe style='width: 100%;height:500px;border: none;' src='https://view.officeapps.live.com/op/embed.aspx?src=$data[file]'></iframe>";
                      
                     }
                    
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
            } else{ 

foreach ($data2X as $key => $valueD) {
 $c_date = date('d-M-Y',strtotime(@$valueD['completion_date']));
    $e_date = date('d-M-Y',strtotime(@$valueD['expiry_date']));
   $id = base64_encode($valueD['id']."&d=".date('d'));
              ?>
            <div class="row">
            
            <div class="form-group col-12 col-md-6">
                <label>Completion Date</label>
                <input class="datepicker" name="c_date" type="text" value="<?php echo @$c_date; ?>" autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Expiry Date</label>
                <input class="datepicker" name="e_date" type="text" value="<?php echo @$e_date ?>" autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Details</label>
                <textarea name="desc" placeholder="Description"><?php echo @$valueD['desc'] ?></textarea> 




            </div>


            <!-- form-group -->
            <div class="form-group col-12 col-md-6"  <?php echo @$display ?> >
                <label>File</label>
                <div class="file">
                    <input type="file" name="document" id="file-upload" placeholder="File">
                    <i class="fas fa-paperclip"></i>
                    <div>Upload</div>
                </div>
            </div> 
            

            <div id="upendappend" class="form-group col-12 col-md-6"></div>
             <div class="form-group col-12 col-md-6">
               <div class="submit_class" onclick="addmoreupload();" style=" padding: 1%; width: 21%;">Add more</div>
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
                   add = '<label>File</label><div class="file"><input type="file" name="document'+countadd+'" placeholder="File"><i class="fas fa-paperclip"></i><div>Upload</div></div>';$('#upendappend').append(add) 
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
           
            <div class="form-group DelScripted">
            <?php
            if($valueD['category'] != 'Signed Policies' && $valueD['category'] != 'MHRA' && @$valueD['file'] != "#" && @$valueD['file'] != ""){
                $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF');
                $file = @$valueD['file'];
                $file0 = @$valueD['file0'];
                $file1 = @$valueD['file1'];
                $file2 = @$valueD['file2'];
                $file3 = @$valueD['file3'];
                $file4 = @$valueD['file4'];
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

                  if ( $valueD['file'] !='' ) {
                     $key ='"file"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                 }
                 
                if ($valueD['file0'] !='') {
                     $key = '"file0"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor0' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($valueD['file1'] !='' ) {
                      $key = '"file1"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor1' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($valueD['file2'] !='') {
                    $key = '"file2"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor2' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($valueD['file3'] !='') {
                  $key = '"file3"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor3' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>  ";  
                }
                if ($valueD['file4'] !='') {
                    $key = '"file4"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."$valueD[id]'><a style='font-size: 14px;' class='dbtn' href='$anchor4' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$valueD['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";  
                }
                // else
                // {

                // echo "<a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a>";
                // }
            }
            ?>



                 <?php  



                  echo "<div class='DelScript'><a data-toggle='tooltip' title='Delete' class='delete dbtn' type='button' onclick='return confirm(\"Are you sure you want to delete?\");' href='profile-detail?user=$user&folD=$id'>Delete Record</a></div>"





                                   ?>




            </div>
<hr>

             <?php } }?>


             
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


    
</script>