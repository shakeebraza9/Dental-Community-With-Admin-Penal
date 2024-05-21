<?php 
include_once("global.php");
error_reporting(E_ALL);
ini_set('display_errors', 0);
global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

// include_once('header.php'); 

include'dashboardheader.php'; 
$msg = "";
$chk = $functions->practicetraining();
if($chk){
    $msg = "File Submit Successfully";
}
$chk1 = $functions->documentInsert();//
if($chk1){
    $msg = "Document Insert Successfully";
}
if(isset($_GET['folD'])){
    $chk = $functions->deleteDocument();
    if($chk){
        $msg = "Document Delete Successfully";
    }
}
if(isset($_GET['alldocumentidPD'])){
    $chk = $functions->deleteDocumentall();
    if($chk){
        $msg = "All Document Delete Successfully";
    }
}


?>

<style type="text/css">
    
    .main-row-down {
    position: relative;
}
.main-row-down ul{
  padding-bottom: 60px !important;
}
.ajax-upload-dragdrop {
  width: 100% !important;
  z-index: 1;
  vertical-align: top;
  border: 2px dotted rgb(165, 165, 199);
  /*position: absolute !important;*/
  background: rgb(255, 255, 255);
  bottom: 0;
  }
.state-hover {
  position: absolute !important;
    z-index: 9;
    height:100%;
    background: #fff;
    inset:0;
}
.ajax-file-upload-statusbar{border: 1px solid #0ba1b5;margin-top: 10px;width: 420px;margin-right: 10px;margin: 5px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;padding: 5px 5px 5px 5px}.ajax-file-upload-filename{width: 100%;height: auto;margin: 0 5px 5px 10px;color: #807579}.ajax-file-upload-progress{margin: 0 10px 5px 10px;position: relative;width: 250px;border: 1px solid #ddd;padding: 1px;border-radius: 3px;display: inline-block}.ajax-file-upload-bar{background-color: #0ba1b5;width: 0;height: 20px;border-radius: 3px;color:#FFFFFF}.ajax-file-upload-percent{position: absolute;display: inline-block;top: 3px;left: 48%}.ajax-file-upload-red{-moz-box-shadow: inset 0 39px 0 -24px #e67a73;-webkit-box-shadow: inset 0 39px 0 -24px #e67a73;box-shadow: inset 0 39px 0 -24px #e67a73;background-color: #e4685d;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;display: inline-block;color: #fff;font-family: arial;font-size: 13px;font-weight: normal;padding: 4px 15px;text-decoration: none;text-shadow: 0 1px 0 #b23e35;cursor: pointer;vertical-align: top;margin-right:5px}.ajax-file-upload-green{background-color: #77b55a;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;margin: 0;padding: 0;display: inline-block;color: #fff;font-family: arial;font-size: 13px;font-weight: normal;padding: 4px 15px;text-decoration: none;cursor: pointer;text-shadow: 0 1px 0 #5b8a3c;vertical-align: top;margin-right:5px}.ajax-file-upload{font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;padding: 15px 20px;cursor:pointer;line-height:20px;height:25px;margin:0 10px 10px 0;display: inline-block;background: #fff;border: 1px solid #e8e8e8;color: #888;text-decoration: none;border-radius: 3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;-moz-box-shadow: 0 2px 0 0 #e8e8e8;-webkit-box-shadow: 0 2px 0 0 #e8e8e8;box-shadow: 0 2px 0 0 #e8e8e8;padding: 6px 10px 4px 10px;color: #fff;background: #2f8ab9;border: none;-moz-box-shadow: 0 2px 0 0 #13648d;-webkit-box-shadow: 0 2px 0 0 #13648d;box-shadow: 0 2px 0 0 #13648d;vertical-align:middle}.ajax-file-upload:hover{background: #3396c9;-moz-box-shadow: 0 2px 0 0 #15719f;-webkit-box-shadow: 0 2px 0 0 #15719f;box-shadow: 0 2px 0 0 #15719f}.ajax-upload-dragdrop{border:2px dotted #A5A5C7;width:420px;color: #DADCE3;text-align:left;vertical-align:middle;padding:10px 10px 0px 10px} 
 
.ajax-upload-dragdrop span b{

text-align: center;
color: black;
    margin: 0 auto;
    display: block;
}

.ajax-upload-dragdrop input[type="file"]{

text-align: center;
color: black;
    margin: 0 auto;
    display: block;
}

</style>
<div class="index_content mypage resources">
    <!-- <div class="left_right_side"> -->
        
        <!-- left_side close -->
        <div class="right_side">
            <h3 class="main-heading_">Practice Training</h3>
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    //$functions->changeSession();
                    
                    if($_SESSION['currentUserType'] != 'Employee'){
                ?>
                
                    <div class="col1_btnn col1_btn22">
                    <a href="javascript:;" onclick="practicecpd()">Add File</a></div>
                
                    <?php } ?>
                
                </div>
                <!-- change-session -->
            </div>
            <!-- right_side_top close -->
            <?php if($msg!=''){ ?>
            <div class="col-sm-12 alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <!-- <div class="sub-head">Practice Training</div> -->
            <div class="resources_search">
               
            </div>
            <!-- resources_search -->
             <div class="col4_main">
                <?php $echo =  $functions->documentClickAbleTitle("Practice Training",$_SESSION['webUser']['id']); 

            echo $echo[0];$allsubOptions = $echo[1];
                ?>         
            <div class="file-box">
           
                            

                <?php
$url_user = "";
 $user1 = '';
   @$url_user = intval( $_SESSION['webUser']['id']);
   
 if($_SESSION['webUser']['id']> 0) {$user = $url_user; $user1 = $_SESSION['currentUser'];}
   else{
     if($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == '0'){
                    $user = $_SESSION['superid'];
                 //   echo "Employee";
                }
                else{
                 //   echo "currentUser";
                    $user1 = $_SESSION['currentUser'];
   }
   }
if($_SESSION['currentUserType'] == 'Employee'){
    $pid = $functions->PracticeId($_SESSION['superid']);
}
else{
    $pid = $_SESSION['currentUser'];
}
$sql="SELECT * FROM `documents` WHERE  `assignto` IN ('all','$user','all:$pid') AND `category`='Practice Training' AND `id` NOT IN (SELECT `title_id` FROM `userdocuments` WHERE `user`='$user' AND `title_id` > 0 )";
$data = $dbF->getRows($sql);
                foreach ($data as $key => $value) {
                    $anchor = "href='javascript:;'";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        $id = base64_encode($value['id']."&d=".date('d'));
                        if (!in_array($ext, $allowed)) {
                          if ($ext == 'el') {

                            $anchor = "href='".WEB_URL."/view-d:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                             $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }

                       echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>";
                       $id = base64_encode($value['id']."&d=".date('d'));
                        $tid = base64_encode(@$value['title_id']."&d=".date('d'));
                       if (@$value['title_id'] != '-1') {
                       if ($value['assignto'] != 'all') {
  if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){


    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='practice-training?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' style='margin-top: 7px;' aria-hidden='true'></i>
</a>
    ";

}
 if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {
    
    echo"                        <a data-toggle='tooltip' title='Delete' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='practice-training?user=$user&alldocumentidPD=$id' style='top: 9px;'><i class='fa fa-times' style='margin-top: 7px;' aria-hidden='true'></i>
</a>";

    }
    }
    }
       

                       if($value['file'] !='#'){echo "<a $anchor class='file_icn'><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}

                    echo "<div class='dtitle'>$value[title]</div>
                         <div class='row-icons'>
                        <a class='eye' data-toggle='tooltip' title='View' id='$value[id]&user=$user' href='javascript:;' onclick='documentInsert(this.id)'><i class='fas fa-eye'></i></a>
                          </div>
                        </div>";

                    // echo "<div class='file-box-desc all red'>
                    //         <button data-toggle='tooltip' title='Sign' id='$value[id]&user=$user' type='button' onclick='documentInsert(this.id)'><i class='fas fa-check'></i></button>
                    //         <a $anchor>
                    //             <i class='far fa-file-alt'></i>
                    //         </a>
                    //         <div class='dtitle'>$value[title]</div>
                    //         <span>Not Signed</span>
                    //     </div>";
                }
                // From User
                $data = $dbF->getRows("SELECT * FROM `userdocuments` WHERE `user`= ?  AND `category`='Practice Training'",array($user));
                foreach ($data as $key => $value) {
                    $anchor = "<a > <i class='far fa-file-alt' style='cursor: pointer;'></i></a>";
                    if($value['file'] != '#'){
                        $allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','pdf','PDF');
                        $ext = pathinfo($value['file'], PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                              if ($ext == 'el') {

                            $anchor = "href='".WEB_URL."/view-u:$value[id]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        else
                        {
                            $anchor = "href='http://view.officeapps.live.com/op/view.aspx?src=$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                        }
                        else{
                            $anchor = "href='$value[file]' target='_blank' data-toggle='tooltip' title='View Document'";
                        }
                    }
                    $id = base64_encode($value['id']."&d=".date('d'));
                    $tid = base64_encode($value['title_id']."&d=".date('d'));
                    echo "<div class='file-box-desc all red ".str_replace('.', '',str_replace('&', '',str_replace(' ', '',$value['sub_dcategory'])))."'>

                            ";
                               $data3 = $dbF->getRow("SELECT * FROM `documents` WHERE `id`='$value[id]' ");
                     if ($value['title_id'] != '-1') {          
                    if ($data3['assignto'] != 'all') {
                    if($_SESSION['currentUserType'] == 'Master' || $_SESSION['currentUserType'] == 'Practice' ){
                      echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='practice-training?user=$user&alldocumentidPD=$tid' style='top: 5px;'><i class='fa fa-times' style='margin-top: 7px;' aria-hidden='true'></i>
                                  </a>";
      } if ($_SESSION['currentUserType'] == 'Employee' && $_SESSION['superUser']['hruser'] == 'full') 

 {

  echo " <a data-toggle='tooltip' title='Delete All' class='delete' type='button' onclick='return confirm(\"Are you sure you want to delete All Document?\");' href='practice-training?user=$user&alldocumentidPD=$tid' style='top: 5px;'><i class='fa fa-times' style='margin-top: 7px;' aria-hidden='true'></i>
                                  </a>";

 }
 }
 }

                            
if($value['file'] !='#'){echo "<a $anchor><i class='far fa-file-alt'></i></a>";}
               
                    else{echo "<a ><i class='far fa-file-alt'></i></a>";}
        echo "<div class='dtitle'>$value[title]</div>
        <div class='row-icons'>
                    <a id='$value[title_id]&user=$user&uid=$value[id]' href='javascript:;' onclick='documentView(this.id)'><i class='fas fa-eye'></i></a>
                </div>
                        </div>";
                }
            ?>
</div>
            </div>
            <!-- mr -->
   <script>

        function AjaxDelScript(indx,ths){
            btn=$('.DelScript'+indx);
            console.log(indx);
            console.log(ths);
            if(secure_delete()){
                btn.addClass('disabled');
                btn.children('.trash').hide();
                btn.children('.waiting').show();

                id=btn.attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: 'ajax_call.php?page=deleteSingleDocumentFileTrash',   
                    data: { indx:indx,ths:ths}
                }).done(function(data)
                {
                 ift =true;
                        console.log(data);
                      if(data > 0 ){
                      //  console.log(data);
        // Remove row from HTML Table
        $(btn).closest('div').css('background','e5f3f2');
        $(btn).closest('div').fadeOut(800,function(){
           $(btn).remove();
        });
          }else{
        alert('Invalid ID.');
          }
                   
                    if(ift){
                        btn.removeClass('disabled');
                        btn.children('.trash').show();
                        btn.children('.waiting').hide();
                    }

                });
            }
        };


        //for small delete in other project
        function secure_delete(text){
            // text = 'view on alert';
            text = typeof text !== 'undefined' ? text : 'Are you sure you want to Delete?';

            bool=confirm(text);
            if(bool==false){return false;}else{return true;}

        }


  
</script>     
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
<?php include_once('dashboardfooter.php'); ?>