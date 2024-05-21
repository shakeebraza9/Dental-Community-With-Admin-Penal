  <?php 
  include_once("global.php");
  global $dbF,$webClass;
  $login       =  $webClass->userLoginCheck();
  if(!$login){
  echo "<script>location.reload();</script>";
  exit();
  }
  $id = htmlspecialchars($_GET['id']);
  $sql = "SELECT * FROM `clientAddIssue` WHERE `id`= ?";
  $data = $dbF->getRow($sql,array($id));
  ?>
  <div class="event_details" id="myform">
  <h3 style="width:100%;">
Complaint Form
  </h3>
  <div class="form_side">





  <div class="row cpd-table">


  
  <?php 
echo '




<h3 style="width:100%;">Person making the complaint</h3>




  <div class="form-group col-12 col-md-6"><label>Name:</label>
<input name="complaint_name" type="text" readonly id="Name:" value="'.$data['complaint_name'].'">
</div>



  <div class="form-group col-12 col-md-6"><label>Address:</label>
<input name="complaint_address" type="text" readonly id="Address:" value="'.$data['complaint_address'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Telephone Number:</label>
<input name="complaint_tel" type="text" readonly id="Telephone Number:" value="'.$data['complaint_tel'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Name and contact details of the healthcare professional to which the complaint refers:</label>
<input name="complaint_refers" type="text" readonly id="Name and contact details of the healthcare professional to which the complaint refers:" value="'.$data['complaint_refers'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Details of complaint, concern or compliment (include dates, times and witnesses where possible):</label>
<input name="complaint_detail" type="text" readonly id="Details of complaint, concern or compliment (include dates, times and witnesses where possible):" value="'.$data['complaint_detail'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Names of any employees specifically complained of or complimented:</label>
<input name="complaint_employee" type="text" readonly id="Names of any employees specifically complained of or complimented:" value="'.$data['complaint_employee'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Name of person originally complained to (if not the person completing this form):</label>
<input name="complaint_originally" type="text" readonly id="Name of person originally complained to (if not the person completing this form):" value="'.$data['complaint_originally'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Name of the person to whom the complaint was referred on to for investigation (state "as above" if the person who receives the complaint also investigates):</label>
<input name="complaint_investigation" type="text" readonly id="Name of the person to whom the complaint was referred on to for investigation (state "as above" if the person who receives the complaint also investigates):" value="'.$data['complaint_investigation'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Investigations carried out (attach additional pages if required):</label>
<input name="complaint_carried_out" type="text" readonly id="Investigations carried out (attach additional pages if required):" value="'.$data['complaint_carried_out'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Action taken or recommended by investigator:</label>
<input name="complaint_action" type="text" readonly id="Action taken or recommended by investigator:" value="'.$data['complaint_action'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Did this action satisfy the complainant? If not, state why, and who the complaint was referred on to next:</label>
<input name="complaint_nextrefer" type="text" readonly id="Did this action satisfy the complainant? If not, state why, and who the complaint was referred on to next:" value="'.$data['complaint_nextrefer'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Action taken by person to whom the complaint was referred on to:</label>
<input name="complaint_referred_onto" type="text" readonly id="Action taken by person to whom the complaint was referred on to:" value="'.$data['complaint_referred_onto'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Did this action satisfy the complainant?</label>
<input name="complaint_action_satisfy" type="text" readonly id="Did this action satisfy the complainant?" value="'.$data['complaint_action_satisfy'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Name of organization to which the complaint was referred in the event of a failure to satisfy the complainant?</label>
<input name="complaint_name_of_org" type="text" readonly id="Name of organization to which the complaint was referred in the event of a failure to satisfy the complainant?" value="'.$data['complaint_name_of_org'].'">
</div>




  <div class="form-group col-12 col-md-6"><label>Date:</label>
<input name="complaint_date" type="text" readonly id="Date:" value="'.$data['complaint_date'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Complainant details:</label>
<input name="complaint_details" type="text" readonly id="Complainant details:" value="'.$data['complaint_details'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Summary of complaint:</label>
<input name="complaint_summary" type="text" readonly id="Summary of complaint:" value="'.$data['complaint_summary'].'">
</div>

  <div class="form-group col-12 col-md-6"><label>Action Taken:</label>
<input name="complaint_action_taken" type="text" readonly id="Action Taken:" value="'.$data['complaint_action_taken'].'">
</div>';







if($data['filename'] != ""){

  $downLink=base64_encode(WEB_URL.'/images/'.$data['filename'].":s:".date('d'));


  
    echo '<div class="form-group col-12 col-md-6"><label>File</label>

  <a href="' . WEB_URL . '/d?f='.$downLink.'" target="_blank">Download / View</a>


  </div>';
$files = WEB_URL."/images/".$data['filename'];
$allowed = array('gif','png','jpg','tiff','jpeg','bmp','webp','JPG','PNG','GIF','WEBP','TIFF','BMP','JPEG','pdf','PDF','html','HTML');

$allowedPDF = array('pdf','PDF');

$ext = pathinfo($files, PATHINFO_EXTENSION);
// var_dump($ext);
if (!in_array($ext, $allowed)) {
$dataAll= "<div class='msgframe'><iframe class='iframeClass' src='https://view.officeapps.live.com/op/embed.aspx?src=$files'></iframe></div>";
}else if(in_array($ext, $allowedPDF)){

$dataAll= "<div class='msgframe'><iframe class='iframeClass' src='$files'></iframe></div>";

}
else{
$dataAll= "<div class='msgframe'><img class='iframeClass' src='$files'></img></div>";
}

echo $dataAll;
}
  ?>

  </div>



  </div>     </div>