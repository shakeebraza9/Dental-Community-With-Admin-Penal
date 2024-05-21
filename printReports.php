<?php 
include_once("global.php");

global $dbF,$webClass;

$login       =  $webClass->userLoginCheck();
if(!$login){
     echo "<script>location.reload();</script>";
     exit();
}

if($seo['title']==''){
$seo['title'] = $dbF->hardWords('Print Issue Report',false);
}



include_once('header.php');





include'dashboardheader.php'; 

  $idz =  explode(":",$_GET['id']);




  $id =   base64_decode($idz[0]);



  $sql = "SELECT * FROM `clientAddIssue` WHERE `id`= ?";
  $data = $dbF->getRow($sql,array($id));

// $dbF->prnt($data);
    if($idz[1] == "Safeguarding"){
       $sql = "SELECT * FROM `safeguarding` WHERE `id`= ?";
        $data = $dbF->getRow($sql,array($id));
    }


    echo "<script>  
    $('.event_details input,.event_details select,.event_details textarea').prop('disabled','disabled');
    $('.event_details input[type=file],.event_details .add-file,.event_details .add-file-btn,.event_details .submit_class,.event_details .ccheckbox,input[type=checkbox]').hide();
    </script>";
  

if($idz[1] == "Complaint Form"){


?>


<style>
      @media print {
         form * {border:none; font-weight:bold;}
      }            .loader{display:none;}
 
      .form-right{display:none;}
      .myevents-div {
          position: relative;
    left: 0%;
    right: 0%;
    width: 90%;
    margin: 0 auto;
    z-index: 999;
    padding: 20px 0;
    background: #fff;
    border-top: 5px solid #01abbf;
    overflow: visible;
      }
.myevents-form {
    min-height: 5px;
}
.myevents-div_ {
    transform: none;
}
.event_details {
    padding-top: 20px;
    font-family: "montserratmedium";
    line-height: 1.8;
    width: 500px;
    max-width: 100%;
}
</style>
<div class="myevents-div myevents-div_ redborder">


    <div class="myevents-form">
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
    echo '<div class="form-group col-12 col-md-6"><label>File</label>

  <a href="'.WEB_URL.'/images/'.$data['filename'].'" target="_blank">Download / View</a>


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
</div></div>
<?php

}elseif($idz[1] == "Safeguarding"){
  ?>
<style>
      @media print {
         form * {border:none; font-weight:bold;}
      }            .loader{display:none;}
 
      .form-right{display:none;}
      .myevents-div {
          position: relative;
    left: 0%;
    right: 0%;
    width: 90%;
    margin: 0 auto;
    z-index: 999;
    padding: 20px 0;
    background: #fff;
    border-top: 5px solid #01abbf;
    overflow: visible;
      }
.myevents-form {
    min-height: 5px;
}
.myevents-div_ {
    transform: none;
}
.event_details {
    padding-top: 20px;
    font-family: "montserratmedium";
    line-height: 1.8;
    width: 500px;
    max-width: 100%;
}
</style>
<div class="myevents-div myevents-div_ redborder">

<div class="myevents-form">
  <div class="event_details" id="myform">
  <h3 style="width:100%;">
  Safeguarding Form
  </h3>
  <div class="form_side">





  <div class="row cpd-table">


<div class="row">

<h3 style="width:100%;">Details of Person Reporting Concern</h3>





<div class="form-group col-12 col-sm-6">
<label>Name of person reporting concern:</label>
<input name="name_of_person" type="text" placeholder=" " value="<?php echo $data['name_of_person']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Date:</label>
<input name="date" type="date" value="<?php echo $data['date']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Job role:</label>
<input name="job_role" type="text" placeholder=" " value="<?php echo $data['job_role']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Work address:</label>
<input name="work_address" type="text" placeholder=" " value="<?php echo $data['work_address']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Email:</label>
<input name="email" type="text" placeholder=" " value="<?php echo $data['email']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Contact Number:</label>
<input name="contact_nub" type="text" placeholder=" " value="<?php echo $data['contact_nub']; ?>">
</div>

<h3 style="width:100%;">Description of Incident/Concern</h3>


<div class="form-group col-12 col-sm-12">
<h6 for="radiograph_audits">This log of concern relates to (please tick)</h6>

<label for="log_concern" style="display:inline;">Child</label>
<input type="radio" name="log_concern" value="" style="margin: 12px 20px 1px 7px;" <?php if($data['log_concern']=="child") echo "checked";?> > 
<label for="log_concern" style="display:inline;">Young person</label>
<input type="radio" name="log_concern" value="<?php echo $data['log_concern']; ?>" style="margin: 12px 20px 1px 7px;" <?php if($data['log_concern']=="Young person") echo "checked";?>>
<label for="log_concern" style="display:inline;">Vulnerable adult</label>
<input type="radio" name="log_concern" value="<?php echo $data['log_concern']; ?>" style="margin: 12px 20px 1px 7px;" <?php if($data['log_concern']=="Vulnerable adult") echo "checked";?>>

</div>

<h3 style="width:100%;">Subject(s) Details</h3>

<div class="form-group col-12 col-sm-6">
<label>Subject(s) name(s):</label>
<input name="subject_name" type="text" placeholder=" " value="<?php echo $data['subject_name']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Name of parents/carers (if appropriate):</label>
<input name="name_of_parent" type="text" value="<?php echo $data['name_of_parent']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Telephone number:</label>
<input name="telephone_nub" type="text" placeholder=" " value="<?php echo $data['telephone_nub']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Mobile number:</label>
<input name="mobile_nub" type="text" placeholder=" " value="<?php echo $data['mobile_nub']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>First language (ifknown):</label>
<input name="first_lang" type="text" placeholder=" " value="<?php echo $data['first_lang']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Address:</label>
<input name="address" type="text" placeholder=" " value="<?php echo $data['address']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Postcode:</label>
<input name="postcode" type="text" placeholder=" " value="<?php echo $data['postcode']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Any special factors to be considered?(e.g.language difficulties,disability or any thing else of relevance):</label>
<input name="special_factor" type="text" placeholder=" " value="<?php echo $data['special_factor']; ?>">
</div>

<h3 style="width:100%;">Details</h3>

<div class="form-group col-12 col-sm-12">
<label>Are you reporting your own concerns or passing on those of somebody else?</label>
<input type="text" name="reporting_your_own_concerns_or_passing" class="form-control" value="<?php echo $data['reporting_your_own_concerns_or_passing'];?>">
</div>


<div class="form-group col-12 col-sm-6">
<label>Date of the incident/concern:</label>
<input name="date_of_incident" type="date" placeholder=" " value="<?php echo $data['date_of_incident']; ?>">
</div>

<div class="form-group col-12 col-sm-6">
<label>Time of the incident/concern:</label>
<input name="" type="text" placeholder=" " value="<?php echo $data['time_of_incident']; ?>">
</div>

<div class="form-group col-12 col-sm-12">
<label>What has prompted the concerns? Include dates, times and details of any specific incidents,making a clear distinction between fact,opinion and hear say:</label>
<input type="text" name="prompted_the_concerns" class="form-control" value="<?php echo $data['prompted_the_concerns'];?>">
</div>

<div class="form-group col-12 col-sm-12">
<label>What (if any) physical,behavioural or indirect signs were present?</label>
<input type="text" name="indirect_signs" class="form-control" value="<?php echo $data['indirect_signs'];?>">
</div>



<div class="form-group col-12 col-sm-12" style="display: flex;" id="spoken_to_the_child">
<div style="width: 44%; ">
<label>Have you spoken to the child,young person or vulnerable adult? :</label>
</div><div style="width: 16%;">
<label for="spoken_to_the_child" style="display:inline;">Yes</label>
<input name="spoken_to_the_child" type="radio" value="" id="spok1" style="margin: 12px 20px 1px 7px;" <?php if($data['spoken_to_the_child']=="yes") echo "checked";?>>

<label for="spoken_to_the_child" style="display:inline;">No</label>
<input name="spoken_to_the_child" type="radio" value="" id="spok2" style="margin: 12px 20px 1px 7px;" <?php if($data['spoken_to_the_child']=="no") echo "checked";?>>
</div><div style="width: 40%; display: flex;">
<label for="spoken_to_the_child" style="margin: 8px 17px 1px 7px;">Discription</label>
<input type="text" name="spoken_to_the_child_comment" class="form-control" id="spok3" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;" value="<?php echo $data['spoken_to_the_child_comment'];?>">
</div>
</div>

<div class="form-group col-12 col-sm-12" style="display: flex;">
<div style="width: 44%; ">
<label>Have you spoken to the parents/carers?</label>
</div><div style="width: 16%;">
<label for="spoken_to_the_parents" style="display:inline;">Yes</label>
<input name="spoken_to_the_parents" type="radio" value="" style="margin: 12px 20px 1px 7px;" <?php if($data['spoken_to_the_parents']=="yes") echo "checked";?>>

<label for="spoken_to_the_parents" style="display:inline;">No</label>
<input name="spoken_to_the_parents" type="radio" value=""style="margin: 12px 20px 1px 7px;" <?php if($data['spoken_to_the_parents']=="no") echo "checked";?>>
</div><div style="width: 40%; display: flex;">
<label for="spoken_to_the_parents" style="margin: 8px 17px 1px 7px;">Discription</label>
<input type="text" name="spoken_to_the_parents_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;" value="<?php echo $data['spoken_to_the_parents_comment'];?>">
</div>
</div>

<div class="form-group col-12 col-sm-12" style="display: flex;">
<div style="width: 44%; ">
<label>Has any body been all eged to be the abuser?</label>
</div><div style="width: 16%;">
<label for="abuser" style="display:inline;">Yes</label>
<input name="abuser" type="radio" value="" style="margin: 12px 20px 1px 7px;"  <?php if($data['abuser']=="yes") echo "checked";?>>

<label for="abuser" style="display:inline;">No</label>
<input name="abuser" type="radio" value=""style="margin: 12px 20px 1px 7px;" <?php if($data['abuser']=="no") echo "checked";?>>
</div><div style="width: 40%; display: flex;">
<label for="abuser" style="margin: 8px 17px 1px 7px;">Discription</label>
<input type="text" name="abuser_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;" value="<?php echo $data['abuser_comment'];?>">
</div>
</div>

<div class="form-group col-12 col-sm-12" style="display: flex;">
<div style="width: 44%; ">
<label>Have you consulted any one else?</label>
</div><div style="width: 16%;">
<label for="consulted" style="display:inline;">Yes</label>
<input name="consulted" type="radio" value="" style="margin: 12px 20px 1px 7px;"  <?php if($data['consulted']=="yes") echo "checked";?>>

<label for="consulted" style="display:inline;">No</label>
<input name="consulted" type="radio" value=""style="margin: 12px 20px 1px 7px;" <?php if($data['consulted']=="no") echo "checked";?>>
</div><div style="width: 40%; display: flex;">
<label for="consulted" style="margin: 8px 17px 1px 7px;">Discription</label>
<input type="text" name="consulted_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;" value="<?php echo $data['consulted_comment'];?>">
</div>
</div>

<div class="form-group col-12 col-sm-12" style="display: flex;">
<div style="width: 44%; ">
<label>Is there anyone else who might be involved in the incident? (e.g. anyone you think has seen or heard things relating to the incident?) </label>
</div><div style="width: 16%;">
<label for="involved_in_the_incident" style="display:inline;">Yes</label>
<input name="involved_in_the_incident" type="radio" value="" style="margin: 12px 20px 1px 7px;"  <?php if($data['involved_in_the_incident']=="yes") echo "checked";?>>

<label for="involved_in_the_incident" style="display:inline;">No</label>
<input name="involved_in_the_incident" type="radio" value=""style="margin: 12px 20px 1px 7px;" <?php if($data['involved_in_the_incident']=="no") echo "checked";?>>
</div><div style="width: 40%; display: flex;">
<label for="involved_in_the_incident" style="margin: 8px 17px 1px 7px;">Discription</label>
<input type="text" name="involved_in_the_incident_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;" value="<?php echo $data['involved_in_the_incident_comment'];?>">
</div>
</div>

<div class="form-group col-12 col-sm-6 ">
<label>Signature of person completing log:</label>
<input name="Signature_of_person_completing" type="text" placeholder=" " value="<?php echo $data['Signature_of_person_completing']; ?>">
</div>
  </div>
  </div>     </div>
  </div>     </div>
  </div>

<?php  
}else{
?>

<style>
      @media print {
         form * {border:none; font-weight:bold;}
      }            .loader{display:none;}
 
      .form-right{display:none;}
      .myevents-div {
          position: relative;
    left: 0%;
    right: 0%;
    width: 90%;
    margin: 0 auto;
    z-index: 999;
    padding: 20px 0;
    background: #fff;
    border-top: 5px solid #01abbf;
    overflow: visible;
      }
.myevents-form {
    min-height: 5px;
}
.myevents-div_ {
    transform: none;
}
.event_details {
    padding-top: 20px;
    font-family: "montserratmedium";
    line-height: 1.8;
    width: 500px;
    max-width: 100%;
}
</style>
<div class="myevents-div myevents-div_ redborder">
      <div class="myevents-form">

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
    echo '<div class="form-group col-12 col-md-6"><label>File</label>

  <a href="'.WEB_URL.'/images/'.$data['filename'].'" target="_blank">Download / View</a>


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
  </div>     </div>



<?php
}
?>
















<?php include_once('footer.php'); ?>
<script>
$('[data-toggle="tooltip"]').tooltip(); 

      $('#loader').fadeOut(100);
     $(window).load(function() {
      //This execute when entire finished loaded
    //   window.print();
      setTimeout(function(){ window.print(); }, 500);
       setTimeout(function(){ window.close(); }, 3000);
    });
    
    </script>