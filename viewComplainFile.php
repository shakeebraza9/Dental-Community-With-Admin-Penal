  <?php 
  include_once("global.php");
  global $dbF,$webClass;
  $login       =  $webClass->userLoginCheck();
  if(!$login){
  echo "<script>location.reload();</script>";
  exit();
  }
  $id = htmlspecialchars($_GET['id']);
  $sql = "SELECT filename FROM `clientAddIssue` WHERE `id`= ?";
  $data = $dbF->getRow($sql,array($id));
  ?>
  <div class="event_details" id="myform">
  <h3 style="width:100%;">
File Preview
  </h3>
  <div class="form_side">





  <div class="row cpd-table">
<?php
// if($filename != ""){
$files = WEB_URL."/images/".$data['filename'];
$allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','html','HTML');

$allowedPDF = array('pdf','PDF');

$ext = pathinfo($files, PATHINFO_EXTENSION);
// var_dump($ext);
if (!in_array($ext, $allowed)) {
$filename= "<div class='msgframe'><iframe class='iframeClass' src='https://view.officeapps.live.com/op/embed.aspx?src=$files'></iframe></div>";
}else if(in_array($ext, $allowedPDF)){

$filename= "<div class='msgframe'><iframe class='iframeClass' src='$files'></iframe></div>";

}
else{
$filename= "<div class='msgframe'><img class='iframeClass' src='$files'></img></div>";
}
// }
  echo $filename;
?>
  </div>



  </div>     </div>