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
  Serious Accident Incident Form
  </h3>
  <div class="form_side">





  <div class="row cpd-table">


  <?php 

  echo '



 <h3 style="width:100%;">
Primary person(s) affected (Leave blank if no persons affected)
  </h3>




  <div class="form-group col-12 col-md-6"><label>First name:</label><input name="primary_person_fn" readonly type="text" id="First name:" value="'.$data['primary_person_fn'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Surname:</label><input name="primary_person_surname" readonly type="text" id="Surname:" value="'.$data['primary_person_surname'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Identity (i.e. service user, carer, staff role)</label><input name="primary_person_identity" readonly type="text" id="Identity (i.e. service user, carer, staff role)" value="'.$data['primary_person_identity'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Address:</label><input name="primary_person_address" readonly type="text" id="Address:" value="'.$data['primary_person_address'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Phone number:</label><input name="primary_person_pn" readonly type="text" id="Phone number:" value="'.$data['primary_person_pn'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Email:</label><input name="primary_person_email" readonly type="text" id="Email:" value="'.$data['primary_person_email'].'"></div>


 <h3 style="width:100%;">
Person(s) believed to be responsible (Leave blank if not applicable)
  </h3>




  <div class="form-group col-12 col-md-6"><label>First name:</label><input name="person_believed_fn" readonly type="text" id="First name:" value="'.$data['person_believed_fn'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Surname:</label><input name="person_believed_surname" readonly type="text" id="Surname:" value="'.$data['person_believed_surname'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Identity (i.e. service user, carer, staff role)</label><input name="person_believed_identity" readonly type="text" id="Identity (i.e. service user, carer, staff role)" value="'.$data['person_believed_identity'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Address:</label><input name="person_believed_address" readonly type="text" id="Address:" value="'.$data['person_believed_address'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Phone number:</label><input name="person_believed_pn" readonly type="text" id="Phone number:" value="'.$data['person_believed_pn'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Email:</label><input name="person_believed_email" readonly type="text" id="Email:" value="'.$data['person_believed_email'].'"></div>







<h3 style="width:100%;">Details of person completing form</h3>




  <div class="form-group col-12 col-md-6"><label>First name:</label><input name="person_completing_fn" readonly type="text" id="First name:" value="'.$data['person_completing_fn'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Surname:</label><input name="person_completing_surname" readonly type="text" id="Surname:" value="'.$data['person_completing_surname'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Type of incident (refer to policy if unsure)</label><input name="person_completing_type_of_incident" readonly type="text" id="Type of incident (Incident,Serious Incident)" value="'.$data['person_completing_type_of_incident'].'"></div>





<h3 style="width:100%;">Description of the incident</h3>

  <div class="form-group col-12 col-md-6"><label>Your description should be as full as possible. Please state only FACTS, not opinions.</label><input name="desc_of_incident" readonly type="text" id="Your description should be as full as possible. Please state only FACTS, not opinions." value="'.$data['desc_of_incident'].'"></div>




<h3 style="width:100%;">When and where the incident took place</h3>


  <div class="form-group col-12 col-md-6"><label>Location:</label><input name="incident_location" readonly type="text" id="Location:" value="'.$data['incident_location'].'"></div>

  <div class="form-group col-12 col-md-6"><label>Address:</label><input name="incident_address" readonly type="text" id="Address:" value="'.$data['incident_address'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Date:</label><input name="incident_date" readonly type="text" id="Date:" value="'.$data['incident_date'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Time of incident( 24h clock)</label><input name="incident_time" readonly type="text" id="Time of incident( 24h clock)" value="'.$data['incident_time'].'"></div>



<h3 style="width:100%;">Witness(1) to the incident</h3>

  <div class="form-group col-12 col-md-6"><label>First name:</label><input name="witness_fn1" readonly type="text" id="First name:" value="'.$data['witness_fn1'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Surname:</label><input name="witness_surname1" readonly type="text" id="Surname:" value="'.$data['witness_surname1'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Identity (i.e. service user, carer, staff role)</label><input name="witness_identity1" readonly type="text" id="Identity (i.e. service user, carer, staff role)" value="'.$data['witness_identity1'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Address:</label><input name="witness_address1" readonly type="text" id="Address:" value="'.$data['witness_address1'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Phone number:</label><input name="witness_pn1" readonly type="text" id="Phone number:" value="'.$data['witness_pn1'].'"></div>






<h3 style="width:100%;">Witness(2) to the incident</h3>




  <div class="form-group col-12 col-md-6"><label>First name:</label><input name="witness_fn2" readonly type="text" id="First name:" value="'.$data['witness_fn2'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Surname:</label><input name="witness_surname2" readonly type="text" id="Surname:" value="'.$data['witness_surname2'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Identity (i.e. service user, carer, staff role)</label><input name="witness_identity2" readonly type="text" id="Identity (i.e. service user, carer, staff role)" value="'.$data['witness_identity2'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Address:</label><input name="witness_address2" readonly type="text" id="Address:" value="'.$data['witness_address2'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Phone number:</label><input name="witness_pn2" readonly type="text" id="Phone number:" value="'.$data['witness_pn2'].'"></div>



<h3 style="width:100%;">If witness statements are required, list the names of individuals to request statements from:</h3>

  <div class="form-group col-12 col-md-6"><label>Cause of incident (including any relevant events leading up to the incident)</label><input name="cause_of_incident" readonly type="text" id="Cause of incident (including any relevant events leading up to the incident)" value="'.$data['cause_of_incident'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Immediate actions taken (to reduce impact of incident and/or risk of reoccurrence. Include who took actions)</label><input name="immediate_action_taken" readonly type="text" id="Immediate actions taken (to reduce impact of incident and/or risk of reoccurrence. Include who took actions)" value="'.$data['immediate_action_taken'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Details of any external agencies involved (include staff names, contact details, advice given and actions taken)</label><input name="detail_of_any_external_agency_involved" readonly type="text" id="Details of any external agencies involved (include staff names, contact details, advice given and actions taken)" value="'.$data['detail_of_any_external_agency_involved'].'"></div>
  <div class="form-group col-12 col-md-6"><label>Management actions</label><input name="management_action" readonly type="text" id="Management actions" value="'.$data['management_action'].'"></div>';







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