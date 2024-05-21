<?php 
include_once("global.php");
error_reporting(E_ALL);
ini_set('display_errors', 0);
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
$onboardPage = $_GET['onboardPage'];
if($type == 'insert'){
    $token = "documentInsert";
}
else if ($type == 'update') {
    $token = "documentUpdate";
    $uid = htmlspecialchars($_GET['uid']);
}
else if ($type == 'view') {
    $token = "documentUpdateExpiry";
    $uid = htmlspecialchars($_GET['uid']);
    echo "<style>.submit_class,.form-group:last-child{display: none;} .expire,.form-group:last-child{display: block;}</style>";
    $sql = "SELECT * FROM `userdocuments` WHERE `id`=?";
    $data2 = $dbF->getRow($sql,array($uid));
    $c_date = date('d-M-Y',strtotime(@$data2['completion_date']));
    $e_date = date('d-M-Y',strtotime(@$data2['expiry_date']));
    $display = "style=display:none;";
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

 
 <?php 
 if (empty($onboardPage) ) {
     $redirect = 'profile-detail?user='.$_GET['user'];
 }else{
     $redirect = '';
 }
 
 
 if ($data['category']=='Practice Training') {
    $redirect = 'practice-training?user='.$_GET['user'] ;
}
$user_ids = @$_GET['user'];
 ?>

<div class="form_side">

        <form method="post" action="<?php echo $redirect; ?>" enctype="multipart/form-data">
            <?php echo $functions->setFormToken(@$token,false); ?>
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="uid" value="<?php echo @$uid ?>">
            <input type="hidden" name="user"value="<?php echo $user_ids ?>">
            <input type="hidden" name="title" value="<?php echo $data['title'] ?>">
            <input type="hidden" name="category" value="<?php echo $data['category'] ?>">
             <input type="hidden" name="sub_dcategory" value="<?php echo $data['sub_dcategory'] ?>">
            <div class='sub-form'>
                <h4><?php echo $data['title'] ?> 




<?php 

$sqld = "SELECT * FROM `filesmanager` WHERE `id`= ?";
$datad = $dbF->getRow($sqld,array($data['ytcode']));


if(!empty($datad['ytcode'])){
?>
<!--<div data-toggle="tooltip" title="Help Video" style="top: 0;" class="help" onclick="hideIframe();"><i class="fa fa-play"></i></div>-->


<?php } ?>   </h4>
</div>





            <?php if(!empty($datad['ytcode'])){
?>


<!--<div class="idShowHide" style="display: none;">-->
<iframe width="900" height="315" src="https://www.youtube.com/embed/<?php echo $datad['ytcode']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<!--</div>-->
<?php } ?>



            <?php
            if($data['category'] == 'Signed Policies' || $data['category'] == 'MHRA' ||  $data['category'] == 'Minute Meeting'||  $data['category'] == 'Onboarding' ||  $data['category'] == 'Practice Training'){
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
                if ($data['category'] == 'Practice Training') {
                        $text = "Training";
                    }else{
                        $text = "Policy";
                    }
                if ($type == 'view') {
                    if (!empty($data2['completion_date'])) {
                        
                    echo "You Signed ".$text." on ".  date('d-M-Y',strtotime(@$data2['completion_date']));
                    }else{
                    echo "You Signed ".$text." on ".  date('d-M-Y',strtotime(@$data2['dateTime']));

                    }
                } else {
                    echo "<label class='ccheckbox'><input type='checkbox' name='desc' value='Yes' checked onclick='return false;'><span class='cmark' ></span>I confirm I have read this ".$text."</label>";
                }
            } else{ ?>
            <div class="row">
            
            <div class="form-group col-12 col-md-6">
                <label>Completion Date</label>
                <input class="datepicker" name="c_date" type="text" value="<?php echo @$c_date ?>" autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Expiry Date</label>
                <input class="datepicker" name="e_date" type="text" value="<?php echo @$e_date ?>" autocomplete="off" readonly>
            </div>
            <!-- form-group -->
            <div class="form-group col-12 col-md-6">
                <label>Details</label>
                <textarea name="desc" placeholder="Description"><?php echo @$data2['desc'] ?></textarea>
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
            <?php } ?>
            <div class="form-group DelScripted">
            <?php
            if($data['category'] != 'Practice Training' && $data['category'] != 'Signed Policies' && $data['category'] != 'MHRA' && @$data2['file'] != "#" && @$data2['file'] != ""){
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
                     $key ='"file"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                 }
                 
                if ($data2['file0'] !='') {
                     $key = '"file0"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor0' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($data2['file1'] !='' ) {
                      $key = '"file1"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor1' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($data2['file2'] !='') {
                    $key = '"file2"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor2' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";
                }
                if ($data2['file3'] !='') {
                  $key = '"file3"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor3' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>  ";  
                }
                if ($data2['file4'] !='') {
                    $key = '"file4"';
                    echo "<div class='DelScript".str_replace('"', '',$key)."'><a style='font-size: 14px;' class='dbtn' href='$anchor4' target='_blank'>View Document</a><i href='javascript:;' class='idbtn glyphicon glyphicon-trash trash fas fa-times-circle' data-toggle='tooltip' title='Delete File' id='".$key."' onclick='AjaxDelScript(".$key.",".$data2['id'].");'  style='width:37px;'>
                                  </i><i class='fa fa-refresh waiting fa-spin fa fa-spinner' style='display: none'></i></div>";  
                }
                // else
                // {

                // echo "<a style='font-size: 14px;' class='dbtn' href='$anchor' target='_blank'>View Document</a>";
                // }
            }
            ?>
            </div>
            <input type="submit" class="submit_class expire" value="Submit" name="submit">
        </form>
    </div>
    <!-- form_side close -->
</div>
<!-- event_details -->
<script>


 function hideIframe(){
  console.log('hideIframe');
  $('.idShowHide').toggle();
 }




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