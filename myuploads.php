<?php 
include_once("global.php");
global $dbF,$webClass;
// $dbF->prnt($_GET);
$login       =  $webClass->userLoginCheck();
if(!$login){
     header('Location: login');
}

$msg = "";
$chk = $functions->submitmyuploads();
if($chk){
    $msg = "File Submit Successfully";
}
$chk3 = $functions->submitmyuploadsedit();
if($chk3){
    $msg = "MyUpload Update Successfully";
}
$chk2 = $functions->submitfiles();
if($chk2){
    $msg = "File Submit Successfully";
}
$chk4 = $functions->submitfiletxt();
if($chk4){
    $msg = "File Submit Successfully";
     header('Location: resources?category=Compliance-Templates&sub_category=Practice%20Policies');
}


$chk5 = $functions->myeventdelete();
 if($chk5){
    $msg = "Event Delete Successfully";
}


if(isset($_GET['cnfrm'])){
    $chk = $functions->deletemyuploads();
    if($chk){
    $msg = "File Delete Successfully";
    }
}
// include_once('header.php');

include'dashboardheader.php'; ?>
<style type="text/css">
    
  /*  .main-row-down {
    position: relative;
}
.main-row-down ul{
  padding-bottom: 60px !important;
}*/
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
            <div class="right_side_top">
                <div class="change-session">
                <?php
                    //$functions->changeSession();
                ?>
                <div class="col1_btnn col1_btn22">
                    <a href="javascript:;" onclick="myuploads()">Upload File</a>
                </div>
                <?php
                $data = $functions->health_check($_SESSION['currentUser']);
                if($data && $_SESSION['currentUserType'] !='Employee' || @$_SESSION['superUser']['ccalendar'] == 'edit' || @$_SESSION['superUser']['ccalendar'] == 'full')
                { ?>
                <div class="col1_btnn">
                <a href="<?php echo WEB_URL."/health_check_form" ?>">Initial Compliance Health Check form</a>
                </div>
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
            <div class="resources_search">
                <select id="optn" class="optn">
                    <?php echo $functions->uploadsName() ?>
                </select>
                <input type="text" placeholder="Keywords" id="kywd" class="optn">
                <button type="submit" id="resources_search"><i class='fas fa-search'></i></button>
            </div>
            <!-- resources_search -->
            <div class="mr">
                <?php $functions->myuploads() ?>
                <?php $functions->myEventsManagement() ?> 
            </div>
            <!-- mr -->
        </div>
        <!-- right_side close -->
    <!-- </div> -->
    <!-- left_right_side -->
    <script>
        $('.APIedit').on('click', function() {
            start_loader();
            var url = this.id;
            var windowurl = window.location.href;
            $.get("https://script.google.com/macros/s/AKfycbyF0ZruTXnjYPGrD02L306gOd50I9LSEjHcN6wVCR_Qaa4ReJNY/exec?url="+url, function(id) {
                localStorage.setItem("url",url);
                localStorage.setItem("windowurl",windowurl);
                document.cookie="id="+id;
                $.get("https://script.google.com/macros/s/AKfycbwYy6HL5H9O85RtbH5YXBIJxnrO_Pd175XZJRW0ww/exec?id="+id, function(editurl) {
                    document.cookie="editurl="+editurl; 
                    $.get("https://script.google.com/macros/s/AKfycbx_uPRmTSV6kXAKe4Lhw-xwSG_y9giQHEaMeFwNcHGMun6doBqr/exec?id="+id);
                    location.replace("<?php echo WEB_URL ?>/docs");
                });
            });
        });
    </script>

<!--     <style type="text/css">
        
        .row-title span {
    display: none;
}


    </style> -->
<?php include_once('dashboardfooter.php'); ?>