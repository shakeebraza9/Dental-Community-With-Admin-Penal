  <?php 
  include_once("global.php");
  global $dbF,$webClass;
  $login       =  $webClass->userLoginCheck();
  if(!$login){
  echo "<script>location.reload();</script>";
  exit();
  }
 
  $id = htmlspecialchars($_GET['id']);
  $sql = "SELECT * FROM `safeguarding` WHERE `id`= ?";
  $data = $dbF->getRow($sql,array($id));
  ?>
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
<input type="radio" name="log_concern" value="" style="margin: 12px 20px 1px 7px;" <?php if($data['log_concern']=="Young person") echo "checked";?>>
<label for="log_concern" style="display:inline;">Vulnerable adult</label>
<input type="radio" name="log_concern" value="" style="margin: 12px 20px 1px 7px;" <?php if($data['log_concern']=="Vulnerable adult") echo "checked";?>>

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
<textarea name="reporting_your_own_concerns_or_passing" class="form-control" ><?php echo $data['reporting_your_own_concerns_or_passing'];?></textarea>
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
<textarea name="prompted_the_concerns" class="form-control"><?php echo $data['prompted_the_concerns'];?></textarea>
</div>

<div class="form-group col-12 col-sm-12">
<label>What (if any) physical,behavioural or indirect signs were present?</label>
<textarea name="indirect_signs" class="form-control" ><?php echo $data['indirect_signs'];?></textarea>
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
<textarea name="spoken_to_the_child_comment" class="form-control" id="spok3" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"><?php echo $data['spoken_to_the_child_comment'];?></textarea>
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
<textarea name="spoken_to_the_parents_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"><?php  echo $data['spoken_to_the_parents_comment'];?></textarea>
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
<textarea name="abuser_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"><?php echo $data['abuser_comment'];?></textarea>
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
<textarea name="consulted_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"><?php echo $data['consulted_comment'];?></textarea>
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
<textarea name="involved_in_the_incident_comment" class="form-control" style="margin: 12px 20px 1px 7px; width: 100%; display:inline-table;"><?php echo $data['involved_in_the_incident_comment'];?></textarea>
</div>
</div>

<div class="form-group col-12 col-sm-6 ">
<label>Signature of person completing log:</label>
<input name="Signature_of_person_completing" type="text" placeholder=" " value="<?php echo $data['Signature_of_person_completing']; ?>">
</div>




  </div>



  </div>     </div>
   </div>